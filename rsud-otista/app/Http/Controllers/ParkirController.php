<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DataTables;
use Auth;

class ParkirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('parkir.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'tarif' => 'required',
            'jml_kendaraan' => 'required'
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
           $pk = new \App\PendapatanParkir();
           $pk->jenis = $request->jenis;
           $pk->tarif = rupiah($request->tarif);
           $pk->jml_kendaraan = rupiah($request->jml_kendaraan);
           $pk->total = rupiah($request->total);
           $pk->user_id = Auth::user()->id;
           $pk->save();
           return response()->json(['sukses' => true]);
        }
    }

    public function dataParkir(){
		$parkir = \App\PendapatanParkir::orderBy('id', 'desc')->get();
		return DataTables::of($parkir)
        ->addIndexColumn()
        ->editColumn('jenis', function($parkir){
            return ($parkir->jenis == 2) ? 'Roda 2' : 'Roda 4 atau lebih';
        })
		->editColumn('tarif', function($parkir){
			return 'Rp. '.number_format($parkir->tarif, 0, ',', '.');
		})
		->editColumn('total', function($parkir){
			return 'Rp. '.number_format($parkir->total, 0, ',', '.');
		})
		->addColumn('aksi', function($parkir){
			return '<a onclick="hapus('.$parkir->id.')" class="btn btn-warning btn-sm btn-flat">BATAL</a>'.
				'<a href="'.url('/parkir/parkir-cetak/'.$parkir->id).'" target="_blank" class="btn btn-danger btn-sm btn-flat">CETAK</a>';
		})
		->rawColumns(['aksi'])
		->make(true);
    }

    public function parkirCetak($id){
		$parkir = \App\PendapatanParkir::find($id);
		return view('parkir.cetakParkir', compact('parkir'));
    }

	public function parkirBatal($id)
	{
		$diklat = \App\PendapatanParkir::find($id);
		$diklat->delete();
		return response()->json(['sukses' => true]);
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
