<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class DepartmentCapacity extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'designation_id',
        'max_capacity',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    // Helper: get current filled count
    public function getCurrentCountAttribute()
    {
        return $this->department->employees()
                    ->where('designation_id', $this->designation_id)
                    ->count();
    }

    // Helper: check if capacity full
    public function getIsFullAttribute()
    {
        return $this->current_count >= $this->max_capacity;
    }
}
