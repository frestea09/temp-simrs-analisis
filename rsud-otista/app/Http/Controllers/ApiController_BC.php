<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Bed\Entities\Bed;
use Modules\Kelas\Entities\Kelas;
use Modules\Poli\Entities\Poli;
use App\Fasilitas;
use App\Http\Requests\AntrianBpjs;
use App\SepPoliLanjutan;
use App\Jadwaldokter;
use App\RegistrasiDummy;
use DB;
use Validator;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use App\Operasi;
use Modules\Registrasi\Entities\Carabayar;

class ApiController extends Controller
{
  public function tanggalOperasi(Request $request)
  {

    $request->validate([
      'tanggalawal' => 'required',
      'tanggalakhir' => 'required',
    ]);
    
    $tga = strtotime($request['tanggalawal']);
    $tgb = strtotime($request['tanggalakhir']);
    if ($tgb < $tga) {
      return [
        'response' => [
          'list' => [
          'error' => 'Tanggal Akhir Tidak Boleh Lebih Dari Tanggal Awal!',
          ]
        ],
        'metadata' => [
          'message' => 'ok',
          'code' => 200
        ]
      ];
    }
    
    date_default_timezone_set('UTC');
    $tStamp = date('d-m-Y');
    $signature = base64_encode(hash_hmac('sha256', 'stmadyang&' . $tStamp, 'ant12i4n', true));

    if ($request->header('x-token') == $signature) {
      $timezone = time() + (60 * 60 * 7);
      $operasi   = Operasi::whereBetween('rencana_operasi', [$request->tanggalawal, $request->tanggalakhir])->get();
      $map = $operasi->map(function ($value) {
        $ubah['kodebooking'] = $value->kodebooking;
        $ubah['tanggaloperasi'] = $value->rencana_operasi;
        $ubah['jenistindakan'] = strip_tags($value->suspect);
        $ubah['kodepoli'] = $value->kodepoli;
        $ubah['namapoli'] = $value->namapoli;
        $ubah['terlaksana'] = $value->terlaksana;
        $ubah['nopeserta'] = $value->no_jkn;
        $ubah['lastupdate'] = round(microtime(true) * 1000);
        return $ubah;
      });

      // return $map->toArray();
      return [
        'response' => [
          'list' => $map
        ],
        'metadata' => [
          'message' => 'ok',
          'code' => 200
        ]
      ];

    } else {
      $resp = '{
        "metadata": {
          "message": "Token invalid !",
          "code": 401
        }
      }';
    }
    return $resp;
  }
  public function Operasi(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'nopeserta' => 'required|numeric|digits:13',
    ]);
    if ($validator->fails()) {
      return [
        'response' => [
          'list' => [
          'error' => 'Nomor Kartu Tidak Valid!',
          ]
        ],
        'metadata' => [
          'message' => 'ok',
          'code' => 200
        ]
      ];
    }


    // $request->validate([
    //   'nopeserta' => 'required|numeric|digits:13',
    // ]);


    date_default_timezone_set('UTC');
    $tStamp = date('d-m-Y');
    $signature = base64_encode(hash_hmac('sha256', 'stmadyang&' . $tStamp, 'ant12i4n', true));

    if ($request->header('x-token') == $signature) {
      $timezone = time() + (60 * 60 * 7);
      $operasi   = Operasi::where('no_jkn', $request->nopeserta)->latest('created_at')->get();
      $map = $operasi->map(function ($value) {
        $ubah['kodebooking'] = $value->kodebooking;
        $ubah['tanggaloperasi'] = $value->rencana_operasi;
        $ubah['jenistindakan'] = strip_tags($value->suspect);
        $ubah['kodepoli'] = $value->kodepoli;
        $ubah['namapoli'] = $value->namapoli;
        $ubah['terlaksana'] = $value->terlaksana;
        return $ubah;
      });
      // return $map;
      return [
        'response' => [
          'list' => $map
        ],
        'metadata' => [
          'message' => 'ok',
          'code' => 200
        ]
      ];
    } else {
      $resp = '{
        "metadata": {
          "message": "Token invalid !",
          "code": 401
        }
      }';
    }
    return $resp;
  }

  public function rekapAntrian(Request $request)
  {

    $request->validate([

      'kodepoli' => 'required',
      'polieksekutif' => 'required|numeric|min:0|max:1',
      'tanggalperiksa' => 'required|date_format:Y-m-d'
    ]);

    $cekpoli   = Poli::where('bpjs', $request->kodepoli)->first();
    if (empty($cekpoli)) {
      $resp = '{
        "metadata": {
          "message": "Poli tidak tersedia di ST.Madyang",
          "code": 401
        }
      }';
      return $resp;
    }

    $date = strtotime($request->tanggalperiksa);
    // $tgl = strtotime("+7 day", $date);
    $start = strtotime('now');
    $end =  strtotime('+7 days');



    date_default_timezone_set('UTC');
    $tStamp = date('d-m-Y');
    $signature = base64_encode(hash_hmac('sha256', 'stmadyang&' . $tStamp, 'ant12i4n', true));


    if ($request->header('x-token') == $signature) {

      $timezone = time() + (60 * 60 * 7);

      $namapoli   = SepPoliLanjutan::where('kode_poli', $request->kodepoli)->first();
      // $poli   = Poli::where('bpjs', $request->kodepoli)->first();
        $totalantri  = RegistrasiDummy::where('tglperiksa',$request->tanggalperiksa)
        ->where('kode_poli',$request->kodepoli)
        ->where('polieksekutif', $request->polieksekutif)
        ->where('status','pending')
        ->count();

        $dilayani  = RegistrasiDummy::where('tglperiksa',$request->tanggalperiksa)
        ->where('kode_poli',$request->kodepoli)
        ->where('polieksekutif', $request->polieksekutif)
        ->where('status','terdaftar')
        ->count();
        // $dilayani = \Modules\Registrasi\Entities\Folio::where('poli_id',$poli->id)->where('created_at', 'LIKE', date('Y-m-d') . '%')->groupBy('registrasi_id')->count();

        $resp = '{
          "response": {
            "namapoli" : "' . $namapoli['nama_poli'] . '",
            "totalantrean" : "' . $totalantri . '",
            "jumlahterlayani" : "' . $dilayani . '",
            "lastupdate" : "' .  	round(microtime(true) * 1000) . '",
          },
          "metadata": {
            "message": "Ok",
            "code": 200
          }
        }';
    } else {
      $resp = '{
        "metadata": {
          "message": "Token invalid !",
          "code": 401
        }
      }';
    }
    return $resp;
  }



  public function antrian(Request $request)
  {
    $date = strtotime($request->tanggalperiksa);
    $dayname = date("D", strtotime($request->tanggalperiksa));
    // return $dayname; die;
    // $tgl = strtotime("+7 day", $date);
		$start = strtotime('now');
    $end =  strtotime('+90 days');

    if (  $dayname == 'Sun' )
    {
      $resp = '{
        "metadata": {
          "message": "Poli pada hari tersebut sedang Tutup",
          "code": 401
        }
      }';
      return $resp; die;
    } 

    if (  $date > $end || $date < $start )
    {
      // $resp = '{
      //     "message": "The given data was invalid.",
      //     "errors": {
      //         "tanggalperiksa": [
      //             "Tanggal Periksa hanya berlaku H+1 sampai dengan H+7."
      //         ]
      //     }
      // }';

      $resp = '{
        "metadata": {
          "message": "Tanggal Periksa hanya berlaku H+1 sampai dengan H+90.",
          "code": 401
        }
      }';
      return $resp; die;
    } 

    if (  RegistrasiDummy::where('no_rujukan', $request->nomorreferensi)->first() )
    {
      $data =  RegistrasiDummy::where('no_rujukan', $request->nomorreferensi)->first();
      // $resp = '{
      //     "message": "The given data was invalid.",
      //     "errors": {
      //         "nomorreferensi": [
      //             "Nomor Rujukan sudah pernah mendaftar di tanggal ' . $data->tglperiksa . ' dengan nomor antrian ' . $data->nomorantrian . '"
      //         ]
      //     }
      // }';

      $resp = '{
        "metadata": {
          "message": "Nomor Rujukan sudah pernah mendaftar di tanggal ' . $data->tglperiksa . ' dengan nomor antrian ' . $data->nomorantrian . '",
          "code": 401
        }
      }';
      return $resp; die;
    } 


    $cekpoli   = Poli::where('bpjs', $request->kodepoli)->first();
    if (empty($cekpoli)) {
      // $resp = '{
      //     "message": "The given data was invalid.",
      //     "errors": {
      //         "namapoli": [
      //             "Poli tidak tersedia di RS ST.Madyang."
      //         ]
      //     }
      // }';

      $resp = '{
        "metadata": {
          "message": "Poli tidak tersedia di RS ST.Madyang.",
          "code": 401
        }
      }';
      return $resp; die;
    }



    // else{
    //   return 'ra iso';
    // }

    

    $request->validate([
      'nomorkartu' => 'required|numeric|digits:13',
      'nik' => 'required|numeric|digits:16',
      'notelp' => 'required',
      'kodepoli' => 'required',
      'nomorreferensi' => 'required|string|min:19|max:19',
      'jenisreferensi' => 'required|numeric|min:1|max:2',
      'jenisrequest' => 'required|numeric|min:1|max:2',
      'polieksekutif' => 'required|numeric|min:0|max:1'
    ]);

    //  $cekpoli   = SepPoliLanjutan::where('kode_poli', $request->kodepoli)->first();
    // if (empty($cekpoli))
    //  {
    //   $resp = '{
    //       "message": "The given data was invalid.",
    //       "errors": {
    //           "namapoli": [
    //               "Poli tidak ditemukan."
    //           ]
    //       }
    //   }';
    //   return $resp;
    // }
    
    


    date_default_timezone_set('UTC');
    $tStamp = date('d-m-Y');
    $signature = base64_encode(hash_hmac('sha256', 'stmadyang&' . $tStamp, 'ant12i4n', true));


    if ($request->header('x-token') == $signature) {
      // return $request->all(); die;
      $cekantrian = RegistrasiDummy::where('jenisdaftar', 'fkrtl')->where('tglperiksa',$request->tanggalperiksa)->where('kode_poli', $request->kodepoli)->count();
      $hitung =  $cekantrian+1;
      $tanggalantri =  date("d", strtotime($request->tanggalperiksa));
      $nomorantri = $tanggalantri.''.$request->kodepoli.''.$hitung;

      if ($cekantrian == 0) {
        $buka_poli = Poli::where('bpjs',$request->kodepoli)->first();
        $convertestimasi = $request->tanggalperiksa.' '.$buka_poli->buka;
      } else {
        # code...
        $cek_estimasi = RegistrasiDummy::where('jenisdaftar', 'fkrtl')->where('tglperiksa',$request->tanggalperiksa)->where('kode_poli', $request->kodepoli)->latest('id')->first();
        $estimasi = strtotime("+15 minutes", strtotime($cek_estimasi->estimasidilayani));
        $convertestimasi = date("Y-m-d H:i:s", $estimasi);
        // return $estimasi*1000; die;
      }
      


      $fkrtl   = New RegistrasiDummy();
      $fkrtl->nomorkartu     = $request->nomorkartu;
      $fkrtl->nik            = $request->nik;
      $fkrtl->no_rm          = $request->nomorrm;
      $fkrtl->no_hp          = $request->notelp;
      $fkrtl->tglperiksa     = $request->tanggalperiksa;
      $fkrtl->kode_poli      = $request->kodepoli;
      $fkrtl->no_rujukan     = $request->nomorreferensi;
      $fkrtl->jenisreferensi = $request->jenisreferensi;
      $fkrtl->jenisrequest   = $request->jenisrequest;
      $fkrtl->polieksekutif  = $request->polieksekutif;
      $fkrtl->jenisdaftar    = 'fkrtl';
      $fkrtl->nomorantrian   = $nomorantri;
      $fkrtl->kode_cara_bayar = 1;
      $fkrtl->status = 'pending';
      $fkrtl->estimasidilayani = $convertestimasi;
      // return $fkrtl;die;
      $fkrtl->save();
      // $reg_dum  = RegistrasiDummy::where(['no_rm' => $request->nomorrm, 'tglperiksa' => $request->tanggalperiksa])->first();
      // $reg_dum  = Registrasi::join('pasiens','pasiens.id','=','registrasis.pasien_id')
      // ->where('pasiens.no_rm',  $request->nomorrm)
      //   ->where('registrasis.created_at', 'LIKE', $request->tanggalperiksa . '%')
      // ->first();
      // dd($reg_dum);
      $poli   = SepPoliLanjutan::where('kode_poli', $request->kodepoli)->first();
      $poli_id = Poli::where('loket', $poli['id'])->pluck('id');
      // $reg_dum  = RegistrasiDummy::where(['no_rm' => $request->nomorrm, 'tglperiksa' => $request->tanggalperiksa])->whereIn('kode_poli', $poli_id)->first();
      $reg_dum  = RegistrasiDummy::where('nomorantrian', $nomorantri)->first();
      // return $reg_dum; die;
      if (!empty($reg_dum)) {
        $resp = '{
          "response": {
            "nomorantrean" : "' . $reg_dum->nomorantrian . '",
            "kodebooking" : "' . $reg_dum->nomorantrian . '",
            "jenisantrean" : ' . $reg_dum->jenisrequest . ',
            "estimasidilayani" : ' . (strtotime($reg_dum->estimasidilayani)*1000) . ',
            "namapoli" : "' . $poli['nama_poli'] . '",
            "namadokter" : ""
          },
          "metadata": {
            "message": "Ok",
            "code": 200
          }
        }';
      } else {
        $resp = '{
          "metadata": {
            "message": "Data invalid !",
            "code": 401
          }
        }';
      }
    } else {
      $resp = '{
        "metadata": {
          "message": "Token invalid !",
          "code": 401
        }
      }';
    }
    return $resp;
  }

  public function token(Request $request)
  {
    $request->validate([
      'password' => 'required',
      'username' => 'required',
    ]);

    if ($request->username == config('app.username_ws') && $request->password == config('app.password_ws')) {
      date_default_timezone_set('UTC');
      $tStamp = date('d-m-Y');
      $signature = base64_encode(hash_hmac('sha256', $request->username . "&" . $tStamp, $request->password, true));


      $resp = '{
        "response": {
          "token": "' . $signature . '"
        },
        "metadata": {
          "message": "Ok",
          "code": 200
        }
      }';
    } else {
      $resp = '{
        "metadata": {
          "message": "Login gagal !",
          "code": 401
        }
      }';
    }
    return response($resp);

    // } else {

    //   return response('gagal');

    // }



  }


  public function daftarOnline(Request $request)
  {
    $data = [
      'no_rm' => $request->no_rm,
      'nama' => $request->nama,
      'alamat' => $request->alamat,
      'tgllahir' => date('Y-m-d', strtotime($request->lahir)),
      'kelamin' => $request->gender,
      'no_hp' => $request->hp,
      'kode_cara_bayar' => $request->cara_bayar,
      'no_rujukan' => ($request->no_rujukan != '') ? $request->no_rujukan : '-',
      'tglperiksa' => date('Y-m-d', strtotime($request->tgl)),
      'kode_poli' => $request->poli,
      'kode_dokter' => $request->dokter
    ];
    $check = RegistrasiDummy::where(['no_rm' => $request->no_rm, 'tglperiksa' => $data['tglperiksa']])->count();
    if ($check == 0) {
      RegistrasiDummy::create($data);
      $no = RegistrasiDummy::where('created_at', 'like', date('Y-m-d') . '%')->count();
      return response()->json(['result' => 'sukses', 'data' => $data, 'no' => $no + 1]);
    } else {
      return response()->json(['result' => 'gagal', 'info' => 'Anda sudah mendaftar di tanggal periksa ini']);
    }
    // return $request;
  }

  public function caraBayar()
  {
    $bayar = Carabayar::select('carabayar', 'id')->get();
    return response($bayar);
  }

  public function dokter()
  {
    $data = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
    return response($data);
  }

  public function poliklinik()
  {
    $data = Poli::where('politype', 'J')->select('nama', 'id')->get();
    return response($data);
  }

  public function cariNoRm($no_rm = '')
  {
    $cek = Pasien::where('no_rm', $no_rm);
    if ($cek->count() > 0) {
      $no = RegistrasiDummy::where('created_at', 'like', date('Y-m-d') . '%')->count();
      return response()->json(['result' => 'success', 'info' => $cek->get(), 'no' => $no + 1]);
    } else {
      return response()->json(['result' => 'gagal', 'info' => 'No Rm tidak ditemukan !']);
    }
  }

  public function pengunjung($tga = '', $tgb = '')
  {
    if (!empty($tga) && !empty($tgb)) {
      $data['jumlah'] = Registrasi::whereBetween('created_at', [valid_date($tga) . ' 00:00:00', valid_date($tgb) . ' 23:59:59'])->where('status_reg', 'LIKE', 'J%')->count();
    } else {
      $data['jumlah'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('status_reg', 'LIKE', 'J%')->count();
    }
    return response()->json($data);
  }

  public function pengunjung_ird($tga = '', $tgb = '')
  {
    if (!empty($tga) && !empty($tgb)) {
      $data['jumlah'] = Registrasi::whereBetween('created_at', [valid_date($tga) . ' 00:00:00', valid_date($tgb) . ' 23:59:59'])->where('status_reg', 'LIKE', 'G%')->count();
    } else {
      $data['jumlah'] = Registrasi::where('created_at', 'LIKE', date('Y-m-d') . '%')->where('status_reg', 'LIKE', 'G%')->count();
    }
    return response()->json($data);
  }

  public function infoKamar()
  {
    $data['totalbed'] = Bed::where('virtual','N')->count();

    foreach (Kelas::where('nama', '<>', '-')->get() as $key => $d) {
      $data['bed_total ' . $d->nama] = DB::table('kamars')->where('kelas_id', $d->id)
        ->join('beds', 'kamars.id', '=', 'beds.kamar_id')->where('beds.virtual','N')
        ->count();
    }
    foreach (Kelas::where('nama', '<>', '-')->get() as $key => $d) {
      $data['bed_terpakai ' . $d->nama] = DB::table('kamars')->where('kelas_id', $d->id)
        ->join('beds', 'kamars.id', '=', 'beds.kamar_id')->where('beds.virtual','N')->where('reserved', 'Y')
        ->count();
    }

    foreach (Kelas::where('nama', '<>', '-')->get() as $key => $d) {
      $data['bed_tersedia ' . $d->nama] = DB::table('kamars')->where('kelas_id', $d->id)
        ->join('beds', 'kamars.id', '=', 'beds.kamar_id')->where('beds.virtual','N')->where('reserved', 'N')
        ->count();
    }

    return response()->json($data);
  }

  public function antrianPoli($tanggal = '', $poli_id = '')
  {
    if (!empty($tanggal) && !empty($poli_id)) {
      $data['pasien'] = DB::table('registrasis')->where('registrasis.created_at', 'LIKE', valid_date($tanggal) . '%')->where('registrasis.poli_id', $poli_id)
        ->join('pasiens', 'registrasis.pasien_id', '=', 'pasiens.id')
        ->select('pasiens.no_rm', 'pasiens.nama')
        ->orderBy('registrasis.created_at', 'asc')
        ->get();
      $data['poli'] = Poli::whereNotIn('id', ['6'])->select('id', 'nama')->get();
    }
    $data['poli'] = Poli::whereNotIn('id', ['6'])->select('id', 'nama')->get();
    return response()->json($data);
  }

  public function fasilitas()
  {
    $fasilitas = Fasilitas::find(1);
    return response()->json($fasilitas);
  }

  public function jadwalDokter()
  {
    $jadwal = Jadwaldokter::all();
    return response()->json($jadwal);
  }
}
