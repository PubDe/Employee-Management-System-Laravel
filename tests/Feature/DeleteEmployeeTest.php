<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteEmployeeTest extends TestCase
{
    use RefreshDatabase;

        public function test_example()
    {
        $this->assertTrue(true);
    }


    /** Guest cannot delete employee */
    // public function test_guest_cannot_delete_employee()
    // {
    //     $employee = Employee::factory()->create();

    //     $response = $this->delete(self::DELETE_ROUTE . $employee->id);

    //     $response->assertRedirect('/');
    // }

    /** User can delete employee */
    // public function test_user_can_delete_employee()
    // {
    //     $user = User::factory()->create();
    //     $employee = Employee::factory()->create();

    //     $response = $this->actingAs($user)
    //                      ->delete(self::DELETE_ROUTE . $employee->id);

    //     $response->assertRedirect('/view-employees');

    //     $this->assertDatabaseMissing('employees', [
    //         'id' => $employee->id,
    //     ]);
    // }

    /** Delete returns success flash message */
    // public function test_delete_employee_sets_success_message()
    // {
    //     $user = User::factory()->create();
    //     $employee = Employee::factory()->create();

    //     $response = $this->actingAs($user)
    //                      ->delete(self::DELETE_ROUTE . $employee->id);

    //     $response->assertSessionHas('success');
    // }
}
