<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transaction;
use App\Dtrans;
use App\Categories;
use App\Traffics;
use App\Library;
use App\FlagReview;
use App\Reviews;
use App\Stories;
use DB;
use App\Book;
use Illuminate\Support\Facades\Validator;
use Mail;
use Session;

class AdminController extends Controller
{
    public function index()
    {
        $_user = new User();
        $usercount = $_user->count();
        $_book = new Book();
        $bookcount = $_book->count();
        $_trans = new Transaction();
        $transactioncount = $_trans->count();
        return view("admin.dashboard", array('usercount' => $usercount, 'bookcount' => $bookcount, 'transactioncount' => $transactioncount, 'lastuser' => $this->getlastregistered()));
    }
    public function login(Request $request)
    {

        if ($request->post('uID')) {

            if ($request->post('uID') == 'admin' && $request->post('password') == 'admin') {

                return redirect('admin/dashboard');
            } else {
                $user = new User();
                $_user = $user->where('username', 'like', $request->uID)->where('password', '=', $request->uPASS)->first();
                if ($_user) {
                    if ($_user->role == null) //
                    {
                        return redirect()->back()->with('error', 'You are not an admin account');
                    } else {
                        $this->setSessionLogin($_user);
                        return redirect('admin/dashboard');
                    }
                }
            }
        }
        return view('admin.login');
    }
    public function logout()
    {
        Session::flush();
        return redirect('/admin');
    }
    public function deletebook(Request $request)
    {
        $_book = new Book();
        $bookid = $request->get('bookid');
        $book = $_book->where('book_id', '=', $bookid)->first();
        $book->timestamps = false;
        $book->status = 0;
        if ($book->save()) {
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
    public function restorebook(Request $request)
    {
        $_book = new Book();
        $bookid = $request->get('bookid');
        $book = $_book->where('book_id', '=', $bookid)->first();
        $book->timestamps = false;
        $book->status = 1;
        if ($book->save()) {

            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
    public function setSessionLogin($user)
    {
        Session::put('admin', $user);
        Session::save();
    }

    public function edituser(Request $request)
    {
        $userid = $request->segment(3);
        $_user = new User();
        if ($request->ban) {
            $user_id = $request->uID;
            $user = $_user->where('user_id', '=', $userid)->update(['status' => -1]);
            return redirect()->back()->with(['success' => 'Successfuly Updated']);
        } else if ($request->unban) {
            $user_id = $request->uID;
            $user = $_user->where('user_id', '=', $userid)->update(['status' => 1]);
            return redirect()->back()->with(['success' => 'Successfuly Updated']);
        } else if ($request->saveedituser) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'username' => 'required|unique:users,username,' . $request->uID . ',user_id',
            ]);
            if ($validator->fails()) {
                return  redirect()
                    ->back()
                    ->withErrors($validator->errors());
            } else {
                $user_id = $request->uID;
                $name =  $request->name;
                $username = $request->username;
                $user = $_user->where('user_id', '=', $userid)->update(['name' => $name, 'username' => $username]);
                return redirect()->back()->with(['success' => 'Successfuly Updated']);
            }
        }
        $user = $_user->where('user_id', '=', $userid)->first();
        return view('admin.edit-user')->with(array('user' => $user));
    }
    public function manageuser(Request $request)
    {
        $_user = new User();
        if ($request->has('query')) {
            $_user = $_user->where('username', 'like', '%' . $request->input('query') . '%')->orWhere('name', 'like', '%' . $request->input('query') . '%');
        }
        $users = $_user->paginate(20)->appends(request()->query());;
        return view('admin.manage-user')->with(array('users' => $users));
    }
    public function managecategories()
    {
        $_categories = new Categories();
        $categories = $_categories->paginate(10)->appends(request()->query());;
        return view('admin.manage-categories')->with(array('categories' => $categories));
    }
    public function removecategory($id)
    {
        $_categories = new Categories();
        $c = $_categories->where('category_id', '=', $id);
        $rowdeleted = $c->delete();
        if ($rowdeleted == 1) {
            return redirect('/admin/managecategories')->with('success', "Category Removed");
        }
    }
    public function editcategories(Request $request, $id)
    {
        if ($request->saveedituser) {
            $_categories = new Categories();
            $cat = $_categories->where('category_id', '=', $request->categoryid)->update(['category_name' => $request->cat]);
            return redirect()->back()->with('success', 'successfully updated');
        }
        $_categories = new Categories();
        $c = $_categories->where('category_id', '=', $id)->first();
        return view('admin.edit-category')->with(array('category' => $c));
    }
    public function addcategory(Request $request)
    {
        $_categories = new Categories();
        $_categories->category_name = ucfirst($request->category);
        if ($_categories->save()) {
            return redirect()->back()->with('success', 'Category Added');
        }
    }

    public function trans(Request $request)
    {
        $trans = new Transaction();
        if ($request->get('transid')) {
            $trans = $trans->where('transaction_id', '=', $request->get('transid'))->paginate(10)->appends(request()->query());;
        } else {
            if ($request->get('todate') != '' && $request->get('fromto') != '') {
                $trans = $trans->whereBetween('created_at', [$request->get('fromto'), $request->get('todate')])->paginate(10);
            } else if ($request->get('transid') != '') {
                $transid = $request->get('transid');
                $trans = $trans->where('transaction_id', '=', $transid)->paginate(10)->appends(request()->query());;
            } else {
                $trans = $trans->paginate(10)->appends(request()->query());;
            }
        }

        return view('admin.trans', array('trans' => $trans));
    }
    public function getbooks(Request $request)
    {
        $book = new Book();
        if ($request->has('q')) {
            $book = $book->where('title', 'like', '%' . $request->input('q') . '%');
        }
        if ($request->has('sortby')) {
            $book = $book->orderBy('title', $request->input('sortby'));
        }
        if ($request->has('m')) {
            $book = $book->where('mature', '>', 0);
        }
        $book = $book->paginate(10)->appends(request()->query());;
        return view('admin.managebook', array('books' => $book));
    }
    public function favorites(Request $request)
    {
        $book = new Book();
        $categories = new Categories();
        $categories = $categories->get();
        $mature = $request->get('mture');
        if ($request->has('q')) {
            $book = $book->where('title', 'like', '%' . $request->input('q') . '%');
        }
        if ($request->has('m')) {
            $book = $book->where('mature', '>', 0);
        }
        if ($request->get('c') != null) {
            $book = $book->whereIn('category_id', $request->get('c'));
        }
        if ($mature) {
            $book = $book->where('mature', '=', 1);
        }
        if ($request->has('sortby')) {
            $book = $book->orderBy('title', $request->input('sortby'));
        }
        if ($request->has('top')) {
            $bookid = $book->get(['book_id'])->toArray();
            $book = Book::withCount('getlikes')->whereIn('book_id', $bookid)->orderBy('getlikes_count', 'desc')->take($request->get('top'))->get();
            // $book = $book->orderBy('favorited','descending');
            // $book = $book->take($request->get('top'))->get();
        } else {
            $book = $book->paginate(10)->appends(request()->query());;
        }

        return view('admin.favorite', array('books' => $book, 'categories' => $categories));
    }
    public function bestselling(Request $request)
    {
        $dstamp1 = $request->input('from');
        $dstamp2 = $request->input('to');
        if ($request->has('from') & $request->has('to')) {
            $dtrans = $this->getbetweendatebestseller($request->input('from'), $request->input('to'));
            if ($request->has('top')) {
                $dtrans = $this->getbetweendatebestseller($request->input('from'), $request->input('to'), $request->input('top'));
            }
        } else {
            if ($request->has('top')) {
                $dtrans = $this->bestseller($request, $request->input('top'));
            } else {
                $dtrans = $this->bestseller($request);
            }
        }
        return view('admin.best-selling', array('best' => $dtrans));
    }


    public function bestauthor(Request $request, $take = '')
    {
        $_dtrans = new Dtrans();
        $year = date("Y");
        $month = date("m");
        $dstamp1 = $request->input('from');
        $dstamp2 = $request->input('to');
        if ($request->has('S')) {
            $number = $request->input('S');
        } else {
            $number = 5;
        }
        if ($request->input('Y') != '') {

            $year = $request->input('Y');
        }
        if ($request->input('M') != '') {

            $month = $request->input('M');
        }
        if ($request->has('from') && $request->has('to')) {
            $fromdate = $request->input('from');
            $todate = $request->input('to');
            $tes = DB::select("select DAY(LAST_DAY('$todate-01')) as COUNT;");
            $lastday = $tes[0]->COUNT;
            $dtrans = $_dtrans->leftjoin('books', 'dtrans.book_id', '=', 'books.book_id')->leftjoin('users', 'books.author', '=', 'users.user_id')
                ->select(DB::raw('sum(value)'), DB::raw('label'))->select([DB::raw('count(books.book_id) as value'), DB::raw('users.username as label')])
                ->whereBetween('dtrans.created_at', ["$fromdate-01", "$todate-$lastday"])
                ->orderBy('value', 'desc')
                ->groupBy('label')->get()
                ->toJson(JSON_PRETTY_PRINT);
        } else {
            $tes = DB::select("select DAY(LAST_DAY('$year-$month-01')) as COUNT;");
            $lastday = $tes[0]->COUNT;
            $dtrans = $_dtrans->leftjoin('books', 'dtrans.book_id', '=', 'books.book_id')->leftjoin('users', 'books.author', '=', 'users.user_id')
                ->select(DB::raw('sum(value)'), DB::raw('label'))->select([DB::raw('count(books.book_id) as value'), DB::raw('users.username as label')])
                ->whereBetween('dtrans.created_at', ["2020-$month-01", "$year-$month-$lastday"])
                ->orderBy('value', 'desc')
                ->groupBy('label')->get()
                ->toJson(JSON_PRETTY_PRINT);
        }
        // dd(DB::getQueryLog()); 
        return view('admin.best-author', array('best' => $dtrans));
    }
    public function getbestauthor(Request $request, $take = '')
    {
        $_dtrans = new Dtrans();
        $year = date("Y");
        $month = date("m");
        if ($request->has('S')) {
            $number = $request->input('S');
        } else {
            $number = 5;
        }
        if ($request->input('Y') != '') {

            $year = $request->input('Y');
        }
        if ($request->input('M') != '') {

            $month = $request->input('M');
        }
        $tes = DB::select("select DAY(LAST_DAY('$year-$month-01')) as COUNT;");
        $lastday = $tes[0]->COUNT;
        $dtrans = $_dtrans->leftjoin('books', 'dtrans.book_id', '=', 'books.book_id')->leftjoin('users', 'books.author', '=', 'users.user_id')
            ->select(DB::raw('sum(label)'), DB::raw('value'))->select([DB::raw('count(books.book_id) as label'), DB::raw('(users.username) as value')])
            ->whereBetween('dtrans.created_at', ["$year-$month-01", "$year-$month-$lastday"])
            ->orderBy('value', 'desc')
            ->groupBy('value')->get()
            ->toJson(JSON_PRETTY_PRINT);
        return $dtrans;
    }
    public function getbetweendatebestseller($fromdate, $todate, $top = '')
    {
        $_dtrans = new Dtrans();
        $tes = DB::select("select DAY(LAST_DAY('$todate-01')) as COUNT;");
        $lastday = $tes[0]->COUNT;
        if ($top) {
            $number = $top;
        } else {
            $number = 10;
        }
        $dtrans = $_dtrans->leftjoin('books', 'dtrans.book_id', '=', 'books.book_id')
            ->select([DB::raw('CONCAT(books.book_id,"-",books.title) as label'), DB::raw('COUNT(books.book_id) as value')])
            ->whereBetween('dtrans.created_at', ["$fromdate-01", "$todate-$lastday"])
            ->orderBy('value', 'desc')
            ->take($number)
            ->groupBy('label')->get()
            ->toJson(JSON_PRETTY_PRINT);
        return $dtrans;
    }
    public function bestseller(Request $request, $take = '')
    {
        $_dtrans = new Dtrans();
        $year = date("Y");
        $month = date("m");
        if ($request->has('S')) {
            $number = $request->input('S');
        } else {
            $number = 5;
        }
        if ($request->input('Y') != '') {
            $year = $request->input('Y');
        }
        if ($request->input('M') != '') {
            $month = $request->input('M');
        }
        $tes = DB::select("select DAY(LAST_DAY('$year-$month-01')) as COUNT;");
        $lastday = $tes[0]->COUNT;
        if ($number) {
            $dtrans = $_dtrans->leftjoin('books', 'dtrans.book_id', '=', 'books.book_id')
                ->select([DB::raw('CONCAT(books.book_id,"-",books.title) as label'), DB::raw('COUNT(books.book_id) as value')])
                ->whereBetween('dtrans.created_at', ["$year-$month-01", "$year-$month-$lastday"])
                ->orderBy('value', 'desc')
                ->take($number)
                ->groupBy('label')->get()
                ->toJson(JSON_PRETTY_PRINT);
        } else {
            $dtrans = $_dtrans->leftjoin('books', 'dtrans.book_id', '=', 'books.book_id')
                ->select([DB::raw('CONCAT(books.book_id,"-",books.title) as label'), DB::raw('COUNT(books.book_id) as value')])
                ->whereBetween('dtrans.created_at', ["$year-$month-01", "$year-$month-$lastday"])
                ->orderBy('value', 'desc')
                ->take($number)
                ->groupBy('label')->get()
                ->toJson(JSON_PRETTY_PRINT);
        }
        return $dtrans;
    }
    public function getlastregistered()
    {
        $_user = new User();
        $user = $_user->orderBy('created_at', 'desc')->take(10)->get();
        return $user;
    }
    public function viewtraffics(Request $request, $id = null, $userid)
    {

        $m = null;
        $y = null;
        // with bookid
        $_book = new Book();
        $books = $_book->select(['book_id', 'title', 'author'])->where('author', '=', $userid)->where('book_id', '=', $id)->get();
        $year = date("Y");
        $month = date("m");
        if ($request->get('time')) {
            $time = explode('/', $request->get('time'));
            $year = $time[0];
            $month = $time[1];
            // dd($request->get('time'));
        }
        if (!$id) {
            if ($request->get('stories') == "all") {
                $id = null;
            } else {
                $id = $request->get('stories');
            }
        } else {
            if ($request->get('stories')) {
                $id = $request->get('stories');
            }
        }
        $_year = $year - 1;
        $date_from = "$_year-01-01";
        $date_from = strtotime($date_from);
        $date_to = date('y') . "-" . date('m') . "-28";
        $date_to = strtotime($date_to); // Convert date to a UNIX timestamp  
        // Loop from the start date to end date and output all dates inbetween  
        for ($i = $date_to; $i >= $date_from; $i -= (86400 * 30)) {
            $dropdown[$i] = date("Y/m", $i);
        }
        $dropdown = array_unique($dropdown);
        if ($id == null) {
            $traffics = Traffics::select([
                DB::raw('count(traffic_id) as count'),
                DB::raw('DAY(DATE(created_at)) as day'),
            ])->whereYear('created_at', $year)
                ->whereMonth('created_at', '=', $month)
                ->groupby('day')
                ->get();
        } else {
            $traffics = Traffics::select([
                DB::raw('count(traffic_id) as count'),
                DB::raw('DAY(DATE(created_at)) as day'),
            ])->whereYear('created_at', $year)
                ->whereMonth('created_at', '=', $month)
                ->where('book_id', '=', $id)
                ->groupby('day')
                ->get();
        }
        $data['thismonth'] = (array_sum(array_column($traffics->toArray(), 'count')));
        $data['year'] = $year;
        $data['month'] = date('F', mktime(0, 0, 0, str_pad($month, 2, '0', STR_PAD_LEFT)));
        $book = $_book->where('author', '=', $userid)->where('book_id', '=', $id)->first();
        $data['infotraffic'] = $book;
        $data['books'] = $books;
        $tes = DB::select("select DAY(LAST_DAY('$year-$month-01')) as COUNT;");
        $lastday = $tes[0]->COUNT;
        for ($i = 1; $i <= $lastday; $i++) {
            $traffic[$i]['label'] = $i;
            $traffic[$i]['value'] = 0;
            for ($j = 0; $j < count($traffics); $j++) {
                if ($i == $traffics[$j]->day) {
                    $traffic[$i]['value'] = $traffics[$j]->count;
                }
            }
        }
        $traf = "";
        for ($i = 1; $i <= ($lastday); $i++) {
            $traf .= "{label : '" . $traffic[$i]['label'] . "', value: " . $traffic[$i]['value'] . "},";
        }
        return view('admin.viewtraffics', array('data' => $data, 'traffic' => json_encode($traf), 'dropdown' => $dropdown));
    }
    public function getPendapatan(Request $request)
    {
        $month = date("m");
        $year  = date('Y');
        if ($request('month')) {
            $month = $request('month');
        }
        if ($request('year')) {
            $year = $request('year');
        }
        $tes = DB::select("select DAY(LAST_DAY('$year-$month-01')) as COUNT;");
        $lastday = $tes[0]->COUNT;
        $_trans = new Transaction();
        $result = $_trans->where('created_at', '<=', "$year-$month-$lastday")
            ->where('created_at', '>=', "$year-$month-01")->get();
        return $result;
    }
    public function showflags()
    {
        $flags = new FlagReview();
        $flags = $flags->select(DB::raw('COUNT(*) as jum, review_id'))->groupBy('review_id')->orderBy('jum', 'desc')->get();
        return view('admin.flagreviews', array('flags' => $flags));
    }
    public function showaflag($id)
    {
        $review = new Reviews();
        $review = $review->where('review_id', '=', $id)->first();
        $flags = new FlagReview();
        $flags = $flags->where('review_id', '=', $id)->get();
        return view('admin.showaflag', array('flags' => $flags, 'review' => $review));
    }
    public function deleteflag($id)
    {
        $flags = new FlagReview();
        $flags = $flags->where('flag_id', '=', $id)->delete();
        return redirect()->back();
    }
    public function deletereview($id = "")
    {
        if ($id != "") {
            $affectedrows = Reviews::where('review_id', '=', $id)->delete();
            return redirect()->back()->with('success', 'Successfully Removed');
        }
    }
    public function preview(Request $request, $bookid = "")
    {
        if ($bookid) {
            $book = new Book();
            $b = $book->where('book_id', '=', $bookid)->first();
            if (isset($b->type)) {
                if (strtolower($b->type) == 'pdf') {
                    // go to pdfviewer
                    return view('admin/readpdf', ['book' => $b]);
                } else {
                    //go to stories
                    $_stories = new Stories();
                    $allstories = $_stories->where('book_id', $b->book_id)->get();
                    $stories = $_stories->where('book_id', $b->book_id)->paginate(1);
                    return view('admin/readstories', ['book' => $b, 'chapter' => $stories, 'options' => $allstories]);
                }
            }
        } else {
            return redirect()->back();
        }
    }
}
