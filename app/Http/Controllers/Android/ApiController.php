<?php

namespace App\Http\Controllers\Android;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Android\android_manajemen;
use App\Android\android_content;
use App\Android\android_content_type;
use Modules\Bed\Entities\Bed;
use Modules\Kelas\Entities\Kelas;
use Modules\Config\Entities\Config;
// use Tymon\JWTAuth\Facades\JWTAuth; 
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Carabayar;
use App\Jadwaldokter;
use App\Fasilitas;
use Modules\Pegawai\Entities\Pegawai;
use App\RegistrasiDummy;
use Carbon\Carbon;
use App\Android\slider;
use App\Android\pasien;
use App\Android\pasien_android;

class ApiController extends Controller
{
    public function all_manajemen()
    {
        $data = android_manajemen::with(['anggota','anggota.agama:id,agama','anggota.jabatan'])->get();
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function show_page($type)
    {
        $type = android_content_type::where('type_slug', $type)->first();
        if( $type == null ) return response()->json(["status"=>"Type Not Found","data"=>null]);
        $query = android_content::where('type_id',$type->id);
        if( $type->type_slug == "berita" || $type->type_slug == "pelayanan" ) $data = $query->paginate(10);
        else $data = $query->first();
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function show_page_detail($id)
    {
        $data = android_content::findOrFail($id);
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function show_kamar()
    {
        $data = [];
        $kelas = Kelas::where('nama', '<>', '-')->take(12)->get();
        foreach($kelas as $key => $kl){
            $kamar = Bed::select('kamar_id')->where('virtual','N')->where('kelas_id', $kl->id)->distinct()->get();
            $data[$key]['kelas'] = $kl->nama;
            foreach($kamar as $i => $km){
                $total  = Bed::where('kelas_id', $kl->id)->where('kamar_id', $km->kamar_id)->where('virtual', 'N')->count();
                $isi    = Bed::where('kelas_id', $kl->id)->where('kamar_id', $km->kamar_id)->where('virtual', 'N')->where('reserved', 'Y')->count();
                $kosong = Bed::where('kelas_id', $kl->id)->where('kamar_id', $km->kamar_id)->where('virtual', 'N')->where('reserved', 'N')->count();

                $data[$key]['kamar'][$i] = [
                    'nama'  => baca_kamar($km->kamar_id),
                    'total' => $total,
                    'isi'   => $isi,
                    'kosong'=> $kosong,
                    "tgl_update" => date("Y-m-d H:i:s")
                ];
            }
        }
        // return $data;
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function about_us()
    {
        $data = Config::all();
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function visimisi()
    {
        $data = android_content::where('type_id',2)->first();
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function syaratketentuan()
    {
        $data = android_content::where('type_id',5)->first();
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function petunjukpenggunaan()
    {
        $data = android_content::where('type_id',4)->first();
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function poliklinik()
    {
        $data = Poli::where('politype', 'J')->select('nama', 'id','bpjs','kuota_online')->get();
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function caraBayar()
    {
        $data = Carabayar::select('carabayar', 'id')->get();
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function dokter($poli_id)
    {
		$pol = Poli::where('id',$poli_id)->first();
		$dokter_id = [];

		// foreach($pol->dokter_id as $pol) {
        //     $dokter_id[] = $pol;
        // }

		$dokter_id = explode(",",$pol->dokter_id);
		$dokter = Pegawai::whereIn('id',$dokter_id)->get();
		if(count($dokter) == 0){
			$dokter = Pegawai::where('kategori_pegawai',1)->get();
		}	
        // $data = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
        return response()->json([
            "status" => "success",
            'poli'=>$pol,
            "data" => $dokter
        ]);
    }

    public function fasilitas()
    {
        $data = Fasilitas::find(1);
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function jadwalDokter(){
        $data = Jadwaldokter::all();
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function slider()
    {
        $data = slider::all();
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }

    public function cekKuota($tgl, $poli)
    {
        $dipesan = RegistrasiDummy::whereDate('tglperiksa', $tgl)->where('kode_poli',$poli)->count();
        $dt_poli = Poli::where('bpjs',$poli)->first();
        // dd($dt_poli);
        return response()->json([
            "status" => "success",
            "data" => [
                "nama_poli" => $dt_poli->nama,
                "dipesan" => $dipesan,
                "tersedia" => $dt_poli->kuota_online - $dipesan,
                "total_kuota" => $dt_poli->kuota_online,
                "diperbarui" => date('d-m-Y h:i:s')
            ]
        ]);
    }

    public function daftarOnlineNew(Request $req){
        if ($req->header('Authorization')) {
            $myToken = explode('Bearer ',$req->header('Authorization'));
            $find = RegistrasiDummy::where('api_token',$myToken[1])->first();
            if( isset($find) ){

                
                $data = [
                    'no_rm' => $find->no_rm,
                    'nik' => ($req->nik == null) ? '-' : $req->nik,
                    'nama' => $req->nama,
                    'alamat' => $req->alamat,
                    'tgllahir' => $req->tgllahir,
                    'kelamin' => $req->gender,
                    'no_hp' => $req->hp,
                    'kode_cara_bayar' => $req->kode_cara_bayar,
                    'no_rujukan' => ($req->no_rujukan != '') ? $req->no_rujukan : '-',
                    'tglperiksa' => $req->tglperiksa,
                    'kode_poli' => $req->poli,
                    'kode_dokter' => $req->dokter,
                    'nomorkartu' => ($req->no_kartu != '') ? $req->no_kartu : '-',
                    ];
                    $check = RegistrasiDummy::where(['no_rm' => $req->no_rm, 'tglperiksa' => $req->tglperiksa])->count();
                    
                    // cek apakah pasienbaru sudah ada ditabel registrasi_dummy
                    // $check_pasien_baru = RegistrasiDummy::where(['no_rm' => $req->no_rm,'jenis_registrasi'=> 'pasien_baru'])->count();
                    // if(!$check_pasien_baru){ //jika belum makan buat baru
                    //     $data['jenis_registrasi'] = 'pasien_baru';
                    //     $data['jenisdaftar'] = "android";
                    //     $new_pasien = RegistrasiDummy::create($data);
                    // }
                    // nomor antrian versi faiq
                    $cekantrian = RegistrasiDummy::where('tglperiksa',$data['tglperiksa'])->where('kode_poli', $req->poli)->count();
                    $hitung =  $cekantrian+1;
                    $tanggalantri =  date("dmY", strtotime($data['tglperiksa']));
                    $nomorantri = $tanggalantri.''.$req->poli.''.$hitung;

                    if ($cekantrian == 0) {
                        $buka_poli = Poli::where('bpjs',$data['kode_poli'])->first();
                        $convertestimasi = $data['tglperiksa'].' '.$buka_poli->buka;
                      } else {
                        # code...
                        $cek_estimasi = RegistrasiDummy::where('tglperiksa',$data['tglperiksa'])->where('kode_poli', $data['kode_poli'])->latest('id')->first();
                        $estimasi = strtotime("+15 minutes", strtotime($cek_estimasi->estimasidilayani));
                        $convertestimasi = date("Y-m-d H:i:s", $estimasi);
                        // return $estimasi*1000; die;
                      }
                    // end

                    if($check == 0){
                        $dt_poli = Poli::where('bpjs',$data['kode_poli'])->first();
                        if( !$dt_poli ){
                            return response()->json(['result' => 'gagal', 'info' => 'Kode Poli tidak ditemukan']);
                        }
                        if($dt_poli->praktik == 'T'){
                            return response()->json(['result' => 'gagal', 'info' => 'Poli Sedang Tutup']);
                        }
                        $dipesan = RegistrasiDummy::whereDate('tglperiksa', $data['tglperiksa'])->where('kode_poli',$data['kode_poli'])->count();
                        // if( $dipesan < $dt_poli->kuota_online ){ // jika masih ada kuota per poli
                            $id = RegistrasiDummy::where('nomorantrian', 'LIKE', date('Ymd', strtotime($req->tgl)) . '%')->count();
                            $data['nomorantrian']     = $nomorantri;
                            $data['angkaantrian']     = $hitung;
                            $data['jenisdaftar']      = "android";
                            $data['jenis_registrasi'] = "antrian";
                            $data['estimasidilayani'] = $convertestimasi;
                            // dd($data);
                            $result = RegistrasiDummy::create($data);
                            return response()->json(['result' => 'sukses', 'data' => $result]);
                        // }else{ // kuota habis
                        //     return response()->json(['result' => 'gagal', 'info' => 'Maaf Kuota Poli '.$dt_poli->nama.' sudah habis']);
                        // }
                    }else{
                        return response()->json(['result' => 'gagal', 'info' => 'Anda sudah mendaftar di tanggal periksa ini']);
                    }
            }else{
                return response()->json([
                    "status" => "gagal",
                    "data" => "token tidak valid"
                ]);
            }
        }else{
            return response()->json([
                "status" => "gagal",
                "data" => "token tidak dimasukkan"
            ]);
        }
    }

    public function daftarOnline(Request $req){
        if ($req->header('Authorization')) {
            $myToken = explode('Bearer ',$req->header('Authorization'));
            $find = pasien::where('no_rm',$req->no_rm)->first();
            // dd($req->all());
            if( isset($find) ){

                
                $data = [
                    'no_rm' => $find->no_rm,
                    'nik' => ($find->nik == null) ? '-' : $find->nik,
                    'nama' => $find->nama,
                    'alamat' => $find->alamat,
                    'tgllahir' => $find->tgllahir,
                    'kelamin' => $find->kelamin,
                    'no_hp' => $find->nohp,
                    'kode_cara_bayar' => $req->kode_cara_bayar,
                    'no_rujukan' => ($req->no_rujukan != '') ? $req->no_rujukan : '-',
                    'tglperiksa' => $req->tglperiksa,
                    'kode_poli' => $req->poli,
                    'kode_dokter' => $req->dokter,
                    'nomorkartu' => @$find->no_jkn,
                    ];

                    $check = RegistrasiDummy::where(['no_rm' => $req->no_rm, 'tglperiksa' => $req->tglperiksa])->count();
                    
                    // cek apakah pasienbaru sudah ada ditabel registrasi_dummy
                    // $check_pasien_baru = RegistrasiDummy::where(['no_rm' => $req->no_rm,'jenis_registrasi'=> 'pasien_baru'])->count();
                    // if(!$check_pasien_baru){ //jika belum makan buat baru
                    //     $data['jenis_registrasi'] = 'pasien_baru';
                    //     $data['jenisdaftar'] = "android";
                    //     $new_pasien = RegistrasiDummy::create($data);
                    // }
                    // nomor antrian versi faiq
                    $cekantrian = RegistrasiDummy::where('tglperiksa',$data['tglperiksa'])->where('kode_poli', $req->poli)->count();
                    $hitung =  $cekantrian+1;
                    $tanggalantri =  date("dmY", strtotime($data['tglperiksa']));
                    $nomorantri = $tanggalantri.''.$req->poli.''.$hitung;

                    // dd($data);

                    if ($cekantrian == 0) {
                        $buka_poli = Poli::where('bpjs',$data['kode_poli'])->first();
                        // dd($buka_poli);
                        $convertestimasi = $data['tglperiksa'].' '.$buka_poli->buka;

                      } else {
                        # code...
                        $cek_estimasi = RegistrasiDummy::where('tglperiksa',$data['tglperiksa'])->where('kode_poli', $data['kode_poli'])->latest('id')->first();
                        $estimasi = strtotime("+15 minutes", strtotime($cek_estimasi->estimasidilayani));
                        $convertestimasi = date("Y-m-d H:i:s", $estimasi);
                        // return $estimasi*1000; die;
                      }
                    // end

                    if($check == 0){
                        $dt_poli = Poli::where('bpjs',$data['kode_poli'])->first();
                        
                        if( !$dt_poli ){
                            return response()->json(['result' => 'gagal', 'info' => 'Kode Poli tidak ditemukan']);
                        }
                        if($dt_poli->praktik == 'T'){
                            return response()->json(['result' => 'gagal', 'info' => 'Poli Sedang Tutup']);
                        }
                        $dipesan = RegistrasiDummy::whereDate('tglperiksa', $data['tglperiksa'])->where('kode_poli',$data['kode_poli'])->count();
                        // if( $dipesan < $dt_poli->kuota_online ){ // jika masih ada kuota per poli
                            $id = RegistrasiDummy::where('nomorantrian', 'LIKE', date('Ymd', strtotime($req->tgl)) . '%')->count();
                            $data['nomorantrian']     = $nomorantri;
                            $data['angkaantrian']     = $hitung;
                            $data['jenisdaftar']      = "android";
                            $data['jenis_registrasi'] = "antrian";
                            $data['estimasidilayani'] = $convertestimasi;
                            // dd($data);
                            $result = RegistrasiDummy::create($data);
                            return response()->json(['result' => 'sukses', 'data' => $result]);
                        // }else{ // kuota habis
                        //     return response()->json(['result' => 'gagal', 'info' => 'Maaf Kuota Poli '.$dt_poli->nama.' sudah habis']);
                        // }
                    }else{
                        return response()->json(['result' => 'gagal', 'info' => 'Anda sudah mendaftar di tanggal periksa ini']);
                    }
            }else{
                return response()->json([
                    "status" => "gagal",
                    "data" => "rm pasien lama tidak ditemukan"
                ]);
            }
        }else{
            return response()->json([
                "status" => "gagal",
                "data" => "token tidak dimasukkan"
            ]);
        }
    }

    public function getUser(Request $request)
    {
        if ($request->header('Authorization')) {
            $myToken = explode('Bearer ',$request->header('Authorization'));
            $find = pasien_android::where('api_token',$myToken[1])->first();
            if( isset($find) ){
                $data["provinsi"] = baca_propinsi($find->province_id);
                $data["kabupaten"] = baca_kabupaten($find->regency_id);
                $data["kecamatan"] = baca_kecamatan($find->district_id);
                $data["kelurahan"] = baca_kelurahan($find->village_id);
                return response()->json([
                    "status" => "success",
                    "data" => $data
                ]);
            }else{
                return response()->json([
                    "status" => "gagal",
                    "data" => "token tidak valid"
                ]);
            }   
        }else{
            return response()->json([
                "status" => "gagal",
                "data" => "token tidak dimasukkan"
            ]);
        }
    }



    public function cekPendaftaran(Request $request)
    {
        if ($request->header('Authorization')) {
            $myToken = explode('Bearer ',$request->header('Authorization'));

            $user = pasien::where('api_token',$myToken[1])->first();
            // dd($user);
            if( isset($user) ){
                // dd($user);
                $data = RegistrasiDummy::where('no_rm',$user->no_rm)->with('poli','dokter','dokters')->orderBy('id','DESC')->limit(5)->get();
                return response()->json([
                    "status" => "success",
                    "data" => $data
                ]);
            }else{      
                return response()->json([
                    "status" => "gagal",
                    "data" => "token tidak valid"
                ]);
            }
        }else{
            return response()->json([
                "status" => "gagal",
                "data" => "token tidak dimasukkan"
            ]);
        }
    }
    public function cekPendaftaranDetail(Request $request)
    {
        if ($request->header('Authorization')) {
            $myToken = explode('Bearer ',$request->header('Authorization'));
            $user = pasien::where('api_token',$myToken[1])->first();
            if( isset($user) ){
                // dd($user);
                $data = RegistrasiDummy::where('id', $request->id_registrasi)->with('poli','dokter')->first();
                return response()->json([
                    "status" => "success",
                    "data" => $data
                ]);
            }else{      
                return response()->json([
                    "status" => "gagal",
                    "data" => "token tidak valid"
                ]);
            }
        }else{
            return response()->json([
                "status" => "gagal",
                "data" => "token tidak dimasukkan"
            ]);
        }
    }

    public function cekPendaftaranNew(Request $request)
    {
        if ($request->header('Authorization')) {
            $myToken = explode('Bearer ',$request->header('Authorization'));
            $user = RegistrasiDummy::where('api_token',$myToken[1])->first();
            if( isset($user) ){
                // dd($user);
                $data = RegistrasiDummy::where('no_rm',$user->no_rm)->whereNotNull('nomorantrian')->with('poli','dokter','dokters')->orderBy('id','DESC')->limit(5)->get();
                return response()->json([
                    "status" => "success",
                    "data" => $data
                ]);
            }else{      
                return response()->json([
                    "status" => "gagal",
                    "data" => "token tidak valid"
                ]);
            }
        }else{
            return response()->json([
                "status" => "gagal",
                "data" => "token tidak dimasukkan"
            ]);
        }
    }
    public function cekPendaftaranDetailNew(Request $request)
    {
        if ($request->header('Authorization')) {
            $myToken = explode('Bearer ',$request->header('Authorization'));
            $user = pasien_android::where('api_token',$myToken[1])->first();
            if( isset($user) ){
                // dd($user);
                $data = RegistrasiDummy::where('id', $request->id_registrasi)->with('poli','dokter')->first();
                return response()->json([
                    "status" => "success",
                    "data" => $data
                ]);
            }else{      
                return response()->json([
                    "status" => "gagal",
                    "data" => "token tidak valid"
                ]);
            }
        }else{
            return response()->json([
                "status" => "gagal",
                "data" => "token tidak dimasukkan"
            ]);
        }
    }

    



    public function cekUpdate()
    {
        $data = [
            "ios" => [
                "latest" => "1.0.1",
                "minimum" => "1.0.1",
                "url" => "https://play.google.com/store/apps/details?id=com.pekade.rsustmadyang",
                "enabled" => true,
            ],
            "android" => [
                "latest" => "1.0.1",
                "minimum" => "1.0.1",
                "url" => "https://play.google.com/store/apps/details?id=com.pekade.rsustmadyang",
                "enabled" => true,
            ]
        ];
        return response()->json($data);
    }

    public function pengumuman()
    {
        $data = [
            "status" => true,
            "data" => [
                "content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam purus enim, dignissim eget ipsum nec, semper molestie felis. Nulla facilisi. Nullam tempor consectetur est vitae varius. Nullam malesuada turpis a lectus ullamcorper, ac viverra lacus fringilla. Sed sollicitudin bibendum tortor, eu pretium lacus. Vivamus non sem ut nunc semper maximus. Aliquam a ultrices nisi, a finibus metus. Integer tincidunt sed tellus sed ornare. Curabitur dapibus lectus neque, sit amet dapibus metus vestibulum ac.",
            ],
        ];
        return response()->json($data);
    }

     // V2
     function rujukan($nomor){
		list($ID, $t, $signature) = $this->HashBPJS();
			
		$completeurl = config('app.sep_url_web_service') . "/Rujukan/". $nomor;
		$response = $this->xrequest($completeurl, $signature, $ID, $t); 
		if($response =='Authentication failed'){
			$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
			return response()->json(json_encode($json,JSON_PRETTY_PRINT));
		}
		$array[] = json_decode($response, true);
		$stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array[0]['response']);
		$array[] = json_decode($this->decompress($stringEncrypt),true);

		$sml = json_encode($array,JSON_PRETTY_PRINT); 
		$json = json_decode($sml,true);
		return $json;
	}

    
    
    function jadwalDokterHfis(Request $request) {
        $ID = config('app.consid_antrean');
        date_default_timezone_set('Asia/Jakarta');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.secretkey_antrean');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
        // dd($request->all());
        
        // jika mengambil data dari reservasi
        if(isset($request['reservasi'])){
            if(!$request['tgl']){
                $request['tgl'] = date('Y-m-d');
            }
            $poli = Poli::find($request['poli']);
            $request['poli'] = $poli->bpjs;
        }else{
            $request['tgl'] = date('Y-m-d');
        }
        $completeurl =config('app.antrean_url_web_service')."jadwaldokter/kodepoli/" . $request['poli'] . "/tanggal/" . $request['tgl'];
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

        $json = json_decode($sml,true);
        
        return response()->json($json);
    }

    function stringDecrypt($key, $string){
            
      
        $encrypt_method = 'AES-256-CBC';

        // hash
        $key_hash = hex2bin(hash('sha256', $key));
  
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
  
        return $output;
    }

    // function lzstring decompress 
    // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
    function decompress($string){
        // dd($string);
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);

    } 
    function HashBPJS() {
		$ID = config('app.sep_id');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key'); 

		date_default_timezone_set('Asia/Jakarta');
		$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
		$signature = hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true);
		$encodedSignature = base64_encode($signature);
		// $encodedSignature = \LZCompressor\LZString::compressToBase64($signature);;
		return array($ID, $t, $encodedSignature);
	}

	// SUDAH V2
	function xrequest($url, $signature, $ID, $t) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		$headers = array();
		$headers[] = "Accept: application/json";
		$headers[] = "Content-Type: application/json";
		$headers[] = "X-Cons-Id:" . $ID;
		$headers[] = "X-Timestamp:" . $t;
		$headers[] = "X-Signature:" . $signature;
		$headers[] = "user_key:" . config('app.user_key');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);

		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			$message = 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return $response;
	}
}
