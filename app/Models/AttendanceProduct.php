<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'attendance_product_time',
        'KPI_done',
        'factory_id',
        'employee_id',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function factory()
    {
        return $this->belongsTo(factory::class);
    }
}
