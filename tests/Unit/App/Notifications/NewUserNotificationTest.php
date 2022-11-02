<?php

namespace App\Notifications;

use App\Listeners\SendEmailNewUserListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tests\Traits\CreateUserTrait;

class NewUserNotificationTest extends TestCase
{
    use CreateUserTrait;

    public function test_send_success()
    {
        $user = $this->createUser();

        Notification::fake();

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);
    }
}
