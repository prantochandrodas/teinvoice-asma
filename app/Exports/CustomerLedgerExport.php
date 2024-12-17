<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
class CustomerLedgerExport implements FromCollection, WithHeadings, WithStyles
{

    protected $ledgerEntries;
    protected $setOpeningAmount;

    public function __construct($ledgerEntries,$setOpeningAmount)
    {
        $this->ledgerEntries = $ledgerEntries;
        $this->setOpeningAmount = $setOpeningAmount;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $balance = $this->setOpeningAmount;
        $totalDebit=$this->setOpeningAmount;
        // return collect($this->ledgerEntries)->map(function ($entry) use (&$balance) {
        //     $type = '';
        //     if ($entry['type'] == 'sale') {
        //         $type = ' Sales Account';
        //         $balance += $entry['debit'];
        //     } elseif ($entry['type'] == 'payment') {
        //         $type = 'Cash Account';
        //         $balance -= $entry['credit'];
        //     }
          
        //     return [
        //         [
        //             'Date' => $entry['date'],
        //             'VNo' => $entry['v_no'],
        //             'Particulars' => $type,
        //             'Debit' => $entry['debit'],
        //             'Credit' => $entry['credit'],
        //             'Balance' => $balance,
        //         ],

        //     ];
        // });

        $entries = collect($this->ledgerEntries)->map(function ($entry) use (&$balance, &$totalDebit, &$totalCredit) {
            $type = '';
            
            if ($entry['type'] == 'sale') {
                $type = 'Sales Account';
                $balance += $entry['debit'];
                $totalDebit += $entry['debit'];
            } elseif ($entry['type'] == 'payment') {
                $type = 'Cash Account';
                $balance -= $entry['credit'];
                $totalCredit += $entry['credit'];
            }

            return [
                'Date' => $entry['date'],
                'VNo' => $entry['v_no'],
                'Particulars' => $type,
                'Debit' => $entry['debit'],
                'Credit' => $entry['credit'],
                'Balance' => $balance,
            ];
        });
        $entries->prepend([
            'Date' => '',
            'VNo' => '',
            'Particulars' => 'Opening Balance',
            'Debit' => $this->setOpeningAmount,
            'Credit' => '',
            'Balance' => $this->setOpeningAmount,
        ]);
        // Add totals at the end
        $entries->push([
            'Date' => 'Total',
            'VNo' => '',
            'Particulars' => '',
            'Debit' => $totalDebit,
            'Credit' => $totalCredit,
            'Balance' => $balance,
        ]);

        return $entries;
    }



    public function headings(): array
    {
        return [
            // ['Leadger Excel sheet'],
            ['Date', 'VNo', 'Particulars', 'Debit', 'Credit', 'Balance'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(20); // Set width for column A
        $sheet->getColumnDimension('B')->setWidth(20); // Set width for column B
        $sheet->getColumnDimension('C')->setWidth(20); // Set width for column C
        $sheet->getColumnDimension('D')->setWidth(20); // Set width for column D
        $sheet->getColumnDimension('E')->setWidth(20); // Set width for column E
        $sheet->getColumnDimension('F')->setWidth(20); // Set width for column E

        $sheet->getStyle('A1:F1')->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Center-align all data rows
        $highestRow = $sheet->getHighestRow(); // Get the last row with data
        $sheet->getStyle("A2:F{$highestRow}")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        return [
            // Style the headings row
            1 => [
                'font' => [
                    'bold' => true, // Make the text bold
                    'size' => 14, // Set the font size
                    // You can add more font properties here
                ],
                // You can add more styling options here, such as borders, alignment, etc.
            ],
        ];
    }

 
}
