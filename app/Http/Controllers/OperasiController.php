<?php

namespace App\Http\Controllers;
use App\Foliopelaksana;
use App\Operasi;
use App\Rawatinap;
use App\EmrInapPemeriksaan;
use Auth;
use App\User;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Folio;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Tarif\Entities\Tarif;
use Yajra\DataTables\DataTables;
use Modules\Registrasi\Entities\Carabayar;
use Illuminate\Support\Facades\DB;
use PDF;
use Excel;
use Modules\Kamar\Entities\Kamar;
use Modules\Kelas\Entities\Kelas;
use Modules\Pasien\Entities\Pasien;
use Modules\Poli\Entities\Poli;

class OperasiController extends Controller {

	public function cariPasien()
	{
		return view('operasi.cari-pasien');
	}
	public function cariPasienProses(Request $request)
	{
		
		if($request->no_rm){
			$data['pasien'] = Pasien::where('no_rm', $request->no_rm)->first();
		}elseif($request->nama){
			$data['pasien'] = Pasien::where('nama', 'like', $request->nama.'%')->first();
		}
		$data['antrian'] = Registrasi::whereIn('status_reg', ['J1', 'J2', 'J3','G1','G2','G3','I2','I3'])			
									->where('.pasien_id', @$data['pasien']->id)
									->limit(500)->get();
		
		return view('operasi.cari-pasien', $data)->with('no',1);
	}

	public function antrian($tgl = '') {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');
		session()->forget('catatan');
		session()->forget('poli_operasi');
		$data['antrian'] = Registrasi::join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->join('kamars', 'kamars.id', '=', 'rawatinaps.kamar_id')
			->join('kelas', 'kelas.id', '=', 'rawatinaps.kelas_id')
			->join('beds', 'beds.id', '=', 'rawatinaps.bed_id')
			->whereIn('registrasis.status_reg', ['I2','I3','G1','G2','G3'])
			->orderBy('registrasis.created_at', 'desc')
			->limit(500)
			->select([
				'pasiens.nama as namaPasien',
				'pasiens.no_rm',
				'registrasis.poli_id',
				'registrasis.dokter_id',
				'registrasis.status_reg',
				'rawatinaps.registrasi_id',
				'kelas.nama as kelas',
				'kamars.nama as kamar',
				'beds.nama as bed',
			]);
		if($tgl){
			$data['antrian'] = $data['antrian']->whereDate('registrasis.created_at', date('Y-m-d', strtotime($tgl)));
		}
		$data['antrian'] = $data['antrian']->get();
		// $data['antrian'] = Registrasi::whereIn('status_reg', ['I2', 'I3'])
		// ->orWhere('poli_id', 6)
		// ->get();
		return view('operasi.antrian', $data)->with('no', 1);
	}

	public function odc($tgl = '') {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');
		
		session()->forget('catatan');
        session()->forget('poli_operasi');
		$tanggal = ($tgl == '') ? date('Y-m-d') : $tgl;
		$data['antrian'] = Registrasi::with('pasien')->whereIn('status_reg', ['J1', 'J2', 'J3','G1','G2','G3'])->where('created_at', 'like', $tanggal.'%')->get();
		return view('operasi.odc', $data)->with('no', 1);
	}

	public function byTanggal(Request $request) {
		request()->validate(['tanggal' => 'required']);
		return redirect('operasi/antrian/' . valid_date($request['tanggal']));
	}

	public function odcPerTanggal(Request $request) {
		request()->validate(['tanggal' => 'required']);
		return redirect('operasi/odc/' . valid_date($request['tanggal']));
	}

