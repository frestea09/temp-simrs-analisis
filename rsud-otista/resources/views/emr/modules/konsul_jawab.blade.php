@extends('master')

@section('header')
  <h1>JAWAB KONSUL DOKTER</h1>
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
                  <form method="POST" action="{{ url('emr-jawabkonsul-rawatinap') }}" class="form-horizontal">
                @else
                  <form method="POST" action="{{ url('emr-update-jawabkonsul-rawatinap') }}" class="form-horizontal">
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
                        <table class="table table-bordered" id="data" style="font-size: 12px;margin-top:0px !important">
                             
                            <tbody style="font-size:11px;">
                              @if (count($all_resume) == 0)
                                  <tr>
                                    <td>Tidak ada record</td>
                                  </tr>
                              @endif
                                @foreach( $all_resume as $key_a => $val_a )
                                
                                <tr class="bg-primary" style="font-size:11px;">
                                  <th>Dokter Pengirim</th>
                                  <th>{{baca_dokter($val_a->dokter_pengirim)}}</th>
                                </tr>
                                <tr class="bg-primary" style="font-size:11px;">
                                  <th>Dokter Penjawab</th>
                                  <th>{{baca_dokter($val_a->dokter_penjawab)}}</th>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Jawab Konsul:</b> {!! $val_a->jawab_konsul !!}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Anjuran:</b> {!! $val_a->anjuran !!}</td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="text-right">
                                    {{-- <span class="text-right"> --}}
                                    <div class="text-left" style="float: left;display:inline-block">
                                      {{valid_date($val_a->tanggal)}}
                                      {{$val_a->waktu}}
                                    </div>
                                    <div class="text-right">
                                      <a href="{{url('/emr-jawabkonsul-rawatinap/'.$reg->id.'/'.$val_a->id.'/edit')}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp;
                                    </div>
                                    
                                    {{-- <a href="" data-toggle="tooltip" title="Cetak"><i class="fa fa-print text-danger"></i></a>&nbsp;&nbsp; --}}
                                    {{-- <a onclick="return confirm('Yakin akan menghapus data?')" href="{{url('/emr/delete-soap/'.$val_a->id)}}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash text-danger"></i></a>&nbsp;&nbsp; --}}
                                    {{-- <a href="{{url('/emr/duplicate-soap/'.$val_a->id)}}" onclick="return confirm('Yakin akan menduplikat data?')" data-toggle="tooltip" title="Duplikat"><i class="fa fa-copy"></i></a>&nbsp;&nbsp; --}}
                                    {{-- </span> --}}
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
                          <tr>
                            <td><b>Tanggal dan Jam</b></td>
                            <td style="padding: 5px;">
                              <div class="row">
                                <div class="col-md-6"><input type="date" name="tanggal" class="form-control" value="{{@$emr->tanggal ? @$emr->tanggal : date('Y-m-d') }}"></div>
                                <div class="col-md-6"><input type="time" name="waktu" class="form-control" value="{{@$emr->waktu ? @$emr->waktu : date('H:i')}}"></div>
                              </div>
                              
                              
                            </td>
                          </tr>
                          <tr>
                            <td style="width:200px;"><b>Dokter Pengirim Konsul</b></td>
                            <td style="padding: 5px;">
                              {!! Form::select('dokter_pengirim', $dokter,@$emr->dokter_pengirim ? @$emr->dokter_pengirim : @$dpjp, ['class' => 'chosen-select', 'placeholder'=>'','readonly'=>true]) !!}
                              {{-- baca_dokter($reg->dokter_id) --}}
                            </td>
                        </tr>
                        <tr>
                          <td style="width:200px;"><b>Dokter yang Menjawab</b></td>
                          <td style="padding: 5px;">
                            {!! Form::select('dokter_penjawab', $dokter,@$emr->dokter_penjawab ? @$emr->dokter_penjawab : @$dpjp, ['class' => 'chosen-select', 'placeholder'=>'','readonly'=>true]) !!}
                            {{-- baca_dokter($reg->dokter_id) --}}
                          </td>
                      </tr> 
                          {{-- <tr>
                              <td style="width:50px;"><b>Jawab Konsul</b></td>
                              <td style="padding: 5px;">
                                  <textarea rows="5" class="form-control ckeditor" name="jawab_konsul" required>{{$emr ? $emr->subject : ''}}</textarea>
                              </td> 
                          </tr> --}}
                          <tr>
                              <td><b>Jawab Konsul</b></td>
                              <td style="padding: 5px;">
                                  <textarea rows="5" class="form-control ckeditor" name="jawab_konsul" required>{{$emr ? $emr->jawab_konsul : ''}}</textarea>
                              </td> 
                          </tr> 
                          <tr>
                              <td><b>Anjuran</b></td>
                              <td style="padding: 5px;">
                                  <textarea rows="5" class="form-control ckeditor" name="anjuran" required>{{$emr ? $emr->anjuran : ''}}</textarea>
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
        CKEDITOR.replaceAll( 'ckeditor', {
                height: 200,
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
            })
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
