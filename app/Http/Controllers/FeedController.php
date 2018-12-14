<?php

namespace App\Http\Controllers;

use App\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($idgroup) {
		$feeds = (new Feed)->feedsgruop($idgroup);
		return $feeds;
	}

	//list feed by user
	public function feeduser() {
		$user_id = Auth::user()->id;
		$feeduser = (new Feed)->feeduser($user_id);
		return view('Feed/feeduser', compact('user_id', 'feeduser'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($idgroup) {

		return view('Feed/create', compact('idgroup'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Feed  $feed
	 * @return \Illuminate\Http\Response
	 */
	public function show(Feed $feed) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Feed  $feed
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Feed $idgroup, $feed) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Feed  $feed
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Feed $feed) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Feed  $feed
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($idfeed) {
		$feed = Feed::find($idfeed);
		$url = 'groups/' . $feed->group_id . '/feeds';
		$feed->delete();

		return redirect($url)->with(['flash_message' => 'Xoá thành công', 'flash_level' => 'success']);
	}

}
