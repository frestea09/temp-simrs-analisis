

@extends('master')

@section('header')
  <h1>SOAP</h1>
@endsection
<style>
  .new{
    background-color:#e4ffe4;
  }
</style>
@section('content')
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
                   
                    <br>
                    
                    <div class="col-md-12">
                        <form class="form-horizontal" method="post" action="{{ url('tindakan/poli-ordered') }}">
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('unit', $unit) !!}
                            <div class="modal-header">
                                <h4 class="modal-title">ORDER POLI</h4>
                            </div>
                            <div class="modal-body">
                                <div class='table-responsive'>
                                    <table class='table table-striped table-bordered table-hover table-condensed'>
                                        <tbody>
                                            <tr><th>No. RM</th> <td>{{ $pasien->no_rm }}</td></tr>
                                            <tr><th>Nama</th> <td>{{ $pasien->nama }}</td></tr>
                                            <tr><th>Alamat</th> <td>{{ $pasien->alamat }}</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{ csrf_field() }} {{ method_field('POST') }}
                                {!! Form::hidden('registrasi_id', $registrasi_id) !!}
                                {!! Form::hidden('pasien_id', $pasien->id) !!}
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Poli Tujuan</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="poli_id" style="width: 100%">
                                            @foreach ($poli as $p)
                                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Dokter DPJP</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="dokter_id" style="width: 100%">
                                            @foreach ($dokter as $d)
                                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <script>$('.select2').select2();</script>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Order</button>
                            </div>
                        </form>
                    </div>
                    <br/><br/> 
                </form>
                <hr/> 
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
