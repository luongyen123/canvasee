<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Resources\Group\GroupResource;
use DB;
use Illuminate\Http\Request;

class GroupController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$data = Group::all();
		return view('Group/index', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$group = $request->all();
		$new = (new Group)->addgroup($group);
		return $new;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Group  $group
	 * @return \Illuminate\Http\Response
	 */
	public function show(Group $group) {
		return new GroupResource($group);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Group  $group
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Group $group) {

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Group  $group
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request) {
		$group = DB::table('groups')
			->where('id', $request->idgroup)
			->update([
				'name' => $request->editname,
			]);
		return $status = 'true';
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Group  $group
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($idgroup) {
		$group = Group::find($idgroup);
		$group->delete();
		return redirect('groups')->with(['flash_message' => 'Xoá thành công', 'flash_level' => 'success']);
	}

	public function feedgroup() {
		# code...
	}

}
