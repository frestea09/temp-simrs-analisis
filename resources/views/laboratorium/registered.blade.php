@extends('master')

@section('header')
  <h1>Billing System Laboratorium Ter-billing</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4 class="box-title">
          {{-- Periode Tanggal &nbsp; --}}
        </h4>
      </div>
      <div class="box-body">

        {{-- {!! Form::open(['method' => 'POST', 'url' => 'laboratorium/registered', 'class'=>'form-hosizontal']) !!} --}}
        {{-- <div class="row">
          <div class="col-md-6">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div> --}}

          {{-- <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Tanggal</button>
              </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
            </div>
          </div> --}}
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">No RM/NAMA</button>
              </span>
              {!! Form::text('keyword', null, [
                'class' => 'form-control', 
                'autocomplete' => 'off', 
                'placeholder' => 'NO RM/NAMA',
                'required',
                ]) !!}
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
                <button class="btn btn-primary searchBtn"><i class="fa fa-search"></i> Cari</button>
            </div>
          </div>
          </div>
        {{-- {!! Form::close() !!} --}}
        <hr>

        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='tableLabRegistered'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>No. RM</th>
                <th>Dokter</th>
                <th>Klinik</th>
                <th>Tgl Masuk</th>
                <th>Cara Bayar</th>
                {{--<th>LIS</th>--}}
                {{-- <th class="text-center" style="vertical-align: middle;">Proses LIS</th> --}}
                <th>Cetak</th>
                <th class="text-center" style="vertical-align: middle;">Billing</th>  
                <th class="text-center" style="vertical-align: middle;">Hasil Lab</th>  
                {{-- <th>Cetak Per.tgl</th> --}}
                {{-- <th>Catatan</th> --}}
              </tr>
            </thead>
            {{-- <tbody>
              @foreach ($registrasi as $key => $d)
                  <td>{{ $no++ }}</td>
                  <td>{{ @$d->registrasi->pasien ? @$d->registrasi->pasien->nama: '-' }}</td>
                  <td>{{ @$d->registrasi->pasien->no_rm }}</td>
                  <td>{{ @$d->registrasi->dokter_umum->nama }}</td>
                  <td>{{ @$d->registrasi->poli ? @$d->registrasi->poli->nama: '-' }}</td>
                  <td>{{ $d->created_at}}</td>
                  <td>{{ @$d->registrasi->bayars->carabayar }}
                    @if (!empty($d->registrasi->tipe_jkn))
                      - {{ $d->registrasi->tipe_jkn }}
                    @endif
                  </td>
                  <td>
                    <a href="{{ url('/emr/lab/igd/'. $d->id.'?poli='.$d->poli_id.'&dpjp='.$d->dokter_id) }}" onclick="return confirm('APAKAH YAKIN AKAN DILAKUKAN ORDER LIS? ')" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a> 
                  </td>
                  <td style="text-align: center;">
                    <a href="{{ url('laboratorium/insert-kunjungan/'. $d->registrasi->id.'/'.$d->registrasi->pasien_id) }}" onclick="return confirm('APAKAH YAKIN AKAN DILAKUKAN TINDAKAN LAB? KARENA AKAN MENAMBAH KUNJUNGAN LAB.')" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                    @if (substr($d->registrasi->status_reg, 0, 1) == 'J' || substr($d->registrasi->status_reg, 0, 1) == 'G')
                      <a href="{{ url('/laboratorium/entry-tindakan-irj-new/'. $d->registrasi->id.'/'.$d->registrasi->pasien_id) }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-plus"></i></a>
                    @elseif (substr($d->registrasi->status_reg, 0, 1) == 'L')
                      <a href="{{ url('/laboratorium/entry-transaksi-langsung/'. $d->registrasi->id) }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-plus"></i></a>
                    @elseif (substr($d->registrasi->status_reg, 0, 1) == 'I')
                      <a href="{{ url('/laboratorium/entry-tindakan-irna-new/'. $d->registrasi->id.'/'.$d->registrasi->pasien_id) }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-plus"></i></a>
                    @endif
                  </td>
                  <td>
                      <a href="{{ url('laboratorium/cetakTindakanLab/'. $d->id .'/'.convertUnit(@$d->registrasi->status_reg).'/'.@$d->registrasi->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                    </td>
                    <td>
                      @if (substr($d->registrasi->status_reg, 0, 1) == 'J')
                      <a href="{{ url('/laboratorium/entry-tindakan-irj-new/'. $d->registrasi->id.'/'.$d->registrasi->pasien_id) }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-plus"></i></a>
                      @else  
                      <a href="{{ url('/laboratorium/entry-tindakan-irna-new/'. $d->registrasi->id.'/'.$d->registrasi->pasien_id) }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-plus"></i></a>
                      @endif
                      <a href="{{ url('laboratorium/registered-tindakan/'. $d->id .'/'.@$d->registrasi->id . '/' . @$d->registrasi->pasien->id) }}" target="_blank" class="btn btn-info btn-sm btn-flat"><i class="fa fa-eye"></i></a>
                    </td>
                    <td>
                      @if ($d->hasillab)
                        <a href="{{url('cetak-lis-pdf/'. @$d->hasillab->no_lab . '/'.  @$d->registrasi->id)}}" target="_blank" class="btn btn-default btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $d->hasillab->no_lab }} </a>
                    @endif
                  </td>
                  <td>
                    @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->registrasi->id)->where('poli_tipe', 'L')->count() > 0)
                    <div class="btn-group">
                      <button type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i></button>
                      <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                        @foreach (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->registrasi->id)->where('poli_tipe', 'L')->select(DB::raw('DATE(created_at) as date'))->groupBy('date')->get() as $p)
                          <li>
                            <a href="{{ url("laboratorium/cetakRincianLab-pertgl/".convertUnit($d->registrasi->status_reg)."/".$d->registrasi->id."/".$p->date) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ $p->date }} </a>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                    @endif
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" onclick="coba({{ $d->id }})"><i class="fa fa-book"></i></button>
                  </td>
                </tr>
              @endforeach
            </tbody> --}}
            <tbody>

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
    $(document).ready(function() {
      var tableLabRegistered = $('#tableLabRegistered').DataTable({
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          url: '/laboratorium/data-registered',
          data:function(d){
            d.keyword = $('input[name="keyword"]').val();
          }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {data: 'nama', orderable: false},
            {data: 'no_rm', orderable: false},
            {data: 'dokter', orderable: false},
            {data: 'poli', orderable: false},
            {data: 'tglMasuk', orderable: false},
            {data: 'caraBayar', orderable: false},
            {data: 'cetakLab', orderable: false},
            {data: 'billing', orderable: false},
            {data: 'hasilLab', orderable: false},
        ]
      });

      $(".searchBtn").click(function (){
        tableLabRegistered.draw();
      });
    });

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
