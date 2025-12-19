<?php

namespace App\Http\Controllers;

use App\EmrInapPerencanaan;
use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use App\SuratInap;
use PDF;
use Auth;
use Modules\Pegawai\Entities\Pegawai;
use MercurySeries\Flashy\Flashy;
use Modules\Poli\Entities\Poli;
use App\Emr;

class SuratInapController extends Controller
{

    public function spri($id)
    {
        // dd($id);
        $spri = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
            ->join('histori_rawatinap', 'histori_rawatinap.registrasi_id','=','registrasis.id')
            ->join('histori_seps', 'histori_seps.no_sep', '=', 'registrasis.no_sep')
            ->where('registrasis.id', $id)
            ->select('registrasis.dokter_id as dokter_pengirim', 'histori_seps.diagnosa_awal as diagnosa_inap', 'histori_rawatinap.dokter_id as dokter_rawat','registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.kelamin', 'pasiens.tgllahir', 'pasiens.alamat')
            ->first();
        // return $spri; die;
        $pdf = PDF::loadView('spri.spri', compact('spri'));
        return $pdf->stream();
    }
    
   
    public function index($registrasi_id)
    {
        $reg = Registrasi::find($registrasi_id);
		$reg->pasien;
		$umur = hitung_umur($reg->pasien->tgllahir);
		$surat = SuratInap::where('registrasi_id', $registrasi_id)->first();
		$data_surat = $surat ? $surat : [];

		$tanggal = !empty($surat->created_at) ? tanggalPeriode($surat->created_at) : null;
		return response()->json(['reg' => $reg, 'ep' => $data_surat, 'umur' => $umur, 'tanggal' => $tanggal]);
    }
     public function createSpri($registrasi_id){
        $data['reg']            = Registrasi::find($registrasi_id);
		$reg = Registrasi::where('pasien_id',$data['reg']->pasien_id)->get();
		$idregs = [];
		foreach($reg as $r){
			$idregs[] = $r->id;
		}
        $data['surat_inap']     = SuratInap::whereIn('registrasi_id',$idregs)->orderBy('id','DESC')->get();
        $data['diagnosa']   = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'rujukan')->orderBy('id', 'DESC')->first();
        // dd($data['surat_inap']);
        $data['poli']           = Poli::all();
        $data['dokter']         = Pegawai::whereNotNull('kode_bpjs')->get();
        return view('spri.create', $data);
     }

     public function createSpriManual($registrasi_id){
        $data['reg']            = Registrasi::find($registrasi_id);
		$reg = Registrasi::where('pasien_id',$data['reg']->pasien_id)->get();
		$idregs = [];
		foreach($reg as $r){
			$idregs[] = $r->id;
		}
        $dokters = Pegawai::where('kategori_pegawai', 1)->pluck('id');
        $data['surat_inap']     = SuratInap::whereIn('registrasi_id',$idregs)->orderBy('id','DESC')->get();
        $data['diagnosa']   = EmrInapPerencanaan::where('registrasi_id', $registrasi_id)->where('type', 'rujukan')->orderBy('id', 'DESC')->first();
        $data['soap'] = Emr::where('registrasi_id', $registrasi_id)
            ->where('unit', 'inap')
            ->whereIn('dokter_id', $dokters)
            ->first();
        // dd($data['surat_inap']);
        $data['poli']           = Poli::all();
        $data['dokter']         = Pegawai::whereNotNull('kode_bpjs')->get();
        return view('spri.create_manual', $data);
     }

     public function deleteSpri($id)
    {
        try {
            $spri = SuratInap::findOrFail($id);
            $spri->delete();

            return response()->json([
                'success' => true,
                'message' => 'SPRI berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus SPRI: ' . $e->getMessage()
            ]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    function stringDecrypt($key, $string){
            
      
		$encrypt_method = 'AES-256-CBC';

		// hash
		$key_hash = hex2bin(hash('sha256', $key));
  
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
  
		return $output;
	}

	// function lzstring decompress 
	// download libraries lzstring : https://github.com/nullpunkt/lz-string-php
	function decompress($string){
		// dd($string);
		return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);

	}
     
    public function store(Request $request)
    {
        // dd($request->all());
		if ($request['id']) {
			return response()->json(['sukses' => false]);
		} else {
			$ep = new SuratInap();
		}

        

		$ep->registrasi_id = $request['registrasi_id'];
		$ep->dokter_rawat = $request['dokter_rawat'];
        $ep->dokter_pengirim = $request['dokter_pengirim'];
        $ep->jenis_kamar = $request['jenis_kamar'];
        $ep->diagnosa = $request['diagnosa'];
        $ep->keterangan = $request['keterangan'];
        $ep->carabayar = $request['cara_bayar'];  
        $ep->tgl_rencana_kontrol = valid_date($request['tglRencanaKontrol']);
        $ep->no_spri = $request['no_spri'];
        $ep->poli_id = $request['poli_id'];

        if ($ep->save()) {
            
			//$sep = 'No. SEP adalah: '.$sml['response'];
			return response()->json(['sukses' => true, 'data' => $ep]);
		} else {
			//$sep = $sml['metadata']['message'];
			return response()->json(['msg' => 'Gagal Buat SPRI','sukses' => false,'code'=>201]);
		}

		
    }   

    

    public function buat_spri(Request $request)
    {  
        // dd($request->all());
        $ID = config('app.sep_id');
		date_default_timezone_set('UTC');
		$t = time();
		$data = "$ID&$t";
		$secretKey = config('app.sep_key');
		$signature = base64_encode(hash_hmac('sha256', utf8_encode($data), utf8_encode($secretKey), true));

        // SPRI WS
        $noKartu = $request['no_jkn'];
        // @$noKartu = @Registrasi::find($request['registrasi_id'])->pasien->no_jkn;
        // if(!@$noKartu){
        //     $noKartu = $request['no_jkn'];
        // }
		@$poliKontrol = @Registrasi::find($request['registrasi_id'])->poli->bpjs;
        if($request['poli_id']){
            $poliKontrol = $request['poli_id'];
        }
		$tglRencanaKontrol = valid_date($request['tglRencanaKontrol']); 
        // dd($poliKontrol);
        $request = '{
                    "request":    
                        {
                            "noKartu":"' . $noKartu . '",
                            "kodeDokter":"' . Pegawai::where('id',$request['dokter_rawat'])->first()->kode_bpjs. '",
                            "poliKontrol":"' . $poliKontrol . '",
                            "tglRencanaKontrol":"' . $tglRencanaKontrol . '",
                            "user":"' . Auth::user()->name . '"
                        }
                }';
        // dd($request);
        // dd($request);
        $uri = config('app.sep_url_web_service');
        $completeurl = $uri."/RencanaKontrol/InsertSPRI";
        // dd($completeurl);
        $session = curl_init($completeurl);
        $arrheader = array(
            'X-cons-id: ' . $ID,
            'X-timestamp: ' . $t,
            'X-signature: ' . $signature,
            'user_key:'. config('app.user_key'),
            'Content-Type: application/x-www-form-urlencoded',
        );
        curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
		curl_setopt($session, CURLOPT_POSTFIELDS, $request);
		curl_setopt($session, CURLOPT_POST, TRUE);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($session);
        $sml = json_decode($response,true);
        
        if ($sml['metaData']['code'] == 200) {
            $stringEncrypt = $this->stringDecrypt($ID.config('app.sep_key').$t,$sml['response']);
			$sep = json_decode($this->decompress($stringEncrypt),true);
			//$sep = 'No. SEP adalah: '.$sml['response'];
            // dd($sep);
			return response()->json(['sukses' => $sep['noSPRI'], 'cetak' => $sep,'code'=>$sml['metaData']['code']]);
		}else {
            
			//$sep = $sml['metadata']['message'];
			return response()->json(['msg' => $sml['metaData']['message'],'sukses' => false,'code'=>$sml['metaData']['code']]);
		}

		
    }   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $spri = SuratInap::join('registrasis', 'registrasis.id', '=', 'surat_inaps.registrasi_id')
			->join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
			->where('surat_inaps.registrasi_id', $id)
			->select('surat_inaps.no_spri','registrasis.id as registrasi_id', 'registrasis.created_at', 'registrasis.bayar', 'registrasis.poli_id', 'registrasis.dokter_id', 'pasiens.nama', 'pasiens.no_rm', 'pasiens.kelamin', 'pasiens.tgllahir', 'pasiens.alamat', 'surat_inaps.*')
			->get();
        // dd($spri);
		// return compact('spri'); die;
		$cek = SuratInap::where('registrasi_id', $id)->first();
		if ($cek) {
			$pdf = PDF::loadView('spri.cetak_spri', compact('spri'));
			return $pdf->stream();
		} else {
			Flashy::error('Cetak SPRI Gagal');
			return redirect()->back();
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
