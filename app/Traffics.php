<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traffics extends Model
{
    protected $table = 'viewtraffics';
    protected $primaryKey =  'traffic_id';
    public  $incrementing  = true;
    protected $fillable = ['traffic_id', 'book_id', 'ip_address', 'created_at', 'updated_at'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
}
