@extends('master')

<style>
    .form-box td,
    select,
    input,
    textarea {
        font-size: 12px !important;
    }

    .history-family input[type=text] {
        height: 20px !important;
        padding: 0px !important;
    }

    .history-family-2 td {
        padding: 1px !important;
    }
</style>
@section('header')
    <h1>Assesment</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
        </h3>
    </div>
    <div class="box-body">
      <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
        @include('emr.modules.addons.profile')
        <form method="POST" action="{{ url('emr-soap/pemeriksaan-gizi-anak/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-12">
                @include('emr.modules.addons.tab-gizi')
                {{ csrf_field() }}
                {!! Form::hidden('registrasi_id', $reg->id) !!}
                {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                {!! Form::hidden('unit', $unit) !!}
                {!! Form::hidden('asessment_id', @$riwayat->id) !!}
              </div>
              <br>
              <div class="col-md-6">
                <h5 class="text-center"><b>SKRINING NUTRISI ANAK</b></h5>
                <table style="width: 100%" class="table-striped table-bordered table-hover table-condensed form-box table" style="font-size:12px;">
                  <tr>
                    <td colspan="2">SKRINING GIZI ANAK (USIA 1 BULAN - 14 TAHUN)</td>
                  </tr>
    
                  <tr>
                    <td style="width: 50%; font-weight:bold">BB</td>
                    <td>
                      <input type="text" class="form-control" name="nutrisi[bb][detail]" style="width: 100%" placeholder="BB" value="{{ @$nutrisi['bb']['detail'] }}">
                    </td>
                  </tr>
                  {{-- {{dd($assesment->id)}} --}}
                  <tr>
                    <td style="width: 50%; font-weight:bold">TB</td>
                    <td>
                      <input type="text" class="form-control" name="nutrisi[tb][detail]" style="width: 100%" placeholder="TB" value="{{ @$nutrisi['tb']['detail'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 50%; font-weight:bold">Usia</td>
                    <td>
                      <input type="text" class="form-control" name="nutrisi[usia][detail]" style="width: 100%" placeholder="Usia" value="{{ @$nutrisi['usia']['detail'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="3" style="width: 50%; font-weight:bold">Skrining</td>
                    <td>
                      <b>BB/U</b>
                      <input type="text" class="form-control" name="nutrisi[skrining][bb/u]" style="width: 100%" placeholder="BB/U" value="{{ @$nutrisi['skrining']['bb/u'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <b>TB/U</b>
                      <input type="text" class="form-control" name="nutrisi[skrining][tb/u]" style="width: 100%" placeholder="TB/U" value="{{ @$nutrisi['skrining']['tb/u'] }}">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <b>BB/TB</b>
                      <input type="text" class="form-control" name="nutrisi[skrining][bb/tb]" style="width: 100%" placeholder="BB/TB" value="{{ @$nutrisi['skrining']['bb/tb'] }}">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:50%; font-weight:bold;">
                        1. Apakah pasien tampak kurus ?
                        <ul>
                          <li>Ya => 1</li>
                          <li>Tidak => 0</li>
                        </ul>
                    </td>
                    <td>
                        <input type="text" class="form-control skorSkrining" name="nutrisi[skor][1]" style="width: 100%" placeholder="1" value="{{ @$nutrisi['skor']['1'] }}" onblur="totalSkor()">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:50%; font-weight:bold;">
                        2. Apakah terdapat penurunan berat badan selama satu bulan terakhir ? <br>
                        {* Untuk bayi < dari 1 tahun, apakah berat badan tidak naik selama 3 bulan terakhir ?
                        <ul>
                            <li>Ya => 1</li>
                            <li>Tidak => 0</li>
                        </ul>
                    </td>
                    <td>
                        <input type="text" class="form-control skorSkrining" name="nutrisi[skor][2]" style="width: 100%" placeholder="0" value="{{ @$nutrisi['skor']['2'] }}" onblur="totalSkor()">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:50%; font-weight:bold;">
                        3. Apakah asupan makan berkurang selama 1 minggu terakhir ?
                        <ul>
                            <li>Ya => 1</li>
                            <li>Tidak => 0</li>
                        </ul>
                    </td>
                    <td>
                        <input type="text" class="form-control skorSkrining" name="nutrisi[skor][3]" style="width: 100%" placeholder="1" value="{{ @$nutrisi['skor']['3'] }}" onblur="totalSkor()">
                    </td>
                  </tr>
    
                  <tr>
                    <td style="width:50%; font-weight:bold;">
                      4. Apakah terdapat penyakit atau keadaan yang mengakibatkan pasien berisiko mengalami malnutrisi ?
                      <ul>
                          <li>Ya => 2</li>
                          <li>Tidak => 0</li>
                      </ul>
                    </td>
                    <td>
                      <input type="text" class="form-control skorSkrining" name="nutrisi[skor][4]" style="width: 100%" placeholder="2" value="{{ @$nutrisi['skor']['4'] }}" onblur="totalSkor()">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%; font-weight:bold;">Total Skor</td>
                    <td>
                      <input type="text" class="form-control" name="nutrisi[skor][total]" id="totalSkorId" value="{{ @$nutrisi['skor']['total'] }}" style="width: 100%">
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%; font-weight:bold;">Kesimpulan dan tindak lanjut</td>
                    <td>
                      <input type="text" class="form-control" name="nutrisi[skor][kesimpulan]" id="kesimpulanSkorId" value="{{ @$nutrisi['skor']['kesimpulan'] }}" style="width: 100%">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">Keterangan</td>
                  </tr>
                  <tr>
                    <td style="width:50%; font-weight:bold;" colspan="2">
                      <ul style="font-weight: normal">
                          <li>
                            Total skor 2 : Risiko malnutrisi.
                          </li>
                          <li>
                            Malnutrisi yang dimaksud dalam hal ini adalah kurang gizi.
                          </li>
                          <li>
                            Penyakit atau keadaan yang mengakibatkan pasien berisiko mengalami malnutrisi.
                            <ul style="list-style-type: none">
                              <li>- Diare kronik (Lebih dari 2 minggu)</li>
                              <li>- (tersangka) penyakit jantung bawaan</li>
                              <li>- (tersangka) infeksi HIV</li>
                              <li>- (tersangka) kanker</li>
                              <li>- Penyakit hati kronik</li>
                              <li>- Penyakit ginjal kronik</li>
                              <li>- TB Paru</li>
                              <li>- Trauma</li>
                              <li>- Luka Bakar luas</li>
                              <li>- Kelainan anatomi mulut yang mengakibatkan kelainan makan</li>
                              <li>- Retardasi mental</li>
                              <li>- Keterlambatan perkembangan</li>
                              <li>- Demam berdarah pada anak</li>
                              <li>- Lain-lain berdasarkan pertimbangan dokter</li>
                            </ul>
                          </li>
                      </ul>
                    </td>
                  </tr>
                  @if (@$cppt)
                    @if ($cppt->user->Pegawai->kategori_pegawai == 1)
                        {{-- @if ($cppt->assesment) --}}
                          <tr>
                            <td style="width:50%; font-weight:bold;">
                              Diagnosa
                            </td>
                            <td>
                              {!! @$cppt->assesment !!}
                            </td>
                          </tr>
                     @endif

                  @if (@$cppt->diagnosistambahan)
                  <tr>
                    <td style="width:50%; font-weight:bold;">
                      Diagnosa Tambahan
                    </td>
                    <td>
                      {!! @$cppt->diagnosistambahan !!}
                    </td>
                  </tr>
                      
                  @endif
                @endif
                  <tr>
                    <td style="width:50%; font-weight:bold;">
                      Diverifikasi oleh       
                    </td>
                    <td>
                      <input type="text" name="nutrisi[verifikasi][nama]" class="form-control" value="{{ @Auth::user()->name }}" readonly>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:50%; font-weight:bold;">
                      Dibuat oleh       
                    </td>
                    <td>
                      <select name="user_id" class="select2" style="width: 100%;">
                        @if (@$assesment && !in_array(@$assesment->user_id, [898, 905, 900, 907, 902, 904, 918, 903, 919]))
                          <option value="{{@$assesment->user_id}}" selected>{{@$assesment->user->name}}</option>
                        @endif
                        <option value="898" {{@$assesment->user_id == 898}}>{{baca_user(898)}}</option>
                        <option value="905" {{@$assesment->user_id == 905}}>{{baca_user(905)}}</option>
                        <option value="900" {{@$assesment->user_id == 900}}>{{baca_user(900)}}</option>
                        <option value="907" {{@$assesment->user_id == 907}}>{{baca_user(907)}}</option>
                        <option value="902" {{@$assesment->user_id == 902}}>{{baca_user(902)}}</option>
                        <option value="904" {{@$assesment->user_id == 904}}>{{baca_user(904)}}</option>
                        <option value="918" {{@$assesment->user_id == 918}}>{{baca_user(918)}}</option>
                        <option value="903" {{@$assesment->user_id == 903}}>{{baca_user(903)}}</option>
                        <option value="919" {{@$assesment->user_id == 919}}>{{baca_user(919)}}</option>
                      </select>
                    </td>
                  </tr>
                </table>
                @if (@$nutrisiId != 'Y')
                <div class="col-md-12 text-right">
                    <button class="btn btn-success" type="button" onclick="alert('Mohon pilih data skrining yang akan diverifikasi terlebuh dahulu!')">Verifikasi</button>
                </div>
                @else
                <div class="col-md-12 text-right">
                    <button class="btn btn-success">Verifikasi</button>
                </div>
                @endif
              </div>
              <div class="col-md-6">
                <div class="box box-solid box-warning">
                  <div class="box-header">
                    <h5><b>Riwayat Skrining Gizi Anak</b></h5>
                  </div>
                              <div class="box-body table-responsive" style="max-height: 400px">
                                  <table style="width: 100%"
                                      class="table-striped table-bordered table-hover table-condensed form-box bordered table"
                                      style="font-size:12px;">
                                      @if (count($riwayats) == 0)
                                          <tr>
                                              <td><i>Belum ada catatan</i></td>
                                          </tr>
                                      @endif
                                      @foreach ($riwayats as $item)
                                          @php
                                              $data = json_decode($item->nutrisi, true);
                                          @endphp
                                          <tr>
                                            <td>
                                              <b>BB :</b> {{@$data['bb']['detail']}} Kg<br />
                                              <b>Total Skor :</b> {{@$data['skor']['total']}}<br />
                                              <b>Kesimpulan :</b> {{@$data['skor']['kesimpulan']}}<br />
                                              <b>Dibuat oleh:</b> {{ @$item->user->name }}<br />
                                              @if (@$data['verifikasi']['nama'])
                                              <b>Diverifikasi oleh:</b> {{ @$data['verifikasi']['nama'] }}<br />
                                              @endif
                                              <span class="pull-right">
                                                  @if (@$data['verifikasi']['nama'])
                                                      <small class="text-success">Telah Diverifikasi</small>
                                                  @else
                                                      <a href="{{ URL::current() . '?asessment_id='. $item->id }}" class="label label-success">Verifikasi</a>
                                                  @endif
                                                  <small>{{ date('d-m-Y, H:i:s', strtotime($item->created_at)) }}</small>
                                              </span>
                                            </td>
                                          </tr>
                                      @endforeach
                                  </table>
                              </div>
                          </div>
                      </div>

                      <br /><br />
                  </div>


              </div>
          </form>
          <br />
          <br />

  </div>
@endsection

@section('script')
  <script type="text/javascript">
      $('.select2').select2();

    function totalSkor(){
      var arr = document.getElementsByClassName('skorSkrining');
      var tot=0;
      for(var i=0;i<arr.length;i++){
          if(parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('totalSkorId').value = tot;
      
      if (tot > 3) {
        document.getElementById('kesimpulanSkorId').value = 'Rujuk ke dokter Spesialis Gizi Klinik';
      } else if (tot < 2) {
        document.getElementById('kesimpulanSkorId').value = 'Skrining ulang 7 hari';
      } else if (tot <= 3) {
        document.getElementById('kesimpulanSkorId').value = 'Rujuk ke dietisien';
      }
    }
  </script>
@endsection
