<?php

namespace App\Http\Controllers\PPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PPI\Ppi;
use DataTables;
use Validator;
use Auth;
use DB;
use App\Rawatinap;
use Modules\Kelas\Entities\Kelas;


class PpiController extends Controller
{
    public function index(Request $request)
    {
        // // $master = \App\PPI\MasterPpi::all();
        // // $pasien = \Modules\Pasien\Entities\Pasien::all();
        // if ($request->ajax()) {
        //     $ppi = \App\PPI\Ppi::latest();
        //     return DataTables::of($ppi)
        //         ->addIndexColumn()
        //         ->addColumn('aksi', function ($ppi) {
        //             // <button type="button" onclick="edit(\'' . $ppi->id . '\')" class="btn btn-sm btn-success btn-flat" title="Edit"><i class="fa fa-edit"></i></button>
        //             return '
        //             <button type="button" onclick="hapus(\'' . $ppi->id . '\')" class="btn btn-sm btn-warning btn-flat" title="Hapus"><i class="fa fa-eraser"></i></button>';

        //         })
        //         ->addColumn('pasien', function ($ppi) {
        //             return !empty(\Modules\Pasien\Entities\Pasien::where('id', $ppi->pasien_id)->first()->nama) ? \Modules\Pasien\Entities\Pasien::where('id', $ppi->pasien_id)->first()->nama : '';

        //         })
        //         ->addColumn('ppi', function ($ppi) {
        //             return !empty(\App\PPI\MasterPpi::where('id', $ppi->tindakan_id)->first()->nama) ? \App\PPI\MasterPpi::where('id', $ppi->tindakan_id)->first()->nama : '';

        //         })
        //         ->rawColumns(['aksi','pasien','ppi'])
        //         ->make(true);
                
        //     // return $ppi; die;
        // }

        if (!empty($kelas_id) && !empty($kamar_id)) {
			$data['inap'] = Rawatinap::where('kelas_id', $kelas_id)->where('kamar_id', $kamar_id)->get();
		} else {
			if (Auth::user()->kelompokkelas_id != 10) {
				$data['inap'] = DB::table('rawatinaps')
					->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
					->where('rawatinaps.kelompokkelas_id', Auth::user()->kelompokkelas_id)
					// ->where('rawatinaps.created_at', 'LIKE', date('Y-m-d') . '%')
					->where('registrasis.status_reg', 'I2')
					->select('rawatinaps.*', 'registrasis.status_reg')->get();
			} else {
				$data['inap'] = DB::table('rawatinaps')
					->join('registrasis', 'rawatinaps.registrasi_id', '=', 'registrasis.id')
					// ->where('rawatinaps.created_at', 'LIKE', date('Y-m-d') . '%')
					->where('registrasis.status_reg', 'I2')
					->select('rawatinaps.*', 'registrasis.status_reg')->get();
			}
		}
		$data['status_reg']	= 'I2';
		$data['kelas'] = Kelas::where('nama', '<>', '-')->pluck('nama', 'id');

        return view('ppi.index', $data)->with('no', 1);
        // return view('ppi.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cek = Validator::make($request->all(), [
            'tindakan_id' => ['required', 'string', 'max:255'],
            'jumlah_tindakan' => ['required', 'string', 'max:255'],
            'pasien_id' => ['required', 'string', 'max:255'],
        ],[
            'tindakan_id.required' => 'Nama Tindakan Wajib Diisi !',
            'jumlah_tindakan.required' => 'Jumlah Tindakan Wajib Diisi !',
            'pasien_id.required' => 'Jumlah Tindakan Wajib Diisi !',
        ]);

        if ($cek->fails()) {
            return response()->json(['sukses' => false, 'error' => $cek->errors()]);
        } else {
            $ppi = new \App\PPI\Ppi();
            $ppi->tindakan_id       = $request['tindakan_id'];
            $ppi->pasien_id         = $request['pasien_id'];
            $ppi->jumlah_tindakan   = $request['jumlah_tindakan'];
            $ppi->user_id   = Auth::user()->id;
            $ppi->save();

            return response()->json(['sukses' => true]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $ppi = \App\PPI\Ppi::find($id);
		$ppi->delete();
		return response()->json(['sukses' => true]);
    }

    public function getMasterPasien(Request $request) {
      $term = trim($request->q);

      if (empty($term)) {
        return \Response::json([]);
      }

      $tags = \Modules\Pasien\Entities\Pasien::where('nama', 'like', '%' . $term . '%')->orWhere('no_rm', 'like', '%' . $term . '%')->limit(5)->get();

      $formatted_tags = [];

      foreach ($tags as $tag) {
        $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama . ' | ' . $tag->no_rm];
      }

      return \Response::json($formatted_tags);
    }

    //laporan
    public function lap_ppi()
    {
        $data['tga']    = now()->format('d-m-Y');
        $data['tgb']    = now()->format('d-m-Y');

        $data['ppis'] = Ppi::
            leftjoin('master_ppis', 'ppis.tindakan_id', '=', 'master_ppis.id')
            ->leftjoin('pasiens', 'pasiens.id', '=', 'ppis.pasien_id')
            ->where('ppis.created_at', 'LIKE', date('Y-m-d') . '%')
            ->select('ppis.*', 'master_ppis.nama', 'pasiens.no_rm', 'pasiens.nama')
            ->get();
        return view('ppi.lap_ppi', $data)->with('no', 1);
    }

    public function lap_ppi_byTanggal(Request $request)
    {
        request()->validate(['tgl_awal' => 'required', 'tgl_akhir' => 'required'],[ 'tgl_awal.required' => 'Harap Diisi, Jagan Dilewati!', 'tgl_akhir.required' => 'Harap Diisi, Jagan Dilewati!' ]);
        $data['tga']    = $request['tgl_awal'];
        $data['tgb']    = $request['tgl_akhir'];

        $awal  = valid_date($request['tgl_awal']);
        $akhir = valid_date($request['tgl_akhir']);
        $data['ppis'] = Ppi::
            leftjoin('master_ppis', 'ppis.tindakan_id', '=', 'master_ppis.id')
            ->leftjoin('pasiens', 'pasiens.id', '=', 'ppis.pasien_id')
            ->whereBetween('ppis.created_at', [date('' . $awal . ' 00:00:00'), date('' . $akhir . ' 23:59:00')])
            ->select('ppis.*', 'master_ppis.nama', 'pasiens.no_rm', 'pasiens.nama')
            ->get();

        if ($request['excel']) {
            return redirect()->back();
            Excel::create('Laporan Barang ', function ($excel) use ($datareg) {
                // Set the properties
                $excel->setTitle('Laporan Barang')
                    ->setCreator('Digihealth')
                    ->setCompany('Digihealth')
                    ->setDescription('Laporan Barang');
                $excel->sheet('Laporan Barang', function ($sheet) use ($datareg) {
                    $row = 1;
                    $no = 1;
                    $sheet->row($row, [
                        'No',
                        'kode',
                        'Nama Barang',
                        'Jenis',
                        'harga',
                        'Stok',
                        'Min Stok',
                        'Masuk',
                    ]);
                    foreach ($datareg as $key => $d) {
                        $kategori = Kategori::find($d->kategori_id);
                        $sheet->row(++$row, [
                            $no++,
                            $d->kode,
                            $d->nama,
                            $kategori->kategori,
                            $d->harga,
                            $d->stok,
                            $d->min_stok,
                            $d->created_at,
                        ]);
                    }
                });
            })->export('xlsx');
        }else{
            return view('ppi.lap_ppi', $data)->with('no', 1);
        }
    }
}
