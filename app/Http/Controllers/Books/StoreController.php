<?php

namespace App\Http\Controllers\Books;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categories;
use App\Book;
use App\Library;
use App\Reviews;
use Session;
use App\Transaction;
use DB;
class StoreController extends Controller
{
    public function index(Request $request){
        $_categories = new Categories();
        $categories = $_categories->all();
        $_books = new Book();
        $newbook = new Book();
        $book = new Book();
        $books = new Book();
        if($request->query('q'))
        {
            
             //search by author or books-title
            $book=$book->join('users','books.author','=','users.user_id')
            ->where('users.name','like','%'.$request->query('q').'%')
            ->orWhere('books.title','like','%'.$request->query('q').'%')
            ->where('books.status','=',1)
            ->get(['books.book_id']);
            $book2 = new Book();
            //search by tag name
            $book2=$book2->join('book_tag','books.book_id','book_tag.book_id')
            ->join('tag','tag.tag_id','book_tag.tag_id')
            ->where('tag.name','like','%'.$request->query('q').'%')
            ->where('books.status','=',1)
            ->get(['books.book_id']);
            $merged = $book2->merge($book);
            $res = new Book();
            $books=$res->whereIn('book_id',$merged);
        }else if($request->query('category'))
        {
            $books= $_books->where('category_id','=',$request->query('category'))->where('books.status','=',1);
        }else if ($request->query('mture'))
        {
            
            $books= $books->where('mature','=',1)->where('books.status','=',1);
        }else if($request->query('c'))
        {
            $books= $books->whereIn('category_id',$request->query('c'))->where('books.status','=',1);
        }else if($request->query('smin')!='')
        {
            $books=$books->where('min_price','>=',$request->query('smin'))->where('books.status','=',1);
        }
        else if($request->query('smax'))
        {
            $books=$books->where('max_price','<=',$request->query('smax'))->where('books.status','=',1);
        }else{
            $books = $_books->where('books.status','=',1);
        }
        $newbook = $newbook->where('books.status','=',1)->orderBy('updated_at','desc')->take(10)->get();
        
        $result = $books->paginate(20)->appends(request()->query());

        return view('store.browse')->with(array('categories'=>$categories,'books'=>$result,'newbook'=>$newbook));
    }
    public function search(Request $r)
    {
        $query= $r->get('q');
        $mature = $r->get('mture');
        $categories = $r->get('c');
        
        // echo $categories;
        $book = new Book();
        //search by author or books-title
        $book=$book->join('users','books.author','=','users.user_id')
        ->where('users.name','like','%'.$query.'%')
        ->where('books.status','=',1)
        ->orWhere('books.title','like','%'.$query.'%')
        ->get(['books.book_id']);
        $book2 = new Book();
        //search by tag name
        $book2=$book2->join('book_tag','books.book_id','book_tag.book_id')
        ->join('tag','tag.tag_id','book_tag.tag_id')
        ->where('tag.name','like','%'.$query.'%')
        ->where('books.status','=',1)
        ->get(['books.book_id']);
        $merged = $book2->merge($book);
        $result = new Book();
        $result=$result->whereIn('book_id',$merged);
        if($r->get('smin')!=null)
        {
            $result=$result->orWhere('min_price','>=',$r->get('smin'));
        }
        if($r->get('smax')!=null)
        {
            $result=$result->orWhere('max_price','<=',$r->get('smax'));
        }
        if($r->get('c')!=null)
        {
            $result=$result->whereIn('category_id',$categories);
        }
        if($mature)
        {
            $result = $result->where('mature','=',1);
        }
        $result = $result->paginate(20)->appends([
            'sort'=>$r->input('sort'),
            'q'=>$r->input('q'),
            'mture'=>$r->input('mture'),
            'c'=>$r->input('c'),
            'smin'=>$r->input('smin'),
            'smax'=>$r->input('smax')
        ]);
    
    }
    public function showbook($id){
        $_book = new Book();
        $book = $_book->where('book_id','=',$id)->first();
        $_lib = new Library();
        $lib = $_lib->where('book_id','=',$id)->where('user_id','=',Session::get('user')->user_id)->first();
        $_reviews = new Reviews();
        $reviews=$_reviews->where('book_id','=',$id)->orderBy('updated_at','desc')->take(10)->get();
        return view('store.bookdetails')->with(array('book'=>$book,'inlib'=>$lib,'reviews'=>$reviews,'ratings'=>$this->getratings($id)));
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
                    'data'=>view('books.bookdetails_reviews')->with(compact('reviews'))->with('ratings',$this->getratings($id))->render(),
                    'next'=>$reviews->nextPageUrl()
                ];
                
            }else {
        
                return [
                    'data'=>view('books.bookdetails_reviews')->with(compact('reviews'))->with('ratings',$this->getratings($id))->render(),
                    'next'=>$reviews->nextPageUrl()
                ]; 
            }
            
        }else {
        
        }
        
    }

    public function getnewestbook()
    {
        $_book = new Book();
        $book=$_book->orderBy('last_updated','DESC')->where('books.status','=',1)->take(5)->get();
        
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
