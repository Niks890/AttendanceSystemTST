<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailSchedule;
use App\Models\Schedule;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class ScheduleShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DetailSchedule::select(
            'schedules.id',
            DB::raw('GROUP_CONCAT(employees.id) AS emp_id'),
            DB::raw('GROUP_CONCAT(DISTINCT schedules.name) AS sche_name'),
            DB::raw('GROUP_CONCAT(DISTINCT schedules.time_in) AS time_in'),
            DB::raw('GROUP_CONCAT(DISTINCT schedules.time_out) AS time_out'),
            DB::raw('GROUP_CONCAT(DISTINCT detail_schedules.KPI) AS KPI')
        )
        ->join('employees', 'detail_schedules.employee_id', '=', 'employees.id')
        ->join('schedules', 'detail_schedules.schedule_id', '=', 'schedules.id')
        ->groupBy('schedules.id')
        ->get();
       return view('schedule-shift.index', compact('data'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
