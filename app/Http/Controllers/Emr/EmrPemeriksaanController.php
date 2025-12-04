<?php

namespace App\Http\Controllers\Emr;

use App\Emr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MercurySeries\Flashy\Flashy;
use App\Http\Controllers\Controller;
use Modules\Registrasi\Entities\Registrasi;
use App\EmrInapPemeriksaan;
use App\EmrInapPenilaian;
use App\EmrInapPerencanaan;
use App\Predictive;
use App\FaskesLanjutan;
use App\KondisiAkhirPasien;
use App\Pasien;
use App\TandaTangan;
use App\Satusehat;
use App\DiagnosaKeperawatan;
use App\Http\Controllers\LogUserController;
use App\IntervensiKeperawatan;
use App\ImplementasiKeperawatan;
use App\ResepNote;
use App\ResepNoteDetail;
use App\SuratInap;
use Auth;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Folio;
use Modules\Tarif\Entities\Tarif;
use Modules\Kamar\Entities\Kamar;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use App\Hasillab;
use App\EmrEws;
use App\Rawatinap;
use App\PerawatanIcd10;
use App\PerawatanIcd9;
use Modules\Kelas\Entities\Kelas;
use App\PaguPerawatan;
use App\Inacbgs_sementara;
use App\inhealthSjp;
use App\EmrKonsul;
use App\Historipengunjung;
use App\FaskesRujukanRs;
use App\SnomedCT;
use App\Allergy;
use App\HasilPemeriksaan;
use App\Http\Controllers\SatuSehatIGDController;
use Modules\Pasien\Entities\Pasien as EntitiesPasien;

class EmrPemeriksaanController extends Controller
{

