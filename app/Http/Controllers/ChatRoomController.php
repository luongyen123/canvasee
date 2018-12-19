<?php

namespace App\Http\Controllers;

use App\ChatRoom;
use Illuminate\Http\Request;

class ChatRoomController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
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
	public function store(Request $request) {
		//
		$user_id = Auth::user()->id;
		$group_id = $request->group_id;
		$message = $request->chat;

		$reponse = [$message, $user_id, $group_id];

		$redis = LRedis::connection();

		$redis->publish('message', json_encode($reponse));

		return reponse()->json($reponse, 200);

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
