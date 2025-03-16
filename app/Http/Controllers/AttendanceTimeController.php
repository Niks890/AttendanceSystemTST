<?php

namespace App\Http\Controllers;

use App\Models\AttendanceTime;
use Illuminate\Http\Request;

class AttendanceTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attendances = collect([
            (object)[
                'attendance_date' => '06-03-2025',
                'emp_id' => 'EMP001',
                'employee' => (object)[
                    'name' => 'Nguyễn Văn A',
                    'schedules' => collect([(object)['time_in' => '08:00', 'time_out' => '17:00']])
                ],
                'attendance_time' => '08:00',
                'status' => 1
            ],
            (object)[
                'attendance_date' => '06-03-2025',
                'emp_id' => 'EMP002',
                'employee' => (object)[
                    'name' => 'Trần Thị B',
                    'schedules' => collect([(object)['time_in' => '08:00', 'time_out' => '17:00']])
                ],
                'attendance_time' => '08:30',
                'status' => 0
            ]
        ]);

        return view('attendancetime.index', compact('attendances'));
    }

    public function checkIn() {
        return view('attendancetime.check-in');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceTime $attendanceTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceTime $attendanceTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceTime $attendanceTime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceTime $attendanceTime)
    {
        //
    }
}
