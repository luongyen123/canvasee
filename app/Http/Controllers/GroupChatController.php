<?php

namespace App\Http\Controllers;


use Auth;
use Illuminate\Http\Request;
use App\GroupChat;

class GroupChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
        $groupchat = GroupChat::create(['name'=>$request->name]);

        $users = collect($request->users);

        $users->push(Auth::id());

        $groupchat->users()->attach($users);

        $groupchat = GroupChat::where('id',$groupchat->id)->with('groupusers')->first();

        return Response::json($groupchat,200);
;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GroupChat  $groupChat
     * @return \Illuminate\Http\Response
     */
    public function show(GroupChat $groupChat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GroupChat  $groupChat
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupChat $groupChat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroupChat  $groupChat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupChat $groupChat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroupChat  $groupChat
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupChat $groupChat)
    {
        //
    }
}
