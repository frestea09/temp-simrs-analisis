@extends('master')
@section('header')
  <h1>Radiologi Gigi- Perawat <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('radiologi-gigi/tindakan-irj') }}" ><img src="{{ asset('menu/fixed/rawatjalan.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Jalan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('radiologi-gigi/tindakan-ird') }}" ><img src="{{ asset('menu/fixed/igd.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Darurat</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('radiologi-gigi/tindakan-irna') }}" ><img src="{{ asset('menu/fixed/rawatinap.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Rawat Inap</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 iconModule">
        <a href="{{ url('radiologi-gigi/transaksi-langsung') }}" ><img src="{{ asset('menu/fixed/pasienlangsung.png') }}"  width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Pasien Langsung</h5>
      </div>
    </div>


    <div class="box-footer">
    </div>
  </div>
@endsection


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
      $('.modal-title').text('Catataan Order Radiologi')
      $("#form")[0].reset()
      CKEDITOR.instances['pemeriksaan'].setData('')
      $.ajax({
        url: '/radiologi-gigi/catatan-pasien/'+registrasi_id,
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
    
    CKEDITOR.replace( 'ekspertise', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    function new_ekspertise(id) {
      $('#ekspertiseModal').modal({
        backdrop: 'static',
        keyboard: false,
      })
      $('.modal-title').text('Tambah Ekpertise IGD')
      $("#formEkspertise")[0].reset()
      $('input[name="ekspertise_id"]').val('');
      CKEDITOR.instances['ekspertise'].setData('');
      $('#tglPeriksa').empty();
      $.ajax({
          url: '/radiologi-gigi/tindakan/'+id,
          type: 'GET',
          dataType: 'html',
        })
        .done(function (res) {
           console.log(res)
          $('#tindakanPeriksa').html(res);
          //$('#registrasi_id').html(res);

        })
        .fail(function () {

      });


    $.ajax({
        url: '/radiologi-gigi/igd/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function (data) {
        console.log(data)
        $('.nama').text(data.reg.pasien.nama)
        $('.no_rm').text(data.reg.pasien.no_rm)
        $('.umur').text(data.umur)
        $('.jk').text(data.reg.pasien.kelamin)
        $('input[name="tglPeriksa"]').val(data.tanggal)
        $('input[name="klinis"]').val(data.klinis)
        CKEDITOR.instances['ekspertise'].setData(data.eks)
        $('input[name="registrasi_id"]').val(data.reg.id)
        $('input[name="tanggal_eksp"]').val(data.tanggal)
        if(data.rad){
          $('select[name="dokter_id"]').val(data.rad.dokter_pelaksana).trigger('change')
        }
        $('select[name="dokter_pengirim"]').val(data.reg.dokter_id).trigger('change')
        // $('#tindakanPeriksa').empty();
        // $('#tglPeriksa').empty();
        // $('.pemeriksaan').empty()
        // $('.tgl_priksa').empty()
      })
      .fail(function () {

      });
  }

  let optionPeriksa = '';
  let tglPeriksa = '';

  function ekspertise(reg_id,id) {
    $('#ekspertiseModal').modal({
      backdrop: 'static',
      keyboard : false,
    })
    $('.modal-title').text('Input Ekpertise')
    $("#formEkspertise")[0].reset()
    CKEDITOR.instances['ekspertise'].setData('')

    $('#tindakanPeriksa').html('');

    $.ajax({
      url: '/radiologi-gigi/ekspertise/'+reg_id+'/'+id,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(data) {
      $('.nama').text(data.reg.pasien.nama)
      $('.no_rm').text(data.reg.pasien.no_rm)
      $('.umur').text(data.umur)
      $('.jk').text(data.reg.pasien.kelamin)
      $('.tgl_priksa').text(data.tindakan.created_at)
      $('input[name="registrasi_id"]').val(data.reg.id)
      // $('input[name="klinis"]').val(data.ep.klinis)
      $('input[name="klinis"]').val(data.klinis)
      $('input[name="tanggal_eksp"]').val(data.tanggal)
      $('select[name="dokter_id"]').val(data.ep.dokter_id).trigger('change')
      $('select[name="dokter_pengirim"]').val(data.ep.dokter_pengirim).trigger('change')
      // $('.pemeriksaan').empty()
      optionPeriksa = '';
      $.each(data.tindakan, function(index, val) {
        // $('.pemeriksaan').append('<li>'+val.namatarif+'</li>')
        if(data.ep.folio_id == val.id){
            optionPeriksa += '<option data_tgl="'+val.created_at+'" value="'+val.id+'" selected>'+val.namatarif+'</option>';
            tglPeriksa = val.created_at;
          }else{
            optionPeriksa += '<option data_tgl="'+val.created_at+'" value="'+val.id+'">'+val.namatarif+'</option>';
            tglPeriksa = val.created_at;
          }
      });
      $('#tglPeriksa').html(tglPeriksa);
      $('#tindakanPeriksa').html(`<select class="form-control" name="tindakan_id"><option selected disabled>Silahkan Pilih</option>${optionPeriksa}</select>`);
      if (data.ep != '') {
        $('input[name="ekspertise_id"]').val(data.ep.id)
        $('input[name="no_dokument"]').val(data.ep.no_dokument)
        CKEDITOR.instances['ekspertise'].setData(data.ep.ekspertise)
      }
    })
    .fail(function() {

    });
  }

  $(document).on('change','select[name="tindakan_id"]',function(){
    let tgl = $(this).find(':selected').attr('data_tgl');
    $('#tglPeriksa').html(tgl);
  })

    function saveEkpertise() {
      var token = $('input[name="_token"]').val();
      var ekspertise = CKEDITOR.instances['ekspertise'].getData();
      var form_data = new FormData($("#formEkspertise")[0])
      form_data.append('ekspertise', ekspertise)

      $.ajax({
        url: '/radiologi-gigi/ekspertise-baru',
        type: 'POST',
        dataType: 'json',
        data: form_data,
        async: false,
        processData: false,
        contentType: false,
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('input[name="ekspertise_id"]').val(resp.data.id)
          alert('Ekspertise IGD berhasil disimpan.')
          location.reload();
        }

      });
    }

    function pemeriksaan_tindakan(registrasi_id) {
      $('#pemeriksaanModal').modal('show');
      $('.modal-title').text('Radiologi Tindakan');
      $('#detailTindakan').load('/radiologi-gigi/tambah-ekspertise/'+registrasi_id);
    }
  </script>
    <style>

.blink_me {
        animation: blinker 2s linear infinite;
        color: orange;
      }

      @keyframes blinker {
        50% {
          opacity: 0;
        }
      }


  </style>