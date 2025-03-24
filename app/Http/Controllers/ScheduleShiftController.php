<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailSchedule;
use App\Models\Schedule;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

        $employeeList = DB::table('employees')
        ->select(
            DB::raw('GROUP_CONCAT(employees.id) AS emp_ids'),
            DB::raw('GROUP_CONCAT(employees.name) AS emp_names')
        )
        ->leftJoin('detail_schedules', 'employees.id', '=', 'detail_schedules.employee_id')
        ->leftJoin('schedules', 'detail_schedules.schedule_id', '=', 'schedules.id')
        ->whereNull('schedules.id')
        ->get();

        
    
       return view('schedule-shift.index', compact('data', 'employeeList'));
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
        try {
            // Bắt đầu transaction
            DB::beginTransaction();
    
            // Lưu ca làm việc
            $shift = Schedule::create([
                'name' => $request->shift_name,
                'slug' => Str::slug($request->shift_name),
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
            ]);
    
            // Lưu chi tiết ca làm việc cho từng nhân viên
            foreach ($request->employee_ids as $employeeId) {
                DetailSchedule::create([
                    'schedule_id' => $shift->id,
                    'employee_id' => $employeeId,
                    'KPI' => $request->KPI,
                ]);
            }
    
            // Nếu không có lỗi, commit transaction
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Ca làm việc đã được tạo thành công!']);
        } catch (\Exception $e) {
            // Nếu có lỗi, rollback transaction
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi khi tạo ca làm việc!', 'error' => $e->getMessage()], 500);
        }
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
