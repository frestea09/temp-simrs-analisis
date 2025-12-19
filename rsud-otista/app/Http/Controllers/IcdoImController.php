<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Icd9Im;
use App\IcdOIm;
use Flashy;
use Yajra\DataTables\DataTables;
use Excel;
use Validator;

class IcdoImController extends Controller
{
    public function index(){
        // $icdoim = icdoIm::all();

        return view('icdo-im.index')->with('no', 1);
    }

    public function create(){
        $icdo = icdOIm::pluck('nama', 'id');

        return view('icdo-im.create', compact('icdo'));
    }

    public function getData()
	{
		$data = icdoIm::orderBy('id', 'asc');

		return DataTables::of($data)
			->make(true);
	}
     


    public function import(Request $request) {
        ini_set('max_execution_time', 0); //0=NOLIMIT
        request()->validate(['excel' => 'required']);
        $excel = $request->file('excel');
        $excels = Excel::selectSheetsByIndex(0)->load($excel, function ($reader) {
            // options jika ada
        })->get();

        // aturan minimal (kolom CODE dan DESCRIPTION harus ada)
        $rowRules = [
            'code'        => 'required',
            'description' => 'required',
        ];

        $importedIDs = [];
        
        foreach ($excels as $row) {
            
            $data = [
                'code'        => $row['code'] ?? null,
                'code2'       => $row['code2'] ?? null,
                'description' => $row['description'] ?? null,
                'system'      => $row['system'] ?? null,
                'validcode'   => isset($row['validcode']) ? (int)$row['validcode'] : null,
                'accpdx'      => $row['accpdx'] ?? null,
                'asterisk'    => isset($row['asterisk']) ? (int)$row['asterisk'] : null,
                'im'          => isset($row['im']) ? (int)$row['im'] : null,
            ];

            // $validator = Validator::make($data, $rowRules);
            // if ($validator->fails()) {
            //     continue;
            // }
            
            if($request->type == 'icdo'){
                $exist = IcdOIm::where('code', $data['code'])
                                ->where('description', $data['description'])
                                ->first();
                 
                if (!$exist) {
                    $new = IcdOIm::create($data);
                    $importedIDs[] = $new->id;
                }
            }elseif($request->type == 'icd10'){
                $exist = icd10Im::where('code', $data['code'])
                                ->where('description', $data['description'])
                                ->first();
                 
                if (!$exist) {
                    $new = icd10Im::create($data);
                    $importedIDs[] = $new->id;
                }

            }else{
                $exist = Icd9Im::where('code', $data['code'])
                                ->where('description', $data['description'])
                                ->first();
                 
                if (!$exist) {
                    $new = Icd9Im::create($data);
                    $importedIDs[] = $new->id;
                }
            }
            // // cek apakah sudah ada berdasarkan code + description
        }
        // dd($importedIDs);
        // $imported = icdoIm::whereIn('id', $importedIDs)->get();
        // if ($imported->count() == 0) {
        //     Flashy::info('Tidak ada data icdo yang diimport');
        // } else {
            Flashy::success(' Data ICD berhasil diimport ke Database ');
        // }

        return redirect('/kontrolpanel/medis');
    }

    public function store(Request $request){
        request()->validate([
            'icdo' => 'required',
            'nama_icdo_im' => 'required',
        ]);

        foreach($request->icdo as $icdo){
            $icdoim = new icdoIm();
            $icdoim->nama_icdo_im = $request->nama_icdo_im;
            $icdoim->icdo_id = $icdo;
            $icdoim->save();
        }

        Flashy::success('Data Berhasil Ditambahkan.');
        return redirect('icdo-im');
    }

    public function show(){
        return redirect('icdo-im');
    }

    public function edit($id){
        $data['icdoim'] = icdoIm::find($id);
        $data['icdo'] = icdOIm::pluck('nama', 'id');
        
        return view('icdo-im.edit', $data);
    }

    public function update(Request $request, $id){
        request()->validate([
            'icdo' => 'required',
            'nama_icdo_im' => 'required',
        ]);

        $icdoim = icdoIm::find($id);
        $icdoim->nama_icdo_im = $request->nama_icdo_im;
        $icdoim->icdo_id = $request->icdo;
        $icdoim->update();

        Flashy::info('Data Berhasil Diperbarui');
        return redirect('icdo-im');
    }

    public function destroy($id){
        icdoIm::findOrFail($id)->delete();

        Flashy::info('Data Berhasil Dihapus');
        return redirect('icdo-im');
    }
}
