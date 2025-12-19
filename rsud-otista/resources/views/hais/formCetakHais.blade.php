<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Cetak Hais</title>
  <!-- Bootstrap 3.3.7 -->
  <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
  <style media="screen">
    @page {
      margin-top: 1cm;
      margin-left: 3cm;
      margin-right: 3cm;
    }

    .table-borderless>tbody>tr>td,
    .table-borderless>tbody>tr>th,
    .table-borderless>tfoot>tr>td,
    .table-borderless>tfoot>tr>th,
    .table-borderless>thead>tr>td,
    .table-borderless>thead>tr>th {
      border: none;
    }
    .page_break { page-break-after: always; }
  </style>
</head>

<body>
  <table style="width:100%; margin-bottom: -10px;">
    <tbody>
      <tr>
        <th style="width:15%" rowspan="2">
          <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive text-left"
            style="width:100px;">
        </th>
        <th class="text-left" colspan="7" rowspan="2">
          <h6 style="font-size: 110%;"><b>{{ configrs()->nama }}</b></h6>
          <p style="font-size: 100%">{{ configrs()->alamat }} {{ configrs()->tlp }} <br />Email : {{configrs()->email
            }}<br />Website : {{configrs()->website }}</p>
        </th>

      </tr>
    </tbody>
  </table>
  <div class="page_break">
  <div class="row">
    <div class="col-sm-12 text-center">
      <hr>
      <h5><b>FORMULIR HARIAN SURVELIANS HAIs</b><br />
        <b>Pemakaian Peralatan</b>
      </h5>
      {{-- <div class="text-left my-3">
        <h5>Ruangan : &nbsp;{{baca_kamar($histori->kamar_id)}}</h5>
        <h5>Bulan : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tahun :</h5>

      </div> --}} 

      {{-- @php
          dd($hais);
      @endphp --}}

      <div class="mt-3" style="font-size:12px !important;">
        <h5 class="text-left"><b>DATA MEDICAL RECORD</b></h5>
        {{-- MEDREC --}}
        <table class="table" width="100px">
          <tbody>
            <tr>
              <td style="width:150px;">No. Medical Record</td>
              <td style="width:20px;">:</td>
              <td style="width:"></td>
            </tr>
            <tr>
              <td>Nomor NIK</td>
              <td>:</td>
              <td>{{@$hais->pasien->nik}}</td>
            </tr>
            <tr>
              <td>Ruangan</td>
              <td>:</td>
              <td>{{@baca_kamar(@$histori->kamar_id)}}</td>
            </tr>
            <tr>
              <td>Tanggal Masuk</td>
              <td>:</td>
              <td>{{date('d-m-Y / H:i',strtotime($histori->tgl_masuk))}}</td>
            </tr>
            <tr>
              <td>Tanggal Keluar</td>
              <td>:</td>
              <td>{{$histori->tgl_keluar ? date('d-m-Y',strtotime($histori->tgl_keluar)) :''}}</td>
            </tr>
            <tr>
              <td>Cara Dirawat</td>
              <td>:</td>
              <td>
                <input type="checkbox"> Emergency &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"> Efektif
              </td>
            </tr>
            <tr>
              <td>Diagnosa Masuk</td>
              <td>:</td>
              <td></td>
            </tr>
            <tr>
              <td>Diagnosa Keluar</td>
              <td>:</td>
              <td></td>
            </tr>
          </tbody>

        </table>
        {{-- Faktor Resiko --}}
        <h5 style="margin-top:-10px;" class="text-left"><b>Faktor Resiko Pasien</b></h5>
        <table class="table" width="100px">
          <tbody>
            <tr>
              <td style="padding: 5px;">
                <p><input type="checkbox" {{$hais->is_umur ? 'checked' :''}}>&nbsp;Umur &nbsp;&nbsp;&nbsp;&nbsp;<input
                    type="checkbox" {{$hais->is_gizi ? 'checked' :''}} >&nbsp;Gizi&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" {{$hais->is_obesitas ? 'checked' :''}}>&nbsp;Obesitas
                </p>
                <p>Penyakit Penyerta :

                  <input type="checkbox" {{$hais->is_diabetes ? 'checked' :''}}>&nbsp;Diabetes
                  <input type="checkbox" {{$hais->is_hiv ? 'checked' :''}}>&nbsp;HIV
                  <input type="checkbox" {{$hais->is_hbv ? 'checked' :''}}>&nbsp;HBV
                  <input type="checkbox" {{$hais->is_hcv ? 'checked' :''}}>&nbsp;HCV
                </p>
              </td>
            </tr>
          </tbody>

        </table>
        {{-- Faktor pemakaian --}}
        @php
        @endphp
        <h5 class="text-left" style="margin-top:-20px;"><b>Faktor risiko pemakaian Peralatan Perawatan Pasien</b></h5>
        <table style="font-size:12px;width: 100%"
          class="table table-striped table-bordered table-hover table-condensed form-box">
          <tr>
            <th style="padding: 5px;">
              <b>Intra Vena Kateter</b>
              {{-- <p><input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1">&nbsp;Umur --}}
            </th>
            <th class="text-center">Tgl Terpasang</th>
            <th class="text-center">Tgl Lepas</th>
            <th class="text-center">Total Hari</th>
          </tr>
          @foreach ( App\PPI\MasterPpi::all() as $key=> $item)
          @php
          // $pemakaian = \App\PPI\PpiFaktorPemakaian::where('ppi_id',$hais->id)->where('master_ppi_id',@$item->id)->first();
          $pemakaian = \App\PPI\PpiFaktorPemakaian::where('ppi_id',$hais->id)->first();
 
          @endphp
          <tr>
            <td>
              <input type="checkbox" {{@$pemakaian->master_ppi_id == null ? 'checked' :''}}> &nbsp;
              &nbsp;
            </td>
            <td class="text-center">{{@$pemakaian->tgl_terpasang ? date('d-m-Y',strtotime(@$pemakaian->tgl_terpasang)) :
              ''}}</td>
            <td class="text-center">{{@$pemakaian->tgl_lepas ? date('d-m-Y',strtotime($pemakaian->tgl_lepas)) :''}}</td>
            <td class="text-center">{{@$pemakaian->total_hari}}</td>
          </tr>
          @endforeach
        </table>
        {{-- Antibiotik --}}
        <table style="width: 100%;font-size:12px;margin-top:-20px;" class="table table-hover table-condensed form-box">
          <tr>
            <th style="padding: 5px;">
              <b>Penggunaan Anti Biotik</b>
              {{-- <p><input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1">&nbsp;Umur --}}
            </th>
            <th>Tgl Pakai</th>
            <th>Tgl Berhenti</th>
          </tr>
          {{-- <td> --}}
            @php
            $antibiotik = \App\PPI\PpiAntibiotik::where('ppi_id',$hais->id)->get();
            @endphp
            @foreach ($antibiotik as $key=>$res)
            <tr>
              <td>
                {{$key+1}}&nbsp;{{@$res->antibiotik}}
              </td>
              <td>{{@valid_date(@$res->tgl_pakai)}}</td>
              <td>{{@valid_date(@$res->tgl_berhenti)}}</td>
            </tr>
            @endforeach



        </table>

        {{-- Penunjang --}}
        <table style="width: 100%;font-size:12px;margin-top:-20px;" class="table table-striped form-box">
          <tr>
            <th style="padding: 5px;" colspan="2">
              <b>Pemeriksaan Penunjang</b>
            </th>
          </tr>
          <tr>
            <td style="width:150px;">Radiologi</td>
            <td style="width:20px;">:</td>
            <td style="width:">{{$hais->radiologi}}</td>
          </tr>
          <tr>
            <td style="width:150px;">Laboratorium</td>
            <td style="width:20px;">:</td>
            <td style="width:">{{$hais->laboratorium}}</td>
          </tr>
        </table>
        {{-- Kultur --}}
        <table style="width: 100%;font-size:12px;margin-top:-20px;" class="table table-striped form-box">
          <tr>
            <th style="padding: 5px;" colspan="2">
              <b>Hasil Kultur Specimen</b>
            </th>
          </tr>
          <tr>
            <td style="width:150px;">Darah</td>
            <td style="width:20px;">:</td>
            <td style="width:">{!!isset(json_decode($hais->kultur,true)['darah']) ? json_decode($hais->kultur,true)['darah']: ''!!}</td>
          </tr>
          <tr>
            <td style="width:150px;">Sputum</td>
            <td style="width:20px;">:</td>
            <td style="width:">{!!isset(json_decode($hais->kultur,true)['sputum']) ? json_decode($hais->kultur,true)['sputum']: ''!!}</td>
          </tr>
          <tr>
            <td style="width:150px;">Spine</td>
            <td style="width:20px;">:</td>
            <td style="width:">{!!isset(json_decode($hais->kultur,true)['spine']) ? json_decode($hais->kultur,true)['spine']: ''!!}</td>
          </tr>
        </table>
        {{-- Kompllikasi --}}
        <table style="width: 100%;font-size:12px;margin-top:-20px;" class="table table-striped form-box">
          <tr>
            <th style="padding: 5px;" colspan="2">
              <b>Komplikasi Infeksi</b>
            </th>
          </tr>
          <tr>
            <td>{{strtoupper($hais->komplikasi)}}</td>
          </tr> 
        </table>
      </div>
    </div>
  </div>
  </div>
  {{-- <p>Update data oleh: {{ $pasien->user_create }}, pada tanggal: {{ $pasien->created_at->format('d/m/Y') }}</p>
  --}}
  <div class="row">
    <div class="col-md-12">
      <h5 class="text-center"><b>TINDAKAN OPERASI</b></h5>
      {{-- <div class="text-left my-3">
        <h5>Ruangan : &nbsp;{{baca_kamar($histori->kamar_id)}}</h5>
        <h5>Bulan : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tahun :</h5>

      </div> --}}
      @php
          $tindakan = json_decode($hais->tindakan_operasi,true);
      @endphp
      <div class="mt-3" style="font-size:12px !important;">
        <h5 class="text-left"><b>Data Petugas Kamar Bedah</b></h5>
        {{-- MEDREC --}}
        <table class="table" width="100px">
          <tbody>
            <tr>
              <th>Ahli Bedah 1</th>
              <td>{{@$tindakan['petugas']['ahli_bedah_1']}}</td>
              <th>Ahli Bedah 2</th>
              <td>{{@$tindakan['petugas']['ahli_bedah_2']}}</td>
          </tr>
          <tr>
              <th>Scrub Nurse 1</th>
              <td>{{@$tindakan['petugas']['nurse_1']}}</td>
              <th>Scrub Nurse 2</th>
              <td>{{@$tindakan['petugas']['nurse_2']}}</td>
          </tr>
          </tbody>

        </table>
        {{-- Faktor Resiko --}}
        <h5 style="margin-top:-10px;" class="text-left"><b>Faktor Resiko Pasien</b></h5>
        <table style="width: 100%" class="table ">
                    <tr>
                        <th style="width:150px;">Jenis Operasi</th>
                        <td style="width:20px;">:</td>
                        <td style="width:">{{@$tindakan['jenis_operasi']}}</td>
                    </tr>
                    <tr>
                        <th>Tipe Operasi</th>
                        <td>:</td>
                        <td>
                            <input class="form-check-input" {{@$tindakan['tipe'] == 'terbuka' ?'checked' :''}} type="radio">
                            Terbuka
                            &nbsp;&nbsp;
                            <input class="form-check-input" type="radio" {{@$tindakan['tipe'] == 'tertutup' ?'checked' :''}} >
                            Tertutup
                        </td>
                    </tr>
                    <tr>
                        <th>Kategori Resiko</th>
                        <td>:</td>
                        <td>
                            <input class="form-check-input" type="radio" {{@$tindakan['resiko'] == '0' ?'checked' :''}}>
                            0&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" {{@$tindakan['resiko'] == '1' ?'checked' :''}}>
                            1&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" {{@$tindakan['resiko'] == '2' ?'checked' :''}}>
                            2&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" {{@$tindakan['resiko'] == '3' ?'checked' :''}}>
                            3
                        </td>
                    </tr>
                    <tr>
                        <th>Klasifikasi Luka</th>
                        <td>:</td>
                        <td>
                            <input class="form-check-input" type="radio" {{@$tindakan['klasifikasi'] == 'Bersih' ?'checked' :''}}>
                            Bersih&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" {{@$tindakan['klasifikasi'] == 'Bersih Terkontaminasi' ?'checked' :''}}>
                            Bersih Terkontaminasi
                            &nbsp;&nbsp;
                            <input class="form-check-input" type="radio" {{@$tindakan['klasifikasi'] == 'Terkontaminasi' ?'checked' :''}}>
                            Terkontaminasi
                            &nbsp;&nbsp;
                            <input class="form-check-input" type="radio" {{@$tindakan['klasifikasi'] == 'Kotor' ?'checked' :''}}>
                            Kotor
                        </td>
                    </tr>
                </table>
        {{-- Faktor pemakaian --}} 
        <h5><b>Klasifikasi ASA (American Society of Anasthesiolosists)</b></h5>
                <table style="width: 100%" class="table">
                    <tr>
                        <td>
                            <input class="form-check-input" type="radio" {{@$tindakan['asa'] == 'Asa 1. Pasien dalam kondisi sehat' ?'checked' :''}}>
                            Asa 1. Pasien dalam kondisi sehat<br/>
                            <input class="form-check-input" type="radio" {{@$tindakan['asa'] == 'Asa 2. Pasien dengan kelainan sistematik ringan - sedang' ?'checked' :''}}>
                            Asa 2. Pasien dengan kelainan sistematik ringan - sedang<br/>
                            <input class="form-check-input" type="radio" {{@$tindakan['asa'] == 'Asa 3. Pasien dengan gangguan sistematik, aktifitas terbatas' ?'checked' :''}}>
                            Asa 3. Pasien dengan gangguan sistematik, aktifitas terbatas<br/>
                            <input class="form-check-input" type="radio" {{@$tindakan['asa'] == 'Asa 4. Pasien dengan kelainan sistematik berat, tidak bisa beraktifitas' ?'checked' :''}}>
                            Asa 4. Pasien dengan kelainan sistematik berat, tidak bisa beraktifitas<br/>
                            <input class="form-check-input" type="radio" {{@$tindakan['asa'] == 'Asa 5. Pasien tidak diharapkan hidup setelah 24 jam walaupun dioperasi' ?'checked' :''}}>
                            Asa 5. Pasien tidak diharapkan hidup setelah 24 jam walaupun dioperasi<br/>
                        </td>
                    </tr>
                </table>
        {{-- Antibiotik --}}
        <table style="width: 100%" class="table"> 
                    <tr>
                        <th style="padding: 5px;" colspan="2">
                            <b>T. Time</b>
                            {{-- <p><input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1">&nbsp;Umur --}}
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-check-input" type="radio" {{@$tindakan['time'] == 'Kurang dari T.Time' ?'checked' :''}}>
                            <label class="form-check-label" for="defaultCheck1">
                                Kurang dari T.Time
                            </label>
                        </td>
                        <td>
                            <input class="form-check-input" type="radio" {{@$tindakan['time'] == 'Lebih dari T.Time' ?'checked' :''}} >
                            <label class="form-check-label" for="defaultCheck1">
                                Lebih dari T.Time
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Hasil Kultur Specimen Luka Jaringan</td>
                        <td>
                          {{@$tindakan['hasil']}} 
                        </td>
                    </tr>
                </table>
{{-- Antibiotik --}}
                <table style="width: 100%"class="table"> 
                <tr>
                    <th style="padding: 5px;">
                        <b>Penggunaan Antibiotik</b>
                        {{-- <p><input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1">&nbsp;Umur --}}
                    </th>
                </tr>
                @if (isset(json_decode($hais->tindakan_operasi,true)['antibiotik']))
                    @foreach (json_decode($hais->tindakan_operasi,true)['antibiotik'] as $key=>$item)
                      @if (@$item)
                      <tr>
                        <td>{{$key+1}}.&nbsp;&nbsp;{{@$item}}</td>
                      </tr>
                          
                      @endif
                    @endforeach
                @endif
                {{-- <tr><td><input type="text" class="form-control" name="tindakan_operasi[antibiotik][1]"></td></tr> --}}
                {{-- <tr><td><input type="text" class="form-control" name="tindakan_operasi[antibiotik][2]"></td></tr> --}}
            </table>
      </div>
    </div>
  </div>
</body>

</html>