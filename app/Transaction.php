<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $primaryKey =  'transaction_id';
    public  $incrementing  = false;
    protected $fillable = ['first_name', 'last_name', 'total', 'cart', 'payment_id', 'status', 'created_at', 'updated_at', 'transaction_id'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
    public function getCart()
    {
        return json_decode($this->cart, false);
    }
    public function getnewkey()
    {
        $awalan = "TRX" . date('Ymd');
        $lebar = 6;
        $hasil = $this->where('transaction_id', 'like', "$awalan%")->orderBy('transaction_id', 'DESC')->first(['transaction_id']);
        $nomor = "";
        if ($hasil == null) {
            $nomor = 1;
        } else {
            $row = $hasil->transaction_id;
            $nomor = intval(substr($row, strlen('TRX' . date('Ymd')))) + 1;
        }
        if ($lebar > 0) {
            $angka = $awalan . str_pad($nomor, $lebar, "0", STR_PAD_LEFT);
        } else {
            $angka = $awalan . $nomor;
        }
        return $angka;
    }
    public function details()
    {
        return $this->hasMany('App\Dtrans', 'transaction_id', 'transaction_id');
    }
}
