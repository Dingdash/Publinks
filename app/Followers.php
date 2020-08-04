<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Followers extends Model
{
    protected $table = 'followers';
    protected $primaryKey =  'id';
    public  $incrementing  = true;
    protected $fillable = ['follower_id', 'user_id'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
    public function follower()
    {
        return $this->hasOne('App\User', 'user_id', 'follower_id');
    }
    public function following()
    {
        return $this->hasOne('App\User', 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'user_id', 'user_id');
    }
}
