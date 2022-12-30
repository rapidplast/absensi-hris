<?php

namespace App\Exports;

use App\Models\AbsenMentah;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class AbsenMentahExport implements 
FromView,
WithEvents,
ShouldAutoSize,
WithCustomCsvSettings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $tanggal;
    public function __construct($tanggal, $dbName)
    {
        $this->tanggal = $tanggal;
        $this->dbName = $dbName;
    }

    public function view(): View
    {
        $tanggal = $this->tanggal;
        $dbName = $this->dbName;
        $absen = DB::connection('mysql2')->table($dbName)
                ->select('pid', DB::raw("DATE_FORMAT(sync_date, '%d.%m.%Y%H:%i:%s') as sync_date"), 'check_in', 'check_out')
                ->where(DB::raw('DATE(sync_date)'), $tanggal)
                ->get();
        return view('admin.absensi.excel', ['absen' => $absen, 'tanggal' => $tanggal]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->setAutoSize(true) ;
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold'  => true
                    ],
                    'borders'   => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => 'FFFF0000'],
                        ]
                    ]
                ]);
            }
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => "",
            'enclosure' => ''
        ];
    }
}
