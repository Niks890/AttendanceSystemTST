<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'duration',
        'overtime_date',
        'type',
        'employee_id',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
