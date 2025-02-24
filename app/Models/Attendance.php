<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'attendance_date',
        'attendance_time',
        'status',
        'type',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
