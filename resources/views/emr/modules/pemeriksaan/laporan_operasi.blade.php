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

  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }

  input[type="date"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}
input[type="time"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}
</style>
@section('header')
<h1>Upload Laporan Operasi</h1>
@endsection

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
    <form method="POST" action="{{ url('emr-soap/pemeriksaan/upload-laporan-operasi/'.$unit.'/'.$reg->id) }}" class="form-horizontal" enctype="multipart/form-data">
      <div class="row">
        @include('emr.modules.addons.tab-operasi')
        <div class="col-md-12">
          {{ csrf_field() }}
          {!! Form::hidden('registrasi_id', $reg->id) !!}
          {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
          {!! Form::hidden('cara_bayar', $reg->bayar) !!}
          {!! Form::hidden('dokter_id', $reg->dokter_id) !!}
          <br>
          <h4 class="text-center"><b>Upload Laporan Operasi</b></h4>
          <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('penanggungjawab') ? ' has-error' : '' }}">
                    {!! Form::label('penanggungjawab', 'Penanggung Jawab', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::select('penanggungjawab', $dokter, null, ['class' => 'chosen-select']) !!}
                        <small class="text-danger">{{ $errors->first('penanggungjawab') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('tgl_pemeriksaan') ? ' has-error' : '' }}">
                    {!! Form::label('tglpemeriksaan', 'Tgl Pemeriksaan', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        <input type="datetime-local" name="tgl_pemeriksaan" class="form-control" value="{{date('Y-m-d H:i')}}">
                        <small class="text-danger">{{ $errors->first('tgl_pemeriksaan') }}</small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                    {!! Form::label('file', 'Upload File', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        <input type="file" name="file" class="form-control">
                        <small class="text-danger">{{ $errors->first('file') }}</small>
                    </div>
                </div>
                <button class="btn btn-md btn-flat btn-success pull-right">SIMPAN</button>
            </div>

            {{-- @endif --}}

           
            {!! Form::close() !!}

          </div>
 
          <br /><br />
        </div>
      </div>
    </form>

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Laporan Operasi</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class='table-responsive'>
                    <table class='table-striped table-bordered table-hover table-condensed table'>
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th >Penanggung Jawab</th>
                                <th >Tgl Pemeriksaan</th>
                                <th >Laporan Operasi</th>
                                <th >User</th>
                                <th >Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($hasilPemeriksaan as $hasil)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$hasil->pegawai->nama}}</td>
                                    <td>{{date('d-m-Y H:i',strtotime($hasil->tgl_pemeriksaan))}}</td>
                                    <td><a href="/hasil-pemeriksaan/{{$hasil->filename}}" target="_blank" class="btn btn-info"><i class="fa fa-eye"> Lihat</i></a></td>
                                    <td>{{baca_user($hasil->user_id)}}</td>
                                    <td><a href="/emr-hasil-pemeriksaan/hapus-hasil-pemeriksaan/{{$hasil->id}}" class="btn btn-flat btn-danger" onclick="return confirm('Yakin akan hapus laporan operasi?')"><i class="fa fa-trash"> Hapus</i></a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="7">Tidak Ada Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
    });
    $('.select2').select2();
    $("#date_tanpa_tanggal").datepicker( {
        format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months"
    });
    $("#date_dengan_tanggal").attr('', true);
  </script>
  @endsection