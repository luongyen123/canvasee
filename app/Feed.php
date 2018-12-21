<?php

namespace App;

use App\Feed;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Response;

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
	//popular feed
	public function popular($user_id)
	{
		$feed = Feed::select('feeds.*','groups.name')->join('groups','groups.id','feeds.group_id')->where('user_id',$user_id)
			->orderBy('comments', 'desc')
			->orderBy('shares', 'desc')
			->orderBy('likes', 'desc')
			->take(5)
			->get();
		$total = $feed->count();
		if($total > 0) {
			return Response::json([
				'data' => $feed,
				'total' => $total
			],200);
		}else {
			return Response::json([
				'status' => 'data not found'
			],400);
		}
	}

}
