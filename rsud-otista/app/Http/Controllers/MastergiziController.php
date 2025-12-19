<?php

namespace App\Http\Controllers;

use App\EmrInapPemeriksaan;
use App\EmrInapPerencanaan;
use App\Gizi;
use App\Mastergizi;
use App\Predictive;
use App\Kelompokkelas;
use DB;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Registrasi;
use Excel;
use Validator;
use PDF;

class MastergiziController extends Controller
{

	public function index()
	{
		$data['gizi'] = Mastergizi::all();
		return view('mastergizi.index', $data)->with('no', 1);
	}

	public function create()
	{
		//
	}

	public function store(Request $request)
	{
		$cek = Validator::make($request->all(), ['gizi' => 'required|unique:mastergizis,gizi']);

		if ($cek->passes()) {
			Mastergizi::create(['gizi' => $request['gizi']]);
			Flashy::success('Gizi berhasil ditambahkan');
			return response()->json(['success' => 1]);
		} else {
			return response()->json(['errors' => $cek->errors()]);
		}
	}

	public function edit($id)
	{
		$data = Mastergizi::find($id);
		return response()->json($data);
	}

	public function update(Request $request, $id)
	{
		$cek = Validator::make($request->all(), ['gizi' => 'required|unique:mastergizis,gizi,' . $id]);
		if ($cek->passes()) {
			$gizi = Mastergizi::find($id)->update(['gizi' => $request['gizi']]);
			if ($gizi) {
				Flashy::info('Gizi berhasil diubah');
			}
			return response()->json(['success' => 1]);
		} else {
			return response()->json(['errors' => $cek->errors()]);
		}
	}

	public function gizi_pasien()
	{
		$data['gizipasien'] = Gizi::where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
		return view('mastergizi.gizi_pasien', $data)->with('no', 1);
	}

