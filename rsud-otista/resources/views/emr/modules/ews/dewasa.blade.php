@extends('master')

@section('header')
    <h1>EWS DEWASA</h1>
@endsection
<style>
    .new {
        background-color: #e4ffe4;
    }
</style>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                    </div>

                    <div class="col-md-12" style="margin: 2rem 0;">
                        <h5 class="text-bold">INFORMASI SKOR</h5>
                        <table class="table-bordered table" id="data"style="font-size: 12px;margin-top:0px !important">
                            <tbody style="font-size:11px;">
                                <tr style="font-size:11px; background-color: rgba(3, 130, 3, 0.774); color: white; font-weight: bold;">
                                    <td style="width: 200px;">Skor 0 (Sangat Rendah)</td>
                                    <td>Monitoring per-shift oleh perawat pelaksanaan dan didokumentasikan.</td>
                                </tr>
                                <tr style="font-size:11px; background-color: rgb(196, 193, 0); color: white; font-weight: bold;">
                                    <td style="width: 200px;">Skor 1-3 (Rendah)</td>
                                    <td>Monitoring TTV per 1 jam dikaji ulang dan lapor ke dokter.</td>
                                </tr>
                                <tr style="font-size:11px; background-color: rgb(255, 128, 0); color: white; font-weight: bold;">
                                    <td style="width: 200px;">Skor 4-5 (Sedang)</td>
                                    <td>Monitoring TTV per 30 menit pengkajian dilakukan PJ Shift & diketahui oleh dokter jaga. Dokter jaga visit pasien & melaporkan ke DPJP untuk tata laksana selanjutnya, pasien diputuskan pindah ke HCU.</td>
                                </tr>
                                <tr style="font-size:11px; background-color: rgb(179, 29, 29); color: white; font-weight: bold;">
                                    <td style="width: 200px;">Skor 6 (Tinggi)</td>
                                    <td>Monitoring ulang tiap 10 menit & aktifkan Code Blue, laporkan segera ke dokter / DPJP & pasien rujuk ke ICU.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                {{-- @if (!$emr) --}}
                    <form method="POST" action="{{ url('emr-ews-dewasa') }}" class="form-horizontal">
                {{-- @else
                    <form method="POST" action="{{ url('emr-update-konsuldokter') }}" class="form-horizontal">
                        {!! Form::hidden('emr_id', $emr->id) !!}
                @endif --}}
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('unit', $unit) !!}
                            {!! Form::hidden('emr_id', @$emr->id) !!}
                            {{-- {{dd($emr->id)}} --}}
                            <br>
                    {{-- List soap --}}
                    
                    {{-- Soap Input --}}
                    <div class="col-md-8">
                        <table style="width: 100%" style="font-size:12px;">
                            <tr>
                                <td>Tanggal</td>
                                <td style="padding: 5px;">
                                    <div class="row">
                                        <div class="col-md-6"><input type="date" name="tanggal" class="form-control"
                                                value="{{ @$emr->tanggal ? @$emr->tanggal : date('Y-m-d') }}"></div>
                                        {{-- <div class="col-md-6"><input type="time" name="waktu" class="form-control"
                                                value="{{ @$emr->waktu ? @$emr->waktu : date('H:i') }}"></div> --}}
                                    </div>


                                </td>
                            </tr>
                            <tr>
                                <td>Waktu</td>
                                <td style="padding: 5px;">
                                    <div class="row">
                                        <div class="col-md-6"><input type="time" name="waktu" class="form-control"
                                                value="{{ @$emr->waktu ? @$emr->waktu : date('H:i') }}"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Tingkat Kesadaran</td>
                                <td style="padding: 5px;">
                                    <input type="radio" class="input_skor" name="formulir[tingkat_kesadaran]" {{@explode(',', @$ewss['tingkat_kesadaran'])[0] == 'sadar' ? 'checked' : ''}} value="sadar,0" > Sadar (0)<br/>
                                    <input type="radio" class="input_skor" name="formulir[tingkat_kesadaran]" {{@explode(',', @$ewss['tingkat_kesadaran'])[0] == 'suara' ? 'checked' : ''}} value="suara,2"> Suara (2)<br/>
                                    <input type="radio" class="input_skor" name="formulir[tingkat_kesadaran]" {{@explode(',', @$ewss['tingkat_kesadaran'])[0] == 'bingung' ? 'checked' : ''}} value="bingung,3"> Bingung (3)<br/>
                                    <input type="radio" class="input_skor" name="formulir[tingkat_kesadaran]" {{@explode(',', @$ewss['tingkat_kesadaran'])[0] == 'nyeri' ? 'checked' : ''}} value="nyeri,3"> Nyeri (3)<br/>
                                    <input type="radio" class="input_skor" name="formulir[tingkat_kesadaran]" {{@explode(',', @$ewss['tingkat_kesadaran'])[0] == 'tidak_respon' ? 'checked' : ''}} value="tidak_respon,3"> Tidak Respon (3)
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Pernapasan</td>
                                <td style="padding: 5px;">
                                    <input type="radio" class="input_skor" name="formulir[pernapasan]" {{@explode(',', @$ewss['pernapasan'])[0] == '8' ? 'checked' : ''}} value="8,3"> =< 8 (3)<br/>
                                    <input type="radio" class="input_skor" name="formulir[pernapasan]" {{@explode(',', @$ewss['pernapasan'])[0] == '9' ? 'checked' : ''}} value="9,1"> 9-11 (1)<br/>
                                    <input type="radio" class="input_skor" name="formulir[pernapasan]" {{@explode(',', @$ewss['pernapasan'])[0] == '12' ? 'checked' : ''}} value="12,0"> 12-20 (0)<br/>
                                    <input type="radio" class="input_skor" name="formulir[pernapasan]" {{@explode(',', @$ewss['pernapasan'])[0] == '21' ? 'checked' : ''}} value="21,2"> 21-24 (2)<br/>
                                    <input type="radio" class="input_skor" name="formulir[pernapasan]" {{@explode(',', @$ewss['pernapasan'])[0] == '25' ? 'checked' : ''}} value="25,3"> >= 25 (3)<br/>
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_pernapasan]" value="{{@$ewss['nilai_pernapasan']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Saturasi Oksigen</td>
                                <td style="padding: 5px;">
                                    <input type="radio" class="input_skor" name="formulir[saturasi_oksigen]"  {{@explode(',', @$ewss['saturasi_oksigen'])[0] == '91' ? 'checked' : ''}}  value="91,3"> =< 91 (3)<br/>
                                    <input type="radio" class="input_skor" name="formulir[saturasi_oksigen]"  {{@explode(',', @$ewss['saturasi_oksigen'])[0] == '92' ? 'checked' : ''}}  value="92,2"> 92-93 (2)<br/>
                                    <input type="radio" class="input_skor" name="formulir[saturasi_oksigen]"  {{@explode(',', @$ewss['saturasi_oksigen'])[0] == '94' ? 'checked' : ''}}  value="94,1"> 94-95 (1)<br/>
                                    <input type="radio" class="input_skor" name="formulir[saturasi_oksigen]"  {{@explode(',', @$ewss['saturasi_oksigen'])[0] == '96' ? 'checked' : ''}}  value="96,0"> >= 96 (0)
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_saturasi_oksigen]" value="{{@$ewss['nilai_saturasi_oksigen']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Penggunaan Oksigen</td>
                                <td style="padding: 5px;">
                                    <input type="radio" class="input_skor" name="formulir[penggunaan_oksigen]" {{@explode(',', @$ewss['penggunaan_oksigen'])[0] == 'ya' ? 'checked' : ''}} value="ya,2"> YA (2)<br/>
                                    <input type="radio" class="input_skor" name="formulir[penggunaan_oksigen]" {{@explode(',', @$ewss['penggunaan_oksigen'])[0] == 'tidak' ? 'checked' : ''}} value="tidak,0"> TIDAK (0)
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Tekanan Darah</td>
                                <td style="padding: 5px;">
                                    <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',', @$ewss['tekanan_darah'])[0] == '220' ? 'checked' : ''}}  value="220,3"> >=220 (3)<br/>
                                    <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',', @$ewss['tekanan_darah'])[0] == '200' ? 'checked' : ''}}  value="200,2"> 200-220 (2)<br/>
                                    <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',', @$ewss['tekanan_darah'])[0] == '160' ? 'checked' : ''}}  value="160,1"> 160-199 (1)<br/>
                                    <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',', @$ewss['tekanan_darah'])[0] == '111' ? 'checked' : ''}}  value="111,0"> 111-159 (0)<br/>
                                    <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',', @$ewss['tekanan_darah'])[0] == '101' ? 'checked' : ''}}  value="101,1"> 101-110 (1)<br/>
                                    <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',', @$ewss['tekanan_darah'])[0] == '91' ? 'checked' : ''}}  value="91,2"> 91-100 (2)<br/>
                                    <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',', @$ewss['tekanan_darah'])[0] == '90' ? 'checked' : ''}}  value="90,3"> 60-90 (3)<br/>
                                    <input type="radio" class="input_skor" name="formulir[tekanan_darah]" {{@explode(',', @$ewss['tekanan_darah'])[0] == '60' ? 'checked' : ''}}  value="60,3"> =< 60 (3)
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_tekanan_darah]" value="{{@$ewss['nilai_tekanan_darah']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Denyut Jantung</td>
                                <td style="padding: 5px;">
                                    <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@explode(',', @$ewss['denyut_jantung'])[0] == '131' ? 'checked' : ''}} value="131,3"> 131 (3)<br/>
                                    <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@explode(',', @$ewss['denyut_jantung'])[0] == '111' ? 'checked' : ''}} value="111,2"> 111-130 (2)<br/>
                                    <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@explode(',', @$ewss['denyut_jantung'])[0] == '91' ? 'checked' : ''}} value="91,1"> 91-130 (1)<br/>
                                    <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@explode(',', @$ewss['denyut_jantung'])[0] == '51' ? 'checked' : ''}} value="51,0"> 51-90 (0)<br/>
                                    <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@explode(',', @$ewss['denyut_jantung'])[0] == '41' ? 'checked' : ''}} value="41,1"> 41-40 (1)<br/>
                                    <input type="radio" class="input_skor" name="formulir[denyut_jantung]" {{@explode(',', @$ewss['denyut_jantung'])[0] == '40' ? 'checked' : ''}} value="40,3"> =< 40 (3)<br/>
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_denyut_jantung]" value="{{@$ewss['nilai_denyut_jantung']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Suhu</td>
                                <td style="padding: 5px;">
                                    <input type="radio" class="input_skor" name="formulir[suhu]" {{@explode(',', @$ewss['suhu'])[0] == '39' ? 'checked' : ''}} value="39,2"> >= 39,1 (2)<br/>
                                    <input type="radio" class="input_skor" name="formulir[suhu]" {{@explode(',', @$ewss['suhu'])[0] == '38' ? 'checked' : ''}} value="38,1"> 38,1 - 39,0 (1)<br/>
                                    <input type="radio" class="input_skor" name="formulir[suhu]" {{@explode(',', @$ewss['suhu'])[0] == '36' ? 'checked' : ''}} value="36,0"> 36,1 - 38,0 (0)<br/>
                                    <input type="radio" class="input_skor" name="formulir[suhu]" {{@explode(',', @$ewss['suhu'])[0] == '35' ? 'checked' : ''}} value="35,1"> 35,1 - 36,0 (1)<br/>
                                    <input type="radio" class="input_skor" name="formulir[suhu]" {{@explode(',', @$ewss['suhu'])[0] == '34' ? 'checked' : ''}} value="34,3"> =< 35 (3)<br/>
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_suhu]" value="{{@$ewss['nilai_suhu']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000; border-bottom:1px dotted #000;">
                                <td>Total Skor</td>
                                <td style="padding: 5px;" id="total_skor">
                                    @php
                                        $tingkat_kesadaran = @explode(',', @$ewss['tingkat_kesadaran'])[1];
                                        $pernapasan = @explode(',', @$ewss['pernapasan'])[1];
                                        $saturasi_oksigen = @explode(',', @$ewss['saturasi_oksigen'])[1];
                                        $penggunaan_oksigen = @explode(',', @$ewss['penggunaan_oksigen'])[1];
                                        $tekanan_darah = @explode(',', @$ewss['tekanan_darah'])[1];
                                        $denyut = @explode(',', @$ewss['denyut_jantung'])[1];
                                        $suhu = @explode(',', @$ewss['suhu'])[1];

                                        $total_skor = $tingkat_kesadaran + $pernapasan + $saturasi_oksigen + $penggunaan_oksigen + $tekanan_darah + $denyut + $suhu;
                                    @endphp
                                    {{$total_skor}}
                                </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>
                            <tr>
                                <td colspan="2">
                                    Skor Nyeri:<input value="{{@$ewss['skors_nyeri']}}" name="formulir[skors_nyeri]" type="text" style="width: 50px;">
                                    BB/TB:<input value="{{@$ewss['bbtb']}}" type="text"name="formulir[bbtb]" style="width: 50px;">
                                    Lingkar Kepala/lingkar perut:<input value="{{@$ewss['lingkep']}}" type="text" name="formulir[lingkep]" style="width: 50px;">
                                    Peroral/NGT:<input type="text" class="qty1" style="width: 50px;" name="formulir[ngt]" value="{{@$ewss['ngt']}}">
                                    Parenatal/Transfusi:<input class="qty1" value="{{@$ewss['parenatal']}}" type="text" name="formulir[parenatal]" style="width: 50px;">
                                    Jumlah:<input name="formulir[jumlah]" class="total" type="text" style="width: 50px;" value="{{@$ewss['jumlah']}}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    
                                    Feses:<input class="qty2" type="text"name="formulir[feses]" value="{{@$ewss['feses']}}" style="width: 50px;">
                                    Urin:<input class="qty2" type="text" name="formulir[urin]" value="{{@$ewss['urin']}}" style="width: 50px;">
                                    Muntah:<input type="text" class="qty2" style="width: 50px;" name="formulir[muntah]" value="{{@$ewss['muntah']}}">
                                    Darah/Drain:<input type="text" class="qty2" style="width: 50px;" name="formulir[darah]" value="{{@$ewss['darah']}}">
                                    IWL:<input type="text" style="width: 50px;" class="qty2" name="formulir[iwl]" value="{{@$ewss['iwl']}}">
                                    Jumlah:<input type="text" style="width: 50px;" class="total2" name="formulir[jumlah2]" value="{{@$ewss['jumlah2']}}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    
                                    Balance Cairan :<input type="text"name="formulir[balance]" style="width: 50px;" value="{{@$ewss['balance']}}">
                                    Lain-lain:<input type="text" name="formulir[lain]" style="width: 300px" value="{{@$ewss['lain']}}">
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="">
                                    <br/>
                                    {{-- <div class="form-group text-center"> --}}
                                    <button type="submit" class="btn btn-primary btn-flat pull-right">SIMPAN</button>
                                    {{--
                    </div> --}}
                                </td>
                            </tr>
                        </table>
                    </div>


                    <div class="col-md-4 " style="margin-top: 10px">
                        <div class="table-responsive" style="max-height: 400px !important;border:1px solid blue">
                            {{-- <table class="table-bordered table" id="data"
                                style="font-size: 12px;margin-top:0px !important"> --}}

                                {{-- <tbody style="font-size:11px;">
                                    @if (count($all_resume) == 0)
                                        <tr>
                                            <td>Tidak ada record</td>
                                        </tr>
                                    @endif
                                    @foreach ($all_resume as $key_a => $val_a)
                                        <tr class="bg-primary" style="font-size:11px;">
                                            <th>Penginput</th>
                                            <th>{{ baca_user($val_a->user_id) }}</th>
                                        </tr>
                                        <tr class="bg-primary" style="font-size:11px;">
                                            <th>Tanggal Input</th>
                                            <th>{{ date('d/m/Y H:i',strtotime($val_a->created_at)) }}</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>EWS : </b>
                                                <a class="btn btn-xs btn-primary" href="{{ url('/emr-ews-dewasa/' .$unit . '/'. $reg->id . '/' . $val_a->id . '/edit?poli='.$poli.'&dpjp='.$dpjp) }}"
                                                    data-toggle="tooltip" title="Lihat"><i
                                                        class="fa fa-eye"></i></a>&nbsp;&nbsp;    
                                                <a onclick="return confirm('Yakin akan menghapus data? jika ingin mengembalikan data mohon hubungi admin SIMRS')" class="btn btn-xs btn-danger" href="{{ url('/emr-ews-dewasa/' .$unit . '/'. $reg->id . '/' . $val_a->id . '/delete?poli='.$poli.'&dpjp='.$dpjp) }}""
                                                    data-toggle="tooltip" title="Hapus"><i
                                                        class="fa fa-trash"></i></a>&nbsp;&nbsp;    
                                            </td>
                                        </tr> --}}
                                        {{-- <tr>
                                            <td colspan="2" class="text-right">
                                                <div class="text-left" style="float: left;display:inline-block">
                                                    {{ valid_date($val_a->tanggal) }}
                                                    {{ $val_a->waktu }}
                                                </div>
                                                <div class="text-right">
                                                    @if (count($val_a->data_jawab_konsul) > 0)
                                                        <button type="button" data-toggle="tooltip"
                                                            data-id="{{ $val_a->id }}"
                                                            class="btn btn-success btn-xs btn-lihat-jawab">Lihat</button>&nbsp;&nbsp;
                                                    @endif
                                                    <button type="button" data-toggle="tooltip"
                                                        data-id="{{ $val_a->id }}"
                                                        class="btn btn-info btn-xs btn-jawab">Jawab
                                                        Konsul</button>&nbsp;&nbsp;
                                                    <a href="{{ url('/emr-konsuldokter-rawatinap/' . $reg->id . '/' . $val_a->id . '/edit') }}"
                                                        data-toggle="tooltip" title="Cetak"><i
                                                            class="fa fa-edit text-warning"></i></a>&nbsp;&nbsp;
                                                </div>
                                            </td>
                                        </tr> --}}
                                    {{-- @endforeach
                                </tbody>
                            </table> --}}
                            <table class="table table-bordered" id="data" style="font-size: 12px;">
                                <tbody>
                                  @if (count($all_resume) == 0)
                                      <tr>
                                        <td>Tidak ada record</td>
                                      </tr>
                                  @endif
                                    @foreach( $all_resume as $key_a => $val_a )
                                      @php
                                          $ews = json_decode($val_a->diagnosis);
                                          $kesadaran = @explode(',', @$ews->tingkat_kesadaran)[1];
                                          $pernapasan = @explode(',', @$ews->pernapasan)[1];
                                          $saturasi_oksigen = @explode(',', @$ews->saturasi_oksigen)[1];
                                          $penggunaan_oksigen = @explode(',', @$ews->penggunaan_oksigen)[1];
                                          $tekanan_darah = @explode(',', @$ews->tekanan_darah)[1];
                                          $denyut_jantung = @explode(',', @$ews->denyut_jantung)[1];
                                          $suhu = @explode(',', @$ews->suhu)[1];
                                          $skor_ews = $kesadaran + $pernapasan + $saturasi_oksigen + $penggunaan_oksigen + $tekanan_darah + $denyut_jantung + $suhu;

                                            if ($skor_ews == 0) {
                                                $style = 'background-color: rgba(3, 130, 3, 0.774); color: white; font-weight: bold;';
                                                $kesimpulan = 'Monitoring per-shift oleh perawat pelaksanaan dan didokumentasikan.';
                                            } elseif ($skor_ews <= 3) {
                                                $style = 'background-color: rgb(196, 193, 0); color: white; font-weight: bold;';
                                                $kesimpulan = 'Monitoring TTV per 1 jam dikaji ulang dan lapor ke dokter.';
                                            } elseif ($skor_ews <= 5) {
                                                $style = 'background-color: rgb(255, 128, 0); color: white; font-weight: bold;';
                                                $kesimpulan = 'Monitoring TTV per 30 menit pengkajian dilakukan PJ Shift & diketahui oleh dokter jaga. Dokter jaga visit pasien & melaporkan ke DPJP untuk tata laksana selanjutnya, pasien diputuskan pindah ke HCU.';
                                            } elseif ($skor_ews == 6) {
                                                $style = 'background-color: rgb(179, 29, 29); color: white; font-weight: bold;';
                                                $kesimpulan = 'Monitoring ulang tiap 10 menit & aktifkan Code Blue, laporkan segera ke dokter / DPJP & pasien rujuk ke ICU.';
                                            }else{
                                                $style = '';
                                                $kesimpulan = '';
                                            }
                                      @endphp
                                    <tr class="bg-primary" style="font-size:11px;">
                                        <th>Penginput</th>
                                        <th>{{ baca_user($val_a->user_id) }}</th>
                                    </tr>
                                    <tr class="bg-primary" style="font-size:11px;">
                                        <th>Tanggal Input</th>
                                        <th>{{ date('d/m/Y',strtotime($val_a->tanggal)) . ' ' . date('H:i',strtotime($val_a->waktu)) }}</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Tingkat Kesadaran:</b> {{@$ews->tingkat_kesadaran ? @explode(',', @$ews->tingkat_kesadaran)[0] . '(' . @explode(',', @$ews->tingkat_kesadaran)[1] . ')' : '-'}} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Pernapasan:</b> {{@$ews->pernapasan ? @$ews->nilai_pernapasan . '(' . @explode(',', @$ews->pernapasan)[1] . ')' : '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Saturasi Oksigen:</b> {{@$ews->saturasi_oksigen ? @$ews->nilai_saturasi_oksigen . '(' . @explode(',', @$ews->saturasi_oksigen)[1] . ')' : '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Penggunaan Oksigen:</b> {{@$ews->penggunaan_oksigen ? @explode(',', @$ews->penggunaan_oksigen)[0] . '(' . @explode(',', @$ews->penggunaan_oksigen)[1] . ')' : '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Tekanan Darah:</b> {{@$ews->tekanan_darah ? @$ews->nilai_tekanan_darah . '(' . @explode(',', @$ews->tekanan_darah)[1] . ')' : '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Denyut Jantung:</b> {{@$ews->denyut_jantung ? @$ews->nilai_denyut_jantung . '(' . @explode(',', @$ews->denyut_jantung)[1] . ')' : '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Suhu:</b> {{@$ews->suhu ? @$ews->nilai_suhu . '(' . @explode(',', @$ews->suhu)[1] . ')' : '-'}}</td>
                                    </tr>
                                    <tr style="{{$style}}">
                                        <td colspan="2"><b>Total Skor:</b> {{$skor_ews}}</td>
                                    </tr>
                                    <tr style="{{$style}}">
                                        <td colspan="2"><b>Total Skor:</b> {{$kesimpulan}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="pull-right">
                                                <a class="btn btn-sm btn-primary" href="{{ url('/emr-ews-dewasa/' .$unit . '/'. $reg->id . '/' . $val_a->id . '/edit?poli='.$poli.'&dpjp='.$dpjp) }}"
                                                    data-toggle="tooltip" title="Lihat"><i
                                                        class="fa fa-eye"></i></a>&nbsp;&nbsp;    
                                                <a class="btn btn-sm btn-success" href="{{ url('cetak-ews-dewasa/pdf/'. $reg->id . '/' . $val_a->id) }}"
                                                    data-toggle="tooltip" title="Cetak" target="_blank"><i
                                                        class="fa fa-print"></i></a>&nbsp;&nbsp;    
                                                <a onclick="return confirm('Yakin akan menghapus data? jika ingin mengembalikan data mohon hubungi admin SIMRS')" class="btn btn-sm btn-danger" href="{{ url('/emr-ews-dewasa/' .$unit . '/'. $reg->id . '/' . $val_a->id . '/delete?poli='.$poli.'&dpjp='.$dpjp) }}""
                                                    data-toggle="tooltip" title="Hapus"><i
                                                        class="fa fa-trash"></i></a>&nbsp;&nbsp;    
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <br /><br />
                    </form>
                    <hr />
                    <form method="POST" action="{{ url('frontoffice/simpan_diagnosa_rawatinap') }}"
                        class="form-horizontal">
                        {{ csrf_field() }}
                        {!! Form::hidden('registrasi_id', $reg->id) !!}
                        {!! Form::hidden('pasien_id', @$reg->pasien->id) !!}
                        {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                        {!! Form::hidden('unit', $unit) !!}
                    </form>
                </div>
            </div>
        </div>

        <div id="modals" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        {{-- <h4 class="modal-title">Jawab Konsul</h4> --}}
                    </div>
                    <div class="modal-body" id="dataModals">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('.input_skor').change(function () {
            var total_skor = 0;
            $('.input_skor').each(function () {
                if ($(this).is(':checked')) {
                    total_skor += +$(this).val().split(',')[1];
                }
            });
            $('#total_skor').html(total_skor);
        })
        $(document).on("change", ".qty1", function() {
            var sum = 0;
            $(".qty1").each(function(){
                sum += +$(this).val();
            });
            $(".total").val(sum);
        });
        $(document).on("change", ".qty2", function() {
            var sum = 0;
            $(".qty2").each(function(){
                sum += +$(this).val();
            });
            $(".total2").val(sum);
        });

        $(".skin-green").addClass("sidebar-collapse");
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
        $(document).on('click', '.btn-jawab', function() {
            let id = $(this).attr('data-id');
            $('#dataModals').html('');
            $('#dataModals').load('/emr-datakonsul/' + id);
            $('#modals').modal('show');
        })

        $(document).on('click', '.btn-lihat-jawab', function() {
            let id = $(this).attr('data-id');
            $('#dataModals').html('');
            $('#dataModals').load('/emr-datajawabankonsul/' + id);
            $('#modals').modal('show');
        })
    </script>
@endsection
