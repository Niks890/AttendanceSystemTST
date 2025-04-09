<?php

namespace App\Http\Controllers;

use App\Models\AttendanceProduct;
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
            ['Ca Làm', 'Ngày thực hiện', 'Mã số nhân viên', 'Họ và tên', 'Thời gian có mặt', 'Giờ Vào', 'Giờ Ra', 'Đánh giá'],
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
            ->select('ds.workday', 'e.id as emp_id', 'e.name', 'a.attendance_time', 's.time_in', 's.time_out', 's.name as sche_name')
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
                $attendance->sche_name,
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

    public function exportExcelAttendanceProduct(Request $request)
    {
        $fileName = 'attendance_product_' . $request->input('date') . '.xlsx';

        // Tạo writer để ghi file Excel
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);

        // Style cho header
        $headerStyle = (new Style())->setFontSize(12);

        // Ghi header
        $headerRow = WriterEntityFactory::createRowFromArray(
            ['Ngày thực hiện', 'Mã số nhân viên', 'Chức vụ', 'Họ và tên', 'Ca làm việc', 'KPI', 'Số lượng hoàn thành', 'Đánh giá', 'Xưởng'],
            $headerStyle
        );
        $writer->addRow($headerRow);

        // Lấy dữ liệu lịch làm việc từ database
        $attendanceData = AttendanceProduct::select(
            'attendance_products.attendance_product_time',
            'employees.id as employee_id',
            'employees.name as employee_name',
            'employees.position',
            'schedules.name as schedule_name',
            'detail_schedules.KPI',
            'attendance_products.KPI_done',
            'attendance_products.status',
            'factories.name as factory_name'
        )
            ->join('factories', 'factories.id', '=', 'attendance_products.factory_id')
            ->join('employees', 'employees.id', '=', 'attendance_products.employee_id')
            ->join('detail_schedules', 'detail_schedules.employee_id', '=', 'employees.id')
            ->join('schedules', 'schedules.id', '=', 'detail_schedules.schedule_id')
            ->whereDate('attendance_products.attendance_product_time', $request->input('date'))
            ->whereColumn('schedules.id', 'attendance_products.schedule_id')
            ->get();

        foreach ($attendanceData as $attendance) {
            $row = WriterEntityFactory::createRowFromArray([
                $attendance->attendance_product_time,
                $attendance->employee_id,
                $attendance->position,
                $attendance->employee_name,
                $attendance->schedule_name,
                $attendance->KPI,
                $attendance->KPI_done,
                $attendance->KPI > $attendance->KPI_done ? 'Chưa hoàn thành' : 'Hoàn thành',
                $attendance->factory_name,
            ]);
            $writer->addRow($row);
        }

        // Đóng file Excel
        $writer->close();
    }
}
