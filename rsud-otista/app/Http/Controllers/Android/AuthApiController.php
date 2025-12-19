<?php

namespace App\Http\Controllers\Android;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// use JWTAuth;
// use Tymon\JWTAuth\Exceptions\JWTException;
use App\Android\pasien;
use App\Android\pasien_android;
use App\PasienBjb;
use App\RegistrasiDummy;
use Config;

class AuthApiController extends Controller
{
    // login pasien lama
    public function login(Request $request)
    {
        $user = pasien::where('no_rm', $request->no_rm)->where('tgllahir', $request->tgllahir)->first();
        
        
        
        
        if($user){

            // generate token jwt from user
            // $token = auth('pasien-api')->fromUser($user);
            $token = Str::random(60);
            $user->forceFill([
                'api_token' => $token,
            ])->save();
            // dd();

            // date_default_timezone_set('UTC');
            // $tStamp = date('d-m-Y');
            // $token = base64_encode(hash_hmac('sha256', $request->no_rm . "&" . $tStamp, $request->tgllahir, true));
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    "no_rm" => $user->no_rm,
                    "nik_ktp" => $user->nik,
                    "no_jkn" => $user->no_jkn,
                    "jenis_jkn" => $user->jkn,
                    "name" => $user->nama,
                    "tempat_lahir" => $user->tmplahir,
                    "tanggal_lahir" => $user->tgllahir,
                    "no_handphone" => $user->nohp,
                    "telepon" => $user->notlp,
                    "jenis_kelamin" => $user->kelamin,
                    "alamat" => $user->alamat,
                    "provinsi" => @$user->province_id ? @baca_propinsi(@$user->province_id) :'',
                    "kabupaten" => @$user->province_id ? @baca_kabupaten(@$user->regency_id):'',
                    "kecamatan" => @$user->province_id ? @baca_kecamatan(@$user->district_id):'',
                    "kelurahan" => @$user->province_id ? @baca_kelurahan(@$user->village_id):'',
                ],
                'token' => $token
            ]);
        }else{
            $bjb = PasienBjb::where('mr_no',@$request->no_rm)->first();
            if($bjb){
                $token = Str::random(60);
                

                $new = Pasien::where('no_rm',$request->no_rm)->first();
                if(!$new){
                    $new = new Pasien();

                }
                $new->no_rm = @$bjb->mr_no;
                $new->nama = @$bjb->mr_name;
                $new->tmplahir = @$bjb->mr_tempat_lahir;
                $new->tgllahir = @$bjb->mr_tgl_lahir;
                $new->kelamin = @$bjb->mr_jk;
                $new->golda = @$bjb->mr_gol_darah;
                $new->alamat = @$bjb->mr_alamat;
                $new->tgldaftar = @date('Y-m-d',strtotime($bjb->rec_created));
                $new->agama = @$bjb->agama;
                $new->nohp = @$bjb->telpon;
                $new->notlp = @$bjb->telpon;
                $new->negara = 'Indonesian';
                $new->pekerjaan = @$bjb->pekerjaan;
                $new->pendidikan = @$bjb->pendidikan;
                $new->nama_keluarga = @$bjb->nama_penanggung;
                $new->nama_ayah = @$bjb->nama_ayah;
                $new->ibu_kandung = @$bjb->nama_ibu;
                $new->nik = @$bjb->nik;
                $new->no_jkn = @$bjb->no_penjamin;
                $new->no_jaminan = @$bjb->no_penjamin;
                // $new->nama_penjamin = @$bjb->nama_penjamin;
                $new->rt = @$bjb->rt;
                $new->rw = @$bjb->rw;
                $new->province_id = @$bjb->propinsi;
                $new->regency_id = @$bjb->kabupaten;
                $new->district_id = @$bjb->kecamatan;
                $new->village_id = @$bjb->kelurahan;
                $new->user_create = 'sinkron_bjb';
                $new->mr_id = @$bjb->mr_id;
                $new->api_token = $token;
                $new->save();
                // dd();
    
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        "no_rm" => @$new->no_rm,
                        "nik_ktp" => @$new->nik,
                        "no_jkn" => @$new->no_jkn,
                        "jenis_jkn" => @$new->jkn,
                        "name" => @$new->nama,
                        "tempat_lahir" => @$new->tmplahir,
                        "tanggal_lahir" => @$new->tgllahir,
                        "no_handphone" => @$new->nohp,
                        "telepon" => @$new->notlp,
                        "jenis_kelamin" => @$new->kelamin,
                        "alamat" => @$new->alamat,
                        "provinsi" => @$new->province_id ? @baca_propinsi(@$new->province_id) :'',
                        "kabupaten" => @$new->province_id ? @baca_kabupaten(@$new->regency_id):'',
                        "kecamatan" => @$new->province_id ? @baca_kecamatan(@$new->district_id):'',
                        "kelurahan" => @$new->province_id ? @baca_kelurahan(@$new->village_id):'',
                    ],
                    'token' => $token
                ]);
            }
            return response()->json([
                'status' => 'error',
                'data' => 'Nomor Rekam Medis atau Tanggal Lahir Tidak Sesuai'
            ]);
        }
        // dd( $user );
        // Get the token
        // $token = auth('pasien-api')->fromUser($user);
        // $token = auth('pasien-api')->attempt($credentials);
        // return $token;
        // $token = auth('pasien-api')->loginUsingId('74631');
        // dd( $token );
        // return $this->respondWithToken($token);
        // return response()->json(compact('token'));
    }

    public function forgetPassword( Request $request)
    {
        $user = pasien::where('nik', $request->nik)->where('tgllahir', $request->tgllahir)->first();
        if( $user ){
            return response()->json([
                'status' => 'success',
                'data' => [
                    "no_rm" => $user->no_rm,
                    "nik_ktp" => $user->nik,
                    "no_jkn" => $user->no_jkn,
                    "jenis_jkn" => $user->jkn,
                    "name" => $user->nama,
                    "tempat_lahir" => $user->tmplahir,
                    "tanggal_lahir" => $user->tgllahir,
                    "telepon" => $user->no_hp,
                    "jenis_kelamin" => $user->kelamin,
                    "alamat" => $user->alamat,
                    "provinsi" => baca_propinsi($user->province_id),
                    "kabupaten" => baca_kabupaten($user->regency_id),
                    "kecamatan" => baca_kecamatan($user->district_id),
                    "kelurahan" => baca_kelurahan($user->village_id),
                ]
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'data' => 'NIK atau Tanggal Lahir Tidak Sesuai'
            ]);
        }
    }

    // login pasien baru
    public function loginNew(Request $request)
    {
        $rules = [
            'nik'       => 'required|numeric',
            'tgllahir'  => 'required|date',
        ];
 
        $validator = Validator::make($request->all(), $rules);
         
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'data' => 'Nomor identitas tidak sesuai dengan format'
            ]);
        }

        $new_no_rm = date('Yn').sprintf("%03s", 0);
        $cek_norm = RegistrasiDummy::where('no_rm','like',date('Yn') . '%')->where('jenis_registrasi','pasien_baru')->count();
        $cek_final_rm = $cek_norm;

        if($cek_final_rm > 0){
            $norm = date('Yn').sprintf("%03s", $cek_final_rm+1);
        }else{
            $norm = $new_no_rm +1;
        }

        $cek = Pasien::where('nik',$request->nik)->where('tgllahir',$request->tgllahir)->first();

        if(!$cek){
            $user = RegistrasiDummy::firstOrCreate([
                'nik' => $request->nik,
                'jenis_registrasi' => 'pasien_baru',
            ], [
                'tgllahir' => $request->tgllahir,
                'no_rm' => $norm,
                // 'nama' => @$request->nama,
                // 'tmplahir' => @$request->tmplahir,
                // 'kelamin' => @$request->kelamin,
                // 'alamat' => @$request->alamat,
                // 'no_hp' => @$request->no_hp,
                // 'jkn' => @$request->jkn,
            ]);

        }else{
            $user = $cek;
        }

        if( $user ){
            $token = Str::random(60);
            $user->forceFill([
                'api_token' => $token,
            ])->save();
          
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    "no_identitas" => $user->nik,
                    "no_rm" => $user->no_rm,
                    "nama" => $user->nama,
                    "tmplahir" => $user->tmplahir,
                    "tgllahir" => $user->tgllahir,
                    "kelamin" => $user->kelamin,
                    "alamat" => $user->alamat,
                    "no_hp" => $user->no_hp,
                    "jkn" => $user->njkn,
                ],
                'token' => $token
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'data' => 'Nomor Identitas atau Tanggal Lahir Tidak Sesuai'
            ]);
        }
    }
}
