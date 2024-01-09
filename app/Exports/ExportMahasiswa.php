<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportMahasiswa implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    //  export dengan fild tertentu
    public function collection()
    {
        return Mahasiswa::select('nama', 'prodi', 'angkatan')->get();
    }

    // export dengan heading di excel
    public function headings(): array
    {
        return ["NAMA", "PRODI", "angkatan"];
    }
}
