<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SignupTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    private const SIGNUP_ROUTE = '/sign-up';
    private const VALID_USER = 'Test User';
    private const VALID_EMAIL = 'test@example.com';


    public function test_guest_can_view_register_page()
    {
        // Act
        $response = $this->get('/signup-page');

        // Assert
        $response->assertStatus(200);
    }

        public function test_user_can_register_with_valid_data()
    {
        // Act
        $response = $this->post(self::SIGNUP_ROUTE, [
            'name' => self::VALID_USER,
            'email' => self::VALID_EMAIL,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Assert
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => self::VALID_EMAIL,
        ]);
    }

        public function test_registration_fails_without_name()
    {
        $response = $this->post(self::SIGNUP_ROUTE, [
            'email' => self::VALID_EMAIL,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertGuest();
    }

    public function test_registration_fails_without_email()
    {
        $response = $this->post(self::SIGNUP_ROUTE, [
            'name' => self::VALID_USER,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_registration_fails_with_invalid_email_format()
    {
        $response = $this->post(self::SIGNUP_ROUTE, [
            'name' => self::VALID_USER,
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_registration_fails_with_duplicate_email()
    {
        User::factory()->create([
            'email' => 'duplicate@example.com',
        ]);

        $response = $this->post(self::SIGNUP_ROUTE, [
            'name' => self::VALID_USER,
            'email' => 'duplicate@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_registration_fails_without_password()
    {
        $response = $this->post(self::SIGNUP_ROUTE, [
            'name' => self::VALID_USER,
            'email' => self::VALID_EMAIL,
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_registration_fails_without_password_confirmation()
    {
        $response = $this->post(self::SIGNUP_ROUTE, [
            'name' => self::VALID_USER,
            'email' => self::VALID_EMAIL,
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_registration_fails_passwords_does_not_match()
    {
        $response = $this->post(self::SIGNUP_ROUTE, [
            'name' => self::VALID_USER,
            'email' => self::VALID_EMAIL,
            'password' => 'password123',
            'password_confirmation' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_password_is_hashed_before_saving()
    {
        $this->post(self::SIGNUP_ROUTE, [
            'name' => self::VALID_USER,
            'email' => self::VALID_EMAIL,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', self::VALID_EMAIL)->first();

        $this->assertNotEquals('password123', $user->password);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

}
