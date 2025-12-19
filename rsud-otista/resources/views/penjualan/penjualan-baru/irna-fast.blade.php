@extends('master')
@section('header')
<h1>Penjualan Rawat Inap  </h1>
@endsection

@section('content')
<style>
.glyphicon.spin {
    animation: spin 1s infinite linear;
}
@keyframes spin {
    from { transform: rotate(0deg);}
    to { transform: rotate(360deg);}
}
</style>
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/irna-baru-fast', 'class'=>'form-horizontal']) !!}
        <div class="row">
          {!! Form::hidden('unit', $unit) !!}
           <div class="col-md-3">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Registrasi Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['autocomplete'=>'off','class' => 'form-control datepicker', 'required' => true]) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
            <br>
          </div> 
           <div class="col-md-3">
            <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">s/d Tanggal</button>
                </span>
                {!! Form::text('tgb', null, ['autocomplete'=>'off','class' => 'form-control datepicker', 'required' => true, 'onchange'=>'this.form.submit()']) !!}
                <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
            <br>
          </div>
           <div class="col-md-3">
            <div class="input-group{{ $errors->has('tgb') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tgb') ? ' has-error' : '' }}" type="button">Asal</button>
                </span>
                <select name="poli_id" id="" class="chosen-select" onchange="this.form.submit()">
                  <option value=""></option>
                  @foreach ($poli as $key=>$item)
                      <option value="{{$key}}" {{@$selected_poli == $key ? 'selected' :''}}>{{$item}}</option>
                  @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('tgb') }}</small>
            </div>
            <br>
          </div>
           <div class="col-md-3">
            <div class="input-group{{ $errors->has('kamar_id') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('kamar_id') ? ' has-error' : '' }}" type="button">Kamar</button>
                </span>
                <select name="kamar_id" id="" class="chosen-select" onchange="this.form.submit()">
                  <option value="">-- Semua --</option>
                  @foreach ($kamar as $key=>$item)
                      <option value="{{$item}}" {{@$filterKamar == $item ? 'selected' :''}}>{{$item}}</option>
                  @endforeach
                </select>
                <small class="text-danger">{{ $errors->first('kamar_id') }}</small>
            </div>
            <br>
          </div>
           
        </div>
      {!! Form::close() !!}

     @if (isset($data))
       <div class='table-responsive'>
         <table class='table table-striped table-bordered table-hover table-condensed' id='datas'>
           <thead>
             <tr>
               <th>No</th>
               <th>Nama</th>
               <th>RM</th>
               <th>Asal</th>
               <th>Ruangan</th>
               <th>Jenis</th>
               <th>Tgl Registrasi</th>
               <th>Proses New</th>
               <th>Resep</th>
               <th>Faktur</th>
               <th>F. Kronis K</th> 
               <th>F. Non Kronis</th> 
               <th>Infus</th>
               <th>Etiket Biru</th>
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
                     {{-- <td>
                        {{@\App\Rawatinap::where('registrasi_id',$d->registrasi_id)->first()->kamar->nama}}
                     </td> --}}
                     <td data-registrasi="{{ $d->registrasi_id }}" class="cek-kamar">
                        <i class="glyphicon glyphicon-refresh spin"></i>
                    </td>
                     <td>{{ baca_carabayar($d->bayar) }}</td>
                     {{-- <td>{{ $d->created_at }}</td> --}}
                     <td>{{ date('d-m-Y, H:i',strtotime($d->created_at)) }}</td>
                     {{-- <td>
                       <a href="{{ url('penjualan/form-penjualan-baru/'.$d->pasien_id).'/'.$d->registrasi_id }}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-check"></i></a>
                      </td> --}}
                      <td>
                        <a href="{{ url('penjualannew/form-penjualan-baru/'.$d->pasien_id).'/'.$d->registrasi_id }}" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-check"></i></a>
                       </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-primary btn-flat" onclick="popupWindow('/penjualan/tab-resep/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
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
                       <button type="button" class="btn btn-sm btn-success btn-flat" onclick="popupWindow('/penjualan/tab-infus/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-list"></i></button>
                      </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-info btn-flat" onclick="popupWindow('/penjualan/tab-etiket/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-id-card"></i></button>
                      </td>
                      <td>
                       <button type="button" class="btn btn-sm btn-warning btn-flat" onclick="popupWindow('/penjualan/tab-edit/'+{{$d->registrasi_id}})" style="margin-bottom: 5px;"><i class="fa fa-edit"></i></button>
                      </td>
                      <td>
                        <div class="btn-group">
                            <a target="_blank" href="{{ url('emr/soap-farmasi/' . $unit . '/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}" class="btn btn-sm btn-flat btn-primary">CPPT</a>
                            <a target="_blank" href="{{ url('emr-soap/pemeriksaan/penelusuran-obat-igd/farmasi/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}" class="btn btn-sm btn-flat btn-danger">Rekonsiliasi Obat</a>
                            <a target="_blank" href="{{ url('emr-soap/pemeriksaan/inap/daftar-pemberian-terapi/farmasi/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}" class="btn btn-sm btn-flat btn-success">Pemberian Terapi</a>
                            <a target="_blank" href="{{ url('emr-soap/pemeriksaan/formulir-edukasi/inap/' . $d->registrasi_id . '?poli=' . $d->poli_id . '&dpjp=' . $d->dokter_id) }}" class="btn btn-sm btn-flat btn-info">Formulir Edukasi & Keluarga</a>
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
    


  </script>
  <script>
      let emrCache = {};

      function loadModal(url){
        $('#modal_md').modal('show');
        $.ajax({
          url: url,
          success: function (response) {
            jQuery('#modal_md .modal-content').html(response);
          }
        });
      }

      $('#datas').DataTable({
        language: {
          url: "/json/pasien.datatable-language.json",
        },
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        drawCallback: function(settings) {
          $('#datas_filter').parent().prev().remove();

           $('.cek-kamar').each(function () {
            var td = $(this);
            var regID = td.data('registrasi');

            $.ajax({
                url: '/ajax-cek-kamar/' + regID,
                method: 'GET',
                success: function (res) {
                    td.html(res.nama_kamar); // ubah isi td
                },
                error: function () {
                    td.html('<span class="text-danger">Gagal load</span>');
                }
            });
        });
          
        }
      });
    </script>
  <script>
    $(document).ready(function () {
       
    });
    </script>

@endsection
