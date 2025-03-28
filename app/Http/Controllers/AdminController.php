<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $quantityEmployee = DB::table('employees')->count();
        $quantitySchedule = DB::table('schedules')->count();

        $getScheduleOfCurrentEmployee = DB::table('detail_schedules as ds')
            ->join('employees as e', 'ds.employee_id', '=', 'e.id')
            ->join('schedules as s', 'ds.schedule_id', '=', 's.id')
            ->where('e.id', Auth::guard('web')->id() - 1)
            ->where('ds.workday', now()->format('Y-m-d'))
            ->select('s.name', 's.time_in', 's.time_out', 'ds.workday')
            ->get();

        $attendanceStats = DB::table('employees as e')
            ->join('detail_schedules as ds', 'e.id', '=', 'ds.employee_id')
            ->join('schedules as s', 's.id', '=', 'ds.schedule_id')
            ->join('attendances as a', 'a.employee_id', '=', 'e.id')
            ->selectRaw("
        COUNT(CASE WHEN TIMEDIFF(a.attendance_time, s.time_in) > '00:15:00' THEN 1 END) AS late_count,
        COUNT(CASE WHEN TIMEDIFF(a.attendance_time, s.time_in) <= '00:15:00' THEN 1 END) AS on_time_count
    ")
            ->where('a.status', 1)
            ->whereBetween('a.attendance_time', [DB::raw('s.time_in'), DB::raw('s.time_out')])
            ->whereMonth('ds.workday', DB::raw('MONTH(CURRENT_DATE())'))
            ->whereYear('ds.workday', DB::raw('YEAR(CURRENT_DATE())'))
            ->first();
        $totalAttendance = $attendanceStats->late_count + $attendanceStats->on_time_count == 0 ? 1 : $attendanceStats->late_count + $attendanceStats->on_time_count;
        $percentOntime = ($attendanceStats->on_time_count / $totalAttendance) * 100;
        $percentLatetime = ($attendanceStats->late_count / $totalAttendance) * 100;

        return view('dashboard', compact('percentOntime', 'percentLatetime', 'quantityEmployee', 'quantitySchedule', 'getScheduleOfCurrentEmployee'));
    }

    public function login()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $user = DB::table('users')
                        ->where('email', $request->email)
                        ->first();

                    if (!$user || !Hash::check($value, $user->password)) {
                        $fail("Mật khẩu không chính xác.");
                    }
                }
            ]
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
            'email.exists' => 'Email không tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')->with('success', 'Đăng nhập thành công!');
        }
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
