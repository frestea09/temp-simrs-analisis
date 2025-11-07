<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Registrasi\Entities\Registrasi;
use Modules\Pasien\Entities\Pasien;
use MercurySeries\Flashy\Flashy;
use Modules\Registrasi\Entities\Folio;
use Modules\Pegawai\Entities\Pegawai;
use Modules\Tarif\Entities\Tarif;
use App\Hasillab;
use App\Labsection;
use App\Labkategori;
use App\Laboratorium;
use App\AntrianLaboratorium;
use App\Pasienlangsung;
use App\RincianHasillab;
use App\FolioMulti;
use App\Orderlab;
use App\ServiceNotif;
use App\LicaResult;
use Auth;
use DB;
use Illuminate\Support\Facades\File;
use PDF;
use Illuminate\Support\Facades\Response;
use Modules\Poli\Entities\Poli;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\HistoriOrderLab;

class PemeriksaanLabController extends Controller
{
  public function teregistrasi() {
		ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '-1');
		session()->forget(['dokter', 'pelaksana', 'perawat']);
		// $data['registrasi'] = Orderlab::with('hasillab', 'folios')
		// 	->with(['hasillab', 'registrasi', 'registrasi.pasien', 'registrasi.dokter_umum', 'registrasi.poli', 'registrasi.bayars'])
		// 	->where('poli_id', '!=', 43)
		// 	->where('created_at', 'LIKE', date('Y-m-d') . '%')
		// 	->orderBy('id','DESC')
		// 	->get();
		$data['registrasi'] = [];
		return view('laboratorium.registered', $data)->with('no', 1);
	}
  public function index()
  {
    // $today = Registrasi::where('registrasis.created_at', 'LIKE', date('Y-m-d' . '%'))
    //   ->where('registrasis.pasien_id', '<>', '0')
    //   ->leftJoin('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')
    //   ->leftJoin('pegawais', 'pegawais.id', '=', 'registrasis.dokter_id')
    //   ->leftJoin('polis', 'polis.id', '=', 'registrasis.poli_id')
    //   ->leftJoin('carabayars', 'carabayars.id', '=', 'registrasis.bayar')
    //   ->leftJoin('hasillabs', 'hasillabs.registrasi_id', '=', 'registrasis.id')
    //   ->groupBy('registrasis.id')
    //   ->orderBy('registrasis.id', 'DESC')
    //   ->select('registrasis.id as registrasi_id', 'registrasis.reg_id', 'registrasis.created_at', 'pasiens.id as pasien_id', 'pasiens.nama', 'pasiens.no_rm', 'pegawais.nama as nama_dokter', 'polis.nama as nama_poli', 'carabayars.carabayar', DB::raw('COUNT(hasillabs.id) as hasillab_count'))
    //   ->get();
    // $reg_id_arr = $today->pluck('registrasi_id')->toArray();
    // $hasillabs  = Hasillab::whereIn('registrasi_id', $reg_id_arr)->get(['no_lab', 'registrasi_id']);

    $dokter = Pegawai::where('kategori_pegawai', 1)->get();
    $dokterLab = Pegawai::where('kategori_pegawai', 2)->get();
    $dokter_id = "";
    $dokterlab_id = "";
    $today = Orderlab::with(['hasillab.pasien', 'registrasi', 'folios' => function ($query) {
            $query->whereNotNull('dokter_pelaksana');
        }])
        ->where('created_at', 'LIKE', date('Y-m-d' . '%'))
        ->where('poli_id', '!=', 43)
        ->orderBy('id', 'DESC')
        ->get();
    session()->forget('pj');
    session()->forget('lab_id');
    return view('lab.index', compact('today', 'dokter', 'dokter_id', 'dokter', 'dokterlab_id'))->with('no', 1);
  }

  public function index_byTanggal(Request $request)
  {
    $dokter = Pegawai::where('kategori_pegawai', 1)->get();
    $dokterLab = Pegawai::where('kategori_pegawai', 2)->get();
    $dokter_id = $request->dokter_id;
    $dokterlab_id = $request->dokterlab_id;

    ini_set('max_execution_time', 0);
    ini_set('memory_limit', '8000M');

    request()->validate(['tga' => 'required']);
    $today = Orderlab::with(['hasillab.pasien', 'registrasi', 'folios'])
        ->leftJoin('registrasis', 'registrasis.id', '=', 'order_lab.registrasi_id')
        ->whereBetween('order_lab.created_at', [
            valid_date($request['tga']) . ' 00:00:00',
            valid_date($request['tgb']) . ' 23:59:59'
        ])
        ->where('order_lab.poli_id', '!=', 43)
        ->orderBy('order_lab.id', 'DESC')
        ->select('order_lab.*');

    if ($request->dokter_id) {
      $today = $today->where('registrasis.dokter_id', $request->dokter_id);
    }
    if ($request->dokterlab_id) {
      $today = $today->whereHas('folios', function ($query) use ($request) {
          $query->where('dokter_pelaksana', $request->dokterlab_id);
      });
    }
    if ($request->tte == 'Y') {
      $today = $today->whereHas('hasillab', function ($query) {
        $query->whereNotNull('tte');
      });
    }
    if ($request->tte == 'N') {
      $today = $today->whereHas('hasillab', function ($query) {
        $query->whereNull('tte');
      });
    }

    $today = $today->get();

    session()->forget('pj');
    session()->forget('lab_id');
    return view('lab.index', compact('today', 'dokter', 'dokter_id', 'dokterlab_id'))->with('no', 1);
  }

  public function create($id = '', $labid = '')
  {
    //   return $request->all(); die;
    $data['reg'] = Registrasi::find($id);
    $data['pasien'] = Pasien::find($data['reg']->pasien_id);
    $data['tagihan'] = Folio::where('registrasi_id', $data['reg']->id)->where('lunas', 'N')->sum('total');
    // $data['section'] = Labsection::all();
    // dd($dokter_ids);
    $data['dokter'] = Pegawai::where('kategori_pegawai', 1)->where('poli_id', 6)->pluck('nama', 'id');
    $data['hasillabs'] = Hasillab::where(['registrasi_id' => $id])->get();
    // if(session('lab_id'))
    // {
    //   $data['rincian'] = RincianHasillab::where('hasillab_id', session('lab_id'))->get();
    //   $data['no'] = 1;
    // }
    $data['lab'] = Hasillab::where('id', $labid)->first();
    $data['labsection'] = Labsection::orderby('nama')->get();
    return view('lab.create', $data);
  }
  public function createPasienLangsung($id = '', $labid = '')
  {
    // return $request->all(); die;
    $data['reg'] = Registrasi::find($id);
    $data['pasien'] = Pasienlangsung::where('registrasi_id', $data['reg']->id)->first();
    $data['tagihan'] = Folio::where('registrasi_id', $data['reg']->id)->where('lunas', 'N')->sum('total');
    // $data['section'] = Labsection::all();
    $dokter_id = explode(',', Poli::find(25)->dokter_id);
    $data['dokter'] = Pegawai::whereIn('id', $dokter_id)->pluck('nama', 'id');

    $data['dokterlab'] = Pegawai::where('kategori_pegawai', 1)->first();
    $data['hasillabs'] = Hasillab::where(['registrasi_id' => $id])->get();

    $data['lab'] = Hasillab::where('id', $labid)->first();
    $data['labsection'] = Labsection::orderby('nama')->get();
    // return $data; die;
    return view('lab.create-pasien-langsung', $data);
  }

  public function store(Request $request)
  {
    if ($request['penanggungjawab'] == null) {
      Flashy::success('Pastikan Inputan Tidak Kosong');
      return redirect()->back();
    }
    $jenis = Registrasi::where('id', '=', $request['reg_id'])->first();
    if (substr($jenis->status_reg, 0, 1) == 'J') {
      $no = 'LABRJ';
    } elseif (substr($jenis->status_reg, 0, 1) == 'I') {
      $no = 'LABRI';
    } else {
      $no = 'LABRJ';
    }
    DB::beginTransaction();
    try {
      $lab = new Hasillab();
      $lab->no_lab = $no . '-' . date('Ymd') . '-' . $request['reg_id'];
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
      $lab->save();


      foreach ($request->hasil as $key => $hasil) {
        if ($hasil != null) {
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
      return redirect('pemeriksaanlab/create/' . $request['reg_id'] . '/' . $lab->id);
    } catch (Exception $e) {
      DB::rollback();

      Flashy::danger('Gagal Input data pemeriksaan lab');
      return redirect()->back();
    }

    // session( ['pj'=> $lab->penanggungjawab, 'lab_id'=>$lab->id]);
  }
  public function storeNoneLis(Request $request)
  {
    $jenis = Registrasi::where('id', $request['reg_id'])->first();
    $reg = $jenis;
    $no_order = date('YmdHis');


    if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
      $pelaksana_tipe = 'TG';
    } else {
      $pelaksana_tipe = 'TA';
    }

    $lab = new Orderlab();
    $lab->jenis = $pelaksana_tipe;
    $lab->poli_id = 25;
    $lab->pemeriksaan = 'Order Lab';
    $lab->registrasi_id = $request['reg_id'];
    $lab->user_id = Auth::user()->id;
    $lab->save();

    $hasil = new Hasillab();
    $hasil->no_lab = $no_order;
    $hasil->order_lab_id = $lab->id;
    $hasil->registrasi_id = $reg->id;
    $hasil->pasien_id = $reg->pasien->id;
    $hasil->dokter_id = $reg->dokter_id;
    $hasil->penanggungjawab = $request['penanggungjawab'];
    $hasil->tgl_pemeriksaan = valid_date($request['tgl_pemeriksaan']);
    $hasil->tgl_bahanditerima = date('Y-m-d');
    $hasil->jam = $request['jam'];
    $hasil->jamkeluar = $request['jamkeluar'];
    //$hasil->sample = $request['jenissample'];
    $hasil->tgl_hasilselesai = date('Y-m-d');
    $hasil->tgl_cetak = date('Y-m-d');
    $hasil->user_id = Auth::user()->id;
    $hasil->save();


    if (!empty($request['tgl_pemeriksaan'])) {
      $created_at = valid_date($request['tgl_pemeriksaan']) . ' ' . date('H:i:s');
    }

    DB::beginTransaction();
    try {
      if (!$request->hasil) {
        Flashy::error('Test wajib diisi');
        return redirect()->back();
      }
      foreach ($request->hasil as $key => $hasil) {
        if ($hasil != null) {
          // dd($key);
          $detail_id = explode('_', $key);
          // dd($detail_id[0]);
          $tarif = Tarif::where('id', $detail_id[0])->first();

          $folio = new FolioMulti();
          $folio->registrasi_id = $request['reg_id'];
          $folio->poli_id = 25;
          $folio->verif_kasa_user  = 'tarif_new';
          $folio->lunas = 'N';
          $folio->namatarif = $tarif ? $tarif->nama : $detail_id[1];
          $folio->tarif_id = $tarif ? $tarif->id : null;
          $folio->cara_bayar_id = $reg->bayar;
          $folio->jenis = $tarif ? $tarif->jenis : 'TA';
          $folio->poli_tipe = 'L';
          $folio->total = $tarif->total;
          $folio->order_lab_id = $lab->id;
          $folio->jenis_pasien = $request['jenis'];
          $folio->harus_bayar = $request['jumlah'];
          $folio->pasien_id = $request['pasien_id'];
          $folio->dokter_id = $request['penanggungjawab'];
          $folio->user_id = Auth::user()->id;
          $folio->mapping_biaya_id = $tarif->mapping_biaya_id;
          $folio->dpjp = $request['dokter_id'];
          $folio->dokter_pelaksana = $request['penanggungjawab'];
          $folio->dokter_lab = $request['penanggungjawab'];
          $folio->penanggung_jawab = $request['penanggungjawab'];
          $folio->cyto = $request['cito'][$detail_id[0]];
          $folio->catatan = $request['keterangan'][$detail_id[0]];
          $folio->pelaksana_tipe = $pelaksana_tipe;
          $folio->created_at = $created_at;
          $folio->save();
        }
        DB::commit();
      }
      Flashy::success('Sukses Input Order Lab');
      return redirect()->back();
    } catch (Exception $e) {
      DB::rollback();
      Flashy::danger('Gagal Input Order Lab');
      return redirect()->back();
    }
  }
  public function storeNoneLisNew(Request $request)
  {
    $jenis = Registrasi::where('id', $request['reg_id'])->first();
    $reg = $jenis;
    $no_order = date('YmdHis');


    if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
      $pelaksana_tipe = 'TG';
    } else {
      $pelaksana_tipe = 'TA';
    }

    // $lab = new Orderlab();
    // $lab->jenis = $pelaksana_tipe;
    // $lab->poli_id = 25;
    // $lab->pemeriksaan = 'Order Lab';
    // $lab->registrasi_id = $request['reg_id'];
    // $lab->user_id = Auth::user()->id;
    // $lab->save();

    //  $hasil = new Hasillab();
    //  $hasil->no_lab = $no_order;
    //  $hasil->order_lab_id = $lab->id;
    //  $hasil->registrasi_id = $reg->id;
    //  $hasil->pasien_id = $reg->pasien->id;
    //  $hasil->dokter_id = $reg->dokter_id;
    //  $hasil->penanggungjawab = $request['penanggungjawab'];
    //  $hasil->tgl_pemeriksaan = valid_date($request['tgl_pemeriksaan']);
    //  $hasil->tgl_bahanditerima = date('Y-m-d');
    //  $hasil->jam = $request['jam'];
    //  $hasil->jamkeluar = $request['jamkeluar'];
    //$hasil->sample = $request['jenissample'];
    //  $hasil->tgl_hasilselesai = date('Y-m-d');
    //  $hasil->tgl_cetak = date('Y-m-d');
    //  $hasil->user_id = Auth::user()->id;
    //  $hasil->save();


    if (!empty($request['tgl_pemeriksaan'])) {
      $created_at = valid_date($request['tgl_pemeriksaan']) . ' ' . date('H:i:s');
    }

    DB::beginTransaction();
    try {
      if (!$request->hasil) {
        Flashy::error('Test wajib diisi');
        return redirect()->back();
      }
      $catatan_order_lab = "";
      $tarif_id = [];
      foreach ($request->hasil as $key => $hasil) {
        if ($hasil != null) {
          // dd($key);
          $detail_id = explode('_', $key);
          // $cito = @$request['cito'][@$detail_id[0]] ? 'Cito' : 'Non Cito';
          $cito = @$request['cito'][@$detail_id[0]] ? 'Eksekutif' : 'Non Eksekutif';

          $keterangan = @$request['keterangan'][@$detail_id[0]] ?? 'Tidak ada keterangan';

          if ($catatan_order_lab == "") {
            $catatan_order_lab = $detail_id[1] . ' (' . $cito . ') ' . '- ' . $keterangan;
          } else {
            $catatan_order_lab = $catatan_order_lab . ', ' . $detail_id[1] . ' (' . $cito . ') ' . '- ' . $keterangan;
          }
          // dd($detail_id[0]);
          $tarif = Tarif::where('id', $detail_id[0])->first();

          $tarif_id[] = [
            "tarif_id" => $tarif->id,
            "is_done" => 0,
            "cito" => @$request['cito'][@$detail_id[0]],
          ];

          $reg->waktu_order_lab = now();
          $reg->is_order_lab = true;
          $reg->dokter_order_lab = Auth::user()->pegawai->id;
          $reg->catatan_order_lab = $catatan_order_lab;
          
          // $cyto = 0;
          // if($request['cito'][$tarif->id]){
          //   if($reg->poli->kelompok == 'ESO'){ // Jika Poli Eksekutif
          //     $cyto = ($tarif->total * 30) / 100;
          //   }else{
          //     $cyto = $tarif->total / 2;
          //   }
          // }

          // $folio = new FolioMulti();
          // $folio->registrasi_id = $request['reg_id'];
          // $folio->poli_id = 25;
          // $folio->lunas = 'N';
          // $folio->verif_kasa_user  = 'tarif_new';
          // $folio->namatarif = $tarif ? $tarif->nama : $detail_id[1];
          // $folio->tarif_id = $tarif ? $tarif->id : null;
          // $folio->cara_bayar_id = $reg->bayar;
          // $folio->jenis = $tarif ? $tarif->jenis : 'TA';
          // $folio->poli_tipe = 'L';
          // $folio->harus_bayar = $request['jumlah'];
          // $folio->total = $tarif->total + $cyto;
          // $folio->jenis_pasien = $request['jenis'];
          // $folio->pasien_id = $request['pasien_id'];
          // $folio->dokter_id = $request['penanggungjawab'];
          // $folio->user_id = Auth::user()->id;
          // $folio->mapping_biaya_id = $tarif->mapping_biaya_id;
          // $folio->dpjp = $request['dokter_id'];
          // $folio->dokter_pelaksana = $request['penanggungjawab'];
          // $folio->dokter_lab = $request['penanggungjawab'];
          // $folio->penanggung_jawab = $request['penanggungjawab'];
          // $folio->cyto = $request['cito'][$detail_id[0]];
          // $folio->catatan = $request['keterangan'][$detail_id[0]];
          // $folio->pelaksana_tipe = $pelaksana_tipe;
          // $folio->created_at = $created_at;
          // $folio->save();
        }
        $reg->update();
        DB::commit();
      }

      // Inser histori order lab
      $histori = new HistoriOrderLab();
      $histori->registrasi_id = $request['reg_id'];
      $histori->unit = $request['unit'];
      $histori->catatan = $catatan_order_lab;
      $histori->user_id = Auth::user()->id;
      $histori->tarif_id = json_encode($tarif_id);
      $histori->save();

      //Update Baru
      $dateNow = date('Y-m-d');
      $cekAntrianRegistrasi = AntrianLaboratorium::where('registrasi_id', $reg->id)->whereDate('tanggal', $dateNow)->first();

      if(!$cekAntrianRegistrasi){
        $cekAntrian = AntrianLaboratorium::whereDate('tanggal', $dateNow)->max('nomor');

        if ($cekAntrian !== null) {
            $nomorurut = $cekAntrian + 1;
        } else {
            $nomorurut = '001';
        }

        $nomorAntrian = $nomorurut;

        $antrianLab = new AntrianLaboratorium();
        $antrianLab->registrasi_id = $reg->id;
        $antrianLab->nomor = $nomorAntrian;
        $antrianLab->tanggal = $dateNow;
        $antrianLab->save();
      }
      // Untuk notifikasi
      $notif  = ServiceNotif::where('registrasi_id', $reg->id)->where('service', 'laboratorium')->first();
      if($notif  == null){
          $notif  = new ServiceNotif();
          $notif->registrasi_id   = $reg->id;
          $notif->service         = 'laboratorium';
      }
      $notif->is_muted        = 'N';
      $notif->is_done         = 'N';
      $notif->updated_at      = now(); //jangan dihapus
      $notif->save();

      Flashy::success('Sukses Input Order Lab');
      return redirect()->back();
    } catch (Exception $e) {
      DB::rollback();
      Flashy::danger('Gagal Input Order Lab');
      return redirect()->back();
    }
  }


  public function saveOrderPA(Request $request)
  {
    $jenis = Registrasi::where('id', $request['reg_id'])->first();
    $reg = $jenis;
    $no_order = date('YmdHis');
    if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
      $pelaksana_tipe = 'TG';
    } else {
      $pelaksana_tipe = 'TA';
    }

    if (!collect($request->keterangan)->filter()->count()) {
      Flashy::error('Minimal satu keterangan klinis harus diisi!');
      return redirect()->back();
    }

    $lab = new Orderlab();
    $lab->jenis = $pelaksana_tipe;
    $lab->poli_id = 43;
    $lab->pemeriksaan = 'Order Lab';
    $lab->diagnosa = $request->diagnosa;
    $lab->registrasi_id = $request['reg_id'];
    $lab->user_id = Auth::user()->id;
    $lab->save();

    $hasil = new Hasillab();
    $hasil->no_lab = $no_order;
    $hasil->order_lab_id = $lab->id;
    $hasil->registrasi_id = $reg->id;
    $hasil->pasien_id = $reg->pasien->id;
    $hasil->dokter_id = $reg->dokter_id;
    $hasil->penanggungjawab = $request['penanggungjawab'];
    $hasil->tgl_pemeriksaan = valid_date($request['tgl_pemeriksaan']);
    $hasil->tgl_bahanditerima = date('Y-m-d');
    $hasil->jam = $request['jam'];
    $hasil->jamkeluar = $request['jamkeluar'];
    //$hasil->sample = $request['jenissample'];
    $hasil->tgl_hasilselesai = date('Y-m-d');
    $hasil->tgl_cetak = date('Y-m-d');
    $hasil->user_id = Auth::user()->id;
    $hasil->save();

    if (substr($reg->status_reg, 0, 1) == 'G' || $reg->status_reg == 'I1') {
      $pelaksana_tipe = 'TG';
    } else {
      $pelaksana_tipe = 'TA';
    }

    if (!empty($request['tgl_pemeriksaan'])) {
      $created_at = valid_date($request['tgl_pemeriksaan']) . ' ' . date('H:i:s');
    }

    DB::beginTransaction();
    try {
      if (!$request->hasil) {
        Flashy::error('Test wajib diisi');
        return redirect()->back();
      }
      foreach ($request->hasil as $key => $hasil) {
        if ($hasil != null) {
          $detail_id = explode('_', $key);
          $tarif = Tarif::where('id', $detail_id[0])->first();

          $cyto = 0;
          if($request['cito'][$tarif->id]){
            if($reg->poli->kelompok == 'ESO'){ // Jika Poli Eksekutif
              $cyto = ($tarif->total * 30) / 100;
            }else{
              $cyto = $tarif->total / 2;
            }
          }

          $folio = new FolioMulti();
          $folio->registrasi_id = $request['reg_id'];
          $folio->poli_id = 43;
          $folio->lunas = 'N';
          $folio->verif_kasa_user  = 'tarif_new';
          $folio->namatarif = $tarif->nama;
          $folio->tarif_id = $tarif ? $tarif->id : null;
          $folio->cara_bayar_id = $reg->bayar;
          $folio->jenis = $tarif ? $tarif->jenis : 'TA';
          $folio->poli_tipe = 'L';
          $folio->order_lab_id = $lab->id;
          $folio->harus_bayar = $request['jumlah'];
          $folio->total = $tarif->total + $cyto;
          $folio->jenis_pasien = $request['jenis'];
          $folio->pasien_id = $request['pasien_id'];
          $folio->dokter_id = $request['penanggungjawab'];
          $folio->user_id = Auth::user()->id;
          $folio->mapping_biaya_id = $tarif->mapping_biaya_id;
          $folio->dpjp = $request['dokter_id'];
          $folio->dokter_pelaksana = $request['penanggungjawab'];
          $folio->dokter_lab = $request['penanggungjawab'];
          $folio->penanggung_jawab = $request['penanggungjawab'];
          $folio->cyto = $request['cito'][$tarif->id];
          $folio->diagnosa = $request['keterangan'][$tarif->id];
          $folio->pelaksana_tipe = $pelaksana_tipe;
          $folio->created_at = $created_at;
          $folio->save();
        }
        // dd("S");
      }
      DB::commit();
      Flashy::success('Sukses Input Order Lab Patalogi Anatomi');
      return redirect()->back();
    } catch (Exception $e) {
      DB::rollback();
      Flashy::danger('Gagal Input Order Lab');
      return redirect()->back();
    }
  }







  public function storeLis(Request $request)
  {
    // dd($request->all());
    $jenis = Registrasi::where('id', $request['reg_id'])->first();
    $reg = $jenis;

    if (!$request->poli_id) {
      $request->poli_id = $reg->poli_id;
    }
    if (substr($jenis->status_reg, 0, 1) == 'J') {
      $no = 'LABRJ';
      $code = baca_data_poli($request->poli_id)->general_code;
      if (!$code) {
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
    try {
      $no_order = date('YmdHis');
      // $no_order = 777700;
      $tgllahir = $reg->pasien->nohp ? $reg->pasien->nohp : $reg->pasien->notlp;
      $js = [
        "demografi" => [
          "no_rkm_medis" => $reg->pasien->no_rm,
          "nama_pasien" => $reg->pasien->nama,
          "tgl_lahir" => $reg->pasien->tgllahir,
          "jk" => $reg->pasien->kelamin,
          "alamat" => $reg->pasien->alamat,
          "no_telp" => $tgllahir
        ],
        "transaksi" => [
          "no_order" => $no_order,
          "tgl_permintaan" => date('Y-m-d'),
          "jam_permintaan" => date('H:i:s'),
          "kode_pembayaran" => baca_data_carabayar($request->cara_bayar_id)->general_code,
          // "kode_pembayaran"=> 'K-0014',
          // "pembayaran"=> 'BPJS',
          "pembayaran" => baca_carabayar($request->cara_bayar_id),
          "kode_ruangan" => $code,
          // "kode_ruangan"=> '35',
          "kelas" => baca_data_poli($request->poli_id)->kelas,
          "ruangan" => $poli,
          // "kode_jenis"=> baca_data_poli($request->poli_id)->kelas,
          "kode_jenis" => cek_kode_jenis_lis($reg->status_reg),
          "jenis" => cek_jenis_lis($reg->status_reg),
          "kode_dokter" => baca_general_dokter($request->dokter_id),
          "dokter" => baca_dokter($request->dokter_id),
          "note" => $request->pesan
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
      if (!$request->hasil) {
        Flashy::error('Test wajib diisi');
        return redirect()->back();
      }
      foreach ($request->hasil as $key => $hasil) {

        if ($hasil != null) {
          $detail_id = explode('_', $key);
          $test[] = [
            'id' => '',
            'test_id' => $detail_id[0],
            'kode_jenis_tes' => $detail_id[2],
            'test_name' => $detail_id[1],
            'cito' => $request->cito[$detail_id[0]],
          ];
        }
      }
      // dd($test);
      $js['tes'] = $test;
      // dd($js);
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
        CURLOPT_POSTFIELDS => json_encode($js, JSON_PRETTY_PRINT),
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



    } catch (Exception $e) {
      DB::rollback();

      Flashy::danger('Gagal Input data pemeriksaan lab');
      return redirect()->back();
    }

    // session( ['pj'=> $lab->penanggungjawab, 'lab_id'=>$lab->id]);
  }

  public function storePasienLangsung(Request $request)
  {
    $jenis = Registrasi::where('id', '=', $request['reg_id'])->first();
    if (substr($jenis->status_reg, 0, 1) == 'J') {
      $no = 'LABRJ';
    } elseif (substr($jenis->status_reg, 0, 1) == 'I') {
      $no = 'LABRI';
    } else {
      $no = 'LABRJ';
    }
    $lab = new Hasillab();
    $lab->no_lab = $no . '-' . date('Ymd') . '-' . $request['reg_id'];
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
    $lab->pesan = $request['pesan'];
    $lab->saran = $request['saran'];
    $lab->kesan = $request['kesan'];
    $lab->user_id = Auth::user()->id;
    $lab->no_sediaan = $request['no_sediaan'];
    $lab->jamkeluar = $request['jamkeluar'];
    $lab->tgl_hasilselesai = date('Y-m-d', strtotime($request['tanggal_keluar_hasil']));
    $lab->save();


    foreach ($request->hasil as $key => $hasil) {
      if ($hasil != null) {
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
    return redirect('pemeriksaanlab/create-pasien-langsung/' . $request['reg_id'] . '/' . $lab->id);
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
    foreach ($request->hasil as $key => $hasil) {
      if ($hasil != null) {
        echo $key . ' => ' . $hasil . '<br/>';
      }
    }
  }

  public function cetak_hasil_lab($registrasi_id, $hasillab_id)
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
    $data['rincian'] = RincianHasillab::where('hasillab_id', '=', $hasillab_id)->get();
    $data['section'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->distinct()->get(['labsection_id', 'hasillab_id']);
    $data['kategori'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->distinct()->get(['labkategori_id']);
    $pdf = PDF::loadView('lab.pdf-rincian', $data);
    return $pdf->stream();
  }
  public static function getLisResult($no_lab)
  {
    $licaResult = LicaResult::where('no_lab', $no_lab)->first();
    $hasil = '';
    $level_keys = array();

    if ($licaResult) {
      $hasil = json_decode($licaResult->json);

      foreach ($hasil as $k => $sub_array) {
        $this_level = @$sub_array->group_name ?? @$sub_array->group_test;
        $level_keys[$this_level][$k] = $sub_array;
      }

      $data['response'] = (object) ["no_ref" => $no_lab, "tgl_kirim" => $licaResult->tgl_pemeriksaan];

    } else {
      Flashy::error('Hasil dari LIS belum muncul, coba beberapa saat lagi');  
      return redirect()->back();

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "172.168.1.97/lica-soreang/public/api/get_result/" . $no_lab, // your preferred link
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 30000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          // Set Here Your Requesred Headers
          'x-api-key: licaapi',
        ),
      ));
      $response = curl_exec($curl);
      if (!isset(json_decode($response)->hasil)) {
        Flashy::error('Hasil dari LIS belum muncul, coba beberapa saat lagi');
        return redirect()->back();
      }
      
      $err = curl_error($curl);
  
      curl_close($curl);
      $data['response'] = '';
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        $data['response'] = json_decode($response);
        $hasil = $data['response']->hasil;
      }

      foreach ($hasil as $k => $sub_array) {
        $this_level = $sub_array->group_test;
        $level_keys[$this_level][$k] = $sub_array;
      }
    }

    $hasillabs = $level_keys;
    return $hasillabs;
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
    $data['pasien'] = Pasienlangsung::where('registrasi_id', $registrasi_id)->first();
    $data['hasillab'] = Hasillab::where('id', '=', $hasillab_id)->first();
    $data['hasillabs'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->get();
    $data['rincian'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->get();
    $data['section'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->distinct()->get(['labsection_id', 'hasillab_id']);
    $data['kategori'] = RincianHasillab::where('hasillab_id', '=', $data['hasillab']->id)->distinct()->get(['labkategori_id']);

    // return view('lab.pdf-rincian-pasien-langsung', $data);
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
    $pdf = PDF::loadView('lab.pdfAll', $data);
    return $pdf->stream();
  }

  public function tteCetakAllLabLis($registrasi_id, Request $request)
  {
    if (empty($request->passphrase)) {
      return response()->json(['sukses' => false, 'message' => "Anda belum memasukkan Passphrase"]);
    }

    // Buat dokumen sementara
    $data['hasilLab'] = cek_hasil_lis($registrasi_id);
    foreach ($data['hasilLab'] as $hlab) {
      $resp = $this->hitungPemeriksaan($hlab->no_lab);
      $hlab->total_pemeriksaan = @$resp->total_pemeriksaan;
      $hlab->jenis_pemeriksaan = @$resp->jenis_pemeriksaan;
    }

    $data['reg'] = Registrasi::find($registrasi_id);
    $data['lab'] = Hasillab::where('registrasi_id', $registrasi_id)->first();
    $data['proses_tte'] = true;
    $pdf = PDF::loadView('lab.cetak_all_lis_pdf', $data);
    $pdfContent = $pdf->output();

    $filePath = uniqId() . 'hasil_lab.pdf';
    File::put(public_path($filePath), $pdfContent);

    // Generate QR code dengan gambar
    $qrCode = QrCode::format('png')->size(300)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(Auth::user()->pegawai->nama . ', ' . date('d-m-Y H:i:s'));

    // Simpan QR code dalam file
    $qrCodePath = uniqid() . '.png';
    File::put(public_path($qrCodePath), $qrCode);

    // Proses TTE
    $tte = tte_visible_koordinat($filePath, $request->nik, $request->passphrase, '#!', $qrCodePath);

    log_esign($data['reg']->id, $tte->response, "hasil-lab-all-sesi", $tte->httpStatusCode);

    $resp = json_decode($tte->response);

    if ($tte->httpStatusCode == 200) {
      $data['reg']->tte_hasillab_lis = convertTTE("dokumen_tte", @json_decode($tte->response)->base64_signed_file);
      $data['reg']->save();
      return response()->json(['sukses' => true, 'message' => "Dokumen berhasil ditandatangan!"]);
    } elseif ($tte->httpStatusCode == 400) {
      if (isset($resp->error)) {
        return response()->json(['sukses' => false, 'message' => $resp->error]);
      }
    } elseif ($tte->httpStatusCode == 500) {
        return response()->json(['sukses' => false, 'message' => $tte->response]);
    }
    return response()->json(['sukses' => false, 'message' => "Gagal melakukan proses tanda tangan elektronik!"]);
  }

  public function cetakAllLabLisTTE($registrasi_id)
  {
    $reg = Registrasi::find($registrasi_id);
    $tte = json_decode($reg->tte_hasillab_lis);
    if ($tte) {
      $base64 = $tte->base64_signed_file;

      $pdfContent = base64_decode($base64);
      return Response::make($pdfContent, 200, [
        'Content-Type' => 'application/pdf',
      ]);
    }
    Flashy::error('Dokumen belum memiliki tanda tangan elektronik');
    return redirect()->back();
  }

  public function cetakAllLabLis($registrasi_id)
  {
    $data['hasilLab'] = cek_hasil_lis($registrasi_id);
    foreach ($data['hasilLab'] as $hlab) {
      $resp = $this->hitungPemeriksaan($hlab->no_lab);
      $hlab->total_pemeriksaan = @$resp->total_pemeriksaan;
      $hlab->jenis_pemeriksaan = @$resp->jenis_pemeriksaan;
    }

    $data['reg'] = Registrasi::find($registrasi_id);
    $data['lab'] = Hasillab::where('registrasi_id', $registrasi_id)->first();
    $pdf = PDF::loadView('lab.cetak_all_lis_pdf', $data);
    return $pdf->stream(@$data['reg']->no_sep . '_' . @$data['reg']->pasien->nama . '.pdf');
  }

  private function hitungPemeriksaan($id_lis)
  {
    $licaResult = LicaResult::where('no_lab', $id_lis)->first();
    $hasil = '';
    $level_keys = array();

    if ($licaResult) {
      $hasil = json_decode($licaResult->json);

      // foreach ($hasil as $k => $sub_array) {
      //   $this_level = @$sub_array->group_name ?? @$sub_array->group_test;
      //   $level_keys[$this_level][$k] = $sub_array;
      // }

      // $data['response'] = (object) ["no_ref" => $id_lis, "tgl_kirim" => $licaResult->tgl_pemeriksaan];
      // Ordering by sequence
			$dataHasil = collect($hasil);
			$sortedData = $dataHasil->sortBy('sequence')->values();

			// Grouping by group test
			foreach ($sortedData as $k => $sub_array) {
			  $this_level = @$sub_array->group_name ?? @$sub_array->group_test;
			  $level_keys[$this_level][$k] = $sub_array;
			}

			$data['hasillab'] = $level_keys;
			$data['response'] = (object) ["no_ref" => $id_lis, "tgl_kirim" => $licaResult->tgl_pemeriksaan];

    } else {
      Flashy::error('Hasil dari LIS belum muncul, coba beberapa saat lagi');  
      return redirect()->back();
      $curl = curl_init();
  
      curl_setopt_array($curl, array(
        CURLOPT_URL => "172.168.1.97/lica-soreang/public/api/get_result/" . $id_lis, // your preferred link
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 30000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          // Set Here Your Requesred Headers
          'x-api-key: licaapi',
        ),
      ));
      $response = curl_exec($curl);
      if (!isset(json_decode($response)->hasil)) {
        return 0;
      }
      $err = curl_error($curl);
      curl_close($curl);
      $data['response'] = '';
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        $data['response'] = json_decode($response);
        $hasil = $data['response']->hasil;
      }
  
      foreach ($hasil as $k => $sub_array) {
        $this_level = $sub_array->group_test;
        $level_keys[$this_level][$k] = $sub_array;
      }
    }

    return (object) [
      'total_pemeriksaan' => count($hasil),
      'jenis_pemeriksaan' => $level_keys,
    ];
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
    $pasien = Pasien::find($data['registrasi']->pasien_id);
    $reg = Registrasi::where('pasien_id', $pasien->id)->pluck('id');
		// $data['hasillabs']   = Hasillab::with('orderLab.folios')->whereIn('registrasi_id', $reg)->whereNotNull('order_lab_id')->orderBy('id', 'DESC')->get();
    // $data['hasillab'] = Hasillab::where('registrasi_id', '=', $registrasi_id)->first();
    $data['hasillabs'] = Hasillab::select('id', 'registrasi_id', 'order_lab_id', 'no_lab', 'tgl_pemeriksaan', 'jam')
    ->whereIn('registrasi_id', $reg)
    ->whereNotNull('order_lab_id')
    ->with([
        'orderLab' => function ($query) {
            $query->select('id', 'registrasi_id')->with([
                'folios' => function ($query) {
                    $query->select('id', 'order_lab_id', 'namatarif');
                }
            ]);
        }
    ])
    ->orderBy('id', 'DESC')
    ->get();

  $data['hasillab'] = Hasillab::select('id', 'registrasi_id', 'dokter_id', 'penanggungjawab')
    ->where('registrasi_id', '=', $registrasi_id)
    ->first();

    return view('lab.lihat-hasil', $data);
  }

  public function deleteDetail($registrasi_id, $lab_id, $id)
  {
    RincianHasillab::find($id)->delete();
    return redirect('pemeriksaanlab/create/' . $registrasi_id . '/' . $lab_id);
  }
  public function getPemeriksaanLab($hasillab_id)
  {
    $hasillab = Hasillab::where('id',$hasillab_id)->first();

    $pemeriksaan = Folio::where('registrasi_id',$hasillab->registrasi_id)
    ->whereNotNull('order_lab_id')
    ->where('order_lab_id', $hasillab->order_lab_id)
    ->select('id', 'order_lab_id', 'namatarif')
    ->get();

    return response()->json($pemeriksaan);
  }
  // ========================================================================
  public function get_kategori($id = '')
  {
    $kategori = Labkategori::where('labsection_id', '=', $id)->pluck('nama', 'id');
    return json_encode($kategori);
  }

  public function get_laboratoria($id = '')
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
    return view('lab.cari-pasien');
  }
  public function cariPasienProses(Request $request)
  {

    session()->forget(['dokter', 'pelaksana', 'perawat']);


    $rm = $request['no_rm'];
    $nama = $request['nama'];
    $alamat = $request['alamat'];


    $today = Registrasi::join('pasiens', 'pasiens.id', '=', 'registrasis.pasien_id')

      // ->where('registrasis.created_at',  'LIKE', valid_date($request['tgl']) . '%')
      ->select('pasiens.id as pasien_id', 'registrasis.*')
      ->orderBy('id', 'DESC');
    // ->limit(3)

    if (isset($rm)) {
      $today = $today->where('pasiens.no_rm', $rm);
    }
    if (isset($nama)) {
      $today = $today->where('pasiens.nama', 'LIKE', $nama . '%');
    }
    if (isset($alamat)) {
      $today = $today->where('pasiens.alamat', 'LIKE', $alamat . '%');
    }



    $today = $today->get();

    return view('lab.cari-pasien', compact('today'))->with('no', 1);
  }
}
