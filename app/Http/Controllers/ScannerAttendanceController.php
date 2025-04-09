<?php

namespace App\Http\Controllers;

use App\Models\AttendanceProduct;
use App\Models\DetailSchedule;
use Illuminate\Http\Request;

class ScannerAttendanceController extends Controller
{
    public function index()
    {
        return view('scanner-attendance.index');
    }

    public function upload(Request $request)
    {
        $ip = $request->input('ip');
        $port = $request->input('port');

        // Tạo TCP Socket
        $socket = @fsockopen($ip, $port, $errno, $errstr, 5);

        if (!$socket) {
            return back()->with('error', "Kết nối thất bại: $errstr ($errno)");
        }

        // Gửi lệnh lấy dữ liệu chấm công (giả định đúng command)
        $command = "GET DATA\n";
        fwrite($socket, $command);

        $response = '';
        while (!feof($socket)) {
            $response .= fgets($socket, 1024);
        }

        fclose($socket);

        // Giả định dữ liệu từ máy chấm công trả về là JSON
        $data = json_decode($response, true);

        if (!$data) {
            return back()->with('error', 'Dữ liệu nhận được không hợp lệ!');
        }

        $employees = [];
        foreach ($data as $entry) {
            $KPI = DetailSchedule::where('schedule_id', $entry['schedule_id'])
                ->where('employee_id', $entry['employee_id'])
                ->pluck('KPI')
                ->first();

            $rating = $KPI > $entry['product_count_done'] ? false : true;

            AttendanceProduct::create([
                'attendance_product_time' => $entry['time'],
                'KPI_done' => $entry['product_count_done'],
                'factory_id' => $entry['factory_id'],
                'employee_id' => $entry['employee_id'],
                'status' => $rating,
                'schedule_id' => $entry['schedule_id']
            ]);

            $employees[] = [
                'employee_id' => $entry['employee_id'],
                'time' => $entry['time'],
                'product_count_done' => $entry['product_count_done'],
            ];
        }

        return back()->with('success', "Nạp dữ liệu thành công!<br>Phản hồi từ máy:<br><pre>$response</pre>");
    }


    public function uploadFromJson(Request $request)
    {
        $request->validate([
            'json_file' => 'required|mimes:json',
        ]);

        $file = $request->file('json_file');
        $data = json_decode(file_get_contents($file), true);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'File JSON không hợp lệ!']);
        }

        $employees = [];
        $rating = false;
        foreach ($data as $entry) {
            $KPI = DetailSchedule::where('schedule_id', $entry['schedule_id'])
                ->where('employee_id', $entry['employee_id'])
                ->pluck('KPI')->first();
            $rating = $KPI > $entry['product_count_done'] ? false : true;
            // return response()->json($KPI);
            AttendanceProduct::create([
                'attendance_product_time' => $entry['time'],
                'KPI_done' => $entry['product_count_done'],
                'factory_id' => $entry['factory_id'],
                'employee_id' => $entry['employee_id'],
                'status' => $rating,
                'schedule_id' => $entry['schedule_id']
            ]);
            $employees[] = [
                'employee_id' => $entry['employee_id'],
                'time' => $entry['time'],
                'product_count_done' => $entry['product_count_done'],
            ];
        }

        return response()->json(['success' => true, 'employees' => $employees]);
    }
}
