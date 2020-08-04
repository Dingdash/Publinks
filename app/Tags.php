<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = 'tag';
    protected $primaryKey =  'tag_id';
    public  $incrementing  = true;
    protected $fillable = ['tag_id', 'name', 'created_at', 'updated_at'];
    public function validate()
    {
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }
}