	public function gizi_pasien_byTanggal(Request $request)
	{
		$data['gizipasien'] = Gizi::whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])->get();
		return view('mastergizi.gizi_pasien', $data)->with('no', 1);
	}

	public function show($id)
	{
		//
	}

	public function destroy($id)
	{
		//
	}

	public function indexInap()
	{
		$data['reg'] = Registrasi::with([
				'pasien', 
				'rawat_inap', 
				'rawat_inap.kamar', 
				'rawat_inap.bed', 
				'rawat_inap.dokter_ahli', 
				'emrPemeriksaan' => function ($query) {
					$query->whereIn('type', [
						'inap-perawat-dewasa',
						'inap-perawat-anak',
						'asesmen-awal-perawat-maternitas',
						'asesmen-perinatologi',
					]);
				}
			])
			->where('status_reg', 'I2')
			->get();

		return view('mastergizi.index-inap', $data)->with('no', 1);
	}

	public function indexInapByTanggal(Request $request)
	{
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$tga = valid_date($request['tga']) . ' 00:00:00';
		$tgb = valid_date($request['tgb']) . ' 23:59:59';

		$data['tga'] = $request->tga;
		$data['tgb'] = $request->tgb;

		$data['reg'] = Registrasi::with([
				'pasien', 
				'rawat_inap', 
				'rawat_inap.kamar', 
				'rawat_inap.bed', 
				'rawat_inap.dokter_ahli',
				'pengkajian_gizi',
				'skrining_anak',
				'skrining_dewasa',
				'skrining_maternitas',
				'skrining_perinatologi',
				'formulir_edukasi',
				'cppt_gizi',
			])
			->whereIn('status_reg', ['I2', 'I3'])
			->whereBetween('created_at', [$tga, $tgb])
			->get();

		return view('mastergizi.index-inap', $data)->with('no', 1);
	}

	public function indexInapLaporan()
	{
		return view('mastergizi.index-inap-laporan');
	}

	public function indexInapLaporanBy(Request $request)
	{
		request()->validate(['tga' => 'required', 'tgb' => 'required']);
		$tga = date(valid_date($request['tga']) . ' 00:00:00');
		$tgb = date(valid_date($request['tgb']) . ' 23:59:59');

		$list_kelas = Kelompokkelas::select('general_code', \DB::raw("MIN(kelompok) as nama"))
			->groupBy('general_code')
			->get()
			->map(function ($item) {
				$item->label = strtok($item->nama, ' ');
				return $item;
			});
		$filter_kamar = $request['filter_kamar'];
		$reg = Registrasi::with('pengkajian_gizi', 'pasien', 'skrining_dewasa', 'skrining_anak', 'rawat_inap')
			->whereBetween('registrasis.created_at', [$tga, $tgb])
			->whereHas('pengkajian_gizi')
			->whereHas('pasien')
			->where(function ($query) {
				$query->whereHas('skrining_dewasa')
					->orWhereHas('skrining_anak');
			});
		if ($request->filled('filter_kamar')) {
			$kelas = Kelompokkelas::where('general_code', $request->filter_kamar)->first();
			if ($kelas) {
				$reg->whereHas('rawat_inap.kamar', function ($q) use ($kelas) {
					$q->where('kelompokkelas_id', $kelas->id);
				});
			}
		}
		if ($request->filled('pegawai')) {
			$reg->whereHas('pengkajian_gizi', function ($q) use ($request) {
				$q->where('user_id', $request->pegawai);
			});
		}
		$reg = $reg->get();
		if ($request['tampil'] == 'TAMPILKAN') {
			return view('mastergizi.index-inap-laporan', compact('reg', 'tga', 'list_kelas', 'filter_kamar'))->with('no', 1);
		}
		
		if ($request['excel']) {
			$data['reg']=$reg;
			$data['tga']=$reg;
			$data['no'] = 1;
            Excel::create('Laporan Gizi', function ($excel) use ($data) {
                $excel->setTitle('Laporan Gizi')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Gizi');
                $excel->sheet('Inap', function ($sheet) use ($data) {
                    $sheet->loadView('mastergizi.index-inap-laporan-excel',$data);
                });
            })->export('xlsx');
		}
	}

	public function hasilPemeriksaan()
	{
		return view('mastergizi.hasil_pemeriksaan');
	}

	public function hasilPemeriksaanBy(Request $request)
	{
		$data['no'] = 1;
		$data['pasien'] = Pasien::where('no_rm', $request->no_rm)->first();
		$data['reg'] = Registrasi::where('pasien_id', $data['pasien']->id)->get();
		return view('mastergizi.hasil_pemeriksaan', $data);
	}

	public function cetak()
    {
        // $today = Registrasi::where('created_at', 'like', date('Y-m-d') . '%')
        $today = Registrasi::with([
				'rawat_inap', 
				'rawat_inap.kamar', 
				'rawat_inap.bed', 
			])
			->where('status_reg', 'I2')
            ->orderBy('id', 'Desc')->get();
        return view('mastergizi.cetak', compact('today'))->with('no', 1);
    }

	public function cetakBy(Request $request)
    {
        ini_set('max_execution_time', 0);
		ini_set('memory_limit', '-1');
        request()->validate(['tga' => 'required', 'tgb' => 'required']);
        $today = Registrasi::with([
				'rawat_inap', 
				'rawat_inap.kamar', 
				'rawat_inap.bed', 
			])
			->whereBetween('created_at', [valid_date($request['tga']) . ' 00:00:00', valid_date($request['tgb']) . ' 23:59:59'])
            ->whereIn('status_reg', ['I1', 'I2', 'I3'])
            ->orderBy('id', 'Desc')->get();
        return view('mastergizi.cetak', compact('today'))->with('no', 1);
	}

	public function cetakLabel($registrasi_id)
	{
        $data['registrasi']  = Registrasi::with('rawat_inap')->find($registrasi_id);
		$data['asessments']  = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type', 'fisik_gizi')->first();
        $data['assesment']   = json_decode(@$data['asessments']->fisik, true);
		$data['konsul_gizi'] = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'konsultasi-gizi')->orderBy('id', 'DESC')->first();
        $data['konsul']  	 = json_decode(@$data['konsul_gizi']->keterangan);
        $pdf = PDF::loadView('mastergizi.cetak_label', $data);
		return $pdf->stream();
	}

	public function getPredictive(Request $request)
	{
		$text = [];
		$predictive = Predictive::where('text', 'like', '%'.$request['term'].'%')->groupBy('text')->get(['text']);

		foreach ($predictive as $item) {
			$text[] = $item->text;
		}

		return response()->json($text);
	}
}
