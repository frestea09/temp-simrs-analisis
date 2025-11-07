<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Icd10\Entities\Icd10;
use App\Icd10Im;
use App\Icd10Inacbg;
use App\Icd9Im;
use App\Icd9Inacbg;
use App\IcdOIm;
use Flashy;
use Yajra\DataTables\DataTables;
use Excel;
use Validator;

class Icd10ImController extends Controller
{
    public function index(){
        // $icd10im = Icd10Im::all();

        return view('icd10-im.index')->with('no', 1);
    }

    public function create(){
        $icd10 = Icd10::pluck('nama', 'id');

        return view('icd10-im.create', compact('icd10'));
    }

    public function getData()
	{
		$data = Icd10Im::orderBy('id', 'asc');

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
                'code'        => @$row['code'] ?? null,
                'code2'       => @$row['code2'] ?? null,
                'description' => @$row['description'] ?? null,
                'system'      => @$row['system'] ?? null,
                'validcode'   => @isset($row['validcode']) ? (int)$row['validcode'] : null,
                'accpdx'      => @$row['accpdx'] ?? null,
                'asterisk'    => @isset($row['asterisk']) ? (int)$row['asterisk'] : null,
                'im'          => @isset($row['im']) ? (int)$row['im'] : null,
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
                $exist = Icd10Im::where('code', $data['code'])
                                ->where('description', $data['description'])
                                ->first();
                 
                if (!$exist) {
                    $new = Icd10Im::create($data);
                    $importedIDs[] = $new->id;
                }

            }elseif($request->type == 'icd9'){
                $exist = Icd9Im::where('code', $data['code'])
                                ->where('description', $data['description'])
                                ->first();
                 
                if (!$exist) {
                    $new = Icd9Im::create($data);
                    $importedIDs[] = $new->id;
                }
            }elseif($request->type == 'icd10_inacbg'){
                $exist = Icd10Inacbg::where('code', $data['code'])
                                ->where('description', $data['description'])
                                ->first();
                 
                if (!$exist) {
                    $new = Icd10Inacbg::create($data);
                    $importedIDs[] = $new->id;
                }
            }elseif($request->type == 'icd9_inacbg'){
                $exist = Icd9Inacbg::where('code', $data['code'])
                                ->where('description', $data['description'])
                                ->first();
                 
                if (!$exist) {
                    $new = Icd9Inacbg::create($data);
                    $importedIDs[] = $new->id;
                }
            }
            // // cek apakah sudah ada berdasarkan code + description
        }
        // dd($importedIDs);
        // $imported = Icd10Im::whereIn('id', $importedIDs)->get();
        // if ($imported->count() == 0) {
        //     Flashy::info('Tidak ada data ICD10 yang diimport');
        // } else {
            Flashy::success(' Data ICD berhasil diimport ke Database ');
        // }

        return redirect('/kontrolpanel/medis');
    }

    public function store(Request $request){
        request()->validate([
            'icd10' => 'required',
            'nama_icd10_im' => 'required',
        ]);

        foreach($request->icd10 as $icd10){
            $icd10im = new Icd10Im();
            $icd10im->nama_icd10_im = $request->nama_icd10_im;
            $icd10im->icd10_id = $icd10;
            $icd10im->save();
        }

        Flashy::success('Data Berhasil Ditambahkan.');
        return redirect('icd10-im');
    }

    public function show(){
        return redirect('icd10-im');
    }

    public function edit($id){
        $data['icd10im'] = Icd10Im::find($id);
        $data['icd10'] = Icd10::pluck('nama', 'id');
        
        return view('icd10-im.edit', $data);
    }

    public function update(Request $request, $id){
        request()->validate([
            'icd10' => 'required',
            'nama_icd10_im' => 'required',
        ]);

        $icd10im = Icd10Im::find($id);
        $icd10im->nama_icd10_im = $request->nama_icd10_im;
        $icd10im->icd10_id = $request->icd10;
        $icd10im->update();

        Flashy::info('Data Berhasil Diperbarui');
        return redirect('icd10-im');
    }

    public function destroy($id){
        Icd10Im::findOrFail($id)->delete();

        Flashy::info('Data Berhasil Dihapus');
        return redirect('icd10-im');
    }
}