    // Pemeriksaan
    public function tandavital(Request $r, $unit, $registrasi_id)
    {


        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'tanda_vital')->orderBy('id', 'DESC')->get();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r->all());
            // $alatbantu = json_encode($r->alatbantu);
            $emr = new EmrInapPemeriksaan();
            $emr->pasien_id = $r->pasien_id;
            $emr->registrasi_id = $r->registrasi_id;
            $emr->user_id = Auth::user()->id;
            $emr->tanda_vital = json_encode($r->pemeriksaan);
            $emr->type = 'tanda_vital';
            $emr->save();

            Flashy::success('Record berhasil disimpan');
            return redirect()->back();
        }


        return view('emr.modules.pemeriksaan.tanda_vital', $data);
    }

    public function nutrisi(Request $r, $unit, $registrasi_id)
    {


        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'nutrisi')->orderBy('id', 'DESC')->get();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r->all());
            // $alatbantu = json_encode($r->alatbantu);
            $emr = new EmrInapPemeriksaan();
            $emr->pasien_id = $r->pasien_id;
            $emr->registrasi_id = $r->registrasi_id;
            $emr->user_id = Auth::user()->id;
            $emr->nutrisi = json_encode($r->pemeriksaan);
            $emr->type = 'nutrisi';
            $emr->save();

            Flashy::success('Record berhasil disimpan');
            return redirect()->back();
        }


        return view('emr.modules.pemeriksaan.nutrisi', $data);
    }

    public function fungsional(Request $r, $unit, $registrasi_id)
    {


        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fungsional')->orderBy('id', 'DESC')->get();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r->all());
            // $alatbantu = json_encode($r->alatbantu);
            $emr = new EmrInapPemeriksaan();
            $emr->pasien_id = $r->pasien_id;
            $emr->registrasi_id = $r->registrasi_id;
            $emr->user_id = Auth::user()->id;
            $emr->fungsional = json_encode($r->pemeriksaan);
            $emr->type = 'fungsional';
            $emr->save();

            Flashy::success('Record berhasil disimpan');
            return redirect()->back();
        }


        return view('emr.modules.pemeriksaan.fungsional', $data);
    }
    public function fisik(Request $r, $unit, $registrasi_id)
    {


        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'gigi_umum')->orderBy('id', 'DESC')->get();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r->all());
            // $alatbantu = json_encode($r->alatbantu);
            $emr = new EmrInapPemeriksaan();
            $emr->pasien_id = $r->pasien_id;
            $emr->registrasi_id = $r->registrasi_id;
            $emr->user_id = Auth::user()->id;
            $emr->fisik = json_encode($r->fisik);
            $emr->type = 'gigi_umum';
            $emr->save();

            Flashy::success('Record berhasil disimpan, mohon segera lakukan TTE pada menu hasil -> histori -> E-Resume');
            return redirect()->back();
        }


        return view('emr.modules.pemeriksaan_fisik', $data);
    }


    public function fisikUmum(Request $r, $unit, $registrasi_id)
    {
        // dd($r->tanda_vital);
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        // if ($data['reg']->nomorantrian) {
        //     @updateTaskId(5, $data['reg']->nomorantrian);//RUN TASKID 5
        // }
        $data['riwayats'] = EmrInapPemeriksaan::leftJoin('registrasis', 'registrasis.id', '=', 'emr_inap_pemeriksaans.registrasi_id')
            ->where('registrasis.poli_id', $data['reg']->poli_id)
            ->where('emr_inap_pemeriksaans.pasien_id', $data['reg']->pasien_id)
            ->where('emr_inap_pemeriksaans.type', 'fisik_umum')
            ->orderBy('emr_inap_pemeriksaans.id', 'DESC')
            ->select('emr_inap_pemeriksaans.*')
            ->get();
        $data['riwayats_pemantauan'] = EmrInapPemeriksaan::leftJoin('registrasis', 'registrasis.id', '=', 'emr_inap_pemeriksaans.registrasi_id')
            ->where('registrasis.poli_id', $data['reg']->poli_id)
            ->where('emr_inap_pemeriksaans.pasien_id', $data['reg']->pasien_id)
            ->where('emr_inap_pemeriksaans.registrasi_id', $data['reg']->id)
            ->where('emr_inap_pemeriksaans.type', 'pemantauan-transfusi')
            ->orderBy('emr_inap_pemeriksaans.id', 'DESC')
            ->select('emr_inap_pemeriksaans.*')
            ->get();
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->first();
        if ($data['gambar'] && $data['gambar']->fisik != null) {
            $data['ketGambar'] = json_decode($data['gambar']->fisik, true);
        }
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();
        $data['faskesRujukanRs'] = FaskesRujukanRs::all();

        $askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
        if ($askep) {
            $data['siki'] = json_decode($askep->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($askep->fungsional, true);
            $data['diagnosis'] = json_decode($askep->diagnosis, true);
        }

        $visum = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'visum')->first();
        if ($visum) {
            $data['visum'] = json_decode($visum->keterangan, true);
        }

        $resep = ResepNote::where('registrasi_id', $registrasi_id)->where('is_done_input', '1')->orderBy('id', 'DESC')->first();
        // dd($resep);
        $data['namaObat'] = [];

        if ($resep) {
            $resepDetail = ResepNoteDetail::where('resep_note_id', $resep->id)->select('logistik_batch_id', 'cara_minum')->get();

            foreach ($resepDetail as $item) {
                $data['namaObat'][] = [
                    'obat' => $item->logistik_batch->master_obat->nama,
                    'signa' => $item->cara_minum,
                ];
            }
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_umum')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_umum')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
            // $data['diagnosis'] = json_decode($assesment->diagnosis, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_umum')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
            // $data['diagnosis'] = json_decode(@$assesment->diagnosis, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_umum')->first();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$r->registrasi_id);
            $pegawai = Pegawai::where('user_id', Auth::user()->id)
                        ->where('kategori_pegawai', 1)
                        ->first();
            if (($data['reg']->nomorantrian) && ($pegawai)) {
                @updateTaskId(5, $data['reg']->nomorantrian);//RUN TASKID 5
            }
            
            $kategoriPegawai = Auth::user()->pegawai->kategori_pegawai;
            if ($kategoriPegawai == 1) {
                $r->validate([
                    'fisik.anamnesa' => 'required',
                    'fisik.pemeriksaan_fisik' => 'required',
                    'fisik.diagnosis' => 'required',
                    'fisik.planning' => 'required',
                    'fisik.dischargePlanning.*' => 'required',
                ], [
                    'fisik.anamnesa.required' => 'Anamnesa wajib diisi',
                    'fisik.pemeriksaan_fisik.required' => 'Pemeriksaan fisik wajib diisi',
                    'fisik.diagnosis.required' => 'Diagnosis wajib diisi',
                    'fisik.planning.required' => 'Planning wajib diisi',
                ]);

                // Manual validate

                $dpKontrol = @$r['fisik']['dischargePlanning']['kontrol']['dipilih'];
                $dpKontrolPRB = @$r['fisik']['dischargePlanning']['kontrolPRB']['dipilih'];
                $dpDirawat = @$r['fisik']['dischargePlanning']['dirawat']['dipilih'];
                $dpDirujuk = @$r['fisik']['dischargePlanning']['dirujuk']['dipilih'];
                $dpKonsultasi = @$r['fisik']['dischargePlanning']['Konsultasi']['dipilih'];
                $dppulpak = @$r['fisik']['dischargePlanning']['pulpak']['dipilih'];
                $dpmeninggal = @$r['fisik']['dischargePlanning']['meninggal']['dipilih'];

                if ($dpKontrol == null && $dpKontrolPRB == null && $dpDirawat == null && $dpDirujuk == null && $dpKonsultasi == null && $dppulpak == null && $dpmeninggal == null) {
                    return redirect()->back()->with('error_dp', 'Discharge Planning wajib diisi');
                }
            }

            // dd($r['fisik']['tanda_vital']);
            $id_observation_ss = NULL;

            if (Satusehat::find(11)->aktif == 1) {
                if (satusehat()) {


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
                        CURLOPT_POSTFIELDS => 'client_id=' . $client_id . '&client_secret=' . $client_secret,
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/x-www-form-urlencoded'
                        ),
                    ));

                    $response_token = curl_exec($curl_token);
                    // dd($response_token);
                    @$token = json_decode($response_token);
                    @$access_token = @$token->access_token;
                    curl_close($curl_token);
                    // END OF API TOKEN
                }








                if (satusehat()) {
                    // API CREATE OBSERVASI
                    $url_create_observasi = config('app.create_observation');
                    $id_dokter_ss = Pegawai::find(Registrasi::find($r['registrasi_id'])->dokter_id)->id_dokterss;
                    $id_encounter_ss = Registrasi::find($r['registrasi_id'])->id_encounter_ss;
                    $pasien_ss = Pasien::find($r['pasien_id'])->nama;
                    $pasien_ss_id = Pasien::find($r['pasien_id'])->id_patient_ss;
                    $time = date('H:i:s');
                    $time_2 = date('H:i');
                    $date = date('d F Y');
                    $waktu = time();
                    $today = date("Y-m-d", $waktu);


                    if (isset($r['fisik']['tanda_vital'])) {
                        if ($r['fisik']['tanda_vital']['temp'] > 38) {
                            $code = 'H';
                            $code_disp = 'High';
                        } elseif ($r['fisik']['tanda_vital']['temp'] < 35) {
                            $code = 'L';
                            $code_disp = 'Low';
                        } else {
                            $code = 'N';
                            $code_disp = 'Normal';
                        }
                    }

                    // dd($today);
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
                        CURLOPT_POSTFIELDS => '{
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
                    "reference": "Patient/' . $pasien_ss_id . '"
                },
                "performer": [
                    {
                        "reference": "Practitioner/' . $id_dokter_ss . '"
                    }
                ],
                "encounter": {
                    "reference": "Encounter/' . $id_encounter_ss . '",
                    "display": "Pemeriksaan Suhu Tubuh ' . $pasien_ss . ' di tanggal ' . $today . '"
                },
                "effectiveDateTime": "' . $today . 'T' . $time . '+07:00",
                "issued": "' . $today . 'T' . $time . '+07:00",
                "valueQuantity": {
                    "value": ' . @$r['fisik']['tanda_vital']['temp'] . ',
                    "unit": "C",
                    "system": "http://unitsofmeasure.org",
                    "code": "Cel"
                }
            }',
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Bearer ' . $access_token . '',
                            'Content-Type: application/json'
                        ),
                    ));

                    $response_observasi = curl_exec($curl_observation);
                    // dd($response_observasi);
                    $id_observation = json_decode($response_observasi);
                    if (!empty($id_observation->id)) {
                        $id_observation_ss = $id_observation->id;
                    } else {
                        $id_observation_ss = NULL;
                    }
                    // dd($id_observation_ss);
                    curl_close($curl_observation);
                    // END OF API CREATE OBSERVASI
                }
            }







            if ($r->asessment_id != null) {
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $update->id_observation_ss = @$id_observation_ss ? @$id_observation_ss : null;
                if (!empty($r->file('planning_file'))) {
                    $file_planning = 'RM_' . $r['registrasi_id'] . '_planning_' . $r->file('planning_file')->getClientOriginalName();
                    $update->file_planning = $file_planning;
                    $r->file('planning_file')->move(public_path() . '/emr_file', $file_planning);
                }
                if (!empty($r->file('diagnosis_file'))) {
                    $file_diagnosis = 'RM_' . $r['registrasi_id'] . '_diag_' . $r->file('diagnosis_file')->getClientOriginalName();
                    $update->file_diagnosis = $file_diagnosis;
                    $r->file('diagnosis_file')->move(public_path() . '/emr_file', $file_diagnosis);
                }

                $update->fisik = json_encode($asessment_new);
                $update->update();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_umum')->orderBy('id', 'DESC')->first();
                @$asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    @$asessment_new = @array_merge(@$asessment_old, @$r->fisik);
                } else {
                    @$asessment_new = @$asessment_old;
                }
                // dd($id_observation_ss);

                //User Dokter
                if ($kategoriPegawai == 1 && $asessment->userdokter_id == null) {
                    $asessment->userdokter_id = Auth::user()->id;
                }
                //User Selain Dokter
                if ($kategoriPegawai != 1 && $asessment->user_id == 0) {
                    $asessment->user_id = Auth::user()->id;
                }

                $asessment->fisik = json_encode($asessment_new);
                // $asessment->diagnosis = json_encode($diagnosis_new);
                @$asessment->id_observation_ss = @$id_observation_ss ? @$id_observation_ss : null;
                // dd($assesment->id_observation_ss);
                if (!empty($r->file('planning_file'))) {
                    $file_planning = 'RM_' . $r['registrasi_id'] . '_planning_' . $r->file('planning_file')->getClientOriginalName();
                    $asessment->file_planning = $file_planning;
                    $r->file('planning_file')->move(public_path() . '/emr_file', $file_planning);
                }
                if (!empty($r->file('diagnosis_file'))) {
                    $file_diagnosis = 'RM_' . $r['registrasi_id'] . '_diag_' . $r->file('diagnosis_file')->getClientOriginalName();
                    $asessment->file_diagnosis = $file_diagnosis;
                    $r->file('diagnosis_file')->move(public_path() . '/emr_file', $file_diagnosis);
                }
                $asessment->update();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->id_observation_ss = @$id_observation_ss ? @$id_observation_ss : null;

                //User Dokter
                if ($kategoriPegawai == 1) {
                    $asessment->userdokter_id = Auth::user()->id;
                }

                //User Selain Dokter
                if ($kategoriPegawai != 1) {
                    $asessment->user_id = Auth::user()->id;
                }
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'fisik_umum';
                if (!empty($r->file('planning_file'))) {
                    $file_planning = 'RM_' . $r['registrasi_id'] . '_planning_' . $r->file('planning_file')->getClientOriginalName();
                    $asessment->file_planning = $file_planning;
                    $r->file('planning_file')->move(public_path() . '/emr_file', $file_planning);
                }
                if (!empty($r->file('diagnosis_file'))) {
                    $file_diagnosis = 'RM_' . $r['registrasi_id'] . '_diag_' . $r->file('diagnosis_file')->getClientOriginalName();
                    $asessment->file_diagnosis = $file_diagnosis;
                    $r->file('diagnosis_file')->move(public_path() . '/emr_file', $file_diagnosis);
                }
                $asessment->save();
                Flashy::success('Record berhasil disimpan, mohon segera lakukan TTE pada menu hasil -> histori -> E-Resume');
                return redirect()->back();
            }
        }
        return view('emr.modules.pemeriksaan.fisik', $data);
    }

    public function pemantauanTransfusi(Request $r, $unit, $registrasi_id)
    {
        $data['pemantauanTransfusi'] = null;
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats_pemantauan'] = EmrInapPemeriksaan::leftJoin('registrasis', 'registrasis.id', '=', 'emr_inap_pemeriksaans.registrasi_id')
            ->where('registrasis.poli_id', $data['reg']->poli_id)
            ->where('emr_inap_pemeriksaans.pasien_id', $data['reg']->pasien_id)
            ->where('emr_inap_pemeriksaans.registrasi_id', $data['reg']->id)
            ->where('emr_inap_pemeriksaans.type', 'pemantauan-transfusi')
            ->orderBy('emr_inap_pemeriksaans.id', 'DESC')
            ->select('emr_inap_pemeriksaans.*')
            ->get();

        if ($r->pemantauan_transfusi_id) {
            $data['pemantauanTransfusi'] = EmrInapPemeriksaan::find($r->pemantauan_transfusi_id);
        }

        if ($r->method() == 'POST') {
            if ($r->pemantauan_transfusi_id) {
                $asessment = EmrInapPemeriksaan::find($r->pemantauan_transfusi_id);
                Flashy::success('Record berhasil diperbarui');
            } else {
                $asessment = new EmrInapPemeriksaan();
                Flashy::success('Record berhasil disimpan');
            }
            $asessment->pasien_id = $r->pasien_id;
            $asessment->registrasi_id = $r->registrasi_id;
            $asessment->user_id = Auth::user()->id;
            $asessment->fisik = json_encode($r->fisik);
            $asessment->type = 'pemantauan-transfusi';
            $asessment->save();
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.pemantauan-transfusi', $data);
    }

    public function apgarScore(Request $r, $unit, $registrasi_id)
    {
        $data['apgarScore'] = null;
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats_apgar_score'] = EmrInapPemeriksaan::leftJoin('registrasis', 'registrasis.id', '=', 'emr_inap_pemeriksaans.registrasi_id')
            ->where('registrasis.poli_id', $data['reg']->poli_id)
            ->where('emr_inap_pemeriksaans.pasien_id', $data['reg']->pasien_id)
            ->where('emr_inap_pemeriksaans.registrasi_id', $data['reg']->id)
            ->where('emr_inap_pemeriksaans.type', 'apgar-score')
            ->orderBy('emr_inap_pemeriksaans.id', 'DESC')
            ->select('emr_inap_pemeriksaans.*')
            ->get();
        if ($r->apgar_score_id) {
            $data['apgarScore'] = EmrInapPemeriksaan::find($r->apgar_score_id);
            if (empty($data['apgarScore'])) {
                return redirect(url()->current());
            }
        } else {
            $data['apgarScore'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)
                ->where('type', 'apgar-score')
                ->orderBy('id', 'DESC')
                ->first();
        }

        if ($r->method() == 'POST') {
            if ($r->apgar_score_id) {
                $asessment = EmrInapPemeriksaan::find($r->apgar_score_id);
                Flashy::success('Record berhasil diperbarui');
            } else {
                $asessment = new EmrInapPemeriksaan();
                Flashy::success('Record berhasil disimpan');
            }
            $asessment->pasien_id = $r->pasien_id;
            $asessment->registrasi_id = $r->registrasi_id;
            $asessment->user_id = Auth::user()->id;
            $asessment->fisik = json_encode($r->fisik);
            $asessment->type = 'apgar-score';
            $asessment->save();
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.apgar-score', $data);
    }

    public function cetakapgarScore($registrasi_id, $riwayat_id)
    {

        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['apgarScore'] = EmrInapPemeriksaan::find($riwayat_id);

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-apgar-score', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Apgar_score_' . $riwayat_id . '_' . $data['reg']->pasien->nama . '.pdf');

        // return view('emr.modules.cetak-apgar-score', $data);
    }
    public function cetak_pengkajian_gizi($registrasi_id, $riwayat_id)
    {

        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $asessment = EmrInapPemeriksaan::find($riwayat_id);
        $data['assesment'] = json_decode(@$asessment->fisik, true);

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-pengkajian-gizi', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('PengkajianGizi_' . $riwayat_id . '_' . $data['reg']->pasien->nama . '.pdf');

        // return view('emr.modules.cetak-apgar-score', $data);
    }

    public function ballardScore(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['ballardScore'] = EmrInapPemeriksaan::leftJoin('registrasis', 'registrasis.id', '=', 'emr_inap_pemeriksaans.registrasi_id')
            ->where('registrasis.poli_id', $data['reg']->poli_id)
            ->where('emr_inap_pemeriksaans.pasien_id', $data['reg']->pasien_id)
            ->where('emr_inap_pemeriksaans.registrasi_id', $data['reg']->id)
            ->where('emr_inap_pemeriksaans.type', 'ballard-score')
            ->orderBy('emr_inap_pemeriksaans.id', 'DESC')
            ->select('emr_inap_pemeriksaans.*')
            ->first();

        if ($r->method() == 'POST') {
            if (!empty($data['ballardScore'])) {
                $asessment = $data['ballardScore'];
                Flashy::success('Record berhasil diperbarui');
            } else {
                $asessment = new EmrInapPemeriksaan();
                Flashy::success('Record berhasil disimpan');
            }
            $asessment->pasien_id = $r->pasien_id;
            $asessment->registrasi_id = $r->registrasi_id;
            $asessment->user_id = Auth::user()->id;
            $asessment->fisik = json_encode($r->fisik);
            $asessment->type = 'ballard-score';
            $asessment->save();
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.ballard-score', $data);
    }

    public function cetakballardScore($registrasi_id)
    {

        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['ballardScore'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'ballard-score')->first();

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-ballard-score', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Ballard_score_' . $data['reg']->pasien->nama . '.pdf');
    }

    public function usiaKehamilan(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['usiaKehamilan'] = EmrInapPemeriksaan::leftJoin('registrasis', 'registrasis.id', '=', 'emr_inap_pemeriksaans.registrasi_id')
            ->where('registrasis.poli_id', $data['reg']->poli_id)
            ->where('emr_inap_pemeriksaans.pasien_id', $data['reg']->pasien_id)
            ->where('emr_inap_pemeriksaans.registrasi_id', $data['reg']->id)
            ->where('emr_inap_pemeriksaans.type', 'usia-kehamilan')
            ->orderBy('emr_inap_pemeriksaans.id', 'DESC')
            ->select('emr_inap_pemeriksaans.*')
            ->first();

        if ($r->method() == 'POST') {
            if (!empty($data['usiaKehamilan'])) {
                $asessment = $data['usiaKehamilan'];
                Flashy::success('Record berhasil diperbarui');
            } else {
                $asessment = new EmrInapPemeriksaan();
                Flashy::success('Record berhasil disimpan');
            }
            $asessment->pasien_id = $r->pasien_id;
            $asessment->registrasi_id = $r->registrasi_id;
            $asessment->user_id = Auth::user()->id;
            $asessment->fisik = json_encode($r->fisik);
            $asessment->type = 'usia-kehamilan';
            $asessment->save();
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.usia-kehamilan', $data);
    }

    public function cetakPemantauanTransfusi($id)
    {
        $data['cetak'] = EmrInapPemeriksaan::find($id);
        $data['pasien'] = Pasien::find($data['cetak']->pasien_id);
        $pdf = PDF::loadView('emr.modules._cetak_pemantauan_transfusi', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }

    public function cetakMCU($id)
    {
        $mcu = EmrInapPemeriksaan::find($id);
        $emrPemeriksaan = EmrInapPemeriksaan::where('registrasi_id', $mcu->registrasi_id)->where('type', 'fisik_mcu')->orderBy('id', 'DESC')->first();
        $reg = Registrasi::find($mcu->registrasi_id);
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $poli = poli::find($reg->poli_id);
        $pdf = PDF::loadView('emr.modules._cetak_pemeriksaan_mcu', compact('reg', 'mcu', 'emrPemeriksaan', 'tgl', 'poli'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('pemeriksaan_mcu.pdf');
    }

    public function cetakTTEPDFMCU($reg_id, $id)
    {
        $mcu   = EmrInapPemeriksaan::find($id);
        $tte = json_decode($mcu->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="MCU-' . $reg_id . '-' . $id . '.pdf"',
        ]);
    }

    public function cetakHasilMCU($id)
    {
        $mcu = EmrInapPemeriksaan::find($id);
        $mcu_perawat = EmrInapPemeriksaan::where('type', 'mcu_perawat')->where('registrasi_id', $mcu->registrasi_id)->get();
        $reg = Registrasi::find($mcu->registrasi_id);
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $poli = poli::find($reg->poli_id);
        $pdf = PDF::loadView('emr.modules._cetak_hasil_medical_checkup', compact('reg', 'mcu', 'mcu_perawat', 'tgl', 'poli'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('pemeriksaan_hasil_mcu.pdf');
    }

    public function cetakTTEPDFHasilMCU($reg_id, $id)
    {
        $mcu   = EmrInapPemeriksaan::find($id);
        $tte = json_decode($mcu->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="MCU-' . $reg_id . '-' . $id . '.pdf"',
        ]);
    }

    public function cetakIBS($id)
    {
        $ibs = EmrInapPemeriksaan::find($id);
        $reg = Registrasi::find($ibs->registrasi_id);
        $pdf = PDF::loadView('emr.modules._cetak_ibs', compact('reg', 'ibs'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('pre_operatif.pdf');
    }

    public function ibs(Request $r, $unit, $registrasi_id)
    {
        // dd($r->tanda_vital);
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'ibs')->orderBy('id', 'DESC')->get();
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'ibs')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'ibs')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'ibs')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        // dd( $data['assesment']);
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'ibs')->first();

        $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asuhan-keperawatan')->first();

        if ($assesment) {
            $data['diagnosis'] = json_decode($assesment->diagnosis, true);
            $data['siki'] = json_decode($assesment->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($assesment->fungsional, true);
        }

        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'ibs')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'ibs';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'ibs';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back();
            }
        }
        return view('emr.modules.pemeriksaan.ibs', $data);
    }


    public function asuhanBidan(Request $r, $unit, $registrasi_id)
    {

        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->whereIn('type', ['asuhan-kebidanan', 'asuhan-keperawatan'])->orderBy('id', 'DESC')->get();
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::where('jenis', 'Askeb')->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-kebidanan')->exists();

        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asuhan-kebidanan')->first();
            // $data['assesment']  = json_decode($assesment->fisik, true);
            $data['diagnosis'] = json_decode($assesment->diagnosis, true);
            $data['siki'] = json_decode($assesment->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($assesment->fungsional, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-kebidanan')->first();
            // $data['assesment'] = json_decode(@$assesment->fisik, true);
            $data['diagnosis'] = json_decode(@$assesment->diagnosis, true);
            $data['siki'] = json_decode(@$assesment->pemeriksaandalam, true);
            $data['implementasi'] = json_decode(@$assesment->fungsional, true);
        }

        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-kebidanan')->first();


        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            // if ($asessmentExists) {
            //     $asessment          =  EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-kebidanan')->orderBy('id', 'DESC')->first();
            //     $diagnosis_old = json_decode($asessment->diagnosis, true);
            //     $siki_old = json_decode($asessment->pemeriksaandalam, true);
            //     $implementasi_old = json_decode($asessment->fungsional, true);

            //     $diagnosis_new = [];
            //     $siki_new = [];
            //     $implementasi_new = [];

            //     if (is_array($r->diagnosa)) {
            //         if ($diagnosis_old == null) {
            //             $diagnosis_new = $r->diagnosa;
            //         } else {
            //             $diagnosis_new = array_merge($diagnosis_old, $r->diagnosa);
            //         }
            //     } else {
            //         $diagnosis_new = $diagnosis_old;
            //     }

            //     if (is_array($r->pemeriksaanDalam)) {
            //         if ($siki_old == null) {
            //             $siki_new = $r->pemeriksaanDalam;
            //         } else {
            //             $siki_new = array_merge($siki_old, $r->pemeriksaanDalam);
            //         }
            //     } else {
            //         $siki_new = $siki_old;
            //     }

            //     if (is_array($r->fungsional)) {
            //         if ($implementasi_old == null) {
            //             $implementasi_new = $r->fungsional;
            //         } else {
            //             $implementasi_new = array_merge($implementasi_old, $r->fungsional);
            //         }
            //     } else {
            //         $implementasi_new = $implementasi_old;
            //     }

            //     $asessment->fungsional = json_encode($implementasi_new);
            //     $asessment->pemeriksaandalam = json_encode($siki_new);
            //     $asessment->diagnosis = json_encode($diagnosis_new);
            //     $asessment->update();
            //     Flashy::success('Record berhasil diupdate');
            //     return redirect()->back();
            // } else {

            if (is_array($r->jam_tindakan)) {
                foreach ($r->jam_tindakan as $jam) {
                    $jam_tindakan[] = $jam ? date('Y-m-d H:i:s', (strtotime($jam))) : null;
                }
            } else {
                $jam_tindakan = $r->jam_tindakan ? date('Y-m-d H:i:s', (strtotime($r->jam_tindakan))) : null;
            }

            $asessment = new EmrInapPemeriksaan();
            $asessment->pasien_id = $r->pasien_id;
            $asessment->registrasi_id = $r->registrasi_id;
            $asessment->user_id = Auth::user()->id;
            $asessment->fisik = is_array($jam_tindakan) ? json_encode($jam_tindakan) : $jam_tindakan;
            $asessment->fungsional = json_encode($r->fungsional);
            $asessment->pemeriksaandalam = json_encode($r->pemeriksaanDalam);
            $asessment->diagnosis = json_encode($r->diagnosa);
            $asessment->type = 'asuhan-kebidanan';
            $asessment->save();
            Flashy::success('Record berhasil disimpan');
            return redirect()->back();
            // }
        }
        return view('emr.modules.pemeriksaan.asuhanKebidanan', $data);
    }




    public function asuhanKeperawatan(Request $r, $unit, $registrasi_id)
    {

        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->whereIn('type', ['asuhan-kebidanan', 'asuhan-keperawatan'])->orderBy('id', 'DESC')->get();
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::where('jenis', 'Askep')->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asuhan-keperawatan')->first();
            $data['diagnosis'] = json_decode(@$assesment->diagnosis, true);
            $data['siki'] = json_decode(@$assesment->pemeriksaandalam, true);
            $data['implementasi'] = json_decode(@$assesment->fungsional, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
            $data['diagnosis'] = json_decode(@$assesment->diagnosis, true);
            $data['siki'] = json_decode(@$assesment->pemeriksaandalam, true);
            $data['implementasi'] = json_decode(@$assesment->fungsional, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
        // dd($data['riwayat']);

        ini_set('max_execution_time', 0); //0=NOLIMIT
        ini_set('memory_limit', '8000M');
        $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
        $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
        $data['reg_id'] = $registrasi_id;
        $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
        $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
        $data['dokter'] = Pegawai::all();
        $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
        $data['kelas'] = Kelas::pluck('nama', 'id');
        $data['pagu'] = PaguPerawatan::all();
        if ($data['rawatinap']) {
            if (@$data['reg']->status_reg == NULL) {
                if ($data['rawatinap']->tgl_keluar) {
                    @$data['reg']->status_reg = 'I3';
                } else {
                    @$data['reg']->status_reg = 'I2';
                }
                @$data['reg']->save();
            }
        }

        if ($r->method() == 'POST') {
            // if ($asessmentExists) {
            //     $asessment          =  EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->orderBy('id', 'DESC')->first();
            //     // $asessment_old = json_decode($asessment->fisik, true);
            //     $diagnosis_old = json_decode($asessment->diagnosis, true);
            //     $siki_old = json_decode($asessment->pemeriksaandalam, true);
            //     $implementasi_old = json_decode($asessment->fungsional, true);

            //     // $asessment_new = [];
            //     $diagnosis_new = [];
            //     $siki_new = [];
            //     $implementasi_new = [];

            //     // if(is_array($r->fisik)){
            //     // 	$asessment_new = array_merge($asessment_old, $r->fisik );
            //     // }else{
            //     // 	$asessment_new = $asessment_old;
            //     // }

            //     if (is_array($r->diagnosa)) {
            //         if ($diagnosis_old == null) {
            //             $diagnosis_new = $r->diagnosa;
            //         } else {
            //             $diagnosis_new = array_merge($diagnosis_old, $r->diagnosa);
            //         }
            //     } else {
            //         $diagnosis_new = $diagnosis_old;
            //     }

            //     if (is_array($r->pemeriksaanDalam)) {
            //         if ($siki_old == null) {
            //             $siki_new = $r->pemeriksaanDalam;
            //         } else {
            //             $siki_new = array_merge($siki_old, $r->pemeriksaanDalam);
            //         }
            //     } else {
            //         $siki_new = $siki_old;
            //     }

            //     if (is_array($r->fungsional)) {
            //         if ($implementasi_old == null) {
            //             $implementasi_new = $r->fungsional;
            //         } else {
            //             $implementasi_new = array_merge($implementasi_old, $r->fungsional);
            //         }
            //     } else {
            //         $implementasi_new = $implementasi_old;
            //     }

            //     // $asessment->fisik   = json_encode($asessment_new);
            //     $asessment->fungsional = json_encode($implementasi_new);
            //     $asessment->pemeriksaandalam = json_encode($siki_new);
            //     $asessment->diagnosis = json_encode($diagnosis_new);
            //     $asessment->type      = 'asuhan-keperawatan';
            //     $asessment->save();
            //     Flashy::success('Record berhasil diupdate');
            //     return redirect()->back();
            // } else {
            if (is_array($r->jam_tindakan)) {
                foreach ($r->jam_tindakan as $jam) {
                    $jam_tindakan[] = $jam ? date('Y-m-d H:i:s', (strtotime($jam))) : null;

                }
            } else {
                $jam_tindakan = $r->jam_tindakan ? date('Y-m-d H:i:s', (strtotime($r->jam_tindakan))) : null;
            }
            if (is_array($r->keterangan)) {
                foreach ($r->keterangan as $ket) {
                    $keterangan[] = $ket;
                }
            } else {
                $keterangan = $r->keterangan ?? null;
            }

            $asessment = new EmrInapPemeriksaan();
            $asessment->pasien_id = $r->pasien_id;
            $asessment->registrasi_id = $r->registrasi_id;
            $asessment->user_id = Auth::user()->id;
            $asessment->fisik = is_array($jam_tindakan) ? json_encode($jam_tindakan) : $jam_tindakan;
            $asessment->keterangan = is_array($keterangan) ? json_encode($keterangan) : $keterangan;
            $asessment->fungsional = json_encode($r->fungsional);
            $asessment->pemeriksaandalam = json_encode($r->pemeriksaanDalam);
            $asessment->diagnosis = json_encode($r->diagnosa);
            $asessment->evaluasi = $r->evaluasi;
            $asessment->type = 'asuhan-keperawatan';
            $asessment->save();
            Flashy::success('Record berhasil disimpan');
            return redirect()->back();
            // }
        }
        return view('emr.modules.pemeriksaan.asuhanKeperawatan', $data);
    }

    public function getAskep(Request $request)
    {
        if ($request->multiple) {
            $diagnosa = DiagnosaKeperawatan::whereIn('nama', explode('|', $request->namaDiagnosa))->pluck('id');
            $intervensi = IntervensiKeperawatan::whereIn('diagnosa_keperawatan_id', $diagnosa)->get();
            $implementasi = ImplementasiKeperawatan::whereIn('diagnosa_keperawatan_id', $diagnosa)->get();
        } else {
            $diagnosa = DiagnosaKeperawatan::where('nama', $request->namaDiagnosa)->first();
            $intervensi = IntervensiKeperawatan::where('diagnosa_keperawatan_id', $diagnosa->id)->get();
            $implementasi = ImplementasiKeperawatan::where('diagnosa_keperawatan_id', $diagnosa->id)->get();
        }


        $data = [];

        $data[0] = [
            'metadata' => [
                'code' => 200
            ]
        ];

        foreach ($intervensi as $d) {
            $data[1][] = [
                'namaIntervensi' => $d->nama_intervensi,
            ];
        }

        foreach ($implementasi as $d) {
            $data[2][] = [
                'namaImplementasi' => $d->nama_implementasi,
            ];
        }

        return response()->json($data);
    }












    public function mata(Request $r, $unit, $registrasi_id)
    {


        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_mata')->orderBy('id', 'DESC')->get();
        $data['gambar1'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->where('type', 'mata1')->first();
        $data['gambar2'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->where('type', 'mata2')->first();
        $data['gambar3'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->where('type', 'mata3')->first();
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();

        $askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
        if ($askep) {
            $data['siki'] = json_decode($askep->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($askep->fungsional, true);
            $data['diagnosis'] = json_decode($askep->diagnosis, true);
        }

        $visum = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'visum')->first();
        if ($visum) {
            $data['visum'] = json_decode($visum->keterangan, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_mata')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_mata')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_mata')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_mata')->first();

        if ($r->method() == 'POST') {
            $kategoriPegawai = Auth::user()->pegawai->kategori_pegawai;
            if ($kategoriPegawai == 1) {
                if (($data['reg']->nomorantrian)) {
                    @updateTaskId(5, $data['reg']->nomorantrian);//RUN TASKID 5
                }
                $r->validate([
                    'fisik.anamnesa' => 'required',
                    'fisik.pemeriksaan_fisik' => 'required',
                    'fisik.diagnosis' => 'required',
                    'fisik.planning' => 'required',
                    'fisik.dischargePlanning.*' => 'required',
                ], [
                    'fisik.anamnesa.required' => 'Anamnesa wajib diisi',
                    'fisik.pemeriksaan_fisik.required' => 'Pemeriksaan fisik wajib diisi',
                    'fisik.diagnosis.required' => 'Diagnosis wajib diisi',
                    'fisik.planning.required' => 'Planning wajib diisi',
                ]);

                // Manual validate

                $dpKontrol = @$r['fisik']['dischargePlanning']['kontrol']['dipilih'];
                $dpKontrolPRB = @$r['fisik']['dischargePlanning']['kontrolPRB']['dipilih'];
                $dpDirawat = @$r['fisik']['dischargePlanning']['dirawat']['dipilih'];
                $dpDirujuk = @$r['fisik']['dischargePlanning']['dirujuk']['dipilih'];
                $dpKonsultasi = @$r['fisik']['dischargePlanning']['Konsultasi']['dipilih'];
                $dppulpak = @$r['fisik']['dischargePlanning']['pulpak']['dipilih'];
                $dpmeninggal = @$r['fisik']['dischargePlanning']['meninggal']['dipilih'];

                if ($dpKontrol == null && $dpKontrolPRB == null && $dpDirawat == null && $dpDirujuk == null && $dpKonsultasi == null && $dppulpak == null && $dpmeninggal == null) {
                    return redirect()->back()->with('error_dp', 'Discharge Planning wajib diisi');
                }
            }


            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_mata')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'fisik_mata';
                //User Dokter
                if ($kategoriPegawai == 1 && $asessment->userdokter_id == null) {
                    $asessment->userdokter_id = Auth::user()->id;
                }
                //User Selain Dokter
                if ($kategoriPegawai != 1 && $asessment->user_id == 0) {
                    $asessment->user_id = Auth::user()->id;
                }
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'fisik_mata';
                //User Dokter
                if ($kategoriPegawai == 1) {
                    $asessment->userdokter_id = Auth::user()->id;
                }
                //User Selain Dokter
                if ($kategoriPegawai != 1) {
                    $asessment->user_id = Auth::user()->id;
                }
                $asessment->save();
                Flashy::success('Record berhasil disimpan, mohon segera lakukan TTE pada menu hasil -> histori -> E-Resume');
                return redirect()->back();
            }
        }
        // $data['riwayat']		   = EmrInapPemeriksaan::where('pasien_id',$data['reg']->pasien_id)->where('type','fisik_mata')->orderBy('id','DESC')->get();
        // dd($data['riwayat']);

        // if ($r->method() == 'POST')
        // {
        // // $alatbantu = json_encode($r->alatbantu);
        //  $emr = new EmrInapPemeriksaan();
        //  $emr->pasien_id  = $r->pasien_id;
        //  $emr->registrasi_id  = $r->registrasi_id;
        //  $emr->user_id  = Auth::user()->id;
        //  $emr->fisik  = json_encode($r->fisik);
        //  $emr->type  	= 'fisik_mata';
        //  $emr->save();

        //  Flashy::success('Record berhasil disimpan');
        //  return redirect()->back();
        // }


        return view('emr.modules.pemeriksaan.mata', $data);
    }

    public function paru(Request $r, $unit, $registrasi_id)
    {


        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_paru')->orderBy('id', 'DESC')->get();
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->first();
        if ($data['gambar'] && $data['gambar']->fisik != null) {
            $data['ketGambar'] = json_decode($data['gambar']->fisik, true);
        }
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();

        $askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
        if ($askep) {
            $data['siki'] = json_decode($askep->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($askep->fungsional, true);
            $data['diagnosis'] = json_decode($askep->diagnosis, true);
        }

        $visum = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'visum')->first();
        if ($visum) {
            $data['visum'] = json_decode($visum->keterangan, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_paru')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_paru')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_paru')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_paru')->first();

        if ($r->method() == 'POST') {
            if (Auth::user()->pegawai->kategori_pegawai == 1) {
                $r->validate([
                    'fisik.anamnesa' => 'required',
                    'fisik.pemeriksaan_fisik' => 'required',
                    'fisik.diagnosis' => 'required',
                    'fisik.planning' => 'required',
                    'fisik.dischargePlanning.*' => 'required',
                ], [
                    'fisik.anamnesa.required' => 'Anamnesa wajib diisi',
                    'fisik.pemeriksaan_fisik.required' => 'Pemeriksaan fisik wajib diisi',
                    'fisik.diagnosis.required' => 'Diagnosis wajib diisi',
                    'fisik.planning.required' => 'Planning wajib diisi',
                ]);

                // Manual validate

                $dpKontrol = @$r['fisik']['dischargePlanning']['kontrol']['dipilih'];
                $dpKontrolPRB = @$r['fisik']['dischargePlanning']['kontrolPRB']['dipilih'];
                $dpDirawat = @$r['fisik']['dischargePlanning']['dirawat']['dipilih'];
                $dpDirujuk = @$r['fisik']['dischargePlanning']['dirujuk']['dipilih'];
                $dpKonsultasi = @$r['fisik']['dischargePlanning']['Konsultasi']['dipilih'];
                $dppulpak = @$r['fisik']['dischargePlanning']['pulpak']['dipilih'];
                $dpmeninggal = @$r['fisik']['dischargePlanning']['meninggal']['dipilih'];

                if ($dpKontrol == null && $dpKontrolPRB == null && $dpDirawat == null && $dpDirujuk == null && $dpKonsultasi == null && $dppulpak == null && $dpmeninggal == null) {
                    return redirect()->back()->with('error_dp', 'Discharge Planning wajib diisi');
                }
            }

            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_paru')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'fisik_paru';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $pegawai = Pegawai::where('user_id', Auth::user()->id)
                        ->where('kategori_pegawai', 1)
                        ->first();
                if (($data['reg']->nomorantrian) && ($pegawai)) {
                        @updateTaskId(5, $data['reg']->nomorantrian);//RUN TASKID 5
                }
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'fisik_paru';
                $asessment->save();
                Flashy::success('Record berhasil disimpan, mohon segera lakukan TTE pada menu hasil -> histori -> E-Resume');
                return redirect()->back();
            }
        }
        return view('emr.modules.pemeriksaan.paru', $data);
    }






    public function gigi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        // $data['riwayat']		   = EmrInapPemeriksaan::where('pasien_id',$data['reg']->pasien_id)->where('type','fisik_gigi')->orderBy('id','DESC')->get();
        // dd($data['riwayat']);

        // if ($r->method() == 'POST')
        // {

        // // $alatbantu = json_encode($r->alatbantu);
        //  $emr = new EmrInapPemeriksaan();
        //  $emr->pasien_id  = $r->pasien_id;
        //  $emr->registrasi_id  = $r->registrasi_id;
        //  $emr->user_id  = Auth::user()->id;
        //  $emr->fisik  = json_encode($r->fisik);
        //  $emr->type  	= 'fisik_gigi';
        //  $emr->save();

        //  Flashy::success('Record berhasil disimpan');
        //  return redirect()->back();
        // }

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_gigi')->orderBy('id', 'DESC')->get();
        $data['riwayats_dokter'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_gigi')->orderBy('id', 'DESC')->get();
        $data['riwayats_perawat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_gigi_perawat')->orderBy('id', 'DESC')->get();

        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->first();
        if ($data['gambar'] && $data['gambar']->fisik != null) {
            $data['ketGambar'] = json_decode($data['gambar']->fisik, true);
        }
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();

        $askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
        if ($askep) {
            $data['siki'] = json_decode($askep->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($askep->fungsional, true);
            $data['diagnosis'] = json_decode($askep->diagnosis, true);
        }

        $visum = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'visum')->first();
        if ($visum) {
            $data['visum'] = json_decode($visum->keterangan, true);
        }

        $riwayat_visum = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'visum')->get();
        $data['riwayat_visum'] = $riwayat_visum;

        if (Auth::user()->pegawai->kategori_pegawai == 1) {
            $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_gigi')->exists();
            if ($r->asessment_id !== null) {
                $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_gigi')->first();
                $data['assesment'] = json_decode($assesment->fisik, true);
                $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_gigi_perawat')->first();
                $data['assesment_perawat'] = json_decode($assesment->fisik, true);
            } else {
                $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_gigi')->first();
                $data['assesment'] = json_decode(@$assesment->fisik, true);
                $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_gigi_perawat')->first();
                $data['assesment_perawat'] = json_decode(@$assesment->fisik, true);
            }
        } else {
            $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_gigi_perawat')->exists();
            if ($r->asessment_id !== null) {
                $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_gigi_perawat')->first();
                $data['assesment'] = json_decode($assesment->fisik, true);
            } else {
                $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_gigi_perawat')->first();
                $data['assesment'] = json_decode(@$assesment->fisik, true);
            }
        }

        $data['current_asessment'] = @$assesment;
        if ($r->method() == 'POST') {
            if (Auth::user()->pegawai->kategori_pegawai == 1) {  
                if (($data['reg']->nomorantrian)) {
                    @updateTaskId(5, $data['reg']->nomorantrian);//RUN TASKID 5
                }
                $r->validate([
                    'fisik.anamnesa' => 'required',
                    'fisik.riwayatPenyakitDahulu' => 'required',
                    'fisik.riwayatPenyakitSekarang' => 'required',
                    'fisik.riwayatPenyakitKeluarga' => 'required',
                    'fisik.isPernahDirawat' => 'required',
                    'fisik.pemeriksaan_fisik' => 'required',
                    'fisik.diagnosis' => 'required',
                    'fisik.planning' => 'required',
                    'fisik.dischargePlanning.rencanaLamaRawat.isDiTetapkan' => 'required',
                ], [
                    'fisik.anamnesa.required' => 'Anamnesa wajib diisi',
                    'fisik.riwayatPenyakitDahulu.required' => 'Riwayat penyakit dahulu wajib diisi',
                    'fisik.isPernahDirawat.required' => 'Pernah dirawat wajib diisi',
                    'fisik.riwayatPenyakitKeluarga.required' => 'Riwayat penyakit keluarga wajib diisi',
                    'fisik.riwayatPenyakitSekarang.required' => 'Riwayat penyakit dahulu sekarang wajib diisi',
                    'fisik.pemeriksaan_fisik.required' => 'Pemeriksaan fisik wajib diisi',
                    'fisik.diagnosis.required' => 'Diagnosis wajib diisi',
                    'fisik.planning.required' => 'Planning wajib diisi',
                    'fisik.dischargePlanning.rencanaLamaRawat.isDiTetapkan.required' => 'Discharge Planning wajib diisi',
                ]);
            }

            if ($r->asesment_type == 'dokter') {
                if ($r->asessment_id != null) {
                    // dd($r->asessment_id);
                    $update = EmrInapPemeriksaan::find($r->asessment_id);
                    $asessment_old = json_decode($update->fisik, true);
                    $asessment_new = [];

                    if (is_array($r->fisik)) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $asessment_old;
                    }

                    $update->fisik = json_encode($asessment_new);
                    $update->user_id = Auth::user()->id;
                    $update->save();
                    Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                    return redirect()->back();
                } elseif ($asessmentExists) {
                    $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_gigi')->orderBy('id', 'DESC')->first();
                    $asessment_old = json_decode($asessment->fisik, true);
                    $asessment_new = [];
                    if (is_array($r->fisik)) {
                        // dd($r->fisik);
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $asessment_old;
                    }
                    $asessment->fisik = json_encode($asessment_new);
                    $asessment->type = 'fisik_gigi';
                    $asessment->user_id = Auth::user()->id;
                    $asessment->save();
                    Flashy::success('Record berhasil diupdate');
                    return redirect()->back();
                } else {
                    $asessment = new EmrInapPemeriksaan();
                    $asessment->pasien_id = $r->pasien_id;
                    $asessment->registrasi_id = $r->registrasi_id;
                    $asessment->user_id = Auth::user()->id;
                    $asessment->fisik = json_encode($r->fisik);
                    $asessment->type = 'fisik_gigi';
                    $asessment->save();
                    Flashy::success('Record berhasil disimpan, mohon segera lakukan TTE pada menu hasil -> histori -> E-Resume');
                    return redirect()->back();
                }
            } elseif ($r->asesment_type == 'perawat') {
                if ($r->asessment_id != null) {
                    // dd($r->asessment_id);
                    $update = EmrInapPemeriksaan::find($r->asessment_id);
                    $asessment_old = json_decode($update->fisik, true);
                    $asessment_new = [];

                    if (is_array($r->fisik)) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $asessment_old;
                    }

                    $update->fisik = json_encode($asessment_new);
                    $update->user_id = Auth::user()->id;
                    $update->save();
                    Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                    return redirect()->back();
                } elseif ($asessmentExists) {
                    $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_gigi_perawat')->orderBy('id', 'DESC')->first();
                    $asessment_old = json_decode($asessment->fisik, true);
                    $asessment_new = [];
                    if (is_array($r->fisik)) {
                        // dd($r->fisik);
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $asessment_old;
                    }
                    $asessment->fisik = json_encode($asessment_new);
                    $asessment->type = 'fisik_gigi_perawat';
                    $asessment->save();
                    Flashy::success('Record berhasil diupdate');
                    return redirect()->back();
                } else {
                    $asessment = new EmrInapPemeriksaan();
                    $asessment->pasien_id = $r->pasien_id;
                    $asessment->registrasi_id = $r->registrasi_id;
                    $asessment->user_id = Auth::user()->id;
                    $asessment->fisik = json_encode($r->fisik);
                    $asessment->type = 'fisik_gigi_perawat';
                    $asessment->save();
                    Flashy::success('Record berhasil disimpan');
                    return redirect()->back();
                }
            }
        }

        return view('emr.modules.pemeriksaan.gigi', $data);
    }

    public function gizi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        // Semua riwayat asesmen
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_gizi')->orderBy('id', 'DESC')->get();
        // dd($data['riwayats'] );
        // Ambil lokalis sesuai registrasi
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->first();
        if ($data['gambar'] && $data['gambar']->fisik != null) {
            $data['ketGambar'] = json_decode($data['gambar']->fisik, true);
        }
        // Askep
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();
        $askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
        if ($askep) {
            $data['siki'] = json_decode($askep->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($askep->fungsional, true);
            $data['diagnosis'] = json_decode($askep->diagnosis, true);
        }
        // Visum
        $visum = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'visum')->first();
        if ($visum) {
            $data['visum'] = json_decode($visum->keterangan, true);
        }

        // Cek apakah sudah ada asesmen untuk registrasi saat ini
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_gizi')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_gizi')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_gizi')->first();
            // Assesmen setelah di isi kosong, ketika edit (asesment_id ada) baru muncul
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = $assesment;
        // dd($data['assesment']);

        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_gizi')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'fisik_gizi';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $pegawai = Pegawai::where('user_id', Auth::user()->id)
                        ->where('kategori_pegawai', 1)
                        ->first();
                if (($data['reg']->nomorantrian) && ($pegawai)) {
                    @updateTaskId(5, $data['reg']->nomorantrian);//RUN TASKID 5
                }
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'fisik_gizi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan, mohon segera lakukan TTE pada menu hasil -> histori -> E-Resume');
                return redirect()->back();
            }
        }
        return view('emr.modules.pemeriksaan.gizi', $data);
    }

    public function rehabMedik(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        // Semua riwayat asesmen
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_rehab_medik')->orderBy('id', 'DESC')->get();
        // dd($data['riwayats'] );
        // Ambil lokalis sesuai registrasi
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->first();
        if ($data['gambar'] && $data['gambar']->fisik != null) {
            $data['ketGambar'] = json_decode($data['gambar']->fisik, true);
        }
        // Askep
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();
        $askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
        if ($askep) {
            $data['siki'] = json_decode($askep->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($askep->fungsional, true);
            $data['diagnosis'] = json_decode($askep->diagnosis, true);
        }
        // Visum
        $visum = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'visum')->first();
        if ($visum) {
            $data['visum'] = json_decode($visum->keterangan, true);
        }

        // Cek apakah sudah ada asesmen untuk registrasi saat ini
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_rehab_medik')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_rehab_medik')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_rehab_medik')->first();
            // Assesmen setelah di isi kosong, ketika edit (asesment_id ada) baru muncul
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = $assesment;
        // dd($data['assesment']);

        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_rehab_medik')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'fisik_rehab_medik';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $pegawai = Pegawai::where('user_id', Auth::user()->id)
                        ->where('kategori_pegawai', 1)
                        ->first();
                if (($data['reg']->nomorantrian) && ($pegawai)) {
                    @updateTaskId(5, $data['reg']->nomorantrian);//RUN TASKID 5
                }
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'fisik_rehab_medik';
                $asessment->save();
                Flashy::success('Record berhasil disimpan, mohon segera lakukan TTE pada menu hasil -> histori -> E-Resume');
                return redirect()->back();
            }
        }
        return view('emr.modules.pemeriksaan.rehab-medik', $data);
    }

    public function obgyn(Request $r, $unit, $registrasi_id)
    {


        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        // $data['riwayat']		   = EmrInapPemeriksaan::where('pasien_id',$data['reg']->pasien_id)->where('type','fisik_obgyn')->orderBy('id','DESC')->get();
        // dd($data['riwayat']);

        // if ($r->method() == 'POST')
        // {
        // // $alatbantu = json_encode($r->alatbantu);
        //  $emr = new EmrInapPemeriksaan();
        //  $emr->pasien_id  = $r->pasien_id;
        //  $emr->registrasi_id  = $r->registrasi_id;
        //  $emr->user_id  = Auth::user()->id;
        //  $emr->fisik  = json_encode($r->fisik);
        //  $emr->type  	= 'fisik_obgyn';
        //  $emr->save();

        //  Flashy::success('Record berhasil disimpan');
        //  return redirect()->back();
        // }

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_obgyn')->orderBy('id', 'DESC')->get();
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->first();
        if ($data['gambar'] && $data['gambar']->fisik != null) {
            $data['ketGambar'] = json_decode($data['gambar']->fisik, true);
        }
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();

        $askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
        if ($askep) {
            $data['siki'] = json_decode($askep->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($askep->fungsional, true);
            $data['diagnosis'] = json_decode($askep->diagnosis, true);
        }

        $visum = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'visum')->first();
        if ($visum) {
            $data['visum'] = json_decode($visum->keterangan, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_obgyn')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_obgyn')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_obgyn')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_obgyn')->first();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {

            if (Auth::user()->pegawai->kategori_pegawai == 1) {
                if (($data['reg']->nomorantrian)) {
                    @updateTaskId(5, $data['reg']->nomorantrian);//RUN TASKID 5
                }
                $r->validate([
                    'fisik.anamnesa' => 'required',
                    'fisik.pemeriksaan_fisik' => 'required',
                    'fisik.diagnosis' => 'required',
                    'fisik.planning' => 'required',
                    'fisik.dischargePlanning.*' => 'required',
                ], [
                    'fisik.anamnesa.required' => 'Anamnesa wajib diisi',
                    'fisik.pemeriksaan_fisik.required' => 'Pemeriksaan fisik wajib diisi',
                    'fisik.diagnosis.required' => 'Diagnosis wajib diisi',
                    'fisik.planning.required' => 'Planning wajib diisi',
                ]);
                // Manual validate
                $dpKontrol = @$r['fisik']['dischargePlanning']['kontrol']['dipilih'];
                $dpKontrolPRB = @$r['fisik']['dischargePlanning']['kontrolPRB']['dipilih'];
                $dpDirawat = @$r['fisik']['dischargePlanning']['dirawat']['dipilih'];
                $dpDirujuk = @$r['fisik']['dischargePlanning']['dirujuk']['dipilih'];
                $dpKonsultasi = @$r['fisik']['dischargePlanning']['Konsultasi']['dipilih'];
                $dppulpak = @$r['fisik']['dischargePlanning']['pulpak']['dipilih'];
                $dpmeninggal = @$r['fisik']['dischargePlanning']['meninggal']['dipilih'];

                if ($dpKontrol == null && $dpKontrolPRB == null && $dpDirawat == null && $dpDirujuk == null && $dpKonsultasi == null && $dppulpak == null && $dpmeninggal == null) {
                    return redirect()->back()->with('error_dp', 'Discharge Planning wajib diisi');
                }
            }


            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_obgyn')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'fisik_obgyn';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'fisik_obgyn';
                $asessment->save();
                Flashy::success('Record berhasil disimpan, mohon segera lakukan TTE pada menu hasil -> histori -> E-Resume');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }


        return view('emr.modules.pemeriksaan.obgyn', $data);
    }

    public function awalObgynDokter(Request $r, $unit, $registrasi_id)
    {


        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_obgyn')->orderBy('id', 'DESC')->get();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_obgyn')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_obgyn')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_obgyn')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_obgyn')->first();

        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_obgyn')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'fisik_obgyn';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'fisik_obgyn';
                $asessment->save();
                Flashy::success('Record berhasil disimpan, mohon segera lakukan TTE pada menu hasil -> histori -> E-Resume');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        return view('emr.modules.pemeriksaan.awal_obgyn_dokter', $data);
    }

    public function awalMCU(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_mcu')->orderBy('id', 'DESC')->get();
        $asesmen = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_umum')->orderBy('id', 'DESC')->first();
        if ($asesmen){
            $data['asesmen'] = json_decode($asesmen->fisik, true);
        }
        
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();
        $data['faskesRujukanRs'] = FaskesRujukanRs::all();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_mcu')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_mcu')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_mcu')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_mcu')->first();

        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_mcu')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'fisik_mcu';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $pegawai = Pegawai::where('user_id', Auth::user()->id)
                        ->where('kategori_pegawai', 1)
                        ->first();
                if (($data['reg']->nomorantrian) && ($pegawai)) {
                        @updateTaskId(5, $data['reg']->nomorantrian);//RUN TASKID 5
                }
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'fisik_mcu';
                $asessment->save();
                Flashy::success('Record berhasil disimpan, mohon segera lakukan TTE pada menu hasil -> histori -> E-Resume');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        return view('emr.modules.pemeriksaan.awal_mcu', $data);
    }

    public function pemeriksaandalam(Request $r, $unit, $registrasi_id)
    {


        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'dalam')->orderBy('id', 'DESC')->get();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r->all());
            // $alatbantu = json_encode($r->alatbantu);
            $emr = new EmrInapPemeriksaan();
            $emr->pasien_id = $r->pasien_id;
            $emr->registrasi_id = $r->registrasi_id;
            $emr->user_id = Auth::user()->id;
            $emr->pemeriksaandalam = json_encode($r->pemeriksaandalam);
            $emr->type = 'dalam';
            $emr->save();

            Flashy::success('Catatan berhasil disimpan');
            return redirect()->back();
        }


        return view('emr.modules.pemeriksaan.pemeriksaan_dalam', $data);
    }






    public function pemeriksaanObgyn(Request $r, $unit, $registrasi_id)
    {


        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'obgyn')->orderBy('id', 'DESC')->get();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r->all());
            // $alatbantu = json_encode($r->alatbantu);
            $emr = new EmrInapPemeriksaan();
            $emr->pasien_id = $r->pasien_id;
            $emr->registrasi_id = $r->registrasi_id;
            $emr->user_id = Auth::user()->id;
            $emr->obgyn = json_encode($r->pemeriksaanobgyn);
            $emr->type = 'obgyn';
            $emr->save();

            Flashy::success('Catatan berhasil disimpan');
            return redirect()->back();
        }


        return view('emr.modules.pemeriksaan.pemeriksaan_obgyn', $data);
    }












    public function pemeriksaanPenunjang(Request $r, $unit, $registrasi_id)
    {

        // dd('ini');

        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'penunjang')->orderBy('id', 'DESC')->get();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r->all());
            // $alatbantu = json_encode($r->alatbantu);
            $emr = new EmrInapPemeriksaan();
            $emr->pasien_id = $r->pasien_id;
            $emr->registrasi_id = $r->registrasi_id;
            $emr->user_id = Auth::user()->id;
            $emr->pemeriksaandalam = json_encode($r->pemeriksaanpenunjang);
            $emr->type = 'penunjang';
            $emr->save();

            Flashy::success('Catatan berhasil disimpan');
            return redirect()->back();
        }


        return view('emr.modules.pemeriksaan.pemeriksaanPenunjang', $data);
    }



    public function pemeriksaanPenunjangTHT(Request $r, $unit, $registrasi_id)
    {

        // dd('ini');

        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'penunjang_tht')->orderBy('id', 'DESC')->get();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r->all());
            // $alatbantu = json_encode($r->alatbantu);
            $emr = new EmrInapPemeriksaan();
            $emr->pasien_id = $r->pasien_id;
            $emr->registrasi_id = $r->registrasi_id;
            $emr->user_id = Auth::user()->id;
            $emr->pemeriksaandalam = json_encode($r->pemeriksaan);
            $emr->type = 'penunjang_tht';
            $emr->save();

            Flashy::success('Catatan berhasil disimpan');
            return redirect()->back();
        }


        return view('emr.modules.pemeriksaan.pemeriksaan_penunjang_tht', $data);
    }




    public function diagnosis_banding(Request $r, $unit, $registrasi_id)
    {

        // dd('ini');

        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'diagnosis_banding')->orderBy('id', 'DESC')->get();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r->all());
            // $alatbantu = json_encode($r->alatbantu);
            $emr = new EmrInapPemeriksaan();
            $emr->pasien_id = $r->pasien_id;
            $emr->registrasi_id = $r->registrasi_id;
            $emr->user_id = Auth::user()->id;
            $emr->diagnosis = json_encode($r->banding);
            $emr->type = 'diagnosis_banding';
            $emr->save();

            Flashy::success('Catatan berhasil disimpan');
            return redirect()->back();
        }


        return view('emr.modules.pemeriksaan.diagnosis_banding', $data);
    }




    public function diagnosis_kerja(Request $r, $unit, $registrasi_id)
    {

        // dd('ini');

        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'diagnosis_kerja')->orderBy('id', 'DESC')->get();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r->all());
            // $alatbantu = json_encode($r->alatbantu);
            $emr = new EmrInapPemeriksaan();
            $emr->pasien_id = $r->pasien_id;
            $emr->registrasi_id = $r->registrasi_id;
            $emr->user_id = Auth::user()->id;
            $emr->diagnosis = json_encode($r->banding);
            $emr->type = 'diagnosis_kerja';
            $emr->save();

            Flashy::success('Catatan berhasil disimpan');
            return redirect()->back();
        }


        return view('emr.modules.pemeriksaan.diagnosis_kerja', $data);
    }









    public function pemeriksaan(Request $r, $unit, $registrasi_id)
    {


        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'pemeriksaan_umum')->orderBy('id', 'DESC')->get();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r->pemeriksaan);
            // $alatbantu = json_encode($r->alatbantu);
            $emr = new EmrInapPemeriksaan();
            $emr->pasien_id = $r->pasien_id;
            $emr->registrasi_id = $r->registrasi_id;
            $emr->user_id = Auth::user()->id;
            $emr->fisik = json_encode($r->pemeriksaan);
            $emr->type = 'pemeriksaan_umum';
            $emr->save();

            Flashy::success('Record berhasil disimpan');
            return redirect()->back();
        }


        return view('emr.modules.pemeriksaan_fisik_umum', $data);
    }

    public function hemodialisis(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_hemodialisis')->orderBy('id', 'DESC')->get();
        $data['riwayats_dokter'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_hemodialisis')->orderBy('id', 'DESC')->get();
        $data['riwayats_perawat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_hemodialisis_perawat')->orderBy('id', 'DESC')->get();

        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->first();
        if ($data['gambar'] && $data['gambar']->fisik != null) {
            $data['ketGambar'] = json_decode($data['gambar']->fisik, true);
        }
        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();

        $askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
        if ($askep) {
            $data['siki'] = json_decode($askep->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($askep->fungsional, true);
            $data['diagnosis'] = json_decode($askep->diagnosis, true);
        }

        $visum = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'visum')->first();
        if ($visum) {
            $data['visum'] = json_decode($visum->keterangan, true);
        }


        if (Auth::user()->pegawai->kategori_pegawai == 1) {
            $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_hemodialisis')->exists();
            if ($r->asessment_id !== null) {
                $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_hemodialisis')->first();
                $data['assesment'] = json_decode($assesment->fisik, true);
            } else {
                $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_hemodialisis')->first();
                $data['assesment'] = json_decode(@$assesment->fisik, true);
            }
        } else {
            $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_hemodialisis_perawat')->exists();
            if ($r->asessment_id !== null) {
                $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'fisik_hemodialisis_perawat')->first();
                $data['assesment'] = json_decode($assesment->fisik, true);
            } else {
                $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_hemodialisis_perawat')->first();
                $data['assesment'] = json_decode(@$assesment->fisik, true);
            }
        }

        if ($r->method() == 'POST') {
            if ($r->asesment_type == 'dokter') {
                if ($r->asessment_id != null) {
                    $update = EmrInapPemeriksaan::find($r->asessment_id);
                    $asessment_old = json_decode($update->fisik, true);
                    $asessment_new = [];

                    if (is_array($r->fisik)) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $asessment_old;
                    }

                    $update->fisik = json_encode($asessment_new);
                    $update->user_id = Auth::user()->id;
                    $update->save();
                    Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                    return redirect()->back();
                } elseif ($asessmentExists) {
                    $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_hemodialisis')->orderBy('id', 'DESC')->first();
                    $asessment_old = json_decode($asessment->fisik, true);
                    $asessment_new = [];
                    if (is_array($r->fisik)) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $asessment_old;
                    }
                    $asessment->fisik = json_encode($asessment_new);
                    $asessment->type = 'fisik_hemodialisis';
                    $asessment->user_id = Auth::user()->id;
                    $asessment->save();
                    Flashy::success('Record berhasil diupdate');
                    return redirect()->back();
                } else {
                    $pegawai = Pegawai::where('user_id', Auth::user()->id)
                        ->where('kategori_pegawai', 1)
                        ->first();
                    if (($data['reg']->nomorantrian) && ($pegawai)) {
                        @updateTaskId(5, $data['reg']->nomorantrian);//RUN TASKID 5
                    }
                    $asessment = new EmrInapPemeriksaan();
                    $asessment->pasien_id = $r->pasien_id;
                    $asessment->registrasi_id = $r->registrasi_id;
                    $asessment->user_id = Auth::user()->id;
                    $asessment->fisik = json_encode($r->fisik);
                    $asessment->type = 'fisik_hemodialisis';
                    $asessment->save();
                    Flashy::success('Record berhasil disimpan, mohon segera lakukan TTE pada menu hasil -> histori -> E-Resume');
                    return redirect()->back();
                }
            } elseif ($r->asesment_type == 'perawat') {
                $fisik = $r->fisik;
                if ($r->selesai_evaluasi_perawatan == "SELESAI") {
                    $fisik['selesai_evaluasi_perawatan'] = now()->format('Y-m-d H:i:s');
                }
                // if ($r->asessment_id != null) {
                //     $update = EmrInapPemeriksaan::find($r->asessment_id);
                //     $asessment_old = json_decode($update->fisik, true);
                //     $asessment_new = [];

                //     if (is_array($fisik)) {
                //         $asessment_new = array_merge($asessment_old, $fisik);
                //     } else {
                //         $asessment_new = $asessment_old;
                //     }

                //     $update->fisik = json_encode($asessment_new);
                //     $update->user_id = Auth::user()->id;
                //     $update->save();
                //     Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                //     return redirect()->back();
                // } elseif ($asessmentExists) {
                //     $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_hemodialisis_perawat')->orderBy('id', 'DESC')->first();
                //     $asessment_old = json_decode($asessment->fisik, true);
                //     $asessment_new = [];
                //     if (is_array($fisik)) {
                //         $asessment_new = array_merge($asessment_old, $fisik);
                //     } else {
                //         $asessment_new = $asessment_old;
                //     }
                //     $asessment->fisik = json_encode($asessment_new);
                //     $asessment->type = 'fisik_hemodialisis_perawat';
                //     $asessment->save();
                //     Flashy::success('Record berhasil diupdate');
                //     return redirect()->back();
                // } else {
                    $asessment = new EmrInapPemeriksaan();
                    $asessment->pasien_id = $r->pasien_id;
                    $asessment->registrasi_id = $r->registrasi_id;
                    $asessment->user_id = Auth::user()->id;
                    $asessment->fisik = json_encode($fisik);
                    $asessment->type = 'fisik_hemodialisis_perawat';
                    $asessment->save();
                    Flashy::success('Record berhasil disimpan');
                    return redirect()->back();
                // }
            }
        }

        return view('emr.modules.pemeriksaan.hemodialisis', $data);
    }

    public function akses_vaskular_hemodialis(Request $r, $unit, $registrasi_id,$id=NULL)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'akses-vaskular')->orderBy('id', 'DESC')->get();

        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->first();
        if ($data['gambar'] && $data['gambar']->fisik != null) {
            $data['ketGambar'] = json_decode($data['gambar']->fisik, true);
        }


        // $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'akses-vaskular')->exists();
        // if ($r->asessment_id !== null) {
        //     $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'akses-vaskular')->first();
        //     $data['assesment'] = json_decode($assesment->fisik, true);
        // } else {
        if($id){
                $data['resume'] = EmrInapPemeriksaan::where('id', $id)->first();
                $data['assesment'] = json_decode(@$data['resume']->fisik, true);

        }
        // }

        if ($r->method() == 'POST') {
            // dd($r->all());
            // if ($r->asessment_id != null) {
            //     $update = EmrInapPemeriksaan::find($r->asessment_id);
            //     $asessment_old = json_decode($update->fisik, true);
            //     $asessment_new = [];

            //     if (is_array($r->fisik)) {
            //         $asessment_new = array_merge($asessment_old, $r->fisik);
            //     } else {
            //         $asessment_new = $asessment_old;
            //     }

            //     $update->fisik = json_encode($asessment_new);
            //     $update->user_id = Auth::user()->id;
            //     $update->save();
            //     Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
            //     return redirect()->back();
            // } elseif ($asessmentExists) {
            //     $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'akses-vaskular')->orderBy('id', 'DESC')->first();
            //     $asessment_old = json_decode($asessment->fisik, true);
            //     $asessment_new = [];
            //     if (is_array($r->fisik)) {
            //         $asessment_new = array_merge($asessment_old, $r->fisik);
            //     } else {
            //         $asessment_new = $asessment_old;
            //     }
            //     $asessment->fisik = json_encode($asessment_new);
            //     $asessment->type = 'akses-vaskular';
            //     $asessment->user_id = Auth::user()->id;
            //     $asessment->save();
            //     Flashy::success('Record berhasil diupdate');
            //     return redirect()->back();
            // } else {
                if($r->asessment_id){
                    $asessment = EmrInapPemeriksaan::where('id',$r->asessment_id)->first();
                }else{
                    $asessment = new EmrInapPemeriksaan();
                }
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'akses-vaskular';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back();
            // }
        }

        return view('emr.modules.pemeriksaan.akses_vaskular', $data);
    }

    public function cetakAksesVaskularHemodialisis($unit, $reg_id, $id)
    {
        $assesments = EmrInapPemeriksaan::find($id);
        $reg = Registrasi::find($reg_id);
        $dokter = Pegawai::find($reg->dokter_id);
        $cetak = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'akses-vaskular')->first();
        $assesment = json_decode(@$assesments->fisik, true);

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak_pdf_akses_vaskular', compact('reg', 'dokter', 'cetak', 'assesment', 'assesments'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Akses Vaskular Hemodialisis.pdf');
    }

    public function laporanHemodialisis(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'laporan_hemodialisis')
            ->orderBy('id', 'DESC')
            ->get();

        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'laporan_hemodialisis')->orderBy('id', 'DESC')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan_hemodialisis')->orderBy('id', 'DESC')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan_hemodialisis')->exists();

        if ($r->method() == 'POST') {
            //     $update = EmrInapPemeriksaan::find($r->asessment_id);
            //     $asessment_old = json_decode($update->fisik, true);
            //     $asessment_new = [];
            
            //     if (is_array($r->fisik)) {
                //         $asessment_new = array_merge($asessment_old, $r->fisik);
                //     } else {
                    //         $asessment_new = $asessment_old;
                    //     }
                    
                    //     $update->fisik = json_encode($asessment_new);
                    //     $update->update();
                    
                    //     Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                    //     return redirect()->back();
                    
                    // } elseif ($asessmentExists) {
                        //     $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_obgyn')->orderBy('id', 'DESC')->first();
                        //     $asessment_old = json_decode($asessment->fisik, true);
                        //     $asessment_new = [];
                        //     if (is_array($r->fisik)) {
            //         // dd($r->fisik);
            //         $asessment_new = array_merge($asessment_old, $r->fisik);
            //     } else {
                //         $asessment_new = $asessment_old;
            //     }
            //     $asessment->fisik = json_encode($asessment_new);
            //     $asessment->update();
            
            //     Flashy::success('Record berhasil diupdate');
            //     return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            // } else {
            if ($r->asessment_id != null) {
                $asessment = EmrInapPemeriksaan::where('id',$r->asessment_id)->first();
            }else{

                $asessment = new EmrInapPemeriksaan();
            }
                
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'laporan_hemodialisis';
                $asessment->save();

                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            // }
        }

        return view('emr.modules.pemeriksaan.laporan_hemodialisis', $data);
    }

    public function cetakLaporanHemodialisis($unit, $reg_id, $id)
    {
        $assesments = EmrInapPemeriksaan::find($id);
        $reg = Registrasi::find($reg_id);
        $dokter = Pegawai::find($reg->dokter_id);
        $cetak = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'laporan_hemodialisis')->first();
        $assesment = json_decode(@$assesments->fisik, true);

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak_pdf_laporan_hemodialisis', compact('reg', 'dokter', 'cetak', 'assesment', 'assesments'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('laporan Hemodialisis.pdf');
    }

    public function mcu(Request $r, $unit, $registrasi_id)
    {
        // dd($r->all());
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats_perawat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'mcu_perawat')->orderBy('id', 'DESC')->get();
        $asesmen = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_mcu')->orderBy('id', 'DESC')->first();
        if ($asesmen !== null) {
            $data['asesmen'] = json_decode($asesmen->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'mcu_perawat')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'mcu_perawat')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'mcu_perawat')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }

        $data['current_asessment'] = @$assesment;

        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'mcu_perawat')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'mcu_perawat';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'mcu_perawat';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back();
            }
        }
        return view('emr.modules.pemeriksaan.mcu', $data);
    }

    public function ttePDFMCU(Request $request)
    {
        $reg_id = $request->registrasi_id;
        $id     = $request->mcu_id;
        $reg    = Registrasi::find($reg_id);
        $mcu    = EmrInapPemeriksaan::find($id);
        $riwayats_perawat = EmrInapPemeriksaan::where('pasien_id', $reg->pasien_id)->where('type', 'mcu_perawat')->orderBy('id', 'DESC')->get();
        if (tte()) {
            $proses_tte = true;
            $pdf = PDF::loadView('emr.modules._cetak_pemeriksaan_mcu', compact('reg', 'mcu', 'riwayats_perawat', 'proses_tte'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-MCU.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($reg->id, $tte->response, "MCU", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $mcu->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $mcu->update();
                Flashy::success('Berhasil melakukan proses TTE dokumen !');
                return redirect()->back();
            } elseif ($tte->httpStatusCode == 400) {
                if (isset($resp->error)) {
                    Flashy::error($resp->error);
                    return redirect()->back();
                }
            } elseif ($tte->httpStatusCode == 500) {
                Flashy::error($tte->response);
                return redirect()->back();
            }
            Flashy::error('Gagal melakukan proses TTE dokumen !');
        } else {
            $tte_nonaktif = true;
            $pdf = PDF::loadView('emr.modules._cetak_pemeriksaan_mcu', compact('reg', 'mcu', 'riwayats_perawat', 'tte_nonaktif'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            $mcu->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $mcu->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function hasilMCU(Request $r, $unit, $registrasi_id)
    {
        // dd($r->all());
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'hasil_mcu')->orderBy('id', 'DESC')->get();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'hasil_mcu')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'hasil_mcu')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'hasil_mcu')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }

        $data['current_asessment'] = @$assesment;

        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                if (!$update->nomor) {
                    $lastNomor = EmrInapPemeriksaan::where('type', 'hasil_mcu')
                        ->whereNotNull('nomor')
                        ->where('nomor', 'like', '%/%/%')
                        ->select(DB::raw("MAX(CAST(TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(nomor, '/', -3), '/', 1)) AS UNSIGNED)) as max_nomor"))
                        ->value('max_nomor');

                    $id_nomor = $lastNomor ? $lastNomor + 1 : 1000;
                    $update->nomor = '445 : 91 / ' . $id_nomor . ' / ' . romawi(date('n')) . ' / ' . date('Y');
                }
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'hasil_mcu')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'hasil_mcu';
                if (!$asessment->nomor) {
                    $lastNomor = EmrInapPemeriksaan::where('type', 'hasil_mcu')
                        ->whereNotNull('nomor')
                        ->where('nomor', 'like', '%/%/%')
                        ->select(DB::raw("MAX(CAST(TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(nomor, '/', -3), '/', 1)) AS UNSIGNED)) as max_nomor"))
                        ->value('max_nomor');

                    $id_nomor = $lastNomor ? $lastNomor + 1 : 1000;
                    $asessment->nomor = '445 : 91 / ' . $id_nomor . ' / ' . romawi(date('n')) . ' / ' . date('Y');
                }
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $lastNomor = EmrInapPemeriksaan::where('type', 'hasil_mcu')
                    ->whereNotNull('nomor')
                    ->where('nomor', 'like', '%/%/%')
                    ->select(DB::raw("MAX(CAST(TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(nomor, '/', -3), '/', 1)) AS UNSIGNED)) as max_nomor"))
                    ->value('max_nomor');

                $id_nomor = $lastNomor ? $lastNomor + 1 : 1000;

                $asessment = new EmrInapPemeriksaan();
                $asessment->nomor = '445 : 91 / ' . $id_nomor . ' / ' . romawi(date('n')) . ' / ' . date('Y');
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'hasil_mcu';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back();
            }
        }
        return view('emr.modules.pemeriksaan.hasilMedicalCheckUp', $data);
    }

    public function ttePDFHasilMCU(Request $request)
    {
        $registrasi_id = $request->registrasi_id;
        $id     = $request->mcu_id;
        $reg    = Registrasi::find($registrasi_id);
        $mcu    = EmrInapPemeriksaan::find($id);
        $unit   = $request->unit;
        $riwayats = EmrInapPemeriksaan::where('pasien_id', $reg->pasien_id)->where('type', 'hasil_mcu')->orderBy('id', 'DESC')->get();
        if (tte()) {
            $proses_tte = true;
            $pdf = PDF::loadView('emr.modules.pemeriksaan.hasilMedicalCheckUp', compact('reg', 'registrasi_id', 'mcu', 'unit', 'riwayats', 'proses_tte'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-MCU.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($reg->id, $tte->response, "MCU", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $mcu->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $mcu->update();
                Flashy::success('Berhasil melakukan proses TTE dokumen !');
                return redirect()->back();
            } elseif ($tte->httpStatusCode == 400) {
                if (isset($resp->error)) {
                    Flashy::error($resp->error);
                    return redirect()->back();
                }
            } elseif ($tte->httpStatusCode == 500) {
                Flashy::error($tte->response);
                return redirect()->back();
            }
            Flashy::error('Gagal melakukan proses TTE dokumen !');
        } else {
            $tte_nonaktif = true;
            $pdf = PDF::loadView('emr.modules.pemeriksaan.hasilMedicalCheckUp', compact('reg', 'registrasi_id', 'mcu', 'unit', 'riwayats', 'tte_nonaktif'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            $mcu->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $mcu->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function gawatDarurat(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        if ($unit == 'jalan') {
            $tindakanCode = 'TA';
        } elseif ($unit == 'inap') {
            $tindakanCode = 'TI';
        } else {
            $tindakanCode = 'TG';
        }
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'assesment-awal-medis-igd')
            ->orderBy('id', 'DESC')
            ->get();
        $data['riwayatPerawat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'assesment-awal-perawat-igd')
            ->orderBy('id', 'DESC')
            ->get();
        $data['riwayatPonek'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'assesment-awal-medis-igd-ponek')
            ->orderBy('id', 'DESC')
            ->get();

        $triage = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'triage-igd')->orderBy('id', 'DESC')->first();
        if ($triage) {
            $data['dataTriage'] = json_decode($triage->fisik, true);
        }

        $asesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)
            ->where('type', 'assesment-awal-perawat-igd')
            ->first();
        if ($asesmenPerawat) {
            $data['dataAsesmenPerawat'] = json_decode($asesmenPerawat->fisik, true);
            $data['satusehat']['perawat_id_condition_keluhan_utama'] = $asesmenPerawat->id_condition_keluhan_utama_ss;
        }

        $asesmenDokter = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)
            ->where('type', 'assesment-awal-medis-igd')
            ->first();
        if ($asesmenDokter) {
            $data['dataAsesmenDokter'] = json_decode($asesmenDokter->fisik, true);
            $data['satusehat']['dokter_id_condition_keluhan_utama'] = $asesmenDokter->id_condition_keluhan_utama_ss;
            $data['satusehat']['dokter_id_condition_riwayat_penyakit'] = $asesmenDokter->id_condition_riwayat_penyakit_ss;
        }

        $asesmenPonek = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)
            ->where('type', 'assesment-awal-medis-igd-ponek')
            ->first();
        if ($asesmenPonek) {
            $data['dataAsesmenPonek'] = json_decode($asesmenPonek->fisik, true);
        }

        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->where('type', 'assesment-awal-medis-igd')->first();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        } else {
            $asessment = $data['current_asessment'];
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        // dd($data['current_asessment']);
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-medis-igd')->exists();

        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();

        $askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
        if ($askep) {
            $data['siki'] = json_decode($askep->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($askep->fungsional, true);
            $data['diagnosis'] = json_decode($askep->diagnosis, true);
        }

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                $asessment = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->asessment)) {
                    $asessment_new = array_merge($asessment_old, $r->asessment);
                } else {
                    $asessment_new = $asessment_old;
                }

                if ($r->rekonsiliasi !== null) {
                    $asessment_old['rekonsiliasi'][] = $r->rekonsiliasi;
                    $asessment->fisik = json_encode($asessment_old);
                } else if ($r->fisik !== null) {
                    $asessment_old['obatAlergi'][] = $r->obatAlergi;
                    $asessment->obatAlergi = json_encode($asessment_old);
                } else {
                    $asessment->fisik = json_encode($asessment_new);
                }


                // $asessment->fisik   = json_encode($asessment_new);
                // $asessment->type      = 'assesment-awal-medis-igd';
                $asessment->update();
                Flashy::success('Record Pada ' . Carbon::parse($asessment->created_at)->format('d-m-Y') . ' Berhasil ditambahkan');
                return redirect('emr-soap/pemeriksaan/asesmen-igd/igd/' . $registrasi_id . '#rekonsiliasiobat');
            } elseif ($r->rekonsiliasi_idx !== null) {
                // Ambil data asesmen berdasarkan registrasi_id
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)
                    ->where('type', 'assesment-awal-medis-igd')
                    ->first();

                if ($asessment) {
                    // Decode data fisik untuk mendapatkan rekonsiliasi
                    $rekonsiliasi_data = json_decode($asessment->fisik, true);
                    // Pastikan rekonsiliasi ada dan bukan null atau kosong
                    if (isset($rekonsiliasi_data['rekonsiliasi']) && !empty($rekonsiliasi_data['rekonsiliasi'])) {
                        // Pastikan indeks rekonsiliasi yang diminta ada dalam data
                        if (isset($rekonsiliasi_data['rekonsiliasi'][$r->rekonsiliasi_idx])) {
                            // Update data rekonsiliasi di indeks yang sesuai
                            $rekonsiliasi_data['rekonsiliasi'][$r->rekonsiliasi_idx] = $r->rekonsiliasi;
                            // Reset array keys untuk mencegah indeks yang terputus
                            $rekonsiliasi_data['rekonsiliasi'] = array_values($rekonsiliasi_data['rekonsiliasi']);

                            // Simpan kembali perubahan ke database
                            $asessment->fisik = json_encode($rekonsiliasi_data);
                            $asessment->update();
                            Flashy::success('Data obat berhasil diupdate.');
                        } else {
                            Flashy::error('Data obat tidak ditemukan.');
                        }
                    } else {
                        Flashy::error('Data rekonsiliasi tidak ditemukan dalam asesmen.');
                    }
                } else {
                    Flashy::error('Data asesmen tidak ditemukan.');
                }
                // Kembali ke halaman sebelumnya
                return redirect('emr-soap/pemeriksaan/asesmen-igd/igd/' . $registrasi_id . '#rekonsiliasiobat');
            } elseif ($r->alergi_idx !== null) {
                // Ambil data asesmen berdasarkan registrasi_id
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)
                    ->where('type', 'assesment-awal-medis-igd')
                    ->first();

                if ($asessment) {
                    // Decode data fisik untuk mendapatkan alergi
                    $alergi_data = json_decode($asessment->fisik, true);
                    // Pastikan alergi ada dan bukan null atau kosong
                    if (isset($alergi_data['obatAlergi']) && !empty($alergi_data['obatAlergi'])) {
                        // Pastikan indeks alergi yang diminta ada dalam data
                        if (isset($alergi_data['obatAlergi'][$r->alergi_idx])) {
                            // Update data alergi di indeks yang sesuai
                            $alergi_data['obatAlergi'][$r->alergi_idx] = $r->obatAlergi;
                            // Reset array keys untuk mencegah indeks yang terputus
                            $alergi_data['obatAlergi'] = array_values($alergi_data['obatAlergi']);

                            // Simpan kembali perubahan ke database
                            $asessment->fisik = json_encode($alergi_data);
                            $asessment->update();
                            Flashy::success('Data obat berhasil diupdate.');
                        } else {
                            Flashy::error('Data obat tidak ditemukan.');
                        }
                    } else {
                        Flashy::error('Data alergi tidak ditemukan dalam asesmen.');
                    }
                } else {
                    Flashy::error('Data asesmen tidak ditemukan.');
                }
                // Kembali ke halaman sebelumnya
                return redirect('emr-soap/pemeriksaan/asesmen-igd/igd/' . $registrasi_id . '#rekonsiliasiobat');
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->where('type', 'assesment-awal-medis-igd')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->asessment)) {
                    $asessment_new = array_merge($asessment_old, $r->asessment);
                } else {
                    $asessment_new = $asessment_old;
                }

                if ($r->rekonsiliasi !== null) {
                    $asessment_old['rekonsiliasi'][] = $r->rekonsiliasi;
                    $asessment->fisik = json_encode($asessment_old);
                } else if ($r->obatAlergi !== null) {
                    $asessment_old['obatAlergi'][] = $r->obatAlergi;
                    $asessment->fisik = json_encode($asessment_old);
                } else {
                    $asessment->fisik = json_encode($asessment_new);
                }
                // $asessment->fisik   = json_encode($asessment_new);
                // $asessment->type      = 'assesment-awal-medis-igd';
                $asessment->update();
                Flashy::success('Record berhasil diupdate');
                // return redirect('emr-soap/pemeriksaan/asesmen-igd/igd/'. $registrasi_id . '#rekonsiliasiobat');
                return redirect()->back();
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->type = 'assesment-awal-medis-igd';
                $asessment->fisik = json_encode($r->asessment);
                if ($r->rekonsiliasi !== null) {
                    $asessment->fisik = json_encode(['rekonsiliasi' => [$r->rekonsiliasi]]);
                    $type = 'formulir-obat';
                } elseif ($r->obatAlergi !== null) {
                    $asessment->fisik = json_encode(['obatAlergi' => [$r->obatAlergi]]);
                    $type = 'formulir-obat';
                } else {
                    $asessment->fisik = json_encode($r->asessment);
                }
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                // return redirect('emr-soap/pemeriksaan/asesmen-igd/igd/'. $registrasi_id . '#rekonsiliasiobat');
                return redirect()->back();
            }

            // Satu Sehat (Condition Keluhan Utama)
            if (!empty(@$r->asessment['igdAwal']['keluhanUtamaPilihan'])) {
                if (satusehat()) {
                    if (empty($asessment->id_condition_keluhan_utama_ss)) {
                        $asessment->id_condition_keluhan_utama_ss = SatuSehatIGDController::ConditionPostKeluhanUtama($r->registrasi_id, $r->asessment['igdAwal']['keluhanUtamaPilihan']);
                        $asessment->update();
                    }
                }
            }

            // Satu Sehat (Condition Riwayat Penyakit)
            if (!empty(@$r->asessment['igdAwal']['riwayat_penyakit_pilihan'])) {
                if (satusehat()) {
                    if (empty($asessment->id_condition_riwayat_penyakit_ss)) {
                        $asessment->id_condition_riwayat_penyakit_ss = SatuSehatIGDController::ConditionPostKeluhanUtama($r->registrasi_id, $r->asessment['igdAwal']['riwayat_penyakit_pilihan']);
                        $asessment->update();
                    }
                }
            }
            return redirect()->back();
        }

        // Lokalis
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();

        // Rekonsiliasi Obat
        $data['rekonsiliasi'] = @$data['asessment']['rekonsiliasi'];
        $data['obatAlergi'] = @$data['asessment']['obatAlergi'];
        // $data['rekonsiliasi'] = @json_decode(@$asessment['rekonsiliasi'],true)['rekonsiliasi'];
        // $data['obatAlergi'] = @json_decode(@$asessment['obatAlergi'],true)['obatAlergi'];

        // dd($data['rekonsiliasi']['rekonsiliasi']);

        //Kamar
        $data['kamars'] = Kamar::all();
        // Tindakan
        $data['tindakan'] = Tarif::where('jenis', $tindakanCode)->get();
        $data['folioTindakanMedis'] = Folio::where(['registrasi_id' => $registrasi_id])->whereIn('jenis', ['TA', 'TI', 'TG'])->get();
        $data['jenis'] = Registrasi::where('id', '=', $registrasi_id)->first();
        $data['pasien'] = Pasien::find($data['reg']->pasien_id);
        $data['pelaksana'] = Pegawai::where('kategori_pegawai', '1')->get();
        $data['perawat'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
        $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
        $data['opt_poli'] = Poli::where('politype', 'G')->get();

        // Keluhan Utama
        $data['keluhanUtama'] = SnomedCT::with('children')->where('concept_id', 404684003)->first();
        // Riwayat Penyakit
        $data['riwayatPenyakit'] = SnomedCT::with('children')->where('concept_id', 417662000)->first();
        return view('emr.modules.pemeriksaan.igd-baru', $data);
    }

    public function cetakRekonsiliasiObat($unit, $reg_id, $id)
    {
        $assesments = EmrInapPemeriksaan::find($id);
        $reg = Registrasi::find($reg_id);
        $dokter = Pegawai::find($reg->dokter_id);
        $cetak = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'assesment-awal-medis-igd')->first();
        $assesment = json_decode(@$assesments->fisik, true);

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak_pdf_rekonsiliasi_obat', compact('reg', 'dokter', 'cetak', 'assesment', 'assesments'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Formulir Penelusuran Obat.pdf');
    }

    public function hapusRekonsiliasi($registrasi_id, $index)
    {
        // Ambil data asesmen berdasarkan registrasi_id
        $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)
            ->where('type', 'assesment-awal-medis-igd')
            ->first();

        if ($asessment) {
            // Decode data fisik untuk mendapatkan rekonsiliasi
            $rekonsiliasi_data = json_decode($asessment->fisik, true);

            // Pastikan rekonsiliasi ada dan bukan null atau kosong
            if (isset($rekonsiliasi_data['rekonsiliasi']) && !empty($rekonsiliasi_data['rekonsiliasi'])) {
                // Cek apakah index yang diminta ada di dalam rekonsiliasi
                if (isset($rekonsiliasi_data['rekonsiliasi'][$index])) {
                    // Hapus rekonsiliasi berdasarkan index
                    unset($rekonsiliasi_data['rekonsiliasi'][$index]);

                    // Reset array keys untuk mencegah index yang terputus
                    $rekonsiliasi_data['rekonsiliasi'] = array_values($rekonsiliasi_data['rekonsiliasi']);

                    // Simpan kembali perubahan ke database
                    $asessment->fisik = json_encode($rekonsiliasi_data);
                    $asessment->save();
                    Flashy::success('Data obat berhasil dihapus.');
                } else {
                    Flashy::error('Data obat tidak ditemukan.');
                }
            } else {
                Flashy::error('Data rekonsiliasi tidak ditemukan dalam asesmen.');
            }
        } else {
            Flashy::error('Data asesmen tidak ditemukan.');
        }

        // Kembali ke halaman sebelumnya
        // return redirect('emr-soap/pemeriksaan/asesmen-igd/igd/'. $registrasi_id . '#rekonsiliasiobat');
        return redirect()->back();
    }

    public function hapusAlergi($registrasi_id, $index)
    {
        // Ambil data asesmen berdasarkan registrasi_id
        $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)
            ->where('type', 'assesment-awal-medis-igd')
            ->first();

        if ($asessment) {
            // Decode data fisik untuk mendapatkan alergi
            $alergi_data = json_decode($asessment->fisik, true);

            // Pastikan alergi ada dan bukan null atau kosong
            if (isset($alergi_data['obatAlergi']) && !empty($alergi_data['obatAlergi'])) {
                // Cek apakah index yang diminta ada di dalam alergi
                if (isset($alergi_data['obatAlergi'][$index])) {
                    // Hapus alergi berdasarkan index
                    unset($alergi_data['obatAlergi'][$index]);

                    // Reset array keys untuk mencegah index yang terputus
                    $alergi_data['obatAlergi'] = array_values($alergi_data['obatAlergi']);

                    // Simpan kembali perubahan ke database
                    $asessment->fisik = json_encode($alergi_data);
                    $asessment->save();
                    Flashy::success('Data obat berhasil dihapus.');
                } else {
                    Flashy::error('Data obat tidak ditemukan.');
                }
            } else {
                Flashy::error('Data rekonsiliasi tidak ditemukan dalam asesmen.');
            }
        } else {
            Flashy::error('Data asesmen tidak ditemukan.');
        }

        // Kembali ke halaman sebelumnya
        // return redirect('emr-soap/pemeriksaan/asesmen-igd/igd/'. $registrasi_id . '#rekonsiliasiobat');
        return redirect()->back();
    }

    public function penelusuranObat(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->where('type', 'assesment-awal-medis-igd')->first();
        $data['asessment'] = json_decode(@$data['current_asessment']->fisik, true);
        // Rekonsiliasi Obat
        $data['rekonsiliasi'] = @$data['asessment']['rekonsiliasi'];
        $data['obatAlergi'] = @$data['asessment']['obatAlergi'];

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-medis-igd')->exists();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                $asessment = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->asessment)) {
                    $asessment_new = array_merge($asessment_old, $r->asessment);
                } else {
                    $asessment_new = $asessment_old;
                }

                if ($r->rekonsiliasi !== null) {
                    $asessment_old['rekonsiliasi'][] = $r->rekonsiliasi;
                    $asessment->fisik = json_encode($asessment_old);
                } else if ($r->fisik !== null) {
                    $asessment_old['obatAlergi'][] = $r->obatAlergi;
                    $asessment->obatAlergi = json_encode($asessment_old);
                } else {
                    $asessment->fisik = json_encode($asessment_new);
                }


                // $asessment->fisik   = json_encode($asessment_new);
                // $asessment->type      = 'assesment-awal-medis-igd';
                $asessment->update();
                Flashy::success('Record Pada ' . Carbon::parse($asessment->created_at)->format('d-m-Y') . ' Berhasil ditambahkan');
                // return redirect('emr-soap/pemeriksaan/asesmen-igd/igd/'. $registrasi_id . '#rekonsiliasiobat');
                return redirect()->back();
            } elseif ($r->rekonsiliasi_idx !== null) {
                // Ambil data asesmen berdasarkan registrasi_id
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)
                    ->where('type', 'assesment-awal-medis-igd')
                    ->first();

                if ($asessment) {
                    // Decode data fisik untuk mendapatkan rekonsiliasi
                    $rekonsiliasi_data = json_decode($asessment->fisik, true);
                    // Pastikan rekonsiliasi ada dan bukan null atau kosong
                    if (isset($rekonsiliasi_data['rekonsiliasi']) && !empty($rekonsiliasi_data['rekonsiliasi'])) {
                        // Pastikan indeks rekonsiliasi yang diminta ada dalam data
                        if (isset($rekonsiliasi_data['rekonsiliasi'][$r->rekonsiliasi_idx])) {
                            // Update data rekonsiliasi di indeks yang sesuai
                            $rekonsiliasi_data['rekonsiliasi'][$r->rekonsiliasi_idx] = $r->rekonsiliasi;
                            // Reset array keys untuk mencegah indeks yang terputus
                            $rekonsiliasi_data['rekonsiliasi'] = array_values($rekonsiliasi_data['rekonsiliasi']);

                            // Simpan kembali perubahan ke database
                            $asessment->fisik = json_encode($rekonsiliasi_data);
                            $asessment->update();
                            Flashy::success('Data obat berhasil diupdate.');
                        } else {
                            Flashy::error('Data obat tidak ditemukan.');
                        }
                    } else {
                        Flashy::error('Data rekonsiliasi tidak ditemukan dalam asesmen.');
                    }
                } else {
                    Flashy::error('Data asesmen tidak ditemukan.');
                }
                // Kembali ke halaman sebelumnya
                // return redirect('emr-soap/pemeriksaan/asesmen-igd/igd/' . $registrasi_id . '#rekonsiliasiobat');
                return redirect()->back();
            } elseif ($r->alergi_idx !== null) {
                // Ambil data asesmen berdasarkan registrasi_id
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)
                    ->where('type', 'assesment-awal-medis-igd')
                    ->first();

                if ($asessment) {
                    // Decode data fisik untuk mendapatkan alergi
                    $alergi_data = json_decode($asessment->fisik, true);
                    // Pastikan alergi ada dan bukan null atau kosong
                    if (isset($alergi_data['obatAlergi']) && !empty($alergi_data['obatAlergi'])) {
                        // Pastikan indeks alergi yang diminta ada dalam data
                        if (isset($alergi_data['obatAlergi'][$r->alergi_idx])) {
                            // Update data alergi di indeks yang sesuai
                            $alergi_data['obatAlergi'][$r->alergi_idx] = $r->obatAlergi;
                            // Reset array keys untuk mencegah indeks yang terputus
                            $alergi_data['obatAlergi'] = array_values($alergi_data['obatAlergi']);

                            // Simpan kembali perubahan ke database
                            $asessment->fisik = json_encode($alergi_data);
                            $asessment->update();
                            Flashy::success('Data obat berhasil diupdate.');
                        } else {
                            Flashy::error('Data obat tidak ditemukan.');
                        }
                    } else {
                        Flashy::error('Data alergi tidak ditemukan dalam asesmen.');
                    }
                } else {
                    Flashy::error('Data asesmen tidak ditemukan.');
                }
                // Kembali ke halaman sebelumnya
                // return redirect('emr-soap/pemeriksaan/asesmen-igd/igd/' . $registrasi_id . '#rekonsiliasiobat');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->where('type', 'assesment-awal-medis-igd')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->asessment)) {
                    $asessment_new = array_merge($asessment_old, $r->asessment);
                } else {
                    $asessment_new = $asessment_old;
                }

                if ($r->rekonsiliasi !== null) {
                    $asessment_old['rekonsiliasi'][] = $r->rekonsiliasi;
                    $asessment->fisik = json_encode($asessment_old);
                } else if ($r->obatAlergi !== null) {
                    $asessment_old['obatAlergi'][] = $r->obatAlergi;
                    $asessment->fisik = json_encode($asessment_old);
                } else {
                    $asessment->fisik = json_encode($asessment_new);
                }
                // $asessment->fisik   = json_encode($asessment_new);
                // $asessment->type      = 'assesment-awal-medis-igd';
                $asessment->update();
                Flashy::success('Record berhasil diupdate');
                // return redirect('emr-soap/pemeriksaan/asesmen-igd/igd/'. $registrasi_id . '#rekonsiliasiobat');
                return redirect()->back();
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->type = 'assesment-awal-medis-igd';
                $asessment->fisik = json_encode($r->asessment);
                if ($r->rekonsiliasi !== null) {
                    $asessment->fisik = json_encode(['rekonsiliasi' => [$r->rekonsiliasi]]);
                    $type = 'formulir-obat';
                } elseif ($r->obatAlergi !== null) {
                    $asessment->fisik = json_encode(['obatAlergi' => [$r->obatAlergi]]);
                    $type = 'formulir-obat';
                } else {
                    $asessment->fisik = json_encode($r->asessment);
                }
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                // return redirect('emr-soap/pemeriksaan/asesmen-igd/igd/'. $registrasi_id . '#rekonsiliasiobat');
                return redirect()->back();
            }
        }

        return view('emr.modules.pemeriksaan.penelusuran_obat', $data);
    }

    public function triageGawatDarurat(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'triage-igd')->get();

        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->where('type', 'triage-igd')->first();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        } else {
            $asessment = $data['current_asessment'];
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'triage-igd')->exists();

        $data['diagnosaKeperawatan'] = DiagnosaKeperawatan::all();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                $asessment = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->asessment)) {
                    $asessment_new = array_merge($asessment_old, $r->asessment);
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'triage-igd';
                $asessment->save();
                Flashy::success('Record Pada ' . Carbon::parse($asessment->created_at)->format('d-m-Y') . ' Berhasil diupdate');
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->where('type', 'triage-igd')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->asessment)) {
                    $asessment_new = array_merge($asessment_old, $r->asessment);
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'triage-igd';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->type = 'triage-igd';
                $asessment->fisik = json_encode($r->asessment);
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }
        return view('emr.modules.pemeriksaan.triage-igd', $data);
    }

    public function triageGawatDaruratAwal(Request $r, $triageId = null)
    {

        $data['asessment'] = null;

        $data['riwayatTriage'] = EmrInapPemeriksaan::where('type', 'triage-igd')
            ->with(['registrasi', 'registrasi.pasien'])
            ->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())
            ->get();

        $data['allergy'] = Allergy::all();

        $data['no'] = 1;

        if ($triageId != null) {
            $asessment = EmrInapPemeriksaan::find($triageId);
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', null);

            $asessment = new EmrInapPemeriksaan();
            $asessment->user_id = Auth::user()->id;
            $asessment->type = 'triage-igd';
            $asessment->fisik = json_encode($r->asessment);
            $asessment->save();

            Flashy::success('Record berhasil disimpan');
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.triage-igd-awal', $data);
    }

    public function ajaxFaskes(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return \Response::json([]);
        }
        $faskes = FaskesLanjutan::where('kode_ppk', 'like', "%$term%")->orWhere('nama_ppk', 'like', "%$term%")->get();
        $formatted_tags = [];
        foreach ($faskes as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->kode_ppk . ' - ' . @$tag->nama_ppk];
        }
        return \Response::json($formatted_tags);
    }

    public function ajaxFaskesRS(Request $request)
    {
        $jenis_faskes = trim($request->jenis_faskes);
        if (empty($jenis_faskes)) {
            return \Response::json([]);
        }
        $faskes_rs = FaskesRujukanRs::where('jenis_faskes', '=', $jenis_faskes)->get();
        $formatted_tags = [];
        foreach ($faskes_rs as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_rs];
        }
        return \Response::json($formatted_tags);
    }

    public function statusIGD(Request $r, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['pasien'] = Pasien::find($data['reg']->pasien_id);
        $data['status'] = @json_decode(@$data['reg']->status_ugd, true);
        // dd( $data['status']);
        $data['kondisi_akhir_pasiens'] = KondisiAkhirPasien::whereIn('jenis', ['kondisi', 'both'])->orderBy('urutan', 'ASC')->get();
        $data['cara_pulangs'] = KondisiAkhirPasien::whereIn('jenis', ['cara_pulang', 'both'])->orderBy('urutan', 'ASC')->get();
        $data['faskesRujukanRs'] = FaskesRujukanRs::all();

        $data['kondisi_id'] = $data['reg']->kondisi_akhir_pasien;
        $data['pulang_id'] = $data['reg']->pulang;
        $data['tgl_pulang'] = $data['reg']->tgl_pulang;
        // $data['dirujuk_ke']         = FaskesLanjutan::find(1);
        if ($r->method() == 'POST') {
            $data['reg']->status_ugd = json_encode($r->status);
            $data['reg']->pulang = $r->cara_pulang;
            $data['reg']->kondisi_akhir_pasien = $r->kondisi_akhir;
            $data['reg']->tgl_pulang = $r->tgl_pulang;
            $data['reg']->save();

            Flashy::success('Record berhasil disimpan');
            return redirect('/tindakan/igd');
        }
        return view('emr.modules.pemeriksaan.status-igd', $data);
    }

    public function layananRehab(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'layanan_rehab')->orderBy('id', 'DESC')->get();
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();
        $data['soap'] = @Emr::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->first();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'layanan_rehab')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'layanan_rehab')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'layanan_rehab')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'layanan_rehab')->first();

        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'layanan_rehab')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'layanan_rehab';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'layanan_rehab';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        return view('emr.modules.pemeriksaan.layananRehab', $data);
    }












    public function gawatDaruratPonek(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        if ($unit == 'jalan') {
            $tindakanCode = 'TA';
        } elseif ($unit == 'inap') {
            $tindakanCode = 'TI';
        } else {
            $tindakanCode = 'TG';
        }
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'assesment-awal-medis-igd-ponek')
            ->orderBy('id', 'DESC')
            ->get();

        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->where('type', 'assesment-awal-medis-igd-ponek')->first();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        } else {
            $asessment = $data['current_asessment'];
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        // dd($data['current_asessment']);


        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-medis-igd-ponek')->exists();
        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                $asessment = EmrInapPemeriksaan::find($r->asessement_id);
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->asessment)) {
                    $asessment_new = array_merge($asessment_old, $r->asessment);
                } else {
                    $asessment_new = $asessment_old;
                }

                if ($r->rekonsiliasi !== null) {
                    $asessment_old['rekonsiliasi'][] = $r->rekonsiliasi;
                    $asessment->fisik = json_encode($asessment_old);
                } else if ($r->obatAlergi !== null) {
                    $asessment_old['obatAlergi'][] = $r->obatAlergi;
                    $asessment->fisik = json_encode($asessment_old);
                } else {
                    $asessment->fisik = json_encode($asessment_new);
                }
                $asessment->type = 'assesment-awal-medis-igd-ponek';
                $asessment->save();
                Flashy::success('Record Pada ' . Carbon::parse($asessment->created_at)->format('d-m-Y') . ' Berhasil diupdate');
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->where('type', 'assesment-awal-medis-igd-ponek')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->asessment)) {
                    $asessment_new = array_merge($asessment_old, $r->asessment);
                } else {
                    $asessment_new = $asessment_old;
                }

                if ($r->rekonsiliasi !== null) {
                    $asessment_old['rekonsiliasi'][] = $r->rekonsiliasi;
                    $asessment->fisik = json_encode($asessment_old);
                } else if ($r->obatAlergi !== null) {
                    $asessment_old['obatAlergi'][] = $r->obatAlergi;
                    $asessment->fisik = json_encode($asessment_old);
                } else {
                    $asessment->fisik = json_encode($asessment_new);
                }
                $asessment->type = 'assesment-awal-medis-igd-ponek';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->type = 'assesment-awal-medis-igd-ponek';
                if ($r->rekonsiliasi !== null) {
                    $asessment->fisik = json_encode(['rekonsiliasi' => [$r->rekonsiliasi]]);
                } elseif ($r->obatAlergi !== null) {
                    $asessment->fisik = json_encode(['obatAlergi' => [$r->obatAlergi]]);
                } else {
                    $asessment->fisik = json_encode($r->asessment);
                }
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }





        // Lokalis
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();

        // Rekonsiliasi Obat
        $data['rekonsiliasi'] = @$data['asessment']['rekonsiliasi'];
        $data['obatAlergi'] = @$data['asessment']['obatAlergi'];

        // dd( $data['rekonsiliasi']);

        // Tindakan
        $data['tindakan'] = Tarif::where('jenis', $tindakanCode)->get();
        $data['folioTindakanMedis'] = Folio::where(['registrasi_id' => $registrasi_id])->whereIn('jenis', ['TA', 'TI', 'TG'])->get();
        $data['jenis'] = Registrasi::where('id', '=', $registrasi_id)->first();
        $data['pasien'] = Pasien::find($data['reg']->pasien_id);
        $data['pelaksana'] = Pegawai::where('kategori_pegawai', '1')->get();
        $data['perawat'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
        $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
        $data['opt_poli'] = Poli::where('politype', 'G')->get();


        return view('emr.modules.pemeriksaan.igd-baru', $data);
    }








    public function gawatDaruratAsesmentAwal(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        if ($unit == 'jalan') {
            $tindakanCode = 'TA';
        } elseif ($unit == 'inap') {
            $tindakanCode = 'TI';
        } else {
            $tindakanCode = 'TG';
        }
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'assesment-awal-perawat-igd')
            ->orderBy('id', 'DESC')
            ->get();

        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->where('type', 'assesment-awal-perawat-igd')->first();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        } else {
            $asessment = $data['current_asessment'];
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        // dd($data['current_asessment']);


        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-perawat-igd')->exists();
        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->where('type', 'assesment-awal-perawat-igd')->first();
                $diagnosis_old = json_decode($asessment->diagnosis, true);
                $siki_old = json_decode($asessment->pemeriksaandalam, true);
                $implementasi_old = json_decode($asessment->fungsional, true);
                $asessment_old = json_decode($asessment->fisik, true);

                $asessment_new = [];
                $diagnosis_new = [];
                $siki_new = [];
                $implementasi_new = [];

                if (is_array($r->asessment)) {
                    if ($asessment_old == null) {
                        $asessment_new = $r->asessment;
                    } else {
                        $asessment_new = array_merge($asessment_old, $r->asessment);
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                if (is_array($r->diagnosa)) {
                    if ($diagnosis_old == null) {
                        $diagnosis_new = $r->diagnosa;
                    } else {
                        $diagnosis_new = array_merge($diagnosis_old, $r->diagnosa);
                    }
                } else {
                    $diagnosis_new = $diagnosis_old;
                }

                if (is_array($r->pemeriksaanDalam)) {
                    if ($siki_old == null) {
                        $siki_new = $r->pemeriksaanDalam;
                    } else {
                        $siki_new = array_merge($siki_old, $r->pemeriksaanDalam);
                    }
                } else {
                    $siki_new = $siki_old;
                }

                if (is_array($r->fungsional)) {
                    if ($implementasi_old == null) {
                        $implementasi_new = $r->fungsional;
                    } else {
                        $implementasi_new = array_merge($implementasi_old, $r->fungsional);
                    }
                } else {
                    $implementasi_new = $implementasi_old;
                }
                $asessment->fungsional = json_encode($implementasi_new);
                $asessment->pemeriksaandalam = json_encode($siki_new);
                $asessment->diagnosis = json_encode($diagnosis_new);
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'assesment-awal-perawat-igd';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->type = 'assesment-awal-perawat-igd';
                if ($r->rekonsiliasi !== null) {
                    $asessment->fungsional = json_encode(['rekonsiliasi' => [$r->rekonsiliasi]]);
                }
                if ($r->obatAlergi !== null) {
                    $asessment->pemeriksaandalam = json_encode(['obatAlergi' => [$r->obatAlergi]]);
                }
                $asessment->fisik = json_encode($r->asessment);
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }

            // Satu Sehat (Condition Keluhan Utama)
            if (!empty(@$r->asessment['keluhan_utama_pilihan'])) {
                if (satusehat()) {
                    if (empty($asessment->id_condition_keluhan_utama_ss)) {
                        $asessment->id_condition_keluhan_utama_ss = SatuSehatIGDController::ConditionPostKeluhanUtama($r->registrasi_id, $r->asessment['keluhan_utama_pilihan']);
                        $asessment->update();
                    }
                }
            }

            // Satu Sehat (Observation)
            $observation_satu_sehat = json_decode(@$asessment->observation_satu_sehat, true);
            // Asesmen Nyeri
            if (!empty(@$r->asessment['asesmen_nyeri']['pilihan'])) {
                if (satusehat()) {
                    if (empty(@$observation_satu_sehat['asesmen_nyeri'])) {
                        $asesmen_nyeri = SatuSehatIGDController::ObservationPostNyeri($r->registrasi_id, @$r->asessment['asesmen_nyeri']['pilihan'] == 'Tidak' ? false : true);
                        $observation_satu_sehat['asesmen_nyeri'] = $asesmen_nyeri;
                    }
                }
            }
            // Skala Nyeri
            if (!empty(@$r->asessment['asesmen_nyeri']['severity']['skor'])) {
                if (satusehat()) {
                    if (empty(@$observation_satu_sehat['skala_nyeri'])) {
                        $skala_nyeri = SatuSehatIGDController::ObservationPostSkalaNyeriNRS($r->registrasi_id, @$r->asessment['asesmen_nyeri']['severity']['skor']);
                        $observation_satu_sehat['skala_nyeri'] = $skala_nyeri;
                    }
                }
            }
            // Lokasi Nyeri
            if (!empty(@$r->asessment['asesmen_nyeri']['region']['lokasi'])) {
                if (satusehat()) {
                    if (empty(@$observation_satu_sehat['lokasi_nyeri'])) {
                        $lokasi_nyeri = SatuSehatIGDController::ObservationPostLokasiNyeri($r->registrasi_id, @$r->asessment['asesmen_nyeri']['region']['lokasi']);
                        $observation_satu_sehat['lokasi_nyeri'] = $lokasi_nyeri;
                    }
                }
            }

            $asessment->observation_satu_sehat = json_encode($observation_satu_sehat);
            $asessment->update();

            return redirect()->back();
        }





        // Lokalis
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();

        // Rekonsiliasi Obat
        $data['rekonsiliasi'] = @$data['asessment']['rekonsiliasi'];
        $data['obatAlergi'] = @$data['asessment']['obatAlergi'];

        // dd( $data['rekonsiliasi']);

        // Tindakan
        $data['tindakan'] = Tarif::where('jenis', $tindakanCode)->get();
        $data['folioTindakanMedis'] = Folio::where(['registrasi_id' => $registrasi_id])->whereIn('jenis', ['TA', 'TI', 'TG'])->get();
        $data['jenis'] = Registrasi::where('id', '=', $registrasi_id)->first();
        $data['pasien'] = Pasien::find($data['reg']->pasien_id);
        $data['pelaksana'] = Pegawai::where('kategori_pegawai', '1')->get();
        $data['perawat'] = Pegawai::where('kategori_pegawai', '2')->pluck('nama', 'id');
        $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
        $data['opt_poli'] = Poli::where('politype', 'G')->get();


        return view('emr.modules.pemeriksaan.igd-baru', $data);
    }

    public function maternitas(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-perawat-maternitas')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-perawat-maternitas')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-perawat-maternitas')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-perawat-maternitas')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-perawat-maternitas')->first();

        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-perawat-maternitas')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-perawat-maternitas';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-perawat-maternitas';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        return view('emr.modules.pemeriksaan.awalMaternitas', $data);
    }

    public function perinatologi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-perinatologi')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-perinatologi')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-perinatologi')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-perinatologi')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-perinatologi')->first();

        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-perinatologi')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-perinatologi';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-perinatologi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        return view('emr.modules.pemeriksaan.perinatologi', $data);
    }

    public function formulirEdukasiInap(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'formulir-edukasi-inap')->orderBy('id', 'DESC')->get();

        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'formulir-edukasi-inap')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'formulir-edukasi-inap')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        // $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'formulir-edukasi-inap')->first();

        if ($r->method() == 'POST') {
            $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'formulir-edukasi-inap')->exists();

            if ($r->asessment_id != null) {
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'formulir-edukasi-inap')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'formulir-edukasi-inap';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'formulir-edukasi-inap';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        return view('emr.modules.pemeriksaan.formulirEdukasiInap', $data);
    }

    public function formulirEdukasiGizi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'formulir-edukasi-inap')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'formulir-edukasi-inap')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'formulir-edukasi-inap')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'formulir-edukasi-inap')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'formulir-edukasi-inap')->first();

        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'formulir-edukasi-inap')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'formulir-edukasi-inap';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'formulir-edukasi-inap';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        return view('emr.modules.pemeriksaan.formulirEdukasiGizi', $data);
    }























    public function programTerapi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();

        // $data['riwayats']           = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'program_terapi_rehab')->orderBy('id', 'DESC')->get();
        $data['riwayats'] = EmrInapPemeriksaan::where('emr_inap_pemeriksaans.pasien_id', $data['reg']->pasien_id)->where('type', 'program_terapi_rehab')
            ->join('registrasis', 'emr_inap_pemeriksaans.registrasi_id', '=', 'registrasis.id') // Gabung dengan tabel registrasis
            ->orderBy('registrasis.created_at', 'DESC') // Urutkan berdasarkan created_at tabel registrasis
            ->select('emr_inap_pemeriksaans.*')
            ->get(); // Pastikan data yang diambil berasal dari emr_inap_pemeriksaans

        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();

        $layananRehab = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'layanan_rehab')->first();

        if ($layananRehab) {
            $data['layananRehab'] = json_decode($layananRehab->fisik, true);
        }

        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'program_terapi_rehab')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        }

        if ($r->method() == 'POST') {

            if ($r->cetak_terpilih) {
                return $this->cetak_program_terapi_terpilih($r->registrasi_id, $r->riwayat_id);
            }
            if ($r->cetak_terpilih_sign) {
                return $this->cetak_program_terapi_terpilih_sign($r->registrasi_id, $r->riwayat_id);
            }
            // if (!$r->asessment_id) {
            $asessment = new EmrInapPemeriksaan();
            // } else {
            //     $asessment = EmrInapPemeriksaan::where('id', $r->asessment_id)->first();
            // }
            $asessment->pasien_id = $r->pasien_id;
            $asessment->registrasi_id = $r->registrasi_id;
            $asessment->user_id = Auth::user()->id;
            $asessment->fisik = json_encode($r->fisik);
            $asessment->type = 'program_terapi_rehab';
            $asessment->save();
            Flashy::success('Record berhasil disimpan');
            return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            // }
        }

        return view('emr.modules.pemeriksaan.programTerapi', $data);
    }

    public function cetak_program_terapi_terpilih($reg_id, $riwayat_id)
    {
        $data['riwayat'] = EmrInapPemeriksaan::whereIn('id', $riwayat_id)
            ->orderBy('created_at', 'DESC')->get();

        $data['soap'] = Emr::where('registrasi_id', $reg_id)
            ->whereNotNull('assesment')
            ->first();

        $program = [];
        foreach ($data['riwayat'] as $p) {
            $dokter_ids = Registrasi::where('id', $p->registrasi_id)->first()->dokter_id;
            $fisik = json_decode(@$p->fisik, true);
            $decodedProgram = $fisik['program'];
            $tgl = Registrasi::where('id', $p->registrasi_id)->first()->created_at;
            $ttd = TandaTangan::where('registrasi_id', $p->registrasi_id)
                ->where('jenis_dokumen', 'program-terapi')
                ->first();
            $tte = EmrInapPemeriksaan::where('registrasi_id', $p->registrasi_id)
                ->where('type', 'program_terapi_rehab')
                ->first();

            foreach ($decodedProgram as $key => $value) {
                if (!is_null($value)) {
                    $program[] = [
                        'tgl' => $tgl,
                        'created_at' => $p->created_at,
                        'program' => $value,
                        'dokter_id' => $dokter_ids,
                        'ttd' => @$ttd->tanda_tangan,
                        'tte' => @$tte->tte,
                    ];
                }
            }
        }

        $data['program'] = collect($program)->sortBy(function ($item) {
            try {
                return isset($item['tgl'])
                    ? \Carbon\Carbon::parse($item['tgl'])
                    : \Carbon\Carbon::parse($item['created_at']);
            } catch (\Exception $e) {
                return \Carbon\Carbon::parse($item['created_at']);
            }
        });

        $data['reg'] = Registrasi::find($reg_id);
        $data['dokter'] = Pegawai::find($data['reg']->dokter_id);
        $data['ttd_dokter'] = $data['dokter']->tanda_tangan;
        $data['tte'] = $tte->tte;

        return view('resume.terpilih_cetak_pdf_program_terapi', $data);
    }

    public function cetak_program_terapi_terpilih_sign($reg_id, $riwayat_id)
    {
        $data['riwayat'] = EmrInapPemeriksaan::whereIn('id', $riwayat_id)
            ->orderBy('created_at', 'DESC')->get();

        $data['soap'] = Emr::where('registrasi_id', $reg_id)
            ->whereNotNull('assesment')
            ->first();
        
        $program = [];
        foreach ($data['riwayat'] as $p) {
            $dokter_ids = Registrasi::where('id', $p->registrasi_id)->first()->dokter_id;
            $fisik = json_decode(@$p->fisik, true);
            $decodedProgram = $fisik['program'];
            $tgl = Registrasi::where('id', $p->registrasi_id)->first()->created_at;
            $ttd = TandaTangan::where('registrasi_id', $p->registrasi_id)
                ->where('jenis_dokumen', 'program-terapi')
                ->first();
            $tte = EmrInapPemeriksaan::where('registrasi_id', $p->registrasi_id)
                ->where('type', 'program_terapi_rehab')
                ->first();

            foreach ($decodedProgram as $key => $value) {
                if (!is_null($value)) {
                    $program[] = [
                        'tgl' => $tgl,
                        'created_at' => $p->created_at,
                        'program' => $value,
                        'dokter_id' => $dokter_ids,
                        'ttd' => @$ttd->tanda_tangan,
                        'tte' => @$tte->tte,
                    ];
                }
            }
        }

        $data['program'] = collect($program)->sortBy(function ($item) {
            try {
                return isset($item['tgl'])
                    ? \Carbon\Carbon::parse($item['tgl'])
                    : \Carbon\Carbon::parse($item['created_at']);
            } catch (\Exception $e) {
                return \Carbon\Carbon::parse($item['created_at']);
            }
        });

        $data['reg'] = Registrasi::find($reg_id);
        $data['dokter'] = Pegawai::find($data['reg']->dokter_id);
        $data['ttd_dokter'] = $data['dokter']->tanda_tangan;
        $data['ttd_pasien'] = Pasien::find($data['reg']->pasien_id);
        $data['tte'] = $tte->tte;

        return view('resume.terpilih_cetak_pdf_program_terapi_sign', $data);
    }


    public function ujiFungsi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'uji_fungsi_rehab')->orderBy('id', 'DESC')->get();
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();

        $layananRehab = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'layanan_rehab')->first();
        $data['soap'] = @Emr::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->first();

        if ($layananRehab) {
            $data['layananRehab'] = json_decode($layananRehab->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'uji_fungsi_rehab')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'uji_fungsi_rehab')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        }
        //  else {
        //     $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'uji_fungsi_rehab')->first();
        //     $data['assesment'] = json_decode(@$assesment->fisik, true);
        // }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'uji_fungsi_rehab')->first();

        if ($r->method() == 'POST') {
            // if ($asessmentExists) {
            //     $asessment          =  EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'uji_fungsi_rehab')->orderBy('id', 'DESC')->first();
            //     $asessment_old = json_decode($asessment->fisik, true);
            //     $asessment_new = [];
            //     if (is_array($r->fisik)) {
            //         $asessment_new = array_merge($asessment_old, $r->fisik);
            //     } else {
            //         $asessment_new = $asessment_old;
            //     }
            //     $asessment->fisik   = json_encode($asessment_new);
            //     $asessment->type      = 'uji_fungsi_rehab';
            //     $asessment->save();
            //     Flashy::success('Record berhasil diupdate');
            //     return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            // } else {
            if (!$r->asessment_id) {
                $asessment = new EmrInapPemeriksaan();
            } else {
                $asessment = EmrInapPemeriksaan::where('id', $r->asessment_id)->first();
            }
            // $asessment = new EmrInapPemeriksaan();
            $asessment->pasien_id = $r->pasien_id;
            $asessment->registrasi_id = $r->registrasi_id;
            $asessment->user_id = Auth::user()->id;
            $asessment->fisik = json_encode($r->fisik);
            $asessment->type = 'uji_fungsi_rehab';
            $asessment->save();
            Flashy::success('Record berhasil disimpan');
            return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            // }
        }

        return view('emr.modules.pemeriksaan.ujiFungsi', $data);
    }

    public function rehabBaru(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['pegawai'] = Pegawai::whereIn('id', [295, 473, 296])->get(); //tim rehab medik

        $aswal      = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_rehab_medik')->orderBy('id', 'DESC')->first();
        $ujiFungsi  = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'uji_fungsi_rehab')->orderBy('id', 'DESC')->first();
        $data['aswal']      = json_decode(@$aswal->fisik, true);
        $data['ujiFungsi']  = json_decode(@$ujiFungsi->fisik, true);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'rehab_baru')->orderBy('id', 'DESC')->get();
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();

        $layananRehab = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'layanan_rehab')->first();
        $data['soap'] = @Emr::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->first();
        $data['soap_terapis'] = @Emr::where('registrasi_id', $registrasi_id)->whereIn('user_id', [295, 473, 296])->orderBy('id', 'DESC')->first();

        if ($layananRehab) {
            $data['layananRehab'] = json_decode(@$layananRehab->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'rehab_baru')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'rehab_baru')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }

        $current_asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'rehab_baru')->orderBy('id', 'DESC')->first();
        $data['current_asessment'] = json_decode(@$current_asessment->fisik, true);

        if ($r->method() == 'POST') {

            if (!$r->asessment_id) {
                $asessment = new EmrInapPemeriksaan();
            } else {
                $asessment = EmrInapPemeriksaan::where('id', $r->asessment_id)->first();
            }
            $asessment->pasien_id = $r->pasien_id;
            $asessment->registrasi_id = $r->registrasi_id;
            $asessment->user_id = Auth::user()->id;
            $asessment->fisik = json_encode($r->fisik);
            $asessment->type = 'rehab_baru';
            $asessment->save();
            Flashy::success('Record berhasil disimpan');
            return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
        }

        return view('emr.modules.pemeriksaan.rehabBaru', $data);
    }

    public function hapusPemeriksaan($unit, $reg_id, $id)
    {
        $reg = Registrasi::withTrashed()->find($reg_id);
        EmrInapPenilaian::where('registrasi_id', $reg_id)->delete();
        EmrInapPemeriksaan::find($id)->delete();
        Flashy::success('Data Asesmen Berhasil Dihapus.');

        // return redirect('emr-soap/anamnesis/main/' . $unit . '/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id);
        return redirect()->back();
    }

    public function historyAskep($id)
    {
        $pasien = Pasien::find($id);
        $reg = Registrasi::where('pasien_id', $id)->get();

        if ($reg) {
            foreach ($reg as $s) {
                $idregs[] = $s->id;
            }
        }

        $askep = EmrInapPemeriksaan::whereIn('registrasi_id', $idregs)->whereIn('type', ['asuhan-kebidanan', 'asuhan-keperawatan'])->orderBy('id', 'DESC')->get();

        $data = [];
        if ($askep) {
            foreach ($askep as $d) {
                $data[] = [
                    'askepId' => $d->id,
                    'regId' => $d->registrasi_id,
                    'type' => $d->type,
                    'fisik' => json_decode(@$d->fisik, true) ?? @$d->fisik,
                    'siki' => json_decode($d->pemeriksaandalam, true),
                    'implementasi' => json_decode($d->fungsional, true),
                    'diagnosis' => json_decode($d->diagnosis, true),
                    'tglRegis' => Carbon::parse($d->registrasi->created_at)->format('d-m-Y'),
                ];
            }
        }
        // return $data; die;
        return view('emr.modules.pemeriksaan.historyAskep', compact('pasien', 'data'));
    }

    public function historyAskepDelete($askep_id)
    {
        $askep = EmrInapPemeriksaan::where('id', $askep_id)->where('type', 'asuhan-keperawatan')->orderBy('id', 'DESC')->first();
        if ($askep) {
            $delete = $askep->delete();
            if ($delete) {
                Flashy::success('Data Asuhan Keperawatan Berhasil Dihapus.');
                return redirect()->back();
            }
        }

        Flashy::error('Data Asuhan Keperawatan Gagal dihapus.');
        return redirect()->back();
    }

    public function askepDelete($askep_id)
    {
        $askep = EmrInapPemeriksaan::where('id', $askep_id)->where('type', 'asuhan-keperawatan')->orderBy('id', 'DESC')->first();

        if ($askep) {
            $delete = $askep->delete();
            if ($delete) {
                Flashy::success('Data Asuhan Keperawatan Berhasil Dihapus.');
                return redirect()->back();
            }
        }

        Flashy::error('Data Asuhan Keperawatan Gagal dihapus.');
        return redirect()->back();
    }

    public function TTEAskep(Request $request)
    {
        $askepId = $request->askep_id;
        $regId = $request->registrasi_id;

        $reg = Registrasi::find($regId);
        $pasien = Pasien::find($reg->pasien_id);
        $askep = EmrInapPemeriksaan::find($askepId);

        $diagnosis = json_decode($askep->diagnosis, true);
        $siki = json_decode($askep->pemeriksaandalam, true);
        $implementasi = json_decode($askep->fungsional, true);
        $jam_tindakan = json_decode(@$askep->fisik, true) ?? @$askep->fisik;
        $keterangan = json_decode(@$askep->keterangan, true) ?? @$askep->keterangan;


        if (tte()) {
            $proses_tte = true;
            $pdf = PDF::loadView('resume.cetak_pdf_askep', compact(
                'reg',
                'askep',
                'diagnosis',
                'siki',
                'implementasi',
                'proses_tte',
                'pasien',
                'jam_tindakan',
                'keterangan'
            ));
            $pdf->setPaper('A4', 'landscape');
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-askep.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($regId, $tte->response, "askep", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $askep->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $askep->save();
                Flashy::success('Berhasil melakukan proses TTE dokumen !');
                return redirect()->back();
            } elseif ($tte->httpStatusCode == 400) {
                if (isset($resp->error)) {
                    Flashy::error($resp->error);
                    return redirect()->back();
                }
            } elseif ($tte->httpStatusCode == 500) {
                Flashy::error($tte->response);
                return redirect()->back();
            }
            Flashy::error('Gagal melakukan proses TTE dokumen !');
            return redirect()->back();
        } else {
            $tte_nonaktif = true;
            $pdf = PDF::loadView('resume.cetak_pdf_askep', compact(
                'reg',
                'askep',
                'diagnosis',
                'siki',
                'implementasi',
                'tte_nonaktif',
                'pasien',
                'jam_tindakan',
                'keterangan'
            ));
            $pdf->setPaper('A4', 'landscape');
            $pdfContent = $pdf->output();

            $askep->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $askep->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
    }

    public function historyAskeb($id)
    {
        $pasien = Pasien::find($id);
        $reg = Registrasi::where('pasien_id', $id)->get();

        if ($reg) {
            foreach ($reg as $s) {
                $idregs[] = $s->id;
            }
        }

        $askeb = EmrInapPemeriksaan::whereIn('registrasi_id', $idregs)->whereIn('type', ['asuhan-kebidanan', 'asuhan-keperawatan'])->orderBy('id', 'DESC')->get();

        $data = [];
        if ($askeb) {
            foreach ($askeb as $d) {
                $data[] = [
                    'askebId' => $d->id,
                    'regId' => $d->registrasi_id,
                    'type' => $d->type,
                    'fisik' => json_decode(@$d->fisik, true) ?? @$d->fisik,
                    'siki' => json_decode($d->pemeriksaandalam, true),
                    'implementasi' => json_decode($d->fungsional, true),
                    'diagnosis' => json_decode($d->diagnosis, true),
                    'tglRegis' => Carbon::parse($d->registrasi->created_at)->format('d-m-Y'),
                ];
            }
        }
        // return $data; die;
        return view('emr.modules.pemeriksaan.historyAskeb', compact('pasien', 'data'));
    }

    public function historyAskebDelete($askeb_id)
    {
        $askeb = EmrInapPemeriksaan::where('id', $askeb_id)->where('type', 'asuhan-kebidanan')->orderBy('id', 'DESC')->first();
        if ($askeb) {
            $delete = $askeb->delete();
            if ($delete) {
                Flashy::success('Data Asuhan Kebidanan Berhasil Dihapus.');
                return redirect()->back();
            }
        }

        Flashy::error('Data Asuhan Kebidanan Gagal dihapus.');
        return redirect()->back();
    }

    public function askebDelete($askeb_id)
    {
        $askeb = EmrInapPemeriksaan::where('id', $askeb_id)->where('type', 'asuhan-kebidanan')->orderBy('id', 'DESC')->first();
        if ($askeb) {
            $delete = $askeb->delete();
            if ($delete) {
                Flashy::success('Data Asuhan Kebidanan Berhasil Dihapus.');
                return redirect()->back();
            }
        }

        Flashy::error('Data Asuhan Kebidanan Gagal dihapus.');
        return redirect()->back();
    }

    public function TTEAskeb(Request $request)
    {
        $askebId = $request->askeb_id;
        $regId = $request->registrasi_id;

        $reg = Registrasi::find($regId);
        $pasien = Pasien::find($reg->pasien_id);
        $askeb = EmrInapPemeriksaan::find($askebId);

        $diagnosis = json_decode($askeb->diagnosis, true);
        $siki = json_decode($askeb->pemeriksaandalam, true);
        $implementasi = json_decode($askeb->fungsional, true);


        if (tte()) {
            $proses_tte = true;
            $pdf = PDF::loadView('resume.cetak_pdf_askeb', compact(
                'reg',
                'askeb',
                'diagnosis',
                'siki',
                'implementasi',
                'proses_tte',
                'pasien'
            ));
            $pdf->setPaper('A4', 'landscape');
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-askeb.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($regId, $tte->response, "askeb", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $askeb->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $askeb->save();
                Flashy::success('Berhasil melakukan proses TTE dokumen !');
                return redirect()->back();
            } elseif ($tte->httpStatusCode == 400) {
                if (isset($resp->error)) {
                    Flashy::error($resp->error);
                    return redirect()->back();
                }
            } elseif ($tte->httpStatusCode == 500) {
                Flashy::error($tte->response);
                return redirect()->back();
            }
            Flashy::error('Gagal melakukan proses TTE dokumen !');
            return redirect()->back();
        } else {
            $tte_nonaktif = true;
            $pdf = PDF::loadView('resume.cetak_pdf_askeb', compact(
                'reg',
                'askeb',
                'diagnosis',
                'siki',
                'implementasi',
                'tte_nonaktif',
                'pasien'
            ));
            $pdf->setPaper('A4', 'landscape');
            $pdfContent = $pdf->output();

            $askeb->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $askeb->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
    }

    public function awalMedisTHT(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-tht')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-tht')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-tht')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-tht')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-tht')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-tht')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-medis-tht';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-tht';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisTHT', $data);
    }

    public function awalMedisDalam(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-dalam')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-dalam')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-dalam')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-dalam')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-dalam')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-dalam')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-medis-dalam';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-dalam';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisDalam', $data);
    }

    public function awalMedisParu(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-paru')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-paru')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-paru')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-paru')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-paru')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-paru')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-medis-paru';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-paru';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisParu', $data);
    }

    public function awalMedisPsikiatri(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-psikiatri')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-psikiatri')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-psikiatri')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-psikiatri')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-psikiatri')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-psikiatri')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-medis-psikiatri';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-psikiatri';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisPsikiatri', $data);
    }

    public function awalMedisKulit(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->where('type', 'kulit')->first();
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-kulit')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-kulit')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-kulit')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-kulit')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-kulit')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-kulit')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-medis-kulit';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-kulit';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisKulit', $data);
    }

    public function awalMedisBedah(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->where('type', 'kulit')->first();
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-bedah')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-bedah')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-bedah')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-bedah')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-bedah')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-bedah')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-medis-bedah';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-bedah';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisBedahNew', $data);
    }

    public function awalMedisGigi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->where('type', 'gigi')->first();
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-gigi')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-gigi')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-gigi')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-gigi')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-gigi')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-gigi')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-medis-gigi';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-gigi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisGigi', $data);
    }

    public function awalMedisNeurologi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->where('type', 'kulit')->first();
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-neurologi')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-neurologi')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-neurologi')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-neurologi')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-neurologi')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-neurologi')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-medis-neurologi';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-neurologi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisNeurologi', $data);
    }

    public function awalMedisMata(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['gambar1'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->where('type', 'mata1')->first();
        $data['gambar2'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->where('type', 'mata2')->first();
        $data['gambar3'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->where('type', 'mata3')->first();
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-mata')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-mata')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-mata')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-mata')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-mata')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-mata')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-medis-mata';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-mata';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }


        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisMata', $data);
    }

    public function awalMedisBedahMulut(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->whereNull('cppt_id')->where('type', 'bedah-mulut')->first();
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-bedah-mulut')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-bedah-mulut')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-bedah-mulut')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-bedah-mulut')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-bedah-mulut')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->update();

                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-bedah-mulut')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->update();

                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-bedah-mulut';
                $asessment->save();

                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisBedahMulut', $data);
    }

    public function awalMedisRehabMedik(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-rehab-medik')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-rehab-medik')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-rehab-medik')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-rehab-medik')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-rehab-medik')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->update();

                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-rehab-medik')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->update();

                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-rehab-medik';
                $asessment->save();

                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisRehabMedik', $data);
    }

    public function awalMedisOnkologi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-onkologi')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-onkologi')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-onkologi')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-onkologi')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-onkologi')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->update();

                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-onkologi')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->update();

                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-onkologi';
                $asessment->save();

                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisOnkologi', $data);
    }

    public function awalMedisAnak(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-anak')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-anak')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-anak')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-anak')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-anak')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-anak')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-medis-anak';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-anak';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisAnak', $data);
    }

    public function awalMedisObgyn(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-obgyn')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-obgyn')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-obgyn')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-obgyn')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-obgyn')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-obgyn')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-medis-obgyn';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-obgyn';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisObgyn', $data);
    }

    public function awalMedisNeonatus(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-neonatus')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-neonatus')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-neonatus')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-neonatus')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-neonatus')->first();
        $assesmentPerinatologi = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-perinatologi')->first();
        $data['perinatologi'] = json_decode(@$assesmentPerinatologi->fisik, true);
        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-neonatus')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-awal-medis-neonatus';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-neonatus';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisNeonatus', $data);
    }


    public function awalMedisGizi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'asesmen-awal-medis-gizi')->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();
        $assesmenPerawat = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->whereIn('type', asesmen_ranap_perawat())->first();

        if ($assesmenPerawat) {
            $data['assesmen_perawat'] = @json_decode($assesmenPerawat->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-gizi')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-medis-gizi')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-gizi')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-gizi')->first();

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->update();

                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-medis-gizi')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->update();

                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-awal-medis-gizi';
                $asessment->save();

                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        if ($unit == "inap") {
            ini_set('max_execution_time', 0); //0=NOLIMIT
            ini_set('memory_limit', '8000M');
            $data['icd9'] = PerawatanIcd9::where('registrasi_id', $registrasi_id)->pluck('icd9')->toArray();
            $data['icd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->pluck('icd10')->toArray();
            $data['reg_id'] = $registrasi_id;
            $data['tagihan'] = Folio::where(['registrasi_id' => $registrasi_id, 'lunas' => 'N'])->sum('total');
            $data['rawatinap'] = Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                if (@$data['reg']->status_reg == NULL) {
                    if ($data['rawatinap']->tgl_keluar) {
                        @$data['reg']->status_reg = 'I3';
                    } else {
                        @$data['reg']->status_reg = 'I2';
                    }
                    @$data['reg']->save();
                }
            }
            $data['carabayar'] = Carabayar::pluck('carabayar', 'id');
            $data['kamar'] = Kamar::pluck('nama', 'id');
            $data['kelas'] = Kelas::pluck('nama', 'id');
            $data['inacbgs'] = Inacbgs_sementara::where('registrasi_id', $registrasi_id)->first();
            // $data['tarif'] = Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')->where('tarifs.jenis', '=', 'TI')->select('tarifs.*', 'kategoritarifs.namatarif')->get();
            $data['tarif'] = Tarif::select('nama', 'kode', 'total')->get();
            $data['pagu'] = PaguPerawatan::all();
            $data['dokter'] = Pegawai::all();
            // inhealth mandiri
            $data['inhealth'] = inhealthSjp::where('reg_id', $registrasi_id)->first();
            if ($data['rawatinap']) {
                session(['kelas' => $data['rawatinap']->kelas_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.dokter.awalMedisGizi', $data);
    }

    public function asesmenAnakPerawat(Request $r, $unit, $registrasi_id)
    {
        // dd("MAAF HALAMAN INI SEDANG DALAM PROSES");
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->whereIn('type', ['asuhan-keperawatan','inap-perawat-anak'])->orderBy('id', 'DESC')->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawats'] = Pegawai::whereIn('kategori_pegawai', [2, 3])->get();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-perawat-anak')->exists();
        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'inap-perawat-anak')->first();
            $data['assesment'] = json_decode($assesment->fisik, true);
            $data['fungsional'] = json_decode($assesment->fungsional, true);
            $data['pemeriksaandalam'] = json_decode($assesment->pemeriksaandalam, true);
            $data['nutrisi'] = json_decode($assesment->nutrisi, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-perawat-anak')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
            $data['fungsional'] = json_decode(@$assesment->fungsional, true);
            $data['pemeriksaandalam'] = json_decode(@$assesment->pemeriksaandalam, true);
            $data['nutrisi'] = json_decode(@$assesment->nutrisi, true);
        }

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true) ?? [];
                $asessment_new = [];
                $fungsional_old = json_decode($update->fungsional, true) ?? [];
                $fungsional_new = [];
                $pemeriksaandalam_old = json_decode($update->pemeriksaandalam, true) ?? [];
                $pemeriksaandalam_new = [];
                $nutrisi_old = json_decode($update->nutrisi, true) ?? [];
                $nutrisi_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                if (is_array($r->fungsional)) {
                    $fungsional_new = array_merge($fungsional_old, $r->fungsional);
                } else {
                    $fungsional_new = $fungsional_old;
                }

                if (is_array($r->pemeriksaandalam)) {
                    $pemeriksaandalam_new = array_merge($pemeriksaandalam_old, $r->pemeriksaandalam);
                } else {
                    $pemeriksaandalam_new = $pemeriksaandalam_old;
                }

                if (is_array($r->nutrisi)) {
                    $nutrisi_new = array_merge($nutrisi_old, $r->nutrisi);
                } else {
                    $nutrisi_new = $nutrisi_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->fungsional = json_encode($fungsional_new);
                $update->pemeriksaandalam = json_encode($pemeriksaandalam_new);
                $update->nutrisi = json_encode($nutrisi_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-perawat-anak')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true) ?? [];
                $asessment_new = [];
                $fungsional_old = json_decode($asessment->fungsional, true) ?? [];
                $fungsional_new = [];
                $pemeriksaandalam_old = json_decode($asessment->pemeriksaandalam, true) ?? [];
                $pemeriksaandalam_new = [];
                $nutrisi_old = json_decode($asessment->nutrisi, true) ?? [];
                $nutrisi_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                if (is_array($r->fungsional)) {
                    $fungsional_new = array_merge($fungsional_old, $r->fungsional);
                } else {
                    $fungsional_new = $fungsional_old;
                }

                if (is_array($r->pemeriksaandalam)) {
                    $pemeriksaandalam_new = array_merge($pemeriksaandalam_old, $r->pemeriksaandalam);
                } else {
                    $pemeriksaandalam_new = $pemeriksaandalam_old;
                }

                if (is_array($r->nutrisi)) {
                    $nutrisi_new = array_merge($nutrisi_old, $r->nutrisi);
                } else {
                    $nutrisi_new = $nutrisi_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->fungsional = json_encode($fungsional_new);
                $asessment->pemeriksaandalam = json_encode($pemeriksaandalam_new);
                $asessment->nutrisi = json_encode($nutrisi_new);
                $asessment->type = 'inap-perawat-anak';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->fungsional = json_encode($r->fungsional);
                $asessment->pemeriksaandalam = json_encode($r->pemeriksaandalam);
                $asessment->nutrisi = json_encode($r->nutrisi);
                $asessment->type = 'inap-perawat-anak';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        return view('emr.modules.pemeriksaan.asesmenAnak', $data);
    }

    public function pemeriksaanGizi(Request $r, $registrasi_id)
    {
        // dd($r);
        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['unit'] = 'inap';
        $data['riwayats'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-perawat-dewasa')->whereNotNull('nutrisi')->orderBy('id', 'DESC')->get();
        $data['cppt'] = Emr::where('registrasi_id', $registrasi_id)->latest()->first();
        if ($r->asessment_id !== null) {
            $data['assesment'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'inap-perawat-dewasa')->first();
            $data['nutrisi'] = json_decode(@$data['assesment']->nutrisi, true);
            $data['nutrisiId'] = 'Y';
        }

        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            $pemeriksaan = EmrInapPemeriksaan::find($r->asessment_id);

            $nutrisi_old = json_decode($pemeriksaan->nutrisi, true) ?? [];
            $nutrisi_new = [];

            if (is_array($r->nutrisi)) {
                $nutrisi_new = array_merge($nutrisi_old, $r->nutrisi);
            } else {
                $nutrisi_new = $nutrisi_old;
            }

            if (!empty($r->user_id)) {
                $pemeriksaan->user_id = $r->user_id;
            }

            $pemeriksaan->nutrisi = json_encode($nutrisi_new);
            $pemeriksaan->update();
            Flashy::success('Berhasil Di Verifikasi');
            return redirect($r->url());
        }
        return view('emr.modules.pemeriksaan.inap.perawat.skrining-gizi', $data);
    }

    public function pemeriksaanGiziAnak(Request $r, $registrasi_id)
    {
        // dd($r);
        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['unit'] = 'inap';
        $data['riwayats'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-perawat-anak')->whereNotNull('nutrisi')->orderBy('id', 'DESC')->get();
        // dd($data['riwayat']);
        $data['cppt'] = Emr::where('registrasi_id', $registrasi_id)->latest()->first();

        if ($r->asessment_id !== null) {
            $data['assesment'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'inap-perawat-anak')->first();
            $data['nutrisi'] = json_decode(@$data['assesment']->nutrisi, true);
            $data['nutrisiId'] = 'Y';
        }

        if ($r->method() == 'POST') {
            $pemeriksaan = EmrInapPemeriksaan::find($r->asessment_id);

            $nutrisi_old = json_decode($pemeriksaan->nutrisi, true) ?? [];
            $nutrisi_new = [];

            if (is_array($r->nutrisi)) {
                $nutrisi_new = array_merge($nutrisi_old, $r->nutrisi);
            } else {
                $nutrisi_new = $nutrisi_old;
            }

            if (!empty($r->user_id)) {
                $pemeriksaan->user_id = $r->user_id;
            }

            $pemeriksaan->nutrisi = json_encode($nutrisi_new);
            $pemeriksaan->update();
            Flashy::success('Berhasil Di Verifikasi');
            return redirect($r->url());
        }
        return view('emr.modules.pemeriksaan.inap.perawat.skrining-gizi-anak', $data);
    }

    public function pemeriksaanGiziMaternitas(Request $r, $registrasi_id)
    {
        // dd($r);
        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['unit'] = 'inap';
        $data['riwayats'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-awal-perawat-maternitas')->orderBy('id', 'DESC')->get();
        $data['cppt'] = Emr::where('registrasi_id', $registrasi_id)->latest()->first();
        // dd($data['riwayat']);

        if ($r->asessment_id !== null) {
            $data['assesment'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-awal-perawat-maternitas')->first();
            $data['skrining'] = @json_decode(@$data['assesment']->fisik, true)['skrining_nutrisi_dewasa'];
            $data['nutrisiId'] = 'Y';
        }

        if ($r->method() == 'POST') {
            $pemeriksaan = EmrInapPemeriksaan::find($r->asessment_id);

            $nutrisi_old = json_decode($pemeriksaan->fisik, true) ?? [];
            $nutrisi_new = [];

            if (is_array($r->fisik)) {
                $nutrisi_new = array_merge($nutrisi_old, $r->fisik);
            } else {
                $nutrisi_new = $nutrisi_old;
            }

            if (!empty($r->user_id)) {
                $pemeriksaan->user_id = $r->user_id;
            }

            $pemeriksaan->fisik = json_encode($nutrisi_new);
            $pemeriksaan->update();
            Flashy::success('Berhasil Di Verifikasi');
            return redirect($r->url());
        }
        return view('emr.modules.pemeriksaan.inap.perawat.skrining-gizi-maternitas', $data);
    }

    public function pemeriksaanGiziPerinatologi(Request $r, $registrasi_id)
    {
        // dd($r);
        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['unit'] = 'inap';
        $data['riwayats'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-perinatologi')->orderBy('id', 'DESC')->get();
        $data['cppt'] = Emr::where('registrasi_id', $registrasi_id)->latest()->first();
        // dd($data['riwayat']);

        if ($r->asessment_id !== null) {
            $data['assesment'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-perinatologi')->first();
            $data['skrining'] = @json_decode(@$data['assesment']->fisik, true)['skrining_gizi_neonatus'];
            $data['nutrisiId'] = 'Y';
        }

        if ($r->method() == 'POST') {
            $pemeriksaan = EmrInapPemeriksaan::find($r->asessment_id);

            $nutrisi_old = json_decode($pemeriksaan->fisik, true) ?? [];
            $nutrisi_new = [];

            if (is_array($r->fisik)) {
                $nutrisi_new = array_merge($nutrisi_old, $r->fisik);
            } else {
                $nutrisi_new = $nutrisi_old;
            }

            if (!empty($r->user_id)) {
                $pemeriksaan->user_id = $r->user_id;
            }

            $pemeriksaan->fisik = json_encode($nutrisi_new);
            $pemeriksaan->update();
            Flashy::success('Berhasil Di Verifikasi');
            return redirect($r->url());
        }
        return view('emr.modules.pemeriksaan.inap.perawat.skrining-gizi-perinatologi', $data);
    }

    public function asuhanGizi(Request $r, $registrasi_id)
    {
        // dd($r);
        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['unit'] = 'inap';
        $data['riwayat'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-gizi')->orderBy('id', 'DESC')->get();
        if ($r->method() == 'POST') {
            $pemeriksaan = new EmrInapPemeriksaan();
            $pemeriksaan->pasien_id = $r->pasien_id;
            $pemeriksaan->registrasi_id = $r->registrasi_id;
            $pemeriksaan->user_id = Auth::user()->id;
            $pemeriksaan->fisik = json_encode($r->data);
            $pemeriksaan->type = 'asuhan-gizi';
            $pemeriksaan->save();
            Flashy::success('Record berhasil disimpan');
            return redirect()->back();
        }
        return view('emr.modules.pemeriksaan.inap.perawat.asuhan_gizi_terintegrasi', $data);
    }

    public function nyeriInap(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'inap-nyeri')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-nyeri')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'inap-nyeri')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-nyeri')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-nyeri')->first();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r);
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-nyeri')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'inap-nyeri';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'inap-nyeri';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.perawat.inap-nyeri', $data);
    }

    public function resikoJatuhDewasaInap(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'inap-resiko-jatuh-dewasa')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-resiko-jatuh-dewasa')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'inap-resiko-jatuh-dewasa')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-resiko-jatuh-dewasa')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-resiko-jatuh-dewasa')->first();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r);
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-resiko-jatuh-dewasa')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'inap-resiko-jatuh-dewasa';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'inap-resiko-jatuh-dewasa';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.perawat.inap-resiko-jatuh-dewasa', $data);
    }

    public function resikoJatuhAnakInap(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-perawat-anak')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'inap-perawat-anak')->first();
            $data['pemeriksaandalam'] = @json_decode(@$asessment->pemeriksaandalam, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-perawat-anak')->first();
            $data['pemeriksaandalam'] = @json_decode(@$asessment->pemeriksaandalam, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-perawat-anak')->first();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            // dd($r);
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-perawat-anak')->orderBy('id', 'DESC')->first();
                $pemeriksaandalam_old = json_decode($asessment->pemeriksaandalam, true) ?? [];
                $pemeriksaandalam_new = [];

                if (is_array($r->pemeriksaandalam)) {
                    $pemeriksaandalam_new = array_merge($pemeriksaandalam_old, $r->pemeriksaandalam);
                } else {
                    $pemeriksaandalam_new = $pemeriksaandalam_old;
                }

                $asessment->pemeriksaandalam = json_encode($pemeriksaandalam_new);
                $asessment->type = 'inap-perawat-anak';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->pemeriksaandalam = json_encode($r->pemeriksaandalam);
                $asessment->type = 'inap-perawat-anak';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.perawat.inap-resiko-jatuh-anak', $data);
    }

    public function resikoJatuhNeonatusInap(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'inap-resiko-jatuh-neonatus')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-resiko-jatuh-neonatus')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'inap-resiko-jatuh-neonatus')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-resiko-jatuh-neonatus')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-resiko-jatuh-neonatus')->first();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-resiko-jatuh-neonatus')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'inap-resiko-jatuh-neonatus';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'inap-resiko-jatuh-neonatus';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.perawat.inap-resiko-jatuh-neonatus', $data);
    }

    public function edukasiInap(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'edukasi-inap')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'edukasi-inap')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'edukasi-inap')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'edukasi-inap')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'edukasi-inap')->first();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'edukasi-inap')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'edukasi-inap';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'edukasi-inap';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }
        return view('emr.modules.pemeriksaan.inap.perawat.inap-edukasi', $data);
    }

    public function praAnestesi(Request $r, $unit, $registrasi_id)
    {
        // dd("MAAF HALAMAN INI SEDANG DALAM PROSES");
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'pra-anestesi')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'pra-anestesi')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'pra-anestesi')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'pra-anestesi')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'pra-anestesi')->first();
        $data['laboratorium'] = Folio::where('registrasi_id', $registrasi_id)->where('poli_tipe', 'L')->select('namatarif')->get();
        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $update->fisik = json_encode($asessment_new);
                $update->update();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'pra-anestesi')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($r->fisik)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->update();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'pra-anestesi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back();
            }
        }

        return view('emr.modules.pemeriksaan.inap.operasi.praAnestesi', $data);
    }

    public function laporanOperasi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['source'] = $r->get('source');
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'laporan-operasi')
            ->orderBy('id', 'DESC')
            ->get();
        $data['pasien'] = Pasien::find($data['reg']->pasien_id);
        $data['smf'] = smf();
        $data['smfTemp'] = Pegawai::where('nama', '!=', 'dr. Irvan Agusta')->pluck('nama', 'id');
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $data['perawats'] = Pegawai::where('kategori_pegawai', 2)->pluck('nama', 'id');
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-operasi')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'laporan-operasi')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-operasi')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-operasi')->first();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-operasi')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'laporan-operasi';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'laporan-operasi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.operasi.laporan-operasi', $data);
    }

    public function laporanOperasiRanap(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['source'] = $r->get('source');
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'laporan-operasi-ranap')
            ->orderBy('id', 'DESC')
            ->get();
        $data['pasien'] = Pasien::find($data['reg']->pasien_id);
        $data['smf'] = smf();
        $data['smfTemp'] = Pegawai::where('nama', '!=', 'dr. Irvan Agusta')->pluck('nama', 'id');
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $data['perawats'] = Pegawai::where('kategori_pegawai', 2)->pluck('nama', 'id');
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-operasi-ranap')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'laporan-operasi-ranap')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-operasi-ranap')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-operasi-ranap')->first();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-operasi-ranap')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'laporan-operasi-ranap';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'laporan-operasi-ranap';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.operasi.laporan-operasi-ranap', $data);
    }

    public function laporanOperasiODS(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['smf'] = smf();
        $data['pasien'] = Pasien::find($data['reg']->pasien_id);
        $data['source'] = $r->get('source');
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id) // pastikan pasien_id benar
            ->leftJoin('pasiens', 'pasiens.no_rm', '=', 'emr_inap_pemeriksaans.pasien_id') // pastikan kolom yang di-join sesuai (di sini saya asumsikan pasien_id di tabel pasiens adalah 'id')
            ->where('type', 'laporan-operasi-ods') // pastikan type benar
            ->orderBy('emr_inap_pemeriksaans.id', 'DESC') // tambahkan alias tabel jika perlu untuk order by
            ->get();
        $data['dokters'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $data['perawats'] = Pegawai::where('kategori_pegawai', 2)->pluck('nama', 'id');
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-operasi-ods')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'laporan-operasi-ods')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-operasi-ods')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-operasi-ods')->first();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-operasi-ods')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'laporan-operasi-ods';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'laporan-operasi-ods';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.operasi.laporan-operasi-ods', $data);
    }

    public function asesmenPraBedah(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'asesmen-pra-bedah')
            ->orderBy('id', 'DESC')
            ->get();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-pra-bedah')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'asesmen-pra-bedah')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-pra-bedah')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-pra-bedah')->first();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asesmen-pra-bedah')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'asesmen-pra-bedah';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'asesmen-pra-bedah';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.operasi.asesmen-pra-bedah', $data);
    }

    public function daftarTilik(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'daftar-tilik')
            ->orderBy('id', 'DESC')
            ->get();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'daftar-tilik')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'daftar-tilik')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'daftar-tilik')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'daftar-tilik')->first();
        // dd($data['riwayat']);

        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'daftar-tilik')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'daftar-tilik';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'daftar-tilik';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.operasi.daftar-tilik', $data);
    }

    public function kartuAnestesi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['cppt'] = Emr::where('registrasi_id', $registrasi_id)->ordeBy('id', 'DESC')->first();
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'kartu-anestesi')
            ->orderBy('id', 'DESC')
            ->get();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'kartu-anestesi')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'kartu-anestesi')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'kartu-anestesi')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'kartu-anestesi')->first();
        // dd($data['riwayat']);


        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'kartu-anestesi')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'kartu-anestesi';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'kartu-anestesi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.operasi.kartu-anestesi', $data);
    }

    public function keadaanPascaBedah(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'keadaan-pasca-bedah')
            ->orderBy('id', 'DESC')
            ->get();

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'keadaan-pasca-bedah')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'keadaan-pasca-bedah')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'keadaan-pasca-bedah')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'keadaan-pasca-bedah')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'keadaan-pasca-bedah')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'keadaan-pasca-bedah';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'keadaan-pasca-bedah';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.operasi.keadaan-pasca-bedah', $data);
    }

    public function asesmenInapPerawatDewasa(Request $r, $unit, $registrasi_id)
    {
        // dd("MAAF HALAMAN INI SEDANG DALAM PROSES");
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'inap-perawat-dewasa')
            ->orderBy('id', 'DESC')
            ->get();

        $asesmenDokter = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)
            ->where('type', 'assesment-awal-medis-igd')
            ->first();
        if ($asesmenDokter) {
            $data['dataAsesmenDokter'] = json_decode($asesmenDokter->fisik, true);
        }
        $asesmenPonek = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)
            ->where('type', 'assesment-awal-medis-igd-ponek')
            ->first();
        if ($asesmenPonek) {
            $data['dataAsesmenPonek'] = json_decode($asesmenPonek->fisik, true);
        }

        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-perawat-dewasa')->exists();

        if ($r->asessment_id !== null) {
            $assesment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'inap-perawat-dewasa')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
            $data['fungsional'] = json_decode(@$assesment->fungsional, true);
            $data['pemeriksaandalam'] = json_decode(@$assesment->pemeriksaandalam, true);
            $data['nutrisi'] = json_decode(@$assesment->nutrisi, true);
        } else {
            $assesment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-perawat-dewasa')->first();
            $data['assesment'] = json_decode(@$assesment->fisik, true);
            $data['fungsional'] = json_decode(@$assesment->fungsional, true);
            $data['pemeriksaandalam'] = json_decode(@$assesment->pemeriksaandalam, true);
            $data['nutrisi'] = json_decode(@$assesment->nutrisi, true);
        }

        if ($r->method() == 'POST') {
            LogUserController::log(Auth::user()->id, 'asesmen', @$registrasi_id);
            if ($r->asessment_id != null) {
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true) ?? [];
                $asessment_new = [];
                $fungsional_old = json_decode($update->fungsional, true) ?? [];
                $fungsional_new = [];
                $pemeriksaandalam_old = json_decode($update->pemeriksaandalam, true) ?? [];
                $pemeriksaandalam_new = [];
                $nutrisi_old = json_decode($update->nutrisi, true) ?? [];
                $nutrisi_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                if (is_array($r->fungsional)) {
                    $fungsional_new = array_merge($fungsional_old, $r->fungsional);
                } else {
                    $fungsional_new = $fungsional_old;
                }

                if (is_array($r->pemeriksaandalam)) {
                    $pemeriksaandalam_new = array_merge($pemeriksaandalam_old, $r->pemeriksaandalam);
                } else {
                    $pemeriksaandalam_new = $pemeriksaandalam_old;
                }

                if (is_array($r->nutrisi)) {
                    $nutrisi_new = array_merge($nutrisi_old, $r->nutrisi);
                } else {
                    $nutrisi_new = $nutrisi_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->fungsional = json_encode($fungsional_new);
                $update->pemeriksaandalam = json_encode($pemeriksaandalam_new);
                $update->nutrisi = json_encode($nutrisi_new);
                $update->update();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'inap-perawat-dewasa')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->fisik, true) ?? [];
                $asessment_new = [];
                $fungsional_old = json_decode($asessment->fungsional, true) ?? [];
                $fungsional_new = [];
                $pemeriksaandalam_old = json_decode($asessment->pemeriksaandalam, true) ?? [];
                $pemeriksaandalam_new = [];
                $nutrisi_old = json_decode($asessment->nutrisi, true) ?? [];
                $nutrisi_new = [];

                if (is_array($r->fisik)) {
                    $asessment_new = array_merge($asessment_old, $r->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }

                if (is_array($r->fungsional)) {
                    $fungsional_new = array_merge($fungsional_old, $r->fungsional);
                } else {
                    $fungsional_new = $fungsional_old;
                }

                if (is_array($r->pemeriksaandalam)) {
                    $pemeriksaandalam_new = array_merge($pemeriksaandalam_old, $r->pemeriksaandalam);
                } else {
                    $pemeriksaandalam_new = $pemeriksaandalam_old;
                }
                if (is_array($r->nutrisi)) {
                    $nutrisi_new = array_merge($nutrisi_old, $r->nutrisi);
                } else {
                    $nutrisi_new = $nutrisi_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->fungsional = json_encode($fungsional_new);
                $asessment->pemeriksaandalam = json_encode($pemeriksaandalam_new);
                $asessment->nutrisi = json_encode($nutrisi_new);
                $asessment->update();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->fungsional = json_encode($r->fungsional);
                $asessment->pemeriksaandalam = json_encode($r->pemeriksaandalam);
                $asessment->nutrisi = json_encode($r->nutrisi);
                $asessment->type = 'inap-perawat-dewasa';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back()->withInput(['poli' => $data['reg']->poli_id, 'dpjp' => $data['reg']->dokter_id]);
            }
        }

        return view('emr.modules.pemeriksaan.inap.perawat.asesmen-dewasa', $data);
    }

    public function pengkajianGizi(Request $request, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['hasillab'] = Hasillab::with('orderLab.folios')->where('registrasi_id', $registrasi_id)->whereNotNull('order_lab_id')->orderBy('id', 'DESC')->get();
        $dokter_user_id = Pegawai::where('kategori_pegawai', 1)->whereNotNull('user_id')->groupBy('user_id')->pluck('user_id')->toArray();
        $data['cppt_perawat'] = Emr::where('unit', '!=', 'sbar')->where('registrasi_id', $registrasi_id)->whereNotIn('user_id', $dokter_user_id)->first();
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik_gizi')->orderBy('id', 'DESC')->get();
        $asessment_id = $request->get('asessment_id');

        if ($asessment_id) {
            $asessment = EmrInapPemeriksaan::find($asessment_id);
        } else {
            if (cek_status_reg($data['reg']) == 'I') {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)
                    ->where('type', 'asesmen-awal-perawat-maternitas')
                    ->first();
            } else {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)
                    ->where('type', 'fisik_gizi')
                    ->first();
            }
        }
        
        $data['assesment'] = json_decode(@$asessment->fisik, true);
        $data['current_asessment'] = $asessment;
        if ($request->method() == 'POST') {
            // Ambil isi diagnosa gizi dan dipisah tiap kata
            $diagnosa = explode(" ", $request->fisik['diagnosa_gizi']);

            // Simpan diagnosa gizi ke table predictive
            if (count($diagnosa) > 0) {
                $this->savePredictive($diagnosa);
            }

            // Cek apakah sudah ada asesmen untuk registrasi saat ini
            if ($asessment) {
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($request->fisik)) {
                    $asessment_new = array_merge($asessment_old, $request->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'fisik_gizi';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $request->pasien_id;
                $asessment->registrasi_id = $request->registrasi_id;
                $asessment->created_at = Carbon::parse($request->tanggal_pemeriksaan);
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($request->fisik);
                $asessment->type = 'fisik_gizi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back();
            }
        }
        return view('emr.modules.pemeriksaan.pengkajian_gizi', $data);
    }

    public function savePredictive(array $text)
    {
        foreach ($text as $item) {
            $predictive = Predictive::where('text', 'like', $item)->first();

            if (empty($predictive)) {
                $predictive = new Predictive();
            }

            $predictive->text = ucfirst(strtolower($item));
            $predictive->save();
        }
    }

    public function riwayat($unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['cppt'] = Emr::where('pasien_id', @$data['reg']->pasien->id)->orderBy('id', 'DESC')->get();
        $data['ews_dewasa'] = EmrEws::where('registrasi_id', @$data['reg']->id)->where('type', 'ews-dewasa')->orderBy('id', 'DESC')->get();
        $data['ews_maternal'] = EmrEws::where('registrasi_id', @$data['reg']->id)->where('type', 'ews-maternal')->orderBy('id', 'DESC')->get();
        $data['ews_anak'] = EmrEws::where('registrasi_id', @$data['reg']->id)->where('type', 'ews-anak')->orderBy('id', 'DESC')->get();
        return view('emr.modules.pemeriksaan.riwayat', $data);
    }

    public function icu(Request $request, $unit, $registrasi_id)
    {
        ini_set('max_input_vars', 5000);
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);

        $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'icu')->first();
        $data['assesment'] = json_decode(@$asessment->fisik, true);
        $data['current_asessment'] = $asessment;

        if ($request->method() == 'POST') {
            if ($asessment) {
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];
                if (is_array($request->fisik)) {
                    $asessment_new = array_merge($asessment_old, $request->fisik);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'icu';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $request->pasien_id;
                $asessment->registrasi_id = $request->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($request->fisik);
                $asessment->type = 'icu';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back();
            }
        }
        return view('emr.modules.pemeriksaan.icu', $data);
    }



    public function laporanPersalinan(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'laporan-persalinan')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-persalinan')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'laporan-persalinan')->first();
            $data['assesment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-persalinan')->first();
            $data['assesment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-persalinan')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'laporan-persalinan')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'laporan-persalinan';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'laporan-persalinan';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.perawat.laporan_persalinan', $data);
    }


    public function cetaklaporanPersalinan($registrasi_id)
    {

        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['laporan'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'laporan-persalinan')->first();

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-laporan-persalinan', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Laporan Persalinan_' . $data['reg']->pasien->nama . '.pdf');
    }

    public function catatanPersalinan(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'catatan-persalinan')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan-persalinan')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'catatan-persalinan')->first();
            $data['assesment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan-persalinan')->first();
            $data['assesment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan-persalinan')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan-persalinan')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'catatan-persalinan';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'catatan-persalinan';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.perawat.catatan_persalinan', $data);
    }

    public function cetakcatatanPersalinan($registrasi_id)
    {

        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['laporan'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'catatan-persalinan')->first();

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-catatan-persalinan', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Catatan_Persalinan_' . $data['reg']->pasien->nama . '.pdf');
    }

    public function daftarPemberianTerapi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)
            ->where('type', 'daftar-pemberian-terapi')
            ->where('is_done_input', true)
            ->orderBy('id', 'DESC')
            ->get();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('id', $r->asessment_id)->where('type', 'daftar-pemberian-terapi')->first();
            $data['assesment'] = json_decode($asessment->fisik, true);
            $data['not_done_input'] = array();
        } else {
            $data['not_done_input'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'daftar-pemberian-terapi')->where('registrasi_id', $registrasi_id)->where('is_done_input', false)->orderBy('id', 'DESC')->get();
        }

        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
            }

            if ($r->simpan) {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'daftar-pemberian-terapi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.perawat.daftar_pemberian_terapi', $data);
    }

    public function cetakPemberianTerapi($unit, $reg_id, $id)
    {
        $assesments = EmrInapPemeriksaan::find($id);
        $reg = Registrasi::find($reg_id);
        $dokter = Pegawai::find($reg->dokter_id);
        $cetak = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'daftar-pemberian-terapi')->first();
        $assesment = json_decode(@$assesments->fisik, true);

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak_pdf_pemberian_terapi', compact('reg', 'dokter', 'cetak', 'assesment', 'assesments'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Daftar Pemberian Terapi.pdf');
    }

    public function handOverPasien(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'hand-over-pasien')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'hand-over-pasien')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'hand-over-pasien')->first();
            $data['assesment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'hand-over-pasien')->first();
            $data['assesment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'hand-over-pasien')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'hand-over-pasien')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'hand-over-pasien';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'hand-over-pasien';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.perawat.handOverPasien', $data);
    }

    public function cetakcatatanHandOver($registrasi_id)
    {

        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['laporan'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'hand-over-pasien ')->first();

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-catatan-persalinan', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Catatan_Persalinan_' . $data['reg']->pasien->nama . '.pdf');
    }

    public function catatanIntakeOutput(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'catatan-intake-output')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan-intake-output')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'catatan-intake-output')->first();
            $data['assesment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan-intake-output')->first();
            $data['assesment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan-intake-output')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan-intake-output')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'catatan-intake-output';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'catatan-intake-output';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.catatan_intake_output', $data);
    }

    public function cetakIntakeOutput($registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['laporan'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'catatan-intake-output')->first();

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak_catatan_intake_output', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Catatan_Intake_Output_' . $data['reg']->pasien->nama . '.pdf');
    }
    
    public function lembarKendaliRegimen(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'lembar-kendali-regimen')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'lembar-kendali-regimen')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'lembar-kendali-regimen')->first();
            $data['assesment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'lembar-kendali-regimen')->first();
            $data['assesment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'lembar-kendali-regimen')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'lembar-kendali-regimen')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'lembar-kendali-regimen';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'lembar-kendali-regimen';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.lembar_kendali_regimen', $data);
    }

    public function cetakLembarKendaliRegimen($registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['pasien'] = Pasien::find($data['reg']->pasien_id);
        $data['dokter'] = Pegawai::find($data['reg']->dokter_id);
        $data['laporan'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'lembar-kendali-regimen')->first();

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak_lembar_kendali_regimen', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Lembar_Kendali_Regimen' . $data['reg']->pasien->nama . '.pdf');
    }

    public function markDoneDaftarPemberianTerapi($id)
    {
        $asessment = EmrInapPemeriksaan::find($id);

        if ($asessment) {
            $asessment->is_done_input = true;
            $asessment->update();

            return response()->json(['sukses' => true]);
        }
        return response()->json(['sukses' => false]);
    }

    public function surveilansInfeksi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'surveilans-infeksi')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'surveilans-infeksi')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'surveilans-infeksi')->first();
            $data['assesment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'surveilans-infeksi')->first();
            $data['assesment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'surveilans-infeksi')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            // dd($r->all());
            if ($r->asessment_id != null) {
                $update = EmrInapPemeriksaan::find($r->asessment_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                // $update->type  	= 'surveilans-infeksi';
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
            } elseif ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'surveilans-infeksi')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'surveilans-infeksi';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'surveilans-infeksi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.perawat.surveilans_infeksi', $data);
    }

    public function partograf(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'partograf')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'partograf')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'partograf')->first();
            $data['assesment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'partograf')->first();
            $data['assesment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'partograf')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($r->gambar_partograf) {
                $base64_data = substr($r->gambar_partograf, strpos($r->gambar_partograf, ',') + 1);
            }

            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'partograf')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment_new["base64"] = @$base64_data;

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'partograf';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $fisik = $r->fisik;
                $fisik["base64"] = @$base64_data;
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($fisik);
                $asessment->type = 'partograf';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.perawat.partograf', $data);
    }

    public function cetakPartograf($registrasi_id)
    {

        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['partograf'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'partograf')->first();

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-partograf', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Catatan_Partograf_' . $data['reg']->pasien->nama . '.pdf');
    }


    public function lembarRawatGabung(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'lembar-rawat-gabung')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'lembar-rawat-gabung')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'lembar-rawat-gabung')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'lembar-rawat-gabung')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'lembar-rawat-gabung')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'lembar-rawat-gabung')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'lembar-rawat-gabung';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'lembar-rawat-gabung';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.perawat.lembar_rawat_gabung', $data);
    }

    public function pemeriksaanFisikAskep(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'pemeriksaan-fisik-askep')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'pemeriksaan-fisik-askep')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'pemeriksaan-fisik-askep')->first();
            $data['asessment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'pemeriksaan-fisik-askep')->first();
            $data['asessment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'pemeriksaan-fisik-askep')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'pemeriksaan-fisik-askep')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'pemeriksaan-fisik-askep';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'pemeriksaan-fisik-askep';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.inap.perawat.pemeriksaan_fisik_askep', $data);
    }

    public function daftarKontrolIstimewa(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats_kontrol_istimewa'] = EmrInapPemeriksaan::leftJoin('registrasis', 'registrasis.id', '=', 'emr_inap_pemeriksaans.registrasi_id')
            ->where('registrasis.poli_id', $data['reg']->poli_id)
            ->where('emr_inap_pemeriksaans.pasien_id', $data['reg']->pasien_id)
            ->where('emr_inap_pemeriksaans.registrasi_id', $data['reg']->id)
            ->where('emr_inap_pemeriksaans.type', 'daftar-kontrol-istimewa')
            ->orderBy('emr_inap_pemeriksaans.id', 'DESC')
            ->select('emr_inap_pemeriksaans.*')
            ->get();

        if ($r->daftar_kontrol_istimewa_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->daftar_kontrol_istimewa_id)->where('type', 'daftar-kontrol-istimewa')->first();
            $data['assesment'] = json_decode($asessment->fisik, true);
            $data['daftar_kontrol_istimewa_id'] = $r->daftar_kontrol_istimewa_id;
        }

        if ($r->method() == 'POST') {
            if ($r->daftar_kontrol_istimewa_id != null) {
                $update = EmrInapPemeriksaan::find($r->daftar_kontrol_istimewa_id);
                $asessment_old = json_decode($update->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->fisik = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
            }

            if ($r->simpan) {
                $asessment = new EmrInapPemeriksaan();
                Flashy::success('Record berhasil disimpan');
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'daftar-kontrol-istimewa';
                $asessment->save();
            }

            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.daftar-kontrol-istimewa', $data);
    }

    public function cetakDaftarKontrolIstimewa(Request $r, $unit, $registrasi_id)
    {

        if ($registrasi_id) {
            $data['registrasi_id'] = $registrasi_id;
            $data['unit'] = $unit;
            $data['histori'] = Historipengunjung::where('registrasi_id', $registrasi_id)->where('politipe', 'I')->first();
            $data['reg'] = Registrasi::find($registrasi_id);
            $data['pasien'] = Pasien::find($data['reg']->pasien_id);

            $data['riwayats_kontrol_istimewa'] = EmrInapPemeriksaan::leftJoin('registrasis', 'registrasis.id', '=', 'emr_inap_pemeriksaans.registrasi_id')
                ->where('registrasis.poli_id', $data['reg']->poli_id)
                ->where('emr_inap_pemeriksaans.pasien_id', $data['reg']->pasien_id)
                ->where('emr_inap_pemeriksaans.registrasi_id', $data['reg']->id)
                ->where('emr_inap_pemeriksaans.type', 'daftar-kontrol-istimewa')
                ->orderBy('emr_inap_pemeriksaans.id', 'DESC')
                ->select('emr_inap_pemeriksaans.*')
                ->get();

            $pdf = PDF::loadView('emr.modules.pemeriksaan.daftar-kontrol-istimewa-pdf', $data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream();
        }

    }

    public function dokumenPemberianInformasi(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'dokumen-pemberian-informasi')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'dokumen-pemberian-informasi')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'dokumen-pemberian-informasi')->first();
            $data['assesment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'dokumen-pemberian-informasi')->first();
            $data['assesment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'dokumen-pemberian-informasi')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'dokumen-pemberian-informasi')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'dokumen-pemberian-informasi';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'dokumen-pemberian-informasi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.dokumen-pemberian-informasi', $data);
    }

    public function cetakPemberianInformasi($unit, $reg_id)
    {
        $reg = Registrasi::find($reg_id);
        $dokter = Pegawai::find($reg->dokter_id);
        $cetak = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'dokumen-pemberian-informasi')->first();
        $data = json_decode(@$cetak->fisik, true);

        if ($unit == 'igd') {
            $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak_pdf_pemberian_informasi_igd', compact('reg', 'dokter', 'cetak', 'data'));
        } else {
            $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak_pdf_pemberian_informasi', compact('reg', 'dokter', 'cetak', 'data'));
        }
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Dokumen Pemberian Informasi.pdf');
    }

    public function pernyataanDNR(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'pernyataan-dnr')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'pernyataan-dnr')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'pernyataan-dnr')->first();
            $data['assesment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'pernyataan-dnr')->first();
            $data['assesment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'pernyataan-dnr')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'pernyataan-dnr')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'pernyataan-dnr';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'pernyataan-dnr';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.pernyataan-dnr', $data);
    }

    public function catatanHarian(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['riwayats'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)
            ->where('type', 'catatan-harian')
            ->orderBy('id', 'DESC')
            ->get();
        $asessmentExists = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan-harian')->exists();
        if ($r->asessment_id !== null) {
            $asessment = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'catatan-harian')->first();
            $data['assesment'] = json_decode($asessment->fisik, true);
        } else {
            $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan-harian')->first();
            $data['assesment'] = json_decode(@$asessment->fisik, true);
        }
        $data['current_asessment'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan-harian')->first();
        // dd($data['riwayat']);
        if ($r->method() == 'POST') {
            if ($asessmentExists) {
                $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan-harian')->first();
                $asessment_old = json_decode($asessment->fisik, true);
                $asessment_new = [];

                if (is_array($r->fisik)) {
                    if ($asessment_old != null) {
                        $asessment_new = array_merge($asessment_old, $r->fisik);
                    } else {
                        $asessment_new = $r->fisik;
                    }
                } else {
                    $asessment_new = $asessment_old;
                }

                $asessment->fisik = json_encode($asessment_new);
                $asessment->type = 'catatan-harian';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');

            } else {
                $asessment = new EmrInapPemeriksaan();
                $asessment->pasien_id = $r->pasien_id;
                $asessment->registrasi_id = $r->registrasi_id;
                $asessment->user_id = Auth::user()->id;
                $asessment->fisik = json_encode($r->fisik);
                $asessment->type = 'catatan-harian';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
            }
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.catatan-harian', $data);
    }

    public function tteTriage(Request $request, $id)
    {
        $data['pemeriksaan'] = EmrInapPemeriksaan::find($id);
        $data['pegawai'] = Pegawai::where('user_id', $data['pemeriksaan']->user_id)->first();
        $data['asessment'] = @json_decode(@$data['pemeriksaan']->fisik);
        $data['reg'] = Registrasi::find($data['pemeriksaan']->registrasi_id);
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $data['reg']->id)->first();
        $askep = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'asuhan-keperawatan')->orderBy('id', 'DESC')->first();
        if ($askep) {
            $data['diagnosis'] = json_decode($askep->diagnosis, true);
            $data['siki'] = json_decode($askep->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($askep->fungsional, true);
        }

        if (tte()) {
            $data['proses_tte'] = true;
            $pdf = PDF::loadView('resume.igd.cetak_pdf_triage_igd', $data);
            $pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();

            // Create temp pdf ekspertise file
            $filePath = uniqId() . 'triage-igd.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(300)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($request['registrasi_id'], $tte->response, "triage-igd", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $data['pemeriksaan']->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $data['pemeriksaan']->update();
                Flashy::success('Berhasil melakukan proses TTE dokumen !');
                return redirect()->back();
            } elseif ($tte->httpStatusCode == 400) {
                if (isset($resp->error)) {
                    Flashy::error($resp->error);
                    return redirect()->back();
                }
            } elseif ($tte->httpStatusCode == 500) {
                Flashy::error($tte->response);
                return redirect()->back();
            }

            Flashy::error('Gagal melakukan proses TTE dokumen');
            return redirect()->back();
        } else {
            $data['tte_nonaktif'] = true;
            $pdf = PDF::loadView('resume.igd.cetak_pdf_triage_igd', $data);
            $pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();
            $data['pemeriksaan']->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $data['pemeriksaan']->update();
            Flashy::success('Berhasil menandatangani dokumen!');
            return redirect()->back();
        }
    }

    public function getTteFile($id, $type)
    {
        $data = EmrInapPemeriksaan::find($id);

        $tte = json_decode($data->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $type . '-' . $data->id . '.pdf"',
        ]);
    }

    public function pengantar($unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['unit'] = $unit;

        $data['triage'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'triage-igd')->get();
        $data['aswal_igd'] = EmrInapPemeriksaan::where('registrasi_id', $data['reg']->id)->where('type', 'assesment-awal-medis-igd')->get();
        $data['transfer_internal'] = Emr::where('registrasi_id', $data['reg']->id)->where('unit', 'sbar')->get();
        $data['konsul_dokter'] = EmrKonsul::where('registrasi_id', @$data['reg']->id)->with('data_jawab_konsul')->where('type', 'konsul_dokter')->get();
        $data['spri'] = SuratInap::where('registrasi_id', $data['reg']->id)->get();
        $asessment = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->where('type', 'assesment-awal-medis-igd')->first();
        $data['asessment'] = json_decode(@$asessment->fisik, true);
        $data['rekonsiliasi'] = @$data['asessment']['rekonsiliasi'];
        $data['obatAlergi'] = @$data['asessment']['obatAlergi'];

        return view('emr.modules.pemeriksaan.pengantar', $data);
    }

    public function tindakanKeperawatan(Request $r, $unit, $registrasi_id)
    {
        $data['registrasi_id'] = $registrasi_id;
        $data['unit'] = $unit;
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['pegawai'] = Pegawai::all();
        $data['riwayats'] = EmrInapPemeriksaan::leftJoin('registrasis', 'registrasis.id', '=', 'emr_inap_pemeriksaans.registrasi_id')
            ->where('registrasis.poli_id', $data['reg']->poli_id)
            ->where('emr_inap_pemeriksaans.pasien_id', $data['reg']->pasien_id)
            ->where('emr_inap_pemeriksaans.registrasi_id', $data['reg']->id)
            ->where('emr_inap_pemeriksaans.type', 'tindakan-keperawatan')
            ->orderBy('emr_inap_pemeriksaans.id', 'DESC')
            ->select('emr_inap_pemeriksaans.*')
            ->get();

        if (!empty($r->asessment_id)) {
            $data['tindakanKeperawatan'] = EmrInapPemeriksaan::find($r->asessment_id);
            $data['asessmen'] = json_decode($data['tindakanKeperawatan']->fisik, true);
        }

        if ($r->method() == 'POST') {
            if (!empty($data['tindakanKeperawatan'])) {
                $asessment = $data['tindakanKeperawatan'];
                Flashy::success('Record berhasil diperbarui');
            } else {
                $asessment = new EmrInapPemeriksaan();
                Flashy::success('Record berhasil disimpan');
            }
            $asessment->pasien_id = $r->pasien_id;
            $asessment->registrasi_id = $r->registrasi_id;
            $asessment->user_id = Auth::user()->id;
            $asessment->fisik = json_encode($r->fisik);
            $asessment->type = 'tindakan-keperawatan';
            $asessment->save();
            return redirect()->back();
        }

        return view('emr.modules.pemeriksaan.tindakan-keperawatan', $data);
    }

    public static function cetakHasilPenunjang($registrasi_id, $id, Request $request)
    {
        $data['reg']       = Registrasi::find($registrasi_id);
        $data['pasien']    = Pasien::find($data['reg']->pasien_id);
        $data['penunjang'] = Emr::find($id);
        $data['dokter']    = Pegawai::find($data['reg']->dokter_id );

        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-hasil-penunjang', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('hasil_penunjang_'. $data['pasien']->nama . '.pdf');
    }

    public function uploadLaporanOperasi(Request $request,$unit, $registrasi_id)
	{
		$data['hasilPemeriksaan'] = HasilPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'operasi')->get();
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['unit'] = $unit;
		$data['registrasi_id']  = $registrasi_id;
        $data['source'] = $request->get('source');

		if ($request->method() == 'POST') {
			$request->validate(['file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg']);
			if(!empty($request->file('file'))){
				$filename = time().$request->file('file')->getClientOriginalName();
				$request->file('file')->move('hasil-pemeriksaan/', $filename);
			}else{
				$filename = null;
			}

			try{
				$operasi = new HasilPemeriksaan();
				$operasi->registrasi_id = $request->registrasi_id;
				$operasi->pasien_id = $request->pasien_id;
				$operasi->dokter_id = $request->dokter_id;
				$operasi->penanggungjawab = $request->penanggungjawab;
				$operasi->tgl_pemeriksaan = $request->tgl_pemeriksaan;
				$operasi->keterangan = $request->keterangan;
				$operasi->filename = $filename;
				$operasi->user_id = Auth::user()->id;
				$operasi->type = "operasi";
				$operasi->save();
				Flashy::success('Berhasil upload Laporan Operasi!');
			}catch(Exception $e){
				Flashy::error('Gagal mengupload Laporan Operasi!');
			}
			return redirect()->back();
		}

		return view('emr.modules.pemeriksaan.laporan_operasi', $data);
	}
}