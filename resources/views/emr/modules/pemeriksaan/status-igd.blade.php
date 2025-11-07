@extends('master')

<style>
    .form-box td,
    select,
    input,
    textarea {
        font-size: 12px !important;
    }

    .history-family input[type=text] {
        height: 20px !important;
        padding: 0px !important;
    }

    .history-family-2 td {
        padding: 1px !important;
    }
</style>
<style>
    .red{
        background-color: rgb(255, 106, 106);
    }
    .yellow{
        background-color: rgb(255, 238, 110);
    }
    .green{
        background-color: rgb(166, 255, 110);
    }
</style>
@section('header')
    <h1>Status Rawat Darurat</h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">
            <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
            <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
            <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
            

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-aqua-active" style="height: auto;">
                          <div class="row">
                            <div class="col-md-2">
                              <h4 class="widget-user-username">Nama</h4>
                              <h5 class="widget-user-desc">No. RM</h5>
                              <h5 class="widget-user-desc">Tgl Lahir / Umur</h5>
                              <h5 class="widget-user-desc">Alamat</h5>
                              <h5 class="widget-user-desc">Cara Bayar</h5>
                            @if(@$reg->bayar == 1)
                              <h5 class="widget-user-desc">No JKN</h5>
                            @endif
                              <h5 class="widget-user-desc">DPJP</h5>
                              <h5 class="widget-user-desc">No. Telepon</h5>
                              <h5 class="widget-user-desc">Eresep</h5>
                            </div>
                            <div class="col-md-7">
                              <h3 class="widget-user-username">:{{ @$pasien->nama}}</h3>
                              <h5 class="widget-user-desc">: {{ @$pasien->no_rm }}</h5>
                              <h5 class="widget-user-desc">: {{ !empty(@$pasien->tgllahir) ? @$pasien->tgllahir : ''}} / {{ !empty(@$pasien->tgllahir) ? hitung_umur(@$pasien->tgllahir) : NULL }}</h5>
                              <h5 class="widget-user-desc">: {{ @$pasien->alamat}}</h5>
                              <h5 class="widget-user-desc">: {{ baca_carabayar(@$reg->bayar) }} </h5>
                            @if($reg->bayar == 1)
                              <h5 class="widget-user-desc">: {{ @$pasien->no_jkn}}</h5>
                            @endif
                              <h5 class="widget-user-desc">: {{ baca_dokter(@$reg->dokter_id)}}</h5>
                              <h5 class="widget-user-desc">: {{ @$pasien->nohp}}</h5>
                              <h5 class="widget-user-desc">: 
                                <button type="button" class="btn btn-warning btn-flat btn-history-resep" data-id="{{ $reg->id }}"><i class="fa fa-bars" aria-hidden="true"></i> HISTORI E-RESEP</button></h5>
                            </div>
                            <div class="col-md-3 text-center">
                              {{-- <h3>Total Tagihan</h3>
                              <h2 style="margin-top: -5px;">Rp. {{ number_format($tagihan,0,',','.') }}</h2> --}}
                            </div>
                          </div>
                        </div>
                        <div class="widget-user-image"></div>
                      </div>
                </div>

                
                <div class="col-md-12">
                    <form class="col-md-12" action={{ url('emr-soap/pemeriksaan/status-igd/' . $reg->id) }} method="post">
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            {{-- A. PENGKAJIAN & INTERVENSI RESIKO JATUH PASIEN RAWAT JALAN --}}
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td style="width:40%; font-weight:bold;">
                                        Triage
                                    </td>
                                    <td colspan="5" >
                                        <div class="red" style="display: inline-block; padding: 10px">
                                            <input class="form-check-input"
                                                name="status[triage]"
                                                {{ @$status['triage'] == 'emergency' ? 'checked' : '' }}
                                                type="radio" value="emergency" id="emergency">
                                            <label class="form-check-label" for="emergency">Emergency</label>
                                        </div>
                                        <div class="yellow"  style="display: inline-block; padding: 10px">
                                            <input class="form-check-input"
                                                name="status[triage]"
                                                {{ @$status['triage'] == 'urgent' ? 'checked' : '' }}
                                                type="radio" value="urgent" id="urgent">
                                            <label class="form-check-label" for="urgent">Urgent</label>
                                        </div>
                                        <div class="green"  style="display: inline-block; padding: 10px">
                                            <input class="form-check-input"
                                                name="status[triage]"
                                                {{ @$status['triage'] == 'non-urgent' ? 'checked' : '' }}
                                                type="radio" value="non-urgent" id="non-urgent">
                                            <label class="form-check-label" for="non-urgent">Non Urgent</label>
                                        </div>
                                        <div  style="display: inline-block; padding: 10px; background-color:rgb(169, 169, 169)">
                                            <input class="form-check-input"
                                                name="status[triage]"
                                                {{ @$status['triage'] == 'meninggal' ? 'checked' : '' }}
                                                type="radio" value="meninggal" id="meninggal">
                                            <label class="form-check-label" for="meninggal">Meninggal</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td  style="width:40%; font-weight:bold;">
                                        Kasus
                                    </td>
                                    <td>
                                        <select name="status[kasus]"  class="form-control select2">
                                            <option value="">-- Pilih --</option>
                                            <option value="anak" {{ @$status['kasus'] == 'anak' ? 'selected' : '' }}>Anak</option>
                                            <option value="ponek" {{ @$status['kasus'] == 'ponek' ? 'selected' : '' }}>Ponek</option>
                                            <option value="bedah" {{ @$status['kasus'] == 'bedah' ? 'selected' : '' }}>Bedah</option>
                                            <option value="non-bedah" {{ @$status['kasus'] == 'non-bedah' ? 'selected' : '' }}>Non Bedah</option>
                                            <option value="infeksius" {{ @$status['kasus'] == 'infeksius' ? 'selected' : '' }}>Infeksius</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td  style="width:40%; font-weight:bold;">
                                        Jam Masuk
                                    </td>
                                    <td>
                                        <input type="time" name="status[jam_masuk]" value="{{@$status['jam_masuk'] == null ? (new DateTime(@$reg->created_at))->format('H:i') : @$status['jam_masuk']}}" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td  style="width:40%; font-weight:bold;">
                                        Mulai Penanganan
                                    </td>
                                    <td>
                                        <input type="time" name="status[jam_penanganan]" value="{{@$status['jam_penanganan']}}"  class="form-control" id="">
                                    </td>
                                </tr>
                                <tr>
                                    <td  style="width:40%; font-weight:bold;">
                                        Tanggal dan Jam Pulang
                                    </td>
                                    <td>
                                        <input type="datetime-local" name="tgl_pulang" value="{{$tgl_pulang}}" class="form-control" id="">
                                    </td>
                                </tr>
                                
                            </table>
                        </div>
    
                        <div class="col-md-6">
                            {{-- A. PENGKAJIAN & INTERVENSI RESIKO JATUH PASIEN RAWAT JALAN --}}
                            <table style="width: 100%"
                                class="table-striped table-bordered table-hover table-condensed form-box table"
                                style="font-size:12px;">
                                <tr>
                                    <td  style="width:40%; font-weight:bold;">
                                        Cara Masuk
                                    </td>
                                    <td>
                                        <select name="status[caraMasuk]"  class="form-control select2">
                                            <option value="">-- Pilih --</option>
                                            <option value="Datang Sendiri" {{@$status['caraMasuk'] == 'Datang Sendiri' ? 'selected' : ''}}>Datang Sendiri</option>
                                            <option value="Rujukan Luar" {{@$status['caraMasuk'] == 'Rujukan Luar' ? 'selected' : ''}}>Rujukan Luar</option>
                                            <option value="Petugas Kesehatan" {{@$status['caraMasuk'] == 'Petugas Kesehatan' ? 'selected' : ''}}>Petugas Kesehatan Lain</option>
                                            <option value="KLL / Kasus Polisi" {{@$status['caraMasuk'] == 'KLL / Kasus Polisi' ? 'selected' : ''}}>KLL / Kasus Polisi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td  style="width:40%; font-weight:bold;">
                                        Cara Pulang
                                    </td>
                                    <td>
                                        <select name="cara_pulang"  class="form-control select2" id="cara_pulang">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($cara_pulangs as $pulang)
                                                <option value="{{$pulang->id}}" {{$pulang_id == $pulang->id ? 'selected' : ''}}>{{$pulang->namakondisi}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr id="rujukan"  @if($pulang_id == 2) style="display: table-row" @else style="display: none" @endif>
                                    <td  style="width:40%; font-weight:bold;">
                                        Faskes Rujukan
                                    </td>
                                    <td>
                                        {{-- <select name="" id="faskes" class="form-control select2">
                                            @if($dirujuk_ke != null)
                                            <option value="{{$dirujuk_ke->id}}">{{$dirujuk_ke->kode_ppk}} - {{$dirujuk_ke->nama_ppk}}</option>
                                            @endif
                                        </select> --}}
                                        <select name="status[diRujukKe]" id="faskes" class="form-control select2" style="width: 100%">
                                            <option value="" {{@$status['diRujukKe'] == '' ? 'selected' : ''}}>- Pilih -</option>
                                            <option value="RS Kab. Bandung" {{@$status['diRujukKe'] == 'RS Kab. Bandung' ? 'selected' : ''}}>RS Kab. Bandung</option>
                                            <option value="RS Kota Bandung" {{@$status['diRujukKe'] == 'RS Kota Bandung' ? 'selected' : ''}}>RS Kota Bandung</option>
                                            <option value="RS Provinsi" {{@$status['diRujukKe'] == 'RS Provinsi' ? 'selected' : ''}}>RS Provinsi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr id="rs_rujukan"  @if($pulang_id == 2) style="display: table-row" @else style="display: none" @endif>
                                    <td  style="width:40%; font-weight:bold;">
                                        Rumah Sakit Rujukan
                                    </td>
                                    <td>
                                        <select name="status[rsRujukan]" id="faskes_rs_rujukan" class="form-control select2" style="width: 100%">
                                            <option value="" {{@$status['rsRujukan'] == '' ? 'selected' : ''}}>- Pilih -</option>
                                            @foreach ($faskesRujukanRs as $rs)
                                                <option value="{{$rs->id}}" {{@$status['rsRujukan'] == $rs->id ? 'selected' : ''}}>{{$rs->nama_rs}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr id="alasan_rujukan"  @if($pulang_id == 2) style="display: table-row" @else style="display: none" @endif>
                                    <td  style="width:40%; font-weight:bold;">
                                        Alasan
                                    </td>
                                    <td>
                                        <input type="text" style="width: 100%" name="status[alasanRujuk]" value="{{@$status['alasanRujuk']}}" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
                                    <td  style="width:40%; font-weight:bold;">
                                        Kondisi Saat Pulang
                                    </td>
                                    <td>
                                        <select name="kondisi_akhir"  class="form-control select2">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($kondisi_akhir_pasiens as $kondisi)
                                                <option value="{{$kondisi->id}}" {{$kondisi_id == $kondisi->id ? 'selected' : ''}}>{{$kondisi->namakondisi}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td  style="width:40%; font-weight:bold;">
                                        Keterangan
                                    </td>
                                    <td>
                                        <input type="text" style="width: 100%" name="status[keterangan]" value="{{@$status['keterangan']}}" class="form-control" >
                                    </td>
                                </tr>
                            </table>
                            <div class="form-group pull-right">
                                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9 text-center">
                                    {!! Form::submit('Simpan', [
                                        'class' => 'btn btn-success btn-flat',
                                        'onclick' => 'javascript:return confirm("Yakin Data Ini Sudah Benar")',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     {{-- Modal History Penjualan ======================================================================== --}}
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
@endsection

@section('script')
    <script type="text/javascript">
        $(".skin-red").addClass("sidebar-collapse");
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr("href") // activated tab
            // alert(target);
        });
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('', true);
    </script>
    <script>
        $(document).on('click','.btn-history-resep',function(){
        let id = $(this).attr('data-id');
        $.ajax({
            url: '/tindakan/e-resep/history/'+id,
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
            $('#listHistoryResep').html('');
            },
            success: function (res){
            $('#listHistoryResep').html(res.html);
            $('#myModalHistoryResep').modal('show');
            }
        });
        })

        function diberikan() {
            var checkBox = document.getElementById("edukasiDiberikan");
            var text = document.getElementById("edukasiDiberikanText");
            if (checkBox.checked == true) {
                text.type = "text";
            } else {
                text.type = "hidden";
            }
        }

        function bicara() {
            var checkBox = document.getElementById("bicaraId");
            var text = document.getElementById("bicaraText");
            if (checkBox.checked == true) {
                text.type = "text";
            } else {
                text.type = "hidden";
            }
        }

        function bicaraSeharihari() {
            var checkBox = document.getElementById("bicaraSeharihariId");
            var text = document.getElementById("bicaraSeharihariText");
            if (checkBox.checked == true) {
                text.type = "text";
            } else {
                text.type = "hidden";
            }
        }

        function alergi() {
            var checkBox = document.getElementById("alergiId");
            var text = document.getElementById("alergiText");
            if (checkBox.checked == true) {
                text.type = "text";
            } else {
                text.type = "hidden";
            }
        }

        function penyakitKeluarga() {
            var checkBox = document.getElementById("penyakitKeluargaId");
            var text = document.getElementById("penyakitKeluargaText");
            if (checkBox.checked == true) {
                text.type = "text";
            } else {
                text.type = "hidden";
            }
        }

        $(document).ready(function(){
            
            $('#cara_pulang').on('change', function(){
                var selectedValue = $(this).val();
                console.log(selectedValue);
                if(selectedValue == 2){
                    $('#rujukan').css('display', 'table-row');
                    $('#rs_rujukan').css('display', 'table-row');
                    $('#alasan_rujukan').css('display', 'table-row');

                    $('#faskes').trigger('change');
                    
                } else {
                    $('#rujukan').css('display', 'none');
                    $('#rs_rujukan').css('display', 'none');
                    $('#alasan_rujukan').css('display', 'none');
                }
            });

            $('#faskes').on('change', function(){
                var selectedValue = $(this).val();
                console.log(selectedValue);
                if(selectedValue != ''){
                    $('#faskes_rs_rujukan').val('');

                    $('#faskes_rs_rujukan').select2({
                        placeholder: "Pilh Faskes RS Rujukan",
                        width: '100%',
                        ajax: {
                            url: '/emr-soap/ajax-faskes-rs',
                            dataType: 'json',
                            data: function (params) {
                                return {
                                    jenis_faskes: selectedValue
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
                    
                }
            });
        });
       
    </script>

    {{-- ICD 10 --}}
@endsection
