<?php

namespace App;

use App\Feed;
use App\GroupMember;
use Illuminate\Database\Eloquent\Model;

class Group extends Model {
	// public function topics(){
	// 	return $this->hasMany('App\Topic');
	// }
	protected $fillable = ['id', 'name'];
	public function feeds() {
		return $this->hasMany(Feed::class);
	}

	public function members() {
		return $this->hasMany(GroupMember::class);
	}

	public function getGroupByUser($user_id) {
		$groups = Group::join('group_members', 'group_members.group_id', '=', 'groups.id')
			->where('group_members.user_id', '=', $user_id)
			->select('groups.name')
			->get();
		return $groups;
	}

	// add group
	public function addgroup($group) {
		$group['name'] = $group['name_group'];
		$groups = Group::create($group);
		return $status = 'true';
	}

	public function users() {
		return $this->belongsToMany(User::class)->withTimestamps();
	}

	// public function getGroupByUser($user_id){
	// 	$groups = Group::join('group_members','group_members.group_id','=','groups.id')
	// 				->where('group_members.user_id','=',$user_id)
	// 				->select('groups.name')
	// 				->get();
	// 	return $groups;
	// }

	public function hasUser($user_id) {

		foreach ($this->users as $user) {
			if ($user->id == $user_id) {
				return true;
			}
		}
	}

}
