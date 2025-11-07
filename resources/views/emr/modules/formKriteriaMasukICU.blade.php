@extends('master')

<style>
    .form-box td,
    select,
    input,
    textarea {
        font-size: 12px !important;
    }

    .history-family input[type=text] {
        height: 80px !important;
        padding: 0px !important;
    }

    .history-family-2 td {
        padding: 1px !important;
    }

    .scroll-umum {
        width: 100%;
        overflow-y: scroll;
        height: 40%;
        display: block;
    }
    .border {
        border: 1px solid black;
    }

    .bold {
        font-weight: bold;
    }

    .p-1 {
        padding: 1rem;
    }
</style>
@section('header')
    <h1>Formulir Kriteria ICU</h1>
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

            @include('emr.modules.addons.profile')
            <form method="POST" action="{{ url('emr/form-kriteria-masuk-icu/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                        {!! Form::hidden('asessment_id', @$riwayat->id) !!}
                        <br>
                        <div class="col-md-12">
                            <table class='table-striped table-bordered table-hover table-condensed table'>
                                <thead>
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle;">Tanggal Asessment</th>
                                        <th class="text-center" style="vertical-align: middle;">User</th>
                                        <th class="text-center" style="vertical-align: middle;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($riwayats) == 0)
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak Ada Riwayat Asessment</td>
                                        </tr>
                                    @endif
                                    @foreach ($riwayats as $riwayat)
                                        <tr>
                                            <td
                                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                {{ Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i') }}
                                            </td>
                                            <td
                                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                {{@baca_user($riwayat->user_id)}}
                                            </td>
                                            <td
                                                style="text-align: center; {{ $riwayat->id == request()->asessment_id ? ' background-color:rgb(172, 247, 162)' : '' }}">
                                                <a href="{{ URL::current() . '?asessment_id=' . $riwayat->id }}"
                                                    class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                <a href="{{url('emr-print/cetak-kriteria-masuk-icu/'.$unit .'/'. $reg->id .'/'. $riwayat->id)}}" target="_blank" class="btn btn-warning btn-sm">Cetak</a>
                                                <a href="{{url('emr-soap-hapus-pemeriksaan/'.$unit .'/'. $reg->id .'/'. $riwayat->id)}}"  class="btn btn-danger btn-sm" onclick="return confirm('Yakin Akan Menghapus Data Ini ?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            {{-- Anamnesis --}}
                            <div class="col-md-12">
                                <h5><b>FORMULIR KRITERIA PASIEN MASUK ICU</b></h5>
    
                                <table style="width: 100%;" class="border">
                                    <thead>
                                        <tr>
                                            <th class="bold p-1 border text-center" style="width: 5%;">No</th>
                                            <th class="bold p-1 border text-center" style="width: 75%">PRIORITAS</th>
                                            <th class="bold p-1 border text-center" style="width: 10%;">Ya</th>
                                            <th class="bold p-1 border text-center" style="width: 10%;">Tidak</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="p-1 border text-center" style="vertical-align: top;">1</td>
                                            <td colspan="3" class="p-1 border" style="vertical-align: top;"><b>PRIORITAS I</b></td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                1. Pasien Kritis tidak stabil <br>
                                                Tensi : <input style="width: 7%;" type="text" name="fisik[pasien_masuk][tensi]" value="{{@$assesment['pasien_masuk']['tensi']}}"> mmhg 
                                                HR : <input style="width: 7%;" type="text" name="fisik[pasien_masuk][hr]" value="{{@$assesment['pasien_masuk']['hr']}}"> x/menit 
                                                Suhu : <input style="width: 7%;" type="text" name="fisik[pasien_masuk][suhu]" value="{{@$assesment['pasien_masuk']['suhu']}}"> °C
                                                GCS : <input style="width: 7%;" type="text" name="fisik[pasien_masuk][gcs]" value="{{@$assesment['pasien_masuk']['gcs']}}">
                                                SpO2 : <input style="width: 7%;" type="text" name="fisik[pasien_masuk][spo2]" value="{{@$assesment['pasien_masuk']['spo2']}}"> %
                                                RR : <input style="width: 7%;" type="text" name="fisik[pasien_masuk][rr]" value="{{@$assesment['pasien_masuk']['rr']}}"> x/menit
                                                
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][prioritasI][checkbox][1]"
                                                    {{ @$assesment['pasien_masuk']['prioritasI']['checkbox']['1'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][prioritasI][checkbox][1]"
                                                    {{ @$assesment['pasien_masuk']['prioritasI']['checkbox']['1'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                2. Pasien memerlukan bantuan ventilasi/intubasi (RM, NRM, NIV, Ventilator) <br>
                                                {{-- a. Adanya gagal napas <br>
                                                &nbsp;- Apneu / Henit napas <br>
                                                &nbsp;- Inadekuat ventilasi <br>
                                                &nbsp;- Inadekuat oksigenasi <br>
                                                b. Insufiensi fungsi respirasi dengan gagal tumbuh kembang <br>
                                                c. Insufiensi kardiak/syok <br>
                                                &nbsp;- Mengurangi work of breathing <br>
                                                &nbsp;- Mengurangi konsumsi oksigen <br>
                                                d. Disfungsi neurologis <br>
                                                e. Hipoventilasi sentral / frequent apnea <br>
                                                f. Penurunan kesadaran/ GCS ≤ 8 <br>
                                                g. Ketidakmampuan mempertahankan jalan napas  <br> --}}
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][prioritasI][checkbox][2]"
                                                    {{ @$assesment['pasien_masuk']['prioritasI']['checkbox']['2'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][prioritasI][checkbox][2]"
                                                    {{ @$assesment['pasien_masuk']['prioritasI']['checkbox']['2'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                3. Pasien memerlukan obat-obat vasoaktif (dopamin, dobutamin, NE (Norepineprin), adrenalin)
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][prioritasI][checkbox][3]"
                                                    {{ @$assesment['pasien_masuk']['prioritasI']['checkbox']['3'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][prioritasI][checkbox][3]"
                                                    {{ @$assesment['pasien_masuk']['prioritasI']['checkbox']['3'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border text-center" style="vertical-align: top;">2</td>
                                            <td colspan="3" class="p-1 border" style="vertical-align: top;"><b>PRIORITAS II</b></td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                Pasien yang memerlukan observasi ketat dan kondisinya sewaktu-waktu dapat berubah 
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][prioritasII][checkbox][1]"
                                                    {{ @$assesment['pasien_masuk']['prioritasII']['checkbox']['1'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][prioritasII][checkbox][1]"
                                                    {{ @$assesment['pasien_masuk']['prioritasII']['checkbox']['1'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border text-center" style="vertical-align: top;">3</td>
                                            <td colspan="3" class="p-1 border" style="vertical-align: top;"><b>PRIORITAS III</b></td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                Pasien dengan Kriteria primer berat atau terminal dengan komplikasi penyakit akut. kritis yang memerlukan pertolongan untuk penyakit kritisnya tetapi tidak sampai intubasi dan RJP
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][prioritasIII][checkbox][1]"
                                                    {{ @$assesment['pasien_masuk']['prioritasIII']['checkbox']['1'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][prioritasIII][checkbox][1]"
                                                    {{ @$assesment['pasien_masuk']['prioritasIII']['checkbox']['1'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border text-center" style="vertical-align: top;">4</td>
                                            <td colspan="3" class="p-1 border" style="vertical-align: top;"><b>SESUAI DIAGNOSA PENYAKIT</b></td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                a. Pasien Kardiovaskuler <br>
                                                Diagnosa : <input style="width: 50%;" type="text" name="fisik[pasien_kardiovaskuler]" value="{{@$assesment['pasien_kardiovaskuler']}}">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][1]"
                                                    {{ @$assesment['pasien_masuk']['[sesuai_diagnosa]']['checkbox']['1'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][1]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['1'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                b. Pasien Pernapasan <br>
                                                Diagnosa : <input style="width: 50%;" type="text" name="fisik[pasien_pernapasan]" value="{{@$assesment['pasien_pernapasan']}}">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][2]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['2'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][2]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['2'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                c. Pasien Neurologis <br>
                                                Diagnosa : <input style="width: 50%;" type="text" name="fisik[pasien_neurologis]" value="{{@$assesment['pasien_neurologis']}}">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][3]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['3'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][3]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['3'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                d. Pasien overdosis obat / keracunan obat <br>
                                                Diagnosa : <input style="width: 50%;" type="text" name="fisik[pasien_overdosis]" value="{{@$assesment['pasien_overdosis']}}">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][4]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['4'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][4]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['4'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                e. Pasien Gastrointesinal <br>
                                                Diagnosa : <input style="width: 50%;" type="text" name="fisik[pasien_gastrointesinal]" value="{{@$assesment['pasien_gastrointesinal']}}">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][5]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['5'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][5]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['5'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                f. Pasien Endokrin <br>
                                                Diagnosa : <input style="width: 50%;" type="text" name="fisik[pasien_endokrin]" value="{{@$assesment['pasien_endokrin']}}">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][6]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['6'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][6]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['6'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                g. Pasien Bedah <br>
                                                Diagnosa : <input style="width: 50%;" type="text" name="fisik[pasien_bedah]" value="{{@$assesment['pasien_bedah']}}">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][7]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['7'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][7]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['7'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                h. Lain-lain <br>
                                                Diagnosa : <input style="width: 50%;" type="text" name="fisik[lain_lain]" value="{{@$assesment['lain_lain']}}">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][8]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['8'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_masuk][sesuai_diagnosa][checkbox][8]"
                                                    {{ @$assesment['pasien_masuk']['sesuai_diagnosa']['checkbox']['8'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                
                            </div>
                            
                            <div class="col-md-12 text-right" style="margin-top: 20px;">
                                <button class="btn btn-success">Simpan</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
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
            $("#date_dengan_tanggal").attr('required', true);
        </script>
    @endsection
