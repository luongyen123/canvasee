<?php

namespace App\Events;

use App\ChatRoom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $converstation;

    public function __construct(ChatRoom $chatroom)
    {
        $this->converstation =$chatroom;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('groups.' .$this->converstation->group->id);
    }

    public function broadcastWith(){
        return [
            'message'=>$this->converstation->chat,
            'user'=>[
                'id'=>$this->converstation->user->id,
                'name'=>$this->converstation->user->name
            ]
        ];
    }
}
