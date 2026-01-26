@extends('layouts.landingpage')
@section('style')
<style>
  .select2-results__option,
  .select2-search__field,
  .select2-selection__rendered,
  .form-control,
  .col-form-label
  {
    font-size:12px;
  }
  .table-pasien tr td{
    padding:5px !important;
    font-size:12px;
  }

  #dataPasien td,  #dataPasien th{
    padding: 0.25rem !important;
  }
  select[readonly] {
  background: #eee; /*Simular campo inativo - Sugestão @GabrielRodrigues*/
  pointer-events: none;
  touch-action: none;
}
.disables {
  pointer-events: none;
  cursor: default;
}
</style>
<link rel=”stylesheet” href=”css/jqbtk/jqbtk.min.css”>
@endsection
@section('content')
<div class="container">
    <h4 class="text-dark text-center">Checkin Pendaftaran Online</h4>
    {{-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Library</a></li>
          <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol>
      </nav> --}}
    <hr/>
    <div class="row">
        <div class="col-lg-12">
             
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
          @if(Session::has('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ Session::get('error') }}.</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
            <div class="card border-info">
                <div class="card-header bg-info">
                  <span style="color:white">Form Checkin </span>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" id="form">
                      {{ csrf_field() }} {{ method_field('POST') }}
                      {{-- <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">No. Booking
                        </label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">@</span>
                          </div>
                          <input  autocomplete="off" id="keyword"  type="text" name="keyword" value="" class="form-control" style="width: 100%;font-size:18px;padding:40px;" onkeyup="this.value =
                            this.value.toUpperCase()" placeholder="Masukkan kode yang didapatkan saat daftar online">
                        </div>
                      </div> --}}
                        <div class="form-group row">
                          <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">No. Booking
                          </label>
                          <div class="input-group mb-3 col-sm-4">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">{{date('dmY')}}</span>
                            </div>
                            {{-- <br/>OKE --}}
                            <input  id="keyword"  type="text" name="keyword" value="" class="form-control" style="width: 100%;font-size:18px;padding:40px;" autofocus placeholder="Contoh : INT3">
                          </div>
                          {{-- <div class="col-sm-4">
                            <input  autocomplete="off" id="keyword"  type="text" name="keyword" value="" class="form-control" style="width: 100%;font-size:18px;padding:40px;" onkeyup="this.value =
                            this.value.toUpperCase()" placeholder="Masukkan kode yang didapatkan saat daftar online">
                          </div> --}}
                          <input type="hidden" name="tglperiksa" value="{{date('d-m-Y')}}" class="form-control" style="width: 100%">

                          <div class="col-sm-4">
                            <button class="btn btn-warning col-md-8 col-lg-8 btnCari btn-sm float-left" type="button" onclick="tampil()" style="height:80px;font-size:18px;">
                              <i class="fa fa-search"></i> Cek Reservasi
                              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>&nbsp;
                            </button>
                          </div>
                          <div class="col-md-12" style="margin-left:190px;">Masukkan Kode ,Contoh : <b style="color:red;font-weight:900">INT3</b></div>
                        </div>
                        <div class="form-group row">
                          </div> 
                          {{-- <div class="form-group row">
                            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Tgl. Periksa</label>
                            <div class="col-sm-10">
                            </div>
                          </div>  --}}
                          <div class="form-group row">
                            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">&nbsp;</label>
                            {{-- <div class="col-lg-offset-2 col-lg-5"> --}}
                                <div class="col-sm-10">
                                    <div class="row">
                                        
                                        <div class="col-sm-6">
                                            {{-- <a href="{{url('/')}}" class="btn btn-danger btn-sm col-md-8 col-lg-8 float-right"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a> --}}
                                        </div>
                                    </div>
                                </div>
                            {{-- </div> --}}
                          </div>
                      </form>
                      
                    </div>
                  </div>
                  <br/>
                  <a href="{{url('/')}}" class="btn btn-danger btn-sm col-md-2 col-lg-2 float-right"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>
        </div>
    </div>
    
    <div class="row dataKunjungan d-none mt-2">
        <div class="col-lg-12">
            <div class="card border-success">
                <div class="card-header bg-success text-light">
                  Hasil Pencarian
                </div>
                <div class="card-body">
                  <div class="row"> 
                      <div class="table-responsive">
                        <table class="table table-hover table-bordered text-sm" style="font-size: 12px !important">
                          <thead class="bg-primary">
                            <tr class="text-light">
                              <th class="text-center" style="vertical-align: middle;">Kode Booking</th>
                              <th class="text-center" style="vertical-align: middle;">Poli</th>
                              {{-- <th class="text-center" style="vertical-align: middle;">No. Antrian</th> --}}
                              <th class="text-center" style="vertical-align: middle;">Nama</th> 
                              <th class="text-center" style="vertical-align: middle;">No. Rujukan</th>
                              <th class="text-center" style="vertical-align: middle;">Tgl.Periksa</th>
                              <th class="text-center" style="vertical-align: middle;">-</th>
                            </tr>
                          </thead>
                          <tbody>
            
                          </tbody>
                          <tfoot>
                            <tfoot ><tr><td class="text-center" colspan="6"><span class="status_finger"></span></td></tr></tfoot>
                          </tfoot>
                        </table>
                      </div> 
                  </div>
                </div>
              </div>
        </div>
    </div>
    
</div> 
@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function() {
    // $('#keyword').focus();
    // $('#keyword').keyboard()
    // $('#keyword').click(function(){
    //     $('input[name="keyword"]').keyboard()
    // });
})
// jQuery(document).ready(function($){
  function cekin(id,rm){
    $.ajax({
    url: '/reservasi/cekin-ajax/'+id+'/'+rm,
    type: 'GET',
    dataType: 'json',
    beforeSend: function () {
      $('tbody').find('.btnCek').addClass('disabled')
      $('tbody').find('.spinner-cek').removeClass('d-none')
    },
    complete: function () {
      $('tbody').find('.btnCek').removeClass('disabled')
      $('tbody').find('.spinner-cek').addClass('d-none')
    }
  })
  .done(function(data) {
    if (data.status == 200) {
      // Swal.fire({
      //   icon: 'error',
      //   title: 'Maaf...',
      //   text: data.result
      // })
      // return
    }else{
      Swal.fire({
        icon: 'error',
        title: 'Maaf...',
        text: data.result
      })
    }
  });
  }

//   function delay(callback, ms) {
//   var timer = 0;
//   return function() {
//     var context = this, args = arguments;
//     clearTimeout(timer);
//     timer = setTimeout(function () {
//       callback.apply(context, args);
//     }, ms || 0);
//   };
// }
  
//   $('input[name="keyword"]').keyup(delay(function (e) {
//     tampil()
//   }, 500));
  // document.getElementById("keyword")
  // .addEventListener("keyup", function(e) {
  //   e.preventDefault();
  //   if (e.code === 'Enter') {
  //     document.getElementById("btnCari").click();
  //   }
  // });

  $("#form").submit(function(e){
    e.preventDefault();
    tampil()
});
  
  function disableButton(){
    $('.btncheckin').addClass('disables')
  }
  function tampil() {
    
  $('.dataKunjungan').addClass('d-none')
  $('.respon').html('');
  $.ajax({
    url: '/reservasi/cek',
    type: 'POST',
    dataType: 'json',
    data: $('#form').serialize(), 
    beforeSend: function () {
      $('.btnCari').addClass('disabled')
      $('.spinner-border').removeClass('d-none')
    },
    complete: function () {
       $('.btnCari').removeClass('disabled')
       $('.spinner-border').addClass('d-none')
    }
  })
  .done(function(data) {
    // console.log(data)
    // var decompressData = LZString.decompressFromBase64(res);  
    // data = JSON.parse(res) 
    if (data.status == 200) {
      $('.dataKunjungan').removeClass('d-none')
      $('tbody').empty() 
      $('.poli').removeClass('d-none')
      $('.kelasRawat').addClass('d-none')

      // if(data.result.status == 'pending' && data.result.fingerprint.kode == '1'){
      if(data.result.status == 'pending'){
        cetak = '<a style="background-color:green;border:1px solid green;" onclick="disableButton()"; class="btn btn-success btncheckin btn-sm" href="/reservasi/checkin/'+data.result.id+'/'+data.result.no_rm+'">CHECK IN <span class="fa fa-print"></span></a>';
        // cetak = '<a style="background-color:green;border:1px solid green;" class="btn btn-success btn-sm" href="/reservasi/cek-sep/'+data.result.id+'/'+data.result.no_rm+'">LANJUTKAN <span class="fa fa-arrow-right"></span></a>';
        // cetak = '<button type="button" onclick="cekin('+data.result.id+','+data.result.no_rm+')" class="btn btn-info btn-sm btnCek" ><span class="fa fa-print"></span>&nbsp;CHECK IN<span class="spinner-border spinner-border-sm d-none spinner-cek" style="margin-left:5px;" role="status" aria-hidden="true"></span>&nbsp;</button>';
        
      }else if(data.result.status == 'checkin'){
        cetak = '<a class="btn btn-primary btn-sm" href="/reservasi/cetak/'+data.result.id+'"><span class="fa fa-print"></span>&nbsp;CETAK TIKET</a>';
      }
      else{
        cetak = '<a style="background-color:green;border:1px solid green;" class="btn btn-success btn-sm disabled" href=""><span class="fa fa-print"></span>&nbsp;Lanjutkan</a>';
      }
      // $.each(data.result, function(index, val) {
        
        $('tbody').append('<tr><td class="text-center">'+data.result.nomorantrian+'</td><td class="text-center">'+data.result.poli+'</td><td class="text-left">'+data.result.nama+'</td> <td>'+data.result.no_rujukan+
          '</td><td class="text-center">'+data.result.tglperiksa+'</td><td class="text-center" style="max-width:600px !important;">'+cetak+'</td></tr>')
      // }); 
      // if(data.result.fingerprint.kode == '1'){
      //   $('.status_finger').html('<b style="color:green;font-weight:700;font-size:14px;">'+data.result.fingerprint.status+'</b>');
      // }else{
      //   $('.status_finger').html('<b style="color:red;font-weight:700;font-size:14px;">'+data.result.fingerprint.status+'</b><br><span style="color:blue;font-weight:700;font-size:14px;">Silahkan melakukan fingerprint terlebih dahulu, Jika sudah melakukan fingerprint,Silahkan "Cek Reservasi" ulang untuk kemudian Checkin</span>');
      // }
      // return
    }else{
      Swal.fire({
        icon: 'error',
        title: 'Maaf...',
        text: data.result
      })
    }
  });
}
// })



</script>
@endsection