<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'age',
        'dob',
        'role',
        'department_id',
        'designation_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function salaryStructure()
    {
        return $this->hasOne(SalaryStructure::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

}
