<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table = 'users';
    protected $primaryKey =  'user_id';
    public  $incrementing  = false;
    protected $fillable = ['user_id', 'name', 'email', 'password', 'email_verified_at', 'activation', 'status', 'about', 'website'];
    private $rules = [
        'email' => 'required|email|unique:users'
    ];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
    public function books()
    {
        return $this->hasMany('App\Book', 'author', 'user_id');
    }
    public function followers()
    {
        // tambahkan count() melihat jumlah follower
        return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id');
    }
    public function followings()
    {
        // tambahkan count() melihat jumlah following
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'user_id');
    }
    public function isFollowing(User $user)
    {
        return !!$this->followers()->where('follower_id', $user->user_id)->count();
    }
}
