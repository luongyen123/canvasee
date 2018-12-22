<?php

namespace App\Http\Controllers\Api;

use App\Feed;
use App\Group;
use App\Http\Controllers\Controller;
use App\Media;
use Auth;
use Illuminate\Http\Request;
use Response;
use DB;
use App\Http\Controllers\MediaClass;

class FeedController extends Controller {
    use MediaClass;
    public $group;

    public function __construct() {

        $this->middleware('jwt.auth');
    }

    public function popular()
    {
        $user_id = Auth::user()->id;
        $popular_feed = (new Feed)->popular($user_id);
        return $popular_feed;
    }
//create feed
    public function create(Request $req)
    {
        $content = $req->contents;
        $user_id = Auth::user()->id;

        $data = (new Feed)->createfeed($user_id,$req);
        return $data;

    }


}
