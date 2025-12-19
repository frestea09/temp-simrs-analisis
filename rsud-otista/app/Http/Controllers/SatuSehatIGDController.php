<?php

namespace App\Http\Controllers;

use App\Allergy;
use App\Http\Controllers\SatuSehatController;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use App\RecordSatuSehat;
use App\EmrInapPemeriksaan;
use App\KondisiPasienTiba;
use App\Transportasi;
use App\SnomedCTChildren;

class SatuSehatIGDController extends Controller
{
    public static function EncounterPost($registrasi_id,$input_from = null){
        $reg                = Registrasi::find($registrasi_id);
        $patient            = $reg->pasien;
        $practitioner       = Pegawai::find($reg->dokter_id);
        $location           = Poli::where('satusehat_room', 'Y')->where('nama', 'Ruangan Triage')->where('politype', 'G')->latest()->first();
        $access_token       = SatuSehatController::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $today              = dateTimeUTC(now()->format('Y-m-d H:i:s'));
        $organization_id    = config('app.organization_id');
        $create_encounter   = config('app.create_encounter');
        $curl_encounter     = curl_init();
        $body = '{
                    "resourceType": "Encounter",
                    "identifier": [
                        {
                        "system": "http://sys-ids.kemkes.go.id/encounter/'.$organization_id.'",
                        "value": "'.$registrasi_id.'"
                        }
                    ],
                    "status": "arrived",
                    "class": {
                        "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                        "code": "EMER",
                        "display": "emergency"
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
                        },
                        "period": {
                            "start": "'.$today.'"
                        },
                        "extension": [
                            {
                            "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/ServiceClass",
                            "extension": [
                                {
                                "url": "value",
                                "valueCodeableConcept": {
                                    "coding": [
                                    {
                                        "system": "http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Outpatient",
                                        "code": "reguler",
                                        "display": "Kelas Reguler"
                                    }
                                    ]
                                }
                                },
                                {
                                "url": "upgradeClassIndicator",
                                "valueCodeableConcept": {
                                    "coding": [
                                    {
                                        "system": "http://terminology.kemkes.go.id/CodeSystem/locationUpgradeClass",
                                        "code": "kelas-tetap",
                                        "display": "Kelas Tetap Perawatan"
                                    }
                                    ]
                                }
                                }
                            ]
                            }
                        ]
                        }
                    ],
                    "statusHistory": [
                        {
                        "status": "arrived",
                        "period": {
                            "start": "'.$today.'"
                        }
                        }
                    ],
                    "serviceProvider": {
                        "reference": "Organization/'.$organization_id.'"
                    }
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

        if(!empty($id_encounter->id)){
            $id_ss_encounter = $id_encounter->id;
        }else{
            $id_ss_encounter = NULL;
        }
        $cek_record = RecordSatuSehat::where('registrasi_id',$registrasi_id)->where('service_name','encouter_post_igd')->first();
        $data_column = [
            'registrasi_id' => $registrasi_id,
            'status'        => $id_ss_encounter ? 'successed' : 'failed',
            'response'      => $response_encounter,
            'status_reg'    => @$reg->status_reg,
            'request'        => @$body,
            'input_from'    => @$input_from,
            'service_name'  => 'encouter_post_igd',
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
        return $id_ss_encounter;
    }

    public static function ObservationPostSaranaTransportasi($registrasi_id){
        $reg                = Registrasi::find($registrasi_id);
        $patient            = $reg->pasien;
        $id_encounter_ss        = $reg->id_encounter_ss;
        $practitioner       = Pegawai::find($reg->dokter_id);
        $triage             = EmrInapPemeriksaan::where('type', 'triage-igd')->where('registrasi_id', $registrasi_id)->first();
        if(empty(@$triage)){
            return NULL;
        }
        $triage             = json_decode($triage->fisik);
        $transportasi       = Transportasi::where('keterangan', $triage->kendaraan)->first();
        if(empty(@$transportasi)){
            return NULL;
        }
        $access_token       = SatuSehatController::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $today              = dateTimeUTC(now()->format('Y-m-d H:i:s'));
        $url_create_observasi   = config('app.create_observation');;
        $curl_observation       = curl_init();
        $body = '{
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
                        "code": "74286-6",
                        "display": "Transport mode to hospital"
                    }
                ]
            },
            "subject": {
                "reference": "Patient/'.$patient->id_patient_ss.'",
                "display": "'.$patient->nama.'"
            },
            "encounter": {
                "reference": "Encounter/'.$id_encounter_ss.'"
            },
            "effectiveDateTime": "'.$today.'",
            "issued": "'.$today.'",
            "performer": [
                {
                    "reference": "Practitioner/'.$practitioner->id_dokterss.'"
                }
            ],
            "valueCodeableConcept": {
                "coding": [
                    {
                        "system": "'.$transportasi->system.'",
                        "code": "'.$transportasi->code.'",
                        "display": "'.$transportasi->display.'"
                    }
                ]
            }
        }';

        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
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
    
        $response_observasi = curl_exec($curl_observation);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
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
            'service_name'  => 'observation_post_sarana_transportasi'
        ]);
        return $id_observation_ss;
    }

    public static function ObservationPostSuratPengantarRujukan($registrasi_id){
        $reg                = Registrasi::find($registrasi_id);
        $patient            = $reg->pasien;
        $id_encounter_ss        = $reg->id_encounter_ss;
        $practitioner       = Pegawai::find($reg->dokter_id);
        $triage             = EmrInapPemeriksaan::where('type', 'triage-igd')->where('registrasi_id', $registrasi_id)->first();
        if(empty(@$triage)){
            return NULL;
        }
        $triage             = json_decode($triage->fisik);
        $rujukan            = @$triage->sebabDatang->sebab == "Rujukan Dari" ? true : false;
        $access_token       = SatuSehatController::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $today              = dateTimeUTC(now()->format('Y-m-d H:i:s'));
        $url_create_observasi   = config('app.create_observation');;
        $curl_observation       = curl_init();
        $body = '{
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
                        "system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
                        "code": "OC000034",
                        "display": "Surat Pengantar Rujukan"
                    }
                ]
            },
            "performer": [
                {
                    "reference": "Practitioner/'.$practitioner->id_dokterss.'"
                }
            ],
            "subject": {
                "reference": "Patient/'.$patient->id_patient_ss.'",
                "display": "'.$patient->nama.'"
            },
            "encounter": {
                "reference": "Encounter/'.$id_encounter_ss.'"
            },
            "effectiveDateTime": "'.$today.'",
            "issued": "'.$today.'",
            "valueBoolean": ' . ($rujukan ? 'true' : 'false') . '
        }';
        
        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
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
    
        $response_observasi = curl_exec($curl_observation);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
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
            'service_name'  => 'observation_post_surat_pengantar_rujukan'
        ]);
        return $id_observation_ss;
    }

    public static function ObservationPostKondisiPasienTiba($registrasi_id){
        $reg                = Registrasi::find($registrasi_id);
        $patient            = $reg->pasien;
        $id_encounter_ss    = $reg->id_encounter_ss;
        $practitioner       = Pegawai::find($reg->dokter_id);
        $triage             = EmrInapPemeriksaan::where('type', 'triage-igd')->where('registrasi_id', $registrasi_id)->first();
        if(empty(@$triage)){
            return NULL;
        }
        $triage             = json_decode($triage->fisik);
        $kondisi            = KondisiPasienTiba::where('keterangan', @$triage->triage->kondisi_pasien_tiba)->first();
        if(empty(@$kondisi)){
            return NULL;
        }
        $access_token       = SatuSehatController::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $today              = dateTimeUTC(now()->format('Y-m-d H:i:s'));
        $url_create_observasi   = config('app.create_observation');;
        $curl_observation       = curl_init();
        $body = '{
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
                        "code": "75910-0",
                        "display": "Canadian triage and acuity scale [CTAS]"
                    }
                ]
            },
            "subject": {
                "reference": "Patient/'.$patient->id_patient_ss.'",
                "display": "'.$patient->nama.'"
            },
            "encounter": {
                "reference": "Encounter/'.$id_encounter_ss.'"
            },
            "effectiveDateTime": "'.$today.'",
            "issued": "'.$today.'",
            "performer": [
                {
                    "reference": "Practitioner/'.$practitioner->id_dokterss.'"
                }
            ],
            "valueCodeableConcept": {
                "coding": [
                    {
                        "system": "'.$kondisi->system.'",
                        "code": "'.$kondisi->code.'",
                        "display": "'.$kondisi->display.'"
                    }
                ]
            }
        }';

        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
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
    
        $response_observasi = curl_exec($curl_observation);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
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
            'service_name'  => 'observation_post_kondisi_pasien_tiba'
        ]);
        return $id_observation_ss;
    }

    public static function ObservationPostNyeri($registrasi_id, $value){
        $reg                = Registrasi::find($registrasi_id);
        $patient            = $reg->pasien;
        $id_encounter_ss        = $reg->id_encounter_ss;
        $practitioner       = Pegawai::find($reg->dokter_id);
        $access_token       = SatuSehatController::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $today              = dateTimeUTC(now()->format('Y-m-d H:i:s'));
        $url_create_observasi   = config('app.create_observation');;
        $curl_observation       = curl_init();
        $body = '{
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
                        "system": "http://snomed.info/sct",
                        "code": "22253000",
                        "display": "Pain"
                    }
                ]
            },
            "performer": [
                {
                    "reference": "Practitioner/'.$practitioner->id_dokterss.'"
                }
            ],
            "subject": {
                "reference": "Patient/'.$patient->id_patient_ss.'",
                "display": "'.$patient->nama.'"
            },
            "encounter": {
                "reference": "Encounter/'.$id_encounter_ss.'"
            },
            "effectiveDateTime": "'.$today.'",
            "issued": "'.$today.'",
            "valueBoolean": ' . ($value ? 'true' : 'false') . '
        }';

        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
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

        $response_observasi = curl_exec($curl_observation);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
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
            'service_name'  => 'observation_post_nyeri'
        ]);
        return $id_observation_ss;
    }

    public static function ObservationPostSkalaNyeriNRS($registrasi_id, $value){
        $reg                = Registrasi::find($registrasi_id);
        $patient            = $reg->pasien;
        $id_encounter_ss        = $reg->id_encounter_ss;
        $practitioner       = Pegawai::find($reg->dokter_id);
        $access_token       = SatuSehatController::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $today              = dateTimeUTC(now()->format('Y-m-d H:i:s'));
        $url_create_observasi   = config('app.create_observation');;
        $curl_observation       = curl_init();
        $body = '{
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
                        "system": "http://snomed.info/sct",
                        "code": "1172399009",
                        "display": "Numeric rating scale score"
                    }
                ]
            },
            "performer": [
                {
                    "reference": "Practitioner/'.$practitioner->id_dokterss.'"
                }
            ],
            "subject": {
                "reference": "Patient/'.$patient->id_patient_ss.'",
                "display": "'.$patient->nama.'"
            },
            "encounter": {
                "reference": "Encounter/'.$id_encounter_ss.'"
            },
            "effectiveDateTime": "'.$today.'",
            "issued": "'.$today.'",
            "valueInteger": ' . $value . '
        }';

        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
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

        $response_observasi = curl_exec($curl_observation);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
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
            'service_name'  => 'observation_post_skala_nyeri'
        ]);
        return $id_observation_ss;
    }

    public static function ObservationPostLokasiNyeri($registrasi_id, $value){
        $reg                = Registrasi::find($registrasi_id);
        $patient            = $reg->pasien;
        $id_encounter_ss        = $reg->id_encounter_ss;
        $practitioner       = Pegawai::find($reg->dokter_id);
        $access_token       = SatuSehatController::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $today              = dateTimeUTC(now()->format('Y-m-d H:i:s'));
        $url_create_observasi   = config('app.create_observation');;
        $curl_observation       = curl_init();
        $body = '{
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
                        "code": "38204-4",
                        "display": "Pain primary location"
                    }
                ]
            },
            "performer": [
                {
                    "reference": "Practitioner/'.$practitioner->id_dokterss.'"
                }
            ],
            "subject": {
                "reference": "Patient/'.$patient->id_patient_ss.'",
                "display": "'.$patient->nama.'"
            },
            "encounter": {
                "reference": "Encounter/'.$id_encounter_ss.'"
            },
            "effectiveDateTime": "'.$today.'",
            "issued": "'.$today.'",
            "valueString": "' . $value . '"
        }';

        curl_setopt_array($curl_observation, array(
            CURLOPT_URL => $url_create_observasi,
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

        $response_observasi = curl_exec($curl_observation);
        $id_observation = json_decode($response_observasi);
        curl_close($curl_observation);
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
            'service_name'  => 'observation_post_lokasi_nyeri'
        ]);
        return $id_observation_ss;
    }

    

    public static function EncounterPutMasukRuanganTriage($registrasi_id){
        $reg                = Registrasi::find($registrasi_id);
        $access_token       = SatuSehatController::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $today              = dateTimeUTC(now()->format('Y-m-d H:i:s'));
        $encounter_body      = SatuSehatController::EncounterGet($reg->id_encounter_ss);
        if( $encounter_body == null){
            return null;
        }
        $update_encounter   = config('app.create_encounter') . "/$reg->id_encounter_ss";
        // Update
        $encounter_body->status = "triaged";
        $encounter_body->statusHistory[0]->period->end = $today;
        $encounter_body->statusHistory[1] = [
            'status'    => 'triaged',
            'period'    => [
                'start' => $today
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
            CURLOPT_POSTFIELDS      => json_encode($encounter_body),
            CURLOPT_HTTPHEADER      => array(
                'Authorization: Bearer '.@$access_token.'',
                'Content-Type: application/json'
            ),
        ));
        $response_encounter = curl_exec($curl_encounter);
        $id_encounter = json_decode($response_encounter);
        curl_close($curl_encounter);

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
            'service_name'  => 'encouter_put_masuk_ruangan_triage'
        ]);
        return $id_ss_encounter;
    }

    public static function EncounterPutMasukRuanganTindakan($registrasi_id){
        $reg                = Registrasi::find($registrasi_id);
        $location           = Poli::where('satusehat_room', 'Y')->where('nama', 'Ruangan Tindakan Kebidanan')->where('politype', 'G')->latest()->first();
        $access_token       = SatuSehatController::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $today              = dateTimeUTC(now()->format('Y-m-d H:i:s'));
        $encounter_body      = SatuSehatController::EncounterGet($reg->id_encounter_ss);
        if( $encounter_body == null){
            return null;
        }
        $update_encounter   = config('app.create_encounter') . "/$reg->id_encounter_ss";
        // Update
        $encounter_body->status = "in-progress";
        $encounter_body->statusHistory[1]->period->end = $today;
        $encounter_body->statusHistory[2] = [
            'status'    => 'in-progress',
            'period'    => [
                'start' => $today
            ]
        ];
        $encounter_body->location[0]->period->end = $today;
        $encounter_body->location[1] = json_decode('{
            "location": {
                "reference": "Location/'.$location->id_location_ss.'",
                "display": "'.$location->nama.'"
            },
            "period": {
                "start": "'.$today.'"
            },
            "extension": [
                {
                    "url": "https://fhir.kemkes.go.id/r4/StructureDefinition/ServiceClass",
                    "extension": [
                        {
                            "url": "value",
                            "valueCodeableConcept": {
                                "coding": [
                                    {
                                        "system": "http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Outpatient",
                                        "code": "reguler",
                                        "display": "Kelas Reguler"
                                    }
                                ]
                            }
                        },
                        {
                            "url": "upgradeClassIndicator",
                            "valueCodeableConcept": {
                                "coding": [
                                    {
                                        "system": "http://terminology.kemkes.go.id/CodeSystem/locationUpgradeClass",
                                        "code": "kelas-tetap",
                                        "display": "Kelas Tetap Perawatan"
                                    }
                                ]
                            }
                        }
                    ]
                }
            ]
        }');
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
        $id_encounter = json_decode($response_encounter);
        curl_close($curl_encounter);

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
            'service_name'  => 'encouter_put_masuk_ruangan_tindakan'
        ]);
        return $id_ss_encounter;
    }

    public static function ConditionPostKeluhanUtama($registrasi_id, $keluhan){
        $reg                = Registrasi::find($registrasi_id);
        $patient            = $reg->pasien;
        $id_encounter_ss    = $reg->id_encounter_ss;
        $create_condition   = config('app.create_condition');
        $access_token       = SatuSehatController::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $keluhan_utama  = SnomedCTChildren::where('concept_id', $keluhan)->first();
        if (empty($keluhan_utama)) {
            return NULL;
        }
        $curl_condition = curl_init();
        $body = '{
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
                            "code": "'.$keluhan_utama->concept_id.'",
                            "display": "'.$keluhan_utama->fsn_term.'"
                        }
                    ]
                },
                "subject": {
                    "reference": "Patient/'.$patient->id_patient_ss.'",
                    "display": "'.$patient->nama.'"
                },
                "encounter": {
                    "reference": "Encounter/'.$id_encounter_ss.'",
                    "display": "Kunjungan '.$patient->nama.' Pada tanggal '.date('Y-m-d H:i:s').'"
                }
        }';
        curl_setopt_array($curl_condition, array(
            CURLOPT_URL => $create_condition,
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
            'request'        => @$body,
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'condition_post_keluhan_utama',
            'extra'         => json_encode([
                'patient_id'        => @$patient->id,
                'patient_id_ss'        => @$patient->id_patient_ss,
                'sctid'               => @$keluhan_utama->concept_id,
            ])
        ]);
        return $id_condition_ss;
    }

    public static function ConditionPostRiwayatPenyakit($registrasi_id, $riwayat){
        $reg                = Registrasi::find($registrasi_id);
        $patient            = $reg->pasien;
        $id_encounter_ss    = $reg->id_encounter_ss;
        $create_condition   = config('app.create_condition');
        $access_token       = SatuSehatController::createToken();
        if(@$access_token == NULL){
            return NULL;
        }
        $riwayat_penyakit  = SnomedCTChildren::where('concept_id', $riwayat)->first();
        if (empty($riwayat_penyakit)) {
            return NULL;
        }
        $curl_condition = curl_init();
        $body = '{
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
                        "code": "'.$riwayat_penyakit->concept_id.'",
                        "display": "'.$riwayat_penyakit->fsn_term.'"
                    }
                ]
            },
            "subject": {
                "reference": "Patient/'.$patient->id_patient_ss.'",
                "display": "'.$patient->nama.'"
            },
            "encounter": {
                "reference": "Encounter/'.$id_encounter_ss.'",
                "display": "Kunjungan '.$patient->nama.' Pada tanggal '.date('Y-m-d H:i:s').'"
            }
        }';
        curl_setopt_array($curl_condition, array(
            CURLOPT_URL => $create_condition,
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
            'request'        => @$body,
            'response'      => json_encode($condition_ss),
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'condition_post_riwayat_penyakit',
            'extra'         => json_encode([
                'patient_id'        => @$patient->id,
                'patient_id_ss'        => @$patient->id_patient_ss,
                'sctid'               => @$riwayat_penyakit->concept_id,
            ])
        ]);
        return $id_condition_ss;
    }

    public static function AllergyIntolerancePost($registrasi_id){
        $reg                = Registrasi::find($registrasi_id);
        $patient            = $reg->pasien;
        $id_encounter_ss    = $reg->id_encounter_ss;
        $organization_id    = config('app.organization_id');
        $practitioner       = Pegawai::find($reg->dokter_id);
        $create_allergy   = config('app.create_allergy');
        $access_token       = SatuSehatController::createToken();
        $today              = dateTimeUTC(now()->format('Y-m-d H:i:s'));
        if(@$access_token == NULL){
            return NULL;
        }
        $triage             = EmrInapPemeriksaan::where('type', 'triage-igd')->where('registrasi_id', $registrasi_id)->first();
        if(empty(@$triage)){
            return NULL;
        }
        $triage             = json_decode($triage->fisik);
        $status_allergy            = @$triage->alergi->ada == "Ada" ? "active" : "inactive";
        $clinical_status_code = $status_allergy == "active" ? "active" : "inactive";
        $clinical_status_display = $status_allergy == "active" ? "Active" : 'Inactive';

        $allergy = Allergy::where('code', @$triage->alergi->pilihan)->first();

        if (empty($allergy)) {
            return NULL;
        }

        $curl_allergy = curl_init();
        $body = '{
            "resourceType": "AllergyIntolerance",
            "identifier": [
                {
                    "system": "http://sys-ids.kemkes.go.id/allergy/'.$organization_id.'",
                    "use": "official",
                    "value": "'.$reg->id.'"
                }
            ],
            "clinicalStatus": {
                "coding": [
                    {
                        "system": "http://terminology.hl7.org/CodeSystem/allergyintolerance-clinical",
                        "code": "'.$clinical_status_code.'",
                        "display": "'.$clinical_status_display.'"
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
                "food",
                "medication",
                "environment",
                "biologic"
            ],
            "code": {
                "coding": [
                    {
                        "system": "'.$allergy->codesystem.'",
                        "code": "'.$allergy->code.'",
                        "display": "'.$allergy->display.'"
                    }
                ],
                "text": "'.@$triage->alergi->ket.'"
            },
            "patient": {
                "reference": "Patient/'.$patient->id_patient_ss.'",
                "display": "'.$patient->nama.'"
            },
            "encounter": {
                "reference": "Encounter/'.$id_encounter_ss.'",
                "display": "Kunjungan '.$patient->nama.' pada tanggal '.date('Y-m-d H:i:s').'"
            },
            "recordedDate": "'.$today.'",
            "recorder": {
                "reference": "Practitioner/'.$practitioner->id_dokterss.'"
            }
        }';
        curl_setopt_array($curl_allergy, array(
            CURLOPT_URL => $create_allergy,
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
        $response_allergy = curl_exec($curl_allergy);
        $allergy = json_decode($response_allergy);
        curl_close($curl_allergy);
        if(!empty($allergy->id)){
            $id_allergy = $allergy->id;
        }else{
            $id_allergy = NULL;
        }
        RecordSatuSehat::create([
            'registrasi_id' => $registrasi_id,
            'status'        => $id_allergy ? 'successed' : 'failed',
            'request'        => @$body,
            'response'      => json_encode($allergy),
            'status_reg'    => @$reg->status_reg,
            'service_name'  => 'allergy_intolerance',
            'extra'         => json_encode([
                'patient_id'        => @$patient->id,
                'patient_id_ss'     => @$patient->id_patient_ss,
                'practitioner_id'   => $practitioner->id_dokterss,
                'id_encounter'      => $id_encounter_ss,
            ])
        ]);
        return $id_allergy;
    }
}
