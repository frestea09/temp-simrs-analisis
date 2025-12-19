<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use MercurySeries\Flashy\Flashy;
use Modules\Registrasi\Entities\Folio;
use Modules\Pegawai\Entities\Pegawai;
use App\Hasillab;
use App\Labsection;
use App\Labkategori;
use App\Laboratorium;
use App\Modality;
use App\Orderradiologi;
use App\PacsExpertise;
use App\RisLog;
use App\RisTindakan;
use Auth;
use DB;
use Modules\Tarif\Entities\Tarif;
use PDF;

class RisController extends Controller
{
  // get exam
  public function getexam($reg_id)
  {
    // dd($reg_id);
    $pasien_id = Registrasi::find($reg_id)->pasien_id;
    $data['reg'] = Registrasi::where('pasien_id', $pasien_id)->get();
    $data['no_rm'] = Pasien::find($pasien_id)->no_rm;
		$idregs = [];
		foreach ($data['reg'] as $r) {
			$idregs[] = $r->id;
		}
    $data['result'] = Orderradiologi::whereIn('registrasi_id', $idregs)->get();
    $data['rad']		= \App\RadiologiEkspertise::whereIn('registrasi_id', $idregs)->get();
    // dd($data['result'][0]['response']);
    // dd(json_decode($data['result'][0]['response'], true)['response']['examlist']);
    // dd($data['radiologi']);
    // dd($rm);
    // $token = $this->token();
    // // dd($token);
    // $json = [
    //   "mrid" => $rm
    // ];
    // $curl_observation = curl_init();
    // curl_setopt_array($curl_observation, array(
    //   CURLOPT_URL => config('app.url_ris') . '/trans/getexam',
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => '',
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 0,
    //   CURLOPT_FOLLOWLOCATION => true,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => 'POST',
    //   CURLOPT_POSTFIELDS => json_encode($json, JSON_PRETTY_PRINT),
    //   CURLOPT_HTTPHEADER => array(
    //     'Content-Type: application/json',
    //     'Authorization:' . $token
    //   ),
    // ));
    // $response_observasi = curl_exec($curl_observation);
    // if($rm == 814920){
    //   dd(json_decode($response_observasi));

    // }
    // $data['result'] = json_decode($response_observasi);
    // dd(base64_decode($data['result']->response[0]->expertisefile));
    // $file = 'testing.pdf';
		// file_put_contents($file, base64_decode($data['result']->response[0]->expertisefile));
    // $data['result'] = [
    //   'response' => [
        
    //     [
    //       "mrid"=> "761721",
    //     "assessementid"=> "AS23022100003",
    //     "modalityid"=> "CR",
    //     "examtypeid"=> "C005",
    //     "expertiseid"=> "EP23022100002",
    //     "expertisefile"=> "JVBERi0xLjQKMSAwIG9iago8PAovVGl0bGUgKP7/KQovQ3JlYXRvciAo/v8AdwBrAGgAdABtAGwAdABvAHAAZABmACAAMAAuADEAMgAuADEALgAyKQovUHJvZHVjZXIgKP7/AFEAdAAgADQALgA4AC4ANikKL0Ny",
    //     "imageurl"=> "http://10.1.103.156/zfp?mode=proxy&lights=on&titlebar=on#View&ris_exam_id=AS23022100003&un=openapi&pw=WcP%2ffTaaqz6JWxCZym5CaeSN64n2VYab0WqUk%2fmHI1UIZB9xp16xxr ▶",
    //     "attendingdoctorid"=> "t.shidki"
    //     ]
    //   ],
    //   "metaData"=>[
    //     "code"=> 200,
    //     "message"=> "Success"
    //   ]
    // ];
    // $data['result'] = json_decode($data['result'],true);
    // dd($data['result']);
    // dd(count($data['result']['response']));
    return view('ris.get_exam',$data)->with('no', 1);
  }

