<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Tarif\Entities\Tarif;
use Yajra\DataTables\DataTables;
use App\HistoriRawatInap;
use App\Inacbg;
use App\Mastermapping;
use Auth;
use Excel;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;
use PDF;
use Validator;
use DB;
use Exception;
use MercurySeries\Flashy\Flashy;

class IdrgController extends Controller {
	public function index() {
		return view('idrg.index');
	}

	public function dataTarif($tahuntarif_id = '', $jenis = '', $kategoritarif_id = '') {
		// if ($kategoritarif_id) {
		// 	$tarif = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('kategoritarif_id', $kategoritarif_id)->where('masteridrg_id', '=', NULL)->get();
		// 	$kiri = ceil($tarif->count() / 2);
		// 	$dataKiri = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('kategoritarif_id', $kategoritarif_id)->where('masteridrg_id', '=', NULL)->skip(0)->take($kiri)->get();
		// 	$dataKanan = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('kategoritarif_id', $kategoritarif_id)->where('masteridrg_id', '=', NULL)->skip($kiri)->take($kiri)->get();
		// } else {
			
			// if($jenis == 'TI'){
				// dd(Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('masteridrg_id', NULL)->get());
			// }
			$tarif = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('masteridrg_id', '=', NULL)->get();
			$kiri = ceil($tarif->count() / 2);
			$dataKiri = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('masteridrg_id', '=', NULL)->skip(0)->take($kiri)->get();
			$dataKanan = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('masteridrg_id', '=', NULL)->skip($kiri)->take($kiri)->get();
		// }
		return view('idrg.dataTarif', compact('tarif', 'dataKiri', 'dataKanan'))->with('no', 1);
	}

	public function simpanIdrg(Request $request) {
		$total = $request['total'];
		$masteridrg_id = $request['masteridrg_id'];
		$id = [];
		// dd($request->all());
		for ($i = 1; $i <= $total; $i++) {
			if (!empty($request['tarif' . $i])) {
				$tarif = Tarif::find($request['tarif' . $i]);
				$namatarif = $tarif->nama;
				$tarf = Tarif::where('nama',$namatarif)->select('nama','masteridrg_id','id')->get();
				foreach($tarf as $t){
					$tarifs = Tarif::find($t->id);
					$tarifs->masteridrg_id = $masteridrg_id;
					$tarifs->update();
				}
				array_push($id, $tarif->id);
			}
		}
		$trf = Tarif::whereIn('id', $id)->get();
		return response()->json(['sukses' => true, 'message' => $trf->count() . ' tarif berhasil di idrg']);
	}

