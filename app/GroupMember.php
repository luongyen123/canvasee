<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;
use App\User;
use DB;

class GroupMember extends Model
{
    
    //
    public function group(){
    	return $this->belongsTo(Group::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function checkFollow($group_id,$user_id){

    	$checkFollow = GroupMember::select('*')
    					->where('group_id',$group_id)
    					->where('user_id',$user_id)
    					->first();
    			
    	 return $checkFollow;

    }
}
