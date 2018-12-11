<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Group;
use App\User;
use App\GroupMember;
use Auth;
use Response;


class GroupMemberController extends Controller
{
    //
	public $groupmember;

    public function __construct(){
    
    	$this->middleware('jwt.auth');
    }

     /**
     * User follow group.
     *
     * @return \Illuminate\Http\Response
     */

    public function follow(Request $request){

    	$reponse=[];
    	$reponse['code']=400;    	

    	$following_group_id = $request->input('following');
    	$following_user_id = $request->input('follower');

    	$following = Group::find($following_group_id);
    	$follower = User::find($following_user_id);

    	$checkFollow = (new GroupMember)->checkFollow($following_group_id,$following_user_id);

    	var_dump($checkFollow);
    	    	
    	if($checkFollow){
    		$reponse['status']="Follwing";
			$reponse['code']=400;
    	}else{
    		$this->groupmember->group_id = $following_group_id;
    		$this->groupmember->user_id = $following_user_id;

    		$this->groupmember->save();

    		$reponse['status']="Success";    		
    		$reponse['code']=200;

    	}

    	// return Response::json(['status'=>$reponse['status']],$reponse['code']);
    }
}
