@extends('master')

@section('header')
    <h1>Sistem RAWAT JALAN</h1>
@endsection

@section('css')
    <style>
        .blink_red {
            color: rgb(229, 34, 56);
            font-weight: bold;
            animation: blinker 2s linear infinite;
        }
        
        @keyframes blinker {
            50% {
            opacity: 0;
            }
        }
        .text-red {
            color: red;
        }
    </style>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            {{-- <h4 class="box-title">
          Periode Tanggal: {{ date('d-m-Y') }}&nbsp;
        </h4> --}}
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'POST', 'url' => 'tindakan', 'class' => 'form-hosizontal']) !!}
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                                type="button">Tanggal</button>
                        </span>
                        {!! Form::text('tga', $tga, [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'autocomplete' => 'off',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Sampai Tanggal</button>
                        </span>
                        {!! Form::text('tgb', $tgb, [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'autocomplete' => 'off',
                            'onchange' => 'this.form.submit()',
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('jenis_reg') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('jenis_reg') ? ' has-error' : '' }}"
                                type="button">Filter Pendaftaran</button>
                        </span>
                        <select name="filter_reg" id="" class="form-control select2" onchange="this.form.submit()">
                            <option value="Semua" {{$filter_reg == 'Semua' ? 'selected' : ''}}>Semua</option>
                            <option value="Pendaftaran Onsite" {{$filter_reg == 'Pendaftaran Onsite' ? 'selected' : ''}}>Pendaftaran Onsite</option>
                            <option value="Pendaftaran Online" {{$filter_reg == 'Pendaftaran Online' ? 'selected' : ''}}>Pendaftaran Online</option>
                            <option value="registrasi-ranap-langsung" {{$filter_reg == 'registrasi-ranap-langsung' ? 'selected' : ''}}>Registrasi Ranap Langsung</option>
                            <option value="regperjanjian" {{$filter_reg == 'regperjanjian' ? 'selected' : ''}}>Registrasi Perjanjian</option>
                            <option value="Registrasi" {{$filter_reg == 'Registrasi' ? 'selected' : ''}}>Registrasi</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('jenis_reg') }}</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('filter_poli') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('filter_poli') ? ' has-error' : '' }}"
                                type="button">Filter Poli</button>
                        </span>
                        <select name="filter_poli" id="" class="form-control select2" onchange="this.form.submit()">
                            <option value="" {{empty($filter_poli) ? 'selected' : ''}}>-</option>
                            @foreach ($poli as $key => $value)
                                <option value="{{$key}}" {{@$filter_poli == $key ? 'selected' : ''}}>{{$value}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('filter_poli') }}</small>
                    </div>
                </div>
                <br><br><br>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">DPJP</button>
                        </span>
                        <select name="dokter_id" class="form-control select2" style="width: 100%" onchange="this.form.submit()">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach ($dokters as $dokter)
                                <option value="{{ $dokter->id }}" {{ $dokter->id == @$dokter_filter ? 'selected' : ''}}>{{ $dokter->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <br>
           
            {!! Form::close() !!}
            <hr>
            <span style="color:red">*</span> Baris tabel yang berwarna merah artinya <b>Pasien belum terbit SEP</b>
            @include('tindakan::view_ajax')

        </div>
    </div>

    {{-- Modal Eresep --}}
    

    <div id="myModalHistoryResep" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">History E-Resep</h4>
                </div>
                <div class="modal-body" id="listHistoryResep">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modal_md" role="dialog" aria-labelledby="" aria-hidden="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
            </div>
        </div>
    </div>


    {{-- <div class="modal fade" id="suratPri" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form method="POST" class="form-horizontal" id="formSPRI">
                        {{ csrf_field() }}
                        <input type="hidden" name="registrasi_id" value="">
                        <input type="hidden" name="id" value="">
                        <div class="table-responsive">
                            <table class="table-condensed table-bordered table">
                                <tbody>
                                    <tr>
                                        <th>Nama Pasien </th>
                                        <td class="nama"></td>
                                        <th>Umur </th>
                                        <td class="umur"></td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin </th>
                                        <td class="jk" colspan="1"></td>
                                        <th>No. RM </th>
                                        <td class="no_rm" colspan="2"></td>
                                    </tr>

                                    <tr>
                                        <th>Dokter Rawat</th>
                                        <td>
                                            <select name="dokter_rawat" class="form-control select2" style="width: 100%">
                                                @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                                                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <th>Dokter Pengirim</th>
                                        <td>
                                            <select name="dokter_pengirim" class="form-control select2"
                                                style="width: 100%">
                                                @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                                                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kamar</th>
                                        <td>
                                            <select name="jenis_kamar" class="form-control select2" style="width: 100%">
                                                @foreach (\Modules\Kamar\Entities\Kamar::all() as $d)
                                                    <option value="{{ $d->id }}">{{ @$d->kode }} |
                                                        {{ @$d->kelompokkelas->kelompok }} |{{ @$d->kelas->nama }}
                                                        |{{ @$d->nama }} | </option>
                                                @endforeach
                                            </select> 
                                        </td>
                                        <th>Cara Bayar</th>
                                        <td>
                                            <select name="cara_bayar" class="form-control select2" style="width: 100%">
                                                @foreach (\Modules\Registrasi\Entities\Carabayar::all() as $d)
                                                    <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tgl Rencana Kontrol <label class="text-danger">*</label></th>
                                        <td>
                                            <div
                                                class="input-group{{ $errors->has('tglRencanaKontrol') ? ' has-error' : '' }}">
                                                <span class="input-group-btn">
                                                    <button
                                                        class="btn btn-default{{ $errors->has('tglRencanaKontrol') ? ' has-error' : '' }}"
                                                        type="button">Tanggal</button>
                                                </span>
                                                {!! Form::text('tglRencanaKontrol', date('d-m-Y'), [
                                                    'class' => 'form-control datepicker',
                                                    'required' => 'required',
                                                    'autocomplete' => 'off',
                                                ]) !!}
                                                <small
                                                    class="text-danger">{{ $errors->first('tglRencanaKontrol') }}</small>
                                            </div>
                                        </td>

                                        <th>No. Kartu<label class="text-danger">*</label></th>
                                        <td>
                                            <div class="input-group{{ $errors->has('no_jkn') ? ' has-error' : '' }}">
                                                {!! Form::text('no_jkn', null, ['class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off']) !!}
                                                <small class="text-danger">{{ $errors->first('no_jkn') }}</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Diagnosa</th>
                                        <td colspan="3">
                                            <textarea name="diagnosa" class="form-control wysiwyg"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>SPRI</th>
                                        <td colspan="3">
                                            <div class="col-sm-2" style="padding-left:0">
                                                <button type="button" id="createSPRI"
                                                    class="btn btn-primary btn-flat"><i class="fa fa-recycle"></i> BUAT
                                                    SPRI</button>
                                            </div>
                                            <div class="col-sm-5" id="fieldSPRI">
                                                {!! Form::text('no_spri', null, ['class' => 'form-control', 'id' => 'noSPRI', 'readonly' => true]) !!}
                                                <small class="text-danger">{{ $errors->first('no_spri') }}</small>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-flat" onclick="saveSPRI()">Simpan</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('script')
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script>
        function loadModal(url) {
            $('#modal_md').modal('show');
            $.ajax({
                url: url,
                success: function(response) {
                    jQuery('#modal_md .modal-content').html(response);
                }
            });
        }
    </script>
     
    <script>
    let emrCache = {}; 

    $('#datas').DataTable({
    language: {
        url: "/json/pasien.datatable-language.json",
    },
    lengthChange: false,
    searching: true,
    paging: false, 
    ordering: false,
    order: [],     
    columnDefs: [
        { orderable: true, targets: [5] }, 
    ],
    info: true,
    autoWidth: false,

    drawCallback: function(settings) {
        $('#datas_filter').parent().prev().remove();

        // === CEK FOLIO ===
        $('.poli-status').each(function() {
        var td = $(this);
        var id = td.data('id');
        var poli_id = td.data('poli');
        td.html('<small class="text-muted">Memuat...</small>');

        $.get('/ajax/cek-folio/' + id + '/' + poli_id, function(res) {
            if (res.jumlah > 0) {
            td.text(res.poli);
            } else {
            td.html('<span style="color: red">' + res.poli + '</span>');
            }
        });
        });

        // === CEK SPRI BULK ===
        var spriIds = [];
        $('.spri-status').each(function() {
        spriIds.push($(this).data('id'));
        });

        $.ajax({
        url: '/ajax/cek-spri-bulk',
        type: 'POST',
        data: { ids: spriIds, _token: '{{ csrf_token() }}' },
        success: function(res) {
            $('.spri-status').each(function() {
            var td = $(this);
            var regId = td.data('id');
            var data = res[regId];

            if (data) {
                // Jika sudah ada SPRI → tombol cetak
                td.html(`
                <a href="/spri/cetak/${data.id}" target="_blank" class="btn btn-info btn-sm">
                    <i class="fa fa-print"></i>
                </a>
                `);
            } else {
                // Jika belum ada SPRI → tombol buat baru
                td.html(`
                <a href="/create-spri/${regId}" target="_blank" class="btn btn-danger btn-sm btn-flat">
                    <i class="fa fa-bed"></i>
                </a>
                `);
            }
            });
        },
        error: function() {
            $('.spri-status').html('<span class="text-danger">Gagal memuat</span>');
        }
        });

        // === CEK RESEP ===
        var ids = [];
        $('.resep-status').each(function() {
        ids.push($(this).data('id'));
        });

        // Kirim semua ID sekaligus
        $.ajax({
        url: '/ajax/cek-resep-bulk',
        type: 'POST',
        data: { ids: ids, _token: '{{ csrf_token() }}' },
        success: function(res) {
            $('.resep-status').each(function() {
            var td = $(this);
            var regId = td.data('id');
            var data = res[regId]; // ambil dari hasil JSON

            if (data) {
                td.html(`
                <a href="/farmasi/eresep-print/${data.id}" target="_blank" class="btn btn-warning btn-xs">
                    Cetak
                </a>
                `);
            } else {
                td.html('<span class="text-muted">Belum ada resep</span>');
            }
            });
        },
        error: function() {
            $('.resep-status').html('<span class="text-danger">Gagal memuat</span>');
        }
        });

    }
    });
    </script>
    <script type="text/javascript">
        $('.select2').select2();


        // ADD RESEP
        $(document).on('click', '.btn-add-resep', function() {
            let id = $(this).attr('data-id');
            $('input[name=uuid]').val('');
            $.ajax({
                url: '/tindakan/e-resep/show/' + id,
                type: 'GET',
                dataType: 'json',
                // data: $('#formPulang').serialize(),
                success: function(res) {
                    console.log(res.data.bayar);
                    $('input[name="pasien_id"]').val(res.data.pasien.id)
                    $('input[name="reg_id"]').val(res.data.id)
                    $('input[name="no_rm"]').val(res.data.pasien.no_rm)
                    $('input[name="nama"]').val(res.data.pasien.nama)
                    $('select[name="cara_bayar"]').val(res.data.bayars.carabayar).trigger('change');
                    $('#myModalAddResep').modal('show');
                    // $('.select2').select2({
                    //   placeholder: '[--]',
                    // });
                }
            });
        })
        // HISTORY RESEP
        $(document).on('click', '.btn-history-resep', function() {
            let id = $(this).attr('data-id');
            $.ajax({
                url: '/tindakan/e-resep/history/' + id,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('#listHistoryResep').html('');
                },
                success: function(res) {
                    $('#listHistoryResep').html(res.html);
                    $('#myModalHistoryResep').modal('show');
                }
            });
        })
        // BTN SAVE RESEP
        $(document).on('click', '#btn-save-resep', function() {
            let body = {
                "uuid": $('input[name=uuid]').val(),
                "reg_id": $('input[name=reg_id]').val(),
                "pasien_id": $('input[name=pasien_id]').val(),
                "source": $('input[name=source]').val(),
                "masterobat_id": $('select[name=masterobat_id]').val(),
                "qty": $('input[name=qty]').val(),
                "cara_bayar": $('select[name=cara_bayar]').val(),
                "tiket": $('select[name=tiket]').val(),
                "cara_minum": $('select[name=cara_minum]').val(),
                "takaran": $('select[name=takaran]').val(),
                "informasi": $('input[name=informasi]').val(),
                "_token": $('input[name=_token]').val(),
            };
            $.ajax({
                url: '/tindakan/e-resep/save-detail',
                type: 'POST',
                dataType: 'json',
                data: body,
                success: function(res) {
                    if (res.status == true) {
                        $('input[name="uuid"]').val(res.uuid);
                        $('#listResep').html(res.html);
                        $('select[name="masterobat_id"]').val('');
                        $('input[name="qty"]').val('');
                    }
                }
            });
        })
        // BTN FINAL RESEP
        $(document).on('click', '#btn-final-resep', function() {
            if (confirm('Yakin Akan Disimpan ?')) {
                let body = {
                    "uuid": $('input[name=uuid]').val(),
                    "_token": $('input[name=_token]').val(),
                };
                $.ajax({
                    url: '/tindakan/e-resep/save-resep',
                    type: 'POST',
                    dataType: 'json',
                    data: body,
                    success: function(res) {
                        if (res.status == true) {
                            location.reload();
                        }
                    }
                });
            }
        })

        $(document).on('click', '.del-detail-resep', function() {
            let id = $(this).attr('data-id');
            let body = {
                "_token": $('input[name=_token]').val(),
            };
            $.ajax({
                url: '/tindakan/e-resep/detail/' + id + '/delete',
                type: 'DELETE',
                dataType: 'json',
                data: body,
                success: function(res) {
                    if (res.status == true) {
                        $('#listResep').html(res.html);
                    }
                }
            });
        })

        $('#masterObat').select2({
            placeholder: "Klik untuk isi nama obat",
            width: '100%',
            ajax: {
                url: '/penjualan/resep/master-obat-baru/',
                dataType: 'json',
                data: function(params) {
                    return {
                        j: 1,
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        })

        function cariBatch() {
            var masterobat_id = $("select[name='masterobat_id']").val();
            $.get('/penjualan/get-obat-baru/' + masterobat_id, function(resp) {
                console.log(resp)
                $('input[name="last_stok"]').val(resp.obat.stok);
            })
        }

        CKEDITOR.replace('kesimpulan', {
            height: 200,
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
        });

        //CKEDITOR
        CKEDITOR.replace('catatan_dokter', {
            height: 200,
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
        });

        function echocardiogram(id) {
            $('#echocardiogramModal').modal({
                backdrop: 'static',
                keyboard: false,
            })
            $('.modal-title').text('Input Echocardiogram')
            $("#formEkspertise")[0].reset()
            CKEDITOR.instances['catatan_dokter'].setData('')
            CKEDITOR.instances['kesimpulan'].setData('')
            $.ajax({
                    url: '/echocardiogram/echocardiogram/' + id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    $('.nama').text(data.reg.pasien.nama)
                    $('.no_rm').text(data.reg.pasien.no_rm)
                    $('input[name="pasien_id"]').val(data.reg.pasien.id)
                    $('.umur').text(data.umur)
                    $('.jk').text(data.reg.pasien.kelamin)
                    $('input[name="registrasi_id"]').val(data.reg.id)
                    $('input[name="jenis"]').val(data.ep.jenis)
                    $('input[name="ef"]').val(data.ep.ef)
                    $('input[name="katup_katup_jantung_aorta_cuspis"]').val(data.ep.katup_katup_jantung_aorta_cuspis)

                    $('select[name="fungsi_sistolik"]').val(data.ep.fungsi_sistolik).trigger('change')
                    $('select[name="global"]').val(data.ep.global).trigger('change')
                    $('select[name="dimensi_ruang_jantung"]').val(data.ep.dimensi_ruang_jantung).trigger('change')
                    $('select[name="lv"]').val(data.ep.lv).trigger('change')
                    $('select[name="fungsi_sistolik_rv"]').val(data.ep.fungsi_sistolik_rv).trigger('change')
                    $('select[name="tapse"]').val(data.ep.tapse).trigger('change')
                    $('select[name="katup_katup_jantung_mitral"]').val(data.ep.katup_katup_jantung_mitral).trigger(
                        'change')
                    $('select[name="katup_katup_jantung_aorta"]').val(data.ep.katup_katup_jantung_aorta).trigger(
                        'change')
                    $('select[name="katup_katup_jantung_aorta_cuspis"]').val(data.ep.katup_katup_jantung_aorta_cuspis)
                        .trigger('change')
                    $('select[name="katup_katup_jantung_trikuspid"]').val(data.ep.katup_katup_jantung_trikuspid)
                        .trigger('change')
                    $('select[name="katup_katup_jantung_pulmonal"]').val(data.ep.katup_katup_jantung_pulmonal).trigger(
                        'change')
                    $('select[name="katup_katup_jantung_trikuspid"]').val(data.ep.katup_katup_jantung_trikuspid)
                        .trigger('change')

                    if (data.ep != '') {
                        $('input[name="id"]').val(data.ep.id)
                        CKEDITOR.instances['kesimpulan'].setData(data.ep.kesimpulan)
                        CKEDITOR.instances['catatan_dokter'].setData(data.ep.catatan_dokter)
                    }
                })
                .fail(function() {

                });
        }

        function saveEkpertise() {
            var token = $('input[name="_token"]').val();
            var catatan_dokter = CKEDITOR.instances['catatan_dokter'].getData();
            var kesimpulan = CKEDITOR.instances['kesimpulan'].getData();
            var form_data = new FormData($("#formEkspertise")[0])
            form_data.append('catatan_dokter', catatan_dokter)
            form_data.append('kesimpulan', kesimpulan)

            $.ajax({
                    url: '/echocardiogram/echocardiogram',
                    type: 'POST',
                    dataType: 'json',
                    data: form_data,
                    async: false,
                    processData: false,
                    contentType: false,
                })
                .done(function(resp) {
                    if (resp.sukses == true) {
                        $('input[name="id"]').val(resp.data.id)
                        alert('Echocardiogram berhasil disimpan.')
                        location.reload();
                    }

                });
        }

        //CKEDITOR
        CKEDITOR.replace('diagnosa', {
            height: 200,
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
        });

        function suratPri(id) {
            $('#suratPri').modal({
                backdrop: 'static',
                keyboard: false,
            })
            $('.modal-title').text('Input SPRI')
            $("#formSPRI")[0].reset()
            CKEDITOR.instances['diagnosa'].setData('')
            $.ajax({
                    url: '/view-spri/' + id,
                    type: 'GET',
                    dataType: 'json',
                })
                .done(function(data) {
                    // console.log(data);
                    $('.nama').text(data.reg.pasien.nama)
                    $('.no_rm').text(data.reg.pasien.no_rm)
                    $('input[name="pasien_id"]').val(data.reg.pasien.id)
                    $('.umur').text(data.umur)
                    $('.jk').text(data.reg.pasien.kelamin)
                    $('input[name="registrasi_id"]').val(data.reg.id)
                    $('input[name="no_jkn"]').val(data.reg.pasien.no_jkn).trigger('change')
                    $('input[name="jenis_kamar"]').val(data.ep.jenis_kamar)
                    $('select[name="dokter_rawat"]').val(data.ep.dokter_rawat).trigger('change')
                    $('select[name="carabayar"]').val(data.ep.carabayar).trigger('change')
                    // $('select[name="dokter_pengirim"]').val(data.ep.dokter_pengirim).trigger('change')
                    $('select[name="dokter_pengirim"]').val(data.reg.dokter_id).trigger('change')

                    if (data.ep != '') {
                        $('input[name="id"]').val(data.ep.id)
                        CKEDITOR.instances['diagnosa'].setData(data.ep.diagnosa)
                    }
                })
                .fail(function() {

                });
        }

        function saveSPRI() {
            var token = $('input[name="_token"]').val();
            var diagnosa = CKEDITOR.instances['diagnosa'].getData();
            var form_data = new FormData($("#formSPRI")[0])
            form_data.append('diagnosa', diagnosa)

            $.ajax({
                    url: '/spri/store',
                    type: 'POST',
                    dataType: 'json',
                    data: form_data,
                    async: false,
                    processData: false,
                    contentType: false,
                })
                .done(function(resp) {
                    if (resp.sukses == true) {
                        $('input[name="id"]').val(resp.data.id)
                        alert('Surat Perintah Rawat Inap berhasil disimpan.')
                        location.reload();
                    } else {
                        alert(resp.msg)
                    }
                });
        }

        $('#createSPRI').on('click', function() {
            $("input[name='no_spri']").val(' ');
            $.ajax({
                url: '{{ url('/spri/buat-spri') }}',
                type: 'POST',
                data: $("#formSPRI").serialize(),
                processing: true,
                beforeSend: function() {
                    $('.overlay').removeClass('hidden')
                },
                complete: function() {
                    $('.overlay').addClass('hidden')
                },
                success: function(data) {
                    console.log(data.sukses)
                    if (data.code !== "200") {
                        return alert(data.msg)
                    }
                    // else if(data.sukses){

                    $('#fieldSPRI').removeClass('has-error');
                    $("input[name='no_spri']").val(data.sukses);
                    // } 
                    // else if (data.msg) { 
                    //   $('.overlay').addClass('hidden')
                    //   alert(data.msg)
                    // }
                }
            });
        });
    </script>
    <script>
    $(document).ready(function(){
        $(".col-resep, .col-konsul").each(function(){
            var td = $(this);
            var regId = td.data("reg");

            $.ajax({
                url: "/registrasi/check/" + regId,
                type: "GET",
                success: function(res){
                    // isi kolom resep
                    if(res.resepNoteId){
                        $("td.col-resep[data-reg='"+regId+"']").html(
                            '<a class="btn btn-warning btn-xs" href="/farmasi/eresep-print/'+res.resepNoteId+'" target="_blank">Cetak</a>'
                        );
                    } else {
                        $("td.col-resep[data-reg='"+regId+"']").html("<i>belum ada</i>");
                    }

                    // isi kolom konsul
                    if(res.konsulJawabId){
                        $("td.col-konsul[data-reg='"+regId+"']").html(
                            '<a href="#modalCetakKonsul'+regId+'" class="btn btn-warning btn-sm" data-toggle="modal" data-id="'+res.konsulJawabId+'"><i class="fa fa-print"></i></a>'
                        );
                    } else {
                        $("td.col-konsul[data-reg='"+regId+"']").html("<i>belum ada</i>");
                    }
                }
            });
        });
    });
    </script>
@endsection
