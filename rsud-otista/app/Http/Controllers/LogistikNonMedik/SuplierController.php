<?php

namespace App\Http\Controllers\LogistikNonMedik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Validator;
use App\LogistikNonMedik\LogistikNonMedikSuplier;

class SuplierController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $satuan = LogistikNonMedikSuplier::latest();
            return DataTables::of($satuan)
                ->addIndexColumn()
                ->addColumn('aksi', function ($satuan) {
                    return '<button type="button" onclick="edit(\'' . $satuan->id . '\')" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        // return $satuan; die;
        return view('logistik.logistiknonmedik.supplierNonmedik');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'kode' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_supliers,kode'],
            'no_spk' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_supliers,no_spk'],
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
        ], [
            'kode.required' => 'Kode Wajib Diisi !',
            'no_spk.required' => 'Kode Gudang Wajib Diisi !',
            'nama.required' => 'Nama Wajib Diisi !',
            'alamat.required' => 'Alamat Wajib Diisi !',
            'telepon.required' => 'Telepon Wajib Diisi !',
            'contact.required' => 'Kontak Wajib Diisi !',
            'kode.unique' => 'Kode Sudah Ada !',
            'no_spk.unique' => 'NO SPK Sudah Ada !',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $suplier = new LogistikNonMedikSuplier();
            $suplier->kode  = $request['kode'];
            $suplier->no_spk       = $request['no_spk'];
            $suplier->nama              = $request['nama'];
            $suplier->alamat     = $request['alamat'];
            $suplier->jenis_kelamin         = $request['jenis_kelamin'];
            $suplier->telepon            = $request['telepon'];
            $suplier->contact            = $request['contact'];
            $suplier->save();

            return response()->json(['sukses' => true]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $suplier = LogistikNonMedikSuplier::find($id);
        return response()->json(['suplier' => $suplier]);
    }

    public function update(Request $request, $id)
    {
        $cek = Validator::make($request->all(), [
            'kode' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_supliers,kode,'.$id],
            'no_spk' => ['required', 'string', 'max:255', 'unique:logistik_non_medik_supliers,no_spk,'.$id],
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
        ], [
            'kode.required' => 'Kode Wajib Diisi !',
            'no_spk.required' => 'Kode Gudang Wajib Diisi !',
            'nama.required' => 'Nama Wajib Diisi !',
            'alamat.required' => 'Alamat Wajib Diisi !',
            'telepon.required' => 'Telepon Wajib Diisi !',
            'contact.required' => 'Kontak Wajib Diisi !',
            'kode.unique' => 'Kode Sudah Ada !',
            'no_spk.unique' => 'NO SPK Sudah Ada !',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $suplier = LogistikNonMedikSuplier::find($id);
            $suplier->kode  = $request['kode'];
            $suplier->no_spk       = $request['no_spk'];
            $suplier->nama              = $request['nama'];
            $suplier->alamat     = $request['alamat'];
            $suplier->jenis_kelamin         = $request['jenis_kelamin'];
            $suplier->telepon            = $request['telepon'];
            $suplier->contact            = $request['contact'];
            $suplier->update();

            return response()->json(['sukses' => true]);
        }
    }

    public function destroy($id)
    {
        //
    }

    public function getSupplier()
    {
        $supplier = LogistikNonMedikSuplier::all();
        return response()->json($supplier);
    }
}
