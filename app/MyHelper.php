<?php

use Carbon\Carbon;
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use App\EsignLog;
use Modules\Registrasi\Entities\Registrasi;
use App\Pembayaran;
use App\RegistrasiDummy;
use Modules\Registrasi\Entities\Folio;
use Modules\Poli\Entities\Poli;
use App\AntrianPoli;
use App\InacbgLog;
use Modules\Pasien\Entities\Pasien;
use App\TaskidLog;
use Modules\Accounting\Entities\Journal;

function organization_id()
{
	$organization               = config('app.organization_id');
	return $organization;
}

function hitungAntrol($dokter,$tglperiksa,$kodepoli){
	$cekantrian = RegistrasiDummy::where('dokter_id',$dokter)->where('tglperiksa',$tglperiksa)->where('kode_poli', $kodepoli)->count();
	$noantri = Registrasi::where('dokter_id',$dokter)->where('poli_id',baca_id_poli($kodepoli))->where('created_at','like',$tglperiksa . '%')->count();
	return $cekantrian+$noantri+1;
}
function hitungAntrolNew($dokter,$tglperiksa,$kodepoli){
	$poli = Poli::where('bpjs',$kodepoli)->first();
	$cekantrian = RegistrasiDummy::where('dokter_id',$dokter)->where('tglperiksa',$tglperiksa)->where('kode_poli', $kodepoli)->count();
	$cekantrian_reg = Registrasi::where('dokter_id',$dokter)->where('created_at','like',$tglperiksa.'%')->where('input_from', 'not like', 'KIOSK%')->count();
	// $antrian_terdata = AntrianPoli::where('tanggal', '=', $tglperiksa)->where('kelompok', $poli->kelompok)->count();
	return $cekantrian+$cekantrian_reg+1;
}
function hitungAntrolNew2($kelompok_poli,$kode_poli){
	$count = AntrianPoli::where('tanggal', '=', date('Y-m-d'))->where('kelompok', $kelompok_poli)->count();
	$antr_poli = RegistrasiDummy::whereNotIn('status', ['pending', 'dibatalkan'])->where('tglperiksa',date('Y-m-d'))->where('kode_poli', $kode_poli)->count();

	$nomor = $count+$antr_poli+ 1;
	return $nomor;
}

function compress_json($json)
{
	if($json == ''){
		return NULL;
	}
	$compressedJson = gzcompress(json_encode($json), 9);

	return base64_encode($compressedJson);
}
function decode_json($json)
{
	return json_decode(gzuncompress(base64_decode($json)), true);
}
function cekFolio($reg_id = '')
{
	$total = DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', $reg_id)->where('lunas', 'N')->count();
	return $total;
}


if (!function_exists('noPo')) {
	function noPo($nomor)
	{
		$tgl = explode('/', $nomor);
		return $tgl[2];
	}
}

