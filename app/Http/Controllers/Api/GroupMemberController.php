<?php

namespace App\Http\Controllers\Api;

use App\Group;
use App\GroupMember;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Response;

class GroupMemberController extends Controller {
	//
	public $groupmember;

	public function __construct() {

		$this->middleware('jwt.auth');
	}

	/**
	 * User follow group.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function follow(Request $request) {

		$reponse = [];
		$reponse['code'] = 400;

		$following_group_id = $request->input('following');
		$following_user_id = Auth::user()->id;

		$checkFollow = (new GroupMember)->checkFollow($following_group_id, $following_user_id);

		if ($checkFollow) {
			$reponse['status'] = "Follwing";
			$reponse['code'] = 400;
		} else {
			$groupmember = new GroupMember();
			$groupmember->group_id = $following_group_id;
			$groupmember->user_id = $following_user_id;

			$groupmember->save();

			$reponse['status'] = "Success";
			$reponse['code'] = 200;

		}

		return Response::json(['status' => $reponse['status']], $reponse['code']);
	}

	/**
	 * User unfollow group.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function followDenied(Request $request) {

		$reponse = [];
		$reponse['code'] = 400;

		$me = $request->input('me');
		$following_group_id = $request->input('following');

		$checkFollow = (new GroupMember)->checkFollow($following_group_id, $me);

		if ($checkFollow) {

			$checkFollow->delete();
			$reponse['code'] = 200;
			$reponse['status'] = "Unfollow success";
		} else {
			$reponse['status'] = "data not found";
		}

		return Response::json(['status' => $reponse['status']], $reponse['code']);

	}

}
