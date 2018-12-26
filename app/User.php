<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\GroupMember;
use App\ChatRoom;
use App\GroupChat;
//use Nexmo\Response;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

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
    //edit profile
    public function edit_profile($user_id,$req){
        try {
            $validator = Validator::make($req->all(), [
                'email' => 'string|email|max:255',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            User::where('id', $user_id)
                ->update([
                    'name' => $req->name,
                    'email' => $req->email,
                    'birthday' => $req->birthday,
                    'phone' => $req->phone
                ]);
            return Response::json([
                'action' => 'edit_profile',
                'status' => 200,
                'message' => 'Update success'
            ],200);
        } catch (\Exception $err){
            return Response::json([
                'action' => 'edit_profile',
                'status' => 500,
                'message' => $err->getMessage()
            ],500);
        }
    }
}
