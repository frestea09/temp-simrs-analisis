<?php

namespace App\Http\Controllers;

use App\Edukasi;
use App\Helpers\FunctionsV2;
use App\Kesadaran;
use App\KondisiAkhirPasien;
use App\KondisiAkhirPasienSS;
use App\LisLog;
use App\Masterobat;
use App\Orderradiologi;
use App\Prognosis;
use App\RecordSatuSehat;
use App\FolioMulti;
use App\EmrInapPemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Mockery\Recorder;
use Modules\Icd10\Entities\Icd10;
use Modules\Icd9\Entities\Icd9;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Registrasi;

class SatuSehatController extends Controller
{
    public function logEncounter(Request $req){
        ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');

        $data['tga']        = $req->tga ? $req->tga : now()->format('d-m-Y');
        $data['tgb']        = $req->tgb ? $req->tgb : now()->format('d-m-Y');
        $data['status']     = $req->status ? $req->status : 'all';
        $data['service_name']= $req->service_name ? $req->service_name : 'encouter_post';
        $tga                = valid_date($data['tga']) . ' 00:00:00';
        $tgb                = valid_date($data['tgb']) . ' 23:59:59';
        $data['services']   = RecordSatuSehat::distinct()->pluck('service_name');

        $logs               = RecordSatuSehat::whereBetween('created_at', [$tga, $tgb]);
        if($req->status != 'all' && $req->status != null){
            $logs->where('status', $req->status);
        }

        if($data['service_name'] != 'all'){
            $logs->where('service_name', $data['service_name']);
        }

        $data['logs']       = $logs->orderBy('id', 'DESC')->get();
        return view('satusehat.logEncounter', $data);
    }
    public function dashboard(Request $req){
        $data['tga']        = $req->tga ? $req->tga : now()->format('d-m-Y');
        $data['tgb']        = $req->tgb ? $req->tgb : now()->format('d-m-Y');
        $data['status']     = $req->status ? $req->status : 'all';
        $data['service_name']= $req->service_name ? $req->service_name : 'all';
        $tga                = valid_date($data['tga']) . ' 00:00:00';
        $tgb                = valid_date($data['tgb']) . ' 23:59:59';
        $data['services']   = RecordSatuSehat::distinct()->pluck('service_name');
        
        $data['registrasi'] = Registrasi::where('status_reg','like','J%')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['registrasi_inap'] = Registrasi::where('status_reg','like','I%')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['registrasi_igd'] = Registrasi::where('status_reg','like','G%')->whereBetween('created_at', [$tga, $tgb])->count();
        
        // SUKSES
        $data['encounter_sukses_rajal']  = RecordSatuSehat::where('service_name','encouter_post')->where('status_reg','like','J%')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        // $data['encounter_sukses_inap']  = RecordSatuSehat::where('service_name','encouter_post')->where('status_reg','like','I%')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['encounter_sukses_igd']  = RecordSatuSehat::where('service_name','encouter_post')->where('status_reg','like','G%')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        // $data['encounter_sukses_rajal'] = Registrasi::where('status_reg','like','J%')->whereNotNull('id_encounter_ss')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['encounter_sukses_inap'] = Registrasi::where('status_reg','like','I%')->whereNotNull('id_encounter_ss')->whereBetween('created_at', [$tga, $tgb])->count();
        // $data['encounter_sukses_igd'] = Registrasi::where('status_reg','like','G%')->whereNotNull('id_encounter_ss')->whereBetween('created_at', [$tga, $tgb])->count();
        
        // GAGAL
        $data['encounter_gagal_rajal']  = RecordSatuSehat::where('service_name','encouter_post')->where('status_reg','like','J%')->where('status','failed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['encounter_gagal_inap']  = RecordSatuSehat::where('service_name','encouter_post')->where('status_reg','like','I%')->where('status','failed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['encounter_gagal_igd']  = RecordSatuSehat::where('service_name','encouter_post')->where('status_reg','like','G%')->where('status','failed')->whereBetween('created_at', [$tga, $tgb])->count();
        // $data['encounter_gagal_rajal'] = Registrasi::where('status_reg','like','J%')->whereNull('id_encounter_ss')->whereBetween('created_at', [$tga, $tgb])->count();
        // $data['encounter_gagal_inap'] = Registrasi::where('status_reg','like','I%')->whereNull('id_encounter_ss')->whereBetween('created_at', [$tga, $tgb])->count();
        // $data['encounter_gagal_igd'] = Registrasi::where('status_reg','like','G%')->whereNull('id_encounter_ss')->whereBetween('created_at', [$tga, $tgb])->count();

        $data['encounter']  = RecordSatuSehat::where('service_name','encouter_post')->whereBetween('created_at', [$tga, $tgb])->count();
        
        $data['condition_rajal']  = RecordSatuSehat::where('status_reg','like','J%')->where('service_name','condition_post')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['observation_rajal']  = RecordSatuSehat::where('status_reg','like','J%')->where('service_name','like','observation_post%')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['procedure_rajal']  = RecordSatuSehat::where('status_reg','like','J%')->where('service_name','like','procedure_post')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['composition_rajal']  = RecordSatuSehat::where('status_reg','like','J%')->where('service_name','like','composition_post')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['medication_rajal']  = RecordSatuSehat::where('status_reg','like','J%')->where('service_name','like','medication_post')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        
        $data['condition_inap']  = RecordSatuSehat::where('status_reg','like','I%')->where('service_name','condition_post')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['observation_inap']  = RecordSatuSehat::where('status_reg','like','I%')->where('service_name','like','observation_post%')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['procedure_inap']  = RecordSatuSehat::where('status_reg','like','I%')->where('service_name','like','procedure_post')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['composition_inap']  = RecordSatuSehat::where('status_reg','like','I%')->where('service_name','like','composition_post')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['medication_inap']  = RecordSatuSehat::where('status_reg','like','I%')->where('service_name','like','medication_post')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();

        $data['condition_igd']  = RecordSatuSehat::where('status_reg','like','G%')->where('service_name','condition_post')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['observation_igd']  = RecordSatuSehat::where('status_reg','like','G%')->where('service_name','like','observation_post%')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['procedure_igd']  = RecordSatuSehat::where('status_reg','like','G%')->where('service_name','like','procedure_post')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['composition_igd']  = RecordSatuSehat::where('status_reg','like','G%')->where('service_name','like','composition_post')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();
        $data['medication_igd']  = RecordSatuSehat::where('status_reg','like','G%')->where('service_name','like','medication_post')->where('status','successed')->whereBetween('created_at', [$tga, $tgb])->count();



        $logs               = RecordSatuSehat::whereBetween('created_at', [$tga, $tgb]);
        if($req->status != 'all' && $req->status != null){
            $logs->where('status', $req->status);
        }

        if($req->service_name != 'all' && $req->service_name != null){
            $logs->where('service_name', $req->service_name);
        }
        $data['logs']       = $logs->latest()->get();
        return view('satusehat.dashboard', $data);
    }
    public function logRis(Request $req){
        $data['tga']        = $req->tga ? $req->tga : now()->format('d-m-Y');
        $data['tgb']        = $req->tgb ? $req->tgb : now()->format('d-m-Y');
        $data['status']     = $req->status ? $req->status : 'all';
        $tga                = valid_date($data['tga']) . ' 00:00:00';
        $tgb                = valid_date($data['tgb']) . ' 23:59:59';

        $logs               = Orderradiologi::whereNotNull('json')->whereBetween('created_at', [$tga, $tgb]);

        $data['logs']       = $logs->latest()->get();
        return view('satusehat.logRis', $data);
    }
    public function logLica(Request $req){
        ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');
        $data['tga']        = $req->tga ? $req->tga : now()->format('d-m-Y');
        $data['tgb']        = $req->tgb ? $req->tgb : now()->format('d-m-Y');
        $data['status']     = $req->status ? $req->status : 'all';
        $tga                = valid_date($data['tga']) . ' 00:00:00';
        $tgb                = valid_date($data['tgb']) . ' 23:59:59';

        $logs               = LisLog::whereNotNull('request')->whereBetween('created_at', [$tga, $tgb]);

        $data['logs']       = $logs->latest()->get();
        return view('satusehat.logLica', $data);
    }

    public function json(Request $req){
        $data['json']   = json_decode(RecordSatuSehat::find($req->id)->response);
        return view('satusehat.json', $data);
    }
    public function jsonRequest(Request $req){
        $data['json']   = json_decode(RecordSatuSehat::find($req->id)->request);
        return view('satusehat.json_request', $data);
    }
    public function jsonRis(Request $req){
        $data['json']   = json_decode(Orderradiologi::find($req->id)->json);
        return view('satusehat.json_ris', $data);
    }
    public function jsonLica(Request $req){
        $data['json']   = json_decode(LisLog::find($req->id)->request);
        return view('satusehat.json_lica', $data);
    }
    public function createKyc(){
        return view('satusehat.createKyc');
    }

    // public function kyc(Request $request){
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['name' => 'Agung Dirmansyah', 'nik' => '3304052705890007']));
    //     curl_setopt($ch, CURLOPT_URL, 'https://kyc.simkes.id/api/kyc');
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     $result = curl_exec($ch);
    //     $res = json_decode($result);
    //     dd($res);
    //     return response()->json($res);
    // }
    public function kyc(Request $request)
    {
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
        // dd($response_token);
        $token = json_decode($response_token);
        $environment = 'production';
        $apiUrl = 'https://api-satusehat.kemkes.go.id/kyc/v1/generate-url';
        $access_token = $token->access_token;
        curl_close($curl_token);

        if ($access_token) {
            $agent_name = $request->nama;
            $agent_nik = $request->nik;
            $res = generateUrl($agent_name, $agent_nik, $access_token, $apiUrl, $environment);
    
            if ($res) {
                $decode_res = json_decode($res);
    
                if ($res == 'error') {
                    Flashy::info('Data Tidak Sesuai KTP');
                    return redirect()->back();
                }
                $url = $decode_res->data->url;
                return redirect($decode_res->data->url);
            }
        }

        Flashy::error('Gagal melakukan KYC');
        return redirect()->back();

    }

    public static function createToken(){
        // API TOKEN
        $client_id      = config('app.client_id');
        $client_secret  = config('app.client_secret'); 
        $urlcreatetoken = config('app.create_token');
        // dd($client_id, $client_secret, $urlcreatetoken);
        $curl_token     = curl_init();
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
        @$response_token = curl_exec($curl_token);
        curl_close($curl_token);
        if(@$response_token == NULL || @$response_token == '0' || @$response_token == false){
            return NULL;
        }
        @$token          = @json_decode(@$response_token);
        @$access_token   = @$token->access_token ?? NULL;
        return @$access_token;
    }

    public static function PatientGet($nik){
        $access_token       = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $url_get_patient    = config('app.get_patient');
        $curl_patient       = curl_init();
        curl_setopt_array($curl_patient, array(
            CURLOPT_URL => $url_get_patient.$nik,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.@$access_token.''
            ),
        ));

        $response_patient   = curl_exec($curl_patient);
        curl_close($curl_patient);
        $patient_ss         = json_decode($response_patient);
        if(!empty($patient_ss->entry)){
            $id_ss          = $patient_ss->entry[0]->resource->id;
        }else{
            $id_ss          = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => null,
            'status'        => $id_ss ? 'successed' : 'failed',
            'response'      => $response_patient,
            'service_name'  => 'patient_get',
            'extra'         => json_encode([
                'NIK'   => $nik
            ])
        ]);

        return $id_ss;
    }

    public static function EncounterPost($registrasi_id,$input_from = null){
        $reg                = Registrasi::find($registrasi_id);
        $patient            = $reg->pasien;
        $practitioner       = Pegawai::find($reg->dokter_id);
        $location           = Poli::find($reg->poli_id);
        $access_token       = self::createToken();
        // if(!$patient->id_patient_ss){
        //     @$id_ss = @$this->PatientGet($patient->nik);
        //     if(@$id_ss){
        //         @$pasien = Pasien::where('id',$patient->id)->first();
        //         @$pasien->id_patient_ss = @$id_ss;
        //         @$pasien->save();
        //         @$patient = $pasien;
        //     }
        // }
        if(@$access_token == NULL){
            return NULL;
        }
        $today              = dateTimeUTC(now()->format('Y-m-d H:i:s'));
        $organization_id    = config('app.organization_id');
        $create_encounter   = config('app.create_encounter');
        $curl_encounter     = curl_init();
        $body = '{
            "resourceType": "Encounter",
            "status": "arrived",
            "class": {
                "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                "code": "AMB",
                "display": "ambulatory"
            },
            "subject": {
                "reference": "Patient/'.$patient->id_patient_ss.'",
                "display": "'.$patient->nama.'"
            },
            "participant": [
                {
                    "type": [
                        {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                    "code": "ATND",
                                    "display": "attender"
                                }
                            ]
                        }
                    ],
                    "individual": {
                        "reference": "Practitioner/'.$practitioner->id_dokterss.'",
                        "display": "'.$practitioner->nama.'"
                    }
                }
            ],
            "period": {
                "start": "'.$today.'"
            },
            "location": [
                {
                    "location": {
                        "reference": "Location/'.$location->id_location_ss.'",
                        "display": "'.$location->nama.'"
                    }
                }
            ],
            "statusHistory": [
                {
                    "status": "arrived",
                    "period": {
                        "start": "'.$today.'",
                        "end": "'.$today.'"
                    }
                }
            ],
            "serviceProvider": {
                "reference": "Organization/'.$organization_id.'"
            },
            "identifier": [
                {
                    "system": "http://sys-ids.kemkes.go.id/encounter/'.$organization_id.'",
                    "value": "'.$registrasi_id.'"
                }
            ]
        }';
        curl_setopt_array($curl_encounter, array(
            CURLOPT_URL => $create_encounter,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$body,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.@$access_token.'',
                'Content-Type: application/json'
            ),
        ));
        $response_encounter = curl_exec($curl_encounter);
        $id_encounter = json_decode($response_encounter);
        curl_close($curl_encounter);
        // dd($response_encounter);

        if(!empty($id_encounter->id)){
            $id_ss_encounter = $id_encounter->id;
        }else{
            $id_ss_encounter = NULL;
        }
        // $cek_record = RecordSatuSehat::where('registrasi_id',$registrasi_id)->where('service_name','encouter_post')->first();
        $data_column = [
            'registrasi_id' => $registrasi_id,
            'status'        => $id_ss_encounter ? 'successed' : 'failed',
            'response'      => $response_encounter,
            'status_reg'    => @$reg->status_reg,
            'request'        => @$body,
            'input_from'    => @$input_from,
            'service_name'  => 'encouter_post',
            'extra'         => json_encode([
                'patient_id'        => @$patient->id,
                'patient_id_ss'        => @$patient->id_patient_ss,
                'practitioner_id'   => $practitioner->id_dokterss,
                'location_id'       => $location->id_location_ss,
                'nik'               => @$patient->nik
            ])
        ];
        // if(!$cek_record){
            RecordSatuSehat::create($data_column);
        // }else{
        //     $cek_record->update($data_column);
        // }
        return $id_ss_encounter;
    }

    public static function EncounterGet($encouter_id){
        $access_token       = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $get_encounter      = config('app.create_encounter') . "/$encouter_id";
        $curl_encounter     = curl_init();
        curl_setopt_array($curl_encounter, array(
            CURLOPT_URL => $get_encounter ,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.@$access_token.'',
                'Content-Type: application/json'
            ),
        ));
        $response_encounter = curl_exec($curl_encounter);
        $encouter_body = json_decode($response_encounter);
        curl_close($curl_encounter);
        if(!empty($encouter_body->id)){
            $id_ss_encounter = $encouter_body->id;
        }else{
            $id_ss_encounter = NULL;
        }
        RecordSatuSehat::create([
            'status'        => $id_ss_encounter ? 'successed' : 'failed',
            'response'          => $response_encounter,
            'service_name'  => 'encounter_get'
        ]);
        return $id_ss_encounter ? $encouter_body : NULL;
    }

    public static function ObservationPostNadi($registrasi_id, $value){
        if($value == null || $value == '0'){
            return NULL;
        }
        $reg                    = Registrasi::find($registrasi_id);
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $id_practitioner        = $reg->dokter_umum->id_dokterss;
        // dd($id_encounter_ss, $pasien_ss_nama, $pasien_ss_id, $id_practitioner, $value);
        
        $today                  = dateTimeUTC07(Carbon::now()->format('Y-m-d H:i:s'));

        $url_create_observasi   = config('app.create_observation');
        $access_token           = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $curl_observation       = curl_init();
        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "Observation",
                "status": "final",
                "category": [
                    {
                        "coding": [
                            {
                                "system": "http://terminology.hl7.org/CodeSystem/observation-category",
                                "code": "vital-signs",
                                "display": "Vital Signs"
                            }
                        ]
                    }
                ],
                "code": {
                    "coding": [
                        {
                            "system": "http://loinc.org",
                            "code": "8867-4",
                            "display": "Heart rate"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$pasien_ss_id.'"
                },
                "performer": [
                    {
                        "reference": "Practitioner/'.$id_practitioner.'"
                    }
                ],
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Pemeriksaan Nadi '.$pasien_ss_nama.' di tanggal '.date('Y-m-d H:i:s').'"
                },
                "valueQuantity": {
                    "value": '.intval($value).',
                    "unit": "beats/minute",
                    "system": "http://unitsofmeasure.org",
                    "code": "/min"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
        ));

        $response_observasi = curl_exec($curl_observation);
        // dd($response_observasi);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
        // dd($id_observation);
        if(!empty($id_observation->id)){
            $id_observation_ss = $id_observation->id;
        }else{
            $id_observation_ss = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status_reg'    => @$reg->status_reg,
            'status'        => $id_observation_ss ? 'successed' : 'failed',
            'response'          => $response_observasi,
            'service_name'  => 'observation_post_nadi'
        ]);
        return $id_observation_ss;
    }

    public static function ObservationPostPernafasan($registrasi_id, $value){
        if($value == null || $value == '0'){
            return NULL;
        }
        $reg                    = Registrasi::find($registrasi_id);
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $id_practitioner        = $reg->dokter_umum->id_dokterss;
        // dd($id_encounter_ss, $pasien_ss_nama, $pasien_ss_id, $id_practitioner, $value);

        $today                  = dateTimeUTC(Carbon::now()->format('Y-m-d H:i:s'));

        $url_create_observasi   = config('app.create_observation');
        $access_token           = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $curl_observation       = curl_init();
        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "Observation",
                "status": "final",
                "category": [
                    {
                        "coding": [
                            {
                                "system": "http://terminology.hl7.org/CodeSystem/observation-category",
                                "code": "vital-signs",
                                "display": "Vital Signs"
                            }
                        ]
                    }
                ],
                "code": {
                    "coding": [
                        {
                            "system": "http://loinc.org",
                            "code": "9279-1",
                            "display": "Respiratory rate"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$pasien_ss_id.'"
                },
                "performer": [
                    {
                        "reference": "Practitioner/'.$id_practitioner.'"
                    }
                ],
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Pemeriksaan Pernafasan '.$pasien_ss_nama.' di tanggal '.date('Y-m-d H:i:s').'"
                },
                "valueQuantity": {
                    "value": '.intval($value).',
                    "unit": "breaths/minute",
                    "system": "http://unitsofmeasure.org",
                    "code": "/min"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
        ));

        $response_observasi = curl_exec($curl_observation);
        // dd($response_observasi);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
        // dd($id_observation);
        if(!empty($id_observation->id)){
            $id_observation_ss = $id_observation->id;
        }else{
            $id_observation_ss = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_observation_ss ? 'successed' : 'failed',
            'response'          => $response_observasi,
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'observation_post_pernafasan'
        ]);
        return $id_observation_ss;
    }

    public static function ObservationPostSistol($registrasi_id, $value){
        if($value == null || $value == '0'){
            return NULL;
        }
        $reg                    = Registrasi::find($registrasi_id);
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $id_practitioner        = $reg->dokter_umum->id_dokterss;
        // dd($id_encounter_ss, $pasien_ss_nama, $pasien_ss_id, $id_practitioner, $value);

        $today                  = dateTimeUTC(Carbon::now()->format('Y-m-d H:i:s'));
        // Seharusnya pakau UTC +00, tapi sepertinya bug dari satusehat

        $url_create_observasi   = config('app.create_observation');
        $access_token           = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $curl_observation       = curl_init();
        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "Observation",
                "status": "final",
                "category": [
                    {
                        "coding": [
                            {
                                "system": "http://terminology.hl7.org/CodeSystem/observation-category",
                                "code": "vital-signs",
                                "display": "Vital Signs"
                            }
                        ]
                    }
                ],
                "code": {
                    "coding": [
                        {
                            "system": "http://loinc.org",
                            "code": "8480-6",
                            "display": "Systolic blood pressure"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$pasien_ss_id.'"
                },
                "performer": [
                    {
                        "reference": "Practitioner/'.$id_practitioner.'"
                    }
                ],
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Pemeriksaan Tekanan Darah Sistol'.$pasien_ss_nama.' di tanggal '.date('Y-m-d H:i:s').'"
                },
                "valueQuantity": {
                    "value": '.intval($value).',
                    "unit": "mm[Hg]",
                    "system": "http://unitsofmeasure.org",
                    "code": "mm[Hg]"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
        ));

        $response_observasi = curl_exec($curl_observation);
        // dd($response_observasi);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
        // dd($id_observation);
        if(!empty($id_observation->id)){
            $id_observation_ss = $id_observation->id;
        }else{
            $id_observation_ss = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_observation_ss ? 'successed' : 'failed',
            'response'          => $response_observasi,
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'observation_post_sistol'
        ]);
        return $id_observation_ss;
    }

    public static function ObservationPostDistol($registrasi_id, $value){
        if($value == null || $value == '0'){
            return NULL;
        }
        $reg                    = Registrasi::find($registrasi_id);
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $id_practitioner        = $reg->dokter_umum->id_dokterss;
        // dd($id_encounter_ss, $pasien_ss_nama, $pasien_ss_id, $id_practitioner, $value);
        $today                  = dateTimeUTC(now()->format('Y-m-d H:i:s'));

        $url_create_observasi   = config('app.create_observation');
        $access_token           = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $curl_observation       = curl_init();
        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "Observation",
                "status": "final",
                "category": [
                    {
                        "coding": [
                            {
                                "system": "http://terminology.hl7.org/CodeSystem/observation-category",
                                "code": "vital-signs",
                                "display": "Vital Signs"
                            }
                        ]
                    }
                ],
                "code": {
                    "coding": [
                        {
                            "system": "http://loinc.org",
                            "code": "8462-4",
                            "display": "Diastolic blood pressure"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$pasien_ss_id.'"
                },
                "performer": [
                    {
                        "reference": "Practitioner/'.$id_practitioner.'"
                    }
                ],
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Pemeriksaan Tekanan Darah Distol'.$pasien_ss_nama.' di tanggal '.date('Y-m-d H:i:s').'"
                },
                "valueQuantity": {
                    "value": '.intval($value).',
                    "unit": "mm[Hg]",
                    "system": "http://unitsofmeasure.org",
                    "code": "mm[Hg]"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
        ));

        $response_observasi = curl_exec($curl_observation);
        // dd($response_observasi);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
        // dd($id_observation);
        if(!empty($id_observation->id)){
            $id_observation_ss = $id_observation->id;
        }else{
            $id_observation_ss = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status_reg'    => @$reg->status_reg,
            'status'        => $id_observation_ss ? 'successed' : 'failed',
            'response'          => $response_observasi,
            'service_name'  => 'observation_post_distol'
        ]);
        return $id_observation_ss;
    }

    public static function ObservationPostSuhu($registrasi_id, $value){
        if($value == null || $value == '0'){
            return NULL;
        }
        $reg                    = Registrasi::find($registrasi_id);
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $id_practitioner        = $reg->dokter_umum->id_dokterss;
        // dd($id_encounter_ss, $pasien_ss_nama, $pasien_ss_id, $id_practitioner, $value);
        $today                  = dateTimeUTC07(Carbon::now()->format('Y-m-d H:i:s'));

        $url_create_observasi   = config('app.create_observation');
        $access_token           = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $curl_observation       = curl_init();
        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "Observation",
                "status": "final",
                "category": [
                    {
                        "coding": [
                            {
                                "system": "http://terminology.hl7.org/CodeSystem/observation-category",
                                "code": "vital-signs",
                                "display": "Vital Signs"
                            }
                        ]
                    }
                ],
                "code": {
                    "coding": [
                        {
                            "system": "http://loinc.org",
                            "code": "8310-5",
                            "display": "Body temperature"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$pasien_ss_id.'"
                },
                "performer": [
                    {
                        "reference": "Practitioner/'.$id_practitioner.'"
                    }
                ],
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Pemeriksaan Suhu '.$pasien_ss_nama.' di tanggal '.date('Y-m-d H:i:s').'"
                },
                "valueQuantity": {
                    "value": '.floatval($value).',
                    "unit": "C",
                    "system": "http://unitsofmeasure.org",
                    "code": "Cel"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
        ));

        $response_observasi = curl_exec($curl_observation);
        // dd($response_observasi);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
        // dd($id_observation);
        if(!empty($id_observation->id)){
            $id_observation_ss = $id_observation->id;
        }else{
            $id_observation_ss = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status_reg'    => @$reg->status_reg,
            'status'        => $id_observation_ss ? 'successed' : 'failed',
            'response'          => $response_observasi,
            'service_name'  => 'observation_post_suhu'
        ]);
        return $id_observation_ss;
    }

    public static function ObservationPostKesadaran($registrasi_id, $code){
        $reg                    = Registrasi::find($registrasi_id);
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $id_practitioner        = $reg->dokter_umum->id_dokterss;
        $kesadaran              = Kesadaran::where('code', $code)->first();
        // dd($id_encounter_ss, $pasien_ss_nama, $pasien_ss_id, $id_practitioner, $value);
        $today                  = dateTimeUTC(Carbon::now()->format('Y-m-d H:i:s'));

        $url_create_observasi   = config('app.create_observation');
        $access_token = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $curl_observation = curl_init();
        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "Observation",
                "status": "final",
                "category": [
                    {
                        "coding": [
                            {
                                "system": "http://terminology.hl7.org/CodeSystem/observation-category",
                                "code": "exam",
                                "display": "Exam"
                            }
                        ]
                    }
                ],
                "code": {
                    "coding": [
                        {
                            "system": "http://loinc.org",
                            "code": "67775-7",
                            "display": "Level of responsiveness"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$pasien_ss_id.'"
                },
                "performer": [
                    {
                        "reference": "Practitioner/'.$id_practitioner.'"
                    }
                ],
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Pemeriksaan Suhu '.$pasien_ss_nama.' di tanggal '.date('Y-m-d H:i:s').'"
                },
                "valueCodeableConcept": {
                    "coding" :[
                        {
                            "system": "http://snomed.info/sct",
                            "code": "'.@$kesadaran->code.'",
                            "display": "'.@$kesadaran->display.'"
                        }
                    ]
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
        ));

        $response_observasi = curl_exec($curl_observation);
        // dd($response_observasi);
        $id_observation     = json_decode($response_observasi);
        curl_close($curl_observation);
        // dd($id_observation);
        if(!empty($id_observation->id)){
            $id_observation_ss = $id_observation->id;
            
        }else{
            $id_observation_ss = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_observation_ss ? 'successed' : 'failed',
            'response'          => $response_observasi,
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'observation_post_kesadaran'
        ]);
        return $id_observation_ss;
    }

    public static function ConditionPost($registrasi_id, $icd10_code, $diagnosis = '', $isPrimary = true){
        $reg                    = Registrasi::find($registrasi_id);
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $icd10                  = Icd10::where('nomor', $icd10_code)->first();
        $today                  = dateTimeUTC(now());
        $create_condition       = config('app.create_condition');
        $access_token           = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $curl_condition         = curl_init();
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
                            "code": "'.@$icd10->nomor.'",
                            "display": "'.@$icd10->nama.'"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$pasien_ss_id.'",
                    "display": "'.$pasien_ss_nama.'"
                },
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Penambahan Kondisi '.$pasien_ss_nama.' pada tanggal '.date('Y-m-d H:i:s').'"
                },
                "note": [
                    {
                        "text": "'.@$diagnosis.'"
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
        ));

        $response_condition = curl_exec($curl_condition);
        $condition_ss       = json_decode($response_condition);
        curl_close($curl_condition);
        // dd($condition_ss);
        if(!empty($condition_ss->id)){
            $id_condition_ss = $condition_ss->id;
            $encounter_body = self::EncounterGet($id_encounter_ss);
            // Update Encounter
            if($encounter_body != null){
                $encounter_body->diagnosis[] = [
                    'condition'     => [
                        'reference'     => 'Condition/' . $id_condition_ss,
                        'display'       => @$icd10->nama
                    ],
                    'use'           => [
                        'coding'        => [
                            [
                                'system'        =>  "http://terminology.hl7.org/CodeSystem/diagnosis-role",
                                'code'          => 'DD',
                                'display'       => 'Discharge diagnosis'
                            ]
                        ]
                    ],
                    'rank'          => $isPrimary ? 1 : 2
                ];
            }
            $update_encounter   = config('app.create_encounter') . "/$id_encounter_ss";
            $curl_encounter     = curl_init();
            curl_setopt_array($curl_encounter, array(
                CURLOPT_URL             => $update_encounter,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_ENCODING        => '',
                CURLOPT_MAXREDIRS       => 10,
                CURLOPT_TIMEOUT         => 0,
                CURLOPT_FOLLOWLOCATION  => true,
                CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST   => 'PUT',
                CURLOPT_POSTFIELDS      => json_encode($encounter_body),
                CURLOPT_HTTPHEADER      => array(
                    'Authorization: Bearer '.@$access_token.'',
                    'Content-Type: application/json'
                ),
            ));
            $response_encounter = curl_exec($curl_encounter);
            curl_close($curl_encounter);
            $id_encounter = json_decode($response_encounter);
            RecordSatuSehat::create([
                'registrasi_id' => $registrasi_id,
                'status'        => $id_encounter ? 'successed' : 'failed',
                'response'      => $response_encounter,
                'status_reg'    => @$reg->status_reg,
                'service_name'  => 'encounter_diagnosis_put',
                'extra'         => json_encode([
                    'icd10'     => @$icd10->nomor,
                    'code'      => @$icd10->nomor
                ])
            ]);
        }else{
            $id_condition_ss = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_condition_ss ? 'successed' : 'failed',
            'response'      => $response_condition,
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'condition_post'
        ]);
        return $id_condition_ss;
    }
    public static function ProcedurePost($registrasi_id, $icd9_code, $diagnosis = ''){
        $reg                    = Registrasi::find($registrasi_id);
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $id_practitioner        = $reg->dokter_umum->id_dokterss;
        $name_practitioner      = $reg->dokter_umum->nama;
        $icd9                   = Icd9::where('nomor', $icd9_code)->first();
        // dd($icd9 );
        $access_token           = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
		$create_procedure       = config('app.create_procedure');
        $curl_procedure         = curl_init();
		curl_setopt_array($curl_procedure, array(
            CURLOPT_URL => $create_procedure,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "Procedure",
                "status": "completed",
                "category": {
                    "coding": [
                        {
                            "system": "http://snomed.info/sct",
                            "code": "103693007",
                            "display": "Diagnostic procedure"
                        }
                    ],
                    "text": "Diagnostic procedure"
                },
                "code": {
                    "coding": [
                        {
                            "system": "http://hl7.org/fhir/sid/icd-9-cm",
                            "code": "'.@$icd9->nomor.'",
                            "display": "'.@$icd9->nama.'"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$pasien_ss_id.'",
                    "display": "'.$pasien_ss_nama.'"
                },
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Tindakan '.@$icd9->nama. " Pasien ".$pasien_ss_nama.' pada tanggal '.date('Y-m-d H:i:s').'"
                },
                "performer": [
                    {
                        "actor": {
                            "reference": "Practitioner/'.$id_practitioner.'",
                            "display": "'.$name_practitioner.'"
                        }
                    }
                ],
                "note": [
                    {
                        "text": "'.@$diagnosis.'"
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
		));

		$response_procedure = curl_exec($curl_procedure);
		$procedure_ss       = json_decode($response_procedure);
		curl_close($curl_procedure);
        // dd($procedure_ss);
		if(!empty($procedure_ss->id)){
			$id_procedure_ss = $procedure_ss->id;
		}else{
			$id_procedure_ss = NULL;
		}
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_procedure_ss ? 'successed' : 'failed',
            'response'      => $response_procedure,
            'service_name'  => 'procedure_post',
            'status_reg'         => @$reg->status_reg,
            'extra'         => json_encode([
                'icd9'      => @$icd9->nama,
                'code'      => @$icd9->nomor
            ])
        ]);
        return $id_procedure_ss;
    }

    public static function ConditionPostPulang($registrasi_id, $condition_id){
        $reg                    = Registrasi::find($registrasi_id);
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $condition              = KondisiAkhirPasienSS::find($condition_id);
        $create_condition = config('app.create_condition');
        $access_token = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
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
                                "code": "problem-list-item",
                                "display": "Problem List Item"
                            }
                        ]
                    }
                ],
                "code": {
                    "coding": [
                        {
                            "system": "http://snomed.info/sct",
                            "code": "'.@$condition->kondisi_code.'",
                            "display": "'.@$condition->kondisi_display.'"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$pasien_ss_id.'",
                    "display": "'.$pasien_ss_nama.'"
                },
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Kondisi Pulang '.$pasien_ss_nama.' pada tanggal '.date('Y-m-d H:i:s').'"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
        ));

        $response_condition = curl_exec($curl_condition);
        $condition_ss = json_decode($response_condition);
        curl_close($curl_condition);
        if(!empty($condition_ss->id)){
            $id_condition_ss = $condition_ss->id;
        }else{
            $id_condition_ss = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_condition_ss ? 'successed' : 'failed',
            'response'      => json_encode($condition_ss),
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'condition_post_pulang',
            'extra'         => json_encode([
                'condition_id'    => $condition_id
            ])
        ]);
        return $id_condition_ss;
    }

    public static function EncounterPulangPut($registrasi_id, $pulang_id, $note = ''){
        $reg                = Registrasi::find($registrasi_id);
        $patient            = $reg->pasien;
        $practitioner       = Pegawai::find($reg->dokter_id);
        $pulang             = KondisiAkhirPasienSS::find($pulang_id);
        $access_token       = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $today              = dateTimeUTC(now()->format('Y-m-d H:i:s'));
        $encouter_body      = self::EncounterGet($reg->id_encounter_ss);
        if( $encouter_body == null){
            return null;
        }
        $update_encounter   = config('app.create_encounter') . "/$reg->id_encounter_ss";

        // Update
        $encouter_body->status = "finished";
        $encouter_body->period->end = $today;
        $encouter_body->statusHistory[] = [
            'status'    => 'finished',
            'period'    => [
                'start' => $today,
                'end'   => $today
            ]
        ];
        $encouter_body->hospitalization = [
            'dischargeDisposition'  => [
                'coding'    => [
                    [
                        'system'    => 'http://terminology.hl7.org/CodeSystem/discharge-disposition',
                        'code'      =>  @$pulang->pulang_code,
                        'display'   =>  @$pulang->pulang_display
                    ]
                ],
                'text'      => $note
            ]
        ];

        $curl_encounter     = curl_init();
        curl_setopt_array($curl_encounter, array(
            CURLOPT_URL             => $update_encounter,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 0,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => 'PUT',
            CURLOPT_POSTFIELDS      => json_encode($encouter_body),
            CURLOPT_HTTPHEADER      => array(
                'Authorization: Bearer '.@$access_token.'',
                'Content-Type: application/json'
            ),
        ));
        $response_encounter = curl_exec($curl_encounter);
        $id_encounter = json_decode($response_encounter);
        curl_close($curl_encounter);
        // dd($response_encounter);

        if(!empty($id_encounter->id)){
            $id_ss_encounter = $id_encounter->id;
        }else{
            $id_ss_encounter = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_ss_encounter ? 'successed' : 'failed',
            'response'      => json_encode($response_encounter),
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'encouter_pulang_put'
        ]);
        return $id_ss_encounter;
    }

    public static function MedicationPost($masterobat_id){
        $medication             = Masterobat::find($masterobat_id);
        $satuanjual             = $medication->satuanjual;
        $access_token           = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $urlcreatemedication    = config('app.create_medication');
        $organization           = config('app.organization_id');
        $curl                   = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $urlcreatemedication,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "resourceType": "Medication",
            "meta": {
                "profile": [
                    "https://fhir.kemkes.go.id/r4/StructureDefinition/Medication"
                ]
            },
            "identifier": [
                {
                    "system": "http://sys-ids.kemkes.go.id/medication/'.$organization.'",
                    "use": "official",
                    "value": "'.$medication->id.'"
                }
            ],
            "code": {
                "coding": [
                    {
                        "system": "http://sys-ids.kemkes.go.id/kfa",
                        "code": "'.$medication->kodekfa.'",
                        "display": "'.$medication->nama.'"
                    }
                ]
            },
            "status": "active",
            "form": {
                "coding": [
                    {
                        "system": "http://terminology.kemkes.go.id/CodeSystem/medication-form",
                        "code": "'.$satuanjual->kodesatuanjual.'",
                        "display": "'.$satuanjual->nama.'"
                    }
                ]
            },
            "extension": [
                {
                    "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType",
                    "valueCodeableConcept": {
                        "coding": [
                            {
                                "system": "http://terminology.kemkes.go.id/CodeSystem/medication-type",
                                "code": "NC",
                                "display": "Non-compound"
                            }
                        ]
                    }
                }
            ]
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$access_token.'',
            'Content-Type: application/json'
        ),
        ));

        $response_medication = curl_exec($curl);
        $responsemedication = json_decode($response_medication);
        curl_close($curl);
        // dd($responsemedication);
        if(!empty($responsemedication->id)){
            $id_medication_ss = $responsemedication->id;
        }else{
            $id_medication_ss = NULL;
            Flashy::error($responsemedication->issue[0]->details->text);
        }

        RecordSatuSehat::create([
            'status'        => $id_medication_ss ? 'successed' : 'failed',
            'response'      => $response_medication,
            'service_name'  => 'medication_post'
        ]);
        return $id_medication_ss;
    }

    public static function MedicationRequestPost($registrasi_id, $resep_id , $resep_detail_id, $masterobat_id){
        $access_token               = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $urlcreatemedicationrequest = config('app.create_medicationrequest');
        $organization               = config('app.organization_id');
        $reg                        = Registrasi::find($registrasi_id);
        $medication                 = Masterobat::find($masterobat_id);
        $patient                    = $reg->pasien;
        $practitioner               = Pegawai::find($reg->dokter_id);
        $today                      = dateTimeUTC(now()->format('Y-m-d H:i:s'));

        $curl = curl_init();
        $body = '{
            "resourceType": "MedicationRequest",
            "identifier": [
                {
                    "system": "http://sys-ids.kemkes.go.id/prescription/'.$organization.'",
                    "use": "official",
                    "value": "'.$resep_id.'"
                },
                {
                    "system": "http://sys-ids.kemkes.go.id/prescription-item/'.$organization.'",
                    "use": "official",
                    "value": "'.$resep_id.'-'.$resep_detail_id.'"
                }
            ],
            "status": "completed",
            "intent": "order",
            "category": [
                {
                    "coding": [
                        {
                            "system": "http://terminology.hl7.org/CodeSystem/medicationrequest-category",
                            "code": "outpatient",
                            "display": "Outpatient"
                        }
                    ]
                }
            ],
            "priority": "routine",
            "medicationReference": {
                "reference": "Medication/'.@$medication->id_medication.'",
                "display": "'.@$medication->nama_obat.'"
            },
            "subject": {
                "reference": "Patient/'.$patient->id_patient_ss.'",
                "display": "'.$patient->nama.'"
            },
            "encounter": {
                "reference": "Encounter/'.$reg->id_encounter_ss.'"
            },
            "requester": {
                "reference": "Practitioner/'.$practitioner->id_dokterss.'",
                "display": "'.$practitioner->nama.'"
            },  
            "courseOfTherapyType": {
                "coding": [
                    {
                        "system": "http://terminology.hl7.org/CodeSystem/medicationrequest-course-of-therapy",
                        "code": "continuous",
                        "display": "Continuing long term therapy"
                    }
                ]
            }
        }';
        curl_setopt_array($curl, array(
        CURLOPT_URL => $urlcreatemedicationrequest,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$access_token.'',
            'Content-Type: application/json'
        ),
        ));

        $response               = curl_exec($curl);
        $id_medicationrequest   = json_decode($response);
        curl_close($curl);
        // dd($id_medicationrequest->id);
        if(!empty($id_medicationrequest->id)){
            $id_medication_req = $id_medicationrequest->id;
        }else{
            $id_medication_req = NULL;
        }
        SatusehatRecord::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_medication_req ? 'successed' : 'failed',
            'json'          => $response,
            'service_name'  => 'medication_request_post',
            'status_reg'    => @$reg->status_reg,
            'extra'         => json_encode([
                'resep_id'          => $resep_id,
                'resep_detail_id'   => $resep_detail_id,
                'dokter_id'         => $practitioner->id
            ])
        ]);
        return $id_medication_req;
    }

    public static function MedicationDispensePost($registrasi_id, $penjualan_id , $penjualan_detail_id, $masterobat_id){
        $access_token               = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $create_medication_dispense = config('app.create_medication_dispense');
        $organization               = config('app.organization_id');
        $reg                        = Registrasi::find($registrasi_id);
        $location                   = Poli::find($reg->poli_id);
        $medication                 = Masterobat::find($masterobat_id);
        $patient                    = $reg->pasien;
        $practitioner               = Pegawai::find($reg->dokter_id);
        $start                      = strval(dateTimeUTC(now()->format('Y-m-d H:i:s')));
        $end                        = strval(dateTimeUTC(now()->addMinute(rand(2,15))->format('Y-m-d H:i:s')));

        $curl = curl_init();
       	curl_setopt_array($curl, array(
            CURLOPT_URL => $create_medication_dispense,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "MedicationDispense",
                "identifier": [
                    {
                        "system": "http://sys-ids.kemkes.go.id/prescription/'.$organization.'",
                        "use": "official",
                        "value": "'.$penjualan_id.'"
                    },
                    {
                        "system": "http://sys-ids.kemkes.go.id/prescription-item/'.$organization.'",
                        "use": "official",
                        "value": "'.$penjualan_id.'-'.$penjualan_detail_id.'"
                    }
                ],
                "status": "completed",
                "category": {
                    "coding": [
                        {
                            "system": "http://terminology.hl7.org/fhir/CodeSystem/medicationdispense-category",
                            "code": "outpatient",
                            "display": "Outpatient"
                        }
                    ]
                },
                "medicationReference": {
                    "reference": "Medication/'.$medication->id_medication.'",
                    "display": "'.$medication->nama_obat.'"
                },
                "subject": {
                    "reference": "Patient/'.$patient->id_patient_ss.'",
                    "display": "'.$patient->nama.'"
                },
                "context": {
                    "reference": "Encounter/'.$reg->id_encounter_ss.'"
                },
                "performer": [
                    {
                        "actor": {
                            "reference": "Practitioner/'.$practitioner->id_dokterss.'",
                            "display": "'.$practitioner->nama.'"
                        }
                    }
                ],
                "location": {
                    "reference": "Location/'.$location->id_location_ss.'",
                    "display": "Apotek RS Otista Poli '.$location->nama.'"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $id_med_desp = json_decode($response);
        curl_close($curl);

        if(!empty($id_med_desp->id)){
            $id_medication_dep = $id_med_desp->id;
        }else{
            $id_medication_dep = NULL;
        }
        SatusehatRecord::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_medication_dep ? 'successed' : 'failed',
            'json'          => $response,
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'medication_dispense_post',
            'extra'         => json_encode([
                'penjualan_id'          => $penjualan_id,
                'penjualan_detail_id'   => $penjualan_detail_id,
                'dokter_id'             => $practitioner->id
            ])
        ]);

        return $id_medication_dep;
    }

    public static function MedicationDispensePostFromRequest($registrasi_id, $penjualan_id , $penjualan_detail_id, $masterobat_id, $id_medication_req){
        $access_token               = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $create_medication_dispense = config('app.create_medication_dispense');
        $organization               = config('app.organization_id');
        $reg                        = Registrasi::find($registrasi_id);
        $location                   = Poli::find($reg->poli_id);
        $medication                 = Masterobat::find($masterobat_id);
        $patient                    = $reg->pasien;
        $practitioner               = Pegawai::find($reg->dokter_id);
        $start                      = strval(dateTimeUTC(now()->format('Y-m-d H:i:s')));
        $end                        = strval(dateTimeUTC(now()->addMinute(rand(5,15))->format('Y-m-d H:i:s')));

        $curl = curl_init();
       	curl_setopt_array($curl, array(
            CURLOPT_URL => $create_medication_dispense,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "MedicationDispense",
                "identifier": [
                    {
                        "system": "http://sys-ids.kemkes.go.id/prescription/'.$organization.'",
                        "use": "official",
                        "value": "'.$penjualan_id.'"
                    },
                    {
                        "system": "http://sys-ids.kemkes.go.id/prescription-item/'.$organization.'",
                        "use": "official",
                        "value": "'.$penjualan_id.'-'.$penjualan_detail_id.'"
                    }
                ],
                "status": "completed",
                "category": {
                    "coding": [
                        {
                            "system": "http://terminology.hl7.org/fhir/CodeSystem/medicationdispense-category",
                            "code": "outpatient",
                            "display": "Outpatient"
                        }
                    ]
                },
                "medicationReference": {
                    "reference": "Medication/'.@$medication->id_medication.'",
                    "display": "'.@$medication->nama_obat.'"
                },
                "subject": {
                    "reference": "Patient/'.$patient->id_patient_ss.'",
                    "display": "'.$patient->nama.'"
                },
                "context": {
                    "reference": "Encounter/'.$reg->id_encounter_ss.'"
                },
                "performer": [
                    {
                        "actor": {
                            "reference": "Practitioner/'.$practitioner->id_dokterss.'",
                            "display": "'.$practitioner->nama.'"
                        }
                    }
                ],
                "location": {
                    "reference": "Location/'.@$location->id_location_ss.'",
                    "display": "Apotek RS Otista Poli '.@$location->nama.'"
                },
                "authorizingPrescription": [
                    {
                        "reference": "MedicationRequest/'.@$id_medication_req.'"
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
        ));

        $response       = curl_exec($curl);
        $id_med_desp    = json_decode($response);
        curl_close($curl);

        if(!empty($id_med_desp->id)){
            $id_medication_dep = $id_med_desp->id;
        }else{
            $id_medication_dep = NULL;
        }
        SatusehatRecord::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_medication_dep ? 'successed' : 'failed',
            'json'          => $response,
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'medication_dispense_post_from_request',
            'extra'         => json_encode([
                'penjualan_id'          => $penjualan_id,
                'penjualan_detail_id'   => $penjualan_detail_id,
                'dokter_id'             => $practitioner->id
            ])
        ]);

        return $id_medication_dep;
    }

    public static function ProcedureEducationPost($registrasi_id, $education_code){
        $reg                    = Registrasi::find($registrasi_id);
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $id_practitioner        = $reg->dokter_umum->id_dokterss;
        $name_practitioner      = $reg->dokter_umum->nama;
        $education              = Edukasi::where('code', $education_code)->first();

        $access_token       = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
		$create_procedure   = config('app.create_procedure');
        $curl_procedure     = curl_init();
		curl_setopt_array($curl_procedure, array(
            CURLOPT_URL => $create_procedure,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "Procedure",
                "status": "completed",
                "category": {
                    "coding": [
                        {
                            "system": "http://snomed.info/sct",
                            "code": "103693007",
                            "display": "Diagnostic procedure"
                        }
                    ],
                    "text": "Diagnostic procedure"
                },
                "code": {
                    "coding": [
                        {
                            "system": "http://snomed.info/sct",
                            "code": "'.@$education->code.'",
                            "display": "'.@$education->display.'"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$pasien_ss_id.'",
                    "display": "'.$pasien_ss_nama.'"
                },
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Tindakan Edukasi '.@$education->display. " Pasien ".$pasien_ss_nama.' pada tanggal '.date('Y-m-d H:i:s').'"
                },
                "performer": [
                    {
                        "actor": {
                            "reference": "Practitioner/'.$id_practitioner.'",
                            "display": "'.$name_practitioner.'"
                        }
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
		));

		$response_procedure = curl_exec($curl_procedure);
		$procedure_ss = json_decode($response_procedure);
		curl_close($curl_procedure);
        // dd($procedure_ss);
		if(!empty($procedure_ss->id)){
			$id_procedure_ss = $procedure_ss->id;
		}else{
			$id_procedure_ss = NULL;
		}
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_procedure_ss ? 'successed' : 'failed',
            'response'      => $response_procedure,
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'procedure_education_post'
        ]);
        return $id_procedure_ss;
    }

    public static function CompositionPost($registrasi_id, $value = ''){
        $access_token               = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $urlcomposition             = config('app.create_composition');
        $organization               = config('app.organization_id');
        $reg                        = Registrasi::find($registrasi_id);
        $patient                    = $reg->pasien;
        $practitioner               = Pegawai::find($reg->dokter_id);
        $today                      = dateTimeUTC(now()->format('Y-m-d H:i:s'));

        $body = '{
            "resourceType": "Composition",
            "identifier": {
                "system": "http://sys-ids.kemkes.go.id/composition/'.$organization.'",
                "value": "'.$reg->id.'"
            },
            "status": "final",
            "type": {
                "coding": [
                    {
                        "system": "http://loinc.org",
                        "code": "18842-5",
                        "display": "Discharge summary"
                    }
                ]
            },
            "category": [
                {
                    "coding": [
                        {
                            "system": "http://loinc.org",
                            "code": "LP173421-1",
                            "display": "Report"
                        }
                    ]
                }
            ],
            "subject": {
                "reference": "Patient/'.$patient->id_patient_ss.'",
                "display": "'.$patient->nama.'"
            },
            "encounter": {
                "reference": "Encounter/'.$reg->id_encounter_ss.'",
                "display": "Asesmen Diet '.$patient->nama.' Tanggal '.date('d-m-y H:i:s').'"
            },
            "date": "'.$today.'",
            "author": [
                {
                    "reference": "Practitioner/'.$practitioner->id_dokterss.'",
                    "display": "'.$practitioner->nama.'"
                }
            ],
            "title": "Resume Medis Rawat Jalan",
            "custodian": {
                "reference": "Organization/'.$organization.'"
            },
            "section": [
                {
                    "code": {
                        "coding": [
                            {
                                "system": "http://loinc.org",
                                "code": "42344-2",
                                "display": "Discharge diet (narrative)"
                            }
                        ]
                    },
                    "text": {
                        "status": "additional",
                        "div": "'.$value.'"
                    }
                }
            ]
        }';
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $urlcomposition,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$access_token.'',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        $composition = json_decode($response);
        curl_close($curl);
        // dd($composition);
        if(!empty($composition->id)){
            $id_composition_ss = $composition->id;
        }else{
            $id_composition_ss = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_composition_ss ? 'successed' : 'failed',
            'response'      => $response,
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'composition_post',
            'extra'         => json_encode([
                'dokter_id'         => $practitioner->id
            ])
        ]);
        return $id_composition_ss;
    }

    public static function ClinicalImpressionPost($registrasi_id, $prognosis_code, $description = '', $investigation = '', $summary = ''){
        $reg                    = Registrasi::find($registrasi_id);
        $patient                = $reg->pasien;
        $practitioner           = $reg->dokter_umum;
        $prognosis              = Prognosis::where('code', $prognosis_code)->first();
        $organization           = config('app.organization_id');

        $access_token = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
		$create_procedure = config('app.create_clinical_impression');
        $curl_procedure = curl_init();
		curl_setopt_array($curl_procedure, array(
            CURLOPT_URL => $create_procedure,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "ClinicalImpression",
                "identifier": [
                    {
                        "system": "http://sys-ids.kemkes.go.id/clinicalimpression/'.$organization.'",
                        "use": "official",
                        "value": "'.$registrasi_id.'"
                    }
                ],
                "status": "completed",
                "description": "'.$description.'",
                "subject": {
                    "reference": "Patient/'.$patient->id_patient_ss.'",
                    "display": "'.$patient->nama.'"
                },
                "encounter": {
                    "reference": "Encounter/'.$reg->id_encounter_ss.'",
                    "display": "Prognosis '.$patient->nama.' Tanggal '.date('d-m-y H:i:s').'"
                },
                "assessor": {
                    "reference": "Practitioner/'.$practitioner->id_dokterss.'",
                    "display": "'.$practitioner->nama.'"
                },
                "investigation": [
                    {
                        "code": {
                            "text" : "'.$investigation.'"
                        }
                    }
                ],
                "summary": "'.$summary.'",
                "prognosisCodeableConcept": [
                    {
                        "coding": [
                            {
                                "system": "http://snomed.info/sct",
                                "code": "'.@$prognosis->code.'",
                                "display": "'.@$prognosis->display.'"
                            }
                        ]
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
		));

		$response_prognosis = curl_exec($curl_procedure);
		$procedure_ss       = json_decode($response_prognosis);
		curl_close($curl_procedure);
        // dd($procedure_ss);
		if(!empty($procedure_ss->id)){
			$id_prognosis_ss = $procedure_ss->id;
		}else{
			$id_prognosis_ss = NULL;
		}
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_prognosis_ss ? 'successed' : 'failed',
            'response'      => $response_prognosis,
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'clinical_impression_post'
        ]);
        return $id_prognosis_ss;
    }

    public static function ProcedurePuasaRadiologiPost($registrasi_id, $folio_id){
        $reg                    = Registrasi::find($registrasi_id); 
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $id_practitioner        = $reg->dokter_umum->id_dokterss;
        $name_practitioner      = $reg->dokter_umum->nama;
        $puasa                  = FolioMulti::find($folio_id);

        $access_token       = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
		$create_procedure   = config('app.create_procedure');
        $curl_procedure     = curl_init();
		curl_setopt_array($curl_procedure, array(
            CURLOPT_URL => $create_procedure,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "Procedure",
                "status": "not-done",
                "category": {
                    "coding": [
                        {
                            "system": "http://snomed.info/sct",
                            "code": "103693007",
                            "display": "Diagnostic procedure"
                        }
                    ],
                    "text": "Prosedur diagnostik"
                },
                "code": {
                    "coding": [
                        {
                            "system": "http://snomed.info/sct",
                            "code": "792805006",
                            "display": "Fasting"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$pasien_ss_id.'",
                    "display": "'.$pasien_ss_nama.'"
                },
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'"
                },
                "performedPeriod": {
                    "start": "'.\Carbon\Carbon::parse($puasa->mulai_puasa)->format('Y-m-d\TH:i:sP').'",
                    "end": "'.\Carbon\Carbon::parse($puasa->selesai_puasa)->format('Y-m-d\TH:i:sP').'"
                },
                "performer": [
                    {
                        "actor": {
                            "reference": "Practitioner/'.$id_practitioner.'",
                            "display": "'.$name_practitioner.'"
                        }
                    }
                ],
                "note": [
                    {
                        "text": "Tidak puasa sebelum pemeriksaan radiologi"
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
		));

		$response_procedure = curl_exec($curl_procedure);
		$procedure_ss = json_decode($response_procedure);
		curl_close($curl_procedure);
        // dd($procedure_ss);
		if(!empty($procedure_ss->id)){
			$id_procedure_ss = $procedure_ss->id;
		}else{
			$id_procedure_ss = NULL;
		}
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_procedure_ss ? 'successed' : 'failed',
            'response'      => $response_procedure,
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'procedure_puasa_radiologi_post'
        ]);
        return $id_procedure_ss;
    }

    public static function ObservationPostKehamilanRad($registrasi_id, $folio_id){
        $reg                    = Registrasi::find($registrasi_id);
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $id_practitioner        = $reg->dokter_umum->id_dokterss;
        
        $today                  = dateTimeUTC07(Carbon::now()->format('Y-m-d H:i:s'));
        $asesmenPonek           = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('type', 'assesment-awal-medis-igd-ponek')->first();

        $hpht = null;
        if ($asesmenPonek) {
            $dataAsesmenPonek = json_decode($asesmenPonek->fisik, true);
            $dataHpht = $dataAsesmenPonek['riwayat']['hpht'] ?? null;
            if ($dataHpht) {
                $hpht = dateTimeUTC07(Carbon::parse($dataHpht)->format('Y-m-d H:i:s'));
            }
        }

        $url_create_observasi   = config('app.create_observation');
        $access_token           = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $curl_observation       = curl_init();
        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "Observation",
                "status": "final",
                "category": [
                    {
                        "coding": [
                            {
                                "system": "http://terminology.hl7.org/CodeSystem/observation-category",
                                "code": "survey",
                                "display": "Survey"
                            }
                        ]
                    }
                ],
                "code": {
                    "coding": [
                        {
                            "system": "http://loinc.org",
                            "code": "82810-3",
                            "display": "Pregnancy status"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$pasien_ss_id.'"
                },
                "performer": [
                    {
                        "reference": "Practitioner/'.$id_practitioner.'"
                    }
                ],
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Kunjungan '.$pasien_ss_nama.' '.$today.'"
                },
                "effectiveDateTime": "'.$hpht.'",
                "issued": "'.$hpht.'",
                "valueCodeableConcept": {
                    "coding": [
                        {
                            "system": "http://snomed.info/sct",
                            "code": "60001007",
                            "display": "Not pregnant"
                        }
                    ]
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
        ));

        $response_observasi = curl_exec($curl_observation);
        // dd($response_observasi);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
        // dd($id_observation);
        if(!empty($id_observation->id)){
            $id_observation_ss = $id_observation->id;
        }else{
            $id_observation_ss = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status_reg'    => @$reg->status_reg,
            'status'        => $id_observation_ss ? 'successed' : 'failed',
            'response'      => $response_observasi,
            'service_name'  => 'observation_post_kehamilan'
        ]);
        return $id_observation_ss;
    }

    public static function ObservationPostAlergiRad($registrasi_id, $folio_id){
        $reg                    = Registrasi::find($registrasi_id);
        $id_encounter_ss        = $reg->id_encounter_ss;
        $pasien_ss_nama         = $reg->pasien->nama;
        $pasien_ss_id           = $reg->pasien->id_patient_ss;
        $id_practitioner        = $reg->dokter_umum->id_dokterss;
        $organization           = config('app.organization_id');
        
        $today                  = dateTimeUTC07(Carbon::now()->format('Y-m-d H:i:s'));
        $riwayat_alergi         = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('type', 'like', 'fisik_%')->orderBy('id', 'DESC')->first();

        $alergi = null;
        if ($riwayat_alergi) {
            $dataRiwayatAlergi = json_decode($riwayat_alergi->fisik, true);
            $alergi = $dataRiwayatAlergi['riwayat_alergi']['sebutkan'] ?? null;
        }

        $url_create_observasi   = config('app.create_allergy');
        $access_token           = self::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $curl_observation       = curl_init();
        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "resourceType": "AllergyIntolerance",
                "identifier": [
                    {
                        "system": "http://sys-ids.kemkes.go.id/allergy/'.$organization.'",
                        "use": "official",
                        "value": "P20240001"
                    }
                ],
                "clinicalStatus": {
                    "coding": [
                        {
                            "system": "http://terminology.hl7.org/CodeSystem/allergyintolerance-clinical",
                            "code": "active",
                            "display": "Active"
                        }
                    ]
                },
                "verificationStatus": {
                    "coding": [
                        {
                            "system": "http://terminology.hl7.org/CodeSystem/allergyintolerance-verification",
                            "code": "confirmed",
                            "display": "Confirmed"
                        }
                    ]
                },
                "category": [
                    "medication"
                ],
                "code": {
                    "coding": [
                        {
                            "system": "http://sys-ids.kemkes.go.id/kfa",
                            "code": "91000928",
                            "display": "'.$alergi.'"
                        }
                    ],
                    "text": "Alergi '.$alergi.'"
                },
                "patient": {
                    "reference": "Patient/'.$pasien_ss_id.'",
                    "display": "'.$pasien_ss_nama.'"
                },
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Kunjungan '.$pasien_ss_nama.' 5 Juli 2025"
                },
                "recordedDate": "'.$today.'",
                "recorder": {
                    "reference": "Practitioner/'.$id_practitioner.'"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ),
        ));

        $response_observasi = curl_exec($curl_observation);
        // dd($response_observasi);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
        // dd($id_observation);
        if(!empty($id_observation->id)){
            $id_observation_ss = $id_observation->id;
        }else{
            $id_observation_ss = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status_reg'    => @$reg->status_reg,
            'status'        => $id_observation_ss ? 'successed' : 'failed',
            'response'      => $response_observasi,
            'service_name'  => 'observation_post_alergi'
        ]);
        return $id_observation_ss;
    }

    public function kirimUlang($reg_id){
        $reg                = Registrasi::find($reg_id);
        $patient            = $reg->pasien;
        $practitioner       = Pegawai::find($reg->dokter_id);
        $location           = Poli::find($reg->poli_id);
        $access_token       = self::createToken();
        if(empty($patient->id_patient_ss)){
            @$id_ss = @$this->PatientGet($patient->nik);
            if(@$id_ss){
                @$pasien = Pasien::where('id',$patient->id)->first();
                @$pasien->id_patient_ss = @$id_ss;
                @$pasien->save();
                @$patient = $pasien;
            } else {
                Flashy::info('Pasien dengan NIK ' . $patient->nik . ' Tidak ditemukan di Satu Sehat');
                return redirect()->back();
            }
        }
        if(@$access_token == NULL){
            Flashy::error('Gagal terhubung ke Satu Sehat');
            return redirect()->back();
        }
        $today              = dateTimeUTC(date('Y-m-d H:i:s', strtotime($reg->created_at)));
        $organization_id    = config('app.organization_id');
        $create_encounter   = config('app.create_encounter');
        $curl_encounter     = curl_init();
        $body = '{
            "resourceType": "Encounter",
            "status": "arrived",
            "class": {
                "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                "code": "AMB",
                "display": "ambulatory"
            },
            "subject": {
                "reference": "Patient/'.$patient->id_patient_ss.'",
                "display": "'.$patient->nama.'"
            },
            "participant": [
                {
                    "type": [
                        {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                    "code": "ATND",
                                    "display": "attender"
                                }
                            ]
                        }
                    ],
                    "individual": {
                        "reference": "Practitioner/'.$practitioner->id_dokterss.'",
                        "display": "'.$practitioner->nama.'"
                    }
                }
            ],
            "period": {
                "start": "'.$today.'"
            },
            "location": [
                {
                    "location": {
                        "reference": "Location/'.$location->id_location_ss.'",
                        "display": "'.$location->nama.'"
                    }
                }
            ],
            "statusHistory": [
                {
                    "status": "arrived",
                    "period": {
                        "start": "'.$today.'",
                        "end": "'.$today.'"
                    }
                }
            ],
            "serviceProvider": {
                "reference": "Organization/'.$organization_id.'"
            },
            "identifier": [
                {
                    "system": "http://sys-ids.kemkes.go.id/encounter/'.$organization_id.'",
                    "value": "'.$reg_id.'"
                }
            ]
        }';
        curl_setopt_array($curl_encounter, array(
            CURLOPT_URL => $create_encounter,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$body,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.@$access_token.'',
                'Content-Type: application/json'
            ),
        ));
        $response_encounter = curl_exec($curl_encounter);
        $id_encounter = json_decode($response_encounter);
        curl_close($curl_encounter);
        // dd($response_encounter);

        if(!empty($id_encounter->id)){
            $id_ss_encounter = $id_encounter->id;
        }else{
            $id_ss_encounter = NULL;
        }
        $cek_record = RecordSatuSehat::where('registrasi_id',$reg_id)->where('service_name','encouter_post')->first();
        $data_column = [
            'registrasi_id' => $reg_id,
            'status'        => $id_ss_encounter ? 'successed' : 'failed',
            'response'      => $response_encounter,
            'status_reg'    => @$reg->status_reg,
            'request'        => @$body,
            'input_from'    => 'kirim-ulang',
            'service_name'  => 'encouter_post',
            'extra'         => json_encode([
                'patient_id'        => @$patient->id,
                'patient_id_ss'        => @$patient->id_patient_ss,
                'practitioner_id'   => $practitioner->id_dokterss,
                'location_id'       => $location->id_location_ss,
                'nik'               => @$patient->nik
            ])
        ];
        if(!$cek_record){
            RecordSatuSehat::create($data_column);
        }else{
            $cek_record->update($data_column);
        }

        if ($id_ss_encounter) {
            $reg->id_encounter_ss = $id_ss_encounter;
            $reg->update();
            Flashy::success('Berhasil mengirim ulang Encounter');
        } else {
            Flashy::error('Gagal mengirim ulang Encounter ' . @$id_encounter->issue[0]->details->text . ' ' . @$id_encounter->issue[0]->diagnostics);
        }
        return redirect()->back();
    }

}
