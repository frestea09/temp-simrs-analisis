@extends('master')

@section('header')
    <h1>Sistem IGD</h1>
@endsection

@section('css')
    <style>
        .blink_me {
            animation: blinker 2s linear infinite;
            color: #f60606;
        }

        @keyframes blinker {
            50% {
            opacity: 0;
            }
        }
    </style>
    <style>
        #blp-fallback { 
            display: none; 
        }

        #blp-fallback.blp-active{
            display: table-cell;      
            width: 100%;
            vertical-align: middle;
            padding-right: 6px; 
        }

        #blp-fallback.blp-active .blp-wrap{
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;        
        }

        #blp-fallback.blp-active .blp-wrap .form-control{
            width: auto !important;     
            display: inline-block;
            height: 34px;              
            padding: 6px 12px;
            box-sizing: border-box;
        }

        #blp-fallback.blp-active #blp-month{
            flex: 1 1 0;
            min-width: 150px;         
        }
        #blp-fallback.blp-active #blp-year{
            flex: 0 0 92px;
            min-width: 92px;
        }

        @media (max-width: 767px){
            #blp-fallback.blp-active #blp-year{ flex-basis: 80px; min-width: 80px; }
            #blp-fallback.blp-active #blp-month{ min-width: 130px; }
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
            {!! Form::open(['method' => 'POST', 'url' => '/frontoffice/antrian-realtime-igd-bytgl', 'class' => 'form-hosizontal']) !!}
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
                            'onchange' => 'this.form.submit()',
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('tga') }}</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group{{ $errors->has('filter_poli') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('filter_poli') ? ' has-error' : '' }}"
                                type="button">Filter Poli</button>
                        </span>
                        <select name="filter_poli" id="" class="form-control select2" onchange="this.form.submit()">
                            <option value="" {{empty($filter_poli) ? 'selected' : ''}}>Semua</option>
                            @foreach ($poli as $value)
                                <option value="{{$value->id}}" {{@$filter_poli == $value->id ? 'selected' : ''}}>{{$value->nama}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger">{{ $errors->first('filter_poli') }}</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group {{ $errors->has('blp') ? ' has-error' : '' }}" id="blp-group">
                        <span class="input-group-btn">
                        <button class="btn btn-default{{ $errors->has('blp') ? ' has-error' : '' }}" type="button">
                            Bulan Pulang
                        </button>
                        </span>

                        <input
                        type="month"
                        name="blp"
                        id="blp"
                        class="form-control"
                        value="{{ old('blp', request('blp')) }}"
                        autocomplete="off"
                        onchange="this.form.submit()"
                        onfocus="
                            if(!this.value){
                            const d = new Date();
                            const y = d.getFullYear();
                            const m = String(d.getMonth()+1).padStart(2,'0');
                            this.value = y + '-' + m;
                            }
                        "
                        >

                        <div id="blp-fallback" style="display:none;">
                        <div id="blp-wrap">
                            <select id="blp-month" class="form-control" onchange="syncBlp()">
                            <option value="">-----</option>
                            @foreach (range(1,12) as $m)
                                <option
                                value="{{ sprintf('%02d', $m) }}"
                                {{ request('blp') && explode('-', request('blp'))[1] == sprintf('%02d', $m) ? 'selected' : '' }}
                                >
                                {{ \Carbon\Carbon::createFromDate(null, $m, 1)->format('F') }}
                              
                                </option>
                            @endforeach
                            </select>

                            @php $yearNow = now()->year; @endphp
                            <select id="blp-year" class="form-control" onchange="syncBlp()">
                            <option value="">-----</option>
                            @foreach (range($yearNow-5, $yearNow+1) as $y)
                                <option
                                value="{{ $y }}"
                                {{ request('blp') && explode('-', request('blp'))[0] == $y ? 'selected' : '' }}
                                >
                                {{ $y }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        </div>

                        <span class="input-group-btn">
                        <button
                            class="btn btn-danger"
                            type="button"
                            {{-- onclick="
                            const f = this.closest('form');
                            const i = f.querySelector('#blp');
                            const m = f.querySelector('#blp-month');
                            const y = f.querySelector('#blp-year');
                            i.value = '';
                            if(m) m.value = '';
                            if(y) y.value = '';
                            f.submit();
                            " --}}
                            onclick="window.location.href='{{ route('frontoffice.antrian-igd') }}'"
                            title="Nonaktifkan filter bulan pulang (---)"
                        >
                            Reset
                        </button>
                        </span>
                    </div>
                    <small class="text-danger">{{ $errors->first('blp') }}</small>
                </div>
                <div class="col-md-3">
                    <div class="input-group{{ $errors->has('filter_koding') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default{{ $errors->has('filter_koding') ? ' has-error' : '' }}"
                                type="button">Coding</button>
                        </span>
                        <select name="filter_koding" class="form-control select2" onchange="this.form.submit()">
                            <option value="" {{ empty($filter_koding) ? 'selected' : '' }}>Semua</option>
                            <option value="sudah" {{ ($filter_koding == 'sudah') ? 'selected' : '' }}>Sudah Coding</option>
                            <option value="belum" {{ ($filter_koding == 'belum') ? 'selected' : '' }}>Belum Coding</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('filter_koding') }}</small>
                    </div>
                </div>
            </div>
            <br>
           
            <hr>
            
            @include('frontoffice.view_ajax_antrianRealtimeIGD')
            {!! Form::close() !!}

        </div>
    </div>

    {{-- Modal Eresep --}}
    <div id="myModalAddResep" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <input type="hidden" name="pasien_id">
            <input type="hidden" name="uuid">
            <input type="hidden" name="reg_id">
            <input type="hidden" name="source" value="inap">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah E-Resep</h4>
                </div>
                <div class="modal-body" style="display:grid;">
                    <h3>Informasi Pasien</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="control-label col-sm-4">No RM:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="no_rm" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-4">Pasien:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nama" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3>Daftar E-Resep</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="control-label col-sm-4">Nama Obat:</label>
                                <div class="col-sm-8">
                                    <select name="masterobat_id" id="masterObat" class="form-control"
                                        onchange="cariBatch()"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-4">Stok:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="last_stok" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-4">Qty:</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="qty">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-4">Cara Bayar:</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" name="cara_bayar" style="width: 100%">
                                        @foreach ($carabayar as $key => $item)
                                            <option value="{{ $item->carabayar }}">{{ $item->carabayar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-4">E-Tiket:</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" name="tiket" style="width: 100%">
                                        @foreach ($tiket as $key => $item)
                                            <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label class="control-label col-sm-4">Cara Minum:</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" name="cara_minum" style="width: 100%">
                                        @foreach ($cara_minum as $key => $item)
                                            <option value="{{ $item->aturan }}">{{ $item->aturan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-4">Takaran:</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" name="takaran" style="width: 100%">
                                        @foreach ($takaran as $key => $item)
                                            <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-sm-4">Inforrmasi:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="informasi">
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-primary" id="btn-save-resep">Tambah</button>
                            </div>
                        </div>
                    </div>
                    <table class='table-striped table-bordered table-hover table-condensed table'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th>Qty</th>
                                <th>Cara Bayar</th>
                                <th>Tiket</th>
                                <th>Cara Minum</th>
                                <th>Takaran</th>
                                <th>Informasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="listResep">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                    <button type="button" id="btn-final-resep" class="btn btn-success">Simpan</button>
                </div>
            </div>

        </div>
    </div>

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
        (function(){
        var input = document.getElementById('blp');
        var fb    = document.getElementById('blp-fallback');
        var wrap  = document.getElementById('blp-wrap');
        var mSel  = document.getElementById('blp-month');
        var ySel  = document.getElementById('blp-year');

        var test = document.createElement('input');
        test.setAttribute('type', 'month');
        var supported = (test.type === 'month');

        if (!supported) {
            fb.style.display       = 'table-cell';
            fb.style.width         = '100%';
            fb.style.maxWidth      = '100%';
            fb.style.verticalAlign = 'middle';
            fb.style.overflow      = 'hidden';
            fb.style.paddingRight  = '6px';

            input.style.display    = 'none';
            mSel.classList.remove('form-control');
            ySel.classList.remove('form-control');

            wrap.style.display     = 'flex';
            wrap.style.alignItems  = 'center';
            wrap.style.flexWrap    = 'nowrap';
            wrap.style.gap         = '6px';
            wrap.style.maxWidth    = '100%';
            wrap.style.overflow    = 'hidden';
            wrap.style.whiteSpace  = 'nowrap';

            [mSel, ySel].forEach(function(el){
            el.style.height      = '34px';
            el.style.padding     = '6px 10px';
            el.style.lineHeight  = '1.42857143';
            el.style.border      = '1px solid #ccc';
            el.style.borderRadius= '4px';
            el.style.background  = '#fff';
            el.style.boxSizing   = 'border-box';
            el.style.maxWidth    = '100%';
            });

            mSel.style.flex       = '1 1 0';
            mSel.style.minWidth   = '180px';   
            mSel.style.minInlineSize = '0';    
            ySel.style.flex       = '0 0 72px';
            ySel.style.width      = '72px';
            ySel.style.minWidth   = '72px';

            if (input.value && /^\d{4}-(0[1-9]|1[0-2])$/.test(input.value)) {
            var parts = input.value.split('-');
            ySel.value = parts[0] || '';
            mSel.value = parts[1] || '';
            } else {
            ySel.value = '';
            mSel.value = '';
            }
            var firstInitDone = false;
            function initNowIfEmpty(){
            if (!firstInitDone && (!ySel.value || !mSel.value)) {
                var d = new Date();
                var y = String(d.getFullYear());
                var m = String(d.getMonth()+1).padStart(2,'0');
                ySel.value = y;
                mSel.value = m;
                input.value = y + '-' + m;
                firstInitDone = true;
            }
            }
            mSel.addEventListener('focus', initNowIfEmpty, { once: true });
            ySel.addEventListener('focus', initNowIfEmpty, { once: true });
            window.syncBlp = function(){
            if (!ySel.value || !mSel.value) return;
            input.value = ySel.value + '-' + mSel.value;
            if (input.form) input.form.submit();
            };
        } else {
            window.syncBlp = function(){};
        }
        })();
    </script>
@endsection
