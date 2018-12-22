<?php

namespace App;

use App\Feed;
use App\GroupMember;

use App\ChatRoom;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Response;

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

	public function chatrooms(){
		return $this->hasMany(ChatRoom::class);
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

	public function hasUser($user_id) {

		foreach ($this->users as $user) {
			if ($user->id == $user_id) {
				return true;
			}
		}
	}
//list new feed
	public function getNewFeed($hastag) {
		$feed = DB::table('feeds')->join('users', 'users.id', 'feeds.user_id')
			->select('feeds.*', 'users.name', 'users.email')
			->where('group_id', $hastag)
			->orderBy('shares', 'desc')
			->orderBy('comments', 'desc')
			->orderBy('likes', 'desc');

		$total = $feed->count();
		$newfeed = $feed->take(2)->get();
		if ($total == 0) {
			return response([
				'status' => 'data not found',
			], 400);
		} else {
			return response([
				'data' => $newfeed,
				'total' => $total,
			], 200);
		}
	
	}

//list related hasgtag
	public function related($user_id)
	{
		$location = Userlocation::select('latitude','longitude')->where('user_id',$user_id)->get();
		$location = json_decode($location,true);

		$longitude1 = $location[0]['longitude'];
		$latitude1 = $location[0]['latitude'];

		//get hastag base radius 5 miles
		$longitude2 = (float)$longitude1 + 0.05619;
		$latitude2 = (float)$latitude1  + 0.05619;

		$sql = "SELECT groups.name ,users_locations.latitude, users_locations.longitude,users_locations.user_id
			 FROM group_members JOIN groups ON group_members.group_id = groups.id
			 JOIN users_locations ON users_locations.user_id = group_members.user_id
			 WHERE users_locations.latitude BETWEEN ".$latitude1." AND ".$latitude2."
			  	and users_locations.longitude BETWEEN ".$longitude1." and ".$longitude2."
			 AND NOT EXISTS (SELECT group_members.* FROM group_members WHERE users_locations.user_id = ".$user_id.")";

		$related = DB::select($sql);

		if (empty($related) ){
			return response([
				'status' => 'data not found',
			], 400);
		} else {
			return response([
				'data' => $related,
			], 200);
		}
	}
}
