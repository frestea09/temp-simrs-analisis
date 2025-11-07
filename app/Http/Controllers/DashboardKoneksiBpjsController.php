<?php

namespace App\Http\Controllers;

use App\HistorikunjunganIRJ;
use App\Historipengunjung;
use App\HistoriSep;
use App\Http\Controllers\HRD\MasterController;
use App\LogBridging;
use App\Logistik\LogistikStock;
use App\LogistikBatch;
use App\Masterobat;
use App\Nomorrm;
use App\Produk;
use App\RencanaKontrol;
use App\Satuanbeli;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Pegawai\Entities\Pegawai;
use PDF;
use Validator;
use Modules\Registrasi\Entities\Registrasi;
use Monolog\Handler\IFTTTHandler;
use Modules\Poli\Entities\Poli;
use MercurySeries\Flashy\Flashy;
use Modules\Pasien\Entities\Pasien;
use Modules\Registrasi\Entities\Folio;
use Yajra\DataTables\DataTables;
use Excel;
use Illuminate\Support\Facades\Cache;

class DashboardKoneksiBpjsController extends Controller {

	public function index(Request $r) {
		$data_antrian = [];
		if ($r->method() == 'POST')
		{
			$cek_reg = Registrasi::where('created_at','LIKE', valid_date($r->tgl).'%')
						->whereNotNull('nomorantrian')->orderBy('poli_id','ASC')->limit(5)->get();

			foreach($cek_reg as $key=> $c){
				$data_antrian[$key]['poli'] = baca_poli($c->poli_id);
				$data_antrian[$key]['nomorantrian'] = $c->nomorantrian;
				$data_antrian[$key]['nama'] = $c->pasien->nama;
				$data_antrian[$key]['no_rm'] = $c->pasien->no_rm;
				// $cek_re[] = $c->nomorantrian;
				$ID = config('app.consid_antrean');
				date_default_timezone_set('Asia/Jakarta');
				$t = time();
				$data = "$ID&$t";
				$secretKey = config('app.secretkey_antrean');
				$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true)); 

				$request = array();
				// parse_str($re, $request);
				$req = '{"kodebooking": "'.$c->nomorantrian.'"}'; 
				// dd($req);
				$completeurl = config('app.antrean_url_web_service') . "antrean/getlisttask";
				// dd($completeurl);
				
				$session = curl_init($completeurl);
				$arrheader = array(
					'x-cons-id: ' . $ID,
					'x-timestamp: ' . $t,
					'x-signature: ' . $signature,
					'user_key:'.config('app.user_key_antrean'),
					'Content-Type: application/json',
				);
				curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
				curl_setopt($session, CURLOPT_POSTFIELDS, $req);
				curl_setopt($session, CURLOPT_POST, TRUE);
				curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
				$response = curl_exec($session);
				// // dd($response);
				$message = json_decode($response, true);
				$array = json_decode($response, true);
				if($message['metadata']['code'] == 200){
					$stringEncrypt = $this->stringDecrypt($ID.config('app.secretkey_antrean').$t,$array['response']);
					$array = json_decode($this->decompress($stringEncrypt),true);
					$data_antrian[$key]['data'] = $array;
				}
			}
			
