<?php

namespace App\Exports;

use App\Models\InquiryProduct;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class InquiryExport implements WithHeadings, WithCustomStartCell, WithEvents, ShouldAutoSize, WithMapping, FromCollection
{
    use Exportable;
    private $i = 1;
    function __construct($idInquiry, $idVisit, $dueDate, $subject, $gradeInquiry, $companyName, $customerName, $telephone, $phone, $email, $file, $note, $data, $id)
    {
        $this->idInquiry = $idInquiry;
        $this->idVisit = $idVisit;
        $this->dueDate = $dueDate;
        $this->subject = $subject;
        $this->gradeInquiry = $gradeInquiry;
        $this->companyName = $companyName;
        $this->customerName = $customerName;
        $this->telephone = $telephone;
        $this->phone = $phone;
        $this->email = $email;
        $this->file = $file;
        $this->note = $note;
        $this->data = $data;
        $this->id = $id;
    }
    /**
     * @return \Illuminate\Support\Collection
     */


    public function collection()
    {
        return $this->data;
    }

    public function startCell(): string
    {
        return 'D1';
    }

    public function headings(): array
    {
        return ['No', 'Item Name', 'Material Description', 'Size', 'QTY', 'Remark'];
    }

    public function map($data): array
    {
        return [
            $this->i++,
            $data->item_name,
            $data->description,
            $data->size,
            $data->qty,
            $data->remark,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setCellValue('A1', 'Id Inquiry');
                $event->sheet->setCellValue('A2', 'Id Visit');
                $event->sheet->setCellValue('A3', 'Due Date');
                $event->sheet->setCellValue('A4', 'Subject');
                $event->sheet->setCellValue('A5', 'Grade Inquiry');
                $event->sheet->setCellValue('A7', 'Company Name');
                $event->sheet->setCellValue('A8', 'Customer Name');
                $event->sheet->setCellValue('A9', 'Telephone');
                $event->sheet->setCellValue('A10', 'Phone');
                $event->sheet->setCellValue('A11', 'Email');
                $event->sheet->setCellValue('A13', 'Document List');
                $event->sheet->setCellValue('A15', 'Note');

                $event->sheet->setCellValue('B1', $this->idInquiry);
                $event->sheet->setCellValue('B2', $this->idVisit);
                $event->sheet->setCellValue('B3', $this->dueDate);
                $event->sheet->setCellValue('B4', $this->subject);
                $event->sheet->setCellValue('B5', $this->gradeInquiry);
                $event->sheet->setCellValue('B7', $this->companyName);
                $event->sheet->setCellValue('B8', $this->customerName);
                $event->sheet->setCellValue('B9',  $this->telephone);
                $event->sheet->setCellValue('B10', $this->phone);
                $event->sheet->setCellValue('B11',  $this->email);
                $event->sheet->setCellValue('B13',   $this->file);
                $event->sheet->setCellValue('B15',  $this->note);

                $event->sheet->getDelegate()->getStyle('D')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('E')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('F')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('G')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('H')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('I')
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
