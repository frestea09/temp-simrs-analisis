<?php

namespace App\Http\Controllers\Conf_rl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Conf_rl\M_config31;
use Modules\Kamar\Entities\Kamar;
use Illuminate\Http\Response;
use MercurySeries\Flashy\Flashy;
use Yajra\DataTables\DataTables;

class Conf31Controller extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = M_config31::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kamar', function ($data) {
                    $kamar = '';
                    foreach ($data->kamar as $key => $value) {
                        $kamar .= $value->nama.'<br>';
                    }
                    return $kamar;
                })
                ->addColumn('edit', function ($data) {
                    return '<a href="'.route('confrl31.edit', $data->id_conf_rl31).'" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>';
                })
                ->rawColumns(['edit', 'kamar'])
                ->make(true);
        }

        return view('sirs.mapping.conf31.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['kamar'] = Kamar::all();
        return view('sirs.mapping.conf31.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate(['kegiatan'=>'required', 'nomer'=>'required', 'kamar_id' => 'required']);
        $rl31 = M_config31::create($data);
        foreach ($request->kamar_id as $key => $val) {
            if (!empty($val)) {
                Kamar::where('id', $val)->update(['conf_rl31_id' => $rl31->id_conf_rl31]);
            }
        }
        Flashy::success('Data Conf RL 3.1 baru berhasil di tambahkan');
        return redirect()->route('confrl31.index');
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
        $data['conf31'] = M_config31::find($id);
        $data['kamar'] = Kamar::all();
        return view('sirs.mapping.conf31.edit', $data);
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
        $data = request()->validate(['kegiatan'=>'required', 'nomer'=>'required', 'kamar_id' => 'required']);
        M_config31::find($id)->update($data);
        Kamar::where('conf_rl31_id', $id)->update(['conf_rl31_id' => null]);
        foreach ($request->kamar_id as $key => $val) {
            if (!empty($val)) {
                Kamar::where('id', $val)->update(['conf_rl31_id' => $id]);
            }
        }
        Flashy::success('Data Conf RL 3.1 berhasil di update');
        return redirect()->route('confrl31.index');
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
