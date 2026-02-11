<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetPin extends Model
{
    protected $fillable = [
        'email',
        'pin',
        'expires_at'
    ];


}
