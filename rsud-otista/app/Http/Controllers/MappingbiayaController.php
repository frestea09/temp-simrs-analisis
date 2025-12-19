<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Tarif\Entities\Tarif;
use Modules\Config\Entities\Tahuntarif;
use Yajra\DataTables\DataTables;
use App\Mastermappingbiaya;
use Flashy;
use DB;

class MappingbiayaController extends Controller{
  //UPDATE `tarifs` AS `a` INNER JOIN `tarifs` AS `b` ON `a`.`nama` = `b`.`nama` SET `a`.`mapping_biaya_id` = 4 WHERE `b`.`mapping_biaya_id` = 4
    public function groupper($id = ''){
      $count = Tarif::where('mapping_biaya_id', $id)->count();
      if($id != ''){
        $map = Tarif::where('mapping_biaya_id', $id)->get();
        foreach($map as $m){
          $tar = Tarif::where('nama', $m->nama)->get();
          foreach($tar as $t){
            $rif = Tarif::find($t->id);
            // $rif->mapping_biaya_id = $id;
            // $rif->update();
          }
        }
      }
      return $count;
    }

    public function index(){
      return view('mappingbiaya.index');
    }

    public function dataMappingBiaya(){
      DB::statement(DB::raw('set @nomorbaris=0'));
      $tarif = Mastermappingbiaya::select([
         DB::raw('@nomorbaris  := @nomorbaris  + 1 AS nomorbaris'),
                 'id',
                 'kelompok',
      ]);
      return DataTables::of($tarif)
          ->addColumn('mapping', function($tarif){
            return '<a href="'.url('mapping-biaya/'.$tarif->id).'" class="btn btn-info btn-flat btn-sm"><i class="fa fa-folder-open"></i></a>';
          })
          ->rawColumns(['mapping'])
          ->make(true);
    }

    public function mappingBiaya(){
      $master_biaya_id = Mastermappingbiaya::all();
      $tarif = Tarif::where('mapping_biaya_id', '=', NULL)->get();
      $kiri = ceil($tarif->count() / 2);
      $dataKiri = Tarif::where('mapping_biaya_id', '=', NULL)->skip(0)->take($kiri)->get();
      $dataKanan = Tarif::where('mapping_biaya_id', '=', NULL)->skip($kiri)->take($kiri)->get();
      return view('mappingbiaya.mappingBiaya', compact('tarif' ,'dataKiri', 'dataKanan', 'master_biaya_id'))->with('no', 1);
    }

    public function viewMappingBiaya($id){
      $master_biaya_id  = Mastermappingbiaya::all();
      $kelompok         = Mastermappingbiaya::find($id)->kelompok;
      $tarif            = Tarif::where('mapping_biaya_id', '=', $id)->get();
      $kiri             = ceil($tarif->count() / 2);
      $dataKiri         = Tarif::where('mapping_biaya_id', '=', $id)->skip(0)->take($kiri)->get();
      $dataKanan        = Tarif::where('mapping_biaya_id', '=', $id)->skip($kiri)->take($kiri)->get();
      return view('mappingbiaya.viewMappingBiaya', compact('tarif' ,'dataKiri', 'dataKanan', 'master_biaya_id', 'kelompok'))->with('no', 1);
    }

    public function simpanMapping(Request $request){
        request()->validate(['mapping_biaya_id' => 'required']);
        $total = $request['total'];
        $mapping_biaya_id = $request['mapping_biaya_id'];
        $master_biaya = Mastermappingbiaya::find($mapping_biaya_id)->kelompok;
        $id = [];
        for ($i=1; $i <= $total ; $i++)
        {
            if(!empty($request['tarif'.$i])) {
                $tarif = Tarif::find($request['tarif'.$i]);
                $tarif->mapping_biaya_id = $mapping_biaya_id;
                $tarif->update();
                array_push($id, $tarif->id);
            }
        }
        $trf = Tarif::whereIn('id', $id)->get();
        Flashy::success($trf->count().' Tarif di berhasil di mapping di kelompok biaya '.$master_biaya);
        if (!empty($request['url'])) {
          return redirect('mapping-biaya/'.$request['url']);
        } else {
          return redirect('mapping-biaya-tarif');
        }
    }

    public function mappingDetail($mastermapping_id=''){
        DB::statement(DB::raw('set @nomorbaris=0'));
		$tarif = Tarif::select([
				 DB::raw('@nomorbaris  := @nomorbaris  + 1 AS nomorbaris'),
                 'id',
				 'nama',
                 'total'
			])->where('mastermapping_id', $mastermapping_id);
        return DataTables::of($tarif)
            ->addColumn('total', function ($tarif)
            {
                return number_format($tarif->total);
            })
            ->make(true);

    }

}
