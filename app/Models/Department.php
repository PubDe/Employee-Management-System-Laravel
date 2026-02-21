<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];
    
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function capacities()
    {
        return $this->hasMany(DepartmentCapacity::class);
    }

    public function designations()
    {
        return $this->hasMany(Designation::class);
    }
}
