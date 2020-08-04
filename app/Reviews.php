<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Book;
use App\User;

class Reviews extends Model
{
    protected $table = 'reviews';
    protected $primaryKey =  'reviews';
    public  $incrementing  = true;
    protected $fillable = ['content', 'reviewer_id', 'book_id', 'reply', 'replier_id', 'created_at', 'updated_at'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
    public function reviewer()
    {
        return $this->hasOne('App\User', 'user_id', 'reviewer_id');
    }
    public function score()
    {
        return $this->hasOne('App\Ratings', 'review_id', 'review_id');
    }
    public function replier()
    {
        return $this->hasOne('App\User', 'user_id', 'replier_id');
    }
    public function book()
    {
        return $this->hasOne('App\Book', 'book_id', 'book_id');
    }

    public function isReviewed($user_id, $book_id)
    {
        return !!$this->where('reviewer_id', $user_id)->where('book_id', $book_id)->count();
    }
}
