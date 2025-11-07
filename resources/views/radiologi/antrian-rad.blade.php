@extends('master')

@section('header')
    <h1>Radiologi {{ date('d-m-Y') }}</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                Belum Diperiksa &nbsp;
            </h3>
        </div>
        <div class="box-body" id="tableAntrianBelumPeriksa">

        </div>
        Keterangan <br>
        <button type="button" class="btn btn-sm btn-success btn-flat">
            <i class="fa fa-check"></i>
        </button> Tandai Selesai/Sudah di Proses
        &nbsp; &nbsp; &nbsp; &nbsp;
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                Sudah Diperiksa &nbsp;
            </h3>
        </div>
        <div class="box-body">
            <div class='table-responsive' id="tableAntrianSudahPeriksa">
            </div>
        </div>
    </div>

    {{-- Modal Expertise --}}
    <div class="modal fade" id="ekspertiseModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form method="POST" class="form-horizontal" id="formEkspertise">
                        {{ csrf_field() }}
                        <input type="hidden" name="registrasi_id" value="">
                        <input type="hidden" name="ekspertise_id" value="">
                        <input type="hidden" name="poli_id" value="{{ poliRadiologi() }}">

                        <div class="table-responsive">
                            <table class="table-condensed table-bordered table">
                                <tbody>
                                    <tr>
                                        <th>Nama Pasien </th>
                                        <td class="nama"></td>
                                        <th>Jenis Kelamin </th>
                                        <td class="jk" colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <th>Umur </th>
                                        <td class="umur"></td>
                                        <th>No. RM </th>
                                        <td class="no_rm" colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <th>Pemeriksaan</th>
                                        <td>
                                            {{-- <ol class="pemeriksaan"></ol>   --}}
                                            <div id="tindakanPeriksa"></div>
                                        </td>
                                        <th>Tanggal Pemeriksaan </th>
                                        <td>
                                            {{-- <div id="tglPeriksa"></div> --}}
                                            {!! Form::text('tglPeriksa', null, [
                                                'class' => 'form-control datepicker ',
                                                'placeholder' => 'Jika kosong, otomatis tgl hari ini',
                                                'required' => 'required',
                                            ]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Diagnosa</th>
                                        <td>
                                            <div id="diagnosa"></div>
                                        </td>
                                        <th>No Foto </th>
                                        <td>
                                            <div id="no_foto"></div>
                                        </td>
                                    </tr>
                                    @php
                                        $data['dokters_poli'] = Modules\Poli\Entities\Poli::where('id', 1)->pluck(
                                            'dokter_id',
                                        );
                                        $data['perawats_poli'] = Modules\Poli\Entities\Poli::where('id', 1)->pluck(
                                            'perawat_id',
                                        );
                                        $dokter_pengirim = Modules\Pegawai\Entities\Pegawai::where(
                                            'kategori_pegawai',
                                            1,
                                        )->get();
                                        $dokter = explode(',', $data['dokters_poli'][0]);
                                    @endphp
                                    <tr>
                                        <th>Dokter</th>
                                        <td>
                                            <select name="dokter_id" class="form-control select2" style="width: 100%">
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d }}">{{ baca_dokter($d) }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <th>Dokter Pengirim</th>
                                        <td>
                                            <select name="dokter_pengirim" class="form-control select2" style="width: 100%">
                                                @foreach ($dokter_pengirim as $d)
                                                    <option value="{{ $d->id }}">{{ baca_dokter($d->id) }}</option>
                                                @endforeach
                                            </select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <td>
                                            {{-- <input type="text" name="klinis" class="form-control"> --}}
                                        </td>
                                        <th>Tanggal Ekspertise </th>
                                        <td colspan="">
                                            {!! Form::text('tanggal_eksp', null, [
                                                'class' => 'form-control datepicker ',
                                                'placeholder' => 'Jika kosong, otomatis tgl hari ini',
                                                'required' => 'required',
                                            ]) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ekspertise</th>
                                        <td colspan="3" rowspan="6">
                                            <textarea name="ekspertise" class="form-control ekspertise" style="height: 500">  </textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-flat" onclick="saveEkpertise()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pemeriksaanModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form method="POST" class="form-horizontal" id="form">
                        <table class="table-condensed table-bordered table">
                            <thead>
                                <tr>
                                    <th>Tindakan</th>
                                    <th>Tgl</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody id="catatanTable">
                                
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pemeriksaanModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-scrollable" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <form method="POST" class="form-horizontal" id="form">
                <table class="table table-condensed table-bordered">
                  <tbody>
                      <tr>
                        <th>Tanggal Order :<input class="form-control" name="waktu" redonly> </th> 
                      </tr>
                      <tr>
                        <td>
                          <textarea name="pemeriksaan" class="form-control wysiwyg"></textarea>
                        </td>
                      </tr>
                  </tbody>
                </table>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
    </div>


@stop

@section('script')
    <script type="text/javascript">
        $('.select2').select2();

        function blink() {
            $('.blink_me').fadeOut(500).fadeIn(500, blink);
        }
        $(document).ready(function() {
            refreshTable();
            setInterval(() => {
                refreshTable();
            }, 15000);
        })

        function refreshTable() {
            $('#tableAntrianBelumPeriksa').load('/radiologi/antrian-belum-periksa');
            $('#tableAntrianSudahPeriksa').load('/radiologi/antrian-sudah-periksa');
        }

        function markAsDone(service_notif_id) {
            $.get('/radiologi/tandai-selesai/' + service_notif_id, function(response) {
                    if (response.success == true) {
                        refreshTable();
                    } else {
                        alert('Gagal! ' + response.error)
                    }
                })
                .fail(function(xhr, status, error) {
                    console.error(status, error);
                });
        }
    </script>

    {{-- radiologi script --}}
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script type="text/javascript">
        $('.select2').select2();

        // CKEDITOR.replace('pemeriksaan', {
        //     height: 200,
        //     filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        //     filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
        // });

        function showNote(id) {
            $('#pemeriksaanModel').modal()
            $('.modal-title').text('Catataan Order Radiologi')
            $("#form")[0].reset()
            $.ajax({
                    url: '/radiologi/showNoteReg/' + id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    $('#catatanTable').html('')
                    $.each(data, function(index, item) {
                        var row = $('<tr>');
                        $('<td>').text(item.namatarif).appendTo(row);
                        $('<td>').text(item.embalase).appendTo(row);
                        $('<td>').text(item.catatan).appendTo(row);
                        row.appendTo('#catatanTable');
                    });
                })
                .fail(function(xhr, status, error) {
                    alert('An error occurred while processing your request. Please try again later.');
                    console.error(xhr, status, error);
                });

        }

        function saveNote() {
            var id_reg = $('input[name="id_reg"]').val();

            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/radiologi/updateNoteReg/' + id_reg,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        catatan: $('input[name="catatan"]').val(),
                        tgl_order: $('input[name="tgl_order"]').val()
                    }
                })
                .done(function(data) {
                    alert('berhasil simpan catatan')
                })
                .fail(function() {
                    alert('gagal input');
                });

        }

        //CKEDITOR
        // CKEDITOR.replace( 'ekspertise', {
        //   height: 200,
        //   filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        //   filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
        // });

        function new_ekspertise(id) {
            $('#ekspertiseModal').modal({
                backdrop: 'static',
                keyboard: false,
            })
            $('.modal-title').text('Tambah Ekpertise Rajal')
            $("#formEkspertise")[0].reset()
            $('input[name="ekspertise_id"]').val('');
            $('input[name="ekspertise"]').val();
            $('#tglPeriksa').empty();
            $.ajax({
                    url: '/radiologi/dokter/' + id,
                    type: 'GET',
                    dataType: 'html',
                })
                .done(function(res) {
                    console.log(res)
                    $('#dokter').html(res);
                    //$('#registrasi_id').html(res);

                })
                .fail(function() {

                });
            $.ajax({
                    url: '/radiologi/tindakan/' + id,
                    type: 'GET',
                    dataType: 'html',
                })
                .done(function(res) {
                    console.log(res)
                    $('#tindakanPeriksa').html(res);
                    //$('#registrasi_id').html(res);

                })
                .fail(function() {

                });
            $.ajax({
                    url: '/radiologi/diagnosa/' + id,
                    type: 'GET',
                    dataType: 'html',
                })
                .done(function(res) {
                    console.log(res)
                    $('#diagnosa').html(res);
                    //$('#registrasi_id').html(res);

                })
                .fail(function() {

                });
            $.ajax({
                    url: '/radiologi/no_foto/' + id,
                    type: 'GET',
                    dataType: 'html',
                })
                .done(function(res) {
                    console.log(res)
                    $('#no_foto').html(res);
                    //$('#registrasi_id').html(res);

                })
                .fail(function() {

                });


            $.ajax({
                    url: '/radiologi/ekspertise/' + id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    console.log(data)
                    $('.nama').text(data.reg.pasien.nama)
                    $('.no_rm').text(data.reg.pasien.no_rm)
                    $('.umur').text(data.umur)
                    $('.jk').text(data.reg.pasien.kelamin)
                    $('input[name="tglPeriksa"]').val(data.ep.tglPeriksa)
                    $('input[name="klinis"]').val()
                    $('input[name="ekspertise"]').val()
                    $('input[name="registrasi_id"]').val(data.reg.id)
                    $('input[name="tanggal_eksp"]').val(data.tanggal)
                    if (data.rad) {
                        $('select[name="dokter_id"]').val(data.rad.dokter_pelaksana).trigger('change')
                    }
                    $('select[name="dokter_pengirim"]').val(data.reg.dokter_id).trigger('change')
                    // $('#tindakanPeriksa').empty();
                    // $('#tglPeriksa').empty();
                    // $('.pemeriksaan').empty()
                    // $('.tgl_priksa').empty()
                })
                .fail(function() {

                });
        }

        let optionPeriksa = '';
        let tglPeriksa = '';

        function ekspertise(reg_id, id) {
            $('#ekspertiseModal').modal({
                backdrop: 'static',
                keyboard: false,
            })
            $('.modal-title').text('Input Ekpertise')
            $("#formEkspertise")[0].reset()


            $.ajax({
                    url: '/radiologi/tindakan/' + reg_id,
                    type: 'GET',
                    dataType: 'html',
                })
                .done(function(res) {
                    console.log(res)
                    $('#tindakanPeriksa').html(res);
                    //$('#registrasi_id').html(res);

                })
                .fail(function() {

                });
            $.ajax({
                    url: '/radiologi/diagnosa/' + reg_id,
                    type: 'GET',
                    dataType: 'html',
                })
                .done(function(res) {
                    console.log(res)
                    $('#diagnosa').html(res);
                    //$('#registrasi_id').html(res);

                })
                .fail(function() {

                });
            $.ajax({
                    url: '/radiologi/no_foto/' + reg_id,
                    type: 'GET',
                    dataType: 'html',
                })
                .done(function(res) {
                    console.log(res)
                    $('#no_foto').html(res);
                    //$('#registrasi_id').html(res);

                })
                .fail(function() {

                });


            $.ajax({
                    url: '/radiologi/dokter/' + reg_id,
                    type: 'GET',
                    dataType: 'html',
                })
                .done(function(res) {
                    console.log(res)
                    $('#dokter').html(res);
                    //$('#registrasi_id').html(res);

                })
                .fail(function() {

                });


            $.ajax({
                    url: '/radiologi/ekspertise/' + reg_id + '/' + id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    // alert(data)
                    $('.nama').text(data.reg.pasien.nama)
                    $('.no_rm').text(data.reg.pasien.no_rm)
                    $('.umur').text(data.umur)
                    $('.jk').text(data.reg.pasien.kelamin)
                    $('input[name="tglPeriksa"]').val(data.ep.tglPeriksa)
                    $('input[name="registrasi_id"]').val(data.reg.id)
                    $('.ekspertise').val(data.ep.ekspertise)
                    $('input[name="klinis"]').val(data.ep.klinis)
                    $('input[name="tanggal_eksp"]').val(data.tanggal)
                    $('select[name="dokter_id"]').val(data.ep.dokter_id).trigger('change')
                    $('select[name="dokter_pengirim"]').val(data.reg.dokter_id).trigger('change')
                    $('#tglPeriksa').html(tglPeriksa);
                    if (data.ep != '') {
                        $('input[name="ekspertise_id"]').val(data.ep.id)
                        $('input[name="no_dokument"]').val(data.ep.no_dokument)
                        $('input[name="ekspertise"]').val()
                    }
                })
                .fail(function() {

                });
        }

        $(document).on('change', 'select[name="tindakan_id"]', function() {
            let tgl = $(this).find(':selected').attr('data_tgl');
            $('#tglPeriksa').html(tgl);
        })

        function coba(registrasi_id) {
            $('#pemeriksaanModal').modal({
                backdrop: 'static',
                keyboard: false,
            })
            $('.modal-title').text('Catataan Order Radiologi')
            $("#form")[0].reset()
            CKEDITOR.instances['pemeriksaan'].setData('')
            $.ajax({
                    url: '/radiologi/catatan-pasien/' + registrasi_id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    $('input[name="waktu"]').val(data.created_at)
                    $('input[name="ekspertise"]').val()
                })
                .fail(function() {

                });
        }

        function saveEkpertise() {
            var token = $('input[name="_token"]').val();
            var ekspertise = $('input[name="ekspertise"]').val()
            var form_data = new FormData($("#formEkspertise")[0])


            $.ajax({
                    url: '/radiologi/ekspertise-baru',
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
                        alert('Ekspertise RAJAL berhasil disimpan.')
                        window.location.reload();
                        window.open('/radiologi/cetak-ekpertise/' + resp.data.id + '/' + resp.data.registrasi_id + '/' +
                            resp.data.folio_id)
                    } else {
                        return alert(resp.data)
                    }

                });
        }

        function pemeriksaan_tindakan(registrasi_id) {
            $('#pemeriksaanModal').modal('show');
            $('.modal-title').text('Radiologi Tindakan');
            $('#detailTindakan').load('/radiologi/tambah-ekspertise/' + registrasi_id);
        }
    </script>
@endsection
