<?php

namespace App\Http\Controllers\Books;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reviews;
use App\Ratings;
use App\Book;
use App\Notifications;
use App\Models\UserLogModel;
use App\Categories;
use App\FlagReview;
use Session;
use DB;
class RateReviewController extends Controller
{
    //
    public function index()
    {
        return view('review');
    }
    public function flagging(Request $request,$review_id)
    {
        $_review = new Reviews();
        $review = $_review->where('review_id','=',$review_id)->first();
        return view('flagreview',array('r'=>$review));
    }
    public function postflagging(Request $request)
    {
        $reviewid=  $request->get('reviewid');
        $reporter = $request->get('uID');
        $description = $request->get('description');
        $choice = $request->get('choice');
        $flag = new FlagReview();
        $flag->review_id = $reviewid;
        $flag->description = $description;
        $flag->type = $choice;
        $flag->author=$reporter;
        if($flag->save())
        {
        return redirect($request->get('url'))->with('flagged','Review Reported');
        }else{
            return redirect()->back()->with('error','Something went wrong');
        }
    }
    public function getreview(Request $request,$book_id)
    {
        // $_reviews = new Reviews();
        // $reviews = $_reviews->where('book_id','=',$request->book_id)->get();
        $_book = new Book();
        $_book = $_book->where('book_id','=',$book_id);
        $book = $_book->first();
        return view('review',array('book'=>$book));
    }
    public function viewallreviews(Request $request,$book_id,$reviewid="")
    {
        
        $_book = new Book();
        $book = $_book->where('book_id','=',$book_id);
        $book = $book->first();
        $_review = new Reviews();
        if ($request->ajax()) {
    		$view = view('data',compact('posts'))->render();
            return response()->json(['html'=>$view]);
        }
       
            $review = $_review->where('review_id','=',$reviewid);    
       
        
        // $review = $_review->where('book_id','=',$book_id)->orderBy('reply','DESC')->paginate(10);
        return view('allreview',['book'=>$book,'ratings'=>$this->getratings($book_id),'review'=>$review]);
    }
    public function singlereview(Request $request,$book_id,$reviewid="")
    {
        
        $_book = new Book();
        $book = $_book->where('book_id','=',$book_id);
        $book = $book->first();
        $_review = new Reviews();
       
        if($reviewid)
        {
            $review = $_review->where('reviewer_id','=',$reviewid)->where('book_id','=',$book_id)->first();    
        }
        
        // $review = $_review->where('book_id','=',$book_id)->orderBy('reply','DESC')->paginate(10);
        return view('singlereview',['book'=>$book,'ratings'=>$this->getratings($book_id),'r'=>$review]);
    }
    public function load_morereview(Request $request,$id)
    {
        
        $_reviews = new Reviews();
        $reviews=$_reviews->where('book_id','=',$id)->orderBy('updated_at','desc')->simplePaginate(1);
        if($request->ajax())
        {
            if($request->get('page')!=null)
            {
                return [
                    'data'=>view('books.allreviews_reviews')->with(compact('reviews'))->with('ratings',$this->getratings($id))->render(),
                    'next'=>$reviews->nextPageUrl()
                ];   
            }else {
                return [
                    'data'=>view('books.allreviews_reviews')->with(compact('reviews'))->with('ratings',$this->getratings($id))->render(),
                    'next'=>$reviews->nextPageUrl()
                ]; 
            }
        }else {
        
        }
        
    }
    // public function load_morereview(Request $request)
    // {
    //     // 
    //     $_categories = new Categories();
    //     $categories = $_categories->simplePaginate(4);
        
    //     if($request->ajax())
    //     {
    //         if($request->get('page')!=null)
    //         {
                
    //             return [
    //                 'data'=>view('lmoreajax')->with(compact('categories'))->render(),
    //                 'next'=>$categories->nextPageUrl()
    //             ];
                
    //         }else {
    //             return [
    //                 'data'=>view('lmoreajax')->with(compact('categories'))->render(),
    //                 'next'=>$categories->nextPageUrl()
    //             ];    
    //         }
            
    //     }else {
         
    //     }
    // }
    public function tesloadmore()
    {
        return view('loadmore');
    }
   
