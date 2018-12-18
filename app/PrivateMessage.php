<?php

namespace App;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class PrivateMessage extends Model
{
    //

    protected $fillable =['sender_id','receiver_id','message','read'];

    protected $apepends =['sender','receiver'];


	public function getCreatedAttribute($value){
    	return Carbon::parse($value)->diffForHumans();
    }

    public function getSenderAttribute(){
    	return User::where('id',$this->sender_id)->first();
    }

    public function getReceiverAttribute(){
    	return User::where('id',$this->receiver_id)->first();
    }


}
