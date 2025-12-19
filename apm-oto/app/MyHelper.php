<?php

function baca_tujuankunj($id){
	$daftar_hari = [
		0 => 'Normal',
		1 => 'Prosedur',
		2 => 'Konsul Dokter'
		];
		if($id){
			return $daftar_hari[$id];
		}else{
			return '';
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


function baca_flag_procedure($id) {
    $data = [
        0 => 'Prosedur Tidak Berkelanjutan',
        1 => 'Prosedur dan Terapi Berkelanjutan'
    ];

    return isset($data[$id]) ? $data[$id] : '';
}
function baca_layanan($id) {
    $layanan = [
        1  => 'Radioterapi',
        2  => 'Kemoterapi',
        3  => 'Rehabilitasi Medik',
        4  => 'Rehabilitasi Psikososial',
        5  => 'Transfusi Darah',
        6  => 'Pelayanan Gigi',
        7  => 'Laboratorium',
        8  => 'USG',
        9  => 'Farmasi',
        10 => 'Lain-Lain',
        11 => 'MRI',
        12 => 'Hemodialisa'
    ];

    return isset($layanan[$id]) ? $layanan[$id] : '';
}

function baca_alasan_kontrol($id) {
    $alasan = [
        1 => 'Poli spesialis tidak tersedia pada hari sebelumnya',
        2 => 'Jam Poli telah berakhir pada hari sebelumnya',
        3 => 'Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya',
        4 => 'Atas Instruksi RS',
        5 => 'Tujuan Kontrol'
    ];

    return isset($alasan[$id]) ? $alasan[$id] : '';
}


function cekFolio($reg_id = ''){
	$total = DB::table('folios')->where('registrasi_id', $reg_id)->where('lunas', 'N')->count();
	return $total;
}


if (!function_exists('noPo')) {
	function noPo($nomor)
	{
		$tgl = explode('/', $nomor);
		return $tgl[2];
	}
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
function dokterStatus($reg = ''){
	$peg = DB::table('pegawais')->where(['kategori_pegawai' => 1])->pluck('id');

	$fol = DB::table('logistik_opnames')->leftJoin('pegawais', 'pegawais.id', '=', 'folios.dokter_pelaksana')
		->where('folios.registrasi_id', $reg)->whereIn('folios.dokter_pelaksana', $peg)->first();
	if($fol != null){
		return $fol->nama;
	}else{
		return '';
	}
}
function mappingTindakan($reg = '', $map = '')
{
	$data = DB::table('folios')->where(['registrasi_id' => $reg, 'jenis' => 'TG', 'mapping_biaya_id' => $map])->selectRaw('SUM(total) as jumlah')->groupBy('mapping_biaya_id')->first();
	if ($data != null) {
		return $data->jumlah;
	} else {
		return 0;
	}
}

function dokterStatus2($reg = ''){
	$peg = DB::table('pegawais')->where(['kategori_pegawai' => 1])->pluck('id');

	$fol = DB::table('folios')->leftJoin('pegawais', 'pegawais.id', '=', 'folios.dokter_pelaksana')
		->where('folios.registrasi_id', $reg)->whereIn('folios.dokter_pelaksana', $peg)->first();
	if($fol != null){
		return $fol->nama;
	}else{
		return '';
	}
}

function getRange($lhr = '', $gndr = ''){
	$lahir 	= explode('||', $lhr);
	$gender	= explode('||', $gndr);
	$range	= [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
	$now	= time();
	foreach($lahir as $k => $l){
		$lhir 	= strtotime($l);
		$diff 	= $now - $lhir;
		$day 	= round($diff / (60 * 60 * 24));
		if($day < 7){
			if($gender[$k] == 'L'){
				$range[0] += 1;
			}else{
				$range[1] += 1;
			}
		}elseif($day > 6 && $day < 29){
			if($gender[$k] == 'L'){
				$range[2] += 1;
			}else{
				$range[3] += 1;
			}
		}elseif($day > 28 && $day < 366){
			if($gender[$k] == 'L'){
				$range[4] += 1;
			}else{
				$range[5] += 1;
			}
		}elseif($day > 365 && $day < 1461){
			if($gender[$k] == 'L'){
				$range[6] += 1;
			}else{
				$range[7] += 1;
			}
		}elseif($day > 1460 && $day < 5111){
			if($gender[$k] == 'L'){
				$range[8] += 1;
			}else{
				$range[9] += 1;
			}
		}elseif($day > 5110 && $day < 8761){
			if($gender[$k] == 'L'){
				$range[10] += 1;
			}else{
				$range[11] += 1;
			}
		}elseif($day > 8760 && $day < 16061){
			if($gender[$k] == 'L'){
				$range[12] += 1;
			}else{
				$range[13] += 1;
			}
		}elseif($day > 16060 && $day < 23361){
			if($gender[$k] == 'L'){
				$range[14] += 1;
			}else{
				$range[15] += 1;
			}
		}elseif($day > 23360){
			if($gender[$k] == 'L'){
				$range[16] += 1;
			}else{
				$range[17] += 1;
			}
		}
	}
	return $range;
}

function getICD9($no = ''){
	$icd9 = DB::table('icd9s')->where('nomor', $no);
	if($icd9->count() > 0)
		return $icd9->first()->nama;
	else
		return '-';
}

function totalMapping($jenis = '', $reg = '', $mapp = ''){
	$count = DB::table('folios')->where(['jenis' => $jenis, 'registrasi_id' => $reg, 'mapping_biaya_id' => $mapp])->count();
	if($count > 0){
		return DB::table('folios')->where(['jenis' => $jenis, 'registrasi_id' => $reg, 'mapping_biaya_id' => $mapp])->sum('total');
	}else{
		return 0;
	}
}

function baca_jkn($reg_id = ''){
	$reg = DB::table('registrasis')->where('id', $reg_id)->first();
	return $reg->tipe_jkn;
}

function lapPasien($reg = '', $politipe = ''){
	if($politipe == 'T'){
		$data = DB::table('folios')->where(['registrasi_id' => $reg])->sum('total');
	}else{
		$data = DB::table('folios')->where(['registrasi_id' => $reg, 'poli_tipe' => $politipe])->sum('total');
	}
	return $data;
}

function tindakanOK($reg = ''){
	$folio = DB::table('folios')->where(['registrasi_id' => $reg, 'poli_tipe' => 'O'])->get();
	return $folio;
}

function pemeriksaanIrna($dokter_id, $jenis, $tga, $tgb, $carabayar) {
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
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('jenis', $jenis)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	} else {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	}
	// $total = DB::table('folios')->where('dokter_id', $dokter_id)->where('jenis', $jenis)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	return $total;
}

//=========== KINERJA RAJAL / IGD ===============================================
function kinerjaDokter($dokter_id, $poli_id, $jenis, $tga, $tgb, $carabayar) {
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
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->where('poli_id', $poli_id)->whereIn('tarif_id', $kj)->where('jenis', $jenis)->whereIn('cara_bayar_id', $bayar)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	} else {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->where('poli_id', $poli_id)->whereIn('tarif_id', $kj)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->sum('total');
	}
	return $total;
}

function tindakan($dokter_id, $jenis, $tga, $tgb, $carabayar) {
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
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $tn)->where('jenis', $jenis)->whereIn('cara_bayar_id', $bayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	} else {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $tn)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	}
	return $total;
}

