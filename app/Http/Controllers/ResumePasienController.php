<?php

namespace App\Http\Controllers;

use App\Emr;
use Illuminate\Http\Request;
// use MercurySeries\Flashy\Flashy;
use Flashy;
use Modules\Registrasi\Entities\Registrasi;
use App\ResumePasien;
use App\KondisiAkhirPasien;
use App\Posisiberkas;
use App\PerawatanIcd10;
use App\PerawatanIcd9;
use App\JknIcd10;
use App\JknIcd9;
use App\Penjualan;
use App\EmrResume;
use App\Penjualandetal;
use App\BpjsProv;
use App\BpjsKab;
use App\BpjsKec;
use App\FaskesLanjutan;
use App\DataSep;
use Modules\Registrasi\Entities\Folio;
use PDF;
use App\RencanaKontrol;
use App\RegistrasiDummy;
use Auth;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use App\EmrInapPemeriksaan;
use App\EmrInapPenilaian;
use App\EmrInapPerencanaan;
use App\ResepNote;
use CURLFile;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\EsignLog;
use App\Hasillab;
use App\RadiologiEkspertise;
use App\EmrEws;
use App\HistoriSep;
use App\TandaTangan;
use Carbon\Carbon;

class ResumePasienController extends Controller
{

    function stringDecrypt($key, $string)
    {


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
    function decompress($string)
    {
        // dd($string);
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    }
    public function create($unit, $registrasi_id)
    {
        $data['reg']            = Registrasi::find($registrasi_id);
        $data['resume']         = ResumePasien::where('registrasi_id', $registrasi_id)->first();
        $data['kondisi']        = KondisiAkhirPasien::pluck('namakondisi', 'id');
        $data['posisi']         = Posisiberkas::pluck('keterangan', 'id');
        $data['perawatanicd9']  = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
        $data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();
        $data['rencana_kontrol']   = RencanaKontrol::where('registrasi_id', $registrasi_id)->get();
        $data['all_resume']     = ResumePasien::where('registrasi_id', $registrasi_id)->get();
        $data['poli']           = Poli::all();
        @$data['kontrol']        = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_umum')->first();
        @$data['cppt'] = Emr::where('registrasi_id', $registrasi_id)->latest()->first();
        if (@$data['kontrol']) {
            @$data['kontrol'] = @json_decode(@$data['kontrol']->fisik, true);
            @$tglkontrol = @explode("/", @$data['kontrol']['dischargePlanning']['kontrol']['waktu']);
            @$data['tgl'] = @$tglkontrol[0] . '-' . @$tglkontrol[1] . '-' . @$tglkontrol[2];
        }
        if (@$data['cppt']) {
            @$data['cppt'] = @json_decode(@$data['cppt']->discharge, true);
            @$data['tgl'] = $data['cppt']['dischargePlanning']['kontrol']['waktu'];
        }
        $data['dokter']         = Pegawai::whereNotNull('kode_bpjs')->get();

        // data create sep
        $dataOnline = RegistrasiDummy::where('registrasi_id', $registrasi_id)->first();
        if($dataOnline) {
            @$data['rujukan'] = @cekRujukan($dataOnline->no_rujukan);
            $data['poli_bpjs'] = Poli::find($data['reg']->poli_id)->bpjs;
            if($data['rujukan'][0]['metaData']['code'] == '200'){
                $data['rujukan'] = cekRujukan($dataOnline->no_rujukan)[1]['rujukan'];
                $poli_kode = $data['rujukan']['poliRujukan']['kode']; 
            }else{
                $poli_kode = $data['poli_bpjs'];
            }
            $pol = Poli::where('bpjs',$poli_kode)->first();
            $dokter_id = [];
            $dokter_id = explode(",",$pol->dokter_id);
            $data['dokter_bpjs'] = Pegawai::whereIn('id',$dokter_id)->get();
            $data['kd_ppk'] = FaskesLanjutan::all();
        }
		$data['bpjsprov'] = BpjsProv::select('propinsi', 'kode')->get();
		$data['bpjskab'] = BpjsKab::pluck('kabupaten', 'kode');
		$data['bpjskec'] = BpjsKec::pluck('kecamatan', 'kode');
		$data['surkon'] = RencanaKontrol::where('pasien_id',@$data['reg']->pasien_id)->orderBy('id','DESC')->limit(10)->get();
		$data['histori_sep'] = HistoriSep::where('registrasi_id',@$data['reg']->id)->first();
		$data['poli_bpjs'] = Poli::find(@$data['reg']->poli_id)->bpjs;
		$data['dokter_bpjs'] = Pegawai::find(@$data['reg']->dokter_id)->kode_bpjs;
		$data['kd_ppk'] = FaskesLanjutan::all();
		$data['noKartu'] = @$data['reg']->pasien->no_jkn;

        return view('resume.create', $data);
    }

    public function cetakRencanaKontrol($id)
    {

        $data['rencana_kontrol'] = RencanaKontrol::where('id', $id)->first();
        $tte    = json_decode($data['rencana_kontrol']->tte);

        if ($data['rencana_kontrol']->tte) {
            if (!empty($tte)) {
                $base64 = $tte->base64_signed_file;
    
                $pdfContent = base64_decode($base64);
                return Response::make($pdfContent, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="Surat kontrol-' . $data['rencana_kontrol']->id . '.pdf"',
                ]);
            } else {
                return redirect('/dokumen_tte/'.$data['rencana_kontrol']->tte);
            }
        } else {
            $pdf = PDF::loadView('resume.cetak_rencana_kontrol', $data);
            return $pdf->stream();
        }
    }

    public function save(Request $req)
    {
        $dokterBpjs = Pegawai::where('kode_bpjs', $req->kode_dokter)->first();

        // request()->validate([
        //         'tekanandarah' => 'required',
        //         'bb' => 'required',
        //         'diagnosa' => 'required',
        //         'tindakan' => 'required',
        //         'kondisi' => 'required'
        //     ]
        // );

        // $create = new \App\ResumePasien();
        // $create->registrasi_id = $request->registrasi_id;
        // $create->tekanandarah = $request->tekanandarah;
        // $create->bb = $request->bb;
        // $create->diagnosa = $request->diagnosa;
        // $create->tindakan = $request->tindakan;
        // $create->keterangan = $request->kondisi;
        // $create->save();

        // if ($request->rencana_kontrol) {
        // $kontrol = new RencanaKontrol();
        $registrasi = Registrasi::find($req->registrasi_id);
        if (empty($registrasi->no_sep)) {
            $registrasi->no_sep = @$req->no_sep;
            $registrasi->save();
        }
        $dok = $dokterBpjs ? $dokterBpjs->id : $registrasi->dokter_id;
        // $kontrol->registrasi_id = $request->registrasi_id;
        // $kontrol->resume_id = $create->id;
        // $kontrol->no_surat_kontrol = '';
        // $kontrol->dokter_id = $registrasi->dokter_id;
        // $kontrol->poli_id = $registrasi->poli_id;
        // $kontrol->pasien_id = $registrasi->pasien_id;
        // $kontrol->tgl_rencana_kontrol = date('Y-m-d', strtotime($request->rencana_kontrol));
        // $kontrol->user_id = Auth::user()->id;
        // $kontrol->no_sep = $registrasi->no_sep;
        // $kontrol->diagnosa_awal = $registrasi->diagnosa_awal;
        // $kontrol->save();

        // $ID = config('app.sep_id');
        // $t = time();
        // $data = "$ID&$t";
        // $secretKey = config('app.sep_key');
        // date_default_timezone_set('UTC');
        // $signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

        // $request = '{
        //             "request": { 
        //                 "noSEP": "' . $req->no_sep . '",
        //                 "kodeDokter": "' . Pegawai::where('id',$registrasi->dokter_id)->first()->kode_bpjs. '",
        //                 "poliKontrol": "' . Poli::where('id',$registrasi->poli_id)->first()->bpjs. '",
        //                 "tglRencanaKontrol": "' . date('Y-m-d', strtotime($req->rencana_kontrol)) . '",
        //                 "user": "' . Auth::user()->name . '" 
        //             }
        //             }'; 
        // // dd($request);
        // $completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/insert";

        // $session = curl_init($completeurl);
        // $arrheader = array(
        //     'X-cons-id: ' . $ID,
        //     'X-timestamp: ' . $t,
        //     'X-signature: ' . $signature,
        //     'user_key:'. config('app.user_key'),
        //     'Content-Type: application/x-www-form-urlencoded',
        // );
        // curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
        // curl_setopt($session, CURLOPT_POSTFIELDS, $request);
        // curl_setopt($session, CURLOPT_POST, TRUE);
        // curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

        // $response = curl_exec($session);
        // $array = json_decode($response, true); 
        // // dd($array);
        // if ($array['metaData']['code'] != "200") {
        //     Flashy::error($array['metaData']['message']); 
        //     return redirect()->back();
        // }else{
        //     $stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$array['response']);
        //     $sml = json_decode($this->decompress($stringEncrypt),true); 
        $kontrol = RencanaKontrol::where('no_surat_kontrol', $req->no_surat_kontrol)->where('registrasi_id', $req->registrasi_id)->first();
        if (!$kontrol) {
            $kontrol = new RencanaKontrol();
        }
        $kontrol->registrasi_id = $req->registrasi_id;
        $kontrol->resume_id = NULL;
        $kontrol->no_surat_kontrol = $req->no_surat_kontrol;
        $kontrol->dokter_id = $dok;
        $kontrol->no_rujukan = @$req->no_rujukan;
        $kontrol->tujuanKunj = @$req->tujuanKunj;
        $kontrol->flagProcedure = @$req->flagProcedure;
        $kontrol->kdPenunjang = @$req->kdPenunjang;
        $kontrol->assesmentPel = @$req->assesmentPel;
        $kontrol->input_from = 'kontrol';
        $kontrol->poli_id = $req->poli_id !== '' ? baca_id_poli($req->poli_id) : $registrasi->poli_id;
        $kontrol->pasien_id = $registrasi->pasien_id;
        $kontrol->tgl_rencana_kontrol = date('Y-m-d', strtotime($req->rencana_kontrol));
        $kontrol->user_id = Auth::user()->id;
        $kontrol->no_sep = $req->no_sep;
        // $kontrol->keterangan = $req->catatan;
        $kontrol->diagnosa_awal = $req->diagnosa_awal !== null ? $req->diagnosa_awal : $registrasi->diagnosa_awal;
        $kontrol->save();
        // dd($sml);



        // dd($kontrol);
        // }
        Flashy::success('Resume berhasil di input !');
        return redirect('cetak-rencana-kontrol/' . $kontrol->id);
        // return redirect()->back();
    }
    public function saveDataSep(Request $req)
    {
        $dokterBpjs = Pegawai::where('kode_bpjs', $req->kode_dokter)->first();

        $registrasi = Registrasi::find($req->registrasi_id);
        if (empty($registrasi->no_sep)) {
            $registrasi->no_sep = @$req->no_sep;
            $registrasi->save();
        }
        $dok = $dokterBpjs ? $dokterBpjs->id : $registrasi->dokter_id;

        $data_sep = DataSep::where('registrasi_id', $req->registrasi_id)->first();
        if (!$data_sep) {
            $data_sep = new DataSep();
        }
		
		$data_sep = new DataSep();
		$data_sep->nik = (!empty($req['nik'])) ? $req['nik'] : NULL;
		$data_sep->registrasi_id = (!empty($req['registrasi_id'])) ? $req['registrasi_id'] : NULL;
		$data_sep->namapasien = (!empty($req['namapasien'])) ? $req['namapasien'] : NULL;
		$data_sep->nama_kartu = (!empty($req['nama'])) ? $req['nama'] : NULL;
		$data_sep->nama_ppk_perujuk = (!empty($req['nama_ppk_perujuk'])) ? $req['nama_ppk_perujuk'] : NULL;
		$data_sep->kode_ppk_perujuk = (!empty($req['kode_ppk_perujuk'])) ? $req['kode_ppk_perujuk'] : NULL;
		$data_sep->no_rm = (!empty($req['no_rm'])) ? $req['no_rm'] : NULL;
		$data_sep->no_bpjs = (!empty($req['no_bpjs'])) ? $req['no_bpjs'] : NULL;
		$data_sep->no_tlp = (!empty($req['no_tlp'])) ? $req['no_tlp'] : NULL;
		$data_sep->tgl_rujukan = (!empty($req['tgl_rujukan'])) ? $req['tgl_rujukan'] : NULL;
		$data_sep->no_rujukan = (!empty($req['no_rujukan'])) ? $req['no_rujukan'] : NULL;
		$data_sep->ppk_rujukan = (!empty($req['ppk_rujukan'])) ? $req['ppk_rujukan'] : NULL;
		$data_sep->nama_perujuk = (!empty($req['nama_perujuk'])) ? $req['nama_perujuk'] : NULL;
		$data_sep->diagnosa_awal = (!empty($req['diagnosa_awal'])) ? $req['diagnosa_awal'] : NULL;
		$data_sep->jenis_layanan = (!empty($req['jenis_layanan'])) ? $req['jenis_layanan'] : NULL;
		$data_sep->asalRujukan = (!empty($req['asalRujukan'])) ? $req['asalRujukan'] : NULL;
		$data_sep->hak_kelas_inap = (!empty($req['hak_kelas_inap'])) ? $req['hak_kelas_inap'] : NULL;
		$data_sep->katarak = (!empty($req['katarak'])) ? $req['katarak'] : NULL;
		$data_sep->tglSep = (!empty($req['tglSep'])) ? $req['tglSep'] : NULL;
		$data_sep->tipe_jkn = (!empty($req['tipe_jkn'])) ? $req['tipe_jkn'] : NULL;
		$data_sep->poli_bpjs = (!empty($req['poli_bpjs'])) ? $req['poli_bpjs'] : NULL;
		$data_sep->noSurat = (!empty($req['noSurat'])) ? $req['noSurat'] : NULL;
		$data_sep->kodeDPJP = (!empty($req['kodeDPJP'])) ? $req['kodeDPJP'] : NULL;
		$data_sep->laka_lantas = (!empty($req['laka_lantas'])) ? $req['laka_lantas'] : NULL;
		$data_sep->penjamin = (!empty($req['penjamin'])) ? $req['penjamin'] : NULL;
		$data_sep->no_lp = (!empty($req['no_lp'])) ? $req['no_lp'] : NULL;
		$data_sep->tglKejadian = (!empty($req['tglKejadian'])) ? $req['tglKejadian'] : NULL;
		$data_sep->kll = (!empty($req['kll'])) ? $req['kll'] : NULL;
		$data_sep->suplesi = (!empty($req['suplesi'])) ? $req['suplesi'] : NULL;
		$data_sep->noSepSuplesi = (!empty($req['noSepSuplesi'])) ? $req['noSepSuplesi'] : NULL;
		$data_sep->kdPropinsi = (!empty($req['kdPropinsi'])) ? $req['kdPropinsi'] : NULL;
		$data_sep->kdKabupaten = (!empty($req['kdKabupaten'])) ? $req['kdKabupaten'] : NULL;
		$data_sep->kdKecamatan = (!empty($req['kdKecamatan'])) ? $req['kdKecamatan'] : NULL;
		$data_sep->no_sep = (!empty($req['no_sep'])) ? $req['no_sep'] : NULL;
		$data_sep->carabayar_id = (!empty($req['carabayar_id'])) ? $req['carabayar_id'] : NULL;
		$data_sep->catatan_bpjs = (!empty($req['catatan_bpjs'])) ? $req['catatan_bpjs'] : NULL;
		$data_sep->cob = (!empty($req['cob'])) ? $req['cob'] : NULL;
		$data_sep->dokter_id = (!empty($req['dokter_id'])) ? $req['dokter_id'] : NULL;
		$data_sep->​kodeDPJP = (!empty($req['​kodeDPJP'])) ? $req['​kodeDPJP'] : NULL;
		$data_sep->save();

        Flashy::success('Data berhasil di input !');
        return redirect()->back();
    }

