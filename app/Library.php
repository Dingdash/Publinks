<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    //
    protected $table = 'library';
    protected $primaryKey =  'id';
    public  $incrementing  = true;
    protected $fillable = ['id', 'user_id', 'book_id', 'created_at', 'updated_at'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
    public function tags()
    {
        return $this->hasMany('App\BookTag', 'book_id', 'book_id');
    }
    public function book()
    {
        return $this->hasOne('App\Book', 'book_id', 'book_id');
    }
}
