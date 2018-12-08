<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;

class Feed extends Model
{
    public function group(){
    	return $this->belongsTo(Group::class);
    }
}
