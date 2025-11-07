<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Foliopelaksana;
use App\histori_kunjungan_ambl;
use App\histori_kunjungan_jnz;
use App\Pasienlangsung;
use App\Rawatinap;
use App\Split;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Pasien\Entities\Pasien;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Tarif\Entities\Tarif;
use Modules\Registrasi\Entities\Carabayar;
use Modules\Registrasi\Entities\Folio;
use MercurySeries\Flashy\Flashy;

class PemulasaranController extends Controller{
    public function ceckTarif(){
        $tarif = Tarif::selectRaw('nama, jenis, total, COUNT(*)')
                ->groupBy(['nama', 'jenis', 'total'])->havingRaw('COUNT(*) > 1')->limit(20)->get();
        $count = Tarif::selectRaw('nama, jenis, total, COUNT(*)')
                ->groupBy(['nama', 'jenis', 'total'])->havingRaw('COUNT(*) > 1')->get();
        // SELECT `nama`, `jenis`, 'total', COUNT(*) FROM `tarifs` GROUP BY `nama`, `jenis`, `total` HAVING COUNT(*) > 1
        echo count($count).'<br/>';
        foreach($tarif as $t){
            $tar    = Tarif::where(['nama' => $t->nama, 'jenis' => $t->jenis, 'total' => $t->total])->get();
            $tar_f  = Tarif::where(['nama' => $t->nama, 'jenis' => $t->jenis, 'total' => $t->total])->first();
            foreach($tar as $tr){
                // echo $tr->id.' | '.$tr->kategoriheader_id.' | '.$tr->kategoritarif_id.' | '.$tr->jenis.' | '.$tr->nama.' | '.$tr->total.'<br/>';
                $fol = Folio::where('tarif_id', $tr->id)->get();
                foreach($fol as $f){
                    $folio = Folio::find($f->id);
                    $folio->tarif_id = $tar_f->id;
                    // $folio->update();
                    // echo '<br/>'.$f->id.' | '.$tr->nama.' = '.$f->namatarif.' | ';
                }
                if($tr->id != $tar_f->id){
                    // echo $tar_f->id;
                    $split = Split::where('tarif_id', $tr->id);
                    // $split->delete();

                    $tarif = Tarif::find($tr->id);
                    // $tarif->delete();
                }
            }
            // echo '<br/>';
        }
    }

    public function pasienLangsung(){
        $data = Pasienlangsung::leftJoin('registrasis', 'registrasis.id', '=', 'pasien_langsung.registrasi_id')
                ->where('.pasien_langsung.created_at', 'like', date('Y-m-d') . '%')
                ->whereIn('pasien_langsung.politype', ['Z', 'B'])
                ->get();
		return view('pemulasaran-jenazah.pasienLangsung', compact('data'))->with('no', 1);
    }

    public function entryAmbulansLangsung($reg_id = ''){
        $data['reg']        = Registrasi::find($reg_id);
        $data['tagihan']    = Folio::where('registrasi_id', $reg_id)->where('poli_tipe', 'B')
                    ->where('lunas', 'N')->sum('total');
        $data['dokter']     = Pegawai::pluck('nama', 'id');
        $data['poli_tipe']  = 'B';
        // $data['tindakan']   = Tarif::where('jenis', '=', 'TA')->where('total', '<>', 0)->get();
        $data['tindakan']   = Tarif::where('total', '<>', 0)->get();
        $data['cek']        = Folio::where(['jenis' => 'TA', 'registrasi_id' => $reg_id, 'poli_tipe' => 'B'])->count();
        $data['folio']      = Folio::where(['jenis' => 'TA', 'registrasi_id' => $reg_id, 'poli_tipe' => 'B'])->get();
        return view('pemulasaran-jenazah.entryTindakanLangsung', $data)->with('no', 1);
    }

