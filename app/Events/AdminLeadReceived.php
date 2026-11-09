<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminLeadReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public int $id, public string $name, public string $subject, public string $type)
    {
    }

    public function broadcastOn(): array { return [new PrivateChannel('admin.notifications')]; }
    public function broadcastAs(): string { return 'lead.received'; }
    public function broadcastWith(): array { return ['id' => $this->type.'-'.$this->id, 'name' => $this->name, 'subject' => $this->subject, 'type' => $this->type, 'created_at' => now()->toIso8601String()]; }
}
