<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\BeforeExport;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Foundation\Events\Dispatchable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Broadcasting\InteractsWithSockets;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SourcingItemReviewExcelExport implements WithHeadings, WithColumnWidths, WithStyles, FromArray
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Exportable;

    /**
     * @var array
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            [
                'No',
                'Item Desc',
                'Qty',
                'Input Nama PT 1',
            ],
            [
                ' ',
                ' ',
                ' ',
                'Description',
                'Qty',
                'Unit Price',
                'Delivery Time'
            ]
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 40,
            'C' => 8,
            'D' => 25,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:G1');

        // Get the row dimension object for the first row
        $rowDimension = $sheet->getRowDimension(1);

        // Set the height of the first row
        $rowDimension->setRowHeight(20);

        // Set the alignment for the first row
        $lastColumn = $sheet->getHighestColumn();
        $range = 'A1:' . $lastColumn . '1';

        $sheet->getStyle($range)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle($range)->applyFromArray($styleArray);

        $lastRow = $sheet->getHighestRow();
        for ($i = 2; $i <= $lastRow; $i++) {
            $range = 'A' . $i . ':' . $lastColumn . $i;
            $sheet->getStyle($range)->getAlignment()
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                ->setWrapText(true);
            $sheet->getStyle($range)->applyFromArray($styleArray);
            $sheet->getStyle('A' . $i)->getAlignment($styleArray)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],
        ];
    }


    public function array(): array
    {
        return $this->data;
    }

    /**
     * @param  \Maatwebsite\Excel\Sheet  $sheet
     * @param  \Maatwebsite\Excel\Writer  $writer
     * @return void
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function (BeforeExport $event) {
                // Custom configuration before export
            },
            AfterSheet::class => function (AfterSheet $event) {
                // Custom styling after the sheet has been created
            },
        ];
    }
}
