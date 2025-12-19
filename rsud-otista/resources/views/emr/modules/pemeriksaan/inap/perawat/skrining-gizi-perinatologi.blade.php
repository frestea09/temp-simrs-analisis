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
        <form method="POST" action="{{ url('emr-soap/pemeriksaan-gizi-perinatologi/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
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
                <h5 class="text-center"><b>SKRINING NUTRISI PERINATOLOGI</b></h5>
                <table style="width: 100%;" class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
                    <tr>
                        <td colspan="2" style="width: 50%;">Tanggal Lahir</td>
                        <td>
                            <input type="date" class="form-control" placeholder="gram" name="fisik[skrining_gizi_neonatus][tanggal_lahir]" value="{{ @$skrining['tanggal_lahir'] }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%; font-weight: bold;">1. Penilaian Pertumbuhan</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Berat badan saat ini</td>
                        <td>
                            <input type="text" class="form-control" placeholder="Berat badan saat ini" name="fisik[skrining_gizi_neonatus][bb_saat_ini]" value="{{ @$skrining['bb_saat_ini'] }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Lingkar kepala</td>
                        <td>
                            <input type="text" class="form-control" placeholder="Lingkar kepala" name="fisik[skrining_gizi_neonatus][lingkar_kepala]" value="{{ @$skrining['lingkar_kepala'] }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Panjang badan</td>
                        <td>
                            <input type="text" class="form-control" placeholder="Panjang badan" name="fisik[skrining_gizi_neonatus][panjang_badan]" value="{{ @$skrining['panjang_badan'] }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Berat badan lahir</td>
                        <td>
                            <input type="text" class="form-control" placeholder="Berat badan lahir" name="fisik[skrining_gizi_neonatus][berat_badan_lahir]" value="{{ @$skrining['berat_badan_lahir'] }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Lingkar kepala lahir</td>
                        <td>
                            <input type="text" class="form-control" placeholder="Lingkar kepala lahir" name="fisik[skrining_gizi_neonatus][lingkar_kepala_lahir]" value="{{ @$skrining['lingkar_kepala_lahir'] }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Panjang badan lahir</td>
                        <td>
                            <input type="text" class="form-control" placeholder="Panjang badan lahir" name="fisik[skrining_gizi_neonatus][panjang_badan_lahir]" value="{{ @$skrining['panjang_badan_lahir'] }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%; font-weight: bold;">2. Ketentuan Golongan Risiko</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Risiko Tinggi</td>
                        <td>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_tinggi]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_tinggi'] == 'Prematur usia < 28 minggu' ? 'checked' : '' }}
                                    type="radio" value="Prematur usia < 28 minggu">
                                <label class="form-check-label">Prematur usia < 28 minggu</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_tinggi]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_tinggi'] == 'Berat badan lahir sangat rendah < 1000 g' ? 'checked' : '' }}
                                    type="radio" value="Berat badan lahir sangat rendah < 1000 g">
                                <label class="form-check-label">Berat badan lahir sangat rendah < 1000 g</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_tinggi]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_tinggi'] == 'Bayi yang mengalami NEC setelah mendapat makanan' ? 'checked' : '' }}
                                    type="radio" value="Bayi yang mengalami NEC setelah mendapat makanan">
                                <label class="form-check-label">Bayi yang mengalami NEC setelah mendapat makanan</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_tinggi]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_tinggi'] == 'Atau bayi yang mengalami gastroinstestinal perforasi' ? 'checked' : '' }}
                                    type="radio" value="Atau bayi yang mengalami gastroinstestinal perforasi">
                                <label class="form-check-label">Atau bayi yang mengalami gastroinstestinal perforasi</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_tinggi]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_tinggi'] == 'Bayi yang mengalami mailformasi gastrointestinal kongenital yang berat (misal : gastroschisis)' ? 'checked' : '' }}
                                    type="radio" value="Bayi yang mengalami mailformasi gastrointestinal kongenital yang berat (misal : gastroschisis)">
                                <label class="form-check-label">Bayi yang mengalami mailformasi gastrointestinal kongenital yang berat (misal : gastroschisis)</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Risiko Sedang</td>
                        <td>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_sedang]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_sedang'] == 'Prematur 28-31 minggu, dengan kondisi baik' ? 'checked' : '' }}
                                    type="radio" value="Prematur 28-31 minggu, dengan kondisi baik">
                                <label class="form-check-label">Prematur 28-31 minggu, dengan kondisi baik</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_sedang]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_sedang'] == 'IUGR (berat < 9 persentile)' ? 'checked' : '' }}
                                    type="radio" value="IUGR (berat < 9 persentile)">
                                <label class="form-check-label">IUGR (berat < 9 persentile)</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_sedang]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_sedang'] == 'Berat badan lahir sangat rendah 1000 - 1500 g' ? 'checked' : '' }}
                                    type="radio" value="Berat badan lahir sangat rendah 1000 - 1500 g">
                                <label class="form-check-label">Berat badan lahir sangat rendah 1000 - 1500 g</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_sedang]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_sedang'] == 'Penyakit atau kelainan kongenital yang tidak mengalami gangguan makan' ? 'checked' : '' }}
                                    type="radio" value="Penyakit atau kelainan kongenital yang tidak mengalami gangguan makan">
                                <label class="form-check-label">Penyakit atau kelainan kongenital yang tidak mengalami gangguan makan</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Risiko Rendah</td>
                        <td>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_rendah]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_rendah'] == 'Prematur 32 - 36 minggu, dengan kondisi baik' ? 'checked' : '' }}
                                    type="radio" value="Prematur 32 - 36 minggu, dengan kondisi baik">
                                <label class="form-check-label">Prematur 32 - 36 minggu, dengan kondisi baik</label>
                            </div>
                            <div>
                                <input class="form-check-input"
                                    name="fisik[skrining_gizi_neonatus][ketentuan_golongan_risiko][risiko_rendah]"
                                    {{ @$skrining['ketentuan_golongan_risiko']['risiko_rendah'] == 'Bayi > 37 minggu dengan kondisi baik' ? 'checked' : '' }}
                                    type="radio" value="Bayi > 37 minggu dengan kondisi baik">
                                <label class="form-check-label">Bayi > 37 minggu dengan kondisi baik</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="width: 50%; font-weight: bold;">2. Ketentuan Intervensi Dukungan Tim Nutrisi</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            Dukungan tim nutrisi pada bayi diberikan berdasarkan kriteria berikut :
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <table style="width: 100%; border: 1px solid black;" class="table table-striped table-hover table-condensed form-box" style="font-size:12px;">
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                        Bayi yang termasuk golongan risiko tinggi
                                    </td>
                                    <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                        <input type="text" name="fisik[skrining_gizi_neonatus][ketentuan_intervensi][param1][detail]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$skrining['ketentuan_intervensi']['param1']['detail']}}">
                                    </td>
                                </tr>
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                        Berat badan lahir tidak kembali dalam 2 minggu usia kelahiran
                                    </td>
                                    <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                        <input type="text" name="fisik[skrining_gizi_neonatus][ketentuan_intervensi][param2][detail]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$skrining['ketentuan_intervensi']['param2']['detail']}}">
                                    </td>
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                        Penurunan berat badan > 15 %
                                    </td>
                                    <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                        <input type="text" name="fisik[skrining_gizi_neonatus][ketentuan_intervensi][param3][detail]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$skrining['ketentuan_intervensi']['param3']['detail']}}">
                                    </td>
                                </tr>
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                        Penambahan berat badan < 10 g/kg/hari selama 2 minggu
                                    </td>
                                    <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                        <input type="text" name="fisik[skrining_gizi_neonatus][ketentuan_intervensi][param4][detail]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$skrining['ketentuan_intervensi']['param4']['detail']}}">
                                    </td>
                                </tr>
                                <tr style="border: 1px solid black;">
                                    <td style="border: 1px solid black; width: 10%; vertical-align: middle;" class="text-center">
                                        NEC atau operasi gastrointestinal
                                    </td>
                                    <td style="border: 1px solid black; width: 10%;  vertical-align: middle;" class="text-center">
                                        <input type="text" name="fisik[skrining_gizi_neonatus][ketentuan_intervensi][param5][detail]" style="display:inline-block; width: 100%;" class="form-control" id="" value="{{@$skrining['ketentuan_intervensi']['param5']['detail']}}">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:50%; font-weight:bold;">
                            Diverifikasi oleh       
                        </td>
                        <td colspan="2">
                            <input type="text" name="fisik[skrining_gizi_neonatus][verifikasi][nama]" class="form-control" value="{{ @Auth::user()->name }}" readonly>
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
                    <h5><b>Riwayat Skrining Gizi Perinatologi</b></h5>
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
                                              $data = json_decode($item->fisik, true)['skrining_gizi_neonatus'];
                                          @endphp
                                          <tr>
                                            <td>
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
    }
  </script>
@endsection
