<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\MediaClass;
class Feed extends Model {
	use MediaClass;
	protected $fillable = ['id', 'title', 'content', 'media_image','media_video','media_link', 'user_id', 'group_id'];

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

	// create feed
	public function createfeed($user_id, $req)
	{
		$content = $req->contents;
		$gruop_name = $req->gruop_name;
		// check hastag does exist
		$gruop = Group::select('id')->where('name','like',$gruop_name)->get();
		$total = $gruop->count();
		// return id
		if($total > 0) {
			$gruop_id =  $gruop[0]['id'];
		}
		else {      // create new hastag
			$newgruop = Group::create([
				'name'=>$gruop_name
			]);
			$gruop_id = $newgruop->id;
		}
		// save image to media
		if (!empty($req->file('images'))) {
			$media_images = $this->upload_image($req);
			$image_id = [];
			$media_image = json_decode(json_encode($media_images),true);
			foreach ($media_image['original']['data'] as $media_image) {
				foreach($media_image as $image) {
					array_push($image_id,$image['id']);
				}
			}
			$image_id = implode(',',$image_id);
		} else {
			$image_id = '';
			$media_images ='';
		}

		// save link to media
		if (!empty($req->link)) {
			$media_links =$this->upload_link($req);
			$link_id = [];
			$media_link = json_decode(json_encode($media_links),true);
			foreach ($media_link['original']['data'] as $media_link) {
				array_push($link_id,$media_link['id']);
			}
			$link_id = implode(',',$link_id);
		} else {
			$link_id = '';
			$media_links= '';
		}

		// save video to media
		if (!empty($req->file('videos'))) {
			$media_videos =$this->upload_video($req);
			$video_id = [];
			$media_video = json_decode(json_encode($media_videos),true);
			foreach ($media_video['original']['data'] as $media_video) {
				array_push($video_id,$media_video['id']);
			}
			$video_id = implode(',',$video_id);
		} else {
			$video_id = '';
			$media_videos ='';
		}
		$feed = Feed::create([
			'content'=>$content,
			'group_id'=>$gruop_id,
			'user_id'=>$user_id,
			'media_image'=>$image_id,
			'media_video'=>$video_id,
			'media_link'=>$link_id
		]);
		return Response::json([
			'feed'=>$feed,
			'image' => $media_images,
			'video' => $media_videos,
			'link' => $media_links
		]);
	}

}
