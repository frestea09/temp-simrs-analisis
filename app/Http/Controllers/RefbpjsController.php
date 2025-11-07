<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BpjsProv;
use App\BpjsKab;
use App\BpjsKec;

class RefbpjsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function propinsi($val = '')
    {
        header('Content-Type: application/json');

        $ID = config('app.sep_id');
        date_default_timezone_set('UTC');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

        $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/propinsi";

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
        echo $json;
        die;
    }
    public function importprovinsi($val = '')
    {
        header('Content-Type: application/json');
        $ID = config('app.sep_id');
        date_default_timezone_set('UTC');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

        // $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/kabupaten/propinsi/" . $val;
        // $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/kecamatan/kabupaten/" . $val;
        $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/propinsi";

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
        $prov = $sml['response']['list'];

        foreach ($prov as $p) {
            $cek = BpjsProv::where('kode', $p['kode'])->count();
            if ($cek == 0) {
                $prop = new BpjsProv();
                $prop->kode = $p['kode'];
                $prop->propinsi = $p['nama'];
                $prop->save();
            }
        }
    }
    public function importkabupaten($val = '')
    {
        $prov = BpjsProv::all();
        foreach ($prov as $p) {
            header('Content-Type: application/json');
            $ID = config('app.sep_id');
            date_default_timezone_set('UTC');
            $t = time();
            $data = "$ID&$t";
            $secretKey = config('app.sep_key');
            $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

            $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/kabupaten/propinsi/" . $p->kode;
            // $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/kecamatan/kabupaten/" . $val;
            // $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/propinsi";

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
            $kab = $sml['response']['list'];
            // return $kab;die;
            if ($kab != null) {
                foreach ($kab as $k) {
                    $cek = BpjsKab::where(['kode' => $k['kode'], 'prov_kode' => $p->kode])->count();
                    if ($cek == 0) {
                        $kabu = new BpjsKab();
                        $kabu->prov_kode = $p->kode;
                        $kabu->kode = $k['kode'];
                        $kabu->kabupaten = $k['nama'];
                        $kabu->save();
                    }
                }
            }
        }
    }
    public function importkecamatan($val = '')
    {
        $kab = BpjsKab::all();
        foreach ($kab as $k) {
            header('Content-Type: application/json');
            $ID = config('app.sep_id');
            date_default_timezone_set('UTC');
            $t = time();
            $data = "$ID&$t";
            $secretKey = config('app.sep_key');
            $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

            // $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/kabupaten/propinsi/" . $p->kode;
            $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/kecamatan/kabupaten/" . $k->kode;
            // $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/propinsi";

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
            $kec = $sml['response']['list'];
            // return $kab;die;
            if ($kec != null) {
                foreach ($kec as $kc) {
                    $cek = BpjsKec::where(['kode' => $kc['kode'], 'prov_kode' => $k->prov_kode, 'kab_kode' => $k->kode])->count();
                    if ($cek == 0) {
                        $kabu = new BpjsKec();
                        $kabu->prov_kode = $k->prov_kode;
                        $kabu->kab_kode = $k->kode;
                        $kabu->kode = $kc['kode'];
                        $kabu->kecamatan = $kc['nama'];
                        $kabu->save();
                    }
                }
            }
        }
    }
    public function kabupaten($val = '')
    {
        header('Content-Type: application/json');

        $ID = config('app.sep_id');
        date_default_timezone_set('UTC');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

        $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/kabupaten/propinsi/" . $val;

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
        echo $json;
        die;
    }
    public function kecamatan($val = '')
    {
        header('Content-Type: application/json');

        $ID = config('app.sep_id');
        date_default_timezone_set('UTC');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

        // $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/kabupaten/propinsi/" . $val;
        // $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/kecamatan/kabupaten/" . $val;
        $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/kecamatan/kabupaten/" . $val;

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
        echo $json;
        die;
    }

    public function dokter($val = '')
    {
        header('Content-Type: application/json');

        $ID = config('app.sep_id');
        date_default_timezone_set('UTC');
        $t = time();
        $data = "$ID&$t";
        $secretKey = config('app.sep_key');
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

        $completeurl = "https://dvlp.bpjs-kesehatan.go.id/VClaim-rest/referensi/dokter/pelayanan/2/tglPelayanan/" . date('Y-m-d') . "/Spesialis/" . $val;

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
        echo $json;
        die;
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
