<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Group;
use Auth;
use Response;

class GroupController extends Controller
{
    //
    public $group;

    public function __construct(){

    	$this->middleware('jwt.auth');
    }

    public function secure($id){
    	$group = Group::find($id);

    	if($group){
    		$this->group = $group;
    		if(!Auth::user()->hasGroup($this->group->id));
    		return true;
    	}

    	return false;
    }

    // List group user follow
    public function GroupByUser(){

    	$user = Auth::user();

    	$groups = (new Group)->getGroupByUser($user->id);

    	return Response::json([
    	 	'group'=>$groups,
    	 	'user'=>$user->id
    	],200);

    }

    
}
