<?php

namespace App;

use App\GroupChat;
use App\User;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    //
    protected $table = 'group_users';
    
    protected $fillable =['group_chat_id','user_id'];

    public function groupchat(){
    	return $this->belongsToMany(GroupChat::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
