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
            <form method="POST" action="{{ url('emr/form-kriteria-keluar-icu/' . $unit . '/' . $reg->id) }}" class="form-horizontal">
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
                                                <a href="{{url('emr-print/cetak-kriteria-keluar-icu/'.$unit .'/'. $reg->id .'/'. $riwayat->id)}}" target="_blank" class="btn btn-warning btn-sm">Cetak</a>
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
                                <h5><b>FORMULIR KRITERIA PASIEN KELUAR ICU</b></h5>
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
                                            <td class="p-1 border" style="vertical-align: top;">1</td>
                                            <td class="p-1 border">
                                                Pasien tidak lagi memerlukan alat atau obat life support
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][1][1]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['1']['1'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][1][1]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['1']['1'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                Masker NRM / RM / NIV / Ventilator
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][1][2]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['1']['2'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][1][2]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['1']['2'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;"></td>
                                            <td class="p-1 border">
                                                Dopamin / Dobutamin / NE (Norepineprin) / Adrenaline
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][1][3]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['1']['3'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][1][3]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['1']['3'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;">2</td>
                                            <td class="p-1 border">
                                                Therapi telah dinyatakan gagal, prognosis jangka pendek jelek dan manfaat kelanjutan therapi intensif kecil (Gagal multi organ tidak berespon terhadap therapi agresif)
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][2][1]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['2']['1'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][2][1]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['2']['1'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;">2</td>
                                            <td class="p-1 border">
                                                Pasien dalam kondisi normal (sesuai parameter base line) dan kemungkinan kebutuhan therapi intensif secara mendadak kecil / kurang <br>
                                                Tensi : <input style="width: 7%;" type="text" name="fisik[pasien_keluar][tensi]" value="{{@$assesment['pasien_keluar']['tensi']}}"> mmhg 
                                                HR : <input style="width: 7%;" type="text" name="fisik[pasien_keluar][hr]" value="{{@$assesment['pasien_keluar']['hr']}}"> x/menit 
                                                Suhu : <input style="width: 7%;" type="text" name="fisik[pasien_keluar][suhu]" value="{{@$assesment['pasien_keluar']['suhu']}}"> °C
                                                GCS : <input style="width: 7%;" type="text" name="fisik[pasien_keluar][gcs]" value="{{@$assesment['pasien_keluar']['gcs']}}">
                                                SpO2 : <input style="width: 7%;" type="text" name="fisik[pasien_keluar][spo2]" value="{{@$assesment['pasien_keluar']['spo2']}}"> %
                                                RR : <input style="width: 7%;" type="text" name="fisik[pasien_keluar][rr]" value="{{@$assesment['pasien_keluar']['rr']}}"> x/menit
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][3][1]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['3']['1'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][3][1]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['3']['1'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;">2</td>
                                            <td class="p-1 border">
                                                Manfaat therapi intensif kecil karena penyakit primernya sudah terminal, tidak berespon terhadap therapi ICU untuk penyakit akutnya, prognosis jangka pendek kecil dan tidak ada therapi potensial untuk memperbaiki prognosisnya
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][4][1]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['4']['1'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][4][1]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['4']['1'] == 'TIDAK' ? 'checked' : '' }}
                                                    type="checkbox" value="TIDAK">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-1 border" style="vertical-align: top;">2</td>
                                            <td class="p-1 border">
                                                Lain-lain <br>
                                                <input style="width: 50%;" type="text" name="fisik[pasien_keluar][lain_lain]" value="{{@$assesment['pasien_keluar']['lain_lain']}}">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][5][1]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['5']['1'] == 'YA' ? 'checked' : '' }}
                                                    type="checkbox" value="YA">
                                            </td>
                                            <td class="p-1 border" style="text-align: center;">
                                                <input class="form-check-input"
                                                    name="fisik[pasien_keluar][checkbox][5][1]"
                                                    {{ @$assesment['pasien_keluar']['checkbox']['5']['1'] == 'TIDAK' ? 'checked' : '' }}
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
