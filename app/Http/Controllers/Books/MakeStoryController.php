<?php

namespace App\Http\Controllers\Books;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\Categories;
use App\Stories;
use App\Traffics;
use Storage;
use Illuminate\Support\Facades\File;
use DB;

class MakeStoryController extends Controller
{
    //
    public function index()
    {
        $_categories = new Categories();
        $categories = $_categories->all();
        return view('store.createstory')->with(array('categories' => $categories));
    }
    public function newstory(Request $request)
    {
        $title = $request['title'];
        $category = $request['category'];
        $about = $request['about'];
        $newbook = new Book();
        $newbook->about = $about;
        $newbook->category_id = $category;
        $newbook->title = $title;
        $newbook->progress = 0;
        $newbook->published = 0;
        $newbook->min_price = 20000;
        $newbook->max_price = 100000;
        $newbook->type = "STORIES";
        $newbook->author = session('user')->user_id;
        if (!$newbook->save()) {
            return redirect()->back()->with('error', 'Create Stories Failed, please refresh the browser');
        } else {
            return $this->story($newbook->book_id);
        }
    }

    public function editstory($storyid)
    {
        $_stories = new Stories();
        $story = $_stories->where('chapter_id', '=', $storyid);
        $story = $story->first();
        $file = "";
        if (File::exists(storage_path('app/public' . $story->manuscript)) && $story->manuscript != null) {
            $file = File::get(storage_path('app/public' . $story->manuscript));
        } else {
            return redirect()->back()->with('error', 'something is error');
        }
        return view('store.writestory', ['chapter' => $story->chapter_id, 'content' => $file, 'title' => $story->chapter_title]);
    }
    public function story($bookid)
    {
        $_stories = new Stories();
        $_stories->book_id = $bookid;
        $_stories->chapter_title = "Chapter";
        $_stories->position = $_stories->newposition($bookid);
        $_stories->save();
        return view('store.writestory', ['chapter' => $_stories->chapter_id]);
    }
    public function changeposition($old, $new)
    {

        $tes = DB::update("UPDATE stories a 
        INNER JOIN stories b 
        ON a.chapter_id = $old AND b.chapter_id = $new
        SET a.position = b.position, b.position = a.position");
        if ($tes == 1) {
            return redirect()->back();
        }
        //jika tes adalah 1
        //ada affected rows
        //else tidak ada affected rows
        //untuk swap position
    }

    public function save(Request $request)
    {
        $chapterid = $request->chapterid;
        if ($request->p == "true") {
            Storage::put("public/manuscript/" . $request->chapterid . ".txt", $request->content);
            Storage::put("public/published/" . $request->chapterid . ".txt", $request->content);
            $_stories = new Stories();
            $_stories = $_stories->where('chapter_id', '=', $chapterid)->first();
            $filename = '/manuscript/' . $chapterid . ".txt";
            $_stories->chapter_title =   htmlspecialchars_decode($request->title);
            $_stories->manuscript = $filename;
            $_stories->published = '/published/' . $chapterid . ".txt";
            if ($_stories->save()) {
                return  'published';
            }
        } else {
            Storage::put("public/manuscript/" . $request->chapterid . ".txt", $request->content);
            $_stories = new Stories();
            $_stories = $_stories->where('chapter_id', '=', $chapterid)->first();
            $filename = '/manuscript/' . $chapterid . ".txt";
            $_stories->chapter_title =  htmlspecialchars_decode($request->title);
            $_stories->manuscript = $filename;
            if ($_stories->save()) {
                return 'saved';
            }
        }
    }
    public function deletebychapter($id)
    {
        $_stories = new Stories();
        $stories = $_stories->where('chapter_id', '=', $id)->delete();
        return redirect()->back();
    }
    public function addviews(Request $request, $bookid)
    {
        $_traffics = new Traffics();
        $_traffics->ip_address = $request->ip();
        $_traffics->book_id = $bookid;
        $_traffics->save();
    }
    public function liststory($id)
    {
        $_book = new Book();
        $book =  $_book->where('book_id', '=', $id);
        $book =  $book->first();
        $chapters = $book->stories()->get();
        return view('library.chapterstory', array('stories' => $book, 'chapters' => $chapters));
    }
    public function updatesort(Request $request)
    {
        $chapter = $request->p;
        for ($i = 1; $i <= count($chapter); $i++) {
            $_c = new Stories();
            $_c->where('chapter_id', $chapter[$i - 1])->update(['position' => $i]);
        }
        echo 'order saved';
    }
}
