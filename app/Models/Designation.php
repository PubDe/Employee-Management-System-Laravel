<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'title',
        'grade',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Employees with this designation
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    // Capacity of this designation
    public function capacities()
    {
        return $this->hasMany(DepartmentDesignationCapacity::class);
    }

}
