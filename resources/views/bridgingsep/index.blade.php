@extends('master')
@section('header')
  <h1>Pendaftaran - Integrasi SIMRS - WS Versi 2.0 SEP BPJS Kesehatan<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body"> 
      {{-- PENDAFTARAN --}}
      {{-- <table style="width:100%">
        <tr><td class="text-center" style="padding:5px;font-size:15px;"><b>PENDAFTARAN</b><hr/></td></tr>
        <tr>
          <td> 
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ url('/antrian/antrian') }}" ><img src="{{ asset('menu/fixed/rawatjalan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Rawat Jalan</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('/rawat-inap/admission') }}" ><img src="{{ asset('menu/fixed/rawatinap.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Rawat Inap</h5>
            </div> 
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a  href="{{ asset('frontoffice/rawat-darurat') }}" ><img src="{{ asset('menu/fixed/igd.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>IGD</h5>
            </div> 
          </td>
        </tr>
      </table> --}}
      {{-- SEP --}}
      <table style="width:100%">
        <tr><td class="text-center" style="padding:5px;font-size:15px;"><b>SEP</b><hr/></td></tr>
        <tr>
          <td>
            <div class="row">

              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a onclick="sepPengajuan()" ><img src="{{ asset('menu/fixed/pengajuan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
                </a>
                <h5>Pengajuan</h5>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a onclick="sepApproval()" ><img src="{{ asset('menu/fixed/approval.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
                </a>
                <h5>Approval</h5>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a onclick="sepUpdateTglPulang()" ><img src="{{ asset('menu/fixed/update_tgl_plg.png') }}" width="50px" heigth="50px" class="img-responsive" alt="""/>
                </a>
                <h5>Update Tgl Pulang</h5>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a href="updatesep" ><img src="{{ asset('menu/fixed/update_sep.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
                </a>
                <h5>Update SEP</h5>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a onclick="sepCari()" ><img src="{{ asset('menu/fixed/hapus_sep.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
                </a>
                <h5>Hapus SEP</h5>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a href="{{ asset('bridgingsep/sep-internal') }}" ><img src="{{ asset('menu/fixed/sep_internal.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
                </a>
                <h5>SEP Internal</h5>
              </div>
            </div>

            <div class="row">

              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a href="{{ url('bridgingsep/hapus-sep-internal') }}" ><img src="{{ asset('menu/fixed/hapus_sep.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
                </a>
                <h5>Hapus SEP Internal</h5>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a  href="{{ asset('bridgingsep/fingerprint') }}" ><img src="{{ asset('menu/fixed/list_fingerprint.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
                </a>
                <h5>List Fingerprint</h5>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a  href="{{ asset('bridgingsep/view-fingerprint') }}" ><img src="{{ asset('menu/fixed/view_fingerprint.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
                </a>
                <h5>View Fingerprint</h5>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a href="{{ asset('bridgingsep/sep-rk-spri') }}" ><img src="{{ asset('menu/fixed/rencana_kontrol.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
                </a>
                <h5>SEP/Rencana Kontrol/SPRI</h5>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a href="{{ asset('bridgingsep/sep-rencana-kontrol') }}" ><img src="{{ asset('menu/fixed/list_sep.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
                </a>
                <h5>List SEP Rencana Kontrol</h5>
              </div> 
              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a href="{{ asset('bridgingsep/sep-rencana-kontrol-no-kartu') }}" ><img src="{{ asset('menu/fixed/list_sep.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
                </a>
                <h5>Data Nomor SURKON Berdasarkan No Kartu</h5>
              </div> 
            </div> 
            
            <div class="row">
              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a href="{{ asset('bridgingsep/antrian-belum-dilayani') }}" ><img src="{{ asset('menu/jkn.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
                </a>
                <h5>Antrean Belum Dilayani</h5>
              </div>
              <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
                <a href="{{ asset('bridgingsep/antrian-belum-dilayani-poli') }}" ><img src="{{ asset('menu/jkn.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
                </a>
                <h5>Antrean Belum Dilayani Per Poli</h5>
              </div>

            </div>
          </td>
        </tr>
      </table>
      <br/>
      {{-- MONITORING --}}
      <table style="width:100%">
        <tr><td class="text-center" style="padding:5px;font-size:15px;border:"><b>MONITORING</b><hr/></td></tr>
        <tr>
          <td>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ url('/bridgingsep/data-kunjungan') }}" ><img src="{{ asset('menu/fixed/datakunjungan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Data Kunjungan</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/histori-kunjungan') }}" ><img src="{{ asset('menu/fixed/historipelayanan.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Histori Pelayanan Peserta</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/dashboard-pertanggal') }}" ><img src="{{ asset('menu/fixed/dashboard_pertanggal.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Dashboard Antrian Per Tanggal</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/dashboard-perbulan') }}" ><img src="{{ asset('menu/fixed/dashboard_perbulan.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Dashboard Antrian Per Bulan</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/list-taskid') }}" ><img src="{{ asset('menu/fixed/list_waktu.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>List Waktu TaskId</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/log-antrian') }}" ><img src="{{ asset('menu/fixed/pembuatanrujuk.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Log Antrian</h5>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/laporan-taskid') }}" ><img src="{{ asset('menu/fixed/list_sep.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Laporan Task ID</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/dashboard-koneksi') }}" ><img src="{{ asset('menu/fixed/list_sep.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Dashboard Koneksi</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/log-bed') }}" ><img src="{{ asset('menu/fixed/list_sep.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Log Bed</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/dashboard-antrianrate') }}" ><img src="{{ asset('menu/fixed/list_sep.png') }}" width="50px" heigth="50px"  width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Dashboard Antrian Rate</h5>
            </div>
          </td>
        </tr>
      </table>
      <br/>
       {{-- RUJUKAN --}}
       <table style="width:100%">
        <tr><td class="text-center" style="padding:5px;font-size:15px;border:"><b>RUJUKAN</b><hr/></td></tr>
        <tr>
          <td>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a onclick="buatRujukankeRSLain()" ><img src="{{ asset('menu/fixed/kirimrujukan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Kirim Rujukan Ke RS Lain</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/rujukan-spesialistik') }}" ><img src="{{ asset('menu/fixed/rujukanspesialis.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Rujukan Spesialistik</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a  href="{{ asset('bridgingsep/rujukan-khusus') }}" ><img src="{{ asset('menu/fixed/rujukankhusus.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Rujukan Khusus</h5>
            </div> 
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a  href="{{ asset('bridgingsep/sarana-rujukan') }}" ><img src="{{ asset('menu/fixed/saranarujukan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Sarana Rujukan</h5>
            </div> 
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ url('bridgingsep/rujuk-balik') }}" ><img src="{{ asset('menu/fixed/pembuatanrujuk.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Pembuatan Rujuk Balik (PRB)</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/update-rujukan') }}" ><img src="{{ asset('menu/fixed/updaterujukan.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Update Rujukan</h5>
            </div>
          </td>
        </tr>
      </table>
      <br/>
       {{-- REFERENSI --}}
       <table style="width:100%">
        <tr><td class="text-center" style="padding:5px;font-size:15px;border:"><b>REFERENSI</b><hr/></td></tr>
        <tr>
          <td>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/jadwal-dokter') }}" ><img src="{{ asset('menu/fixed/jadwaldokter.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Jadwal Dokter</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/jadwal-spesialistik') }}" ><img src="{{ asset('menu/fixed/jadwalspesialis.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Jadwal Spesialistik</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/suplesi') }}" ><img src="{{ asset('menu/fixed/suplesi.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Suplesi</h5>
            </div> 
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/jadwal-dokter-hfis') }}" ><img src="{{ asset('menu/fixed/dokterhfis.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Dokter HFIS</h5>
            </div>
          </td>
        </tr>
      </table>

      {{-- ANTREAN --}}
      <table style="width:100%">
        <tr><td class="text-center" style="padding:5px;font-size:15px;border:"><b>ANTREAN ONLINE</b><hr/></td></tr>
        <tr>
          <td>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/batal-antrol') }}" ><img src="{{ asset('menu/fixed/hapus_sep.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Batal Antrol</h5>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/hapus-antrol') }}" ><img src="{{ asset('menu/fixed/hapus_sep.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Hapus Antrol</h5>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/tambah-pasien-antrol') }}" ><img src="{{ asset('menu/fixed/hapus_sep.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Tambah Pasien</h5>
            </div>
            
            @if (Auth::user()->id == 1)
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/sinkron-taskid') }}" ><img src="{{ asset('menu/fixed/suplesi.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Sinkron Taskid</h5>
            </div>

            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/sinkron-taskid-tgl') }}" ><img src="{{ asset('menu/fixed/suplesi.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>Sinkron Taskid By Tgl</h5>
            </div>
                
            @endif
            
          </td>
        </tr>
      </table>
      
      
      {{-- <table style="width:100%">
        <tr><td class="text-center" style="padding:5px;font-size:15px;border:"><b>I-CARE</b><hr/></td></tr>
        <tr>
          <td>
            <div class="col-md-2 col-sm-3 col-xs-6 iconModule bpjs">
              <a href="{{ asset('bridgingsep/icare') }}" ><img src="{{ asset('menu/fixed/hapus_sep.png') }}" width="50px" heigth="50px" class="img-responsive" alt=""/>
              </a>
              <h5>FKRTL</h5>
            </div> 
          </td>
        </tr>
      </table> --}}
      
      {{-- <div class="col-md-2 col-sm-3 col-xs-6">
        <a onclick="updateSEP()" ><img src="{{ asset('menu/jkn.png') }}" width="50px" heigth="50px" class="img-responsive img-circle img-thumbnail" alt="" style="50%"/>
        </a>
        <h5>Update SEP</h5>
      </div> --}} 
     
    </div>
    <div class="box-footer">

    </div>
  </div>

@include('bridgingsep.form')

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

@endsection

@section('script')
  <script src="{{ asset('js/lz-string/libs/lz-string.js') }}"></script>
  <script type="text/javascript">
    $('.surat_meninggal').hide();
    function kondisi(a){
      if(a.value == 4){
        $('.surat_meninggal').show();
      }else{
        $('.surat_meninggal').hide();
      }
    }
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
        // data: $('#formSepPengajuan').serialize(),
        data: {
          data : LZString.compressToBase64($('#formSepPengajuan').serialize()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
          },
      })
      .done(function(res) {
         
        data = JSON.parse(res)
        // console.log(data)
        $('.progress').addClass('hidden')
        
          if (data[0].metaData.code == 201) {
            if (data[0].metaData.error) {
              if (data[0].metaData.error.noKartu) {
                $('.nokaGroup').addClass('has-error')
                $('.nokaError').text(data[0].metaData.error.noKartu[0]);
              }
              if (data[0].metaData.error.tglSep) {
                $('.tglSepGroup').addClass('has-error')
                $('.tglSepError').text(data[0].metaData.error.tglSep[0]);
              }
              if (data[0].metaData.error.keterangan) {
                  $('.keteranganGroup').addClass('has-error')
                  $('.keteranganError').text(data[0].metaData.error.keterangan[0]);
                }
              } else {
                $('.nokaGroup').removeClass('has-error')
                $('.nokaError').text('');
                $('.tglSepGroup').removeClass('has-error')
                $('.tglSepError').text('');
                $('.keteranganGroup').removeClass('has-error')
                $('.keteranganError').text('');
                $('.respon').addClass('text-danger')
                $('.respon').html(data[0].metaData.message)
              }
            }

            if(data[0].metaData.code == 404){
              return alert(data[0].metaData.message)
            }

        if (data[0].metaData.code == 200) {
          $('#formSepPengajuan')[0].reset()
          $('.respon').removeClass('text-danger')
          $('.respon').addClass('text-success')
          $('.respon').html(data[0].metaData.message)
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

    function sepApproval() {
      $('#sepApproval').modal({ backdrop: 'static', keyboard: false })
      $('.modal-title').text('Approval SEP')
      $('.respon').html('')
      //SHOW DATA
      var table;
      table = $('.table').DataTable({
        autoWidth: false,
        destroy: true,
        processing: true,
        serverSide: true,
        ordering: false,
        searching: false,
        ajax: '{{ url('bridgingsep/data-pengajuan-sep') }}',
        columns: [
            {data: 'no_kartu'},
            {data: 'tanggal_sep'},
            {data: 'jenisPelayanan'},
            {data: 'keterangan'},
            {data: 'approve'}
        ]
      });

    }

    // V2
    function saveApproval(id) {
      $('.progress').removeClass('hidden')
      $('.respon').html('')
      $.ajax({
        url: '/bridgingsep/approveSEP/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(res) {
        data = JSON.parse(res) 
        console.log()
        $('.progress').addClass('hidden')
        if (data[0].metaData.code !== 200) {
            $('.respon').addClass('text-danger')
            $('.respon').html(data[0].metaData.message)
            return
        }
        if (data[0].metaData.code == 200) {
          sepApproval()
          $('.respon').removeClass('text-danger')
          $('.respon').addClass('text-success')
          $('.respon').html(data[0].metaData.message)

        }
      });

    }
// =============================================================
    function sepUpdateTglPulang() {
      $('#sepUpdateTglPulang').modal('show')
      $('.modal-title').text('Update Tanggal Pulang')
      $('.respon').removeClass('text-danger')
      $('.respon').html('')
      $('.noSepGroup').removeClass('has-error')
      $('.noSepError').text('')
      $('.tglSepGroup').removeClass('has-error')
      $('.tglSepError').text('')
    }

    function saveUpdateTanggalPulang() {
      $('.progress').removeClass('hidden')
      $('.respon').html('')
      $.ajax({
        url: '/bridgingsep/updateTanggalPulang',
        type: 'POST',
        dataType: 'json',
        data: $('#formsepUpdateTglPulang').serialize(),
      })
      .done(function(res) {
        data = JSON.parse(res)
        console.log(data);
        $('.progress').addClass('hidden')
        if (data[0].metaData.code !== '200') {
           return alert(data[0].metaData.message)
        }
        if (data[0].metaData.code == '200') {
          $('.respon').removeClass('text-danger')
          $('.respon').addClass('text-success')
          $('.respon').html(data[0].metaData.message)
          return alert('Berhasil update tanggal pulang')
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
          if (data[0].metaData.code == '201') {
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
          if (data[0].metaData.code == '200') {
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
        url: '/bridgingsep/insert-rujukan-2',
        type: 'POST',
        dataType: 'json',
        data: $('#formRujukanKeRSLain').serialize(),
      })
      .done(function(res) {
        data = JSON.parse(res)
        console.log(res);
        $('.progress').addClass('hidden')

        if (data[0].metaData.code == '201') {
          return alert(data[0].metaData.message) 
        }
        // var _noSEP = $('input[name="noSEP"]').val();
        // alert(_noSEP);
        //SUKSES
        if (data[0].metaData.code == '200') {
          console.log(data)
          window.location = "/bridgingsep/cetak-rujukan/"+data[0].metaData.message;
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
