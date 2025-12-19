@extends('master')

@section('css')
<style>
    .blink_me {
        animation: blinker 4s linear infinite;
        color: red;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
</style>
@endsection

@section('header')
<h1>
    Sistem Rawat Inap
</h1>
@endsection

@section('content')

<div class="box box-primary">

    <div class="box-body">
        <div class="box box-info">
            <div class="box-body">
                @if (count($bed) > 0)
                    
                @foreach ($bed as $item)
                <div class="row">
                    @php
                    libxml_use_internal_errors(true);
                    @$reg_id = $item->registrasi_id;
                    @$registrasi_id = $item->registrasi_id;
                    @@$reg = \Modules\Registrasi\Entities\Registrasi::where('id', '=', @$registrasi_id)->first();

                    $rawatinap = \App\Rawatinap::with('biaya_diagnosa_awal')->where('registrasi_id',@$registrasi_id)->first();
                    
                    @endphp
                    <div class="col-md-12">
                        <div class='table-responsive' style="overflow: hidden;">
                            <table class='table-striped table-bordered table-hover table-condensed table'>
                                <tbody>
                                    <tr>
                                        <th>Nama Pasien</th>
                                        <td>{{ @$reg->pasien->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. RM</th>
                                        <td>{{ @$reg->pasien->no_rm }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ @$reg->pasien->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cara Bayar</th>
                                        <td>{{ baca_carabayar(@$reg->bayar) }}
                                            @if (@$reg->bayar == '1')
                                            @if (!empty(@$reg->tipe_jkn))
                                            - {{ @$reg->tipe_jkn }}
                                            @endif
                                            @endif
                                            {{-- @if (!empty(@$reg->perusahaan_id))
                                            - {{ @$reg->perusahaan->nama }}
                                            @endif --}}
                                        </td>
                                    </tr>
                                    @if (@$reg->bayar == '1')
                                    <tr>
                                        <th>No. SEP</th>
                                        <td>{{ @$reg->no_sep ? @$reg->no_sep : @\App\HistoriSep::where('registrasi_id',
                                            @$reg->id)->first()->no_sep }}
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <th>Hak Kelas JKN </th>
                                        <td>{{ @$reg->hak_kelas_inap }}</td>
                                    </tr> --}}
                                    @endif
                                    <tr>
                                        {{-- <th>Kelas Perawatan </th>
                                        <td>{{ baca_kelas(@$reg->kelas_id) }}</td> --}}
                                        <th>Kelas Perawatan </th>
                                        <td>{{ baca_kelas(@$rawatinap->kelas_id) }}</td>
                                        @php
                                        session(['kelas_id' => @@$reg->kelas_id]);
                                        @endphp
                                    </tr>
                                    {{-- <tr>
                                        <th>DPJP IGD</th>
                                        <td>{{ baca_dokter(@$reg->dokter_id) }}</td>
                                    </tr> --}}
                                    <tr>
                                        <th>DPJP UTAMA</th>
                                        <td> <b> {{ baca_dokter(@$rawatinap->dokter_id) }} </b></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Masuk</th>
                                        <td> {{ tanggal_eklaim(@$rawatinap->tgl_masuk) }} </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Keluar</th>
                                        <td> {{ tanggal_eklaim(@$rawatinap->tgl_keluar) }} </td>
                                    </tr>
                                    <tr>
                                        <th>Kamar </th>
                                        <td>{{ baca_kamar(@$rawatinap->kamar_id) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status </th>
                                        <td>
                                            @if (@$reg->status_reg == 'I3')
                                            <b style="color:green">DIPULANGKAN</b>
                                            @else
                                            <b style="color:red">BELULM DIPULANGKAN</b>
                                            @endif
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <th>ICD 9</th>
                                        <td>
                                            @if (!empty($icd9))
                                            {{ implode(',', $icd9) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>ICD 10</th>
                                        <td>
                                            @if (!empty($icd10))
                                            {{ implode(',', $icd10) }}
                                            @endif
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <hr/>
                <hr/>
                <hr/>
                    @endforeach
                @endif


            </div>
        </div>


    </div>
</div>
@stop


@section('script')
<script type="text/javascript">
    $(".skin-blue").addClass("sidebar-collapse");
            $(function() {
                //LOAD TINDAKAN IRNA
                var registrasi_id = $('input[name="registrasi_id"]').val()
                
                if (loadData == true) {
                    $('.progress').addClass('hidden')
                }
            });
            
            status_reg = "I"
           

            // console.log(settings.kelas_id)
            $('.select2').select2();

            let kelas_id = $('select[name="kelas_id"]').val()
 
 

            function ribuan(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

</script>
@endsection