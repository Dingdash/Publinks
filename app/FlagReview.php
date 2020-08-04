<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlagReview extends Model
{
    protected $table = 'review_flags';
    protected $primaryKey =  'flag_id';
    public  $incrementing  = true;
    protected $fillable = ['review_id', 'type', 'description'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
}
