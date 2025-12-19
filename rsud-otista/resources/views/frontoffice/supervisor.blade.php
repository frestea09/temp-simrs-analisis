@extends('master')
@section('header')
  <h1>Pendaftaran Rawat Jalan - Supervisor <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      @role(['supervisor', 'administrator'])
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('/jadwal-dokter') }}" ><img src="{{ asset('menu/fixed/jadwaldokter.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Jadwal Dokter</h5>
      </div>
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('frontoffice/input_diagnosa_rawatjalan') }}" ><img src="{{ asset('menu/fixed/diagnosa.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Diagnosa IRJ</h5>
      </div>
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('frontoffice/input_diagnosa_rawatinap') }}" ><img src="{{ asset('menu/fixed/diagnosa.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Diagnosa IRNA</h5>
      </div>
      @endrole
      @role(['supervisor-rekammedis', 'supervisor', 'administrator'])
      <div class="col-sm-3 text-center iconModule">
        <a onclick="mergeRM()"><img src="{{ asset('menu/fixed/mergerm.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Merge RM</h5>
      </div>
      @endrole
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('/frontoffice/supervisor/ubahdpjp') }}" ><img src="{{ asset('menu/fixed/ubahdpjp.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Ubah DPJP</h5>
      </div>
      @if ( json_decode(Auth::user()->is_edit,true)['hapus'] == 1)
      <div class="col-sm-3 text-center iconModule">
        <a href="/frontoffice/supervisor/hapusregistrasi" ><img src="{{ asset('menu/fixed/hapuspendaftaran.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Hapus Pendaftaran</h5>
      </div>
      <div class="col-sm-3  text-center iconModule">
        <a onclick="sepCari()" ><img src="{{ asset('menu/fixed/hapus_sep.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Hapus SEP</h5>
      </div>
      @endif
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('/pasien') }}" ><img src="{{ asset('menu/fixed/datapasien.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Data Pasien</h5>
      </div>
      {{-- <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('/pasien/rekam-medis') }}" ><img src="{{ asset('menu/fixed/rekammedis.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Rekam Medis Pasien</h5>
      </div> --}}
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('/regperjanjian') }}" ><img src="{{ asset('menu/fixed/pendaftaranperjanjian.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Pendaftaran Perjanjian</h5>
      </div>
      @if (in_array(Auth::user()->id, [1, 566, 627, 574]))
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('/frontoffice/setting-kuota-poli') }}" ><img src="{{ asset('menu/fixed/settingloket.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Setting Loket Antrian </h5>
      </div>
      @endif
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('/frontoffice/setting-kuota-dokter') }}" ><img src="{{ asset('menu/fixed/settingloket.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Setting Loket Antrian Dokter</h5>
      </div>
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('/pendaftaran/pendaftaran-online') }}" ><img src="{{ asset('menu/fixed/pendaftaranonline.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Pendaftaran Online</h5>
      </div>
      
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('mastermapping') }}" ><img src="{{ asset('menu/fixed/mappingtarifinacbg.png') }}" width="50px" heigth="50px"  class="img-responsive" alt=""/>
        </a>
        <h5>Mapping Tarif INACBG</h5>
      </div>
     
      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('/pasien/riwayat-status-pasien') }}" ><img src="{{ asset('menu/fixed/rekappengunjung.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Riwayat Status Pasien</h5>
      </div>

      <div class="col-sm-3 text-center iconModule">
        <a href="{{ url('/frontoffice/riwayat-hapus-tindakan') }}" ><img src="{{ asset('menu/fixed/list_waktu.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
        </a>
        <h5>Histori Hapus Tindakan</h5>
      </div>
      
    </div>
    <div class="box-footer">

    </div>
  </div>

  @include('bridgingsep.form')

  {{-- MERGE RM --}}
  <div class="modal fade" id="modalMergeRM">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formMerge" class="form-horizontal">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="table-responsive">
              <table class="table table-hover table-condensed table-bordered">
                <thead>
                  <tr>
                    <th>NO. RM</th>
                    <th>NAMA</th>
                    <th>ALAMAT</th>
                    <th>EDIT</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <div class="col-sm-5 pull-left bg-primary bgError" style="padding-top: 5px">
              <div class="form-group">
                <label for="utama" class="col-sm-4 control-label">RM UTAMA</label>
                <div class="col-sm-8">
                  <input type="text" name="rmUtama" class="form-control">
                  <small class="errorRMUtama"></small>
                </div>
              </div>
            </div>
          </form>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <div class="pull-left text-info">
            <i><b> *) Ketik nama dan alamat di kolom cari! <br> *) Ketik RM yang akan di pakai di kolom RM UTAMA!</b></i>
          </div>
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">TUTUP</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="saveMergeRM()">GABUNGKAN</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('script')
  <script src="{{ asset('js/lz-string/libs/lz-string.js') }}"></script>
  <script type="text/javascript">
    function mergeRM() {
      $('#modalMergeRM').modal('show');
      $('.modal-title').text('Merge Nomor RM');
      $('input[name="rmUtama"]').val('');
      $('.bgError').addClass('bg-primary');
      $('.bgError').removeClass('bg-danger has-error');
      $('.errorRMUtama').text('')
      $('.table').DataTable({
          "language": {
              "url": "/json/obat.datatable-language.json",
          },
          page:{
            "pagingType": "simple",
          },
          destroy: true,
          pageLength: 5,
          autoWidth: false,
          processing: true,
          serverSide: true,
          lengthChange: false,
          info: false,
          ajax: '/frontoffice/get-rm',
          columns: [
              {data: 'no_rm', orderable: false},
              {data: 'nama', orderable: false},
              {data: 'alamat', orderable: false},
              {data: 'edit', orderable: false, sClass: 'text-center iconModule'},
          ]
      });

    }

    function saveMergeRM() {
      data = $('#formMerge').serialize();
      $.ajax({
        url: '/frontoffice/save-merge-rm',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function (data) {
            if (data.sukses == false) {
              $('.bgError').removeClass('bg-primary');
              $('.bgError').addClass('bg-danger has-error');
              $('input[name="rmUtama"]').focus();
              $('.errorRMUtama').text(data.error.rmUtama[0])
            }

            if (data.sukses == true) {
              $('#modalMergeRM').modal('hide');
              location.reload();
            }
        }
      });

    }

    // =====================================================
    function sepHapus() {
      $('#sepHapus').modal('show')
      $('.modal-title').text('Hapus SEP')
      $('.respon').removeClass('text-danger')
      $('.respon').html('')
      $('.noSEPGroup').removeClass('has-error')
      $('.noSEPError').text('')
    }

    function saveSepHapus(sep) {
      if (confirm('Yakin No. SEP: '+sep+' akan di hapus?')) {
          $('.progress').removeClass('hidden')
        $('.respon').html('')
        $.ajax({
          url: '/bridgingsep/sepHapus/'+sep,
          type: 'GET',
          dataType: 'json',
        })
        .done(function(res) {
          data = JSON.parse(res)
          $('.progress').addClass('hidden')
          if (data[0].metaData.code == 201) {
            if (data[0].metaData.error) {
              if (data[0].metaData.error.noSEP) {
                $('.noSEPGroup').addClass('has-error')
                $('.noSEPError').text(data[0].metaData.error.noSEP[0])
              }
            } else {
              $('.noSEPGroup').removeClass('has-error')
              $('.noSEPError').text('')
              $('.respon').addClass('text-danger')
              $('.respon').html(data[0].metaData.message)
            }

          }
          if (data[0].metaData.code == 200) {
            $('#sepCari').modal('hide')
            alert('SEP berhasil di hapus')
            $('.respon').removeClass('text-danger')
            $('.respon').addClass('text-success')
            $('.respon').html(data[0].metaData.message)
          }
        });
      }

    }
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
      .done(function(res) {
        data = JSON.parse(res)
        
        $('.progress').addClass('hidden')
        $('.sepResponse').addClass('hidden')
        if (data[0].metaData.code == 201) {
          if (data[0].metaData.error) {
            if (data[0].metaData.error.noSEP) {
              $('.noSEPGroup').addClass('has-error')
              $('.noSEPError').text(data[0].metaData.error.noSEP[0])
            }
          } else {
            $('.noSEPGroup').removeClass('has-error')
            $('.noSEPError').text('')
            $('.respon').addClass('text-danger')
            $('.respon').html(data[0].metaData.message)
          }

        }
        if (data[0].metaData.code == 200) {
          $('.noSEPGroup').removeClass('has-error')
          $('.noSEPError').text('')
          $('.respon').removeClass('text-danger')
          $('.respon').addClass('text-success')
          $('.respon').html(data[0].metaData.message)
          $('.sepResponse').removeClass('hidden')
          $('.respNama').text(data[1].peserta.nama)
          $('.respNoka').text(data[1].peserta.noKartu)
          $('.respNoRujukan').text(data[1].noRujukan)
          $('.respMr').text(data[1].peserta.noMr)
          $('.respJnsPelayanan').text(data[1].jnsPelayanan)
          $('.respTglLhr').text(data[1].peserta.tglLahir)
          $('.respKelas').text(data[1].peserta.hakKelas)
          $('.respJenisPeserta').text(data[1].peserta.jnsPeserta)
          $('.respCatatan').text(data[1].catatan)
          $('.respDiagnosa').text(data[1].diagnosa)
          $('#btnDelete').attr('onclick', 'saveSepHapus("'+data[1].noSep+'")');
        }
      });

    }

  </script>
@endsection
