<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_loggedin_can_be_logout(): void
    {
        $user = User::where('username', 'admin')->first();
        $this->actingAs($user);
        $this->post('/logout')->assertRedirect(route('login'));
    }
}
