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
        'address',
        'avatar',
        'gender',
        'position',
        'username',
        'password',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function leaves(){
        return $this->hasMany(Leave::class);
    }

    public function lateTimes()
    {
        return $this->hasMany(LateTime::class);
    }

    public function overTimes()
    {
        return $this->hasMany(OverTime::class);
    }

    public function attendanes()
    {
        return $this->hasMany(Attendance::class);
    }

    public function detailSchedules()
    {
        return $this->hasMany(DetailSchedule::class);
    }


}
