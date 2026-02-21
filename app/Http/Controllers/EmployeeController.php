<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Designation;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
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
            'designation_id' => ['required'],
            'department_id' => ['required'],
    

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
    public function editEmployee(Employee $employee, Request $request){
        $designations=Designation::all();
        $departments=Department::all();
        $page = $request->input('page', 1); // default to 1 if missing
        return view('edit-employee', ['employee'=>$employee, 'designations'=>$designations,'departments'=>$departments, 'page'=>$page]);
    }

    //Update Employee info
    public function updateEmployee(Employee $employee, Request $request){
        
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:15'],
            'email' => ['required', 'email', 'unique:employees,email,' . $employee->id],
            'age' => ['required','max:3'],
            'phone' => ['required','max:10'],
            'dob' => ['required','date'],
            'designation_id' => ['required'],
            'department_id' => ['required'],
        ]);

        $incomingFields['name'] = strip_tags($incomingFields['name']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);

        $page=$request->input('page',1);

        // dd($page);
        //log errors
        try {
            $employee -> update($incomingFields);
            return redirect()->route('view-employees', ['page' => $page])->with('success', 'Edit Employee successfully!');
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

    //Add employee
    public function addEmployeePage(){
        $designations=Designation::all();
        $departments=Department::all();
        return view('add-employee',['designations'=>$designations,'departments'=>$departments]);
    }

    //view employee
    public function viewEmployee(){
        $employees = DB::table('employees')
                    ->join('designations', 'employees.designation_id','=','designations.id')
                    ->join('departments', 'employees.department_id','=','departments.id')
                    ->select(
                        'employees.id as id',
                        'employees.employee_code as employee_code',
                        'employees.name as name',
                        'employees.email as email',
                        'employees.age as age',
                        'employees.phone as phone',
                        'employees.dob as dob',
                        'designations.title as role',
                        'departments.name as department'
                    )->orderBy('employees.employee_code')-> paginate(5);
        return view('view-employees', ['employees'=>$employees]);
    }
}
