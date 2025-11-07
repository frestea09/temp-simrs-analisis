@extends('master')
@section('header')
  <h1>Admission </h1>
  <style>
    .modal { overflow: auto !important; }
  </style>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Antrian Rawat Inap &nbsp;
        </h3>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th>No</th>
                <th>No. RM</th>
                <th>Nama</th>
                <th>Cara Bayar</th>
                <th>DPJP Rajal/IGD</th>
                <th>Tgl Masuk Antrian</th>
                <th>Proses</th>
                <th>SPRI</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($antrian as $key => $d)
                <tr>
                  <td>{{ @$no++ }}</td>
                 
                  <td>{{ @$d->pasien->no_rm }}</td>
                  <td>{{ strtoupper(@$d->pasien->nama) }}
                    @if (cek_status_reg($d->status_reg) == 'J')
                      (<b style="color:blue;">RAJAL</b>)
                    @elseif (cek_status_reg($d->status_reg) == 'I')
                      (<b style="color:blue;">INAP</b>)
                    @elseif (cek_status_reg($d->status_reg) == 'G')
                      (<b style="color:blue;">IGD</b>)
                    @endif
  
                    @if ($d->status_reg == 'I3')
                        (<b style="color:green;">PASIEN INAP SUDAH PULANG</b>)
                    @endif
                  </td>
                  <td>{{ baca_carabayar(@$d->bayar) }} {{ (!empty($d->tipe_jkn)) ? ' - '.$d->tipe_jkn : '' }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td><span style="position:absolute;-webkit-text-fill-color: transparent;">{{ date("dmY", strtotime( @$d->updated_at )) }}</span>{{ date("d-m-Y", strtotime( @$d->updated_at )) }}</td>
                  <td>
                    <a href="{{ url('/registrasi/ranap/form-sep/'.$d->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i></a>
                    {{-- <button type="button" data-id="{{ $d->id }}" class="btn btn-primary btn-sm openForm" name="button" href="{{ url('rawatinap/antrian/'.$d->id) }}"><i class="fa fa-refresh"></i></button> --}}
                  </td>
                  <td>
                    <a href="{{ url('/create-spri/'.$d->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-refresh"></i></a>
                    {{-- <button type="button" data-id="{{ $d->id }}" class="btn btn-primary btn-sm openForm" name="button" href="{{ url('rawatinap/antrian/'.$d->id) }}"><i class="fa fa-refresh"></i></button> --}}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

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

        @include('rawat-inap.form_antrian')

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
  <script type="text/javascript">
    $( ".tanggalSEP" ).datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
      });
    $( ".tanggalinap" ).datepicker({
    format: "yyyy-mm-dd hh:mm:ss ",
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
      url: '/rawat-inap/get-datareg/'+$(this).attr('data-id')+'',
      type: 'GET',
      success : function (data) {
       //  var tjkn = (data.tipe_jkn != null) ? data.tipe_jkn : ' ';
        $('input[name="namaPasien"]').val(data.nama);
        $('input[name="no_rm"]').val(data.no_rm);
        $('input[name="caraBayar"]').val(data.pembayaran);
        $('input[name="registrasi_id"]').val(data.id);
        $('input[name="carabayar_id"]').val(data.bayar);
        $('input[name="catatan_bpjs"]').val('-')

        $( '#dokter_idGroup' ).removeClass('has-error')
        $( '#dokter_idError' ).html('');
        
        $( '#kelompokkelas_idGroup' ).removeClass('has-error')
        $( '#kelompokkelas_idError' ).html('');
        $( '#kelas_idGroup' ).removeClass('has-error')
        $( '#kelas_idError' ).html( '' );
        $('#kamaridGroup').removeClass('has-error');
        $('#kamaridError').html( '' );
        $('#bedID').removeClass('has-error');
        $( '#bed_id-error' ).html( '' );

        $('#tgl_masukID').removeClass('has-error');
        $( '#tgl_masuk-error' ).html( '' );
        

        $('#statusNoJKN').removeClass('has-error');
        $('#statusNoJKN').removeClass('has-success');

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
        url: '/rawatinap/save',
        type: 'POST',
        data: formData,
        success: function (data) {
          // console.log(data);
          if(data.errors) {
            if (data.errors.dokter_id) {
              $( '#dokter_idGroup' ).addClass('has-error')
              $( '#dokter_idError' ).html( data.errors.dokter_id[0] );
            }

            if (data.errors.kelompokkelas_id) {
              $( '#kelompokkelas_idGroup' ).addClass('has-error')
              $( '#kelompokkelas_idError' ).html( data.errors.kelompokkelas_id[0] );
            }
            if(data.errors.kelas_id){
              $( '#kelas_idGroup' ).addClass('has-error')
              $( '#kelas_idError' ).html( data.errors.kelas_id[0] );
            }
            if(data.errors.kamarid){
              $('#kamaridGroup').addClass('has-error');
              $('#kamaridError').html( data.errors.kamarid[0] );
            }
            if(data.errors.bed_id){
              $('#bedID').addClass('has-error');
              $( '#bed_id-error' ).html( data.errors.bed_id[0] );
            }

            if(data.errors.tgl_masuk){
              $('#tgl_masukID').addClass('has-error');
              $( '#tgl_masuk-error' ).html( data.errors.tgl_masuk[0] );
            }
          };

          if (data.success == 1) {
            location.href='/rawat-inap/admission';
            $('#antrianIRNA').modal('hide');
          }

          if(data.error == true){
            $('#error').html(data.pesan)
          }

        }
      });
  });
</script>
<script src="{{ asset('js/lz-string/libs/lz-string.js') }}"></script>

{{-- Pengaturan Kelas --}}
<script type="text/javascript">
  function compressData(string){
      data = LZString.compressToEncodedURIComponent(string)
      return data
    }
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

//CEK NIK IRNA =================================================================================================
$('#cekNik').on('click',  function(e) {
  e.preventDefault();
  var nik = compressData($('input[name="nik"]').val())
  $('.tableStatus').addClass('hidden')
      $.ajax({
        url: '/cari-sep-irna/nik/'+nik,
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
        
        data = JSON.parse(res);
        
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
          $('input[name="no_tlp"]').val(data[1].peserta.mr.noTelepon)
          $('input[name="hak_kelas_inap"]').val(data[1].peserta.hakKelas.kode)
          $('input[name="nama"]').val(data[1].peserta.nama)
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
    var no_kartu = compressData($('input[name="no_bpjs"]').val())
    $.ajax({
      url: '/cari-sep-irna/noka/'+no_kartu,
      type: 'GET',
      dataType: 'json',
      beforeSend: function () {
        $('.progress').removeClass('hidden')
      },
      complete: function () {
        $('.progress').addClass('hidden')
      },
      success: function (res) {
        data = JSON.parse(res);
        console.log(data)
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

      }
    });

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
            // console.log(data);
            if(data.sukses){
              $('#fieldSEP').removeClass('has-error');
              $("input[name='no_sep']").val( data.sukses );
            } else if (data.msg) {
              alert(data.msg)
              // $('#fieldSEP').addClass('has-error');
              // $("input[name='no_sep']").val( data.msg );
            }
          }
        });
      });

</script>

@endsection
