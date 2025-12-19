<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Registrasi;
use App\Hasilradiologi;
use Modules\Registrasi\Entities\Folio;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Tarif\Entities\Tarif;
use App\KondisiAkhirPasien;
use Modules\Registrasi\Entities\HistoriStatus;
use App\Orderradiologi;
use App\Foliopelaksana;
use App\HistorikunjunganRAD;
use App\Pasienlangsung;
use App\HistorikunjunganRM;
use Auth;
use Excel;
use PDF;
use DB;
use Modules\Registrasi\Entities\Carabayar;
use Illuminate\Support\Facades\Cache;

class RehabmedikController extends Controller{
    public function tindakanIRJ(){
        session()->forget(['dokter', 'pelaksana', 'perawat']);
        
        $keyCache = 'data_rehab';
            $data['registrasi'] = Cache::get($keyCache);
			if(!$data['registrasi']){
                $data['registrasi'] = Registrasi::where('status_reg', 'like', 'J%')->where('poli_id', 20)->where('created_at', 'LIKE', date('Y-m-d').'%')->orderBy('created_at', 'asc')->get();
                Cache::put($keyCache,$data['registrasi'],120); //BUAT CACHE 2 menit
            }
        return view('rehabmedik.tindakanIRJ', $data)->with('no', 1);
    }

