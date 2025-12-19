<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\Tarif\Entities\Tarif;
use App\Conf_rl33;
use App\Conf_rl36;
use Excel;

class RekapLaporanController extends Controller
{
    public function rawatDarurat()
    {
        return view('rekap-laporan.rawat-darurat');
    }

    public function gigiMulut()
    {
        $data['mapping'] = Conf_rl33::all();
        return view('rekap-laporan.gigi-mulut', compact('data'));
    }

    public function gigiMulutMapping($id)
    {
        $data['mapping'] = Conf_rl33::find($id);
        return view('rekap-laporan.mapping', compact('data'));
    }

    public function updateRl33( Request $request)
    {
        $find = Conf_rl33::find($request->id);
        $find->update(['nama' => $request->mapping]);
        return redirect('rekap-laporan/gigi-mulut');
    }

    public function toExcel()
    {
        $mapping = Conf_rl33::withCount('tarif')->get();
        Excel::create('Laporan RL 3.3', function ($excel) use ($mapping) {
            // Set the properties
            $excel->setTitle('Laporan RL 3.3')
                ->setCreator('Digihealth')
                ->setCompany('Digihealth')
                ->setDescription('Laporan RL 3.3');
            $excel->sheet('Laporan RL 3.3', function ($sheet) use ($mapping) {
                $row = 1;
                $no = 1;
                $sheet->row($row, [
                    'No',
                    'Jenis Kegiatan',
                    'Jumlah',
                ]);
                foreach ($mapping as $key => $d) {
                    $sheet->row(++$row, [
                        $no++,
                        $d->nama,
                        $d->tarif_count,
                    ]);
                };
                // $sheet->row(++$row, ['', '', '', '', '', 'TOTAL', $tunai, $piutang, '', '', '', '']);
            });

        })->export('xlsx');
    }

    public function pembedahan()
    {
        $data['mapping'] = Conf_rl36::all();
        return view('rekap-laporan.pembedahan', compact('data'));
    }

    public function PembedahanMapping($id)
    {
        $data['mapping'] = Conf_rl36::find($id);
        return view('rekap-laporan.mapping', compact('data'));
    }

    public function updateRl36( Request $request)
    {
        $find = Conf_rl36::find($request->id);
        $find->update(['nama' => $request->mapping]);
        return redirect('rekap-laporan/pembedahan');
    }

    public function toExcelPembedahan()
    {
        $mapping = Conf_rl36::withCount('tarif')->get();
        Excel::create('Laporan RL 3.6', function ($excel) use ($mapping) {
            // Set the properties
            $excel->setTitle('Laporan RL 3.6')
                ->setCreator('Digihealth')
                ->setCompany('Digihealth')
                ->setDescription('Laporan RL 3.6');
            $excel->sheet('Laporan RL 3.6', function ($sheet) use ($mapping) {
                $row = 1;
                $no = 1;
                $sheet->row($row, [
                    'No',
                    'Jenis Kegiatan',
                    'Jumlah',
                ]);
                foreach ($mapping as $key => $d) {
                    $sheet->row(++$row, [
                        $no++,
                        $d->nama,
                        $d->tarif_count,
                    ]);
                };
                // $sheet->row(++$row, ['', '', '', '', '', 'TOTAL', $tunai, $piutang, '', '', '', '']);
            });

        })->export('xlsx');
    }

    public function mappingDetail($type, $id) {
        if( $type == "rl33" ){
            $tarif = Tarif::where('rl33_id', $id)->get();
            return DataTables::of($tarif)
			->addIndexColumn()
			->addColumn('total', function ($tarif) {
				return number_format($tarif->total);
			})
			->addColumn('carabayar', function ($tarif) {
				return baca_carabayar($tarif->carabayar);
			})
			->addColumn('hapus', function ($tarif) {
				return '<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="hapusMapping(' . $tarif->rl33_id . ',' . $tarif->id . ')"><i class="fa fa-remove"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
        }else{
            $tarif = Tarif::where('rl36_id', $id)->get();
            return DataTables::of($tarif)
			->addIndexColumn()
			->addColumn('total', function ($tarif) {
				return number_format($tarif->total);
			})
			->addColumn('carabayar', function ($tarif) {
				return baca_carabayar($tarif->carabayar);
			})
			->addColumn('hapus', function ($tarif) {
				return '<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="hapusMapping(' . $tarif->rl36_id . ',' . $tarif->id . ')"><i class="fa fa-remove"></i></button>';
			})
			->rawColumns(['hapus'])
			->make(true);
        }
	}

    public function dataTarif($type, $rl33_id, $tahuntarif_id = '', $jenis = '') {
        $tarif = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('mastermapping_id', '=', NULL)->get();
        $kiri = ceil($tarif->count() / 2);
        $dataKiri = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('mastermapping_id', '=', NULL)->skip(0)->take($kiri)->get();
        $dataKanan = Tarif::where('tahuntarif_id', $tahuntarif_id)->where('jenis', $jenis)->where('mastermapping_id', '=', NULL)->skip($kiri)->take($kiri)->get();

		return view('rekap-laporan.data-tarif', compact('tarif', 'dataKiri', 'dataKanan', 'rl33_id', 'type'))->with('no', 1);
	}

    public function saveMapping( Request $request)
    {
        if( $request->type == "pembedahan" ){
            $total = $request['total'];
            $rl33_id = $request['rl33_id'];
            $id = [];
            for ($i = 1; $i <= $total; $i++) {
                if (!empty($request['tarif' . $i])) {
                    $tarif = Tarif::find($request['tarif' . $i]);
                    $tarif->rl36_id = $rl33_id;
                    $tarif->update();
                    array_push($id, $tarif->id);
                }
            }
            $trf = Tarif::whereIn('id', $id)->get();
        }else{
            $total = $request['total'];
            $rl33_id = $request['rl33_id'];
            $id = [];
            for ($i = 1; $i <= $total; $i++) {
                if (!empty($request['tarif' . $i])) {
                    $tarif = Tarif::find($request['tarif' . $i]);
                    $tarif->rl33_id = $rl33_id;
                    $tarif->update();
                    array_push($id, $tarif->id);
                }
            }
            $trf = Tarif::whereIn('id', $id)->get();
        }
		return response()->json(['sukses' => true, 'message' => $trf->count() . ' tarif berhasil di mapping']);
    }

    public function hapusMapping($type, $tarif_id) {
        $tarif = Tarif::find($tarif_id);
        if( $type == "rl33" ){
            $id = $tarif->rl33_id;
            $tarif->rl33_id = NULL;
        }else{
            $id = $tarif->rl36_id;
            $tarif->rl36_id = NULL;
        }
		$tarif->update();
        
        return response()->json([
            'status' => true,
            "ref" => $id
        ]);
	}
}
