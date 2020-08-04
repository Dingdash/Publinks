<?php

namespace App\Http\Controllers\Books;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\Categories;
use App\Tags;
use App\BookTag;
use App\Library;
use App\Notifications;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Validator;
use Session;

class MakeBookController extends Controller
{
    //
    public function index()
    {
        return view('store.createstory-menu');
    }
    public function menupdf()
    {
        $_categories = new Categories();
        $categories = $_categories->all();
        return view('store.createpdf')->with(array('categories' => $categories));
    }
    public function getBookImage($filename)
    {
        $file  = Storage::disk('local')->get('/' . $filename);
        return new Response($file, 200);
    }
    public function publishing(Request $request, $bookid = '')
    {
        $_book = new Book();
        if ($request->method() == 'POST') {
            if ($request->SUBMIT == "Cancel") {
                return redirect('authorstory#' . $bookid);
            } else if ($request->SUBMIT == "Publish") {
                $bookid = $request->bookid;
                $book = $_book->where('book_id', '=', $bookid)->first();
                $book->published = 1;
                if ($book->save()) {
                    $recipient = new Book();
                    $recipient = $recipient->where('book_id', '=', $bookid)->first();

                    foreach ($recipient->penulis->followers as $r) {
                        //notification
                        $_notif = new Notifications();
                        $_notif->recipient = $r->user_id;
                        $_notif->status = 1;
                        $_notif->type = 1;
                        $_notif->book_id = $bookid;
                        $_notif->author_id = Session::get('user')->user_id;
                        $_notif->save();
                    }
                    return redirect()->back()->with('success', 'Published');
                } else {
                    return redirect()->back()->with('error', 'There was an error from the server');
                }
            }
        }
        $book = $_book->where('book_id', '=', $bookid)->first();
        return view('publishing', ['books' => $book]);
    }

    public function createnewpdf(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|max:255',
            'category' => 'required',
            'pdf' => "required|mimes:pdf|max:32000"
        ]);
        if ($validator->fails()) {
            return  redirect()
                ->back()
                ->withErrors($validator->errors());
        }
        $title = $request['title'];
        $category = $request['category'];
        $about = $request['about'];
        $newbook = new Book();
        //TODO
        $bookid = Book::latest()->value('book_id');

        if ($bookid == null) {
            $bookid = 1;
        }

        $file = $request->file('pdf');
        $filename = $bookid . '.' . $file->extension();
        $path = null;
        if ($file) {
            $path = $request->file('pdf')->storeAs('public/pdfs', $filename);
            $newbook->uri = 'pdfs/' . $filename;
        }
        $newbook->category_id = $category;
        $newbook->min_price = 20000;
        $newbook->max_price = 100000;
        $newbook->progress = 0;
        $newbook->title = $title;
        $newbook->type = "PDF";
        $newbook->author = Session::get('user')->user_id;
        $newbook->about = $about;
        if (!$newbook->save()) {
            return redirect()->back()->with('error', 'Upload Failed');
        } else {
            return  redirect()->back()->withSuccess('Upload Successful');
        }
    }
    public function editbookinfo($id)
    {
        $_categories = new Categories();
        $categories = $_categories->all();
        $_book = new Book();
        $book = $_book->where('book_id', '=', $id)->first();
        return view('store.editbookinfo', array('categories' => $categories, 'book' => $book));
    }

    public function saveeditbookinfo(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|max:255',
            'category' => 'required',
            'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096'
        ]);
        if ($validator->fails()) {
            return  redirect()->back()->withErrors($validator->errors());
        }
        $bookid = $request['bookid'];
        $title = $request['title'];
        $category = $request['category'];
        $file = $request['cover'];
        $path = null;
        $minprice = $request['minprice'];
        $maxprice = $request['maxprice'];
        $type = $request['booktype'];
        $mature = $request['mature'];
        $progress = $request['progress'];
        $tags = $request['tags'];
        $about = $request['about'];
        $newbook = new Book();
        $newbook = $newbook->where('book_id', '=', $bookid)->first();
        $newbook->title = $title;
        $newbook->author = Session::get('user')->user_id;
        $newbook->category_id = $category;
        $newbook->min_price = $minprice;
        $newbook->max_price = $maxprice;
        $newbook->type = $type;
        $newbook->progress = $progress;
        $newbook->about = $about;
        if ($file) {
            $path = $request->file('cover')->storeAs('public/bookcovers', $bookid . '-' . time() . '.' . $file->extension());
            $newbook->cover = 'bookcovers/' . $bookid . '-' . time() . '.' . $file->extension();
        }
        if ($mature) {
            $newbook->mature = 1;
        } else {
            $newbook->mature = null;
        }
        if ($request['free']) {
            $newbook->free  = 1;
            $newbook->min_price = null;
            $newbook->max_price = null;
        } else {
            $newbook->free = 0;
        }
        $newbook->save();
        $id = $newbook->id;
        // $newbook->cover = $cover;

        if ($tags) {
            $tags = str_replace(' ', '', $tags);
            $tags_arr = explode(',', $tags);
            $booktag = new BookTag();
            $booktag->where('book_id', '=', $bookid)->delete();
            foreach ($tags_arr as $tag) {
                $newtag = new Tags();
                $newtag->updateOrCreate(['name' => $tag]);
                $newtag = new Tags();
                $newtag = $newtag->where('name', '=', $tag)->first();
                $booktag = new BookTag();
                $booktag->updateOrCreate(['tag_id' => $newtag->tag_id, 'book_id' => $bookid]);
            }
        } else {
            $booktag = new BookTag();
            $booktag->where('book_id', '=', $bookid)->delete();
        }
        return redirect()->back()->with(['success' => "book info successfully updated"]);
    }
    public function updatenewpdf(Request $request, $id)
    {
        $_book = new Book();
        if ($request->method() == 'POST') {
            if ($request->SUBMIT == "Cancel") {
                return redirect('authorstory#2');
            } else if ($request->SUBMIT == "Upload") {
                $validator = Validator::make(request()->all(), [
                    'pdf' => "required|mimes:pdf|max:32000"
                ]);
                if ($validator->fails()) {
                    return  redirect()->back()->withErrors($validator->errors());
                }
                $bookid = $request->bookid;
                $book = $_book->where('book_id', '=', $bookid)->first();
                if ($request->file('pdf') != null) {
                    $file = $request->file('pdf');
                    $filename = $bookid . '.' . $file->extension();
                    $path = null;
                    if ($file) {
                        $path = $request->file('pdf')->storeAs('public/pdfs', $filename);
                        $book->uri = 'pdfs/' . $filename;
                    }
                    if ($book->save()) {
                        return redirect()->back()->with('success', 'you have updated the book to a new version');
                    } else {
                        return redirect()->back()->with('error', 'There was an error from the server');
                    }
                } else {
                    return redirect()->back();
                }
            }
        }
        $book = $_book->where('book_id', '=', $id)->first();
        return view('library.updatenewpdf', ['books' => $book]);
    }
    public function edittoc(Request $request)
    {
        $_book = new Book();
        $book = $_book->where('book_id', '=', $request->bookid)->first();
        $book->toc = $request->texttoc;
        $book->save();
        return redirect()->back()->with(['success' => 'table of content succesfully updated']);
    }
}
