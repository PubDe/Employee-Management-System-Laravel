<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        $departments = Department::all();
        return view('departments.status', ['departments'=>$departments]);
    }

    public function getStatus($id)
    {
        $data = $this->departmentService->getDepartmentStatus($id);
        return response()->json($data);
    }
}
