<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function apiStatus($data, $status_code, $total = 0, $message = null)
    {
        return response()->json([
            'data' => $data,
            'status_code' => $status_code,
            'total' => $total,
            'message' => $message
        ]);
    }

    public function employee($id)
    {
        $employee = Employee::with('department', 'detailSchedules')->find($id);
        return $this->apiStatus($employee, 200);
    }

    public function getEvents()
    {
        $events = [
            [
                'title' => 'Họp nhóm',
                'start' => Carbon::parse('2025-03-10 09:00:00')->toIso8601String(),
                'end'   => Carbon::parse('2025-03-10 11:00:00')->toIso8601String(),
            ],
            [
                'title' => 'Làm báo cáo',
                'start' => Carbon::parse('2025-03-12 14:00:00')->toIso8601String(),
                'end'   => Carbon::parse('2025-03-12 16:00:00')->toIso8601String(),
            ],
        ];

        return response()->json($events);
    }


    public function getEmployeeList(Request $request)
    {
        $scheduleId = $request->schedule_id;
        $listId = $request->listId ? explode(',', $request->listId) : [];

        if (empty($scheduleId) || empty($listId)) {
            return $this->apiStatus([], 400, 0, "Lịch làm việc hoặc danh sách ID trống");
        }
        $employees = DB::table('employees')
            ->join('detail_schedules', 'employees.id', '=', 'detail_schedules.employee_id')
            ->join('schedules', 'detail_schedules.schedule_id', '=', 'schedules.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->where('schedules.id', $scheduleId)
            ->whereIn('employees.id', $listId)
            ->select('employees.*', 'departments.name as department_name')
            ->get();
        return $this->apiStatus($employees, 200, count($employees));
    }

    public function checkShift(Request $request)
    {
        $workday = $request->workday;
        $timeIn = $request->time_in;
        $timeOut = $request->time_out;
        $employees = Employee::join('detail_schedules', 'employees.id', '=', 'detail_schedules.employee_id')
            ->join('schedules', 'detail_schedules.schedule_id', '=', 'schedules.id')
            ->whereDate('detail_schedules.workday', $workday)
            ->whereBetween(DB::raw("'$timeIn'"), [DB::raw('schedules.time_in'), DB::raw('schedules.time_out')])
            ->whereBetween(DB::raw("'$timeOut'"), [DB::raw('schedules.time_in'), DB::raw('schedules.time_out')])
            ->select('employees.id', 'employees.name', 'detail_schedules.workday', 'schedules.time_in', 'schedules.time_out')
            ->get();
        if ($employees->count() == 0) {
            return $this->apiStatus($employees, 200, count($employees));
        } else {
            return $this->apiStatus($employees, 400, count($employees), message: 'Lịch đã bị chiếm dụng.');
        }
    }
}
