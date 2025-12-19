@extends('master')
@section('header')
  <h1>Penjualan Rawat Jalan</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/jalan-baru-fast', 'class'=>'form-horizontal']) !!}
        <div class="row">
          {!! Form::hidden('unit', $unit) !!}
           <div class="col-md-4">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Registrasi Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['autocomplete'=>'off','class' => 'form-control datepicker', 'required' => true]) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
            <br>
          </div> 
           <div class="col-md-4">
            <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">s/d Tanggal</button>
                </span>
                {!! Form::text('tgb', null, ['autocomplete'=>'off','class' => 'form-control datepicker', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
            <br>
          </div> 
          <div class="col-md-4">
            <div class="input-group{{ $errors->has('poli') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('poli') ? ' has-error' : '' }}" type="button">Poli</button>
                </span>
                {{-- {!! Form::text('poli', null, ['autocomplete'=>'off','class' => 'form-control', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('poli') }}</small> --}}
                @php
                    $poli = Modules\Poli\Entities\Poli::all();
                @endphp
                <select name="poli" id="" onchange="this.form.submit()" class="select2">
                  <option value="">-- SEMUA --</option>
                  @foreach ($poli as $item)
                    <option value="{{ $item->id }}" {{$polis == $item->id ? 'selected' :''}}>{{ baca_poli($item->id) }}</option>
                  @endforeach
                
                </select>
            </div>
            <br>
          </div> 
           
        </div>
      {!! Form::close() !!}

     @if (isset($data))
       <div class='table-responsive'>
         <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
           <thead>
             <tr>
               <th>No</th>
               <th>Nama</th>
               <th>RM</th>
               <th>Poli</th>
               <th>Jenis</th>
               <th>Tgl Registrasi</th>
               <th>Total</th>
               <th>Proses</th>
               {{-- @if (Auth()->user()->id == '1') --}}
               <th>Proses New</th>
                   
               {{-- @endif --}}
               <th>Resep</th>
               <th>Copy Resep</th>
               <th>Bundling</th>
               <th>Resep Dokter</th>
               <th>Faktur</th>
               <th>F. Kronis K</th> 
               <th>F. Non Kronis</th> 
               <th>Etiket Biru</th>
               <th>Etiket Biru 2</th>
               <th>Edit</th>
               <th>EMR</th>
             </tr>
           </thead>
           <tbody>
               @foreach ($data as $key => $d)
                   <tr>
                     <td>{{ $no++ }}</td>
                     <td>{{ strtoupper($d->nama) }}</td>
                     <td>{{ $d->no_rm }}</td>
                     <td>{{ strtoupper(baca_poli($d->poli_id)) }}</td>
                     <td>{{ baca_carabayar($d->bayar) }}</td>
                     {{-- <td>{{ tanggal_eklaim($d->tgl_regisrasi) }}</td> --}}
                     <td>{{ date('d-m-Y, H:i',strtotime($d->tgl_regisrasi)) }}</td>
                     <td>
                        {{ number_format(@Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->registrasi_id)->where('jenis', 'ORJ')->sum('total')) }}
                    </td>
                     <td>
                       <a href="{{ url('penjualan/form-penjualan-baru/'.$d->pasien_id).'/'.$d->registrasi_id }}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></a>
                      </td>
                      {{-- @if (Auth()->user()->id == '1') --}}
                    <td>
                      <a href="{{ url('penjualannew/form-penjualan-baru/'.$d->pasien_id).'/'.$d->registrasi_id }}" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-check"></i></a>
                     </td>
                    {{-- @endif --}}
                      <td>
                       <button type="button" class="btn btn-sm btn-primary btn-flat" onclick="popupWindow('/penjualan/tab-resep/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
                     </td>
                     <td>
                        <button type="button" class="btn btn-sm btn-success btn-flat" onclick="popupWindow('/penjualan/tab-copy-resep/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
                      </td>
                     <td>
                       <div class="btn-group">
                          <a class="btn btn-sm btn-success btn-flat" href="{{url('penjualan/bundling-resep/'.$d->registrasi_id)}}"><i class="fa fa-dashboard"></i></a>
                          <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          @if (@Auth::user()->pegawai->nik)
                            <ul class="dropdown-menu dropdown-menu-pencil" role="menu" style="">
                                <button data-url="{{url('penjualan/tte-bundling-resep/'.$d->registrasi_id)}}" class="btn btn-warning btn-flat btn-xs tte-faktur-button"><i class="fa fa-pencil"></i> TTE Faktur Kronis</button>
                            </ul>
                          @endif
                        </div>
                      </td>
                      <td>
                        <a class="btn btn-sm btn-info btn-flat" href="{{ url('penjualan/bundling-resep/' . $d->registrasi_id . '?mode=resep-dokter') }}"><i class="fa fa-dashboard"></i></a>
                      </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-danger btn-flat" onclick="popupWindow('/penjualan/tab-faktur/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-list-alt"></i></button>
                     </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-default btn-flat" onclick="popupWindow('/penjualan/tab-fkronis/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-indent"></i></button>
                     </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-default btn-flat" onclick="popupWindow('/penjualan/tab-fnonkronis/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-indent"></i></button>
                     </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-info btn-flat" onclick="popupWindow('/penjualan/tab-etiket/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-id-card"></i></button>
                     </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-info btn-flat" onclick="popupWindow('/penjualan/tab-etiket2/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-id-card"></i></button>
                     </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-warning btn-flat" onclick="popupWindow('/penjualan/tab-edit/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-edit"></i></button>
                     </td>
                     <td>
                        <div class="btn-group">
                            <a target="_blank" href="{{ url('emr/soap-farmasi/' . $unit . '/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}" class="btn btn-sm btn-flat btn-primary">CPPT</a>
                            <a target="_blank" href="{{ url('emr-soap/pemeriksaan/penelusuran-obat-igd/farmasi/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}" class="btn btn-sm btn-flat btn-danger">Rekonsiliasi Obat</a>
                            <a target="_blank" href="{{ url('emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/farmasi/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}" class="btn btn-sm btn-flat btn-success">Pemberian Terapi</a>
                        </div>
                     </td>
                    </tr>
                  @endforeach
             </tbody>
         </table>
       </div>
     @endif
    </div>
  </div>


<!-- Modal TTE E-Resume Pasien-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form id="form-tte-bundling-resep" action="" method="POST">
    <input type="hidden" name="id">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">TTE</h4>
      </div>
      <div class="modal-body row" style="display: grid;">
          {!! csrf_field() !!}
          <input type="hidden" class="form-control" name="proses_tte" value="true">
          <input type="hidden" class="form-control" name="nik" id="nik_hidden" value="{{@Auth::user()->pegawai->nik}}">
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Nama:</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" name="dokter" id="dokter" value="{{@Auth::user()->pegawai->nama}}" disabled>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">NIK:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="nik" value="{{substr(@Auth::user()->pegawai->nik, 0, -5) . '*****'}}" disabled>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="passphrase" id="passphrase" value="{{session('passphrase') ? @session('passphrase')['passphrase'] : ''}}">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="button-proses-tte-eresume-pasien">Proses TTE</button>
      </div>
    </div>
    </form>

  </div>
</div>
  

@endsection

@section('script')
  <script type="text/javascript">
    $('.select2').select2();
    $(".skin-blue").addClass( "sidebar-collapse" );
    function popupWindow(mylink) {
      if (!window.focus) return true;
      var href;
      if (typeof (mylink) == 'string')
        href = mylink;
      else href = mylink.href;
      window.open(href, "Resep", 'width=500,height=500,scrollbars=yes');
      return false;
    }
    // function popupFaktur(mylink) {
    //   if (!window.focus) return true;
    //   var href;
    //   if (typeof (mylink) == 'string')
    //     href = mylink;
    //   else href = mylink.href;
    //   window.open(href, "Resep", 'width=500,height=500,scrollbars=yes');
    //   return false;
    // }
    // function popupFakturKronis(mylink) {
    //   if (!window.focus) return true;
    //   var href;
    //   if (typeof (mylink) == 'string')
    //     href = mylink;
    //   else href = mylink.href;
    //   window.open(href, "Resep", 'width=500,height=500,scrollbars=yes');
    //   return false;
    // }
    // function popupEtiket(mylink) {
    //   if (!window.focus) return true;
    //   var href;
    //   if (typeof (mylink) == 'string')
    //     href = mylink;
    //   else href = mylink.href;
    //   window.open(href, "Resep", 'width=500,height=500,scrollbars=yes');
    //   return false;
    // }


    $('#masterNorm').select2({
        placeholder: "Pilih No Rm...",
        ajax: {
            url: '/pasien/master-pasien/',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    })
    

    $('.tte-faktur-button').click(function () {
      $('#form-tte-bundling-resep').attr('action', $(this).data("url") );
      $('#myModal').modal('show');
    })

  </script>
@endsection
