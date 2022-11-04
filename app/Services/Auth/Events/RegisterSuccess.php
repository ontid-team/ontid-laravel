<?php

namespace App\Services\Auth\Events;

use App\Services\Auth\AuthService;
use App\Services\Auth\Interfaces\IUserModel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegisterSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public AuthService $service;
    public IUserModel $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AuthService $service, IUserModel $model)
    {
        $this->service = $service;
        $this->user = $model;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
