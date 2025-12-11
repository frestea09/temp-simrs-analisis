<?php

namespace App\Http\Controllers;

use App\AntrianLog;
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
use App\LicaResult;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use App\Operasi;
use Modules\Registrasi\Entities\Carabayar;

class ApiController extends Controller
{


  public function licaReport(Request $r){
    
    
    if ($r->header('x-username') == config('app.username_licareport_ws') && $r->header('x-password') == config('app.password_licareport_ws')) {
      $lica = LicaResult::where('no_lab',$r->no_ref)->first();
      if(!$lica){
        $lica = new LicaResult();
      }
      // dd($r->all());
      $lica->no_lab          = $r->no_ref;
      $lica->tgl_pemeriksaan = $r->tgl_kirim;
      $lica->json            = json_encode($r->hasil);
      $lica->pemeriksa       = @$r->pemeriksa;
      $lica->keterangan       = @$r->keterangan;
      $lica->save();
      
      return 
        $resp = [
          "metadata"=>[
            "message"=>"Sukses",
            "code"=> 200
          ]
        ];
      ;
    }else{
      dd("GAGAL");
    }
  }
  
  public function tanggalOperasi(Request $request)
  {
    // dd($request->all());
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
    
    date_default_timezone_set('Asia/Jakarta');
    $tStamp = date('d-m-Y');
    $signature = base64_encode(hash_hmac('sha256',config('app.username_ws').'&' . $tStamp, config('app.password_ws'), true));

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
      $timezone = time() + (60 * 60 * 7);
      $operasi   = Operasi::where('terlaksana','0')->whereBetween('rencana_operasi', [$request->tanggalawal, $request->tanggalakhir])->orderBy('id','ASC')->get();
      $map = $operasi->map(function ($value) {
        $ubah['kodebooking'] = $value->kodebooking;
        $ubah['tanggaloperasi'] = $value->rencana_operasi;
        $ubah['jenistindakan'] = strip_tags($value->suspect);
        $ubah['kodepoli'] = $value->kodepoli;
        $ubah['namapoli'] = $value->namapoli;
        $ubah['terlaksana'] = $value->terlaksana;
        $ubah['nopeserta'] = $value->no_jkn;
        $ubah['lastupdate'] = strtotime($value->created_at)*1000;
        return $ubah;
      });

      // dd($operasi); 
      if(count($map) > 0){
        $resp = [
            "response"=> [
              "list" => $map, 
            ],
            "metadata"=> [
              "message"=> "Ok",
              "code"=>200
            ]
          ]; 
      }else{
        $resp = [
            "response"=>[],
            "metadata"=>[
              "message"=> "Antrean Tidak Ditemukan",
              "code"=> 201
            ]
          ]; 
      }

    } else {
      $resp = [
        "metadata"=>[
          "message"=> "Token Expired",
          "code"=> 201
        ]
      ];
    }
    return Response::json($resp);
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


