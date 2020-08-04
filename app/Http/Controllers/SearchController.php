<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\BookTag;
use App\Tags;
use App\User;

class SearchController extends Controller
{
    public function search(Request $r)
    {
        $query = $r->get('q');
        $mature = $r->get('mture');
        $categories = $r->get('c');
        $book = new Book();
        //search by author or books-title
        $book = $book->join('users', 'books.author', '=', 'users.user_id')
            ->where('users.name', 'like', '%' . $query . '%')
            ->orWhere('books.title', 'like', '%' . $query . '%')
            ->where('books.status', '=', 1)
            ->get(['books.book_id']);
        $book2 = new Book();
        //search by tag name
        $book2 = $book2->join('book_tag', 'books.book_id', 'book_tag.book_id')
            ->join('tag', 'tag.tag_id', 'book_tag.tag_id')
            ->where('tag.name', 'like', '%' . $query . '%')
            ->where('books.status', '=', 1)
            ->get(['books.book_id']);
        $merged = $book2->merge($book);
        $result = new Book();
        $result = $result->whereIn('book_id', $merged);
        if ($r->get('smin') != null) {
            $result = $result->where('min_price', '>=', $r->get('smin'));
        }
        if ($r->get('smax') != null) {
            $result = $result->where('max_price', '<=', $r->get('smax'));
        }
        if ($r->get('c') != null) {
            $result = $result->whereIn('category_id', $categories);
        }
        if ($mature) {
            $result = $result->where('mature', '=', 1);
        }
        $result = $result->paginate(10)->appends([
            'sort' => $r->input('sort'),
            'q' => $r->input('q'),
            'mture' => $r->input('mture'),
            'c' => $r->input('c'),
            'smin' => $r->input('smin'),
            'smax' => $r->input('smax')
        ]);
    }
}
