<?php

namespace App;

use App\Feed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Feed extends Model {
	protected $fillable = ['id', 'title', 'content', 'medias', 'user_id', 'group_id'];
	public function group() {
		return $this->belongsTo(Group::class);
	}
// feed by group
	public function feedsgruop($idgroup) {
		$feeds = Feed::join('groups', 'feeds.group_id', '=', 'groups.id')
			->where('feeds.group_id', '=', $idgroup)
			->select('feeds.*')
			->get();
		$group = Group::pluck('name', 'id');
		return view('Feed.index', compact('feeds', 'idgroup', 'group'));
	}
//  feed by user
	public function feeduser($user_id) {
		$feed_user = DB::table('feeds')->where('user_id', $user_id)->get();
		return $feed_user;
	}

}