    date_default_timezone_set('Asia/Jakarta');
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
      $operasi   = Operasi::where('no_jkn', $request->nopeserta)->orderBy('id','ASC')->get();
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
        $resp = [
            "response"=>[
              "list" => $map
            ],
            "metadata"=> [
              "message"=> "Ok",
              "code"=> 200
            ]
        ]; 
      }else{
        $resp = [
            "response"=> [],
            "metadata"=>[
              "message"=> "Antrean Tidak Ditemukan",
              "code"=> 201
            ]
          ]; 
      }
      
    } else {
      $resp = [
        "metadata"=>[
          "message"=>"Token Expired",
          "code"=> 201
        ]
      ];
    }
    return Response::json($resp);
  }

  public function sisaAntrian(Request $request)
  {
    $sisaAntrian  = RegistrasiDummy::where('status','terdaftar')->where('tglperiksa',date('Y-m-d'))->count();
    if($sisaAntrian > 1){
      $antr = $sisaAntrian - 1;
    }else{
      $antr = 1;
    }
    $request->validate([

      'kodebooking' => 'required',
    ]); 

    $date = strtotime($request->tanggalperiksa);
    // $tgl = strtotime("+7 day", $date);
    $start = strtotime('now');
    $end =  strtotime('+7 days');



    date_default_timezone_set('Asia/Jakarta');
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
        $cekDokter = HfisDokter::where('kodedokter',$data->kode_dokter)->first();
        $dokters = baca_dokter_bpjs($data->kode_dokter) == '' ? @$cekDokter->namadokter : baca_dokter_bpjs($data->kode_dokter);
        // dd($data);
        if($data){
          $resp = Response::json([
            "response"=> [
              "nomorantrean" => $data['nomorantrian'],
              "namapoli" => baca_kode_poli($data->kode_poli),
              "namadokter" => $dokters, 
              "kodedokter" => @$data->kode_dokter,
              "antreanpanggil" => $data['nomorantrian'],
              "keterangan" => '',
              "sisaantrean" => @$sisaAntrian,
              // "waktutunggu" => strtotime(60*$antr)*1000 //1 menit * (sisaantrian-1) dalam format miliseconds
              "waktutunggu" => strtotime(60*$antr)*1000, //1 menit * (sisaantrian-1) dalam format miliseconds
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



    date_default_timezone_set('Asia/Jakarta');
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
      $dilayani  = RegistrasiDummy::where('kodebooking',$request->kodebooking)->where('cekin','Y')->first();
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
      $dibatalkan  = RegistrasiDummy::where('kodebooking',$request->kodebooking)->where('status','dibatalkan')->first();
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
        $data  = RegistrasiDummy::where('kodebooking',$request->kodebooking)->first();
        if (!$data) {
            $data = RegistrasiDummy::where('nomorantrian', $request->kodebooking)->first();
        }

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



    date_default_timezone_set('Asia/Jakarta');
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
        $data  = RegistrasiDummy::where('kodebooking',$request->kodebooking)->first();
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
    ]);
    
    // CEK FORMAT TANGGAL
    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$request->tanggalperiksa) || !$request->tanggalperiksa) {
      return Response::json([
        "metadata" => [
          "message" =>"Format Tanggal Tidak Sesuai, format yang benar adalah yyyy-mm-dd",
          "code"=> 201
        ]
      ]);
    } 

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



    date_default_timezone_set('Asia/Jakarta');
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
        ->where('jenisdaftar','fkrtl')
        // ->where('kode_dokter', $request->kodedokter)
        // ->where('jampraktek', $request->jampraktek)
        // ->where('status','pending')
        ->count();

        $sisaAntrean  = RegistrasiDummy::where('tglperiksa',$request->tanggalperiksa)
        ->where('kode_poli',$request->kodepoli)
        ->where('kode_dokter', $request->kodedokter)
        // ->where('jampraktek', $request->jampraktek)
        ->where('status','pending')
        ->where('cekin','N')
        ->count();

        $sisaKuotaJkn  = RegistrasiDummy::where('tglperiksa',$request->tanggalperiksa)
        ->where('kode_poli',$request->kodepoli)
        ->where('kode_cara_bayar','1')
        ->count();

        $sisaKuotaNonJkn  = RegistrasiDummy::where('tglperiksa',$request->tanggalperiksa)
        ->where('kode_poli',$request->kodepoli)
        ->where('kode_cara_bayar','2')
        ->count();

        $dilayani  = RegistrasiDummy::where('tglperiksa',$request->tanggalperiksa)
        ->where('kode_poli',$request->kodepoli)
        ->where('kode_dokter', $request->kodedokter)
        // ->where('jampraktek', $request->jampraktek)
        ->where('status','terdaftar')
        ->count();

        $kuotaJKN = @Poli::where('bpjs',$request->kodepoli)->first()->kuota_online;
        $kuotaNonJKN = @Poli::where('bpjs',$request->kodepoli)->first()->kuota;

        // $kuotap = hitung_kuota_poli_jkn($cekpoli->id,$request->tanggalperiksa);
        @$dokter = Pegawai::where('kode_bpjs',$request->kodedokter)->first();
    // @$kuotap = hitung_kuota_poli_jkn($dt_poli->id,$request->tanggalperiksa); //KUOTA POLI
        @$kuotap = hitung_kuota_poli_dokter_jkn($dokter->id,$request->tanggalperiksa); //KUOTA DOKTER PER POLI
        @$dipesan = RegistrasiDummy::where('jenisdaftar','fkrtl')->where('tglperiksa', $request->tanggalperiksa)->where('kode_poli',$request->kodepoli)->count();
        // $dilayani = \Modules\Registrasi\Entities\Folio::where('poli_id',$poli->id)->where('created_at', 'LIKE', date('Y-m-d') . '%')->groupBy('registrasi_id')->count();
        if($reg_dum){
          $resp = Response::json([
            "response"=> [
              "namapoli" =>baca_kode_poli($reg_dum->kode_poli), 
              "namadokter" => baca_dokter_bpjs($reg_dum->kode_dokter),
              "totalantrean" =>$totalantri,
              "sisaantrean" =>$totalantri,
              "antreanpanggil" =>$dilayani,
              "sisakuotajkn" =>abs($kuotap-$dipesan),
              "kuotajkn" =>$kuotap,
              "sisakuotanonjkn" =>$kuotaNonJKN-$sisaKuotaNonJkn,
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
              "message"=>"Antrean Tidak Ditemukan",
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
    @$this->saveLog($request->all(),"INIT");
    // CEK JADWAL POLI
    $dayname = date("D", strtotime($request->tanggalperiksa)); 
		$start = strtotime('now');
    $end =  strtotime('+90 days');
    $h1 = date('Y-m-d');
    $validation_h1 = date('Y-m-d', strtotime($h1. ' + 1 days'));
    
    // if($request->tanggalperiksa == $validation_h1){
    //   return Response::json(["metadata"=> ["message"=> "Pengambilan antrian H+1 belum bisa dilakukan","code"=> 201]]);
    // }

    $dt_poli = Poli::where('bpjs',$request->kodepoli)->first();
    // if( !$dt_poli ){
    //     return response()->json(['result' => 'gagal', 'info' => 'Kode Poli tidak ditemukan']);
    // }
    @$dokter = Pegawai::where('kode_bpjs',$request->kodedokter)->first();
    
    
    // @$kuotap = hitung_kuota_poli_jkn($dt_poli->id,$request->tanggalperiksa); //KUOTA POLI
    @$kuotap = hitung_kuota_poli_dokter_jkn($dokter->id,$request->tanggalperiksa); //KUOTA DOKTER PER POLI
    
    $dipesan = RegistrasiDummy::where('jenisdaftar','fkrtl')->where('kode_dokter',$request->kodedokter)->where('tglperiksa', $request->tanggalperiksa)->where('kode_poli',$request->kodepoli)->count();
    
    if( $dipesan >= $kuotap ){
      
      $resp =  Response::json([
        "metadata" =>[
          "message"=>"Kuota Dokter Tidak Tersedia",
          "code"=>201
        ]
        ]);
      return $resp;
    }
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
    $pasien = [];
    if(!empty($request->norm)){
      $cekrm = Pasien::where('no_rm', $request->norm)->first();
      $pasien = $cekrm;
      // dd($cekrm);
      if(!$cekrm){
        $resp = [
          'metadata' =>[
            'message' =>"Data pasien ini tidak ditemukan, silahkan Melakukan Registrasi Pasien Baru",
            'code'=>202
          ]
        ]; 
        return Response::json($resp);
      }
      
    }
 
    // CEK RM
    // $cek = RegistrasiDummy::where('no_rm', $request->norm)
    // ->where('nik',$request->nik)
    // ->where('nomorkartu',$request->nomorkartu)
    // ->where('jenis_registrasi','pasien_baru')
    // ->first();
    // if (!$cek) {
    //   $resp = [
    //     'metadata' =>[
    //       'message' =>"Data pasien ini tidak ditemukan, silahkan Melakukan Registrasi Pasien Baru",
    //       'code'=>202
    //     ]
    //   ]; 
    //   return Response::json($resp);
    // } 
    

    // SINKRONKAN DATA DOKTER HFIS
    $this->jadwalDokterHfis($request->kodepoli,$request->tanggalperiksa);
    
    
    // CEK JADWAL DOKTER
    $dateNum = date('N',strtotime($request->tanggalperiksa));
    $cekDokter = HfisDokter::where('kodedokter',$request->kodedokter)
    ->where('hari',$dateNum)->where('kodepoli',$request->kodepoli)
    ->where('jadwal',$request->jampraktek);
    // dd($cekDokter->first());
    // dd($cekDokter->first());
    $adaDokter = $cekDokter->first();
    if(!$cekDokter->first()){
      // $dokter = Pegawai::where('kode_bpjs',$request->kodedokter)->first();
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
 


    date_default_timezone_set('Asia/Jakarta');
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
      
      $buka_poli = Poli::where('bpjs', $request->kodepoli)->first();
      $tgldaftar_pasien = $request->tanggalperiksa.' '.$buka_poli->buka;

      $cekDokter = Pegawai::where('kode_bpjs',$request->kodedokter)->first();
      $nowHour = now()->format('H'); // ambil jam saat ini 00-23

      DB::beginTransaction();
     
      try {

            // dd("A");
            // Kunci tabel RegistrasiDummy supaya ada blocking untuk request simultan
            // DB::statement('LOCK TABLES registrasi_dummy WRITE');

            // Hitung antrian booking + antrian registrasi lama
            $queryDummy = RegistrasiDummy::where('tglperiksa', $request->tanggalperiksa)
                ->where('dokter_id', $dokter->id)
                ->where('kode_poli', $request->kodepoli);
                // ->lockForUpdate()
                // ->count();

            $queryReg = Registrasi::where('dokter_id', $dokter->id)
                ->where('created_at', 'like', $request->tanggalperiksa.'%')
                ->where('input_from', 'not like', 'KIOSK%');
                // ->where('input_from', 'not like', 'APM');
                // ->lockForUpdate()
                // ->count();
            // aktifkan lock hanya antara jam 00–02
            if ((int)$nowHour >= 0 && (int)$nowHour <= 2) {
                $queryDummy->lockForUpdate();
                $queryReg->lockForUpdate();
            }

            $cekantrianDummy = $queryDummy->count();
            $cekantrianReg   = $queryReg->count();

            // Nomor antrian fix (hanya 1 patokan)
            $noAntrian = $cekantrianDummy + $cekantrianReg + 1;
            // dd($noAntrian);
            $hitung = $noAntrian;
            $tanggalantri = date("dmY", strtotime($request->tanggalperiksa));
            $kodeantri = $dokter->kode_antrian ? $dokter->kode_antrian : $tanggalantri;

            // kodebooking JANGAN pakai variable perhitungan berbeda
            $kodebooking = $tanggalantri.$kodeantri.$request->kodepoli.$noAntrian;
            $nomorantri = $kodeantri.'-'.$request->kodepoli.$noAntrian;
          // dd($nomorantri);
          @$this->saveLog($request->all(),$nomorantri);
          
          
           if($cekDokter){
              $dokter = $cekDokter->id;
            }else{
              $dokter = '';
            }

          $spm = 4; // menit per pasien

          // hitung nomor antrian pasien di dokter ini
          $no_antrian_dokter = $noAntrian;

          // pasien pertama = 0 menit tunggu
          $menit_antri = $spm * ($no_antrian_dokter - 1);

          $estimasi = strtotime("+".$menit_antri." minutes", strtotime($tgldaftar_pasien));
          $convertestimasi = date("Y-m-d H:i:s", $estimasi);
          //END HITUNG ESTIMASI DILAYANI NEW
          // dd($convertestimasi);
          
          // cek kode dokter
         

          if(is_numeric(substr($nomorantri,-2))){
            $angka = substr($nomorantri,-2);
          }else{
            $angka = substr($nomorantri,-1);
          }
          // JIKA POLI SUBSPESIALIS
          if(is_numeric($request->kodepoli)){
            $angka = $hitung;
          }

         $fkrtl   = New RegistrasiDummy();
        $fkrtl->nomorkartu     = $request->nomorkartu;
        $fkrtl->nik            = $request->nik;
        $fkrtl->no_rm          = $request->norm;
        $fkrtl->no_hp          = $request->nohp;
        $fkrtl->nama           = @$pasien->nama;
        $fkrtl->alamat         = @$pasien->alamat;
        $fkrtl->kodeprop       = @$pasien->province_id;
        $fkrtl->kodedati2      = @$pasien->regency_id;
        $fkrtl->kodekec        = @$pasien->district_id;
        $fkrtl->kodekel        = @$pasien->village_id;
        $fkrtl->rt             = @$pasien->rt;
        $fkrtl->rw             = @$pasien->rw;
        $fkrtl->kelamin        = @$pasien->kelamin;
        $fkrtl->tmplahir       = @$pasien->tmplahir;
        $fkrtl->tgllahir       = @$pasien->tgllahir;
        $fkrtl->tglperiksa     = $request->tanggalperiksa;
        $fkrtl->kode_poli      = $request->kodepoli;
        $fkrtl->no_rujukan     = $request->nomorreferensi;
        $fkrtl->jenisreferensi = $request->jenisreferensi;
        $fkrtl->jenisrequest   = $request->jenisrequest;
        $fkrtl->polieksekutif  = $request->polieksekutif;
        $fkrtl->kode_dokter    = $request->kodedokter;
        $fkrtl->dokter_id      = $dokter;
        // $fkrtl->jampraktek     = $cekDokter->jadwal;
        $fkrtl->jampraktek     = $request->jampraktek;
        $fkrtl->jeniskunjungan = $request->jeniskunjungan;
        $fkrtl->cekin           = 'N';
        $fkrtl->jenis_registrasi    = 'antrian'; 
        $fkrtl->jenisdaftar    = 'fkrtl';
        $fkrtl->nomorantrian   = $nomorantri;
        $fkrtl->kodebooking   = $kodebooking;
        $fkrtl->angkaantrian   = $angka;
        $fkrtl->request   = json_encode($request->all());
        $fkrtl->flag   = 'antrian2.0';
        $fkrtl->kode_cara_bayar = 1;
        $fkrtl->status = 'pending';
        $fkrtl->estimasidilayani = $convertestimasi;
        // return $fkrtl;die;
        $fkrtl->save();

        // DB::statement('UNLOCK TABLES');
        DB::commit();

      } catch (\Exception $e) {
          DB::rollBack();
          return response()->json([
              "metadata" => [
                  "message" => "Terjadi kesalahan saat membuat antrian: Ulangi Beberapa saat lagi",
                  "code" => 201
              ]
          ]);
      }


      
      
      
      // $reg_dum  = RegistrasiDummy::where(['no_rm' => $request->nomorrm, 'tglperiksa' => $request->tanggalperiksa])->first();
      // $reg_dum  = Registrasi::join('pasiens','pasiens.id','=','registrasis.pasien_id')
      // ->where('pasiens.no_rm',  $request->nomorrm)
      //   ->where('registrasis.created_at', 'LIKE', $request->tanggalperiksa . '%')
      // ->first();
      // dd($reg_dum);
      $poli   = Poli::where('bpjs',$request->kodepoli)->first();
      // $poli_id = Poli::where('loket', $poli['id'])->pluck('id');
      // $reg_dum  = RegistrasiDummy::where(['no_rm' => $request->nomorrm, 'tglperiksa' => $request->tanggalperiksa])->whereIn('kode_poli', $poli_id)->first();
      $reg_dum  = RegistrasiDummy::where('kodebooking', $kodebooking)->first();

      $sisaKuotaJkn  = RegistrasiDummy::where('tglperiksa',$request->tanggalperiksa)
        ->where('kode_poli',$request->kodepoli)
        ->where('kode_cara_bayar','1')
        ->count();

        $sisaKuotaNonJkn  = RegistrasiDummy::where('tglperiksa',$request->tanggalperiksa)
        ->where('kode_poli',$request->kodepoli)
        ->where('kode_cara_bayar','2')
        ->count();
      

      // return $reg_dum; die;
      if (!empty($reg_dum)) {
        $kuotaJKN = @Poli::where('bpjs',$request->kodepoli)->first()->kuota_online;
        $kuotaNonJKN = @Poli::where('bpjs',$request->kodepoli)->first()->kuota;

        if(is_numeric(substr($reg_dum->nomorantrian,-2))){
          $angka = substr($reg_dum->nomorantrian,-2);
        }else{
          $angka = substr($reg_dum->nomorantrian,-1);
        }

        // JIKA SUBSPESIALIS
        if(is_numeric($reg_dum->kode_poli)){
          $angka = $hitung;
        }

        $dokters = baca_dokter_bpjs($reg_dum->kode_dokter) == '' ? @$adaDokter->namadokter : baca_dokter_bpjs($reg_dum->kode_dokter);
        // dd($dokters);
        $resp = [
          // 1615869169000
          // 1685970900000
          "response"=>[
            "nomorantrean" => $reg_dum->nomorantrian,
            // "nomorantrean" => $request->kodepoli.''.$hitung,
            "angkaantrean" => (int)$angka,
            "kodebooking" => $reg_dum->kodebooking,
            "norm" => (string) $reg_dum->no_rm,
            "estimasidilayani" => strtotime($reg_dum->estimasidilayani)*1000,
            // "estimasidilayani" => strtotime(explode(" ",$reg_dum->estimasidilayani))*1000,
            "namapoli" => $poli->nama,
            "kuotajkn" => $kuotap,
            "sisakuotajkn" =>abs($kuotap-$dipesan),
            "kuotanonjkn" => $kuotaNonJKN,
            "sisakuotanonjkn" =>$kuotaNonJKN-$sisaKuotaNonJkn,
            "keterangan" => "Peserta harap 60 menit lebih awal guna pencatatan administrasi.",
            "namadokter" => $dokters
          ],
          "metadata"=> [
            "message"=>"Ok",
            "code"=>200
          ]
        ];


        @$logBPJS = new AntrianLog();
        @$logBPJS->response = @json_encode($resp);
        @$logBPJS->nomorantrian = @$reg_dum->nomorantrian;
        @$logBPJS->save();
        
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

  public static function saveLog($request,$nomorantri){
     $new = new AntrianLog();
     $new->request = json_encode($request);
     $new->nomorantrian = $nomorantri;
     $new->save();
  }
  
  function jadwalDokterHfis($poli,$tgl) { 
			// dd($request);
      // dd([$tgl,$poli]);
			$ID = config('app.consid_antrean');
			date_default_timezone_set('Asia/Jakarta');
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
      // dd($array);
			if($message['metadata']['code'] == 200){
				$stringEncrypt = $this->stringDecrypt($ID.config('app.secretkey_antrean').$t,$array[0]['response']);
				$array[] = json_decode($this->decompress($stringEncrypt),true);
			}else{
				$array[] = json_decode($response,true);
			}

			$sml = json_encode($array,JSON_PRETTY_PRINT); 
			// return json_decode($sml,true);
      $json = json_decode($sml,true);
      // dd($json);
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
    // dd(is_numeric($request->nomorkartu));
    if(strlen($request->nomorkartu) !== 13 || is_numeric($request->nomorkartu) == false){
      
      return Response::json(["metadata"=> ["message"=> "Format Nomor Kartu Tidak Sesuai","code"=> 201]]);
    }
    // Jika NIK kosong
    if(!$request->nik){
      return Response::json(["metadata"=> ["message"=> "NIK Belum Diisi","code"=> 201]]);
    }

    // Cek nomor NIK
    if(strlen($request->nik) !== 16 || is_numeric($request->nik) ==false)    {
      return Response::json(["metadata"=> ["message"=> "Format NIK Tidak Sesuai","code"=> 201]]);
    }
    
    // Jika nomorkk kosong
    if(!$request->nomorkk){
      return Response::json(["metadata"=> ["message"=> "Nomor KK Belum Diisi","code"=> 201]]);
    }
    // Cek nomor NIK
    if(strlen($request->nomorkk) !== 16 || is_numeric($request->nomorkk)==false)    {
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
    $new_no_rm = date('Yn').sprintf("%03s", 0);
    $cek_norm = RegistrasiDummy::where('no_rm','like',date('Yn') . '%')->count();
    if($cek_norm > 0){
      $norm = date('Yn').sprintf("%03s", $cek_norm+1);
    }else{
      $norm = $new_no_rm +1;
    }
    // return $norm;
    

    date_default_timezone_set('Asia/Jakarta');
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
            "norm" => (string) $norm
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
      date_default_timezone_set('Asia/Jakarta');
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
      date_default_timezone_set('Asia/Jakarta');
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

  public function jadwalDokter(Request $req)
  { 
    $ID = config('app.consid_antrean');
    date_default_timezone_set('Asia/Jakarta');
    $t = time();
    $data = "$ID&$t";
    $secretKey = config('app.secretkey_antrean');
    $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
    
  
    $completeurl =config('app.antrean_url_web_service')."jadwaldokter/kodepoli/" . $req['kodepoli'] . "/tanggal/" .$req['tanggal'];
    // dd($completeurl);
    $session = curl_init($completeurl);
    $arrheader = array(
      'x-cons-id: ' . $ID,
      'x-timestamp: ' . $t,
      'x-signature: ' . $signature,
      'user_key:'.config('app.user_key_antrean'),
      'Content-Type: application/json; charset=utf-8',
    ); 
    curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
    curl_setopt($session, CURLOPT_HTTPGET, 1);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($session);
    // dd("A");
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
      // dd($array);
      $res = [];
      $res['metadata'] = $array[0]['metadata'];
      $res['response']['list'] = @$array[1];
      if($array[0]['metadata']['code'] == 201){
        $res['response']['list'] = [];
      }
			return response()->json($res);
  }

  public function refDokter()
  { 
      $ID = config('app.consid_antrean');
      date_default_timezone_set('Asia/Jakarta');
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
      date_default_timezone_set('Asia/Jakarta');
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
      date_default_timezone_set('Asia/Jakarta');
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
      date_default_timezone_set('Asia/Jakarta');
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
      date_default_timezone_set('Asia/Jakarta');
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
