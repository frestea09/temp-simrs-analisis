<?php

namespace Modules\Icd10\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Icd10\Entities\Icd10;
use MercurySeries\Flashy\Flashy;
use Yajra\DataTables\DataTables;

class Icd10Controller extends Controller
{
    public function index()
    {
        return view('icd10::datatable');
    }

    public function getICD10()
    {
      $data = Icd10::all();
      return DataTables::of($data)
        ->addColumn('edit', function ($data) {
          return '<a href="'.route('icd10.edit',$data->id) .'" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>';
        })
        ->rawColumns(['edit'])
        ->make(true);
    }

    public function create()
    {
        return view('icd10::create');
    }

    public function store(Request $request)
    {
      $data = request()->validate(['nomor'=>'required','nama'=>'required']);
      Icd10::create($data);
      Flashy::success('Data ICD10 baru berhasil di tambahkan');
      return redirect()->route('icd10');
    }

    public function show()
    {
        return view('icd10::show');
    }

    public function edit($id)
    {
        $icd10 = Icd10::find($id);
        return view('icd10::edit', compact('icd10'));
    }

    public function update(Request $request, $id)
    {
      $data = request()->validate(['nomor'=>'required','nama'=>'required']);
      Icd10::find($id)->update($data);
      Flashy::info('Data ICD10 berhasil di update');
      return redirect()->route('icd10');
    }

    public function getDataIcd10($no='')
    {
      $data = Icd10::all();
      if($no == 1) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih1"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 2) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih2"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 3) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih3"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 4) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih4"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 5) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih5"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 6) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih6"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 7) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih7"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 8) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih8"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 9) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih9"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 10) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih10"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 11) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih11"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 12) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih12"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 13) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih13"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 14) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih14"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 15) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih15"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 16) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih16"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 17) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih17"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 18) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih18"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 19) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih19"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 20) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat pilih20"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      }

    }
}
