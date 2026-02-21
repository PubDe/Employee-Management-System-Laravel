<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SalaryStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'basic_salary',
        'allowance',
        'deduction',
    ];

    // Employee for this salary structure
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Helper: gross salary
    public function getGrossSalaryAttribute()
    {
        return $this->basic_salary + $this->allowance;
    }

    // Helper: net salary
    public function getNetSalaryAttribute()
    {
        return $this->basic_salary + $this->allowance - $this->deduction;
    }
}
