<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Labkategori;
use App\Labsection;
use App\Sipeka;
use App\UserSipeka;
use MercurySeries\Flashy\Flashy;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class KeluhanPasienController extends Controller
{

public function index()
    {
        $data['sipeka'] = Sipeka::all();
        return view('keluhanPasien.index', $data);
    }
 
 public function store(Request $request)
    {
        $data = new Sipeka();
        $data->nik =  $request->nik;
        $data->no_hp =  $request->no_hp;
        $data->perihal =  $request->perihal;
        $data->tanggal =  $request->tanggal;
        $data->judul_pesan =  $request->judul_pesan;
        $data->pesan =  $request->pesan;
        $data->save();
        Flashy::success('Laporan Berhasil di Simpan');
        return redirect()->back();
    }


public function form_user()
    {
        $data['sipeka'] = UserSipeka::all();
        return view('keluhanPasien.form_user', $data);
    }
 
 public function store_user(Request $request)
    {   
        $data = new UserSipeka();
        $data->nama =  $request->nama;
        $data->no_hp =  $request->nomor_kontak;
        $data->tanggal_kejadian =  $request->tanggal_kejadian;
        $data->lokasi_kejadian =  $request->lokasi_kejadian;
        $data->bagian_permasalahan =  $request->bagian_permasalahan;
        $data->jenis_permasalahan_petugas =  json_encode($request->jenis_permasalahan_petugas);
        $data->bidang_petugas_karyawan =  $request->bidang_petugas_karyawan;
        $data->nama_petugas_karyawan =  $request->nama_petugas_karyawan;
        $data->masalah_fasilitas =  json_encode($request->masalah_fasilitas);
        $data->jenis_masalah_fasilitas =  json_encode($request->jenis_masalah_fasilitas);
        $data->jenis_permasalahan_administrasi =  $request->jenis_permasalahan_administrasi;
        $data->komplain =  $request->komplain;
        $data->save();
        Flashy::success('Berhasil, Silahkan Isi Laporan');
        return redirect()->back();
    }


    public function updateDisposisi($id, Request $request)
    {   
        $data = UserSipeka::findOrFail($id);

        $data->disposisi = $request->disposisi;
        if ($request->has('status')) {
            $data->status = $request->status;
        }
        $data->save();

        return response()->json(['success' => true]);
    }

    public function updateBidang($id, Request $request)
    {
        $data = UserSipeka::findOrFail($id);

        $data->user_bidang_id = $request->user_bidang_id;
        $data->bidang = $request->bidang;
        $data->disposisi = 1;
        $data->save();

        return response()->json(['success' => true]);
    }

// public function dashboard()
//     {
//         $data['sipeka'] = Sipeka::all();
//         return view('keluhanPasien.dashboard', $data);
//     }
public function dashboard()
    {
        $data['sipeka'] = UserSipeka::where('created_at', 'LIKE', date('Y-m-d'.'%'))->get();
        return view('keluhanPasien.dashboard', $data)->with('no', 1);
    }

public function dashboard_byTanggal(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '8000M');

        // kalau tidak ada input, default hari ini
        $tga = $request->tga ?? date('Y-m-d');
        $tgb = $request->tgb ?? date('Y-m-d');

        // ambil data sesuai range
        $data['sipeka'] = UserSipeka::whereBetween('created_at', [
            valid_date($tga).' 00:00:00',
            valid_date($tgb).' 23:59:59'
        ])->get();

        // === PDF ===
        if ($request->pdf) {
            $pdf = \PDF::loadView('keluhanPasien.laporanAll-pdf', [
                'sipeka' => $data['sipeka'],
                'tga'    => $tga,
                'tgb'    => $tgb,
            ])->setPaper('A4', 'landscape');
            return $pdf->stream('Laporan-Sipeka.pdf');

        // === Excel ===
        } elseif ($request->excel) {
            Excel::create('Laporan Pengaduan SIPEKA', function ($excel) use ($data) {
				$excel->setTitle('Laporan Pengaduan Sipeka')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Pengaduan Sipeka');
				$excel->sheet('Data', function ($sheet) use ($data) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No','Nama',
                        // 'No HP','Tanggal','Lokasi',
						// 'Bagian','Jenis Masalah Petugas','Bidang','Petugas',
                        // 'Fasilitas','Jenis Masalah Fasilitas','Administrasi','Komplain',
					]);
					foreach ($data['sipeka'] as $d) {
                        // dd($d);
                        $sheet->row(++$row, [
                            $no++,
                            $d->nama,
                            // $d->no_hp,
                            // $d->tanggal_kejadian,
                            // $d->lokasi_kejadian,
                            // $d->bagian_permasalahan,
                            // // decodeToString($d->jenis_permasalahan_petugas),
                            // $d->bidang_petugas_karyawan ?? '',
                            // $d->nama_petugas_karyawan ?? '',
                            // // decodeToString($d->masalah_fasilitas),
                            // // decodeToString($d->jenis_masalah_fasilitas),
                            // $d->jenis_permasalahan_administrasi ?? '',
                            // $d->komplain,
                        ]);
                    }
				});
			})->export('xlsx');

        } else {
            return view('keluhanPasien.dashboard', $data)->with('no', 1);
        }
    }

public function updateBalasanAdmin($id, Request $request)
        {   
            $data = UserSipeka::find($id);
            $data->balasan_admin = $request->balasan;
            $data->update();
            return response()->json(['success' => '1']);
        }   



public function updateBalasanBagian($id, Request $request)
        {   
            $data = UserSipeka::find($id);
            $data->balasan_bidang = $request->balasan;
            $data->update();
            return response()->json(['success' => '1']);
        }   



public function getBalasanAdmin($id, Request $request)
        {   
            $data = UserSipeka::find($id);
            return response()->json(['balasan' => $data->balasan_admin]);
        }   



public function getBalasanBagian($id, Request $request)
        {   
            $data = UserSipeka::find($id);
            return response()->json(['balasan' => $data->balasan_bidang]);
        }  






        
public function cari_laporan(Request $request)
        {
            return view('keluhanPasien.cek-laporan');
        }

public function cari(Request $request)
        {   
            $cari = $request->cari;

            $data['sipeka'] = UserSipeka::where('nama','like',"%".$cari."%")
                            ->orWhere('bagian_permasalahan','like',"%".$cari."%")
                            ->get();
    
            return view('keluhanPasien.cek-laporan', $data)->with('no', 1);
        }

public function uploadDokumen($id, Request $request)
{
    $data = UserSipeka::findOrFail($id);

    if($request->hasFile('dokumen')){
        $file = $request->file('dokumen');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('dokumen_sipeka'), $filename);

        $data->dokumen = $filename;
        $data->status = 'Dokumen Diupload';
        $data->save();
    }

    return response()->json(['success' => true]);
}

public function kembalikanDokumen($id, Request $request)
{
    $data = UserSipeka::findOrFail($id);

    $data->disposisi = 1; 
    $data->status = 'Dikembalikan';
    $data->save();

    return response()->json(['success' => true, 'message' => 'Dokumen berhasil dikembalikan']);
}


public function laporanPDF($id)
{
    $data = UserSipeka::findOrFail($id);
    $pdf = PDF::loadView('keluhanPasien.laporan-pdf', compact('data'))
               ->setPaper('A4', 'landscape');

    return $pdf->stream("laporan-sipeka-{$id}.pdf");
}

protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => 'recaptcha',
        ]);
    }



}

?>

