<?php

namespace App\Http\Controllers;

use App\Models\AttendanceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $attendanceData = AttendanceProduct::select(
            DB::raw("DATE(attendance_products.attendance_product_time) as date_only"),
            DB::raw("TIME(attendance_products.attendance_product_time) as time_only"),
            'employees.id as employee_id',
            'employees.name as employee_name',
            'employees.position',
            'schedules.name as schedule_name',
            'detail_schedules.KPI',
            'attendance_products.KPI_done',
            'attendance_products.status',
            'factories.name as factory_name'
        )
            ->join('factories', 'factories.id', '=', 'attendance_products.factory_id')
            ->join('employees', 'employees.id', '=', 'attendance_products.employee_id')
            ->join('detail_schedules', 'detail_schedules.employee_id', '=', 'employees.id')
            ->join('schedules', 'schedules.id', '=', 'detail_schedules.schedule_id');

        if ($request->has('filter_date')) {
            $query = $request->input('filter_date');
            $attendanceData = $attendanceData->whereRaw("DATE(attendance_products.attendance_product_time) = ?", [$query])->get();
        } else {
            $attendanceData = $attendanceData->whereRaw("DATE(attendance_products.attendance_product_time) = ?", [now()->format('Y-m-d')])->get();
        }

        return view('attendanceproduct.index', compact('attendanceData'));
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
    public function show(AttendanceProduct $attendanceProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceProduct $attendanceProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceProduct $attendanceProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceProduct $attendanceProduct)
    {
        //
    }
}
