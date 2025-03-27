<?php

namespace App\Http\Controllers;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Style\Style;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ExportController extends Controller
{
    public function exportExcelEmployee()
    {
        $fileName = 'employees.xlsx';

        // Tạo writer để ghi file Excel
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);

        // Style cho header
        $headerStyle = (new Style())->setFontSize(12);

        // Ghi header
        $headerRow = WriterEntityFactory::createRowFromArray(
            ['ID', 'Họ Tên', 'Email', 'SĐT', 'Chức vụ', 'Phòng Ban'],
            $headerStyle
        );
        $writer->addRow($headerRow);

        // Lấy dữ liệu nhân viên từ database
        $employees = Employee::with('department')->get();

        foreach ($employees as $employee) {
            $row = WriterEntityFactory::createRowFromArray([
                $employee->id,
                $employee->name,
                $employee->email,
                $employee->phone,
                $employee->position,
                $employee->department->name
            ]);
            $writer->addRow($row);
        }

        // Đóng file Excel
        $writer->close();
    }


    public function exportExcelSchedule($id)
    {
        $fileName = 'schedule_' . $id . '.xlsx';

        // Tạo writer để ghi file Excel
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);

        // Style cho header
        $headerStyle = (new Style())->setFontSize(12);

        // Ghi header
        $headerRow = WriterEntityFactory::createRowFromArray(
            ['ID', 'Họ Tên', 'Tên Ca', 'Ngày Làm', 'Giờ Vào', 'Giờ Ra', 'KPI', 'Phòng Ban'],
            $headerStyle
        );
        $writer->addRow($headerRow);

        // Lấy dữ liệu lịch làm việc từ database
        $schedules = DB::table('employees')
            ->select(
                'employees.id AS emp_ids',
                'employees.name AS emp_names',
                'schedules.name AS schedule_name',
                'detail_schedules.workday',
                'schedules.time_in',
                'schedules.time_out',
                'detail_schedules.KPI',
                'departments.name AS department_name'
            )
            ->join('detail_schedules', 'employees.id', '=', 'detail_schedules.employee_id')
            ->join('schedules', 'detail_schedules.schedule_id', '=', 'schedules.id')
            ->join('departments', 'departments.id', '=', 'employees.department_id')
            ->where('schedule_id', $id)
            ->get();

        foreach ($schedules as $schedule) {
            $row = WriterEntityFactory::createRowFromArray([
                $schedule->emp_ids,
                $schedule->emp_names,
                $schedule->schedule_name,
                $schedule->workday,
                $schedule->time_in,
                $schedule->time_out,
                $schedule->KPI,
                $schedule->department_name,
            ]);
            $writer->addRow($row);
        }

        // Đóng file Excel
        $writer->close();
    }


    public function exportExcelAttendance(Request $request)
    {

        $fileName = 'schedule_' . $request->input('date') . '.xlsx';

        // Tạo writer để ghi file Excel
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);

        // Style cho header
        $headerStyle = (new Style())->setFontSize(12);

        // Ghi header
        $headerRow = WriterEntityFactory::createRowFromArray(
            ['Ngày thực hiện', 'Mã số nhân viên', 'Họ và tên', 'Thời gian có mặt', 'Giờ Vào', 'Giờ Ra', 'Đánh giá'],
            $headerStyle
        );
        $writer->addRow($headerRow);

        // Lấy dữ liệu lịch làm việc từ database
        $attendances = DB::table('detail_schedules as ds')
            ->join('schedules as s', 's.id', '=', 'ds.schedule_id')
            ->join('employees as e', 'ds.employee_id', '=', 'e.id')
            ->join('attendances as a', 'e.id', '=', 'a.employee_id')
            ->whereColumn('ds.workday', 'a.attendance_date')
            ->where('ds.workday', $request->input('date'))
            ->select('ds.workday', 'e.id as emp_id', 'e.name', 'a.attendance_time', 's.time_in', 's.time_out')
            ->get();

        $checkAttendance = "";

        foreach ($attendances as $attendance) {
            $time1 = Carbon::createFromFormat(
                'H:i:s',
                $attendance->attendance_time,
            );
            $time2 = Carbon::createFromFormat('H:i:s', $attendance->time_in);
            $diffInMinutes = $time1->diffInMinutes($time2);
            if ($diffInMinutes <= 15) {
                $checkAttendance = "Đúng giờ";
            } else {
                $checkAttendance = "Trễ giờ";
            }
            $row = WriterEntityFactory::createRowFromArray([
                $attendance->workday,
                $attendance->emp_id,
                $attendance->name,
                $attendance->attendance_time,
                $attendance->time_in,
                $attendance->time_out,
                $checkAttendance
            ]);
            $writer->addRow($row);
        }

        // Đóng file Excel
        $writer->close();
    }
}
