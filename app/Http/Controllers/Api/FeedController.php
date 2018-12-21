<?php

namespace App\Http\Controllers\Api;

use App\Feed;
use App\Group;
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
//create feed
    public function create(Request $req)
    {
        $content = $req->content;
        $user_id = Auth::user()->id;
        $gruop_name = $req->gruop_name;
        $gruop = Group::select('id')->where('name','like',$gruop_name)->get();
        $total = $gruop->count();
        if($total > 0) {
           $gruop_id =  $gruop[0]['id'];
        }
        else {
            $newgruop = Group::create([
                'name'=>$gruop_name
            ]);
            $gruop_id = $newgruop->id;
        }

        $files = $req->file('uploads');
        $a1=[];
        if (!empty($files)) {
            foreach ($files as $file) {
                $type = $file->getMimeType(); //get type
                $file_format = explode('/', $type);
                if($file_format[0] == 'image'){
                    $a = 'image';

                } else if($file_format[0] == 'video'){
                    $a = 'video';
                } else{
                    $a = 'link';
                }
                array_push($a1,$a);
            }

        }
        return $a1;
        $feed = Feed::create([
            'content'=>$content,
            'group_id'=>$gruop_id,
            'user_id'=>$user_id
        ]);
        return $feed;
    }


}
