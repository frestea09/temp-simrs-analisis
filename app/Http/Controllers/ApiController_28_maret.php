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
use Response;
use DB;
use Validator;
use App\HfisDokter;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use App\Operasi;
use Modules\Registrasi\Entities\Carabayar;

class ApiControllerBACKUP2 extends Controller
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
    $signature = base64_encode(hash_hmac('sha256',config('app.username_ws').'&' . $tStamp, config('app.password_ws'), true));

    if(empty($request->header('x-token')) && empty($request->header('x-username'))){
      $resp = '{
        "metadata": {
          "message": "Header invalid !",
          "code": 201
        }
      }';
      return $resp;
    }
    if ($request->header('x-token') == $signature && $request->header('x-username') == config('app.username_ws')) {
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

      // dd($operasi); 
      if(count($map) > 0){
        $resp = '{
            "response": {
              "list" : "' . $map . '", 
            },
            "metadata": {
              "message": "Ok",
              "code": 200
            }
          }'; 
      }else{
        $resp = '{
            "response": {},
            "metadata": {
              "message": "Tidak ada data",
              "code": 201
            }
          }'; 
      }

    } else {
      $resp = '{
        "metadata": {
          "message": "Token Expired",
          "code": 201
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
    $signature = base64_encode(hash_hmac('sha256', config('app.username_ws').'&' . $tStamp, config('app.password_ws'), true));

    if(empty($request->header('x-token')) && empty($request->header('x-username'))){
      $resp = '{
        "metadata": {
          "message": "Header invalid !",
          "code": 201
        }
      }';
      return $resp;
    }
    if ($request->header('x-token') == $signature && $request->header('x-username') == config('app.username_ws')) {

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
      // dd($operasi);
      // return $map;
      if(count($map) > 0){
        $resp = '{
            "response": {
              "list" : "' . $map . '", 
            },
            "metadata": {
              "message": "Ok",
              "code": 200
            }
          }'; 
      }else{
        $resp = '{
            "response": {},
            "metadata": {
              "message": "Tidak ada data",
              "code": 201
            }
          }'; 
      }
      
    } else {
      $resp = '{
        "metadata": {
          "message": "Token Expired",
          "code": 201
        }
      }';
    }
    return $resp;
  }

  public function sisaAntrian(Request $request)
  {
    $sisaAntrian  = RegistrasiDummy::where('status','terdaftar')
        ->count();
      
    $request->validate([

      'kodebooking' => 'required',
    ]); 

    $date = strtotime($request->tanggalperiksa);
    // $tgl = strtotime("+7 day", $date);
    $start = strtotime('now');
    $end =  strtotime('+7 days');



    date_default_timezone_set('UTC');
    $tStamp = date('d-m-Y');
    $signature = base64_encode(hash_hmac('sha256', config('app.username_ws').'&' . $tStamp, config('app.password_ws'), true));

    if(empty($request->header('x-token')) && empty($request->header('x-username'))){
      $resp = [
        "metadata"=> [
          "message"=> "Header invalid !",
          "code"=> 201
        ]
      ];
      return Response::json($resp);
    }
    if ($request->header('x-token') == $signature && $request->header('x-username') == config('app.username_ws')) {

      $timezone = time() + (60 * 60 * 7);

      // $poli   = Poli::where('bpjs', $request->kodepoli)->first();
        $data  = RegistrasiDummy::where('nomorantrian',$request->kodebooking)->first();
        // dd($data);
        if($data){
          $resp = Response::json([
            "response"=> [
              "nomorantrean" => $data['nomorantrian'],
              "namapoli" => baca_kode_poli($data->kode_poli),
              "namadokter" => baca_dokter_bpjs($data->kode_dokter), 
              "antreanpanggil" => $data['nomorantrian'],
              "keterangan" => '',
              "sisaantrean" => @$sisaAntrian,
              "waktutunggu" => strtotime(date('Y-m-d h:i:s'))
            ],
            "metadata"=> [
              "message"=> "Ok",
              "code"=> 200
            ]
          ]);
        } else{
          $resp = Response::json([
            "metadata" => [
              "message"=> "Antrean Tidak Ditemukan",
              "code"=> 201
            ]
          ]);
        }
    } else {
      $resp = Response::json([
        "metadata" => [
          "message"=> "Token Expired",
          "code"=> 201
        ]
      ]);
    }
    return $resp;
  }

  public function batalAntrian(Request $request)
  {

    $request->validate([

      'kodebooking' => 'required',
    ]); 

    $date = strtotime($request->tanggalperiksa);
    // $tgl = strtotime("+7 day", $date);
    $start = strtotime('now');
    $end =  strtotime('+7 days');



    date_default_timezone_set('UTC');
    $tStamp = date('d-m-Y');
    $signature = base64_encode(hash_hmac('sha256', config('app.username_ws').'&' . $tStamp, config('app.password_ws'), true));

    if(empty($request->header('x-token')) && empty($request->header('x-username'))){
      $resp = [
        "metadata"=> [
          "message"=> "Header invalid !",
          "code"=> 201
        ]
      ];
      return Response::json($resp);
    }
    if ($request->header('x-token') == $signature && $request->header('x-username') == config('app.username_ws')) {

      // Cek sudah dilayani atau belum
      $dilayani  = RegistrasiDummy::where('nomorantrian',$request->kodebooking)->where('cekin','Y')->first();
      // dd($dilayani);
      if($dilayani){

        $resp =Response::json([ 
            "metadata"=> [
              "message"=> "Pasien Sudah Dilayani, Antrean Tidak Dapat Dibatalkan",
              "code"=> 201
            ] 
        ]); 
        return $resp;
      }
      // sudah dibatalkan
      $dibatalkan  = RegistrasiDummy::where('nomorantrian',$request->kodebooking)->where('status','dibatalkan')->first();
      if($dibatalkan){
        $resp = Response::json([
          "metadata"=> [
            "message"=> "Antrean Tidak Ditemukan atau Sudah Dibatalkan",
            "code"=> 201
          ]
        ]);
        return $resp;
      }
      $timezone = time() + (60 * 60 * 7);

      // $poli   = Poli::where('bpjs', $request->kodepoli)->first();
        $data  = RegistrasiDummy::where('nomorantrian',$request->kodebooking)->first();
        if($data){
          $data->cekin = 'N';
          $data->status= 'dibatalkan';
          $data->keterangan = $request->keterangan;
          $data->save();

          $resp = [ 
            "metadata"=> [
              "message"=> "Ok",
              "code"=> 200
            ]
          ];
        } else{
          $resp = [
            "metadata"=> [
              "message"=> "Antrean Tidak Ditemukan",
              "code"=> 201
            ]
          ];
        }
    } else {
      $resp = [
        "metadata"=> [
          "message"=> "Token Expired",
          "code"=> 201
        ]
      ];
    }
    return Response::json($resp);
  }

  public function cekIn(Request $request)
  {

    $request->validate([

      'kodebooking' => 'required',
    ]); 

    $date = strtotime($request->tanggalperiksa);
    // $tgl = strtotime("+7 day", $date);
    $start = strtotime('now');
    $end =  strtotime('+7 days');



    date_default_timezone_set('UTC');
    $tStamp = date('d-m-Y');
    $signature = base64_encode(hash_hmac('sha256', config('app.username_ws').'&' . $tStamp, config('app.password_ws'), true));

    // dd();
    if(empty($request->header('x-token')) && empty($request->header('x-username'))){
      $resp = [
        "metadata"=> [
          "message"=> "Header invalid !",
          "code"=> 201
        ]
      ];
      return Response::json($resp);
    }
    if ($request->header('x-token') == $signature && $request->header('x-username') == config('app.username_ws')) {

      $timezone = time() + (60 * 60 * 7);

      // $poli   = Poli::where('bpjs', $request->kodepoli)->first();
        $data  = RegistrasiDummy::where('nomorantrian',$request->kodebooking)->first();
        if($data){
          $data->cekin = 'Y';
          $data->waktu = strtotime($request->waktu)*1000;
          $data->save();

          $resp = [
            "metadata"=> [
              "message"=> "Ok",
              "code"=> 200
            ]
          ];
        } else{
          $resp = [
            "metadata"=>[
              "message"=> "Gagal",
              "code"=> 201
            ]
          ];
        }
    } else {
      $resp = [
        "metadata"=>[
          "message"=>"Token Expired",
          "code"=>201
        ]
      ];
    }
    return Response::json($resp);
  }

  public function rekapAntrian(Request $request)
  {

    $request->validate([

      'kodepoli' => 'required',
      'kodedokter' => 'required', 
      'tanggalperiksa' => 'required|date_format:Y-m-d'
    ]);
    
    // Cek  backdate
    if(date('Y-m-d', strtotime($request->tanggalperiksa)) < date('Y-m-d')){
      $resp = Response::json([
        "metadata"=> [
          "message"=> "Tanggal Periksa Tidak Berlaku",
          "code"=> 201
        ]
      ]);
      return $resp;
    }

    $cekpoli   = Poli::where('bpjs', $request->kodepoli)->first();
    if (empty($cekpoli)) {
      $resp = Response::json([
        "metadata"=>[
          "message"=> "Poli Tidak Ditemukan",
          "code"=> 201
        ]
      ]);
      return $resp;
    }

    $date = strtotime($request->tanggalperiksa);
    // $tgl = strtotime("+7 day", $date);
    $start = strtotime('now');
    $end =  strtotime('+7 days');



    date_default_timezone_set('UTC');
    $tStamp = date('d-m-Y');
    $signature = base64_encode(hash_hmac('sha256', config('app.username_ws').'&' . $tStamp, config('app.password_ws'), true));

    if(empty($request->header('x-token')) && empty($request->header('x-username'))){
      $resp = Response::json([
        "metadata"=> [
          "message"=> "Header invalid !",
          "code"=> 201
        ]
      ]);
      return $resp;
    }

    if ($request->header('x-token') == $signature && $request->header('x-username') == config('app.username_ws')) {

      $timezone = time() + (60 * 60 * 7);
      $reg_dum  = $dilayani  = RegistrasiDummy::where('tglperiksa',$request->tanggalperiksa)
        ->where('kode_poli',$request->kodepoli)
        ->where('kode_dokter', $request->kodedokter)
        ->first();

      // $namapoli   = SepPoliLanjutan::where('kode_poli', $request->kodepoli)->first();
      // $poli   = Poli::where('bpjs', $request->kodepoli)->first();
        $totalantri  = RegistrasiDummy::where('tglperiksa',$request->tanggalperiksa)
        ->where('kode_poli',$request->kodepoli)
        ->where('kode_dokter', $request->kodedokter)
        // ->where('jampraktek', $request->jampraktek)
        ->where('status','pending')
        ->count();

        $sisaAntrean  = RegistrasiDummy::where('tglperiksa',$request->tanggalperiksa)
        ->where('kode_poli',$request->kodepoli)
        ->where('kode_dokter', $request->kodedokter)
        // ->where('jampraktek', $request->jampraktek)
        ->where('status','pending')
        ->where('cekin','N')
        ->count();

        $dilayani  = RegistrasiDummy::where('tglperiksa',$request->tanggalperiksa)
        ->where('kode_poli',$request->kodepoli)
        ->where('kode_dokter', $request->kodedokter)
        // ->where('jampraktek', $request->jampraktek)
        ->where('status','terdaftar')
        ->count();

        $kuotaJKN = @Poli::where('bpjs',$request->kodepoli)->first()->kuota_online;
        $kuotaNonJKN = @Poli::where('bpjs',$request->kodepoli)->first()->kuota;
        // $dilayani = \Modules\Registrasi\Entities\Folio::where('poli_id',$poli->id)->where('created_at', 'LIKE', date('Y-m-d') . '%')->groupBy('registrasi_id')->count();
        if($reg_dum){
          $resp = Response::json([
            "response"=> [
              "namapoli" =>baca_kode_poli($reg_dum->kode_poli), 
              "namadokter" => baca_dokter_bpjs($reg_dum->kode_dokter),
              "totalantrean" =>$totalantri,
              "sisaantrean" =>$sisaAntrean-$dilayani,
              "antreanpanggil" =>$dilayani,
              "sisakuotajkn" =>$kuotaJKN,
              "kuotajkn" =>$kuotaJKN,
              "sisakuotanonjkn" =>$kuotaNonJKN,
              "kuotanonjkn" => $kuotaNonJKN,
              "keterangan" => "Mobile JKN"            
            ],
            "metadata"=> [
              "message"=> "Ok",
              "code"=> 200
            ]
          ]);
        }else{
          $resp = Response::json([
            "response"=> [],
            "metadata"=> [
              "message"=>"Tidak ada data",
              "code"=> 201
            ]
          ]);
        }
        
    } else {
      $resp = Response::json([
        "metadata"=> [
          "message"=> "Token Expired",
          "code"=> 201
        ]
      ]);
    }
    return $resp;
  }


  public function antrian(Request $request)
  {
    // CEK JADWAL POLI
    $dayname = date("D", strtotime($request->tanggalperiksa)); 
		$start = strtotime('now');
    $end =  strtotime('+90 days');

    if (  $dayname == 'Sun' )
    {
      $resp =  Response::json([
        "metadata" =>[
          "message"=>"Pendaftaran ke Poli Ini Sedang Tutup",
          "code"=>201
        ]
        ]);
      return $resp;
    } 

    

    // CEK FORMAT TANGGAL
    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$request->tanggalperiksa)) {
      $resp = Response::json([
        "metadata" => [
          "message" =>"Format Tanggal Tidak Sesuai, format yang benar adalah yyyy-mm-dd",
          "code"=> 201
        ]
      ]); 
      return $resp;
    } 

    // CEK POLI
    $cekpoli   = Poli::where('bpjs', $request->kodepoli)->first();
    if (empty($cekpoli)) { 
      $resp = Response::json([
        "metadata" => [
          "message" =>"Poli Tidak Ditemukan",
          "code"=> 201
        ]
      ]); 
      return $resp;
    }
 

    // CEK RM
    $cek = RegistrasiDummy::where('no_rm', $request->norm)->first();
    if (!$cek) {
      $resp = [
        'metadata' =>[
          'message' =>"Data pasien ini tidak ditemukan, silahkan Melakukan Registrasi Pasien Baru",
          'code'=>202
        ]
      ]; 
      return Response::json($resp);
    } 
    

    // SINKRONKAN DATA DOKTER HFIS
    $this->jadwalDokterHfis($request->kodepoli,$request->tanggalperiksa);
    
    
    // CEK JADWAL DOKTER
    $dateNum = date('N',strtotime($request->tanggalperiksa));
    $cekDokter = HfisDokter::where('kodedokter',$request->kodedokter)
    ->where('hari',$dateNum)->where('kodepoli',$request->kodepoli)
    ->where('jadwal',$request->jampraktek);
    
    if(!$cekDokter->first()){
      $dokter = Pegawai::where('kode_bpjs',$request->kodedokter)->first();
      $resp = [
        'metadata' =>[
          'message' =>"Jadwal Dokter ".@$dokter->nama." Tersebut Belum Tersedia, Silahkan Reschedule Tanggal dan Jam Praktek Lainnya",
          'code'=>201
        ]
      ]; 
      return Response::json($resp);
    }elseif($cekDokter->where('libur','1')->first()){
      $resp = [
        'metadata' =>[
          'message' =>"Jadwal dokter sedang libur ditanggal ini",
          'code'=>201
        ]
      ]; 
      return Response::json($resp);
    }
    
   
    // Validasi Nomor kartu antrian yang sama
    if (  
      RegistrasiDummy::where('nomorkartu', $request->nomorkartu)
      ->where('no_rm', $request->norm)
      ->where('status','pending')
      ->where('jenis_registrasi','antrian')
      ->where('kode_poli',$request->kodepoli)
      ->where('tglperiksa', $request->tanggalperiksa)
      ->first()){
        
      $resp = Response::json([
        "metadata" => [
          "message"=> "Nomor Antrean Hanya Dapat Diambil 1 Kali Pada Tanggal Yang Sama",
          "code"=> 201
        ]
      ]);
      return $resp;
    }


    // if (  RegistrasiDummy::where('no_rujukan', $request->nomorreferensi)->first() )
    // {
    //   $data =  RegistrasiDummy::where('no_rujukan', $request->nomorreferensi)->first(); 
    //   $resp = '{
    //     "metadata": {
    //       "message": "Nomor Rujukan sudah pernah mendaftar di tanggal ' . $data->tglperiksa . ' dengan nomor antrian ' . $data->nomorantrian . '",
    //       "code": 201
    //     }
    //   }';
    //   return $resp;
    // } 


   
     
    $request->validate([
      // 'nomorkartu' => 'required|numeric|digits:13',
      // 'nik' => 'required|numeric|digits:16',
      'nohp' => 'required',
      'kodepoli' => 'required', 
    ]);
 


    date_default_timezone_set('UTC');
    $tStamp = date('d-m-Y');
    $signature = base64_encode(hash_hmac('sha256', config('app.username_ws').'&' . $tStamp, config('app.password_ws'), true));

    if(empty($request->header('x-token')) && empty($request->header('x-username'))){
      $resp = [
        "metadata"=>[
          "message"=> "Header invalid !",
          "code"=> 201
        ]
      ];
      return Response::json($resp);
    }
    if ($request->header('x-token') == $signature && $request->header('x-username') == config('app.username_ws')) {
      
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
      $fkrtl->no_rm          = $request->norm;
      $fkrtl->no_hp          = $request->nohp;
      $fkrtl->tglperiksa     = $request->tanggalperiksa;
      $fkrtl->kode_poli      = $request->kodepoli;
      $fkrtl->no_rujukan     = $request->nomorreferensi;
      $fkrtl->jenisreferensi = $request->jenisreferensi;
      $fkrtl->jenisrequest   = $request->jenisrequest;
      $fkrtl->polieksekutif  = $request->polieksekutif;
      $fkrtl->kode_dokter    = $request->kodedokter;
      // $fkrtl->jampraktek     = $cekDokter->jadwal;
      $fkrtl->jampraktek     = $request->jampraktek;
      $fkrtl->jeniskunjungan = $request->jeniskunjungan;
      $fkrtl->cekin           = 'N';
      $fkrtl->jenis_registrasi    = 'antrian'; 
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
        $kuotaJKN = @Poli::where('bpjs',$request->kodepoli)->first()->kuota_online;
        $kuotaNonJKN = @Poli::where('bpjs',$request->kodepoli)->first()->kuota;

        if(is_numeric(substr($reg_dum->nomorantrian,-2))){
          $angka = substr($reg_dum->nomorantrian,-2);
        }else{
          $angka = substr($reg_dum->nomorantrian,-1);
        }
        $resp = [
          "response"=>[
            "nomorantrean" => $reg_dum->nomorantrian,
            "angkaantrean" => $angka,
            "kodebooking" => $reg_dum->nomorantrian,
            "norm" => $reg_dum->no_rm,
            "estimasidilayani" => (strtotime($reg_dum->estimasidilayani)*1000),
            "namapoli" => $poli['nama_poli'],
            "sisakuotajkn" => $kuotaJKN,
            "kuotajkn" => $kuotaJKN,
            "sisakuotanonjkn" => $kuotaNonJKN,
            "kuotanonjkn" => $kuotaNonJKN,
            "keterangan" => "Peserta harap 60 menit lebih awal guna pencatatan administrasi.",
            "namadokter" => baca_dokter_bpjs($reg_dum->kode_dokter)
          ],
          "metadata"=> [
            "message"=>"Ok",
            "code"=>200
          ]
        ];
      } else {
        $resp = [
          "metadata"=> [
            "message"=> "Data invalid !",
            "code"=> 201
          ]
        ];
      }
    } else {
      $resp = [
        "metadata"=>[
          "message"=>"Token Expired",
          "code"=>201
        ]
      ];
    }
    return Response::json($resp);
  }

  
  function jadwalDokterHfis($poli,$tgl) { 
			// dd($request);
      // dd([$tgl,$poli]);
			$ID = config('app.consid_antrean');
			date_default_timezone_set('UTC');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
			
			$completeurl =config('app.antrean_url_web_service')."jadwaldokter/kodepoli/" . $poli . "/tanggal/" . $tgl;
			// dd($completeurl);
			$session = curl_init($completeurl);
			// dd($session);
			$arrheader = array(
			  'x-cons-id: ' . $ID,
			  'x-timestamp: ' . $t,
			  'x-signature: ' . $signature,
			  'user_key:'.config('app.user_key_antrean'),
			  'Content-Type: application/json',
			);
			curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session, CURLOPT_HTTPGET, 1);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			
			$response = curl_exec($session);
      // return $response;
			// dd($response['metadata']['code']);
			
			$message = json_decode($response, true); 
			if($response =='Authentication failed'){
				$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
				return response()->json(json_encode($json,JSON_PRETTY_PRINT));
			}
			$array[] = json_decode($response, true);
			if($message['metadata']['code'] == 200){
				$stringEncrypt = $this->stringDecrypt($ID.config('app.secretkey_antrean').$t,$array[0]['response']);
				$array[] = json_decode($this->decompress($stringEncrypt),true);
			}else{
				$array[] = json_decode($response,true);
			}

			$sml = json_encode($array,JSON_PRETTY_PRINT); 
			// return json_decode($sml,true);
      $json = json_decode($sml,true);
      // dd($json[1]['metadata']['code']);
      
      if($json[0]['metadata']['code'] == '201'){
        return false;
      }else{  
        foreach($json[1] as $v){
          $cek = HfisDokter::where('kodedokter',$v['kodedokter'])->where('hari',$v['hari'])->where('kodesubspesialis',$v['kodesubspesialis'])->first();
          // dd($v['kodesubspesialis']);
          if(!$cek){
            $hfis                     = new HfisDokter();
            $hfis->kodesubspesialis   = $v['kodesubspesialis'];
            $hfis->hari   = $v['hari'];
            $hfis->libur   = $v['libur'];
            $hfis->namahari   = $v['namahari'];
            $hfis->jadwal   = $v['jadwal'];
            $hfis->jadwal_start   = explode('-',$v['jadwal'])[0];
            $hfis->jadwal_end   = explode('-',$v['jadwal'])[1];
            $hfis->namasubspesialis   = $v['namasubspesialis'];
            $hfis->namadokter   = $v['namadokter'];
            $hfis->kodepoli   = $v['kodepoli'];
            $hfis->namapoli   = $v['namapoli'];
            $hfis->kodedokter   = $v['kodedokter'];
            $hfis->save();
            
          }else{
            $cek->jadwal   = $v['jadwal'];
            $cek->jadwal_start   = explode('-',$v['jadwal'])[0];
            $cek->jadwal_end   = explode('-',$v['jadwal'])[1];
            $cek->updated_at   = date('Y-m-d H:i:s');
            $cek->save();
          }

        } 
      }
      
      // dd("BERHASIL");
      // dd($json[1]);
      // dd(count($json[1]));
      // foreach($json[1] as)
      // dd(json_decode($sml,true));
			// return response()->json($sml); 
	} 

  public function pasienBaru(Request $request)
  { 
    // $request->validate([
    //   'nomorkartu' => 'required|numeric|digits:13',
    //   'nik' => 'required|numeric|digits:16',      
    // ]);
    
    
    // Jika nomor kartu kosong
    if(!$request->nomorkartu){
      return Response::json(["metadata"=> ["message"=> "Nomor Kartu Belum Diisi","code"=> 201]]);
    }
    // Cek nomor kartu
    if(strlen($request->nomorkartu) !== 13)   {
      return Response::json(["metadata"=> ["message"=> "Format Nomor Kartu Tidak Sesuai","code"=> 201]]);
    }
    // Jika NIK kosong
    if(!$request->nik){
      return Response::json(["metadata"=> ["message"=> "NIK Belum Diisi","code"=> 201]]);
    }

    // Cek nomor NIK
    if(strlen($request->nik) !== 16)    {
      return Response::json(["metadata"=> ["message"=> "Format NIK Tidak Sesuai","code"=> 201]]);
    }
    
    // Jika nomorkk kosong
    if(!$request->nomorkk){
      return Response::json(["metadata"=> ["message"=> "Nomor KK Belum Diisi","code"=> 201]]);
    }
    // Cek nomor NIK
    if(strlen($request->nomorkk) !== 16)    {
      return Response::json(["metadata"=> ["message"=> "Nomor KK Tidak Sesuai","code"=> 201]]);
    }
    // Jika nama kosong
    if(!$request->nama){
      return Response::json(["metadata"=> ["message"=> "Nama Belum Diisi","code"=> 201]]);
    }
    // Jika kelamin kosong
    if(!$request->jeniskelamin){
      return Response::json(["metadata"=> ["message"=> "Jenis Kelamin Belum Diisi","code"=> 201]]);
    }
    // Jika Tgl lahir kosong
    if(!$request->tanggallahir){
      return Response::json(["metadata"=> ["message"=> "Tanggal Lahir Belum Diisi","code"=> 201]]);
    }
    // Jika alamat kosong
    if(!$request->alamat){
      return Response::json(["metadata"=> ["message"=> "Alamat Belum Diisi","code"=> 201]]);
    }
    // Jika kdprop kosong
    if(!$request->kodeprop){
      return Response::json(["metadata"=> ["message"=> "Kode Propinsi Belum Diisi","code"=> 201]]);
    }
    // Jika namaprop kosong
    if(!$request->namaprop){
      return Response::json(["metadata"=> ["message"=> "Nama Propinsi Belum Diisi","code"=> 201]]);
    }
    // Jika kodedati kosong
    if(!$request->kodedati2){
      return Response::json(["metadata"=> ["message"=> "Kode Dati 2 Belum Diisi","code"=> 201]]);
    }
    // Jika namadati kosong
    if(!$request->namadati2){
      return Response::json(["metadata"=> ["message"=> "Dati 2 Belum Diisi","code"=> 201]]);
    }

    // Jika kdprop kosong
    if(!$request->kodekec){
      return Response::json(["metadata"=> ["message"=> "Kode Kecamatan Belum Diisi","code"=> 201]]);
    }
    // Jika kdprop kosong
    if(!$request->namakec){
      return Response::json(["metadata"=> ["message"=> "Kecamatan Belum Diisi","code"=> 201]]);
    }
    // Jika kdprop kosong
    if(!$request->kodekel){
      return Response::json(["metadata"=> ["message"=> "Kode Kelurahan Belum Diisi","code"=> 201]]);
    }
    // Jika kdprop kosong
    if(!$request->namakel){
      return Response::json(["metadata"=> ["message"=> "Kelurahan Belum Diisi","code"=> 201]]);
    }
    // Jika kdprop kosong
    if(!$request->rw){
      return Response::json(["metadata"=> ["message"=> "RW Belum Diisi","code"=> 201]]);
    }
    // Jika kdprop kosong
    if(!$request->rt){
      return Response::json(["metadata"=> ["message"=> "RT Belum Diisi","code"=> 201]]);
    }
    
    $cek_reg = RegistrasiDummy::where('nik',$request->nik)
    ->where('nomorkartu',$request->nomorkartu)
    ->where('jenis_registrasi','pasien_baru')
    ->first();

    if($cek_reg){
      return Response::json(["metadata"=> ["message"=> "Data Peserta Sudah Pernah Dientrikan","code"=> 201]]);
    }
    // CEK FORMAT TANGGAL
    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$request->tanggallahir)) {
      $resp = Response::json([
        "metadata" => [
          "message" =>"Format Tanggal Lahir Tidak Sesuai, format yang benar adalah yyyy-mm-dd",
          "code"=> 201
        ]
      ]); 
      return $resp; die;
    }

    // GENERATE NEW NO RM
    $new_no_rm = date('yn').sprintf("%03s", 0);
    $cek_norm = RegistrasiDummy::where('no_rm','like',date('yn') . '%')->count();
    if($cek_norm > 0){
      $norm = date('yn').sprintf("%03s", $cek_norm)+1;
    }else{
      $norm = $new_no_rm +1;
    }
    // return $norm;
    

    date_default_timezone_set('UTC');
    $tStamp = date('d-m-Y');
    $signature = base64_encode(hash_hmac('sha256', config('app.username_ws').'&' . $tStamp, config('app.password_ws'), true));

    if(empty($request->header('x-token')) && empty($request->header('x-username'))){
      $resp = '{
        "metadata": {
          "message": "Header invalid !",
          "code": 201
        }
      }';
      return $resp;
    }
    if ($request->header('x-token') == $signature && $request->header('x-username') == config('app.username_ws')) { 
      $reg_dum  = RegistrasiDummy::where('nomorkartu', $request->nomorkartu)->first();


      $fkrtl                 = New RegistrasiDummy();
      $fkrtl->nomorkartu     = $request->nomorkartu;
      $fkrtl->nik            = $request->nik;
      $fkrtl->nomorkk        = $request->nomorkk; 
      $fkrtl->nama           = $request->nama;
      $fkrtl->kelamin        = $request->jeniskelamin;
      $fkrtl->tgllahir       = $request->tanggallahir;
      $fkrtl->no_hp          = $request->nohp;
      $fkrtl->alamat         = $request->alamat;
      $fkrtl->kodeprop       = $request->kodeprop;
      $fkrtl->namaprop       = $request->namaprop;
      $fkrtl->kodedati2      = $request->kodedati2;
      $fkrtl->namadati2      = $request->namadati2;
      $fkrtl->kodekec        = $request->kodekec;
      $fkrtl->namakec        = $request->namakec;
      $fkrtl->kodekel        = $request->kodekel;
      $fkrtl->namakel        = $request->namakel;
      $fkrtl->rw             = $request->rw;
      $fkrtl->rt             = $request->rt;
      $fkrtl->cekin          = 'N';
      $fkrtl->jenisdaftar    = 'fkrtl'; 
      $fkrtl->jenis_registrasi    = 'pasien_baru'; 
      $fkrtl->kode_cara_bayar= 1;
      $fkrtl->status         = 'pending';  
      $fkrtl->no_rm           =$norm;
      // $fkrtl->save();
       
        
      // return $reg_dum; die;
      if ( $fkrtl->save()) {
        $resp = Response::json([
          "response"=> [
            "norm" => $norm
          ],
          "metadata"=> [
             "message"=> "Harap datang ke admisi untuk melengkapi data rekam medis",
             "code"=> 200
          ]
        ]);
      } else {
        $resp = Response::json([
          "metadata"=> [
            "message"=> "Data invalid !",
            "code"=> 201
          ]
        ]);
      }
    } else {
      $resp = Response::json([
        "metadata"=> [
          "message"=> "Header invalid !",
          "code"=> 201
        ]
      ]); 
    }
    return $resp;
  }

  public function token(Request $request)
  {
    // $request->validate([
    //   'password' => 'required',
    //   'username' => 'required',
    // ]);
    if($request->header('x-username') ==config('app.username_ws') && $request->header('x-password') == config('app.password_ws')){
    // if ($request->username == config('app.username_ws') && $request->password == config('app.password_ws')) {
      date_default_timezone_set('UTC');
      $tStamp = date('d-m-Y');
      $signature = base64_encode(hash_hmac('sha256', $request->header('x-username') . "&" . $tStamp, $request->header('x-password'), true));


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
          "message": "Username atau Password Tidak Sesuai",
          "code": 201
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

  public function updatejadwaldokter( Request $request ) { 
      // CALL API BPJS 
      $ID = config('app.consid_antrean');
      date_default_timezone_set('UTC');
      $t = time();
      $data = "$ID&$t";
      $secretKey = config('app.secretkey_antrean');
      $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
      
      $req   = '{
        "kodepoli": "'.$request['kodepoli'].'",
        "kodesubspesialis": "'.$request['kodesubspesialis'].'",
        "kodedokter": "'.$request['kodedokter'].'"
      }'; 
     
      // dd(json_decode($req));
      $jadwal = [];

      foreach($request['jadwal'] as $j){
        $jadwal[] = [
          'hari'=>$j['hari'],
          'buka'=>$j['buka'],
          'tutup'=>$j['tutup'],
        ];
      } 
      $req = json_decode($req, true); 
      $req['jadwal'] = $jadwal;

      // return json_encode($req);
      $completeurl =config('app.antrean_url_web_service')."/jadwaldokter/updatejadwaldokter";;
      

      $session = curl_init($completeurl);
      // dd($session);
      $arrheader = array(
        'x-cons-id: ' . $ID,
        'x-timestamp: ' . $t,
        'x-signature: ' . $signature,
        'user_key:'.config('app.user_key_antrean'),
        'Content-Type: application/json',
      );
      // dd([$arrheader,$completeurl]);
      // dd(json_decode($body_prb));
      curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
      curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($req));
      curl_setopt($session, CURLOPT_POST, TRUE);
      curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
      
      $response = curl_exec($session);
      dd($response);
      $sml = json_decode($response, true);
      // dd($sml); 
  }

  public function jadwalDokter($kodepoli)
  { 
    $ID = config('app.sep_id');
    date_default_timezone_set('UTC');
    $t = time();
    $data = "$ID&$t";
    $secretKey = config('app.sep_key');
    $user_key = config('app.user_key');
    $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

    $completeurl = "https://apijkn-dev.bpjs-kesehatan.go.id/antreanrs_dev/jadwaldokter/kodepoli/". $kodepoli."/tanggal/".date('Y-m-d');
    // dd($completeurl);
    $session = curl_init($completeurl);
    $arrheader = array(
      'x-cons-id: ' . $ID,
      'x-timestamp: ' . $t,
      'x-signature: ' . $signature,
      'user_key:'.$user_key, 
      'Content-Type: application/json; charset=utf-8',
    ); 
    curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
    curl_setopt($session, CURLOPT_HTTPGET, 1);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($session);
    dd($response); 
    $array[] = json_decode($response, true);
    $stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
    
    $array[] = json_decode($this->decompress($stringEncrypt),true);
     
    $sml = json_encode($array,JSON_PRETTY_PRINT);
    dd($sml);
    // $jadwal = Jadwaldokter::all();
    // $data = [];
    // if($jadwal){
    //   foreach($jadwal as $j){
    //     $data[] = [
    //       'kodesubspesialis' => $j->polis->bpjs,
    //       'hari' => convert_hari($j->hari), 
    //       'kapasitaspasen' => '', 
    //       'libur' => '', 
    //       'namahari' => $j->hari,
    //       'jadwal' => $j->jam_mulai.'-'.$j->jam_akhir,
    //       'namasubspesialis' => strtoupper($j->poli),
    //       'namadokter' => $j->dokter,
    //       'kodepoli' => $j->polis->bpjs,
    //       'namapoli' => $j->poli,
    //       'kodedokter' => @$j->pegawai->kode_bpjs ? @$j->pegawai->kode_bpjs : '',
    //     ];
    //   }
    // }
    // return response()->json($data);
  }

  public function refDokter()
  { 
      $ID = config('app.consid_antrean');
      date_default_timezone_set('UTC');
      $t = time();
      $data = "$ID&$t";
      $secretKey = config('app.secretkey_antrean');
      $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 

    $completeurl = "https://apijkn-dev.bpjs-kesehatan.go.id/antreanrs_dev/ref/dokter";
    // dd($completeurl);
    $session = curl_init($completeurl);
    $arrheader = array(
      'x-cons-id: ' . $ID,
      'x-timestamp: ' . $t,
      'x-signature: ' . $signature,
      'user_key:'.config('app.user_key_antrean'),  
    ); 
    curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
    curl_setopt($session, CURLOPT_HTTPGET, 1);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($session);
    // dd($response); 
    $array[] = json_decode($response, true);
    
    $stringEncrypt = $this->stringDecrypt($ID.config('app.consid_antrean').$t,$array[0]['response']);
    
    $array[] = json_decode($this->decompress($stringEncrypt),true);
     
    $sml = json_encode($array,JSON_PRETTY_PRINT);
    return $sml;
    // $jadwal = Jadwaldokter::all();
    // $data = [];
    // if($jadwal){
    //   foreach($jadwal as $j){
    //     $data[] = [
    //       'kodesubspesialis' => $j->polis->bpjs,
    //       'hari' => convert_hari($j->hari), 
    //       'kapasitaspasen' => '', 
    //       'libur' => '', 
    //       'namahari' => $j->hari,
    //       'jadwal' => $j->jam_mulai.'-'.$j->jam_akhir,
    //       'namasubspesialis' => strtoupper($j->poli),
    //       'namadokter' => $j->dokter,
    //       'kodepoli' => $j->polis->bpjs,
    //       'namapoli' => $j->poli,
    //       'kodedokter' => @$j->pegawai->kode_bpjs ? @$j->pegawai->kode_bpjs : '',
    //     ];
    //   }
    // }
    // return response()->json($data);
  }


  // V2
  public function tambahantrian( Request $request ) {
    
    DB::beginTransaction();
    try{ 

      // CALL API BPJS 
      $ID = config('app.consid_antrean');
      date_default_timezone_set('UTC');
      $t = time();
      $data = "$ID&$t";
      $secretKey = config('app.secretkey_antrean');
      $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
      
      $req   = '{
         "kodebooking": "'.$request['kodebooking'].'",
         "jenispasien": "'.$request['jenispasien'].'",
         "nomorkartu": "'.$request['nomorkartu'].'",
         "nik": "'.$request['nik'].'",
         "nohp": "'.$request['nohp'].'",
         "kodepoli": "'.$request['kodepoli'].'",
         "namapoli": "'.$request['namapoli'].'",
         "pasienbaru: "'.$request['pasienbaru'].'",
         "norm": "'.$request['norm'].'",
         "tanggalperiksa": "'.$request['tanggalperiksa'].'",
         "kodedokter": "'.$request['kodedokter'].'",
         "namadokter": "'.$request['namadokter'].'",
         "jampraktek": "'.$request['jampraktek'].'",
         "jeniskunjungan: "'.$request['jeniskunjungan'].'",
         "nomorreferensi": "'.$request['nomorreferensi'].'",
         "nomorantrean": "'.$request['nomorantrean'].'",
         "angkaantrean": "'.$request['angkaantrean'].'",
         "estimasidilayani": "'.$request['estimasidilayani'].'",
         "sisakuotajkn: "'.$request['sisakuotajkn'].'",
         "kuotajkn": "'.$request['kuotajkn'].'",
         "sisakuotanonjkn": "'.$request['sisakuotanonjkn'].'",
         "kuotanonjkn": "'.$request['kuotanonjkn'].'",
         "keterangan": "'.$request['keterangan'].'"
      }';
      // $req   = '{
      //    "kodebooking": "16032021A004",
      //    "jenispasien": "JKN",
      //    "nomorkartu": "0002045624005",
      //    "nik": "3212345678987654",
      //    "nohp": "085635228888",
      //    "kodepoli": "ANA",
      //    "namapoli": "Anak",
      //    "pasienbaru": 0,
      //    "norm": "123345",
      //    "tanggalperiksa": "2021-01-28",
      //    "kodedokter": 11858,
      //    "namadokter": "drg. Aulia Aita Aswar",
      //    "jampraktek": "08:00-16:00",
      //    "jeniskunjungan": 1,
      //    "nomorreferensi": "0001R0040116A000004",
      //    "nomorantrean": "A-12",
      //    "angkaantrean": 12,
      //    "estimasidilayani": 1615869169000,
      //    "sisakuotajkn": 5,
      //    "kuotajkn": 30,
      //    "sisakuotanonjkn": 5,
      //    "kuotanonjkn": 30,
      //    "keterangan": "Peserta harap 30 menit lebih awal guna pencatatan administrasi."
      // }';
 
      // dd(json_encode($req));
      $completeurl = config('app.antrean_url_web_service')."/antrean/add";
      

      $session = curl_init($completeurl);
      // dd($session);
      $arrheader = array(
        'X-cons-id: ' . $ID,
        'X-timestamp: ' . $t,
        'X-signature: ' . $signature,
        'user_key:'. config('app.user_key_antrean'),
        'Content-Type: application/json',
      );
      
      // dd(json_decode($body_prb));
      curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
      curl_setopt($session, CURLOPT_POSTFIELDS, $req);
      curl_setopt($session, CURLOPT_POST, TRUE);
      curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
      
      $response = curl_exec($session);
      $req2   = '{
        "kodebooking": "16032021A004",
        "taskid": 1,
        "waktu": 1616559330000
     }';

     // dd($req);
     $completeurl2 ="https://apijkn-dev.bpjs-kesehatan.go.id/antreanrs_dev/antrean/updatewaktu";
     

     $session2 = curl_init($completeurl2);
     // dd($session);
     $arrheader2 = array(
       'x-cons-id: ' . $ID,
       'x-timestamp: ' . $t,
       'x-signature: ' . $signature,
       'user_key:'. config('app.user_key_antrean'),
       'Content-Type: application/json',
     );
     // dd([$arrheader,$completeurl]);
     // dd(json_decode($body_prb));
     curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader2);
     curl_setopt($session2, CURLOPT_POSTFIELDS, $req2);
     curl_setopt($session2, CURLOPT_POST, TRUE);
     curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
     
     $response2 = curl_exec($session2);


      dd([
        'header'=>$arrheader,
        'url'=>$completeurl,
        'request'=> json_decode($req,true),
        'response' => $response,
        'response2' => $response2,

      ]);
      $sml = json_decode($response, true);
      // dd($sml);
        
      
    }catch( \Exception $e ){
      DB::rollback();
      // dd($e->getMessage());
      Flashy::error('Terjadi Kesalahan. Error: '.$e->getMessage());
      return redirect()->back();
    }
  }

  public function updatewaktu( Request $request ) {
    
    DB::beginTransaction();
    try{ 

      // CALL API BPJS 
      $ID = config('app.consid_antrean');
      date_default_timezone_set('UTC');
      $t = time();
      $data = "$ID&$t";
      $secretKey = config('app.secretkey_antrean');
      $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
      
      $req   = '{
         "kodebooking": "16032021A002",
         "taskid": 2,
         "waktu": 1616559330000
      }';
 
      // dd($req);
      $completeurl ="https://apijkn-dev.bpjs-kesehatan.go.id/antreanrs_dev/antrean/updatewaktu";
      

      $session = curl_init($completeurl);
      // dd($session);
      $arrheader = array(
        'x-cons-id: ' . $ID,
        'x-timestamp: ' . $t,
        'x-signature: ' . $signature,
        'user_key:'. config('app.user_key_antrean'),
        'Content-Type: application/json',
      );
      // dd([$arrheader,$completeurl]);
      // dd(json_decode($body_prb));
      curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
      curl_setopt($session, CURLOPT_POSTFIELDS, $req);
      curl_setopt($session, CURLOPT_POST, TRUE);
      curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
      
      $response = curl_exec($session);
      dd($response);
      $sml = json_decode($response, true);
      // dd($sml);
        
      
    }catch( \Exception $e ){
      DB::rollback();
      // dd($e->getMessage());
      Flashy::error('Terjadi Kesalahan. Error: '.$e->getMessage());
      return redirect()->back();
    }
  }

  public function batalAntrianBpjs( Request $request ) {
    
    DB::beginTransaction();
    try{ 

      // CALL API BPJS 
      $ID = config('app.consid_antrean');
      date_default_timezone_set('UTC');
      $t = time();
      $data = "$ID&$t";
      $secretKey = config('app.secretkey_antrean');
      $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
      
      $req   = '{
         "kodebooking": "'.$request['kodebooking'].'",
         "keterangan": "Terjadi perubahan jadwal dokter, silahkan daftar kembali"
      }';
 
      // dd($req);
      $completeurl ="https://apijkn-dev.bpjs-kesehatan.go.id/antreanrs_dev/antrean/batal";
      

      $session = curl_init($completeurl);
      // dd($session);
      $arrheader = array(
        'x-cons-id: ' . $ID,
        'x-timestamp: ' . $t,
        'x-signature: ' . $signature,
        'user_key:'. config('app.user_key_antrean'),
        'Content-Type: application/json',
      );
      // dd([$arrheader,$completeurl]);
      // dd(json_decode($body_prb));
      curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
      curl_setopt($session, CURLOPT_POSTFIELDS, $req);
      curl_setopt($session, CURLOPT_POST, TRUE);
      curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
      
      $response = curl_exec($session);
      dd($response);
      $sml = json_decode($response, true);
      // dd($sml);
        
      
    }catch( \Exception $e ){
      DB::rollback();
      // dd($e->getMessage());
      Flashy::error('Terjadi Kesalahan. Error: '.$e->getMessage());
      return redirect()->back();
    }
  }
  public function getlisttask( Request $request ) {
    
    DB::beginTransaction();
    try{ 

      // CALL API BPJS 
      $ID = config('app.sep_id');
      date_default_timezone_set('UTC');
      $t = time();
      $data = "$ID&$t";
      $secretKey = config('app.sep_key');
      $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
      
      $req   = '{
         "kodebooking": "16032021A001", 
      }';
 
      // dd($req);
      $completeurl ="https://apijkn-dev.bpjs-kesehatan.go.id/antreanrs_dev/antrean/batal";
      

      $session = curl_init($completeurl);
      // dd($session);
      $arrheader = array(
        'x-cons-id: ' . $ID,
        'x-timestamp: ' . $t,
        'x-signature: ' . $signature,
        'user_key:'. config('app.user_key'),
        'Content-Type: application/json',
      );
      // dd([$arrheader,$completeurl]);
      // dd(json_decode($body_prb));
      curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
      curl_setopt($session, CURLOPT_POSTFIELDS, $req);
      curl_setopt($session, CURLOPT_POST, TRUE);
      curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
      
      $response = curl_exec($session);
      dd($response);
      $sml = json_decode($response, true);
      // dd($sml);
        
      
    }catch( \Exception $e ){
      DB::rollback();
      // dd($e->getMessage());
      Flashy::error('Terjadi Kesalahan. Error: '.$e->getMessage());
      return redirect()->back();
    }
  }

  function stringDecrypt($key, $string){
    $encrypt_method = 'AES-256-CBC';

    // hash
    $key_hash = hex2bin(hash('sha256', $key));
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hex2bin(hash('sha256', $key)), 0, 16); 
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
    // dd($output);
    return $output;
  }

  // function lzstring decompress 
  // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
  function decompress($string){
    // dd($string);
    return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);

  }
}