    public function tteSurkon(Request $req)
    {
        $kontrol = RencanaKontrol::find($req->surkon_id);
        $data['rencana_kontrol'] = $kontrol;
        if (tte()) {
            $data['proses_tte'] = true;
            $pdf = PDF::loadView('resume.cetak_rencana_kontrol', $data);
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-surat-kontrol-pasien.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(150)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $req->nik, $req->passphrase, '#', $qrCodePath);

            log_esign($req->registrasi_id, $tte->response, "surat-kontrol-pasien", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $kontrol->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $kontrol->update();
                Flashy::success('Berhasil melakukan tanda tangan elektronik !');
                return redirect()->back();
            } elseif ($tte->httpStatusCode == 400) {
                if (isset($resp->error)) {
                    Flashy::error($resp->error);
                    return redirect()->back();
                } else {
                    Flashy::error($resp);
                    return redirect()->back();
                }
            } elseif ($tte->httpStatusCode == 500) {
                Flashy::error($tte->response);
                return redirect()->back();
            }
        } else {
            $data['tte_nonaktif'] = true;
            $pdf = PDF::loadView('resume.cetak_rencana_kontrol', $data);
            $pdfContent = $pdf->output();

            $kontrol->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $kontrol->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
    }

    public function deleteResume($id)
    {
        $find   = ResumePasien::find($id);
        $find->delete();
        $rencana = RencanaKontrol::where('resume_id', $id)->delete();
        return response()->json(true);
    }

    public function cetakResume($reg_id)
    {
        $data['reg'] = Registrasi::find($reg_id);
        $data['resume'] = ResumePasien::where('registrasi_id', $reg_id)->get();

        return view('resume.cetak', $data)->with('no', 1);
    }

