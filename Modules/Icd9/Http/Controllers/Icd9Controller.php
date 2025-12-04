<?php

namespace Modules\Icd9\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Icd9\Entities\Icd9;
use MercurySeries\Flashy\Flashy;
use Yajra\DataTables\DataTables;
use DB;

class Icd9Controller extends Controller
{
    public function index()
    {
        return view('icd9::datatable');
    }

    public function getICD9()
    {
      $data = Icd9::all();
      return DataTables::of($data)
             ->addColumn('edit', function ($data) {
                return '<a href="'.route('icd9.edit',$data->id).'" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>';
             })
             ->rawColumns(['edit'])
             ->make(true);
    }

    public function create()
    {
        return view('icd9::create');
    }

    public function store(Request $request)
    {
      $data = request()->validate(['nomor'=>'required','nama'=>'required']);
      Icd9::create($data);
      Flashy::success('Data ICD9 baru berhasil di tambahkan');
      return redirect()->route('icd9');
    }

    public function show()
    {
        return view('icd9::show');
    }

    public function edit($id)
    {
        $icd9 = Icd9::find($id);
        return view('icd9::edit', compact('icd9'));
    }

    public function update(Request $request, $id)
    {
      $data = request()->validate(['nomor'=>'required','nama'=>'required']);
      Icd9::find($id)->update($data);
      Flashy::info('Data ICD9 berhasil di update');
      return redirect()->route('icd9');
    }

    public function destroy()
    {
    }

    public function getDataIcd9($no)
    {
      $data = Icd9::all();
      if($no == 1) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add1"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 2) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add2"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 3) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add3"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 4) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add4"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 5) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add5"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 6) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add6"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 7) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add7"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 8) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add8"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 9) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add9"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 10) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add10"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 11) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add11"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 12) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add12"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 13) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add13"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 14) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add14"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 15) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add15"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 16) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add16"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 17) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add17"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 18) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add18"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 19) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add19"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      } elseif ($no == 20) {
        return DataTables::of($data)
              ->addColumn('add', function ($data) {
                return ' <a href="#" data-nomor="'.$data->nomor.'" class="btn btn-sm btn-success btn-flat add20"><i class="fa fa-check"></i></a> ';
              })
              ->rawColumns(['add'])
              ->make(true);
      }


    }


}
