<?php

namespace App;

use App\User;
use App\GroupChat;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    //
    //
    protected $fillable = ['user_id','group_chat_id','message'];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function groupchat(){
    	return $this->belongsTo(GroupChat::class);
    }
}
