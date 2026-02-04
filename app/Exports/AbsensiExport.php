<?php

namespace App\Exports;

use App\Models\Absensi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;


class AbsensiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
           'Waktu Absen',
            'Nama Peserta',
            'Asal Sekolah',
            'Jenis Absen',
            'Status',
            'Mode Kerja',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [ 
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'E5E7EB',
                    ],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $range = 'A1:' . $highestColumn . $highestRow;

                $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '9CA3AF'], 
                        ],
                    ],
                ]);
            },
        ];
    }

    public function map($row): array
    {
        return [
            $row->waktu_absen
                ? $row->waktu_absen->format('d-m-Y H:i:s')
                : '-',
            $row->peserta->nama ?? '-',
            $row->peserta->asal_sekolah_universitas ?? '-',
            $row->jenis_absen ?? '-',
            $row->status,
            $row->status === 'Hadir'
                ? $row->mode_kerja
                : '-',
        ];
    }
}
