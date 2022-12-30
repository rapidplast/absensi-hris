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


class AbsenMentahExportSearch implements 
FromView,
WithEvents,
ShouldAutoSize,
WithCustomCsvSettings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($tanggal, $tanggal2, $dbName)
    {
        $this->tanggal = $tanggal;
        $this->tanggal2 = $tanggal2;
        $this->dbName = $dbName;
    }

    public function view(): View
    {
        $tanggal = $this->tanggal;
        $tanggal2 = $this->tanggal2;
        $dbName = $this->dbName;
        $absen = DB::connection('mysql2')->table($dbName)
                ->select('pid', DB::raw("DATE_FORMAT(sync_date, '%d.%m.%Y%H:%i:%s') as sync_date"), 'check_in', 'check_out')
                ->whereDate(DB::raw('DATE(sync_date)'), '>=',$tanggal)   
                ->whereDate(DB::raw('DATE(sync_date)'), '<=',$tanggal2)   
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
