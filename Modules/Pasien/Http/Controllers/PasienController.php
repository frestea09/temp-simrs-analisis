<?php

namespace Modules\Pasien\Http\Controllers;

use Auth;
use App\BpjsProv;
use App\BpjsKab;
use App\BpjsKec;
use App\EmrInapPemeriksaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Antrian\Entities\Antrian;
use Modules\Pasien\Entities\Agama;
use Modules\Pasien\Entities\District;
use Modules\Pasien\Entities\Pasien;
use Modules\Pasien\Entities\Province;
use Modules\Pasien\Entities\Regency;
use Modules\Pasien\Entities\Village;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Province2;
use Modules\Pasien\Entities\District2;
use Modules\Pasien\Entities\Regency2;
use Modules\Pasien\Entities\Village2;
use Modules\Pasien\Http\Requests\SavePasienRequest;
use Modules\Pekerjaan\Entities\Pekerjaan;
use Modules\Pendidikan\Entities\Pendidikan;
use Modules\Perusahaan\Entities\Perusahaan;
use Activity;
use Yajra\DataTables\DataTables;
use Flashy;
use Modules\Registrasi\Entities\HistoriStatus;
use Excel;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
	public function index()
	{
		return view('pasien::datatable');
	}

	public function getData()
	{
		$pasien = Pasien::select([
			'id',
			'no_rm',
			'no_jkn',
			'nama',
			'nik',
			'kelamin',
			'tgllahir',
			'alamat',
			'village_id',
		])->orderBy('id', 'asc');

		return DataTables::of($pasien)
			->addColumn('kelurahan', function ($pasien) {
				return !empty(@$pasien->village_id) ? @$pasien->kelurahan->name : NULL;
				//return empty($pasien->kelurahan->name) ? !empty($pasien->kelurahan->name) ?  : $pasien->kelurahan->name ;
			})
			->addColumn('edit', function ($pasien) {
				// if (Auth::user()->hasRole(['administrator','rekammedis','rawatdarurat', 'rawatinap', 'laboratorium'])) {
				return '<a href="' . route('pasien.edit', $pasien->id) . '" class="btn btn-info btn-flat"><i class="fa fa-edit"></i></a>' .
					'<button type="button" class="btn btn-primary btn-flat" data-idpasien="' . $pasien->id . '" id=pasienshow><i class="fa fa-search"></i></button>' .
					'<a href="' . url('/frontoffice/histori-pasien/' . $pasien->id) . '" class="btn btn-success  btn-flat"><i class="fa fa-file-pdf-o"></i></a>' .
					'<a href="' . url('/signaturepad/pasien/'.@$pasien->id) . '" class="btn btn-danger btn-flat" target="_blank"><i class="fa fa-pencil"></i></a>';
				// }else{
				// 	return '<button type="button" class="btn btn-primary btn-flat" data-idpasien="' . $pasien->id . '" id=pasienshow><i class="fa fa-search"></i></button>' .
				// 	'<a href="' . url('/frontoffice/histori-pasien/' . $pasien->id) . '" class="btn btn-success  btn-flat"><i class="fa fa-file-pdf-o"></i></a>';
				// }
			})
			->editColumn('tgllahir', function ($pasien) {
				return hitung_umur($pasien->tgllahir);
			})
			->rawColumns(['edit'])
			->make(true);
	}

	public function InfoData()
	{
		return view('pasien::datatable_info');
	}

	public function getDataInfo()
	{
		$pasien = Pasien::select([
			'id',
			'no_rm',
			'nama',
			'nik',
			'kelamin',
			'tgllahir',
			'alamat',
			'village_id',
		])->orderBy('id', 'asc');

		return DataTables::of($pasien)
			->addColumn('kelurahan', function ($pasien) {
				return !empty(@$pasien->village_id) ? @$pasien->kelurahan->name : NULL;
			})
			->addColumn('edit', function ($pasien) {
				// if (Auth::user()->hasRole(['administrator','rekammedis', 'rawatdarurat', 'rawatinap', 'admission', 'loketigd', 'laboratorium'])) {
				return '<a href="' . route('pasien.edit', $pasien->id) . '" class="btn btn-info btn-flat"><i class="fa fa-edit"></i></a>' .
					'<button type="button" class="btn btn-primary btn-flat" data-idpasien="' . $pasien->id . '" id=pasienshow><i class="fa fa-search"></i></button>' .
					'<a href="' . url('/frontoffice/histori-pasien/' . $pasien->id) . '" class="btn btn-success  btn-flat"><i class="fa fa-file-pdf-o"></i></a>' .
					'<a href="' . url('/signaturepad/pasien/'.@$pasien->id) . '" class="btn btn-danger btn-flat"><i class="fa fa-pencil"></i></a>';
				// }else{
				// 	return '<button type="button" class="btn btn-primary btn-flat" data-idpasien="' . $pasien->id . '" id=pasienshow><i class="fa fa-search"></i></button>' .
				// 	'<a href="' . url('/frontoffice/histori-pasien/' . $pasien->id) . '" class="btn btn-success  btn-flat"><i class="fa fa-file-pdf-o"></i></a>';
				// }
			})

			->addColumn('umur', function ($pasien) {
				return hitung_umur($pasien->tgllahir);
			})
			->rawColumns(['edit'])
			->make(true);
	}

	public function search(Request $req)
	{
		request()->validate(['keyword' => 'required']);
		$keyword = $req['keyword'];
		$data['pasien'] = Pasien::where('nama', 'LIKE', '%' . $keyword . '%')
			->orWhere('no_rm', 'LIKE', '%' . $keyword . '%')
			->orWhere('alamat', 'LIKE', '%' . $keyword . '%')

			->get();
		$data['no'] = 1;
		return view('pasien::search', $data);
	}

	public function create()
	{

		$data['provinsi'] = Province::pluck('name', 'id');
		$data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
		$data['perusahaan'] = Perusahaan::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		return view('pasien::create', $data);
	}

	public function store(SavePasienRequest $request)
	{
		//dd('save jkn 3');
		$no_rm = Pasien::where('no_rm', 'LIKE', '00%')->count();
		$data = $request->all();
		$data['no_rm'] = sprintf("%06s", ($no_rm + 1));
		$data['foto'] = '';
		$data['kode'] = '';
		$data['negara'] = 'Indonesia';
		$data['nama_kk'] = '';
		$date['no_kk'] = '';
		$data['no_identitas'] = '';
		$data['no_jaminan'] = '';
		$data['tipe_paket'] = '';
		$data['no_sktm'] = '';
		$pasien = Pasien::create($data);
		return redirect('registrasi/create/' . $pasien->id);
	}

	public function show($id)
	{
		$p = Pasien::find($id);
		return view('pasien::show', compact('p'));
	}

	public function edit($id)
	{
		$data['provinsi'] = Province::pluck('name', 'id');
		$data['pekerjaan'] = Pekerjaan::pluck('nama', 'id');
		$data['agama'] = Agama::pluck('agama', 'id');
		$data['perusahaan'] = Perusahaan::pluck('nama', 'id');
		$data['pendidikan'] = Pendidikan::pluck('pendidikan', 'id');
		$data['pasien'] = Pasien::find($id);

		if($data['pasien'] != null){
			$data['id']       = $data['pasien']->id;
		  }else{
			$data['id']       ='';
		  }
		$data['triage'] = EmrInapPemeriksaan::where('registrasi_id', 0)
			->where('pasien_id', 0)
			->where('type', 'triage-igd')
			->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())
			->get();
		$data['tgl_reg'] = Registrasi::where('pasien_id', $data['pasien']->id)
			->select('id', 'created_at')
			->get();
		return view('pasien::edit', $data);
	}

	public function update(Request $request, $id)
	{
		request()->validate(['tgllahir' => 'date_format:d-m-Y']);
		$pasien = Pasien::find($id);

		if ($pasien->nama != $request['nama']) {
			$text = Auth::user()->name . ' mengubah nama pasien ' . $pasien->nama . ' menjadi ' . $request['nama'];

			$pasien->nama = $request['nama'];

			if ($pasien->update()) {
				Activity::log($text . ' pasien_id ' . $pasien->id);
				Flashy::success($text);
			};
		}

		$reg = Registrasi::find($request['tgl_reg']);

		if ($request['triage'] != null && $request['tgl_reg'] != null) {
			$triage = EmrInapPemeriksaan::where('id', $request['triage'])->where('type', 'triage-igd')->first();
			if ($triage) {
				$triage->pasien_id = $pasien->id;
				$triage->registrasi_id = $reg ? $reg->id : null;
				$triage->update();
			}
		}

		if(!empty($request->file('ttd'))){
			$imagettd = time().$request->file('ttd')->getClientOriginalName();
			$request->file('ttd')->move('images/', $imagettd);
			$img   = Image::make(public_path().'/images/'.$imagettd)->resize(300,300);
			$img->save();
		}else{
		    $imagettd = $pasien->tanda_tangan;
		}

		$pasien->no_rm = $request['no_rm'];
		$pasien->nik = $request['nik'];
		$pasien->tmplahir = $request['tmplahir'];
		$pasien->tgllahir = valid_date($request['tgllahir']);
		$pasien->kelamin = $request['kelamin'];
		$pasien->province_id = $request['province_id'];
		$pasien->regency_id = $request['regency_id'];
		$pasien->district_id = $request['district_id'];
		$pasien->village_id = $request['village_id'];
		$pasien->alamat = $request['alamat'];
		$pasien->nohp = $request['nohp'];
		$pasien->no_jkn = @$request['no_jkn'];
		$pasien->negara = 'Indonesia';
		$pasien->pekerjaan_id = $request['pekerjaan_id'];
		$pasien->agama_id = $request['agama_id'];
		$pasien->pendidikan_id = $request['pendidikan_id'];
		// $pasien->user_create = Auth::user()->name;
		$pasien->user_update = Auth::user()->name;
		$pasien->ibu_kandung = $request['ibu_kandung'];
		$pasien->status_marital = $request['status_marital'];
		$pasien->tanda_tangan = $request['ttd'];
		$pasien->update();
		return redirect('pasien');
	}

	public function destroy()
	{
	}

	// =========== Demografi ===============================

	public function getKabupaten($province_id)
	{
		$kab = Regency::where('province_id', $province_id)->pluck('name', 'id');
		return json_encode($kab);
	}

	public function getKecamatan($regency_id)
	{
		$kec = District::where('regency_id', $regency_id)->pluck('name', 'id');
		return json_encode($kec);
	}

	public function getDesa($district_id)
	{
		$desa = Village::where('district_id', $district_id)->pluck('name', 'id');
		return json_encode($desa);
	}

	public function getBpjsProv($prov_kode)
	{
		$bpjsprov = BpjsProv::where('kode', $prov_kode)->pluck('propinsi', 'kode');
		return json_encode($bpjsprov);
	}
	public function getBpjsKab($kab_kode)
	{
		$bpjskab = BpjsKab::where('prov_kode', $kab_kode)->pluck('kabupaten', 'kode');
		return json_encode($bpjskab);
	}
	public function getBpjsKec($kec_kode)
	{
		$bpjskec = BpjsKec::where('kab_kode', $kec_kode)->pluck('kecamatan', 'kode');
		return json_encode($bpjskec);
	}


	public function searchPasien(Request $request, $antrian_id, $no_loket)
	{

		$no_rm = (!empty($request["no_rm"])) ? ($request["no_rm"]) : ('');
		$alamat = (!empty($request["alamat"])) ? ($request["alamat"]) : ('');
		$nama = (!empty($request["nama"])) ? ($request["nama"]) : ('');
		$tgllahir = (!empty($request["tgllahir"])) ? ($request["tgllahir"]) : ('');

		$antr = Antrian::where('id', $antrian_id)->first();
		session()->forget('antrian_id');
		session()->forget('no_loket');
		session(['antrian_id' => $antrian_id]);
		session(['no_loket' => $no_loket]);
		session(['bagian_loket' => @$antr->bagian]);
		$pasien = Pasien::select([
			'id',
			'no_rm',
			'no_rm_lama',
			'nama',
			'nik',
			'alamat',
			'ibu_kandung',
			'no_jkn',
			'tgllahir',

			// date("dmY", strtotime( @$d->updated_at ))

		]);
		if (!empty($no_rm)) {
			$pasien = $pasien->where('no_rm', $no_rm);
		}
		if (!empty($nama)) {
			$pasien = $pasien->where('nama', 'LIKE', '%' . $nama . '%');
		}
		if (!empty($alamat)) {
			$pasien = $pasien->where('alamat', 'LIKE', '%' . $alamat . '%');
		}
		if (!empty($tgllahir)) {
			@$hri = @substr($tgllahir, 0, 2);
			@$bulan = @substr($tgllahir, 2, 2);
			@$tahun = @substr($tgllahir, 4, 4);
			// dd($tahun);
			$pasien = $pasien->where('tgllahir', @$tahun . '-' . @$bulan . '-' . @$hri);
		}

		$pasien = $pasien->orderBy('id', 'asc');
		// '. date("d-m-Y", strtotime( @$pasien->tgllahir )) .'
		return DataTables::of($pasien)
			->addColumn('tgllahir', function ($pasien) {
				return date("d-m-Y", strtotime(@$pasien->tgllahir));
			})
			->addColumn('jkn', function ($pasien) {
				return '<a href="/registrasi/create/' . $pasien->id . '" onclick="return confirm(\'Yakin didaftarkan ke JKN? \')" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';
			})
			->addColumn('non-jkn', function ($pasien) {
				return '<a href="/registrasi/create_umum/' . $pasien->id . '" onclick="return confirm(\'Yakin didaftarkan ke Non JKN? \')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';
			})
			->rawColumns(['jkn', 'non-jkn', 'tgllahir'])
			->make(true);
	}

	public function searchPasienIGD()
	{
		$pasien = Pasien::select([
			'id',
			'no_rm',
			'no_rm_lama',
			'nama',
			'nik',
			'alamat',
			'ibu_kandung',
			'no_jkn',
			'tgllahir',
		])->orderBy('id', 'asc');

		return DataTables::of($pasien)
			->addColumn('tgllahir', function ($pasien) {
				return date("d-m-Y", strtotime(@$pasien->tgllahir));
			})
			->addColumn('jkn', function ($pasien) {
				return '<a href="/registrasi/igd/jkn/' . $pasien->id . '" onclick="return confirm(\'Yakin didaftarkan ke JKN? \')" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';
			})
			->addColumn('non-jkn', function ($pasien) {
				return '<a href="/registrasi/igd/umum/' . $pasien->id . '" onclick="return confirm(\'Yakin didaftarkan ke Non JKN? \')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';
			})
			->rawColumns(['jkn', 'non-jkn', 'tgllahir'])
			->make(true);
	}



	public function searchFilterPasienIGD(Request $request)
	{
		$no_rm = (!empty($request["no_rm"])) ? ($request["no_rm"]) : ('');
		$alamat = (!empty($request["alamat"])) ? ($request["alamat"]) : ('');
		$nama = (!empty($request["nama"])) ? ($request["nama"]) : ('');
		$tgl_lahir = (!empty($request["tgllahir"])) ? ($request["tgllahir"]) : ('');

		$pasien = Pasien::select([
			'id',
			'no_rm',
			'no_rm_lama',
			'nama',
			'nik',
			'alamat',
			'ibu_kandung',
			'no_jkn',
			'tgllahir',

			// date("dmY", strtotime( @$d->updated_at ))



		]);
		if (!empty($no_rm)) {
			$pasien = $pasien->where('no_rm', $no_rm);
		}
		if (!empty($nama)) {
			$pasien = $pasien->where('nama', 'LIKE', '%' . $nama . '%');
		}
		if (!empty($alamat)) {
			$pasien = $pasien->where('alamat', 'LIKE', '%' . $alamat . '%');
		}
		if (!empty($tgllahir)) {
			$pasien = $pasien->where('tgllahir', $tgl_lahir);
		}

		$pasien = $pasien->orderBy('id', 'asc');

		return DataTables::of($pasien)
			->addColumn('tgllahir', function ($pasien) {
				return date("d-m-Y", strtotime(@$pasien->tgllahir));
			})
			->addColumn('jkn', function ($pasien) {
				return '<a href="/registrasi/igd/jkn/' . $pasien->id . '" onclick="return confirm(\'Yakin didaftarkan ke JKN? \')" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';
			})
			->addColumn('non-jkn', function ($pasien) {
				return '<a href="/registrasi/igd/umum/' . $pasien->id . '" onclick="return confirm(\'Yakin didaftarkan ke Non JKN? \')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';
			})
			->rawColumns(['jkn', 'non-jkn', 'tgllahir'])
			->make(true);
	}


	public function searchPasienRanap()
	{
		$pasien = Pasien::select([
			'id',
			'no_rm',
			'no_rm_lama',
			'nama',
			'nik',
			'alamat',
			'ibu_kandung',
			'no_jkn',
			'tgllahir',
		])->orderBy('id', 'asc');

		return DataTables::of($pasien)
			->addColumn('tgllahir', function ($pasien) {
				return date("d-m-Y", strtotime(@$pasien->tgllahir));
			})
			->addColumn('jkn', function ($pasien) {
				return '<a href="/registrasi/ranap/jkn/' . $pasien->id . '" onclick="return confirm(\'Yakin didaftarkan ke JKN? \')" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';
			})
			->addColumn('non-jkn', function ($pasien) {
				return '<a href="/registrasi/ranap/umum/' . $pasien->id . '" onclick="return confirm(\'Yakin didaftarkan ke Non JKN? \')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right "></i></a>';
			})
			->rawColumns(['jkn', 'non-jkn', 'tgllahir'])
			->make(true);
	}

	public function getMasterPasien(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = Pasien::where('no_rm', 'like', '%' . $term . '%')

			->orWhere('nama', 'like', '%' . $term . '%')
			->limit(5)
			->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$formatted_tags[] = ['id' => $tag->no_rm, 'text' => $tag->no_rm . ' | ' . $tag->nama];
		}

		return \Response::json($formatted_tags);
	}

	public function index_rekamMedis()
	{
		return view('pasien::rekam-medis');
	}

	public function rekamMedis_source()
	{
		$pasien = Pasien::select([
			'id',
			'no_rm',
			'nama',
			'nik',
			'kelamin',
			'tgllahir',
			'alamat',
			'village_id',
		])->orderBy('id', 'asc');

		return DataTables::of($pasien)
			->addColumn('kelurahan', function ($pasien) {
				return !empty(@$pasien->village_id) ? @$pasien->kelurahan->name : NULL;
			})
			->addColumn('edit', function ($pasien) {
				return '<a href="' . url('/frontoffice/histori-pasien-rm/' . $pasien->id) . '" class="btn btn-success  btn-flat"><i class="fa fa-file-pdf-o"></i></a>';
			})
			->editColumn('tgllahir', function ($pasien) {
				return hitung_umur($pasien->tgllahir);
			})
			->rawColumns(['edit'])
			->make(true);
	}

	public function getKabupaten2($province_id)
	{
		$kab = Regency2::where('province_id', $province_id)->pluck('name', 'id');
		return json_encode($kab);
	}

	public function getKecamatan2($regency_id)
	{
		$kec = District2::where('regency_id', $regency_id)->pluck('name', 'id');
		return json_encode($kec);
	}

	public function getDesa2($district_id)
	{
		$desa = Village2::where('district_id', 'like', '%' . $district_id . '%')->pluck('name', 'id');
		return json_encode($desa);
	}
	public function riwayatStatusPasien(Request $request)
	{
		$data['no_rm']  = $request->no_rm;
		$data['pasien'] = Pasien::where('no_rm', $request->no_rm)->whereNotNull('no_rm')->first();
		$reg_ids        = Registrasi::where('pasien_id', @$data['pasien']->id)->pluck('id')->toArray();
		$data['history'] = HistoriStatus
			::whereIn('registrasi_id', $reg_ids)
			->leftJoin('polis', 'polis.id', '=', 'histori_statuses.poli_id')
			->leftJoin('beds', 'beds.id', '=', 'histori_statuses.bed_id')
			->leftJoin('users', 'users.id', '=', 'histori_statuses.user_id')
			->select('histori_statuses.*', 'polis.nama as nama_poli', 'beds.nama as nama_bed', 'users.name as username')
			->get();
		return view('frontoffice.riwayat-status-pasien', $data);
	}

	public function exportPasienbyDokter($dokter_id)
	{
		$registrasi = Registrasi::with('pasien')->where('dokter_id', $dokter_id)->get();

		Excel::create('Data Pasien' . baca_dokter($dokter_id), function ($excel) use ($registrasi, $dokter_id) {
			$excel->setTitle('Data Pasien')
				->setCreator('SIMRS Versi 4.0')
				->setCompany(configrs()->nama)
				->setDescription('Data Pasien');
			$excel->sheet('Data Pasien', function ($sheet) use ($registrasi, $dokter_id) {
				$no = 1;
				$sheet->appendRow([
					'No',
					'No RM',
					'Nama',
					'Tempat Lahir',
					'Tgl Lahir',
					'Jenis Kelamin',
					'Alamat',
					'Tanggal Pendaftaran',
				]);

				foreach ($registrasi as $d) {
					$sheet->appendRow([
						$no++,
						$d->pasien->no_rm,
						$d->pasien->nama,
						$d->pasien->tmplahir,
						$d->pasien->tgllahir,
						$d->pasien->kelamin,
						$d->pasien->alamat,
						date('d-m-Y', strtotime($d->created_at)),
					]);
				}

				$sheet->appendRow([
					'Dokter :',
					baca_dokter($dokter_id)
				]);
			});
		})->export('xlsx');
	}

}