			// dd(date('Y-m-d H:i',strtotime("02-12-2023 07:52:51 WIB")));
			// dd($cek_reg);
			// dd($r->all());
			Excel::create('Lap Responses Time Pelayanan '.$r->tgl, function ($excel) use ($data_antrian) {
				// Set the properties
				$excel->setTitle('Lap Responses Time Pelayanan')
					->setCreator('Digihealth')
					->setCompany('Digihealth')
					->setDescription('Lap Responses Time Pelayanan');
				$excel->sheet('Lap Responses Time Pelayanan', function ($sheet) use ($data_antrian) {
					$row = 1;
					$no  = 1;
					$sheet->row($row, [
						'No',
						'Kode Booking',
						'RM',
						'poli',
						'Poli',
						'TaskID 1',
						'TaskID 2-1',
						'TaskID 2',
						'TaskID 3-2',
						'TaskID 3',
						'TaskID 4-3',
						'TaskID 4',
						'TaskID 5-4',
						'TaskID 5',
						'TaskID 6-5',
						'TaskID 6',
						'TaskID 6-7',
						'TaskID 7'
					]);
					foreach ($data_antrian as $key => $d) {
						if(@$d['data'][0]['wakturs']){
							@$taskid_1   	= date_create(@$d['data'][0]['wakturs']);
							@$taskid_2  	= date_create(@$d['data'][1]['wakturs']);
							@$taskid_3  	= date_create(@$d['data'][2]['wakturs']);
							@$taskid_4  	= date_create(@$d['data'][3]['wakturs']);
							@$taskid_5  	= date_create(@$d['data'][4]['wakturs']);
							@$taskid_6  	= date_create(@$d['data'][5]['wakturs']);
							@$taskid_7  	= date_create(@$d['data'][6]['wakturs']);
							
							if(@$taskid_1 && @$taskid_2){
								@$diff_1       = date_diff(@$taskid_1, @$taskid_2);
							}
							
							if(@$taskid_2 && @$taskid_3){
								@$diff_2       = date_diff(@$taskid_2, @$taskid_3);
							}
							if(@$taskid_3 && @$taskid_4){
								@$diff_3       = date_diff(@$taskid_3, @$taskid_4);
							}
							if(@$taskid_4 && @$taskid_5){
								@$diff_4       = date_diff(@$taskid_4, @$taskid_5);
							}
							if(@$taskid_5 && @$taskid_6){
								@$diff_5       = date_diff(@$taskid_5, @$taskid_6);
							}
							if(@$taskid_6 && @$taskid_7){
								@$diff_6       = date_diff(@$taskid_6, @$taskid_7);
							}

							$sheet->row(++$row, [
								$no++,
								$d['nomorantrian'],
								$d['no_rm'],
								$d['nama'],
								$d['poli'],
								@$d['data'][0]['wakturs'],
								@$diff_1->i . 'menit',
								@$d['data'][1]['wakturs'],
								@$diff_2->i . 'menit',
								@$d['data'][2]['wakturs'],
								@$diff_3->i . 'menit',
								@$d['data'][3]['wakturs'],
								@$diff_4->i . 'menit',
								@$d['data'][4]['wakturs'],
								@$diff_5->i . 'menit',
								@$d['data'][5]['wakturs'],
								@$diff_6->i . 'menit',
								@$d['data'][6]['wakturs'],
							]);

						}
					}
				});
			})->export('xlsx');
		}
		// dd($data_antrian);
		
		return view('bridgingsep.koneksi.index',compact('data_antrian'));
	}

	public function koneksiVclaim($type=NULL){
		$data['type']  = $type;
		return view('bridgingsep.koneksi.koneksi_sep',$data);
	}

	public function dataKoneksiVclaim($type=NULL){
		if($type == 'aplikasiFinger'){
			$completeurl = config('app.sep_url_web_service') . "/SEP/FingerPrint/Peserta/0000416469295/TglPelayanan/2024-01-11";
		}elseif($type =='surkon'){
			$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/noSuratKontrol/0237R0041121K000025";
		}elseif($type =='noka'){
			$completeurl = config('app.sep_url_web_service') . "/Rujukan/List/Peserta/0000132213609"; //Multiple
		}elseif($type =='jadwaldokter'){
			$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/JadwalPraktekDokter/JnsKontrol/2/KdPoli/INT/TglRencanaKontrol/2024-11-01";
		}elseif($type =='poli'){
			$completeurl = config('app.sep_url_web_service')."/referensi/poli/INT";
		}elseif($type =='insert_sep'){
			$completeurl = config('app.sep_url_web_service') . "/SEP/2.0/insert"; //Insert
		}elseif($type =='hapus_sep'){
			$completeurl = config('app.sep_url_web_service') . "/SEP/2.0/delete";
		}elseif($type =='spri'){
			$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/InsertSPRI";
		}elseif($type =='buat_surkon'){
			$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/insert";
		}elseif($type =='hapus_surkon'){
			$completeurl = config('app.sep_url_web_service') . "/RencanaKontrol/Delete";
		}elseif($type =='histori_kunjungan'){
			$completeurl = config('app.sep_url_web_service') . "/monitoring/HistoriPelayanan/NoKartu/0001321159792/tglAwal/2024-01-11/tglAkhir/2024-01-11";
		}elseif($type =='sep'){
			$completeurl = config('app.sep_url_web_service')."/SEP/1824R0020622V005380";
		}elseif($type =='tte'){
			$completeurl = config('app.esign_client');
		}else{
			$completeurl = config('app.sep_url_web_service')."/SEP/1824R0020622V005380";
		}
		$session = curl_init($completeurl);

		
		return getResponseTime($session);
		
	}
	public function dataKunjunganPoliDashboard(){
		// $keyCache = 'data_kunjungan_poli_dashboard';
		// $data['poli'] = Cache::get($keyCache);
		// if(!$data['poli']){
			$data['poli'] = HistorikunjunganIRJ::leftJoin('polis', 'histori_kunjungan_irj.poli_id', '=', 'polis.id')->select('histori_kunjungan_irj.poli_id')->where('histori_kunjungan_irj.created_at', 'LIKE', date('Y-m-d').'%')->where('histori_kunjungan_irj.poli_id', '<>', '')->orderBy('polis.urutan','ASC')->distinct()->get();
		// 	Cache::put($keyCache,$data['poli'],120);
		// }
		 
		return view('bridgingsep.koneksi.dashboard_poli',$data);
	}
	public function dataKunjunganDashboard($type=NULL){
		if($type == 'rajal'){
			// $keyCache = 'count_rajal';
			// $count = Cache::get($keyCache);
			// if(!$count){
				$count = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->where('politipe', 'J')->count();
			// 	Cache::put($keyCache,$count,120);
			// }
		}elseif($type =='igd'){
			// $keyCache = 'count_igd';
			// $count = Cache::get($keyCache);
			// if(!$count){
				$count = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->where('politipe', 'G')->count();
			// 	Cache::put($keyCache,$count,120);
			// }
			
		}elseif($type =='irna'){
			// $keyCache = 'count_irna';
			// $count = Cache::get($keyCache);
			// if(!$count){
				$count = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->where('politipe', 'I')->count();
			// 	Cache::put($keyCache,$count,120);
			// }
			
		}elseif($type == 'total'){
			// $keyCache = 'count_total';
			// $count = Cache::get($keyCache);
			// if(!$count){
				$count = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->count();
			// 	Cache::put($keyCache,$count,120);
			// }
		}elseif($type == 'l'){
			// $keyCache = 'count_laki';
			// $count = Cache::get($keyCache);
			// if(!$count){
				$count = Historipengunjung::join('pasiens', 'histori_pengunjung.pasien_id', '=', 'pasiens.id')
                                ->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')
                                ->where('pasiens.kelamin', '=', 'L')->count();
			// 	Cache::put($keyCache,$count,120);
			// }
			
		}elseif($type== 'p'){
			// $keyCache = 'count_perempuan';
			// $count = Cache::get($keyCache);
			// if(!$count){
				$count = Historipengunjung::join('pasiens', 'histori_pengunjung.pasien_id', '=', 'pasiens.id')
                                ->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')
                                ->where('pasiens.kelamin', '=', 'P')->count();
			// 	Cache::put($keyCache,$count,120);
			// }
			
		}
		

		
		return $count;
		
	}


	
}