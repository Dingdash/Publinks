<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlist';
    protected $primaryKey =  'wishlist_id';
    public  $incrementing  = true;
    protected $fillable = ['user_id', 'item_id', 'uri', 'created_at', 'updated_at'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
    public function book()
    {
        return $this->hasOne('App\Book', 'book_id', 'item_id');
    }
}
