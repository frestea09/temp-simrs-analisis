@extends('master')
@section('header')
  <h1>Admission </h1>
@endsection

@section('content')
<style>
  .modal { overflow: auto !important; }
</style>
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          SEP Susulan Rawat Inap &nbsp;
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          {!! Form::open(['method' => 'POST', 'url' => 'admission/sep-susulan/rawat-inap', 'class'=>'form-hosizontal']) !!}
            <div class="row">
              <div class="col-md-3">
              <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete'=>'off']) !!}
              </div>
              </div>
            </div>
          {!! Form::close() !!}
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>Nama</th>
                <th>Cara Bayar</th>
                <th>DPJP Rajal</th>
                <th>Status Pasien</th>
                <th>Tgl Antri/Inap</th>
                <th>SEP</th>
                <th>SPRI</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($antrian as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ baca_norm($d->pasien_id) }}</td>
                  <td>{{ baca_pasien($d->pasien_id) }}</td>
                  <td>{{ baca_carabayar($d->bayar) }} {{ (!empty($d->tipe_jkn)) ? ' - '.$d->tipe_jkn : '' }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>
                    @if ($d->status_reg == 'I1')
                        Antri Inap
                    @elseif ($d->status_reg == 'I2')
                     Sudah Dapat BED
                    @endif
                  </td>
                  <td>{{ $d->updated_at }}</td>
                  <td>
                    <a href="{{ url('/registrasi/ranap/form-sep/'.$d->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i></a>
                    {{-- <button type="button" data-id="{{ $d->id }}" class="btn btn-primary btn-sm openForm" name="button"><i class="fa fa-refresh"></i></button> --}}
                  </td>
                  <td>
                    <a href="{{ url('/create-spri/'.$d->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-refresh"></i></a>
                    {{-- <button type="button" data-id="{{ $d->id }}" class="btn btn-primary btn-sm openForm" name="button"><i class="fa fa-refresh"></i></button> --}}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @if (!empty(session('no_sep')))
          <script type="text/javascript">
            window.open("{{ url('cetak-sep/'.session('no_sep')) }}","Cetak SEP", width=800,height=325)
          </script>
        @endif

      </div>
    </div>


<div class="modal fade" id="antrianIRNA" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
      <div class="modal-body">
        <h4 id="error" class="text-danger text-center"></h4>

        @include('admission.form_irna')

      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

{{-- MODAL DIAGNOSA --}}
<div class="modal fade" id="ICD10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Add</th>
                </tr>
              </thead>

            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

{{-- STATUS KARTU JKN --}}
<div class="modal fade" id="modalStatusJKN">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title statusJKNtitle"></h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-condensed">
            <tbody>
              <tr>
                <th>Nama Pasien</th><td class="nama"></td>
              </tr>
              <tr>
                <th>Tgl Lahir</th><td class="tglLahir"></td>
              </tr>
              <tr>
                <th>NIK</th><td class="nik"></td>
              </tr>
              <tr>
                <th>No. Kartu</th><td class="noka"></td>
              </tr>
              <tr>
                <th>No. Telepon</th><td class="noTelepon"></td>
              </tr>
              <tr>
                <th>Status</th><td class="status"></td>
              </tr>
              <tr class="rujukan hidden">
                <th>PPK Perujuk</th><td class="ppkPerujuk"></td>
              </tr>
              <tr>
                <th>Dinsos</th><td class="dinsos"></td>
              </tr>
              <tr>
                <th>No. SKTM</th><td class="noSKTM"></td>
              </tr>
              <tr>
                <th>Prolanis</th><td class="prolanisPRB"></td>
              </tr>
            </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary btn-flat" data-dismiss="modal">Lanjut</button>
      </div>
    </div>
  </div>
</div>
@stop


@section('script')
  <script src="{{ asset('js/lz-string/libs/lz-string.js') }}"></script>
  <script type="text/javascript">
    $( ".tanggalSEP" ).datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
      });
    $( "#tglKejadian" ).datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
      });

  $('.openForm').on('click', function () {
    $('#antrianIRNA').modal('show');
    $('.modal-title').text('Pilih Kamar');
    $( '#kelas_id-error' ).html( "" );
    $( '#kamar_id-error' ).html( "" );
    $( '#bed_id-error' ).html( "" );
    $('#kamarID').removeClass('has-error');
    $('#bedID').removeClass('has-error');
    $("#Register")[0].reset();
    $('.select2').select2();

    $.ajax({
      url: '/admission/get-data-irna/'+$(this).attr('data-id')+'',
      type: 'GET',
      success : function (data) {
       //  var tjkn = (data.tipe_jkn != null) ? data.tipe_jkn : ' ';
        $('input[name="namaPasien"]').val(data.nama);
        $('input[name="no_rm"]').val(data.no_rm);
        $('input[name="caraBayar"]').val(data.pembayaran);
        $('input[name="registrasi_id"]').val(data.id);
        $('input[name="carabayar_id"]').val(data.bayar);
        $('input[name="catatan_bpjs"]').val('-')
        $('select[name="dokter_id"]').val(data.dokter_id).trigger('change')
        $('input[name="no_bpjs"]').val(data.no_jkn)
        $('input[name="nik"]').val(data.nik)
        $('input[name="tgl_rujukan"]').val(data.tgl)
        $('input[name="tgl_sep"]').val(data.tgl)

        if (data.bayar == 1) {
          $('#pasienJKN').removeClass('hidden');
          $('input[name="nojkn"]').val(data.no_jkn);
        } else {
          $('#pasienJKN').addClass('hidden');
        }
      }
    });
  });

