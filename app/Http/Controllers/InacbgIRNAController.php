<?php

namespace App\Http\Controllers;

use App\Inacbg;
use Auth;
use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;
use PDF;
use Validator;

class InacbgIRNAController extends Controller
{
	public function new_claim(Request $req)
	{
		// return $req->all(); die;
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

			$in = new Inacbg();
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
			$in->no_hp = $reg->pasien->nohp;
			$in->poli_id = $reg->poli_id;
			$in->registrasi_id = $reg->id;
			$in->dijamin = null;
			$in->kode = null;
			$in->urun_bayar_rupiah = $req['urun_bayar_rupiah'];
			$in->urun_bayar_persen = $req['urun_bayar_persen'];
			$in->tgl_masuk = $reg->created_at;
			$in->tgl_keluar = $reg->updated_at;
			$in->save();

			$newClaim = $this->BuatKlaimBaru(
				$req['no_kartu'],
				$req['no_sep'],
				$req['no_rm'],
				$req['nama'],
				$req['tgllahir'] . ' 00:00:00',
				$req['gender']
			);
			$dataKlaim = $this->UpdateDataKlaim(
				$req['registrasi_id'],
				$req['no_sep'],
				$req['no_kartu'],
				$req['tgl_masuk'],
				$req['tgl_pulang'],
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
			$grouper = $this->GroupingStage1($req['no_sep'], $req['coder_nik']);
			$stage2 = $this->GroupingStage2($req['no_sep'], NULL);
			// $final = $this->FinalisasiKlaim($req['no_sep'], $req['coder_nik']);
			// $kirimDC = $this->KirimKlaimIndividualKeDC($req['no_sep']); //KIRIM DC LANGSUNG

			//Input ICD
			// $this->inputPerawatanICD9($reg->id, $req['procedure']);
			// $this->inputPerawatanICD10($reg->id, $req['diagnosa']);

			return response()->json(['sukses' => true, 'no_sep' => $req['no_sep']]);
		} else {
			return response()->json(['errors' => $cek->errors()]);
		}
	}

