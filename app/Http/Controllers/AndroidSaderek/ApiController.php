<?php

namespace App\Http\Controllers\AndroidSaderek;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AndroidSaderek\RegistrasiDummy;
use App\AndroidSaderek\UserDummy;
use App\AndroidSaderek\screeningPasien;
use Carbon\Carbon;
use DB;
use Validator;
use Exception;

class ApiController extends Controller
{
    public function daftarOnline(Request $request)
    {
        $uuid = 'SDR' . date('YmdHis');
        $data = [
            'uuid' => $uuid,
            'no_rm' => $request->nomor_rm,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tgllahir' => date('Y-m-d', strtotime($request->tgl_lahir)),
            'kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'kode_cara_bayar' => $request->kode_cara_bayar,
            'no_rujukan' => ($request->nomor_rujukan != '') ? $request->nomor_rujukan : '-',
            'tglperiksa' => date('Y-m-d', strtotime($request->tglperiksa)),
            'jenisdaftar' => 'android',
            'kode_poli' => $request->kode_poli,
            'kode_dokter' => $request->kode_dokter,
            'nomorkartu' => $request->nomor_jkn,
        ];
        // dd($data);

        // $check = RegistrasiDummy::where(['no_rm' => $request->no_rm, 'tglperiksa' => $data['tglperiksa']])->count();
        $check = RegistrasiDummy::where(['nik' => $request->nik, 'tglperiksa' => $data['tglperiksa']])->count();
        if ($check == 0) {
            RegistrasiDummy::create($data);
            $no = RegistrasiDummy::where('created_at', 'like', date('Y-m-d') . '%')->count();
            $res = [
                "status" => true,
                "data" => $data,
                "msg" => 'Berhasil'
            ];
            return response()->json($res);
        } else {
            $res = [
                "status" => false,
                "data" => null,
                "msg" => 'Anda sudah mendaftar di tanggal periksa ini'
            ];
            return response()->json($res);
        }
        // return $request;
    }

    public function loginUser(Request $request)
    {
        request()->validate(['nik' => 'required','tgllahir' => 'required']);
        $find = UserDummy::where('nik',$request->nik)->where('tgllahir',date('Y-m-d', strtotime($request->tgllahir)))->first();
        if( isset($find->id) ){
            $res = [
                "status" => true,
                "data" => $find,
                "msg" => 'Berhasil Login'
            ];
            return response()->json($res);
        }else{
            $data = [
                "nik" => $request->nik,
                "tgllahir" => date('Y-m-d', strtotime($request->tgllahir))
            ];
            $find = UserDummy::create($data);
            $res = [
                "status" => true,
                "data" => $find,
                "msg" => 'Berhasil Create'
            ];
            return response()->json($res);
        }
        return response()->json($res);
    }