// Form Submit
  $('#submitForm').on('click', function () {
      var registerForm = $("#Register");
      var formData = registerForm.serialize();
      $.ajax({
        url: '/admission/save-sep/irna',
        type: 'POST',
        data: formData,
        success: function (data) {
          console.log(data);
          if (data.success == 1) {
            $('#antrianIRNA').modal('hide');
            location.href='/admission/sep-susulan';
          }

          if(data.error == true){
            $('#error').html(data.pesan)
          }
          if(data.error == 'sep_kosong'){
            alert('Pastikan Nomor SEP tidak kosong!');
          }

        }
      });
  });
</script>

{{-- Pengaturan Kelas --}}
<script type="text/javascript">

  $('select[name="dokter_id"]').change(function(e) {
    e.preventDefault();
    $.ajax({
      url: '/rawatinap/get-kode-dpjp/'+$(this).val(),
      type: 'GET',
      dataType: 'json',
    })
    .done(function(data) {
      $('input[name="kodeDPJP"]').val(data.kode_bpjs)
    });

  });

  $('select[name="kelompokkelas_id"]').on('change', function(e) {
    e.preventDefault();
    var kelompokkelas_id = $(this).val();
    $.ajax({
      url: '/kamar/getkelas/'+kelompokkelas_id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        console.log(data);
        $('select[name="kamarid"]').empty()
        $('select[name="kelas_id"]').empty()
        $('select[name="bed_id"]').empty()
        $('select[name="kelas_id"]').append('<option value=""></option>');
        $.each(data, function(key, value) {
            $('select[name="kelas_id"]').append('<option value="'+ value.id +'">'+ value.kelas +'</option>');
        });
      }
    })
  })

  $('select[name="kelas_id"]').on('change', function(e) {
    e.preventDefault();
    var kelompokkelas_id = $('select[name="kelompokkelas_id"]').val()
    var kelas_id = $(this).val();
    $.ajax({
      url: '/kamar/getkamar/'+kelompokkelas_id+'/'+kelas_id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        $('select[name="bed_id"]').empty()
        $('select[name="kamarid"]').empty()
        $('select[name="kamarid"]').append('<option value=""></option>');
        $.each(data, function(key, value) {
            $('select[name="kamarid"]').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
        });
      }
    })
  })

  $('select[name="kamarid"]').on('change', function(e) {
    e.preventDefault();
    var kelompokkelas_id = $('select[name="kelompokkelas_id"]').val()
    var kelas_id = $('select[name="kelas_id"]').val()
    var kamar_id = $(this).val()
    $.ajax({
      url: '/getbed/'+kelompokkelas_id+'/'+kelas_id+'/'+kamar_id+'/',
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        console.log(data);
        $('select[name="bed_id"]').empty()
        $.each(data, function(key, value) {
          $('select[name="bed_id"]').append('<option value="'+ key +'">'+ value +'</option>');
        });
      }
    })
  });

  //CEK STATUS JKN
  $('input[name="no_bpjs"]').keyup(function() {
    $('#statusNoJKN').removeClass('has-error');
    $('#statusNoJKN').removeClass('has-success');
    $('input[name="nik"]').val('')
  });

  $('input[name="nik"]').keyup(function() {
    $('input[name="no_bpjs"]').val('')
  });
function compressData(string){
    data = LZString.compressToEncodedURIComponent(string)
    return data
  }
