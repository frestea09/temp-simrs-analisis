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

    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }

    .select2-selection__rendered {
        padding-left: 20px !important;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@section('header')
    <h1>Formulir Edukasi Pasien Dan Keluarga</h1>
@endsection

@section('content')
    @php
        $poli = request()->get('poli');
        $dpjp = request()->get('dpjp');
    @endphp
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
            </h3>
        </div>
        <div class="box-body">
            <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
            <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
            <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

            @include('emr.modules.addons.profile')
            <form method="POST" action="{{ url('emr-soap/pemeriksaan/inap/pernyataan-dnr/' . $unit . '/' . $reg->id) }}"
                class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        {!! Form::hidden('assesment_id', @$riwayat->id) !!}
                          <h4 style="text-align: center; padding: 10px"><b>Pernyataan DNR</b></h4>
                        <br>
                    </div>
                </div>
                
                <div class="row">

                    <div class="col-md-12">
                        <table style="width: 100%"
                            class="table-striped table-bordered table-hover table-condensed form-box table"
                            style="font-size:12px;">
                            <tr>
                                <td style="width:30%;">Diagnosa</td>
                                <td style="padding: 5px;">
                                    <input type="text" name="fisik[pernyataan_dnr][diagnosa]" value="{{@$assesment['pernyataan_dnr']['diagnosa']}}" class="form-control" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width:30%; font-weight: bold;">Status Resusitasi</td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Apakah pasien ini dilakukan resusitasi</td>
                                <td>
                                    <div style="display: flex; flex-flow: column">
                                        <div style="width:100%;">
                                            <input class="form-check-input"
                                                name="fisik[pernyataan_dnr][status_resusitasi][ya]"
                                                type="checkbox" value="Ya"  {{ @$assesment['pernyataan_dnr']['status_resusitasi']['ya'] == 'Ya' ? 'checked' : '' }} >
                                            <label for="">Ya</label>
                                        </div>
                                        <div style="width:100%;">
                                            <input class="form-check-input"
                                                name="fisik[pernyataan_dnr][status_resusitasi][tidak]"
                                                type="checkbox" value="Tidak"  {{ @$assesment['pernyataan_dnr']['status_resusitasi']['tidak'] == 'Tidak' ? 'checked' : '' }} >
                                            <label for="">Tidak</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"><span>Jika jawaban "Tidak", berikan alasan</span></td>
                                <td>
                                    <div style="display: flex; flex-flow: column">
                                        <div style="width:100%;">
                                            <input class="form-check-input"
                                                name="fisik[pernyataan_dnr][alasan_tidak][kondisi_pasien]"
                                                type="checkbox" value="Kondisi pasien mengindikasi bahwa resusitasi tidak mungkin efektif atau berhasil"  {{ @$assesment['pernyataan_dnr']['alasan_tidak']['kondisi_pasien'] == 'Kondisi pasien mengindikasi bahwa resusitasi tidak mungkin efektif atau berhasil' ? 'checked' : '' }} >
                                            <label for="">Kondisi pasien mengindikasi bahwa resusitasi tidak mungkin efektif atau berhasil</label>
                                        </div>
                                        <div style="width:100%;">
                                            <input class="form-check-input"
                                                name="fisik[pernyataan_dnr][alasan_tidak][pasien_menolak]"
                                                type="checkbox" value="Pasien/Keluarga menolak dilakukan tindakan resusitasi"  {{ @$assesment['pernyataan_dnr']['alasan_tidak']['pasien_menolak'] == 'Pasien/Keluarga menolak dilakukan tindakan resusitasi' ? 'checked' : '' }} >
                                            <label for="">Pasien/Keluarga menolak dilakukan tindakan resusitasi</label> <br>
                                            <span>Hubungan dengan pasien :</span>
                                            <input type="text" name="fisik[pernyataan_dnr][alasan_tidak][hubungan_pasien]" value="{{@$assesment['pernyataan_dnr']['alasan_tidak']['hubungan_pasien']}}" class="form-control" />
                                        </div>
                                        <div style="width:100%;">
                                            <input class="form-check-input"
                                                name="fisik[pernyataan_dnr][alasan_tidak][alasan_lain]"
                                                type="checkbox" value="Pasien/Keluarga menolak dilakukan tindakan resusitasi"  {{ @$assesment['pernyataan_dnr']['alasan_tidak']['alasan_lain'] == 'Pasien/Keluarga menolak dilakukan tindakan resusitasi' ? 'checked' : '' }} >
                                            <label for="">Alasan lain, sebutkan</label> <br>
                                            <input type="text" name="fisik[pernyataan_dnr][alasan_tidak][alasan_lain_tidak]" value="{{@$assesment['pernyataan_dnr']['alasan_tidak']['alasan_lain_tidak']}}" class="form-control" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="width:30%; font-weight: bold;">Komunikasi</td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Didiskusikan dengan pasien</td>
                                <td>
                                    <div style="display: flex; flex-flow: column">
                                        <div style="width:100%;">
                                            <input class="form-check-input"
                                                name="fisik[pernyataan_dnr][komunikasi][diskusi_pasien][ya]"
                                                type="checkbox" value="Ya"  {{ @$assesment['pernyataan_dnr']['komunikasi']['diskusi_pasien']['ya'] == 'Ya' ? 'checked' : '' }} >
                                            <label for="">Ya</label>
                                        </div>
                                        <div style="width:100%;">
                                            <input class="form-check-input"
                                                name="fisik[pernyataan_dnr][komunikasi][diskusi_pasien][tidak]"
                                                type="checkbox" value="Tidak"  {{ @$assesment['pernyataan_dnr']['komunikasi']['diskusi_pasien']['tidak'] == 'Tidak' ? 'checked' : '' }} >
                                            <label for="">Tidak</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Didiskusikan dengan keluarga pasien</td>
                                <td>
                                    <div style="display: flex; flex-flow: column">
                                        <div style="width:100%;">
                                            <input class="form-check-input"
                                                name="fisik[pernyataan_dnr][komunikasi][diskusi_pasien_keluarga][ya]"
                                                type="checkbox" value="Ya"  {{ @$assesment['pernyataan_dnr']['komunikasi']['diskusi_pasien_keluarga']['ya'] == 'Ya' ? 'checked' : '' }} >
                                            <label for="">Ya</label>
                                        </div>
                                        <div style="width:100%;">
                                            <input class="form-check-input"
                                                name="fisik[pernyataan_dnr][komunikasi][diskusi_pasien_keluarga][tidak]"
                                                type="checkbox" value="Tidak"  {{ @$assesment['pernyataan_dnr']['komunikasi']['diskusi_pasien_keluarga']['tidak'] == 'Tidak' ? 'checked' : '' }} >
                                            <label for="">Tidak</label><br>
                                            <span>Jika tidak, berikan alasan</span>
                                            <input type="text" name="fisik[pernyataan_dnr][komunikasi][diskusi_pasien_keluarga_tidak]" value="{{@$assesment['pernyataan_dnr']['komunikasi']['diskusi_pasien_keluarga_tidak']}}" class="form-control" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Alamat lengkap dokter</td>
                                <td>
                                    <div style="display: flex; flex-flow: column">
                                        <div style="width:100%;">
                                            <input class="form-check-input"
                                                name="fisik[pernyataan_dnr][komunikasi][alamat_lengkap_dokter][ya]"
                                                type="checkbox" value="Ya"  {{ @$assesment['pernyataan_dnr']['komunikasi']['alamat_lengkap_dokter']['ya'] == 'Ya' ? 'checked' : '' }} >
                                            <label for="">Ya</label>
                                        </div>
                                        <div style="width:100%;">
                                            <input class="form-check-input"
                                                name="fisik[pernyataan_dnr][komunikasi][alamat_lengkap_dokter][tidak]"
                                                type="checkbox" value="Tidak"  {{ @$assesment['pernyataan_dnr']['komunikasi']['alamat_lengkap_dokter']['tidak'] == 'Tidak' ? 'checked' : '' }} >
                                            <label for="">Tidak</label><br>
                                            <span>Jika tidak, berikan alasan</span>
                                            <input type="text" name="fisik[pernyataan_dnr][komunikasi][alamat_lengkap_dokter_tidak]" value="{{@$assesment['pernyataan_dnr']['komunikasi']['alamat_lengkap_dokter_tidak']}}" class="form-control" />
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Tanggal Peninjauan Ulang</td>
                                <td style="padding: 5px;">
                                    <input type="date" name="fisik[pernyataan_dnr][tanggal_peninjauan_ulang]" value="{{@$assesment['pernyataan_dnr']['tanggal_peninjauan_ulang']}}" class="form-control" />
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

                <button class="btn btn-success pull-right">Simpan</button>
            </form>
            <br />
            
        </div>
    </div>


    

@endsection

@section('script')
    <script>
        $(".skin-blue").addClass("sidebar-collapse");
        $('#dokter_id').select2()

        function editDokter(id) {
            var dok = $('#dokter_id').val();
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/emr/editDokter/' + dok + '/' + id,
                    type: 'POST',
                    dataType: 'json',
                })
                .done(function(data) {
                    alert('Berhasil Ubah DPJP');
                })
                .fail(function() {
                    alert('Gagal Ubah DPJP');
                });

        }
    </script>
    
@endsection
