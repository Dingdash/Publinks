<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $table = 'notifications';
    protected $primaryKey =  'id';
    public  $incrementing  = true;
    protected $fillable = ['id', 'recipient', 'type', 'follower_id', 'author_id', 'text', 'isRead', 'created_at', 'updated_at'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
    public function recipient()
    {
        return $this->belongsTo('App\User', 'recipient', 'user_id');
    }
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id', 'user_id');
    }
    public function book()
    {
        return $this->belongsTo("App\Book", 'book_id', 'book_id');
    }
}
