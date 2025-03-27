<?php

namespace App\Http\Controllers;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Style\Style;
use App\Models\Employee;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
}
