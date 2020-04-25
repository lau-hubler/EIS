<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class InvoiceDetailsSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents, WithTitle
{
    use Exportable;

    private $invoices;

    public function __construct($invoices)
    {
        $this->invoices = $invoices;
    }

    public function collection()
    {
        return $this->invoices;
    }

    public function headings(): array
    {
        return [
            [
                __('invoice.code.title'),
                __('invoice.client.title'),
                '',
                __('invoice.vendor.title'),
                '',
                __('invoice.invoiceDate.title'),
                __('invoice.deliveryDate.title'),
                __('invoice.dueDate.title'),
                __('invoice.status.title'),
            ],
            [
                '',
                __('stakeholder.name.title'),
                __('stakeholder.document.title'),
                __('stakeholder.name.title'),
                __('stakeholder.document.title'),
            ]
        ];
    }

    public function title(): string
    {
        return __('invoice.title');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $heading1 = 'A1:W1';
                $heading2 = 'A2:W2';
                $spreadsheet = 'A:W';
                $event->sheet->getDelegate()->getStyle($spreadsheet)->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle($heading1)->getFont()->setBold(true)->setName('Arial');
                $event->sheet->getDelegate()->getStyle($heading1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle($heading1)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle($heading2)->getFont()->setBold(true)->setName('Arial');
                $event->sheet->getDelegate()->getStyle($heading2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle($heading2)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle($spreadsheet)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->getSheet()->getDelegate()->mergeCells('A1:A2');
                $event->getSheet()->getDelegate()->mergeCells('B1:C1');
                $event->getSheet()->getDelegate()->mergeCells('D1:E1');
                $event->getSheet()->getDelegate()->mergeCells('F1:F2');
                $event->getSheet()->getDelegate()->mergeCells('G1:G2');
                $event->getSheet()->getDelegate()->mergeCells('H1:H2');
                $event->getSheet()->getDelegate()->mergeCells('I1:I2');
            },
        ];
    }
}
