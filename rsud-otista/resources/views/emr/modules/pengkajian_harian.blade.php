@extends('master')

@section('header')
  <h1>Pengkajian Harian</h1>
@endsection
<style>
  .new{
    background-color:#e4ffe4;
  }
</style>
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
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script> 
        @include('emr.modules.addons.profile')
        <div class="row">
            <div class="col-md-12">
             @include('emr.modules.addons.tabs')
                @if (!$emr)
                  <form method="POST" action="{{ url('save-emr-pengkajian-harian') }}" class="form-horizontal">
                @else
                  <form method="POST" action="{{ url('update-emr-pengkajian-harian') }}" class="form-horizontal">
                  {!! Form::hidden('emr_id', $emr->id) !!}
                @endif
                    {{ csrf_field() }}
                    {!! Form::hidden('registrasi_id', $reg->id) !!}
                    {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                    {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                    {!! Form::hidden('unit', $unit) !!}
                    <br>
                    {{-- List soap --}}
                    <div class="col-md-4">  
                      <div class="table-responsive" style="max-height: 400px !important;border:1px solid blue">
                        <table class="table table-bordered" id="data" style="font-size: 12px;">
                             
                            <tbody>
                              @if (count($all_resume) == 0)
                                  <tr>
                                    <td>Tidak ada record</td>
                                  </tr>
                              @endif
                                @foreach( $all_resume as $key_a => $val_a )
                                
                                <tr style="background-color:#aeef9a">
                                  {{-- <th>{{@$val_a->registrasi->reg_id}}</th> --}}
                                  <th>PENGINPUT :</th>
                                  <th>{{baca_user($val_a->user_id)}}</th>
                                </tr>
                                <tr style="background-color:#aeef9a">
                                  <th>WAKTU :</th>
                                  <th>{{$val_a->created_at ? @date('d-m-Y, H:i A',strtotime($val_a->created_at)) : @date('d-m-Y, H:i A',strtotime($val_a->registrasi->created_at))}}</th>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Tekanan Darah:</b> {!! $val_a->tekanandarah !!}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Nadi:</b> {!! $val_a->nadi !!}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>F. Nafas:</b> {!! $val_a->frekuensi_nafas !!}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Suhu:</b> {!! $val_a->suhu !!}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Suhu:</b> {!! $val_a->skala_nyeri !!}</td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="text-right" style="font-size:15px;">
                                    {{-- <a href="" data-toggle="tooltip" title="Cetak"><i class="fa fa-print text-danger"></i></a>&nbsp;&nbsp; --}}
                                    <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('/delete-emr-pengkajian-harian/'.$val_a->id)}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp;
                                    <a href="{{url('/emr/duplicate-pengkajian-harian/'.$val_a->id.'/'.$reg->id)}}" onclick="return confirm('Yakin akan menduplikat data?')" data-toggle="tooltip" title="Duplikat"><i class="fa fa-copy"></i></a>&nbsp;&nbsp;
                                    <a href="{{url('/emr/pengkajian-harian/'.$unit.'/'.$reg->id.'/'.$val_a->id.'/edit?poli='.$poli.'&dpjp='.$dpjp)}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp;
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                      </div>
                    </div>
                    
                    {{-- Soap Input --}}
                      <div class="col-md-8">  
                        <table style="width: 100%" style="font-size:12px;"> 
                          {{-- <tr>
                            <td style="width:200px;"><b>Dokter</b></td>
                            <td style="padding: 5px;">
                              {!! Form::select('dokter_id', $dokter,@$emr->dokter_id ? @$emr->dokter_id : @$reg->dokter_id, ['class' => 'chosen-select', 'placeholder'=>'','readonly'=>true]) !!}
                              
                            </td>
                        </tr> --}}
                        <tr>
                          <td><b>Tanggal</b></td>
                          <td style="padding: 5px;">
                            <input type="date" name="tanggal" class="form-control" value="{{@$emr->tanggal ? @$emr->tanggal : date('Y-m-d')}}">
                          </td>
                        </tr>
                          <tr>
                              <td style="width:200px;"><b>Nadi </b><i style="color:green">(x/menit)</i></td>
                              <td style="padding: 5px;">
                                <input type="text" name="nadi" class="form-control" value="{{$emr ? $emr->nadi : ''}}">
                              </td> 
                          </tr>
                          <tr>
                              <td><b>Tekanan Darah </b><i style="color:blue">(mmHG)</i></td>
                              <td style="padding: 5px;">
                                <input type="text" name="tekanan_darah" class="form-control" value="{{$emr ? $emr->tekanandarah : ''}}">
                              </td> 
                          </tr>
                          <tr>
                            <td><b>Frekuensi Nafas </b><i style="color:rebeccapurple">(x/menit)</i></td>
                              <td style="padding: 5px;">
                                <input type="text" name="frekuensi_nafas" class="form-control" value="{{$emr ? $emr->frekuensi_nafas : ''}}">
                              </td> 
                          </tr>
                          <tr>
                            <td><b>Suhu </b><i style="color:rebeccapurple">(°C)</i></td>
                              <td style="padding: 5px;">
                                <input type="text" name="suhu" class="form-control" value="{{$emr ? $emr->suhu : ''}}">
                              </td> 
                          </tr>
                          <tr>
                            <td><b>Berat Badan </b><i style="color:rebeccapurple"></i></td>
                              <td style="padding: 5px;">
                                <input type="text" name="berat_badan" class="form-control" value="{{$emr ? $emr->berat_badan : ''}}">
                              </td> 
                          </tr>
                          <tr>
                            <td><b>Skala Nyeri </b></td>
                              <td style="padding: 5px;">
                                <input type="text" name="skala_nyeri" class="form-control" value="{{$emr ? $emr->skala_nyeri : ''}}">
                              </td> 
                          </tr>
                          <tr>
                            <td>
                              {{-- <div class="form-group text-center"> --}}
                                <button type="submit" class="btn btn-primary btn-flat">SIMPAN</button>
                              {{-- </div> --}}
                            </td>
                          </tr>
                        </table>
                      </div>
                      
                      
                    <br/><br/> 
                </form>
                <hr/>
                <form method="POST" action="{{ url('frontoffice/simpan_diagnosa_rawatinap') }}" class="form-horizontal">
                  {{ csrf_field() }}
                  {!! Form::hidden('registrasi_id', $reg->id) !!}
                  {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                  {!! Form::hidden('cara_bayar', $reg->bayar) !!} 
                  {!! Form::hidden('unit', $unit) !!}
                </form> 
            </div>
        </div>
    </div>
  </div>  

@endsection

@section('script')

    <script type="text/javascript">
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
