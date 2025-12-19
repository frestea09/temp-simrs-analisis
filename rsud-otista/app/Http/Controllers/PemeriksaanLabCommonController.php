<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use MercurySeries\Flashy\Flashy;
use Modules\Registrasi\Entities\Folio;
use Modules\Pegawai\Entities\Pegawai;
use App\Hasillab;
use App\Labsection;
use App\Labkategori;
use App\Laboratorium;
use App\Pasienlangsung;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use App\RincianHasillab;
use Auth;
use DB;
use PDF;
use Modules\Poli\Entities\Poli;

class PemeriksaanLabCommonController extends Controller
{
    public function index()
    {
        $today = Registrasi
            ::join('pasiens', 'pasiens.id', 'registrasis.pasien_id')
            ->leftJoin('pegawais', 'pegawais.id', 'registrasis.dokter_id')
            ->leftJoin('polis', 'polis.id', 'registrasis.poli_id')
            ->leftJoin('carabayars', 'carabayars.id', 'registrasis.bayar')
            ->leftJoin('hasillabs', 'hasillabs.registrasi_id', 'registrasis.id')
            ->with('hasilLab_patalogi')
            ->where('registrasis.created_at', 'LIKE', date('Y-m-d') .'%')
            // ->where('registrasis.pasien_id', '<>', '0')
            ->select('pasiens.nama', 'pasiens.no_rm', 'pegawais.nama as dpjp', 'polis.nama as poli', 'registrasis.created_at', 'carabayars.carabayar', 'registrasis.id', DB::raw('COUNT(*) as hasillab_count') )
            ->groupBy('registrasis.id')
            ->get();
        session()->forget('pj');
        session()->forget('lab_id');
        return view('lab_common.index', compact('today'))->with('no', 1);
    }

    public function index_byTanggal(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '8000M');
        // request()->validate(['tga'=>'required']);
        $today = Registrasi
            ::join('pasiens', 'pasiens.id', 'registrasis.pasien_id')
            ->leftJoin('pegawais', 'pegawais.id', 'registrasis.dokter_id')
            ->leftJoin('polis', 'polis.id', 'registrasis.poli_id')
            ->leftJoin('carabayars', 'carabayars.id', 'registrasis.bayar')
            ->leftJoin('hasillabs', 'hasillabs.registrasi_id', 'registrasis.id')
            ->with('hasilLab_patalogi')
            ->where('pasiens.no_rm',$request->no_rm)
            ->select('pasiens.nama', 'pasiens.no_rm', 'pegawais.nama as dpjp', 'polis.nama as poli', 'registrasis.created_at', 'carabayars.carabayar', 'registrasis.id', DB::raw('COUNT(*) as hasillab_count') )
            ->groupBy('registrasis.id')
            ->orderBy('registrasis.id','DESC')
            ->get();
            
