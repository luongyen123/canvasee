<?php

namespace App\Http\Controllers\Api;

use App\Group;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class GroupController extends Controller {
	//
	public $group;

	public function __construct() {

		$this->middleware('jwt.auth');
	}

	public function secure($id) {
		$group = Group::find($id);

		if ($group) {
			$this->group = $group;
			if (!Auth::user()->hasGroup($this->group->id));
			return true;
		}

		return false;
	}

	// List group user follow
	public function GroupByUser() {

		$user = Auth::user();

		$groups = (new Group)->getGroupByUser($user->id);

		return Response::json([
			'group' => $groups,
			'user' => $user->id,
		], 200);

	}

	//list new feed
	public function newfeed(Request $request) {
		$hastag = $request->hastag;
		$newfeed = DB::table('feeds')->select('feeds.*')->where('group_id', $hastag)->orderBy('created_at', 'desc')->take(3)->get();
		return response::json([
			'data' => $newfeed,
		]);
	}
}