	public function idrgDetail($masteridrg_id = '') {
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');
		$tarif = Tarif::where('masteridrg_id', $masteridrg_id)->select('nama','carabayar','total','id','masteridrg_id')->groupBy('nama')->groupBy('total')->get();
		return DataTables::of($tarif)
			->addIndexColumn()
			->addColumn('total', function ($tarif) {
				return @number_format(@$tarif->total);
			})
			->addColumn('carabayar', function ($tarif) {
				return @baca_carabayar(@$tarif->carabayar);
			})
			->addColumn('hapus', function ($tarif) {
				return '<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="hapusIdrg(' . @$tarif->masteridrg_id . ',' . @$tarif->id . ')"><i class="fa fa-remove"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	public function hapusIdrg($tarif_id) {
		$tarif = Tarif::find($tarif_id);
		$tarif->masteridrg_id = NULL;
		$tarif->update();
		return $tarif;
	}


	// BRIDGING
	public function new_claim(Request $req) {
		
		$cek = Validator::make($req->all(), [
			'no_kartu' => 'required',
			'no_sep' => 'required',
			'diagnosa' => 'required',
			'procedure' => 'nullable',
		]);
		
		if ($cek->passes()) {
			$reg = Registrasi::where('id', $req['registrasi_id'])->first();
			$reg->no_sep = $req['no_sep'];
			$reg->update();
			
			$in = Inacbg::where('no_sep',$req['no_sep'])->where('registrasi_id',$req['registrasi_id'])->first();
			if(!$in){
				$in = new Inacbg();
			}
			$in->pasien_nama = $reg->pasien->nama;
			$in->pasien_kelamin = $reg->pasien->kelamin;
			$in->pasien_tgllahir = $reg->pasien->tgllahir;
			$in->jenis_pembayaran = $reg->bayar;
			$in->no_kartu = $req['no_kartu'];
			$in->no_sep = $req['no_sep'];
			$in->jenis_pasien = $reg->jenis_pasien;
			$in->kelas_perawatan = $req['kelas_rawat'];
			$in->cara_keluar = $req['discharge_status'];
			$in->dokter = $req['nama_dokter'];
			$in->berat = 0;
			$in->total_rs = $req['tarif_rs'];
			$in->no_rm = $req['no_rm'];
			$in->icd1 = $req['diagnosa'];
			$in->prosedur1 = $req['procedure'];
			$in->alamat = $reg->pasien->alamat;
			$in->who_update = Auth::user()->name;
			$in->no_hp = $reg->pasien->nohp;
			$in->poli_id = $reg->poli_id;
			$in->registrasi_id = $reg->id;
			$in->dijamin = null;
			$in->kode = null;
			$in->tgl_masuk = $req['tgl_masuk'];
			$in->tgl_keluar = $req['tgl_keluar'];
			$in->save();
			
			$newClaim = $this->BuatKlaimBaru(
				$req['no_kartu'],
				$req['no_sep'],
				$req['no_rm'],
				$req['nama'],
				$req['tgllahir'] . ' 00:00:00', $req['gender']
			);
			$dataKlaim = $this->UpdateDataKlaim($req['registrasi_id'],$req);
			// AKTIFKAN IDRG
			
			$IdrgDiagnosaSet = $this->IdrgDiagnosaSet($req['no_sep'], $req['diagnosa']);
			$IdrgDiagnosaGet = $this->IdrgDiagnosaGet($req['no_sep'], $req['diagnosa']);
			$IdrgProcedureSet = $this->IdrgProcedureSet($req['no_sep'], $req['procedure']);
			$IdrgProcedureGet = $this->IdrgProcedureGet($req['no_sep'], $req['procedure']);
			
			
			$GroupingIDRGStage1 = $this->GroupingIDRGStage1($req['no_sep']);
			
			
			
			// $final = $this->FinalisasiKlaim($req['no_sep'], $req['coder_nik']);
			// $kirimDC = $this->KirimKlaimIndividualKeDC($req['no_sep']);
			
			//Input ICD
			// $this->inputPerawatanICD9($reg->id, $req['procedure']);
			// $this->inputPerawatanICD10($reg->id, $req['diagnosa']); 
			
			return response()->json(['sukses' => 1, 'no_sep' => $GroupingIDRGStage1]);
		} else {
			return response()->json(['errors' => $cek->errors()]);
		}
	}
	public function final_claim_idrg(Request $req) {
		// AFTER GROUPING STAGE 1
		$IDRGFinal = $this->IDRGFinal($req['no_sep']);
		$IDRGImportINACBG = $this->IDRGImportINACBG($req['no_sep']);
		
		$InacbgDiagnosaSet = $this->InacbgDiagnosaSet($req['no_sep'], $req['diagnosa']);
		$InacbgProcedureSet = $this->InacbgProcedureSet($req['no_sep'], $req['procedure']);
		
		
		$grouper = $this->GroupingStage1($req['no_sep'], $req['coder_nik']);
		// $stage2 = $this->GroupingStage2($req['no_sep'], NULL);

		return response()->json(['sukses' => 1, 'no_sep' => $req['no_sep']]);
	}

	// URUTAN 2
	public function grouping_idrg_only(Request $req) {
		// AFTER FINAL IDRG
		$IdrgDiagnosaSet = $this->IdrgDiagnosaSet($req['no_sep'], $req['diagnosa']);
		$IdrgDiagnosaGet = $this->IdrgDiagnosaGet($req['no_sep'], $req['diagnosa']);
		$IdrgProcedureSet = $this->IdrgProcedureSet($req['no_sep'], $req['procedure']);
		$IdrgProcedureGet = $this->IdrgProcedureGet($req['no_sep'], $req['procedure']);
		
		
		$GroupingIDRGStage1 = $this->GroupingIDRGStage1($req['no_sep']);
		@$msg = $GroupingIDRGStage1;
		if (@$msg['msg']['metadata']['message'] == "Ok" && @$msg['msg']['metadata']['response_idrg']['mdc_description'] =='Ungroupable or Unrelated') {
			return response()->json(['sukses' => 1, 'no_sep' => $msg]);
		}

		if (@$msg['msg']['metadata']['message'] == "Ok") {
			$r = Inacbg::where('no_sep', $req['no_sep'])->first();
			$r->idrg_grouper = "2"; //SET FINAL IDRG
			$r->set = "2"; //SET FINAL IDRG
			$r->save();
		}
		
		return response()->json(['sukses' => 1, 'no_sep' => $msg]);
	}
	public function grouping_inacbg_only(Request $req) {
		// AFTER FINAL IDRG
		// if($req->procedure_inacbg){
		// 		// Ambil value original
		// 	$procedures = $req['procedure_inacbg'];

		// 	// Pecah jadi array berdasarkan '#'
		// 	$proceduresArray = explode('#', $procedures);

		// 	// Hapus bagian +qty (contoh: "86.22+2" -> "86.22")
		// 	$cleanedProcedures = array_map(function ($p) {
		// 		return preg_replace('/\+.*/', '', $p);
		// 	}, $proceduresArray);

		// 	// Gabungkan kembali
		// 	$req['procedure_inacbg'] = implode('#', $cleanedProcedures);
		// }
		$req['procedure_inacbg'] = format_icd9($req['procedure_inacbg']); 
		// dd($req['procedure_inacbg'],$req['diagnosa_inacbg']);

		$InacbgDiagnosaSet = $this->InacbgDiagnosaSet($req['no_sep'], $req['diagnosa_inacbg']);
		$InacbgProcedureSet = $this->InacbgProcedureSet($req['no_sep'], $req['procedure_inacbg']);
		$grouper = $this->GroupingStage1($req['no_sep'], $req['coder_nik']);

		// @$input_icd9 = $this->inputPerawatanICD9($req['registrasi_id'], $req['diagnosa_inacbg']);
		// @$input_icd10 = $this->inputPerawatanICD10($req['registrasi_id'], $req['procedure_inacbg']);
		
		@$input_icd9_idrg = $this->inputPerawatanICD9IDRG($req['registrasi_id'], $req['procedure']);
		@$input_icd10_idrg = $this->inputPerawatanICD10IDRG($req['registrasi_id'], $req['diagnosa']);
		// $stage2 = $this->GroupingStage2($req['no_sep'], NULL);
		@$msg = $grouper;
		
		@$message = @$msg['msg']['metadata']['message'] ?? '';
		@$description = @$msg['msg']['response_inacbg']['cbg']['description'] ?? '';
		
		
		$r = Inacbg::where('no_sep', $req['no_sep'])->first();
		$r->icd10_inacbg = $req['diagnosa_inacbg']; 
		$r->icd9_inacbg = $req['procedure_inacbg'];
		$r->save();

		
		if (
			$message == 'Ok' &&
			stripos($description, 'GAGAL:') !== 0 &&
			stripos($description, 'ERROR:') !== 0
		) {
			// $stage2 = $this->GroupingStage2($req['no_sep'], NULL);
			$r->idrg_grouper = "7"; //SET FINAL IDRG
			$r->dijamin = @$msg['msg']['response_inacbg']['tariff'];
			$r->kode = @$msg['msg']['response_inacbg']['cbg']['code'];
			$r->deskripsi_grouper = @$msg['msg']['response_inacbg']['cbg']['description'];
			$r->versi_eklaim = @$msg['msg']['response_inacbg']['inacbg_version'];
			$r->who_update = Auth::user()->name;
			$r->grouping_stage1 = @json_encode($msg);
			$r->los = 1;
			$r->status_step = 'final_claim';
			$r->final_klaim = 'Y';
			$r->kirim_dc = 'N';
			$r->final_idrg = "1";
			$r->save();

			return response()->json(['sukses' => 1, 'no_sep' => $req['no_sep'],'last_bridging' =>true]);
		}
		
		return response()->json(['sukses' => 1, 'no_sep' => $msg,'last_bridging' =>false]);
	}

	// URUTAN 4
	public function final_idrg_only(Request $req) {
		// AFTER FINAL IDRG
		$IDRGFinal = $this->IDRGFinal($req['no_sep']);
		@$msg = $IDRGFinal;
		if (@$msg['msg']['metadata']['message'] == "Ok" || @$msg['msg']['metadata']['message'] == "Klaim sudah final") {
			$r = Inacbg::where('no_sep', $req['no_sep'])->first();
			$r->idrg_grouper = "4"; //SET FINAL IDRG
			$r->status_step = "import_idrg"; //SET FINAL IDRG
			$r->save();
		}
		
		return response()->json(['sukses' => 1, 'no_sep' => $msg]);
	}
	// URUTAN 5
	public function import_idrg_only(Request $req) {
		// AFTER FINAL IDRG
		$IDRGImportINACBG = $this->IDRGImportINACBG($req['no_sep']);
		@$msg = $IDRGImportINACBG;
		// dd($req->all());
		// if($req['procedure_inacbg']){
			 
		// }
		// dd($req['procedure_inacbg']);
		
		if (@$msg['msg']['metadata']['message'] == "Ok") {
			$r = Inacbg::where('no_sep', $req['no_sep'])->first();


			$r->idrg_grouper = "5"; //SET FINAL IDRG
			$r->status_step = "grouping_inacbg"; //SET KE GROUPING INACBG
			$r->icd10_inacbg = $req['diagnosa']; 
			$r->icd9_inacbg = format_icd9($req['procedure']); 
			// if($r->icd10_inacbg){//JIKA ADA, IMPORT ULANG
			// 	$r->icd10_inacbg = $req['icd1'];
			// } 
			// if($r->icd9_inacbg){
			// 	$r->icd9_inacbg = $req['procedure1'];
			// }//JIKA ADA, IMPORT ULANG
			$r->save();
		}
		
		return response()->json(['sukses' => 1, 'no_sep' => $msg]);
	}
	
	public function inacbg_edit_klaim(Request $req) {
		// AFTER FINAL IDRG
		$request = '{
                    "metadata": {
                        "method":"reedit_claim"
                    },
                    "data": {
                        "nomor_sep":"' . $req['no_sep'] . '"
                    }
               }';
		$msg = $this->Request($request);
		
		if (@$msg['msg']['metadata']['message'] == "Ok") {
			$r = Inacbg::where('no_sep', $req['no_sep'])->first();
			$r->idrg_grouper = "6"; //SET FINAL IDRG
			$r->save();
		}
		
		return response()->json(['sukses' => 1, 'no_sep' => $msg]);
	}
	public function inacbg_edit_klaim_belum_dc(Request $req) {
		// AFTER FINAL IDRG
		$request = '{
                    "metadata": {
                        "method":"inacbg_grouper_reedit"
                    },
                    "data": {
                        "nomor_sep":"' . $req['no_sep'] . '"
                    }
               }';
		$msg = $this->Request($request);
		
		if (@$msg['msg']['metadata']['message'] == "Ok") {
			$r = Inacbg::where('no_sep', $req['no_sep'])->first();
			$r->idrg_grouper = "5"; //SET KE GROUPING INACBG
			// $r->icd10_inacbg = NULL; 
			// $r->icd9_inacbg = NULL; 
			$r->status_step = "grouping_inacbg"; //SET KE GROUPING INACBG
			$r->save();
		}
		
		return response()->json(['sukses' => 1, 'no_sep' => $msg]);
	}

