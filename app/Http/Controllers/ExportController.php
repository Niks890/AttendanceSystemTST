<?php

namespace App\Http\Controllers;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Style\Style;
use App\Models\Employee;
use Illuminate\Http\Response;

class ExportController extends Controller
{
    public function exportExcel()
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
}
