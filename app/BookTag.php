<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookTag extends Model
{
    //
    protected $table = 'book_tag';
    public  $incrementing  = false;
    protected $fillable = ['book_id', 'tag_id', 'created_at', 'updated_at'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
    public function tag()
    {
        return $this->hasOne('App\Tags', 'tag_id', 'tag_id');
    }
    public function getname()
    {
        return $this->hasOne('App\Tags', 'tag_id', 'tag_id');
    }
}