    public function laporanPengunjung(){
        $data['tga']        = date('Y-m-d');
        $data['tgb']        = date('Y-m-d');
        $data['bayar']      = 0;
        $data['cara_bayar'] = Carabayar::all();
        $data['pengunjung'] = Folio::leftJoin('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
                    ->where('folios.created_at', 'like', date('Y-m-d').'%')
                    ->where('folios.poli_tipe', 'Z')->get();
        return view('pemulasaran-jenazah.laporanPengunjung', $data)->with('no', 1);
    }

    public function filterLaporan(Request $req){
        request()->validate(['tga'=>'required', 'tgb'=>'required']);
		$tga				= valid_date($req->tga).' 00:00:00';
        $tgb				= valid_date($req->tgb).' 23:59:59';
        
        $data['cara_bayar'] = Carabayar::all();
        $data['tga']        = $req->tga;
        $data['tgb']        = $req->tgb;
        $data['bayar']      = $req->bayar;
        $data['pengunjung'] = Folio::leftJoin('registrasis', 'registrasis.id', '=', 'folios.registrasi_id')
                    ->leftJoin('foliopelak', 'foliopelak.folio_id', '=', 'folios.id')
                    ->whereBetween('folios.created_at', [$tga, $tgb])
                    ->where('registrasis.bayar', ($req->bayar == 0) ? '>' : '=', $req->bayar)
                    ->where('folios.poli_tipe', 'Z')
                    ->select(
                        DB::raw("GROUP_CONCAT(folios.namatarif SEPARATOR '||') as tindakan"),
                        DB::raw("GROUP_CONCAT(folios.created_at SEPARATOR '||') as tanggal"),
                        DB::raw("GROUP_CONCAT(folios.total SEPARATOR '||') as total"),
                        DB::raw("GROUP_CONCAT(foliopelak.dokter_pelaksana SEPARATOR '||') as dokter"),
                        'registrasis.user_create','registrasis.bayar','registrasis.pasien_id','registrasis.status','registrasis.poli_id'
                    )
                    ->groupBy('folios.registrasi_id')->get();

        if($req->lanjut){
            return view('pemulasaran-jenazah.laporanPengunjung', $data)->with('no', 1);
        }else{
            return view('pemulasaran-jenazah.cetakLaporan', $data)->with('no', 1);
        }
    }

    public function tindakanRajal(){
        $data['tga']    = date('d-m-Y');
        $data['tgb']    = date('d-m-Y');
        $data['reg']    = Registrasi::where('status_reg', 'like', 'J%')->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
        return view('pemulasaran-jenazah.tindakanRajal', $data)->with('no', 1);
    }
    public function tindakanRanap(){
        $data['tga']    = date('d-m-Y');
        $data['tgb']    = date('d-m-Y');
        $data['reg']    = Registrasi::where('status_reg', 'like', 'I%')->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
        return view('pemulasaran-jenazah.tindakanIrna', $data)->with('no', 1);
    }
    public function tindakanDarurat(){
        $data['tga']    = date('d-m-Y');
        $data['tgb']    = date('d-m-Y');
        $data['reg']    = Registrasi::where('status_reg', 'like', 'G%')->where('created_at', 'LIKE', date('Y-m-d') . '%')->get();
        return view('pemulasaran-jenazah.tindakanDarurat', $data)->with('no', 1);
    }
    public function filterTindakanRajal(Request $req){
        $data['tga']    = valid_date($req['tga']).' 00:00:00';
        $data['tgb']    = valid_date($req['tgb']).' 23:59:59';
        $data['reg']    = Registrasi::where('status_reg', 'like', 'J%')->whereBetween('created_at', [$data['tga'], $data['tgb']])->get();
        return view('pemulasaran-jenazah.tindakanRajal', $data)->with('no', 1);
    }
    public function filterTindakanRanap(Request $req){
        $data['tga']    = valid_date($req['tga']).' 00:00:00';
        $data['tgb']    = valid_date($req['tgb']).' 23:59:59';
        $data['reg']    = Registrasi::where('status_reg', 'like', 'I%')->whereBetween('created_at', [$data['tga'], $data['tgb']])->get();
        return view('pemulasaran-jenazah.tindakanIrna', $data)->with('no', 1);
    }
    public function filterTindakanDarurat(Request $req){
        $data['tga']    = valid_date($req['tga']).' 00:00:00';
        $data['tgb']    = valid_date($req['tgb']).' 23:59:59';
        $data['reg']    = Registrasi::where('status_reg', 'like', 'G%')->whereBetween('created_at', [$data['tga'], $data['tgb']])->get();
        return view('pemulasaran-jenazah.tindakanDarurat', $data)->with('no', 1);
    }
    public function insertTindakan($jenis = '', $unit = '', $reg = '', $pasien = ''){
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '8000M');
        if($unit == 'ranap'){
            $data['j']      = 'TI';
            $data['unit']   = 'Rawat Inap';
        }elseif($unit == 'rajal'){
            $data['j']      = 'TA';
            $data['unit']   = 'Rawat Jalan';
        }elseif($unit == 'langsung'){
            if($jenis == 'jenazah'){
                $data['j']          = histori_kunjungan_jnz::where('registrasi_id', $reg)->first()->pasien_asal;
            }else{
                $data['j']          = histori_kunjungan_jnz::where('registrasi_id', $reg)->first()->pasien_asal;
            }
            $data['unit']   = 'Pasien Langsung';
        }else{
            $data['j']      = 'TG';
            $data['unit']   = 'Rawat Darurat';
        }

        if($jenis == 'jenazah'){
            $data['jenis']      = 'Jenazah';
            $data['poli_tipe']  = 'Z';
        }else{
            $data['jenis']      = 'Ambulans';
            $data['poli_tipe']  = 'B';
        }
        // dd($data['j']);
        $data['pasien']     = Pasien::find($pasien);
        $data['reg']        = Registrasi::find($reg);
        $data['tarif']      = Tarif::where(['jenis' => $data['j']])->groupBy('nama')->groupBy('total')->get();
		$data['carabayar']  = Carabayar::pluck('carabayar', 'id');
		$data['tagihan']    = Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
                ->where(['folios.registrasi_id' => $reg, 'folios.jenis' => $data['j'], 'lunas' => 'N'])
                ->whereIn('folios.poli_tipe', ['Z', 'B'])->sum('total');
        $data['folio']      = Folio::leftJoin('foliopelaksanas', 'folios.id', '=', 'foliopelaksanas.folio_id')
                ->where(['folios.registrasi_id' => $reg, 'folios.jenis' => $data['j']])
                ->whereIn('folios.poli_tipe', ['Z', 'B'])
                ->select('folios.*', 'foliopelaksanas.dokter_pelaksana', 'foliopelaksanas.id as fol_id')->get();
        $data['pelaksana']  = Pegawai::where('kategori_pegawai', '!=', '1')->pluck('nama', 'id');
        
        return view('pemulasaran-jenazah.insertTindakan', $data)->with('no', 1);
    }
    public function saveTindakan(Request $req){
        $tarif              = Tarif::find($req->tarif_id);

        // if($req->poli_tipe == 'B'){
        //     $data = histori_kunjungan_ambl::where('registrasi_id', $req->registrasi_id)->first();
        if($req->poli_tipe == 'Z'){
            $data = histori_kunjungan_jnz::where('registrasi_id', $req->registrasi_id)->first();
        }

        $fol                = new Folio();
        $fol->registrasi_id = $req->registrasi_id;
        $fol->namatarif     = $tarif->nama;
        $fol->cara_bayar_id = $req->cara_bayar_id;
        $fol->total         = $tarif->total * $req->jumlah;
        $fol->tarif_id      = $req->tarif_id;
        $fol->jenis         = $req->jenis;
        $fol->lunas         = 'N';
        $fol->jenis_pasien  = $req->jenis_pasien;
        $fol->pasien_id     = $req->pasien_id;
        $fol->created_at    = valid_date($req->tanggal).' '.now()->format('H:i:s');
        $fol->mapping_biaya_id = $tarif->mapping_biaya_id;
        $fol->poli_tipe     = $req->poli_tipe;
        $fol->dokter_pelaksana = $req->pelaksana;
        $fol->user_id       = Auth::user()->id;
        $fol->save();

        $p                  = new Foliopelaksana();
        $p->folio_id        = $fol->id;
        $p->dokter_pelaksana= $req->pelaksana;
        $p->pelaksana_tipe  = $req->jenis;
        $p->user            = Auth::user()->id;
        $p->save();

        return redirect()->back();
    }
    public function cetakTindakan($unit = '', $reg_id = ''){
        $id_fol             = Folio::where(['jenis' => $unit, 'registrasi_id' => $reg_id])->whereIn('poli_tipe', ['Z', 'B'])->first();
		$data['reg']        = Registrasi::find($reg_id);
        $data['tindakan']   = Folio::where(['jenis' => $unit, 'registrasi_id' => $reg_id])->whereIn('poli_tipe', ['Z', 'B'])->get();
        // $data['pelaksana']  = Foliopelaksana::where('folio_id', $id_fol->id)->first();
        $data['dibayar']	= Folio::where(['jenis' => $unit, 'registrasi_id' => $reg_id, 'lunas' => 'Y'])->whereIn('poli_tipe', ['Z', 'B'])->sum('total');
		$data['total']		= Folio::where(['jenis' => $unit, 'registrasi_id' => $reg_id])->whereIn('poli_tipe', ['Z', 'B'])->sum('total');
        
        return view('pemulasaran-jenazah.cetakTindakan', $data)->with('no', 1);
    }
    public function hapusTindakan($fol = '', $fol_id = ''){
        Folio::find($fol)->delete();
        Foliopelaksana::find($fol_id)->delete();

        return redirect()->back();
    }
	public function lunaskanTindakan(Request $request){
		foreach($request->lunas as $key){
			$id = (int)$key;
			$folio = Folio::find($id);
			$folio->lunas = 'Y';
			$folio->update();
		}
		Flashy::success('Tindakan berhasil di bayarkan / lunas');
		return response()->json(['sukses'=>true]);
	}
	public function belumLunaskanTindakan(Request $request){
		foreach($request->lunas as $key){
			$id = (int)$key;
			$folio = Folio::find($id);
			$folio->lunas = 'N';
			$folio->update();
		}
		Flashy::success('Tindakan berhasil');
		return response()->json(['sukses'=>true]);
	}
}