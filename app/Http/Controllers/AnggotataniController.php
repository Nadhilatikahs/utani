<?php

namespace App\Http\Controllers;

use App\Models\AnggotaTani;
use App\Models\KelompokTani;
use App\Models\Lahan;
use App\Http\Requests\StoreAnggotataniRequest;
use App\Http\Requests\UpdateAnggotataniRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Iluminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

#tambahan untuk import excel
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

use Illuminate\Support\Facades\Response;


class AnggotataniController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    
    public function index()
    {
        $anggotatanis = DB::table('anggotatanis')
        ->join('kelompoktanis', 'anggotatanis.id_keltani', '=', 'kelompoktanis.id_keltani')
        ->select('anggotatanis.*', 'kelompoktanis.*')
        ->orderBy('kelompoktanis.id_keltani')
        ->get(); 

        // Menambahkan informasi apakah data master memiliki data transaksi atau tidak
        foreach ($anggotatanis as $d) {
            $d->hasLahans = Lahan::where('id_anggota', $d->id_anggota)->exists();
}
        return view('anggotatanis/index',compact('anggotatanis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggotatanis = AnggotaTani::all();
        $kelompoktanis = KelompokTani::all();
        return view('anggotatanis.create',[
            'kode_anggota' => AnggotaTani::getKodeanggota(),
            'kelompoktanis' => KelompokTani::all(),
            'anggotatanis' => AnggotaTani::all()
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnggotaTaniRequest $request)
    {
        $validated = $request->validate([
            'kode_anggota' => 'required',
            /*
            'nama_anggota' => 'required|unique:anggotatanis,nama_anggota',
            'nik' => 'required|unique:anggotatanis,nik',
            'tempat_lahir' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required',
            'status_anggota' => 'required',
            'kategori_petani' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'id_keltani' => 'required',
            */
            'nama_anggota' => 'required',
            'nik' => 'required',
            'tempat_lahir' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required',
            'status_anggota' => 'required',
            'kategori_petani' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'id_keltani' => 'required',
        ]);

        // masukkan ke db
        Anggotatani::create($request->all());
        
        return redirect()->route('anggotatanis.index')->with('success','Data Berhasil di Input');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnggotaTani $anggotatani)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id_anggota)
    {
        
        $get = DB::table('anggotatanis')->where('id_anggota', $id_anggota)->get();
        foreach ($get as $p) {
            $id_anggota = $p->id_anggota;
            $kode_anggota = $p->kode_anggota;
            $nama_anggota = $p->nama_anggota;
            $nik = $p->nik;
            $tempat_lahir = $p->tempat_lahir;
            $alamat = $p->alamat;
            $jenis_kelamin = $p->jenis_kelamin;
            $no_hp = $p->no_hp;
            $status_anggota = $p->status_anggota;
            $kategori_petani = $p->kategori_petani;
            $latitude = $p->latitude;
            $longitude = $p->longitude;
            
           
        }
        return view('anggotatanis.edit', [
            'id_anggota' => $id_anggota,
            'kode_anggota' => $kode_anggota,
            'nama_anggota' => $nama_anggota,
            'nik' => $nik,
            'tempat_lahir' => $tempat_lahir,
            'alamat' => $alamat,
            'jenis_kelamin' => $jenis_kelamin,
            'no_hp' => $no_hp,
            'status_anggota' => $status_anggota,
            'kategori_petani' => $kategori_petani,
            'latitude' => $latitude,
            'longitude' => $longitude,
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnggotaTani $anggotatanis)
    {
        $validated = $request->validate([
            
            'kode_anggota' => 'required',
            'nama_anggota' => 'required',
            'nik' => 'required',
            'tempat_lahir' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required',
            'status_anggota' => 'required',
            'kategori_petani' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
           
           
            
        ]);

        $update = AnggotaTani::where('id_anggota', $request->id_anggota)
            ->update([
                
                'kode_anggota' => $request->kode_anggota,
                'nama_anggota' => $request->nama_anggota,
                'nik' => $request->nik,
                'tempat_lahir' => $request->tempat_lahir,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'status_anggota' => $request->status_anggota,
                'kategori_petani' => $request->kategori_petani,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
               
              
            ]);

        return redirect()->route('anggotatanis.index')->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_anggota)
    {
        $anggotatanis = AnggotaTani::findOrFail($id_anggota);
        $anggotatanis->delete();
        return redirect()->route('anggotatanis.index')->with('success', 'Data Berhasil dihapus');
    }


    public function import(Request $request)
    {
        return view('anggotatanis.import');
    }

    public function import_proses(Request $request)
    {
        // echo "ok";
        // Validasi file yang diupload
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');

        // Membaca file Excel
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Memasukkan data ke dalam database
        foreach ($rows as $index => $row) {
            // Lewatkan header atau row kosong
            if ($index == 0 || empty($row[0])) {
                continue;
            }

            $id_anggota = $row[0]; // id_anggota sebagai identifikasi unik
            $nik = $row[2]; // NIK sebagai kunci untuk pengecekan

            // Dapatkan kode anggota baru jika diperlukan
            $kode_anggota = AnggotaTani::getKodeanggota();

            // Dapatkan detail anggota dan id_keltani
            $anggota_detail = AnggotaTani::getAnggotaDetailkeltani();
            $id_keltani = $row[11]; // id_keltani sesuai dari file excel

            // Cek apakah id_anggota sudah ada di database
            $anggota = AnggotaTani::where('nik', $nik)->first();

            if ($anggota) {
                // Update data anggota
                $anggota->update([
                    'nama_anggota' => $row[1],
                    'nik' => $row[2],
                    'tempat_lahir' => $row[3],
                    'alamat' => $row[4],
                    'jenis_kelamin' => $row[5],
                    'no_hp' => $row[6],
                    'status_anggota' => $row[7],
                    'kategori_petani' => $row[8],
                    'latitude' => $row[9],
                    'longitude' => $row[10],
                    'id_keltani' => $id_keltani,
                ]);
            } else {
                // Insert data anggota baru
                Anggotatani::create([
                    // 'id_anggota' => $id_anggota,
                    'kode_anggota' => $kode_anggota,
                    'nama_anggota' => $row[1],
                    'nik' => $row[2],
                    'tempat_lahir' => $row[3],
                    'alamat' => $row[4],
                    'jenis_kelamin' => $row[5],
                    'no_hp' => $row[6],
                    'status_anggota' => $row[7],
                    'kategori_petani' => $row[8],
                    'latitude' => $row[9],
                    'longitude' => $row[10],
                    'id_keltani' => $id_keltani,
                ]);
            }
        }

        return redirect()->route('anggotatanis.index')->with('success','Import Data Berhasil ');
    }


//export excel
    public function export()
    {
        // Ambil data pengguna dari database
        $anggotatanis = AnggotaTani::all(['kode_anggota','nama_anggota','tempat_lahir','alamat','jenis_kelamin','no_hp','status_anggota','kategori_petani','created_at']);

        // Buat objek spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menentukan header
        $sheet->setCellValue('A1', 'kode_anggota');
        $sheet->setCellValue('B1', 'nama_anggota');
        $sheet->setCellValue('C1', 'tempat_lahir');
        $sheet->setCellValue('D1', 'alamat');
        $sheet->setCellValue('E1', 'jenis_kelamin');
        $sheet->setCellValue('F1', 'no_hp');
        $sheet->setCellValue('G1', 'status_anggota');
        $sheet->setCellValue('H1', 'kategori_petani');
        $sheet->setCellValue('I1', 'Created At');

        // Mengisi data pengguna
        $row = 2;
        foreach ($anggotatanis as $anggotatani) {
            $sheet->setCellValue('A' . $row, $anggotatani->kode_anggota);
            $sheet->setCellValue('B' . $row, $anggotatani->nama_anggota);
            $sheet->setCellValue('C' . $row, $anggotatani->tempat_lahir);
            $sheet->setCellValue('D' . $row, $anggotatani->alamat);
            $sheet->setCellValue('E' . $row, $anggotatani->jenis_kelamin);
            $sheet->setCellValue('F' . $row, $anggotatani->no_hp);
            $sheet->setCellValue('G' . $row, $anggotatani->status_anggota);
            $sheet->setCellValue('H' . $row, $anggotatani->kategori_petani);
            $sheet->setCellValue('I' . $row, $anggotatani->created_at);
            $row++;
        }
        //Tentukan rentang yang ingin diberi border
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $cellRange = 'A1:' . $highestColumn . $highestRow;
        // Menambahkan border pada sel yang berisi data dan header
$sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        // Buat writer untuk menghasilkan file Excel
        $writer = new Xlsx($spreadsheet);

        // Simpan file Excel ke output buffer
        $fileName = 'anggotatani.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        // Kirim file Excel ke client untuk diunduh
        return Response::download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
}


