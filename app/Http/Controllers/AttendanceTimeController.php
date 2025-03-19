<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function checkIn()
    {
        if (Auth::guard('web')->id() - 1 !== 0) {
            $results = DB::table('attendances as a')
                ->join('detail_schedules as ds', 'a.employee_id', '=', 'ds.employee_id')
                ->join('schedules as s', 'ds.schedule_id', '=', 's.id')
                ->join('employees as e', 'a.employee_id', '=', 'e.id')
                ->select('e.id', 'e.name', 's.id as schedule_id', 's.time_in', 's.time_out', 'a.attendance_date', 'a.attendance_time', 'a.type')
                ->where('e.id', Auth::guard('web')->id() - 1)
                ->whereBetween('a.attendance_time', [DB::raw('s.time_in'), DB::raw('s.time_out')])
                ->get();
            $scheduleOfEmployee = collect($results);
            return view('attendancetime.check-in', compact('scheduleOfEmployee'));
        }
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
        Attendance::create([
            'employee_id' => Auth::guard('web')->id() - 1,
            'attendance_date' => $request->attendance_date,
            'attendance_time' => $request->attendance_time,
            'status' => false,
            'type' => true
        ]);
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
