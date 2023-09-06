<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\BeforeExport;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Foundation\Events\Dispatchable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Broadcasting\InteractsWithSockets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InquiryExcelExport implements WithHeadings, WithColumnWidths, WithStyles
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
        return ['No', 'Item Name', 'Material Description', 'Size', 'Quantity', 'Remark'];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 4,
            'B' => 20,
            'C' => 30,
            'D' => 8,
            'E' => 10,            
            'F' => 20,            
        ];
    }

    public function styles(Worksheet $sheet)
    {
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

        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
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
                $sheet = $event->sheet;

                $sheet->getDelegate()->getStyle('A1:F1')->getFont()->setBold(true);
            },
        ];
    }
}
