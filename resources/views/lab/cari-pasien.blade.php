@extends('master')

@section('header')
  <h1>Laboratorium Hasil Lab - Cari Pasien </h1>
  <h6 class="text-right">
    - <span class="color:red !important">*</span> Menu ini hanya digunakan untuk mencari pasien yang sudah <b>Teregistrasi</b><br/>
    - Jika pasien belum diregistrasi terbaru, <b>harus diregistrasi</b> terlebih dahulu, jangan <b>dibilling</b> di registrasi yang tanggal terdahulu</h6>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4 class="box-title">
          Periode Tanggal &nbsp;
        </h4>
      </div>
      <div class="box-body">

        {!! Form::open(['method' => 'POST', 'url' => 'pemeriksaanlab/cari-pasien', 'class'=>'form-horizontal']) !!}
        <div class="row">
          <div class="col-md-4">
          <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
            <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">Nomor RM</button>
            </span>
            @if (session('no_rm'))
                
            {!! Form::text('no_rm', '', ['class' => 'form-control']) !!}
            @else
            {!! Form::text('no_rm', null, ['class' => 'form-control']) !!}
                
            @endif
          </div>
          </div>
          <div class="col-md-4">
          <div class="input-group{{ $errors->has('nama') ? ' has-error' : '' }}">
            <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('nama') ? ' has-error' : '' }}" type="button">Nama Pasien</button>
            </span>
            @if (session('nama'))
                
            {!! Form::text('nama', '', ['class' => 'form-control']) !!}
            @else
            {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                
            @endif
          </div>
          </div>
          <div class="col-md-4">
          <div class="input-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
            <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('alamat') ? ' has-error' : '' }}" type="button">Alamat Pasien</button>
            </span>
            @if (session('alamat'))
                
            {!! Form::text('alamat', '', ['class' => 'form-control']) !!}
            @else
            {!! Form::text('alamat', null, ['class' => 'form-control']) !!}
                
            @endif
          </div>
          </div>
          <br>
          <div class="col-md-4">
            <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI PASIEN">
          </div>
        </div>
          {!! Form::close() !!}
        <hr>

        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>No. RM</th>
                <th>No. Reg</th>
                <th>Dokter</th>
                <th>Poli</th>
                <th>Tanggal Registrasi</th>
                <th>Cara Bayar</th>
                {{-- <th>Input</th> --}}
                <th>Cetak LIS</th>
                <th>Cetak LIS Semua</th>
                {{-- <th>Rujukan</th> --}}
                <th>Cetak Per Jam</th>
              </tr>
            </thead>
            <tbody>
              @isset($today)
                  
          
              @foreach ($today as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ !empty($d->pasien_id) ? @$d->pasien->nama : '' }}</td>
                  <td>{{ !empty($d->pasien_id) ? @$d->pasien->no_rm : '' }}</td>
                  <td>{{ $d->reg_id }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ !empty($d->poli_id) ? @$d->poli->nama : NULL }}</td>
                  <td>{{ date('d-m-Y',  strtotime($d->created_at))}}</td>
                  <td>{{ baca_carabayar($d->bayar) }}</td>
                  {{-- <td><a href="{{ url('pemeriksaanlab/create/'.$d->id) }}" target="_blank" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a></td> --}}
                  <td>
                    @if (cek_hasil_lab($d->id) >= 1)
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-danger">Cetak</button>
                      <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                        @foreach (cek_hasil_lis($d->id) as $item)
                          <a href="{{url('cetak-lis-pdf/'.$item->no_lab.'/'.$item->registrasi_id)}}" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-print"></i> {{$item->no_lab}}</a>
                          {{-- <a href="{{ url('pemeriksaanlab/cetakAll/'.$d->id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat"><i class="fa fa fa-print"></i></a> --}}
                        @endforeach 
                      </ul>
                  </div>
                    
                    @endif
                  </td>
                  {{-- <td>
                    <a href="{{ url('pemeriksaanlab/cetakRujukan/'.$d->id) }}" target="_blank" class="btn btn-sm btn-warning btn-flat"><i class="fa fa fa-print"></i></a>
                  </td> --}}
                  {{-- <td>
                    @if (cek_hasil_lab($d->id) >= 1)
                      @php
                        $hasil = App\Hasillab::where('registrasi_id', $d->id)->get();
                      @endphp
                      <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-success">Cetak</button>
                          <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                            @foreach ($hasil as $p)
                                <li><a href="{{ url('pemeriksaanlab/cetak/'.$d->id.'/'.$p->id) }}" class="btn btn-flat btn-sm" target="_blank"> {{ $p->created_at }}</a></li>
                            @endforeach
                          </ul>
                      </div>
                    @endif
                    
                  </td> --}}
                  <td>
                    <a href="{{url('cetak-lis-all-pdf/'.$d->id)}}" class="btn btn-info btn-flat btn-xs">Cetak LIS Semua</a>
                  </td>

                  <td>
                    @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->count() > 0)
                    <div class="btn-group">
                      <button type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i></button>
                      <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                        {{-- @php
                            $folios = ;
                        @endphp --}}
                        {{-- @foreach (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->select('created_at')->select(DB::raw('DATE(created_at) as date'))->get() as $p) --}}
                        @foreach (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->select('created_at')->groupBy(DB::raw('hour(created_at),day(created_at)'))->orderBy('id','DESC')->get() as $p)
                        @php
                            $datetime = str_replace(" ","_",date('Y-m-d H:i',strtotime($p->created_at)))
                        @endphp
                          <li>

                            @if (cek_jenis_reg(@$d->status_reg) == 'Rawat Inap')
                            <a href="{{ url("laboratorium/cetakRincianLab-pertgl/irna/".$d->id."/".$datetime) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ date('d-m-Y H:i',strtotime($p->created_at)) }} </a>
                            @elseif(cek_jenis_reg(@$d->status_reg) == 'Rawat Jalan')  
                            <a href="{{ url("laboratorium/cetakRincianLab-pertgl/irj/".$d->id."/".$datetime) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ date('d-m-Y H:i',strtotime($p->created_at)) }} </a>
                            @else
                            <a href="{{ url("laboratorium/cetakRincianLab-pertgl/ird/".$d->id."/".$datetime) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->date }} </a>
                            @endif


                               </li>
                        @endforeach
                      </ul>
                    </div>
                    @endif
                  </td>
                </tr>
              @endforeach
              @endisset
            </tbody>
          </table>
        </div>
  
  
      </div>
    </div>
    <div class="modal fade" id="pemeriksaanModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form method="POST" class="form-horizontal" id="form">
              <table class="table table-condensed table-bordered">
                <tbody>
                    <tr>
                      <th>Tanggal Order :<input class="form-control" name="waktu" redonly> </th> 
                    </tr>
                    <tr>
                      <td>
                        <textarea name="pemeriksaan" class="form-control wysiwyg"></textarea>
                      </td>
                    </tr>
                </tbody>
              </table>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
@stop
@section('script')
  <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
  <script type="text/javascript">
    //CKEDITOR
    $('.select2').select2();
    
    CKEDITOR.replace( 'pemeriksaan', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    function coba(registrasi_id) {
      $('#pemeriksaanModel').modal({
        backdrop: 'static',
        keyboard : false,
      })
      $('.modal-title').text('Catataan Order Laboratorium')
      $("#form")[0].reset()
      CKEDITOR.instances['pemeriksaan'].setData('')
      $.ajax({
        url: '/laboratorium/catatan-pasien/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('input[name="waktu"]').val(data.created_at)
        CKEDITOR.instances['pemeriksaan'].setData(data.pemeriksaan)
      })
      .fail(function() {

      });
    }
  </script>
@endsection
