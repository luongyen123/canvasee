<?php

namespace App;


use App\User;
use App\Group;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    //
    protected $fillable = ['user_id','group_id','chat'];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function group(){
    	return $this->belongsTo(Group::class);
    }
}
 