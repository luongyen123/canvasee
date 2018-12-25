<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;

class Comments extends Model
{
    protected $fillable =['id','user_id','content','feed_id'];

    //create comment
    public function create_cmt($request,$user_id){
        try{
            $comments = Comments::create([
                'content'=> $request->contents,
                'user_id' =>$user_id,
                'feed_id'=>$request->feed_id
            ]);
            return Response::json([
                'action' =>'comment_feed',
                'status'=>'200',
                'data'=>$comments

            ],200);
        } catch (\Exception $err){
            return Response::json([
                'action' =>'comment_feed',
                'status'=>$err->getMessage(),
            ],500);
        }
    }
}
