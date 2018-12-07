<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;
use App\User;

class GroupMember extends Model
{
    //
    public function group(){
    	return $this->belongsTo(Group::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
