<?php

namespace App\Http\Controllers\Api;

use App\Feed;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Response;
use DB;
class FeedController extends Controller {
    //
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


}
