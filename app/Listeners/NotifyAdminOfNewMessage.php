<?php

namespace App\Listeners;

use App\Events\MessageReceived;
use App\Models\AdminNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminOfNewMessage implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MessageReceived $event): void
    {
        AdminNotification::create([
            'contact_message_id' => $event->message->id,
            'message' => 'New contact message from ' . $event->message->name . ': ' . $event->message->subject,
        ]);
    }
}
