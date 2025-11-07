<?php

namespace App\Http\Controllers;

use App\Kategoriobat;
use App\LogistikBatch;
use App\Masterobat;
use App\RecordSatuSehat;
use App\Satuanbeli;
use App\Satuanjual;
use DB;
use Flashy;
use Excel;
use Illuminate\Http\Request;
use Modules\Accounting\Entities\Master\AkunCOA;
use Validator;
use App\Satusehat;
use Yajra\DataTables\DataTables;

class MasterobatController extends Controller
{
	public function index()
	{
		
		return view('masterobat.datatable');
	}

	public function ajax_masterobat()
	{
		return DataTables::of();
	}

	public function create()
	{
		$data['satuanbeli'] = Satuanbeli::pluck('nama', 'id');
		$data['satuanjual'] = Satuanjual::pluck('nama', 'id');
		$data['kategoriobat'] = Kategoriobat::pluck('nama', 'id');

		$akunCoa = AkunCOA::where('akun_code_9', '!=', '0')->get()->toArray();
		foreach ($akunCoa as $value) {
			$data['akun_coa'][$value['id']] = implode(' - ', [$value['code'], $value['nama']]);
		}

		return view('masterobat.create', $data);
	}

	public function import(Request $request)
	{
		//dd('test import master obat');

		ini_set('max_execution_time', 500); //300 seconds = 5 minutes
		ini_set('max_execution_time', 0); //0=NOLIMIT

		request()->validate(['excel' => 'required']);
		$excel = $request->file('excel');

		DB::beginTransaction();
		try {

			$excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
			})->get();

			$rowRules = [
				'nama'   => 'required',
				'umum'   => 'required',
				'jenis'  => 'required',
				'satuan' => 'required',
			];
			$data = [];

			//Looping data
			//dd($excels);
			foreach ($excels as $row) {
				$validator = Validator::make($row->toArray(), $rowRules);
				if ($validator->fails()) {
					continue;
				}
				// Satuan beli
				$satuanbeli = Satuanbeli::where('nama', $row['satuan'])->first();

				if (!$satuanbeli) {
					$sat       = new Satuanbeli();
					$sat->nama = $row['satuan'];
					$sat->save();
					$beli      = $sat->id;
				} else {
					$beli = $satuanbeli->id;
				}

				// Satuan Jual
				$satuanjual = Satuanjual::where('nama', $row['satuan'])->first();
				if (!$satuanjual) {
					$satj = new SatuanJual();
					$satj->nama = $row['satuan'];
					$satj->save();
					$jual = $satj->id;
				} else {
					$jual = $satuanjual->id;
				}

				$masterObat = Masterobat::where('nama', $row['nama'])->first(); //Cek obat 

				if (!$masterObat) { //Jika tiddk ada, buat baru
					$obat = new Masterobat();
					$obat->nama = $row['nama'];
					$obat->kode = $row['umum'];
					$obat->jenis_obat = $row['jenis'];
					$obat->satuanbeli_id = $beli;
					$obat->satuanjual_id = $jual;
					$obat->kategoriobat_id = 2;
					$obat->hargajual = 0;
					$obat->hargajual_jkn = 0;
					$obat->hargajual_kesda = 0;
					//$obat->hargabeli = $row['harga_beli'];
					$obat->hargabeli = 0;
					$obat->aktif = 'Y';
					$obat->save();
				} else { //update
					$masterObat->nama = $row['nama'];
					$obat->kode = $row['umum'];
					$obat->jenis_obat = $row['jenis'];
					$masterObat->satuanbeli_id = $beli;
					$masterObat->satuanjual_id = $jual;
					$masterObat->kategoriobat_id = 2;
					//$masterObat->hargajual = $row['harga_beli'];
					$masterObat->hargajual = 0;
					$masterObat->hargajual_jkn = 0;
					$masterObat->hargajual_kesda = 0;
					$masterObat->hargabeli = 0;
					$masterObat->aktif = 'Y';
					$masterObat->save();
				}
			}

