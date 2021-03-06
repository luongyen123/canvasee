<?php

namespace App\Http\Controllers;

use App\GroupMember;
use Illuminate\Http\Request;

class GroupMemberController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($idgroup) {
		$member = (new GroupMember)->membergruop($idgroup);
		return $member;
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
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\GroupMember  $groupMember
	 * @return \Illuminate\Http\Response
	 */
	public function show(GroupMember $groupMember) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\GroupMember  $groupMember
	 * @return \Illuminate\Http\Response
	 */
	public function edit(GroupMember $groupMember) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\GroupMember  $groupMember
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, GroupMember $groupMember) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\GroupMember  $groupMember
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($idmember) {
		$member = GroupMember::find($idmember);
		$url = 'groups/' . $member->group_id . '/members';
		$member->delete();

		return redirect($url)->with(['flash_message' => 'Xoá thành công', 'flash_level' => 'success']);
	}

}
