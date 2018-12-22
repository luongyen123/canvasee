<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GroupUser;
use App\Conversation;


class GroupChat extends Model
{
    //
    //
    protected $table = 'group_chats';
    
    protected $fillable =['name'];

    public function users(){
    	return $this->belongsToMany(GroupUser::class);
    }

    public function conversations(){
    	return $this->hasMany(Conversation::class);
    }
}
