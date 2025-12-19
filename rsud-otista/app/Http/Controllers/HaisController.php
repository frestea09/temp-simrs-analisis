<?php

namespace App\Http\Controllers;

use App\HistoriRawatInap;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Modules\Registrasi\Entities\Registrasi;
use App\ResumePasien;
use App\KondisiAkhirPasien;
use App\Posisiberkas;
use App\PerawatanIcd10;
use App\PerawatanIcd9;
use App\PPI\Ppi;
use App\PPI\PpiAntibiotik;
use App\PPI\PpiFaktorPemakaian;
use App\Rawatinap;
use PDF;
use App\RencanaKontrol;
use DB;
use Auth;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;

class HaisController extends Controller
{
    

    public function create($unit, $registrasi_id){

      

        $data['unit']           = $unit;
        $data['reg']            = Registrasi::find($registrasi_id);
        $data['dokter'] = Pegawai::where('kategori_pegawai','1')->get();
        $data['perawat'] = Pegawai::where('kategori_pegawai','2')->get();

        $data['ppi']            =  \App\PPI\Ppi::where('pasien_id', $data['reg']->pasien_id)->get();
        $data['inap'] = DB::table('rawatinaps')
					->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
					// ->where('rawatinaps.created_at', 'LIKE', date('Y-m-d') . '%')
                    ->where('registrasis.id',$data['reg']->id)
					->where('registrasis.status_reg', 'I2')
                    ->orderBy('id','DESC')
					->select('rawatinaps.*', 'registrasis.status_reg')->first();
        $data['hais']  = Ppi::where('pasien_id',$data['reg']->pasien_id)->get();
        return view('hais.create', $data);
    }

    public function save(Request $request){

        DB::beginTransaction();
        try{
            // dd($request->all());
            $ppi = new Ppi();
            $ppi->pasien_id = $request->pasien_id;
            $ppi->registrasi_id = $request->reg_id;
            $ppi->unit = $request->unit;
            $ppi->komplikasi = $request->komplikasi;
            $ppi->tindakan_operasi = json_encode($request->tindakan_operasi);
            $ppi->kultur = json_encode($request->kultur);
            $ppi->is_umur = isset($request->is_umur) ? $request->is_umur : '0';
            $ppi->is_gizi = isset($request->is_gizi) ? $request->is_gizi : '0';
            $ppi->is_obesitas = isset($request->is_obesitas) ? $request->is_obesitas : '0';
            $ppi->is_diabetes = isset($request->is_diabetes) ? $request->is_diabetes : '0';
            $ppi->is_hiv = isset($request->is_hiv) ? $request->is_hiv : '0';
            $ppi->is_hbv = isset($request->is_hbv) ? $request->is_hbv : '0';
            $ppi->is_hcv = isset($request->is_hcv) ? $request->is_hcv : '0';
            $ppi->user_id = Auth::user()->id;
            $ppi->radiologi = $request->radiologi;
            $ppi->laboratorium = $request->laboratorium;
            $ppi->type = 'hais';
            $ppi->save();

            // insert risiko pemakaian
            
            if(isset($request->risiko['cek'])){
            foreach($request->risiko as $r){
              
                    $ppi_fp = new PpiFaktorPemakaian();
                    $ppi_fp->ppi_id = $ppi->id;
                    $ppi_fp->pasien_id = $ppi->pasien_id;
                    $ppi_fp->master_ppi_id = $r['id'];
                    $ppi_fp->tgl_terpasang = $r['tgl_terpasang'];
                    $ppi_fp->tgl_lepas = $r['tgl_lepas'];
                    $ppi_fp->total_hari = $r['total_hari'];
                    $ppi_fp->save();

                
            }
        }

            // insert antibiotik
            if(@$request->antibiotik['value'] == !null){
            foreach($request->antibiotik as $r){
               
                    $ppi_antibiotik = new PpiAntibiotik();
                    $ppi_antibiotik->ppi_id = $ppi->id;
                    $ppi_antibiotik->pasien_id = $ppi->pasien_id;
                    $ppi_antibiotik->antibiotik = $r['value'];
                    $ppi_antibiotik->tgl_pakai = $r['tgl_pakai'];
                    $ppi_antibiotik->tgl_berhenti = $r['tgl_berhenti'];
                    $ppi_antibiotik->save();

               
            }
        }

            DB::commit();
            Flashy::success('HAIs berhasil di input !');
        
            return redirect()->back();    
		}catch(Exception $e){
			DB::rollback();
			
			Flashy::info('Gagal Insert HAIs');
			return redirect()->back();
		} 
        
       
    }
    public function hapus($id) {
        Ppi::where('id',$id)->first()->delete();
        Flashy::success('HAIs berhasil dihapus !');
        return redirect()->back();
    }
    public function formCetakHais($id) {
        $data['hais'] = Ppi::where('id',$id)->first();
        if(!$data['hais']->registrasi_id){
            $regid = Registrasi::where('pasien_id',$data['hais']->pasien_id)->orderBy('id','DESC')->first();
        }else{
            $regid = Registrasi::where('id',$data['hais']->registrasi_id)->first();
        }
        $data['histori'] = Rawatinap::where('registrasi_id',$regid->id)->first();
        // dd($histori);
        // $resume = ResumePasien::where('registrasi_id', )->get();
        // dd('cek');
        $pdf = PDF::loadView('hais.formCetakHais',$data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('resume-laporan.pdf');
    }
}
