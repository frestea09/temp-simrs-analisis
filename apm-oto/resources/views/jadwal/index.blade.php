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
</style>
@endsection
@section('content')
<div class="container">
    <h4 class="text-dark text-center">Jadwal Dokter</h4>
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
            <div class="card border-warning">
                <div class="card-header bg-warning" style="background-color: #E5D9B6 !important;border-color:#E5D9B6;color:#285430;">
                  Filter Pencarian 
                </div>
                <div class="card-body">
                    <form class="form-horizontal" id="form">
                      {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="form-group row">
                          <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Poliklinik</label>
                          <div class="col-sm-10">
                            <select class="custom-select form-control-md select2" name="poli" id="inlineFormCustomSelect">
                                {{-- <option selected>-- PILIH --</option> --}}
                                @foreach ($poli as $item)
                                  <option value="{{$item->bpjs}}">{{$item->nama}}</option>
                                @endforeach
                              </select>
                          </div>
                        </div>
                        <div class="form-group row">
                            {{-- <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Dokter</label>
                            <div class="col-sm-10">
                              <select class="custom-select mr-sm-2 form-control-sm" id="inlineFormCustomSelect">
                                  <option selected>-- PILIH --</option>
                                  <option value="1">One</option>
                                  <option value="2">Two</option>
                                  <option value="3">Three</option>
                                </select>
                            </div> --}}
                          </div> 
                          <div class="form-group row">
                            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Tanggal</label>
                            <div class="col-sm-10">
                              <input type="text" name="tgl" value="{{date('d-m-Y')}}" class="form-control datepicker" style="width: 100%">
                            </div>
                          </div> 
                          <div class="form-group row">
                            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">&nbsp;</label>
                            {{-- <div class="col-lg-offset-2 col-lg-5"> --}}
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <button class="btn btn-success col-md-8 col-lg-8 btnCari" type="button" onclick="tampil()">
                                              <i class="fa fa-search"></i> Cari
                                              <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>&nbsp;
                                            </button>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="{{url('reservasi')}}" class="btn btn-info col-md-8 col-lg-8 float-right"><i class="fa fa-bookmark"></i>&nbsp;Reservasi</a>
                                        </div>
                                    </div>
                                </div>
                            {{-- </div> --}}
                          </div>
                      </form>
                  {{-- <h5 class="card-title">Special title treatment</h5>
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> --}}
                  
                </div>
              </div>
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
                              <th class="text-center" style="vertical-align: middle;">No</th>
                              {{-- <th class="text-center" style="vertical-align: middle;">Kode</th> --}}
                              <th class="text-center" style="vertical-align: middle;">Nama</th>
                              {{-- <th class="text-center" style="vertical-align: middle;">Hari</th> 
                              <th class="text-center" style="vertical-align: middle;">Jadwal</th>
                              <th class="text-center" style="vertical-align: middle;">Status</th>
                              <th class="text-center" style="vertical-align: middle;">Kapasitas</th> --}}
                              {{-- <th class="text-center" style="vertical-align: middle;">-</th> --}}
                            </tr>
                          </thead>
                          <tbody>
            
                          </tbody>
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

function tampil() {
  $('.respon').html('');
  $.ajax({
    url: '/jadwal/jadwal-dokter-hfis',
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
  .done(function(res) {
    // var decompressData = LZString.decompressFromBase64(res);  
    // data = JSON.parse(res) 
    data = res
    $('.dataKunjungan').addClass('d-none')
    if (data[0].metadata.code == 200) {
      $('.dataKunjungan').removeClass('d-none')
      $('tbody').empty() 
      $('.poli').removeClass('d-none')
      $('.kelasRawat').addClass('d-none')
      $.each(data[1], function(index, val) {
        if(val.libur == '0'){
          val.libur = '<span style="color:green">Tersedia</span>'
        }else{
          val.libur = '<span style="color:red">Libur</span>'
        }
        // $('tbody').append('<tr> <td>'+(index + 1)+'</td>  <td>'+val.kodedokter+'</td> <td>'+val.namadokter+'</td>  <td class="text-center">'+val.namahari+'</td> <td>'+val.jadwal+'</td><td class="text-center">'+val.libur+'</td> <td>'
        //   +val.kapasitaspasien+'</td></tr>')
        // $('tbody').append('<tr> <td>'+(index + 1)+'</td>  <td>'+val.kodedokter+'</td> <td>'+val.namadokter+'</td>  <td class="text-center">'+val.namahari+'</td> <td>'+val.jadwal+'</td><td class="text-center">'+val.libur+'</td> <td>'
        $('tbody').append('<tr> <td>'+(index + 1)+'</td> <td>'+val.namadokter+'</td></tr>')
      }); 
      // return
    }else{
        Swal.fire({
          icon: 'info',
          title: 'Maaf...',
          text: 'Jadwal Dokter Poli '+$('select[name="poli"]').find(":selected").text()+' Pada Tanggal Ini Tidak Tersedia'
        })
        // $('.dataKunjungan').removeClass('d-none')  
        // $('tbody').empty()
        // $('tbody').append('<tr> <td colspan="8">'+data['0'].metadata.message+'</td> </tr>')
    }
  });
}
</script>
@endsection