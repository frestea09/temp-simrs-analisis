<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Icd10\Entities\Icd10;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Poli\Entities\Poli;
use Modules\Registrasi\Entities\Registrasi;
use App\Helpers\CurlAPI;
use Carbon\Carbon;
use App\inhealthSjp;
use Validator;
use Auth;

class SepInhealthController extends Controller
{
    protected $client;

    public function __construct(CurlAPI $client)
    {
        $this->client = $client;
    }

    public function index($reg_id = '') {
        $registrasi_id = !empty(session('reg_id')) ? session('reg_id') : $reg_id;
        // dd($registrasi_id);
		$data['poli'] = Poli::select('nama', 'inhealth')->whereNotNull('inhealth')->get();
		// $data['bpjsprov'] = BpjsProv::select('propinsi', 'kode')->get();
		// $data['bpjskab'] = BpjsKab::pluck('kabupaten', 'kode');
		// $data['bpjskec'] = BpjsKec::pluck('kecamatan', 'kode');
		// $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->select('nama', 'kode_bpjs')->get();
		$data['reg'] = Registrasi::find($registrasi_id);
        $data['poli_inhealth'] = Poli::find($data['reg']->poli_id)->inhealth;
        // dd($data);
		// $data['dokter_bpjs'] = Pegawai::find($data['reg']->dokter_id)->kode_bpjs;
		// if (substr($data['reg']->status_reg, 0, 1) == 'G') {
		// 	return view('sep.form_create_rujukan', $data);
		// } else {
			return view('sep-inhealth.form_create', $data);
		// }

    }
    
    public function EligibilitasPeserta(Request $request)
    {
        $rules = [
            'no_kartu' => 'required',
            'poli'   => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json([
                "status" => false,
                "html" => "<tr class='text-center'><td colspan='6'><b>".$validator->errors()->first()."</b></td></tr>",
                "msg" => $validator->errors()->first()
            ]);
        } 

        $tgl_pelayanan = Carbon::now()->format('Y-m-d');
        $data = [
            "token" => config('app.token_inhealth'),
            "kodeprovider"  => config('app.kodeprovider_inhealth'),
            "nokainhealth"  => $request->no_kartu,
            "tglpelayanan"  => $tgl_pelayanan,
            // "jenispelayanan"  => 1,
            "poli"  => $request->poli 
        ];
        $poli_tujuan = Poli::select('nama')->where('inhealth',$request->poli)->first();
        $res = $this->client->post('EligibilitasPeserta',json_encode($data)); // api
        if( $res['data']['ERRORCODE'] == "00" ){ // jika sukses
            $result = [
                "status" => true,
                "html" => "<tr>
                            <td>".$res['data']['NMPST']."</td>
                            <td>".$res['data']['KODEPRODUK']."-".$res['data']['NAMAPRODUK']."</td>
                            <td>".$res['data']['NAMAPROVIDER']."</td>
                            <td>".$poli_tujuan->nama."</td>
                            <td>".Carbon::parse($tgl_pelayanan)->format('d-m-Y')."</td>
                            <td><button type='button' class='btn btn-success btn-sm' id='pilih-inhealth' data-id='".$res['data']['NOKAPST']."' data-nama='".$res['data']['NMPST']."' data-tgl-pelayanan='".$request->tgl_pelayanan."'>Pilih</button></td>
                            </tr>",
                "msg" => $res['data']['ERRORDESC']
            ];
        }else{ // jika status error
            $result = [
                "status" => false,
                "html" => "<tr class='text-center'><td colspan='6'><b>".$res['data']['ERRORDESC']."</b></td></tr>",
                "msg" => $res['data']['ERRORDESC']
            ];
        }
        return response()->json($result);
    }