    public function cetakPDFResume($reg_id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();

        $pdf = PDF::loadView('resume.cetak_pdf', compact('reg', 'resume'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('resume-laporan.pdf');
    }

    public function cetakPDFResumeRencanaKontrol($reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $emrPemeriksaan   = EmrInapPemeriksaan::find($id);
        $soap = json_decode($emrPemeriksaan->fisik, true);
        $gambar = EmrInapPenilaian::where('registrasi_id', $reg_id)->first();
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);
        $kategoriPegawai = @Auth::user()->pegawai->kategori_pegawai;
        if ($kategoriPegawai == 1) {
            $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal', compact('reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'obats', 'rads', 'labs', 'gambar'));
        } else {
            if ($reg->poli_id == 8 || $reg->poli_id == 10) {
                $pdf = PDF::loadView('resume.asesmen_perawat_rajal.cetak_pdf_anak', compact('reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'obats', 'rads', 'labs', 'gambar'));
            } elseif ($reg->poli_id == 19) {
                $pdf = PDF::loadView('resume.asesmen_perawat_rajal.cetak_pdf_psikiatri', compact('reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'obats', 'rads', 'labs', 'gambar'));
            } else {
                $pdf = PDF::loadView('resume.asesmen_perawat_rajal.cetak_pdf_umum', compact('reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'obats', 'rads', 'labs', 'gambar'));
            }
        }
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('resume-laporan.pdf');
        // if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1'){
        //     $pdf = PDF::loadView('resume.cetak_pdf_igd', compact('reg','resume','soap','tgl'));
        //     $pdf->setPaper('A4', 'portrait');
        //     return $pdf->stream('resume-laporan.pdf');
        // }else if (substr($reg->status_reg, 0, 1) == 'J'){
        //     $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal', compact('reg','resume','soap','tgl'));
        //     $pdf->setPaper('A4', 'portrait');
        //     return $pdf->stream('resume-laporan.pdf');
        // }else if (substr($reg->status_reg, 0, 1) == 'I'){
        //     $pdf = PDF::loadView('resume.cetak_pdf_rencana_kontrol', compact('reg','resume','soap','tgl'));
        //     $pdf->setPaper('A4', 'portrait');
        //     return $pdf->stream('resume-laporan.pdf');
        // }
    }

    public function cetakPDFResumeRencanaKontrolMCU($reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $emrPemeriksaan   = EmrInapPemeriksaan::find($id);
        $soap = json_decode($emrPemeriksaan->fisik, true);
        $gambar = EmrInapPenilaian::where('registrasi_id', $reg_id)->first();
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);
        $kategoriPegawai = @Auth::user()->pegawai->kategori_pegawai;
        if ($kategoriPegawai == 1) {
            $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_mcu', compact('reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'obats', 'rads', 'labs', 'gambar'));
        } else {
            $pdf = PDF::loadView('resume.asesmen_perawat_rajal.cetak_pdf_mcu', compact('reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'obats', 'rads', 'labs', 'gambar'));
        }
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('resume-laporan.pdf');
    }

    public function cetakPDFResumeRencanaKontrolObgyn(Request $request, $reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $emrPemeriksaan   = EmrInapPemeriksaan::find($id);
        $soap = json_decode($emrPemeriksaan->fisik, true);
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $gambar = EmrInapPenilaian::where('registrasi_id', $reg_id)->first();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);
        $kategoriPegawai = @Auth::user()->pegawai->kategori_pegawai;

        // Jika Request nya POST 
        if ($request->method() == 'POST') {
            if (tte()) {
                $proses_tte = true;
                if ($kategoriPegawai == 1) {
                    $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_obgyn', compact('proses_tte', 'reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'obats', 'rads', 'labs', 'gambar'));
                } else {
                    $pdf = PDF::loadView('resume.asesmen_perawat_rajal.cetak_pdf_obgyn', compact('proses_tte', 'reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'obats', 'rads', 'labs', 'gambar'));
                }
                $pdf->setPaper('A4', 'portrait');
                $pdfContent = $pdf->output();

                // Create temp pdf eresep file
                $filePath = uniqId() . '-resume-medis-obgyn.pdf';
                File::put(public_path($filePath), $pdfContent);

                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);

                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

                log_esign($reg->id, $tte->response, "resume-medis-obgyn", $tte->httpStatusCode);

                $resp = json_decode($tte->response);

                if ($tte->httpStatusCode == 200) {
                    $emrPemeriksaan->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                    $emrPemeriksaan->save();
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
                if ($kategoriPegawai == 1) {
                    $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_obgyn', compact('tte_nonaktif', 'reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'obats', 'rads', 'labs', 'gambar'));
                } else {
                    $pdf = PDF::loadView('resume.asesmen_perawat_rajal.cetak_pdf_obgyn', compact('tte_nonaktif', 'reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'obats', 'rads', 'labs', 'gambar'));
                }
                $pdf->setPaper('A4', 'portrait');

                $pdfContent = $pdf->output();
                $emrPemeriksaan->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
                $emrPemeriksaan->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }

        if ($kategoriPegawai == 1) {
            $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_obgyn', compact('reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'obats', 'rads', 'labs', 'gambar'));
        } else {
            $pdf = PDF::loadView('resume.asesmen_perawat_rajal.cetak_pdf_obgyn', compact('reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'obats', 'rads', 'labs', 'gambar'));
        }
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('resume-laporan.pdf');
        // if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1'){
        //     $pdf = PDF::loadView('resume.cetak_pdf_igd', compact('reg','resume','soap','tgl'));
        //     $pdf->setPaper('A4', 'portrait');
        //     return $pdf->stream('resume-laporan.pdf');
        // }else if (substr($reg->status_reg, 0, 1) == 'J'){
        //     $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal', compact('reg','resume','soap','tgl'));
        //     $pdf->setPaper('A4', 'portrait');
        //     return $pdf->stream('resume-laporan.pdf');
        // }else if (substr($reg->status_reg, 0, 1) == 'I'){
        //     $pdf = PDF::loadView('resume.cetak_pdf_rencana_kontrol', compact('reg','resume','soap','tgl'));
        //     $pdf->setPaper('A4', 'portrait');
        //     return $pdf->stream('resume-laporan.pdf');
        // }
    }

    public function cetakPDFResumeRencanaKontrolGigi(Request $request, $reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $soap   = EmrInapPemeriksaan::find($id);
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $gambar = EmrInapPenilaian::where('registrasi_id', $reg_id)->first();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);

        // Jika Request nya POST 
        if ($request->method() == 'POST') {
            if (tte()) {
                $proses_tte = true;
                if ($soap->type == 'fisik_gigi') {
                    $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_gigi', compact('proses_tte', 'reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
                    $pdf->setPaper('A4', 'portrait');
                } elseif ($soap->type == 'fisik_gigi_perawat') {
                    $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_gigi_perawat', compact('proses_tte', 'reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
                    $pdf->setPaper('A4', 'portrait');
                }
                $pdfContent = $pdf->output();

                // Create temp pdf eresep file
                $filePath = uniqId() . '-resume-medis-gigi.pdf';
                File::put(public_path($filePath), $pdfContent);

                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);

                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

                log_esign($reg->id, $tte->response, "resume-medis-gigi", $tte->httpStatusCode);

                $resp = json_decode($tte->response);

                if ($tte->httpStatusCode == 200) {
                    $soap->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                    $soap->save();
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
                if ($soap->type == 'fisik_gigi') {
                    $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_gigi', compact('tte_nonaktif', 'reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
                    $pdf->setPaper('A4', 'portrait');
                } elseif ($soap->type == 'fisik_gigi_perawat') {
                    $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_gigi_perawat', compact('tte_nonaktif', 'reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
                    $pdf->setPaper('A4', 'portrait');
                }
                $pdfContent = $pdf->output();
                $soap->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
                $soap->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }

        if ($soap->type == 'fisik_gigi') {
            $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_gigi', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('resume-laporan.pdf');
        } elseif ($soap->type == 'fisik_gigi_perawat') {
            $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_gigi_perawat', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('resume-laporan.pdf');
        }
        // if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1'){
        //     $pdf = PDF::loadView('resume.cetak_pdf_igd', compact('reg','resume','soap','tgl'));
        //     $pdf->setPaper('A4', 'portrait');
        //     return $pdf->stream('resume-laporan.pdf');
        // }else if (substr($reg->status_reg, 0, 1) == 'J'){
        //     $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal', compact('reg','resume','soap','tgl'));
        //     $pdf->setPaper('A4', 'portrait');
        //     return $pdf->stream('resume-laporan.pdf');
        // }else if (substr($reg->status_reg, 0, 1) == 'I'){
        //     $pdf = PDF::loadView('resume.cetak_pdf_rencana_kontrol', compact('reg','resume','soap','tgl'));
        //     $pdf->setPaper('A4', 'portrait');
        //     return $pdf->stream('resume-laporan.pdf');
        // }
    }

    public function cetakPDFResumeRencanaKontrolGizi($reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $soap   = EmrInapPemeriksaan::find($id);
        $folio  = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads   = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs   = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats  = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $gambar = EmrInapPenilaian::where('registrasi_id', $reg_id)->first();
        $tgl    = date('Y-m-d', strtotime($reg->created_at));
        $data   = poli::find($reg->poli_id);
        $pdf    = PDF::loadView('resume.cetak_pdf_resume_rajal_gizi', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($reg->pasien->no_rm . '_Resume_Medis_Gizi.pdf');
    }

    public function cetakPDFResumeRencanaKontrolRehabMedik($reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $soap   = EmrInapPemeriksaan::find($id);
        $folio  = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads   = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs   = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats  = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $gambar = EmrInapPenilaian::where('registrasi_id', $reg_id)->first();
        $tgl    = date('Y-m-d', strtotime($reg->created_at));
        $data   = poli::find($reg->poli_id);
        $pdf    = PDF::loadView('resume.cetak_pdf_resume_rajal_rehab_medik', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($reg->pasien->no_rm . '_Resume_Medis_Rehab_Medik.pdf');
    }



    public function cetakPDFResumeRencanaKontrolHemodialisis(Request $request, $reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $soap   = EmrInapPemeriksaan::find($id);
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $gambar = EmrInapPenilaian::where('registrasi_id', $reg_id)->first();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);

        // Jika Request nya POST 
        if ($request->method() == 'POST') {
            if (tte()) {
                $proses_tte = true;
                if ($soap->type == 'fisik_hemodialisis') {
                    $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_hemodialisis', compact('proses_tte', 'reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
                    $pdf->setPaper('A4', 'portrait');
                } elseif ($soap->type == 'fisik_hemodialisis_perawat') {
                    $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_hemodialisis_perawat', compact('proses_tte', 'reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
                    $pdf->setPaper('A4', 'portrait');
                }
                $pdfContent = $pdf->output();

                // Create temp pdf eresep file
                $filePath = uniqId() . '-resume-medis-hemodialisis.pdf';
                File::put(public_path($filePath), $pdfContent);

                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);

                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

                log_esign($reg->id, $tte->response, "resume-medis-hemodialisis", $tte->httpStatusCode);

                $resp = json_decode($tte->response);

                if ($tte->httpStatusCode == 200) {
                    $soap->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                    $soap->save();
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
                if ($soap->type == 'fisik_hemodialisis') {
                    $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_hemodialisis', compact('tte_nonaktif', 'reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
                    $pdf->setPaper('A4', 'portrait');
                } elseif ($soap->type == 'fisik_hemodialisis_perawat') {
                    $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_hemodialisis_perawat', compact('tte_nonaktif', 'reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
                    $pdf->setPaper('A4', 'portrait');
                }
                $pdfContent = $pdf->output();
                $soap->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
                $soap->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }

        if ($soap->type == 'fisik_hemodialisis') {
            $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_hemodialisis', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('resume-laporan.pdf');
        } elseif ($soap->type == 'fisik_hemodialisis_perawat') {
            $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_hemodialisis_perawat', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('resume-laporan.pdf');
        }
    }

    public function cetakPDFResumeRencanaKontrolMata($reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $emrPemeriksaan   = EmrInapPemeriksaan::find($id);
        $soap = json_decode($emrPemeriksaan->fisik, true);
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $gambar1 = EmrInapPenilaian::where('registrasi_id', $reg_id)->where('type', 'mata1')->first();
        $gambar2 = EmrInapPenilaian::where('registrasi_id', $reg_id)->where('type', 'mata2')->first();
        $gambar3 = EmrInapPenilaian::where('registrasi_id', $reg_id)->where('type', 'mata3')->first();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);
        $kategoriPegawai = @Auth::user()->pegawai->kategori_pegawai;

        if (@$kategoriPegawai == 1) {
            $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_mata', compact('reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar1', 'gambar2', 'gambar3'));
        } else {
            $pdf = PDF::loadView('resume.asesmen_perawat_rajal.cetak_pdf_mata', compact('reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'gambar1', 'gambar2', 'gambar3'));
        }

        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Resume Asesmen ' . @$reg->pasien->nama . '.pdf');
    }

    public function cetakPDFResumeRencanaKontrolParu($reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $emrPemeriksaan   = EmrInapPemeriksaan::find($id);
        $soap = json_decode($emrPemeriksaan->fisik, true);
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);
        $kategoriPegawai = @Auth::user()->pegawai->kategori_pegawai;

        if (@$kategoriPegawai == 1) {
            $pdf = PDF::loadView('resume.cetak_pdf_resume_rajal_paru', compact('reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats'));
        } else {
            $pdf = PDF::loadView('resume.asesmen_perawat_rajal.cetak_pdf_paru', compact('reg', 'resume', 'emrPemeriksaan', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats'));
        }

        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Resume Asesmen ' . @$reg->pasien->nama . '.pdf');
    }

    public function cetakPDFEresume(Request $request, $reg_id, $id)
    {
        $source = $request->source;
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $askep  = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('type', 'asuhan-keperawatan')->orderBy('id', 'DESC')->get();
        if ($source == 'asesmen') {
            $soap   = EmrInapPemeriksaan::find($id);
        } else {
            $soap   = Emr::find($id);
        }
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $eresep = ResepNote::where('registrasi_id', $reg->id)->get();
        // $gambar = EmrInapPenilaian::where('registrasi_id', $reg_id)->first();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);

        if ($source == 'asesmen') {
            if (strpos($soap->type, 'fisik') === 0) {
                $tipe = $request->tipe;
                $pdf = PDF::loadView('resume.cetak_pdf_eresume_rajal', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'source', 'eresep', 'askep', 'tipe'));
            } else {
                $data['tipe'] = $request->tipe;
                $data['reg'] = Registrasi::find($reg_id);
                $data['pemeriksaan']   = EmrInapPemeriksaan::find($id);
                $data['soap']   = $data['pemeriksaan'];
                $data['source']   = $source;
                $data['asessment']      = @json_decode(@$data['pemeriksaan']->fisik, true);
                $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $reg->id)->first();
                $data['askep'] = $askep;
                $data['resume'] = $resume;
                $data['eresep'] = $eresep;
                $data['obats'] = $obats;
                $data['labs'] = $labs;
                $data['rads'] = $rads;
                $data['folio'] = $folio;
                $data['tgl'] = $tgl;

                // INAP PERAWAT
                if (in_array($soap->type, asesmen_ranap_perawat())) {
                    Flashy::info('Pratinjau belum tersedia');
                    return redirect()->back();
                }

                // INAP DOKTER
                if ($soap->type == "asesmen-awal-medis-neonatus") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_neonatus', $data);
                } elseif ($soap->type == "asesmen-awal-medis-obgyn") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_obgyn', $data);
                } elseif ($soap->type == "asesmen-awal-medis-anak") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_anak', $data);
                } elseif ($soap->type == "asesmen-awal-medis-onkologi") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_onkologi', $data);
                } elseif ($soap->type == "asesmen-awal-medis-gizi") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_gizi', $data);
                } elseif ($soap->type == "asesmen-awal-medis-rehab-medik") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_rehab_medik', $data);
                } elseif ($soap->type == "asesmen-awal-medis-bedah-mulut") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_bedah_mulut', $data);
                } elseif ($soap->type == "asesmen-awal-medis-mata") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_mata', $data);
                } elseif ($soap->type == "asesmen-awal-medis-neurologi") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_neurologi', $data);
                } elseif ($soap->type == "asesmen-awal-medis-gigi") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_gigi', $data);
                } elseif ($soap->type == "asesmen-awal-medis-bedah") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_bedah', $data);
                } elseif ($soap->type == "asesmen-awal-medis-kulit") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_kulit', $data);
                } elseif ($soap->type == "asesmen-awal-medis-psikiatri") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_psikiatri', $data);
                } elseif ($soap->type == "asesmen-awal-medis-paru") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_paru', $data);
                } elseif ($soap->type == "asesmen-awal-medis-dalam") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_dalam', $data);
                } elseif ($soap->type == "asesmen-awal-medis-tht") {
                    $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_tht', $data);
                }
                // IGD
                elseif ($soap->type == "assesment-awal-medis-igd") { // Dokter
                    $pdf = PDF::loadView('resume.igd.cetak_pdf_asessment_awal_medis_igd', $data);
                } elseif ($soap->type == "assesment-awal-perawat-igd") { // Perawat
                    $pdf = PDF::loadView('resume.igd.cetak_pdf_asessment_awal_perawat_igd', $data);
                } elseif ($soap->type == "assesment-awal-medis-igd-ponek") { // Ponek
                    $pdf = PDF::loadView('resume.igd.cetak_pdf_asessment_awal_igd_ponek', $data);
                } else {
                    $pdf = PDF::loadView('resume.igd.cetak_pdf_eresume', $data);
                }
            }
        } else {
            $unit = $soap->unit;
            $pdf = PDF::loadView('resume.cetak_pdf_eresume_rajal_cppt', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'source', 'eresep', 'askep', 'unit'));
        }

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('resume-laporan.pdf');
    }
    public function cetakPDFTreadmill($id)
    {
        $data['emr'] = EmrInapPerencanaan::where('id', $id)->first();
        $data['assesment'] = json_decode(@$data['emr']->keterangan, true);
        $data['reg'] = Registrasi::where('id', $data['emr']->registrasi_id)->first();
        $pdf = PDF::loadView('resume.cetak_pdf_eresume_treadmill', $data);


        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('resume-pdf_treadmill.pdf');
    }

    public function ttePDFTreadmill(Request $request)
    {
        $id = $request->treadmill_id;
        $data['emr'] = EmrInapPerencanaan::where('id', $id)->first();
        $data['assesment'] = json_decode(@$data['emr']->keterangan, true);
        $data['reg'] = Registrasi::where('id', $data['emr']->registrasi_id)->first();
        if (tte()) {
            $data['cetak_tte'] = true;
            $pdf = PDF::loadView('resume.cetak_pdf_eresume_treadmill', $data);
            $pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-resume-treadmill.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($data['reg']->id, $tte->response, "resume-treadmill", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $data['emr']->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $data['emr']->save();
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
            $data['tte_nonaktif'] = true;
            $pdf = PDF::loadView('resume.cetak_pdf_eresume_treadmill', $data);
            $pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();
            $data['emr']->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $data['emr']->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function cetakTTEPDFTreadmill($treadmill_id)
    {
        $treadmill = EmrInapPerencanaan::where('id', $treadmill_id)->first();

        $tte = json_decode($treadmill->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Resume Medis Treadmill-' . $treadmill_id . '.pdf"',
        ]);
    }

    public function ttePDFResumeMedis(Request $request)
    {
        $reg_id = $request->registrasi_id;
        $id = $request->resume_id;
        $source = $request->source;

        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();

        $askep  = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('type', 'asuhan-keperawatan')->orderBy('id', 'DESC')->get();

        if ($source == 'asesmen') {
            $soap   = EmrInapPemeriksaan::find($id);
        } else {
            $soap   = Emr::find($id);
        }
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $eresep = ResepNote::where('registrasi_id', $reg->id)->get();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);
        if (tte()) {
            $cetak_tte = true;
            if ($source == 'asesmen') {
                if (strpos($soap->type, 'fisik') === 0) {
                    $tipe = $request->tipe;
                    $pdf = PDF::loadView('resume.cetak_pdf_eresume_rajal', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'source', 'eresep', 'askep', 'tipe', 'cetak_tte'));
                } else {
                    $data['tipe'] = $request->tipe;
                    $data['reg'] = Registrasi::find($reg_id);
                    $data['pemeriksaan']   = EmrInapPemeriksaan::find($id);
                    $data['soap']   = $data['pemeriksaan'];
                    $data['source']   = $source;
                    $data['asessment']      = @json_decode(@$data['pemeriksaan']->fisik, true);
                    $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $reg->id)->first();
                    $data['cetak_tte'] = $cetak_tte;
                    $data['askep'] = $askep;
                    $data['resume'] = $resume;
                    $data['eresep'] = $eresep;
                    $data['obats'] = $obats;
                    $data['labs'] = $labs;
                    $data['rads'] = $rads;
                    $data['folio'] = $folio;
                    $data['tgl'] = $tgl;

                    // INAP PERAWAT
                    if (in_array($soap->type, asesmen_ranap_perawat())) {
                        Flashy::info('Pratinjau belum tersedia');
                        return redirect()->back();
                    }

                    // INAP DOKTER
                    if ($soap->type == "asesmen-awal-medis-neonatus") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_neonatus', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-obgyn") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_obgyn', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-anak") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_anak', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-onkologi") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_onkologi', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-gizi") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_gizi', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-rehab-medik") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_rehab_medik', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-bedah-mulut") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_bedah_mulut', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-mata") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_mata', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-neurologi") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_neurologi', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-gigi") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_gigi', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-bedah") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_bedah', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-kulit") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_kulit', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-psikiatri") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_psikiatri', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-paru") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_paru', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-dalam") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_dalam', $data);
                    } elseif ($soap->type == "asesmen-awal-medis-tht") {
                        $pdf = PDF::loadView('resume.ranap.cetak_pdf_asessment_awal_medis_tht', $data);
                    }
                    // IGD
                    elseif ($soap->type == "assesment-awal-medis-igd") { // Dokter
                        $pdf = PDF::loadView('resume.igd.cetak_pdf_asessment_awal_medis_igd', $data);
                    } elseif ($soap->type == "assesment-awal-perawat-igd") { // Perawat
                        $pdf = PDF::loadView('resume.igd.cetak_pdf_asessment_awal_perawat_igd', $data);
                    } elseif ($soap->type == "assesment-awal-medis-igd-ponek") { // Ponek
                        $pdf = PDF::loadView('resume.igd.cetak_pdf_asessment_awal_igd_ponek', $data);
                    } else {
                        $pdf = PDF::loadView('resume.igd.cetak_pdf_eresume', $data);
                    }
                }
            } else {
                $unit = $soap->unit;
                $pdf = PDF::loadView('resume.cetak_pdf_eresume_rajal_cppt', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'source', 'eresep', 'cetak_tte', 'askep', 'unit'));
            }

            $pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-eresume-medis.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($reg->id, $tte->response, "eresume-medis", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $soap->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $soap->save();
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

            if ($source == 'asesmen') {
                if (substr($soap->registrasi->status_reg, 0, 1) == 'J') {
                    $tipe = $request->tipe;
                    $pdf = PDF::loadView('resume.cetak_pdf_eresume_rajal', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'source', 'eresep', 'askep', 'tipe', 'tte_nonaktif'));
                } elseif (substr($soap->registrasi->status_reg, 0, 1) == 'G') {
                    $data['reg'] = Registrasi::find($reg_id);
                    $data['pemeriksaan']   = EmrInapPemeriksaan::find($id);
                    $data['asessment']      = @json_decode(@$data['pemeriksaan']->fisik, true);
                    $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $reg->id)->first();
                    $data['tte_nonaktif'] = $tte_nonaktif;

                    $pdf = PDF::loadView('resume.igd.cetak_pdf_asessment_igd', $data);
                } else {
                    $pdf = PDF::loadView('resume.igd.cetak_pdf_eresume', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'source', 'eresep', 'askep', 'tte_nonaktif'));
                }
            } else {
                if (substr($soap->registrasi->status_reg, 0, 1) == 'J') {
                    $unit = 'jalan';
                } elseif (substr($soap->registrasi->status_reg, 0, 1) == 'G') {
                    $unit = 'igd';
                } else {
                    $unit = 'inap';
                }
                $pdf = PDF::loadView('resume.cetak_pdf_eresume_rajal_cppt', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'source', 'eresep', 'tte_nonaktif', 'askep', 'unit'));
            }


            $pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();
            $soap->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $soap->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function cetakTTEPDFResumeMedis(Request $request, $id)
    {
        $source = $request->source;
        if ($source == 'asesmen') {
            $soap   = EmrInapPemeriksaan::find($id);
        } else {
            $soap   = Emr::find($id);
        }

        $tte = json_decode($soap->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Resume Medis-' . $source . '-' . $id . '.pdf"',
        ]);
    }

    public function cetakPDFEresumeTTE(Request $request, $reg_id, $id)
    {
        $source = $request->source;
        if ($source == 'asesmen') {
            $soap   = EmrInapPemeriksaan::find($id);
        } else {
            $soap   = Emr::find($id);
        }

        $tte = json_decode($soap->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function tteResume(Request $request, $id)
    {
        $source = $request->source;
        if ($source == 'asesmen') {
            $soap   = EmrInapPemeriksaan::find($id);
        } else {
            $soap   = Emr::find($id);
        }

        // $dokter = Pegawai::where('user_id', Auth::user()->id)->first();
        $dokter = Auth::user()->pegawai;

        return response()->json((object) [
            'dokter' => $dokter,
            'tte' => $soap->tte == null ? 'belum' : 'sudah',
        ]);
    }

    public function cetakPDFLayananRehab($reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $soap   = EmrInapPemeriksaan::find($id);
        $ttd = TandaTangan::where('registrasi_id', $reg_id)
                  ->where('jenis_dokumen', 'layanan-rehab')
                  ->first();
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);
        $icd9s = PerawatanIcd9::join('icd9s', 'perawatan_icd9s.icd9', '=', 'icd9s.nomor')->where('perawatan_icd9s.registrasi_id', $reg->id)->select('icd9s.nama')->get();
        $icd10s = PerawatanIcd10::join('icd10s', 'perawatan_icd10s.icd10', '=', 'icd10s.nomor')->where('perawatan_icd10s.registrasi_id', $reg->id)->select('icd10s.nama')->get();
        $pdf = PDF::loadView('resume.cetak_pdf_layanan_rehab', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'icd9s', 'icd10s', 'ttd'));
        $pdf->setPaper('A4');
        return $pdf->stream('layanan-rehab.pdf');
    }

    public function ttePDFLayananRehab(Request $request)
    {
        $reg_id = $request->registrasi_id;
        $id = $request->layanan_id;
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $soap   = EmrInapPemeriksaan::find($id);
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);
        $icd9s = PerawatanIcd9::join('icd9s', 'perawatan_icd9s.icd9', '=', 'icd9s.nomor')->where('perawatan_icd9s.registrasi_id', $reg->id)->select('icd9s.nama')->get();
        $icd10s = PerawatanIcd10::join('icd10s', 'perawatan_icd10s.icd10', '=', 'icd10s.nomor')->where('perawatan_icd10s.registrasi_id', $reg->id)->select('icd10s.nama')->get();
        if (tte()) {
            $proses_tte = true;
            $pdf = PDF::loadView('resume.cetak_pdf_layanan_rehab', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'icd9s', 'icd10s', 'proses_tte'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-layanan-rehab.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($reg->id, $tte->response, "layanan-rehab", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $soap->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $soap->update();
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
            $pdf = PDF::loadView('resume.cetak_pdf_layanan_rehab', compact('reg', 'resume', 'soap', 'tgl', 'folio', 'rads', 'labs', 'obats', 'icd9s', 'icd10s', 'tte_nonaktif'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            $soap->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $soap->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function cetakAllPDFLayananRehab($reg_id, $pasien_id)
    {
        $reg = Registrasi::with('pasien')->findOrFail($reg_id);
        $layananRehab = EmrInapPemeriksaan::with('registrasi')
        ->where('pasien_id', $pasien_id)
        ->where('type', 'layanan_rehab')
        ->whereYear('created_at', Carbon::parse($reg->created_at)->year)
        ->whereMonth('created_at', Carbon::parse($reg->created_at)->month)
        ->get();

        if (count($layananRehab) > 0) {
            $pdf = PDF::loadView('resume.cetak_all_pdf_layanan_rehab', compact('layananRehab'));
            $pdf->setPaper('A4');
            return $pdf->stream('layanan-rehab.pdf');
        }


        Flashy::error("Tidak ada Layanan Rehab");
        return redirect()->back();
    }

    public function cetakTTEPDFLayananRehab($reg_id, $id)
    {
        $soap   = EmrInapPemeriksaan::find($id);
        $tte = json_decode($soap->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Layanan Rehab Medis-' . $reg_id . '-' . $id . '.pdf"',
        ]);
    }

    public function ttePDFProgramTerapi(Request $request)
    {
        $reg_id = $request->registrasi_id;
        $id = $request->id;
        $reg    = Registrasi::find($reg_id);
        $soap   = EmrInapPemeriksaan::find($id);
        $cppt = Emr::where('registrasi_id', $reg_id)
            ->whereNotNull('assesment')
            ->first();
        $dokter = Pegawai::find($reg->dokter_id);
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $ttd = TandaTangan::where('registrasi_id', $reg_id)
                  ->where('jenis_dokumen', 'program-terapi')
                  ->first();
        $ttd_dokter = $dokter->tanda_tangan;
        if (tte()) {
            $proses_tte = true;
            $pdf = PDF::loadView('resume.cetak_pdf_program_terapi', compact('reg', 'soap', 'cppt', 'dokter', 'ttd', 'ttd_dokter', 'tgl', 'proses_tte'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-program-terapi.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($reg->id, $tte->response, "program-terapi", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $soap->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $soap->update();
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
            $pdf = PDF::loadView('resume.cetak_pdf_program_terapi', compact('reg', 'soap', 'cppt', 'dokter', 'ttd', 'ttd_dokter', 'tgl', 'tte_nonaktif'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            $soap->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $soap->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function cetakAllPDFProgramTerapi($reg_id, $pasien_id)
    {
        $reg = Registrasi::with('pasien')->findOrFail($reg_id);
        $dokter = Pegawai::find($reg->dokter_id);
        $ttd_dokter = $dokter->tanda_tangan;
        $programTerapi = EmrInapPemeriksaan::with('registrasi')
            ->where('pasien_id', $pasien_id)
            ->where('type', 'program_terapi_rehab')
            ->whereYear('created_at', Carbon::parse($reg->created_at)->year)
            ->whereMonth('created_at', Carbon::parse($reg->created_at)->month)
            ->get();

        if ($programTerapi->isNotEmpty()) {
            $pdf = PDF::loadView('resume.cetak_all_pdf_program_terapi', compact('programTerapi', 'ttd_dokter', 'reg'));
            $pdf->setPaper('A4');
            return $pdf->stream('program-terapi.pdf');
        }

        Flashy::error("Tidak ada Program Terapi");
        return redirect()->back();
    }

    public function cetakTTEPDFProgramTerapi($reg_id, $id)
    {
        $programTerapi = EmrInapPemeriksaan::where('id', $id)->first();

        $tte = json_decode($programTerapi->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Program Terapi -' . $id . '.pdf"',
        ]);
    }

    public function cetakPDFProgramTerapi($reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $cppt = Emr::where('registrasi_id', $reg_id)
            ->whereNotNull('assesment')
            ->first();
        $soap   = EmrInapPemeriksaan::find($id);
        $dokter = Pegawai::find($reg->dokter_id);
        $ttd = TandaTangan::where('registrasi_id', $reg_id)
                  ->where('jenis_dokumen', 'program-terapi')
                  ->first();
        $ttd_dokter = $dokter->tanda_tangan;
        // $folio = Folio::where('registrasi_id', $reg->id)
        //     ->whereIn('poli_tipe', ['J', 'G', 'I'])
        //     ->get();
        // $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        // $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        // $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
        //     ->where('penjualandetails.jumlah', '!=', '0')
        //     ->where('penjualans.registrasi_id', $reg->id)
        //     ->select('penjualandetails.*')
        //     ->get();
        $tgl = date('d-m-Y', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);
        // $pdf = PDF::loadView('resume.cetak_pdf_layanan_rehab', compact('reg','resume','soap','tgl','folio','rads','labs','obats'));
        // $pdf->setPaper('A4', 'portrait');
        // return $pdf->stream('layanan-rehab.pdf');
        return view('resume.cetak_pdf_program_terapi', compact('reg', 'resume', 'soap', 'cppt', 'tgl', 'dokter', 'ttd', 'ttd_dokter'));
    }

    public function ttePDFUjiFungsi(Request $request)
    {
        $reg_id = $request->registrasi_id;
        $id = $request->id;
        $reg    = Registrasi::find($reg_id);
        $soap   = EmrInapPemeriksaan::find($id);
        $cppt   = Emr::where('registrasi_id', $reg_id)
                ->whereNotNull('assesment')
                ->first();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        if (tte()) {
            $proses_tte = true;
            $pdf = PDF::loadView('resume.cetak_pdf_uji_fungsi', compact('reg', 'soap', 'cppt', 'tgl', 'proses_tte'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-layanan-rehab.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($reg->id, $tte->response, "layanan-rehab", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $soap->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $soap->update();
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
            $pdf = PDF::loadView('resume.cetak_pdf_uji_fungsi', compact('reg', 'soap', 'cppt', 'tgl', 'tte_nonaktif'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            $soap->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $soap->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function cetakTTEPDFUjiFungsi($reg_id, $id)
    {
        $uji_fungsi = EmrInapPemeriksaan::where('id', $id)->first();

        $tte = json_decode($uji_fungsi->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Uji Fungsi - ' . $id . '.pdf"',
        ]);
    }

    public function cetakAllPDFUjiFungsi($reg_id, $pasien_id)
    {
        $reg = Registrasi::with('pasien')->findOrFail($reg_id);
        $dokter = Pegawai::find($reg->dokter_id);
        $ttd_dokter = $dokter->tanda_tangan;
        $ujiFungsi = EmrInapPemeriksaan::with('registrasi')
            ->where('pasien_id', $pasien_id)
            ->where('type', 'uji_fungsi_rehab')
            ->whereYear('created_at', Carbon::parse($reg->created_at)->year)
            ->whereMonth('created_at', Carbon::parse($reg->created_at)->month)
            ->get();

        if ($ujiFungsi->isNotEmpty()) {
            $pdf = PDF::loadView('resume.cetak_all_pdf_uji_fungsi', compact('ujiFungsi', 'ttd_dokter', 'reg'));
            $pdf->setPaper('A4');
            return $pdf->stream('uji-fungsi.pdf');
        }

        Flashy::error("Tidak ada Uji Fungsi");
        return redirect()->back();
    }

    public function cetakPDFUjiFungsi($reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $soap   = EmrInapPemeriksaan::find($id);
        $cppt   = Emr::where('registrasi_id', $reg_id)
                ->whereNotNull('assesment')
                ->first();
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);
        // $pdf = PDF::loadView('resume.cetak_pdf_layanan_rehab', compact('reg','resume','soap','tgl','folio','rads','labs','obats'));
        // $pdf->setPaper('A4', 'portrait');
        // return $pdf->stream('layanan-rehab.pdf');
        return view('resume.cetak_pdf_uji_fungsi', compact('reg', 'resume', 'soap', 'cppt', 'tgl', 'folio', 'rads', 'labs', 'obats'));
    }

    public function ttePDFRehabBaru(Request $request)
    {
        $reg_id = $request->registrasi_id;
        $id = $request->id;
        $reg    = Registrasi::find($reg_id);
        $soap   = EmrInapPemeriksaan::find($id);
        $cppt   = Emr::where('registrasi_id', $reg_id)->get()
                ->whereNotNull('assesment')
                ->first();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        if (tte()) {
            $proses_tte = true;
            $pdf = PDF::loadView('resume.cetak_pdf_rehab_baru', compact('reg', 'soap', 'cppt', 'tgl', 'proses_tte'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-Rehab-Baru.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($reg->id, $tte->response, "rehab-baru", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $soap->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $soap->update();
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
            $pdf = PDF::loadView('resume.cetak_pdf_rehab_baru', compact('reg', 'soap', 'cppt', 'tgl', 'tte_nonaktif'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            $soap->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $soap->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function cetakTTEPDFRehabBaru($reg_id, $id)
    {
        $rehab_baru = EmrInapPemeriksaan::where('id', $id)->first();

        $tte = json_decode($rehab_baru->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Rehab Baru - ' . $id . '.pdf"',
        ]);
    }

    public function cetakAllPDFRehabBaru($reg_id, $pasien_id)
    {
        $reg = Registrasi::with('pasien')->findOrFail($reg_id);
        $dokter = Pegawai::find($reg->dokter_id);
        $ttd_dokter = $dokter->tanda_tangan;
        $rehabBaru = EmrInapPemeriksaan::with('registrasi')
            ->where('pasien_id', $pasien_id)
            ->where('type', 'rehab_baru')
            ->whereYear('created_at', Carbon::parse($reg->created_at)->year)
            ->whereMonth('created_at', Carbon::parse($reg->created_at)->month)
            ->get();

        if ($rehabBaru->isNotEmpty()) {
            $pdf = PDF::loadView('resume.cetak_all_pdf_rehab_baru', compact('rehabBaru', 'ttd_dokter', 'reg'));
            $pdf->setPaper('A4');
            return $pdf->stream('rehab-baru.pdf');
        }

        Flashy::error("Tidak ada Rehab Baru");
        return redirect()->back();
    }

    public function cetakPDFRehabBaru($reg_id, $id)
    {
        $reg    = Registrasi::find($reg_id);
        $resume = ResumePasien::where('registrasi_id', $reg_id)->get();
        $spri   = RencanaKontrol::where('registrasi_id', $reg->id)->orderBy('id', 'DESC')->first();
        $soap   = EmrInapPemeriksaan::find($id);
        $cppt   = Emr::where('registrasi_id', $reg_id)
                ->whereNotNull('assesment')
                ->first();
        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $tgl = date('Y-m-d', strtotime($reg->created_at));
        $data = poli::find($reg->poli_id);
        // $pdf = PDF::loadView('resume.cetak_pdf_layanan_rehab', compact('reg','resume','soap','tgl','folio','rads','labs','obats'));
        // $pdf->setPaper('A4', 'portrait');
        // return $pdf->stream('layanan-rehab.pdf');
        return view('resume.cetak_pdf_rehab_baru', compact('reg', 'resume', 'soap', 'cppt', 'tgl', 'folio', 'rads', 'labs', 'obats'));
    }

    public function cetakPDFResumeRegistrasi($reg_id)
    {
        $reg    = Registrasi::find($reg_id);
        $dokter = Pegawai::find($reg->dokter_id);
        $poliBpjs = baca_poli_bpjs($reg->poli_id);

        $resume = EmrResume::where('registrasi_id', $reg->id)->first();
        // Asesmen Hemodialisa & Gigi sudah dipisah antara perawat & dokter
        if ($poliBpjs == "HDL" || $poliBpjs == "GIG") {
            $soap   = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('user_id', $dokter->user_id)->first();
        } else {
            $soap   = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('userdokter_id', $dokter->user_id)->first();

            if (!$soap) {
                $soap   = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->first();
            }
        }

        // Poli Hemodialisa mengambil asesmen perawat untuk tanggal keluar
        if ($poliBpjs == 'HDL') {
            $soap_perawat = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('user_id', '!=', $dokter->user_id)->first();
        } else {
            $soap_perawat = null;
        }

        $triage = [];
        if($reg->poli->politype == 'G'){
            $triageIgd = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('type', 'triage-igd')->orderBy('id', 'DESC')->first();
            if($triageIgd && $triageIgd->fisik){
                $triage = json_decode($triageIgd->fisik, true);
            }
        }
        //Update baru - mengatasi user dokter yg mengisi cppt selain dpjp
        // $poli = Poli::find($reg->poli_id, ['dokter_id']);
        // $dokterPoli = preg_split("/\,/", $poli->dokter_id);
		// $userDokterPoli = Pegawai::whereIn('id', $dokterPoli)->pluck('user_id');
        $userDokterPoli = Pegawai::where('kategori_pegawai', 1)->pluck('user_id');
        $cppt = Emr::where('registrasi_id', $reg->id)->whereIn('user_id', $userDokterPoli)->where('unit', '!=', 'sbar')->orderBy('id', 'desc')->first();
        $cpptPerawat = Emr::where('registrasi_id', $reg->id)->whereNotIn('user_id', $userDokterPoli)->orderBy('id', 'desc')->first();

        // $cppt = Emr::where('registrasi_id', $reg->id)->where('user_id', $dokter->user_id)->first();
        // $cpptPerawat = Emr::where('registrasi_id', $reg->id)->where('user_id', '!=', $dokter->user_id)->first();
        $icd10Primary = PerawatanIcd10::where('registrasi_id', $reg->id)->where('kategori', 'Primary')->get();
        $icd10Secondary = PerawatanIcd10::where('registrasi_id', $reg->id)->whereNull('kategori')->get();

        $icd10Primary_jkn = JknIcd10::where('registrasi_id', $reg->id)->where('kategori', 'Primary')->get();
        $icd10Secondary_jkn = JknIcd10::where('registrasi_id', $reg->id)->whereNull('kategori')->get();

        $icd9 = PerawatanIcd9::where('registrasi_id', $reg->id)->get();
        $icd9_jkn = JknIcd9::where('registrasi_id', $reg->id)->get();


        $emrPemeriksaan   = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'fisik_mata')->first();
        @$soaps = json_decode($emrPemeriksaan->fisik, true);
        $gambar1 = EmrInapPenilaian::where('registrasi_id', $reg_id)->where('type', 'mata1')->first();
        $gambar2 = EmrInapPenilaian::where('registrasi_id', $reg_id)->where('type', 'mata2')->first();
        $gambar3 = EmrInapPenilaian::where('registrasi_id', $reg_id)->where('type', 'mata3')->first();

        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $tgl = date('Y-m-d', strtotime($reg->created_at));

        $pdf = PDF::loadView('resume.cetak_pdf_resume_registrasi', compact('reg', 'dokter', 'soap', 'soap_perawat', 'triage', 'cppt', 'tgl', 'folio', 'rads', 'labs', 'obats', 'resume', 'icd10Primary', 'icd10Primary_jkn', 'icd10Secondary', 'icd10Secondary_jkn', 'icd9', 'icd9_jkn', 'cpptPerawat', 'soaps', 'gambar1', 'gambar2', 'gambar3'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Resume Pasien Per Registrasi.pdf');
        // return view('resume.cetak_pdf_resume_registrasi', compact('reg','resume','soap','tgl','folio','rads','labs','obats'));
    }

    public function ttePDFResumeRegistrasi(Request $request)
    {
        $reg_id = $request->registrasi_id;
        $nik = $request->nik;
        $passphrase = $request->passphrase;

        $reg    = Registrasi::find($reg_id);
        $dokter = Pegawai::find($reg->dokter_id);
        $poliBpjs = baca_poli_bpjs($reg->poli_id);

        // Asesmen Hemodialisa & Gigi sudah dipisah antara perawat & dokter
        if ($poliBpjs == "HDL" || $poliBpjs == "GIG") {
            $soap   = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('user_id', $dokter->user_id)->first();
        } else {
            $soap   = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('userdokter_id', $dokter->user_id)->first();

            if (!$soap) {
                $soap   = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->first();
            }
        }

        // Poli Hemodialisa mengambil asesmen perawat untuk tanggal keluar
        if ($poliBpjs == 'HDL') {
            $soap_perawat = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('user_id', '!=', $dokter->user_id)->first();
        } else {
            $soap_perawat = null;
        }

        $triage = [];
        if($reg->poli->politype == 'G'){
            $triageIgd = EmrInapPemeriksaan::where('registrasi_id', $reg->id)->where('type', 'triage-igd')->orderBy('id', 'DESC')->first();
            if($triageIgd && $triageIgd->fisik){
                $triage = json_decode($triageIgd->fisik, true);
            }
        }
        //Update baru - mengatasi user dokter yg mengisi cppt selain dpjp
        $poli = Poli::find($reg->poli_id, ['dokter_id']);
        $dokterPoli = preg_split("/\,/", $poli->dokter_id);
		$userDokterPoli = Pegawai::whereIn('id', $dokterPoli)->pluck('user_id');
        $cppt = Emr::where('registrasi_id', $reg->id)->whereIn('user_id', $userDokterPoli)->first();
        $cpptPerawat = Emr::where('registrasi_id', $reg->id)->whereNotIn('user_id', $userDokterPoli)->first();

        // $cppt = Emr::where('registrasi_id', $reg->id)->where('user_id', $dokter->user_id)->first();
        // $cpptPerawat = Emr::where('registrasi_id', $reg->id)->where('user_id', '!=', $dokter->user_id)->first();
        $icd10Primary = PerawatanIcd10::where('registrasi_id', $reg->id)->where('kategori', 'Primary')->get();
        $icd10Secondary = PerawatanIcd10::where('registrasi_id', $reg->id)->whereNull('kategori')->get();

        $icd10Primary_jkn = JknIcd10::where('registrasi_id', $reg->id)->where('kategori', 'Primary')->get();
        $icd10Secondary_jkn = JknIcd10::where('registrasi_id', $reg->id)->whereNull('kategori')->get();

        $icd9 = PerawatanIcd9::where('registrasi_id', $reg->id)->get();
        $icd9_jkn = JknIcd9::where('registrasi_id', $reg->id)->get();

        $folio = Folio::where('registrasi_id', $reg->id)
            ->whereIn('poli_tipe', ['J', 'G', 'I'])
            ->get();
        $rads = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'R')->get();
        $labs = Folio::where('registrasi_id', $reg->id)->where('poli_tipe', 'L')->get();
        $obats = Penjualan::join('penjualandetails', 'penjualans.id', '=', 'penjualandetails.penjualan_id')
            ->where('penjualandetails.jumlah', '!=', '0')
            ->where('penjualans.registrasi_id', $reg->id)
            ->select('penjualandetails.*')
            ->get();
        $tgl = date('Y-m-d', strtotime($reg->created_at));

        $emrPemeriksaan   = EmrInapPemeriksaan::where('registrasi_id', $reg_id)->where('type', 'fisik_mata')->first();
        $resume = EmrResume::where('registrasi_id', $reg->id)->first();
        @$soaps = json_decode($emrPemeriksaan->fisik, true);
        $gambar1 = EmrInapPenilaian::where('registrasi_id', $reg_id)->where('type', 'mata1')->first();
        $gambar2 = EmrInapPenilaian::where('registrasi_id', $reg_id)->where('type', 'mata2')->first();
        $gambar3 = EmrInapPenilaian::where('registrasi_id', $reg_id)->where('type', 'mata3')->first();

        if (tte()) {
            $proses_tte = true;
            $pdf = PDF::loadView('resume.cetak_pdf_resume_registrasi', compact('reg', 'dokter', 'soap', 'soap_perawat', 'triage', 'cppt', 'tgl', 'folio', 'rads', 'labs', 'obats', 'icd10Primary', 'icd10Primary_jkn', 'icd10Secondary', 'icd10Secondary_jkn', 'icd9', 'icd9_jkn', 'cpptPerawat', 'resume', 'soaps', 'gambar1', 'gambar2', 'gambar3', 'proses_tte'));
            $pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-eresume-pasien.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
            log_esign($reg->id, $tte->response, "eresume-pasien", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $reg->tte_resume_pasien = convertTTE("tte_resume_pasien", @json_decode($tte->response)->base64_signed_file);
                $reg->tte_resume_pasien_status = '1';
                $reg->update();
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
            $pdf = PDF::loadView('resume.cetak_pdf_resume_registrasi', compact('reg', 'dokter', 'soap', 'soap_perawat' ,'triage', 'cppt', 'tgl', 'folio', 'rads', 'labs', 'obats', 'icd10Primary', 'icd10Secondary', 'icd9', 'cpptPerawat', 'resume', 'soaps', 'gambar1', 'gambar2', 'gambar3', 'tte_nonaktif'));
            $pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();

            $reg->tte_resume_pasien = convertTTE("tte_resume_pasien", base64_encode($pdfContent));

            $reg->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();
    }


    public function cetakTTEPDFResumeRegistrasi($reg_id)
    {
        $reg    = Registrasi::find($reg_id);
        $tte    = json_decode($reg->tte_resume_pasien);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Resume Pasien-' . $reg_id . '.pdf"',
        ]);
    }

    public function cetakPDFResumeRanap(Request $request, $resume_id)
    {
        $resume = EmrInapPerencanaan::find($resume_id);
        $icd9   = JknIcd9::where('registrasi_id', $resume->registrasi_id)->get();
        $icd10Primary_jkn = JknIcd10::where('registrasi_id', $resume->registrasi_id)
            ->where('kategori', 'Primary')
            ->first();
        $icd10Secondary_jkn = JknIcd10::where('registrasi_id', $resume->registrasi_id)
            ->whereNull('kategori')
            ->get();

        if ($resume) {
            if (!empty($resume->is_draft)) {
                Flashy::error('Resume belum di buka secara publik');
                return redirect()->back();
            }
            $registrasi    = Registrasi::find($resume->registrasi_id);
            $content = json_decode($resume->keterangan, true);
            $versi = $request->query('versi');

            if ($versi == '2') {
                $pdf = PDF::loadView('resume.cetak_pdf_resume_ranap_baru', compact('registrasi', 'resume', 'icd9', 'content', 'icd10Primary_jkn', 'icd10Secondary_jkn'));
            } else {
                $pdf = PDF::loadView('resume.cetak_pdf_resume_ranap', compact('registrasi', 'resume', 'icd9', 'content', 'icd10Primary_jkn', 'icd10Secondary_jkn'));
            }
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream();
        }

        Flashy::error('Resume tidak ditemukan');
        return redirect()->back();
    }

    public function ttePDFResumeRanap(Request $request)
    {
        $nik = $request->nik;
        $passphrase = $request->passphrase;

        $resume = EmrInapPerencanaan::find($request->resume_id);
        if ($resume) {
            $registrasi    = Registrasi::find($resume->registrasi_id);
            $content = json_decode($resume->keterangan, true);
            $icd9   = JknIcd9::where('registrasi_id', $resume->registrasi_id)->get();
            
            if (tte()) { 
                $proses_tte = true;
                $pdf = PDF::loadView('resume.cetak_pdf_resume_ranap', compact('registrasi', 'resume', 'content', 'icd9', 'proses_tte'));
                $pdf->setPaper('A4', 'portrait');
                $pdfContent = $pdf->output();

                // Create temp pdf file
                $filePath = uniqId() . '-resume-ranap.pdf';
                File::put(public_path($filePath), $pdfContent);

                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);

                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
                log_esign($registrasi->id, $tte->response, "eresume-ranap", $tte->httpStatusCode);

                $resp = json_decode($tte->response);

                if ($tte->httpStatusCode == 200) {
                    $resume->tte = convertTTE("tte_resume_pasien", @json_decode($tte->response)->base64_signed_file);
                    $resume->update();
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
                $pdf = PDF::loadView('resume.cetak_pdf_resume_ranap', compact('registrasi', 'resume', 'content', 'icd9', 'tte_nonaktif'));
                $pdf->setPaper('A4', 'portrait');
                $pdfContent = $pdf->output();

                $resume->tte = convertTTE("tte_resume_pasien", base64_encode($pdfContent));

                $resume->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }

        Flashy::error('Resume tidak ditemukan');
        return redirect()->back();
    }

    public function cetakTTEPDFResumeRanap($resume_id)
    {
        $resume    = EmrInapPerencanaan::find($resume_id);
        $tte    = json_decode($resume->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Resume Pasien-' . $resume_id . '.pdf"',
        ]);
    }

    public function cetakPDFResumeIGD($resume_id)
    {
        $resume = EmrResume::find($resume_id);
        $icd10Primary_jkn = JknIcd10::where('registrasi_id', $resume->registrasi_id)
            ->where('kategori', 'Primary')
            ->first();
        $icd10Secondary_jkn = JknIcd10::where('registrasi_id', $resume->registrasi_id)
            ->whereNull('kategori')
            ->get();
            
        if ($resume) {
            $registrasi    = Registrasi::find($resume->registrasi_id);
            $dokter = Pegawai::find($registrasi->dokter_id);
            $content = json_decode($resume->content, true);

            $pdf = PDF::loadView('resume.cetak_pdf_resume_igd', compact('registrasi', 'resume', 'content', 'dokter', 'icd10Primary_jkn', 'icd10Secondary_jkn'));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream();
        }

        Flashy::error('Resume tidak ditemukan');
        return redirect()->back();
    }

    public function ttePDFResumeIGD(Request $request)
    {
        $nik = $request->nik;
        $passphrase = $request->passphrase;

        $resume = EmrResume::find($request->resume_id);
        if ($resume) {
            $registrasi    = Registrasi::find($resume->registrasi_id);
            $dokter = Pegawai::find($registrasi->dokter_id);
            $content = json_decode($resume->content, true);

            if (tte()) { 
                $proses_tte = true;
                $pdf = PDF::loadView('resume.cetak_pdf_resume_igd', compact('registrasi', 'resume', 'content', 'dokter' , 'proses_tte'));
                $pdf->setPaper('A4', 'portrait');
                $pdfContent = $pdf->output();

                // Create temp pdf file
                $filePath = uniqId() . '-resume-igd.pdf';
                File::put(public_path($filePath), $pdfContent);

                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);

                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
                log_esign($registrasi->id, $tte->response, "eresume-igd", $tte->httpStatusCode);

                $resp = json_decode($tte->response);

                if ($tte->httpStatusCode == 200) {
                    $resume->tte = convertTTE("tte_resume_pasien", @json_decode($tte->response)->base64_signed_file);
                    $resume->update();
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
                $pdf = PDF::loadView('resume.cetak_pdf_resume_igd', compact('registrasi', 'resume', 'content', 'dokter', 'tte_nonaktif'));
                $pdf->setPaper('A4', 'portrait');
                $pdfContent = $pdf->output();

                $resume->tte = convertTTE("tte_resume_pasien", base64_encode($pdfContent));

                $resume->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }

        Flashy::error('Resume tidak ditemukan');
        return redirect()->back();
    }

    public function cetakPDFAskep($regId, $askepId)
    {
        $reg = Registrasi::find($regId);
        $askep = EmrInapPemeriksaan::find($askepId);

        $diagnosis = json_decode($askep->diagnosis, true);
        $siki = json_decode($askep->pemeriksaandalam, true);
        $implementasi = json_decode($askep->fungsional, true);
        $jam_tindakan  = json_decode(@$askep->fisik, true) ?? @$askep->fisik;
        $keterangan  = json_decode(@$askep->keterangan, true) ?? @$askep->keterangan;

        $base64 = @json_decode(@$askep->tte)->base64_signed_file;
        if ($base64) {
            $pdfContent = base64_decode($base64);
            return Response::make($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="Cetak_Askep_' . $reg->pasien->nama . '_' . $reg->pasien->no_rm . '.pdf"',
            ]);
        } else {
            $pdf = PDF::loadView('resume.cetak_pdf_askep', compact(
                'reg',
                'askep',
                'diagnosis',
                'siki',
                'implementasi',
                'jam_tindakan',
                'keterangan',
            ));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('Cetak_Askep_' . $reg->pasien->nama . '_' . $reg->pasien->no_rm . '.pdf');
        }
    }

    public function cetakPDFAskeb($regId, $askebId)
    {
        $reg = Registrasi::find($regId);
        $askeb = EmrInapPemeriksaan::find($askebId);

        $diagnosis = json_decode($askeb->diagnosis, true);
        $siki = json_decode($askeb->pemeriksaandalam, true);
        $implementasi = json_decode($askeb->fungsional, true);
        $tindakan = json_decode($askeb->keterangan, true);

        $base64 = @json_decode(@$askeb->tte)->base64_signed_file;
        if ($base64) {
            $pdfContent = base64_decode($base64);
            return Response::make($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="Cetak_Askeb_' . $reg->pasien->nama . '_' . $reg->pasien->no_rm . '.pdf"',
            ]);
        } else {
            $pdf = PDF::loadView('resume.cetak_pdf_askeb', compact(
                'reg',
                'askeb',
                'diagnosis',
                'tindakan',
                'siki',
                'implementasi'
            ));
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('Cetak_Askeb_' . $reg->pasien->nama . '_' . $reg->pasien->no_rm . '.pdf');
        }
    }

    public function cetakAsesmenIGD($registrasi_id, $id)
    {
        $data['reg']     = Registrasi::find($registrasi_id);
        $data['pemeriksaan']   = EmrInapPemeriksaan::find($id);
        $data['asessment']      = @json_decode(@$data['pemeriksaan']->fisik, true);
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();
        // $askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
        // if ($askep) {
        //     $data['diagnosis'] = json_decode($askep->diagnosis, true);
        //     $data['siki'] = json_decode($askep->pemeriksaandalam, true);
        //     $data['implementasi'] = json_decode($askep->fungsional, true);
        // }
        // return view('resume.igd.cetak_pdf_asessment_igd', $data);
        $pdf = PDF::loadView('resume.igd.cetak_pdf_asessment_igd', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($data['reg']->pasien->no_rm . '_ASESMEN_IGD.pdf');
    }

    public function cetakAsesmenBidanPonek($registrasi_id, $id)
    {
        $data['reg']     = Registrasi::find($registrasi_id);
        $data['pemeriksaan']   = EmrInapPemeriksaan::find($id);
        $data['asessment']      = @json_decode(@$data['pemeriksaan']->fisik, true);
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();
        $askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->first();
        if ($askep) {
            $data['diagnosis'] = json_decode($askep->diagnosis, true);
            $data['siki'] = json_decode($askep->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($askep->fungsional, true);
        }
        // return view('resume.igd.cetak_pdf_asessment_igd', $data);
        $pdf = PDF::loadView('resume.igd.cetak_pdf_asessment_bidan_ponek', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($data['reg']->pasien->no_rm . '_ASESMEN_PONEK.pdf');
    }

    public function cetakTriageIGD($registrasi_id, $id)
    {
        $data['reg']     = Registrasi::find($registrasi_id);
        $data['pemeriksaan']   = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'triage-igd')->orderBy('id', 'DESC')->first();
        $data['pegawai']    = Pegawai::where('id', $data['reg']->dokter_id)->first();
        $data['asessment']      = @json_decode(@$data['pemeriksaan']->fisik);
        $data['gambar'] = EmrInapPenilaian::where('registrasi_id', $registrasi_id)->first();
        $askep = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'asuhan-keperawatan')->orderBy('id', 'DESC')->first();
        
        $asessment_aswal   = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type','assesment-awal-medis-igd')->orderBy('id', 'DESC')->first();
        $asessment_aswal_ponek   = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type','assesment-awal-medis-igd-ponek')->orderBy('id', 'DESC')->first();
        $data['asessment_awal']  = json_decode(@$asessment_aswal->fisik, true);
        $data['asessment_awal_ponek']  = json_decode(@$asessment_aswal_ponek->fisik, true);


        if ($askep) {
            $data['diagnosis'] = json_decode($askep->diagnosis, true);
            $data['siki'] = json_decode($askep->pemeriksaandalam, true);
            $data['implementasi'] = json_decode($askep->fungsional, true);
        }
        // return view('resume.igd.cetak_pdf_asessment_igd', $data);
        $pdf = PDF::loadView('resume.igd.cetak_pdf_triage_igd', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($data['reg']->pasien->no_rm . '_TRIAGE_IGD.pdf');
    }

    public function cetakEdukasiPasienKeluarga($registrasi_id, $id)
    {
        $data['reg']     = Registrasi::find($registrasi_id);
        $data['pemeriksaan']   = EmrInapPemeriksaan::find($id);
        $data['ttd_pasien'] = TandaTangan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->first();
        $data['asessment']      = @json_decode(@$data['pemeriksaan']->fisik, true);

        $pdf = PDF::loadView('resume.cetak_pdf_edukasi_pasien_keluarga', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($data['reg']->pasien->no_rm . '_Formulir_Edukasi_Pasien_Keluarga.pdf');
    }

    public function cetakFormSurveilansInfeksi($registrasi_id, $id)
    {
        $data['reg']     = Registrasi::find($registrasi_id);
        $data['pemeriksaan']   = EmrInapPemeriksaan::find($id);
        $data['asessment']      = @json_decode(@$data['pemeriksaan']->fisik, true);

        $pdf = PDF::loadView('resume.cetak_pdf_surveilans_infeksi', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($data['reg']->pasien->no_rm . '_Formulir_Surveilans_Infeksi.pdf');
    }

    public function cetakEwsDewasa($registrasi_id, $id)
    {
        // dd('Mohon maaf Halaman ini sedang dalam proses :)');
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['data'] = EmrEws::find($id);
        $data['ews'] = @json_decode(@$data['data']->fisik, true);
        $data['emr']			= EmrEws::find($id);
        $data['ewss'] = json_decode($data['emr']->diagnosis,true);
        // dd($data['emr']);

        $pdf = PDF::loadView('resume.ews.cetak_pdf_dewasa', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($data['reg']->pasien->no_rm . '_EWS_Dewasa.pdf');
    }
    public function cetakEwsAnak($registrasi_id, $id)
    {
        // dd('Mohon maaf Halaman ini sedang dalam proses :)');
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['data'] = EmrEws::find($id);
        $data['ews'] = @json_decode(@$data['data']->fisik, true);
        $data['emr']			= EmrEws::find($id);
        $data['ewss'] = json_decode($data['emr']->diagnosis,true);
        // dd($data['emr']);

        $pdf = PDF::loadView('resume.ews.cetak_pdf_anak', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($data['reg']->pasien->no_rm . '_EWS_Anak.pdf');
    }
    public function cetakEwsMaternitas($registrasi_id, $id)
    {
        // dd('Mohon maaf Halaman ini sedang dalam proses :)');
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['data'] = EmrEws::find($id);
        $data['ews'] = @json_decode(@$data['data']->fisik, true);
        $data['emr']			= EmrEws::find($id);
        $data['ewss'] = json_decode($data['emr']->diagnosis,true);
        // dd($data['emr']);

        $pdf = PDF::loadView('resume.ews.cetak_pdf_maternitas', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($data['reg']->pasien->no_rm . '_EWS_Maternitas.pdf');
    }
    public function cetakEwsNeonatus($registrasi_id, $id)
    {
        // dd('Mohon maaf Halaman ini sedang dalam proses :)');
        $data['reg'] = Registrasi::find($registrasi_id);
        $data['data'] = EmrEws::find($id);
        $data['ews'] = @json_decode(@$data['data']->fisik, true);
        $data['emr']			= EmrEws::find($id);
        $data['ewss'] = json_decode($data['emr']->diagnosis,true);
        // dd($data['emr']);

        $pdf = PDF::loadView('resume.ews.cetak_pdf_neonatus', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($data['reg']->pasien->no_rm . '_EWS_Neonatus.pdf');
    }

    public function ttePDFEWS(Request $request)
    {
        $data['data'] = EmrEws::find($request->ews_id);
        $data['reg'] = Registrasi::find($data['data']->registrasi_id);
        $data['ews'] = @json_decode(@$data['data']->fisik, true);
        $data['emr'] = EmrEws::find($request->ews_id);
        $data['ewss'] = json_decode($data['emr']->diagnosis,true);
        if ($data['data']) {
            
            if (tte()) { 
                $pdf = null;
    
                $data['cetak_tte'] = true;
                // Cek tipe EWS
                switch ($data['data']->type) {
                    case 'ews-dewasa':
                        $pdf = PDF::loadView('resume.ews.cetak_pdf_dewasa', $data);
                      break;
                    case 'ews-anak':
                        $pdf = PDF::loadView('resume.ews.cetak_pdf_anak', $data);
                      break;
                    case 'ews-maternal':
                        $pdf = PDF::loadView('resume.ews.cetak_pdf_maternitas', $data);
                      break;
                    case 'ews-neonatus':
                        $pdf = PDF::loadView('resume.ews.cetak_pdf_neonatus', $data);
                      break;
                    default:
                      $pdf = null;
                  }
                $pdf->setPaper('A4', 'portrait');
                $pdfContent = $pdf->output();

                // Create temp pdf file
                $filePath = uniqId() . '-ews.pdf';
                File::put(public_path($filePath), $pdfContent);

                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);

                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
                log_esign($data['reg']->id, $tte->response, "ews", $tte->httpStatusCode);

                $resp = json_decode($tte->response);

                if ($tte->httpStatusCode == 200) {
                    $data['data']->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                    $data['data']->update();
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
                $data['tte_nonaktif'] = true;
                // Cek tipe EWS
                switch ($data['data']->type) {
                    case 'ews-dewasa':
                        $pdf = PDF::loadView('resume.ews.cetak_pdf_dewasa', $data);
                      break;
                    case 'ews-anak':
                        $pdf = PDF::loadView('resume.ews.cetak_pdf_anak', $data);
                      break;
                    case 'ews-maternal':
                        $pdf = PDF::loadView('resume.ews.cetak_pdf_maternitas', $data);
                      break;
                    case 'ews-neonatus':
                        $pdf = PDF::loadView('resume.ews.cetak_pdf_neonatus', $data);
                      break;
                    default:
                      $pdf = null;
                  }
                $pdf->setPaper('A4', 'portrait');
                $pdfContent = $pdf->output();

                $data['data']->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));

                $data['data']->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }

        Flashy::error('EWS tidak ditemukan');
        return redirect()->back();
    }

    public function convertPDF()
    {
        $data['tga'] = date('d-m-Y');
        $data['tgb'] = date('d-m-Y');
        $data['dokumen'] = '';
        return view('resume.convertPDF', $data);
    }

    public function convertPDF_by(Request $request)
    {
        ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');

        $tga = valid_date($request->tga);
        $tgb = valid_date($request->tgb);
        $data['dokumen']= $request->dokumen;
        $data['tga']    = $tga;
        $data['tgb']    = $tgb;

        switch ($request->dokumen) {
            case "resume":
                $reg = Registrasi::whereNotNull('tte_resume_pasien')->whereBetween('created_at', [$tga.' 00:00:00', $tgb.' 23:59:59'])->get();
                foreach($reg as $r){
                    $base64 = @json_decode(@$r->tte_resume_pasien)->base64_signed_file;
                    if ($base64) {
                        $r->tte_resume_pasien = convertTTE('tte_resume_pasien', $base64);
                        $r->update();
                    }
                }

                Flashy::success('Selesai convert base64 ke PDF RESUME (RAJAL & IGD)');
                break;
            case "resume-inap":
                $resume = EmrInapPerencanaan::where('type', 'resume')->whereNotNull('tte')->whereBetween('created_at', [$tga.' 00:00:00', $tgb.' 23:59:59'])->get();
                foreach($resume as $r){
                    $base64 = @json_decode(@$r->tte)->base64_signed_file;
                    if ($base64) {
                        $r->tte = convertTTE('tte_resume_pasien', $base64);
                        $r->update();
                    }
                }
                Flashy::success('Selesai convert base64 ke PDF RESUME (RAWAT INAP)');
                break;
            case "cppt-sbar":
                $item = Emr::whereNotNull('tte')->whereBetween('created_at', [$tga.' 00:00:00', $tgb.' 23:59:59'])->get();
                foreach($item as $i){
                    $base64 = @json_decode(@$i->tte)->base64_signed_file;
                    if ($base64) {
                        $i->tte = convertTTE('dokumen_tte', $base64);
                        $i->update();
                    }
                }
                Flashy::success('Selesai convert base64 ke PDF CPPT & SBAR');
                break;
            case "form-pemeriksaan":
                $item = EmrInapPemeriksaan::whereNotNull('tte')->whereBetween('created_at', [$tga.' 00:00:00', $tgb.' 23:59:59'])->get();
                foreach($item as $i){
                    $base64 = @json_decode(@$i->tte)->base64_signed_file;
                    if ($base64) {
                        $i->tte = convertTTE('dokumen_tte', $base64);
                        $i->update();
                    }
                }
                Flashy::success('Selesai convert base64 ke PDF');
                break;
            case "ekspertise":
                $item = RadiologiEkspertise::whereNotNull('tte')->whereBetween('created_at', [$tga.' 00:00:00', $tgb.' 23:59:59'])->get();
                foreach($item as $i){
                    $base64 = @json_decode(@$i->tte)->base64_signed_file;
                    if ($base64) {
                        $i->tte = convertTTE('dokumen_tte', $base64);
                        $i->update();
                    }
                }
                Flashy::success('Selesai convert base64 ke PDF');
                break;
            default:
                Flashy::error('Pilih tipe dokumen');
                return redirect()->back();
        }

        return view('resume.convertPDF', $data);
    }
}