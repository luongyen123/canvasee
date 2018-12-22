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
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $chatroom;

    public function __construct(ChatRoom $chatroom)
    {
        $this->chatroom =$chatroom;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('groups.' .$this->converstation->group->id);
        return new Channel('groups.' .$this->chatroom->group->id);
    }

    public function broadcastWith(){
        return [
            'message'=>$this->chatroom->chat,
            'user'=>[
                'id'=>$this->chatroom->user->id,
                'name'=>$this->chatroom->user->name
            ]
        ];
    }

    // public function broadcastAs(){
    //     return 'message';
    // }
}
