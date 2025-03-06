<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

    public function employee($id) {
        $employee = Employee::with('department')->find($id);
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
}
