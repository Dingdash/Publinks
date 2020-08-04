<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $table = 'shopping_cart';
    protected $primaryKey =  'id';
    public  $incrementing  = true;
    protected $fillable = ['id', 'product_item', 'price', 'user_id', 'created_at', 'updated_at'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
    public function buku()
    {
        return $this->hasOne('App\Book', 'book_id', 'product_item');
    }
}
