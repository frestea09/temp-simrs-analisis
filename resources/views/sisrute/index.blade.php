@extends('master')
@section('header')
  <h1>SISRUTE <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a onclick="buatRujukankeRSLain()" ><img src="{{ asset('menu/jkn.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Kirim Rujukan</h5>
      </div>
      <div class="col-md-2 col-sm-3 col-xs-6 text-center">
        <a href="{{ url('display') }}" target="_blank" ><img src="{{ asset('menu/hospital-bed.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Informasi Bed</h5>
      </div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@include('bridgingsep.form')

@endsection


@section('script')
  <script type="text/javascript">
    $('.select2').select2({
      placeholder: '[--]',
    });

    $("input[name='diagnosaRujukan']").on('focus', function () {
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
        document.getElementById("diagnosaRujukan").value = $(this).attr('data-nomor');
        $('#ICD10').modal('hide');
      });


    function sepPengajuan() {
      $('#sepPengajuan').modal({backdrop: 'static', keyboard: false})
      $('.modal-title').text('Pengajuan SEP')
      $('.respon').removeClass('text-danger')
      $('.respon').html('')
      $('.nokaGroup').removeClass('has-error')
      $('.nokaError').text('');
      $('.tglSepGroup').removeClass('has-error')
      $('.tglSepError').text('');
      $('.keteranganGroup').removeClass('has-error')
      $('.keteranganError').text('');
    }

    function savePengajuan() {
      $('.progress').removeClass('hidden')
      $('.respon').html('')
      $.ajax({
        url: '/bridgingsep/pengajuan',
        type: 'POST',
        dataType: 'json',
        data: $('#formSepPengajuan').serialize(),
      })
      .done(function(data) {
        $('.progress').addClass('hidden')
          if (data.metaData.code == 201) {
            if (data.metaData.error) {
              if (data.metaData.error.noKartu) {
                $('.nokaGroup').addClass('has-error')
                $('.nokaError').text(data.metaData.error.noKartu[0]);
              }
              if (data.metaData.error.tglSep) {
                $('.tglSepGroup').addClass('has-error')
                $('.tglSepError').text(data.metaData.error.tglSep[0]);
              }
              if (data.metaData.error.keterangan) {
                  $('.keteranganGroup').addClass('has-error')
                  $('.keteranganError').text(data.metaData.error.keterangan[0]);
                }
              } else {
                $('.nokaGroup').removeClass('has-error')
                $('.nokaError').text('');
                $('.tglSepGroup').removeClass('has-error')
                $('.tglSepError').text('');
                $('.keteranganGroup').removeClass('has-error')
                $('.keteranganError').text('');
                $('.respon').addClass('text-danger')
                $('.respon').html(data.metaData.message)
              }
            }

        if (data.metaData.code == 200) {
          $('#formSepPengajuan')[0].reset()
          $('.respon').removeClass('text-danger')
          $('.respon').addClass('text-success')
          $('.respon').html(data.metaData.message)
        }

      });

    }
    // ==========================================================

    function updateSEP() {
      $('#modalUpdateSEP').modal('show')
      $('.modal-title').text('Update SEP')
    }

    function updateSEP_Cari() {
      var sep = $('input[name="noSEP"]').val()
      if (sep == '') {
        alert('No. SEP Kosong')
      } else{
        $.ajax({
          url: '/bridgingsep/cariSep',
          type: 'POST',
          dataType: 'json',
          data: $('#formCariSEP').serialize(),
          beforeSend: function () {
            $('.progress').removeClass('hidden')
          },
          complete: function () {
            $('.progress').addClass('hidden')
          }
        })
        .done(function(json) {
          $('.viewForm').removeClass('hidden')
          getDokter()
          $('input[name="namaPasien"]').val(json.response.peserta.nama)
          $('input[name="noMr"]').val(json.response.peserta.noMr)
          $('input[name="noSep"]').val(json.response.noSep)
          $('input[name="catatan"]').val(json.response.catatan)
        })
      }

    }

    function getDokter() {
      $.ajax({
        url: '/bridgingsep/get-dokter-dpjp',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(json) {
        $('select[name="kodeDPJP"]').empty()
        $.each(json, function(index, val) {
           $('select[name="kodeDPJP"]').append('<option value="'+val.kode_bpjs+'">'+val.nama+'</option>')
        });
      });

    }


    // ==========================================================

// =============================================================

// ==============================================================
    function sepCari() {
      $('#sepCari').modal('show')
      $('input[name="noSEP"]').val('')
      $('.modal-title').text('Cari & Hapus SEP ')
      $('.respon').html('')
      $('.sepResponse').addClass('hidden')
      $('.noSEPGroup').removeClass('has-error')
      $('.noSEPError').text('')
    }

    function saveCariSEP() {
      $('.sepResponse').addClass('hidden')
      $('.progress').removeClass('hidden')
      $('.respon').html('')
      $.ajax({
        url: '/bridgingsep/cariSep',
        type: 'POST',
        dataType: 'json',
        data: $('#formsepCari').serialize(),
      })
      .done(function(data) {
        $('.progress').addClass('hidden')
        $('.sepResponse').addClass('hidden')
        if (data.metaData.code == 201) {
          if (data.metaData.error) {
            if (data.metaData.error.noSEP) {
              $('.noSEPGroup').addClass('has-error')
              $('.noSEPError').text(data.metaData.error.noSEP[0])
            }
          } else {
            $('.noSEPGroup').removeClass('has-error')
            $('.noSEPError').text('')
            $('.respon').addClass('text-danger')
            $('.respon').html(data.metaData.message)
          }

        }
        if (data.metaData.code == 200) {
          $('.noSEPGroup').removeClass('has-error')
          $('.noSEPError').text('')
          $('.respon').removeClass('text-danger')
          $('.respon').addClass('text-success')
          $('.respon').html(data.metaData.message)
          $('.sepResponse').removeClass('hidden')
          $('.respNama').text(data.response.peserta.nama)
          $('.respNoka').text(data.response.peserta.noKartu)
          $('.respNoRujukan').text(data.response.noRujukan)
          $('.respMr').text(data.response.peserta.noMr)
          $('.respJnsPelayanan').text(data.response.jnsPelayanan)
          $('.respTglLhr').text(data.response.peserta.tglLahir)
          $('.respKelas').text(data.response.peserta.hakKelas)
          $('.respJenisPeserta').text(data.response.peserta.jnsPeserta)
          $('.respCatatan').text(data.response.catatan)
          $('.respDiagnosa').text(data.response.diagnosa)
          $('#btnDelete').attr('onclick', 'saveSepHapus("'+data.response.noSep+'")');
        }
      });

    }
// ==========================================================================================
    function resetFormBuatRujukan() {
      $('.noSEPGroup').removeClass('has-error')
      $('.noSEPError').text('')
      $('.tglRujukanGroup').removeClass('has-error')
      $('.tglRujukanError').text('')
      $('.ppkDirujukGroup').removeClass('has-error')
      $('.ppkDirujukError').text('')
      $('.jnsPelayananGroup').removeClass('has-error')
      $('.jnsPelayananError').text('')
      $('.catatanGroup').removeClass('has-error')
      $('.catatanError').text('')
      $('.diagnosaRujukanGroup').removeClass('has-error')
      $('.diagnosaRujukanError').text('')
      $('.tipeRujukanGroup').removeClass('has-error')
      $('.tipeRujukanError').text('')
      $('.poliRujukanGroup').removeClass('has-error')
      $('.poliRujukanError').text('')
      $('.respon').removeClass('text-danger')
      $('.respon').html('')
    }
    function buatRujukankeRSLain() {
      resetFormBuatRujukan()
      getPoliRujukan()
      $('#rujukanKeRSLain').modal('show')
      $('.modal-title').text('Insert Rujukan ke RS Lain')
      $('.noSEPGroup').removeClass('has-error')
      $('.noSEPError').text('')
      $('.tglRujukanGroup').removeClass('has-error')
      $('.tglRujukanError').text('')
      $('.ppkDirujukGroup').removeClass('has-error')
      $('.ppkDirujukError').text('')
      $('.jnsPelayananGroup').removeClass('has-error')
      $('.jnsPelayananError').text('')
      $('.catatanGroup').removeClass('has-error')
      $('.catatanError').text('')
      $('.diagnosaRujukanGroup').removeClass('has-error')
      $('.diagnosaRujukanError').text('')
      $('.tipeRujukanGroup').removeClass('has-error')
      $('.tipeRujukanError').text('')
      $('.poliRujukanGroup').removeClass('has-error')
      $('.poliRujukanError').text('')
    }

    function getKodePPK() {
      $.ajax({
        url: '/bridgingsep/get-kode-ppk2',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(json) {
        $('select[name="ppkDirujuk"]').empty()
        $('select[name="ppkDirujuk"]').append('<option value="">[ -- ]</option>')
        $.each(json, function(index, val) {
           $('select[name="ppkDirujuk"]').append('<option value="'+val.kode_ppk+'">'+val.nama_ppk+'</option>')
        });
      });
    }

    function getPoliRujukan() {
      $.ajax({
        url: '/bridgingsep/get-poliRujukan/',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(json) {
        $('select[name="poliRujukan"]').empty()
        $('select[name="poliRujukan"]').append('<option value="">[ -- ]</option>')
        $.each(json, function(index, val) {
           $('select[name="poliRujukan"]').append('<option value="'+val.kode_poli+'">'+val.nama_poli+'</option>')
        });
      });
    }

    function saveRujukKeRSLain() {
      resetFormBuatRujukan()
      $('.progress').removeClass('hidden')
      $('.respon').html('')
      $.ajax({
        url: '/bridgingsep/insert-rujukan',
        type: 'POST',
        dataType: 'json',
        data: $('#formRujukanKeRSLain').serialize(),
      })
      .done(function(data) {
        $('.progress').addClass('hidden')
        if (data.metaData.code == 201) {
          if (data.metaData.error) {
            if (data.metaData.error.noSEP) {
              $('.noSEPGroup').addClass('has-error')
              $('.noSEPError').text(data.metaData.error.noSEP[0])
            }
            if (data.metaData.error.tglRujukan) {
              $('.tglRujukanGroup').addClass('has-error')
              $('.tglRujukanError').text(data.metaData.error.tglRujukan[0])
            }
            if (data.metaData.error.ppkDirujuk) {
              $('.ppkDirujukGroup').addClass('has-error')
              $('.ppkDirujukError').text(data.metaData.error.ppkDirujuk[0])
            }
            if (data.metaData.error.jnsPelayanan) {
              $('.jnsPelayananGroup').addClass('has-error')
              $('.jnsPelayananError').text(data.metaData.error.jnsPelayanan[0])
            }
            if (data.metaData.error.catatan) {
              $('.catatanGroup').addClass('has-error')
              $('.catatanError').text(data.metaData.error.catatan[0])
            }
            if (data.metaData.error.diagnosaRujukan) {
              $('.diagnosaRujukanGroup').addClass('has-error')
              $('.diagnosaRujukanError').text(data.metaData.error.diagnosaRujukan[0])
            }
            if (data.metaData.error.tipeRujukan) {
              $('.tipeRujukanGroup').addClass('has-error')
              $('.tipeRujukanError').text(data.metaData.error.tipeRujukan[0])
            }
            if (data.metaData.error.poliRujukan) {
              $('.poliRujukanGroup').addClass('has-error')
              $('.poliRujukanError').text(data.metaData.error.poliRujukan[0])
            }
          } else {
            $('.respon').addClass('text-danger')
            $('.respon').html(data.metaData.message)
          }
        }
        var _noSEP = $('input[name="noSEP"]').val();
        alert(_noSEP);
        //SUKSES
        if (data.metaData.code == 200) {
          window.location = "/bridgingsep/cetak-rujukan/"+data.metaData.noSEP;
        }
      });

    }

    $('#ppkDirujuk').select2({
      placeholder: "Pilih PPK...",
      ajax: {
          url: '/bridgingsep/get-kode-ppk2',
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

    function getPoliLanjutan() {
      $.ajax({
        url: '/bridgingsep/get-poli-lanjutan',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(resp) {

      });

    }


  </script>
@endsection