        session()->forget('pj');
        session()->forget('lab_id');
        return view('lab_common.index', compact('today'))->with('no', 1);
    }

    public function create($id='', $labid='')
    {
      
      // dd('A');
      // return $request->all(); die;
        $data['reg'] = Registrasi::find($id);
        $data['pasien'] = Pasien::find($data['reg']->pasien_id);
        $data['tagihan'] = Folio::where('registrasi_id', $data['reg']->id)->where('lunas', 'N')->where('poli_id', 43)->sum('total');
        // $data['section'] = Labsection::all();
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $data['hasillabs'] = Hasillab::where(['registrasi_id' => $id])->whereHas('rincianHasilLab')->get();
        // if(session('lab_id'))
        // {
        //   $data['rincian'] = RincianHasillab::where('hasillab_id', session('lab_id'))->get();
        //   $data['no'] = 1;
        // }
        $data['lab'] = Hasillab::where('id', $labid)->first();
        $data['labsection'] = Labsection::orderby('nama')->get();
        return view('lab_common.create', $data);
    }
    public function createPasienLangsung($id='', $labid='')
    {
      // return $request->all(); die;
        $data['reg'] = Registrasi::find($id);
        $data['pasien'] = Pasienlangsung::where('registrasi_id',$data['reg']->id)->first();
        $data['tagihan'] = Folio::where('registrasi_id', $data['reg']->id)->where('poli_id', 43)->sum('total');
        // $data['section'] = Labsection::all();
        $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->pluck('nama', 'id');
        $data['dokterlab'] = Pegawai::where('kategori_pegawai', 1)->first();
        $data['hasillabs'] = Hasillab::where(['registrasi_id' => $id])->get();

          $data['lab'] = Hasillab::where('id', $labid)->first();
          $data['labsection'] = Labsection::orderby('nama')->get();
          // return $data; die;
        return view('lab_common.create-pasien-langsung', $data);
    }

    public function store(Request $request){
      if ($request['penanggungjawab'] == null) {
        Flashy::success('Pastikan Inputan Tidak Kosong');
        return redirect()->back();
      }
      $jenis = Registrasi::where('id', '=', $request['reg_id'])->first();
      if(substr($jenis->status_reg, 0, 1) == 'J') {
        $no = 'LABRJ';
      } elseif (substr($jenis->status_reg, 0, 1) == 'I') {
        $no = 'LABRI';
      } else {
        $no = 'LABRJ';
      }

      DB::beginTransaction();
        try{
          $lab = new Hasillab();
          $lab->no_lab = $no.'-'.date('Ymd').'-'.$request['reg_id'];
          $lab->registrasi_id = $request['reg_id'];
          $lab->pasien_id = $request['pasien_id'];
          $lab->dokter_id = $request['dokter_id'];
          $lab->penanggungjawab = $request['penanggungjawab'];
          $lab->tgl_pemeriksaan = valid_date($request['tgl_pemeriksaan']);
          $lab->tgl_bahanditerima = date('Y-m-d');
          $lab->jam = $request['jam'];
          $lab->jamkeluar = $request['jamkeluar'];
          $lab->sample = $request['jenissample'];
          $lab->pesan = $request['pesan'];
          $lab->saran = $request['saran'];
          $lab->kesan = $request['kesan'];
          $lab->tgl_hasilselesai = date('Y-m-d', strtotime($request['tanggal_keluar_hasil']));
          $lab->tgl_cetak = date('Y-m-d');
          $lab->user_id = Auth::user()->id;
          $lab->no_sediaan = $request['no_sediaan'];
          $lab->save();


          foreach($request->hasiltext as $key => $hasil){
            if($hasil != null){
              $detail_id = explode('_', $key);
              $rincian = new RincianHasillab();
              $rincian->hasillab_id = $lab->id;
              $rincian->labsection_id = $detail_id[2];
              $rincian->labkategori_id = $detail_id[1];
              $rincian->laboratoria_id = $detail_id[0];
              $rincian->hasil = $hasil;
              $rincian->hasiltext = $request->hasiltext[$key];
              $rincian->user_id = Auth::user()->id;
              $rincian->save();
            }
          }
          DB::commit();
          Flashy::success('Sukses Input data pemeriksaan lab');
          return redirect('pemeriksaanlabCommon/create/'.$request['reg_id'].'/'.$lab->id);
        }catch(Exception $e){
          DB::rollback();
          
          Flashy::danger('Gagal Input data pemeriksaan lab');
          return redirect()->back();
        } 
      
        // session( ['pj'=> $lab->penanggungjawab, 'lab_id'=>$lab->id]);
    }
    public function storeLis(Request $request){
      // dd($request->all());
      $jenis = Registrasi::where('id', $request['reg_id'])->first();
      $reg = $jenis;
      
      if(!$request->poli_id){
        $request->poli_id = $reg->poli_id;
      }
      if(substr($jenis->status_reg, 0, 1) == 'J') {
        $no = 'LABRJ';
        $code = baca_data_poli($request->poli_id)->general_code;
        if(!$code){
          $code = baca_data_poli($jenis->poli_id)->general_code;

        }
        $poli = baca_poli($request->poli_id);
      } elseif (substr($jenis->status_reg, 0, 1) == 'I') {
        $no = 'LABRI';
        $code = $request->ruangan_inap;
        $poli = $request->kelompok;
      } else {
        $no = 'LABRD';
        $code = baca_data_poli($jenis->poli_id)->general_code;
        $poli = baca_poli($request->poli_id);
      }
      

      DB::beginTransaction();
        try{
          $no_order = date('YmdHis');
          // $no_order = 777700;
          $tgllahir = $reg->pasien->nohp ? $reg->pasien->nohp : $reg->pasien->notlp; 
          $js = [
            "demografi"=> [
              "no_rkm_medis"=> $reg->pasien->no_rm,
              "nama_pasien"=> $reg->pasien->nama,
              "tgl_lahir"=> $reg->pasien->tgllahir,
              "jk"=> $reg->pasien->kelamin,
              "alamat"=> $reg->pasien->alamat,
              "no_telp"=> $tgllahir
            ],
            "transaksi"=>[
              "no_order"=> $no_order,
              "tgl_permintaan"=> date('Y-m-d'),
              "jam_permintaan"=> date('H:i:s'),
              "kode_pembayaran"=> baca_data_carabayar($request->cara_bayar_id)->general_code,
              // "kode_pembayaran"=> 'K-0014',
              // "pembayaran"=> 'BPJS',
              "pembayaran"=> baca_carabayar($request->cara_bayar_id),
              "kode_ruangan"=> $code,
              // "kode_ruangan"=> '35',
              "kelas"=> baca_data_poli($request->poli_id)->kelas,
              "ruangan"=> $poli, 
              // "kode_jenis"=> baca_data_poli($request->poli_id)->kelas,
              "kode_jenis"=> cek_kode_jenis_lis($reg->status_reg),
              "jenis"=> cek_jenis_lis($reg->status_reg), 
              "kode_dokter"=> baca_general_dokter($request->dokter_id),
              "dokter"=> baca_dokter($request->dokter_id),
              "note"=> $request->pesan
            ]

          ];
          // dd($js);
          // dd($data);
          // dd(json_encode($js,JSON_PRETTY_PRINT));
          $lab = new Hasillab();
          $lab->no_lab = $no_order;
          $lab->registrasi_id = $request['reg_id'];
          $lab->pasien_id = $request['pasien_id'];
          $lab->dokter_id = $request['dokter_id'];
          $lab->penanggungjawab = $request['penanggungjawab'];
          $lab->tgl_pemeriksaan = valid_date($request['tgl_pemeriksaan']);
          $lab->tgl_bahanditerima = date('Y-m-d');
          $lab->jam = $request['jam'];
          $lab->jamkeluar = $request['jamkeluar'];
          $lab->sample = $request['jenissample'];
          $lab->pesan = $request['pesan'];
          $lab->kesan = $request['kesan'];
          $lab->tgl_hasilselesai = date('Y-m-d');
          $lab->tgl_cetak = date('Y-m-d');
          $lab->user_id = Auth::user()->id;
          

          $test = [];
          if(!$request->hasil){
            Flashy::error('Test wajib diisi');
            return redirect()->back();
          }
          foreach($request->hasil as $key => $hasil){
            
            if($hasil != null){
              $detail_id = explode('_', $key);
              $test[] = [
                  'id' => '',
                  'test_id' => $detail_id[0],
                  'kode_jenis_tes'=> $detail_id[2],
                  'test_name'=> $detail_id[1],
                  'cito'=> $request->cito[$detail_id[0]],
                ];
            }
          }
          // dd($test);
          $js['tes'] = $test;
          // dd($js);
          // $lab->json = json_encode($js,JSON_PRETTY_PRINT);
          $lab->json = compress_json($js);
          // dd(json_encode($js,JSON_PRETTY_PRINT));
          // dd($js);
          $curl_observation = curl_init();

          curl_setopt_array($curl_observation, array(
          CURLOPT_URL => config('app.url_lis') . '/insert_patient',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => json_encode($js,JSON_PRETTY_PRINT),
          CURLOPT_HTTPHEADER => array(
            'x-api-key:  licaapi',
            'Content-Type: application/json'
          ),
          ));
          $response_observasi = curl_exec($curl_observation);
          // if(!isset(json_decode(@$response_observasi)->error)){
          //   Flashy::info('Data Tersimpan, Master Test tidak ada di LIS');
          //   return redirect()->back();
          // }
          // dd($response_observasi);
          // if(!$response_observasi){
          //   Flashy::error('Gagal Simpan Ke LIS');
          //   return redirect()->back();
          // }
          $lab->save();
          DB::commit();
          Flashy::success('Sukses Input data ke LIS');
          return redirect()->back();

          // if(isset(json_decode(@$response_observasi)->error->status_code)){
          //   if(json_decode(@$response_observasi)->error->status_code == '200'){
          //     $lab->save();
          //     DB::commit();
          //     Flashy::success('Sukses Input data ke LIS');
          //     // dd($response_observasi);
          //     return redirect()->back();
          //   }elseif(json_decode(@$response_observasi)->error->status_code == 400){
          //     Flashy::error('Gagal Simpan Ke LIS: '.json_decode(@$response_observasi)->error->message);
          //     return redirect()->back();
          //   }else{
          //     Flashy::error('Gagal Simpan Ke LIS: '.json_decode(@$response_observasi)->error->message);
          //     return redirect()->back();
  
          //   }
          // }else{
          //   Flashy::error('Gagal Simpan Ke LIS: '.json_decode(@$response_observasi)->error->message);
          //   return redirect()->back();
          // }
			    
          
          
        }catch(Exception $e){
          DB::rollback();
          
          Flashy::danger('Gagal Input data pemeriksaan lab');
          return redirect()->back();
        } 
      
        // session( ['pj'=> $lab->penanggungjawab, 'lab_id'=>$lab->id]);
    }

    public function storePasienLangsung(Request $request){
      $jenis = Registrasi::where('id', '=', $request['reg_id'])->first();
      if(substr($jenis->status_reg, 0, 1) == 'J') {
        $no = 'LABRJ';
      } elseif (substr($jenis->status_reg, 0, 1) == 'I') {
        $no = 'LABRI';
      } else {
        $no = 'LABRJ';
      }
      $lab = new Hasillab();
      $lab->no_lab = $no.'-'.date('Ymd').'-'.$request['reg_id'];
      $lab->registrasi_id = $request['reg_id'];
      $lab->pasien_id = $request['pasien_id'];
      $lab->dokter_id = $request['dokter_id'];
      $lab->penanggungjawab = $request['penanggungjawab'];
      $lab->tgl_pemeriksaan = valid_date($request['tgl_pemeriksaan']);
      $lab->tgl_bahanditerima = date('Y-m-d');
      $lab->jam = $request['jam'];
      $lab->sample = $request['jenissample'];
      $lab->tgl_hasilselesai = date('Y-m-d');
      $lab->tgl_cetak = date('Y-m-d');
      $lab->user_id = Auth::user()->id;
      $lab->save();


      foreach($request->hasil as $key => $hasil){
        if($hasil != null){
          $detail_id = explode('_', $key);
          $rincian = new RincianHasillab();
          $rincian->hasillab_id = $lab->id;
          $rincian->labsection_id = $detail_id[2];
          $rincian->labkategori_id = $detail_id[1];
          $rincian->laboratoria_id = $detail_id[0];
          $rincian->hasil = $hasil;
          $rincian->hasiltext = $request->hasiltext[$key];
          $rincian->user_id = Auth::user()->id;
          $rincian->save();
        }
      }
        // session( ['pj'=> $lab->penanggungjawab, 'lab_id'=>$lab->id]);
      return redirect('pemeriksaanlab/create-pasien-langsung/'.$request['reg_id'].'/'.$lab->id);
    }

    public function save_rincian(Request $request)
    {
      /*
      $data = request()->validate([
        'hasillab_id' => 'required',
        'labsection_id' => 'nullable',
        'labkategori_id' => 'nullable',
        'laboratoria_id' => 'nullable',
        'hasil' => 'nullable|numeric',
        'hasiltext' => ''
      ]);

      $rincian = new RincianHasillab();
      $rincian->hasillab_id = $request['hasillab_id'];
      $rincian->labsection_id = $request['labsection_id'];
      $rincian->labkategori_id = $request['labkategori_id'];
      $rincian->laboratoria_id = $request['laboratoria_id'];
      $rincian->hasiltext = $request['hasiltext'];
      $rincian->hasil = $request['hasil'];
      $rincian->user_id = Auth::user()->id;
      $rincian->save();
      return redirect('pemeriksaanlab/create/'.$request['reg_id'].'/'.$request['hasillab_id']);*/
      // var_dump($request->hasil);
      foreach($request->hasil as $key => $hasil){
        if($hasil != null){
          echo $key.' => '. $hasil.'<br/>';
        }
      }
    }

    public function cetak_hasil_lab(Request $request, $registrasi_id, $hasillab_id)
    {
      
      // $data['reg'] = Registrasi::find($registrasi_id);
      // $data['lab'] = Hasillab::where('id', '=', $hasillab_id)->first();
      // $data['rincian'] = RincianHasillab::where('hasillab_id', '=', $data['lab']->id)->get();
      // $data['section'] = RincianHasillab::where('hasillab_id', '=', $data['lab']->id)->distinct()->get(['labsection_id', 'hasillab_id']);
      // $data['kategori'] = RincianHasillab::where('hasillab_id', '=', $data['lab']->id)->distinct()->get(['labkategori_id']);
      // $pdf = PDF::loadView('lab.pdf', $data);
      // return $pdf->stream();

      $data['reg'] = Registrasi::find($registrasi_id);
      $data['hasillab'] = Hasillab::where('id', '=', $hasillab_id)->first();
      $data['hasillabs'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->get();
      $data['rincian'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->get();
      $data['section'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->distinct()->get(['labsection_id', 'hasillab_id']);
      $data['kategori'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->distinct()->get(['labkategori_id']);

      if ($request->cetak_file_tte) {
        $tte = json_decode($data['hasillab']->tte);
        if (!empty($tte)) {
          $base64 = $tte->base64_signed_file;
    
          $pdfContent = base64_decode($base64);
          return Response::make($pdfContent, 200, [
              'Content-Type' => 'application/pdf',
              'Content-Disposition' => 'attachment; filename="Hasil Lab Patalogi-' . $data['hasillab']->no_lab . '.pdf"',
          ]);
        }
      } else {
        $poli = Poli::find(43);
        $data['dokter_id'] = @explode(",", $poli->dokter_id)[0]; // Get first dokter id
        // $html = view('lab_common.pdf-rincian', $data)->render();
        // $html = $this->cleanHTML($html);
        // $pdf = PDF::loadHTML($html);
        $pdf = PDF::loadView('lab_common.pdf-rincian', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
      }

    }
    function cleanHTML($html)
    {
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();
        return $doc->saveHTML();
    }

    public function cetak_hasil_labPasienLangsung($registrasi_id, $hasillab_id)
    {
   
      // ini_set('max_execution_time', 300); // 5 minutes

      // $data['reg'] = Registrasi::find($registrasi_id);
      // $data['lab'] = Hasillab::where('id', '=', $hasillab_id)->first();
      // $data['rincian'] = RincianHasillab::where('hasillab_id', '=', $data['lab']->id)->get();
      // $data['section'] = RincianHasillab::where('hasillab_id', '=', $data['lab']->id)->distinct()->get(['labsection_id', 'hasillab_id']);
      // $data['kategori'] = RincianHasillab::where('hasillab_id', '=', $data['lab']->id)->distinct()->get(['labkategori_id']);
      // $pdf = PDF::loadView('lab.pdf', $data);
      // return $pdf->stream();
      $data['reg'] = Registrasi::find($registrasi_id);
      $data['pasien'] = Pasienlangsung::where('registrasi_id',$registrasi_id)->first();
      $data['hasillab'] = Hasillab::where('id', '=', $hasillab_id)->first();
      $data['hasillabs'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->get();
      $data['rincian'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->get();
      $data['section'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->distinct()->get(['labsection_id', 'hasillab_id']);
      $data['kategori'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->distinct()->get(['labkategori_id']);
      
      // return view('lab_common.pdf-rincian-pasien-langsung', $data);
      $pdf = PDF::loadView('lab.pdf-rincian-pasien-langsung', $data);
      return $pdf->stream();
    }

    public function cetakAllLab($registrasi_id)
    {
      $data['registrasi'] = Registrasi::find($registrasi_id);
      if ($data['registrasi']->pasien_id == 0) {
        $data['registrasi']->pasien = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
      }
      $data['hasillabs'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->get();
      $data['hasillab'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->orderBy('created_at', 'desc')->first();
      // dd($data['hasillab']);
      $poli = Poli::find(43);
      $data['dokter_id'] = @explode(",", $poli->dokter_id)[0]; // Get first dokter id
      $pdf = PDF::loadView('lab.pdfAll', $data);
      return $pdf->stream();
    }

    public function cetakRujukanLab($registrasi_id)
    {
      //dd("Cetak Rujukan");
      $data['registrasi'] = Registrasi::find($registrasi_id);
      if ($data['registrasi']->pasien_id == 0) {
        $data['registrasi']->pasien = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
      }
      $data['hasillabs'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->get();
      $data['hasillab']  = Hasillab::where('registrasi_id', '=', $registrasi_id)->first();
      $pdf = PDF::loadView('lab.pdfRujukan', $data);
      return $pdf->stream();
    }

    public function cetakAllLabvedika($registrasi_id)
    {
      $data['registrasi'] = Registrasi::find($registrasi_id);
      $data['hasillabs'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->get();
      $data['hasillab'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->first();
      $pdf = PDF::loadView('lab.pdfAll-vedika', $data);
      return $pdf->stream();
    }

    public function lihatHasil($registrasi_id)
    {
      $data['registrasi'] = Registrasi::find($registrasi_id);
      $data['hasillabs'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->get();
      $data['hasillab'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->first();
      return view('lab_common.lihat-hasil', $data);
    }

    public function deleteDetail($registrasi_id, $lab_id, $id)
    {
      RincianHasillab::find($id)->delete();
      return redirect('pemeriksaanlabCommon/create/'.$registrasi_id.'/'.$lab_id);
    }
    // ========================================================================
    public function get_kategori($id='')
    {
      $kategori = Labkategori::where('labsection_id', '=', $id)->pluck('nama','id');
      return json_encode($kategori);
    }

    public function get_laboratoria($id='')
    {
      $lab = Laboratorium::where('labkategori_id', $id)->pluck('nama', 'id');
      return json_encode($lab);
    }

    public function hapus($id)
    {
      $pt = RincianHasillab::find($id)->delete();
      return redirect()->back();
    }


    

	
	public function cariPasien()
	{	
		return view('lab_common.cari-pasien');
	}
	public function cariPasienProses(Request $request)
	{
		
		session()->forget(['dokter', 'pelaksana', 'perawat']);


    $rm = $request['no_rm'];
		$nama = $request['nama'];
		$alamat = $request['alamat'];


    if (isset($rm)) {
			$pasien = Pasien::where('no_rm', $rm)->select('id')->first();
		}
		if (isset($nama)) {
			$pasien = Pasien::where('nama', 'LIKE', $nama . '%')->select('id')->first();
		}
		if (isset($alamat)) {
			$pasien = Pasien::where('alamat', 'LIKE', $alamat . '%')->select('id')->first();
		}

		if (empty($pasien)) {
			$today = array();
		} else {
			$today = Registrasi::where('registrasis.pasien_id', $pasien->id)
				->with(['hasilLab_patalogi'])
        ->join('pasiens', 'pasiens.id', 'registrasis.pasien_id')
        ->leftJoin('pegawais', 'pegawais.id', 'registrasis.dokter_id')
        ->leftJoin('polis', 'polis.id', 'registrasis.poli_id')
        ->leftJoin('carabayars', 'carabayars.id', 'registrasis.bayar')
        ->leftJoin('hasillabs', 'hasillabs.registrasi_id', 'registrasis.id')
        ->select('pasiens.nama', 'pasiens.no_rm', 'pegawais.nama as dpjp', 'polis.nama as poli', 'registrasis.created_at', 'carabayars.carabayar', 'registrasis.id', DB::raw('COUNT(*) as hasillab_count') )
        ->groupBy('registrasis.id')
        ->orderBy('registrasis.id','DESC')
        ->get();
		}

		return view('lab_common.cari-pasien', compact('today'))->with('no', 1);

	}

  public function tteHasilLab(Request $request, $id)
  {
    $data['hasillab'] = Hasillab::where('id', '=', $id)->first();
    $data['reg'] = Registrasi::find($data['hasillab']->registrasi_id);
    $data['hasillabs'] = Hasillab::where('registrasi_id', '=', $data['reg']->registrasi_id)->get();
    $data['rincian'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->get();
    $data['section'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->distinct()->get(['labsection_id', 'hasillab_id']);
    $data['kategori'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->distinct()->get(['labkategori_id']);
    $poli = Poli::find(43);
    $data['dokter_id'] = @explode(",", $poli->dokter_id)[0]; // Get first dokter id

    if (tte()) {

        $data['proses_tte'] = true;
        $pdf = PDF::loadView('lab_common.pdf-rincian', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdfContent = $pdf->output();

        // Create temp pdf eresep file
        $filePath = uniqId() . '-hasil-lab-pa.pdf';
        File::put(public_path($filePath), $pdfContent);

        // Generate QR code dengan gambar
        $qrCode = QrCode::format('png')->size(200)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

        // Simpan QR code dalam file
        $qrCodePath = uniqid() . '.png';
        File::put(public_path($qrCodePath), $qrCode);

        $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#', $qrCodePath);

        log_esign($data['reg']->id, $tte->response, "hasil-lab-pa", $tte->httpStatusCode);

        $resp = json_decode($tte->response);

        if ($tte->httpStatusCode == 200) {
            $data['hasillab']->tte = $tte->response;
            $data['hasillab']->save();
            Flashy::success('Berhasil melakukan proses TTE dokumen !');
            return redirect()->back();
        } elseif ($tte->httpStatusCode == 400) {
            if (isset($resp->error)) {
                Flashy::error($resp->error);
                return redirect()->back();
            }
        } elseif ($tte->httpStatusCode == 500) {
            Flashy::error($tte->response);
            return redirect()->back();
        }
        Flashy::error('Gagal melakukan proses TTE dokumen !');
        return redirect()->back();

    } else {
        $data['tte_nonaktif'] = true;
        $pdf = PDF::loadView('lab_common.pdf-rincian', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdfContent = $pdf->output();
        $data['hasillab']->tte = json_encode((object) [
            "base64_signed_file" => base64_encode($pdfContent),
        ]);
        $data['hasillab']->update();
        Flashy::success('Berhasil menandatangani dokumen !');
        return redirect()->back();
    }
  }
}
