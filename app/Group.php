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

    public function users(){
    	return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function getGroupByUser($user_id){
    	$groups = Group::join('group_members','group_members.group_id','=','groups.id')
    				->where('group_members.user_id','=',$user_id)
    				->select('groups.name')
    				->get();
    	return $groups;
    }

    public function hasUser($user_id){

    	foreach($this->users as $user){
    		if($user->id == $user_id){
    			return true;   
    		}
    	}
    }
}
