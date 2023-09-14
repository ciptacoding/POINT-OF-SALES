<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_page_can_be_rendered(): void
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_user_can_be_authenticated_using_his_credentials()
    {
        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => '4dm1n',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_user_may_not_loggedin_with_wrong_credentials()
    {
        $this->post('/login', [
            'username' => 'admin',
            'password' => 'incorrect-password',
        ]);
        $this->assertGuest();
    }
}
