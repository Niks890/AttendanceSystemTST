<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiController extends Controller
{
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
