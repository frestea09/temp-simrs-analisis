<?php

namespace App\Http\Controllers;

use App\Kelompokkelas;
use App\BedLog;
use Modules\Kamar\Entities\Kamar;
use Modules\Kelas\Entities\Kelas;
use Modules\Bed\Entities\Bed;
use Illuminate\Http\Request;
use Auth;
use Activity;
use Flashy;

class AplicareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');


        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/read/".config('app.sep_ppkLayanan')."/1/1000";

        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'Content-Type: application/json; charset=utf-8',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_HTTPGET, 1);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        // $json = json_encode($sml);
        // dd($sml);
        
        $data = [];
        foreach ($sml['response']['list'] as $d){
            $data[] = $d;
        }

        // dd($data);

        return view('aplicare.index', compact('data'))->with('no',1);
    }

    public function readbed()
    {
        // header('Content-Type: application/json');

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');


        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/read/".config('app.sep_ppkLayanan')."/1/1000";

        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'Content-Type: application/json; charset=utf-8',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_HTTPGET, 1);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        
        $data = [];
        foreach ($sml['response']['list'] as $d){
            $data[] = $d;
        }
        // dd("A");
        echo '<pre>',print_r($data,1),'</pre>';
        // $str="<pre>".print_r($data)."</pre>";
        // print_r
        // return $str;
        // $data = $sml['response']['list'];
        // foreach ($data as $d) {
        // 	$kr = $d['koderuang'];
        // 	$kl = $d['kodekelas'];
        // }

        // header('location: deleteBed.php?kodekelas=' . $kl . '&koderuang=' . $kr . '');
    }
    public function kelas()
    {
        // header('Content-Type: application/json');

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');


        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/ref/kelas";

        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'Content-Type: application/json; charset=utf-8',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_HTTPGET, 1);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        
        $data = [];
        foreach ($sml['response']['list'] as $d){
            $data[] = $d;
        }
        dd($data);

        // $data = $sml['response']['list'];
        // foreach ($data as $d) {
        // 	$kr = $d['koderuang'];
        // 	$kl = $d['kodekelas'];
        // }

        // header('location: deleteBed.php?kodekelas=' . $kl . '&koderuang=' . $kr . '');
    }

    public function deleteBed($kodekelas,$koderuang)
    {
        // header('Content-Type: application/json');

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');

        $request = '{ "kodekelas":"' . $kodekelas . '","koderuang":"' . $koderuang . '"}';
        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/delete/".config('app.sep_ppkLayanan');
        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'Content-Type: application/json',
        );
        // dd($request);
        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        $user = Auth::user();
        Activity::log('User ' . $user->name . ' Menghapus Kamar '. $koderuang . ' Dari BPJS');
        dd($json);

        // $data = $sml['response']['list'];
        // foreach ($data as $d) {
        // 	$kr = $d['koderuang'];
        // 	$kl = $d['kodekelas'];
        // }

        // header('location: deleteBed.php?kodekelas=' . $kl . '&koderuang=' . $kr . '');
    }

    public function createBedIccu()
    {
        // header('Content-Type: application/json');

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');
        //KAMAR MELATI
        
        $kapasitas_melati = Bed::where('kamar_id',45)->count();
        $tersedia_melati = Bed::where('kamar_id',45)->where('reserved','N')->count();

        $no = 1; 

        $request = '{
            "kodekelas":"HCU",
            "koderuang":"R045",
            "namaruang":"Kelas HCU",
            "kapasitas":"'.$kapasitas_melati.'",
            "tersedia":"'.$tersedia_melati.'",
            "tersediapria":"0",
            "tersediawanita":"0",
            "tersediapriawanita":"0"
      }';

        $completeurl = "http://api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/create/" . $kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
        'X-cons-id: ' . $ID,
        'X-timestamp: ' . $t,
        'X-signature: ' . $signature,
        'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br/> Kelas ICU : ' . $json;

        // $data = $sml['response']['list'];
        // foreach ($data as $d) {
        // 	$kr = $d['koderuang'];
        // 	$kl = $d['kodekelas'];
        // }

        // header('location: deleteBed.php?kodekelas=' . $kl . '&koderuang=' . $kr . '');
    }
    public function createBedBugen2()
    {
        // header('Content-Type: application/json');

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');
        //KAMAR MELATI
        
        $kapasitas_melati = Bed::where('kamar_id',16)->count();
        $tersedia_melati = Bed::where('kamar_id',16)->where('reserved','N')->count();

        $no = 1; 

        $request = '{
            "kodekelas":"ISO",
            "koderuang":"BGI02",
            "namaruang":"Isolasi Bougenville",
            "kapasitas":"'.$kapasitas_melati.'",
            "tersedia":"'.$tersedia_melati.'",
            "tersediapria":"0",
            "tersediawanita":"0",
            "tersediapriawanita":"0"
      }';

        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/create/" . $kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
        'X-cons-id: ' . $ID,
        'X-timestamp: ' . $t,
        'X-signature: ' . $signature,
        'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br/> Kelas Isolasi Bougenville : ' . $json;

        // $data = $sml['response']['list'];
        // foreach ($data as $d) {
        // 	$kr = $d['koderuang'];
        // 	$kl = $d['kodekelas'];
        // }

        // header('location: deleteBed.php?kodekelas=' . $kl . '&koderuang=' . $kr . '');
    }
    public function createBedAnyelir2()
    {
        // header('Content-Type: application/json');

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');
        //KAMAR MELATI
        
        $kapasitas_melati = Bed::where('kamar_id',12)->count();
        $tersedia_melati = Bed::where('kamar_id',12)->where('reserved','N')->count();

        $no = 1; 

        $request = '{
            "kodekelas":"ISO",
            "koderuang":"AYI02",
            "namaruang":"Isolasi Anyelir",
            "kapasitas":"'.$kapasitas_melati.'",
            "tersedia":"'.$tersedia_melati.'",
            "tersediapria":"0",
            "tersediawanita":"0",
            "tersediapriawanita":"0"
      }';

        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/create/" . $kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
        'X-cons-id: ' . $ID,
        'X-timestamp: ' . $t,
        'X-signature: ' . $signature,
        'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br/> Kelas Isolasi Anyelir : ' . $json;

        // $data = $sml['response']['list'];
        // foreach ($data as $d) {
        // 	$kr = $d['koderuang'];
        // 	$kl = $d['kodekelas'];
        // }

        // header('location: deleteBed.php?kodekelas=' . $kl . '&koderuang=' . $kr . '');
    }
    public function createBedMawar2()
    {
        // header('Content-Type: application/json');

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');
        //KAMAR MELATI
        
        $kapasitas_melati = Bed::where('kamar_id',21)->count();
        $tersedia_melati = Bed::where('kamar_id',21)->where('reserved','N')->count();

        $no = 1; 

        $request = '{
            "kodekelas":"ISO",
            "koderuang":"MWI03",
            "namaruang":"Mawar Isolasi",
            "kapasitas":"'.$kapasitas_melati.'",
            "tersedia":"'.$tersedia_melati.'",
            "tersediapria":"0",
            "tersediawanita":"0",
            "tersediapriawanita":"0"
      }';

        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/create/" . $kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
        'X-cons-id: ' . $ID,
        'X-timestamp: ' . $t,
        'X-signature: ' . $signature,
        'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br/> Kelas Mawar Isolasi : ' . $json;

        // $data = $sml['response']['list'];
        // foreach ($data as $d) {
        // 	$kr = $d['koderuang'];
        // 	$kl = $d['kodekelas'];
        // }

        // header('location: deleteBed.php?kodekelas=' . $kl . '&koderuang=' . $kr . '');
    }
    public function createBedWijaya()
    {
        // header('Content-Type: application/json');

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');
        //KAMAR MELATI
        
        $kapasitas_melati = Bed::where('kamar_id',24)->count();
        $tersedia_melati = Bed::where('kamar_id',24)->where('reserved','N')->count();

        $no = 1; 

        $request = '{
            "kodekelas":"ISO",
            "koderuang":"2I020",
            "namaruang":"Wijaya Kusumah",
            "kapasitas":"'.$kapasitas_melati.'",
            "tersedia":"'.$tersedia_melati.'",
            "tersediapria":"0",
            "tersediawanita":"0",
            "tersediapriawanita":"0"
      }';

        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/create/" . $kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
        'X-cons-id: ' . $ID,
        'X-timestamp: ' . $t,
        'X-signature: ' . $signature,
        'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br/> Kelas Wijaya Kusumah : ' . $json;

        // $data = $sml['response']['list'];
        // foreach ($data as $d) {
        // 	$kr = $d['koderuang'];
        // 	$kl = $d['kodekelas'];
        // }

        // header('location: deleteBed.php?kodekelas=' . $kl . '&koderuang=' . $kr . '');
    }
    public function createBedFlamboyan1()
    {
        // header('Content-Type: application/json');

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');
        //KAMAR MELATI
        
        $kapasitas_melati = Bed::where('kamar_id',19)->count();
        $tersedia_melati = Bed::where('kamar_id',19)->where('reserved','N')->count();

        $no = 1; 

        $request = '{
            "kodekelas":"ISO",
            "koderuang":"FLI01",
            "namaruang":"Flamboyan Isolasi",
            "kapasitas":"'.$kapasitas_melati.'",
            "tersedia":"'.$tersedia_melati.'",
            "tersediapria":"0",
            "tersediawanita":"0",
            "tersediapriawanita":"0"
      }';

        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/create/" . $kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
        'X-cons-id: ' . $ID,
        'X-timestamp: ' . $t,
        'X-signature: ' . $signature,
        'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br/> Kelas Flamboyan Isolasi : ' . $json;

        // $data = $sml['response']['list'];
        // foreach ($data as $d) {
        // 	$kr = $d['koderuang'];
        // 	$kl = $d['kodekelas'];
        // }

        // header('location: deleteBed.php?kodekelas=' . $kl . '&koderuang=' . $kr . '');
    }

    public function createBedCamelia2()
    {
        // header('Content-Type: application/json');

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');
        //KAMAR MELATI
        
        $kapasitas_melati = Bed::where('kamar_id',9)->count();
        $tersedia_melati = Bed::where('kamar_id',9)->where('reserved','N')->count();

        $no = 1; 

        $request = '{
            "kodekelas":"ISO",
            "koderuang":"CMI02",
            "namaruang":"Isolasi Camelia",
            "kapasitas":"'.$kapasitas_melati.'",
            "tersedia":"'.$tersedia_melati.'",
            "tersediapria":"0",
            "tersediawanita":"0",
            "tersediapriawanita":"0"
      }';

        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/create/" . $kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
        'X-cons-id: ' . $ID,
        'X-timestamp: ' . $t,
        'X-signature: ' . $signature,
        'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br/> Kelas Camelia ISOLASI 2 : ' . $json;

        // $data = $sml['response']['list'];
        // foreach ($data as $d) {
        // 	$kr = $d['koderuang'];
        // 	$kl = $d['kodekelas'];
        // }

        // header('location: deleteBed.php?kodekelas=' . $kl . '&koderuang=' . $kr . '');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelompokKamar = Kelompokkelas::with(['bed'])
            ->orderBy('kelompok')
            ->get();
        $kamar = Kamar::pluck('nama', 'id');

        return view('aplicare.create', compact('kelompokKamar', 'kamar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kelompok = Kelompokkelas::find($request->kelompok_id);
        $kamar = Kamar::where('kelompokkelas_id', $kelompok->id)->first();

        $kelas = Kelas::find($kamar->kelas_id);
        $kapasitas = Bed::where('kelompokkelas_id', $kelompok->id)->count();
        $tersedia = Bed::where('kelompokkelas_id',$kelompok->id)->where('reserved','N')->count();

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');

        $request = '{
            "kodekelas":"'.$kelas->kode.'",
            "koderuang":"'.$kelompok->general_code.'",
            "namaruang":"'.$kelompok->kelompok.'",
            "kapasitas":"'.$kapasitas.'",
            "tersedia":"'.$tersedia.'",
            "tersediapria":"0",
            "tersediawanita":"0",
            "tersediapriawanita":"0"
        }';

        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/create/" . $kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
        'X-cons-id: ' . $ID,
        'X-timestamp: ' . $t,
        'X-signature: ' . $signature,
        'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);

        // Flashy::success($sml['metadata']['message']);
        return redirect('aplicare-bpjs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        
        $kamar = Kamar::find($id);
        $kelas = Kelas::find($kamar->kelas_id);
        $kapasitas = Bed::where('kamar_id', $id)->count();
        $tersedia = Bed::where('kamar_id',$id)->where('reserved','N')->count();
        $no = 1;

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');

        $request = '{
			    "kodekelas":"'.$kelas->kode.'",
			    "koderuang":"'. $kamar->kode.'",
			    "namaruang":"' .$kamar->nama. '",
			    "kapasitas":"' . $kapasitas . '",
			    "tersedia":"' . $tersedia . '",
			    "tersediapria":"0",
			    "tersediawanita":"0",
			    "tersediapriawanita":"0"
		  }';
        //   dd($request);
        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/update/".$kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br /> Kamar: ' . $kamar->nama . '.' . $kelas->kode . ' 	: ' . $json;

    }

    // UPDATE KELAS APLICARE
    public function vip()
    {
        $id_kelas = 1 ;
        $kelas = Kelas::find(1);
        $kapasitas = Bed::where('kelas_id', $id_kelas)->count();
        $tersedia = Bed::where('kelas_id',$id_kelas)->where('reserved','N')->count();
        $no = 1;

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');

        $request = '{
			    "kodekelas":"'.$kelas->kode.'",
			    "koderuang":"VIP",
			    "namaruang":"VIP",
			    "kapasitas":"' . $kapasitas . '",
			    "tersedia":"' . $tersedia . '",
			    "tersediapria":"0",
			    "tersediawanita":"0",
			    "tersediapriawanita":"0"
		  }';
        dd($request);
        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/update/".$kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br /> Kelas: VIP : ' . $json;

    }

    public function kls1()
    {
        $id_kelas = 2;
        $koderuang = 'kls1';
        $namaruang = 'Kelas1';
        $kodekelas = 'KL1';

        $kelas = Kelas::find(1);
        $kapasitas = Bed::where('kelas_id', $id_kelas)->count();
        $tersedia = Bed::where('kelas_id',$id_kelas)->where('reserved','N')->count();
        $no = 1;

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');

        $request = '{
			    "kodekelas":"'.$kodekelas.'",
			    "koderuang":"'.$koderuang.'",
			    "namaruang":"'.$namaruang.'",
			    "kapasitas":"' . $kapasitas . '",
			    "tersedia":"' . $tersedia . '",
			    "tersediapria":"0",
			    "tersediawanita":"0",
			    "tersediapriawanita":"0"
		  }';
        //   dd($request);
        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/update/".$kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br /> Kelas: '.$namaruang.' : ' . $json;

    }

    public function kls2()
    {
        $id_kelas = 3;
        $koderuang = 'kls2';
        $namaruang = 'Kelas2';
        $kodekelas = 'KL2';

        $kelas = Kelas::find(1);
        $kapasitas = Bed::where('kelas_id', $id_kelas)->count();
        $tersedia = Bed::where('kelas_id',$id_kelas)->where('reserved','N')->count();
        $no = 1;

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');

        $request = '{
			    "kodekelas":"'.$kodekelas.'",
			    "koderuang":"'.$koderuang.'",
			    "namaruang":"'.$namaruang.'",
			    "kapasitas":"' . $kapasitas . '",
			    "tersedia":"' . $tersedia . '",
			    "tersediapria":"0",
			    "tersediawanita":"0",
			    "tersediapriawanita":"0"
		  }';
        //   dd($request);
        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/update/".$kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br /> Kelas: '.$namaruang.' : ' . $json;

    }
    public function kls3()
    {
        $id_kelas = 4;
        $koderuang = 'kls3';
        $namaruang = 'Kelas3';
        $kodekelas = 'KL3';

        $kelas = Kelas::find(1);
        $kapasitas = Bed::where('kelas_id', $id_kelas)->count();
        $tersedia = Bed::where('kelas_id',$id_kelas)->where('reserved','N')->count();
        $no = 1;

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');

        $request = '{
			    "kodekelas":"'.$kodekelas.'",
			    "koderuang":"'.$koderuang.'",
			    "namaruang":"'.$namaruang.'",
			    "kapasitas":"' . $kapasitas . '",
			    "tersedia":"' . $tersedia . '",
			    "tersediapria":"0",
			    "tersediawanita":"0",
			    "tersediapriawanita":"0"
		  }';
        //   dd($request);
        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/update/".$kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br /> Kelas: '.$namaruang.' : ' . $json;

    }
    public function hcu()
    {
        $id_kelas = 5;
        $koderuang = 'hcu';
        $namaruang = 'hcu';
        $kodekelas = 'HCU';

        $kelas = Kelas::find(1);
        $kapasitas = Bed::where('kelas_id', $id_kelas)->count();
        $tersedia = Bed::where('kelas_id',$id_kelas)->where('reserved','N')->count();
        $no = 1;

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');

        $request = '{
			    "kodekelas":"'.$kodekelas.'",
			    "koderuang":"'.$koderuang.'",
			    "namaruang":"'.$namaruang.'",
			    "kapasitas":"' . $kapasitas . '",
			    "tersedia":"' . $tersedia . '",
			    "tersediapria":"0",
			    "tersediawanita":"0",
			    "tersediapriawanita":"0"
		  }';
        //   dd($request);
        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/update/".$kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br /> Kelas: '.$namaruang.' : ' . $json;

    }
    public function iso()
    {
        $id_kelas = 6;
        $koderuang = 'Ruang Isol';
        $namaruang = 'Ruang isolasi';
        $kodekelas = 'ISO';

        $kelas = Kelas::find(1);
        $kapasitas = Bed::where('kelas_id', $id_kelas)->count();
        $tersedia = Bed::where('kelas_id',$id_kelas)->where('reserved','N')->count();
        $no = 1;

        $ID = config('app.sep_id');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        date_default_timezone_set('Asia/Jakarta');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
        $kode_ppk = config('app.sep_ppkLayanan');

        $request = '{
			    "kodekelas":"'.$kodekelas.'",
			    "koderuang":"'.$koderuang.'",
			    "namaruang":"'.$namaruang.'",
			    "kapasitas":"' . $kapasitas . '",
			    "tersedia":"' . $tersedia . '",
			    "tersediapria":"0",
			    "tersediawanita":"0",
			    "tersediapriawanita":"0"
		  }';
        //   dd($request);
        $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/update/".$kode_ppk;

        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'Content-Type: application/json',
        );

        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        curl_setopt($session, CURLOPT_POST, TRUE);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($session);
        $sml = json_decode($response, true);
        $json = json_encode($sml);
        // return $json;
        echo '<br /> Kelas: '.$namaruang.' : ' . $json;

    }
    // END UPDATE KELAS APLICARE
    public function updateAll()
    {
        $kamar = Kamar::all();
        $json_kamar = [];
        foreach( $kamar as $key_k => $val_k ) {
            // dd($val_k);
            $kelas = Kelas::find($val_k->kelas_id);
            // $kapasitas = Bed::where('kamar_id', $val_k->id)->where('virtual','N')->count();
            // $tersedia = Bed::where('kamar_id',$val_k->id)->where('virtual','N')->where('reserved','N')->count();
            $kelompok = Kelompokkelas::find($val_k->kelompokkelas_id);
            $kapasitas = Bed::where('kelompokkelas_id', $kelompok->id)->where('virtual','N')->count();
            $tersedia = Bed::where('kelompokkelas_id',$kelompok->id)->where('virtual','N')->where('reserved','N')->count();
            
            $ID = config('app.sep_id');
            $t = time();
            $data = "$ID&$t";
            $secretKey = config('app.sep_key');
            date_default_timezone_set('Asia/Jakarta');
            $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
            $kode_ppk = config('app.sep_ppkLayanan');
    
            // $request = '{
            //         "kodekelas":"'.$kelas->kode.'",
            //         "koderuang":"'. $val_k->kode.'",
            //         "namaruang":"' .$val_k->nama. '",
            //         "kapasitas":"' . $kapasitas . '",
            //         "tersedia":"' . $tersedia . '",
            //         "tersediapria":"0",
            //         "tersediawanita":"0",
            //         "tersediapriawanita":"0"
            //   }';
            $request = '{
                    "kodekelas":"'.$kelas->kode.'",
                    "koderuang":"'.$kelompok->general_code.'",
                    "namaruang":"'.$kelompok->kelompok.'",
                    "kapasitas":"' . $kapasitas . '",
                    "tersedia":"' . $tersedia . '",
                    "tersediapria":"0",
                    "tersediawanita":"0",
                    "tersediapriawanita":"0"
              }';
    
            $completeurl = "https://new-api.bpjs-kesehatan.go.id/aplicaresws/rest/bed/update/".$kode_ppk;
    
            $session = curl_init($completeurl);
            $arrheader = array(
                'X-cons-id: ' . $ID,
                'X-timestamp: ' . $t,
                'X-signature: ' . $signature,
                'Content-Type: application/json',
            );
    
            curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
            curl_setopt($session, CURLOPT_POSTFIELDS, $request);
            curl_setopt($session, CURLOPT_POST, TRUE);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
    
            $response = curl_exec($session);
            $sml = json_decode($response, true);
            $json = json_encode($sml);
            $json_kamar[] = json_decode($request,true);
            // return $json;
            echo '<br /> Kamar: ' . $val_k->nama . '.' . $kelas->kode . ' 	: ' . $json;
        }

        $log = new BedLog();
        $log->request = json_encode($json_kamar);
        $log->save();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
