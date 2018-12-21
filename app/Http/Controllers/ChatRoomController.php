<?php

namespace App\Http\Controllers;

use App\ChatRoom;
use Illuminate\Http\Request;
use App\Events\NewMessage;
use Response;

class ChatRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = ChatRoom::all();
        return view('messages',compact('messages'));
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


    public function store(Request $request)
    {
        $conversation = ChatRoom::create([
            'chat' => $request->chat,
            'group_id' => $request->group_id,
            'user_id' => $request->user_id,
            // 'user_id' => auth()->user()->id,
        ]);

        event(
            $e = new NewMessage($conversation)
        );

        return redirect()->back();
        // return Response::json($$conversation,200);

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
	public function destroy(ChatRoom $chatRoom) {
		//
	}
}
