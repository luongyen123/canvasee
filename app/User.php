<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\GroupMember;
use App\ChatRoom;
use App\GroupChat;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function groupmembers(){
        return $this->hasMany(GroupMember::class);
    }

    public function chatrooms(){
        return $this->hasMany(ChatRoom::class);
    }

    public function groupusers()
    {
        return $this->belongsToMany(GroupChat::class)->withTimestamps();
    }
}
