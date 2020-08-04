<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Book extends Model
{
    //
    protected $table = 'books';
    protected $primaryKey =  'book_id';
    public  $incrementing  = true;
    protected $fillable = ['book_id', 'category_id', 'title', 'author', 'uri', 'type', 'toc', 'min_price', 'published', 'max_price', 'free', 'cover', 'created_at', 'updated_at'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
    public function penulis()
    {
        return $this->belongsTo('App\User', 'author', 'user_id');
    }
    public function stories()
    {
        return $this->hasMany('App\Stories', 'book_id', 'book_id')->orderBy('stories.position');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Tags', 'book_tag', 'book_id', 'tag_id');
    }
    public function getlikes()
    {
        return $this->hasMany('App\Library', 'book_id', 'book_id')->where('favorited', '=', 1);
    }
    public function countlikes()
    {
        return $this->hasMany('App\Library', 'book_id', 'book_id')->where('favorited', '=', 1)->count();
    }
    public function cat()
    {
        return $this->belongsTo('App\Categories', 'category_id', 'category_id');
    }
}
