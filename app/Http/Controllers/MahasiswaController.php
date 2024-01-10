<?php

namespace App\Http\Controllers;

use App\Exports\ExportMahasiswa;
use App\Imports\ImportMahasiswa;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use function Laravel\Prompts\alert;

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
        $data = Mahasiswa::findOrFail($id);
        $url = env('APP_URL');

        //validasi 

        if (!empty($data->qrcode)) {
            return redirect()->back()->with('info', 'QRCODE sudah ada');
        } else {
            $qrcode = QrCode::size(200)
                ->format('png')
                ->generate('http://laravel-qrcode/' . $data->nama);
            $img = $data->nama . '-qrcode.png';
            $path = 'public/qrcode/' . $img;
            // dd($qrcode);
            Storage::put($path, $qrcode);
            // dd($qrcode, $path);
            $data->update([
                'qrcode' => $path
            ]);
            return redirect()->back()->with('success', 'QRCODE berhasil dibuat');

            // return response($qrcode)
            //     ->header('Content-type', 'image/png');
        }


        // return response()->streamDownload(
        //     function () use ($data) {
        //         echo QrCode::size(200)
        //             ->format('png')
        //             ->generate($data->nama); // Adjust this based on the field you want to use for the QR code content
        //     },
        //     $nama = 'qr-code-' . $data->nama . '.png',
        //     [
        //         'Content-Type' => 'image/png',
        //     ]
        // );


    }

    public function update($nama)
    {
        // update via get dengan qrcode
        //next bisa tambah untuk jam masuk  dan pulang
        $mhs = Mahasiswa::where('nama', $nama)->first();
        $mhs->update([
            'updated_at' => Carbon::now()
        ]);

        echo "berhasil";
        // return response()->json('berhasil');
    }

    //meregenerate qrcode semua mhs
    public function getALLQRCODE()
    {
        $data =  Mahasiswa::all();
        $mahasiswa = [];
        foreach ($data as $item) {
            $qrcode = QrCode::size(200)
                ->format('png')
                ->generate('http://laravel-qrcode/' . $item->nama);
            $img = $item->nama . '-qrcode.png';
            $path = 'public/qrcode/' . $img;
            // dd($qrcode);
            Storage::put($path, $qrcode);
            // dd($qrcode, $path);
            $item->update([
                'qrcode' => $path
            ]);

            $mahasiswa[] = $item;
        }
        return redirect()->back()->with('success', 'QRCODE berhasil dibuat');
    }

    //delete semua qrcode tiap mhs
    public function deleteAllQRCODE()
    {
        $data = Mahasiswa::all();
        foreach ($data as $item) {
            $item->update([
                'qrcode' => ''
            ]);
        }
        return redirect()->back()->with('success', 'QRCODE berhasil dihapus');
    }
}
