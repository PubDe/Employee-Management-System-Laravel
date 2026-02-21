<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'working_hours',
    ];

    // Employee for this attendance
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