	public function editClaim(Request $req)
	{
		$cek = Validator::make($req->all(), [
			'no_kartu' => 'required',
			'no_sep' => 'required',
			'diagnosa' => 'required',
			'procedure' => 'nullable',
		]);

		if ($cek->passes()) {
			$reg = Registrasi::where('id', $req['registrasi_id'])->first();

			$in = Inacbg::where('registrasi_id', $req['registrasi_id'])->first();
			$in->icd1 = $req['diagnosa'];
			$in->prosedur1 = $req['procedure'];
			$in->urun_bayar_rupiah = $req['urun_bayar_rupiah'];
			$in->urun_bayar_persen = $req['urun_bayar_persen'];
			$in->update();

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

	public function hapusKlaim($no_sep, $coder_nik)
	{
		$this->MenghapusKlaim($no_sep, $coder_nik);
		$inacbg = Inacbg::where('no_Sep', $no_sep)->first();
		if ($inacbg) {
			$inacbg->delete();
		}
		return response()->json(['proses' => true]);
	}


	public function finalKirimDC($no_sep, $coder_nik)
	{
		$final = $this->FinalisasiKlaim($no_sep, $coder_nik);
		$kirimDC = $this->KirimKlaimIndividualKeDC($no_sep);
		return response()->json(['sukses' => true, 'no_sep' => $no_sep]);
	}

	public function ambbilDataPerKlaim($sep = '')
	{
		return $this->MengambilDataDetailPerklaim($sep);
	}

	//==============================================================================================================================

	function getKey()
	{
		$keyRS = config('app.keyRS');
		return $keyRS;
	}

	function getUrlWS()
	{
		$UrlWS = config('app.url_eklaim');
		return $UrlWS;
	}

	function getKelasRS()
	{
		$kelasRS = config('app.tipe_RS');
		return $kelasRS;
	}

	function mc_encrypt($data, $strkey)
	{
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

	function mc_decrypt($str, $strkey)
	{
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

	function mc_compare($a, $b)
	{
		if (strlen($a) !== strlen($b)) {
			return false;
		}

		$result = 0;

		for ($i = 0; $i < strlen($a); $i++) {
			$result |= ord($a[$i]) ^ ord($b[$i]);
		}

		return $result == 0;
	}

	function BuatKlaimBaru($nomor_kartu, $nomor_sep, $nomor_rm, $nama_pasien, $tgl_lahir, $gender)
	{
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
	}

	function UpdateDataPasien($nomor_rmlama, $nomor_kartu, $nomor_rm, $nama_pasien, $tgl_lahir, $gender)
	{
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
	}

	function HapusDataPasien($nomor_rm, $coder_nik)
	{
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
	}

	function UpdateDataKlaim(
		$registrasi_id,
		$nomor_sep,
		$nomor_kartu,
		$tgl_masuk,
		$tgl_pulang,
		$jenis_rawat,
		$kelas_rawat,
		$adl_sub_acute,
		$adl_chronic,
		$icu_indikator,
		$icu_los,
		$ventilator_hour,
		$upgrade_class_ind,
		$upgrade_class_class,
		$upgrade_class_los,
		$add_payment_pct,
		$birth_weight,
		$discharge_status,
		$diagnosa,
		$procedure,
		$tarif_rs,
		$tarif_poli_eks,
		$nama_dokter,
		$kode_tarif,
		$payor_id,
		$payor_cd,
		$cob_cd,
		$coder_nik
	) {

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
		$obat_kronis = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 17)->sum('folios.total');
		$obat_kemoterapi = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 18)->sum('folios.total');

		$request = '{
                          "metadata": {
                              "method": "set_claim_data",
                              "nomor_sep": "' . $nomor_sep . '"
                          },
                          "data": {
                              "nomor_sep": "' . $nomor_sep . '",
                              "nomor_kartu": "' . $nomor_kartu . '",
                              "tgl_masuk": "' . $tgl_masuk . '",
                              "tgl_pulang": "' . $tgl_pulang . '",
                              "jenis_rawat": "' . $jenis_rawat . '",
                              "kelas_rawat": "' . $kelas_rawat . '",
                              "adl_sub_acute": "' . $adl_sub_acute . '",
                              "adl_chronic": "' . $adl_chronic . '",
                              "icu_indikator": "' . $icu_indikator . '",
                              "icu_los": "' . $icu_los . '",
                              "ventilator_hour": "' . $ventilator_hour . '",
                              "upgrade_class_ind": "' . $upgrade_class_ind . '",
                              "upgrade_class_class": "' . $upgrade_class_class . '",
                              "upgrade_class_los": "' . $upgrade_class_los . '",
                              "add_payment_pct": "' . $add_payment_pct . '",
                              "birth_weight": "' . $birth_weight . '",
                              "discharge_status": "' . $discharge_status . '",
                              "diagnosa": "' . $diagnosa . '",
                              "procedure": "' . $procedure . '",
                              "tarif_rs": {
                                  "prosedur_non_bedah": "' . $prosedur_non_bedah . '",
                                  "prosedur_bedah": "' . $prosedur_bedah . '",
                                  "konsultasi": "' . $konsultasi . '",
                                  "tenaga_ahli": "' . $tenaga_ahli . '",
                                  "keperawatan": "' . $keperawatan . '",
                                  "penunjang": "' . $penunjang . '",
                                  "radiologi": "' . $radiologi . '",
                                  "laboratorium": "' . $laboratorium . '",
                                  "pelayanan_darah": "' . $pelayanan_darah . '",
                                  "rehabilitasi": "' . $rehabilitasi . '",
                                  "kamar": "' . $kamar . '",
                                  "rawat_intensif": "' . $rawat_intensif . '",
                                  "obat": "' . $obat . '",
                                  "obat_kronis": "' . $obat_kronis . '",
                                  "obat_kemoterapi": "' . $obat_kemoterapi . '",
                                  "alkes": "' . $alkes . '",
                                  "bmhp": "' . $bmhp . '",
                                  "sewa_alat": "' . $sewa_alat . '"
                               },
                              "tarif_poli_eks": "' . $tarif_poli_eks . '",
                              "nama_dokter": "' . $nama_dokter . '",
                              "kode_tarif": "' . $kode_tarif . '",
                              "payor_id": "' . $payor_id . '",
                              "payor_cd": "' . $payor_cd . '",
                              "cob_cd": "' . $cob_cd . '",
                              "coder_nik": "' . $coder_nik . '"
                          }
                     }';
		//echo "Data : ".$request;
		$msg = $this->Request($request);
		if ($msg['metadata']['message'] == "Ok") {
			// Hapus2("inacbg_data_terkirim", "no_sep='".$nomor_sep."'");
			// InsertData2("inacbg_data_terkirim", "'".$nomor_sep."','".$coder_nik."'");
			//$this->GroupingStage1($nomor_sep, $coder_nik);
		}
	}

	function UpdateDataProsedur($nomor_sep, $procedure, $coder_nik)
	{
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
		// echo $msg['metadata']['message'] . "";
	}

	function HapusSemuaProsedur($nomor_sep, $coder_nik)
	{
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
		// echo $msg['metadata']['message'] . "";
	}

	function GroupingStage1($nomor_sep, $coder_nik)
	{
		$request = '{
                          "metadata": {
                              "method":"grouper",
                              "stage":"1"
                          },
                          "data": {
                              "nomor_sep":"' . $nomor_sep . '"
                          }
                     }';
		$msg = $this->Request($request);
		if ($msg['metadata']['message'] == "Ok") {
			$r = Inacbg::where('no_sep', $nomor_sep)->first();
			$r->dijamin = $msg['response']['cbg']['tariff'];
			$r->kode = $msg['response']['cbg']['code'];
			$r->deskripsi_grouper = $msg['response']['cbg']['description'];
			$r->versi_eklaim = $msg['response']['inacbg_version'];
			$r->who_update = Auth::user()->name;
			$r->los = 1;
			$r->final_klaim = 'Y';
			$r->kirim_dc = 'N';
			$r->update();
		}
	}

