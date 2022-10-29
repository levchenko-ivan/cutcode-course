<?php

namespace Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function is_store_success(): void
    {
        Event::fake();
        Notification::fake();

        $request = [
            'name'     => 'Test',
            'email'    => 'testing@email.ru',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ];

        $response = $this->post(route('store'), $request);

        $response->assertRedirect();

        $this->assertDatabaseHas('users');
    }
}
