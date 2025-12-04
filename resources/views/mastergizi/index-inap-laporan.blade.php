@extends('master')
@section('header')
  <h1>Laporan Gizi<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <form class="form-horizontal" action="{{ url('index-inap-laporan') }}" method="POST">
        {{ csrf_field() }}
        <div class="row">
          @php
              $ruangans =  Modules\Kamar\Entities\Kamar::all();
              $list_kelas =  App\Kelompokkelas::select('general_code', \DB::raw("MIN(kelompok) as nama"))->groupBy('general_code')->get()
                              ->map(function ($item) {
                                $item->label = strtok($item->nama, ' ');
                                return $item;
                              });
              $pegawais =  Modules\Pegawai\Entities\Pegawai::where('kelompok_pegawai', 6)->select('nama', 'user_id')->get();
          @endphp
            <div class="col-md-12">
              <div class="col-md-7">
                <div class="form-group">
                  <label for="tanggal" class="col-md-2 control-label">Periode</label>
                  <div class="col-md-5">
                      <input type="text" name="tga" class="form-control datepicker" autocomplete="off" value="{{ isset($_POST['tga']) ? $_POST['tga'] : '' }}">
                      <span class="text-danger" id=""></span>
                  </div>
                  <div class="col-md-5">
                      <input type="text" name="tgb" class="form-control datepicker" autocomplete="off" value="{{ isset($_POST['tgb']) ? $_POST['tgb'] : '' }}">
                      <span class="text-danger" id=""></span>
                  </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Ruangan</label>
                    <div class="col-md-5">
                        <select name="filter_kamar" id="" class="form-control select2">
                        <option value="" {{ empty($filter_kamar) ? 'selected' : '' }}>Semua</option>
                            @foreach ($list_kelas as $k)
                                <option value="{{ $k->general_code }}" {{ @$filter_kamar == $k->general_code ? 'selected' : '' }}>
                                    {{ $k->label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Ahli Gizi</label>
                    <div class="col-md-5">
                        <select name="pegawai" class="form-control select2">
                            <option value="" {{ ($_POST['pegawai'] ?? '') == '' ? 'selected' : '' }}>-- Semua Ahli Gizi --</option>
                            @foreach ($pegawais as $pegawai)
                                <option value="{{ $pegawai->user_id }}" {{ ($_POST['pegawai'] ?? '') == $pegawai->user_id ? 'selected' : '' }}>
                                    {{ $pegawai->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                    <input type="submit" name="excel" class="btn btn-success btn-flat" value="EXCEL">
                    <input type="submit" name="tampil" class="btn btn-primary btn-flat" value="TAMPILKAN">
                </div>
              </div>
            </div>
        </div>
      </form>
    </div>
      <hr>

      <div class='table-responsive'>
        <table id='data' class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              {{-- <th>Tanggal Registrasi</th> --}}
              <th>Nama Pasien</th>
              <th>No. RM</th>
              <th>Ruangan</th>
              <th>Usia</th>
              <th>Diagnosa</th>
              <th>Bentuk Makanan</th>
              <th>Jenis Diet</th>
              <th>Keterangan</th>
              <th>Skrinning</th>
              <th>Ahli Gizi</th>
              {{-- <th>Jenis Kelamin </th>
              <th>Dokter</th>
              <th style="width: 500px !important;">Diet</th>
              <th>Skrinning</th>
              <th>Edukasi</th>
              <th>PAGT</th>
              <th>Jenis Bayar</th>
              <th>BB</th>
              <th>TB</th>
              <th>Status Gizi</th>
              <th>Petugas</th> --}}
            </tr>
          </thead>
          <tbody>
            @if (isset($reg))
              @foreach ($reg as $key => $d)
                @if ($d->pengkajian_gizi)
                  @php
                    $gizi = json_decode($d->pengkajian_gizi->fisik, true);
                  @endphp
                  <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ date('d-m-Y', strtotime($d->created_at)) }}</td> --}}
                    <td>{{ @$d->pasien->nama }}</td>
                    <td>{{ @$d->pasien->no_rm }}</td>
                    <td>{{ baca_kamar(@$d->rawat_inap->kamar_id) }}</td>
                    <td>{{ hitung_umur(@$d->pasien->tgllahir) }}</td>
                    <td>{{ @$gizi['diagnosa_gizi'] }}</td>
                    <td>
                        @php
                            $bentukMakanan = @$gizi['intervensi_gizi']['preskripsi_diet']['bentuk_makanan'] ?? [];
                            if (!is_array($bentukMakanan)) {
                                $bentukMakanan = (array) $bentukMakanan;
                            }
                            $bentukMakananLain = @$gizi['intervensi_gizi']['preskripsi_diet']['bentuk_makanan_lain'] ?? null;
                        @endphp
                        @if (!empty($bentukMakanan))
                            {{ implode(', ', $bentukMakanan) }}
                            @if (in_array('Lainnya', $bentukMakanan) && $bentukMakananLain)
                                : {{ $bentukMakananLain }}
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if (@$gizi['intervensi_gizi']['preskripsi_diet']['jenis_diet'] == 'Lainnya')
                            Lainnya: {{ @$gizi['intervensi_gizi']['preskripsi_diet']['jenis_diet_lainnya'] }}
                        @else
                            {{ @$gizi['intervensi_gizi']['preskripsi_diet']['jenis_diet'] }}
                        @endif
                    </td>
                    <td></td>
                    <td>
                      @php
                        $totalSkor = 0;
                        if ($d->skrining_anak) {
                          $totalSkor = @json_decode($d->skrining_anak->nutrisi, true)['skor']['total'];
                          $kesimpulan = @json_decode($d->skrining_anak->nutrisi, true)['skor']['kesimpulan'];
                        }
                        if ($d->skrining_dewasa) {
                          $totalSkor = @json_decode($d->skrining_dewasa->nutrisi, true)['skor']['total'];
                          $kesimpulan = @json_decode($d->skrining_dewasa->nutrisi, true)['skor']['kesimpulan'];
                        }
                      @endphp
                      {{$kesimpulan}}({{$totalSkor}})
                    </td>
                    <td>{{ baca_user(@$d->pengkajian_gizi->user_id) }}</td>
                    {{-- <td>{{ @$d->pasien->kelamin }}</td>
                    <td>{{ baca_dokter(@$d->dokter_id) }}</td>
                    <td style="width: 500px !important;">
                      @php
                        $intervensi = @json_decode(@$d->pengkajian_gizi->fisik, true)['intervensi_gizi'];
                      @endphp
                      @if ($intervensi)
                        <b>Tujuan : </b> {{@$intervensi['tujuan']}} <br>
                        <b>Preskripsi Diet : </b> <br>
                        <b>- Bentuk makanan : </b>{{@$intervensi['preskripsi_diet']['bentuk_makanan']}}, {{@$intervensi['preskripsi_diet']['bentuk_makanan_lain']}} <br>
                        <b>- Jenis diet : </b>{{@$intervensi['preskripsi_diet']['jenis_diet']}} <br>
                        <b>- Frekuensi : </b>{{@$intervensi['preskripsi_diet']['frekuensi']}} <br>
                        <b>- Rute : </b>@if (is_array(@$intervensi['preskripsi_diet']['rute']))
                                    @foreach (@$intervensi['preskripsi_diet']['rute'] as $rute)
                                      {{$rute}}, 
                                    @endforeach
                                 @endif <br>
                        <b>- Kebutuhan Energi : </b> {{@$intervensi['preskripsi_diet']['kebutuhan']['energi']}} <br>
                        <b>- Kebutuhan Protein : </b> {{@$intervensi['preskripsi_diet']['kebutuhan']['protein']}} <br>
                        <b>- Kebutuhan Lemak : </b> {{@$intervensi['preskripsi_diet']['kebutuhan']['lemak']}} <br>
                        <b>- Kebutuhan Karbohidrat : </b> {{@$intervensi['preskripsi_diet']['kebutuhan']['karbohidrat']}} <br>

                      @else
                       -
                      @endif
                    </td>
                    <td>
                      @php
                        $totalSkor = 0;
                        if ($d->skrining_anak) {
                          $totalSkor = @json_decode($d->skrining_anak->nutrisi, true)['skor']['total'];
                        }
                        if ($d->skrining_dewasa) {
                          $totalSkor = @json_decode($d->skrining_dewasa->nutrisi, true)['skor']['total'];
                        }
                      @endphp
                      {{$totalSkor}}
                    </td>
                    <td> {{ @$gizi['intervensi_gizi']['preskripsi_diet']['edukasi'] }} </td>
                    <td> {{ @baca_pagt($totalSkor)}}</td>
                    <td> {{ baca_carabayar($d->bayar) }}</td>
                    <td> {{ @$gizi['pengkajian']['antropometri']['dewasa']['bb_saat_ini'] ?? @$gizi['pengkajian']['antropometri']['anak']['bb_saat_ini'] }} </td>
                    <td> {{ @$gizi['pengkajian']['antropometri']['dewasa']['tinggi_badan'] ?? @$gizi['pengkajian']['antropometri']['anak']['tinggi_badan'] }} </td>
                    <td style="width: 150px;"> 
                      @if (@$gizi['pengkajian']['antropometri']['dewasa']['status_gizi'])
                        <b> Dewasa : </b>{{ @$gizi['pengkajian']['antropometri']['dewasa']['status_gizi']}}  <br>
                      @endif
                      @if (@$gizi['pengkajian']['antropometri']['anak']['status_gizi'] )
                        <b>Anak : </b> {{ @$gizi['pengkajian']['antropometri']['anak']['status_gizi'] }}  <br>
                        <b> Standar Deviasi : </b><br>
                        @if (@$gizi['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_1'])
                          <b>- BB / U : </b>{{@$gizi['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_1']}} <br>
                        @endif
                        @if (@$gizi['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_2'])
                          <b>- PB, TB / U : </b>{{@$gizi['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_2']}} <br>
                        @endif
                        @if (@$gizi['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_3'])
                          <b>- BB / PB , TB : </b>{{@$gizi['pengkajian']['antropometri']['anak']['standar_deviasi']['status_gizi_3']}} <br>
                        @endif
                      @endif

                    </td>
                    <td>{{ baca_user(@$d->pengkajian_gizi->user_id) }}</td> --}}
                  </tr>
                @endif
              @endforeach
            @endif
          </tbody>
        </table>
      </div>


    </div>
    <div class="box-footer">
    </div>
  </div>



@endsection

@section('script')
 <script>
        $(".skin-blue").addClass("sidebar-collapse");
 </script>
@endsection
