<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Feed;

class Feed extends Model
{
    public function group(){
    	return $this->belongsTo(Group::class);
    }

    public function feedsgruop($idgroup)
    {
    	$feeds= Feed::join('groups','feeds.group_id','=','groups.id')
                    ->where('feeds.group_id','=',$idgroup)
                    ->get();
        return view('Feed.index',compact('feeds'));
    }
}
