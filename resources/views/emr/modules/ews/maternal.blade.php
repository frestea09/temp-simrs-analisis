@extends('master')

@section('header')
    <h1>EWS MATERNAL</h1>
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
                        <h5 class="text-bold">INFORMASI NILAI EWSS</h5>
                        <table class="table-bordered table" id="data"style="font-size: 12px;margin-top:0px !important">
                            <tbody style="font-size:11px;">
                                <tr style="font-size:11px; background-color: rgba(3, 130, 3, 0.774); color: white; font-weight: bold;">
                                    <td style="width: 200px;">Nilai EWSS 0</td>
                                    <td>Lakukan monitoring pershift oleh perawat pelaksana & didokumentasikan.</td>
                                </tr>
                                <tr style="font-size:11px; background-color: rgb(196, 193, 0); color: white; font-weight: bold;">
                                    <td style="width: 200px;">Nilai EWSS 1-4</td>
                                    <td>Monitoring per 2 jam. Pengkajian dilakukan oleh penanggungjawab shift dan dilaporkan kepada dokter penanggungjawab.</td>
                                </tr>
                                <tr style="font-size:11px; background-color: rgb(255, 128, 0); color: white; font-weight: bold;">
                                    <td style="width: 200px;">Nilai EWSS 5-6</td>
                                    <td>Lakukan monitor per 1 jam. Dokter penanggungjawab ruangan/Jaga visite kepada pasien lalu melaporkan kepada DPJP. Selanjutnya pasien akan diputuskan pindah HCU/RUJUK</td>
                                </tr>
                                <tr style="font-size:11px; background-color: rgb(179, 29, 29); color: white; font-weight: bold;">
                                    <td style="width: 200px;">Nilai EWSS >7</td>
                                    <td>Pasien pindah ICU dengan fasilitas memadai. Bila pasien diruangan biasa aktifkan code blue.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                {{-- @if (!$emr) --}}
                    <form method="POST" action="{{ url('emr-ews-maternal') }}" class="form-horizontal">
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
                                <td>Pernapasan</td>
                                <td style="padding: 5px;">
                                    @foreach (pernapasan_ews_maternal() as $item)
                                        <input type="radio" class="input_skor" name="formulir[pernapasan]" {{@ews(@$ewss['pernapasan'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_pernapasan]" value="{{@$ewss['nilai_pernapasan']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Sp.O2</td>
                                <td style="padding: 5px;">
                                    @foreach (spo2_ews_maternal() as $item)
                                        <input type="radio" class="input_skor" name="formulir[spo2]" {{@ews(@$ewss['spo2'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_spo2]" value="{{@$ewss['nilai_spo2']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Suhu</td>
                                <td style="padding: 5px;">
                                    @foreach (suhu_ews_maternal() as $item)
                                        <input type="radio" class="input_skor" name="formulir[suhu]" {{@ews(@$ewss['suhu'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_suhu]" value="{{@$ewss['nilai_suhu']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Frekuensi Jantung</td>
                                <td style="padding: 5px;">
                                    @foreach (freqjan_ews_maternal() as $item)
                                        <input type="radio" class="input_skor" name="formulir[frekuensi_jantung]" {{@ews(@$ewss['frekuensi_jantung'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_frekuensi_jantung]" value="{{@$ewss['nilai_frekuensi_jantung']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Tekanan Sistolik</td>
                                <td style="padding: 5px;">
                                    @foreach (sitolik_ews_maternal() as $item)
                                        <input type="radio" class="input_skor" name="formulir[sitolik]" {{@ews(@$ewss['sitolik'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_sitolik]" value="{{@$ewss['nilai_sitolik']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Tekanan Diastolik</td>
                                <td style="padding: 5px;">
                                    @foreach (diastolik_ews_maternal() as $item)
                                        <input type="radio" class="input_skor" name="formulir[diastolik]" {{@ews(@$ewss['diastolik'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_diastolik]" value="{{@$ewss['nilai_diastolik']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000">
                                <td>Nyeri</td>
                                <td style="padding: 5px;">
                                    @foreach (nyeri_ews_maternal() as $item)
                                        <input type="radio" class="input_skor" name="formulir[nyeri]" {{@ews(@$ewss['nyeri'],'val') == ews($item,'val') ? 'checked' : ''}} value="{{$item}}"> {{ews($item,'val')}} ({{ews($item,'skor')}})<br/>
                                    @endforeach
                                    <input type="text" class="form-control" placeholder="Masukkan nilai" name="formulir[nilai_nyeri]" value="{{@$ewss['nilai_nyeri']}}">
                                </td>
                            </tr>
                            <tr style="border-top:1px dotted #000; border-bottom:1px dotted #000;">
                                <td>Total Skor</td>
                                <td style="padding: 5px;" id="total_skor">
                                    @php
                                        $pernapasan = @ews(@$ewss['pernapasan'],'skor');
                                        $spo2 = @ews(@$ewss['spo2'],'skor');
                                        $suhu = @ews(@$ewss['suhu'],'skor');
                                        $frekuensi_jantung = @ews(@$ewss['frekuensi_jantung'],'skor');
                                        $sitolik = @ews(@$ewss['sitolik'],'skor');
                                        $diastolik = @ews(@$ewss['diastolik'],'skor');
                                        $nyeri = @ews(@$ewss['nyeri'],'skor');

                                        $total_skor = $pernapasan + $spo2 + $suhu + $frekuensi_jantung + $sitolik + $diastolik + $nyeri;
                                    @endphp
                                    {{$total_skor}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Urine (+)</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                    Protein:<input class="urine" value="{{@$ewss['urine']['protein']}}" name="formulir[urine][protein]" type="text" style="width: 50px;">&nbsp;&nbsp;
                                    Darah:<input class="urine" value="{{@$ewss['urine']['darah']}}" name="formulir[urine][darah]" type="text" style="width: 50px;">&nbsp;&nbsp;
                                    Keton:<input class="urine" value="{{@$ewss['urine']['keton']}}" name="formulir[urine][keton]" type="text" style="width: 50px;">&nbsp;&nbsp;
                                    Jumlah:<input name="formulir[urine][jumlah]" type="text" class="total1" style="width: 50px;" value="{{@$ewss['urine']['jumlah']}}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Pendarahan AnteNatal</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                    Kecoklatan : <input class="" {{@$ewss['antenatal']['kecoklatan'] ? 'checked' : ''}} name="formulir[antenatal][kecoklatan]" type="checkbox">&nbsp;&nbsp;
                                    Merah : <input class="" {{@$ewss['antenatal']['merah'] ? 'checked' : ''}} name="formulir[antenatal][merah]" type="checkbox">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Air Ketuban jika KPD</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                    Jernih : <input class="" {{@$ewss['ketuban']['jernih'] ? 'checked' : ''}} name="formulir[ketuban][jernih]" type="checkbox">&nbsp;&nbsp;
                                    Meconium : <input class="" {{@$ewss['ketuban']['Meconium'] ? 'checked' : ''}} name="formulir[ketuban][Meconium]" type="checkbox">&nbsp;&nbsp;
                                </td>
                            </tr>
                            {{-- <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Air Ketuban jika KPD</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                    Jernih : <input class="" {{@$ewss['ketuban']['jernih'] ? 'checked' : ''}} name="formulir[ketuban][jernih]" type="checkbox">&nbsp;&nbsp;
                                    Meconium : <input class="" {{@$ewss['ketuban']['Meconium'] ? 'checked' : ''}} name="formulir[ketuban][Meconium]" type="checkbox">&nbsp;&nbsp;
                                </td>
                            </tr> --}}
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Tonus Uteri Post Natal</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                    Keras : <input class="" {{@$ewss['tonus']['Keras'] ? 'checked' : ''}} name="formulir[tonus][Keras]" type="checkbox">&nbsp;&nbsp;
                                    Lembek : <input class="" {{@$ewss['tonus']['Lembek'] ? 'checked' : ''}} name="formulir[tonus][Lembek]" type="checkbox">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Luka Kemerahan/<br/>Bengkak/Nyeri</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                    Ya : <input class="" {{@$ewss['kemerahan']['Ya'] ? 'checked' : ''}} name="formulir[kemerahan][Ya]" type="checkbox">&nbsp;&nbsp;
                                    Tidak : <input class="" {{@$ewss['kemerahan']['Tidak'] ? 'checked' : ''}} name="formulir[kemerahan][Tidak]" type="checkbox">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Lockea</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                    Normal : <input class="" {{@$ewss['lockea']['normal'] ? 'checked' : ''}} name="formulir[lockea][normal]" type="checkbox">&nbsp;&nbsp;
                                    Tidak Normal : <input class="" {{@$ewss['lockea']['Tidak'] ? 'checked' : ''}} name="formulir[lockea][Tidak]" type="checkbox">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Respon Neurologis</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                    Sadar : <input class="" {{@$ewss['Neurologis']['Sadar'] ? 'checked' : ''}} name="formulir[Neurologis][Sadar]" type="checkbox">&nbsp;&nbsp;
                                    Suara : <input class="" {{@$ewss['Neurologis']['Suara'] ? 'checked' : ''}} name="formulir[Neurologis][Suara]" type="checkbox">&nbsp;&nbsp;
                                    Nyeri : <input class="" {{@$ewss['Neurologis']['Nyeri'] ? 'checked' : ''}} name="formulir[Neurologis][Nyeri]" type="checkbox">&nbsp;&nbsp;
                                    Tidak Berespon : <input class="" {{@$ewss['Neurologis']['Tidak'] ? 'checked' : ''}} name="formulir[Neurologis][Tidak]" type="checkbox">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>Tinggi Fundus</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                     <input class="" value="{{@$ewss['tinggi_fundus']}}" name="formulir[tinggi_fundus]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>DJJ</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                     <input class="" value="{{@$ewss['djj']}}" name="formulir[djj]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>INTAKE</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                    Peroral/NGT : <input class="intake" value="{{@$ewss['intake']['peroral']}}" name="formulir[intake][peroral]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                    Parental : <input class="intake" value="{{@$ewss['intake']['parental']}}" name="formulir[intake][parental]" type="text" style="width: 100px;">&nbsp;&nbsp;
                                    Jumlah:<input name="formulir[intake][jumlah]" class="total2" type="text" style="width: 50px;" value="{{@$ewss['intake']['jumlah']}}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>OUTPUT</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                    Urine : <input class="output" value="{{@$ewss['output']['urine']}}" name="formulir[output][urine]" type="text" style="width: 70px;">&nbsp;&nbsp;
                                    Darah/Drain : <input class="output" value="{{@$ewss['output']['darah']}}" name="formulir[output][darah]" type="text" style="width: 70px;">&nbsp;&nbsp;
                                    Feses : <input class="output" value="{{@$ewss['output']['feses']}}" name="formulir[output][feses]" type="text" style="width: 70px;">&nbsp;&nbsp;
                                    Muntah : <input class="output" value="{{@$ewss['output']['muntah']}}" name="formulir[output][muntah]" type="text" style="width: 70px;">&nbsp;&nbsp;
                                    Jumlah:<input name="formulir[output][jumlah]" class="total3" type="text" style="width: 50px;" value="{{@$ewss['output']['jumlah']}}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <br/>
                                    <b>BALANCE CAIRAN</b> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
                                     <input class="" value="{{@$ewss['balance']}}" name="formulir[balance]" type="text" style="width: 100px;">&nbsp;&nbsp;
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
                            <table class="table-bordered table" id="data"
                                style="font-size: 12px;margin-top:0px !important">

                                <tbody style="font-size:11px;">
                                    @if (count($all_resume) == 0)
                                        <tr>
                                            <td>Tidak ada record</td>
                                        </tr>
                                    @endif
                                    @foreach ($all_resume as $key_a => $val_a)
                                        @php
                                            $ews = json_decode($val_a->diagnosis);
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
                                            <td colspan="2"><b>Pernapasan:</b> {{@$ews->pernapasan ? @$ews->nilai_pernapasan . '(' . @explode(',', @$ews->pernapasan)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Sp.O2:</b> {{@$ews->spo2 ? @$ews->nilai_spo2 . '(' . @explode(',', @$ews->spo2)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Suhu:</b> {{@$ews->suhu ? @$ews->nilai_suhu . '(' . @explode(',', @$ews->suhu)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Frekuensi Jantung:</b> {{@$ews->frekuensi_jantung ? @$ews->nilai_frekuensi_jantung. '(' . @explode(',', @$ews->frekuensi_jantung)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Tekanan Sistolik:</b> {{@$ews->sitolik ? @$ews->nilai_sitolik. '(' . @explode(',', @$ews->sitolik)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Tekanan Diastolik:</b> {{@$ews->diastolik ? @$ews->nilai_diastolik. '(' . @explode(',', @$ews->diastolik)[1] . ')' : '-'}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b>Nyeri:</b> {{@$ews->nyeri ? @$ews->nilai_nyeri. '(' . @explode(',', @$ews->nyeri)[1] . ')' : '-'}}</td>
                                        </tr>
                                        @php
                                            $pernapasan = @ews(@$ews->pernapasan,'skor');
                                            $spo2 = @ews(@$ews->spo2,'skor');
                                            $suhu = @ews(@$ews->suhu,'skor');
                                            $frekuensi_jantung = @ews(@$ews->frekuensi_jantung,'skor');
                                            $sitolik = @ews(@$ews->sitolik,'skor');
                                            $diastolik = @ews(@$ews->diastolik,'skor');
                                            $nyeri = @ews(@$ews->nyeri,'skor');

                                            $total_skor = $pernapasan + $spo2 + $suhu + $frekuensi_jantung + $sitolik + $diastolik + $nyeri;

                                            if ($total_skor == 0) {
                                                $style = 'background-color: rgba(3, 130, 3, 0.774); color: white; font-weight: bold;';
                                                $kesimpulan = '	Lakukan monitoring pershift oleh perawat pelaksana & didokumentasikan.';
                                            } elseif ($total_skor <= 4) {
                                                $style = 'background-color: rgb(196, 193, 0); color: white; font-weight: bold;';
                                                $kesimpulan = 'Monitoring per 2 jam. Pengkajian dilakukan oleh penanggungjawab shift dan dilaporkan kepada dokter penanggungjawab.';
                                            } elseif ($total_skor <= 6) {
                                                $style = 'background-color: rgb(255, 128, 0); color: white; font-weight: bold;';
                                                $kesimpulan = 'Lakukan monitor per 1 jam. Dokter penanggungjawab ruangan/Jaga visite kepada pasien lalu melaporkan kepada DPJP. Selanjutnya pasien akan diputuskan pindah HCU/RUJUK';
                                            } elseif ($total_skor >= 7) {
                                                $style = 'background-color: rgb(179, 29, 29); color: white; font-weight: bold;';
                                                $kesimpulan = 'Pasien pindah ICU dengan fasilitas memadai. Bila pasien diruangan biasa aktifkan code blue.';
                                            }else{
                                                $style = '';
                                                $kesimpulan = '';
                                            }
                                        @endphp
                                        <tr style="{{$style}}">
                                            <td colspan="2"><b>Total Skor:</b> {{$total_skor}}</td>
                                        </tr>
                                        <tr style="{{$style}}">
                                            <td colspan="2"><b>Kesimpulan:</b> {{$kesimpulan}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="pull-right">
                                                    <a class="btn btn-xs btn-primary" href="{{ url('/emr-ews-maternal/' .$unit . '/'. $reg->id . '/' . $val_a->id . '/edit?poli='.$poli.'&dpjp='.$dpjp) }}"
                                                        data-toggle="tooltip" title="Lihat"><i
                                                            class="fa fa-eye"></i></a>&nbsp;&nbsp;    
                                                    <a class="btn btn-xs btn-success" href="{{ url('cetak-ews-maternitas/pdf/'. $reg->id . '/' . $val_a->id) }}"
                                                        data-toggle="tooltip" title="Cetak" target="_blank"><i
                                                            class="fa fa-print"></i></a>&nbsp;&nbsp;    
                                                    <a onclick="return confirm('Yakin akan menghapus data? jika ingin mengembalikan data mohon hubungi admin SIMRS')" class="btn btn-xs btn-danger" href="{{ url('/emr-ews-maternal/' .$unit . '/'. $reg->id . '/' . $val_a->id . '/delete?poli='.$poli.'&dpjp='.$dpjp) }}""
                                                        data-toggle="tooltip" title="Hapus"><i
                                                            class="fa fa-trash"></i></a>&nbsp;&nbsp;    
                                                </div>
                                            </td>
                                        </tr>
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
        $(document).on("change", ".urine", function() {
            var sum = 0;
            $(".urine").each(function(){
                sum += +$(this).val();
            });
            $(".total1").val(sum);
        });
        $(document).on("change", ".intake", function() {
            var sum = 0;
            $(".intake").each(function(){
                sum += +$(this).val();
            });
            $(".total2").val(sum);
        });
        $(document).on("change", ".output", function() {
            var sum = 0;
            $(".output").each(function(){
                sum += +$(this).val();
            });
            $(".total3").val(sum);
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
