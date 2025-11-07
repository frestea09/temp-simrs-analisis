<?php

namespace App\Http\Controllers;

use App\Emr;
use App\EmrInapPemeriksaan;
use App\EmrKonsul;
use Illuminate\Http\Request;
use App\MasterPuskesmas;
use App\MasterDokterPerujuk;
use App\ResepNote;
use App\SuratInap;
use DB;
use Flashy;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Poli\Entities\Poli;

class AjaxController extends Controller
{

    public function cekKamar($regID)
    {
        $rawat = \App\Rawatinap::where('registrasi_id', $regID)->with('kamar')->first();

        if ($rawat && $rawat->kamar) {
            return response()->json(['nama_kamar' => $rawat->kamar->nama]);
        } else {
            return response()->json(['nama_kamar' => 'Tidak Ada'], 404);
        }
    }
    public function cekFolio($id, $poli_id)
    {
        $jumlah = cek_folio_counts($id, $poli_id);
        $poli = Poli::find($poli_id);

        return response()->json([
            'jumlah' => $jumlah,
            'poli' => $poli ? $poli->nama : null
        ]);
    }
    public function index(Request $request, $type)
    {
        if ($request->ajax()) {
            if ($type == "perujuk") {
                $data = MasterDokterPerujuk::get();
                $view = view("ajax.index", compact('data', 'type'))->render();

                $res = [
                    "status"    => "success",
                    "html"      => $view
                ];
                return response()->json($res);
            } elseif ($type == "puskesmas") {
                $data = MasterPuskesmas::get();
                $view = view("ajax.index", compact('data', 'type'))->render();

                $res = [
                    "status"    => "success",
                    "html"      => $view
                ];
                return response()->json($res);
            }
        }
    }

    public function saveDokterPerujuk(Request $request)
    {
        MasterDokterPerujuk::updateOrCreate(
            [
                "nama" => $request->nama,
            ],
            [
                "alamat" => $request->alamat
            ]
        );

        $res = [
            "status"    => "success",
            "msg"      => 'Dokter Perujuk Berhasil Ditambah'
        ];
        return response()->json($res);
    }

    public function updateDokterPerujuk(Request $request, $id)
    {
        $find       = MasterDokterPerujuk::find($id);
        $data       = [
            "nama"  => $request->nama,
            "alamat"  => $request->alamat,
        ];
        $find->update($data);

        $res = [
            "status"    => "success",
            "msg"      => 'Dokter Perujuk Berhasil diupdate'
        ];
        return response()->json($res);
    }

    public function updatePuskesmas(Request $request, $id)
    {
        $find       = MasterPuskesmas::find($id);
        $data       = [
            "nama"  => $request->nama,
            "alamat"  => $request->alamat,
        ];
        $find->update($data);

        $res = [
            "status"    => "success",
            "msg"      => 'Puskesmas Berhasil diupdate'
        ];
        return response()->json($res);
    }

    public function savePuskesmas(Request $request)
    {
        MasterPuskesmas::updateOrCreate(
            [
                "nama" => $request->nama,
            ],
            [
                "alamat" => $request->alamat
            ]
        );

        $res = [
            "status"    => "success",
            "msg"      => 'Puskesmas Berhasil Ditambah'
        ];
        return response()->json($res);
    }

    public function deleteDokterPerujuk($id)
    {
        $find       = MasterDokterPerujuk::find($id);
        $find->delete();

        $res = [
            "status"    => "success",
            "msg"      => 'Dokter Perujuk Berhasil Dihapus'
        ];
        return response()->json($res);
    }

    public function deletePuskesmas($id)
    {
        $find       = MasterPuskesmas::find($id);
        $find->delete();

        $res = [
            "status"    => "success",
            "msg"      => 'Puskesmas Berhasil Dihapus'
        ];
        return response()->json($res);
    }

    public function cekCountFolio($id, $poli)
    {
        $count = cek_folio_counts($id, $poli); // function lama kamu
        return response()->json([
            'count' => $count
        ]);
    }
    public function cekStatusBatch(Request $request)
    {
        $items = $request->items; // array of {id, dokter}

        $ids = collect($items)->pluck('id')->toArray();
        $dokterMap = collect($items)->pluck('dokter', 'id');

        $cppts = Emr::whereIn('registrasi_id', $ids)->get();
        $asesments = EmrInapPemeriksaan::whereIn('registrasi_id', $ids)->get();

        $result = [];

        foreach ($items as $row) {
            $id = $row['id'];
            $dokterId = $row['dokter'];

            $cpptDokter = $cppts->where('registrasi_id', $id)->where('user_id', $dokterId)->isNotEmpty();
            $asesmenDokter = $asesments->where('registrasi_id', $id)->where('user_id', $dokterId)->isNotEmpty();
            $asesmenDokter2 = $asesments->where('registrasi_id', $id)->where('userdokter_id', $dokterId)->isNotEmpty();

            $result[$id] = ($cpptDokter || $asesmenDokter || $asesmenDokter2) ? 'sudah' : 'belum';
        }

        return response()->json($result);
    }

    public function cekStatusPerawatBatch(Request $request)
    {
        $items = $request->items; // array of {id, dokter}
        $ids = collect($items)->pluck('id')->toArray();

        $cppts = Emr::whereIn('registrasi_id', $ids)->get();
        $asesments = EmrInapPemeriksaan::whereIn('registrasi_id', $ids)->get();

        $result = [];

        foreach ($items as $row) {
            $id = $row['id'];
            $dokterId = $row['dokter'];

            $cpptPerawat = $cppts->where('registrasi_id', $id)->where('user_id', '!=', $dokterId)->isNotEmpty();
            $asesmenPerawat = $asesments->where('registrasi_id', $id)->isNotEmpty();

            $result[$id] = $cpptPerawat || $asesmenPerawat ? 'sudah' : 'belum';
        }

        return response()->json($result);
    }

