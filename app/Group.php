<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Feed;
use App\GroupMember;
use DB;

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

    public function selectAll(){
    	$data = DB::table('groups')
    			->join('feeds','groups.id','=','feeds.group_id')
    			->join('group_members','groups.id','=','group_members.group_id')
    			->select('groups.name');

    	return $data;
    }
}
