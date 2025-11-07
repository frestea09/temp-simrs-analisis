@extends('master')

@section('header')
<h1>FORMULIR SURVEILANS HAIs</h1>
@endsection

@section('content')
<div class="box box-success">
    <div class="box-body">
        <link rel="shortcut icon" type="image/png" href="{{ asset('vendor/laravel-filemanager/img/folder.png') }}">
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-widget widget-user">
                    <div class="widget-user-header bg-green">
                        <div class="row">
                            <div class="col-md-2">
                                <h4 class="widget-user-username">Nama</h4>
                                <h5 class="widget-user-desc">No. RM</h5>
                                <h5 class="widget-user-desc">NIK</h5>
                                <h5 class="widget-user-desc">Kunjungan</h5>
                                @if ($inap)
                                <h5 class="widget-user-desc">Kelas</h5>
                                <h5 class="widget-user-desc">Kamar</h5>
                                <h5 class="widget-user-desc">Bed</h5>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <h3 class="widget-user-username">:{{ $reg->pasien->nama}}</h3>
                                <h5 class="widget-user-desc">: {{ $reg->pasien->no_rm }}</h5>
                                <h5 class="widget-user-desc">: {{ $reg->pasien->nik}}</h5>
                                <h5 class="widget-user-desc">: {{ ($reg->jenis_pasien == 1) ? 'Baru' : 'Lama' }}</h5>
                                @if ($inap)
                                <h5 class="widget-user-desc">: {{ @baca_kelas($inap->kelas_id) }}</h5>
                                <h5 class="widget-user-desc">: {{ @baca_kamar($inap->kamar_id)}}</h5>
                                <h5 class="widget-user-desc">: {{ @baca_bed($inap->bed_id) }}</h5>
                                @endif
                            </div>
                            <div class="col-md-3 text-center">
                                {{-- <h3>Total Tagihan</h3>
                                <h2 style="margin-top: -5px;">Rp. </h2> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ url('/hais/save') }}" class="form-horizontal">
            <input type="hidden" name="unit" value="{{$unit}}">
            <input type="hidden" name="pasien_id" value="{{$reg->pasien_id}}">
            <input type="hidden" name="reg_id" value="{{$reg->id}}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <h5><b>Faktor Resiko Pasien</b></h5>
                <table style="width: 100%"
                    class="table table-striped table-bordered table-hover table-condensed form-box"
                    style="font-size:12px;">
                    <tr>
                        <td style="padding: 5px;">
                            <p><input type="checkbox" id="" name="is_umur" value="1">&nbsp;Umur
                            </p>
                            <p><input type="checkbox" id="" name="is_gizi" value="1">&nbsp;Gizi
                            </p>
                            <p><input type="checkbox" id="" name="is_obesitas"
                                    value="1">&nbsp;Obesitas</p>
                            <p>Penyakit Penyerta :

                                <input type="checkbox" name="is_diabetes" value="1">&nbsp;Diabetes
                                <input type="checkbox" name="is_hiv" value="1">&nbsp;HIV
                                <input type="checkbox" name="is_hbv" value="1">&nbsp;HBV
                                <input type="checkbox" name="is_hcv" value="1">&nbsp;HCV
                            </p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-md-12">
                <h5><b>Faktor risiko pemakaian Peralatan Perawatan Pasien</b></h5>
                <table style="width: 100%"
                    class="table table-striped table-bordered table-hover table-condensed form-box"
                    style="font-size:12px;">
                    <tr>
                        <th style="padding: 5px;">
                            <b>Intra Vena Kateter</b>
                            {{-- <p><input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1">&nbsp;Umur --}}
                        </th>
                        <th>Tgl Terpasang</th>
                        <th>Tgl Lepas</th>
                        <th>Total Hari</th>
                    </tr>
                    @foreach (\App\PPI\MasterPpi::all() as $item)
                        <input type="hidden" name="risiko[{{$item->id}}][id]" value="{{$item->id}}">
                        <tr>
                            <td>
                                <input type="checkbox" id="{{$item->nama}}" name="risiko[{{$item->id}}][cek]"
                                value="{{$item->id}}">
                                {{$item->nama}} &nbsp;
                            </td>
                            <td><input type="date" class="form-control" name="risiko[{{$item->id}}][tgl_terpasang]">
                            <td><input type="date" class="form-control" name="risiko[{{$item->id}}][tgl_lepas]"></td>
                            <td><input type="number" class="form-control" name="risiko[{{$item->id}}][total_hari]"></td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="col-md-12">
                <table style="width: 100%"
                    class="table table-striped table-bordered table-hover table-condensed form-box"
                    style="font-size:12px;">
                    <tr>
                        <th style="padding: 5px;">
                            <b>Penggunaan Anti Biotik</b>
                            {{-- <p><input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1">&nbsp;Umur --}}
                        </th>
                        <th>Tgl Pakai</th>
                        <th>Tgl Berhenti</th>
                    </tr>
                    @for ($i=0;$i <= 2; $i++)
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="antibiotik[{{$i}}][value]">
                            </td>
                            <td><input type="date" class="form-control" name="antibiotik[{{$i}}][tgl_pakai]">
                            <td><input type="date" class="form-control" name="antibiotik[{{$i}}][tgl_berhenti]"></td>
                        </tr>
                    @endfor
                </table>
            </div>

            <div class="row">
                
            </div>
            <div class="col-md-6">
                <table style="width: 100%"
                    class="table table-striped table-bordered table-hover table-condensed form-box"
                    style="font-size:12px;"> 
                    <tr>
                        <th style="padding: 5px;" colspan="2">
                            <b>Pemeriksaan Penunjang</b>
                            {{-- <p><input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1">&nbsp;Umur --}}
                        </th>
                    </tr>
                    <tr>
                        <td>Radiologi</td>
                        <td><input type="text" class="form-control" name="radiologi"></td>
                    </tr>
                    <tr>
                        <td>Laboratorium</td>
                        <td><input type="text" class="form-control" name="laboratorium"></td>
                    </tr>
                </table>
                {{-- <button type="submit" class="btn btn-success pull-right">Simpan</button> --}}
            </div>
            <div class="col-md-6">
                <table style="width: 100%"
                    class="table table-striped table-bordered table-hover table-condensed form-box"
                    style="font-size:12px;"> 
                    <tr>
                        <th style="padding: 5px;" colspan="2">
                            <b>Hasil Kultur Specimen</b>
                            {{-- <p><input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1">&nbsp;Umur --}}
                        </th>
                    </tr>
                    <tr>
                        <td>Darah</td>
                        <td><input type="text" class="form-control" name="kultur[darah]"></td>
                    </tr>
                    <tr>
                        <td>Sputum</td>
                        <td><input type="text" class="form-control" name="kultur[sputum]"></td>
                    </tr>
                    <tr>
                        <td>Spine</td>
                        <td><input type="text" class="form-control" name="kultur[spine]"></td>
                    </tr>
                </table>
                {{-- <button type="submit" class="btn btn-success pull-right">Simpan</button> --}}
            </div>
            <div class="col-md-6">
                <table style="width: 100%"
                    class="table table-bordered table-hover form-box"
                    style="font-size:12px;"> 
                    <tr>
                        <th style="padding: 5px;" colspan="2">
                            <b>Komplikasi Infeksi</b>
                            {{-- <p><input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1">&nbsp;Umur --}}
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-check-input" type="radio" value="ido" name="komplikasi">
                            <label class="form-check-label" for="defaultCheck1">
                                IDO
                            </label>
                        </td>
                        <td>
                            <input class="form-check-input" type="radio" value="plabsi" name="komplikasi">
                            <label class="form-check-label" for="defaultCheck1">
                                Plabsi ( Infeksi Luksa Infus)
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-check-input" type="radio" value="isk" name="komplikasi">
                            <label class="form-check-label" for="defaultCheck1">
                                ISK
                            </label>
                        </td>
                        
                        
                    </tr>
                </table>
                {{-- <button type="submit" class="btn btn-success pull-right">Simpan</button> --}}
            </div>

            {{-- Tindakan Operasi --}}
            
            <div class="col-md-12">
                <h4 class="text-center"><b>Tindakan Operasi</b></h4><br/>
                <table style="width: 100%"
                    class="table table-striped table-bordered table-hover table-condensed form-box"
                    style="font-size:12px;">
                        <tr>
                            <th>Ahli Bedah 1</th>
                            <td>
                                <select name="tindakan_operasi[petugas][ahli_bedah_1]" class="form-control select2" id="">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($dokter as $item)
                                        <option value="{{$item->nama}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <th>Ahli Bedah 2</th>
                            <td>
                                <select name="tindakan_operasi[petugas][ahli_bedah_2]" class="form-control select2" id="">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($dokter as $item)
                                        <option value="{{$item->nama}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Scrub Nurse 1</th>
                            <td>
                                <select name="tindakan_operasi[petugas][nurse_1]" class="form-control select2" id="">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($perawat as $item)
                                        <option value="{{$item->nama}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <th>Scrub Nurse 2</th>
                            <td>
                                <select name="tindakan_operasi[petugas][nurse_2]" class="form-control select2" id="">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($perawat as $item)
                                        <option value="{{$item->nama}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    {{-- @endforeach --}}
                </table>
            </div>

            <div class="col-md-6">
                <table style="width: 100%"
                    class="table table-striped table-bordered table-hover table-condensed form-box"
                    style="font-size:12px;"> 
                    
                    <tr>
                        <th>Jenis Operasi</th>
                        <td><input type="text" class="form-control" name="tindakan_operasi[jenis_operasi]" ></td>
                    </tr>
                    <tr>
                        <th>Tipe Operasi</th>
                        <td>
                            <input class="form-check-input" type="radio" value="terbuka" name="tindakan_operasi[tipe]">
                            Terbuka
                            &nbsp;&nbsp;
                            <input class="form-check-input" type="radio" value="tertutup" name="tindakan_operasi[tipe]">
                            Tertutup
                        </td>
                    </tr>
                    <tr>
                        <th>Kategori Resiko</th>
                        <td>
                            <input class="form-check-input" type="radio" value="0" name="tindakan_operasi[resiko]">
                            0&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" value="1" name="tindakan_operasi[resiko]">
                            1&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" value="2" name="tindakan_operasi[resiko]">
                            2&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" value="3" name="tindakan_operasi[resiko]">
                            3
                        </td>
                    </tr>
                    <tr>
                        <th>Klasifikasi Luka</th>
                        <td>
                            <input class="form-check-input" type="radio" value="Bersih" name="tindakan_operasi[klasifikasi]">
                            Bersih&nbsp;&nbsp;
                            <input class="form-check-input" type="radio" value="Bersih Terkontaminasi" name="tindakan_operasi[klasifikasi]">
                            Bersih Terkontaminasi
                            &nbsp;&nbsp;
                            <input class="form-check-input" type="radio" value="Terkontaminasi" name="tindakan_operasi[klasifikasi]">
                            Terkontaminasi
                            &nbsp;&nbsp;
                            <input class="form-check-input" type="radio" value="Kotor" name="tindakan_operasi[klasifikasi]">
                            Kotor
                        </td>
                    </tr>
                </table>
                {{-- <button type="submit" class="btn btn-success pull-right">Simpan</button> --}}
            </div> 

            <div class="col-md-12">
                <h5><b>Klasifikasi ASA (American Society of Anasthesiolosists)</b></h5>
                <table style="width: 100%"
                    class="table table-striped table-bordered table-hover table-condensed form-box"
                    style="font-size:12px;">
                    <tr>
                        <td>
                            <input class="form-check-input" type="radio" value="Asa 1. Pasien dalam kondisi sehat" name="tindakan_operasi[asa]">
                            Asa 1. Pasien dalam kondisi sehat<br/>
                            <input class="form-check-input" type="radio" value="Asa 2. Pasien dengan kelainan sistematik ringan - sedang" name="tindakan_operasi[asa]">
                            Asa 2. Pasien dengan kelainan sistematik ringan - sedang<br/>
                            <input class="form-check-input" type="radio" value="Asa 3. Pasien dengan gangguan sistematik, aktifitas terbatas" name="tindakan_operasi[asa]">
                            Asa 3. Pasien dengan gangguan sistematik, aktifitas terbatas<br/>
                            <input class="form-check-input" type="radio" value="Asa 4. Pasien dengan kelainan sistematik berat, tidak bisa beraktifitas" name="tindakan_operasi[asa]">
                            Asa 4. Pasien dengan kelainan sistematik berat, tidak bisa beraktifitas<br/>
                            <input class="form-check-input" type="radio" value="Asa 5. Pasien tidak diharapkan hidup setelah 24 jam walaupun dioperasi" name="tindakan_operasi[asa]">
                            Asa 5. Pasien tidak diharapkan hidup setelah 24 jam walaupun dioperasi<br/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table style="width: 100%"
                    class="table table-bordered table-hover form-box"
                    style="font-size:12px;"> 
                    <tr>
                        <th style="padding: 5px;" colspan="2">
                            <b>T. Time</b>
                            {{-- <p><input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1">&nbsp;Umur --}}
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-check-input" type="radio" value="Kurang dari T.Time" name="tindakan_operasi[time]">
                            <label class="form-check-label" for="defaultCheck1">
                                Kurang dari T.Time
                            </label>
                        </td>
                        <td>
                            <input class="form-check-input" type="radio" value="Lebih dari T.Time" name="tindakan_operasi[time]">
                            <label class="form-check-label" for="defaultCheck1">
                                Lebih dari T.Time
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Hasil Kultur Specimen Luka Jaringan</td>
                        <td>
                            <textarea rows="4" class="form-control" name="tindakan_operasi[hasil]"></textarea>
                        </td>
                    </tr>
                </table>
                {{-- <button type="submit" class="btn btn-success pull-right">Simpan</button> --}}
            </div>
            <div class="col-md-6">
                <table style="width: 100%"
                    class="table table-bordered table-hover form-box"
                    style="font-size:12px;"> 
                    <tr>
                        <th style="padding: 5px;" colspan="2">
                            <b>Penggunaan Antibiotik</b>
                            {{-- <p><input type="checkbox" id="vehicle1" name="riwayat_medis_sebelumnya" value="1">&nbsp;Umur --}}
                        </th>
                    </tr>
                    <tr><td><input type="text" class="form-control" name="tindakan_operasi[antibiotik][0]"></td></tr>
                    <tr><td><input type="text" class="form-control" name="tindakan_operasi[antibiotik][1]"></td></tr>
                    <tr><td><input type="text" class="form-control" name="tindakan_operasi[antibiotik][2]"></td></tr>
                </table>
                <button type="submit" class="btn btn-success pull-right">Simpan</button>
            </div>

            
        </div>
        </form>
        <h4>History</h4>
        <div class="row" >
            <div class="col-md-12">
                <table class="table table-bordered" id="data">
                    <thead>
                        <tr>
                            <th>Tgl Input</th>
                            <th>Faktor Resiko Pasien</th>
                            <th>Pemakaian Peralatan Perawatan Pasien</th>
                            <th>Antibiotik</th>
                            <th>Pemeriksaan Penunjang</th>
                            <th>Penginput</th>
                            <th>Lihat</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hais as $item)
                            <tr>
                                <td>{{date('d-m-Y',strtotime($item->created_at))}}</td>
                                <td>{{$item->is_gizi ? 'Gizi,' :''}}{{$item->is_umur ? 'Umur,' :''}}{{$item->is_obesitas ? 'Obesitas,' :''}}<br/>
                                    <b>Penyakit Penyerta</b> : {{$item->is_diabetes ? 'Diabetes,' :''}}{{$item->is_hiv ? 'HIV,' :''}}{{$item->is_hbv ? 'HBV,' :''}}{{$item->is_hcv ? 'HCV,' :''}}
                                </td>
                                <td>
                                    @php
                                    $pemakaian = \App\PPI\PpiFaktorPemakaian::where('ppi_id',$item->id)->get();
                                @endphp
                                @foreach ($pemakaian as $res)
                                    - ({{$res->master_ppi->nama}}) | {{@valid_date(@$res->tgl_terpasang)}} <b>s/d</b> {{@valid_date($res->tgl_lepas)}} | {!!$res->total_hari ?  '<b>'.$res->total_hari .'</b> Hari' : ''!!}<br/>
                                @endforeach</td> 
                               <td>
                                    @php
                                        $antibiotik = \App\PPI\PpiAntibiotik::where('ppi_id',$item->id)->get();
                                    @endphp
                                    @foreach ($antibiotik as $res)
                                        - ({{$res->antibiotik}}) | {{@valid_date(@$res->tgl_pakai)}} <b>s/d</b> {{@valid_date($res->tgl_berhenti)}}  <br/>
                                    @endforeach
                                </td>
                                <td>
                                    <b>Radiologi</b> : {{$item->radiologi}}<br/>
                                    <b>Laboratorium</b> : {{$item->laboratorium}}<br/>
                                </td>
                                <td>
                                    {{baca_user($item->user_id)}}
                                </td>
                                <td>
                                    <a target="_blank" href="{{url('/cetak-hais/formCetakHais/'.$item->id)}}" class="btn btn-xs btn-success">Cetak</a>
                                </td>
                                <td>
                                    <a onclick="return confirm('Yakin Akan Menghapus data ?')" href="{{url('/hapus-hais/'.$item->id)}}" class="btn btn-xs btn-danger">Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{-- <thead>Faktor risiko pemakaian</thead> --}}
                </table>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $('.select2').select2();
        
</script>
@endsection