	function GroupingStage2($nomor_sep, $special_cmg)
	{
		$request = '{
                          "metadata": {
                              "method":"grouper",
                              "stage":"2"
                          },
                          "data": {
                              "nomor_sep":"' . $nomor_sep . '",
                              "special_cmg": "' . $special_cmg . '"
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
                              "coder_nik": "' . $coder_nik . '"
                          }
                     }';
		$msg = $this->Request($request);
		if ($msg['metadata']['message'] == "Ok") {
			$r = Inacbg::where('no_sep', $nomor_sep)->first();
			$r->final_klaim = 'Y';
			$r->update();
		}
	}

	function EditUlangKlaim($nomor_sep)
	{
		$request = '{
                          "metadata": {
                              "method":"reedit_claim"
                          },
                          "data": {
                              "nomor_sep":"' . $nomor_sep . '"
                          }
                     }';
		$msg = $this->Request($request);
	}

	function KirimKlaimPeriodeKeDC($start_dt, $stop_dt, $jenis_rawat)
	{
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

	function KirimKlaimIndividualKeDC($nomor_sep)
	{
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

	function MenarikDataKlaimPeriode($start_dt, $stop_dt, $jenis_rawat)
	{
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

	function MengambilDataDetailPerklaim($nomor_sep)
	{
		$request = '{
                          "metadata": {
                              "method":"get_claim_data"
                          },
                          "data": {
                              "nomor_sep":"' . $nomor_sep . '"
                          }
                     }';
		$msg = $this->Request($request);
	}

	function MengambilSetatusPerklaim($nomor_sep)
	{
		$request = '{
                          "metadata": {
                              "method":"get_claim_status"
                          },
                          "data": {
                              "nomor_sep":"' . $nomor_sep . '"
                          }
                     }';
		$msg = $this->Request($request);
	}

	function MenghapusKlaim($nomor_sep, $coder_nik)
	{
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
	}

	function CetakKlaim($nomor_sep)
	{
		$request = '{
                          "metadata": {
                              "method": "claim_print"
                          },
                          "data": {
                              "nomor_sep": "' . $nomor_sep . '"
                          }
                     }';
		$msg = $this->Request($request);
	}

	function Request($request)
	{
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
		$first = strpos($response, "\n") + 1;
		$last = strrpos($response, "\n") - 1;
		$hasilresponse = substr($response, $first, strlen($response) - $first - $last);
		$hasildecrypt = $this->mc_decrypt($hasilresponse, $this->getKey());
		//echo $hasildecrypt;
		$msg = json_decode($hasildecrypt, true);
		return $msg;
		//echo json_encode($msg);
	}

	//============ RESPONSE BRIDGING =======================================
	public static function getResponse($no_sep)
	{
		$resp = Inacbg::where('no_sep', $no_sep)
			->select('no_sep', 'total_rs', 'dijamin', 'kode', 'final_klaim', 'kirim_dc', 'deskripsi_grouper', 'who_update')
			->first();
		return response()->json($resp);
	}

	public static function detailBridging($registrasi_id)
	{
		$inacbg = Inacbg::where('registrasi_id', $registrasi_id)->first();
		$registrasi = Registrasi::find($registrasi_id);
		return view('bridging.detailBridging', compact('inacbg', 'registrasi'));
	}

	public static function cetakBiayaPerawatan($registrasi_id)
	{
		$reg = Registrasi::find($registrasi_id);
		$folio = Folio::where('registrasi_id', $registrasi_id)->get();
		$jml = Folio::where('registrasi_id', $registrasi_id)->sum('total');
		$no = 1;
		$pdf = PDF::loadView('bridging.rincianBiayaJKN', compact('reg', 'folio', 'jml', 'no'));
		return $pdf->stream();
	}

	public function tesTarif($registrasi_id)
	{
		$data['prosedur_non_bedah'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 1)->sum('folios.total');
		$data['tenaga_ahli'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 2)->sum('folios.total');
		$data['radiologi'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 3)->sum('folios.total');
		$data['rehabilitasi'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 4)->sum('folios.total');
		$data['obat'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 5)->sum('folios.total');
		$data['sewa_alat'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 6)->sum('folios.total');
		$data['prosedur_bedah'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 7)->sum('folios.total');
		$data['keperawatan'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 8)->sum('folios.total');
		$data['laboratorium'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 9)->sum('folios.total');
		$data['kamar'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 10)->sum('folios.total');
		$data['alkes'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 11)->sum('folios.total');
		$data['konsultasi'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 12)->sum('folios.total');
		$data['penunjang'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 13)->sum('folios.total');
		$data['pelayanan_darah'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 14)->sum('folios.total');
		$data['rawat_intensif'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 15)->sum('folios.total');
		$data['bmhp'] = Folio::join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')->where('folios.registrasi_id', $registrasi_id)->where('tarifs.mastermapping_id', 16)->sum('folios.total');
		$data['total'] = $data['prosedur_non_bedah'] + $data['tenaga_ahli'] + $data['radiologi'] + $data['rehabilitasi'] + $data['obat'] + $data['sewa_alat'] + $data['prosedur_bedah'] +
			$data['keperawatan'] + $data['laboratorium'] + $data['kamar'] + $data['alkes'] + $data['konsultasi'] + $data['penunjang'] + $data['pelayanan_darah'] + $data['rawat_intensif'] + $data['bmhp'];
		return $data;
	}

	public function inputPerawatanICD9($registrasi_id, $dataicd9)
	{
		$reg = \Modules\Registrasi\Entities\Registrasi::find($registrasi_id);
		$prosedur = explode('#', $dataicd9);
		for ($i = 0; $i < count($prosedur); $i++) {
			$proc = new \App\PerawatanIcd9();
			$proc->icd9 = $prosedur[$i];
			$proc->registrasi_id = $reg->id;
			$proc->carabayar_id = $reg->bayar;
			$proc->jenis = 'TI';
			$proc->save();
		}
	}

	public function inputPerawatanICD10($registrasi_id, $dataicd10)
	{
		$reg = \Modules\Registrasi\Entities\Registrasi::find($registrasi_id);
		$diagnosa = explode('#', $dataicd10);
		for ($i = 0; $i < count($diagnosa); $i++) {
			$diag = new \App\PerawatanIcd10();
			$diag->icd10 = $diagnosa[$i];
			$diag->registrasi_id = $reg->id;
			$diag->carabayar_id = $reg->bayar;
			$diag->jenis = 'TI';
			$diag->save();
		}
	}
}
