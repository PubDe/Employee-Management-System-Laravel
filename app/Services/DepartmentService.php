<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    public function getDepartmentStatus($departmentId)
    {

        $response= DB::table('department_capacities')
                        ->select('departments.name as department_name','designations.id as designation_id','designations.title as designation_name','department_capacities.max_capacity',)
                        ->join('departments', 'departments.id', '=', 'department_capacities.department_id')
                        ->join('designations', 'designations.id', '=', 'department_capacities.designation_id')
                        ->where('department_capacities.department_id',$departmentId)
                        ->get();

        $data = [];

        foreach ($response as $row) {

            $currentCount = DB::table('employees')
                ->where('department_id', $departmentId)
                ->where('designation_id', $row->designation_id)
                ->count();

            $data[] = [
                'designation'   => $row->designation_name,
                'max_capacity'  => $row->max_capacity,
                'current_count' => $currentCount,
                'remaining'     => $row->max_capacity - $currentCount,
            ];
        }

        return $data;
    }
}