    function HashBPJS() {
        // $ID = '18007'; // soreang
        $ID = '9606';
		$t = time();
		$data = "$ID&$t";
        // $secretKey = '3uQFBF6322'; // soreang
        $secretKey = '2aH65269D3';

		date_default_timezone_set('UTC');
		// $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
		$signature = hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true);
		$encodedSignature = base64_encode($signature);
		return array($ID, $t, $encodedSignature);
    }
    
    function xrequest($url, $signature, $ID, $t) {
        try {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DEFAULT@SECLEVEL=1');

            $headers = array();
            $headers[] = "Accept: application/json";
            $headers[] = "Content-Type: application/json";
            $headers[] = "X-Cons-Id:" . $ID;
            $headers[] = "X-Timestamp:" . $t;
            $headers[] = "X-Signature:" . $signature;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);

            $response = curl_exec($ch);
            
            // if ($response === false) {
            //     throw new Exception(curl_error($ch), curl_errno($ch));
            // }

            if (curl_errno($ch)) {
                $message = 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            return $response;
        } catch(Exception $e) {

            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
        
        }
	}

    public function getRujukan(Request $request)
    {  
        request()->validate(['no_rujukan' => 'required']);
        list($ID, $t, $signature) = $this->HashBPJS();
        $completeurl = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Rujukan/" . $request['no_rujukan'];
        //$completeurl = "https://dvlp.bpjs-kesehatan.go.id/vclaim-rest/Rujukan/RS/".$request['no_rujukan']; //Rumah sakit
        $response = $this->xrequest($completeurl, $signature, $ID, $t);
        $hasil = json_decode($response);
        $sml = json_encode($hasil);
        return response()->json($hasil);
    }

    public function getPeserta(Request $request)
    {  
        request()->validate(['no_kartu' => 'required']);
        list($ID, $t, $signature) = $this->HashBPJS();
        $completeurl = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Rujukan/Peserta/" . $request['no_kartu'];
        //$completeurl = "https://dvlp.bpjs-kesehatan.go.id/vclaim-rest/Rujukan/RS/".$request['no_rujukan']; //Rumah sakit
        $response = $this->xrequest($completeurl, $signature, $ID, $t);
        $hasil = json_decode($response);
        $sml = json_encode($hasil);
        return response()->json($hasil);
    }

    public function getPesertaMultiple(Request $request)
    {  
        request()->validate(['no_kartu' => 'required']);
        list($ID, $t, $signature) = $this->HashBPJS();
        $completeurl = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Rujukan/List/Peserta/" . $request['no_kartu'];
        //$completeurl = "https://dvlp.bpjs-kesehatan.go.id/vclaim-rest/Rujukan/RS/".$request['no_rujukan']; //Rumah sakit
        $response = $this->xrequest($completeurl, $signature, $ID, $t);
        $hasil = json_decode($response);
        $sml = json_encode($hasil);
        return response()->json($hasil);
    }

    public function cekPendaftaran(Request $request)
    {
        $data = RegistrasiDummy::with(['data_screening.screening_detail.screening'])->where('nik',$request->nik)->get();
        $res = [
            "status" => true,
            "data" => $data,
            "msg" => 'Berhasil'
        ];
        return response()->json($res);
    }

    public function cekPendaftaranByUUID(Request $request)
    {
        $data = RegistrasiDummy::with(['data_screening.screening_detail.screening'])->where('uuid',$request->uuid)->first();
        $res = [
            "status" => true,
            "data" => $data,
            "msg" => 'Berhasil'
        ];
        return response()->json($res);
    }

    public function hashAPI(){
        $ID = 'SQp4a';
		$t = time();
		$data = "$ID&$t";
        $secretKey = 'mr6lmq9HdX';
		date_default_timezone_set('UTC');
        $signature = hash_hmac('sha256', $data, $secretKey, true);
        $encodedSignature = base64_encode($signature);
        return $encodedSignature;
    }

    public function getPendaftaran(Request $request)
    {
        $cons_id = $request->header('X-Cons-Id');
        $secret_key = $request->header('X-Secret-Key');

        if( $cons_id == 'SQp4a' && $secret_key == "mr6lmq9HdX" ){
            $data = RegistrasiDummy::where('uuid',$request->uuid)->first();
            if( isset($data->id) ){
                $dt = [
                    "uuid" => $data->uuid,
                    "no_rm" => $data->no_rm,
                    "nik" => $data->nik,
                    "no_kartu" => $data->nomorkartu,
                    "nama" => $data->nama,
                    "alamat" => $data->alamat,
                ];
                $res = [
                    "status" => true,
                    "data" => $dt,
                    "msg" => 'Berhasil'
                ];
            }else{
                $res = [
                    "status" => true,
                    "data" => null,
                    "msg" => 'UUID Tidak Ditemukan'
                ];
            }
            return response()->json($res);
        }else{
            $res = [
                "status" => false,
                "data" => null,
                "msg" => 'Cons Id / Secret Key Not Valid'
            ];
            return response()->json($res,401);
        }
    }

    public function countScreening(Request $request)
    {
        $count = screeningPasien::where('reg_id',$request->registrasi_id)->count();
        $res = [
            "status" => true,
            "data" => $count,
            "msg" => 'Berhasil'
        ];
        return response()->json($res);
    }

    public function checkin(Request $request)
    {
        DB::beginTransaction();
        try{
            $find = screeningPasien::where('uuid',$request->uuid)->first();
            if( !isset($find->id) ){
                $res = [
                    "status" => true,
                    "data" => null,
                    "msg" => "UUID tidak ditemukan"
                ];
                return response()->json($res);
            }
            $data = [
                "suhu_tubuh" => $request->suhu_tubuh,
                "check_in" => $request->check_in,
                "infeksi_covid" => $request->infeksi_covid
            ];
            $find->update($data);
            DB::commit();
            $res = [
                "status" => true,
                "data" => [
                    "uuid" => $find->uuid,
                    "suhu_tubuh" => $find->suhu_tubuh,
                    "check_in" => ($request->check_in == 0) ? 'Tidak' : "Ya",
                    "infeksi_covid" => ($request->infeksi_covid == 0) ? 'Tidak' : 'Ya'
                ],
                "msg" => "Berhasil"
            ];
            return response()->json($res);
        }catch(\Exception $e){
            DB::rollback();
            $res = [
                "status" => false,
                "data" => null,
                "msg" => "Terjadi Kesalahan. Error:".$e->getMessage(),
            ];
            return response()->json($res);
        }
    }

    public function vclaimKartuPeserta(Request $request)
    {
        request()->validate(['no_kartu' => 'required','tgl_sep' => 'required']);
        list($ID, $t, $signature) = $this->HashBPJS();
        $completeurl = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Peserta/nokartu/" . $request['no_kartu'].'/tglSEP/'.$request['tgl_sep'];
        $response = $this->xrequest($completeurl, $signature, $ID, $t);
        $hasil = json_decode($response);
        $sml = json_encode($hasil);
        return response()->json($hasil);
    }

    public function vclaimNIK(Request $request)
    {
        request()->validate(['nik' => 'required','tgl_sep' => 'required']);
        list($ID, $t, $signature) = $this->HashBPJS();
        $completeurl = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/Peserta/nik/" . $request['nik'].'/tglSEP/'.$request['tgl_sep'];
        $response = $this->xrequest($completeurl, $signature, $ID, $t);
        $hasil = json_decode($response);
        $sml = json_encode($hasil);
        return response()->json($hasil);
    }

    public function cekUpdate()
    {
        $data = [
            "ios"=> [
				"latest"=> "1.1.1",
				"minimum"=> "1.1.1",
				"url"=> "https://play.google.com/store/apps/details?id=com.pekade.saderekrsudsoreang",
				"enabled"=> true,
				"alerts" => [
					"maintenance" => [
						"title" => "Aplikasi dalam masa perbaikan.",
						"text" => "Saderek RSUD Soreang sedang dalam perbaikan, Mohong tunggu sampai perbaikan selesai !"
					],
					"mandatory" => [
						"title" => "Pembaruan Aplikasi",
						"text" => "Terdapat pembaruan pada aplikasi Saderek RSUD Soreang, Silahkan perbarui aplikasi anda untuk melanjutkan penggunaan !"
					],
					"optional" => [
						"title" => "Pembaruan Aplikasi telah tersedia",
						"text" => "Silahkan perbarui aplikasi anda untuk menikmati fitur baru !"
					]
				]
			],
			"android"=> [
				"latest"=> "1.1.1",
				"minimum"=> "1.1.1",
				"url"=> "https://play.google.com/store/apps/details?id=com.pekade.saderekrsudsoreang",
				"enabled"=> true,
				"alerts" => [
					"maintenance" => [
						"title" => "Aplikasi dalam masa perbaikan.",
						"text" => "Saderek RSUD Soreang sedang dalam perbaikan, Mohong tunggu sampai perbaikan selesai !"
					],
					"mandatory" => [
						"title" => "Pembaruan Aplikasi",
						"text" => "Terdapat pembaruan pada aplikasi Saderek RSUD Soreang, Silahkan perbarui aplikasi anda untuk melanjutkan penggunaan !"
					],
					"optional" => [
						"title" => "Pembaruan Aplikasi telah tersedia",
						"text" => "Silahkan perbarui aplikasi anda untuk menikmati fitur baru !"
					]
				]
			],
        ];
        return response()->json($data);
    }

    public function pengumuman()
    {
        $data = [
            "status" => true,
            "data" => [
                "content" => "Diberitahukan, Mulai Tanggal 7 Juni 2021 Seluruh Pelayanan Rawat Jalan Sudah dilaksanakan Pada Gedung Baru RSUD OTO ISKANDAR DI NATA Jl. Raya Gading Tutuka Kampung Cingcin Kolot RT. 001 RW. 001, Desa Cingcin, Kecamatan Soreang.",
            ],
        ];
        return response()->json($data);
    }
}