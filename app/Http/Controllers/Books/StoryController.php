<?php

namespace App\Http\Controllers\Books;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use Session;
class StoryController extends Controller
{
    public function index()
    {
        
        $_book = new Book();
        $books=$_book->where('author','=',Session::get('user')->user_id)->get();
        return view('library.yourstory')->with(array('books'=>$books));
    }
    //
}
