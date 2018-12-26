<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Feed;

class Likes extends Model
{
    protected $fillable = ['id','user_id','feed_id'];
    public function feed(){
        return $this->belongsTo(Feed::class);
    }
}
