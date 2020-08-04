<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    protected $table = 'rates';
    protected $primaryKey =  'rate_id';
    public  $incrementing  = true;
    protected $fillable = ['review_id', 'reviewer_id', 'score', 'created_at', 'updated_at'];
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
    public function book()
    {
        return $this->hasOne('App\Book', 'book_id', 'book_id');
    }
    public function ratings()
    {
        return $this->hasOne('App\Ratings', 'review_id', 'review_id');
    }
}