	public function editClaim(Request $req) {
		$cek = Validator::make($req->all(), [
			'no_kartu' => 'required',
			'no_sep' => 'required',
			'diagnosa' => 'required',
			'procedure' => 'nullable',
		]);

		if ($cek->passes()) {
			$reg = Registrasi::where('id', $req['registrasi_id'])->first();
			$dataKlaim = $this->UpdateDataKlaim(
				$req['registrasi_id'],
				$req['no_sep'],
				$req['no_kartu'],
				$req['tgl_masuk'],
				$req['tgl_keluar'],
				$req['jenis_rawat'],
				$req['kelas_rawat'],
				$req['adl_sub_acute'],
				$req['adl_chronic'],
				$req['icu_indikator'],
				$req['icu_los'],
				$req['ventilator_hour'],
				$req['upgrade_class_ind'],
				$req['upgrade_class_class'],
				$req['upgrade_class_los'],
				$req['add_payment_pct'],
				$req['birth_weight'],
				$req['discharge_status'],
				$req['diagnosa'],
				$req['procedure'],
				$req['tarif_rs'],
				$req['tarif_poli_eks'],
				$req['nama_dokter'],
				$req['kode_tarif'],
				$req['payor_id'],
				$req['payor_cd'],
				$req['cob_cd'],
				$req['coder_nik']
			);
			//Input ICD
			// $this->inputPerawatanICD9($reg->id, $req['procedure']);
			// $this->inputPerawatanICD10($reg->id, $req['diagnosa']);

			return response()->json(['sukses' => 1, 'no_sep' => $req['no_sep']]);
		} else {
			return response()->json(['errors' => $cek->errors()]);
		}
	}
	function InacbgGrouperFinal($nomor_sep) {
		$request = '{
                    "metadata": {
                        "method":"inacbg_grouper_final"
                        
                    },
                    "data": {
                        "nomor_sep":"' . $nomor_sep . '"
                    }
               }';
		$msg = $this->Request($request);
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"inacbg_grouper_final");
	}
		public function finalKirimDC($no_sep, $coder_nik =NULL)
	{
		$final_inacb = $this->InacbgGrouperFinal($no_sep);
		$final_claim = $this->FinalisasiKlaim($no_sep, $coder_nik);

		$r = Inacbg::where('no_sep', $no_sep)->first();
		$r->idrg_grouper = "6"; //SET FINAL IDRG
		$r->final_klaim = 'Y';
		$r->save();
		Flashy::info('Berhasil Final Claim');
		return redirect()->back();
		// $kirimDC = $this->KirimKlaimIndividualKeDC($no_sep);
		// return response()->json(['sukses' => true, 'no_sep' => $no_sep]);
	}

	public function hapusKlaim($no_sep, $coder_nik)
	{
		$this->MenghapusKlaim($no_sep, $coder_nik);
		$inacbg = Inacbg::where('no_Sep', $no_sep)->first();
		if ($inacbg) {
			$inacbg->delete();
		}
		return response()->json(['proses'=>true]);
	}

	public function ambbilDataPerKlaim($sep = '') {
		return $this->MengambilDataDetailPerklaim($sep);
	}


	function getKey() {
		$keyRS = config('app.keyRS');
		return $keyRS;
	}

	function getUrlWS() {
		$UrlWS = config('app.url_eklaim_idrg');
		return $UrlWS;
	}

	function getKelasRS() {
		$kelasRS = config('app.tipe_RS');
		return $kelasRS;
	}

	function mc_encrypt($data, $strkey) {
		$key = hex2bin($strkey);
		if (mb_strlen($key, "8bit") !== 32) {
			throw new Exception("Needs a 256-bit key!");
		}

		$iv_size = openssl_cipher_iv_length("aes-256-cbc");
		$iv = openssl_random_pseudo_bytes($iv_size);
		$encrypted = openssl_encrypt($data, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);
		$signature = mb_substr(hash_hmac("sha256", $encrypted, $key, true), 0, 10, "8bit");
		$encoded = chunk_split(base64_encode($signature . $iv . $encrypted));
		return $encoded;
	}

	function mc_decrypt($str, $strkey) {
		$key = hex2bin($strkey);
		if (mb_strlen($key, "8bit") !== 32) {
			throw new Exception("Needs a 256-bit key!");
		}

		$iv_size = openssl_cipher_iv_length("aes-256-cbc");
		$decoded = base64_decode($str);
		$signature = mb_substr($decoded, 0, 10, "8bit");
		$iv = mb_substr($decoded, 10, $iv_size, "8bit");
		$encrypted = mb_substr($decoded, $iv_size + 10, NULL, "8bit");
		$calc_signature = mb_substr(hash_hmac("sha256", $encrypted, $key, true), 0, 10, "8bit");
		if (!$this->mc_compare($signature, $calc_signature)) {
			return "SIGNATURE_NOT_MATCH";
		}

		$decrypted = openssl_decrypt($encrypted, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);
		return $decrypted;
	}

	function mc_compare($a, $b) {
		if (strlen($a) !== strlen($b)) {
			return false;
		}

		$result = 0;

		for ($i = 0; $i < strlen($a); $i++) {
			$result |= ord($a[$i]) ^ ord($b[$i]);
		}

		return $result == 0;
	}

	function BuatKlaimBaru($nomor_kartu, $nomor_sep, $nomor_rm, $nama_pasien, $tgl_lahir, $gender) {
		$request = '{
                          "metadata":{
                              "method":"new_claim"
                          },
                          "data":{
                              "nomor_kartu":"' . $nomor_kartu . '",
                              "nomor_sep":"' . $nomor_sep . '",
                              "nomor_rm":"' . $nomor_rm . '",
                              "nama_pasien":"' . $nama_pasien . '",
                              "tgl_lahir":"' . $tgl_lahir . '",
                              "gender":"' . $gender . '"
                          }
                      }';
		$msg = $this->Request($request);
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"new_claim");
	}

	function UpdateDataPasien($nomor_rmlama, $nomor_kartu, $nomor_rm, $nama_pasien, $tgl_lahir, $gender) {
		$request = '{
                  "metadata": {
                      "method": "update_patient",
                      "nomor_rm": "' . $nomor_rmlama . '"
                  },
                  "data": {
                      "nomor_kartu": "' . $nomor_kartu . '",
                      "nomor_rm": "' . $nomor_rm . '",
                      "nama_pasien": "' . $nama_pasien . '",
                      "tgl_lahir": "' . $tgl_lahir . '",
                      "gender": "' . $gender . '"
                  }
             }';
		$msg = $this->Request($request);
		echo $msg['metadata']['message'] . "";
	}

	function HapusDataPasien($nomor_rm, $coder_nik) {
		$request = '{
                      "metadata": {
                          "method": "delete_patient"
                      },
                      "data": {
                          "nomor_rm": "' . $nomor_rm . '",
                          "coder_nik": "' . $coder_nik . '"
                      }
                 }';
		$msg = $this->Request($request);
		echo $msg['metadata']['message'] . "";
	}

	function UpdateDataKlaim($registrasi_id,$req) {

		$prosedur_non_bedah = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 1)->sum('folios.total');
		$tenaga_ahli = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 2)->sum('folios.total');
		$radiologi = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 3)->sum('folios.total');
		$rehabilitasi = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 4)->sum('folios.total');
		$obat = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 5)->sum('folios.total');
		
		$sewa_alat = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 6)->sum('folios.total');
		$prosedur_bedah = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 7)->sum('folios.total');
		$keperawatan = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 8)->sum('folios.total');
		$laboratorium = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 9)->sum('folios.total');
		$kamar = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 10)->sum('folios.total');
		
		$alkes = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 11)->sum('folios.total');
		$konsultasi = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 12)->sum('folios.total');
		$penunjang = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 13)->sum('folios.total');
		$pelayanan_darah = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 14)->sum('folios.total');
		$rawat_intensif = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 15)->sum('folios.total');
		$bmhp = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 16)->sum('folios.total');
		
		$obat_kronis = Folio::where('folios.registrasi_id', $registrasi_id)->where('user_id', 610)->sum('total'); //ID  USER RIRI YANG INPUT OBAT KRONIS
		if($obat_kronis > 0){
		$obat =  Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 5)->sum('folios.total')-$obat_kronis;
		}else{
		$obat =  Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 5)->sum('folios.total');
		}
		// $obat_kronis = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 17)->sum('folios.total');
		$obat_kemoterapi = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 18)->sum('folios.total');

		$data = [
        "metadata" => [
            "method"     => "set_claim_data",
            "nomor_sep"  => $req['no_sep'] ?? null,
        ],
        "data" => [
            "nomor_sep"        => $req['no_sep'] ?? null,
            "nomor_kartu"      => $req['no_kartu'] ?? null,
            "tgl_masuk"        => $req['tgl_masuk'] ?? null,
            "tgl_pulang"       => $req['tgl_keluar'] ?? null,
            "jenis_rawat"      => $req['jenis_rawat'] ?? null,
            "kelas_rawat"      => $req['kelas_rawat'] ?? null,
            "adl_sub_acute"    => $req['adl_sub_acute'] ?? null,
            "adl_chronic"      => $req['adl_chronic'] ?? null,
            "icu_indikator"    => $req['icu_indikator'] ?? null,
            "icu_los"          => $req['icu_los'] ?? null,
            "ventilator_hour"  => $req['ventilator_hour'] ?? null,
            "upgrade_class_ind"    => $req['upgrade_class_ind'] ?? null,
            "upgrade_class_class"  => $req['upgrade_class_class'] ?? null,
            "upgrade_class_los"    => $req['upgrade_class_los'] ?? null,
            "add_payment_pct"      => $req['add_payment_pct'] ?? null,
            "birth_weight"         => $req['birth_weight'] ?? null,
            "discharge_status"     => $req['discharge_status'] ?? null,
			// new
			"cara_masuk"              => $req['cara_masuk'] ?? "gp",
			"sistole"                 => $req['sistole'] ?? null,
			"diastole"                => $req['diastole'] ?? null,
			"pemulasaraan_jenazah"    => $req['pemulasaraan_jenazah'] ?? null,
			"kantong_jenazah"         => $req['kantong_jenazah'] ?? null,
			"peti_jenazah"            => $req['peti_jenazah'] ?? null,
			"plastik_erat"            => $req['plastik_erat'] ?? null,
			"desinfektan_jenazah"     => $req['desinfektan_jenazah'] ?? null,
			"mobil_jenazah"           => $req['mobil_jenazah'] ?? null,
			"desinfektan_mobil_jenazah" => $req['desinfektan_mobil_jenazah'] ?? null,
			"covid19_status_cd"       => $req['covid19_status_cd'] ?? null,
			"nomor_kartu_t"           => $req['nomor_kartu_t'] ?? null,
			"episodes"                => $req['episodes'] ?? null,
			"akses_naat"              => $req['akses_naat'] ?? null,
			"isoman_ind"              => $req['isoman_ind'] ?? null,
			"bayi_lahir_status_cd"    => $req['bayi_lahir_status_cd'] ?? null,
			"dializer_single_use"     => $req['dializer_single_use'] ?? null,
			"kantong_darah"           => $req['kantong_darah'] ?? null,
			"alteplase_ind"           => $req['alteplase_ind'] ?? null,
			// "diagnosa"           	  => $req['diagnosa'] ?? null,
			// "procedure"           	  => $req['procedure'] ?? null,
			// "diagnosa_inagrouper"     => $req['diagnosa'] ?? null,
			// "procedure_inagrouper"    => $req['procedure'] ?? null,
			// endnew
            "tarif_rs" => [
				"prosedur_non_bedah" => $prosedur_non_bedah,
				"prosedur_bedah"     => $prosedur_bedah,
				"konsultasi"         => $konsultasi,
				"tenaga_ahli"        => $tenaga_ahli,
				"keperawatan"        => $keperawatan,
				"penunjang"          => $penunjang,
				"radiologi"          => $radiologi,
				"laboratorium"       => $laboratorium,
				"pelayanan_darah"    => $pelayanan_darah,
				"rehabilitasi"       => $rehabilitasi,
				"kamar"              => $kamar,
				"rawat_intensif"     => $rawat_intensif,
				"obat"               => $obat,
				"obat_kronis"        => $obat_kronis,
				"obat_kemoterapi"    => $obat_kemoterapi,
				"alkes"              => $alkes,
				"bmhp"               => $bmhp,
				"sewa_alat"          => $sewa_alat,
			],
            "tarif_poli_eks" => $req['tarif_poli_eks'] ?? null,
            "nama_dokter"    => $req['nama_dokter'] ?? null,
            "kode_tarif"     => $req['kode_tarif'] ?? null,
            "payor_id"       => $req['payor_id'] ?? null,
            "payor_cd"       => $req['payor_cd'] ?? null,
            "cob_cd"         => $req['cob_cd'] ?? null,
            "coder_nik"      => $req['coder_nik'] ?? null,
        ]
    ];

    $request = json_encode($data, JSON_UNESCAPED_SLASHES);
    $msg = $this->Request($request);
	log_inacbg(@$req['no_sep'],@$request,@json_encode($msg),"set_claim_data");
	
	}

	function UpdateDataProsedur($nomor_sep, $procedure, $coder_nik) {
		$request = '{
                  "metadata": {
                      "method": "set_claim_data",
                      "nomor_sep": "' . $nomor_sep . '",
                  },
                  "data": {
                      "procedure": "' . $procedure . '",
                      "coder_nik": "' . $coder_nik . '"
                  }
             }';
		$msg = $this->Request($request);
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"set_claim_data");
	}

	function HapusSemuaProsedur($nomor_sep, $coder_nik) {
		$request = '{
                  "metadata": {
                      "method": "set_claim_data",
                      "nomor_sep": "' . $nomor_sep . '",
                  },
                      "data": {
                      "procedure": "#",
                      "coder_nik": "' . $coder_nik . '"
                  }
             }';
		$msg = $this->Request($request);
	}

	function GroupingStage1($nomor_sep, $coder_nik) {
		$request = '{
                    "metadata": {
                        "method":"grouper",
                        "stage":"1",
						"grouper": "inacbg"
                    },
                    "data": {
                        "nomor_sep":"' . $nomor_sep . '"
                    }
               }';
		$msg = $this->Request($request);
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"grouper");
		// dd($msg);
		// $msg = $msg['msg'];
		// AKTIFKAN IDRG
		
		return $msg;
		

	}
	function GroupingStage2(Request $req) {
	$specialCmg = '';

	if ($req->has('special_cmg')) {
		$specialCmg = collect($req->input('special_cmg'))
			->filter(function ($val) {
				return !empty($val);
			})
			->implode('#');
	}

	$data['special_cmg'] = $specialCmg;

	
		$request = '{
                    "metadata": {
                        "method":"grouper",
                        "stage":"2",
						"grouper": "inacbg"

                    },
                    "data": {
                        "nomor_sep":"' . $req['no_sep'] . '",
                        "special_cmg": "' . $data['special_cmg'] . '"
                    }
               }';
		
		$msg = $this->Request($request);
		
		@$message = @$msg['msg']['metadata']['message'] ?? '';
		@$description = @$msg['msg']['response_inacbg']['cbg']['description'] ?? '';
		log_inacbg(@$req['no_sep'],@$request,@json_encode($msg),"grouper2");
		if($message == 'Ok' && stripos($description, 'GAGAL:') !== 0){
			// $stage2 = $this->GroupingStage2($req['no_sep'], NULL);
			$r = Inacbg::where('no_sep', $req['no_sep'])->first();
			$r->dijamin = @$msg['msg']['response_inacbg']['base_tariff'];
			$r->topup = @$msg['msg']['response_inacbg']['tariff'];
			$r->kode = @$msg['msg']['response_inacbg']['cbg']['code'];
			$r->deskripsi_grouper = @$msg['msg']['response_inacbg']['cbg']['description'];
			$r->versi_eklaim = @$msg['msg']['response_inacbg']['inacbg_version'];
			$r->who_update = Auth::user()->name;
			$r->icd10_inacbg = $req['diagnosa_inacbg']; 
			$r->icd9_inacbg = $req['procedure_inacbg']; 
			$r->special_cmg = $data['special_cmg'];
			$r->los = 1;
			$r->grouping_stage2 = @json_encode($msg);
			$r->status_step = 'final_claim';
			$r->final_klaim = 'Y';
			$r->kirim_dc = 'N';
			$r->final_idrg = "1";
			$r->save();

			return response()->json(['sukses' => 1, 'no_sep' => $req['no_sep'],'last_bridging' =>true]);
		}
		return $msg;
	}
	
	function GroupingIDRGStage1($nomor_sep) {
		$request = '{
                    "metadata": {
                        "method":"grouper",
                        "stage":"1",
						"grouper": "idrg"
                    },
                    "data": {
                        "nomor_sep":"' . $nomor_sep . '"
                    }
               }';
		$msg = $this->Request($request);
		if (@$msg['msg']['metadata']['message'] == "Ok" && @$msg['msg']['response_idrg']['mdc_description'] !==  'Ungroupable or Unrelated') {
			$r = Inacbg::where('no_sep', $nomor_sep)->first();
			$r->idrg_grouper = "1";
			$r->status_step = "final_idrg"; //SET GO TO FINAL
			$r->save();
		}
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"grouper1-idrg");
		return $msg;

	}

	function idrg_grouper_reedit(Request $req) {
		$request = '{
                    "metadata": {
                        "method":"idrg_grouper_reedit"
                    },
                    "data": {
                        "nomor_sep":"' . $req['no_sep'] . '"
                    }
               }';
		$msg = $this->Request($request);
		if (@$msg['msg']['metadata']['message'] == "Ok") {
			$r = Inacbg::where('no_sep', $req['no_sep'])->first();
			$r->idrg_grouper = "1";
			$r->status_step = ""; //BACK TO GROUPING IDRG
			$r->icd10_inacbg = NULL; 
			$r->icd9_inacbg = NULL; 
			$r->save();
		}
		log_inacbg(@$req['no_sep'],@$request,@json_encode($msg),"grouper1-idrg");
		return $msg;

	}
	
	function IDRGFinal($nomor_sep) {
		$request = '{
                    "metadata": {
                        "method":"idrg_grouper_final"
                    },
                    "data": {
                        "nomor_sep":"' . $nomor_sep . '"
                    }
               }';
		$msg = $this->Request($request);
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"idrg_grouper_final");
		return $msg;
	}
	
	function IDRGImportINACBG($nomor_sep) {
		$request = '{
                    "metadata": {
                        "method":"idrg_to_inacbg_import"
                    },
                    "data": {
                        "nomor_sep":"' . $nomor_sep . '"
                    }
               }';
		$msg = $this->Request($request);
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"idrg_to_inacbg_import");
		return  $msg;
	}
	function InacbgProcedureSet($nomor_sep, $procedure) {
		$request = '{
                    "metadata": {
                        "method":"inacbg_procedure_set",
                        "nomor_sep":"' . $nomor_sep . '"
                    },
                    "data": {
                        
                        "procedure": "' . $procedure . '"
                    }
               }';
		$msg = $this->Request($request);
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"inacbg_procedure_set");
	}
	function InacbgDiagnosaSet($nomor_sep, $diagnosa) {
		$request = '{
                    "metadata": {
                        "method":"inacbg_diagnosa_set",
                        "nomor_sep":"' . $nomor_sep . '"
                    },
                    "data": {
                        
                        "diagnosa": "' . $diagnosa . '"
                    }
               }';
		$msg = $this->Request($request);
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"inacbg_diagnosa_set");
	}

	
	function IdrgProcedureSet($nomor_sep, $procedure) {
		$request = '{
                    "metadata": {
                        "method":"idrg_procedure_set",
                        "nomor_sep":"' . $nomor_sep . '"
                    },
                    "data": {
                        
                        "procedure": "' . $procedure . '"
                    }
               }';
		$msg = $this->Request($request);
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"idrg_procedure_set");
	}
	function IdrgProcedureGet($nomor_sep, $procedure) {
		$request = '{
                    "metadata": {
                        "method":"idrg_procedure_get"
						},
					"data": {
						"nomor_sep":"' . $nomor_sep . '"
                    }
               }';
		$msg = $this->Request($request);
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"idrg_procedure_get");
	}
	function IdrgDiagnosaSet($nomor_sep, $diagnosa) {
		$request = '{
                    "metadata": {
                        "method":"idrg_diagnosa_set",
                        "nomor_sep":"' . $nomor_sep . '"
                    },
                    "data": {
                        
                        "diagnosa": "' . $diagnosa . '"
                    }
               }';
		$msg = $this->Request($request);
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"idrg_diagnosa_set");
	}
	function IdrgDiagnosaGet($nomor_sep, $diagnosa) {
		$request = '{
                    "metadata": {
                        "method":"idrg_diagnosa_get"
						},
					"data": {		
						"nomor_sep":"' . $nomor_sep . '"
                    }
               }';
		$msg = $this->Request($request);
	}

	function FinalisasiKlaim($nomor_sep, $coder_nik)
	{
		$request = '{
                          "metadata": {
                              "method":"claim_final"
                          },
                          "data": {
                              "nomor_sep":"' . $nomor_sep . '",
                              "coder_nik": "' .config('app.coder_nik'). '"
                          }
                     }';
		$msg = $this->Request($request);
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"claim_final");
		if ($msg['msg']['metadata']['message'] == "Ok") {
			$r = Inacbg::where('no_sep', $nomor_sep)->first();
			$r->final_klaim = 'Y';
			$r->status_step = 'done';
			$r->update();
		}
	}

	function EditUlangKlaim(Request $request) {
		$nomor_sep = $request['no_sep'];
		$request = '{
                          "metadata": {
                              "method":"reedit_claim"
                          },
                          "data": {
                              "nomor_sep":"' . $nomor_sep . '"
                          }
                     }';
		$msg = $this->Request($request);
		if (@$msg['msg']['metadata']['message'] == "Ok") {
			$r = Inacbg::where('no_sep', $nomor_sep)->first();
			$r->status_step = "final_claim"; //SET GO TO FINAL
			$r->final_klaim = "N"; //SET N
			$r->save();
		}
		log_inacbg(@$nomor_sep,@$request,@json_encode($msg),"reedit_claim");
		return $msg;
	}

	function KirimKlaimPeriodeKeDC($start_dt, $stop_dt, $jenis_rawat) {
		$request = '{
                    "metadata": {
                        "method":"send_claim"
                    },
                    "data": {
                        "start_dt":"' . $start_dt . '",
                        "stop_dt":"' . $stop_dt . '",
                        "jenis_rawat":"' . $jenis_rawat . '"
                    }
               }';
		$msg = $this->Request($request);
	}

	function KirimKlaimIndividualKeDC($nomor_sep) {
		$request = '{
                          "metadata": {
                              "method":"send_claim_individual"
                          },
                          "data": {
                              "nomor_sep":"' . $nomor_sep . '"
                          }
                     }';
		$msg = $this->Request($request);
		if ($msg['metadata']['message'] == "Ok") {
			$r = Inacbg::where('no_sep', $nomor_sep)->first();
			$r->kirim_dc = 'Y';
			$r->update();
		}

	}

	function MenarikDataKlaimPeriode($start_dt, $stop_dt, $jenis_rawat) {
		$request = '{
                    "metadata": {
                        "method":"pull_claim"
                    },
                    "data": {
                        "start_dt":"' . $start_dt . '",
                        "stop_dt":"' . $stop_dt . '",
                        "jenis_rawat":"' . $jenis_rawat . '"
                    }
               }';
		$msg = $this->Request($request);
	}

	function MengambilDataDetailPerklaim($nomor_sep) {
		$request = '{
                          "metadata": {
                              "method":"get_claim_data"
                          },
                          "data": {
                              "nomor_sep":"' . $nomor_sep . '"
                          }
                     }';
		$msg = $this->Request($request);
		echo $msg['metadata']['message'] . "";
	}

	function MengambilSetatusPerklaim($nomor_sep) {
		$request = '{
                          "metadata": {
                              "method":"get_claim_status"
                          },
                          "data": {
                              "nomor_sep":"' . $nomor_sep . '"
                          }
                     }';
		$msg = $this->Request($request);
		echo $msg['metadata']['message'] . "";
	}

	function MenghapusKlaim($nomor_sep, $coder_nik) {
		$request = '{
                          "metadata": {
                              "method":"delete_claim"
                          },
                          "data": {
                              "nomor_sep":"' . $nomor_sep . '",
                              "coder_nik":"' . $coder_nik . '"
                          }
                    }';
		$msg = $this->Request($request);
		// echo $msg['metadata']['message'] . "";
	}

	// function CetakKlaim($nomor_sep) {
	// 	$request = '{
    //                       "metadata": {
    //                           "method": "claim_print"
    //                       },
    //                       "data": {
    //                           "nomor_sep": "' . $nomor_sep . '"
    //                       }
    //                  }';
	// 	$msg = $this->Request($request);
	// 	echo $msg['metadata']['message'] . "";
	// }
	function CetakKlaim($nomor_sep) {
		$request = '{
                          "metadata": {
                              "method": "claim_print"
                          },
                          "data": {
                              "nomor_sep": "' . $nomor_sep . '"
                          }
                     }';
		$response = $this->Request($request);

		if ($response['status']) {
			$msg = $response['msg'];
			$data= $msg['data']. "";
			$decoded = base64_decode($data);
			$file = $nomor_sep.'.pdf';
			file_put_contents($file, $decoded);
	
	
			if (file_exists($file)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.basename($file).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				readfile($file);
				exit;
			}
			return Redirect::back();
		} else {
			Flashy::error('Server INACBG Sedang tidak dapat diakses');
			return redirect()->to('frontoffice/antrian-realtime');
		}
	}

	function Request($request) {
		$json = $this->mc_encrypt($request, $this->getKey());
		$header = array("Content-Type: application/x-www-form-urlencoded");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->getUrlWS());
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		$response = curl_exec($ch);
		if ($response) {
			$status = true;
			$first = strpos($response, "\n") + 1;
			$last = strrpos($response, "\n") - 1;
			$hasilresponse = substr($response, $first, strlen($response) - $first - $last);
			$hasildecrypt = $this->mc_decrypt($hasilresponse, $this->getKey());
			$msg = json_decode($hasildecrypt, true);
			return [
				"msg" => $msg,
				"status" => $status,
			];
		} else {
			$status = false;
			return [
				"msg" => null,
				"status" => $status,
			];
		}
		//echo json_encode($msg);
	}

	//============ RESPONSE BRIDGING =======================================
	public static function getResponse($no_sep) {
		$resp = Inacbg::where('no_sep', $no_sep)
			->select('no_sep', 'total_rs', 'dijamin', 'kode', 'final_klaim', 'kirim_dc', 'deskripsi_grouper', 'who_update', 'registrasi_id')
			->first();
		return response()->json($resp);
	}

	public static function detailBridging($registrasi_id) {
		$inacbg = Inacbg::where('registrasi_id', $registrasi_id)->first();
		$registrasi = Registrasi::find($registrasi_id);
		return view('bridging.detailBridging', compact('inacbg', 'registrasi'));
	}

	public static function cetakBiayaPerawatan($registrasi_id) {
		$reg = Registrasi::find($registrasi_id);
		$folio = Folio::where('registrasi_id', $registrasi_id)->get();
		$jml = Folio::where('registrasi_id', $registrasi_id)->sum('total');
		$no = 1;
		$pdf = PDF::loadView('bridging.rincianBiayaJKN', compact('reg', 'folio', 'jml', 'no'));
		return $pdf->stream();
	}

	public static function cetakDetailEklaim($registrasi_id)
	{
		$reg = Registrasi::find($registrasi_id);
		$folio = Folio::where('registrasi_id', $registrasi_id)->get();
		$mapping = Mastermapping::all();
		$jml = Folio::where('registrasi_id', $registrasi_id)->sum('total');
		$no = 1;
		$pdf = PDF::loadView('bridging.detailRincianBiayaEklaim', compact('reg', 'folio', 'jml', 'no', 'mapping'));
		return $pdf->stream();
	}

	public function inputPerawatanICD9($registrasi_id, $dataicd9)
	{
		$reg = \Modules\Registrasi\Entities\Registrasi::find($registrasi_id);
		if (substr($reg->status_reg, 0, 1) == 'I') {
			$jenis = 'TI';
		} elseif (substr($reg->status_reg, 0, 1) == 'J') {
			$jenis = 'TA';
		} elseif (substr($reg->status_reg, 0, 1) == 'G') {
			$jenis = 'TG';
		}
		@$delete = \App\JknIcd9::where('registrasi_id',$registrasi_id)->delete();
		$prosedur = explode('#', $dataicd9);
		for ($i = 0; $i < count($prosedur); $i++) {
			$proc = new \App\JknIcd9();
			$proc->icd9 = $prosedur[$i];
			$proc->registrasi_id = $reg->id;
			$proc->carabayar_id = $reg->bayar;
			$proc->jenis = $jenis;
			$proc->save();
		}
	}

	public function inputPerawatanICD10($registrasi_id, $dataicd10)
	{
		$reg = \Modules\Registrasi\Entities\Registrasi::find($registrasi_id);
		if (substr($reg->status_reg, 0, 1) == 'I') {
			$jenis = 'TI';
		} elseif (substr($reg->status_reg, 0, 1) == 'J') {
			$jenis = 'TA';
		} elseif (substr($reg->status_reg, 0, 1) == 'G') {
			$jenis = 'TG';
		}
		$diagnosa = explode('#', $dataicd10);
		@$delete = \App\JknIcd10::where('registrasi_id',$registrasi_id)->delete();
		for ($i = 0; $i < count($diagnosa); $i++) {
			$diag = new \App\JknIcd10();
			$diag->icd10 = $diagnosa[$i];
			$diag->registrasi_id = $reg->id;
			$diag->carabayar_id = $reg->bayar;
			$diag->jenis = $jenis;
			$diag->save();
		}
	}

	// INPUT IDRG
	public function inputPerawatanICD9IDRG($registrasi_id, $dataicd9)
	{
		$reg = \Modules\Registrasi\Entities\Registrasi::find($registrasi_id);
		if (substr($reg->status_reg, 0, 1) == 'I') {
			$jenis = 'TI';
		} elseif (substr($reg->status_reg, 0, 1) == 'J') {
			$jenis = 'TA';
		} elseif (substr($reg->status_reg, 0, 1) == 'G') {
			$jenis = 'TG';
		}
		@$delete = \App\PerawatanIcd9Idrg::where('registrasi_id',$registrasi_id)->delete();
		$prosedur = explode('#', $dataicd9);
		for ($i = 0; $i < count($prosedur); $i++) {
			$proc = new \App\PerawatanIcd9Idrg();
			$proc->icd9 = $prosedur[$i];
			$proc->registrasi_id = $reg->id;
			$proc->carabayar_id = $reg->bayar;
			$proc->jenis = $jenis;
			$proc->save();
		}
	}

	public function inputPerawatanICD10IDRG($registrasi_id, $dataicd10)
	{
		$reg = \Modules\Registrasi\Entities\Registrasi::find($registrasi_id);
		if (substr($reg->status_reg, 0, 1) == 'I') {
			$jenis = 'TI';
		} elseif (substr($reg->status_reg, 0, 1) == 'J') {
			$jenis = 'TA';
		} elseif (substr($reg->status_reg, 0, 1) == 'G') {
			$jenis = 'TG';
		}
		$diagnosa = explode('#', $dataicd10);
		@$delete = \App\PerawatanIcd10Idrg::where('registrasi_id',$registrasi_id)->delete();
		for ($i = 0; $i < count($diagnosa); $i++) {
			$diag = new \App\PerawatanIcd10Idrg();
			$diag->icd10 = $diagnosa[$i];
			$diag->registrasi_id = $reg->id;
			$diag->carabayar_id = $reg->bayar;
			$diag->jenis = $jenis;
			$diag->save();
		}
	}

	public function getDataKlaim($registrasi_id)
	{
		return Inacbg::where('registrasi_id', $registrasi_id)->first();
	}

	public function statusInaCGB($registrasi_id)
	{
		return Inacbg::where('registrasi_id', $registrasi_id)
		->select('id', 'pasien_nama', 'pasien_tgllahir', 'no_kartu', 'no_sep', 'kelas_perawatan', 'dokter', 'total_rs', 'no_rm', 'icd1', 'prosedur1', 'alamat', 'dijamin', 'kode', 'final_klaim', 'who_update', 'tgl_masuk', 'tgl_keluar', 'deskripsi_grouper')
		->get();
	}

	public function deleteInacbg($id)
	{
		$in = Inacbg::find($id);
		session(['registrasi_id' => $in->registrasi_id]);
		$in->delete();
		if ($in) {
			return response()->json(['sukses'=>true]);
		}
	}

	public function lap_Eklaim_bytanggal(Request $request) {
			request()->validate(['jenis_rawat' => 'required', 'tga' => 'required', 'tgb' => 'required']);
			// $inacbg = Registrasi::leftJoin('inacbgs', 'registrasis.id', '=', 'inacbgs.registrasi_id')
			// 	->whereBetween('registrasis.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
			// 	->where('registrasis.bayar', 1)
			// 	->where('registrasis.status_reg', 'LIKE', $request['jenis_rawat'] . '%')
			// 	->select('registrasis.id as registrasi_id', 'registrasis.pasien_id', 'registrasis.status_reg', 'registrasis.poli_id', 'registrasis.no_sep', 'inacbgs.dijamin', 'inacbgs.total_rs', 'inacbgs.kode')
			// 	->get();
			$inacbg = HistoriRawatInap::leftJoin('registrasis', 'registrasis.id', '=', 'histori_rawatinap.registrasi_id')
				->leftJoin('inacbgs', 'registrasis.id', '=', 'inacbgs.registrasi_id')
				->whereBetween('registrasis.created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
				->where('registrasis.bayar', 1)
				->where('registrasis.status_reg', 'LIKE', $request['jenis_rawat'] . '%')
				->select('registrasis.id as registrasi_id', 'registrasis.pasien_id', 'registrasis.status_reg', 'registrasis.poli_id', 'registrasis.no_sep', 'inacbgs.dijamin', 'inacbgs.total_rs', 'inacbgs.kode')
				->get();
			if ($request['view']) {
				return view('bridging/laporanEklaim', compact('inacbg'))->with('no', 1);
			} elseif ($request['excel']) {
				Excel::create('Laporan Bridging Eklaim', function ($excel) use ($inacbg) {
					// Set the properties
					$excel->setTitle('Laporan Bridging Eklaim')
						->setCreator('Digihealth')
						->setCompany('Digihealth')
						->setDescription('Laporan Bridging Eklaim');
					$excel->sheet('Laporan Bridging Eklaim', function ($sheet) use ($inacbg) {
						$row = 1;
						$no = 1;
						$sheet->row($row, [
							'No',
							'Nama',
							'No RM',
							'Nomor SEP',
							'Tarif RS',
							'Tarif Grouper',
						]);
						foreach ($inacbg as $key => $d) {
							$pasien = \Modules\Pasien\Entities\Pasien::find($d->pasien_id);
							if ($pasien) {
								$sheet->row(++$row, [
									$no++,
									$pasien->nama,
									$pasien->no_rm,
									$d->no_sep,
									$d->total_rs,
									$d->dijamin,
								]);
							}
						};
					});

				})->export('xlsx');
			}
	}


	public function lihatEklaimIRJIGD(Request $request)
	{
		request()->validate(['tga' => 'required', 'tgb' => 'required']);

		// return $request->all(); die;

		$tga		= valid_date($request['tga']) . ' 00:00:00';
		$tgb		= valid_date($request['tgb']) . ' 23:59:59';
		$data['rekammedis'] = Inacbg::leftjoin('registrasis','inacbgs.registrasi_id','=','registrasis.id')
		->whereBetween('registrasis.created_at', [$tga, $tgb])
		->where('inacbgs.dijamin','!=',NULL)
		->where('registrasis.bayar', 1)
		->whereIn('registrasis.status_reg', ['J1','J2','J3','G1','G2','G3'])
		->select('inacbgs.*','registrasis.pasien_id as pasien_id', 'registrasis.status_reg as status_reg','registrasis.dokter_id as dokter_id', 'registrasis.bayar as bayar','registrasis.created_at as tgl_regis','registrasis.updated_at as tgl_pulang')
		->get();
		// return $data; die;
		return view('bridging/lihat-eklaim-irj-igd', $data)->with('no', 1);
	}
	public function lihatEklaimIRNA(Request $request) {
		request()->validate(['tga' => 'required', 'tgb' => 'required']);

		$tga		= valid_date($request['tga']) . ' 00:00:00';
		$tgb		= valid_date($request['tgb']) . ' 23:59:59';
		$data['rekammedis'] = Inacbg::leftjoin('registrasis','inacbgs.registrasi_id','=','registrasis.id')
			->leftjoin('rawatinaps','rawatinaps.registrasi_id','=','inacbgs.registrasi_id')
			->whereBetween('rawatinaps.tgl_keluar', [$tga, $tgb])
			->where('inacbgs.dijamin','!=',NULL)
			->where('registrasis.bayar', 1)
			->whereIn('registrasis.status_reg',['I1','I2','I3'])
			->select('inacbgs.*','registrasis.pasien_id as pasien_id', 'registrasis.status_reg as status_reg','rawatinaps.dokter_id as dokter_id', 'registrasis.bayar as bayar','rawatinaps.tgl_masuk as tgl_masuk','rawatinaps.tgl_keluar as tgl_keluar')
			->get();
		// return $data; die;
		return view('bridging/lihat-eklaim-irna', $data)->with('no', 1);
	}

	public function hapusInacbgIRJIGD($id)
	{
		Inacbg::find($id)->delete();
		Flashy::success('Data INACBG berhasil dihapus dari SIMRS');
		return redirect('inacbg/lihat-eklaim-irj-igd');
	}
	public function hapusInacbgIRNA($id)
	{	
		Inacbg::find($id)->delete();
		Flashy::success('Data INACBG berhasil dihapus dari SIMRS');
		return redirect('inacbg/lihat-eklaim-irna');
	}

}
