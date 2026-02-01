<?php

namespace Tests\Feature;

use App\Events\MessageReceived;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submission_dispatches_event()
    {
        Event::fake();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('contact.store'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test Message',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
        ]);

        Event::assertDispatched(MessageReceived::class, function ($event) {
            return $event->message->email === 'john@example.com';
        });
    }

    public function test_listener_creates_admin_notification()
    {
        $user = User::factory()->create();

        $message = ContactMessage::create([
            'user_id' => $user->id,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Listener Test',
            'message' => 'Testing listener.',
        ]);

        $event = new MessageReceived($message);
        $listener = new \App\Listeners\NotifyAdminOfNewMessage();
        $listener->handle($event);

        $this->assertDatabaseHas('admin_notifications', [
            'contact_message_id' => $message->id,
            'message' => 'New contact message from Jane Doe: Listener Test',
        ]);
    }
}
