<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    // public function group(){
    // 	return belongsTo('App\Group');
    	
    // }

    public function feeds(){
    	return hasMany('App\Feed');
    }
}
