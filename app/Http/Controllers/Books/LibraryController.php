<?php

namespace App\Http\Controllers\Books;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Session;
use App\Library;
use App\Traffics;
use App\Book;

use App\Stories;

class LibraryController extends Controller
{
    //
    public function index()
    {
        $userid = Session::get('user')->user_id;
        $_library = new Library();
        if (isset($_GET['libraryType'])) {
            if ($_GET['libraryType'] == "current") {

                $library = $_library->where('user_id', '=', $userid)->where('favorited', '=', 0)->get();
            } else {
                $library = $_library->where('user_id', '=', $userid)->where('favorited', '=', 1)->get();
            }
        } else {
            $library = $_library->where('user_id', '=', $userid)->where('favorited', '=', 0)->get();
        }
        return view('library.library')->with(array('book' => $library));
    }

    public function open(Request $request, $bookid)
    {
        $_books = new Book();
        $book = $_books->where('book_id', '=', $bookid);
        $_library = new Library();
        $library = $_library->where('book_id', '=', $bookid)->first();
        $book = $book->first();
        if (!$library) {
            if (Session::get('user')->user_id == $book->author) {
            } else {
                return redirect()->back();
            }
        }
        if ($book->type == "PDF") {
            return $this->openpdf($book, $bookid);
        } else {
            return  $this->openstories($book, $bookid, $request);
        }
    }
    public function openpdf($book, $bookid, $pages = 0)
    {
        if ($pages == 0) {
            if ($book->author != Session::get('user')->user_id) {
                $_traffics = new Traffics();
                $_traffics->ip_address = $this->getIP();
                $_traffics->book_id = $bookid;
                $saved = $_traffics->save();
                if ($saved == 1) {
                } else {
                }
            }
        }
        return view('library/readpdf', ['book' => $book]);
    }
    public function openstories($book, $bookid, $request)
    {
        //stories
        if (Session::get('user')->user_id != $book->author) {
            if ($request->get('page')) {
            } else {
                $_traffics = new Traffics();
                $_traffics->ip_address = $this->getIP();
                $_traffics->book_id = $bookid;
                $saved = $_traffics->save();
            }
        } else {
        }
        $_stories = new Stories();
        $allstories = $_stories->where('book_id', $book->book_id)->whereNotNull('published')->get();
        $stories = $_stories->where('book_id', $book->book_id)->whereNotNull('published')->paginate(1);
        return view('library/readstories', ['book' => $book, 'chapter' => $stories, 'options' => $allstories]);
    }
    public function addtoarchive(Request $request)
    {
        $_book = new Library();
        $book = $_book->where('book_id', $request->post('bookID'))->where('user_id', Session::get("user")->user_id)->first();
        $book->favorited = 1;
        $updated = $book->save();
    }
    public function unarchive(Request $request)
    {
        $_book = new Library();
        $book = $_book->where('book_id', $request->post('bookID'))->where('user_id', Session::get("user")->user_id)->first();
        $book->favorited = 0;
        $updated = $book->save();
        echo $updated;
    }
    public function getIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }
}