  public function getPdf($rm,$assessementid)
  {
    // dd($rm);
    $token = $this->token();
    // dd($token);
    $json = [
      "mrid" => $rm,
      "assessementid" => $assessementid,
    ];
    $curl_observation = curl_init();
    curl_setopt_array($curl_observation, array(
      CURLOPT_URL => config('app.url_ris') . '/trans/getexamonassessment',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($json, JSON_PRETTY_PRINT),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
        // 'Authorization:' . $token
      ),
    ));
    $response_observasi = curl_exec($curl_observation);
    // dd(json_decode($response_observasi));
    $data['result'] = json_decode($response_observasi);
    // return file_put_contents('rm.pdf', base64_decode($data['result']->response[0]->expertisefile));
    $folderPath = public_path('file_pacs/');
    $pacs = PacsExpertise::where('no_rm',$rm)->where('acc_number',$assessementid)->first();
    if(!$pacs){
      $image_base64 = base64_decode($data['result']->response->expertisefile);

      $filename = $rm.'_'.uniqid() . '.pdf';
      $file = $folderPath . $filename;
      file_put_contents($file, $image_base64);

      $pc = new PacsExpertise();
      $pc->no_rm = $rm;
      $pc->acc_number = $assessementid;
      $pc->expertise = $filename;
      $pc->save();

      $ex_file = $filename;
    }else{
      $ex_file = $pacs->expertise;
    }

    
    return redirect('/file_pacs/'.$ex_file);
    // dd(base64_decode($data['result']->response[0]->expertisefile));
    // $file = 'testing.pdf';
		// file_put_contents($file, base64_decode($data['result']->response[0]->expertisefile));
    // $data['result'] = [
    //   'response' => [
        