	public function tindakan($unit = '', $registrasi_id = '') {
		$data['unit'] = $unit;
		$data['reg_id'] = $registrasi_id;
		$data['reg'] = Registrasi::where('id', '=', $registrasi_id)->select('id', 'pasien_id', 'status_reg', 'dokter_id', 'poli_id', 'user_create', 'bayar')->first();
		// dd($data['reg']);
		$data['polis'] = Poli::where('politype','J')->get();
		$data['poli'] = Folio::where('registrasi_id', '=', $registrasi_id)->distinct();
		$data['tagihan'] = Folio::where('registrasi_id', $registrasi_id)->where('lunas', 'N')->sum('total');
		$data['irna'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		$data['carabayar'] = Carabayar::pluck('carabayar', 'id');
		$data['kamar'] = Kamar::pluck('nama', 'id');
		$data['kelas'] = Kelas::pluck('nama', 'id');
		$data['pj'] = $data['anestesi'] = Pegawai::all();
		$data['dokter'] = Pegawai::where('kategori_pegawai', '1')->get();
		$data['dokter_anak'] = Pegawai::where('kategori_pegawai', '1')->where('smf', '10')->get();
		$data['perawat'] = Pegawai::where('kategori_pegawai', '2')->get();
		$data['tarif']		= Tarif::leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
			->where('tarifs.nama','not like','%PA Biopsi Besar%')
			->where('tarifs.nama','not like','%PA Biopsi Kecil%')
			->where('tarifs.nama','not like','%PA Biopsi%')
			->where('tarifs.total', '<>', 0)
			->where('tarifs.kategoriheader_id', '<>', 10)
			->where('tarifs.kode', '!=', null)
			->where('tarifs.kode', '!=', ' ')
			->select('tarifs.*', 'kategoritarifs.namatarif')
			->groupBy('tarifs.nama')
			->get();
		if ($data['irna']) {
			session(['kelas' => $data['irna']->kelas_id]);
		}
		$data['total'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'O'])->orderBy('id', 'desc')->sum('total');
		// dd($data);
		return view('operasi.tindakan', $data)->with('no', 1);
		
	}
	public function cetakTindakanOka($registrasi_id = '') {
		$data['reg_id'] = $registrasi_id;
		$data['reg'] = Registrasi::where('id', '=', $registrasi_id)->select('id', 'pasien_id', 'status_reg', 'dokter_id', 'poli_id', 'user_create', 'bayar')->first();
		$data['irna'] = Rawatinap::where('registrasi_id', $registrasi_id)->first();
		// $data['folio'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'O'])->orderBy('id', 'desc');
		$data['folio'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'O'])->orderBy('id', 'desc')
			->select('cara_bayar_id','dokter_anestesi','dokter_anak', 'diskon', 'dpjp', 'id', 'registrasi_id', 'namatarif', 'cara_bayar_id','kamar_id','kelas_id','cyto','total', 'tarif_id', 'jenis', 'lunas', 'pasien_id', 'dokter_id', 'user_id', 'created_at', 'dokter_pelaksana');
		// dd($data['folio']);
		// $data['total'] = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'O'])->orderBy('id', 'desc')->sum('total');
		// return $data; die; 
		$pdf = PDF::loadView('operasi.cetak_tindakan_oka', $data)->setpaper('folio', 'portrait');
		return $pdf->stream();
		
	}

	public function simpanTindakan(Request $request) {
		// dd($request->all());
		
		$cek_reg = Registrasi::find($request->registrasi_id);
		$tgl = !empty($request['tanggal']) ? valid_date($request['tanggal']) : date('Y-m-d');
		
		
		$oprs = [];

		foreach ($request['tarif_id'] as $i) {
		

		session(['catatan' => $request['catatan'],'poli_operasi'=>@$request['poli_id']]);
		$kode   = $i;
		$tarif = Tarif::where('id', $kode)->first();
		$reg = Registrasi::find($request['registrasi_id']);
		$oprs[] = $tarif->nama;

		$check = Folio::where(['poli_tipe' => 'O', 'registrasi_id' => $request['registrasi_id']])->get();
		// Hitung penambahan harga berdasarkan pilihan
        $cyto = $request['cyto'] != null ? $tarif->total * 0.5 : 0; // 50% jika Cito dipilih
        $eksekutif = $request['eksekutif'] != null ? $tarif->total * 0.8 : 0; // 80% jika Eksekutif dipilih
        
        // Total penambahan harga
        $totalIncrease = $cyto + $eksekutif;
        
        // Total setelah penambahan harga
        $fol = new Folio();
        $fol->registrasi_id = $request['registrasi_id'];
        $fol->cara_bayar_id = (!empty($request['cara_bayar_id'])) ? $request['cara_bayar_id'] : $reg->bayar;
        $fol->namatarif = $tarif->nama;
        
        // Hitung total
        $fol->total = ($tarif->total + $totalIncrease) * $request['jumlah'];
		$fol->cyto = $request['cyto'];
		$fol->tarif_id = $tarif->id;
		$fol->lunas = 'N';
		if($request['unit'] == 'odc'){
			$fol->jenis = 'TA';
		}else{
			$fol->jenis = 'TI';
		}
		
		$fol->poli_tipe = 'O';
		$fol->pasien_id = $request['pasien_id'];
		$fol->kelas_id = $request['kelas_id'];
		$fol->kamar_id = $request['kamar_id'];
		$fol->catatan = $request['catatan'];
		$fol->dokter_id = $request['dokter_bedah'];
		$fol->user_id = Auth::user()->id;
		if (!empty($request['tanggal'])) {
			$fol->created_at = valid_date($request['tanggal']);
		}

		//revisi foliopelaksana
		$fol->penanggung_jawab = $request['penanggung_jawab'];
		$fol->dpjp = $request['dpjp'];
		$fol->dokter_pelaksana = $request['dokter_pelaksana'];
		$fol->catatan = $request['catatan'];
		$fol->verif_kasa_user = 'tarif_new';
		$fol->harus_bayar = $request->jumlah;
		$fol->dokter_bedah = $request['dokter_bedah'];
		$fol->dokter_anak = $request['dokter_anak'];
		$fol->perawat = @$request['perawat'];
		$fol->perawat_ibs2 = $request['perawat_bedah2'];
		$fol->perawat_anestesi1 = $request['ass_anestesi'];
		$fol->dokter_anestesi = $request['dokter_anestesi'];
		$fol->dokter_operator = $request['ass_operator'];
		$fol->poli_id = @$request['poli_id'];
		// $fol->cyto = $request['cito'];
		$fol->save();
		
	}
	$t_operasi = count($oprs) > 0 ? implode(', ', $oprs) : '-';

	if($cek_reg){
		if($cek_reg->bayar== 1){
			$cek = Operasi::where('registrasi_id',$request->reqistrasi_id)->where('rencana_operasi', $tgl)->first();
			
			$pasien = Pasien::where('id',$cek_reg->pasien_id)->first();
			if($pasien){
				$pasien->no_jkn = @$request->no_jkn;
				$pasien->save();
			}

			if(!$cek){
				if(!empty($request['poli_id'])){
					$namapoli   = Poli::where('id', @$request['poli_id'])->first();
				}else{
					$namapoli   = Poli::where('id', @$cek_reg->poli_id)->first();

				}
				// dd($namapoli);
				$booking	= Operasi::where('rencana_operasi', @valid_date($request['rencana_operasi']))->count();
				$hitung		= $booking+1;
				
				$ibs = Operasi::where('registrasi_id',@$request['registrasi_id'])->where('rencana_operasi',@valid_date($request['rencana_operasi']))->first();
				if(!$ibs){
					$ibs = new Operasi();
				}

				$ibs->registrasi_id = @$request['registrasi_id'];
				$ibs->rawatinap_id = isset($request['rawatinap_id']) ? $request['rawatinap_id'] : 0;
				$ibs->no_rm = @$cek_reg->pasien->no_rm;
				$ibs->no_jkn = @!empty($request['no_jkn']) ? @$request->no_jkn : @$cek_reg->pasien->no_jkn;
				$ibs->rencana_operasi = @valid_date($request['rencana_operasi']);
				$ibs->suspect = @$request->catatan?$request->catatan:$t_operasi;
				$ibs->kodepoli = @$namapoli->bpjs;
				$ibs->namapoli = @$namapoli->nama;
				$ibs->terlaksana = 0;
				$ibs->kodebooking = 'IBS'.date('Y-m-d').'-'.$hitung;
				$ibs->save();
			}
			
		}

	}

		Flashy::success('Tindakan berhasil di tambahkan');
		return redirect('operasi/tindakan/'.$request['unit'].'/'. $request['registrasi_id']);
	}

	public function Order($registrasi_id)
	{
		$data = \App\Operasi::where('registrasi_id', $registrasi_id)->latest()->first();
		return response()->json($data);
	}

	public function gettarif($kat_id) {
		$tarif = Tarif::where('kategoritarif_id', $kat_id)->pluck('nama', 'id');
		return json_encode($tarif);
	}

	public function getDokter(Request $request) {
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = Pegawai::where('nama', 'like', '%' . $term . '%')->limit(5)->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama];
		}

		return \Response::json($formatted_tags);
	}

	public function getTarifTindakan(Request $request) {
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = Tarif::where('jenis', 'TI')->where('nama', 'like', '%' . $term . '%')->limit(5)->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | ' . number_format($tag->total)];
		}

		return \Response::json($formatted_tags);
	}

	public function hapusTindakan($id, $reg_id){
		$fol = Folio::find($id);
		$fol->delete();
		return redirect()->back();
	}

	public function getDataFolio($registrasi_id) {
		$data = Folio::where(['registrasi_id' => $registrasi_id, 'poli_tipe' => 'O'])->orderBy('id', 'desc')
			->select('cara_bayar_id','verif_kasa_user','dokter_anestesi','dokter_anak','perawat', 'diskon', 'dpjp', 'id', 'registrasi_id', 'namatarif', 'cara_bayar_id','kamar_id','kelas_id','cyto','total', 'tarif_id', 'jenis', 'lunas', 'pasien_id', 'dokter_id', 'user_id', 'created_at', 'dokter_pelaksana')
			->get();
		return DataTables::of($data)
			->addIndexColumn()
			->addColumn('jenisPelayanan', function ($data) {
				if ($data->jenis == 'TA') {
					return 'Tindakan di Rawat Jalan';
				} elseif ($data->jenis == 'TI') {
					return 'Tindakan di Rawat Inap';
				} elseif ($data->jenis == 'TG') {
					return 'Tindakan di Rawat Darurat';
				}
			})
			->addColumn('namatarif', function ($data) {
				return @$data->tarif->kategoritarif->namatarif.'-'.@$data->namatarif;
			})
			->addColumn('biaya', function ($data) {
				if($data->verif_kasa_user =='tarif_new') {
					return ($data->tarif_id != 10000) ? number_format($data->tarif_baru->total, 0, ',', '.') : NULL;
					
				}else{
					return ($data->tarif_id != 10000) ? number_format($data->tarif->total, 0, ',', '.') : NULL;
				}
			})
			->addColumn('jumlah', function ($data) {
				if($data->verif_kasa_user =='tarif_new') {
					return ($data->tarif_id != 10000) ? @floor(((@$data->total + @$data->diskon) / @$data->tarif_baru->total)) : NULL;
				}else{
					return ($data->tarif_id != 10000) ? @floor(((@$data->total + @$data->diskon) / @$data->tarif->total)) : NULL;

				}
				
			})
			// ->addColumn('jmlTotalcito', function ($data) {
			// 	return number_format($data->total + $data->total / '2', 0, ',', '.');
			// })
			->addColumn('jmlTotal', function ($data) {
				return number_format($data->total, 0, ',', '.');
			})
			->addColumn('cyto', function ($data) {
				if ($data->cyto == 1) {
					$cyt = "Ya";
				} else{
					$cyt = "Tidak";
				}

				return $cyt;
			})
			->addColumn('kamar_id', function ($data) {
				return baca_kamar(@$data->kamar_id);
			})
			->addColumn('kelas_id', function ($data) {
				return baca_kelas(@$data->kelas_id);
			})
			->addColumn('dpjp', function ($data) {
				return baca_dokter($data->dokter_id);
			})
			->addColumn('dokter_anestesi', function ($data) {
				$dokter = $data->dokter_anestesi ? baca_dokter($data->dokter_anestesi) : '-';
				return $dokter;
			})
			->addColumn('dokter_anak', function ($data) {
				$dokter = $data->dokter_anak ? baca_dokter($data->dokter_anak) : '-';
				return $dokter;
			})
			->addColumn('perawat', function ($data) {
				$perawat = $data->perawat ? baca_dokter($data->perawat) : '-';
				return $perawat;
			})
			->addColumn('carabayar', function ($data) {
				return baca_carabayar($data->cara_bayar_id);
			})
			->addColumn('dokterPelaksana', function ($data) {
				return baca_dokter($data->dokter_pelaksana);
			})
			->addColumn('user', function ($data) {
				return $data->user->name;
			})
			->addColumn('create', function ($data) {
				return $data->created_at->format('d-m-Y');
			})
			->addColumn('lunas', function ($data) {
				if ($data->lunas == 'Y') {
					return '<i class="fa fa-check"></i>';
				} else {
					return '<i class="fa fa-remove"></i>';
				}
			})
			->addColumn('hapus', function ($data){
				if ($data->lunas == 'Y'){
					return '<i class="fa fa-check"></i>';
				}else{
				  if ( json_decode(Auth::user()->is_edit,true)['hapus'] == 1){
					return '<a href="'.url('operasi/hapus-tindakan/'.$data->id.'/'.$data->registrasi_id).'" onclick="return confirm(\'Yakin akan di hapus?\')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>';
				  }else{

				  }
				}
			})
			->rawColumns(['lunas', 'hapus'])
			->make(true);
	}

	public function laporanOperasi(){
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');
		$data['dokter']			= Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		// $data['tindakan']		= Folio::where('poli_tipe', 'O')->distinct()->get();
		$data['cara_bayar']		= Carabayar::all();
		$data['kamar'] 			= Kamar::pluck('nama', 'id');

		$data['tga']			= '';
		$data['tgb']			= '';
		$data['jenis_pasien']	= 0;
		$data['dokter_id']		= 0;
		$data['tarif_id']		= 0;
		$data['operasi']		= [];
		$data['detail_dokter']	= [];
		$data['catatan'] = [];
		return view('operasi.laporanOperasi', $data);
	}

	public function ajaxGetTindakan(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}
		// ->->get();
		$tags = Folio::where('poli_tipe', 'O')
			->where('namatarif', 'like', '%' . $term . '%')
			->limit(15)
			// ->groupBy('tarif_id')
			->distinct()
			->get();

		// $tags = LogistikBatch::where('gudang_id', '2')
		// 		->where('nama_obat', 'like', '%' . $term . '%')
		// 		// ->where('stok', '!=', '0')
		// 		->where('stok', '!=', 0)
		// 		->limit(15)->orderByRaw('DATE_FORMAT(expireddate, "%m-%d")')->get();


		$formatted_tags = [];

		foreach ($tags as $tag) {
			$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->namatarif];
		}
		return \Response::json($formatted_tags);
	}

	public function laporanOperasiByReq(Request $req){
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '10000M');
		$data['dokter']			= Pegawai::where('kategori_pegawai', 1)->select('nama', 'id')->get();
		$data['tindakan']		= Folio::where('poli_tipe', 'O')->distinct()->orderBy('created_at','ASC')->get();
		$data['cara_bayar']		= Carabayar::all();
		$data['kamar']			= Kamar::pluck('nama', 'id');

		$data['tga']			= $req->tga;
		$data['tgb']			= $req->tgb;
		$data['jenis_pasien']	= $req->jenis_pasien;
		$data['dokter_id']		= $req->dokter_id;
		$data['tarif_id']		= $req->tarif_id;

		$tga				= valid_date($req['tga']) . ' 00:00:00';
		$tgb				= valid_date($req['tgb']) . ' 23:59:59';

		// $data['operasi']	= Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
		// 				->whereBetween('folios.created_at', [$tga, $tgb])
		// 				->where('folios.poli_tipe', 'O')
		// 				->where('registrasis.bayar', ($req->jenis_pasien == 0) ? '>' : '=', $req->jenis_pasien)
		// 				->where('folios.tarif_id', ($req->tarif_id == 0) ? '>' : '=', $req->tarif_id)
		// 				->select(
		// 					DB::raw("GROUP_CONCAT(folios.namatarif SEPARATOR '||') as namatarif"),
		// 					DB::raw("GROUP_CONCAT(folios.tarif_id SEPARATOR '||') as tarif_id"),
		// 					DB::raw("GROUP_CONCAT(folios.total SEPARATOR '||') as total"),
		// 					DB::raw("GROUP_CONCAT(folios.created_at SEPARATOR '||') as tanggal"),
		// 					DB::raw("GROUP_CONCAT(folios.dokter_bedah SEPARATOR '||') as dokter"),
		// 					DB::raw("GROUP_CONCAT(folios.dokter_anestesi SEPARATOR '||') as anestesi"),
		// 					DB::raw("GROUP_CONCAT(folios.catatan SEPARATOR '||') as catatan"),
		// 					DB::raw("GROUP_CONCAT(folios.cyto SEPARATOR '||') as cito"),
		// 					DB::raw("GROUP_CONCAT(folios.kamar_id SEPARATOR '||') as kamar")
		// 				)
		// 				->selectRaw('registrasis.id, registrasis.user_create, registrasis.bayar, registrasis.pasien_id, registrasis.status, registrasis.poli_id')
		// 				->groupBy('folios.registrasi_id')
		// 				->get();

				$query = Folio::whereBetween('created_at', [$tga, $tgb])
					->with('tarif')
					->where('poli_tipe', 'O')
					->selectRaw('registrasi_id, perawat_ibs1, perawat, dokter_anestesi,dokter_anak, tarif_id, poli_id, kamar_id, cyto, catatan, dokter_bedah, created_at, namatarif, sum(total) AS total')
					->orderBy('created_at', 'ASC')
					->groupBy('registrasi_id', 'tarif_id');

				if ($req->kamar) {
					$query->where('kamar_id', $req->kamar);
				}

				$data['data_operasi_irna'] = $query->get();

				$data['operasi_new'] = [];
				foreach ($data['data_operasi_irna'] as $element) {
					$data['operasi_new'][$element['registrasi_id']][] = $element;
				}

				// dd($data['operasi_new']);
		// dd($data['folio_irna']);
						
		// dd($data['operasi']);
		// $data['detail_dokter']	= Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
		// 				->whereBetween('folios.created_at', [$tga, $tgb])
		// 				->where('folios.poli_tipe', 'O')
		// 				->where('registrasis.bayar', ($req->jenis_pasien == 0) ? '>' : '=', $req->jenis_pasien)
		// 				->where('folios.tarif_id', ($req->tarif_id == 0) ? '>' : '=', $req->tarif_id)
		// 				->selectRaw('COUNT(folios.id) as jumlah, folios.dokter_bedah')
		// 				->groupBy('folios.dokter_bedah')->get();
		// return $data['visite'];die;
		if($req->lanjut){
			return view('operasi.laporanOperasi', $data)->with('no', 1);
		}elseif($req->pdf) {
			$data['no'] = 1; 
			// return view('operasi.rekap-laporan', $data, compact('no'));
			$pdf = PDF::loadView('operasi.rekap-laporan', $data);
			$pdf->setPaper('A4', 'landscape');
			return $pdf->download('rekap-laporan.pdf');
		}elseif ($req->excel) {
			// dd($data);
			Excel::create('Laporan Operasi', function ($excel) use ($data) {
				$excel->setTitle('Laporan Operasi')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Operasi');

				$excel->sheet('Laporan Operasi', function ($sheet) use ($data) {
					$row = 1;
					$no = 1;

					// Header sama persis seperti di view
					$sheet->row($row, [
						'No',
						'No. RM',
						'Nama',
						'Status',
						'L/P',
						'Bayar',
						'Dr. Bedah',
						'Dr. Anestesi',
						'Dr. Anak',
						'Perawat',
						'Tindakan',
						'Cito',
						'Poli',
						'Tanggal',
						'Tarif',
						'Kamar',
						'Catatan',
					]);

					foreach ($data['operasi_new'] as $registrasi_id => $group) {
						$reg = \Modules\Registrasi\Entities\Registrasi::find($registrasi_id);
						$total_rows = count($group);

						$first = true;
						foreach ($group as $d) {
							$row++;

							$nt = @$d->namatarif;
							$cito = @$d->cyto;
							$poli = @$d->poli_id;
							$dokter = @$d->dokter_bedah;
							$anestesi = @$d->dokter_anestesi;
							$anak = @$d->dokter_anak;
							$perawat = @$d->perawat;
							$tgl = @$d->created_at;
							$catatan = @$d->catatan;
							$kamar = @$d->kamar_id;
							$tarif = @$d->total;

							$perawatReal = '';
							if (isset($perawat)) {
								if ($perawat == 1) {
									$perawatReal = "Perawat Bedah";
								} elseif ($perawat == 2) {
									$perawatReal = "Perawat Anestesi";
								} else {
									$perawatReal = baca_pegawai($perawat);
								}
							}

							$sheet->row($row, [
								$first ? $no : '', // Nomor hanya di baris pertama group
								$first ? @$reg->pasien->no_rm : '',
								$first ? @$reg->pasien->nama : '',
								$first ? (@$reg->status == 'baru' ? 'Baru' : 'Lama') : '',
								$first ? @$reg->pasien->kelamin : '',
								$first ? strtoupper(baca_carabayar(@$reg->bayar)) : '',
								baca_dokter($dokter),
								baca_dokter($anestesi),
								baca_dokter($anak),
								$perawatReal,
								@$d->tarif->kategoritarif->namatarif . ' - ' . $nt,
								$cito !== null ? 'Ya' : 'Tidak',
								baca_poli($poli ?? @$reg->poli_id),
								date('d-m-Y', strtotime($tgl)),
								number_format($tarif),
								baca_kamar($kamar),
								$catatan,
							]);

							$first = false;
						}
						$no++;
					}
				});
			})->export('xlsx');
		}
	}

	public function emr($unit)
	{
		$data['unit'] = $unit;
		$status_reg = null;

		if ($unit == "jalan") {
			$status_reg = 'J';
		} elseif ($unit == "inap") {
			$status_reg = 'I';
		} elseif ($unit == "igd") {
			$status_reg = 'G';
		}


		$data['emr'] = Operasi::join('registrasis', 'registrasis.id','=','operasis.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('operasis.rencana_operasi', date('Y-m-d'))
			->where('registrasis.status_reg', 'like', $status_reg.'%')
			->get();
		return view('operasi.emr', $data)->with('no', 1);
	}
	public function emrByRequest(Request $request, $unit)
	{
		$data['unit'] = $unit;
		$status_reg = null;

		if ($unit == "jalan") {
			$status_reg = 'J';
		} elseif ($unit == "inap") {
			$status_reg = 'I';
		} elseif ($unit == "igd") {
			$status_reg = 'G';
		}

		request()->validate(['tga' => 'required']);
		request()->validate(['tgb' => 'required']);
		$data['emr'] = Operasi::join('registrasis', 'registrasis.id','=','operasis.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('registrasis.status_reg', 'like', $status_reg.'%')
			->whereBetween('operasis.rencana_operasi', [valid_date($request['tga']), valid_date($request['tgb'])])->get();
		return view('operasi.emr', $data)->with('no', 1);
	}

	public function cetakDaftarTilik($registrasi_id, $id)
	{
        $data['reg'] 	  = Registrasi::find($registrasi_id);
        $data['pasien']   = Pasien::find($data['reg']->pasien_id);
        $data['dokter']   = Pegawai::find($data['reg']->dokter_id);
        $data['riwayat']  = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type','daftar-tilik')->orderBy('id','DESC')->first();
		$data['cetak']    = json_decode($data['riwayat']->fisik, true);
        
		$pdf = PDF::loadView('operasi.cetak_daftar_tilik', $data);
        $pdf->setPaper('A4', 'portrait');
		return $pdf->stream('daftar-tilik.pdf');
    }

	public function daftarTilikDelete($daftar_id)
    {
        $daftar_tilik = EmrInapPemeriksaan::where('id', $daftar_id)->where('type', 'daftar-tilik')->orderBy('id', 'DESC')->first();

        if ($daftar_tilik) {
            $delete = $daftar_tilik->delete();
            if ($delete) {
                Flashy::success('Daftar Tilik Berhasil Dihapus.');
                return redirect()->back();
            }
        }

        Flashy::error('Daftar Tilik Gagal dihapus.');
        return redirect()->back();
    }

	public function cetakPraAnestesi($registrasi_id, $id)
	{
        $data['reg'] 	  = Registrasi::find($registrasi_id);
        $data['pasien']   = Pasien::find($data['reg']->pasien_id);
        $data['dokter']   = Pegawai::find($data['reg']->dokter_id);
        $data['laboratorium'] = Folio::where('registrasi_id', $registrasi_id)->where('poli_tipe', 'L')->select('namatarif')->get();
        $data['riwayat']  = EmrInapPemeriksaan::where('registrasi_id', $registrasi_id)->where('type','pra-anestesi')->orderBy('id','DESC')->first();
		$data['cetak']    = json_decode($data['riwayat']->fisik, true);
        
		$pdf = PDF::loadView('operasi.cetak_pra_anestesi', $data);
        $pdf->setPaper('A4', 'portrait');
		return $pdf->stream('pra-anestesi.pdf');
    }

	public function ttePDFPraAnestesi(Request $request)
    {
        $data['riwayat']  = EmrInapPemeriksaan::find($request->riwayat_id);
		$data['reg']      = Registrasi::find($data['riwayat']->registrasi_id);
        $data['dokter']   = Pegawai::find($data['reg']->dokter_id);
        $data['laboratorium'] = Folio::where('registrasi_id', $data['reg']->id)->where('poli_tipe', 'L')->select('namatarif')->get();
		$data['pasien']   = Pasien::find($data['riwayat']->pasien_id);
		$data['cetak']    = json_decode($data['riwayat']->fisik, true);

        // TTE
        if ($request->method() == "POST") {
            if (tte()) {
                $data['cetak_tte'] = true;
                $pdf    = PDF::loadView('operasi.cetak_pra_anestesi', $data);
                $pdf->setPaper('A4', 'portrait');
                $pdfContent = $pdf->output();
    
                // Create temp pdf
                $filePath = uniqId() . '-pra-anestesi.pdf';
                File::put(public_path($filePath), $pdfContent);
    
                // Generate QR code dengan gambar
                $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));
    
                // Simpan QR code dalam file
                $qrCodePath = uniqid() . '.png';
                File::put(public_path($qrCodePath), $qrCode);
    
                $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);
                log_esign($data['reg']->id, $tte->response, "pra-anestesi", $tte->httpStatusCode);
    
                $resp = json_decode($tte->response);
    
                if ($tte->httpStatusCode == 200) {
                    $data['riwayat']->tte = $tte->response;
                    $data['riwayat']->update();
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
                $pdf = PDF::loadView('operasi.cetak_pra_anestesi', $data);
                $pdfContent = $pdf->output();

                $data['riwayat']->tte = json_encode((object) [
                    "base64_signed_file" => base64_encode($pdfContent),
                ]);
                $data['riwayat']->update();
                Flashy::success('Berhasil menandatangani dokumen !');
                return redirect()->back();
            }
        }

        $pdf    = PDF::loadView('operasi.cetak_pra_anestesi', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('pra-anestesi.pdf');
    }

	public function cetakTTEPDFPraAnestesi($registrasi_id, $id)
    {
        $riwayat    = EmrInapPemeriksaan::find($id);
        $tte    	= json_decode($riwayat->tte);
        $base64 	= $tte->base64_signed_file;

        $pdfContent = base64_decode($base64);
        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Pra Anestesi-' . $registrasi_id . '.pdf"',
        ]);
    }
}