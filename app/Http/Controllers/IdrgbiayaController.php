<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Tarif\Entities\Tarif;
use Modules\Config\Entities\Tahuntarif;
use Yajra\DataTables\DataTables;
use App\Masteridrgbiaya;
use Flashy;
use DB;

class IdrgbiayaController extends Controller{
  //UPDATE `tarifs` AS `a` INNER JOIN `tarifs` AS `b` ON `a`.`nama` = `b`.`nama` SET `a`.`idrg_biaya_id` = 4 WHERE `b`.`idrg_biaya_id` = 4
    public function groupper($id = ''){
      $count = Tarif::where('idrg_biaya_id', $id)->count();
      if($id != ''){
        $map = Tarif::where('idrg_biaya_id', $id)->get();
        foreach($map as $m){
          $tar = Tarif::where('nama', $m->nama)->get();
          foreach($tar as $t){
            $rif = Tarif::find($t->id);
            // $rif->idrg_biaya_id = $id;
            // $rif->update();
          }
        }
      }
      return $count;
    }

    public function index(){
      return view('idrgbiaya.index');
    }

    public function dataIdrgBiaya(){
      DB::statement(DB::raw('set @nomorbaris=0'));
      $tarif = Masteridrgbiaya::select([
         DB::raw('@nomorbaris  := @nomorbaris  + 1 AS nomorbaris'),
                 'id',
                 'kelompok',
      ]);
      return DataTables::of($tarif)
          ->addColumn('idrg', function($tarif){
            return '<a href="'.url('idrg-biaya/'.$tarif->id).'" class="btn btn-info btn-flat btn-sm"><i class="fa fa-folder-open"></i></a>';
          })
          ->rawColumns(['idrg'])
          ->make(true);
    }

    public function idrgBiaya(){
      $master_biaya_id = Masteridrgbiaya::all();
      $tarif = Tarif::where('idrg_biaya_id', '=', NULL)->get();
      $kiri = ceil($tarif->count() / 2);
      $dataKiri = Tarif::where('idrg_biaya_id', '=', NULL)->skip(0)->take($kiri)->get();
      $dataKanan = Tarif::where('idrg_biaya_id', '=', NULL)->skip($kiri)->take($kiri)->get();
      return view('idrgbiaya.idrgBiaya', compact('tarif' ,'dataKiri', 'dataKanan', 'master_biaya_id'))->with('no', 1);
    }

    public function viewIdrgBiaya($id){
      $master_biaya_id  = Masteridrgbiaya::all();
      $kelompok         = Masteridrgbiaya::find($id)->kelompok;
      $tarif            = Tarif::where('idrg_biaya_id', '=', $id)->get();
      $kiri             = ceil($tarif->count() / 2);
      $dataKiri         = Tarif::where('idrg_biaya_id', '=', $id)->skip(0)->take($kiri)->get();
      $dataKanan        = Tarif::where('idrg_biaya_id', '=', $id)->skip($kiri)->take($kiri)->get();
      return view('idrgbiaya.viewIdrgBiaya', compact('tarif' ,'dataKiri', 'dataKanan', 'master_biaya_id', 'kelompok'))->with('no', 1);
    }

    public function simpanIdrg(Request $request){
        request()->validate(['idrg_biaya_id' => 'required']);
        $total = $request['total'];
        $idrg_biaya_id = $request['idrg_biaya_id'];
        $master_biaya = Masteridrgbiaya::find($idrg_biaya_id)->kelompok;
        $id = [];
        for ($i=1; $i <= $total ; $i++)
        {
            if(!empty($request['tarif'.$i])) {
                $tarif = Tarif::find($request['tarif'.$i]);
                $tarif->idrg_biaya_id = $idrg_biaya_id;
                $tarif->update();
                array_push($id, $tarif->id);
            }
        }
        $trf = Tarif::whereIn('id', $id)->get();
        Flashy::success($trf->count().' Tarif di berhasil di idrg di kelompok biaya '.$master_biaya);
        if (!empty($request['url'])) {
          return redirect('idrg-biaya/'.$request['url']);
        } else {
          return redirect('idrg-biaya-tarif');
        }
    }

    public function idrgDetail($masteridrg_id=''){
        DB::statement(DB::raw('set @nomorbaris=0'));
		$tarif = Tarif::select([
				 DB::raw('@nomorbaris  := @nomorbaris  + 1 AS nomorbaris'),
                 'id',
				 'nama',
                 'total'
			])->where('masteridrg_id', $masteridrg_id);
        return DataTables::of($tarif)
            ->addColumn('total', function ($tarif)
            {
                return number_format($tarif->total);
            })
            ->make(true);

    }

}
