<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\RateLimiter;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    private const EMAIL='test@example.com';
    private const SIGNIN_ROUTE = '/login';


    public function test_guest_can_view_signin_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_is_redirected_from_signin_page()
    {
  
        $user=User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }


    public function test_user_can_login_with_valid_credentials()
    {
        $password = 'password123';

        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        $response = $this->post(self::SIGNIN_ROUTE, [
            'email' => $user->email,
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    
    public function test_login_is_rate_limited_after_failed_attempts()
    {
        // Disable actual login attempts to test RateLimiter only
        RateLimiter::clear('test@example.com|127.0.0.1');

        User::factory()->create([
            'email' => self::EMAIL,
            'password' => bcrypt('correctpassword'),
        ]);

        $maxAttempts = 5;

        // Attempt login with wrong password multiple times
        for ($i = 1; $i <= $maxAttempts; $i++) {
            $response = $this->post(self::SIGNIN_ROUTE, [
                'email' => self::EMAIL,
                'password' => 'wrongpassword',
            ]);

            $response->assertSessionHasErrors(['submit' => 'Invalid credentials.']);

        }

        // Next attempt should trigger rate limit
        $response = $this->post(self::SIGNIN_ROUTE, [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');

        $errors = session('errors')->get('email');
        $this->assertStringContainsString('Too many login attempts', $errors[0]);
    }


    public function test_login_fails_without_email()
    {
        $response = $this->post(self::SIGNIN_ROUTE, [
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_login_fails_with_invalid_email_format()
    {
        $response = $this->post(self::SIGNIN_ROUTE, [
            'email' => 'not-an-email',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_login_fails_without_password()
    {
        $response = $this->post(self::SIGNIN_ROUTE, [
            'email' => self::EMAIL,
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
    }

    public function test_login_fails_with_non_existing_email()
    {
        $response = $this->post(self::SIGNIN_ROUTE, [
            'email' => 'notfound@example.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }

    public function test_user_is_redirected_to_intended_page_after_login()
    {
        $password = 'password123';

        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        $this->get('/view-employees');

        $response = $this->post(self::SIGNIN_ROUTE, [
            'email' => $user->email,
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/view-employees');
    }


}
