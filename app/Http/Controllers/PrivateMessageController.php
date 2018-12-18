<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Response;
use App\PrivateMessage;

class PrivateMessageController extends Controller
{
    //

    public function getUserNotifications(Request $request){
    	$notifications = PrivateMessage::where('read',0)
    				->where('receiver_id',$request->user()->id)
    				->orderBy('created_at','desc')
    				->get();

    	return reponse(['data'=>$notifications],200);
    }

    public function getPrivateMessages(Request $request){

    	$pms = PrivateMessage::where('receiver_id',$request->user()->id)
    			->orderBy('created_at','desc')
    			->get();

    	return reponse(['data'=>$pms],200);
    }

    public function getPrivateMessageById(Request $request){

    	$pms = PrivateMessage::where('id',$request->id)->first();

    	// If the message is not read, change the status
    	if($pms->read == 0){
    		$pms->read=1;
    		$pms->save();
    	}

    	return reponse(['data'=>$pms],200);
    }

    public function getPrivateMessageSent(Request $request){

    	$pms = PrivateMessage::where('read',0)
    				->where('sender_id',$request->user()->id)
    				->orderBy('created_at','desc')
    				->get();

    	return reponse(['data'=>$pms],200);
    }

    public function sendPrivateMessage(Request $request){

    	$attributes =[
    		'sender_id'=>$request->sender_id,
    		'receiver_id'=>$request->receiver_id,
    		'message'=>$request->message,
    		'read'=>0

    	];

    	$pm = PrivateMessage::create($attributes);

    	$data = PrivateMessage::where('id',$pm->id)->first();

    	return reponse(['data'=>$data],201);

    }
}
