<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Province;
use Modules\Pekerjaan\Entities\Pekerjaan;
use Modules\Pendidikan\Entities\Pendidikan;
use Modules\Perusahaan\Entities\Perusahaan;
use Modules\Poli\Entities\Poli;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Pasien\Entities\Agama;
use Yajra\DataTables\DataTables;
use Modules\Registrasi\Entities\Tipelayanan;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Status;
use Modules\Registrasi\Http\Requests\SaveRegistrasiRequest;
use App\RegistrasiDummy;
use App\HistorikunjunganIRJ;
use App\Historipengunjung;
use App\Nomorrm;
use Modules\Registrasi\Entities\Biayaregistrasi;
use Modules\Registrasi\Entities\Tagihan;
use Modules\Registrasi\Entities\HistoriStatus;
use DB;
use Flashy;
use Auth;
use Excel;
use Illuminate\Support\Facades\Cache;
use Modules\Pasien\Entities\District;
use Modules\Pasien\Entities\Regency;
use Modules\Pasien\Entities\Village;
use PDF;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
		$data['cara_bayar'] = Carabayar::pluck('carabayar', 'id');
		$data['poli']		= Poli::where('politype', 'J')->get();
		$data['dokter']		= Pegawai::where('kategori_pegawai', 1)->get();
		$data['propinsi']	= Province::pluck('name', 'id');
		$data['kabupaten']	= Regency::pluck('name', 'id');
		$data['kecamatan']	= District::pluck('name', 'id');
		$data['kelurahan']	= Village::pluck('name', 'id');
		return view('pendaftaran/pendaftaran', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$data = [
			'no_rm' => $request->no_rm,
			'nama' => $request->nama,
			'alamat' => $request->alamat,
			'tgllahir' => $request->tgllahir,
			'kelamin' => ($request->kelamin == 'Perempuan') ? 'P' : 'L',
			'no_hp' => $request->no_telp,
			'kode_cara_bayar' => $request->cara_bayar,
			'no_rujukan' => ($request->no_rujukan != '') ? $request->no_rujukan : '-',
			'tglperiksa' => date('Y-m-d', strtotime($request->tgl_periksa)),
			'kode_poli' => $request->kode_poli,
			'kode_dokter' => $request->kode_dokter
        ];
        $check = RegistrasiDummy::where(['no_rm' => $request->no_rm, 'tglperiksa' => $data['tglperiksa']])->count();
		if($check == 0){
			RegistrasiDummy::create($data);
            return view('pendaftaran/resumePendaftaran');
		}else{
            session(['data' => $data]);
            return view('pendaftaran/resumePendaftaran', compact('data'));
		}
    }

    public function checkNoRm($no_rm, $tgl_lahir){
        $ceck = Pasien::where(array('no_rm' => $no_rm, 'tgllahir' => $tgl_lahir));
        if($ceck->count() > 0){
            $data = [
                'status'    => 'ada',
                'result'    => $ceck->first()
            ];
        }else{
            $data = [
                'status'    => 'kosong',
                'result'    => null
            ];
        }
        echo json_encode($data);
    }

    public function dataPendaftar(){
		$data['tga'] = date('d-m-Y');
		$data['tgb'] = date('d-m-Y');
		// $tga		 = valid_date($data['tga']).' 00:00:00';
		// $tgb		 = valid_date($data['tgb']).' 23:59:59';
		// $tga		 = valid_date($data['tga']);
		// $tgb		 = valid_date($data['tgb']);
		$data['status'] = 'pending';
		$data['jenis'] = 'fkrtl';
		$data['poli']		= Poli::where('politype', 'J')->get();
		// $data['reg'] = RegistrasiDummy::where('jenis_registrasi','antrian')->where('status', $data['status'])->whereBetween('tglperiksa', [$tga, $tgb])->get();
		// return $data; die;
		// dd($data['reg']);
		return view('pendaftaran.pendaftaranOnline', $data)->with('no', 1);
	}
    public function dataPendaftaranOnline(Request $req){

		// dd($req->carabayar_id);
		if($req->filled('keyword')){
			// dd($req->keyword);
			$d = RegistrasiDummy::where('jenis_registrasi','antrian')->where('status', 'pending')
				// ->where('tglperiksa', date('Y-m-d'))
				->where(function ($query) use($req){
					$query->where('no_rm', $req->keyword)
						->orWhere('nama', 'LIKE', "%$req->keyword%");
				})
				->groupBy('nomorantrian')
				->orderBy('id', 'DESC')
				->limit(5)
				->get();
		}elseif($req->filled('tanggal')){
			// $keyCache = 'pendaftaran_online_'.$req->tanggal;
			// $d = Cache::get($keyCache);
			// if(!$d){
				$d = RegistrasiDummy::where('jenis_registrasi','antrian')->where('status', 'pending')
				// ->where('tglperiksa', date('Y-m-d'))
				->where(function ($query) use($req){
					$query->where('tglperiksa', $req->tanggal);
				});

				if($req->carabayar_id){
					$d = $d->where('kode_cara_bayar', $req->carabayar_id);
				}
				if($req->poli_id){
					$d = $d->where('kode_poli', $req->poli_id);
				}

				$d = $d->orderBy('id', 'DESC')->groupBy('nomorantrian')->get();
			// 	Cache::put($keyCache,$d,120); //BUAT CACHE 2 menit
			// }
			
		}elseif($req->filled('carabayar_id')){
				$d = RegistrasiDummy::where('jenis_registrasi','antrian')->where('status', 'pending')
				->where('kode_cara_bayar', $req->carabayar_id);

				if($req->tanggal){
					$d = $d->where('tglperiksa', $req->tanggal);
				}else{
					$d = $d->where('tglperiksa', date('Y-m-d'));
				}
				
				$d = $d->orderBy('id', 'DESC')->groupBy('nomorantrian')->get();
			
		}else{
			$keyCache = 'pendaftaran_online';
			$d = Cache::get($keyCache);
			if(!$d){
				$d = RegistrasiDummy::where('jenis_registrasi','antrian')->where('status', 'pending')
				->where('tglperiksa', date('Y-m-d'))->groupBy('nomorantrian')->get();
				Cache::put($keyCache,$d,120); //BUAT CACHE 2 menit
			}
		}

		return DataTables::of($d)
		
			->addColumn('nomorantrian', function ($d) {
				return @$d->nomorantrian;
			})
			->addColumn('no_rujukan', function ($d) {
				return @$d->no_rujukan;
			})
			->addColumn('no_rm', function ($d) {
				if(strlen(@$d->no_rm) > 6){
					return '<i>Pasien Baru Sipantes</i>';
				}else{
					return !empty(@$d->no_rm) ? @$d->no_rm : 'Dari Mobile JKN';
				}
				
			})
			->addColumn('nama', function ($d) {
				return !empty(@$d->nama) ? @$d->nama : '<i>Pasien Baru</i>';
			})
			->addColumn('nik', function ($d) {
				// if(!$d->nik){
				// 	@$pasien = RegistrasiDummy::where('jenis_registrasi','pasien_baru')->where('nik',$d->nik)->first()->nik;
				// }else{
				// 	@$pasien = @$d->nik;
				// }
				return @$d->nik;
			})
			->addColumn('nohp', function ($d) {
				// if(!$d->no_hp){
				// 	@$pasien = RegistrasiDummy::where('jenis_registrasi','pasien_baru')->where('nik',$d->nik)->first()->no_hp;
				// }else{
				// 	@$pasien = @$d->no_hp;
				// }
				return @$d->no_hp;
			})
			->addColumn('poli', function ($d) {
				if(!$d->kode_poli){
					@$pasien = RegistrasiDummy::where('jenis_registrasi','pasien_baru')->where('nik',$d->nik)->first();
				}
				return !empty(@$d['kode_poli']) ? @Poli::where('bpjs', @$d['kode_poli'])->first()->nama : Poli::where('bpjs', @$pasien->kode_poli)->first()->nama;
			})
			->addColumn('cara_bayar', function ($d) {
				return !empty(@$d->kode_cara_bayar) ? baca_carabayar(@$d['kode_cara_bayar']) : 'JKN';
			})
			->addColumn('jenis_daftar', function ($d) {
				return ucfirst(@$d['jenisdaftar']);
			})
			->addColumn('tglperiksa', function ($d) {
				return @$d['tglperiksa'];
			})
			->addColumn('proses', function ($d) {
				$confirm = "return confirm('Yakin akan Batalkan antrian?')";
				if(@$d['status'] == 'pending'){
                  return '<a href="'.url('regperjanjian/online/'.@$d['id']).'" data-toggle="tooltip" data-placement="top" title="Proses"  class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right"></i></a> <a href="'.url('pendaftaran/batalRegPendaftaran/'.@$d['id']).'" onclick="'.$confirm.'" data-toggle="tooltip" data-placement="top" title="Batalkan" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-times-circle"></i></a>';
                }else{
                  return '<a href="'.url('form-sep-susulan-online/'.@$d['registrasi_id']).'" data-toggle="tooltip" data-placement="top" title="Proses"  class="btn btn-success btn-sm btn-flat"><i class="fa fa-arrow-circle-right"></i></a>';
				}
			})
			 
 
			->rawColumns(['bayar','nama','proses','no_rm'])
			->addIndexColumn()
			->make(true);
	}
	
	public function dataFilterPendaftar(Request $req){
		$data['tga'] = $req->tga;
		$data['tgb'] = $req->tgb;
		// $tga		 = valid_date($data['tga']).' 00:00:00';
		// $tgb		 = valid_date($data['tgb']).' 23:59:59';
		$tga		 = valid_date($data['tga']);
		$tgb		 = valid_date($data['tgb']);
		$data['status'] = $req->status;
		$data['jenis'] = $req->jenis;
		$data['reg'] = RegistrasiDummy::where('jenisdaftar',$data['jenis'])->where('status', $data['status'])->whereBetween('tglperiksa', [$tga, $tgb])->groupBy('nomorantrian')->get();
		$datareg = $data['reg'];
		if($req->submit =='CETAK'){
			Excel::create('Laporan Pasien Antrol', function ($excel) use ($datareg, $req) {
				// Set the properties
				$excel->setTitle('Laporan Pasien Antrol')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Laporan Pasien Antrol');
				$excel->sheet('Laporan Pasien Antrol', function ($sheet) use ($datareg, $req) {
					$row = 1;
					$no = 1;
					$sheet->row($row, [
						'No',
						'Kode Booking',
						'Rujukan',
						'No RM',
						'Nama',
						'NIK',
						'No.HP',
						'Poli',
						'Cara Bayar',
						'Jenis',
						'Tanggal Periksa'

					]);
					foreach ($datareg as $key => $k) {
						$pasien = \App\RegistrasiDummy::where('jenis_registrasi','pasien_baru')->where('nik',$k->nik)->first();

						$sheet->row(++$row, [
							$no++,
							@$k->nomorantrian,
							@$k->no_rujukan,
							!empty(@$k->no_rm) ? @$k->no_rm : 'Dari Mobile JKN',
							!empty(@$k->nama) ? @$k->nama : '<i>Pasien Baru</i>',
							!empty(@$k->nik) ? @$k->nik : @$pasien->nik,
							!empty(@$k->no_hp) ? @$k->no_hp : @$pasien->no_hp,
							!empty(@$k['kode_poli']) ? @Poli::where('bpjs', @$k['kode_poli'])->first()->nama :@Poli::where('bpjs', @$pasien->kode_poli)->first()->nama ,
							!empty(@$k->kode_cara_bayar) ? baca_carabayar(@$k['kode_cara_bayar']) : 'JKN',
							ucfirst(@$k['jenisdaftar']),
							@$k['tglperiksa'],
							
						]);
					}
				});
			})->export('xlsx');
			// return view('pendaftaran.cetakPendaftaranOnline', $data)->with('no', 1);	
		}
		// return $data; die;
		// dd($data['reg']);
		return view('pendaftaran.pendaftaranOnline', $data)->with('no', 1);
	}

    public function regPendaftaran($id){
        $reg = RegistrasiDummy::find($id);

		// dd(explode('-',$reg->jampraktek));
        $data = [
            'pekerjaan' => Pekerjaan::pluck('nama', 'id'),
            'agama'     => Agama::pluck('agama', 'id'),
		    'perusahaan'=> Perusahaan::pluck('nama', 'id'),
		    'pendidikan'=> Pendidikan::pluck('pendidikan', 'id'),
		    'status'    => Status::pluck('status', 'id'),
            'carabayar' => Carabayar::pluck('carabayar', 'id'),
            'tipelayanan'=> Tipelayanan::pluck('tipelayanan', 'id'),
		    'carabayar' => Carabayar::pluck('carabayar', 'id'),
            'provinsi'  => Province::pluck('name', 'id'),
            'poli'      => Poli::pluck('nama', 'id'),
    		'dokter'    => Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id'),
            'pasien'    => Pasien::where('no_rm', $reg->no_rm)->first() ? Pasien::where('no_rm', $reg->no_rm)->first() : $reg,
            'regist'    => $reg,
			'regist_id' => $id,
			'jampraktek'=> explode('-',$reg->jampraktek)
        ];
		 
		// dd($data);
		// dd($data['pasien']);
        return view('pendaftaran/regPendaftaran', compact('data'));
    }

	public function batalRegPendaftaran($id){
		$reg = RegistrasiDummy::find($id);
		if($reg->nomorantrian){
			// JIKA ADA UPDATE TASKID 3
			// $ID = config('app.consid_antrean');
			// date_default_timezone_set('Asia/Jakarta');
			// $t = time();
			// $dat = "$ID&$t";
			// $secretKey = config('app.secretkey_antrean');
			// $signature = base64_encode(hash_hmac('sha256', utf8_encode($dat), utf8_encode($secretKey), true));
			// $completeurl = config('app.antrean_url_web_service')."/antrean/updatewaktu";
			// $arrheader = array(
			// 	'X-cons-id: ' . $ID,
			// 	'X-timestamp: ' . $t,
			// 	'X-signature: ' . $signature,
			// 	'user_key:'. config('app.user_key_antrean'),
			// 	'Content-Type: application/json',
			// );
			
			// $updatewaktu   = '{
			// 	"kodebooking": "'.$reg->nomorantrian.'",
			// 	"taskid": 99,
			// 	"waktu": "'.round(microtime(true) * 1000).'"
			//  }'; 
			//  $session2 = curl_init($completeurl);
			//  curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
			//  curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
			//  curl_setopt($session2, CURLOPT_POST, TRUE);
			//  curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
			//  $response = curl_exec($session2);
			//  if($response){
			// 	 if(@$response['metadata']['code'] !== '200' || @$response['metaData']['code'] !== '200'){
			// 		Flashy::error('Gagal Batalkan antrian, '.@$response['metadata']['message']);
			// 		return redirect()->back();
			// 	 }

			//  }

			 $reg->delete();
			 Flashy::success('Sukses batalkan antrian');
			return redirect()->back();
		}else{
			Flashy::error('Gagal Batalkan antrian, nomor antrian kosong');
			return redirect()->back();
		}
		Flashy::success('Sukses batalkan antrian');
		return redirect()->back();
	}

    public function saveRegOnline(Request $request, $id, $dummy){
		request()->validate([
			'created_at' => 'required',
			'poli_id' => 'required',
			'dokter_id' => 'required',
		]);
		
		// dd(valid_date($request['created_at']));
		// dd($id);
		DB::beginTransaction();
        try{
			// Update Pasien
			$pasien = Pasien::find($id);
			if (empty($pasien->no_rm)) {
				$new_rm = !empty($request['no_rm']) ? $request['no_rm'] : Nomorrm::count() + config('app.no_rm');
				$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $new_rm]);
				$pasi = Pasien::where('id',$pasien->id)->first();
				$rmid = $rms->id;
				$cek_pas = Pasien::where('no_rm',$rmid)->first();
				if($cek_pas){
					$rms = Nomorrm::create(['pasien_id' => $pasien->id, 'no_rm' => $new_rm]);
					$rmid = $rms->id;
				}
				$pasien->no_rm = $rmid;
				$pasien->save();
			}
			$pasien->nama = $request['nama'];
			$pasien->nik = $request['nik'];
			$pasien->tmplahir = $request['tmplahir'];
			$pasien->tgllahir = valid_date($request['tgllahir']);
			$pasien->kelamin = $request['kelamin'];
			$pasien->province_id = $request['province_id'];
			$pasien->regency_id = $request['regency_id'];
			$pasien->district_id = $request['district_id'];
			$pasien->village_id = $request['village_id'];
			$pasien->alamat = $request['alamat'];
			$pasien->rt = $request['rt'];
			$pasien->rw = $request['rw'];
			$pasien->ibu_kandung = $request['ibu_kandung'];
			$pasien->status_marital = $request['status_marital'];
			$pasien->nohp = $request['nohp'];
			$pasien->negara = 'Indonesia';
			$pasien->pekerjaan_id = $request['pekerjaan_id'];
			$pasien->agama_id = $request['agama_id'];
			$pasien->pendidikan_id = $request['pendidikan_id'];
			$pasien->user_update = Auth::user()->name;
			$pasien->update();



			// Save registrasi
			$id = Registrasi::where('reg_id', 'LIKE', date('Ymd') . '%')->count();

			$reg = new Registrasi();
			$reg->pasien_id = $pasien->id;
			$reg->reg_id = date('Ymd') . sprintf("%04s", ($id + 1));
			$reg->status = $request['status'];
			$reg->keterangan = $request['keterangan'];
			$reg->rujukan = $request['rujukan'];
			$reg->antrian_id = NULL;
			$reg->nomorantrian = $request['nomorantrian'];
			$reg->rjtl = $request['rjtl'];
			$reg->kepesertaan = $request['kepesertaan']; //kepesertaan JKN
			$reg->hakkelas = $request['hakkelas'];
			$reg->nomorrujukan = $request['nomorrujukan'];
			$reg->tglrujukan = $request['tglrujukan'];
			$reg->kodeasal = $request['kodeasal'];
			$reg->tipe_layanan = $request['tipe_layanan'];
			$reg->catatan = $request['catatan'];
			$reg->dokter_id = $request['dokter_id'];
			$reg->poli_id = $request['poli_id'];
			$reg->icd = $request['icd'];
			$reg->kecelakaan = $request['kecelakaan'];
			$reg->tipe_jkn = $request['jkn'];
			$reg->no_sep = $request['no_sep'];
			$reg->sebabsakit_id = $request['sebabsakit_id'];
			$reg->bayar = $request['bayar'];
			$reg->no_jkn = $request['no_jkn'];
			$reg->user_create = Auth::user()->id;
			$reg->jenis_pasien = $request['bayar'];
			$reg->posisiberkas_id = '2';
			$reg->status_reg = $request['status_reg'];
			if ($request['status_reg'] == 'G1') {
				$reg->status_ugd = $request['status_ugd'];
			}
			$reg->perusahaan_id = isset($request['perusahaan_id']) ? $request['perusahaan_id'] : NULL;
			$reg->antrian_poli = $this->antrianPoli($request['poli_id'], valid_date($request['created_at']));
			$reg->created_at = date(valid_date($request['created_at']) . ' H:i:s');
			$reg->updated_at = date(valid_date($request['created_at']) . ' H:i:s');
			$reg->save();
			session(['reg_id' => $reg->id]);

			//Insert Histori Pengunjung
			$hp = new Historipengunjung();
			$hp->registrasi_id = $reg->id;
			$hp->pasien_id = $pasien->id;
			$hp->politipe = 'J';
			if ($request['status'] == 1) {
				$hp->status_pasien = 'BARU';
			} else {
				$hp->status_pasien = 'LAMA';
			}
			$hp->created_at = date(valid_date($request['created_at']) . ' H:i:s');
			$hp->user = Auth::user()->name;
			$hp->save();

			//Histori Kunjungan
			$irj = new HistorikunjunganIRJ();
			$irj->registrasi_id = $reg->id;
			$irj->pasien_id = $pasien->id;
			$irj->poli_id = $request['poli_id'];
			$irj->dokter_id = $request['dokter_id'];
			$irj->user = Auth::user()->name;
			$irj->created_at = date(valid_date($request['created_at']) . ' H:i:s');
			$irj->save();

			// Insert Biaya Registrasi dan ke Folio
			$biaya = Biayaregistrasi::all();
			$harus_dibayar = 0;
			$harus_dibayar;

			// Insert ke Tagihan
			$tag = new Tagihan();
			$tag->user_id = Auth::user()->id;
			$tag->registrasi_id = $reg->id;
			$tag->dokter_id = $reg->dokter_id;
			$tag->diskon = 0;
			$tag->pasien_id = $pasien->id;
			$tag->harus_dibayar = $harus_dibayar;
			$tag->subsidi = 0;
			$tag->dijamin = 0;
			$tag->selisih_positif = 0;
			$tag->selisih_negatif = 0;
			$tag->approval_tanggal = date('Y-m-d');
			$tag->user_approval = '';
			$tag->pembulatan = 0;
			$tag->save();

			// Insert Histori
			$history = new HistoriStatus();
			$history->registrasi_id = $reg->id;
			$history->status = 'J1';
			$history->poli_id = $reg->poli_id;
			$history->bed_id = 1;
			$history->user_id = Auth::user()->id;
			$history->save();
			session(['pasienID' => $pasien->id]);


			// SAVE TO BPJS
			$ID = config('app.consid_antrean');
			date_default_timezone_set('UTC');
			$t = time();
			$data = "$ID&$t";
			$secretKey = config('app.secretkey_antrean');
			$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

			$kuotaJKN = Poli::where('bpjs',baca_bpjs_poli($request['poli_id']))->first()->kuota;
			// dd(baca_bpjs_poli($request['poli_id']));
			$noantrian = is_numeric(substr($request['nomorantrian'],-2));
			if($noantrian){
				$nomorantrian = substr($request['nomorantrian'],-2);
			}else{
				$nomorantrian = substr($request['nomorantrian'],-1);
			}
			$req   = '{
			   "kodebooking": "'.$request['nomorantrian'].'",
			   "jenispasien": "'.($request['bayar'] == '1' ? 'JKN' : 'NON JKN').'",
			   "nomorkartu": "'.$request['nomorkartu'].'",
			   "nik": "'.$request['nik'].'",
			   "nohp": "'.$request['nohp'].'",
			   "kodepoli": "'.baca_bpjs_poli($request['poli_id']).'",
			   "namapoli": "'.baca_kode_poli(baca_bpjs_poli($request['poli_id'])).'", 
			   "pasienbaru": "'.($request['norm'] ? 1 : 0).'",
			   "norm": "'.@$request['norm'].'",
			   "tanggalperiksa": "'.valid_date($request['created_at']).'", 
			   "kodedokter": "'.baca_dokter_kode($request['dokter_id']).'", 
			   "namadokter": "'.baca_dokter($request['dokter_id']).'",
			   "jampraktek": "'.($request['jam_start'].'-'.$request['jam_end']).'",
			   "jeniskunjungan": "'.$request['jeniskunjungan'].'",
			   "nomorreferensi": "'.$request['nomorreferensi'].'",
			   "nomorantrean": "'.("A".'-'.(int) $nomorantrian).'",
			   "angkaantrean": "'.(int) $nomorantrian.'",
			   "estimasidilayani": "'.(strtotime($request['estimasidilayani'])*1000).'",
			   "sisakuotajkn":"'.$kuotaJKN.'",
			   "kuotajkn": "'.$kuotaJKN.'",
			   "sisakuotanonjkn": "0",
			   "kuotanonjkn": "0",
			   "keterangan": "'.$request['keterangan'].'"
			}';
			
			// dd($req);
			$completeurl = config('app.antrean_url_web_service')."/antrean/add";
			$session = curl_init($completeurl);
			// dd($session);
			$arrheader = array(
				'X-cons-id: ' . $ID,
				'X-timestamp: ' . $t,
				'X-signature: ' . $signature,
				'user_key:'. config('app.user_key_antrean'),
				'Content-Type: application/json',
			);
			
			// dd(json_decode($body_prb));
			curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
			curl_setopt($session, CURLOPT_POSTFIELDS, $req);
			curl_setopt($session, CURLOPT_POST, TRUE);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($session);
			$sml = json_decode($response, true);
			// dd($sml);
			if($sml['metadata']['code'] == '200'){

				// Update waktu 1
				$updatewaktu   = '{
					"kodebooking": "'.$request['nomorantrian'].'",
					"taskid": 1,
					"waktu": "'.round(microtime(true) * 1000).'"
				 }';
				 $completeurl2 = config('app.antrean_url_web_service')."/antrean/updatewaktu";
				 $session2 = curl_init($completeurl2);
				 curl_setopt($session2, CURLOPT_HTTPHEADER, $arrheader);
				 curl_setopt($session2, CURLOPT_POSTFIELDS, $updatewaktu);
				 curl_setopt($session2, CURLOPT_POST, TRUE);
				 curl_setopt($session2, CURLOPT_RETURNTRANSFER, TRUE);
				 $response2 = curl_exec($session2);
				 $sml2 = json_decode($response2, true); 

				//  Update waktu 2
				 if($sml2['metadata']['code'] == '200' || $sml2['metadata']['message'] == 'TaskId=1 sudah ada'){
					$updatewaktu2   = '{
						"kodebooking": "'.$request['nomorantrian'].'",
						"taskid": 2,
						"waktu": "'.round(microtime(true) * 1000).'"
					 }';
					 $completeurl3 = config('app.antrean_url_web_service')."/antrean/updatewaktu";
					 $session3 = curl_init($completeurl3);
					 curl_setopt($session3, CURLOPT_HTTPHEADER, $arrheader);
					 curl_setopt($session3, CURLOPT_POSTFIELDS, $updatewaktu2);
					 curl_setopt($session3, CURLOPT_POST, TRUE);
					 curl_setopt($session3, CURLOPT_RETURNTRANSFER, TRUE);
					 $response3 = curl_exec($session3);
					 $sml3 = json_decode($response3, true); 
				 }else{
					if($sml2['metadata']['code'] !== '200'){
						Flashy::error('Registrasi Gagal, '.$sml2['metadata']['message']);
						return redirect('/pendaftaran/regPendaftaran/' . $request['regist_id']);
					 }
				 }

				 
			} else{ 
				Flashy::error('Registrasi Gagal, '.$sml['metadata']['message']);
				return redirect('/pendaftaran/regPendaftaran/' . $request['regist_id']); 
			} 
			Flashy::success('Registrasi Sukses');
			$reg = RegistrasiDummy::find($dummy);
			$reg->status = 'terdaftar';
			// $reg->taskid = '1';
			$reg->update();
			DB::commit();
			if ($request['bayar'] == 1) {
				return redirect('form-sep/' . session('reg_id'));
			} else {
				return redirect('pendaftaran/pendaftaran-online');
			}
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Gagal Registrasi Data');
			return redirect('/pendaftaran/regPendaftaran/' . session('reg_id'));
		} 
		
    }

	

	public function antrianPoli($poli_id = NULL, $tgl = NULL) {
		$poli = Registrasi::where('poli_id', $poli_id)->where('created_at', 'like', $tgl . '%')->count();
		return $poli + 1;
	}

	public function cetak_pendaftaran() {
        $data = session('data');
		$pdf = PDF::loadView('pendaftaran.cetakPendaftaran', compact('data'));
		return $pdf->stream();
	}
	
	public function taskList() {
        $data = session('data');
		$pdf = PDF::loadView('pendaftaran.cetakPendaftaran', compact('data'));
		return $pdf->stream();
	}



	// public function cekPasien($no_rm = '', $tgl = ''){
	// 	$pasien = Pasien::where(['no_rm' => $no_rm, 'tgllahir' => $tgl]);
	// 	if($pasien->count() > 0){
	// 		return $pasien->get();
	// 	}else{
	// 		return '0';
	// 	}
	// }

}
