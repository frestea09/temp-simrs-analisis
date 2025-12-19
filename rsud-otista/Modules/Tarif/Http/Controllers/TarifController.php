<?php

namespace Modules\Tarif\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Kategoritarif\Entities\Kategoritarif;
use Modules\Config\Entities\Tahuntarif;
use Modules\Config\Entities\Kelompoktarif;
use Modules\Tarif\Http\Requests\SavetarifRequest;
use Modules\Tarif\Http\Requests\UpdatetarifRequest;
use Modules\Tarif\Entities\Tarif;

use Modules\Kelas\Entities\Kelas;
use Modules\Kategoriheader\Entities\Kategoriheader;
use MercurySeries\Flashy\Flashy;
use App\Split;
use App\Mastersplit;
use DB;
use Excel;
use PDF;
use Modules\Accounting\Entities\Master\AkunCOA;

class TarifController extends Controller
{
  public function index() //Rawat Inap
  {
    $data['thn_tarif'] = Tahuntarif::pluck('tahun', 'id');
    $data['kh'] = Kategoritarif::all();
    //$data['tarif'] = Tarif::where('jenis', '=', 'TI')->get();
    $data['tarif'] = [];
    $data['kelas'] = Kelas::pluck('nama', 'id');
    // return $data; die;
    return view('tarif::index', $data)->with('no', 1);
  }

  public function irnaByRequest(Request $request) //Rawat Inap
  {
    $data['thn_tarif'] = Tahuntarif::pluck('tahun', 'id');
    $data['kh'] = Kategoritarif::all();
    $data['kelas'] = Kelas::pluck('nama', 'id');
    $data['tarif'] = Tarif::where('jenis', '=', 'TI')
      ->where('tahuntarif_id', $request['tahuntarif'])
      ->where('kelas_id', $request['kelas_id'])
      ->where('kategoritarif_id', $request['kategoritarif_id'])->get();
    return view('tarif::index', $data)->with('no', 1);
  }

  public function create($ta = '')
  {
    $data['kategoriheader'] = Kategoriheader::pluck('nama', 'id');
    $data['kategoritarif'] = Kategoritarif::pluck('namatarif', 'id');
    $data['tahuntarif'] = Tahuntarif::pluck('tahun', 'id');
    $data['kelompoktarif'] = Kelompoktarif::pluck('kelompok', 'id');
    $data['kelas'] = Kelas::pluck('nama', 'id');
    $data['carabayar'] = \Modules\Registrasi\Entities\Carabayar::whereIn('id', [1, 2, 8])->pluck('carabayar', 'id');

    $akunCoa = AkunCOA::where('akun_code_9', '!=', '0')->get()->toArray();
    foreach ($akunCoa as $value) {
      $data['akun_coa'][$value['id']] = implode(' - ', [$value['code'], $value['nama']]);
    }

    $data['jenis'] = $ta;

    return view('tarif::create', $data);
  }

  public function cek_split($idheader = '')
  {
    $split = Mastersplit::where('kategoriheader_id', '=', $idheader)->pluck('nama', 'id');
    return json_encode($split);
  }

