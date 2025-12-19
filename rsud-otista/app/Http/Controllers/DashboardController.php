<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use Modules\Bed\Entities\Bed;
use Modules\Kelas\Entities\Kelas;
use App\Historipengunjung;
use DB;
use Modules\Registrasi\Entities\Folio;
use Modules\Tarif\Entities\Tarif;

class DashboardController extends Controller{
    public function updateMappingFolio(){
        // echo date('d M Y H:i:s');
        // $c = Folio::where('mapping_biaya_id', null)->where('tarif_id', '!=', 10000)->count();
        //SELECT `tarif_folio` as `id_old`, `f_jenis` as `j_old`, `f_nama` as `n_old`, `tarifs`.`id` as `id`, `tarifs`.`jenis` as `jenis`, `tarifs`.`nama` as `nama` FROM (SELECT `folios`.`id` as `tarif_folio`, `folios`.`jenis` as `f_jenis`, `folios`.`namatarif` as `f_nama` FROM `folios` INNER JOIN `tarifs` ON `folios`.`tarif_id` = `tarifs`.`id` WHERE `folios`.`jenis` != `tarifs`.`jenis` AND `folios`.`jenis` != 'ORJ') as `old` INNER JOIN `tarifs` ON `old`.`f_nama` = `tarifs`.`nama` AND `old`.`f_jenis` = `tarifs`.`jenis`
        //UPDATE `folios` SET `mapping_biaya_id` = (SELECT `mapping_biaya_id` FROM `tarifs` WHERE `folios`.`tarif_id` = `tarifs`.`id`)
        // return view('dashboard.updateMappingFolio', compact('c'));
    }
    public function index(){
        $data['poli'] = DB::table('histori_kunjungan_irj')->where('created_at', 'LIKE', date('Y-m-d').'%')->select('poli_id')->where('created_at', 'LIKE', date('Y-m-d').'%')->distinct()->get();
    	$data['tanggal'] = date('Y-m-d');
    	return view('dashboard.index', $data)->with('no',1);
    }

    public function dataDashboard(Request $request){
        $data['poli'] = DB::table('histori_kunjungan_irj')->where('created_at', 'LIKE', valid_date($request['tanggal']).'%')->select('poli_id')->where('created_at', 'LIKE', valid_date($request['tanggal']).'%')->distinct()->get();
        $data['tanggal'] = valid_date($request['tanggal']);
        return view('dashboard.index', $data)->with('no', 1);
    }

    public function statusBed(){
    	$data['totalbed'] = Bed::count();
        $data['kelas'] = Kelas::where('nama', '<>', '-')->take(12)->get();
        $data['tanggal'] = date('Y-m-d');
        return view('dashboard.displaybed', $data)->with('no', 1);
    }

    public function diagnosa(){
        $tga = date('Y').'-'.date('m').'-01';
        $tgb = date('Y').'-'.date('m').'-31';
        $data['tanggal'] = date('Y-m-d');
        $data['irj'] = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah FROM perawatan_icd10s WHERE created_at BETWEEN "'.$tga.'" AND "'.$tgb.'" AND jenis <> "TI"
                            GROUP BY icd10 ORDER BY jumlah DESC limit 10');
        $data['irna'] = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah FROM perawatan_icd10s WHERE created_at BETWEEN "'.$tga.'" AND "'.$tgb.'" AND jenis = "TI"
                            GROUP BY icd10 ORDER BY jumlah DESC limit 10');
        return view('dashboard.diagnosa', $data)->with(['no_irj'=>1, 'no_irna'=>1]);
    }

    public function diagnosaByTanggal(Request $request){
        
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);
        $data['tanggal'] = date('Y-m-d');
        $data['irj'] = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah FROM perawatan_icd10s WHERE created_at BETWEEN "'.$tga.'" AND "'.$tgb.'" AND jenis <> "TI"
                            GROUP BY icd10 ORDER BY jumlah DESC limit 10');
        $data['irna'] = DB::select('SELECT icd10 AS diagnosa, sum(1) AS jumlah FROM perawatan_icd10s WHERE created_at BETWEEN "'.$tga.'" AND "'.$tgb.'" AND jenis = "TI"
                            GROUP BY icd10 ORDER BY jumlah DESC limit 10');
        return view('dashboard.diagnosa', $data)->with(['no_irj'=>1, 'no_irna'=>1]);
    }

