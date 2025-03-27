<?php

namespace App\Http\Controllers;

use App\Models\AttendanceProduct;
use App\Models\DetailSchedule;
use App\Models\Schedule;
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

        // Ví dụ: Gửi lệnh lấy dữ liệu chấm công (thay bằng command đúng với máy)
        $command = "GET DATA\n";
        fwrite($socket, $command);

        // Đọc dữ liệu trả về
        $response = '';
        while (!feof($socket)) {
            $response .= fgets($socket, 1024);
        }

        fclose($socket);

        // Có thể parse response rồi lưu database ở đây
        return back()->with('success', "Nạp dữ liệu thành công!<br>Phản hồi từ máy:<br><pre>$response</pre>");
    }

    // public function uploadFromJson(Request $request)
    // {
    //     $request->validate([
    //         'json_file' => 'required|file|mimes:json',
    //     ], [
    //         'json_file.required' => 'Vui lòng chọn file JSON',
    //         'json_file.file' => 'File không hợp lệ',
    //         'json_file.mimes' => 'File phải có định dạng JSON'
    //     ]);

    //     // $jsonContent = file_get_contents($request->file('json_file')->getRealPath());
    //     // $data = json_decode($jsonContent, true);

    //     // if (!$data) {
    //     //     return back()->with('error', 'File JSON không hợp lệ');
    //     // }

    //     // // xử lý với dữ liệu này
    //     // // Ví dụ: foreach($data as $record) { save vào database }

    //     // // return back()->with('success', "Đọc file JSON thành công!<br><pre>" . print_r($data, true) . "</pre>");
    //     // return response()->json($data);

    //     $jsonContent = file_get_contents($request->file('json_file')->getRealPath());
    //     $data = json_decode($jsonContent, true);

    //     if (!$data) {
    //         return response()->json(['status' => 'fail', 'message' => 'File JSON không hợp lệ'], 400);
    //     }

    //     // Tùy ý xử lý data
    //     // return response()->json([
    //     //     'status' => 'success',
    //     //     'message' => 'Nạp dữ liệu từ file JSON thành công!',
    //     //     'data' => $data
    //     // ]);
    //     dd($data);
    // }

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

        // Xử lý dữ liệu chấm công, ví dụ: lưu vào DB
        $employees = [];
        $rating = false;
        foreach ($data as $entry) {
            $KPI = DetailSchedule::where('schedule_id', $entry['schedule_id'])
                                                ->where('employee_id', $entry['employee_id'])
                                                ->pluck('KPI')->first();
            $KPI > $entry['product_count_done'] ? $rating = false : $rating = true;
            // return response()->json($KPI);
            AttendanceProduct::create([
                'attendance_product_time' => $entry['time'],
                'KPI_done' => $entry['product_count_done'],
                'factory_id' => $entry['factory_id'],
                'employee_id' => $entry['employee_id'],
                'status' => $rating

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
