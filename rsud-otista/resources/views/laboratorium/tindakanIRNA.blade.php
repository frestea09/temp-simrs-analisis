@extends('master')

@section('header')
  <h1>Billing System Laboratorium - Rawat Inap </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4 class="box-title">
          {{-- Periode Tanggal &nbsp; --}}
        </h4>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'laboratorium/tindakan-irna', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-3">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>

          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group ">
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
          <div class="col-md-3">
            <div class="input-group">
                <button class="btn btn-primary mx-4 ml-2" type="submit"><i class="fa fa-search"></i> Cari</button>
            </div>
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
                <th>Tgl Registrasi</th>
                <th>Dokter</th>
                <th>Bangsal</th>
                <th>Cara Bayar</th>
                {{-- <th>Kondisi Akhir Pasien</th> --}}
                {{-- <th>Status Pulang</th> --}}
                <th>SEP</th>
                {{-- <th class="text-center" style="vertical-align: middle;">Proses LIS</th> --}}
                {{-- <th>LIS</th> --}}
                <th>Cetak</th>
                <th class="text-center" style="vertical-align: middle;">Billing</th>  
                <th>Cetak/Sesi (LIS)</th>
                <th>Upload Hasil</th>
                <th class="text-center" style="vertical-align: middle;">Catatan</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($registrasi as $key => $d)
                  @if ($roleUser == 'laboratorium')
                      @if ( cek_tindakan($d->id, 19) > 0 )
                        <tr class="danger">
                      @else
                        <tr>
                      @endif
                  @endif

                  <td>{{ $no++ }}</td>
                  <td>{{ @$d->pasien->nama }}</td>
                  <td>{{ @$d->pasien->no_rm }}</td>
                  <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                  <td>{{ @$d->rawat_inap->dokter_ahli->nama }}</td>
                  <td>{{ @$d->rawat_inap->kamar->nama }}</td>
                  <td>{{ @$d->bayars->carabayar }}
                    @if (!empty($d->tipe_jkn))
                      - {{ $d->tipe_jkn }}
                    @endif
                  </td>
                  {{-- <td>  
                    @if (@$d->kondisi_akhir_pasien)
                        <i  style="color: green">{{ @$d->kondisiAkhir->namakondisi }}</i>
                    @else
                        <i  style="color: red">Belum Di beri Input Kondisi Akhir</i>
                    @endif
                  </td> --}}
                    {{-- <td>  
                    @if (@$d->kondisi_akhir_pasien)
                        <i style="color: green">Sudah Di Pulangkan</i>
                    @else
                        <i style="color: red">Belum Di Pulangkan</i>
                    @endif
                  </td> --}}
                  <td>{{@$d->no_sep}}</td>


                  {{-- <td>
                    <a href="{{ url('laboratorium/insert-kunjungan/'. $d->id.'/'.$d->pasien_id) }}" onclick="return confirm('APAKAH YAKIN AKAN DILAKUKAN TINDAKAN LAB? KARENA AKAN MENAMBAH KUNJUNGAN LAB.')" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                  </td> --}}
                  {{-- <td>
                    <a href="{{ url('/emr/lab/inap/'. $d->id.'?poli='.$d->poli_id.'&dpjp='.$d->dokter_id) }}" onclick="return confirm('APAKAH YAKIN AKAN DILAKUKAN ORDER LIS? ')" class="btn btn-sm btn-warning btn-flat"><i class="fa fa-edit"></i></a>
                  </td> --}}

                  <td>
                    @if (count(@$d->folioLab) > 0)
                      <a href="{{ url('laboratorium/cetakRincianLab/irna/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-print"></i></a>
                    @endif
                  </td>
                  <td>
                    <a href="{{ url('/laboratorium/entry-tindakan-irna-new/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-plus"></i></a>
                  </td>
                  {{-- <td>
                    @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->count() > 0)
                    <div class="btn-group">
                      <button type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i></button>
                      <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" style="">
                        @foreach (Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->where('poli_tipe', 'L')->select('created_at')->groupBy(DB::raw('hour(created_at),day(created_at)'))->orderBy('id','DESC')->get() as $p)
                        @php
                            $datetime = str_replace(" ","_",date('Y-m-d H:i',strtotime($p->created_at)))
                        @endphp
                          <li>
                            <a href="{{ url("laboratorium/cetakRincianLab-pertgl/irna/".$d->id."/".$datetime) }}" target="_blank" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> {{ date('d-m-Y H:i',strtotime($p->created_at)) }} </a>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                    @endif
                  </td> --}}
                  <td>
                    <button type="button" class="btn btn-sm btn-danger btn-flat" onclick="popupWindow('/laboratorium/list-lis/'+{{$d->id}})" style="margin-bottom: 5px;"><i class="fa fa-list-alt"></i></button>                   
                  </td>
                  <td>
                    <a href="{{ url('/emr/upload-hasil/lain/inap/'.$d->id) }}" class="btn btn-sm btn-warning btn-flat" target="_blank"><i class="fa fa-upload"></i></a>
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" onclick="coba({{ $d->id }})"><i class="fa fa-book"></i></button>
                  </td>
                </tr>
              @endforeach
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
        if (data.is_order_lab) {
          $('input[name="waktu"]').val(data.waktu_order_lab)
          CKEDITOR.instances['pemeriksaan'].setData(data.catatan_order_lab)
        }
      })
      .fail(function() {

      });
    }

    function popupWindow(mylink) {
      if (!window.focus) return true;
      var href;
      if (typeof (mylink) == 'string')
        href = mylink;
      else href = mylink.href;
      window.open(href, "Resep", 'width=500,height=500,scrollbars=yes');
      return false;
    }
  </script>
@endsection
