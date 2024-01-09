<?php

namespace App\Http\Controllers;

use App\Exports\ExportMahasiswa;
use App\Imports\ImportMahasiswa;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MahasiswaController extends Controller
{
    public function index()
    {
        $data = Mahasiswa::all();
        return view('welcome', ['data' => $data]);
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            Excel::import(new ImportMahasiswa, $file->store('files'));
            return redirect()->back();
        }
    }

    public function export()
    {
        return Excel::download(new ExportMahasiswa, 'mahasiswa.xlsx');
    }

    public function exportPDF()
    {
        $data = Mahasiswa::all();

        $pdf = Pdf::loadview('pdf', ['data' => $data]);
        return $pdf->download('laporan-mahasiswa.pdf'); //untuk download
        // return $pdf->stream(); //untuk membuka
    }

    public function getQRCODE($id)
    {
        $data = Mahasiswa::where('id', $id)->first();
        // dd($data);
        return QrCode::size(200)
            // ->format('png')
            ->generate($data);
        // ->merge('/storage/app/' . $data->nama . '-qrcode.jpg');
    }
}