    public function SimpanSJP(Request $request)
    {
        // dd($request->all());
        $rules = [
            'tgl_pelayanan' => 'required',
            'jenis_layanan'   => 'required',
            'no_kartu' => 'required',
            'no_rm' => 'required',
            'tgl_rujukan' => 'required',
            'diagnosa_awal' => 'required',
            'poli_inhealth' => 'required',
            'diagnosa_awal' => 'required',
            'kecelakaan' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json([
                "status" => false,
                "msg" => $validator->errors()->first()
            ]);
        } 

        $data = [
            "token" => config('app.token_inhealth'),
            "kodeprovider"  => config('app.kodeprovider_inhealth'),
            "kodeproviderasalrujukan"  => config('app.kodeprovider_inhealth'),
            "tanggalpelayanan"  => $request->tgl_pelayanan,
            "jenispelayanan"  => $request->jenis_layanan,
            "nokainhealth"  => $request->no_kartu,
            "nomormedicalreport"  => $request->no_rm,
            "tanggalasalrujukan"  => $request->tgl_rujukan,
            "kodediagnosautama"  => $request->diagnosa_awal,
            "poli"  => $request->poli_inhealth,
            "username"  => str_replace(' ','_',Auth::user()->name),
            "informasitambahan"  => $request->informasi_tambahan,
            "kecelakaankerja"  => $request->kecelakaan,
        ];
        $res = $this->client->post('SimpanSJP',json_encode($data)); // api
        if( $res['data']['ERRORCODE'] == "00" ){ // jika sukses
            $dtSJP = [
                "reg_id" => $request->registrasi_id,
                "no_sjp" => $res['data']['NOSJP'],
                "tgl_sjp" => Carbon::parse($res['data']['TGLSJP'])->format('Y-m-d'),
                "nama_poli" => $res['data']['NMPOLI'],
                "noka_peserta" => $res['data']['NOKAPESERTA'],
                "plan_desc" => $res['data']['PLANDESC'],
                "kelas" => $res['data']['KELAS'],
                "nomor_rm" => $res['data']['NOMEDICALRECORD'],
                "jenis_kelamin" => $res['data']['JENISKELAMIN'],
                "tgl_lahir" => Carbon::parse($res['data']['TGLLAHIR'])->format('Y-m-d'),
                "tgl_rujukan" => Carbon::parse($res['data']['TGLRUJUKAN'])->format('Y-m-d'),
                "jenis_pelayanan" => $request->jenis_layanan,
            ];
            inhealthSjp::create($dtSJP);
            $result = [
                "status" => true,
                "nosjp" => $res['data']['NOSJP'],
                "tkp" => $request->jenis_layanan,
                "msg" => $res['data']['ERRORDESC']
            ];
        }else{
            $result = [
                "status" => false,
                "msg" => $res['data']['ERRORDESC']
            ];
        }
        return response()->json($result);
    }

    public function CetakSJP(Request $request)
    {
        $data = [
            "token" => config('app.token_inhealth'),
            "kodeprovider"  => config('app.kodeprovider_inhealth'),
            "nosjp"  => $request->nosjp,
            "tkp"  => $request->tkp,
            "tipefile"  => "pdf"
        ];
        $res = $this->client->post('CetakSJP',json_encode($data)); // api
        if( $res['data']['ERRORCODE'] == "00" ){ // jika sukses
            $decoded = base64_decode($res['data']['BYTEDATA']);
            $file = $res['data']['FILENAME'];
            file_put_contents($file, $decoded);

            if (file_exists($file)) {
                // header('Content-Description: File Transfer');
                // header('Content-Type: application/octet-stream');
                // header('Content-Disposition: attachment; filename="'.basename($file).'"');
                // header('Expires: 0');
                // header('Cache-Control: must-revalidate');
                // header('Pragma: public');
                // header('Content-Length: ' . filesize($file));
                // readfile($file);
                // exit;
                $result = [
                    "status" => true,
                    "file" => url($file)
                ];
                return response()->json($result);
            }

        }else{
            $result = [
                "status" => false,
                "msg" => $res['data']['ERRORDESC']
            ];
            return response()->json($result);
        }
    }

    public function simpan_sep(Request $request) {

		$registrasi_id = !empty($request['registrasi_id']) ? $request['registrasi_id'] : session('reg_id');
		$reg = Registrasi::find($registrasi_id);
		$reg->no_sep = $request['no_sep'];
		$reg->tgl_rujukan = $request['tgl_rujukan'];
		$reg->no_rujukan = $request['no_rujukan'];
		$reg->ppk_rujukan = $request['ppk_rujukan'] . '|' . $request['nama_perujuk'];
		$reg->diagnosa_awal = $request['diagnosa_awal'];
		$reg->tgl_sep = $request['tglSep'];
		$reg->poli_bpjs = $request['poli_bpjs'];
		$reg->hakkelas = $request['hak_kelas_inap'];
		$reg->nomorrujukan = $request['no_rujukan'];
		$reg->catatan = $request['catatan_bpjs'];
		$reg->kecelakaan = $request['kecelakaan'];
		$reg->no_jkn = $request['no_bpjs'];
		$reg->update();

		$pasien = \Modules\Pasien\Entities\Pasien::find($reg->pasien_id);
		$pasien->nik = $request['nik'];
		$pasien->nohp = $request['no_tlp'];
		$pasien->no_jkn = $request['no_bpjs'];
		$pasien->update();

		session()->forget('reg_id');
		if (!empty($request['no_sep'])) {
			session(['no_sep' => $request['no_sep']]);
			Flashy::success('Integrasi SEP sukses, No SEP berhasil simpan');
		}

		if (substr($reg->status_reg, 0, 1) == 'G') {
			if (session('status') == 'ubahdpjp') {
				return redirect('/frontoffice/supervisor/ubahdpjp');
			} else {
				return redirect('/frontoffice/rawat-darurat');
			}

		} else {
			if (session('no_loket') == '1') {
				return redirect('antrian/daftarantrian');
			} else {
				return redirect('antrian' . session('no_loket') . '/daftarantrian');
			}
		}

	}
}
