<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Student::with(['courses', 'classes', 'teachers', 'payments'])->get();
    }


    public function map($student): array
    {
        return [
            $student->id,
            $student->fullname,
            $student->email,
            $student->phone,
            date_format($student->birthday, 'd-m-Y'),
            $student->courses()->pluck('name')->join(','),
            $student->classes()->pluck('name')->join(','),
            $student->teachers()->pluck('fullname')->join(','),
            $student->payments()->pluck('fee_status')->join(','),
            $student->payments()->pluck('remaining')->join(','),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Họ và tên',
            'Email',
            'SDT',
            'Ngày sinh',
            'Khóa học',
            'Lớp học',
            'Giáo viên',
            'Trạng thái học phí',
            'Còn nợ',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style cho hàng 1 (heading)
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'FFFF00'], // vàng
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        return [];
    }

}
