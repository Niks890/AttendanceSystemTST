<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'time_in', 
        'time_out', 
        'slug'
    ];

    public function detailSchedules()
    {
        return $this->hasMany(DetailSchedule::class);
    }

    public function attendanceProducts() {
        return $this->hasMany(AttendanceProduct::class);
    }
}
