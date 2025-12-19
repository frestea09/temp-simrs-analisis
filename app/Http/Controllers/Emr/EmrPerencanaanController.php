<?php

namespace App\Http\Controllers\Emr;

use App\EmrInapIcd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MercurySeries\Flashy\Flashy;
use App\Http\Controllers\Controller;
use Modules\Registrasi\Entities\Registrasi;
use App\EmrInapPemeriksaan;
use App\EmrInapPenilaian;
use App\EmrInapPerencanaan;
use App\EmrInapMedicalRecord;
use Modules\Kamar\Entities\Kamar;
use App\HistoriRawatInap;
use App\Rawatinap;
use Carbon\Carbon;
use Auth;
use PDF;
use App\Emr;
use App\EmrMr;
use App\EmrResume;
use App\PerawatanIcd9;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Folio;
use Modules\Tarif\Entities\Tarif;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use App\TandaTangan;
use App\SuratInap;
use App\JknIcd10;
use App\JknIcd9;

class EmrPerencanaanController extends Controller
{


	public function terapi(Request $r, $unit, $registrasi_id)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'terapi')->orderBy('id', 'DESC')->get();


		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapPerencanaan();
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = $r->keterangan;
			$emr->type  	= 'terapi';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.perencanaan.terapi', $data);
	}
	public function kontrol(Request $r, $unit, $registrasi_id)
	{


		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'kontrol')->orderBy('id', 'DESC')->get();
		$data['poli']              = Poli::all();
		$data['dokter']			   = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();

		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapPerencanaan();
			$emr->pasien_id  = $r->pasien_id;
			$emr->nomor      = 'NO' . date('dmyhis');
			$emr->no_referensi = 'NOREF' . date('dmyhis');
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->dokter_id  = $r->dokter_id;
			$emr->poli_id  = $r->poli_id;
			$emr->tgl_kontrol  = $r->tgl_kontrol;
			$emr->jam_kontrol  = $r->jam_kontrol;
			$emr->keterangan  = $r->keterangan;
			$emr->type  	= 'kontrol';
			$emr->save();

			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.perencanaan.kontrol', $data);
	}

	// Cetak Surat
	public function cetakSurat($registrasi_id, $id)
	{
		$data['cetak'] = EmrInapPerencanaan::find($id);
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);
		// dd($cetak);
		$pdf = PDF::loadView('emr.modules.perencanaan._cetak_surat', $data);
		return $pdf->stream();
	}
	
	public function cetakSuratReg($registrasi_id)
	{
		$data['cetak'] = EmrInapPerencanaan::where('registrasi_id',$registrasi_id)->orderBy('id','DESC')->first();
		if(!$data['cetak']){
			Flashy::error('Surat sakit belum ada');
			return redirect()->back();
		}
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);
		// dd($cetak);
		$pdf = PDF::loadView('emr.modules.perencanaan._cetak_surat', $data);
		return $pdf->stream();
	}

	// Cetak Surat Rujukan
	public function cetakSuratrujukan(Request $request, $registrasi_id, $id)
	{
		// dd("cetak surat rujukan");
		$data['cetak'] = EmrInapPerencanaan::find($id);
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);
		$data['spri'] = \App\SuratInap::where('registrasi_id', $registrasi_id)->first();
		// dd($cetak);

		if ($request->method() == "POST") {
			if (tte()) {
				$data['cetak_tte'] = true;

				if(cek_jenis_reg($data['cetak']->registrasi->status_reg) == 'Rawat Inap' || cek_jenis_reg($data['cetak']->registrasi->status_reg) == 'Rawat Jalan'){
					$pdf = PDF::loadView('emr.modules.perencanaan._cetak_rujukan_new', $data);
				}else{
					$pdf = PDF::loadView('emr.modules.perencanaan._cetak_rujukan_new_igd', $data);
				}
				$pdfContent = $pdf->output();
				// Create temp file
				$filePath = uniqId() . '-spri.pdf';
				File::put(public_path($filePath), $pdfContent);
	
				// Generate QR code dengan gambar
				$qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));
				// Simpan QR code dalam file
				$qrCodePath = uniqid() . '.png';
				File::put(public_path($qrCodePath), $qrCode);
	
				$tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
	
				log_esign($registrasi_id, $tte->response, "surat-pengantar-rawat-inap", $tte->httpStatusCode);
	
				$resp = json_decode($tte->response);
	
				if ($tte->httpStatusCode == 200) {
					$data['cetak']->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
					$data['cetak']->save();
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

				if(cek_jenis_reg($data['cetak']->registrasi->status_reg) == 'Rawat Inap' || cek_jenis_reg($data['cetak']->registrasi->status_reg) == 'Rawat Jalan'){
					$pdf = PDF::loadView('emr.modules.perencanaan._cetak_rujukan_new', $data);
				}else{
					$pdf = PDF::loadView('emr.modules.perencanaan._cetak_rujukan_new_igd', $data);
				}

				$pdfContent = $pdf->output();
				$data['cetak']->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
				$data['cetak']->update();
				Flashy::success('Berhasil menandatangani dokumen !');
				return redirect()->back();
			}
		}

		if(cek_jenis_reg($data['cetak']->registrasi->status_reg) == 'Rawat Inap' || cek_jenis_reg($data['cetak']->registrasi->status_reg) == 'Rawat Jalan'){
			$pdf = PDF::loadView('emr.modules.perencanaan._cetak_rujukan_new', $data);
		}else{
			$pdf = PDF::loadView('emr.modules.perencanaan._cetak_rujukan_new_igd', $data);
		}
		return $pdf->stream();
	}

	//Cetak Surat Rujukan
	public function cetakSuratkematian($registrasi_id, $id)
	{
		//dd("cetak surat kematian");
		$data['cetak']  = EmrInapPerencanaan::find($id);
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);

		$pdf = PDF::loadView('emr.modules.perencanaan._cetak_kematian', $data);
		return $pdf->stream();
	}

	public function ttePDFSuratKematian(request $request, $registrasi_id, $id)
	{
		$kematianId = $request->kematian_id;

		$data['cetak']  = EmrInapPerencanaan::find($kematianId);
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);

		if (tte()) {
            $data['proses_tte'] = true;
			$pdf = PDF::loadView('emr.modules.perencanaan._cetak_kematian', $data);
			$pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();

            $filePath = uniqId() . '-surat-kematian.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($data['cetak']->id, $tte->response, "surat-kematian", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $data['cetak']->tte = $tte->response;
                $data['cetak']->update();
                Flashy::success('Berhasil melakukan proses TTE dokumen !');
                return redirect()->back();
            } elseif ($tte->httpStatusCode == 400) {
                if (isset($resp->error)) {
                    Flashy::error($resp->error);
                    return redirect()->back();
                }
            }
            Flashy::error('Gagal melakukan proses TTE dokumen !');
        } else {
            $data['tte_nonaktif'] = true;
            $pdf = PDF::loadView('emr.modules.perencanaan._cetak_kematian', $data);
            $pdfContent = $pdf->output();

            $data['cetak']->tte = json_encode((object) [
                "base64_signed_file" => base64_encode($pdfContent),
            ]);
            $data['cetak']->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();

		$pdf = PDF::loadView('emr.modules.perencanaan._cetak_kematian', $data);
		return $pdf->stream();
	}

	public function cetakTTEPDFSuratKematian($registrasi_id, $id)
	{
		$cetak = EmrInapPerencanaan::find($id);

		$tte    = json_decode($cetak->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Surat Kematian-' . $id . '.pdf"',
        ]);
    }

	// CETAK SURAT RUJUKAN RUMAH SAKIT
	public function cetakSuratRujukanRS($registrasi_id, $id)
	{
		$data['cetak'] = EmrInapPerencanaan::find($id);
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);
		$data['registrasi'] = Registrasi::find($registrasi_id);
		// dd($cetak);
		// $pdf = PDF::loadView('emr.modules.perencanaan._cetak_surat_rujukan_rumahsakit', $data);
		$pdf = PDF::loadView('emr.modules.perencanaan._cetak_surat_rujukan_rumahsakit_jalan', $data);
		return $pdf->stream();
	}

	public function surat(Request $r, $unit, $registrasi_id,$item_id = NULL,$method=NULL)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'surat_sakit')->orderBy('id', 'DESC')->get();
		$data['poli']              = Poli::all();
		$data['dokter']			   = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$asesmen		   		   = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'like', '%asesmen-awal-medis%')->orderBy('id', 'DESC')->first();
		if ($asesmen) {
			$data['asesmen']	   = json_decode($asesmen->fisik, true);
		}
		$dokter             	   = Pegawai::where('kategori_pegawai', 1)->pluck('user_id');
		$data['cppt_dokter']       = Emr::where('registrasi_id', $registrasi_id)->whereIn('user_id', $dokter)->orderBy('id', 'DESC')->first();

		if ($item_id && $method == 'delete') {
			$delete = EmrInapPerencanaan::where('id', $item_id)->first();
			$delete->delete();
			Flashy::success('Catatan berhasil dihapus');
			return redirect()->back();
		}
		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapPerencanaan();
			$emr->pasien_id  = $r->pasien_id;
			$emr->poli_id  = $r->poli;
			$emr->dokter_id  = $r->dpjp;
			$emr->nomor      = 'NO' . date('dmyhis');
			$emr->no_referensi = 'NOREF' . date('dmyhis');
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->tgl_kontrol  = $r->tgl_kontrol;
			$emr->tgl_selesai  = $r->tgl_selesai;
			$emr->keterangan  = $r->keterangan;
			$emr->lama_istirahat  = $r->lama_istirahat;
			$emr->type  	= 'surat_sakit';
			$emr->save();


			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}

		return view('emr.modules.perencanaan.surat', $data);
	}
	public function menolakRujuk(Request $r, $unit, $registrasi_id,$item_id = NULL,$method=NULL)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'menolak_rujuk')->orderBy('id', 'DESC')->get();
		$data['poli']              = Poli::all();
		$data['dokter']			   = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();

		if ($item_id && $method == 'delete') {
			$delete = EmrInapPerencanaan::where('id', $item_id)->first();
			$delete->delete();
			Flashy::success('Catatan berhasil dihapus');
			return redirect()->back();
		}
		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapPerencanaan();
			$emr->pasien_id  = $r->pasien_id;
			$emr->poli_id  = $data['reg']->poli_id;
			$emr->dokter_id  = $data['reg']->dokter_id;
			$emr->nomor      = 'NO' . date('dmyhis');
			$emr->no_referensi = 'NOREF' . date('dmyhis');
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = json_encode($r->keterangan);
			$emr->type  	= 'menolak_rujuk';
			$emr->save();


			Flashy::success('Catatan berhasil disimpan');
			return redirect()->back();
		}

		return view('emr.modules.perencanaan.menolak_rujuk', $data);
	}


	public function rujukan(Request $r, $unit, $registrasi_id)
	{
		// dd("Surat Rujukan");
		$data['registrasi_id']        = $registrasi_id;
		$data['unit']                 = $unit;
		$data['reg']                  = Registrasi::find($registrasi_id);
		$data['riwayat']		      = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'rujukan')->orderBy('id', 'DESC')->get();
		// $data['rawat']		          = EmrInapPerencanaan::where('pasien_id',$data['reg']->pasien_id)->where('type','rujukan')->first();
		$data['poli']                 = Poli::all();
		$data['medicalrecordumum']    = EmrInapMedicalRecord::where('pasien_id', $data['reg']->pasien_id)->where('type', 'umum')->get();
		$data['medicalrecordkeluhan'] = EmrInapMedicalRecord::where('pasien_id', $data['reg']->pasien_id)->where('type', 'keluhan_utama')->get();
		$data['fisik']                = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'fisik')->get();
		$data['dokter']			      = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['surat_inap']    		  = SuratInap::where('registrasi_id', $data['reg']->id)->first();

		if ($r->assesmen_id) {
			$data['assesmen'] = EmrInapPerencanaan::where('id',$r->assesmen_id)->first();
			
			if($r->delete == true){
				$data['assesmen']->delete();
				Flashy::success('Data Berhasil Dihapus');
				return redirect()->back();
			}

		} else {
			$data['assesmen'] = null;
		}

	

		//dd($data['medicalrecordumum']);
		if ($r->method() == 'POST') {
			// dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			
			// if (empty($data['surat_inap']) || !$data['surat_inap']->no_spri) {
			// 	Flashy::error('Nomor SPRI belum dibuat, simpan gagal!');
			// 	return redirect()->back()->withInput();
			// }
			
			if ($r->assesmen_id) {
				$emr = EmrInapPerencanaan::find($r->assesmen_id);
				Flashy::success('Catatan rujukan berhasil diperbarui');
			} else {
				$emr = new EmrInapPerencanaan();
				Flashy::success('Catatan rujukan berhasil disimpan');
			}
			$emr->pasien_id  = $r->pasien_id;
			$emr->poli_id  = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->nomor      = 'NO' . date('dmyhis');
			$emr->no_referensi = 'NOREF' . date('dmyhis');
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->tgl_kontrol  = $r->tgl_kontrol;
			$emr->tgl_selesai  = $r->tgl_selesai;
			$emr->kebutuhan_ruangan = @$r->kebutuhan_ruangan;
			$emr->dokter_igd_id = @$r->dokter_igd_id;
			$emr->dokter_dpjp_id = @$r->dokter_dpjp_id;
			$emr->rencana_terapi = @$r->rencana_terapi;
			$emr->ket_fisik    = $r->fisik;
			$emr->keterangan   = $r->keterangan;
			$emr->lama_istirahat  = $r->lama_istirahat;
			$emr->type  	= 'rujukan';
			$emr->save();

			return redirect()->back();
		}


		return view('emr.modules.perencanaan.rujukan', $data);
	}

	public function kematian(Request $r, $unit, $registrasi_id)
	{

		//dd("Surat Kematian");
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'kematian')->orderBy('id', 'DESC')->get();
		$data['poli']              = Poli::all();
		$data['dokter']			   = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();

		if ($r->method() == 'POST') {
			//dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			$emr = new EmrInapPerencanaan();
			$emr->pasien_id  = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->nomor      = $r->no_surat;
			$emr->no_referensi = 'NOREF' . date('dmyhis');
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->tgl_kontrol  = $r->tgl_kontrol;
			$emr->tgl_selesai  = $r->tgl_selesai;
			$emr->jam_kontrol  = $r->jam_kontrol;
			$emr->keterangan  = $r->keterangan;
			$emr->lama_istirahat  = $r->lama_istirahat;
			$emr->type  	= 'kematian';
			$emr->save();

			Flashy::success('Catatan surat kematian berhasil disimpan');
			return redirect()->back();
		}

		return view('emr.modules.perencanaan.kematian', $data);
	}
	public function rujukanRS(Request $r, $unit, $registrasi_id)
	{

		// dd($r);
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'rujukan_rumah_sakit')->orderBy('id', 'DESC')->get();
		$data['poli']              = Poli::all();
		$data['dokter']			   = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();

		if (!empty($r->surat_id)) {
			$data['surat'] = EmrInapPerencanaan::find($r->surat_id);
		}

		if ($r->method() == 'POST') {
			//dd($r->all());
			// $alatbantu = json_encode($r->alatbantu);
			if (!empty($r->surat_id)) {
				$emr = EmrInapPerencanaan::find($r->surat_id);
			} else {
				$emr = new EmrInapPerencanaan();
			}

			$emr->pasien_id  = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->nomor      = 'NO' . date('dmyhis');
			$emr->no_referensi = 'NOREF' . date('dmyhis');
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->rujukan_rs  = json_encode($r->rujukan_rs);
			$emr->type  	= 'rujukan_rumah_sakit';

			if (!empty($r->surat_id)) {
				$emr->update();
				Flashy::success('Catatan surat rujukan rumah sakit berhasil diperbarui');
			} else {
				$emr->save();
				Flashy::success('Catatan surat rujukan rumah sakit berhasil disimpan');
			}
			return redirect()->back();
		}

		return view('emr.modules.perencanaan.rujukanRS', $data);
	}

	public function deleteSuratRujukanRS($id)
	{
		$surat = EmrInapPerencanaan::find($id);
		if ($surat) {
			$surat->delete();
		}
		Flashy::success('Catatan surat rujukan rumah sakit berhasil dihapus');
		return redirect()->back();
	}

	public function visum(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'visum')->orderBy('id', 'DESC')->get();
		$data['poli']              = Poli::all();
		$data['dokter']			   = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();

		$visumExist = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'visum')->exists();

		if ($r->visum_id !== null) {
			$visum = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->visum_id)->where('type', 'visum')->first();
			$data['visum'] = json_decode(@$visum->keterangan, true);
		} else {
			$visum = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'visum')->first();
			$data['visum'] = json_decode(@$visum->keterangan, true);
		}

		if ($r->method() == 'POST') {
			if ($visumExist) {
				$visum = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'visum')->orderBy('id', 'DESC')->first();

				$visum_old = json_decode($visum->keterangan, true);
				$visum_new = [];

				if (is_array($r->keterangan)) {
					if ($visum_old == null) {
						$visum_new = $r->keterangan;
					} else {
						$visum_new = array_merge($visum_old, $r->keterangan);
					}
				} else {
					$visum_new = $visum_old;
				}

				$visum->keterangan = json_encode($visum_new);
				$visum->type = 'visum';
				$visum->save();
				Flashy::success('Catatan Berhasil Diupdate');
				return redirect()->back();
			} else {
				$visum = new EmrInapPerencanaan();
				// $visum->nomor = $r->noSuratVisum;
				$visum->poli_id = $r->poli;
				$visum->dokter_id = $r->dpjp;
				$visum->pasien_id = $r->pasien_id;
				$visum->registrasi_id = $r->registrasi_id;
				$visum->user_id = Auth::user()->id;
				$visum->type = 'visum';
				$visum->keterangan = json_encode($r->keterangan);
				$visum->save();

				Flashy::success('Catatan Berhasil Disimpan');
				return redirect()->back();
			}
		}

		return view('emr.modules.perencanaan.visum', $data);
	}

	public function catatanKhusus(Request $r, $unit, $registrasi_id, $id_record = NULL, $method = NULL)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'catatan_khusus')->orderBy('id', 'DESC')->get();
		$data['poli']              = Poli::all();
		$data['dokter']			   = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();

		// $visumExist = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan_khusus')->exists();
		if ($id_record && $method == 'delete') {
			$record = EmrInapPerencanaan::where('id', $id_record)->first();
			$record->delete();
			Flashy::success('Catatan Berhasil Dihapus');
			return redirect()->back();
		}
		// if($r->visum_id !== null){
		// 	$visum = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->visum_id)->where('type', 'catatan_khusus')->first();
		// 	$data['visum'] = json_decode(@$visum->keterangan, true);
		// }else{
		// 	$visum = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'catatan_khusus')->first();
		// 	$data['visum'] = json_decode(@$visum->keterangan, true);
		// }

		if ($r->method() == 'POST') {
			// if($visumExist){
			// 	$visum = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan_khusus')->orderBy('id','DESC')->first();

			// 	$visum_old = json_decode($visum->keterangan, true);
			// 	$visum_new = [];

			// 	if(is_array($r->keterangan)){
			// 		if($visum_old == null){
			// 			$visum_new = $r->keterangan;
			// 		}else{
			// 			$visum_new = array_merge($visum_old, $r->keterangan);
			// 		}
			// 	}else{
			// 		$visum_new = $visum_old;
			// 	}

			// 	$visum->keterangan = json_encode($visum_new);
			// 	$visum->type = 'catatan_khusus';
			// 	$visum->save();
			// 	Flashy::success('Catatan Berhasil Diupdate');
			// 	return redirect()->back();
			// }else{
			$visum = new EmrInapPerencanaan();
			// $visum->nomor = $r->noSuratVisum;
			$visum->poli_id = $data['reg']->poli_id;
			$visum->dokter_id = $data['reg']->dokter_id;
			$visum->tgl_kontrol = $r->tgl_kontrol;
			$visum->pasien_id = $r->pasien_id;
			$visum->registrasi_id = $r->registrasi_id;
			$visum->user_id = Auth::user()->id;
			$visum->type = 'catatan_khusus';
			$visum->keterangan = json_encode($r->keterangan);
			$visum->save();

			Flashy::success('Catatan Berhasil Disimpan');
			return redirect()->back();
			// }
		}

		return view('emr.modules.perencanaan.catatan_khusus', $data);
	}

	public function informedConsent(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['dokters'] 		   = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
		$data['tarifs'] 		   = Tarif::pluck('nama', 'id');
		$data['riwayats'] 		   = EmrInapPerencanaan::where('registrasi_id', $data['reg']->id)->where('type', 'informed_consent')->orderBy('id', 'DESC')->get();
		$data['source']            = $r->get('source');
		
		if ($r->filled('asessment_id')) {
			$data['riwayat'] = EmrInapPerencanaan::find($r->asessment_id);
			$data['form'] = json_decode($data['riwayat']->keterangan, true);
		} else {
			$data['form'] = [];
		}

		if ($r->method() == 'POST') {
			// if (!empty($data['riwayat'])) {
			// 	$emr = EmrInapPerencanaan::find($data['riwayat']->id);
			// 	Flashy::success('Informed Consent berhasil diperbarui');
			// } else {
			// 	$emr = new EmrInapPerencanaan();
			// 	Flashy::success('Informed Consent berhasil disimpan');
			// }
			$emr = new EmrInapPerencanaan();
			$emr->nomor      = 'NO'.date('dmyhis').date('H');
			$emr->pasien_id = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = json_encode($r->form);
			$emr->type  	= 'informed_consent';
			$emr->save();

			Flashy::success('Informed Consent berhasil disimpan');
			return redirect()->back();
		}

		return view('emr.modules.perencanaan.informed_consent', $data);
	}

	public function cetakinformedConsentPersetujuan($registrasi_id, $id)
	{
		$data['registrasi'] = Registrasi::find($registrasi_id);
		$data['perencanaan'] = EmrInapPerencanaan::find($id);
		$data['ttd_saksi'] = TandaTangan::where('registrasi_id', $registrasi_id)->where('jenis_dokumen', 'informed-consent-saksi')->orderBy('id', 'DESC')->first();
		if ($data['perencanaan']) {
			$data['cetak']      = json_decode(@$data['perencanaan']->keterangan);
			$data['pasien']     = Pasien::find($data['perencanaan']->pasien_id);
			$data['dokter']     = Pegawai::find($data['registrasi']->dokter_id);
	
			$pdf = PDF::loadView('emr.modules.perencanaan._cetak_informedConsentPersetujuan', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		} else {
			Flashy::error('Tidak informed consent!');
			return redirect()->back();
		}
	}

	public function cetakinformedConsentPenolakan($registrasi_id, $id)
	{
		$data['registrasi'] = Registrasi::find($registrasi_id);
		$data['perencanaan'] = EmrInapPerencanaan::find($id);
		$data['ttd_saksi'] = TandaTangan::where('registrasi_id', $registrasi_id)->where('jenis_dokumen', 'informed-consent-saksi')->orderBy('id', 'DESC')->first();
		if ($data['perencanaan']) {
			$data['cetak']      = json_decode(@$data['perencanaan']->keterangan);
			$data['pasien']     = Pasien::find($data['perencanaan']->pasien_id);
			$data['dokter']     = Pegawai::find($data['registrasi']->dokter_id);
	
			$pdf = PDF::loadView('emr.modules.perencanaan._cetak_informedConsentPenolakan', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		} else {
			Flashy::error('Tidak informed consent!');
			return redirect()->back();
		}
	}

	public function cetakinformedConsentPenundaan($registrasi_id)
	{
		$data['registrasi'] = Registrasi::find($registrasi_id);
		$data['perencanaan'] = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'informed_consent')->first();
		if ($data['perencanaan']) {
			$data['cetak']      = json_decode(@$data['perencanaan']->keterangan);
			$data['pasien']     = Pasien::find($data['perencanaan']->pasien_id);
			$data['dokter']     = $data['perencanaan']->dokter_id;
	
			$pdf = PDF::loadView('emr.modules.perencanaan._cetak_informedConsentPenundaan', $data);
			$pdf->setPaper('A4', 'potret');
			return $pdf->stream();
		} else {
			Flashy::error('Tidak informed consent!');
			return redirect()->back();
		}
	}

	public function treadmill(Request $r, $unit, $registrasi_id, $id_record = NULL, $method = NULL)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['asesmen_id']        = @$id_record;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'treadmill')->orderBy('id', 'DESC')->get();
		$data['poli']              = Poli::all();
		$data['dokter']			   = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();

		// $visumExist = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'catatan_khusus')->exists();
		$data['assesment'] = [];
		if ($id_record) {
			$assesment = EmrInapPerencanaan::where('id', $id_record)->first();
			$data['assesment'] = json_decode(@$assesment->keterangan, true);
		}
		if ($id_record && $method == 'delete') {
			$record = EmrInapPerencanaan::where('id', $id_record)->first();
			$record->delete();
			Flashy::success('Catatan Berhasil Dihapus');
			return redirect()->back();
		}

		if ($r->method() == 'POST') {

			if ($r->asesmen_id) {
				$visum = EmrInapPerencanaan::where('id', $r->asesmen_id)->first();
			} else {

				$visum = new EmrInapPerencanaan();
			}
			// $visum->nomor = $r->noSuratVisum;
			$visum->poli_id = @$data['reg']->poli_id;
			$visum->dokter_id = @$data['reg']->dokter_id;
			$visum->tgl_kontrol = $r->tgl_kontrol;
			$visum->pasien_id = $r->pasien_id;
			$visum->registrasi_id = $r->registrasi_id;
			$visum->user_id = Auth::user()->id;
			$visum->type = 'treadmill';
			$visum->keterangan = json_encode($r->keterangan);
			$visum->save();

			Flashy::success('Catatan Berhasil Disimpan');
			return redirect()->back();
			// }
		}

		return view('emr.modules.perencanaan.treadmill', $data);
	}

	public function hapusPerencanaan($unit, $reg_id, $id)
	{
		$reg = Registrasi::find($reg_id);
		EmrInapPerencanaan::find($id)->delete();
		Flashy::success('Data Berhasil Dihapus.');

		// return redirect('emr-soap/anamnesis/main/' . $unit . '/' . $reg->id . '?poli=' . $reg->poli_id . '&dpjp=' . $reg->dokter_id);
		return redirect()->back();
	}

	public function cetakVisum($registrasi_id, $id)
	{
		$data['cetak'] = EmrInapPerencanaan::find($id);
		$data['dokter'] = Pegawai::find($data['cetak']->dokter_id)->first();
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id)->first();
		$data['tindakans'] = Folio::where('registrasi_id', $data['cetak']->registrasi_id)->where('jenis', '!=', 'ORJ')->get();

		$data['visum'] = json_decode($data['cetak']->keterangan, true);
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);

		setLocale(LC_TIME, config('app.locale'));
		// dd($cetak);
		// $pdf = PDF::loadView('emr.modules.perencanaan._cetak_surat', $data);
		// return $pdf->stream();
		return view('emr.modules.perencanaan._cetak_visum', $data);
	}

	public function catatanTransferInternal(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'transfer-internal')->orderBy('id', 'DESC')->get();
		$data['poli']              = Poli::all();
		$data['dokter']			   = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();

		$emrExist = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'transfer-internal')->exists();

		if ($r->emr_id !== null) {
			$emr = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->emr_id)->where('type', 'transfer-internal')->first();
			$data['transferInternal'] = json_decode(@$emr->keterangan, true);
		} else {
			$emr = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'transfer-internal')->first();
			$data['transferInternal'] = json_decode(@$emr->keterangan, true);
		}

		if ($r->method() == 'POST') {
			if ($emrExist) {
				$emr = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'transfer-internal')->orderBy('id', 'DESC')->first();

				$emr_old = json_decode($emr->keterangan, true);
				$emr_new = [];

				if (is_array($r->keterangan)) {
					if ($emr_old == null) {
						$emr_new = $r->keterangan;
					} else {
						$emr_new = array_merge($emr_old, $r->keterangan);
					}
				} else {
					$emr_new = $emr_old;
				}

				$emr->keterangan = json_encode($emr_new);
				$emr->type = 'transfer-internal';
				$emr->save();
				Flashy::success('Catatan Berhasil Diupdate');
				return redirect()->back();
			} else {
				$emr = new EmrInapPerencanaan();
				$emr->poli_id = $r->poli;
				$emr->dokter_id = $r->dpjp;
				$emr->pasien_id = $r->pasien_id;
				$emr->registrasi_id = $r->registrasi_id;
				$emr->user_id = Auth::user()->id;
				$emr->type = 'transfer-internal';
				$emr->keterangan = json_encode($r->keterangan);
				$emr->save();

				Flashy::success('Catatan Berhasil Disimpan');
				return redirect()->back();
			}
		}

		return view('emr.modules.perencanaan.transfer-internal', $data);
	}

	public function sbar(Request $r, $unit, $registrasi_id)
	{

		//dd("Surat Kematian");
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		// $data['riwayat']		   = EmrInapPerencanaan::where('pasien_id',$data['reg']->pasien_id)->where('type','sbar')->orderBy('id','DESC')->get();
		$data['riwayat'] 			= EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->where('type', 'assesment-awal-perawat-igd')->get();
		$data['all_resume']     = Emr::where('registrasi_id', $registrasi_id)->orderBy('id', 'DESC')->first();
		$data['lastCppt']     = Emr::where('registrasi_id', $registrasi_id)->where('user_id', '!=', $data['reg']->dokter_umum->user_id)->orderBy('id', 'DESC')->first();
		$data['poli']              = Poli::all();
		$data['dokters']			   = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['kamar']			   = Kamar::all();
		$data['history_irna']		   = HistoriRawatInap::where('registrasi_id', $registrasi_id)->latest()->take(2)->get();
		$data['sbars']				= EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where("type", 'sbar')->get();
		if ($r->method() == 'POST') {
			$sbar = ["situation" => $r['situation'], "background" => $r['background'], "assesment" => $r['assesment'], "recomendation" => $r['recomendation']];
			$sbar_json = json_encode($sbar);
			$emr = new EmrInapPerencanaan();
			$emr->pasien_id  = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->nomor      = 'NO' . date('dmyhis');
			$emr->no_referensi = 'NOREF' . date('dmyhis');
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->type  	= 'sbar';
			$emr->sbar		= $sbar_json;
			$emr->save();

			Flashy::success('Sbar berhasil disimpan');
			return redirect()->back();
		}

		return view('emr.modules.perencanaan.sbar', $data);
	}

	public function cetakSuratPemindahan($registrasi_id, $id)
	{
		$data['cetak'] = EmrInapPerencanaan::find($id);
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);
		$data['cetak']  = json_decode($data['cetak']->sbar);
		$pdf = PDF::loadView('emr.modules.perencanaan.pemindahan_pasien', $data);
		return $pdf->stream();
	}

	public function laporanTindakanRJ(Request $r, $unit, $registrasi_id, $record_id = NULL, $method = NULL)
	{
		//dd("Surat Rujukan");
		$data['registrasi_id']        = $registrasi_id;
		$data['unit']                 = $unit;
		$data['reg']                  = Registrasi::find($registrasi_id);
		$data['riwayat']		      = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'lap-tindakan-rj')->orderBy('id', 'DESC')->get();
		$asessment                    = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->first();
		$data['asessment']            = json_decode(@$asessment->fisik);
		$data['dokter']			      = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['perawat']			  = Pegawai::where('kategori_pegawai', 2)->select('nama', 'id')->get();
		$data['method']				  = $method;

		if ($record_id) {
			$edit		      = EmrInapPerencanaan::where('id', $record_id)->first();
			$data['asessment']            = json_decode(@$edit->keterangan);
		}
		// dd($data['edit']);
		//dd($data['medicalrecordumum']);
		if ($r->method() == 'POST') {

			$emr                = new EmrInapPerencanaan();
			$emr->pasien_id     = $r->pasien_id;
			$emr->poli_id       = $r->poli;
			$emr->dokter_id     = $r->dokter_id;
			$emr->nomor         = 'NO' . date('dmyhis');
			if (@$r->method == 'duplicate') {
				$emr->diagnosis = 'duplicate';
			}
			$emr->no_referensi  = 'NOREF' . date('dmyhis');
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id       = Auth::user()->id;
			$emr->type  	    = 'lap-tindakan-rj';
			$emr->keterangan    = json_encode([
				'tgl_tindakan'      => $r->tgl_tindakan,
				'dokter'            => $r->dokter_id,
				'asisten'           => $r->perawat_id,
				'diagnosa'          => $r->diagnosa,
				'tindakan'          => $r->tindakan,
				'jaringanEksisi'    => $r->eksisi,
				'sendToPA'          => $r->pa,
				'uraian_tindakan'   => $r->uraian_tindakan,
				'instruksi'         => $r->instruksi
			]);

			if ($r->proses_tte) {
				if (tte()) {
					$data['cetak']      = json_decode(@$emr->keterangan);
					$data['pasien']     = Pasien::find(@$emr->pasien_id);
					$data['proses_tte'] = true;
					$pdf = PDF::loadView('emr.modules.perencanaan._cetak_laporan_tindakan_rj', $data);
					$pdfContent = $pdf->output();

					// Create temp pdf eresep file
					$filePath = uniqId() . '-laporan-tindakan.pdf';
					File::put(public_path($filePath), $pdfContent);

					// Generate QR code dengan gambar
					$qrCode = QrCode::format('png')->size(150)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

					// Simpan QR code dalam file
					$qrCodePath = uniqid() . '.png';
					File::put(public_path($qrCodePath), $qrCode);

					$tte = tte_visible_koordinat($filePath, $r->nik, $r->passphrase, '#', $qrCodePath);

					log_esign($registrasi_id, $tte->response, "laporan-tindakan", $tte->httpStatusCode);

					$resp = json_decode($tte->response);
					if ($tte->httpStatusCode == 200) {
						$emr->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
						$emr->save();
						Flashy::success('Laporan Tindakan Rawat Jalan berhasil disimpan');
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
					} else {
						Flashy::error('Gagal menandatangani dokumen! Dokumen tidak disimpan');
						return redirect()->back();
					}
				} else {
					$emr->save();

					Flashy::success('Laporan Tindakan Rawat Jalan berhasil disimpan');
					return redirect()->back();
				}
			}


			$emr->save();

			Flashy::success('Laporan Tindakan Rawat Jalan berhasil disimpan');
			return redirect()->back();
		}
		return view('emr.modules.perencanaan.lap_tindakan_rj', $data);
	}
	public function duplicatelaporanTindakanRJ(Request $r, $unit, $registrasi_id, $record_id = '')
	{
		//dd("Surat Rujukan");
		$data['registrasi_id']        = $registrasi_id;
		$data['unit']                 = $unit;
		$data['reg']                  = Registrasi::find($registrasi_id);
		$data['riwayat']		      = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'lap-tindakan-rj')->orderBy('id', 'DESC')->get();
		$asessment                    = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->first();
		$data['asessment']            = json_decode(@$asessment->fisik);
		$data['dokter']			      = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['perawat']			  = Pegawai::where('kategori_pegawai', 2)->select('nama', 'id')->get();

		//dd($data['medicalrecordumum']);
		if ($r->method() == 'POST') {
			$emr                = new EmrInapPerencanaan();
			$emr->pasien_id     = $r->pasien_id;
			$emr->poli_id       = $r->poli;
			$emr->dokter_id     = $r->dokter_id;
			$emr->nomor         = 'NO' . date('dmyhis');
			$emr->no_referensi  = 'NOREF' . date('dmyhis');
			$emr->registrasi_id = $r->registrasi_id;
			$emr->user_id       = Auth::user()->id;
			$emr->type  	    = 'lap-tindakan-rj';
			$emr->keterangan    = json_encode([
				'tgl_tindakan'      => $r->tgl_tindakan,
				'dokter'            => $r->dokter_id,
				'asisten'           => $r->perawat_id,
				'diagnosa'          => $r->diagnosa,
				'tindakan'          => $r->tindakan,
				'jaringanEksisi'    => $r->eksisi,
				'sendToPA'          => $r->pa,
				'uraian_tindakan'   => $r->uraian_tindakan,
				'instruksi'         => $r->instruksi
			]);

			if ($r->proses_tte) {
				if (tte()) {
					$data['cetak']      = json_decode(@$emr->keterangan);
					$data['pasien']     = Pasien::find(@$emr->pasien_id);
					$data['proses_tte'] = true;
					$pdf = PDF::loadView('emr.modules.perencanaan._cetak_laporan_tindakan_rj', $data);
					$pdfContent = $pdf->output();

					// Create temp pdf eresep file
					$filePath = uniqId() . '-laporan-tindakan.pdf';
					File::put(public_path($filePath), $pdfContent);

					// Generate QR code dengan gambar
					$qrCode = QrCode::format('png')->size(150)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

					// Simpan QR code dalam file
					$qrCodePath = uniqid() . '.png';
					File::put(public_path($qrCodePath), $qrCode);

					$tte = tte_visible_koordinat($filePath, $r->nik, $r->passphrase, '#', $qrCodePath);

					log_esign($registrasi_id, $tte->response, "laporan-tindakan", $tte->httpStatusCode);

					$resp = json_decode($tte->response);
					if ($tte->httpStatusCode == 200) {
						$emr->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
						$emr->save();
						Flashy::success('Laporan Tindakan Rawat Jalan berhasil disimpan');
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
					} else {
						Flashy::error('Gagal menandatangani dokumen! Dokumen tidak disimpan');
						return redirect()->back();
					}
				} else {
					$emr->save();

					Flashy::success('Laporan Tindakan Rawat Jalan berhasil disimpan');
					return redirect()->back();
				}
			}


			$emr->save();

			Flashy::success('Laporan Tindakan Rawat Jalan berhasil disimpan');
			return redirect()->back();
		}
		return view('emr.modules.perencanaan.lap_tindakan_rj', $data);
	}

	public function cetakLapTindakanRJ($registrasi_id, $id)
	{
		$data['registrasi'] = Registrasi::find($registrasi_id);
		$data['perencanaan'] = EmrInapPerencanaan::find($id);
		$data['ttd'] = TandaTangan::where('emr_inap_perencanaan_id', $id)->first();

		$data['cetak']      = json_decode(@$data['perencanaan']->keterangan);
		$data['pasien']     = Pasien::find($data['perencanaan']->pasien_id);
		$data['dokter'] 	= Pegawai::find($data['perencanaan']->dokter_id);

		$tte    = json_decode($data['perencanaan']->tte);

		if (!empty($tte)) {
			$base64 = $tte->base64_signed_file;
			$pdfContent = base64_decode($base64);
			return Response::make($pdfContent, 200, [
				'Content-Type' => 'application/pdf',
				'Content-Disposition' => 'attachment; filename="Laporan tindakan-' . $data['perencanaan']->id . '.pdf"',
			]);
		} else {
			return view('emr.modules.perencanaan._cetak_laporan_tindakan_rj', $data);
		}
	}

	// EMR ANESTESI
	public function anestesi(Request $r, $registrasi_id, $record_id = null, $method = null)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = 'inap';
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrMr::where('pasien_id', $data['reg']->pasien_id)->where('type', 'anestesi')->orderBy('id', 'DESC')->get();
		$data['pasien'] = Pasien::find($data['reg']->pasien_id);
		$data['history'] = [];
		if ($record_id) {
			$data['history'] = EmrMr::where('id', $record_id)->first();
			$data['data_emr'] = $data['history']->anestesi;
			// jika ada parameter delete, maka jalankan fungsi delete
			if ($method == 'delete') {
				$data['history']->delete();
				Flashy::success('record berhasil dihapus');
				return redirect()->back();
			}
		}

		$pas = [];
		foreach (Registrasi::where('pasien_id', $data['reg']->pasien_id)->get() as $rre) {
			$pas[] = $rre->id;
		}
		// $data['operasi']		   = Operasi::whereIn('registrasi_id',$pas)->orderBy('id','DESC')->get();

		if ($r->method() == 'POST') {
			// dd($r->formulir);
			// jika ada record_id maka update
			if ($r->record_id) {
				$emr = EmrMr::where('id', $r->record_id)->first();
			} else {
				// buat baru
				$emr = new EmrMr();
			}
			$emr->pasien_id  = $r->pasien_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->unit  = $r->unit;
			$emr->dokter_id  = @$r->dokter_id;
			$emr->anestesi  = json_encode($r->formulir);
			$emr->type  = 'anestesi';
			$emr->user_id  = Auth::user()->id;
			$emr->save();

			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
		}


		return view('emr.modules.anestesi.formulir', $data);
	}


	public function cetakAnestesi($id)
	{
		$data['data'] = EmrMr::where('id', $id)->first();
		$data['data_emr'] = $data['data']->anestesi;
		// dd($data['data_emr']);
		$data['reg']               = Registrasi::find($data['data']->registrasi_id);
		// $penjualan = ResepNote::where('pasien_id', $reg->pasien_id)->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
		// dd(@json_decode(@$data['data']->formulir,true));
		$pdf = PDF::loadView('emr.modules.anestesi.cetak.pdf_formulir', $data);
		$pdf->setPaper('A4', 'potret');
		return $pdf->stream();
		// return view('emr_rawatinap.modules.kontrol_poli._cetak', $data);
	}

	public function echocardiogram(Request $request, $unit, $registrasi_id)
	{
		$data = [
			'unit' => $unit,
			'registrasi_id' => $registrasi_id,
			'reg' => Registrasi::find($registrasi_id),
			'asesmen_id' => '',
			'riwayat' => \App\echocardiogram::where('registrasi_id', $registrasi_id)->get()
		];

		if ($request->method() == 'POST') {
			// $echocardiogram = \App\echocardiogram::where('registrasi_id', $registrasi_id)->first();
			// if ($echocardiogram) {
			// 	$ep = $echocardiogram;
			// } else {
			$ep = new \App\echocardiogram();
			// }
			$ep->registrasi_id = $registrasi_id;
			$ep->pasien_id = @$data['reg']->pasien->id;
			$ep->atrium_kiri = $request['atrium_kiri'];
			$ep->global = $request['global'];
			$ep->ventrikel_kanan = $request['ventrikel_kanan'];
			$ep->katup_katup_jantung_aorta = $request['katup_katup_jantung_aorta'];
			$ep->ejeksi_fraksi = $request['ejeksi_fraksi'];
			$ep->diagnosa = $request['diagnosa'];
			$ep->ea = $request['ea'];
			$ep->ee = $request['ee'];
			$ep->tapse = $request['tapse'];
			$ep->lvesd = $request['lvesd'];
			$ep->ivsd = $request['ivsd'];
			$ep->ivss = $request['ivss'];
			$ep->lvedd = $request['lvedd'];
			$ep->pwd = $request['pwd'];
			$ep->pws = $request['pws'];
			$ep->lvmi = $request['lvmi'];
			$ep->rwt = $request['rwt'];
			$ep->kesimpulan = $request['kesimpulan'];
			$ep->catatan_dokter = $request['catatan_dokter'];
			$ep->jenis = $request['jenis'];
			$ep->user_id = Auth::user()->id;
			$ep->tte = null;
			$ep->save();

			if ($request->proses_tte == 'true') {
				$radiologi = \App\echocardiogram::join('registrasis', 'registrasis.id', '=', 'echocardiograms.registrasi_id')
					->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
					->where('echocardiograms.id', $ep->id)
					->select('registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.kelamin', 'pasiens.tgllahir', 'pasiens.rt', 'pasiens.rw', 'pasiens.village_id', 'echocardiograms.*')
					->first();

				if (tte()) {
					$proses_tte = true;
					$pdf = PDF::loadView('echocardiogram.lap_hasil_echocardiogram', compact('radiologi', 'proses_tte'));
					$pdfContent = $pdf->output();

					// Create temp pdf eresep file
					$filePath = uniqId() . '-echocardiogram.pdf';
					File::put(public_path($filePath), $pdfContent);

					// Generate QR code dengan gambar
					$qrCode = QrCode::format('png')->size(150)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

					// Simpan QR code dalam file
					$qrCodePath = uniqid() . '.png';
					File::put(public_path($qrCodePath), $qrCode);

					$tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

					log_esign($registrasi_id, $tte->response, "echocardiogram", $tte->httpStatusCode);

					$resp = json_decode($tte->response);

					if ($tte->httpStatusCode == 200) {
						$ep->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
						$ep->update();
						Flashy::success('Echocardiogram berhasil di input!');
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
					$tte_nonaktif = true;
					$pdf = PDF::loadView('echocardiogram.lap_hasil_echocardiogram', compact('radiologi', 'tte_nonaktif'));
					$pdfContent = $pdf->output();
					$ep->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
					$ep->update();
					Flashy::success('Berhasil menandatangani dokumen !');
					return redirect()->back();
				}
			}

			Flashy::success('Echocardiogram berhasil di input!');
			return redirect()->back();
		}
		return view('emr.modules.perencanaan.echocardiogram', $data);
	}

	public function suratPaps(Request $r, $unit, $registrasi_id){
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id',$data['reg']->pasien_id)->where('type','surat-paps')->orderBy('id','DESC')->get();
		$data['poli']              = Poli::all();
		$data['dokter']			   = Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		if ($r->method() == 'POST'){
			$emr = new EmrInapPerencanaan();
			$emr->nomor      = 'NO'.date('dmyhis').'/UN 19.5.3.2.7/PM/'.date('H');
			$emr->pasien_id = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			 $emr->dokter_id  = $r->dokter_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = json_encode($r->form);
			 $emr->type  	= 'surat-paps';
			$emr->save();

			Flashy::success('Surat PAPS Berhasil Dibuat');
			 return redirect()->back();
		}

		return view('emr.modules.perencanaan.surat_paps', $data);
	}

	public function cetakSuratPaps($unit, $registrasi_id, $id){
		$data['cetak']  = EmrInapPerencanaan::find($id);
		$data['paps']   = json_decode($data['cetak']->keterangan);
		$data['ttd_saksi'] = TandaTangan::where('emr_inap_perencanaan_id', $id)->first();
		$data['unit'] = $unit;
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);
		$data['reg'] = Registrasi::find($data['cetak']->registrasi_id);

		return view('emr.modules.perencanaan._cetak_surat_paps', $data);
	}
	public function cetakSuratMenolakRujuk($registrasi_id, $id){
		$data['cetak']  = EmrInapPerencanaan::find($id);
		$data['paps']   = json_decode($data['cetak']->keterangan);
		// dd($data['paps']);
		// $data['unit'] = $unit;
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);
		$data['reg'] = Registrasi::find($data['cetak']->registrasi_id);

		return view('emr.modules.perencanaan._cetak_surat_menolak_rujuk', $data);
	}

	public function uploadSuratPaps(Request $request){
		$request->validate(['file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg']);
		if(!empty($request->file('file'))){
			$filename = time().$request->file('file')->getClientOriginalName();
			$request->file('file')->move('paps/', $filename);
		}else{
			$filename = null;
		}
		$keterangan = [
			"paps_uploaded_file" => $filename,
		];
		$paps  = EmrInapPerencanaan::find($request->id);
		$paps_old      = json_decode($paps->keterangan, true);
		if (@$paps_old['paps_uploaded_file']) {
			$fileToDelete = public_path('paps/' . $paps_old['paps_uploaded_file']);
			if (File::exists($fileToDelete)) {
				File::delete($fileToDelete);
			} 
		}
		$paps_new      = array_merge($paps_old, $keterangan);
		$paps->keterangan   = json_encode($paps_new);
		$paps->update();
		Flashy::success('Berhasil mengunggah file!');
		
		return redirect()->back();
	}

	public function persetujuanNICU(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id',$data['reg']->pasien_id)->where('type','persetujuan-nicu')->orderBy('id','DESC')->get();
		$data['perawat']			   = Pegawai::where('kategori_pegawai', 2)->select('nama', 'id')->get();
		if ($r->method() == 'POST') {
			$emr = new EmrInapPerencanaan();
			$emr->nomor      = 'NO'.date('dmyhis').date('H');
			$emr->pasien_id = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = json_encode($r->form);
			$emr->type  	= 'persetujuan-nicu';
			$emr->save();

			Flashy::success('Surat Persetujuan Nicu berhasil disimpan');
			return redirect()->back();
		}

		return view('emr.modules.perencanaan.persetujuan_nicu', $data);
	}

	public function cetakPersetujuanNICU($unit, $registrasi_id, $id)
	{
		$data['cetak']  = EmrInapPerencanaan::find($id);
		$data['nicu']   = json_decode($data['cetak']->keterangan);

		$data['unit'] = $unit;
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);
		$data['reg'] = Registrasi::find($data['cetak']->registrasi_id);
		return view('emr.modules.perencanaan._cetak_persetujuan_nicu', $data);
	}

	public function persetujuanTindakan(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id',$data['reg']->pasien_id)->where('type','persetujuan-tindakan')->orderBy('id','DESC')->get();
		if ($r->method() == 'POST') {
			$emr = new EmrInapPerencanaan();
			$emr->nomor      = 'NO'.date('dmyhis').date('H');
			$emr->pasien_id = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = json_encode($r->form);
			$emr->type  	= 'persetujuan-tindakan';
			$emr->save();

			Flashy::success('Surat Persetujuan Tindakan berhasil disimpan');
			return redirect()->back();
		}

		return view('emr.modules.perencanaan.persetujuan_tindakan', $data);
	}

	public function cetakPersetujuanTindakan($unit, $registrasi_id, $id)
	{
		$data['cetak']  = EmrInapPerencanaan::find($id);
		$data['tindakan']   = json_decode($data['cetak']->keterangan, true);

		$data['unit'] = $unit;
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);
		$data['reg'] = Registrasi::find($data['cetak']->registrasi_id);
		return view('emr.modules.perencanaan._cetak_persetujuan_tindakan', $data);
	}

	public function pulangPasien(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('pasien_id',$data['reg']->pasien_id)->where('type','perencanaan-pulang-pasien')->orderBy('id','DESC')->get();
		$data['form']			   = null;

		if (!empty($r->id)) {
			$data['perencanaan'] = EmrInapPerencanaan::find($r->id);
			if (empty($data['perencanaan'])) {
				return redirect(url()->current());
			}
			$data['form'] = json_decode($data['perencanaan']->keterangan, true);
		}

		if ($r->method() == 'POST') {
			$emr = new EmrInapPerencanaan();
			$emr->nomor      = 'NO'.date('dmyhis').date('H');
			$emr->pasien_id = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = json_encode($r->form);
			$emr->type  	= 'perencanaan-pulang-pasien';
			$emr->save();

			Flashy::success('Perencanaan pasien pulang berhasil disimpan');
			return redirect()->back();
		}

		return view('emr.modules.perencanaan.pulang_pasien', $data);
	}

	// Resume Inap
	public function resume(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('registrasi_id',$registrasi_id)->where('type','resume')->orderBy('id','DESC')->first();
		$data['form']			   = @json_decode(@$data['riwayat']->keterangan, true);
		$data['aswal_ranap'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)
			->whereIn('type', asesmen_ranap_dokter())
			->orderBy('id','DESC')
			->first();
		if (!$data['aswal_ranap']) {
			$data['aswal_ranap'] = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)
				->where('type', 'like', 'fisik_%')
				->where('type', '!=', 'fisik_gizi')
				->orderBy('id','DESC')
				->first();
		}
		$data['aswal_igd']	   		= EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-medis-igd')->first();
		$data['aswal_ponek']	   	= EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-medis-igd-ponek')->first();
		$data['laboratorium'] = Folio::where('registrasi_id', $registrasi_id)->where('poli_tipe', 'L')->select('namatarif')->get();
		$data['radiologi'] = Folio::where('registrasi_id', $registrasi_id)->where('poli_tipe', 'R')->select('namatarif')->get();
		$data['icd10Primary_jkn']	= JknIcd10::where('registrasi_id', $registrasi_id)->where('kategori', 'Primary')->orderBy('id','DESC')->first();
        $data['icd10Secondary_jkn'] = JknIcd10::where('registrasi_id', $registrasi_id)->whereNull('kategori')->get();
		$data['icd9_jkn'] 			= JknIcd9::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->first();
		$data['rawatInap'] 			= RawatInap::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->first();
		if ($r->method() == 'POST') {
			if (!empty($data['riwayat'])) {
				$emr = EmrInapPerencanaan::find($data['riwayat']->id);
				Flashy::success('Resume berhasil diperbarui');
			} else {
				$emr = new EmrInapPerencanaan();
				Flashy::success('Resume berhasil disimpan');
			}
			$emr->nomor      = 'NO'.date('dmyhis').date('H');
			$emr->pasien_id = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = json_encode($r->form);
			$emr->type  	= 'resume';
			$emr->is_draft  	= empty($r->is_draft) ? null : true;
			$emr->save();

			// Simpan atau update tanggal keluar di tabel RawatInap
			$rawatInap = RawatInap::where('registrasi_id', $registrasi_id)->first();

			if (!$rawatInap) {
				$rawatInap = new RawatInap();
				$rawatInap->registrasi_id = $registrasi_id;
			}

			if (!empty($r->tgl_keluar)) {
				$rawatInap->tgl_keluar = Carbon::parse($r->tgl_keluar)->format('Y-m-d H:i:s');
				
				// Simpan data hanya jika ada perubahan
				if (!$rawatInap->isDirty('tgl_keluar')) {
					return;
				}
				$rawatInap->save();
			}
		
			return redirect()->back();
		}

		return view('emr.modules.perencanaan.resume', $data);
	}

	public function icdUpdateResume(Request $req)
	{
		$emr = EmrInapPerencanaan::find($req->id);
		if (!$emr) return response()->json(['error' => 'Data tidak ditemukan'], 404);

		$data = json_decode($emr->keterangan, true);
		$data[$req->key] = $req->value;

		$emr->keterangan = json_encode($data);
		$emr->save();

		return response()->json(['success' => true]);
	}

	// Resume IGD
	public function resumeIGD(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrResume::where('registrasi_id',$registrasi_id)->where('type','resume-igd')->orderBy('id','DESC')->first();
		$data['form']			   = @json_decode(@$data['riwayat']->content, true);
		$data['aswal_igd']	   	   = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'assesment-awal-medis-igd')->first();
		$data['cppt']			   = Emr::whereNotNull('diagnosistambahan')->where('registrasi_id', $registrasi_id)->first();
		$data['icd10Primary_jkn']	= JknIcd10::where('registrasi_id', $registrasi_id)->where('kategori', 'Primary')->orderBy('id','DESC')->first();
        $data['icd10Secondary_jkn'] = JknIcd10::where('registrasi_id', $registrasi_id)->whereNull('kategori')->orderBy('id','DESC')->get();
		$data['icd9_jkn'] 			= JknIcd9::where('registrasi_id', $registrasi_id)->orderBy('id','DESC')->first();
		if ($r->method() == 'POST') {
			if (!empty($data['riwayat'])) {
				$emr = EmrResume::find($data['riwayat']->id);
				Flashy::success('Resume berhasil diperbarui');
			} else {
				$emr = new EmrResume();
				Flashy::success('Resume berhasil disimpan');
			}

			$emr->pasien_id       = $r->pasien_id;
			$emr->registrasi_id   = $r->registrasi_id;
			$emr->user_id         = Auth::user()->id;
			$emr->content           = json_encode($r->form);
			$emr->type  	        = 'resume-igd';
			$emr->save();

			return redirect()->back();
		}

		return view('emr.modules.perencanaan.resume_igd', $data);
	}

	public function icdUpdateResumeIGD(Request $req)
	{
		$emr = EmrResume::find($req->id);
		if (!$emr) return response()->json(['error' => 'Data tidak ditemukan'], 404);

		$data = json_decode($emr->content, true);
		$data[$req->key] = $req->value;

		$emr->content = json_encode($data);
		$emr->save();

		return response()->json(['success' => true]);
	}

	public function lembarObservasiObgyn(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('registrasi_id',$registrasi_id)->where('type','observasi-obgyn')->orderBy('id','DESC')->first();
		$data['form']			   = @json_decode(@$data['riwayat']->keterangan, true);

		if ($r->method() == 'POST') {
			if (!empty($data['riwayat'])) {
				$emr = EmrInapPerencanaan::find($data['riwayat']->id);
				Flashy::success('Observasi Obgyn berhasil diperbarui');
			} else {
				$emr = new EmrInapPerencanaan();
				Flashy::success('Observasi Obgyn berhasil disimpan');
			}
			$emr->nomor      = 'NO'.date('dmyhis').date('H');
			$emr->pasien_id = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = json_encode($r->form);
			$emr->type  	= 'observasi-obgyn';
			$emr->save();

			return redirect()->back();
		}

		return view('emr.modules.perencanaan.observasi_obgyn', $data);
	}

	public function cetakobservasiObgyn($registrasi_id)
    {
        
        $data['registrasi_id']     = $registrasi_id;
        $data['reg']               = Registrasi::find($registrasi_id);
        $data['observasi'] = EmrInapPerencanaan::where('registrasi_id', $data['reg']->id)->where('type', 'observasi-obgyn')->first();
        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-observasi-obgyn', $data);
		$pdf->setPaper('A4', 'landscape');
		return $pdf->stream('Observasi_Obgyn_'. $data['reg']->pasien->nama . '.pdf');
    }

	public function laporanKuret(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('registrasi_id',$registrasi_id)->where('type','laporan-kuret')->orderBy('id','DESC')->first();
		$data['form']			   = @json_decode(@$data['riwayat']->keterangan, true);

		if ($r->method() == 'POST') {
			if (!empty($data['riwayat'])) {
				$emr = EmrInapPerencanaan::find($data['riwayat']->id);
				Flashy::success('Laporan kuret berhasil diperbarui');
			} else {
				$emr = new EmrInapPerencanaan();
				Flashy::success('Laporan kuret berhasil disimpan');
			}
			$emr->nomor      = 'NO'.date('dmyhis').date('H');
			$emr->pasien_id = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = json_encode($r->form);
			$emr->type  	= 'laporan-kuret';
			$emr->save();

			return redirect()->back();
		}

		return view('emr.modules.perencanaan.laporan_kuret', $data);
	}

	public function cetaklaporanKuret($registrasi_id)
    {
        
        $data['registrasi_id']     = $registrasi_id;
        $data['reg']               = Registrasi::find($registrasi_id);
        $data['laporan'] = EmrInapPerencanaan::where('registrasi_id', $data['reg']->id)->where('type', 'laporan-kuret')->first();
        $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-laporan-kuret', $data);
		$pdf->setPaper('A4', 'portrait');
		return $pdf->stream('Laporan_Kuret_'. $data['reg']->pasien->nama . '.pdf');
    }

	public function sertifikatKematian(Request $r, $unit, $registrasi_id)
	{
		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('registrasi_id',$registrasi_id)->where('type','sertifikat-kematian')->orderBy('id','DESC')->first();
		$data['form']			   = @json_decode(@$data['riwayat']->keterangan, true);

		if ($r->method() == 'POST') {
			if (!empty($data['riwayat'])) {
				$emr = EmrInapPerencanaan::find($data['riwayat']->id);
				Flashy::success('Sertifikat kematian berhasil diperbarui');
			} else {
				$emr = new EmrInapPerencanaan();
				Flashy::success('Sertifikat kematian berhasil disimpan');
			}
			$emr->nomor      = 'NO'.date('dmyhis').date('H');
			$emr->pasien_id = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = json_encode($r->form);
			$emr->type  	= 'sertifikat-kematian';
			$emr->save();

			return redirect()->back();
		}

		return view('emr.modules.perencanaan.sertifikat_kematian', $data);
	}

	public function cetakSertifikatkematian($registrasi_id, $id)
	{
		//dd("cetak sertifikat kematian");
		$data['cetak']  = EmrInapPerencanaan::find($id);
		$data['reg']	= Registrasi::find($registrasi_id);
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);
		$data['riwayat']= EmrInapPerencanaan::where('registrasi_id',$registrasi_id)->where('type','sertifikat-kematian')->orderBy('id','DESC')->first();
		$data['form']	= @json_decode(@$data['riwayat']->keterangan, true);

		$pdf = PDF::loadView('emr.modules.perencanaan._cetak_sertifikat_kematian', $data);
		return $pdf->stream();
	}

	public function ttePDFSertifikatKematian(request $request, $registrasi_id, $id)
	{
		$kematianId = $request->kematian_id;

		$data['cetak']   = EmrInapPerencanaan::find($kematianId);
		$data['reg']	 = Registrasi::find($registrasi_id);
		$data['pasien']  = Pasien::find($data['cetak']->pasien_id);
		$data['riwayat'] = EmrInapPerencanaan::where('registrasi_id',$registrasi_id)->where('type','sertifikat-kematian')->orderBy('id','DESC')->first();
		$data['form']	 = @json_decode(@$data['riwayat']->keterangan, true);

		if (tte()) {
            $data['proses_tte'] = true;
			$pdf = PDF::loadView('emr.modules.perencanaan._cetak_sertifikat_kematian', $data);
			$pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();

            $filePath = uniqId() . '-sertifikat-kematian.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($data['cetak']->id, $tte->response, "sertifikat-kematian", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $data['cetak']->tte = $tte->response;
                $data['cetak']->update();
                Flashy::success('Berhasil melakukan proses TTE dokumen !');
                return redirect()->back();
            } elseif ($tte->httpStatusCode == 400) {
                if (isset($resp->error)) {
                    Flashy::error($resp->error);
                    return redirect()->back();
                }
            }
            Flashy::error('Gagal melakukan proses TTE dokumen !');
        } else {
            $data['tte_nonaktif'] = true;
            $pdf = PDF::loadView('emr.modules.perencanaan._cetak_sertifikat_kematian', $data);
            $pdfContent = $pdf->output();

            $data['cetak']->tte = json_encode((object) [
                "base64_signed_file" => base64_encode($pdfContent),
            ]);
            $data['cetak']->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();

		$pdf = PDF::loadView('emr.modules.perencanaan._cetak_sertifikat_kematian', $data);
		return $pdf->stream();
	}


	public function ttePDFSertifikatKuret(request $request, $registrasi_id, $id)
	{
		$kematianId = $request->record_id;
		
		$data['cetak']   = EmrInapPerencanaan::find($kematianId);
		$data['reg']	 = Registrasi::find($registrasi_id);
		$data['pasien']  = Pasien::find($data['cetak']->pasien_id);
		$data['riwayat'] = EmrInapPerencanaan::where('registrasi_id',$registrasi_id)->where('type','laporan-kuret')->orderBy('id','DESC')->first();
		$data['form']	 = @json_decode(@$data['riwayat']->keterangan, true);

		if (tte()) {
            $data['proses_tte'] = true;
			$pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-laporan-kuret', $data);
			$pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();

            $filePath = uniqId() . '-laporan-kuret.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($data['cetak']->id, $tte->response, "laporan-kuret", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $data['cetak']->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $data['cetak']->update();
                Flashy::success('Berhasil melakukan proses TTE dokumen !');
                return redirect()->back();
            } elseif ($tte->httpStatusCode == 400) {
                if (isset($resp->error)) {
                    Flashy::error($resp->error);
                    return redirect()->back();
                }
            }
            Flashy::error('Gagal melakukan proses TTE dokumen !');
        } else {
            $data['tte_nonaktif'] = true;
            $pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-laporan-kuret', $data);
            $pdfContent = $pdf->output();

            $data['cetak']->tte = json_encode((object) [
                "base64_signed_file" => base64_encode($pdfContent),
            ]);
            $data['cetak']->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();

		$pdf = PDF::loadView('emr.modules.pemeriksaan.cetak-laporan-kuret', $data);
		return $pdf->stream();
	}

	public function cetakTTEPDFSertifikatKematian($registrasi_id, $id)
	{
		$cetak = EmrInapPerencanaan::find($id);

		$tte    = json_decode($cetak->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Sertifikat Kematian-' . $id . '.pdf"',
        ]);
    }

	public function suratDPJP(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapPerencanaan::where('registrasi_id',$registrasi_id)->where('type','surat-dpjp')->orderBy('id','DESC')->first();
		$data['form']			   = @json_decode(@$data['riwayat']->keterangan, true);
		$data['dokter']			   = Pegawai::where('kategori_pegawai', 1)->select(['id', 'nama'])->get();

		if ($r->method() == 'POST') {
			if (!empty($data['riwayat'])) {
				$emr = EmrInapPerencanaan::find($data['riwayat']->id);
				Flashy::success('Surat pernyataan berhasil diperbarui');
			} else {
				$emr = new EmrInapPerencanaan();
				Flashy::success('Surat pernyataan berhasil disimpan');
			}
			$emr->nomor      = 'NO'.date('dmyhis').date('H');
			$emr->pasien_id = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = json_encode($r->form);
			$emr->type  	= 'surat-dpjp';
			$emr->save();

			return redirect()->back();
		}

		return view('emr.modules.perencanaan.surat_dpjp', $data);
	}

	public function cetakSuratDPJP($unit, $registrasi_id, $id)
	{
		$data['cetak']  = EmrInapPerencanaan::find($id);
		$data['surat']   = json_decode($data['cetak']->keterangan, true);
		$data['unit'] = $unit;
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);
		$data['reg'] = Registrasi::with('rawat_inap', 'icd10s')->find($data['cetak']->registrasi_id);
		$data['dokter'] = Pegawai::find($data['reg']->dokter_id);
		$data['ranap'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$data['dpjp_inap'] = Pegawai::find($data['ranap']->dokter_id);
		$pdf = PDF::loadView('emr.modules.perencanaan._cetak_surat_dpjp', $data);
		return $pdf->stream();
	}

	public function cetakPerencanaanPasienPulang($unit, $registrasi_id, $id)
	{
		Flashy::warning("Mohon Maaf Halaman Ini Sedang Dalam Proses :)");
		return redirect()->back();
		$data['reg'] = Registrasi::find($registrasi_id);
		$data['cetak']  = EmrInapPerencanaan::find($id);
		$data['surat']   = json_decode($data['cetak']->keterangan, true);
		$data['unit'] = $unit;
		$data['pasien'] = Pasien::find($data['cetak']->pasien_id);
		$data['reg'] = Registrasi::with('rawat_inap', 'icd10s')->find($data['cetak']->registrasi_id);
		// $pdf = PDF::loadView('emr.modules.perencanaan._cetak_perencanaan_pasien_pulang', $data);
		// return $pdf->stream();
	}

	public function kirSehat(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
        $data['unit']              = $unit;
        $data['reg']               = Registrasi::find($registrasi_id);

		$data['riwayats'] = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'kir_sehat')->orderBy('id', 'DESC')->get();
		$data['mcu_perawat'] = EmrInapPemeriksaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'mcu_perawat')->orderBy('id', 'DESC')->get();
		// dd($data['mcu_perawat']);
        $asessmentExists = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'kir_sehat')->exists();
        if ($r->asessment_id !== null) {
            $assesment   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'kir_sehat')->first();
            $data['assesment']  = json_decode($assesment->keterangan, true);
        } else {
            $assesment = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'kir_sehat')->first();
            $data['assesment'] = json_decode(@$assesment->keterangan, true);
        }

        $data['current_asessment'] = @$assesment;
        
        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPerencanaan::find($r->asessment_id);
                $asessment_old = json_decode($update->keterangan, true);
                $asessment_new = [];

                if (is_array($r->keterangan)) {
                    $asessment_new = array_merge($asessment_old, $r->keterangan);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->keterangan = json_encode($asessment_new);
				if (!$update->nomor) {
                    $lastNomor = EmrInapPerencanaan::where('type', 'kir_sehat')
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
                $asessment          =  EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'kir_sehat')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->keterangan, true);
                $asessment_new = [];
                if (is_array($r->keterangan)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->keterangan);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->keterangan   = json_encode($asessment_new);
                $asessment->type      = 'kir_sehat';
				if (!$asessment->nomor) {
                    $lastNomor = EmrInapPerencanaan::where('type', 'kir_sehat')
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
				$lastNomor = EmrInapPerencanaan::where('type', 'kir_sehat')
                    ->whereNotNull('nomor')
                    ->where('nomor', 'like', '%/%/%')
                    ->select(DB::raw("MAX(CAST(TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(nomor, '/', -3), '/', 1)) AS UNSIGNED)) as max_nomor"))
                    ->value('max_nomor');

                $id_nomor = $lastNomor ? $lastNomor + 1 : 1000;

                $asessment = new EmrInapPerencanaan();
                $asessment->nomor 			= '445 : 91 / ' . $id_nomor . ' / ' . romawi(date('n')) . ' / ' . date('Y');
                $asessment->pasien_id       = $r->pasien_id;
                $asessment->registrasi_id   = $r->registrasi_id;
                $asessment->user_id         = Auth::user()->id;
                $asessment->keterangan      = json_encode($r->keterangan);
                $asessment->type            = 'kir_sehat';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back();
            }
        }

		return view('emr.modules.perencanaan.kir_sehat', $data);
	}

	public function ttePDFKIRSehat(Request $request)
    {
        $registrasi_id = $request->registrasi_id;
        $id     = $request->kir_id;
        $reg    = Registrasi::find($registrasi_id);
        $kir    = EmrInapPerencanaan::find($id);
        $unit   = $request->unit;
		$riwayats = EmrInapPerencanaan::where('pasien_id', $reg->pasien_id)->where('type', 'kir_sehat')->orderBy('id', 'DESC')->get();
        if (tte()) {
            $proses_tte = true;
            $pdf = PDF::loadView('emr.modules.perencanaan._cetak_kir_sehat', compact('reg', 'registrasi_id', 'kir', 'unit', 'riwayats', 'proses_tte'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            // Create temp pdf eresep file
            $filePath = uniqId() . '-KIR.pdf';
            File::put(public_path($filePath), $pdfContent);

            // Generate QR code dengan gambar
            $qrCode = QrCode::format('png')->size(320)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

            // Simpan QR code dalam file
            $qrCodePath = uniqid() . '.png';
            File::put(public_path($qrCodePath), $qrCode);

            $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

            log_esign($reg->id, $tte->response, "KIR", $tte->httpStatusCode);

            $resp = json_decode($tte->response);

            if ($tte->httpStatusCode == 200) {
                $kir->tte = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
                $kir->update();
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
            $pdf = PDF::loadView('emr.modules.perencanaan._cetak_kir_sehat', compact('reg', 'registrasi_id', 'kir', 'unit', 'riwayats', 'tte_nonaktif'));
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            $kir->tte = convertTTE("dokumen_tte", base64_encode($pdfContent));
            $kir->update();
            Flashy::success('Berhasil menandatangani dokumen !');
            return redirect()->back();
        }
        return redirect()->back();
    }

	public function cetakKirSehat($unit, $registrasi_id)
	{
    $kir = EmrInapPerencanaan::find($registrasi_id);
    $asesmen = EmrInapPemeriksaan::where('registrasi_id', $kir->registrasi_id)->where('type', 'fisik_mcu')->orderBy('id', 'DESC')->first();
	if ($asesmen !== null) {
        $asesmen = json_decode($asesmen->fisik, true);
    }
	// dd($kir);
    $reg = Registrasi::find($kir->registrasi_id);
    $tgl = date('Y-m-d', strtotime($reg->created_at));
    $poli = Poli::find($reg->poli_id);

    $pdf = PDF::loadView('emr.modules.perencanaan._cetak_kir_sehat', compact('reg', 'kir', 'tgl', 'poli', 'asesmen'));
    $pdf->setPaper('A4', 'portrait');

    return $pdf->stream('_cetak_kir_sehat.pdf');
	}

	public function cetakTTEPDFKIRSehat($reg_id, $id)
    {
        $kir   = EmrInapPerencanaan::find($id);
		$asesmen = EmrInapPemeriksaan::where('registrasi_id', $kir->registrasi_id)->where('type', 'fisik_mcu')->orderBy('id', 'DESC')->first();
		if ($asesmen !== null) {
			$asesmen = json_decode($asesmen->fisik, true);
		}
        $tte = json_decode($kir->tte);
        $base64 = $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="KIR Sehat-' . $reg_id . '-' . $id . '.pdf"',
        ]);
    }

	public function konsulGizi(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
		$data['unit']              = $unit;
		$data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayats']		   = EmrInapPerencanaan::where('registrasi_id',$registrasi_id)->where('type','konsultasi-gizi')->orderBy('id','DESC')->get();
		if ($r->method() == 'POST') {
			$emr = new EmrInapPerencanaan();
			$emr->nomor      = 'NO'.date('dmyhis').date('H');
			$emr->pasien_id = $r->pasien_id;
			$emr->poli_id    = $r->poli;
			$emr->dokter_id  = $r->dokter_id;
			$emr->registrasi_id  = $r->registrasi_id;
			$emr->user_id  = Auth::user()->id;
			$emr->keterangan  = json_encode($r->form);
			$emr->type  	= 'konsultasi-gizi';
			$emr->save();
			Flashy::success('Konsultasi Gizi berhasil disimpan');

			return redirect()->back();
		}

		return view('emr.modules.perencanaan.konsultasi_gizi', $data);
	}

	public function permohonanVaksinasi(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
        $data['unit']              = $unit;
        $data['reg']               = Registrasi::find($registrasi_id);

		$data['riwayats'] = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'permohonan-vaksinasi')->orderBy('id', 'DESC')->get();
        $asessmentExists = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'permohonan-vaksinasi')->exists();
        if ($r->asessment_id !== null) {
            $assesment   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'permohonan-vaksinasi')->first();
            $data['assesment']  = json_decode($assesment->keterangan, true);
        } else {
            $assesment = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'permohonan-vaksinasi')->first();
            $data['assesment'] = json_decode(@$assesment->keterangan, true);
        }

        $data['current_asessment'] = @$assesment;
        
        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPerencanaan::find($r->asessment_id);
                $asessment_old = json_decode($update->keterangan, true);
                $asessment_new = [];

                if (is_array($r->keterangan)) {
                    $asessment_new = array_merge($asessment_old, $r->keterangan);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->keterangan = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment          =  EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'permohonan-vaksinasi')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->keterangan, true);
                $asessment_new = [];
                if (is_array($r->keterangan)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->keterangan);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->keterangan   = json_encode($asessment_new);
                $asessment->type      = 'permohonan-vaksinasi';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $asessment = new EmrInapPerencanaan();
                $asessment->nomor 		 	= 'NO' . date('dmyhis');
                $asessment->pasien_id       = $r->pasien_id;
                $asessment->registrasi_id   = $r->registrasi_id;
                $asessment->user_id         = Auth::user()->id;
                $asessment->keterangan      = json_encode($r->keterangan);
                $asessment->type            = 'permohonan-vaksinasi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back();
            }
        }

		return view('emr.modules.perencanaan.permohonan_vaksinasi', $data);
	}

	public function cetakPermohonanVaksinasi($unit, $id) 
	{
		$vaksinasi = EmrInapPerencanaan::find($id);
		$data = json_decode($vaksinasi->keterangan, true);

		$reg = Registrasi::find($vaksinasi->registrasi_id);
		$pasien = Pasien::find($vaksinasi->pasien_id);
		$tgl = date('Y-m-d', strtotime($reg->created_at));
		$poli = Poli::find($reg->poli_id);

		$pdf = PDF::loadView('emr.modules.perencanaan._cetak_permohonan_vaksinasi', compact('reg', 'pasien', 'vaksinasi', 'tgl', 'poli', 'data'));
		$pdf->setPaper('A4', 'portrait');

		return $pdf->stream('_cetak_permohonan_vaksinasi.pdf');
	}

	public function persetujuanVaksinasi(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
        $data['unit']              = $unit;
        $data['reg']               = Registrasi::find($registrasi_id);
		$data['perawat'] 		   = Pegawai::where('kategori_pegawai', 2)->get();
        $permohonan         	   = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'permohonan-vaksinasi')->orderBy('id', 'DESC')->first();
		if ($permohonan) {
			$data['permohonan']    = json_decode($permohonan->keterangan, true);
		}

		$data['riwayats'] = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('type', 'persetujuan-vaksinasi')->orderBy('id', 'DESC')->get();
        $asessmentExists = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'persetujuan-vaksinasi')->exists();
        if ($r->asessment_id !== null) {
            $assesment   = EmrInapPerencanaan::where('pasien_id', $data['reg']->pasien_id)->where('id', $r->asessment_id)->where('type', 'persetujuan-vaksinasi')->first();
            $data['assesment']  = json_decode($assesment->keterangan, true);
        } else {
            $assesment = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'persetujuan-vaksinasi')->first();
            $data['assesment'] = json_decode(@$assesment->keterangan, true);
        }

        $data['current_asessment'] = @$assesment;
        
        if ($r->method() == 'POST') {
            if ($r->asessment_id != null) {
                // dd($r->asessment_id);
                $update = EmrInapPerencanaan::find($r->asessment_id);
                $asessment_old = json_decode($update->keterangan, true);
                $asessment_new = [];

                if (is_array($r->keterangan)) {
                    $asessment_new = array_merge($asessment_old, $r->keterangan);
                } else {
                    $asessment_new = $asessment_old;
                }

                $update->keterangan = json_encode($asessment_new);
                $update->save();
                Flashy::success('Record Pada ' . Carbon::parse($update->created_at)->format('d-m-Y') . ' Berhasil diupdate');
                return redirect()->back();
            } elseif ($asessmentExists) {
                $asessment          =  EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'persetujuan-vaksinasi')->orderBy('id', 'DESC')->first();
                $asessment_old = json_decode($asessment->keterangan, true);
                $asessment_new = [];
                if (is_array($r->keterangan)) {
                    // dd($r->fisik);
                    $asessment_new = array_merge($asessment_old, $r->keterangan);
                } else {
                    $asessment_new = $asessment_old;
                }
                $asessment->keterangan   = json_encode($asessment_new);
                $asessment->type      = 'persetujuan-vaksinasi';
                $asessment->save();
                Flashy::success('Record berhasil diupdate');
                return redirect()->back();
            } else {
                $asessment = new EmrInapPerencanaan();
                $asessment->nomor 		 	= 'NO' . date('dmyhis');
                $asessment->pasien_id       = $r->pasien_id;
                $asessment->registrasi_id   = $r->registrasi_id;
                $asessment->user_id         = Auth::user()->id;
                $asessment->keterangan      = json_encode($r->keterangan);
                $asessment->type            = 'persetujuan-vaksinasi';
                $asessment->save();
                Flashy::success('Record berhasil disimpan');
                return redirect()->back();
            }
        }

		return view('emr.modules.perencanaan.persetujuan_vaksinasi', $data);
	}

	public function cetakPersetujuanVaksinasi($unit, $id) 
	{
		$vaksinasi 			= EmrInapPerencanaan::find($id);
		$data 				= json_decode($vaksinasi->keterangan, true);

		$reg 				= Registrasi::find($vaksinasi->registrasi_id);
		$pasien 			= Pasien::find($vaksinasi->pasien_id);
		$saksi_pasien 		= TandaTangan::where('registrasi_id', $reg->id)->where('jenis_dokumen', 'vaksinasi-saksi')->orderBy('id', 'DESC')->first();
		$pembuat_keterangan = TandaTangan::where('registrasi_id', $reg->id)->where('jenis_dokumen', 'vaksinasi-pemberi')->orderBy('id', 'DESC')->first();
		$poli 				= Poli::find($reg->poli_id);

		$pdf = PDF::loadView('emr.modules.perencanaan._cetak_persetujuan_vaksinasi', compact('reg', 'pasien', 'saksi_pasien', 'pembuat_keterangan', 'vaksinasi', 'poli', 'data'));
		$pdf->setPaper('A4', 'portrait');

		return $pdf->stream('_cetak_persetujuan_vaksinasi.pdf');
	}

	public function daftarTilikVaksinasi(Request $r, $unit, $registrasi_id)
	{

		$data['registrasi_id']     = $registrasi_id;
        $data['unit']              = $unit;
        $data['reg']               = Registrasi::find($registrasi_id);

		$data['riwayats'] = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'tilik-vaksinasi')->orderBy('id', 'DESC')->get();
        if ($r->has('assesment_id')) {
			$assesment = EmrInapPerencanaan::where('id', $r->assesment_id)->where('registrasi_id', $registrasi_id)->where('type', 'tilik-vaksinasi')->first();
		} else {
			$assesment = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'tilik-vaksinasi')->orderBy('id', 'DESC')->first();
		}
        $data['assesment'] = json_decode(@$assesment->keterangan, true);
        
        if ($r->method() == 'POST') {
			$asessment = new EmrInapPerencanaan();
			$asessment->nomor 		 	= 'NO' . date('dmyhis');
			$asessment->pasien_id       = $r->pasien_id;
			$asessment->dokter_id       = $r->dokter_id;
			$asessment->registrasi_id   = $r->registrasi_id;
			$asessment->user_id         = Auth::user()->id;
			$asessment->keterangan      = json_encode($r->keterangan);
			$asessment->type            = 'tilik-vaksinasi';
			$asessment->save();
			Flashy::success('Record berhasil disimpan');
			return redirect()->back();
            }

		return view('emr.modules.perencanaan.daftar_tilik_vaksinasi', $data);
	}

	public function cetakDaftarTilikVaksinasi($unit, $id) 
	{
		$vaksinasi 			= EmrInapPerencanaan::find($id);
		$data 				= json_decode($vaksinasi->keterangan, true);

		$reg 				= Registrasi::find($vaksinasi->registrasi_id);
		$pasien 			= Pasien::find($vaksinasi->pasien_id);
		$poli 				= Poli::find($reg->poli_id);

		$pdf = PDF::loadView('emr.modules.perencanaan._cetak_daftar_tilik_vaksinasi', compact('reg', 'pasien', 'vaksinasi', 'poli', 'data'));
		$pdf->setPaper('A4', 'portrait');

		return $pdf->stream('_cetak_daftar_tilik_vaksinasi.pdf');
	}

	public function clinicalPathway($path = null)
	{
		$basePath = public_path('clinical-pathway');
		$currentPath = realpath($basePath . ($path ? '/' . $path : ''));

		if ($currentPath === false || strpos($currentPath, realpath($basePath)) !== 0) {
			abort(403, 'Akses tidak diizinkan');
		}

		$folders = [];
		$files = [];

		foreach (scandir($currentPath) as $entry) {
			if ($entry === '.' || $entry === '..') continue;
			$fullPath = $currentPath . '/' . $entry;

			if (is_dir($fullPath)) {
				$folders[] = $entry;
			} elseif (is_file($fullPath)) {
				$files[] = $entry;
			}
		}

		$parentPath = null;
		if ($path) {
			$parts = explode('/', $path);
			array_pop($parts);
			$parentPath = implode('/', $parts);
		}

		return view('emr.modules.clinicalpathway.index', [
			'folders' => $folders,
			'files' => $files,
			'path' => $path,
			'parentPath' => $parentPath,
		]);
	}
}
