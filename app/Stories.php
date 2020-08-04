<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stories extends Model
{
    protected $table = 'stories';
    protected $primaryKey =  'chapter_id';
    public  $incrementing  = true;
    protected $fillable = ['chapter_id', 'book_id', 'category_id', 'chapter_title', 'published', 'created_at', 'updated_at'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
    public function newposition($bookid)
    {
        return $this->where('book_id', '=', $bookid)->count() + 1;
    }
}
