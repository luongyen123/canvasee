<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function topics(){
    	return $this->hasMany('App\Topic');
    }
}