    public function tindakanIRJByTanggal(Request $request){
        request()->validate(['tga'=>'required']);
        session()->forget(['dokter', 'pelaksana', 'perawat']);
        $data['registrasi'] = Registrasi::where('status_reg', 'like', 'J%')->where('poli_id', 20)->whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])->orderBy('created_at', 'asc')->get();
        return view('rehabmedik.tindakanIRJ', $data)->with('no', 1);
    }

    public function tindakanIRD(){
        session()->forget(['dokter', 'pelaksana', 'perawat']);
        $data['registrasi'] = Registrasi::where('status_reg', 'like', 'G%')->where('created_at', 'LIKE', date('Y-m-d').'%')->orderBy('created_at', 'asc')->get();
        return view('rehabmedik.tindakanIRD', $data)->with('no', 1);
    }

    public function tindakanIRDByTanggal(Request $request){
        request()->validate(['tga'=>'required']);
        session()->forget(['dokter', 'pelaksana', 'perawat']);
        $data['registrasi'] = Registrasi::where('status_reg', 'like', 'G%')->whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])->orderBy('created_at', 'asc')->get();
        return view('rehabmedik.tindakanIRD', $data)->with('no', 1);
    }

    public function tindakanIRNA(){
        // $data['registrasi'] = Registrasi::join('order_radiologi', 'registrasis.id', '=', 'order_rehabmedik.registrasi_id')
        //                                   ->join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
        //                                   ->select('registrasis.id as id', 'registrasis.bayar', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.pasien_id as pasien_id', 'rawatinaps.kamar_id')
        //                                   ->get();
        session()->forget(['dokter', 'pelaksana', 'perawat']);
        $keyCache = 'data_rehab_ranap';
        $data['registrasi'] = Cache::get($keyCache);
			if(!$data['registrasi']){
                $data['registrasi'] = Registrasi::whereIn('status_reg', ['I1', 'I2'])->orderBy('created_at', 'asc')->get();
                Cache::put($keyCache,$data['registrasi'],120); //BUAT CACHE 2 menit
            }
        return view('rehabmedik.tindakanIRNA', $data)->with('no', 1);
    }

    public function tindakanIRNAByTanggal(Request $request){
        request()->validate(['tga'=>'required']);
        // $data['registrasi'] = Registrasi::join('order_radiologi', 'registrasis.id', '=', 'order_rehabmedik.registrasi_id')
        //                                   ->join('rawatinaps', 'registrasis.id', '=', 'rawatinaps.registrasi_id')
        //                                   ->whereBetween('order_rehabmedik.created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
        //                                   ->select('registrasis.id as id', 'registrasis.bayar', 'registrasis.dokter_id', 'registrasis.poli_id', 'registrasis.pasien_id as pasien_id', 'rawatinaps.kamar_id')
        //                                   ->get();
        session()->forget(['dokter', 'pelaksana', 'perawat']);
        $data['registrasi'] = Registrasi::whereIn('status_reg', ['I1', 'I2'])
                                        ->whereBetween('created_at', [valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59'])
                                        ->orderBy('created_at', 'asc')
                                        ->get();
        return view('rehabmedik.tindakanIRNA', $data)->with('no', 1);
    }

    public function insertKunjungan($registrasi_id, $pasien_id){
        $reg = Registrasi::find($registrasi_id);
        $cek = HistorikunjunganRM::where('registrasi_id', $registrasi_id)->where('created_at', 'like', date('Y-m-d').'%')->count();
        if($cek == 0){
        $hk = new HistorikunjunganRM();
        $hk->registrasi_id = $registrasi_id;
        $hk->pasien_id = $pasien_id;
        $hk->poli_id = $reg->poli_id;
        if(substr($reg->status_reg, 0,1) == 'J') {
            $hk->pasien_asal = 'TA';
        } elseif (substr($reg->status_reg, 0,1) == 'G') {
            $hk->pasien_asal = 'TG';
        } elseif (substr($reg->status_reg, 0,1) == 'I') {
            $hk->pasien_asal = 'TI';
        }
        $hk->user = Auth::user()->name;
        $hk->save();
        }
        return redirect('rehabmedik/entry-tindakan-irj/'. $registrasi_id.'/'.$pasien_id);
    }

    public function entryTindakanIRNA($idreg, $idpasien){
        $data['folio'] = Folio::where('registrasi_id', $idreg)
                ->where('poli_tipe', 'M')->get();
        $data['pasien'] = Pasien::find($idpasien);
        $data['reg'] = Registrasi::find($idreg);
        $data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
        $data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
        $data['tagihan'] = Folio::where('registrasi_id',$idreg)->where('poli_tipe', 'M')->where('lunas', 'N')->sum('total');
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawat'] = Pegawai::where('kategori_pegawai', 2)->get();
        $data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
        $data['carabayar'] = Carabayar::pluck('carabayar', 'id');

        $jenis = $data['jenis']->status_reg;
        if (substr($jenis, 0, 1) == 'G') {
            session(['jenis' => 'TG']);
            $data['tindakan'] = Tarif::where('jenis', '=', 'TG')->where('total', '<>', 0)->get();
        } elseif (substr($jenis, 0, 1) == 'J') {
            session(['jenis' => 'TA']);
            $data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
        } elseif (substr($jenis, 0, 1) == 'I') {
            session(['jenis' => 'TI']);
            $data['opt_poli'] = Poli::where('politype', 'M')->get();
        }

        $data['opt_poli'] = Poli::where('politype', 'M')->get();
        $data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
        return view('rehabmedik.entryTindakanRehabmedikIRNA', $data)->with('no', 1);

    }

    public function entryTindakanIRJ($idreg, $idpasien){
        $data['folio'] = Folio::where(['registrasi_id' => $idreg, 'poli_tipe' => 'M'])->get();

        $data['pasien'] = Pasien::find($idpasien);
        $data['reg'] = Registrasi::find($idreg);
        $data['jenis'] = Registrasi::where('id', '=', $idreg)->first();
        $data['poli'] = Folio::where('registrasi_id', '=', $idreg)->distinct();
        $data['tagihan'] = Folio::where('registrasi_id',$idreg)->where('poli_tipe', 'M')->where('lunas', 'N')->sum('total');
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->get();
        $data['perawat'] = Pegawai::where('kategori_pegawai', 2)->get();
        $data['kat_tarif'] = Kategoritarif::select('namatarif', 'id')->get();
        $data['carabayar'] = Carabayar::pluck('carabayar', 'id');

        $jenis = $data['jenis']->status_reg;
        if (substr($jenis, 0, 1) == 'G') {
            session(['jenis' => 'TG']);
            $data['tindakan'] = Tarif::where('jenis', '=', 'TG')->where('total', '<>', 0)->get();
        } elseif (substr($jenis, 0, 1) == 'J') {
            session(['jenis' => 'TA']);
            $data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
        } elseif (substr($jenis, 0, 1) == 'M') {
            $jns = HistorikunjunganRM::where('registrasi_id', $idreg)->first();
            session(['jenis' => $jns->pasien_asal]);
            $data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
        } elseif (substr($jenis, 0, 1) == 'I') {
            session(['jenis' => 'TI']);
            $data['opt_poli'] = Poli::where('politype', 'M')->get();
        }

        $data['opt_poli'] = Poli::where('politype', 'M')->get();
        $data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
        
        return view('rehabmedik.entryTindakanRehabmedik', $data)->with('no', 1);
    }

    public function saveTindakan(Request $request){
        request()->validate(['tarif_id' => 'required']);
        session(['dokter'=>$request['dokter_id'], 'pelaksana'=>$request['pelaksana'], 'perawat'=>$request['perawat']]);
        $reg = Registrasi::find($request->registrasi_id);

        foreach($request->tarif_id as $t) {
   
            $tarif = Tarif::find($t);
            $fol = new Folio();
            $fol->registrasi_id = $reg->id;
            $fol->poli_id       = $request->poli_id;
            $fol->lunas         = 'N';
            $fol->namatarif     = $tarif->nama;
            $fol->tarif_id      = $tarif->id;
            // $fol->jenis         = $tarif->jenis;
            if(substr($reg->status_reg,0,1) == 'G'){
                $fol->jenis = 'TG';
            }elseif (substr($reg->status_reg,0,1) == 'I') {
                $fol->jenis = 'TI';
            }elseif (substr($reg->status_reg,0,1) == 'J') {
                $fol->jenis = 'TA';
            }
            $fol->cara_bayar_id = (isset($request->cara_bayar_id)) ? $request->cara_bayar_id : $reg->bayar;
            $fol->poli_tipe     = 'M';
            $fol->total         = ($tarif->total * $request->jumlah);
            $fol->jenis_pasien  = $request['jenis'];
            $fol->pasien_id     = $request['pasien_id'];
            $fol->dokter_id     = $request['dokter_id'];
            $fol->user_id       = Auth::user()->id;
            $fol->poli_id       = 20;
    
            //revisi foliopelaksana
           $fol->dpjp = $reg->dokter_id;
           $fol->radiografer = $request['pelaksans'];
            if(substr($reg->status_reg,0,1) == 'G'){
               $fol->pelaksana_tipe = 'TG';
            }elseif(substr($reg->status_reg,0,1) == 'I') {
               $fol->pelaksana_tipe = 'TI';
            }elseif(substr($reg->status_reg,0,1) == 'J') {
               $fol->pelaksana_tipe = 'TA';
            }
            $fol->save();
        





        //INSERT FOLIO PELAKSANA
    //    $fp = new Foliopelaksana();
    //     $fp->folio_id = $fol->id;
    //     $fp->dpjp = $reg->dokter_id;
    //     $fp->radiografer = $request['pelaksana'];
    //     if(substr($reg->status_reg,0,1) == 'G'){
    //         $fp->pelaksana_tipe = 'TG';
    //     }elseif(substr($reg->status_reg,0,1) == 'I') {
    //         $fp->pelaksana_tipe = 'TI';
    //     }elseif(substr($reg->status_reg,0,1) == 'J') {
    //         $fp->pelaksana_tipe = 'TA';
    //     }
    //     $fp->user = Auth::user()->id;
    //     $fp->save();

        //Update status registrasi
    }   
        if(substr($reg->status_reg,0,1) == 'G'){
            $reg->status_reg = 'G2';
        }elseif (substr($reg->status_reg,0,1) == 'I') {
            $reg->status_reg = 'I2';
        }elseif (substr($reg->status_reg,0,1) == 'R') {
            $reg->status_reg = 'R1';
        }else{
            $reg->status_reg = 'J2';
        }
        $reg->update();
    
        // Insert Histori
        $history = new HistoriStatus();
        $history->registrasi_id = $reg->id;
        if(substr($reg->status_reg,0,1) == 'G'){
            $history->status = 'G2';
        }elseif (substr($reg->status_reg,0,1) == 'J') {
            $history->status = 'J2';
        } else {
            $history->status = 'I2';
        }

        $history->poli_id       = $request['poli_id'];
        $history->bed_id        = null;
        $history->user_id       = Auth::user()->id;
        $history->save();
    
        session()->forget('jenis');
        if (substr($reg->status_reg,0,1) == 'I') {
            return redirect('rehabmedik/entry-tindakan-irna/'.$request['registrasi_id'].'/'.$request['pasien_id']);
        } elseif (substr($reg->status_reg,0,1) == 'R') {
            return redirect('rehabmedik/entry-transaksi-langsung/'.$request['registrasi_id']);
        } else {
            return redirect('rehabmedik/entry-tindakan-irj/'.$request['registrasi_id'].'/'.$request['pasien_id']);
        }
        // return redirect()->back();
    }

    public function rehabCetak($reg_id, $pasien_id){
        $pasien = Pasien::find($pasien_id);
        $folio = Folio::where('registrasi_id', $reg_id)
            ->where(['poli_tipe' => 'M','lunas' => 'N'])->get();
        $reg = Registrasi::find($reg_id);
        $tindakan = Folio::where(['registrasi_id' => $reg_id, 'poli_tipe' => 'M','lunas' => 'N'])->get();
        return view('rehabmedik.cetak', compact('reg', 'pasien', 'folio', 'tindakan'))->with('no', 1);
    }

    public function hapusTindakan($id, $idreg, $pasien_id){
        if (Auth::user()->hasRole(['supervisor', 'radiologi','administrator', 'rehabmedik'])) {
        Folio::where('id',$id)->where('lunas', 'N')->delete();
        // Foliopelaksana::where('folio_id', $id)->delete();
        }
        $reg = Registrasi::find($idreg);
        if(substr($reg->status_reg,0,1) == 'I'){
            return redirect('rehabmedik/entry-tindakan-irna/'.$idreg.'/'.$pasien_id);
        } elseif (substr($reg->status_reg,0,1) == 'R') {
            return redirect('rehabmedik/entry-transaksi-langsung/'.$idreg);
        } else {
            return redirect('rehabmedik/entry-tindakan-irj/'.$idreg.'/'.$pasien_id);

        }
    }

    public function laporan(){
        $data['tga']        = '';
        $data['tgb']        = '';
        $data['tarif_id']   = 0;
		$data['bayar']      = 0;
		$data['cara_bayar']	= Carabayar::all();
        $data['tindakan']   = Folio::whereIn('poli_tipe', ['M','J'])->groupBy('tarif_id', 'namatarif')->selectRaw('namatarif, tarif_id')->get();
        return view('rehabmedik.filterLaporan', $data)->with('no', 1);
    }

    public function filterLaporan(Request $req){
        request()->validate(['tga'=>'required', 'tgb'=>'required']);
        $tga                = valid_date($req->tga). ' 00:00:00';
        $tgb                = valid_date($req->tgb). ' 00:00:00';
        $data['tarif_id']   = $req->tarif_id;
        $data['bayar']      = $req->bayar;
        $data['jenis']      = $req->jenis;
		$data['cara_bayar']	= Carabayar::all();
        $data['tindakan']   = Folio::whereIn('poli_tipe', ['M','J'])->groupBy('tarif_id', 'namatarif')->selectRaw('namatarif, tarif_id')->get();

        $data['tga']    = $req->tga;
        $data['tgb']    = $req->tgb;
        $data['lap']    = Registrasi::leftJoin('folios', 'folios.registrasi_id', '=', 'registrasis.id')
                        ->whereBetween('folios.created_at', [$tga, $tgb])
                        // ->where('folios.poli_tipe', 'M')
                        ->where('folios.poli_id', 20)
                        ->where('folios.jenis', '!=', 'ORJ')
                        ->where('namatarif', 'not like', '%Sticker label 60 mm X 40 mm%')
                        ->where('namatarif', 'not like', '%Retribusi Poliklinik Rehabilitasi Medik%')
						// ->where('registrasis.bayar', ($req->bayar == 0) ? '>' : '=', $req->bayar)
						// ->where('folios.tarif_id', ($req->tarif_id == 0) ? '>' : '=', $req->tarif_id)
                        ->select(
                            DB::raw("GROUP_CONCAT(folios.namatarif SEPARATOR '||') as tindakan"),
                            DB::raw("GROUP_CONCAT(folios.created_at SEPARATOR '||') as tanggal"),
                            DB::raw("GROUP_CONCAT(folios.total SEPARATOR '||') as total"),
                            'folios.dokter_id','registrasis.id as registrasi_id','registrasis.ubah_dpjp', 'folios.radiografer','registrasis.user_create','registrasis.bayar','registrasis.pasien_id','registrasis.status','registrasis.poli_id'
                        )
                        ->groupBy('folios.registrasi_id', 'folios.dokter_id');

                        if (isset($data['jenis'])) {
                            $data['lap'] =  $data['lap']->where('folios.jenis',  $data['jenis']);
                        }

                        $data['lap'] = $data['lap']->get();
        
		if($req->lanjut){
			return view('rehabmedik.filterLaporan', $data)->with('no', 1);
		}elseif($req->pdf) {
			$no = 1;
			return view('rehabmedik.cetakLaporan', $data, compact('no'));
			// $pdf = PDF::loadView('operasi.rekap-laporan', compact('datareg', 'no'));
			// $pdf->setPaper('A4', 'landscape');
			// return $pdf->download('rekap-laporan.pdf');
		}
    }
    
    //TRANSAKSI LANGSUNG
    public function transaksiLangsung(){
        // $data = Pasienlangsung::where('created_at', 'like', date('Y-m-d').'%')->where('politype', 'M')->get();
        $data = Pasienlangsung::leftJoin('registrasis', 'registrasis.id', '=', 'pasien_langsung.registrasi_id')
                ->where('pasien_langsung.created_at', 'like', date('Y-m-d').'%')->where('pasien_langsung.politype', 'M')->get();
        return view('rehabmedik.transaksiLangsung', compact('data'))->with('no', 1);
    }

    public function simpanTransaksiLangsung(Request $request){
        request()->validate(['nama'=>'required', 'alamat'=>'required']);
        DB::transaction(function () use ($request) {
            // $reg = Registrasi::find()
            $id = Registrasi::where('reg_id', 'LIKE',date('Ymd').'%')->count();
            $reg = new Registrasi();
            $reg->pasien_id     = '0';
            $reg->status_reg    = 'R1';
            $reg->bayar         = '2';
            $reg->reg_id        = date('Ymd').sprintf("%04s", ($id + 1));
            $reg->user_create   = Auth::user()->id;
            $reg->save();

            $pasien = new Pasienlangsung();
            $pasien->registrasi_id = $reg->id;
            $pasien->nama = $request['nama'];
            $pasien->alamat = $request['alamat'];
            $pasien->politype = 'R';
            $pasien->pemeriksaan = $request['pemeriksaan'];
            $pasien->user_id = Auth::user()->id;
            $pasien->save();

            $hk = new HistorikunjunganRM();
            $hk->registrasi_id = $reg->id;
            $hk->pasien_id = '0';
            $hk->poli_id = '18';
            $hk->pasien_asal = 'TA';
            $hk->user = Auth::user()->name;
            $hk->save();
            session(['registrasi_id' => $reg->id]);
        });
        return redirect('/radiologi/entry-transaksi-langsung/'.session('registrasi_id'));
    }

    public function entryTindakanLangsung($registrasi_id){
        $data['folio'] = Folio::where('registrasi_id', $registrasi_id)->where('poli_id', 20)->get();
        $data['pasien'] = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
        $data['reg_id'] = $registrasi_id;
        $data['poli'] = Folio::where('registrasi_id', '=', $registrasi_id)->distinct();
        $data['tagihan'] = Folio::where('registrasi_id',$registrasi_id)->where('poli_id', 20)->where('lunas', 'N')->sum('total');
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $data['perawat'] = Pegawai::pluck('nama', 'id');
        $data['tindakan'] = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
        $data['jenis'] = Registrasi::find($registrasi_id);
        $data['opt_poli'] = Poli::where('politype', 'M')->get();
        $data['kondisi'] = KondisiAkhirPasien::pluck('namakondisi', 'id');
        session(['jenis' => 'TA']);
        return view  ('rehabmedik.entryTindakanLangsung', $data)->with('no', 1); 
    }






    public function getTarifDataFisio(Request $request) {
        ini_set('max_execution_time', 0);
		ini_set('memory_limit', '8000M');
		$term = trim($request->q);

		if (empty($term)) {
			return \Response::json([]);
		}
		
		$tags =  Tarif::where('nama', 'like', '%' . $term . '%')->get();

		$formatted_tags = [];
        
		foreach ($tags as $tag) {
			if($request->j == 1){
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | Rp. ' . number_format($tag->total)];
			}elseif($request->j == 5){
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | Rp. ' . number_format($tag->total)];
			}else{
				$formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | Rp. ' . number_format($tag->total)];
			}
		}
		return \Response::json($formatted_tags);
	}















    /*
    public function laporanKunjungan($unit = ''){
        if($unit == 'rajal'){
            $data['j']  = 'TA';
        }elseif($unit == 'ranap'){
            $data['j']  = 'TI';
        }else{
            $data['j']  = 'TG';
        }
        return view('rehabmedik.filterLaporan', $data)->with('no', 1);
    }

    public function filterLaporan(Request $req){
        $tga          = valid_date($req->tga).' 00:00:00';
        $tgb          = valid_date($req->tgb).' 23:59:59';

        $data['lap']  = HistorikunjunganRM::join('registrasis', 'registrasis.id', '=', 'histori_kunjungan_rm.registrasi_id')
                    ->join('folios', 'folios.registrasi_id', '=', 'histori_kunjungan_rm.')
                    ->where('pasien_asal', $req->jenis)
                    ->whereBetween('created_at', [$tga, $tgb])->get();

        return view('rehabmedik.filterLaporan', $data)->with('no', 1);
    }*/


    // public function lap_kunjungan(){
    //   $data['dokter'] = Pegawai::select('id','nama')->get();
    //   $data['petugas'] = Hasilradiologi::distinct()->get(['who_update']);
    //   return view('rehabmedik.lap_kunjungan', $data);
    // }

    // public function lap_kunjungan_by_request(Request $request){
    //   echo 'Masuk';die;
    //   request()->validate(['tga'=>'required', 'tgb'=>'required']);
    //   $dokter = Pegawai::select('id')->get();
    //   $di = [];
    //   foreach ($dokter as $key => $d) {
    //     $di[] = ''.$d->id.'';
    //   }

    //   $petugas = Hasilradiologi::distinct()->get(['who_update']);
    //   $ptg = [];
    //   foreach ($petugas as $key => $d) {
    //     $ptg[] = ''.$d->who_update.'';
    //   }

    //   if(!empty($request['tipe_jkn'])) {
    //     $data['reg'] = Registrasi::join('folios', 'registrasis.id', '=', 'folios.registrasi_id')
    //                       ->where('folios.poli_tipe', '=', 'M')
    //                       ->whereBetween('registrasis.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
    //                       ->whereIn('folios.dokter_id', !empty($request['dokter']) ? [$request['dokter']] : $di)
    //                       ->whereIn('registrasis.bayar', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
    //                       ->whereIn('registrasis.tipe_jkn', [$request['tipe_jkn']])
    //                       ->select('registrasis.id','registrasis.pasien_id','registrasis.poli_id', 'registrasis.bayar', 'registrasis.jenis_pasien', 'registrasis.tipe_jkn', 'folios.*')
    //                       ->get();
    //   } else {
    //     $data['reg'] = Registrasi::join('folios', 'registrasis.id', '=', 'folios.registrasi_id')
    //                       ->where('folios.poli_tipe', '=', 'M')
    //                       ->whereBetween('registrasis.created_at', [ valid_date($request['tga']).' 00:00:00', valid_date($request['tgb']).' 23:59:59' ])
    //                       ->whereIn('folios.dokter_id', !empty($request['dokter']) ? [$request['dokter']] : $di)
    //                       ->whereIn('registrasis.bayar', !empty($request['jenis_pasien']) ? [$request['jenis_pasien']] : ['1','2'])
    //                       ->select('registrasis.id','registrasis.pasien_id','registrasis.poli_id', 'registrasis.bayar', 'registrasis.jenis_pasien', 'registrasis.tipe_jkn', 'folios.*')
    //                       ->get();
    //   }
    //   $datareg = $data['reg'];
    //   $data['dokter'] = Pegawai::select('id','nama')->get();
    //   $data['petugas'] = Hasilradiologi::distinct()->get(['who_update']);

    //   if($request['lanjut']){
    //     return view('rehabmedik.lap_kunjungan', $data)->with('no', 1);

    //   } elseif ($request['excel']) {
    //     Excel::create('Laporan Kunjungan Radiologi', function($excel) use ($datareg) {
    //     // Set the properties
    //     $excel->setTitle('Laporan Kunjungan Radiologi')
    //           ->setCreator('Digihealth')
    //           ->setCompany('Digihealth')
    //           ->setDescription('Laporan Kunjungan Radiologi');
    //     $excel->sheet('Laporan Kunjungan Radiologi', function($sheet) use ($datareg) {
    //       $row = 1;
    //       $no = 1;
    //       $sheet->row($row, [
    //                     'No',
    //                     'No. RM',
    //                     'Nama',
    //                     'Alamat',
    //                     'Umur',
    //                     'L/P',
    //                     'Cara Bayar',
    //                     'Poli',
    //                     'Dokter',
    //                     'Tanggal / Waktu',
    //                     'Diagnosa Utama',
    //                     'Petugas'
    //                 ]);
    //         foreach ($datareg as $key => $d) {
    //           $sheet->row(++$row, [
    //                       $no++,
    //                       $d->pasien->no_rm,
    //                       $d->pasien->nama,
    //                       $d->pasien->alamat,
    //                       hitung_umur($d->pasien->tgllahir, 'Y'),
    //                       $d->pasien->kelamin,
    //                       baca_carabayar($d->bayar).' '.$d->tipe_jkn,
    //                       baca_poli($d->poli_id),
    //                       $d->dokter,
    //                       tanggal($d->created_at),
    //                       strip_tags($d->pemeriksaan),
    //                       $d->who_update
    //             ]);
    //           };
    //         });
    //     })->export('xlsx');

    //   } elseif ($request['pdf']) {
    //     $reg = $data['reg'];
    //     $no = 1;
        // $pdf = PDF::loadView('rehabmedik.pdf_lap_kunjungan', compact('reg', 'no'));
    //     $pdf->setPaper('A4', 'landscape');
    //     return $pdf->download('lap_kunjungan_rehabmedik.pdf');
    //   }
    // }
}