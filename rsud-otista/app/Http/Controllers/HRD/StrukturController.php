<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Pegawai\Entities\Pegawai;
use App\HRD\HrdStruktur;
use Flashy;
use DB;

class StrukturController extends Controller
{
    public function index()
    {
        $data['struktur'] = HrdStruktur::with(['childrenLocation'])->whereNull('parent_id')->get();
        $data['all'] = HrdStruktur::get();
        return view('hrd.struktur.index',compact('data'));
    }

    public function store(Request $request)
    {
        $parent_id = ($request->parent_id == 0) ? null : $request->parent_id;
        $data = $request->all();
        $data['parent_id'] = $parent_id;
        HrdStruktur::create($data);
        Flashy::success('Struktur Berhasil Ditambahkan');
        return redirect('hrd/master/struktur');
    }

    public function update(Request $request, $id)
    {
        $find = HrdStruktur::find($id);
        // $parent_id = ($request->parent_id == 0) ? null : $request->parent_id;
        // dd($request->all());
        $data = [
            "nama" => $request->nama
        ];
        // $data['parent_id'] = $parent_id;
        $find->update($data);
        Flashy::success('Struktur Berhasil Diupdate');
        return redirect('hrd/master/struktur');
    }

    public function destroy(Request $request, $id)
    {
        $find = HrdStruktur::find($id);
        $find->delete();
        Flashy::success('Struktur Berhasil Dihapus');
        return redirect('hrd/master/struktur');
    }

    public function searchPegawai(Request $request)
    {
        $find = Pegawai::where('nama','LIKE','%'.$request->q.'%')->limit(20)->get();
        $res = [];
        foreach ($find as $val){
            $res[] = [
                "id" => $val->id,
                "text" => $val->nama
            ];
        }
        return response()->json($res);
    }

    public function addPegawaiDireksi(Request $request)
    {
        $find = Pegawai::find($request->pegawai_id);
        $data = [
            "struktur_id" => $request->struktur_id
        ];
        $find->update($data);
        Flashy::success('Pegawai Berhasil Ditambahkan');
        return redirect()->back();
    }

    public function getPegawai(Request $request)
    {
        if($request->ajax()){
            $data = Pegawai::where('struktur_id',$request->struktur_id)->get();
            $body = '';
            foreach( $data as $key => $item ){
                $body .= '<tr>
                        <td>'.($key+1).'</td>
                        <td>'.$item->nik.'</td>
                        <td>'.$item->nama.'</td>
                        <td>'.$item->agama.'</td>
                        <td>'.$item->alamat.'</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-flat btn-sm" data-id="'.$item->id.'" id="btn-delete-pegawai">Delete</i></button>  
                        </td>
                        </tr>';
            }
            if( $body == '' ){
                $body = '<tr><td colspan="6" class="text-center">Pegawai Tidak Ditemukan</td></tr>';
            }
            $html = '<table class="table table-bordered" id="data-peg">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Agama</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$body.'
                    </tbody>
                    </table>
                    <script>
                    $(\'#data-peg\').DataTable({
                        \'language\'    : {
                        "url": "/json/pasien.datatable-language.json",
                        },
                        \'paging\'      : true,
                        \'lengthChange\': false,
                        \'searching\'   : true,
                        \'ordering\'    : true,
                        \'info\'        : true,
                        \'autoWidth\'   : false
                    });
                    </script>';
            $res = [
                "status" => true,
                "html" => $html
            ];
            return response()->json($res);
        }
    }

    public function deletePegawai(Request $request)
    {
        if($request->ajax()){
            $find = Pegawai::find($request->id);
            $data = [
                "struktur_id" => null
            ];
            $find->update($data);
            Flashy::success('Jabatan Pegawai Berhasil Dihapus');
            $res = [
                "status" => true,
                "data" => "Jabatan Pegawai Berhasil Dihapus"
            ];
            return response()->json($res);
        }
    }
}