  public function store(SavetarifRequest $request)
  {

    // return $request->all();
    // die;
    DB::transaction(function () use ($request) {
      $tarif = new Tarif();
      $tarif->nama = $request['nama'];
      $tarif->kode = $request['kode'];
      $tarif->jenis = $request['jenis'];
      $tarif->jenis_akreditasi = $request['jenis_akreditasi'];
      $tarif->carabayar = $request['carabayar'];
      $tarif->kategoriheader_id = $request['kategoriheader_id'];
      $tarif->kategoritarif_id = $request['kategoritarif_id'];
      $tarif->keterangan = $request['keterangan'];
      $tarif->lica_id = $request['lica_id'];
      $tarif->kodeloinc = $request['kodeloinc'];
      $tarif->kelas_id = @$request['kelas_id'];
      $tarif->tahuntarif_id = $request['tahuntarif_id'];
      $tarif->kelompoktarif_id = $request['kelompoktarif_id'];
      $tarif->total = $request['total'];
      $tarif->inhealth_jenpel = $request['kode_jenpel'];
      $tarif->akutansi_akun_coa_id = $request['akutansi_akun_coa_id'];
      $tarif->save();

      $jml_split = $request['jmlsplit'];
      for ($i = 1; $i <= $jml_split; $i++) {
        if (!empty($request['namasplit' . $i])) {
          $split = new Split();
          $split->tahuntarif_id = $request['tahuntarif_id'];
          $split->kategoriheader_id = $request['kategoriheader_id'];
          $split->tarif_id = $tarif->id;
          $split->nama = $request['namasplit' . $i];
          $split->nominal = !empty($request['split' . $i]) ? $request['split' . $i] : 0;
          $split->save();
        }
      }
    });

    Flashy::success('Tarif baru berhasil di tambahkan');
    if ($request['jenis'] == 'TA') {
      return redirect('tarif/rawatjalan');
    } elseif ($request['jenis'] == 'TI') {
      return redirect()->route('tarif');
    } else {
      return redirect('tarif/rawatdarurat');
    }
  }

  public function show()
  {
    return view('tarif::show');
  }

  public function edit($id)
  {
    $data['kategoriheader'] = Kategoriheader::pluck('nama', 'id');
    $data['kategoritarif'] = Kategoritarif::pluck('namatarif', 'id');
    $data['tahuntarif'] = Tahuntarif::pluck('tahun', 'id');
    $data['kelompoktarif'] = Kelompoktarif::pluck('kelompok', 'id');
    $data['carabayar'] = \Modules\Registrasi\Entities\Carabayar::whereIn('carabayar', ['JKN', 'UMUM'])->pluck('carabayar', 'id');
    $data['tarif'] = Tarif::find($id);
    $data['split'] = Split::where('tarif_id', '=', $id)->get();
    $data['kelas'] = Kelas::pluck('nama', 'id');
    $data['jenis'] = request()->segment(4);

    $akunCoa = AkunCOA::where('akun_code_9', '!=', '0')->get();
    foreach ($akunCoa as $value) {
      $data['akun_coa'][$value['id']] = implode(' - ', [$value['code'], $value['nama']]);
    }

    return view('tarif::edit', $data);
  }

  public function update(UpdatetarifRequest $request, $id)
  {
    $tarif = Tarif::find($id);
    $tarif->nama = $request['nama'];
    $tarif->kode = $request['kode'];
    $tarif->jenis = $request['jenis'];
    $tarif->jenis_akreditasi = $request['jenis_akreditasi'];
    $tarif->kelas_id = @$request['kelas_id'];
    $tarif->kategoritarif_id = $request['kategoritarif_id'];
    $tarif->keterangan = $request['keterangan'];
    $tarif->lica_id = $request['lica_id'];
    $tarif->kodeloinc = $request['kodeloinc'];
    $tarif->tahuntarif_id = $request['tahuntarif_id'];
    $tarif->kelompoktarif_id = $request['kelompoktarif_id'];
    $tarif->total = $request['total'];
    $tarif->akutansi_akun_coa_id = $request['akutansi_akun_coa_id'];
    $tarif->is_aktif = $request['is_aktif'];
    $tarif->update();

    $jml_split = $request['jmlsplit'];
    for ($i = 1; $i <= ($jml_split); $i++) {
      $split = Split::find($request['idsplit' . $i]);
      $split->tahuntarif_id = $request['tahuntarif_id'];
      $split->kategoriheader_id = $request['kategoriheader_id'];
      $split->tarif_id = $tarif->id;
      $split->nominal = !empty($request['master-split' . $i]) ? $request['master-split' . $i] : 0;
      $split->update();
    }

    Flashy::info('Tarif berhasil di update');
    if ($request['jenis'] == 'TA') {
      return redirect('tarif/rawatjalan');
    } elseif ($request['jenis'] == 'TI') {
      return redirect()->route('tarif');
    } elseif ($request['jenis'] == 'TG') {
      return redirect('tarif/rawatdarurat');
    }
  }

