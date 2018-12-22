<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GroupUser;
use App\Conversation;
use App\User;


class GroupChat extends Model
{
    //
    //
    protected $table = 'group_chats';
    
    protected $fillable =['name'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function conversations(){
    	return $this->hasMany(Conversation::class);
    }

    public function hasUser($user_id)
    {
        foreach ($this->users as $user) {
            if($user->id == $user_id) {
                return true;
            }
        }
    }
}