//CEK NIK IRNA =================================================================================================
$('#cekNik').on('click',  function(e) {
  e.preventDefault();
  var nik = $('input[name="nik"]').val()
  $('.tableStatus').addClass('hidden')
      $.ajax({
        url: '/cari-sep-irna/nik/'+compressData(nik),
        type: 'GET',
        dataType: 'json',
        beforeSend: function () {
          $('.progress').removeClass('hidden')
        },
        complete: function () {
          $('.progress').addClass('hidden')
        }
      })
      .done(function(res) {
        var decompressData = LZString.decompressFromBase64(res); 
        data = JSON.parse(res)

        if (data[1].metaData.code == 200) {
          $('#modalStatusJKN').modal('show')
          $('.statusJKNtitle').text('Status Kartu JKN')
          $('.nama').text(data[1].peserta.nama)
          $('.tglLahir').text(data[1].peserta.tglLahir)
          $('.nik').text(data[1].peserta.nik)
          $('.noTelepon').text(data[1].peserta.mr.noTelepon)
          $('.noka').text(data[1].peserta.noKartu)
          $('.status').text(data[1].peserta.statusPeserta.keterangan)
          $('.dinsos').text(data[1].peserta.informasi.dinsos)
          $('.noSKTM').text(data[1].peserta.informasi.noSKTM)
          $('.prolanisPRB').text(data[1].peserta.informasi.prolanisPRB)
          $('#statusNoJKN').addClass('has-success')
          $('input[name="nama"]').val(data[1].peserta.nama)
          $('input[name="no_tlp"]').val(data[1].peserta.mr.noTelepon)
          $('input[name="hak_kelas_inap"]').val(data[1].peserta.hakKelas.kode)
          $('input[name="no_bpjs"]').val(data[1].peserta.noKartu)
        }

        if (data[0].metaData.code == 201) {
          alert(data[0].metaData.message)
        }

      });
});

//CEK NO KARTU JKN ===============================================================================================
  $('#cekStatus').on('click',  function(e) {
    e.preventDefault();
    var no_kartu = $('input[name="no_bpjs"]').val();
    console.log(no_kartu);
    
    $.ajax({
      url: '/cari-sep-irna/noka/'+compressData(no_kartu),
      type: 'GET',
      dataType: 'json',
      beforeSend: function () {
        $('.progress').removeClass('hidden')
      },
      complete: function () {
        $('.progress').addClass('hidden')
      }
      })
      .done(function(res) {
        // console.log(res);
        var decompressData = LZString.decompressFromBase64(res); 
        data = JSON.parse(res)
        
        // console.log(data)
        // alert("Added")
        // return
        if (data[0].metaData.code == 200) {
          $('#modalStatusJKN').modal('show')
          $('.statusJKNtitle').text('Status Kartu JKN')
          $('.nama').text(data[1].peserta.nama)
          $('.tglLahir').text(data[1].peserta.tglLahir)
          $('.nik').text(data[1].peserta.nik)
          $('.noTelepon').text(data[1].peserta.mr.noTelepon)
          $('.noka').text(data[1].peserta.noKartu)
          $('.status').text(data[1].peserta.statusPeserta.keterangan)
          $('.dinsos').text(data[1].peserta.informasi.dinsos)
          $('.noSKTM').text(data[1].peserta.informasi.noSKTM)
          $('.prolanisPRB').text(data[1].peserta.informasi.prolanisPRB)
          $('#statusNoJKN').addClass('has-success')
          $('input[name="nama"]').val(data[1].peserta.nama)
          $('input[name="no_tlp"]').val(data[1].peserta.mr.noTelepon)
          $('input[name="hak_kelas_inap"]').val(data[1].peserta.hakKelas.kode)
        }

        if (data[0].metaData.code == 201) {
          alert(data[0].metaData.message)
        }

      })
    });


// ADD DIAGNOSA
  $('input[name="diagnosa_awal"]').focus(function(event) {
    $("#dataICD10").DataTable().destroy()
        $("#ICD10").modal('show');
        $('#dataICD10').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },

            pageLength: 10,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '/sep/geticd10',
            columns: [
                // {data: 'rownum', orderable: false, searchable: false},
                {data: 'id'},
                {data: 'nomor'},
                {data: 'nama'},
                {data: 'add', searchable: false}
            ]
        });
  });

  $(document).on('click', '.addICD', function (e) {
    document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
    $('#ICD10').modal('hide');
  });

  //CREATE SEP
  $('#createSEP').on('click', function () {
        $.ajax({
          url : '{{ url('/buat-sep') }}',
          type: 'POST',
          // data: $("#Register").serialize(),
          data:{
            data : LZString.compressToBase64($('#Register').serialize()),
            _token : $('input[name="_token"]').val(),
            _method : 'POST'
          },
          processing: true,
          beforeSend: function () {
            $('.progress').removeClass('hidden')
          },
          complete: function () {
            $('.progress').addClass('hidden')
          },
          success:function(data){
            console.log(data);
            if(data.sukses){
              $('#fieldSEP').removeClass('has-error');
              $("input[name='no_sep']").val( data.sukses );
            } else if (data.msg) {
              $('.progress').addClass('hidden')
              alert(data.msg)
            }
          }
        });
    });
    
      $('select[name="laka_lantas"]').change(function(e) {
      if($(this).val() == 1){
        $('.laka').removeClass('hidden')
      } else {
        $('.laka').addClass('hidden')
      }
    });
   

</script>

@endsection
