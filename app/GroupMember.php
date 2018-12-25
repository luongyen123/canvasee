<?php

namespace App;

use App\Group;
use App\User;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model {

	//
	public function group() {
		return $this->belongsTo(Group::class);
	}

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function checkFollow($group_id, $user_id) {

		$checkFollow = GroupMember::select('*')
			->where('group_id', $group_id)
			->where('user_id', $user_id)
			->first();

		return $checkFollow;

	}
	public function membergruop($idgroup) {
		$member = GroupMember::join('groups', 'group_members.group_id', '=', 'groups.id')
			->where('group_members.group_id', '=', $idgroup)
			->select('group_members.*')
			->get();
		$group = Group::pluck('name', 'id');
		$user = User::pluck('email', 'id');

		return view('GroupMember.index', compact('member', 'idgroup', 'group', 'user'));
	}

}
