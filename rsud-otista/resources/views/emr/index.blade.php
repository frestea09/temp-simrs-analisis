@extends('master')

@section('header')
<h1>EMR {{strtoupper($unit)}}</h1>
@endsection

@section('css')
<style>
    .blink_violet {
        color: rgb(149, 0, 255);
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
        <h4 class="box-title">
            Periode Tanggal: {{ date('d-m-Y') }}&nbsp;
        </h4>
    </div>
    <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'emr/' . $unit, 'class' => 'form-hosizontal']) !!}
        {!! Form::hidden('unit', $unit) !!}
        <div class="row">
            {{-- @if ($unit !== 'jalan') --}}

            <div class="col-md-4">
                <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}"
                            type="button">Tanggal</button>
                    </span>
                    @if($unit == 'inap')
                        {!! Form::text('tga', null, [
                            'class' => 'form-control datepicker',
                            'autocomplete' => 'off',
                            'placeholder' => '-----Pilih Tanggal-----'
                        ]) !!}
                    @else
                        {!! Form::text('tga', date('d-m-Y'), [
                            'class' => 'form-control datepicker',
                            'autocomplete' => 'off',
                        ]) !!}
                    @endif
                    <small class="text-danger">{{ $errors->first('tga') }}</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="input-group {{ $errors->has('tgb') ? ' has-error' : '' }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default {{ $errors->has('tgb') ? ' has-error' : '' }}"
                            type="button">Sampai Tanggal</button>
                    </span>
                    @if($unit == 'inap')
                        {!! Form::text('tgb', null, [
                            'class' => 'form-control datepicker',
                            'onchange' => 'this.form.submit()',
                            'autocomplete' => 'off',
                            'placeholder' => '-----Pilih Tanggal-----'
                        ]) !!}
                    @else
                        {!! Form::text('tgb', date('d-m-Y'), [
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                            'onchange' => 'this.form.submit()',
                            'autocomplete' => 'off',
                        ]) !!}
                    @endif
                    <small class="text-danger">{{ $errors->first('tgb') }}</small>
                </div>
            </div>
            {{-- @endif --}}

            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">DPJP</button>
                    </span>
                    <select name="dokter_id" class="form-control select2" style="width: 100%"
                        onchange="this.form.submit()">
                        <option value="">-- Pilih Dokter --</option>
                        @foreach ($dokters as $dokter)
                        <option value="{{ $dokter->id }}" {{ $dokter->id == @$dokter_filter ? 'selected' : ''}}>{{
                            $dokter->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <br>
        @if ($unit == 'jalan')
        <div class="row">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Kondisi</button>
                    </span>
                    <select name="kondisi" class="form-control select2" style="width: 100%"
                        onchange="this.form.submit()">
                        <option value="">-- Semua --</option>
                        <option value="belum" {{ @$kondisi=='belum' ? 'selected' : '' }}>Belum Diperiksa</option>
                        <option value="sudah" {{ @$kondisi=='sudah' ? 'selected' : '' }}>Sudah Diperiksa</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Poli</button>
                    </span>
                    <form method="GET" action="{{ url()->current() }}">
                        <select name="poli_id" class="form-control select2" style="width: 100%"
                            onchange="this.form.submit()">
                            <option value="">-- Semua --</option>
                            @foreach($polis as $poli)
                            <option value="{{ $poli->id }}" {{ request('poli_id')==$poli->id ? 'selected' : '' }}>
                                {{ $poli->nama }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @if($unit == 'inap')
        <div class="row">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Status</button>
                    </span>
                    <select name="status" class="form-control select2" style="width: 100%"
                        onchange="this.form.submit()">
                        <option value="semua" {{ @$status=='semua' ? 'selected' : '' }}>Semua</option>
                        <option value="inap" {{ @$status=='inap' ? 'selected' : '' }}>Diinapkan</option>
                        <option value="pulang" {{ @$status=='pulang' ? 'selected' : '' }}>Dipulangkan</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Ruang</button>
                    </span>
                    <select name="filter_kamar" id="" class="form-control select2" onchange="this.form.submit()">
                        <option value="" {{ empty($filter_kamar) ? 'selected' : '' }}>Semua</option>
                        @foreach ($list_kelas as $k)
                            <option value="{{ $k->general_code }}" {{ @$filter_kamar == $k->general_code ? 'selected' : '' }}>
                                {{ $k->label }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('filter_kamar') }}</small>
                </div>
            </div>
        </div>
        @endif
        {!! Form::close() !!}
        <hr>

        @if($unit == 'inap')
        @include('emr.view_ajax_inap')
        @elseif ($unit == "igd")
        @include('emr.view_ajax_igd')
        @else
        @include('emr.view_ajax')
        @endif
    </div>
</div>

<div id="modalPassphrase" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form id="formPassphrase" action="" method="POST">
            <input type="hidden" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Masukkan Passphrase TTE</h4>
                </div>
                <div class="modal-body row" style="display: grid;">
                    {!! csrf_field() !!}
                    <div class="col-md-12" style="margin-bottom: 1rem;">
                        <span style="color: red;"><i>Agar ketika melakukan TTE Dokumen tidak perlu passphrase
                                lagi</i></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="pwd">Passphrase:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="passphrase" id="passphrase">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="handleUserRefuse()"
                        data-dismiss="modal">Abaikan</button>
                    <button type="button" class="btn btn-primary" onclick="handleUserSave()">Simpan</button>
                </div>
            </div>
        </form>

    </div>
</div>
{{-- Modal Tarif IDRG --}}
<div class="modal fade" id="modalTarifIDRG">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Set Tarif IDRG</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formTarifIDRG" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="registrasi_id">
          <div class="form-group">
            <label class="col-md-3 control-label">Tarif IDRG Sementara</label>
            <div class="col-md-9">
              <input type="number" name="tarif_idrg" class="form-control" placeholder="Masukkan tarif IDRG">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="saveIDRG()">Simpan</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
{{-- Passphrase Session --}}
<script>
    let passphrase = {!! json_encode(session('passphrase')) !!};
        if (!passphrase) {
            showModalPassphrase();
        }

        function showModalPassphrase() {
            $('#modalPassphrase').modal('show');
        }

        function closeModalPassphrase() {
            $('#modalPassphrase').modal('hide');
        }

        function handleUserRefuse() {
            $.ajax({
                url: '{{ url('/save_passphrase') }}',
                type: 'POST',
                data: {
                    save_passphrase : false,
                    _token : $('input[name="_token"]').val(),
                    _method : 'POST'
                },
                processing: true,
                success: function(data) {
                    if (data) {
                        closeModalPassphrase()
                    }
                }
            });
        }

        function handleUserSave() {
            $.ajax({
                url: '{{ url('/save_passphrase') }}',
                type: 'POST',
                data: {
                    save_passphrase : true,
                    passphrase : $('input[name="passphrase"]').val(),
                    _token : $('input[name="_token"]').val(),
                    _method : 'POST'
                },
                processing: true,
                success: function(data) {
                    if (data) {
                        closeModalPassphrase()
                    }
                }
            });
        }
</script>
{{-- End Passphrase Session --}}
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script>
    $(document).ready(function() {
           $('#dataemr').DataTable({
                ordering: false, 
                order: [],
                stateSave: true, 
                stateSaveParams: function (settings, data) {
                    data.search.search = '';
                }
           });
       });
      function loadModal(url){
        $('#modal_md').modal('show');
        $.ajax({
          url: url,
          success: function (response) {
            jQuery('#modal_md .modal-content').html(response);
          }
        });
    }
</script>
<script type="text/javascript">
    $('.select2').select2();

        // function echocardiogram(id) {
        //     $('#echocardiogramModal').modal({
        //         backdrop: 'static',
        //         keyboard: false,
        //     })
        //     $('.modal-title').text('Input Echocardiogram')
        //     $("#formEkspertise")[0].reset()
        //     CKEDITOR.instances['catatan_dokter'].setData('')
        //     CKEDITOR.instances['kesimpulan'].setData('')
        //     $.ajax({
        //             url: '/echocardiogram/echocardiogram/' + id,
        //             type: 'GET',
        //             dataType: 'json',
        //         })
        //         .done(function(data) {
        //             $('.nama').text(data.reg.pasien.nama)
        //             $('.no_rm').text(data.reg.pasien.no_rm)
        //             $('input[name="pasien_id"]').val(data.reg.pasien.id)
        //             $('.umur').text(data.umur)
        //             $('.jk').text(data.reg.pasien.kelamin)
        //             $('input[name="registrasi_id"]').val(data.reg.id)
        //             $('input[name="jenis"]').val(data.ep.jenis)
        //             $('input[name="ef"]').val(data.ep.ef)
        //             $('input[name="katup_katup_jantung_aorta_cuspis"]').val(data.ep.katup_katup_jantung_aorta_cuspis)

        //             $('select[name="fungsi_sistolik"]').val(data.ep.fungsi_sistolik).trigger('change')
        //             $('select[name="global"]').val(data.ep.global).trigger('change')
        //             $('select[name="dimensi_ruang_jantung"]').val(data.ep.dimensi_ruang_jantung).trigger('change')
        //             $('select[name="lv"]').val(data.ep.lv).trigger('change')
        //             $('select[name="fungsi_sistolik_rv"]').val(data.ep.fungsi_sistolik_rv).trigger('change')
        //             $('select[name="tapse"]').val(data.ep.tapse).trigger('change')
        //             $('select[name="katup_katup_jantung_mitral"]').val(data.ep.katup_katup_jantung_mitral).trigger(
        //                 'change')
        //             $('select[name="katup_katup_jantung_aorta"]').val(data.ep.katup_katup_jantung_aorta).trigger(
        //                 'change')
        //             $('select[name="katup_katup_jantung_aorta_cuspis"]').val(data.ep.katup_katup_jantung_aorta_cuspis)
        //                 .trigger('change')
        //             $('select[name="katup_katup_jantung_trikuspid"]').val(data.ep.katup_katup_jantung_trikuspid)
        //                 .trigger('change')
        //             $('select[name="katup_katup_jantung_pulmonal"]').val(data.ep.katup_katup_jantung_pulmonal).trigger(
        //                 'change')
        //             $('select[name="katup_katup_jantung_trikuspid"]').val(data.ep.katup_katup_jantung_trikuspid)
        //                 .trigger('change')

        //             if (data.ep != '') {
        //                 $('input[name="id"]').val(data.ep.id)
        //                 CKEDITOR.instances['kesimpulan'].setData(data.ep.kesimpulan)
        //                 CKEDITOR.instances['catatan_dokter'].setData(data.ep.catatan_dokter)
        //             }
        //         })
        //         .fail(function() {

        //         });
        // }

        // function saveEkpertise() {
        //     var token = $('input[name="_token"]').val();
        //     var catatan_dokter = CKEDITOR.instances['catatan_dokter'].getData();
        //     var kesimpulan = CKEDITOR.instances['kesimpulan'].getData();
        //     var form_data = new FormData($("#formEkspertise")[0])
        //     form_data.append('catatan_dokter', catatan_dokter)
        //     form_data.append('kesimpulan', kesimpulan)

        //     $.ajax({
        //             url: '/echocardiogram/echocardiogram',
        //             type: 'POST',
        //             dataType: 'json',
        //             data: form_data,
        //             async: false,
        //             processData: false,
        //             contentType: false,
        //         })
        //         .done(function(resp) {
        //             if (resp.sukses == true) {
        //                 $('input[name="id"]').val(resp.data.id)
        //                 alert('Echocardiogram berhasil disimpan.')
        //                 location.reload();
        //             }

        //         });
        // }

        //CKEDITOR
        // CKEDITOR.replace('diagnosa', {
        //     height: 200,
        //     filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        //     filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
        // });

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
                    $('select[name="dokter_pengirim"]').val(data.ep.dokter_pengirim).trigger('change')

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
    $('#datas').DataTable({
        language: {
        url: "/json/pasien.datatable-language.json",
        },
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        order: [],
        info: true,
        autoWidth: false,
        drawCallback: function(settings) {
            
            // CEK POli
            $(".poli-name").each(function () {
                let td = $(this);
                let id = td.data("id");
                let poli = td.data("poli");
                let nama = td.data("nama");

                // cek supaya tidak request ulang jika sudah ada hasil
                if (!td.find(".loading").length) return;

                $.get("/cek-folio-count/" + id + "/" + poli, function (res) {
                    if (res.count > 0) {
                        td.html(nama);
                    } else {
                        td.html('<span style="color:red">' + nama + '</span>');
                    }
                });
            });

            // STATUS PERIKSA
            let items = [];
            $(".status-periksa").each(function () {
                if ($(this).find(".loading").length) {
                    items.push({
                        id: $(this).data("id"),
                        dokter: $(this).data("dokter")
                    });
                }
            });

            if (items.length > 0) {
                $.ajax({
                    url: "/cek-status-batch",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        items: items
                    },
                    success: function(res) {
                        $(".status-periksa").each(function () {
                            let td = $(this);
                            let id = td.data("id");

                            if (typeof res[id] !== "undefined") {
                                if (res[id] === "sudah") {
                                    td.html('<span class="text-success"><i>Sudah Diperiksa</i></span>');
                                } else {
                                    td.html('<span class="text-danger"><i>Belum Diperiksa</i></span>');
                                }
                            }
                        });
                    }
                });
            }
            // PERAWAT
            let itemsPerawat = [];

            $(".status-perawat").each(function () {
                if ($(this).find(".loading").length) {
                    itemsPerawat.push({
                        id: $(this).data("id"),
                        dokter: $(this).data("dokter")
                    });
                }
            });

            if (itemsPerawat.length > 0) {
                $.ajax({
                    url: "/cek-status-perawat-batch",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        items: itemsPerawat
                    },
                    success: function(res) {
                        $(".status-perawat").each(function () {
                            let td = $(this);
                            let id = td.data("id");

                            if (res[id]) {
                                let poli   = td.data("poli");
                                let dpjp   = td.data("dpjp");
                                let unit   = td.data("unit");
                                let status = td.data("status");
                                let tte    = td.data("tte");

                                let url = "";
                                if (poli == 14 && status === "lama" && {{ Auth::user()->pegawai->kategori_pegawai }} == 1) {
                                    url = "/emr/soap/" + unit + "/" + id + "?poli=" + poli + "&dpjp=" + dpjp;
                                } else {
                                    url = "/emr-soap/anamnesis/main/" + unit + "/" + id + "?poli=" + poli + "&dpjp=" + dpjp;
                                }

                                if (res[id] === "sudah") {
                                    let html = '<a href="'+url+'" class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>';
                                    if (!tte) {
                                        html += '<br><span><i class="blink_violet">E-Resume belum di TTE</i></span>';
                                    }
                                    td.html(html);
                                } else {
                                    td.html('<a href="'+url+'" class="btn btn-warning btn-flat btn-sm"><i class="fa fa-paste"></i></a>');
                                }
                            }
                        });
                    }
                });
            }

            // STATUS DISCHARGE
            let itemsDischarge = [];

            $(".status-discharge").each(function () {
                if ($(this).find(".loading").length) {
                    itemsDischarge.push({
                        id: $(this).data("id"),
                        dokter: $(this).data("dokter"),
                        pasien: $(this).data("pasien")
                    });
                }
            });

            if (itemsDischarge.length > 0) {
                $.ajax({
                    url: "/cek-discharge-batch",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        items: itemsDischarge
                    },
                    success: function(res) {
                        $(".status-discharge").each(function () {
                            let td = $(this);
                            let id = td.data("id");

                            if (res[id] !== undefined) {
                                td.text(res[id]);
                            } else {
                                td.text("-");
                            }
                        });
                    }
                });
            }

            // STATUS EMR
            $(".status-emr").each(function () {
                let td = $(this);
                let registrasiId = td.data("registrasi-id");
                let unit   = td.data("unit");
                let poli   = td.data("poli");
                let dpjp   = td.data("dpjp");
                let tte    = td.data("tte");

                if (td.find(".loading").length) {
                    $.get("/ajax/cek-emr/" + registrasiId, function (res) {
                        // res = { exists: true/false }
                        let url = "/emr-soap/anamnesis/main/" + unit + "/" + registrasiId + "?poli=" + poli + "&dpjp=" + dpjp;
                        let html = "";

                        if (res.exists) {
                            // tombol hijau
                            html = '<a href="'+url+'" class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>';
                            if (!tte) {
                                html += '<br><span><i class="blink_violet">E-Resume belum di TTE</i></span>';
                            }
                        } else {
                            // tombol kuning
                            html = '<a href="'+url+'" class="btn btn-warning btn-flat btn-sm"><i class="fa fa-paste"></i></a>';
                        }

                        td.html(html);
                    }).fail(function () {
                        td.html(`<span class="text-danger">Error</span>`);
                    });
                }
            });

            // CEK KAMAR
            // STATUS KAMAR-BED
                $(".status-kamar-bed").each(function () {
                    let td = $(this);
                    let id = td.data("id");

                    if (td.find(".loading").length) {
                        $.get("/ajax/cek-kamar-bed/" + id, function (res) {
                            td.text(res.text);
                        }).fail(function () {
                            td.text("-");
                        });
                    }
                });
            }
            });
            
            // Tarif IDRG Sementara
            function tarifIDRG(registrasi_id, tarif_idrg) {
                $('#modalTarifIDRG').modal('show');
                $('input[name="registrasi_id"]').val(registrasi_id);
                $('input[name="tarif_idrg"]').val(tarif_idrg);
            }

            function saveIDRG() {
                var formData = new FormData($("#formTarifIDRG")[0]);

                $.ajax({
                    url: "{{ url('/registrasi/set-tarif-idrg') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#modalTarifIDRG').modal('hide');
                        alert('Tarif IDRG berhasil disimpan');
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('Gagal menyimpan tarif IDRG');
                        console.log(xhr.responseText);
                    }
                });
            }

</script>
@endsection