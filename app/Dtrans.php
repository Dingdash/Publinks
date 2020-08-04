<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dtrans extends Model
{
    //
    protected $table = 'dtrans';
    protected $primaryKey =  'dtrans_id';
    public  $incrementing  = true;
    protected $fillable = ['transaction_id', 'product_item', 'price', 'book_id', 'created_at', 'updated_at'];
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
        $hasil = $this->orderBy('transaction_id', 'DESC')->first(['transaction_id']);
        $record = 1;
        if ($hasil != null) {
            $record = $hasil->count();
        } else {
            $row = $hasil;
            $nomor = intval(substr($row, strlen('TRX'))) + 1;
        }
        if ($lebar > 0) {
            $angka = $awalan . str_pad($nomor, $lebar, "0", STR_PAD_LEFT);
        } else {
            $angka = $awalan . $nomor;
        }
        return $angka;
    }
}
