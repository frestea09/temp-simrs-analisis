<?php

namespace App\Http\Controllers\Emr;

use App\EmrInapIcd;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use App\Http\Controllers\Controller;
use Modules\Registrasi\Entities\Registrasi;
use App\EmrInapPemeriksaan;
use App\EmrInapPenilaian;
use App\PerawatanIcd10;
use App\PerawatanIcd9;
use App\RencanaKontrol;
use Auth;
use Modules\Icd10\Entities\Icd10;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;

class EmrSurkonController extends Controller
{ 

	
	public function index(Request $r,$unit,$registrasi_id){

		
        $data['registrasi_id']     = $registrasi_id;
        $data['unit']              = $unit;
		$data['poli']              = Poli::all();
		$data['dokter']            = Pegawai::whereNotNull('kode_bpjs')->get();
		$data['rencana_kontrol']   = RencanaKontrol::where('registrasi_id',$registrasi_id)->get();
        $data['reg']               = Registrasi::find($registrasi_id);
		$d = Registrasi::where('pasien_id',$data['reg']->pasien_id)->get();
		
		$idregs = [];
		if($d){

			foreach ($d as $s) {
				$idregs[] = $s->id;
			}
		}
		
		$data['riwayat']		   = PerawatanIcd10::whereIn('registrasi_id',$idregs)->orderBy('id','DESC')->get();
		// dd($data['riwayat']);
		// $data['riwayat']		   = EmrInapIcd::where('pasien_id',$data['reg']->pasien_id)->where('type','icd10')->orderBy('id','DESC')->get();
		
		
		if ($r->method() == 'POST')
		{
		


		foreach ($r->diagnosa_awal as $k) {
					

		$icd10 = new PerawatanIcd10();
		$icd10->icd10 = $k;
		$icd10->registrasi_id = $r->registrasi_id;
		$icd10->carabayar_id = $data['reg']->bayar;
		$icd10->jenis = baca_jenis_unit($unit);
		$icd10->kategori  = $r->kategori;
		$icd10->diagnosis  = $r->diagnosis;
		$icd10->kasus  = $r->kasus;
		$icd10->save();
		}
		 Flashy::success('Catatan berhasil disimpan');
		 return redirect()->back();
		}

		
        return view('emr.modules.surkon', $data);
    }
	

	public function penyebabKematian(Request $r,$registrasi_id){

		
        $data['registrasi_id']     = $registrasi_id;
        $data['unit']              = 'inap';
        $data['reg']               = Registrasi::find($registrasi_id);
		$data['riwayat']		   = EmrInapIcd::where('pasien_id',$data['reg']->pasien_id)->where('type','penyebab_kematian')->orderBy('id','DESC')->get();
		
		
		if ($r->method() == 'POST')
		{
			// dd($r->all());
		// $alatbantu = json_encode($r->alatbantu);
		 $emr = new EmrInapIcd();
		 $emr->pasien_id  = $r->pasien_id;
		 $emr->registrasi_id  = $r->registrasi_id;
		 $emr->user_id  = Auth::user()->id;
		 $emr->icd10  = $r->diagnosa_awal;
		 $emr->diagnosis  = $r->diagnosis;
		 $emr->kategori  = $r->kategori;
		 $emr->type  	= 'penyebab_kematian';
		 $emr->save();

		 Flashy::success('Catatan berhasil disimpan');
		 return redirect()->back();
		}

		
        return view('emr.modules.icd.penyebab_kematian', $data);
    }
	public function icd10Destroy($id){
       
		// dd($id);
        
		$icd		   = PerawatanIcd10::find($id);
		// dd($data['riwayat']);
		// $data['riwayat']		   = EmrInapIcd::where('pasien_id',$data['reg']->pasien_id)->where('type','icd10')->orderBy('id','DESC')->get();
		$icd->delete();

		 Flashy::success('Catatan berhasil di hapus');
		 return redirect()->back();
    }

}