    public function replyreview(Request $request)
    {
          $_reviews = new Reviews();
          $review = $_reviews->where('review_id','=',$request->r)->first();
    //    $_reviews = new Reviews();
    //    $_reviews->exists = true;
      $affectedrows= DB::table('reviews')
            ->where('review_id', $request->r)
            ->update(['reply' => $request->m,"replier_id"=>$request->a]);
      echo $affectedrows;
      $notif = new Notifications();
         //notification
        
         $notif->type=4;
         $notif->recipient = $review->reviewer_id;
         $notif->author_id = $request->a;
         $notif->book_id = $review->book_id;
         $notif->status=1;
         $notif->save(); 
    //    { echo 'success';}
       
       
    }
    public function review(Request $request)
    {
        $_reviews = new Reviews();
        $book = new Book();
        
        $content = $request->content;
        $bookid = $request->bookid;
        $book = $book->where('book_id','=',$bookid)->first();
        $rating = $request->rating;
        $reviewer = $request->user_id;
        $reviewer = session('user')->user_id;
        $score = 0;
        if($request->score!=null)
                {
                    $score = $request->score;
                    
                }else {
                    
                    $score = 0;
                }
        // $_reviews=$_reviews->where('book_id',$bookid)->where('reviewer_id',$reviewer)->first();
        if($_reviews->where('book_id',$bookid)->where('reviewer_id',$reviewer)->first()==null)
        {  $_reviews = new Reviews();
            $_reviews->content = $content;
            $_reviews->reviewer_id=$reviewer;
            $_reviews->book_id = $bookid;
            if($_reviews->save()==true)
            {
            $lastinsertedid=$_reviews->getKey();
            $_ratings = new Ratings();
            $_ratings->review_id=$lastinsertedid;
            $_ratings->score = $score;
            $_ratings->reviewer_id = $reviewer;
            $_ratings->save();
            $userlog = new UserLogModel();
            $log = $userlog->insertlog(Session::get('user')->user_id,6,$bookid);
            $notif = new Notifications();
            //notification
            
            $notif->type=3;
            $notif->recipient = $book->author;
            $notif->author_id = $reviewer;
            $notif->book_id = $bookid;
            $notif->status=1;
            $notif->save(); 
            }
        }else
        {  
            $r = new Reviews();
            DB::Update("UPDATE reviews set content =? where book_id = '".$bookid."' and reviewer_id= '".$reviewer."'",[$content]);
            $t = $r->where('book_id',$bookid)->where('reviewer_id',$reviewer)->first();
            $_ratings = Ratings::updateOrCreate(['review_id'=>$t->review_id],['score'=>$score , 'reviewer_id'=>$reviewer]);   
        }
        return redirect('/book/'.$bookid);
    }
    public function removereview($id)
    {
        
        $_reviews = new Reviews();
        $_ratings = new Ratings();
    }

    public function getratings($bookid=1)
    {
        $rate=[];
        $_reviews = new Reviews();
        $rr = $_reviews->select(DB::raw('FORMAT(avg(rates.score),1) as SCORE'))->where('book_id','=',$bookid)->where('score','>',0)->join('rates','rates.review_id','=','reviews.review_id')->first();
        $r = DB::select(DB::raw('select R.score as score,round(count(R.score)/(SELECT count(score) as TOTAL from `reviews` inner join `rates` as `R` on `R`.`review_id` = `reviews`.`review_id` where `book_id` = '.$bookid.'  and `score`>0 )*100,1) as percentage from `reviews` inner join `rates` as `R` on `R`.`review_id` = `reviews`.`review_id` where `book_id` = '.$bookid.' and `score`>0 group by `R`.`score` 
        '));
        $rate['average']= $rr;
        for($i=1; $i<=5; $i++)
        {
            $rt[$i]['score']=$i;
                     $rt[$i]['percentage']=0;   
            foreach($r as $score)
            {
                if($i == $score->score )
                {
                    $rt[$i]['score']=$score->score;
                     $rt[$i]['percentage']=$score->percentage;   
                }else{
                   
                }
            }   
        }
        $rate['scores']=$rt;
        return $rate;
    }
    
}