			DB::commit();
			Flashy::success('Obat Berhasil diimport');
			return redirect('masterobat');
		} catch (Exception $e) {
			DB::rollback();

			Flashy::info('Gagal Import data');
			return redirect('masterobat');
		}
	}

	public function store(Request $request)
	{
		// dd($request);
		$data = request()->validate([
			'nama' => 'required|unique:masterobats,nama',
			'satuanjual_id' => 'required',
		]);
		$id_responsemedication = NULL;
		

		



		
		if(!is_numeric($request['satuanbeli_id'])){
			$cek_satuan = Satuanbeli::where('nama',$request['satuanbeli_id'])->first();
			if(!$cek_satuan){
				$cek_satuan = new Satuanbeli();
				$cek_satuan->nama = $request['satuanbeli_id'];
				$cek_satuan->save();
				$request['satuanbeli_id'] = $cek_satuan->id;
			}else{
				$request['satuanbeli_id'] = $cek_satuan->id;
			}
		}
		
		if(!is_numeric($request['satuanjual_id'])){
			$cek_satuan_jual = Satuanjual::where('nama',$request['satuanjual_id'])->first();
			if(!$cek_satuan_jual){
				$cek_satuan_jual = new Satuanjual();
				// dd($request['satuanjual_id']);
				$cek_satuan_jual->nama = $request['satuanjual_id'];
				$cek_satuan_jual->save();
				$request['satuanjual_id'] = $cek_satuan_jual->id;
			}else{
				$request['satuanjual_id'] = $cek_satuan_jual->id;
			}
		}
		

		$obat = new Masterobat();
		$obat->nama = $request['nama'];
		$obat->alias = $request['alias'];
		$obat->kode = $request['kode'];
		$obat->kategoriobat_id = $request['kategoriobat_id'];
		$obat->kodekfa = $request['kodekfa'];
		$obat->id_medication = @$id_responsemedication;
		$obat->satuanbeli_id = $request['satuanbeli_id'];
		$obat->satuanjual_id = $request['satuanjual_id'];
		$obat->hargajual = $this->rupiah($request['hargajual']);
		$obat->hargajual_jkn = $this->rupiah($request['hargajual_jkn']);
		$obat->hargajual_kesda = $this->rupiah($request['hargajual_kesda']);
		$obat->hargabeli = $this->rupiah($request['hargabeli']);
		$obat->aktif = 'Y';
		$obat->akutansi_akun_coa_id = $request['akutansi_akun_coa_id'];
		$obat->satuan_obat = $request['satuan_obat'];
		$obat->isi_satuan_obat = $request['isi_satuan_obat'];
		$obat->save();

        if(Satusehat::find(7)->aktif == 1) {
			if(satusehat()) {
				$obat->id_medication = SatuSehatController::MedicationPost($obat->id);
                $obat->save();
			}
		}
		Flashy::success('Master Obat Telah Ditambahkan');
		return redirect('masterobat');
	}

	public function show($id)
	{
		return Masterobat::find($id);
	}	




	public function editBatch($id) {
		
		$data['batch'] = LogistikBatch::where('id',$id)->first();
		// dd($data['batch']);
		$data['masterobat'] = Masterobat::find($data['batch']->masterobat_id);
		$data['satuanbeli'] = Satuanbeli::pluck('nama', 'id');
		$data['satuanjual'] = Satuanjual::pluck('nama', 'id');
		$data['kategoriobat'] = Kategoriobat::pluck('nama', 'id');
	
		return view('masterobat.edit_batch', $data);
		
	}

	public function updateBatch(Request $r) {
		// dd($r->all());
		$batch = LogistikBatch::where('id',$r->id_batch)->first();
		$batch->hargajual_umum = $r->hargajual;
		$batch->hargajual_jkn = $r->hargajual_jkn;
		$batch->hargajual_dinas = $r->hargajual_kesda;
		$batch->hargabeli = $r->hargabeli;
		$batch->save();
		Flashy::info('Data Master Obat Batch berhasil di update');
		return redirect('masterobat');
	}






	
	public function edit($id)
	{
		$data['masterobat'] = Masterobat::find($id);
		$data['satuanbeli'] = Satuanbeli::pluck('nama', 'id');
		$data['satuanjual'] = Satuanjual::pluck('nama', 'id');
		$data['kategoriobat'] = Kategoriobat::pluck('nama', 'id');
		$data['masterobat'] = Masterobat::find($id);
		$data['batch'] = LogistikBatch::where('masterobat_id',$id)->orderBy('id','DESC')->get();

		$akunCoa = AkunCOA::where('akun_code_9', '!=', '0')->get()->toArray();
		foreach ($akunCoa as $value) {
			$data['akun_coa'][$value['id']] = implode(' - ', [$value['code'], $value['nama']]);
		}

		return view('masterobat.edit', $data);
	}

	public function update(Request $request, $id)
	{
		// $data = request()->validate(['nama' => 'required|unique:masterobats,nama,' . $id]);
		$id_responsemedication = NULL;
	

		
		if(!is_numeric($request['satuanbeli_id'])){
			$cek_satuan = Satuanbeli::where('nama',$request['satuanbeli_id'])->first();
			if(!$cek_satuan){
				$cek_satuan = new Satuanbeli();
				$cek_satuan->nama = $request['satuanbeli_id'];
				$cek_satuan->save();
				$request['satuanbeli_id'] = $cek_satuan->id;
			}else{
				$request['satuanbeli_id'] = $cek_satuan->id;
			}
		}
		
		if(!is_numeric($request['satuanjual_id'])){
			$cek_satuan_jual = Satuanjual::where('nama',$request['satuanjual_id'])->first();
			if(!$cek_satuan_jual){
				$cek_satuan_jual = new Satuanjual();
				// dd($request['satuanjual_id']);
				$cek_satuan_jual->nama = $request['satuanjual_id'];
				$cek_satuan_jual->save();
				$request['satuanjual_id'] = $cek_satuan_jual->id;
			}else{
				$request['satuanjual_id'] = $cek_satuan_jual->id;
			}
		}

		$obat = Masterobat::find($id);
		$obat->nama = $request['nama'];
		$obat->alias = $request['alias'];
		$obat->kode = $request['kode'];
		$obat->kodekfa = $request['kodekfa'];
		$obat->id_medication = $id_responsemedication;
		$obat->saldo = $request['saldo'];
		$obat->kategoriobat_id = $request['kategoriobat_id'];
		$obat->satuanbeli_id = $request['satuanbeli_id'];
		$obat->satuanjual_id = $request['satuanjual_id'];
		$obat->hargajual = $this->rupiah($request['hargajual']);
		$obat->hargajual_jkn = $this->rupiah($request['hargajual_jkn']);
		$obat->hargajual_kesda = $this->rupiah($request['hargajual_kesda']);
		$obat->hargabeli = $this->rupiah($request['hargabeli']);
		$obat->aktif = 'Y';
		$obat->akutansi_akun_coa_id = $request['akutansi_akun_coa_id'];
		$obat->satuan_obat = $request['satuan_obat'];
		$obat->isi_satuan_obat = $request['isi_satuan_obat'];
		$obat->update();

        if(Satusehat::find(7)->aktif == 1) {
			if(satusehat()) {
				$obat->id_medication = SatuSehatController::MedicationPost($obat->id);
                $obat->save();
			}
		}
		Flashy::info('Data Master Obat berhasil di update');
		return redirect('masterobat');
	}

	public function destroy($id)
	{
		$batches = LogistikBatch::where('masterobat_id',$id)->orderBy('id','DESC')->get();
		$obat = Masterobat::find($id);
		$batches->delete();
		$obat->delete();

		Flashy::info('Data Master Obat berhasil di hapus');
		return redirect('masterobat');

	}



	public function hapus($id)
	{
		// $batches = LogistikBatch::where('masterobat_id',$id)->orderBy('id','DESC')->get();
		$obat = Masterobat::find($id);
		// $batches->delete();
		$obat->delete();

		Flashy::info('Data Master Obat berhasil di hapus');
		return redirect('masterobat');

	}


	public function rupiah($angka)
	{
		$d = str_replace('.', '', $angka);
		$r = str_replace(',', '', $d);
		return $r;
	}

    public function prosesSatuSehat($masterobat_id){
        $obat = Masterobat::find($masterobat_id);
        if($obat->kodekfa != null && $obat->kodekfa != '-'){
            $id_medication_ss = SatuSehatController::MedicationPost($masterobat_id);
            if($id_medication_ss == null){
                return redirect()->route('masterobat.edit', ['id' => $masterobat_id]);
            }
            $obat->id_medication = $id_medication_ss;
            $obat->save();
            Flashy::success('Berhasil integrasi Satusehat!');
            return redirect()->back();
        }
        Flashy::error('Kode KFA tidak boleh kosong!');
        return redirect()->route('masterobat.edit', ['id' => $masterobat_id]);
    }

	public function getData()
	{
		//dd('test');
		DB::statement(DB::raw('set @rownum=0'));
		$masterobat = Masterobat::select([
			'id',
			'nama',
			'satuanbeli_id',
			'satuanjual_id',
			'kategoriobat_id',
			'hargajual',
			'hargajual_jkn',
			'hargajual_kesda',
			'hargabeli',
			'id_medication',
		]);
		return DataTables::of($masterobat)
			->addIndexColumn()
			->editColumn('satuanbeli_id', function ($data) {
				return @$data->satuanbeli->nama;
			})
			->editColumn('satuanjual_id', function ($data) {
				return @$data->satuanjual->nama;
			})
			->editColumn('kategoriobat_id', function ($data) {
				return @$data->kategoriobat->nama;
			})
			->editColumn('hargajual', function ($data) {
				return @number_format(@$data->hargajual);
			})
			->editColumn('hargajual_jkn', function ($data) {
				return @number_format(@$data->hargajual_jkn);
			})
			->editColumn('hargajual_kesda', function ($data) {
				return @number_format(@$data->hargajual_kesda);
			})
			->editColumn('hargabeli', function ($data) {
				return @number_format(@$data->hargabeli);
			})
			->editColumn('id_medication', function ($data) {
				if($data->id_medication == null){
                    return '<a href="/masterobat/' . $data->id . '/proses-satu-sehat" class="btn btn-success btn-sm btn-flat">Proses SatuSehat</a>';
                }
				return $data->id_medication;
			})
			->addColumn('edit', function ($masterobat) {
				return '<a href="/masterobat/' . $masterobat->id . '/edit" class="btn btn-info btn-sm btn-flat"><i class="fa fa-edit"></i></a>';
						// <a href="/obat/' . $masterobat->id . '/hapus" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash"></i></a>';
			})
			->addColumn('hapus', function ($masterobat) {
				return '<a href="/masterobat/' . $masterobat->id . '/hapus" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash"></i></a>';
			})
			->rawColumns(['edit', 'hapus', 'id_medication'])
			->make(true);
	}

	//Kategori Obat
	function dataMasterObatPengelompokan()
	{
		$obat = Masterobat::all();
		return DataTables::of($obat)
			->addIndexColumn()
			->addColumn('generik', function ($obat) {
				$check = $obat->generik == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="generik['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="generik['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
            ->addColumn('non_generik', function ($obat) {
				$check = $obat->non_generik == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="non_generik['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="non_generik['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('formularium', function ($obat) {
				$check = $obat->formularium == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="formularium['.$obat->id.']"><input type="checkbox" name="formularium['.$obat->id.']" value="' . $obat->id . '" '.$check.'>';
			})
			->addColumn('narkotik', function ($obat) {
				$check = $obat->narkotik == 'Y' ? 'checked' : '';
				return'<input id="uncheck'.$obat->id.'" type="hidden" value="" name="narkotik['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="narkotik['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('high_alert', function ($obat) {
				$check = $obat->high_alert == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="high_alert['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="high_alert['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('fornas', function ($obat) {
				$check = $obat->fornas == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="fornas['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="fornas['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			// ->addColumn('non_fornas', function ($obat) {
			// 	$check = $obat->non_fornas == 'Y' ? 'checked' : '';
			// 	return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="non_fornas['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="non_fornas['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			// })
			->addColumn('non_formularium', function ($obat) {
				$check = $obat->non_formularium == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="non_formularium['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="non_formularium['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('psikotoprik', function ($obat) {
				$check = $obat->psikotoprik == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="psikotoprik['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="psikotoprik['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('bebas', function ($obat) {
				$check = $obat->bebas == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="bebas['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="bebas['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('e_katalog', function ($obat) {
				$check = $obat->e_katalog == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="e_katalog['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="e_katalog['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('lasa', function ($obat) {
				$check = $obat->lasa == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="lasa['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="lasa['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('antibiotik', function ($obat) {
				$check = $obat->antibiotik == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="antibiotik['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="antibiotik['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('tablet', function ($obat) {
				$check = $obat->tablet == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="tablet['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="tablet['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('injeksi', function ($obat) {
				$check = $obat->injeksi == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="injeksi['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="injeksi['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('infus', function ($obat) {
				$check = $obat->infus == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="infus['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="infus['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('obat_luar', function ($obat) {
				$check = $obat->obat_luar == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="obat_luar['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="obat_luar['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('BHP', function ($obat) {
				$check = $obat->BHP == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="BHP['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="BHP['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('sirup', function ($obat) {
				$check = $obat->sirup == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="sirup['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="sirup['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('paten', function ($obat) {
				$check = $obat->paten == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="paten['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="paten['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('bebas_terbatas', function ($obat) {
				$check = $obat->bebas_terbatas == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="bebas_terbatas['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="bebas_terbatas['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('keras', function ($obat) {
				$check = $obat->keras == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="keras['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="keras['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->addColumn('prekusor', function ($obat) {
				$check = $obat->prekusor == 'Y' ? 'checked' : '';
				return '<input id="uncheck'.$obat->id.'" type="hidden" value="" name="prekusor['.$obat->id.']"><input id="check'.$obat->id.'" type="checkbox" name="prekusor['.$obat->id.']" value="' . $obat->id . '" '.$check.' >';
			})
			->rawColumns(['antibiotik','lasa','e_katalog','generik', 'non_generik','formularium','narkotik','high_alert','fornas','non_formularium','psikotoprik','bebas','tablet','injeksi','infus', 'obat_luar', 'BHP', 'sirup', 'paten', 'fornas', 'bebas_terbatas', 'keras', 'prekusor'])
			->make(true);
	}
	//Kategori Obat
	function dataMasterObat($kategoriobat)
	{
		$obat = Masterobat::where($kategoriobat, NULL)->orWhere($kategoriobat, '')->get(['id', 'nama', 'kode']);
		return DataTables::of($obat)
			->addIndexColumn()
			->addColumn('edit', function ($obat) {
				return '<input type="checkbox" name="obat[]" value="' . $obat->id . '">';
			})
			->rawColumns(['edit'])
			->make(true);
	}

	//Data Obat Narkotika
	public function dataObatNarkotik()
	{
		$narkotik = Masterobat::where('narkotik', 'Y')->get(['id', 'nama', 'kode', 'narkotik']);
		return DataTables::of($narkotik)
			->addIndexColumn()
			->addColumn('hapus', function ($narkotik) {
				return '<button type="button" onclick="hapusKategori(' . $narkotik->id . ', \'narkotik\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	//Data Obat High Alert
	public function dataObatHighAlert()
	{
		$high_alert = Masterobat::where('high_alert', 'Y')->get(['id', 'nama', 'kode', 'high_alert']);
		return DataTables::of($high_alert)
			->addIndexColumn()
			->addColumn('hapus', function ($high_alert) {
				return '<button type="button" onclick="hapusKategori(' . $high_alert->id . ', \'high_alert\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	//Data Obat Pengelompokan
	public function dataObatPengelompokan()
	{
		$generik = Masterobat::all();
		return DataTables::of($generik)
			->addIndexColumn()
			->addColumn('hapus', function ($generik) {
				return '<button type="button" onclick="hapusKategori(' . $generik->id . ', \'generik\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	//Data Obat Generik
	public function dataObatGenerik()
	{
		$generik = Masterobat::where('generik', 'Y')->get(['id', 'nama', 'kode', 'generik']);
		return DataTables::of($generik)
			->addIndexColumn()
			->addColumn('hapus', function ($generik) {
				return '<button type="button" onclick="hapusKategori(' . $generik->id . ', \'generik\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}
    //Data Obat Non Generik
	public function dataObatNonGenerik()
	{
		$generik = Masterobat::where('non_generik', 'Y')->get(['id', 'nama', 'kode', 'non_generik']);
		return DataTables::of($generik)
			->addIndexColumn()
			->addColumn('hapus', function ($generik) {
				return '<button type="button" onclick="hapusKategori(' . $generik->id . ', \'non_generik\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	//Data Obat Fornas
	public function dataObatFornas()
	{
		$fornas = Masterobat::where('fornas', 'Y')->get(['id', 'nama', 'kode', 'fornas']);
		return DataTables::of($fornas)
			->addIndexColumn()
			->addColumn('hapus', function ($fornas) {
				return '<button type="button" onclick="hapusKategori(' . $fornas->id . ', \'fornas\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}
	public function dataObatNon_fornas()
	{
		$non_fornas = Masterobat::where('non_fornas', 'Y')->get(['id', 'nama', 'kode', 'non_fornas']);
		return DataTables::of($non_fornas)
			->addIndexColumn()
			->addColumn('hapus', function ($non_fornas) {
				return '<button type="button" onclick="hapusKategori(' . $non_fornas->id . ', \'non_fornas\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	//Data Obat Formularium
	public function dataObatFormularium()
	{
		$formularium = Masterobat::where('formularium', 'Y')->get(['id', 'nama', 'kode', 'formularium']);
		return DataTables::of($formularium)
			->addIndexColumn()
			->addColumn('hapus', function ($formularium) {
				return '<button type="button" onclick="hapusKategori(' . $formularium->id . ', \'formularium\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}
	
	public function dataObatnon_Formularium()
	{
		$non_formularium = Masterobat::where('non_formularium', 'Y')->get(['id', 'nama', 'kode', 'non_formularium']);
		return DataTables::of($non_formularium)
			->addIndexColumn()
			->addColumn('hapus', function ($non_formularium) {
				return '<button type="button" onclick="hapusKategori(' . $non_formularium->id . ', \'non_formularium\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	public function dataObatPsikotoprik()
	{
		$psikotoprik = Masterobat::where('psikotoprik', 'Y')->get(['id', 'nama', 'kode', 'psikotoprik']);
		return DataTables::of($psikotoprik)
			->addIndexColumn()
			->addColumn('hapus', function ($psikotoprik) {
				return '<button type="button" onclick="hapusKategori(' . $psikotoprik->id . ', \'psikotoprik\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	public function dataObatBebas()
	{
		$bebas = Masterobat::where('bebas', 'Y')->get(['id', 'nama', 'kode', 'bebas']);
		return DataTables::of($bebas)
			->addIndexColumn()
			->addColumn('hapus', function ($bebas) {
				return '<button type="button" onclick="hapusKategori(' . $bebas->id . ', \'bebas\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}
	//Data Obat E-Katalok
	public function dataObatEKatalog()
	{
		$e_katalog = Masterobat::where('e_katalog', 'Y')->get(['id', 'nama', 'kode', 'e_katalog']);
		return DataTables::of($e_katalog)
			->addIndexColumn()
			->addColumn('hapus', function ($e_katalog) {
				return '<button type="button" onclick="hapusKategori(' . $e_katalog->id . ', \'e_katalog\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	//Data Obat Lasa
	public function dataObatLasa()
	{
		$lasa = Masterobat::where('lasa', 'Y')->get(['id', 'nama', 'kode', 'lasa']);
		return DataTables::of($lasa)
			->addIndexColumn()
			->addColumn('hapus', function ($lasa) {
				return '<button type="button" onclick="hapusKategori(' . $lasa->id . ', \'lasa\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	//Data Obat Antibiotik
	public function dataObatAntibiotik()
	{
		$antibiotik = Masterobat::where('antibiotik', 'Y')->get(['id', 'nama', 'kode', 'antibiotik']);
		return DataTables::of($antibiotik)
			->addIndexColumn()
			->addColumn('hapus', function ($antibiotik) {
				return '<button type="button" onclick="hapusKategori(' . $antibiotik->id . ', \'antibiotik\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	// Data Obat Tablet
	public function dataObatTablet()
	{
		$tablet = Masterobat::where('tablet', 'Y')->get(['id', 'nama', 'kode', 'tablet']);
		return DataTables::of($tablet)
			->addIndexColumn()
			->addColumn('hapus', function ($tablet) {
				return '<button type="button" onclick="hapusKategori(' . $tablet->id . ', \'tablet\')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
	}

	function saveKategoriObat(Request $request)
	{
		
		$masterObat = [];
		$kategori = $request->kategoriobat;
		if ($request->obat) {
			foreach ($request->obat as $d) {
				$master = Masterobat::find($d);
				$master->$kategori = 'Y';
				$master->update();
				array_push($masterObat, $master->id);
			}
		}

		$jmlUpdate = Masterobat::whereIn('id', $masterObat)->get();
		if ($jmlUpdate->count() > 0) {
			return response()->json(['update' => true, 'pesan' => 'Sebanyak ' . $jmlUpdate->count() . ' obat di tambahkan ke obat ' . $kategori]);
		} else {
			return response()->json(['update' => false, 'pesan' => 'Tidak ada obat yang di tambahkan ke obat ' . $kategori]);
		}
	}

	function saveKategoriObatPengelompokan(Request $request)
	{
		// dd($request->all());
		$masterObat = [];
		$kategori = $request->kategoriobat;
		// generik
		foreach ($request->generik as $key=>$d) {
			$master = Masterobat::find($key);
			if($d == $key){
				$master->generik = 'Y';
			}else{
				$master->generik = NULL;
			}
			$master->update();
			// array_push($masterObat, $master->id);
		}
       
        foreach ($request->non_generik as $key=>$d) {
			$master = Masterobat::find($key);
			if($d == $key){
				$master->non_generik = 'Y';
			}else{
				$master->non_generik = NULL;
			}
			$master->update();
			// array_push($masterObat, $master->id);
		}

		 // Injeksi
         foreach ($request->injeksi as $key=>$d) {
			$master = Masterobat::find($key);
			if($d == $key){
				$master->injeksi = 'Y';
			}else{
				$master->injeksi = NULL;
			}
			$master->update();
		}
        // Infus
		foreach ($request->infus as $key=>$d) {
			$master = Masterobat::find($key);
			if($d == $key){
				$master->infus = 'Y';
			}else{
				$master->infus = NULL;
			}
			$master->update();
		}
        // Obat Luar
		foreach ($request->obat_luar as $key=>$d) {
			$master = Masterobat::find($key);
			if($d == $key){
				$master->obat_luar = 'Y';
			}else{
				$master->obat_luar = NULL;
			}
			$master->update();
		}

        // BHP
		foreach ($request->BHP as $key=>$d) {
			$master = Masterobat::find($key);
			if($d == $key){
				$master->BHP = 'Y';
			}else{
				$master->BHP = NULL;
			}
			$master->update();
		}

        // Sirup
		foreach ($request->sirup as $key=>$d) {
			$master = Masterobat::find($key);
			if($d == $key){
				$master->sirup = 'Y';
			}else{
				$master->sirup = NULL;
			}
			$master->update();
		}

        // paten
		foreach ($request->paten as $key=>$d) {
			$master = Masterobat::find($key);
			if($d == $key){
				$master->paten = 'Y';
			}else{
				$master->paten = NULL;
			}
			$master->update();
		}

        // paten
		foreach ($request->paten as $key=>$d) {
			$master = Masterobat::find($key);
			if($d == $key){
				$master->paten = 'Y';
			}else{
				$master->paten = NULL;
			}
			$master->update();
		}

		foreach ($request->bebas_terbatas as $key=>$d) {
			$master = Masterobat::find($key);
			if($d == $key){
				$master->bebas_terbatas = 'Y';
			}else{
				$master->bebas_terbatas = NULL;
			}
			$master->update();
		}

        foreach ($request->keras as $key=>$d) {
			$master = Masterobat::find($key);
			if($d == $key){
				$master->keras = 'Y';
			}else{
				$master->keras = NULL;
			}
			$master->update();
		}
        foreach ($request->prekusor as $key=>$d) {
			$master = Masterobat::find($key);
			if($d == $key){
				$master->prekusor = 'Y';
			}else{
				$master->prekusor = NULL;
			}
			$master->update();
		}
        
		// formularium
		foreach ($request->formularium as $key=>$d) {
			$master2 = Masterobat::find($key);
				if($d == $key){
					$master2->formularium = 'Y';
				}else{
					$master2->formularium = NULL;
				}
			
				$master2->update();
				// array_push($master2, $master2->id);
		}

		// narkotik
		foreach ($request->narkotik as $key=>$d) {
			$narkotik = Masterobat::find($key);
				if($d == $key){
					$narkotik->narkotik = 'Y';
				}else{
					$narkotik->narkotik = NULL;
				}
				$narkotik->update();
		}

		// high_alert
		foreach ($request->high_alert as $key=>$d) {
			$master2 = Masterobat::find($key);
				if($d == $key){
					$master2->high_alert = 'Y';
				}else{
					$master2->high_alert = NULL;
				}
				$master2->update();
		}

		// fornas
		foreach ($request->fornas as $key=>$d) {
			$master2 = Masterobat::find($key);
				if($d == $key){
					$master2->fornas = 'Y';
				}else{
					$master2->fornas = NULL;
				}
				$master2->update();
		}
		// non_formularium
		foreach ($request->non_formularium as $key=>$d) {
			$master2 = Masterobat::find($key);
				if($d == $key){
					$master2->non_formularium = 'Y';
				}else{
					$master2->non_formularium = NULL;
				}
				$master2->update();
		}

		// psikotoprik
		foreach ($request->psikotoprik as $key=>$d) {
			$master2 = Masterobat::find($key);
				if($d == $key){
					$master2->psikotoprik = 'Y';
				}else{
					$master2->psikotoprik = NULL;
				}
				$master2->update();
		}

		// bebas
		foreach ($request->bebas as $key=>$d) {
			$master2 = Masterobat::find($key);
				if($d == $key){
					$master2->bebas = 'Y';
				}else{
					$master2->bebas = NULL;
				}
				$master2->update();
		}
		// e_katalog
		foreach ($request->e_katalog as $key=>$d) {
			$master2 = Masterobat::find($key);
				if($d == $key){
					$master2->e_katalog = 'Y';
				}else{
					$master2->e_katalog = NULL;
				}
				$master2->update();
		}

		// lasa
		foreach ($request->lasa as $key=>$d) {
			$master2 = Masterobat::find($key);
				if($d == $key){
					$master2->lasa = 'Y';
				}else{
					$master2->lasa = NULL;
				}
				$master2->update();
		}

		// antibiotik
		foreach ($request->antibiotik as $key=>$d) {
			$master2 = Masterobat::find($key);
				if($d == $key){
					$master2->antibiotik = 'Y';
				}else{
					$master2->antibiotik = NULL;
				}
				$master2->update();
		}
		// tablet
		foreach ($request->tablet as $key=>$d) {
			$master2 = Masterobat::find($key);
				if($d == $key){
					$master2->tablet = 'Y';
				}else{
					$master2->tablet = NULL;
				}
				$master2->update();
		}

		$jmlUpdate = Masterobat::whereIn('id', $masterObat)->get();
		// if ($jmlUpdate->count() > 0) {
		return response()->json(['update' => true, 'pesan' => ' Obat Berhasil diupdate ']);
		// } else {
		// 	return response()->json(['update' => false, 'pesan' => 'Tidak ada obat yang di tambahkan ke obat ' . $kategori]);
		// }
	}

	public function hapusKategori($masterobat_id, $kategori)
	{
		$obat = Masterobat::find($masterobat_id);
		$obat->$kategori = NULL;
		$obat->update();
		if ($obat) {
			return response()->json(['update' => true, 'pesan' => 'Obat berhasil dihapus']);
		}
	}

	public function getMasterObat(Request $request)
	{
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}

		$tags = \App\Masterobat::where('nama', 'like', '%' . $term . '%')->limit(15)->get();

		$formatted_tags = [];

		foreach ($tags as $tag) {
			$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama];
		}

		return \Response::json($formatted_tags);
	}
}