    //     [
    //       "mrid"=> "761721",
    //     "assessementid"=> "AS23022100003",
    //     "modalityid"=> "CR",
    //     "examtypeid"=> "C005",
    //     "expertiseid"=> "EP23022100002",
    //     "expertisefile"=> "JVBERi0xLjQKMSAwIG9iago8PAovVGl0bGUgKP7/KQovQ3JlYXRvciAo/v8AdwBrAGgAdABtAGwAdABvAHAAZABmACAAMAAuADEAMgAuADEALgAyKQovUHJvZHVjZXIgKP7/AFEAdAAgADQALgA4AC4ANikKL0Ny",
    //     "imageurl"=> "http://10.1.103.156/zfp?mode=proxy&lights=on&titlebar=on#View&ris_exam_id=AS23022100003&un=openapi&pw=WcP%2ffTaaqz6JWxCZym5CaeSN64n2VYab0WqUk%2fmHI1UIZB9xp16xxr ▶",
    //     "attendingdoctorid"=> "t.shidki"
    //     ]
    //   ],
    //   "metaData"=>[
    //     "code"=> 200,
    //     "message"=> "Success"
    //   ]
    // ];
    // $data['result'] = json_decode($data['result'],true);
    // dd($data['result']);
    // dd(count($data['result']['response']));
    // return view('ris.get_exam',$data)->with('no', 1);
    return response()->json(['sukses' => true, 'path_signature' => $file]);
  }
  public function getexamResp($rm)
  {
    // dd($rm);
    $token = $this->token();
    // dd($token);
    $json = [
      "mrid" => $rm
    ];
    $curl_observation = curl_init();
    curl_setopt_array($curl_observation, array(
      CURLOPT_URL => config('app.url_ris') . '/trans/getexam',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($json, JSON_PRETTY_PRINT),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
        // 'Authorization:' . $token
      ),
    ));
    $response_observasi = curl_exec($curl_observation);
    // dd(json_decode($response_observasi));
    $data['result'] = json_decode($response_observasi);
    // dd($data['result']);
    return view('ris.get_exam',$data)->with('no', 1);
  }

  // get exam on assessment
  public function getexamonassessment($rm, $assid)
  {
    $token = $this->token();
    $json = [
      "mrid" => $rm,
      "assessementid" => $assid
    ];
    $curl_observation = curl_init();
    curl_setopt_array($curl_observation, array(
      CURLOPT_URL => config('app.url_ris') . '/trans/getexamonassessment',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($json, JSON_PRETTY_PRINT),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
        // 'Authorization:' . $token
      ),
    ));
    $response_observasi = curl_exec($curl_observation);
    // dd(json_decode($response_observasi));
    $result = json_decode($response_observasi);
    dd($result);
  }


  // get exam waiting report
  public function getexamwaitingreport($rm, $assid)
  {
    $token = $this->token();
    $json = [
      "mrid" => $rm,
      "assessementid" => $assid
    ];
    $curl_observation = curl_init();
    curl_setopt_array($curl_observation, array(
      CURLOPT_URL => config('app.url_ris') . '/trans/getexamwaitingreport',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($json, JSON_PRETTY_PRINT),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
        // 'Authorization:' . $token
      ),
    ));
    $response_observasi = curl_exec($curl_observation);
    // dd(json_decode($response_observasi));
    $result = json_decode($response_observasi,true);
    $log = RisLog::where('assid',$assid)->first();
    if(!$log){
      $log = new RisLog();
    }
    $log->no_rm = @$rm;
    $log->assid = @$assid;
    $log->response = @$response_observasi;
    $log->save();
    // dd($result);
    if($result['metaData']['code'] == 200){
      if(!$result['response']['imageurl']){
        Flashy::error('Data RIS '.@$assid.' tidak tersedia');
        return redirect()->back();  
      }
      return redirect()->away($result['response']['imageurl']);
    }else{
      Flashy::error('Gagal melihat gambar RIS, hubungi SIMRS');
      return redirect()->back();
    }
  }

  // store klik submit data
  public function store(Request $request)
  {
    // dd($request->all());
    $reg = Registrasi::find($request->reg_id);
    // $token = $this->token();
    $token = '';
    // $token = '1';
    // dd($token);
    $this->registerpatient($token, $reg,$request->poli_id,$request);
    Flashy::success('Pendaftaran Radiologi Sukses');
    return redirect()->back();
     
  }

  // generate token RIS
  public function token()
  {

    return "";
    $curl_observation = curl_init();
    $json = [
      "Username" => config('app.username_ris'),
      "Password" => config('app.password_ris')
    ];

    curl_setopt_array($curl_observation, array(
      CURLOPT_URL => config('app.url_ris') . '/login/get_token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($json, JSON_PRETTY_PRINT),
      CURLOPT_HTTPHEADER => array(
        'x-api-key:  licaapi',
        'Content-Type: application/json'
      ),
    ));
    $response_observasi = curl_exec($curl_observation);
    // dd(json_decode($response_observasi));
    $token = json_decode($response_observasi);
    return $token->response->token;
  }

  // register pasien RIS
  public function registerpatient($token, $reg,$poli_id,$request)
  {
    
    $curl_observation = curl_init();
    $provinsi = @$reg->pasien->province_id ? @baca_propinsi(@$reg->pasien->province_id) : '-';
    $kokab = @$reg->pasien->regency_id ? @baca_kabupaten(@$reg->pasien->regency_id) : '-';

    $json = [
      // "regid" => $reg->reg_id,
      "regid" => date('dmyHis'),
      "patienttype" => baca_carabayar($reg->bayar),
      "patientpriority" => true,
      "regdate" => date('Y-m-d H:i:s', strtotime($reg->created_at)),
      "patientheader" => [
        "mrid" => $reg->pasien->no_rm,
        "nik" => $reg->pasien->nik,
        "firstname" => $reg->pasien->nama,
        "lastname" => "-",
        "initial" => $reg->pasien->nama,
        "dateofbirth" => $reg->pasien->tgllahir,
        "placeofbirth" => $reg->pasien->tmplahir,
        "sex" => $reg->pasien->kelamin,
        "phone" => $reg->pasien->nohp,
        "religion" => @$reg->pasien->agama ? @$reg->pasien->agama->agama : '-',
        "guarantor" => "-",
        "maritalstatus" => $reg->pasien->status_marital,
        "address" => $reg->pasien->alamat,
        "city" => @$kokab,
        "province" => @$provinsi,
        "postcode" => $reg->pasien->kode,
        "country" => "Indonesia"
      ],
      "patientdiagnosis" => $request['pemeriksaan'],
      "examlist" => []
    ];
    $examlist = [];
    // dd($request->exam);
    foreach($request->exam as $md){
      if(isset($md['examlist'])){
        // $examlisted = explode("__",$md['examlist']);
        $exam = Tarif::where('id',$md['examlist'])->first();
        // dd($modalti);
        $examlist[] = [
          "modalityid" => $exam->modality->modalityid,
          "modalityname" => $exam->modality->modalityname,
          "examtypeid" => $exam->id,
          "examtypename" => $exam->nama,
          "examdate" => date('Y-m-d H:i:s'),
          "examroom" => baca_poli($poli_id),
          "referrerphysician" => baca_dokter($reg->dokter_id),
          "requestingphysician" => $request['dokter_radiologi'] ? baca_dokter($request['dokter_radiologi']) :baca_dokter($reg->dokter_id),
          "departmentorder" => baca_poli($poli_id)
        ];

      }
    }
    $json['examlist'] = $examlist;
    // dd(json_encode($json, JSON_PRETTY_PRINT));
    // dd($examlist);
    // dd(json_encode($json, JSON_PRETTY_PRINT));

    curl_setopt_array($curl_observation, array(
      CURLOPT_URL => config('app.url_ris') . '/trans/registerpatient',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($json, JSON_PRETTY_PRINT),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
        // 'Authorization:' . $token
      ),
    ));
    $response_observasi = curl_exec($curl_observation);
    
    $res = json_decode(@$response_observasi);
    if(@$res->metaData->code == 200){


      $lab = new Orderradiologi();
      $lab->jenis = @baca_jenis_unit($request['unit']);
      $lab->registrasi_id = @$request['reg_id'];
      $lab->json = json_encode($json);
      $lab->response = @$response_observasi;
      $lab->source = 'RIS';
      $lab->pemeriksaan = @$request['pemeriksaan'];
      $lab->poli_id = @$request['poli_id'];
      $lab->user_id = Auth::user()->id;
      $lab->save();

      foreach($request->exam as $md){
        if(isset($md['examlist'])){
          
          $tarif = Tarif::find($md['examlist']);
          if ($request['cyto'] != null) {
            $cyto = $tarif->total / 2;
      
          } else {
            $cyto = 0;
          }
          $request['jumlah'] = $md['jumlah'];

          $fol = new Folio();
          $fol->registrasi_id = $reg->id;
          $fol->poli_id = poliRadiologi();
          $fol->lunas = 'N';
          $fol->namatarif = $tarif->nama;
          $fol->tarif_id = $tarif->id;
          
          $fol->cara_bayar_id = $reg->bayar;
          $fol->poli_tipe = 'R';
          $fol->cyto = $cyto;
          $fol->total = ($tarif->total * $request['jumlah'] + $cyto);
          $fol->jenis_pasien = $reg->bayar;
          $fol->pasien_id = $request['pasien_id'];
          $fol->dokter_id = @$request['dokter_id'];
          $fol->no_foto = @$request['no_foto'];
          $fol->diagnosa = @$request['diagnosa'];
          $fol->user_id = Auth::user()->id;
          if (!empty($request['tgl_pemeriksaan'])) {
            $fol->created_at = valid_date($request['tgl_pemeriksaan']).' '.date('H:i:s');
          }
          // dd($fol->created_at);
          $fol->mapping_biaya_id = $tarif->mapping_biaya_id;

          //revisi pelaksana
          $fol->dpjp = $reg->dokter_id;
          $fol->dokter_radiologi = $request['dokter_radiologi'];
          $fol->radiografer = $request['radiografer'];
          if (substr($reg->status_reg, 0, 1) == 'G') {
            $tipe_pasien = 'TG';
          } elseif (substr($reg->status_reg, 0, 1) == 'I') {
            $tipe_pasien = 'TI';
          } else {
            $tipe_pasien = 'TA';
          }
          $fol->pelaksana_tipe = $tipe_pasien;
          $fol->jenis = $tipe_pasien;
          // dd($fol);
          $fol->save();
  
        }
      }
      
    }
    
    return $res;
    // return $token->response->token;
  }

  public function getTarifRis(Request $request){
    $term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

    $tags = Tarif::whereNotNull('modality_id')->where('nama', 'like', '%' . $term . '%')->groupBy('nama')->groupBy('modality_id')->get();
		$formatted_tags = [];

		foreach ($tags as $tag) {
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama.' ('.$tag->modality->modalityid.') - Rp. '.number_format($tag->total)];
		}
		return \Response::json($formatted_tags);
  }

  public function getTindakan(Request $request){
    $term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

    $tags = RisTindakan::where('mt_desc', 'like', '%' . $term . '%')->get();
		$formatted_tags = [];

		foreach ($tags as $tag) {
				$formatted_tags[] = ['id' => $tag->mt_id.'__'.$tag->mt_desc, 'text' => $tag->mt_desc];
		}
		return \Response::json($formatted_tags);
  }
  public function getModality(Request $request){
    $term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

    $tags = Modality::where('modalityname', 'like', '%' . $term . '%')->get();
		$formatted_tags = [];

		foreach ($tags as $tag) {
				$formatted_tags[] = ['id' => $tag->modalityid.'__'.$tag->modalityname, 'text' => $tag->modalityname];
		}
		return \Response::json($formatted_tags);
  }
}
