<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userlog extends Model
{
    //
    protected $table = 'user_log';
    protected $primaryKey =  'log_id';
    public  $incrementing  = true;
    protected $fillable = ['log_id', 'type', 'text', 'created_at', 'updated_at', 'user_id'];
    private $rules = [];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
}