function konsultasi($dokter_id, $jenis, $tga, $tgb, $carabayar) {
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
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $ks)->where('jenis', $jenis)->whereIn('cara_bayar_id', $bayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	} else {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $ks)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	}
	return $total;
}

function pemeriksaan($dokter_id, $jenis, $tga, $tgb, $carabayar) {
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
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('jenis', $jenis)->whereIn('cara_bayar_id', $bayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	} else {
		$total = DB::table('folios')->where('dokter_id', $dokter_id)->whereIn('tarif_id', $pm)->where('jenis', $jenis)->where('cara_bayar_id', $carabayar)->whereBetween('updated_at', [$tga, $tgb])->count();
	}

	return $total;
}
//================================== END KINERJA ===================================================
function tglLOS($tanggal, $ket = NULL) {
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

function cekVerifJalan($registrasi_id, $poli_tipe) {
	$verif = DB::table('folios')->where('registrasi_id', $registrasi_id)->where('poli_tipe', $poli_tipe)->where('verif_kasa', 'Y')->count();
	return $verif;
}

function cekVerif($registrasi_id, $tarif_id) {
	$verif = DB::table('folios')->where('registrasi_id', $registrasi_id)->where('tarif_id', $tarif_id)->where('verif_kasa', 'Y')->count();
	return $verif;
}

if (!function_exists('tarif_mapping')) {
	function tarif_mapping($registrasi_id = '', $mapping_id = '') {
		if (!empty($registrasi_id && $mapping_id)) {
			return DB::table('folios')->join('tarifs', 'tarifs.id', '=', 'folios.tarif_id')
				->where('folios.registrasi_id', $registrasi_id)
				->where('tarifs.mastermapping_id', $mapping_id)
				->sum('folios.total');
		} else {
			return NULL;
		}
	}
}

if (!function_exists('tanggal_eklaim')) {
	function tanggal_eklaim($tanggal = '') {
		if (!empty(@$tanggal)) {
			$tg = explode(" ", $tanggal);
			$t = explode("-", $tg[0]);
			return $t[2] . '/' . $t[1] . '/' . $t[0];
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_carapulang')) {
	function baca_carapulang($id = '') {
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
	function baca_kategori_obat($id = '') {
		if (!empty($id)) {
			return DB::table('kategoriobats')->where('id', $id)->first()->nama;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_diagnosa')) {
	function baca_diagnosa($kode = '') {
		if (!empty($kode)) {
			// return $kode;
			return DB::table('icd10s')->where('nomor', $kode)->first()->nama;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_prosedur')) {
	function baca_prosedur($kode = '') {
		if (!empty($kode)) {
			return DB::table('icd9s')->where('nomor', $kode)->first()->nama;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('no_rm')) {
	function no_rm($no_rm = '') {
		$a = substr($no_rm, 0, 2);
		$b = substr($no_rm, 2, 2);
		$c = substr($no_rm, 4, 2);
		$d = substr($no_rm, 6, 2);
		return $a . '-' . $b . '-' . $c . '-' . $d;
	}
}

if (!function_exists('pasien_perpoli')) {
	function pasien_perpoli($tanggal, $poli_id) {
		return DB::table('histori_kunjungan_irj')->where('created_at', 'LIKE', $tanggal . '%')->where('poli_id', $poli_id)->count();
	}
}

if (!function_exists('tanggal')) {
	function tanggal($created_at) {
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
	function baca_icd10($nomor) {
		return isset(DB::table('icd10s')->where('nomor', $nomor)->first()->nama) ? DB::table('icd10s')->where('nomor', $nomor)->first()->nama : null;
	}
}

if (!function_exists('cek_tindakan')) {
	function cek_tindakan($registrasi_id, $poli_id) {
		return DB::table('folios')->where('registrasi_id', $registrasi_id)->where('poli_id', $poli_id)->count();
	}
}

if (!function_exists('baca_bed')) {
	function baca_bed($id) {
		$bed = DB::table('beds')->where('id', $id)->first();
		if ($bed) {
			return $bed->nama;
		} else {
			return NULL;
		}

	}
}

if (!function_exists('baca_pegawai')) {
	function baca_pegawai($id) {
		return isset(DB::table('pegawais')->where('id', $id)->first()->nama) ? DB::table('pegawais')->where('id', $id)->first()->nama : $id;
	}
}

if (!function_exists('baca_kelompok')) {
	function baca_kelompok($id) {
		$klpk = DB::table('kelompok_kelas')->where('id', $id)->first();
		if ($klpk) {
			return $klpk->kelompok;
		} else {
			return NULL;
		}

	}
}

if (!function_exists('baca_kamar')) {
	function baca_kamar($id) {
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

if(!function_exists('count_resume')){
	function count_resume($reg_id){
		return DB::table('resume_pasiens')->where('registrasi_id', '=', $reg_id)->count();
	}
}

if (!function_exists('baca_kelas')) {
	function baca_kelas($id) {
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
	function kode_kelas($id) {
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
	function rupiah($angka) {
		$d = str_replace('.', '', $angka);
		$r = str_replace(',', '', $d);
		return $r;
	}
}

if (!function_exists('valid_date')) {
	function valid_date($tgl_indo) {
		$t = explode('-', $tgl_indo);
		return $t[2] . '-' . $t[1] . '-' . $t[0];
	}
}

if (!function_exists('cek_jenispasien')) {
	function cek_jenispasien($registrasi_id) {
		return DB::table('registrasis')->where('id', '=', $registrasi_id)->first()->bayar;
	}
}

if (!function_exists('cek_id_pasien')) {
	function cek_id_pasien($registrasi_id) {
		return DB::table('registrasis')->where('id', '=', $registrasi_id)->first()->pasien_id;
	}
}

if (!function_exists('tgl_indo')) {
	function tgl_indo($tgl) {
		$t = explode('-', $tgl);
		return $t[2] . '-' . $t[1] . '-' . $t[0];
	}
}
if (!function_exists('baca_apoteker')) {
	function baca_apoteker($id) {
		return DB::table('apotekers')->where('id', $id)->first()->nama;
	}
}

if (!function_exists('baca_kelurahan')) {
	function baca_kelurahan($id) {
		if (!empty($id)) {
			return DB::table('villages')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}

	}
}

function hitung_kuota_poli($id,$tgl){
	$antrian_poli = DB::table('antrians')->where('poli_id', $id)->where('tanggal',$tgl)->count();
	$hari = strtolower(date('l'));
	$kuota_poli = DB::table('polis')->where('id', $id)->first()->$hari;

	if($kuota_poli == 0){
		$sisa_kuota = 0;
	}else{
		$sisa_kuota = $kuota_poli-$antrian_poli;
	}
	if($sisa_kuota <= 0){
		$sisa_kuota = 0;
	}
	return $sisa_kuota;
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
if (!function_exists('baca_norm')) {
	function baca_norm($id)
	{
		if (!empty($id)) {
			return DB::table('pasiens')->where('id', $id)->first()->no_rm;
		} else {
			return NULL;
		}
	}
}

if (!function_exists('baca_kecamatan')) {
	function baca_kecamatan($id) {
		if (!empty($id)) {
			return DB::table('districts')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}

	}
}

if (!function_exists('baca_kabupaten')) {
	function baca_kabupaten($id) {
		if (!empty($id)) {
			return DB::table('regencies')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}

	}
}

if (!function_exists('baca_propinsi')) {
	function baca_propinsi($id) {
		if (!empty($id)) {
			return DB::table('provinces')->where('id', $id)->first()->name;
		} else {
			return NULL;
		}

	}
}

if (!function_exists('cek_hasil_lab')) {
	function cek_hasil_lab($reg_id) {
		return DB::table('hasillabs')->where('registrasi_id', '=', $reg_id)->count();
	}
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
		return DB::table('folios')->where('registrasi_id', '=', $reg_id)->where('jenis', 'ORJ')->count();
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
	function total_tagihan($reg_id) {
		return DB::table('folios')->where('registrasi_id', '=', $reg_id)->where('lunas', 'N')->sum('total');
	}
}

if (!function_exists('baca_poli')) {
	function baca_poli($id) {
		if (!empty($id)) {
			return DB::table('polis')->where('id', '=', $id)->first()->nama;
		} else {
			return '';
		}
	}
}

if (!function_exists('baca_kode_poli')) {
	function baca_kode_poli($bpjs) {
		if (!empty($bpjs)) {
			return DB::table('polis')->where('bpjs', '=', $bpjs)->first()->nama;
		} else {
			return '';
		}
	}
}

if (!function_exists('baca_id_poli')) {
	function baca_id_poli($bpjs) {
		if (!empty($bpjs)) {
			return DB::table('polis')->where('bpjs', '=', $bpjs)->first()->id;
		} else {
			return '';
		}
	}
}

if (!function_exists('baca_data_poli')) {
	function baca_data_poli($bpjs) {
		if (!empty($bpjs)) {
			return DB::table('polis')->where('bpjs', '=', $bpjs)->first();
		} else {
			return '';
		}
	}
}

function searchForId($id, $array) {
	// dd($id,$array);
	foreach ($array as $key => $val) {
		if ($val['kodedokter'] == $id) {
			return $val['jadwal'];
		}
	}
	return 'Maaf Dokter Tidak Tersedia';
 }
function jadwalDokterHfis($poli,$kodedokter,$tgl) { 
	// dd($request);
	// dd([$tgl,$poli]);
	$ID = config('app.consid_antrean');
	date_default_timezone_set('Asia/Jakarta');
	$t = time();
	$data = "$ID&$t";
	$secretKey = config('app.secretkey_antrean');
	$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 
	
	$completeurl =config('app.antrean_url_web_service')."jadwaldokter/kodepoli/" . $poli . "/tanggal/" . $tgl;
	// $completeurl =config('app.antrean_url_web_service')."jadwaldokter/kodepoli/" . $poli . "/tanggal/2023-06-05";
	// dd($completeurl);
	$session = curl_init($completeurl);
	// dd($session);
	$arrheader = array(
	  'x-cons-id: ' . $ID,
	  'x-timestamp: ' . $t,
	  'x-signature: ' . $signature,
	  'user_key:'.config('app.user_key_antrean'),
	  'Content-Type: application/json',
	);
	curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
	curl_setopt($session, CURLOPT_HTTPGET, 1);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
	
	$response = curl_exec($session);
	
// return $response;
	// dd($response['metadata']['code']);
	
	$message = json_decode($response, true); 
	if($response =='Authentication failed'){
		$json = [['metaData'=>['code'=>'201','message'=>'Authentication failed']]];
		return response()->json(json_encode($json,JSON_PRETTY_PRINT));
	}
	$array[] = json_decode($response, true);
	
	if($message['metadata']['code'] == 200){
		$stringEncrypt = stringDecrypt($ID.config('app.secretkey_antrean').$t,$array[0]['response']);
		$array[] = json_decode(decompress($stringEncrypt),true);
	}else{
		$array[] = json_decode($response,true);
	}

	$sml = json_encode($array,JSON_PRETTY_PRINT); 
	// dd($sml);
	if(!$sml){
		return ['status'=>201,'result'=>'Maaf, Gangguan terhubung ke WS BPJS'];
	}
	
	// return json_decode($sml,true);
	// dd($json);
	// dd(searchForId($kodedokter,$json[1]));
	$json = json_decode($sml,true);
	// dd($json);
	// dd(searchForId($kodedokter,$json[1]));
	if($json[0]['metadata']['code'] == '201'){
		return ['status'=>201,'result'=>'Maaf,jadwal dokter tidak tersedia'];
	}else{
		return ['status'=>200,'result'=>searchForId($kodedokter,$json[1])];
		// return ;
	}
	
	
// dd($json);
// dd($json[1]['metadata']['code']);

// if($json[0]['metadata']['code'] == '201'){
// return false;
// }else{  
// foreach($json[1] as $v){
//   $cek = HfisDokter::where('kodedokter',$v['kodedokter'])->where('hari',$v['hari'])->where('kodesubspesialis',$v['kodesubspesialis'])->first();
//   // dd($v['kodesubspesialis']);
//   if(!$cek){
// 	$hfis                     = new HfisDokter();
// 	$hfis->kodesubspesialis   = $v['kodesubspesialis'];
// 	$hfis->hari   = $v['hari'];
// 	$hfis->libur   = $v['libur'];
// 	$hfis->namahari   = $v['namahari'];
// 	$hfis->jadwal   = $v['jadwal'];
// 	$hfis->jadwal_start   = explode('-',$v['jadwal'])[0];
// 	$hfis->jadwal_end   = explode('-',$v['jadwal'])[1];
// 	$hfis->namasubspesialis   = $v['namasubspesialis'];
// 	$hfis->namadokter   = $v['namadokter'];
// 	$hfis->kodepoli   = $v['kodepoli'];
// 	$hfis->namapoli   = $v['namapoli'];
// 	$hfis->kodedokter   = $v['kodedokter'];
// 	$hfis->save();
	
//   }else{
// 	$cek->jadwal   = $v['jadwal'];
// 	$cek->jadwal_start   = explode('-',$v['jadwal'])[0];
// 	$cek->jadwal_end   = explode('-',$v['jadwal'])[1];
// 	$cek->updated_at   = date('Y-m-d H:i:s');
// 	$cek->save();
//   }

// } 
// }

// dd("BERHASIL");
// dd($json[1]);
// dd(count($json[1]));
// foreach($json[1] as)
// dd(json_decode($sml,true));
	// return response()->json($sml); 
} 
function stringDecrypt($key, $string){
            
      
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
function decompress($string){
	// dd($string);
	return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
} 

function sisaKuotaJkn($poli,$tgl){
	$sisaKuotaJkn  = \App\Models\RegistrasiDummy::where('tglperiksa',$tgl)
        ->where('kode_poli',$poli)
        ->where('kode_cara_bayar','1')
        ->count();

    return $sisaKuotaJkn;
}
function sisaKuotaNonJkn($poli,$tgl){
	$sisaKuotaNonJkn  = \App\Models\RegistrasiDummy::where('tglperiksa',$tgl)
        ->where('kode_poli',$poli)
        ->where('kode_cara_bayar','2')
        ->count();
	return $sisaKuotaNonJkn;
}

if (!function_exists('baca_bpjs_poli')) {
	function baca_bpjs_poli($id) {
		if (!empty($id)) {
			return DB::table('polis')->where('id', '=', $id)->first()->bpjs;
		} else {
			return '';
		}
	}
}

if (!function_exists('baca_politipe')) {
	function baca_politipe($kode) {
		if (!empty($kode)) {
			return DB::table('politypes')->where('kode', '=', $kode)->first()->nama;
		} else {
			return '';
		}
	}
}

if (!function_exists('baca_dokter')) {
	function baca_dokter($id) {
		if (!empty($id)) {
			$cek = DB::table('pegawais')->where('id', '=', $id)->count();
			if($cek > 0){
				return DB::table('pegawais')->where('id', '=', $id)->first()->nama;
			}else{
				return '';
			}
		} else {
			return null;
		}
	}
}

if (!function_exists('baca_dokter_kode')) {
	function baca_dokter_kode($id) {
		if (!empty($id)) {
			$cek = DB::table('pegawais')->where('id', '=', $id)->count();
			if($cek > 0){
				return DB::table('pegawais')->where('id', '=', $id)->first()->kode_bpjs;
			}else{
				return '';
			}
		} else {
			return null;
		}
	}
}

if (!function_exists('baca_dokter_bpjs')) {
	function baca_dokter_bpjs($kode_bpjs) {
		if (!empty($kode_bpjs)) {
			$cek = DB::table('pegawais')->where('kode_bpjs',$kode_bpjs)->count();
			if($cek > 0){
				return DB::table('pegawais')->where('kode_bpjs',$kode_bpjs)->first()->nama;
			}else{
				return '';
			}
		} else {
			return null;
		}
	}
}
if (!function_exists('error_msg_bpjs')) {
	function error_msg_bpjs($msg) {
		if (!empty($msg)) {
			if($msg == 'tujuanKunj tidak sesuai'){
				return 'Tujuan Kunjungan Tidak Sesuai';
			}elseif($msg == 'kdPenunjang tidak sesuai'){
				return 'Penunjang tidak sesuai';
			}elseif($msg == 'flagProcedure tidak sesuai'){
				return 'Flag Procedure tidak sesuai';
			}else{
				return $msg;
			}
		} else {
			return 'Gagal Buat SEP';
		}
	}
}

if (!function_exists('convert_hari')) {
	function convert_hari($hari) {
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
	function convert_hari_hfis($hari) {
		$daftar_hari = [
		 1=>'Senin' ,
		 2=>'Selasa' ,
		 3=>'Rabu' ,
		 4=>'Kamis' ,
		 5=>'Jumat' ,
		 6=>'Sabtu' ,
		 7=>'Minggu',
		 8=>'Libur Nasional'
		];
		return $daftar_hari[$hari];
	}
}

if (!function_exists('cek_registrasi')) {
	function cek_registrasi($antrian_id, $no_loket) {
		return DB::table('registrasis')->where('antrian_id', '=', $antrian_id)->where('no_loket', $no_loket)->where('created_at', 'LIKE', date('Y-m-d') . '%')->count();
	}
}

if (!function_exists('hitung_umur')) {
	function hitung_umur($tgl, $bln = '') {
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

if (!function_exists('baca_carabayar')) {
	function baca_carabayar($id) {
		if (!empty($id)) {
			$kat = DB::table('carabayars')->where('id', '=', $id)->first();
			return $kat->carabayar;
		} else {
			return NULL;
		}

	}
}

if (!function_exists('baca_rujukan')) {
	function baca_rujukan($id) {
		if (!empty($id)) {
			$kat = DB::table('pengirim_rujukan')->where('id', '=', $id)->first();
			return $kat->nama;
		} else {
			return NULL;
		}

	}
}

if (!function_exists('baca_pengirim_rujukan')) {
	function baca_pengirim_rujukan($id) {
		if (!empty($id)) {
			$kat = DB::table('pengirim_rujukan')->where('id', '=', $id)->first();
			return $kat->nama;
		} else {
			return NULL;
		}

	}
}

if (!function_exists('terbilang')) {
	function terbilang($satuan) {
		if (!empty($satuan)) {
			$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh",
				"Delapan", "Sembilan", "Sepuluh", "Sebelas");
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
	function tanggalPeriode($tanggal) {
		$tgl = explode('-', $tanggal);
		return $tgl[2] . '-' . $tgl[1] . '-' . $tgl[0];
	}
}

if (!function_exists('penanggungJawabSep')) {
	function penanggungJawabSep($x) {
		if (!empty($x)) {
			switch($x){
				case '1': $x = 'Pribadi';
					break;
				case '2': $x = 'Pemberi Kerja';
					break;
				case '3': $x = 'Asuransi Kesehatan Tambahan';
					break;
			}
			return $x;
		}
	}
}
if (!function_exists('tanggalkuitansi')) {
	function tanggalkuitansi($x) {
		if (!empty($x)) {
			$y = explode('-', $x);
			switch ($y[1]) {
			case '1':$b = 'Januari';
				break;
			case '2':$b = 'Februari';
				break;
			case '3':$b = 'Maret';
				break;
			case '4':$b = 'April';
				break;
			case '5':$b = 'Mei';
				break;
			case '6':$b = 'Juni';
				break;
			case '7':$b = 'Juli';
				break;
			case '8':$b = 'Agustus';
				break;
			case '9':$b = 'September';
				break;
			case '10':$b = 'Oktober';
				break;
			case '11':$b = 'Nopember';
				break;
			case '12':$b = 'Desember';
				break;
			}
			$z = $y[0] . ' ' . $b . ' ' . $y[2];
			return $z;
		}
	}
}

if (!function_exists('configrs')) {
	function configrs() {
		$cf = DB::table('configs')->where('id', '=', 1)->first();
		return $cf;
	}
}

if (!function_exists('baca_user')) {
	function baca_user($id = '')
	{
		if (!empty($id)) {
			return DB::table('users')->where('id', $id)->first()->name;
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
	$data = DB::table('folios')->where('namatarif', $namatarif)->first();
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
			return DB::table('icd10s')->where('nomor', $id)->first()->nama;
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

function totalRs($reg_id = '')
{
	$total = DB::table('folios')->where('registrasi_id', $reg_id)->sum('total');
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
	function cekBatchOpname($logistik_batch = ''){
		$data = DB::table('logistik_opnames')->where('logistik_batch_id', $logistik_batch)->where('created_at','like', date('Y-m').'%')->count();

		if($data != null){
			return $data;
		}else{
			return 0;
		}
	}
}

if (!function_exists('baca_batches')) {
	function baca_batches($id) {
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
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
}

if (!function_exists('cek_folio_counts')) {
	function cek_folio_counts($reg_id, $poli_id, $jenis = 'TA') {
		if (!empty($reg_id) || !empty($poli_id)) {
			$count = DB::table('folios')->where('registrasi_id', '=', $reg_id)->where('poli_id', '=', $poli_id)->where('jenis', '=', $jenis)->count();
			return $count;
		} else {
			return 0;
		}

	}
}

if (!function_exists('baca_rencanakontrol')) {
	function baca_rencanakontrol($id = '') {
		if (!empty($id)) {
			$rencana =  DB::table('bpjs_rencana_kontrol')->where('resume_id', $id)->first();
			if ( isset($rencana->month_only) ) {
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

// FAIQ



if (!function_exists('baca_unit')) {
	function baca_unit($x) {
		if (!empty($x)) {
			switch ($x) {
			case 'jalan':$b = 'RAWAT JALAN';
				break;
			case 'igd':$b = 'IGD';
				break;
			case 'inap':$b = 'RAWAT INAP';
				break; 
			} 
			return $b;
		}
	}
}

if (!function_exists('baca_jenis_unit')) {
	function baca_jenis_unit($x) {
		if (!empty($x)) {
			switch ($x) {
			case 'jalan':$b = 'TA';
				break;
			case 'igd':$b = 'TG';
				break;
			case 'inap':$b = 'TI';
				break; 
			} 
			return $b;
		}
	}
}

if (!function_exists('convert_kabupaten')) {
	function convert_kabupaten($x) { 
		$kabupaten = str_replace("KABUPATEN","KAB.",$x);
		return $kabupaten;
	}
}



function signature_bpjs(){
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
		'user_key:'. config('app.user_key_antrean'),
		'Content-Type: application/json',
	);
	return $arrheader;
}
function generateKodeBooking(){
	$noantri = DB::table('registrasis')->where('nomorantrian','like',date('dmY') . '%')->count();
	$nomorantrian = date('dmY').sprintf("%04s",$noantri+1);
	return $nomorantrian;
}

function generateKodeBookingRegDummy(){
	$noantri = DB::table('registrasis')->where('nomorantrian','like',date('dmY') . '%')->count();
	$nomorantrian = date('dmY').sprintf("%04s",$noantri+1);
	return $nomorantrian;
}