    //Display Pengunjung To Informasi
    public function display(){

        $tga   = date('2022').'-'.date('01').'-01';
        $tgb   = date('2023').'-'.date('12').'-31';
        $data['tanggal'] = date('Y-m-d');

        // $poli  = DB::table('histori_pengunjung')
        //         ->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
        //         ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
        //         ->groupBy('histori_pengunjung.created_at')
        //         ->select('histori_pengunjung.politipe', 'histori_pengunjung.created_at', DB::raw('count(*) as total'), DB::raw('sum(1) as jml'))
        //         ->limit(10)->get();
        // dd($poli);
        
        $data['total'] = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->count();
        $data['l']     = Historipengunjung::join('pasiens', 'histori_pengunjung.pasien_id', '=', 'pasiens.id')
                        ->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')
                        ->where('pasiens.kelamin', '=', 'L')->count();
        $data['p']     = Historipengunjung::join('pasiens', 'histori_pengunjung.pasien_id', '=', 'pasiens.id')
                        ->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')
                        ->where('pasiens.kelamin', '=', 'P')->count();
        $data['rajal'] = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->where('politipe', 'J')->count();
        $data['igd']   = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->where('politipe', 'G')->count();
        $data['jkn']   = Historipengunjung::leftJoin('registrasis', 'histori_pengunjung.registrasi_id', '=', 'registrasis.id')->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')->where('bayar', '1')->count();
        $data['umum']  = Historipengunjung::leftJoin('registrasis', 'histori_pengunjung.registrasi_id', '=', 'registrasis.id')->where('histori_pengunjung.created_at', 'LIKE', date('Y-m-d').'%')->where('bayar', '<>', '1')->count();
        $data['irna']  = Historipengunjung::where('created_at', 'LIKE', date('Y-m-d').'%')->where('politipe', 'I')->count();
       
       return view('dashboard.informasikominfo', $data);

    }

    public function pengunjung(){
        $tga = date('Y').'-'.date('m').'-01';
        $tgb = date('Y').'-'.date('m').'-31';
        $data['tanggal'] = date('Y-m-d');
        $data['per_layanan'] = DB::table('histori_pengunjung')
                                ->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
                                ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
                                ->groupBy('histori_pengunjung.politipe')
                                ->select('histori_pengunjung.politipe', DB::raw('count(*) as total'))
                                ->get();
        $data['per_poli'] = DB::table('histori_pengunjung')
                                ->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
                                ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
                                ->groupBy('registrasis.poli_id')
                                ->select('registrasis.poli_id', DB::raw('count(*) as total'))
                                ->get();
        return view('dashboard.pengunjung', $data)->with(['no' => 1, 'tga' => $tga, 'tgb' => $tgb, 'i' => 1]);
    }
    

    public function pengunjungByTanggal(Request $request){
        $tga = valid_date($request['tga']);
        $tgb = valid_date($request['tgb']);
        $data['tanggal'] = date('Y-m-d');
        $data['per_layanan'] = DB::table('histori_pengunjung')
                                ->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
                                ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
                                ->groupBy('histori_pengunjung.politipe')
                                ->select('histori_pengunjung.politipe', DB::raw('count(*) as total'))
                                ->get();
        $data['per_poli'] = DB::table('histori_pengunjung')
                                ->join('registrasis', 'registrasis.id', '=', 'histori_pengunjung.registrasi_id')
                                ->whereBetween('histori_pengunjung.created_at', [$tga, $tgb])
                                ->groupBy('registrasis.poli_id')
                                ->select('registrasis.poli_id', DB::raw('count(*) as total'))
                                ->get();
        return view('dashboard.pengunjung', $data)->with(['no' => 1, 'tga' => $tga, 'tgb' => $tgb, 'i' => 1]);
    }
}
