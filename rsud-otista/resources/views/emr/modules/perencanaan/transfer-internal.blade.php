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
<h1>Visum</h1>
@endsection

@section('content')
@php

  $poli = request()->get('poli');
  $dpjp = request()->get('dpjp');
@endphp
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
    <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">

    @include('emr.modules.addons.profile')
    <form method="POST" action="{{ url('emr-soap/perencanaan/catatan-transfer-internal/'.$unit.'/'.$reg->id) }}" class="form-horizontal">
      <div class="row">
        <div class="col-md-12">
          @include('emr.modules.addons.tabs')
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('unit', $unit) !!}
          {!! Form::hidden('poli', $poli) !!}
          {!! Form::hidden('dpjp', $dpjp) !!}
          <br>
          <br>
          <br>

          {{-- Anamnesis --}}
          <div class="col-md-6">
            <h5><b>Catatan Transfer Internal</b></h5>
            <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
              style="font-size:12px;">
              <tr>
                <td style="width:20%;">Ruang Asal</td>
                <td style="padding: 5px;">
                  <label for="" style="margin-right: 10px;">
                    <input type="radio" name="keterangan[ruangAsal][pilihan]" id="" class="form-check-input" value="IGD" {{ @$transferInternal['ruangAsal']['pilihan'] == 'IGD' ? 'checked' : '' }}>
                    IGD
                  </label>
                  <label for="" style="margin-right: 10px;">
                    <input type="radio" name="keterangan[ruangAsal][pilihan]" id="" class="form-check-input" value="IGD Kebidanan" {{ @$transferInternal['ruangAsal']['pilihan'] == 'IGD Kebidanan' ? 'checked' : '' }}>
                    IGD Kebidanan
                  </label>
                  <label for="" style="margin-right: 10px;">
                    <input type="radio" name="keterangan[ruangAsal][pilihan]" id="" class="form-check-input" value="IBS" {{ @$transferInternal['ruangAsal']['pilihan'] == 'IBS' ? 'checked' : '' }}>
                    IBS
                  </label>
                  <label for="" style="margin-right: 10px;">
                    <input type="radio" name="keterangan[ruangAsal][pilihan]" id="" class="form-check-input" value="Ruangan" {{ @$transferInternal['ruangAsal']['pilihan'] == 'Ruangan' ? 'checked' : '' }}>
                    Ruangan
                  </label>
                  <input type="text" name="keterangan[ruangAsal][ket]" id="" class="form-control" style="display: inline-block;" value="{{ @$transferInternal['ruangAsal']['ket'] }}">
                </td>
              </tr>
              <tr>
                <td style="width:20%;">Pindah Ke</td>
                <td>
                  <input type="text" name="keterangan[pindahKe][ruangan]" id="" class="form-control" style="display: inline-block;" value="{{ @$transferInternal['pindahKe']['ruangan'] }}">
                  <br>
                  Tanggal
                  <br>
                  <input type="date" name="keterangan[pindahKe][tgl]" id="" class="form-control" style="display: inline-block;" value="{{ @$transferInternal['pindahKe']['tgl']  }}">
                  <br>
                  Jam
                  <br>
                  <input type="time" name="keterangan[pindahKe][waktu]" id="" class="form-control" style="display: inline-block;" value="{{ @$transferInternal['pindahKe']['waktu'] }}">
                </td>
              </tr>
              <tr>
                <td>Dokter Yang Merawat</td>
                <td>
                  <select name="keterangan[dokter]" id="" class="select2 form-control">
                    @foreach ($dokter as $data)
                      <option value="{{ $data->nama }}" {{ @$transferInternal['dokter'] == $data->nama ? 'selected' : '' }}>{{ $data->nama }}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Alasan Dirawat</td>
                <td>
                  <input type="text" name="keterangan[alasanRawat]" id="" class="form-control" style="display: inline-block;" value="{{ @$transferInternal['alasanRawat'] }}">
                </td>
              </tr>
              <tr>
                <td>Alasan Pindah</td>
                <td>
                  <input type="text" name="keterangan[alasanPindah]" id="" class="form-control" style="display: inline-block;" value="{{ @$transferInternal['alasanPindah'] }}">
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <b>SITUATION</b>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <textarea name="keterangan[situation][isi]" id="" class="form-control" style="resize: vertical;" rows="5">{{ @$transferInternal['situation']['isi'] }}</textarea>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <b>BACKGROUND</b>
                </td>
              </tr>
              <tr>
                <td style="">
                    Kesadaran
                </td>
                <td>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input" name="keterangan[background][kesadaran][composMentis]"
                            {{ @$transferInternal['background']['kesadaran']['composMentis'] == 'composMentis' ? 'checked' : '' }} type="checkbox"
                            value="composMentis">
                        <label class="form-check-label">Compos Mentis</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input" name="keterangan[background][kesadaran][apatis]"
                            {{ @$transferInternal['background']['kesadaran']['apatis'] == 'apatis' ? 'checked' : '' }} type="checkbox"
                            value="apatis">
                        <label class="form-check-label">Apatis</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input" name="keterangan[background][kesadaran][delirium]"
                            {{ @$transferInternal['background']['kesadaran']['delirium'] == 'delirium' ? 'checked' : '' }} type="checkbox"
                            value="delirium">
                        <label class="form-check-label">Delirium</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input" name="keterangan[background][kesadaran][somnolen]"
                            {{ @$transferInternal['background']['kesadaran']['somnolen'] == 'somnolen' ? 'checked' : '' }} type="checkbox"
                            value="somnolen">
                        <label class="form-check-label">Somnolen</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input" name="keterangan[background][kesadaran][soporoKoma]"
                            {{ @$transferInternal['background']['kesadaran']['soporoKoma'] == 'soporoKoma' ? 'checked' : '' }} type="checkbox"
                            value="soporoKoma">
                        <label class="form-check-label">Soporo Koma</label>
                    </div>
                    <div style="display: inline-block; padding: 5px">
                        <input class="form-check-input" name="keterangan[background][kesadaran][koma]"
                            {{ @$transferInternal['background']['kesadaran']['koma'] == 'koma' ? 'checked' : '' }} type="checkbox"
                            value="koma">
                        <label class="form-check-label">Koma</label>
                    </div>
                </td>
              </tr>
              <tr>
                <td>GCS</td>
                <td>
                  <label for="" style="margin-right: 10px;">
                    E
                    <input type="text" name="keterangan[background][gcs][e]" value="{{ @$transferInternal['background']['gcs']['e'] }}" class="form-control" style="width: 100px; display: inline-block;">
                  </label>
                  <label for="" style="margin-right: 10px;">
                    M
                    <input type="text" name="keterangan[background][gcs][m]" value="{{ @$transferInternal['background']['gcs']['m'] }}" class="form-control" style="width: 100px; display: inline-block;">
                  </label>
                  <label for="" style="margin-right: 10px;">
                    V
                    <input type="text" name="keterangan[background][gcs][v]" value="{{ @$transferInternal['background']['gcs']['v'] }}" class="form-control" style="width: 100px; display: inline-block;">
                  </label>
                </td>
              </tr>

              <tr>
                <td  style="">Tekanan Darah</td>
                <td> 
                    <input style="width: 80%; display: inline" type="text" class="form-control" name="keterangan[background][tandaVital][tekananDarah]" value="{{@$transferInternal['background']['tandaVital']['tekananDarah'] }}" > 
                    <span style="width: 20%" >mmHg</span>
                </td>
            </tr>
            <tr>
                <td  style="">Nadi</td>
                <td> 
                    <input style="width: 80%; display: inline" type="text" class="form-control" name="keterangan[background][tandaVital][frekuensiNadi]"  value="{{@$transferInternal['background']['tandaVital']['frekuensiNadi'] }}" > 
                    <span style="width: 20%" >x/Menit</span>
                </td>
            </tr>
            <tr>
                <td  style=""> Suhu </td>
                <td> 
                    <input style="width: 80%; display: inline" type="text" class="form-control" name="keterangan[background][tandaVital][suhu]"  value="{{@$transferInternal['background']['tandaVital']['suhu'] }}" >
                    <span style="width: 20%" >&deg;C</span>
                </td>
            </tr>
            <tr>
                <td  style="">Pernapasan</td>
                <td> 
                    <input style="width: 80%; display: inline" type="text" class="form-control" name="keterangan[background][tandaVital][RR]"  value="{{@$transferInternal['background']['tandaVital']['RR'] }}" > 
                    <span style="width: 20%" >x/Menit</span>
                </td>
            </tr>
            <tr>
                <td  style="">Penggunaan Oksigen</td>
                <td> 
                    <input style="width: 80%; display: inline" type="text" class="form-control" name="keterangan[background][tandaVital][penggunaanOksigen]"  value="{{@$transferInternal['background']['tandaVital']['penggunaanOksigen'] }}" > 
                    <span style="width: 20%" >L/M</span>
                </td>
            </tr>
            <tr>
                <td  style="">Cairan Parenteral</td>
                <td> 
                    <input style="width: 80%; display: inline" type="text" class="form-control" name="keterangan[background][tandaVital][cairanParenteral]"  value="{{@$transferInternal['background']['tandaVital']['cairanParenteral'] }}" > 
                    <span style="width: 20%" >ml/24</span>
                </td>
            </tr>
            <tr>
                <td  style="">Transfusi</td>
                <td> 
                    <input style="width: 80%; display: inline" type="text" class="form-control" name="keterangan[background][tandaVital][transfusi]"  value="{{@$transferInternal['background']['tandaVital']['transfusi'] }}" > 
                    <span style="width: 20%" >ml</span>
                </td>
            </tr>
            <tr>
              <td>Penggunaan Kateter</td>
              <td>
                <label for="" style="margin-right: 10px;">
                  <input type="radio" name="keterangan[background][kateter][pilihan]" id="" class="form-check-input" value="Ada" {{ @$transferInternal['background']['kateter']['pilihan'] == 'Ada' ? 'checked' : '' }}>
                  Ada
                </label>
                <label for="" style="margin-right: 10px;">
                  <input type="radio" name="keterangan[background][kateter][pilihan]" id="" class="form-check-input" value="Tidak" {{ @$transferInternal['background']['kateter']['pilihan'] == 'Tidak' ? 'checked' : '' }}>
                  Tidak
                </label>
                <br>
                Pemakaian Ke
                <input type="text" name="keterangan[background][kateter][pemakaianKe]" id="" class="form-control" style="width: 150px; display: inline-block;" value="{{ @$transferInternal['kateter']['pemakaianKe'] }}">
                <br><br>
                Tanggal
                <input type="date" name="keterangan[background][kateter][tgl]" id="" class="form-control" style="width: 150px; display: inline-block;" value="{{ @$transferInternal['kateter']['tgl']  }}">
                Jam
                <input type="time" name="keterangan[background][kateter][waktu]" id="" class="form-control" style="width: 150px; display: inline-block;" value="{{ @$transferInternal['kateter']['waktu'] }}">
              </td>
            </tr>
            <tr>
              <td colspan="2"><b>Hasil Pemeriksaan Selama Dirawat</b></td>
            </tr>
            <tr>
              <td colspan="2">
                <textarea name="keterangan[background][hasilPemeriksaan][isi]" id="" class="form-control" style="resize: vertical;" rows="5">{{ @$transferInternal['background']['hasilPemeriksaan']['isi'] }}</textarea>
              </td>
            </tr>
            <tr>
              <td colspan="2"><b>Prosedur / Tindakan Yang Sudah Dilakukan</b></td>
            </tr>
            <tr>
              <td colspan="2">
                <textarea name="keterangan[background][tindakan][isi]" id="" class="form-control" style="resize: vertical;" rows="5">{{ @$transferInternal['background']['tindakan']['isi'] }}</textarea>
              </td>
            </tr>
              
            <tr>
              <td colspan="2">
                <b>ASESSMENT</b>
              </td>
            </tr>
            <tr>
              <td  style="">Diagnosa Medis</td>
                <td> 
                    <input style="display: inline" type="text" class="form-control" name="keterangan[asessment][diagnosaMedis]"  value="{{@$transferInternal['asessment']['diagnosaMedis'] }}" > 
                </td>
            </tr>
            <tr>
              <td  style="">Diagnosa Keperawatan</td>
                <td> 
                    <input style="display: inline" type="text" class="form-control" name="keterangan[asessment][diagnosaKeperawatan]"  value="{{@$transferInternal['asessment']['diagnosaKeperawatan'] }}" > 
                </td>
            </tr>
            <tr>
              <td colspan="2">
                <b>RECOMMENDATION</b>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <textarea name="keterangan[recommendation][isi]" id="" class="form-control" style="resize: vertical;" rows="5">{{ @$transferInternal['recommendation']['isi'] }}</textarea>
              </td>
            </tr>
            </table>
          </div>

          <div class="col-md-6">
            <div class="box box-solid box-warning">
              <div class="box-header">
                <h5><b>Riwayat</b></h5>
              </div>
              <div class="box-body table-responsive" style="max-height: 400px">
                <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box bordered"
                style="font-size:12px;">
                @if (count($riwayat) == 0)
                <tr>
                  <td><i>Belum ada catatan</i></td>
                </tr>  
                @endif
                @foreach ($riwayat as $item)
                  <tr>
                    <td>
                      Ruang Asal : {{ @json_decode($item->keterangan, true)['ruangAsal']['pilihan'] }}
                      <br>
                      Pindah Ke : {{ @json_decode($item->keterangan, true)['pindahKe']['ruangan'] }}
                      <br>
                      Dokter : {{ @json_decode($item->keterangan, true)['dokter'] }}
                      <br>
                      Alasan Pindah : {{ @json_decode($item->keterangan, true)['alasanPindah'] }}
                      <br>
                      <br>
                      <span style="font-size: 8pt;">
                        <i>{{date('d-m-Y, H:i:s',strtotime($item->created_at))}} ({{ baca_user(@$item->user_id) }})</i>
                      </span>
                      {{-- <span class="pull-right">
                        <a target="_blank" href="{{url('emr-soap-print-surat-visum/'.$reg->id.'/'.$item->id)}}" data-toggle="tooltip" title="Cetak Surat"><i class="fa fa-print text-warning"></i></a>&nbsp;&nbsp;
                      </span> --}}
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
      
      <div class="col-md-12 text-right">
        <button class="btn btn-success">Simpan</button>
      </div>
    </form>
    <br/>
    <br/>
    {{-- <div class="col-md-12 text-right">
      <table class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode(ICD 9)</th>
            <th>Deskripsi</th>
            <th>Diagnosa</th>
            <th>Tanggal</th>
          </tr>
        </thead>
         <tbody>
          @foreach ($riwayat as $key=>$item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->icd9}}</td>
                <td>{{baca_icd9($item->icd9)}}</td>
                <td>{{$item->diagnosis}}</td>
                <td>{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
              </tr>
          @endforeach
         </tbody>
      </table>
    </div> --}}
    
  </div>

  @endsection

  @section('script')

  <script type="text/javascript">
  //ICD 10
  
    $(".skin-red").addClass( "sidebar-collapse" );
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);  
         
  </script>
  @endsection