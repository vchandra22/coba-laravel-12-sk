<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = [
        'phone',
        'birth_place',
        'birth_date',
        'address',
        'hire_date'
    ];

}
