<?php

namespace App\Http\Controllers\Emr;

use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Modules\Registrasi\Entities\Registrasi; 
use App\KondisiAkhirPasien;
use App\Posisiberkas; 
use App\PerawatanIcd10;
use App\Http\Controllers\Controller;
use App\PerawatanIcd9;
use Modules\Registrasi\Entities\Carabayar; 
use App\MasterEtiket;
use App\TakaranobatEtiket;
use App\Aturanetiket; 
use App\Emr;
use App\EmrPengkajianHarian;
use Modules\Pegawai\Entities\Pegawai;
use Auth;

class EmrPengkajianController extends Controller
{ 

	
	 // Pengkajian Harian
	public function pengkajianHarian($unit, $registrasi_id, $id_soap = NULL, $edit=NULL){
        $data['registrasi_id']  = $registrasi_id;
        $data['unit']           = $unit;
        $data['reg']            = Registrasi::find($registrasi_id);
        $data['resume']         = Emr::where('pasien_id', @$data['reg']->pasien->id)->first();
        $data['kondisi']        = KondisiAkhirPasien::pluck('namakondisi', 'id');
        $data['posisi']         = Posisiberkas::pluck('keterangan', 'id');
		$data['perawatanicd9']  = PerawatanIcd9::where('registrasi_id', $registrasi_id)->get();
		$data['perawatanicd10'] = PerawatanIcd10::where('registrasi_id', $registrasi_id)->get();
		$data['dokter'] = Pegawai::pluck('nama', 'id');
        $data['carabayar'] 	= Carabayar::all('carabayar', 'id');
		$data['tiket'] 		= MasterEtiket::all('nama', 'id');
		$data['cara_minum'] = Aturanetiket::all('aturan', 'id');
		$data['takaran'] 	= TakaranobatEtiket::all('nama', 'nama');
        $data['all_resume']     = EmrPengkajianHarian::where('pasien_id', @$data['reg']->pasien_id)->orderBy('id','DESC')->get();
		$data['emr']			= EmrPengkajianHarian::find($id_soap);

        return view('emr.modules.pengkajian_harian', $data);
    }
	public function savePengkajianHarian(Request $request){ 
		
        $create = new EmrPengkajianHarian();
        $create->registrasi_id = $request->registrasi_id; 
        $create->pasien_id = @$request->pasien_id;
        $create->dokter_id = @$request->dokter_id;
        $create->tekanandarah = $request->tekanan_darah;
        $create->nadi = $request->nadi;
        $create->frekuensi_nafas = $request->frekuensi_nafas;
        $create->suhu = $request->suhu;
        $create->berat_badan = $request->berat_badan;
        $create->skala_nyeri = $request->skala_nyeri;
        $create->tanggal = $request->tanggal;
        $create->user_id = Auth::user()->id;
        $create->unit = $request->unit;
        
        $create->save();
        
        Flashy::success('Pengkajian Harian berhasil di input !');
        
        return redirect()->back();
    }
	public function updatePengkajianHarian(Request $request){ 
		// dd($request->all());
        $create = EmrPengkajianHarian::find($request->emr_id);
		if($create){
			$create->tekanandarah = $request->tekanan_darah;
			$create->nadi = $request->nadi;
			$create->frekuensi_nafas = $request->frekuensi_nafas;
			$create->suhu = $request->suhu;
			$create->skala_nyeri = $request->skala_nyeri;
			$create->tanggal = $request->tanggal;
			$create->user_id = Auth::user()->id;
			$create->save();
		}
        
        
        Flashy::success('Data berhasil diedit !');
        
        return redirect()->back();
    }
	public function deletePengkajianHarian($id){
        $data = EmrPengkajianHarian::find($id);
		if($data){
			$data->deleted_at = date('Y-m-d H:i:s');
			$data->save();
		}
        
        
        Flashy::success('Data berhasil dihapus !');
        
        return redirect()->back();
    }
	public function duplicatePengkajianHarian($id,$reg_id){ 
		
		$find = Emr::find($id);
		if($find){
			// dd($find);
			$create = new Emr();
			$create->registrasi_id = $reg_id; 
			$create->pasien_id = @$find->pasien_id; 
			$create->subject = $find->subject;
			$create->object = $find->object;
			$create->assesment = $find->assesment;
			$create->notation = $find->notation;
			$create->planning = $find->planning;
			$create->unit = $find->unit;
			$create->created_at = date("Y-m-d H:i:s");
			$create->save();
			Flashy::success('EMR berhasil di duplikat');
		}
        // $create->keterangan = $request->kondisi;
        
         
        
        return redirect()->back();
    }

}
