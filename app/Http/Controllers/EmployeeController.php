<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Throwable;



class EmployeeController extends Controller
{
    // Employee Registration
    public function addEmployee(Request $request) {
    
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:15', 'regex:/^[A-Za-z\s]+$/'],
            'email' => ['required', 'email',  'unique:employees,email'],
            'age' => ['required', 'max:3'],
            'phone' => ['required', 'max:10'],
            'dob' => ['required'],
            'role' => ['required']

        ]);

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $incomingFields['age'] = strip_tags($incomingFields['age']);
        $incomingFields['phone'] = strip_tags($incomingFields['phone']);


        try {
            Employee::create($incomingFields);
                return redirect('/dashboard')
                    ->with('success', 'Employee added successfully!');
        } catch (QueryException $e) {
                logger()->error($e->getMessage());
                return back();
        } catch (Throwable $e) {
                logger()->critical($e->getMessage());
                return back();
        }

    }

    //Edit Employee Information - Page view
    public function editEmployee(Employee $employee){
        return view('edit-employee', ['employee'=>$employee]);
    }

    //Update Employee info
    public function updateEmployee(Employee $employee, Request $request){
        
    $incomingFields = $request->validate([
        'name' => ['required', 'min:3', 'max:15'],
        'email' => ['required', 'email', 'unique:employees,email,' . $employee->id],
        'age' => ['required','max:3'],
        'phone' => ['required','max:10'],
        'dob' => ['required','date'],
        'role' => ['required'],
    ]);


        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);


        //log errors
        try {
            $employee -> update($incomingFields);
            return redirect('/view-employees')->with('success', 'Edit Employee successfully!');;
        } catch (QueryException $e) {
            logger()->error($e->getMessage());
            return back();
        } catch (Throwable $e) {
            logger()->critical($e->getMessage());
            return back();
        }
    }

    //Delete a Employee
    public function deleteEmployee(Employee $employee, Request $request){

        //log errors
        try {
            $employee->delete();
            return redirect('/view-employees')
                        ->with('success', 'Employee removed successfully!');
        } catch (QueryException $e) {
            logger()->error($e->getMessage());
            return back();
        } catch (Throwable $e) {
            logger()->critical($e->getMessage());
            return back();
        }
    }

}
