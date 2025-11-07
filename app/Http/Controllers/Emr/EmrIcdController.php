<?php

namespace App\Http\Controllers\Emr;

use App\EmrInapIcd;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use App\Http\Controllers\Controller;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use App\EmrInapPemeriksaan;
use App\EmrInapPenilaian;
use App\PerawatanIcd10;
use App\PerawatanIcd9;
use App\Satusehat;
use Auth;
use Modules\Icd10\Entities\Icd10;

class EmrIcdController extends Controller
{ 

	
	public function icd10(Request $r,$unit,$registrasi_id){

		
        $data['registrasi_id']     = $registrasi_id;
        $data['unit']              = $unit;
        $data['reg']               = Registrasi::find($registrasi_id);
		$d = Registrasi::where('pasien_id',$data['reg']->pasien_id)->get();
		
		$idregs = [];
		if($d){

			foreach ($d as $s) {
				$idregs[] = $s->id;
			}
		}
		
		$data['riwayat']		   = PerawatanIcd10::whereIn('registrasi_id',$idregs)->orderBy('id','DESC')->get();
		// dd($data['riwayat']);
		// $data['riwayat']		   = EmrInapIcd::where('pasien_id',$data['reg']->pasien_id)->where('type','icd10')->orderBy('id','DESC')->get();
		
		
		if ($r->method() == 'POST')
		{
			

		foreach ($r->diagnosa_awal as $k) {
				
			
			if(Satusehat::find(4)->aktif == 1) {

				if(satusehat()){
		
					// API TOKEN
					$client_id = config('app.client_id');
					$client_secret = config('app.client_secret'); 
					// create code satusehat
					$urlcreatetoken = config('app.create_token');
					$curl_token = curl_init();
		
					curl_setopt_array($curl_token, array(
					CURLOPT_URL => $urlcreatetoken,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => 'client_id='.$client_id.'&client_secret='.$client_secret,
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/x-www-form-urlencoded'
					),
					));
		
					$response_token = curl_exec($curl_token);
					$token = json_decode($response_token);
					$access_token = $token->access_token;
					// dd($access_token);
					curl_close($curl_token);
					// END OF API TOKEN
				}
	
			
				if(satusehat()) {
				//API CONDITION - MEINGGALKAN FASKES
				$create_condition = config('app.create_condition');
				$pasien_ss = Pasien::find(Registrasi::find($r['registrasi_id'])->pasien_id)->nama;
				$pasien_ss_id = Pasien::find(Registrasi::find($r['registrasi_id'])->pasien_id)->id_patient_ss;
				$id_encounter_ss = Registrasi::find($r['registrasi_id'])->id_encounter_ss;
				$time_2 = date('H:i');
				$date = date('d F Y');
				$waktu= time();
				$today = date("Y-m-d",$waktu);
	
				$curl_condition = curl_init();
	
				curl_setopt_array($curl_condition, array(
				CURLOPT_URL => $create_condition,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'{
					"resourceType": "Condition",
					"clinicalStatus": {
					   "coding": [
						  {
							 "system": "http://terminology.hl7.org/CodeSystem/condition-clinical",
							 "code": "active",
							 "display": "Active"
						  }
					   ]
					},
					"category": [
					   {
						  "coding": [
							 {
								"system": "http://terminology.hl7.org/CodeSystem/condition-category",
								"code": "encounter-diagnosis",
								"display": "Encounter Diagnosis"
							 }
						  ]
					   }
					],
					"code": {
					   "coding": [
						  {
							 "system": "http://hl7.org/fhir/sid/icd-10",
							 "code": "'.$k.'",
							 "display": "'.baca_icd10($k).'"
						  }
					   ]
					},
					"subject": {
						"reference": "Patient/'.$pasien_ss_id.'",
						"display": "'.$pasien_ss.'"
					},
					"encounter": {
						"reference": "Encounter/'.$id_encounter_ss.'",
						"display": "Kunjungan '.$pasien_ss.' pada tanggal '.$today.'"
					}
				 }',
				CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer '.$access_token.'',
					'Content-Type: application/json'
				),
				));
	
				$response_condition = curl_exec($curl_condition);
				// dd($response_condition);
				$condition_ss = json_decode($response_condition);
				if(!empty($condition_ss->id)){
					$id_condition_ss = $condition_ss->id;
				}else{
					$id_condition_ss = NULL;
				}
				// dd($id_condition_ss);
				curl_close($curl_condition);
				// echo $response;
				//END OF API CONDITION - MEINGGALKAN FASKES
			}


			}


			

			
		// dd(baca_icd10($k));


