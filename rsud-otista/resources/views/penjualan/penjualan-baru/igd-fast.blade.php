@extends('master')
@section('header')
<h1>Penjualan Rawat Darurat</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/darurat-baru-fast', 'class'=>'form-horizontal']) !!}
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
               <th>Di Bayar</th>
               <th>Tgl Registrasi</th>
               {{-- <th>Proses</th> --}}
               <th>Proses New</th>
               <th>Tgl Entry</th>
               <th>Resep</th>
               <th>Faktur</th>
               <th>F. Kronis K</th> 
               <th>F. Non Kronis</th> 
               <th>Etiket Biru</th>
               <th>Edit</th>
               <th>EMR</th>
             </tr>
           </thead>
           <tbody>
               @foreach ($data as $key => $d)
                   <tr>
                     <td>{{ $no++ }}</td>
                     <td>{{ strtoupper(@$d->pasien->nama) }}</td>
                     <td>{{ @$d->pasien->no_rm }}</td>
                     <td>{{ strtoupper(@$d->poli->nama) }}</td>
                     <td>{{ $d->bayars->carabayar }}</td>
                     <td>
                        @if ($d->lunas == 'Y')
                            {{ 'Lunas' }}
                        @else
                            {{ 'Belum Lunas' }}
                        @endif
                    </td>
                     <td>{{ date('d-m-Y, H:i',strtotime($d->created_at)) }}</td>
                     {{-- <td>{{ tanggal_eklaim($d->tgl_regisrasi) }}</td> --}}
                     {{-- <td>
                       <a href="{{ url('penjualan/form-penjualan-baru/'.$d->pasien_id).'/'.$d->id }}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></a>
                      </td> --}}
                      <td>
                        <a href="{{ url('penjualannew/form-penjualan-baru/'.$d->pasien_id).'/'.$d->id }}" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-check"></i></a>
                       </td>
                      <td>
                        {{ count(@$d->penjualan) > 0 ? date('d-m-Y H:i', strtotime(@$d->penjualan->last()->created_at)) : '-' }}
                       </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-primary btn-flat" onclick="popupWindow('/penjualan/tab-resep/'+{{$d->id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
                     </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-danger btn-flat" onclick="popupWindow('/penjualan/tab-faktur/'+{{$d->id}})" style="margin-bottom: 5px;"><i class="fa fa-list-alt"></i></button>
                     </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-default btn-flat" onclick="popupWindow('/penjualan/tab-fkronis/'+{{$d->id}})" style="margin-bottom: 5px;"><i class="fa fa-indent"></i></button>
                     </td>
                     <td>
                        <button type="button" class="btn btn-sm btn-default btn-flat" onclick="popupWindow('/penjualan/tab-fnonkronis/'+{{$d->id}})" style="margin-bottom: 5px;"><i class="fa fa-indent"></i></button>
                      </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-info btn-flat" onclick="popupWindow('/penjualan/tab-etiket/'+{{$d->id}})" style="margin-bottom: 5px;"><i class="fa fa-id-card"></i></button>
                     </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-warning btn-flat" onclick="popupWindow('/penjualan/tab-edit/'+{{$d->id}})" style="margin-bottom: 5px;"><i class="fa fa-edit"></i></button>
                     </td>
                     <td>
                      <div class="btn-group">
                          <a target="_blank" href="{{ url('emr/soap-farmasi/' . $unit . '/' . $d->id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}" class="btn btn-sm btn-flat btn-primary">CPPT</a>
                          <a target="_blank" href="{{ url('emr-soap/pemeriksaan/penelusuran-obat-igd/farmasi/' . $d->id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}" class="btn btn-sm btn-flat btn-danger">Rekonsiliasi Obat</a>
                          <a target="_blank" href="{{ url('emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/farmasi/' . $d->id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}" class="btn btn-sm btn-flat btn-success">Pemberian Terapi</a>
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
  

@endsection

@section('script')
  <script type="text/javascript">
    $(".skin-blue").addClass( "sidebar-collapse" );
    $('.select2').select2();
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
    


  </script>
@endsection