    public function cekDischargeBatch(Request $request)
    {
        $items = $request->items; // array of {id, dokter, pasien}
        $result = [];

        foreach ($items as $row) {
            $id = $row['id'];
            $dokterId = $row['dokter'];
            $pasienId = $row['pasien'];

            $hasilDischarge = '-';
            $foundDischarge = false;

            // Cari discharge dari registrasi sekarang
            $planningDokter = \App\Emr::where('registrasi_id', $id)
                ->where('user_id', $dokterId)
                ->orderBy('id', 'DESC')
                ->first();

            if ($planningDokter && $planningDokter->discharge) {
                $discharge = json_decode($planningDokter->discharge, true);
                $planning = $discharge['dischargePlanning'] ?? [];

                foreach ($planning as $plan) {
                    if (!empty($plan['dipilih'])) {
                        $hasilDischarge = $plan['dipilih'];
                        $foundDischarge = true;
                        break;
                    }
                }
            }

            // Kalau belum ketemu, cek CPPT pasien sebelumnya
            if (!$foundDischarge) {
                $cpptPasien = \App\Emr::where('pasien_id', $pasienId)
                    ->where('registrasi_id', '<', $id)
                    ->orderBy('id', 'DESC')
                    ->get();

                foreach ($cpptPasien as $c) {
                    if ($c->discharge) {
                        $discharge = json_decode($c->discharge, true);
                        $planning = $discharge['dischargePlanning'] ?? [];

                        foreach ($planning as $plan) {
                            if (!empty($plan['dipilih'])) {
                                $hasilDischarge = $plan['dipilih'];
                                $foundDischarge = true;
                                break 2;
                            }
                        }
                    }
                }
            }

            $result[$id] = $hasilDischarge;
        }

        return response()->json($result);
    }

    public function cekEmr($registrasi_id)
    {
        $exists = Emr::where('registrasi_id', $registrasi_id)->first();

        return response()->json([
            'exists' => $exists,
        ]);
    }
    
    public function checkCetak($id)
{
    $resepNote = ResepNote::where('registrasi_id', $id)
        ->whereNotNull('nomor')
        ->select('id')
        ->first();

    $konsulJawab = EmrKonsul::where('registrasi_id', $id)
        ->where('type', 'jawab_konsul')
        ->select('id')
        ->orderBy('id', 'DESC')
        ->first();

    if (!$konsulJawab) {
        $konsulJawab = EmrKonsul::where('registrasi_id', $id)
            ->where('type', 'konsul_dokter')
            ->select('id')
            ->orderBy('id', 'DESC')
            ->first();
    }

    return response()->json([
        'resepNoteId'   => $resepNote ? $resepNote->id : null,
        'konsulJawabId' => $konsulJawab ? $konsulJawab->id : null,
    ]);
}

    public function cekKamarBed($id)
{
    $rawat = \App\Rawatinap::with(['kamar', 'bed'])
        ->where('registrasi_id', $id)
        ->first();

    if (!$rawat) {
        return response()->json(['text' => '-']);
    }

    $text = '';
    if ($rawat->kamar) {
        $text .= $rawat->kamar->nama;
    }
    if ($rawat->bed) {
        $text .= ' (' . $rawat->bed->nama . ')';
    }

    return response()->json([
        'text' => $text ?: '-'
    ]);
}

public function updateTaskIdAjax(Request $request)
{
    $request->validate([
        'taskid' => 'required|integer',
        'nomorantrian' => 'required'
    ]);

    @updateTaskId($request->taskid, $request->nomorantrian);

    return response()->json([
        'status' => true,
        'message' => 'TaskId berhasil diupdate'
    ]);
}
public function cekSpriAjax($id)
{
    $count = SuratInap::where('registrasi_id', $id)->count();
    return response()->json(['count' => $count]);
}
public function cekResepAjax($registrasi_id)
{
    $resep = ResepNote::where('registrasi_id', $registrasi_id)
        ->whereNotNull('nomor')
        ->select('id')
        ->first();

    return response()->json([
        'found' => $resep ? true : false,
        'id' => $resep ? $resep->id : null
    ]);
}
public function cekResepBulk(Request $request)
{
    $ids = $request->input('ids', []);

    $resepList = ResepNote::whereIn('registrasi_id', $ids)
        ->whereNotNull('nomor')
        ->select('id', 'registrasi_id')
        ->get()
        ->keyBy('registrasi_id');

    return response()->json($resepList);
}
public function cekSpriBulk(Request $request)
{
    $ids = $request->input('ids', []);

    // Ambil semua SPRI berdasarkan registrasi_id
    $spriList =  SuratInap::whereIn('registrasi_id', $ids)
        ->select('id', 'registrasi_id')
        ->get()
        ->keyBy('registrasi_id');

    return response()->json($spriList);
}

public function cekDiagnosaTerakhir(Request $request)
{
    $pasien_id = $request->pasien_id;
    $diagnosa_input = $request->diagnosa_awal;

    // Ambil registrasi terakhir pasien
    $registrasi_terakhir = Registrasi::where('pasien_id', $pasien_id)
        ->whereNotNull('diagnosa_awal')
        ->orderBy('created_at', 'desc')
        ->first();
    // dd($registrasi_terakhir);
    if ($registrasi_terakhir) {
        $diagnosa_terakhir = $registrasi_terakhir->diagnosa_awal;

        // Bandingkan diagnosa (case insensitive)
        if ($diagnosa_input == $diagnosa_terakhir) {
            return response()->json(['sama' => true]);
        }
    }

    return response()->json(['sama' => false]);
}
}
