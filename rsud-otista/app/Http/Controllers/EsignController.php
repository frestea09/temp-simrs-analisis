<?php

namespace App\Http\Controllers;

use App\Edukasi;
use App\EsignLog;
use App\Helpers\FunctionsV2;
use App\Kesadaran;
use App\KondisiAkhirPasien;
use App\KondisiAkhirPasienSS;
use App\LisLog;
use App\Masterobat;
use App\Orderradiologi;
use App\Prognosis;
use App\RecordSatuSehat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Mockery\Recorder;
use Modules\Icd10\Entities\Icd10;
use Modules\Icd9\Entities\Icd9;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Registrasi;

class EsignController extends Controller
{
    public function log(Request $req)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '8000M');

        $data['tga']        = $req->tga ? $req->tga : now()->format('d-m-Y');
        $data['tgb']        = $req->tgb ? $req->tgb : now()->format('d-m-Y');
        $data['status']     = $req->status ? $req->status : 'all';
        $data['type']       = $req->type;
        $tga                = valid_date($data['tga']) . ' 00:00:00';
        $tgb                = valid_date($data['tgb']) . ' 23:59:59';
        $data['type_name']   = EsignLog::distinct()->pluck('type');

        $logs               = EsignLog::whereBetween('created_at', [$tga, $tgb]);
        if ($req->status != 'all' && $req->status != null) {
            $logs->where('status', $req->status);
        }

        if ($req->type != 'all' && $req->type != null) {
            $logs->where('type', $req->type);
        }
        $data['logs']       = $logs->latest()->get();
        return view('esign.log', $data);
    }

    public function userPassphrase(Request $req)
    {
        if ($req->save_passphrase == "true"){
            session(["passphrase" => [
                "save_passphrase" => true,
                "passphrase" => $req->passphrase
            ]]);
        } elseif ($req->save_passphrase == "false") {
            session(["passphrase" => [
                "save_passphrase" => false,
                "passphrase" => null
            ]]);
        }

        return response()->json(true);
    }
}