  public function byKategoriHeader(Request $request)
  {
    ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '-1');
    $data['thn_tarif'] = Tahuntarif::pluck('tahun', 'id');
    $data['kh'] = Kategoritarif::all();
    if ($request['kategoriheader_id'] == null) {
      $data['tarif'] = Tarif::with(['akun_coa', 'tahuntarif'])->where('jenis', 'TA')->where('tahuntarif_id', $request['tahuntarif'])->orderBy('nama', 'asc')->get();
      return view('tarif::rawat_jalan', $data)->with('no', 1);
    } else {
      return redirect('tarif/rawatjalan/' . $request['tahuntarif'] . '/' . $request['kategoriheader_id']);
    }
  }

  public function tarif_rawatjalan($thntarif_id = '', $kategoritarif_id = '')
  {
    $data['thn_tarif'] = Tahuntarif::pluck('tahun', 'id');
    $data['kh'] = Kategoritarif::all();

    if (!empty($thntarif_id) && !empty($kategoritarif_id)) {
      // $kat_tarif = Kategoritarif::where('kategoriheader_id', $kategoriheader_id)->first();
      $data['tarif'] = Tarif::with(['akun_coa', 'tahuntarif'])->where('jenis', '=', 'TA')->where('tahuntarif_id', $thntarif_id)->where('kategoritarif_id', $kategoritarif_id)->get();
      $data['tahuntarif_id'] = $thntarif_id;
      $data['kategoritarif_id'] = $kategoritarif_id;
    }
    return view('tarif::rawat_jalan', $data)->with('no', 1);
  }

  public function igdByKategoriHeader(Request $request)
  {
    ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '-1');
    $data['thn_tarif'] = Tahuntarif::pluck('tahun', 'id');
    $data['kh'] = Kategoritarif::all();
    if ($request['kategoriheader_id'] == null) {
      $data['tarif'] = Tarif::with('akun_coa')->where('jenis', 'TG')->where('tahuntarif_id', $request['tahuntarif'])->orderBy('nama', 'asc')->get();
      return view('tarif::rawat_darurat', $data)->with('no', 1);
    } else {
      return redirect('tarif/rawatdarurat/' . $request['tahuntarif'] . '/' . $request['kategoriheader_id']);
    }
  }

  public function tarif_darurat($thntarif_id = 1, $kategoritarif_id = "")
  {
    $data['thn_tarif'] = Tahuntarif::pluck('tahun', 'id');
    $data['kh'] = Kategoritarif::all();
    // if (!empty($thntarif_id) && !empty($kategoriheader_id)) {
    //   $data['tarif'] = Tarif::where('jenis','=','TG')->where('tahuntarif_id', $thntarif_id)->where('kategoritarif_id', $kategoritarif_id)->get();
    // } else {
    //   $data['tarif'] = Tarif::where(['jenis' => 'TG', 'tahuntarif_id' => $thntarif_id, 'kategoritarif_id' => $kategoritarif_id])->get();
    // }
    $data['tarif'] = Tarif::with('akun_coa')->where(['jenis' => 'TG', 'tahuntarif_id' => $thntarif_id, 'kategoritarif_id' => $kategoritarif_id])->get();
    //return $data; die;
    return view('tarif::rawat_darurat', $data)->with('no', 1);
  }

  public function tarif_irna($thntarif_id = 1, $kategoritarif_id = "")
  {
    $data['thn_tarif'] = Tahuntarif::pluck('tahun', 'id');
    $data['kh'] = Kategoritarif::all();
    // if (!empty($thntarif_id) && !empty($kategoriheader_id)) {
    //   $data['tarif'] = Tarif::where('jenis','=','TG')->where('tahuntarif_id', $thntarif_id)->where('kategoritarif_id', $kategoritarif_id)->get();
    // } else {
    //   $data['tarif'] = Tarif::where(['jenis' => 'TG', 'tahuntarif_id' => $thntarif_id, 'kategoritarif_id' => $kategoritarif_id])->get();
    // }
    $data['tarif'] = Tarif::with(['akun_coa', 'kelas', 'tahuntarif'])->where(['jenis' => 'TI', 'tahuntarif_id' => $thntarif_id, 'kategoritarif_id' => $kategoritarif_id])->get();
    //return $data; die;
    return view('tarif::rawat_inap', $data)->with('no', 1);
  }

  public function irnaByKategoriHeader(Request $request)
  {
    ini_set('max_execution_time', 0); //0=NOLIMIT
		ini_set('memory_limit', '-1');
    $data['thn_tarif'] = Tahuntarif::pluck('tahun', 'id');
    $data['kh'] = Kategoritarif::all();
    if ($request['kategoriheader_id'] == null) {
      $data['tarif'] = Tarif::with(['akun_coa', 'kelas', 'tahuntarif'])->where('jenis', 'TI')->where('tahuntarif_id', $request['tahuntarif'])->orderBy('nama', 'asc')->get();
      return view('tarif::rawat_inap', $data)->with('no', 1);
    } else {
      return redirect('tarif/irna/' . $request['tahuntarif'] . '/' . $request['kategoriheader_id']);
    }
  }

  public function updateInhealth(Request $request)
  {
    $find = Tarif::find($request->id);
    $find->inhealth_jenpel = $request->inhealth_jenpel;
    $find->update();
    return redirect()->back();
  }

  public function hapusTarif($jenis, $thntarif_id, $kategoriheader_id)
  {
    //Cek tarif
    //Hapus split
    //Hapus tarif
  }

  public function destroy()
  {
  }

  public function alltarif()
  {
    $data['tarif'] = Tarif::leftJoin('kategoriheaders', 'kategoriheaders.id', '=', 'tarifs.kategoriheader_id')
      ->leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
      // ->where('tarifs.jenis', '')
      // ->where('kategoriheaders.nama', '')
      ->select('tarifs.nama as tarif', 'kategoriheaders.nama as kategoriheader', 'kategoritarifs.namatarif as kategoritarif', 'tarifs.total', 'tarifs.jenis', 'tarifs.carabayar')
      ->get();
    return view('tarif::tampilsemua', $data)->with('no', 1);
  }

  public function alltarifby(Request $request)
  {
    $jenis = $request['jenis'];

    if ($jenis == 'semua') {
      $data['tarif'] = Tarif::leftJoin('kategoriheaders', 'kategoriheaders.id', '=', 'tarifs.kategoriheader_id')
        ->leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
        // ->where('tarifs.jenis', '')
        // ->where('kategoriheaders.nama', '')
        ->select('tarifs.nama as tarif', 'kategoriheaders.nama as kategoriheader', 'kategoritarifs.namatarif as kategoritarif', 'tarifs.total', 'tarifs.jenis')
        ->get();
      $get = $data['tarif'];
    } else {
      $data['tarif'] = Tarif::leftJoin('kategoriheaders', 'kategoriheaders.id', '=', 'tarifs.kategoriheader_id')
        ->leftJoin('kategoritarifs', 'kategoritarifs.id', '=', 'tarifs.kategoritarif_id')
        ->where('tarifs.jenis', $jenis)
        // ->where('kategoriheaders.nama', '')
        ->select('tarifs.nama as tarif', 'kategoriheaders.nama as kategoriheader', 'kategoritarifs.namatarif as kategoritarif', 'tarifs.total', 'tarifs.jenis')
        ->get();
      $get = $data['tarif'];
    }

    if ($request['lanjut']) {
      return view('tarif::tampilsemua', $data)->with('no', 1);
    } elseif ($request['excel']) {

      Excel::create('Tarif' . ' - ' . $jenis, function ($excel) use ($get) {
        // Set the properties
        $excel->setTitle('Tarif')
          ->setCreator('Digihealth')
          ->setCompany('Digihealth')
          ->setDescription('Tarif');
        $excel->sheet('Tarif', function ($sheet) use ($get) {
          $row = 1;
          $no = 1;
          $sheet->row($row, [
            'No',
            'Nama',
            'Jenis',
            'Kategori Header',
            'Kategori Tarif',
            'Total',
          ]);
          foreach ($get as $key => $d) {
            $sheet->row(++$row, [
              $no++,
              $d->tarif,
              $d->jenis,
              $d->kategoriheader,
              $d->kategoritarif,
              $d->total,
            ]);
          }
        });
      })->export('xlsx');
    } elseif ($request['pdf']) {
      $tarif = $data['tarif'];
      $jenis = $jenis;
      $no = 1;
      $pdf = PDF::loadView('tarif::tampilsemua', compact('tarif', 'jn', 'no'));
      $pdf->setPaper('A4', 'landscape');
      return $pdf->download('Tarif.pdf');
    }
  }

  public function exportAllTarif()
  {
    ini_set('max_execution_time', 0); //0=NOLIMIT
    ini_set('memory_limit', '8000M');

    $tarif = Tarif::with(['kategoritarif', 'kategoriheader', 'tahuntarif'])->get();
    Excel::create('Daftar Semua Tarif', function ($excel) use ($tarif) {
      // Set the properties
      $excel->setTitle('Tarif')
        ->setCreator('Digihealth')
        ->setCompany('Digihealth')
        ->setDescription('Tarif');
      $excel->sheet('Tarif', function ($sheet) use ($tarif) {
        $row = 1;
        $no = 1;
        $sheet->row($row, [
          'No',
          'Nama',
          'Jenis',
          'Kategori Header',
          'Kategori Tarif',
          'Tahun Tarif',
          'Harga',
        ]);
        foreach ($tarif as $key => $d) {
          $sheet->row(++$row, [
            $no++,
            @$d->nama,
            @$d->jenis,
            @$d->kategoriheader->nama,
            @$d->kategoritarif->namatarif,
            @$d->tahuntarif->tahun,
            'Rp. ' . number_format(@$d->total),
          ]);
        }
      });
    })->export('xlsx');
  }

  public function exportTarifLab()
  {
    ini_set('max_execution_time', 0); //0=NOLIMIT
    ini_set('memory_limit', '8000M');

    $tarif = Tarif::with(['kategoritarif', 'kategoriheader', 'tahuntarif'])->where('jenis', 'TI')->whereNotNull('lica_id')->get();
    Excel::create('Daftar tarif lab', function ($excel) use ($tarif) {
      // Set the properties
      $excel->setTitle('Tarif')
        ->setCreator('Digihealth')
        ->setCompany('Digihealth')
        ->setDescription('Tarif');
      $excel->sheet('Tarif', function ($sheet) use ($tarif) {
        $row = 1;
        $no = 1;
        $sheet->row($row, [
          'No',
          'Nama',
          'kode',
          'Kategori Header',
          'Kategori Tarif',
          'Tahun Tarif',
          'Harga',
        ]);
        foreach ($tarif as $key => $d) {
          $sheet->row(++$row, [
            $no++,
            @$d->nama,
            @$d->kode,
            @$d->kategoriheader->nama,
            @$d->kategoritarif->namatarif,
            @$d->tahuntarif->tahun,
            'Rp. ' . number_format(@$d->total),
          ]);
        }
      });
    })->export('xlsx');
  }
}
