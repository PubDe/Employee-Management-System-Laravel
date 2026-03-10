<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateEmployeeTest extends TestCase
{
    use RefreshDatabase;

    private const UPDATE_ROUTE = '/edit-employee/';
    private const UPDATED_NAME = 'Updated Name';
    private const UPDATED_EMAIL = 'updated@example.com';
    private const UPDATED_AGE = 23;
    private const UPDATED_PHONE = '1234567890';
    private const UPDATED_DOB = '2000-01-01';
    private const UPDATED_ROLE = 'Manager';


    /** Guest cannot update employee */
    public function test_guest_cannot_update_employee()
    {
        $employee = Employee::factory()->create();

        $response = $this->put(self::UPDATE_ROUTE . $employee->id, [
            'name' => self::UPDATED_NAME,
            'email' => self::UPDATED_EMAIL,
            'age' => self::UPDATED_AGE,
            'phone' => self::UPDATED_PHONE,
            'dob' => self::UPDATED_DOB,
            'role' => self::UPDATED_ROLE,
        ]);

        $response->assertRedirect('/');
    }

    /** User can update employee with valid data */
    public function test_user_can_update_employee_with_valid_data()
    {
        $user = User::factory()->create();
        $employee = Employee::factory()->create();

        $response = $this->actingAs($user)->put(self::UPDATE_ROUTE . $employee->id, [
            'name' => self::UPDATED_NAME,
            'email' => self::UPDATED_EMAIL,
            'phone' => self::UPDATED_PHONE,
            'age' => self::UPDATED_AGE,
            'dob' => self::UPDATED_DOB,
            'role' => self::UPDATED_ROLE,
        ]);

        $response->assertRedirect('/view-employees');

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => self::UPDATED_NAME,
            'email' => self::UPDATED_EMAIL,
            'age' => self::UPDATED_AGE,
            'phone' => self::UPDATED_PHONE,
            'dob' => self::UPDATED_DOB,
            'role' => self::UPDATED_ROLE,
        ]);
    }

    /** Name is required */
    public function test_update_employee_fails_without_name()
    {
        $user = User::factory()->create();
        $employee = Employee::factory()->create();

        $response = $this->actingAs($user)->put(self::UPDATE_ROUTE . $employee->id, [
            'name' => '',
            'email' => self::UPDATED_EMAIL,
            'age' => self::UPDATED_AGE,
            'phone' => self::UPDATED_PHONE,
            'dob' => self::UPDATED_DOB,
            'role' => self::UPDATED_ROLE,
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** Email is required */
    public function test_update_employee_fails_without_email()
    {
        $user = User::factory()->create();
        $employee = Employee::factory()->create();

        $response = $this->actingAs($user)->put(self::UPDATE_ROUTE . $employee->id, [
            'name' => self::UPDATED_NAME,
            'email' => '',
            'age' => self::UPDATED_AGE,
            'phone' => self::UPDATED_PHONE,
            'dob' => self::UPDATED_DOB,
            'role' => self::UPDATED_ROLE,
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** Email must be unique */
    public function test_update_employee_email_must_be_unique()
    {
        $user = User::factory()->create();

        Employee::factory()->create([
            'email' => 'existing@example.com'
        ]);

        $employee2 = Employee::factory()->create();

        $response = $this->actingAs($user)->put(self::UPDATE_ROUTE . $employee2->id, [
            'name' => self::UPDATED_NAME,
            'email' => 'existing@example.com',
            'age' => self::UPDATED_AGE,
            'phone' => self::UPDATED_PHONE,
            'dob' => self::UPDATED_DOB,
            'role' => self::UPDATED_ROLE,
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** Name min/max validation */
    public function test_update_employee_name_validation()
    {
        $user = User::factory()->create();
        $employee = Employee::factory()->create();

        // Too short
        $response = $this->actingAs($user)->put(self::UPDATE_ROUTE . $employee->id, [
            'name' => 'Jo',
            'email' => self::UPDATED_EMAIL,
            'age' => self::UPDATED_AGE,
            'phone' => self::UPDATED_PHONE,
            'dob' => self::UPDATED_DOB,
            'role' => self::UPDATED_ROLE,
        ]);

        $response->assertSessionHasErrors('name');

        // Too long
        $response = $this->actingAs($user)->put(self::UPDATE_ROUTE . $employee->id, [
            'name' => str_repeat('A', 16),
            'email' => self::UPDATED_EMAIL,
            'age' => self::UPDATED_AGE,
            'phone' => self::UPDATED_PHONE,
            'dob' => self::UPDATED_DOB,
            'role' => self::UPDATED_ROLE,
        ]);

        $response->assertSessionHasErrors('name');
    }
}