		$icd10 = new PerawatanIcd10();
		$icd10->icd10 = $k;
		$icd10->registrasi_id = $r->registrasi_id;
		$icd10->carabayar_id = $data['reg']->bayar;
		$icd10->jenis = baca_jenis_unit($unit);
		$icd10->kategori  = $r->kategori;
		$icd10->diagnosis  = $r->diagnosis;
		$icd10->id_condition_ss  = $id_condition_ss;
		$icd10->kasus  = $r->kasus;
		$icd10->save();
		}
		 Flashy::success('Catatan berhasil disimpan');
		 return redirect()->back();
		}

		
        return view('emr.modules.icd.icd10', $data);
    }
	
	public function icd9(Request $r,$unit,$registrasi_id){

		
        $data['registrasi_id']     = $registrasi_id;
        $data['unit']              = $unit;
        $data['reg']               = Registrasi::find($registrasi_id);
		// $data['riwayat']		   = EmrInapIcd::where('pasien_id',$data['reg']->pasien_id)->where('type','icd9')->orderBy('id','DESC')->get();
		$d = Registrasi::where('pasien_id',$data['reg']->pasien_id)->get();
		$idregs = [];
		if($d){

			foreach ($d as $s) {
				$idregs[] = $s->id;
			}
		}
		$data['riwayat']		   = PerawatanIcd9::whereIn('registrasi_id',$idregs)->orderBy('id','DESC')->get();
		
		
		if ($r->method() == 'POST')
		{


		foreach ($r->diagnosa_awal as $k) {
		$icd = new PerawatanIcd9();
		$icd->icd9 = $k;
		$icd->registrasi_id = $r->registrasi_id;
		$icd->carabayar_id = $data['reg']->bayar;
		$icd->jenis = baca_jenis_unit($unit);
		$icd->kategori  = $r->kategori;
		$icd->diagnosis  = $r->diagnosis;
		$icd->save();

		 
		}
		Flashy::success('Catatan berhasil disimpan');
		return redirect()->back();
		}
		
        return view('emr.modules.icd.icd9', $data);
    }

	public function penyebabKematian(Request $r,$registrasi_id){

		
        $data['registrasi_id']     = $registrasi_id;
        $data['unit']              = 'inap';
        $data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapIcd::where('pasien_id',$data['reg']->pasien_id)->where('type','penyebab_kematian')->orderBy('id','DESC')->get();
		
		
		if ($r->method() == 'POST')
		{
			// dd($r->all());
		// $alatbantu = json_encode($r->alatbantu);
		 $emr = new EmrInapIcd();
		 $emr->pasien_id  = $r->pasien_id;
		 $emr->registrasi_id  = $r->registrasi_id;
		 $emr->user_id  = Auth::user()->id;
		 $emr->icd10  = $r->diagnosa_awal;
		 $emr->diagnosis  = $r->diagnosis;
		 $emr->kategori  = $r->kategori;
		 $emr->type  	= 'penyebab_kematian';
		 $emr->save();

		 Flashy::success('Catatan berhasil disimpan');
		 return redirect()->back();
		}

		
        return view('emr.modules.icd.penyebab_kematian', $data);
    }
	public function icd10Destroy($id){
       
		// dd($id);
        
		$icd		   = PerawatanIcd10::find($id);
		// dd($data['riwayat']);
		// $data['riwayat']		   = EmrInapIcd::where('pasien_id',$data['reg']->pasien_id)->where('type','icd10')->orderBy('id','DESC')->get();
		$icd->delete();

		 Flashy::success('Catatan berhasil di hapus');
		 return redirect()->back();
    }

	public function icd9Destroy($id){
       
		// dd($id);
        
		$icd		   = PerawatanIcd9::find($id);
		// dd($data['riwayat']);
		// $data['riwayat']		   = EmrInapIcd::where('pasien_id',$data['reg']->pasien_id)->where('type','icd9')->orderBy('id','DESC')->get();
		$icd->delete();

		 Flashy::success('Catatan berhasil di hapus');
		 return redirect()->back();
    }

}
