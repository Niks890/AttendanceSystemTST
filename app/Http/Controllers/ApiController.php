<?php

namespace App\Http\Controllers;

use App\Models\Employee;
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
}
