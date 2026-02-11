<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddEmployeeTest extends TestCase
{

    use RefreshDatabase;

    private const VALID_NAME = 'Test Employee';
    private const VALID_EMAIL = 'testemployee@example.com';
    private const VALID_AGE = 25;
    private const VALID_PHONE = '1234567890';
    private const VALID_DOB = '2000-01-01';
    private const VALID_ROLE = 'Manager';
    private const ROUTE = '/add-employee';

    private function validPayload(array $overrides = [])
    {
        return array_merge([
            'name' => self::VALID_NAME,
            'email' => self::VALID_EMAIL,
            'age' => self::VALID_AGE,
            'phone' => self::VALID_PHONE,
            'dob' => self::VALID_DOB,
            'role' => self::VALID_ROLE,
        ], $overrides);
    }


    public function test_guest_cannot_view_add_employee()
    {

        $response = $this->get('/add');
        $response->assertRedirect('/'); //Default landing page which includes login
    }

    public function test_guest_cannot_add_employee()
    {
        $response = $this->post(self::ROUTE,[
            'name' => self::VALID_NAME,
            'email' => self::VALID_EMAIL,
            'age' => self::VALID_AGE,
            'phone' => self::VALID_PHONE,
            'dob' => self::VALID_DOB,
            'role' => self::VALID_ROLE,
        ]);


        $response->assertRedirect('/');
        $this->assertDatabaseCount('employees', 0);
    }

    public function test_user_can_add_employee_with_valid_data()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(self::ROUTE,[
            'name' => self::VALID_NAME,
            'email' => self::VALID_EMAIL,
            'age' => self::VALID_AGE,
            'phone' => self::VALID_PHONE,
            'dob' => self::VALID_DOB,
            'role' => self::VALID_ROLE,
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('employees', [
            'email' => self::VALID_EMAIL,
            'name' => self::VALID_NAME,
        ]);
    }


    public function test_add_employee_fails_without_name()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(self::ROUTE, $this->validPayload(['name' => '']));

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('employees', 0);
    }


    public function test_add_employee_fails_without_email()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(self::ROUTE, $this->validPayload(['email' => '']));

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('employees', 0);
    }


    public function test_add_employee_fails_without_age()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(self::ROUTE, $this->validPayload(['age' => '']));

        $response->assertSessionHasErrors('age');
        $this->assertDatabaseCount('employees', 0);
    }

    public function test_add_employee_fails_without_phone()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(self::ROUTE, $this->validPayload(['phone' => '']));

        $response->assertSessionHasErrors('phone');
        $this->assertDatabaseCount('employees', 0);
    }

    public function test_add_employee_fails_without_dob()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(self::ROUTE, $this->validPayload(['dob' => '']));

        $response->assertSessionHasErrors('dob');
        $this->assertDatabaseCount('employees', 0);
    }

    public function test_add_employee_fails_without_role()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(self::ROUTE, $this->validPayload(['role' => '']));

        $response->assertSessionHasErrors('role');
        $this->assertDatabaseCount('employees', 0);
    }

    public function test_add_employee_name_validation()
    {
        $user = User::factory()->create();

        // Name too short
        $response = $this->actingAs($user)->post(self::ROUTE, $this->validPayload(['name' => 'Jo']));
        $response->assertSessionHasErrors('name');

        // Name too long
        $response = $this->actingAs($user)->post(self::ROUTE, $this->validPayload(['name' => str_repeat('A', 16)]));
        $response->assertSessionHasErrors('name');

        // Name with invalid characters
        $response = $this->actingAs($user)->post(self::ROUTE, $this->validPayload(['name' => 'John123']));
        $response->assertSessionHasErrors('name');
    }

    public function test_add_employee_email_must_be_unique()
    {
        $user = User::factory()->create();

        Employee::create([
            'name' => 'Test User',
            'email' => self::VALID_EMAIL,
            'age' => 25,
            'phone' => '1234567890',
            'dob' => '2000-01-01',
            'role' => 'Manager',
        ]);


        $response = $this->actingAs($user)->post(self::ROUTE, $this->validPayload());
        $response->assertSessionHasErrors('email');
    }

    public function test_add_employee_age_max_3_digits()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(self::ROUTE, $this->validPayload(['age' => 1234]));
        $response->assertSessionHasErrors('age');
    }

    public function test_add_employee_phone_max_10_digits()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(self::ROUTE, $this->validPayload(['phone' => '12345678901']));
        $response->assertSessionHasErrors('phone');
    }


}
