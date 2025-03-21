<?php

namespace App\Http\Controllers;

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

    public function uploadFromJson(Request $request)
    {
        $request->validate([
            'json_file' => 'required|file|mimes:json',
        ], [
            'json_file.required' => 'Vui lòng chọn file JSON',
            'json_file.file' => 'File không hợp lệ',
            'json_file.mimes' => 'File phải có định dạng JSON'
        ]);

        // $jsonContent = file_get_contents($request->file('json_file')->getRealPath());
        // $data = json_decode($jsonContent, true);

        // if (!$data) {
        //     return back()->with('error', 'File JSON không hợp lệ');
        // }

        // // xử lý với dữ liệu này
        // // Ví dụ: foreach($data as $record) { save vào database }

        // // return back()->with('success', "Đọc file JSON thành công!<br><pre>" . print_r($data, true) . "</pre>");
        // return response()->json($data);

        $jsonContent = file_get_contents($request->file('json_file')->getRealPath());
        $data = json_decode($jsonContent, true);

        if (!$data) {
            return response()->json(['status' => 'fail', 'message' => 'File JSON không hợp lệ'], 400);
        }

        // Tùy ý xử lý data
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Nạp dữ liệu từ file JSON thành công!',
        //     'data' => $data
        // ]);
        dd($data);
    }
}
