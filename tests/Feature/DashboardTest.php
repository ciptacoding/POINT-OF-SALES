<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    // use RefreshDatabase;

    public function test_dashboard_screen_can_be_rendered_if_user_authenticated(): void
    {
        $user = User::where('username', 'admin')->first();
        $this->actingAs($user);
        $this->get('/')->assertStatus(200);
    }

    public function test_redirect_if_user_not_authenticated()
    {
        $this->get('/')->assertRedirect(route('login'));
    }
}
