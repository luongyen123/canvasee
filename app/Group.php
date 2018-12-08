<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Feed;
use App\GroupMember;

class Group extends Model
{
    // public function topics(){
    // 	return $this->hasMany('App\Topic');
    // }

    public function feeds(){
    	return $this->hasMany(Feed::class);
    }

    public function members(){
    	return $this->hasMany(GroupMember::class);
    }
}