if (!function_exists('baca_kelompokpegawai')) {
	function baca_kelompokpegawai($id)
	{
		if (!empty($id)) {
			return DB::table('kategori_pegawai')->where('id', $id)->first()->kategori;
		} else {
			return NULL;
		}
	}
}
if (!function_exists('baca_kabupaten2')) {
	function baca_kabupaten2($id)
	{
		if (!empty($id)) {
			return DB::table('regencies2')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}
	}
}
if (!function_exists('baca_kecamatan2')) {
	function baca_kecamatan2($id)
	{
		if (!empty($id)) {
			return @DB::table('districts2')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}
	}
}
if (!function_exists('baca_kelurahan2')) {
	function baca_kelurahan2($id)
	{
		if (!empty($id)) {
			return DB::table('villages2')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}
	}
}
function lamaInap($masuk = '', $keluar = '')
{
	$_masuk = new DateTime($masuk);
	$_keluar = new DateTime($keluar);
	$_diff	= $_keluar->diff($_masuk);
	$ret = '';
	if ($_diff->d > 0) {
		$ret .= $_diff->d . ' hari ';
	}
	if ($_diff->h > 0) {
		$ret .= $_diff->h . ' jam ';
	}
	if ($_diff->i > 0) {
		$ret .= $_diff->i . ' menit ';
	}
	if ($_diff->s > 0) {
		$ret .= $_diff->s . ' detik ';
	}
	return $ret;
}
function lapByCaraBayar($bangsal = '', $bayar = '', $unit = '', $tga = '', $tgb = '')
{
	$data = DB::table('rawatinaps')->leftJoin('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
		->leftJoin('folios', 'folios.registrasi_id', '=', 'rawatinaps.registrasi_id')
		->whereBetween('registrasis.created_at', [valid_date($tga) . ' 00:00:00', valid_date($tgb) . ' 23:59:59'])
		->where(['rawatinaps.kelompokkelas_id' => $bangsal, 'rawatinaps.carabayar_id' => $bayar, 'folios.lunas' => 'Y', 'folios.jenis' => $unit])
		->sum('folios.total');
	return $data;
}
function lapByKelasRawat($bangsal = '', $kelas = '', $unit = '', $tga = '', $tgb = '')
{
	$data = DB::table('rawatinaps')->leftJoin('registrasis', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
		->leftJoin('folios', 'folios.registrasi_id', '=', 'rawatinaps.registrasi_id')
		->whereBetween('registrasis.created_at', [valid_date($tga) . ' 00:00:00', valid_date($tgb) . ' 23:59:59'])
		->where(['rawatinaps.kelompokkelas_id' => $bangsal, 'rawatinaps.kelas_id' => $kelas, 'folios.lunas' => 'Y', 'folios.jenis' => $unit])
		->sum('folios.total');
	return $data;
}

if (!function_exists('baca_faktur')) {
	function baca_faktur($nomor)
	{
		$d = str_replace('/', '-', $nomor);
		return $d;
	}
}

if (!function_exists('baca_tahun')) {
	function baca_tahun($nomor)
	{
		$tgl = explode("/", $nomor);
		return $tgl[4];
	}
}

// function dokterStatus($status = '', $reg = ''){
// 	$peg = DB::table('pegawais')->where(['kategori_pegawai' => 1, 'status' => $status])->pluck('id');
function dokterStatus($reg = '')
{
	$peg = DB::table('pegawais')->where(['kategori_pegawai' => 1])->pluck('id');

	$fol = DB::table('folios')->whereNull('deleted_at')->leftJoin('pegawais', 'pegawais.id', '=', 'folios.dokter_pelaksana')
		->where('folios.registrasi_id', $reg)->whereIn('folios.dokter_pelaksana', $peg)->first();
	if ($fol != null) {
		return $fol->nama;
	} else {
		return '';
	}
}

function getRange($lhr = '', $gndr = '')
{
	$lahir 	= explode('||', $lhr);
	$gender	= explode('||', $gndr);
	$range	= [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
	$now	= time();
	foreach ($lahir as $k => $l) {
		$lhir 	= strtotime($l);
		$diff 	= $now - $lhir;
		$day 	= round($diff / (60 * 60 * 24));
		if ($day < 7) {
			if ($gender[$k] == 'L') {
				$range[0] += 1;
			} else {
				$range[1] += 1;
			}
		} elseif ($day > 6 && $day < 29) {
			if ($gender[$k] == 'L') {
				$range[2] += 1;
			} else {
				$range[3] += 1;
			}
		} elseif ($day > 28 && $day < 366) {
			if ($gender[$k] == 'L') {
				$range[4] += 1;
			} else {
				$range[5] += 1;
			}
		} elseif ($day > 365 && $day < 1461) {
			if ($gender[$k] == 'L') {
				$range[6] += 1;
			} else {
				$range[7] += 1;
			}
		} elseif ($day > 1460 && $day < 5111) {
			if ($gender[$k] == 'L') {
				$range[8] += 1;
			} else {
				$range[9] += 1;
			}
		} elseif ($day > 5110 && $day < 8761) {
			if ($gender[$k] == 'L') {
				$range[10] += 1;
			} else {
				$range[11] += 1;
			}
		} elseif ($day > 8760 && $day < 16061) {
			if ($gender[$k] == 'L') {
				$range[12] += 1;
			} else {
				$range[13] += 1;
			}
		} elseif ($day > 16060 && $day < 23361) {
			if ($gender[$k] == 'L') {
				$range[14] += 1;
			} else {
				$range[15] += 1;
			}
		} elseif ($day > 23360) {
			if ($gender[$k] == 'L') {
				$range[16] += 1;
			} else {
				$range[17] += 1;
			}
		}
	}
	return $range;
}

function getICD9($no = '')
{
	// $icd9 = DB::table('icd9s')->where('nomor', $no);
	$icd9 = DB::table('icd9_im')->where('code', $no);
	if ($icd9->count() > 0)
		// return $icd9->first()->nama;
		return $icd9->first()->description;
	else
		return '-';
}

function totalMapping($jenis = '', $reg = '', $mapp = '')
{
	$count = DB::table('folios')->whereNull('deleted_at')->where(['jenis' => $jenis, 'registrasi_id' => $reg, 'mapping_biaya_id' => $mapp])->count();
	if ($count > 0) {
		return DB::table('folios')->whereNull('deleted_at')->where(['jenis' => $jenis, 'registrasi_id' => $reg, 'mapping_biaya_id' => $mapp])->sum('total');
	} else {
		return 0;
	}
}

function totalIdrg($jenis = '', $reg = '', $idrg = '')
{
	$count = DB::table('folios')->whereNull('deleted_at')->where(['jenis' => $jenis, 'registrasi_id' => $reg, 'idrg_biaya_id' => $idrg])->count();
	if ($count > 0) {
		return DB::table('folios')->whereNull('deleted_at')->where(['jenis' => $jenis, 'registrasi_id' => $reg, 'idrg_biaya_id' => $idrg])->sum('total');
	} else {
		return 0;
	}
}

function baca_jkn($reg_id = '')
{
	$reg = DB::table('registrasis')->where('id', $reg_id)->first();
	return $reg->tipe_jkn;
}

function lapPasien($reg = '', $politipe = '')
{
	if ($politipe == 'T') {
		$data = DB::table('folios')->whereNull('deleted_at')->where(['registrasi_id' => $reg])->sum('total');
	} else {
		$data = DB::table('folios')->whereNull('deleted_at')->where(['registrasi_id' => $reg, 'poli_tipe' => $politipe])->sum('total');
	}
	return $data;
}

function tindakanOK($reg = '')
{
	$folio = DB::table('folios')->whereNull('deleted_at')->where(['registrasi_id' => $reg, 'poli_tipe' => 'O'])->get();
	return $folio;
}

function pemeriksaanIrna($dokter_id, $jenis, $tga, $tgb, $carabayar)
{
	$pemeriksaan = DB::table('tarifs')->where('mapping_pemeriksaan', 'PM')->get();
	$pm = [];
	foreach ($pemeriksaan as $key => $d) {
		$pm[] = '' . $d->id . '';
	}
	$bayar = [];
	foreach (DB::table('carabayars')->get(['id']) as $d) {
		$bayar[] = '' . $d->id . '';
	}
	if ($carabayar == '100') {
		$total = DB::table('folios')->whereNull('deleted_at')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('jenis', $jenis)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	} else {
		$total = DB::table('folios')->whereNull('deleted_at')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	}
	// $total = DB::table('folios')->whereNull('deleted_at')->where('dokter_id', $dokter_id)->where('jenis', $jenis)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	return $total;
}

//=========== KINERJA RAJAL / IGD ===============================================
function kinerjaDokter($dokter_id, $poli_id, $jenis, $tga, $tgb, $carabayar)
{
	$kinerjaDokter = DB::table('tarifs')->whereIn('mapping_pemeriksaan', ['KS', 'PM'])->get();
	$kj = [];
	foreach ($kinerjaDokter as $key => $d) {
		$kj[] = '' . $d->id . '';
	}
	$bayar = [];
	foreach (DB::table('carabayars')->get(['id']) as $d) {
		$bayar[] = '' . $d->id . '';
	}
	if ($carabayar == '100') {
		$total = DB::table('folios')->whereNull('deleted_at')->where('dokter_id', $dokter_id)->where('poli_id', $poli_id)->whereIn('tarif_id', $kj)->where('jenis', $jenis)->whereIn('cara_bayar_id', $bayar)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	} else {
		$total = DB::table('folios')->whereNull('deleted_at')->where('dokter_id', $dokter_id)->where('poli_id', $poli_id)->whereIn('tarif_id', $kj)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	}
	return $total;
}

function tindakan($dokter_id, $jenis, $tga, $tgb, $carabayar)
{
	$tindakan = DB::table('tarifs')->where('mapping_pemeriksaan', 'TN')->get();
	$tn = [];
	foreach ($tindakan as $key => $d) {
		$tn[] = '' . $d->id . '';
	}
	$bayar = [];
	foreach (DB::table('carabayars')->get(['id']) as $d) {
		$bayar[] = '' . $d->id . '';
	}
	if ($carabayar == '100') {
		$total = DB::table('folios')->whereNull('deleted_at')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $tn)->where('jenis', $jenis)->whereIn('cara_bayar_id', $bayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	} else {
		$total = DB::table('folios')->whereNull('deleted_at')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $tn)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	}
	return $total;
}

function konsultasi($dokter_id, $jenis, $tga, $tgb, $carabayar)
{
	$konsultasi = DB::table('tarifs')->where('mapping_pemeriksaan', 'KS')->get();
	$ks = [];
	foreach ($konsultasi as $key => $d) {
		$ks[] = '' . $d->id . '';
	}
	$bayar = [];
	foreach (DB::table('carabayars')->get(['id']) as $d) {
		$bayar[] = '' . $d->id . '';
	}
	if ($carabayar == '100') {
		$total = DB::table('folios')->whereNull('deleted_at')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $ks)->where('jenis', $jenis)->whereIn('cara_bayar_id', $bayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	} else {
		$total = DB::table('folios')->whereNull('deleted_at')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $ks)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	}
	return $total;
}

function pemeriksaan($dokter_id, $jenis, $tga, $tgb, $carabayar)
{
	$pemeriksaan = DB::table('tarifs')->where('mapping_pemeriksaan', 'PM')->get();
	$pm = [];
	foreach ($pemeriksaan as $key => $d) {
		$pm[] = '' . $d->id . '';
	}
	$bayar = [];
	foreach (DB::table('carabayars')->get(['id']) as $d) {
		$bayar[] = '' . $d->id . '';
	}
	if ($carabayar == '100') {
		$total = DB::table('folios')->whereNull('deleted_at')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('jenis', $jenis)->whereIn('cara_bayar_id', $bayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	} else {
		$total = DB::table('folios')->whereNull('deleted_at')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	}

	return $total;
}
//================================== END KINERJA ===================================================
function tglLOS($tanggal, $ket = NULL)
{
	if (!empty($tanggal)) {
		$tgl = explode(" ", $tanggal);
		$t = explode("-", $tgl[0]);
		if ($ket == 'Y') {
			return $t[0];
		} elseif ($ket == 'm') {
			return $t[1];
		} elseif ($ket == 'd') {
			return $t[2];
		} else {
			return 'format tanggal salah';
		}
	} else {
		return NULL;
	}
}

function cekVerifJalan($registrasi_id, $poli_tipe)
{
	$verif = DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', $registrasi_id)->where('poli_tipe', $poli_tipe)->where('verif_kasa', 'Y')->count();
	return $verif;
}

function cekVerif($registrasi_id, $tarif_id)
{
	$verif = DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', $registrasi_id)->where('tarif_id', $tarif_id)->where('verif_kasa', 'Y')->count();
	return $verif;
}

if (!function_exists('tarif_mapping')) {
	function tarif_mapping($registrasi_id = '', $mapping_id = '')
	{
		if (!empty($registrasi_id && $mapping_id)) {
			return DB::table('folios')->whereNull('deleted_at')->join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
				->where('folios.registrasi_id', $registrasi_id)
				->where('tarifs.mastermapping_id', $mapping_id)
				->sum('folios.total');
		} else {
			return NULL;
		}
	}
}
if (!function_exists('mappingTindakan')) {
	function mappingTindakan($registrasi_id = '', $mapping_id = '')
	{
		return $registrasi_id . '-' . $mapping_id;
		// dd($registrasi_id,$mapping_id);
		if (!empty($registrasi_id && $mapping_id)) {
			return DB::table('folios')->whereNull('deleted_at')->join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
				->where('folios.registrasi_id', $registrasi_id)
				->where('tarifs.mastermapping_id', $mapping_id)
				->sum('folios.total');
		} else {
			return NULL;
		}
	}
}

if (!function_exists('tarif_idrg')) {
	function tarif_idrg($registrasi_id = '', $idrg_id = '')
	{
		if (!empty($registrasi_id && $idrg_id)) {
			return DB::table('folios')->whereNull('deleted_at')->join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
				->where('folios.registrasi_id', $registrasi_id)
				->where('tarifs.masteridrg_id', $idrg_id)
				->sum('folios.total');
		} else {
			return NULL;
		}
	}
}
if (!function_exists('idrgTindakan')) {
	function idrgTindakan($registrasi_id = '', $idrg_id = '')
	{
		return $registrasi_id . '-' . $idrg_id;
		// dd($registrasi_id,$idrg_id);
		if (!empty($registrasi_id && $idrg_id)) {
			return DB::table('folios')->whereNull('deleted_at')->join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
				->where('folios.registrasi_id', $registrasi_id)
				->where('tarifs.masteridrg_id', $idrg_id)
				->sum('folios.total');
		} else {
			return NULL;
		}
	}
}

if (!function_exists('tanggal_eklaim')) {
	function tanggal_eklaim($tanggal = '')
	{
		if (!empty($tanggal)) {
			$tg = explode(" ", $tanggal);
			$t = explode("-", $tg[0]);
			return $t[2] . '/' . $t[1] . '/' . $t[0];
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_carapulang')) {
	function baca_carapulang($id = '')
	{
		if (!empty($id)) {
			return DB::table('kondisi_akhir_pasiens')->where('id', $id)->first()->namakondisi;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('cekEkpertise')) {
	function cekEkpertise($id = '')
	{
		if (!empty($id)) {
			return DB::table('radiologi_ekspertises')->where('registrasi_id', $id)->count();
		} else {
			return NULL;
		}
	}
}

if (!function_exists('cekLab')) {
	function cekLab($id = '')
	{
		if (!empty($id)) {
			return DB::table('hasillabs')->where('registrasi_id', $id)->count();
		} else {
			return NULL;
		}
	}
}

function baca_labor($id = '')
{
	if (!empty($id)) {
		return DB::table('laboratoria')->where('id', $id)->first()->nama;
	} else {
		return NULL;
	}
}

if (!function_exists('cekResume')) {
	function cekResume($id = '')
	{
		if (!empty($id)) {
			return DB::table('resume_pasiens')->where('registrasi_id', $id)->count();
		} else {
			return NULL;
		}
	}
}

if (!function_exists('cekEcho')) {
	function cekEcho($id = '')
	{
		if (!empty($id)) {
			return DB::table('echocardiograms')->where('registrasi_id', $id)->count();
		} else {
			return NULL;
		}
	}
}


if (!function_exists('baca_kategori_obat')) {
	function baca_kategori_obat($id = '')
	{
		if (!empty($id)) {
			return DB::table('kategoriobats')->where('id', $id)->first()->nama;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_diagnosa')) {
	function baca_diagnosa($kode = '')
	{
		if (!empty($kode)) {
			// return $kode;
			// $db = DB::table('icd10s')->where('nomor', $kode)->first();
			$db = DB::table('icd10_im')->where('code', $kode)->first();
			if(!$db){
				$db = DB::table('icd10s')->where('nomor', $kode)->first();
				if($db){
					return @$db->nama;
				}
			}

			if($db){
				return @$db->code.' '.@$db->description;
			}else{
				return NULL;

			}
		} else {
			return NULL;
		}
	}
}
if (!function_exists('baca_code_diagnosa')) {
	function baca_code_diagnosa($desc = '')
	{
		if (!empty($desc)) {
			// return $kode;
			// $db = DB::table('icd10s')->where('nomor', $kode)->first();
			$db = DB::table('icd10_im')->where('description', $desc)->first();
			if(!$db){
				$db = DB::table('icd10s')->where('nama', $desc)->first();
				if($db){
					return @$db->nama;
				}else{
					return $desc;
				}
			}

			if($db){
				return @$db->code.' '.$db->description;
			}else{
				return NULL;

			}
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_prosedur')) {
	function baca_prosedur($kode = '')
	{
		if (!empty($kode)) {
			// $db =  DB::table('icd9s')->where('nomor', $kode)->first();
			$db =  DB::table('icd9_im')->where('code', $kode)->first();
			if(!$db){
				$db =  DB::table('icd9s')->where('nomor', $kode)->first();
				if($db){
					return @$db->nama;
				}
			}


			if($db){
				return @$db->description;
			}else{
				return NULL;

			}
		} else {
			return NULL;
		}
	}
}

if (!function_exists('no_rm')) {
	function no_rm($no_rm = '')
	{
		$a = substr($no_rm, 0, 2);
		$b = substr($no_rm, 2, 2);
		$c = substr($no_rm, 4, 2);
		$d = substr($no_rm, 6, 2);
		return $a . '-' . $b . '-' . $c;
	}
}

if (!function_exists('pasien_perpoli')) {
	function pasien_perpoli($tanggal, $poli_id)
	{
		// $keyCache = 'pasien_perpoli_'.$poli_id;
		// $pasien = Cache::get($keyCache);
		// if(!$pasien){
		$pasien = DB::table('histori_kunjungan_irj')->where('created_at', 'LIKE', $tanggal . '%')->where('poli_id', $poli_id)->count();
		// 	Cache::put($keyCache,$pasien,120);
		// }
		// $pasien = 
		return $pasien;
	}
}

function baca_layanan($layanan)
{
	if (substr($layanan, 0, 1) == 'G') {
		return '<span style="color:red">IGD</span>';
	} elseif (substr($layanan, 0, 1) == 'I') {
		return '<span style="color:green">INAP</span>';
	} else {
		return '<span style="color:blue">RAJAL</span>';
	}
}

if (!function_exists('tanggal')) {
	function tanggal($created_at)
	{
		if (!empty($created_at)) {
			$tgl = explode(' ', $created_at);
			$t = explode('-', $tgl[0]);
			return $t[2] . '-' . $t[1] . '-' . $t[0] . ' ' . $tgl[1];
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_icd10')) {
	function baca_icd10($kode)
	{
		// return isset(DB::table('icd10s')->where('nomor', $nomor)->first()->nama) ? DB::table('icd10s')->where('nomor', $nomor)->first()->nama : null;
		$db = DB::table('icd10_im')->where('code', $kode)->first();
		if(!$db){
			$db = DB::table('icd10s')->where('nomor', $kode)->first();
			if($db){
				return @$db->nama;
			}else{
				return $kode;
			}
		}

		if($db){
			return @$db->code.' '.@$db->description;
		}else{
			return NULL;

		}
	}
}


if (!function_exists('baca_icd9')) {
	function baca_icd9($kode)
	{
		// return isset(DB::table('icd9s')->where('nomor', $nomor)->first()->nama) ? DB::table('icd9s')->where('nomor', $nomor)->first()->nama : null;
		// return isset(DB::table('icd9_im')->where('code', $nomor)->first()->description) ? DB::table('icd9_im')->where('code', $nomor)->first()->description : null;
		$db = DB::table('icd9_im')->where('code', $kode)->first();
		if(!$db){
			$db = DB::table('icd9s')->where('nomor', $kode)->first();
			if($db){
				return @$db->nama;
			}
		}

		if($db){
			return @$db->code.' '.@$db->description;
		}else{
			return NULL;

		}
		
	}
}

if (!function_exists('cek_tindakan')) {
	function cek_tindakan($registrasi_id, $poli_id)
	{
		return DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', $registrasi_id)->where('poli_id', $poli_id)->count();
	}
}

if (!function_exists('cek_tindakan_igd')) {
	function cek_tindakan_igd($registrasi_id)
	{
		return DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', $registrasi_id)->count();
	}
}

if (!function_exists('baca_bed')) {
	function baca_bed($id)
	{
		$bed = DB::table('beds')->where('id', $id)->first();
		if ($bed) {
			return $bed->nama;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_pegawai')) {
	function baca_pegawai($id)
	{
		return isset(DB::table('pegawais')->where('id', $id)->first()->nama) ? DB::table('pegawais')->where('id', $id)->first()->nama : $id;
	}
}

if (!function_exists('baca_kelompok')) {
	function baca_kelompok($id)
	{
		$klpk = DB::table('kelompok_kelas')->where('id', $id)->first();
		if ($klpk) {
			return $klpk->kelompok;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('kelamin')) {
	function kelamin($kelamin)
	{
		if ($kelamin == 'L') {
			return 'LAKI-LAKI';
		} else {
			return 'PEREMPUAN';
		}
	}
}

if (!function_exists('baca_kamar')) {
	function baca_kamar($id)
	{
		if (!empty($id)) {
			$kamar = DB::table('kamars')->where('id', $id)->first();
			if ($kamar) {
				return $kamar->nama;
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}
}

if (!function_exists('count_resume')) {
	function count_resume($reg_id)
	{
		return DB::table('resume_pasiens')->where('registrasi_id', '=', $reg_id)->count();
	}
}

if (!function_exists('baca_kelas')) {
	function baca_kelas($id)
	{
		if (!empty($id)) {
			$kelas = DB::table('kelas')->where('id', $id)->first();
			if ($kelas) {
				return $kelas->nama;
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}
}

if (!function_exists('kode_kelas')) {
	function kode_kelas($id)
	{
		if (!empty($id)) {
			$kelas = DB::table('kelas')->where('id', $id)->first();
			if ($kelas) {
				return $kelas->kode;
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}
}

if (!function_exists('rupiah')) {
	function rupiah($angka)
	{
		$d = str_replace('.', '', $angka);
		$r = str_replace(',', '', $d);
		return $r;
	}
}

if (!function_exists('valid_date')) {
	function valid_date($tgl_indo)
	{
		$t = explode('-', $tgl_indo);
		return $t[2] . '-' . $t[1] . '-' . $t[0];
	}
}

if (!function_exists('cek_jenispasien')) {
	function cek_jenispasien($registrasi_id)
	{
		return DB::table('registrasis')->where('id', '=', $registrasi_id)->first()->bayar;
	}
}

// RADIOLOGI BIASA
function codePoliRadiologi()
{
	$poli = DB::table('polis')->where('bpjs', 'RDO')->first();
	return $poli->bpjs;
}
function poliRadiologi()
{
	$poli = DB::table('polis')->where('bpjs', codePoliRadiologi())->first();
	return $poli->id;
}
function getDokterRadiologi()
{
	$dokter = [];
	$poli = DB::table('polis')->where('bpjs', codePoliRadiologi())->first()->dokter_id;
	$dokter_id = explode(',', $poli);
	$radiografer = DB::table('pegawais')->whereIn('id', $dokter_id)->get();
	return $radiografer;
}
// END RADIOLOGI BIASA


// RADIOLOGI GIGI
function codeRadiologiGigi()
{
	$poli = DB::table('polis')->where('bpjs', 'RAD')->first();
	return $poli->bpjs;
}
function poliRadiologiGigi()
{
	$poli = DB::table('polis')->where('bpjs', codeRadiologiGigi())->first();
	return $poli->id;
}
function getDokterRadiologiGigi()
{
	$dokter = [];
	$poli = DB::table('polis')->where('bpjs', codeRadiologiGigi())->first()->dokter_id;
	$dokter_id = explode(',', $poli);
	$radiografer = DB::table('pegawais')->whereIn('id', $dokter_id)->get();
	return $radiografer;
}
// END RADIOLOGI GIGI



if (!function_exists('cek_id_pasien')) {
	function cek_id_pasien($registrasi_id)
	{
		return DB::table('registrasis')->where('id', '=', $registrasi_id)->first()->pasien_id;
	}
}

if (!function_exists('tgl_indo')) {
	function tgl_indo($tgl)
	{
		$t = explode('-', $tgl);
		return $t[2] . '-' . $t[1] . '-' . $t[0];
	}
}
if (!function_exists('baca_apoteker')) {
	function baca_apoteker($id)
	{
		return DB::table('apotekers')->where('id', $id)->first()->nama;
	}
}

if (!function_exists('baca_kelurahan')) {
	function baca_kelurahan($id)
	{
		if (!empty(@$id)) {
			return @DB::table('villages')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_pasien')) {
	function baca_pasien($id)
	{
		if (!empty($id)) {
			return DB::table('pasiens')->where('id', $id)->first()->nama;
		} else {
			return NULL;
		}
	}
}
if (!function_exists('baca_pasien_rm')) {
	function baca_pasien_rm($id)
	{
		if (!empty($id)) {
			$pas = DB::table('pasiens')->where('id', $id)->first();
			return $pas->nama . '(' . $pas->no_rm . ')';
		} else {
			return NULL;
		}
	}
}
if (!function_exists('baca_norm')) {
	function baca_norm($id)
	{
		if (!empty($id)) {
			return @DB::table('pasiens')->where('id', $id)->first()->no_rm;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_kecamatan')) {
	function baca_kecamatan($id)
	{
		if (!empty($id)) {
			return @DB::table('districts')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_kabupaten')) {
	function baca_kabupaten($id)
	{
		if (!empty($id)) {
			return @DB::table('regencies')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_propinsi')) {
	function baca_propinsi($id)
	{
		if (!empty($id)) {
			return @DB::table('provinces')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('cek_hasil_lab')) {
	function cek_hasil_lab($reg_id)
	{
		return DB::table('hasillabs')->where('registrasi_id', '=', $reg_id)->count();
	}
}
if (!function_exists('cek_hasil_lis')) {
	function cek_hasil_lis($reg_id)
	{
		return DB::table('hasillabs')->where('registrasi_id', $reg_id)->whereNotNull('json')->get();
	}
}
function path_ttd()
{
	return 'http://172.168.1.175/';
}

if (!function_exists('cek_ekspertise')) {
	function cek_ekspertise($reg_id)
	{
		return DB::table('radiologi_ekspertises')->where('registrasi_id', '=', $reg_id)->count();
	}
}

if (!function_exists('cek_leb')) {
	function cek_leb($reg_id)
	{
		return DB::table('hasillabs')->where('registrasi_id', '=', $reg_id)->count();
	}
}

if (!function_exists('cek_spri')) {
	function cek_spri($reg_id)
	{
		return DB::table('surat_inaps')->where('registrasi_id', '=', $reg_id)->count();
	}
}

if (!function_exists('cek_farmasi')) {
	function cek_farmasi($reg_id)
	{
		return DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', '=', $reg_id)->where('jenis', 'ORJ')->count();
	}
}

if (!function_exists('cek_echocardiogram')) {
	function cek_echocardiogram($reg_id)
	{
		return DB::table('echocardiograms')->where('registrasi_id', '=', $reg_id)->count();
	}
}

if (!function_exists('cek_ekspertises')) {
	function cek_ekspertises($reg_id)
	{
		return DB::table('radiologi_ekspertises')->where('registrasi_id', '=', $reg_id)->count();
	}
}

if (!function_exists('total_tagihan')) {
	function total_tagihan($reg_id)
	{
		return DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', '=', $reg_id)->where('lunas', 'N')->sum('total');
		//return DB::table('folios')->whereNull('deleted_at')->join('penjualandetails', 'penjualandetails.no_resep', '=', 'folios.namatarif')->where('folios.registrasi_id', '=', $reg_id)->where('folios.lunas', 'N')->sum('folios.total');
	}
}

if (!function_exists('total_dibayar')) {
	function total_dibayar($reg_id)
	{
		return DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', '=', $reg_id)->sum('dibayar');
	}
}

if (!function_exists('no_kuitansi')) {
	function no_kuitansi($reg_id)
	{
        return DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', '=', $reg_id)->pluck('no_kuitansi')->filter()->unique()->implode('<br>');
    }
}

if (!function_exists('total_tagihan_tindakan')) {
	function total_tagihan_tindakan($reg_id)
	{
		return DB::table('folios')->whereNull('deleted_at')->where('jenis', '!=', 'ORJ')->where('registrasi_id', '=', $reg_id)->where('lunas', 'N')->sum('total');
		//return DB::table('folios')->whereNull('deleted_at')->join('penjualandetails', 'penjualandetails.no_resep', '=', 'folios.namatarif')->where('folios.registrasi_id', '=', $reg_id)->where('folios.lunas', 'N')->sum('folios.total');
	}
}

function hitung_kuota_poli($id, $tgl)
{
	// dd(date('l'));
	$antrian_poli = DB::table('antrians')->where('poli_id', $id)->where('tanggal', $tgl)->count();
	$hari = strtolower(date('l'));
	$kuota_poli = DB::table('polis')->where('id', $id)->first()->$hari;

	if ($kuota_poli == 0) {
		$sisa_kuota = 0;
	} else {
		$sisa_kuota = $kuota_poli - $antrian_poli;
	}
	// dd($sisa_kuota);
	return $sisa_kuota;
}

if (!function_exists('total_tagihan_obat')) {
	function total_tagihan_obat($reg_id)
	{
		return DB::table('folios')->whereNull('deleted_at')->where('jenis', '=', 'ORJ')->where('registrasi_id', '=', $reg_id)->where('lunas', 'N')->sum('total');
		//return DB::table('folios')->whereNull('deleted_at')->join('penjualandetails', 'penjualandetails.no_resep', '=', 'folios.namatarif')->where('folios.registrasi_id', '=', $reg_id)->where('folios.lunas', 'N')->sum('folios.total');
	}
}

if (!function_exists('total_tagihan_racikan')) {
	function total_tagihan_racikan($reg_id)
	{
		return DB::table('folios')->whereNull('deleted_at')->join('penjualandetails', 'penjualandetails.no_resep', '=', 'folios.namatarif')->where('folios.registrasi_id', '=', $reg_id)->where('folios.lunas', 'N')->sum('uang_racik');
		// return DB::table('penjualans')::join('penjualandetails','penjualans.id','=','penjualandetails.penjualan_id')
		// ->join('folios', 'folios.namatarif', '=', 'penjualans.no_resep')
		// ->where('folios.lunas', 'N')
		// ->where('penjualans.registrasi_id', $reg_id)
		// ->sum('uang_racik');
	}
}

if (!function_exists('baca_data_poli')) {
	function baca_data_poli($id)
	{
		if (!empty($id)) {
			$polis = DB::table('polis')->where('id', $id)->first();
			if ($polis) {
				return $polis;
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
}
if (!function_exists('baca_datas_poli')) {
	function baca_datas_poli($bpjs)
	{
		if (!empty($bpjs)) {
			return DB::table('polis')->where('bpjs', '=', $bpjs)->first();
		} else {
			return '';
		}
	}
}

if (!function_exists('baca_poli')) {
	function baca_poli($id)
	{
		if (!empty($id)) {
			$polis = DB::table('polis')->where('id', '=', $id)->first();
			if ($polis) {
				return $polis->nama;
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
}

if (!function_exists('baca_poli_bpjs')) {
	function baca_poli_bpjs($id)
	{
		if (!empty($id)) {
			$polis = DB::table('polis')->where('id', '=', $id)->first();
			if ($polis) {
				return $polis->bpjs;
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
}

if (!function_exists('baca_kode_poli')) {
	function baca_kode_poli($bpjs)
	{
		if (!empty($bpjs)) {
			return DB::table('polis')->where('bpjs', '=', $bpjs)->first()->nama;
		} else {
			return '';
		}
	}
}

if (!function_exists('baca_id_poli')) {
	function baca_id_poli($bpjs)
	{
		if (!empty($bpjs)) {
			return DB::table('polis')->where('bpjs', '=', $bpjs)->first()->id;
		} else {
			return '';
		}
	}
}

if (!function_exists('baca_bpjs_poli')) {
	function baca_bpjs_poli($id)
	{
		if (!empty($id)) {
			return DB::table('polis')->where('id', '=', $id)->first()->bpjs;
		} else {
			return '';
		}
	}
}

if (!function_exists('baca_politipe')) {
	function baca_politipe($kode)
	{
		if (!empty($kode)) {
			return DB::table('politypes')->where('kode', '=', $kode)->first()->nama;
		} else {
			return '';
		}
	}
}

if (!function_exists('baca_dokter_bpjs')) {
	function baca_dokter_bpjs($kode)
	{
		if (!empty($kode)) {
			$cek = DB::table('pegawais')->where('kode_bpjs', '=', $kode)->count();
			if ($cek > 0) {
				return DB::table('pegawais')->where('kode_bpjs', '=', $kode)->first()->nama;
			} else {
				return '';
			}
		} else {
			return null;
		}
	}
}
if (!function_exists('baca_dokter')) {
	function baca_dokter($id)
	{
		if (!empty($id)) {
			$cek = DB::table('pegawais')->where('id', '=', $id)->count();
			if ($cek > 0) {
				return DB::table('pegawais')->where('id', '=', $id)->first()->nama;
			} else {
				return '';
			}
		} else {
			return null;
		}
	}
}

if (!function_exists('baca_general_dokter')) {
	function baca_general_dokter($id)
	{
		if (!empty($id)) {
			$cek = DB::table('pegawais')->where('id', '=', $id)->count();
			if ($cek > 0) {
				return DB::table('pegawais')->where('id', '=', $id)->first()->general_code;
			} else {
				return '';
			}
		} else {
			return null;
		}
	}
}

if (!function_exists('tandatangan')) {
	function tandatangan($id)
	{
		if (!empty($id)) {
			$cek = DB::table('pegawais')->where('id', '=', $id)->count();
			if ($cek > 0) {
				return DB::table('pegawais')->where('id', '=', $id)->first()->tanda_tangan;
			} else {
				return '';
			}
		} else {
			return null;
		}
	}
}

if (!function_exists('cek_registrasi_new')) {
	function cek_registrasi_new($antrian_id, $bagian)
	{
		if ($bagian == 'C') {
			$no_loket = [5, 6, 7, 8];
		} else {
			$no_loket = [1, 2, 3, 4];
		}
		return DB::table('registrasis')->where('antrian_id', '=', $antrian_id)->whereIn('no_loket', $no_loket)->where('created_at', 'LIKE', date('Y-m-d') . '%')->count();
	}
}
function bagianAntrian($bagian)
{
	if ($bagian == 'B' || $bagian == 'A') {
		return 'bawah';
	} else {
		return 'atas';
	}
}
function bagian_lokets($bagian)
{
	if ($bagian == 'bawah') {
		return 'B';
	} else {
		return 'C';
	}
}
if (!function_exists('cek_registrasi')) {
	function cek_registrasi($antrian_id, $no_loket)
	{

		return DB::table('registrasis')->where('antrian_id', '=', $antrian_id)->where('no_loket', $no_loket)->where('created_at', 'LIKE', date('Y-m-d') . '%')->count();
	}
}

if (!function_exists('hitung_umur')) {
	function hitung_umur($tgl, $bln = '')
	{
		$lahir = new DateTime($tgl);
		$today = new DateTime();
		$umur = $today->diff($lahir);
		if (!empty($bln)) {
			return $umur->y . ' th ' . $umur->m . ' bl ';
		} else {
			return $umur->y . ' th ' . $umur->m . ' bl ' . $umur->d . ' hr';
		}
	}
}
if (!function_exists('hitung_umur_by_tanggal')) {
	function hitung_umur_by_tanggal($tgl_lahir, $tgl)
	{
		$lahir = new DateTime($tgl_lahir);
		$tgl = new DateTime($tgl);
		$umur = $tgl->diff($lahir);
		return $umur->y . ' th ' . $umur->m . ' bl ' . $umur->d . ' hr';
	}
}
if (!function_exists('jenis_pembelian')) {
	function jenis_pembelian($id)
	{
		if ($id == 1) {
			return 'Cash';
		} else {
			return "Faktur";
		}
	}
}
if (!function_exists('baca_carabayar')) {
	function baca_carabayar($id)
	{
		if (!empty($id)) {
			$kat = DB::table('carabayars')->where('id', '=', $id)->first();
			if ($kat->carabayar == 'JKN') {
				return 'BPJS';
			}
			return $kat->carabayar;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_data_carabayar')) {
	function baca_data_carabayar($id)
	{
		if (!empty($id)) {
			$kat = DB::table('carabayars')->where('id', '=', $id)->first();
			return $kat;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_rujukan')) {
	function baca_rujukan($id)
	{
		if (!empty($id)) {
			$kat = DB::table('pengirim_rujukan')->where('id', '=', $id)->first();
			return $kat->nama;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_pengirim_rujukan')) {
	function baca_pengirim_rujukan($id)
	{
		if (!empty($id)) {
			$kat = DB::table('pengirim_rujukan')->where('id', '=', $id)->first();
			return $kat->nama;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('terbilang')) {
	function terbilang($satuan)
	{
		if (!empty($satuan)) {
			$huruf = array(
				"", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh",
				"Delapan", "Sembilan", "Sepuluh", "Sebelas"
			);
			if ($satuan < 12) {
				return " " . $huruf[$satuan];
			} elseif ($satuan < 20) {
				return Terbilang($satuan - 10) . " Belas";
			} elseif ($satuan < 100) {
				return Terbilang($satuan / 10) . " Puluh" .
					Terbilang($satuan % 10);
			} elseif ($satuan < 200) {
				return " Seratus" . Terbilang($satuan - 100);
			} elseif ($satuan < 1000) {
				return Terbilang($satuan / 100) . " Ratus" .
					Terbilang($satuan % 100);
			} elseif ($satuan < 2000) {
				return "Seribu" . Terbilang($satuan - 1000);
			} elseif ($satuan < 1000000) {
				return Terbilang($satuan / 1000) . " Ribu" .
					Terbilang($satuan % 1000);
			} elseif ($satuan < 1000000000) {
				return Terbilang($satuan / 1000000) . " Juta" .
					Terbilang($satuan % 1000000);
			} elseif ($satuan >= 1000000000) {
				echo "Hasil terbilang tidak dapat di proses, nilai terlalu besar";
			}
		}
	}
}

if (!function_exists('tanggalPeriode')) {
	function tanggalPeriode($tanggal)
	{
		$tgl = explode('-', $tanggal);
		return $tgl[2] . '-' . $tgl[1] . '-' . $tgl[0];
	}
}
if (!function_exists('baca_sjp')) {
	function baca_sjp($x)
	{
		if (!empty($x)) {
			switch ($x) {
				case 'irj':
					$b = 'RAWAT JALAN';
					break;
				case 'igd':
					$b = 'IGD';
					break;
				case 'irna':
					$b = 'RAWAT INAP';
					break;
			}
			return $b;
		}
	}
}
if (!function_exists('tanggalkuitansi')) {
	function tanggalkuitansi($x)
	{
		if (!empty($x)) {
			$y = explode('-', $x);
			switch ($y[1]) {
				case '1':
					$b = 'Januari';
					break;
				case '2':
					$b = 'Februari';
					break;
				case '3':
					$b = 'Maret';
					break;
				case '4':
					$b = 'April';
					break;
				case '5':
					$b = 'Mei';
					break;
				case '6':
					$b = 'Juni';
					break;
				case '7':
					$b = 'Juli';
					break;
				case '8':
					$b = 'Agustus';
					break;
				case '9':
					$b = 'September';
					break;
				case '10':
					$b = 'Oktober';
					break;
				case '11':
					$b = 'November';
					break;
				case '12':
					$b = 'Desember';
					break;
			}
			$z = $y[0] . ' ' . $b . ' ' . $y[2];
			return $z;
		}
	}
}

if (!function_exists('bulan')) {
	function bulan($bulan)
	{
		$b = "";
		switch ($bulan) {
			case '1':
				$b = 'Januari';
				break;
			case '2':
				$b = 'Februari';
				break;
			case '3':
				$b = 'Maret';
				break;
			case '4':
				$b = 'April';
				break;
			case '5':
				$b = 'Mei';
				break;
			case '6':
				$b = 'Juni';
				break;
			case '7':
				$b = 'Juli';
				break;
			case '8':
				$b = 'Agustus';
				break;
			case '9':
				$b = 'September';
				break;
			case '10':
				$b = 'Oktober';
				break;
			case '11':
				$b = 'November';
				break;
			case '12':
				$b = 'Desember';
				break;
		}

		return $b;
	}
}

if (!function_exists('configrs')) {
	function configrs()
	{
		$cf = DB::table('configs')->where('id', '=', 1)->first();
		return $cf;
	}
}

if (!function_exists('baca_user')) {
	function baca_user($id = '')
	{
		if (!empty($id)) {
			return @DB::table('users')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_tarif')) {
	function baca_tarif($id = '')
	{
		if (!empty($id)) {
			return DB::table('tarifs')->where('id', $id)->first()->nama;
		} else {
			return NULL;
		}
	}
}


if (!function_exists('baca_gudang_logistik')) {
	function baca_gudang_logistik($id = '')
	{
		if (!empty($id)) {
			return DB::table('logistik_gudangs')->where('id', $id)->first()->nama;
		} else {
			return NULL;
		}
	}
}



function resepLunas($namatarif = '')
{
	$data = DB::table('folios')->whereNull('deleted_at')->where('namatarif', $namatarif)->first();
	if ($data == NULL) {
		return 'Y';
	} else {
		return $data->lunas;
	}
}



if (!function_exists('baca_icd10')) {
	function baca_icd10($id)
	{
		if (!empty($id)) {
			// return DB::table('icd10s')->where('nomor', $id)->first()->nama;
			return DB::table('icd10_im')->where('code', $id)->first()->description;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_satuan_jual')) {
	function baca_satuan_jual($id)
	{
		if (!empty($id)) {
			return DB::table('satuanjuals')->where('id', $id)->first()->nama;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_pekerjaan')) {
	function baca_pekerjaan($id)
	{
		if (!empty($id)) {
			return DB::table('pekerjaans')->where('id', $id)->first()->nama;
		} else {
			return NULL;
		}
	}
}

function baca_agama($id)
{
	if ($id !== null) {
		$agama = DB::table('agamas')->where('id', $id)->first();
		return $agama ? $agama->agama : null;
	}
	return null;
}


function baca_pagt($skor)
{
	if ($skor == '0' || $skor == '1') {
		return 'NON PAGT';
	} elseif ($skor == '2' || $skor == '3') {
		return 'PAGT';
	} elseif ($skor == '4' || $skor == '5') {
		return 'RUJUK DOKTER SPKG';
	} else {
		return NULL;
	}
}


if (!function_exists('baca_satuan_jual_report')) {
	function baca_satuan_jual_report($id)
	{
		if (!empty($id)) {
			// return DB::table('satuanjuals')->where('id', $id)->first()->nama;
			return DB::table('masterobats')->join('satuanjuals', 'satuanjuals.id', '=', 'masterobats.satuanjual_id')->where('masterobats.id', $id)->first()->nama;
		} else {
			return NULL;
		}
	}
}


if (!function_exists('baca_satuan_beli')) {
	function baca_satuan_beli($id)
	{
		if (!empty($id)) {
			return DB::table('satuanbelis')->where('id', $id)->first()->nama;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_obat')) {
	function baca_obat($id)
	{
		if (!empty($id)) {
			return DB::table('masterobats')->where('id', $id)->first()->nama;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('opnameMasuk')) {
	function opnameMasuk($id)
	{
		if (!empty($id)) {
			return DB::table('logistik_stocks')->where('opname_id', $id)->first()->masuk;
		} else {
			return NULL;
		}
	}
}

function generateRmId()
{
	$pasien = DB::table('pasiens')->orderBy('mr_id', 'DESC')->first();
	@$mr_id = @$pasien->mr_id + 1;
	return @$mr_id;
}

function signature_bpjs()
{
	$ID = config('app.consid_antrean');
	date_default_timezone_set('Asia/Jakarta');
	$t = time();
	$data = "$ID&$t";
	$secretKey = config('app.secretkey_antrean');
	$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));
	// dd($completeurl);
	$arrheader = array(
		'X-cons-id: ' . $ID,
		'X-timestamp: ' . $t,
		'X-signature: ' . $signature,
		'user_key:' . config('app.user_key_antrean'),
		'Content-Type: application/json',
	);
	return $arrheader;
}
function generateKodeBooking()
{
	$noantri = DB::table('registrasis')->where('nomorantrian', 'like', date('dmY') . '%')->count();
	$nomorantrian = date('dmY') . sprintf("%04s", $noantri + 1);
	return $nomorantrian;
}

if (!function_exists('stok')) {
	function stok($id)
	{
		if (!empty($id)) {
			return DB::table('logistik_stocks')->where('masterobat_id', $id)->first()->total;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('historimasuk')) {
	function historimasuk($id)
	{
		if (!empty($id)) {
			return DB::table('logistik_stocks')->where('masterobat_id', $id)->first()->masuk;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('expired')) {
	function expired($id)
	{
		if (!empty($id)) {
			return DB::table('logistik_stocks')->where('masterobat_id', $id)->first()->expired_date;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('historikeluar')) {
	function historikeluar($id)
	{
		if (!empty($id)) {
			return DB::table('logistik_stocks')->where('masterobat_id', $id)->first()->keluar;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('opnameKeluar')) {
	function opnameKeluar($id)
	{
		if (!empty($id)) {
			return DB::table('logistik_stocks')->where('opname_id', $id)->first()->masuk;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('ExpiredDate')) {
	function ExpiredDate($id)
	{
		if (!empty($id)) {
			return DB::table('logistik_stocks')->where('opname_id', $id)->first()->expired_date;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('Ket')) {
	function Ket($id)
	{
		if (!empty($id)) {
			return DB::table('logistik_stocks')->where('masterobat_id', $id)->first()->keterangan;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_obat_harga')) {
	function baca_obat_harga($masterobat_id)
	{
		if (!empty($masterobat_id)) {
			return DB::table('masterobats')->where('id', '=', $masterobat_id)->first()->hargajual;
		} else {
			return null;
		}
	}
}
if (!function_exists('baca_diagnosa_im')) {
	function baca_diagnosa_im($kode = '')
	{
		if (!empty($kode)) {
			// return $kode;
			// $db = DB::table('icd10s')->where('nomor', $kode)->first();
			$db = DB::table('icd10_im')->where('code', $kode)->first();
			if(!$db){
				$db = DB::table('icd10s')->where('nomor', $kode)->first();
				if($db){
					return @$db->nama;
				}
			}

			if($db){
				$nama = @$db->code.' '.@$db->description;
				if ($db->im == 1) {
					$nama .= ' <span style="color:red;">(IM Tidak Berlaku)</span>';
				}
				return $nama;
			}else{
				return NULL;

			}
		} else {
			return NULL;
		}
	}
}
if (!function_exists('baca_prosedur_im')) {
	function baca_prosedur_im($kode = '')
	{
		if (!empty($kode)) {
			// $db =  DB::table('icd9s')->where('nomor', $kode)->first();
			$db =  DB::table('icd9_im')->where('code', $kode)->first();
			if(!$db){
				$db =  DB::table('icd9s')->where('nomor', $kode)->first();
				if($db){
					return @$db->nama;
				}
			}


			if($db){
				$nama = @$db->description;
				if ($db->im == 1) {
					$nama .= ' <span style="color:red;">(IM Tidak Berlaku)</span>';
				}
				return $nama;
			}else{
				return NULL;

			}
		} else {
			return NULL;
		}
	}
}
if (!function_exists('format_icd9')) {
	function format_icd9($kode = ''){
		if(empty($kode) || $kode == '#'){
			return '#';
		}
		// Ambil value original
		$procedures = $kode;

		// 1️⃣ Pecah jadi array berdasarkan '#'
		$proceduresArray = explode('#', $procedures);

		// 2️⃣ Hapus bagian +qty (contoh: "86.22+2" -> "86.22")
		$cleanedProcedures = array_map(function ($p) {
			return preg_replace('/\+.*/', '', trim($p)); // tambah trim biar gak ada spasi
		}, $proceduresArray);

		// 3️⃣ Hapus duplikat dan elemen kosong
		$cleanedProcedures = array_filter(array_unique($cleanedProcedures));

		// 4️⃣ Gabungkan kembali jadi string
		$req = implode('#', $cleanedProcedures);

		return $req;
	}
}

function totalRs($reg_id = '')
{
	$total = DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', $reg_id)->sum('total');
	return 'Rp. ' . number_format($total);
}

function totalEklaim($reg_id = '')
{
	$total = DB::table('inacbgs')->where('registrasi_id', $reg_id)->first();
	if ($total) {
		return 'Rp. ' . number_format($total->dijamin);
	} else {
		return '';
	}
}
if (!function_exists('penanggungJawabSep')) {
	function penanggungJawabSep($x)
	{
		if (!empty($x)) {
			switch ($x) {
				case '1':
					$x = 'Pribadi';
					break;
				case '2':
					$x = 'Pemberi Kerja';
					break;
				case '3':
					$x = 'Asuransi Kesehatan Tambahan';
					break;
			}
			return $x;
		}
	}
}
function kodeInacbgs($reg_id = '')
{
	$total = DB::table('inacbgs')->where('registrasi_id', $reg_id)->first();
	if ($total) {
		return $total->kode;
	} else {
		return '';
	}
}

function cekEkpertise($reg_id = '')
{
	$total = DB::table('radiologi_ekspertises')->where('registrasi_id', $reg_id)->count();
	return $total;
}

function satusehat()
{
	$total = DB::table('configs')->where('status_satusehat', '1')->first();
	return $total;
}
function jamLaporan($laporan)
{
	// $keyCache = 'jam_laporan';
	// $data = Cache::get($keyCache);

	// if($data){
	// 	return $data;
	// }else{
	$data = DB::table('jam_laporans')->where('nama', $laporan)->first();
	// Cache::put($keyCache,$data,120);
	// }


	if ($data) {

		$jam_sekarang = date('H:i:s');
		$jam_buka     = $data->jam_buka;
		$jam_tutup     = $data->jam_tutup;
		if ($jam_sekarang >= $jam_buka) {
			if ($jam_sekarang <= $jam_tutup) {
				return true; //BUKA
			} else {
				return false; //TUTUP
			}
		} else {
			return false; //TUTUP
		}

		// JIKA TIDAK ADA DATA
	} else {
		return true;
	}
}
function validasi_sep()
{
	$total = DB::table('configs')->where('status_validasi_sep', '1')->first();
	return $total;
}

function tte()
{
	$total = DB::table('configs')->where('status_tte', '1')->first();
	return $total;
}

function cekDetailObat($no_resep = '')
{
	$total = DB::table('penjualandetails')->where('no_resep', $no_resep)->count();
	return $total;
}


function cekPenjualan($reg_id)
{
	$total = DB::table('penjualans')->where('registrasi_id', $reg_id)->first();
	if ($total) {
		return $total->id;
	} else {
		return '';
	}
}

function periode($id)
{
	$total = DB::table('logistik_periodes')->where('id', $id)->first();
	if ($total) {
		return $total->nama;
	} else {
		return '';
	}
}


if (!function_exists('cekBatchOpname')) {
	function cekBatchOpname($logistik_batch = '')
	{
		$data = DB::table('logistik_opnames')->where('logistik_batch_id', $logistik_batch)->where('created_at', 'like', date('Y-m') . '%')->count();

		if ($data != null) {
			return $data;
		} else {
			return 0;
		}
	}
}

if (!function_exists('baca_batches')) {
	function baca_batches($id)
	{
		return isset(DB::table('logistik_batches')->where('id', $id)->first()->nama_obat) ? DB::table('logistik_batches')->where('id', $id)->first()->nama_obat : $id;
	}
}

function batch($id)
{
	$total = DB::table('logistik_batches')->where('id', $id)->first();
	if ($total) {
		return $total->nomorbatch;
	} else {
		return '';
	}
}
function expiredobat($id)
{
	$total = DB::table('logistik_batches')->where('id', $id)->first();
	if ($total) {
		return $total->expireddate;
	} else {
		return '';
	}
}

function randomWaktu()
{
	$starttime = round(microtime(true) * 1000);
	$min = 5;
	$max = 10;
	$endtime = $starttime + rand($min, $max) * 60 * 1000;

	return $endtime;
}
function randomWaktu1()
{
	$starttime = round(microtime(true) * 1000);
	$min = 1;
	$max = 3;
	$endtime = $starttime + rand($min, $max) * 60 * 1000;

	return $endtime;
}
function randomWaktu2()
{
	$starttime = round(microtime(true) * 1000);
	$min = 1;
	$max = 5;
	$endtime = $starttime + rand($min, $max) * 60 * 1000;

	return $endtime;
}
function randomWaktu3()
{
	$starttime = round(microtime(true) * 1000);
	$min = 5;
	$max = 7;
	$endtime = $starttime + rand($min, $max) * 60 * 1000;

	return $endtime;
}

if (!function_exists('pernapasan_ews_maternal')) {
	function pernapasan_ews_maternal()
	{
		$data = ['> 30,3', '21-30,2', '10-20,0', '< 10,3'];
		return $data;
	}
}
if (!function_exists('spo2_ews_maternal')) {
	function spo2_ews_maternal()
	{
		$data = ['91-100%,0', '=< 90%,2'];
		return $data;
	}
}
if (!function_exists('suhu_ews_maternal')) {
	function suhu_ews_maternal()
	{
		$data = ['39,3', '38,2', '37,1', '36,0', '35,3'];
		return $data;
	}
}
if (!function_exists('freqjan_ews_maternal')) {
	function freqjan_ews_maternal()
	{
		$data = ['150,3', '140,3', '130,2', '120,2', '110,1', '100,1', '90,0', '80,0', '70,0', '60,0', '50,2', '40,3'];
		return $data;
	}
}
if (!function_exists('sitolik_ews_maternal')) {
	function sitolik_ews_maternal()
	{
		$data = ['200,3', '190,3', '180,3', '170,3', '160,2', '150,2', '140,2', '130,0', '120,0', '110,0', '100,0', '90,0', '80,1', '70,1', '60,2', '50,3'];
		return $data;
	}
}
if (!function_exists('diastolik_ews_maternal')) {
	function diastolik_ews_maternal()
	{
		$data = ['130,3', '120,3', '110,2', '100,2', '90,1', '80,0', '70,0', '60,0', '50,1', '40,3'];
		return $data;
	}
}
if (!function_exists('nyeri_ews_maternal')) {
	function nyeri_ews_maternal()
	{
		$data = ['0,0', '1-3,1', '4-6,2', '> 7,3'];
		return $data;
	}
}
if (!function_exists('skorlain_ews_anak')) {
	function skorlain_ews_anak()
	{
		$data = ['Inhalasi 1/4 Jam,2', 'Post Op : Muntah,2'];
		return $data;
	}
}
if (!function_exists('pernafasan_ews_anak')) {
	function pernafasan_ews_anak()
	{
		$data = ['Tidak Ada Retraksi,0', 'Cuping Hidung / O2 1-3 Lpm,1', 'Retraksi Dada / O2 4-6 Lpm,2', 'Stridor / O2 7-8 Lpm,3'];
		return $data;
	}
}
if (!function_exists('kulit_ews_anak')) {
	function kulit_ews_anak()
	{
		$data = ['1 - 20 dtk / PINK,0', '3 dtk / Pucat,1', '4 dtk / Sianosis,2', '>= 5 dtk / Mottle,3'];
		return $data;
	}
}

if (!function_exists('perilaku_ews_anak')) {
	function perilaku_ews_anak()
	{
		$data = ['Sadar / Bermain,0', 'Respon Terhadap SUARA,1', 'Respon Terhadap NYERI,2', 'Tidak Respon Terhadap NYERI,3'];
		return $data;
	}
}

if (!function_exists('tingkat_kesadaran_ews_neonatus')) {
	function tingkat_kesadaran_ews_neonatus()
	{
		$data = ['State 5,2', 'State 4,1', 'State 3-1,3'];
		return $data;
	}
}

if (!function_exists('suhu_ews_neonatus')) {
	function suhu_ews_neonatus()
	{
		$data = ['>37.6,3', '37.5-36.5,2', '36.4-35.1,1', '<35,3'];
		return $data;
	}
}

if (!function_exists('frekuensi_nafas_ews_neonatus')) {
	function frekuensi_nafas_ews_neonatus()
	{
		$data = ['>81,3', '80-61,1', '60-40,2', '39-26,1', '<25,3'];
		return $data;
	}
}

if (!function_exists('denyut_jantung_ews_neonatus')) {
	function denyut_jantung_ews_neonatus()
	{
		$data = ['>181,3', '180-161,1', '160-100,2', '99-60,1', '<59,3'];
		return $data;
	}
}

if (!function_exists('saturasi_ews_neonatus')) {
	function saturasi_ews_neonatus()
	{
		$data = ['>95,2', '94-90,1', '<90,3'];
		return $data;
	}
}

if (!function_exists('crt_ews_neonatus')) {
	function crt_ews_neonatus()
	{
		$data = ['1-2",2', '3",1', '>3",3'];
		return $data;
	}
}

if (!function_exists('ews')) {
	function ews($value, $type)
	{
		if ($type == 'skor') {
			return @explode(',', @$value)[1]; //Menampilkan skor
		} else {
			return @explode(',', @$value)[0]; //Menampilkan nilai
		}
	}
}

if (!function_exists('cek_status_reg')) {
	function cek_status_reg($str)
	{
		if (!empty($str)) {
			if (strpos($str, 'I') !== false) {
				return "I";
			} else if (strpos($str, 'J') !== false) {
				return "J";
			} else if (strpos($str, 'G') !== false) {
				return "G";
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
}

function munculkanDokterTarif($diagnosa, $keyword)
{
	$haystack = $diagnosa;
	$needle   = $keyword;

	if (str_contains($haystack, $needle)) {
		return true;
	} else {
		return false;
	}
}
function status_consid($consid)
{
	$total = DB::table('conf_consid')->where('consid', $consid)->first();
	if ($total) {
		return $total->aktif;
	}
	return '';
}

function status_antrolo()
{
	$total = DB::table('conf_consid')->where('consid', 'antr')->first();
	if ($total) {
		return $total->aktif;
	}
	return 1;
}

function hitung_kuota_poli_jkn($id, $tgl)
{

	$hari = 'jkn_' . strtolower(date('l', strtotime($tgl)));
	// dd($hari);
	$kuota_poli = DB::table('polis')->where('id', $id)->first()->$hari;

	return $kuota_poli;
}
function hitung_kuota_poli_dokter_jkn($dokter_id, $tgl)
{

	$hari = 'jkn_' . strtolower(date('l', strtotime($tgl)));
	// dd($hari);
	$kuota_poli = DB::table('kuota_dokter')->where('pegawai_id', $dokter_id)->first()->$hari;
	
	return $kuota_poli;
}

function cekKatarak($diagnosa)
{
	$haystack = $diagnosa;
	$needle   = 'cataract';

	if (str_contains($haystack, $needle)) {
		return true;
	} else {
		return false;
	}
}

function ttdPasienBpjs($tgl_reg)
{
	$tgl_berlaku = '2025-02-06';
	$tgl_reg = date('Y-m-d',strtotime($tgl_reg));
	
	if($tgl_reg >= $tgl_berlaku) {
		return true;
	}else{
		return false;
	}
}

if (!function_exists('cek_jenis_reg')) {
	function cek_jenis_reg($str)
	{
		if (!empty($str)) {
			if (strpos($str, 'I') !== false) {
				return "Rawat Inap";
			} else if (strpos($str, 'J') !== false) {
				return "Rawat Jalan";
			} else if (strpos($str, 'G') !== false) {
				return "Rawat Darurat";
			} else if (strpos($str, 'R') !== false) {
				return "Radiologi Langsung";
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
}

function updateTaskId($taskid, $kodebooking)
{

	$ID = config('app.consid_antrean');
	date_default_timezone_set('Asia/Jakarta');
	$t = time();
	$dat = "$ID&$t";
	$secretKey = config('app.secretkey_antrean');
	$signature = base64_encode(hash_hmac('sha256', utf8_encode($dat), utf8_encode($secretKey), true));
	$completeurl = config('app.antrean_url_web_service') . "antrean/updatewaktu";
	$arrheader = array(
		'X-cons-id: ' . $ID,
		'X-timestamp: ' . $t,
		'X-signature: ' . $signature,
		'user_key:' . config('app.user_key_antrean'),
		'Content-Type: application/json',
	);
	// dd($re);
	$updatewaktu   = '{
		"kodebooking": "' . $kodebooking . '",
		"taskid": "' . $taskid . '",
		"waktu": "' . round(microtime(true) * 1000) . '"
	}';
	$session2 = curl_init($completeurl);
	curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
	curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
	curl_setopt($session2, CURLOPT_POST, TRUE);
	curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
	$exec = curl_exec($session2);
	// dd($exec);

	@$history = new TaskidLog();
	@$history->response = @$exec;
	@$history->url = url()->full();
	@$history->nomorantrian = @$kodebooking;
	@$history->taskid = @$taskid;
	@$history->save();
}


if (!function_exists('cek_jenis_lis')) {
	function cek_jenis_lis($str)
	{
		if (!empty($str)) {
			if (strpos($str, 'I') !== false) {
				return "Rawat Inap";
			} else if (strpos($str, 'J') !== false) {
				return "Rawat Jalan";
			} else if (strpos($str, 'G') !== false) {
				return "IGD";
			} else {
				return "Rawat Jalan";
			}
		} else {
			return null;
		}
	}
}
function RemoveSpecialChar($str)
{

	// Using str_replace() function
	// to replace the word
	$res = str_replace(array(
		'\'', '"',
		',', ';', '<', '>', "'"
	), ' ', $str);

	// Returning the result
	return $res;
}
if (!function_exists('baca_jenispasien')) {
	function baca_jenispasien($str)
	{
		if (!empty($str)) {
			if (strpos($str, 'I') !== false) {
				return "Inap";
			} else if (strpos($str, 'J') !== false) {
				return "Jalan";
			} else if (strpos($str, 'G') !== false) {
				return "Darurat";
			} else {
				return "Jalan";
			}
		} else {
			return null;
		}
	}
}
function getGroupKelas()
{
	$data_kelompok_kelas = \App\Kelompokkelas::all();
	$data['kelompok_kelas'] = [];
	foreach ($data_kelompok_kelas as $kel) {
		$data['kelompok_kelas'][] = str_word_count($kel->kelompok) > 1 ? explode(' ', $kel->kelompok)[0] : $kel->kelompok;
	}
	return array_unique($data['kelompok_kelas']);
}
if (!function_exists('cek_kode_jenis_lis')) {
	function cek_kode_jenis_lis($str)
	{
		if (!empty($str)) {
			if (strpos($str, 'I') !== false) {
				return 1;
			} else if (strpos($str, 'J') !== false) {
				return 2;
			} else if (strpos($str, 'G') !== false) {
				return 3;
			} else {
				return 2;
			}
		} else {
			return null;
		}
	}
}

if (!function_exists('cek_folio_counts')) {
	function cek_folio_counts($reg_id, $poli_id, $jenis = 'TA')
	{
		if (!empty($reg_id) || !empty($poli_id)) {
			$count = DB::table('folios')->whereNull('deleted_at')->where('registrasi_id', '=', $reg_id)->where('poli_id', '=', $poli_id)->where('jenis', '=', $jenis)->count();
			return $count;
		} else {
			return 0;
		}
	}
}

if (!function_exists('baca_rencanakontrol')) {
	function baca_rencanakontrol($id = '')
	{
		if (!empty($id)) {
			$rencana =  DB::table('bpjs_rencana_kontrol')->where('resume_id', $id)->first();
			if (isset($rencana->month_only)) {
				if ($rencana->month_only) {
					return \Carbon\Carbon::parse($rencana->tgl_rencana_kontrol)->format('F Y');
				} else {
					return \Carbon\Carbon::parse($rencana->tgl_rencana_kontrol)->format('d F Y');
				}
			} else {
				return NULL;
			}
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_dokter_bpjs')) {
	function baca_dokter_bpjs($kode_bpjs)
	{
		if (!empty($kode_bpjs)) {
			$cek = DB::table('pegawais')->where('kode_bpjs', $kode_bpjs)->count();
			if ($cek > 0) {
				return DB::table('pegawais')->where('kode_bpjs', $kode_bpjs)->first()->nama;
			} else {
				return '';
			}
		} else {
			return null;
		}
	}
}
// FAIQ
if (!function_exists('baca_tipe_reg')) {
	function baca_tipe_reg($x)
	{
		if (!empty($x)) {
			switch ($x) {
				case 'J':
					$b = 'RAWAT JALAN';
					break;
				case 'G':
					$b = 'IGD';
					break;
				case 'I':
					$b = 'RAWAT INAP';
					break;
			}
			return $b;
		}
	}
}

function convertUnit($unit)
{
	if (substr($unit, 0, 1) == 'G') {
		return 'ird';
	} elseif (substr($unit, 0, 1) == 'J') {
		return 'irj';
	} else {
		return 'irn';
	}
}

if (!function_exists('convert_hari')) {
	function convert_hari($hari)
	{
		$daftar_hari = [
			'Senin' => 1,
			'Selasa' => 2,
			'Rabu' => 3,
			'Kamis' => 4,
			'Jumat' => 5,
			'Sabtu' => 6,
			'Minggu' => 7
		];
		return $daftar_hari[$hari];
	}
}
if (!function_exists('convert_hari_hfis')) {
	function convert_hari_hfis($hari)
	{
		$daftar_hari = [
			1 => 'Senin',
			2 => 'Selasa',
			3 => 'Rabu',
			4 => 'Kamis',
			5 => 'Jumat',
			6 => 'Sabtu',
			7 => 'Minggu',
			8 => 'Libur Nasional'
		];
		return $daftar_hari[$hari];
	}
}


if (!function_exists('baca_dokter_kode')) {
	function baca_dokter_kode($id)
	{
		if (!empty($id)) {
			$cek = DB::table('pegawais')->where('id', '=', $id)->count();
			if ($cek > 0) {
				return DB::table('pegawais')->where('id', '=', $id)->first()->kode_bpjs;
			} else {
				return '';
			}
		} else {
			return null;
		}
	}
}

if (!function_exists('baca_unit')) {
	function baca_unit($x)
	{
		if (!empty($x)) {
			switch ($x) {
				case 'jalan':
					$b = 'RAWAT JALAN';
					break;
				case 'igd':
					$b = 'IGD';
					break;
				case 'inap':
					$b = 'RAWAT INAP';
					break;
			}
			return $b;
		}
	}
}

function cekNoSurkon($nomorkartu)
{
	$tahun = date('Y');
	list($ID, $t, $signature) = HashBPJS();
	// dd($nomor);
	// $bulan = 7;
	$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/ListRencanaKontrol/Bulan/" . date('m') . "/Tahun/" . $tahun . "/Nokartu/" . $nomorkartu . "/filter/2";
	$response = xrequest($completeurl, $signature, $ID, $t);
	// dd($response);
	if (!$response) {
		return $response;
	}
	if ($response == 'Authentication failed') {
		$json = [['metaData' => ['code' => '201', 'message' => 'Authentication failed']]];
		return response()->json(json_encode($json, JSON_PRETTY_PRINT));
	}
	$array[] = json_decode($response, true);
	$stringEncrypt = stringDecrypt($ID . config('app.sep_key') . $t, $array[0]['response']);
	$array[] = json_decode(decompress($stringEncrypt), true);

	$sml = json_encode($array, JSON_PRETTY_PRINT);
	$json = json_decode($sml, true);
	// dd($json);
	return $json;
}

function cekRujukan($nomor)
{
	list($ID, $t, $signature) = HashBPJS();

	$completeurl = config('app.sep_url_web_service') . "/Rujukan/" . $nomor;
	$response = xrequest($completeurl, $signature, $ID, $t);
	if ($response == 'Authentication failed') {
		$json = [['metaData' => ['code' => '201', 'message' => 'Authentication failed']]];
		return response()->json(json_encode($json, JSON_PRETTY_PRINT));
	}
	$array[] = json_decode($response, true);
	$stringEncrypt = stringDecrypt($ID . config('app.sep_key') . $t, $array[0]['response']);
	$array[] = json_decode(decompress($stringEncrypt), true);

	$sml = json_encode($array, JSON_PRETTY_PRINT);
	$json = json_decode($sml, true);
	return $json;
}
function searchForId($id, $array)
{
	// dd($id,$array);
	foreach ($array as $key => $val) {
		if ($val['kodedokter'] == $id) {
			return $val['jadwal'];
		}
	}
	return 'Maaf Dokter Tidak Tersedia';
}
function jadwalDokterHfis($poli, $kodedokter, $tgl)
{
	// dd($request);
	// dd([$tgl,$poli]);
	$ID = config('app.consid_antrean');
	date_default_timezone_set('Asia/Jakarta');
	$t = time();
	$data = "$ID&$t";
	$secretKey = config('app.secretkey_antrean');
	$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

	$completeurl = config('app.antrean_url_web_service') . "jadwaldokter/kodepoli/" . $poli . "/tanggal/" . $tgl;
	// $completeurl =config('app.antrean_url_web_service')."jadwaldokter/kodepoli/" . $poli . "/tanggal/2023-06-05";
	// dd($completeurl);
	$session = curl_init($completeurl);
	// dd($session);
	$arrheader = array(
		'x-cons-id: ' . $ID,
		'x-timestamp: ' . $t,
		'x-signature: ' . $signature,
		'user_key:' . config('app.user_key_antrean'),
		'Content-Type: application/json',
	);
	curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
	curl_setopt($session, CURLOPT_HTTPGET, 1);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

	$response = curl_exec($session);

	// return $response;
	// dd($response['metadata']['code']);

	$message = json_decode($response, true);
	if ($response == 'Authentication failed') {
		$json = [['metaData' => ['code' => '201', 'message' => 'Authentication failed']]];
		return response()->json(json_encode($json, JSON_PRETTY_PRINT));
	}
	$array[] = json_decode($response, true);

	if ($message['metadata']['code'] == 200) {
		$stringEncrypt = stringDecrypt($ID . config('app.secretkey_antrean') . $t, $array[0]['response']);
		$array[] = json_decode(decompress($stringEncrypt), true);
	} else {
		$array[] = json_decode($response, true);
	}

	$sml = json_encode($array, JSON_PRETTY_PRINT);
	// dd($sml);
	if (!$sml) {
		return ['status' => 201, 'result' => 'Maaf, Gangguan terhubung ke WS BPJS'];
	}

	// return json_decode($sml,true);
	// dd($json);
	// dd(searchForId($kodedokter,$json[1]));
	$json = json_decode($sml, true);
	// dd($json);
	// dd(searchForId($kodedokter,$json[1]));
	if ($json[0]['metadata']['code'] == '201') {
		return ['status' => 201, 'result' => 'Maaf,jadwal dokter tidak tersedia'];
	} else {
		return ['status' => 200, 'result' => searchForId($kodedokter, $json[1])];
		// return ;
	}
}
function sisaKuotaJkn($poli, $tgl)
{
	$sisaKuotaJkn  = \App\RegistrasiDummy::where('tglperiksa', $tgl)
		->where('kode_poli', $poli)
		->where('kode_cara_bayar', '1')
		->count();

	return $sisaKuotaJkn;
}
function sisaKuotaNonJkn($poli, $tgl)
{
	$sisaKuotaNonJkn  = \App\RegistrasiDummy::where('tglperiksa', $tgl)
		->where('kode_poli', $poli)
		->where('kode_cara_bayar', '2')
		->count();
	return $sisaKuotaNonJkn;
}




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

function HashBPJS()
{
	$ID = config('app.sep_id');
	$t = time();
	$data = "$ID&$t";
	$secretKey = config('app.sep_key');

	date_default_timezone_set('Asia/Jakarta');
	$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
	$signature = hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true);
	$encodedSignature = base64_encode($signature);
	// $encodedSignature = \LZCompressor\LZString::compressToBase64($signature);;
	return array($ID, $t, $encodedSignature);
}

// SUDAH V2
function xrequest($url, $signature, $ID, $t)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

	$headers = array();
	$headers[] = "Accept: application/json";
	$headers[] = "Content-Type: application/json";
	$headers[] = "X-Cons-Id:" . $ID;
	$headers[] = "X-Timestamp:" . $t;
	$headers[] = "X-Signature:" . $signature;
	$headers[] = "user_key:" . config('app.user_key');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);

	$response = curl_exec($ch);
	if (curl_errno($ch)) {
		$message = 'Error:' . curl_error($ch);
	}
	curl_close($ch);
	return $response;
}



if (!function_exists('baca_jenis_unit')) {
	function baca_jenis_unit($x)
	{
		if (!empty($x)) {
			switch ($x) {
				case 'jalan':
					$b = 'TA';
					break;
				case 'igd':
					$b = 'TG';
					break;
				case 'inap':
					$b = 'TI';
					break;
			}
			return $b;
		}
	}
}


if (!function_exists('baca_nomorantrian_bpjs')) {
	function baca_nomorantrian_bpjs($nomorantrian)
	{
		if ($nomorantrian == null || strlen($nomorantrian) <= 8) {
			// Bukan antrian online
			return false;
		}
		$antrian = substr($nomorantrian, 8); // start dari index ke 8 sampai akhir
		if (!preg_match('/[a-zA-Z]/', $antrian)) {
			// Bukan antrian BPJS
			return false;
		}
		return $antrian;
	}
}

if (!function_exists('split_nomorantrian_online')) {
	function split_nomorantrian_online($nomorantrian)
	{
		if (preg_match("/([A-Za-z]+)([0-9]+)/", $nomorantrian, $matches)) {
			return $matches;
		} else {
			return false;
		}
	}
}

if (!function_exists('dateTimeUTC')) {
	/** 
	 * Convert Y-m-d H:i:s Asia/jakarta ke iso8601 UTC+00
	 */
	function dateTimeUTC($datetime)
	{
		return Carbon::parse($datetime)->setTimezone('UTC')->toIso8601String();
	}
}
if (!function_exists('dateTimeUTC07')) {
	/** 
	 * Convert Y-m-d H:i:s Asia/jakarta ke iso8601 UTC+00
	 */
	function dateTimeUTC07($datetime)
	{
		return Carbon::parse($datetime)->setTimezone('Asia/Jakarta')->toIso8601String();
	}
}

function getResponseTime($session)
{
	curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
	if (curl_exec($session)) {
		$info = curl_getinfo($session);
		$status = 'Terhubung';
	} else {
		$info['total_time'] = '0';
		$status = 'Terputus';
	}

	curl_close($session);
	return response()->json(['status' => $status, 'ping' => round($info['total_time'] * 1000)]);
	// return 'Took ' . $info['total_time'] . ' seconds to transfer a request to ' . $info['url'];
}


if (!function_exists('tte_invisible')) {
	function tte_invisible($filepath, $nik, $passphrase)
	{
		$session = curl_init(config('app.esign_client') . "/api/sign/pdf");
		$arrheader = array(
			'Content-Type: multipart/form-data',
			'Accept: */*',
			'Accept-Encoding: gzip, deflate, br',
			'Connection: keep-alive',
		);

		$dataPost = array(
			'file' => new CURLFile(public_path($filepath), 'application/pdf', 'e-resep.pdf'),
			"nik" => $nik,
			"passphrase" => $passphrase,
			"tampilan" => "invisible",
			"jenis_response" => "BASE64",
		);

		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POST, true);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($session, CURLOPT_USERPWD, config('app.esign_username') . ":" . config('app.esign_password'));
		curl_setopt($session, CURLOPT_POSTFIELDS, $dataPost);
		$response = curl_exec($session);
		$httpStatusCode = curl_getinfo($session, CURLINFO_HTTP_CODE);
		curl_close($session);

		return (object) ["response" => $response, "httpStatusCode" => $httpStatusCode];
	}
}

function convertTTE($prefix, $base64)
{

	if ($base64) {
		$decoded = base64_decode($base64);
		$file = uniqid(date('YmdHis')) . '.pdf';
		$path = public_path($prefix . '/' . $file);
		file_put_contents($path, $decoded);

		return $file;
	}

	return null;
}

if (!function_exists('tte_visible_koordinat')) {
	function tte_visible_koordinat($filepath, $nik, $passphrase, $tag_koordinat, $qrPath)
	{
		$session = curl_init(config('app.esign_client') . "/api/sign/pdf");
		$arrheader = array(
			'Content-Type: multipart/form-data',
			'Accept: */*',
			'Accept-Encoding: gzip, deflate, br',
			'Connection: keep-alive',
		);

		$dataPost = array(
			'file' => new CURLFile(public_path($filepath), 'application/pdf', 'e-resep.pdf'),
			"imageTTD" => new CURLFile(public_path($qrPath), 'image/png', 'image.png'),
			"nik" => $nik,
			"passphrase" => $passphrase,
			"tampilan" => "visible",
			"jenis_response" => "BASE64",
			"image" => "true",
			"width" => "60",
			"height" => "60",
			"tag_koordinat" => $tag_koordinat,
		);

		curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POST, true);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($session, CURLOPT_USERPWD, config('app.esign_username') . ":" . config('app.esign_password'));
		curl_setopt($session, CURLOPT_POSTFIELDS, $dataPost);
		$response = curl_exec($session);
		$httpStatusCode = curl_getinfo($session, CURLINFO_HTTP_CODE);
		curl_close($session);

		// Remove temp file
		File::delete(public_path($filepath));
		File::delete(public_path($qrPath));

		return (object) ["response" => $response, "httpStatusCode" => $httpStatusCode];
	}
}

if (!function_exists('baca_status_tte')) {
	function baca_status_tte($id)
	{
		$peg = DB::table('pegawais')->where('id', $id)->first();
		return $peg->status_tte ? 'aktif' : 'non_aktif';
	}
}

if (!function_exists('log_esign')) {
	function log_esign($reg_id, $response, $type, $httpCode)
	{
		return EsignLog::create([
			"registrasi_id"	=> $reg_id,
			"response"		=> $response == 0 ? NULL : $response,
			"type"			=> $type,
			"status" 		=> $httpCode == 200 ? 'success' : 'fail',
			"extra"			=> json_encode([
				"url"		=> url()->current()
			])
		]);
	}
}

if (!function_exists('log_inacbg')) {
	function log_inacbg($no_sep,$request, $response,$url)
	{
		return InacbgLog::create([
			"no_sep"	=> @$no_sep,
			"response"		=> @$response,
			"request"			=> $request,
			"url"			=> $url,
		]);
	}
}


function generateUrl($agen, $nik_agen, $accessToken, $apiUrl, $environment)
{
	$keyPair = generateKey();
	$publicKey = $keyPair['publicKey'];
	$privateKey = $keyPair['privateKey'];

	if ($environment == 'development') {

		$pubPEM = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqoicEXIYWYV3PvLIdvB
qFkHn2IMhPGKTiB2XA56enpPb0UbI9oHoetRF41vfwMqfFsy5Yd5LABxMGyHJBbP
+3fk2/PIfv+7+9/dKK7h1CaRTeT4lzJBiUM81hkCFlZjVFyHUFtaNfvQeO2OYb7U
kK5JrdrB4sgf50gHikeDsyFUZD1o5JspdlfqDjANYAhfz3aam7kCjfYvjgneqkV8
pZDVqJpQA3MHAWBjGEJ+R8y03hs0aafWRfFG9AcyaA5Ct5waUOKHWWV9sv5DQXmb
EAoqcx0ZPzmHJDQYlihPW4FIvb93fMik+eW8eZF3A920DzuuFucpblWU9J9o5w+2
oQIDAQAB
-----END PUBLIC KEY-----";
	} elseif ($environment == 'production') {

		$pubPEM = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxLwvebfOrPLIODIxAwFp
4Qhksdtn7bEby5OhkQNLTdClGAbTe2tOO5Tiib9pcdruKxTodo481iGXTHR5033I
A5X55PegFeoY95NH5Noj6UUhyTFfRuwnhtGJgv9buTeBa4pLgHakfebqzKXr0Lce
/Ff1MnmQAdJTlvpOdVWJggsb26fD3cXyxQsbgtQYntmek2qvex/gPM9Nqa5qYrXx
8KuGuqHIFQa5t7UUH8WcxlLVRHWOtEQ3+Y6TQr8sIpSVszfhpjh9+Cag1EgaMzk+
HhAxMtXZgpyHffGHmPJ9eXbBO008tUzrE88fcuJ5pMF0LATO6ayXTKgZVU0WO/4e
iQIDAQAB
-----END PUBLIC KEY-----";
	}

	// Set the request data
	$data = array(
		'agent_name' => $agen,
		'agent_nik' => $nik_agen,
		'public_key' => $publicKey
	);

	$jsonData = json_encode($data);

	$encryptedPayload = encryptMessage($jsonData, $pubPEM);

	// Initialize cURL
	$ch = curl_init();

	// Set the cURL options
	curl_setopt($ch, CURLOPT_URL, $apiUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $encryptedPayload);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'X-Debug-Mode: 0',
		'Content-Type: text/plain',
		'Authorization: Bearer ' . $accessToken
	));

	// Execute the request
	$response = curl_exec($ch);

	// Check for cURL errors
	if (curl_errno($ch)) {
		echo 'cURL error: ' . curl_error($ch);
	}

	// Close cURL
	curl_close($ch);

	// Output the response
	return decryptMessage($response, $privateKey);
}

function generateKey()
{
	// Generate a new RSA key pair



	$keySize = 2048;

	$privateKey = RSA::createKey($keySize);
	$publicKey = $privateKey->getPublicKey();



	$privateKey = $privateKey->toString('PKCS8');
	$publicKey = $publicKey->toString('PKCS8');

	// dd($privateKey.PHP_EOL, $publicKey.PHP_EOL);

	// $config = [
	//     'private_key_type' => OPENSSL_KEYTYPE_RSA,
	//     'private_key_bits' => 2048,
	// ];

	// $keyPair = openssl_pkey_new($config);

	// // Extract the public key
	// $publicKey = openssl_pkey_get_details($keyPair)['key'];

	// // Export the private key
	// openssl_pkey_export($keyPair, $privateKey);

	return [
		'publicKey' => $publicKey,
		'privateKey' => $privateKey,
	];
}

function encryptMessage($message, $pubPEM)
{
	// Generate a symmetric key
	$aesKey = generateSymmetricKey(); // Generate a 256-bit key (32 bytes)

	$serverKey = PublicKeyLoader::load($pubPEM);
	$serverKey = $serverKey->withPadding(RSA::ENCRYPTION_OAEP);
	$wrappedAesKey = $serverKey->encrypt($aesKey);


	// echo ($wrappedAesKey);

	// Encrypt the message using the generated AES key
	$encryptedMessage = aesEncrypt($message, $aesKey);

	// Combine wrapped AES key and encrypted message
	$payload = $wrappedAesKey . $encryptedMessage;

	return formatMessage($payload);
}

function formatMessage($data)
{
	$dataAsBase64 = chunk_split(base64_encode($data));
	return "-----BEGIN ENCRYPTED MESSAGE-----\r\n{$dataAsBase64}-----END ENCRYPTED MESSAGE-----";
}

function generateSymmetricKey()
{
	// Generate a random key using OpenSSL
	$cryptoStrong = true;
	$key = openssl_random_pseudo_bytes(32, $cryptoStrong);

	if ($cryptoStrong !== true) {
		// Error occurred during key generation
		return null;
	}

	// Return the generated key
	return $key;
}

function aesEncrypt($data, $symmetricKey)
{

	$cipher = "aes-256-gcm";
	$ivLength = 12;
	$tag = '';
	$iv = "";

	// Generate random IV
	if (function_exists('random_bytes')) {
		$iv = random_bytes($ivLength);
	} elseif (function_exists('openssl_random_pseudo_bytes')) {
		$iv = openssl_random_pseudo_bytes($ivLength);
	} else {
		// Fallback if random bytes generation is not available
		$iv = "";
		for ($i = 0; $i < $ivLength; $i++) {
			$iv .= chr(mt_rand(0, 255));
		}
	}


	// $cipher = new AES(AES::MODE_GCM);
	$cipher = new AES('gcm');
	$cipher->setKeyLength(256);
	$cipher->setKey($symmetricKey);
	$cipher->setNonce($iv);

	$ciphertext = $cipher->encrypt($data);
	$tag = $cipher->getTag();

	// Concatenate the IV, ciphertext, and tag
	$encryptedData = $iv . $ciphertext . $tag;

	return $encryptedData;
}

function decryptMessage($message, $privateKey)
{
	$beginTag = "-----BEGIN ENCRYPTED MESSAGE-----";
	$endTag = "-----END ENCRYPTED MESSAGE-----";

	// Fetch the part of the PEM string between beginTag and endTag
	$messageContents = substr(
		$message,
		strlen($beginTag) + 1,
		strlen($message) - strlen($endTag) - strlen($beginTag) - 2
	);

	// Base64 decode the string to get the binary data
	$binaryDerString = base64_decode($messageContents);

	// Split the binary data into wrapped key and encrypted message
	$wrappedKeyLength = 256;
	$wrappedKey = substr($binaryDerString, 0, $wrappedKeyLength);
	$encryptedMessage = substr($binaryDerString, $wrappedKeyLength);

	// Unwrap the key using RSA private key
	// $unwrappedKey = unwrapKey($wrappedKey, $privateKey);

	// $key = new RSA();

	// $key->loadKey($privateKey);
	$key = PublicKeyLoader::load($privateKey);
	// $key = $key->withPadding(RSA::ENCRYPTION_OAEP);
	$aesKey = $key->decrypt($wrappedKey);


	// Decrypt the encrypted message using the unwrapped key
	$decryptedMessage = aesDecrypt($encryptedMessage, $aesKey);
	//echo "decryptedMessage = $decryptedMessage\n";

	return $decryptedMessage;
}

function aesDecrypt($encryptedData, $symmetricKey)
{
	try {
		$cipher = "aes-256-gcm";
		$ivLength = 12;

		// Extract IV and encrypted bytes
		$iv = substr($encryptedData, 0, $ivLength);
		$encryptedBytes = substr($encryptedData, $ivLength);


		$ivlen = openssl_cipher_iv_length($cipher);
		$tag_length = 16;
		$iv = substr($encryptedData, 0, $ivlen);
		$tag = substr($encryptedData, -$tag_length);
		$ciphertext = substr($encryptedData, $ivlen, -$tag_length);

		$ciphertext_raw = openssl_decrypt($ciphertext, $cipher, $symmetricKey, OPENSSL_NO_PADDING, $iv, $tag);
		return $ciphertext_raw;

		// Decrypt the data
		$decryptedData = openssl_decrypt(
			$encryptedBytes,
			$cipher,
			$symmetricKey,
			OPENSSL_RAW_DATA,
			$iv
		);

		return $decryptedData;
	} catch (Exception $e) {
		$err = 'error';
		return $err;
	}
}
function is_decimal($val)
{
	return is_numeric($val) && floor($val) != $val;
}

function asesmen_ranap_dokter()
{
	return array(
		'asesmen-awal-medis-tht',
		'asesmen-awal-medis-dalam',
		'asesmen-awal-medis-paru',
		'asesmen-awal-medis-psikiatri',
		'asesmen-awal-medis-kulit',
		'asesmen-awal-medis-bedah',
		'asesmen-awal-medis-gigi',
		'asesmen-awal-medis-neurologi',
		'asesmen-awal-medis-mata',
		'asesmen-awal-medis-bedah-mulut',
		'asesmen-awal-medis-rehab-medik',
		'asesmen-awal-medis-gizi',
		'asesmen-awal-medis-onkologi',
		'asesmen-awal-medis-anak',
		'asesmen-awal-medis-obgyn',
		'asesmen-awal-medis-neonatus'
	);
}

function asesmen_ranap_perawat()
{
	return array(
		'inap-perawat-anak',
		'inap-perawat-dewasa',
		'asesmen-perinatologi',
		'asesmen-awal-perawat-maternitas',
	);
}

function not_an_asesmen()
{
	return array(
		// 'asuhan-keperawatan',
		'asuhan-kebidanan',
		'pemantauan-transfusi',
		'akses-vaskular',
		'diagnosis_banding',
		'diagnosis_kerja',
		'program_terapi_rehab',
		'uji_fungsi_rehab',
		'layanan_rehab',
		'laporan-persalinan',
		'catatan-persalinan',
		'daftar-pemberian-terapi',
		'partograf',
		'triage-igd',
		'lembar-rawat-gabung',
		'pemeriksaan-fisik-askep',
		'dokumen-pemberian-informasi',
		'pernyataan-dnr',
		'catatan-harian',
		'icu',
		'formulir-edukasi-inap',
		'edukasi-inap',
		'surveilans-infeksi',
		'inap-perawat-anak',
		'asesmen-pra-bedah',
		'laporan-operasi',
		'pra-anestesi',
		'usia-kehamilan',
		'ballard-score',
		'tindakan-keperawatan',
	);
}

function smf()
{
	return [
		'0' => 'Semua',
		'1' => 'Dalam',
		'2' => 'Jantung',
		'3' => 'Bedah',
		'4' => 'Anaesthesi',
		'5' => 'Orthopedi',
		'6' => 'Saraf',
		'7' => 'Paru',
		'8' => 'Rehab',
		'9' => 'Obgyn',
		'10' => 'Anak',
		'11' => 'Kulit Kelamin',
		'12' => 'Mata',
		'13' => 'THT',
		'14' => 'Gizi',
		'15' => 'Psikiatri',
		'16' => 'Gigi',
		'17' => 'Bedah Mulut',
	];
}


function baca_discharge_cppt($cppt)
{
	@$discharge = @json_decode(@$cppt->discharge, true);
	if ($discharge) {
		foreach ($discharge['dischargePlanning'] as $key => $value) {
			if (isset($value['dipilih']) && !is_null($value['dipilih'])) {
				return $value['dipilih'];
			}
		}
	} else {
		return '';
	}
}

if (!function_exists('decodeToString')) {
    function decodeToString($value) {
        $arr = json_decode($value, true);
        if (is_array($arr)) {
            return implode(", ", $arr);
        }
        return $value;
    }
}

function hari($tanggal)
{
	$hariInggris = date('l', strtotime($tanggal));
	
	$hariIndo = [
		'Sunday'    => 'Minggu',
		'Monday'    => 'Senin',
		'Tuesday'   => 'Selasa',
		'Wednesday' => 'Rabu',
		'Thursday'  => 'Kamis',
		'Friday'    => 'Jumat',
		'Saturday'  => 'Sabtu',
	];

	return $hariIndo[$hariInggris] ?? $hariInggris;
}

function maskString($inputStr)
{
	$words = explode(' ', $inputStr);

	foreach ($words as &$word) {
		if (strlen($word) > 1) {
			$word = $word[0] . str_repeat('x', strlen($word) - 1);
		}
	}

	return implode(' ', $words);
}

function bayarUmum($reg_id,$total,$idFolio){
	$r = Registrasi::find($reg_id);
	$reg = $r;
	if (substr($r->status_reg, 0, 1) == 'G') {
		$cek_kuitansi = Pembayaran::where('no_kwitansi', 'LIKE', 'RD-' . date('Ymd') . '-%')->count() + 1;
		$no_kuitansi = 'RD-' . date('Ymd') . '-' . sprintf("%05s", $cek_kuitansi);
	} else {
		$cek_kuitansi = Pembayaran::where('no_kwitansi', 'LIKE', 'RJ-' . date('Ymd') . '-%')->count() + 1;
		$no_kuitansi = 'RJ-' . date('Ymd') . '-' . sprintf("%05s", $cek_kuitansi);
	}

	$id_condition_ss= NULL;
	if(satusehat()) {
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

		@$response_token = curl_exec($curl_token);
		@$token = json_decode($response_token);
		@$access_token = $token->access_token;
		// dd($access_token);
		curl_close($curl_token);
		// END OF API TOKEN

		//API CONDITION - MEINGGALKAN FASKES
		@$create_condition = config('app.create_condition');
		@$pasien_ss = Pasien::find(Registrasi::find($reg_id)->pasien_id)->nama;
		@$pasien_ss_id = Pasien::find(Registrasi::find($reg_id)->pasien_id)->id_patient_ss;
		@$id_encounter_ss = Registrasi::find($reg_id)->id_encounter_ss;
		$time_2 = date('H:i');
		$date = date('d F Y');
		$waktu= time();
		$today = date("Y-m-d",$waktu);

		@$curl_condition = curl_init();

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
						"system": "http://terminology.kemkes.go.id/CodeSystem/clinical-term",
						"code": "MN000001",
						"display": "Stabil"
					}
				]
			},
			"subject": {
				"reference": "Patient/'.@$pasien_ss_id.'",
				"display": "'.@$pasien_ss.'"
			},
			"encounter": {
				"reference": "Encounter/'.@$id_encounter_ss.'",
				"display": "Kunjungan '.@$pasien_ss.' pada tanggal '.@$today.'"
			}
		}',
		CURLOPT_HTTPHEADER => array(
			'Authorization: Bearer '.@$access_token.'',
			'Content-Type: application/json'
		),
		));

		@$response_condition = curl_exec($curl_condition);
		@$condition_ss = json_decode($response_condition);
		if(!empty($condition_ss->id)){
			@$id_condition_ss = @$condition_ss->id;
		}else{
			@$id_condition_ss = NULL;
		}
		// dd($id_condition_ss);
		@curl_close($curl_condition);
		// echo $response;
		//END OF API CONDITION - MEINGGALKAN FASKES
	}

	//Journal Accounting
	$journal = Journal::create([
		'id_customer'		=> $reg->pasien_id,
		'contact_type'		=> 'customer',
		'code'				=> $no_kuitansi,
		'tanggal'			=> date('Y-m-d'),
		'total_transaksi'	=> rupiah($total),
		'type'				=> 'rawat_jalan',
		'keterangan'		=> 'Jurnal Rawat Jalan a.n ' . $reg->pasien->nama,
		'verifikasi'		=> 1
	]);
	// Insert pembayaran
	$pem = new Pembayaran();
	$pem->jenis = 'tunai';
	$pem->user_id = Auth::user()->id;
	$pem->total = $total;
	$pem->metode_bayar_id = 1;
	$pem->dibayar = $total;
	$pem->iur = 0;
	$pem->flag = 'Y';
	$pem->pembayaran = 'tindakan';
	$pem->registrasi_id = $reg_id;
	$pem->dokter_id = $reg->dokter_id;
	$pem->id_condition_ss = @$id_condition_ss;
	$pem->diskon_persen = 0;
	$pem->diskon_rupiah = 0;
	$pem->no_kwitansi = $no_kuitansi;
	$pem->pasien_id = $reg->pasien_id;
	$pem->journal_id = $journal->id;

	$pem->save();
	Activity::log('kasir_' . Auth::user()->name . ' menerima pembayaran senilai ' . number_format($pem->total) . ' no kuitansi ' . $pem->no_kwitansi);
	//Update Folio
	$fol = Folio::whereIn('id', $idFolio)->get();
	if (substr($r->status_reg, 0, 1) == 'G') { // IGD
		$reg->lunas = 'Y';
	}
	// } else { // Rajal
	// 	$fol = Folio::with('tarif')->where('jenis','!=','ORJ')->where('registrasi_id', $reg_id)->where('lunas', 'N')->get();
	// }
	// $fol = Folio::with('tarif')->where('registrasi_id', $request['registrasi_id'])->where('lunas', 'N')->get();
	foreach ($fol as $key => $d) {
		$d->lunas = 'Y';
		$d->dibayar = $d->total;
		$d->waktu_dibayar = date('Y-m-d');
		$d->no_kuitansi = $pem->no_kwitansi;
		$d->update();
	}

	return($pem);
}

if (!function_exists('romawi')) {
    function romawi($bulan)
    {
        $romawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        return $romawi[(int)$bulan] ?? '';
    }

	function lokasi_kejadian()
	{
		return [
			'Klinik Anak',
			'Klinik Bedah Anak',
			'Klinik Bedah Umum',
			'Klinik Bedah Mulut',
			'Klinik Bedah Saraf',
			'Klinik Obgyn (Kandungan)',
			'Klinik Gigi dan Mulut',
			'Klinik Gigi Endodonsi',
			'Klinik Gigi Prostodonsi',
			'Klinik Gizi',
			'Klinik Hemato Onkologi',
			'Klinik Jantung',
			'Klinik Kardiologi Anak (Jantung Anak)',
			'Klinik Kemuning',
			'Klinik Kulit dan Kelamin',
			'Klinik Mata',
			'Klinik Orthopedi',
			'Klinik Penyakit Dalam',
			'Klinik Psikiatri',
			'Klinik Saraf',
			'Klinik THT',
			'Rawat Inap Mawar',
			'Rawat Inap Melati',
			'Rawat Inap Kenanga',
			'Rawat Inap Anyelir',
			'Rawat Inap Dahlia',
			'Rawat Inap Camelia',
			'Rawat Inap Bougenville',
			'Rawat Inap Lavender/Wijaya Kusuma',
			'Rawat Inap VIP Anggrek',
			'Rawat Inap VIP Rosella',
			'Rawat Inap Flamboyan',
			'ICU / NICU / PICU',
			'Instalasi Gawat Darurat (IGD)',
			'IGD Ponek',
			'Klinik Eksekutif',
			'Laboratorium',
			'Lab. Patologi Anatomi',
			'Hemodialisa',
			'Radiologi',
			'Pendaftaran IGD',
			'Pendaftaran Rawat Jalan',
			'Tempat Pendaftaran Pasien Rawat Inap (TPPRI)',
			'Kasir',
			'Lobby Utama/Pusat Informasi',
			'Parkir',
			'Masjid Al-Ikhlas RSUD Oto Iskandar Di nata',
			'Basement',
			'Management (Lantai 4)',
		];
	}
}

