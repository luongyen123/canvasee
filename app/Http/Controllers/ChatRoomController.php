<?php

namespace App\Http\Controllers;

use App\ChatRoom;
use App\Group;
use Illuminate\Http\Request;
use App\Events\NewMessage;
use Response;
use Auth;

class ChatRoomController extends Controller
{
    /**
     * Display a listing message of chatting room
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $group)
    {
       return Response::json($group->chatrooms()->with('user')->latest());
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Group $group, Request $request)
    {
       
        $chatroom = $group->chatrooms()->create([
            'chat'=>$request->chat,
            'user_id'=>Auth::id(),
        ]);

        $chatroom = ChatRoom::where('id',$chatroom->id)->with('user')->first();
        

        broadcast(new NewMessage($chatroom))->toOthers();

        return Response::json($chatroom,200);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\ChatRoom  $chatRoom
	 * @return \Illuminate\Http\Response
	 */
	public function show(ChatRoom $chatRoom) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\ChatRoom  $chatRoom
	 * @return \Illuminate\Http\Response
	 */
	public function edit(ChatRoom $chatRoom) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\ChatRoom  $chatRoom
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, ChatRoom $chatRoom) {
		//
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChatRoom  $chatRoom
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatRoom $chatRoom)
    {
        //
    }
}
