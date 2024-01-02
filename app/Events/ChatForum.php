<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatForum implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $name;
    public $created_at;
    public $photo;
    public $nip;
    public $message_photo;

    public function __construct($nip,$name, $message, $created_at, $photo)
    {
        $this->nip = $nip;
        $this->name = $name;
        $this->message = $message;
        $this->created_at = $created_at;
        $this->photo = $photo;
    }

    public function broadcastOn():array
    {
        return [new Channel ('chat')];
    }

    public function broadcastAs()
    {
        return 'message';
    }
}
