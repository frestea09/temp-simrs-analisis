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
@section('header')
    <h1>Perencanaan - SBAR</h1>
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

            @include('emr.modules.addons.profile')
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        @include('emr.modules.addons.tabs')
                    </div>
                    <br>

                    <div class="col-md-12">
                        <form method="POST" action="{{ url('emr-soap/perencanaan/sbar/' . $unit . '/' . $reg->id) }}"
                            class="form-horizontal" style="width: 100%">
                            {{ csrf_field() }}
                            {!! Form::hidden('registrasi_id', $reg->id) !!}
                            {!! Form::hidden('pasien_id', $reg->pasien_id) !!}
                            {!! Form::hidden('cara_bayar', $reg->bayar) !!}
                            {!! Form::hidden('unit', $unit) !!}
                            {!! Form::hidden('poli', $poli) !!}
                            {!! Form::hidden('dpjp', $dpjp) !!}
                            <br>
                            {{-- Anamnesis --}}
                            <div class="col-md-12">
                                <div class="box box-solid box-warning">
                                  <div class="box-header">
                                    <h5><b>Riwayat</b></h5>
                                  </div>
                                  <div class="box-body table-responsive" style="max-height: 400px">
                                    <table style="width: 100%; font-size:12px;" class="table table-striped table-bordered table-hover table-condensed form-box bordered">
                                        @forelse ($sbars as $sbar)
                                            <tr>
                                                <td> 
                                                <b>NO REF	:</b> {{ $sbar->no_referensi }}<br/>
                                                <b>Tanggal Dibuat	:</b> {{ date('d-m-Y, H:i:s', strtotime($sbar->created_at)) }}<br/>
                                                <span class="pull-right">
                                                    <a target="_blank" href="{{url("/emr-soap-print-surat-pemindahan/$sbar->registrasi_id/$sbar->id")}}" data-toggle="tooltip" title="Cetak Surat"><i class="fa fa-print text-warning"></i></a>&nbsp;&nbsp;
                                                </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                            <td><i>Belum ada catatan</i></td>
                                            </tr>  
                                        @endforelse
                                    </table>
                                  </div>
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <h2 class="text-center"><b>SBAR</b></h2>
                                <h5><b>SITUATION</b></h5>
                                <div class="col-md-12">
                                    @php
                                        $dari_ruangan = null;
                                        $tiba_di = null;
                                        $dokter = null;
                                        if (count($history_irna) > 1) {
                                            $dari_ruangan = $history_irna[1]->kamar->nama;
                                        }
                                        if (count($history_irna) > 0) {
                                            $tiba_di = $history_irna[0]->kamar->nama;
                                            $dokter = $history_irna[0]->dokter_id;
                                            $dari_ruangan = '';
                                        }
                                    @endphp
                                    <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                                      style="font-size:12px;">
                                      <tr>
                                        <td style="width:20%;">Tiba di ruangan</td>
                                        <td style="padding: 5px;">
                                            <input type="text" value="{{$tiba_di}}" name="situation[di_ruangan]" class="form-control">

                                            {{-- <select name="situation[di_ruangan]" id="" class="select2" style="width: 100%;">
                                                <option value="">Tidak ada</option>
                                                @foreach ($kamar as $k)
                                                    <option value="{{$k->nama}}" {{$tiba_di == $k->id ? 'selected' : ''}}>{{$k->nama}}</option>
                                                @endforeach
                                            </select> --}}
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width:20%;">Dari ruangan</td>
                                        <td style="padding: 5px;">
                                            {{-- @if ($dari_ruangan = 'IGD') --}}
                                                <input type="text" value="{{$dari_ruangan}}" name="situation[dari_ruangan]" class="form-control">
                                            {{-- @else
                                                <select name="situation[dari_ruangan]" id="" class="select2" style="width: 100%;">
                                                    <option value="">Tidak ada</option>
                                                    @foreach ($kamar as $k)
                                                        <option value="{{$k->nama}}" {{$dari_ruangan == $k->id ? 'selected' : ''}}>{{$k->nama}}</option>
                                                    @endforeach
                                                </select>
                                            @endif --}}
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width:20%;">Tanggal Masuk</td>
                                        <td style="padding: 5px;">
                                          <input type="date" name="situation[tgl_masuk]" value="{{ @$history_irna[0]->tgl_masuk ? date('Y-m-d', strtotime(@$history_irna[0]->tgl_masuk)) : date('Y-m-d') }}" class="form-control"/>
                                          {{-- <small class="pull-right">Klik icon <b>kalender</b> untuk memunculkan tanggal</small> --}}
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width:20%;">Jam Masuk</td>
                                        <td style="padding: 5px;">
                                          <input type="time" value="{{date('H:i', strtotime(@$history_irna[0]->tgl_masuk))}}" name="situation[jam_masuk]" class="form-control"/>
                                          {{-- <small class="pull-right">Klik icon <b>jam</b> untuk memunculkan tanggal</small> --}}
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width:20%;">Diagnosa </td>
                                        <td style="padding: 5px;">
                                            <input type="text" name="situation[diagnosa]" class="form-control" value="{{ @$lastCppt->assesment }}"/>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width:200px;">Dokter yang merawat</td>
                                        <td style="padding: 5px;">
                                            <select class="select2" style="width: 100%;" name="situation[dokter_perawat]">
                                                @foreach ($dokters as $dok)
                                                    <option value="{{$dok->id}}" {{$dokter == $dok->id ? 'selected' : ''}}>{{$dok->nama}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">Pasien / Keluarga sudah dijelaskan mengenai diagnosis </td>
                                        <td style="padding: 5px;">
                                          <input type="checkbox" name="situation[dijelaskan]"/>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width:20%;">Masalah keperawatan yang utama saat ini </td>
                                        <td style="padding: 5px;">
                                          <input type="text" name="situation[masalah_keperawatan]" class="form-control"/>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width:20%;">Prosedur pembedahan / invasif yang akan / sudah dilakukan</td>
                                        <td style="padding: 5px;">
                                          <input type="text" name="situation[prosedur_pembedahan]" class="form-control"/>
                                        </td>
                                      </tr>
                                    </table>
                                  </div>
                                <h5><b>BACKGROUND</b></h5>
                                <div>
                                <div class="col-md-12">
                                    <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                                        style="font-size:12px;">
                                        <tr>
                                            <td  style="width:40%;">
                                                Alergi
                                            </td>
                                            <td style="padding: 5px;">
                                                <div>
                                                    <input class="form-check-input"
                                                        name="background[alergi][ada]"
                                                        {{ @$asessment['alergi']['ada'] == 'Ada' ? 'checked' : '' }}
                                                        type="radio" value="Ada" >
                                                    <label class="form-check-label">Ada</label>
                                                    <input type="text" name="background[alergi][nama]" value="" placeholder="Nama OBat" class="form-control">
                                                </div>
                                                <div>
                                                    <input class="form-check-input"
                                                        type="radio" value="Tidak Ada" name="background[alergi][tidak_ada]">
                                                    <label class="form-check-label">Tidak Ada</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                        <td style="width:20%;">Riwayat Reaksi </td>
                                            <td style="padding: 5px;">
                                                <input type="text" name="background[riwayat_reaksi]" class="form-control"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%;">Intervensi medik keperawatan </td>
                                            <td style="padding: 5px;">
                                              <input type="text" name="background[intervensi]" class="form-control"/>
                                            </td>
                                          </tr>
                                        <tr>
                                            <td style="width:20%;">Hasil investigasi Abnormal </td>
                                            <td style="padding: 5px;">
                                              <input type="text" name="background[hasil_investigasi]" class="form-control"/>
                                            </td>
                                        </tr>
                                        <tr>
                                        <td style="width:20%;">Kewaspadaan / Precaution </td>
                                        <td style="padding: 5px;">
                                            <select class="select2" style="width: 100%;" name="background[kewaspadaan]">
                                                <option value="" disabled selected>Pilih salah satu</option>
                                                <option value="Standar">Standar</option>
                                                <option value="Contect">Contect</option>
                                                <option value="Airbone">Airbone</option>
                                                <option value="Droplet">Droplet</option>
                                            </select>
                                        </td>
                                        </tr>
                                    </table>
                                </div>
                                <h5><b>ASSESMENT</b></h5>
                                <div class="col-md-12">
                                    <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                                        style="font-size:12px;">
                                        <tr>
                                            <td style="width: 20%;">Observasi terakhir pukul</td>
                                            <td style="padding: 5px;">
                                                <input type="date" name="assesment[observasi_akhir]" class="form-control"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">GCS</td>
                                            <td style="padding: 5px;">
                                                <input type="text" class="form-control" name="assesment[gcs]">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Pupil reaksi cahaya kanan</td>
                                            <td style="padding: 5px;">
                                                <input type="text" name="assesment[pupil_cahaya_kanan]" class="form-control"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Pupil reaksi cahaya kiri</td>
                                            <td style="padding: 5px;">
                                                <input type="text" name="assesment[pupil_cahaya_kiri]" class="form-control"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">TD</td>
                                            <td style="padding: 5px;">
                                                <input type="text" name="assesment[tekanan_darah]" class="form-control"  value="{{@$all_resume->tekanan_darah}}" />
                                            </td>
                                            <td>
                                                <small>mmHg</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">N</td>
                                            <td style="padding: 5px;">
                                                <input type="text" name="assesment[nadi]" class="form-control"  value="{{@$all_resume->nadi}}"/>
                                            </td>
                                            <td>
                                                <small>x/mnl</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">RP</td>
                                            <td style="padding: 5px;">
                                                <input type="text" name="assesment[rp]" class="form-control"/>
                                            </td>
                                            <td>
                                                <small>x/mnt</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">SPO2</td>
                                            <td style="padding: 5px;">
                                                <input type="text" name="assesment[spo2]" class="form-control"/>
                                            </td>
                                            <td>
                                                <small>%</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Suhu</td>
                                            <td style="padding: 5px;">
                                                <input type="text" name="assesment[suhu]" class="form-control" value="{{@$all_resume->suhu}}"/>
                                            </td>
                                            <td>
                                                <small>°C</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  style="width:20%;">
                                                Skala Nyeri
                                            </td>
                                            <td>
                                                <img src="{{asset('Skala-nyeri-wajah.png')}}" style="width: 100%">
                                                <input name="assesment[skala_nyeri]" type="range" min="0" max="10" value="{{ @$all_resume->skala_nyeri }}" oninput="this.nextElementSibling.value = this.value">
                                                <output style="text-align: center; font-weight: bold">{{ @$all_resume->skala_nyeri }}</output>
                                            </td>
                                       </tr>
                                        <tr>
                                            <td  style="width:20%;">
                                                Diet/Nutrisi
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="checkbox" name="assesment[oral]">
                                                    <small>Oral</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="assesment[ngt]">
                                                    <small>NGT</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="assesment[cairan]">
                                                    <small>Belasan Cairan</small>
                                                    <input type="text" placeholder="Belasan cairan (cc)" class="form-control">
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="assesment[diet]">
                                                    <small>Diet Khusus</small>
                                                    <input type="text" placeholder="Diet Khusus" class="form-control">
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="assesment[puasa]">
                                                    <small>Puasa Jam</small>
                                                    <input type="time" name="assesment[puasa_jam]" placeholder="Puasa Jam" class="form-control">
                                                </div>
                                            </td>
                                       </tr>
                                       <tr>
                                            <td style="width: 20%;">BAB</td>
                                            <td style="padding: 5px;">
                                                <select name="assesment[bab]" id="" class="select2" style="width: 100%;">
                                                    <option value="" selected disabled>Pilih salah satu</option>
                                                    <option value="normal">Normal</option>
                                                    <option value="ileustomy/coloslomy">Ileustomy/Coloslomy</option>
                                                    <option value="inkonsistensiaurin">Inkonsistensia Urin</option>
                                                    <option value="inkonsistensiaalvin">Inkonsistensia Alvin</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  style="width:20%;">
                                                BAK
                                            </td>
                                            <td>
                                                <div>
                                                        <input type="checkbox" name="assesment[bak][normal]">
                                                        <small>Normal</small>
                                                    </div>
                                                    <div>
                                                        <input type="checkbox" name="assesment[bak][kateter]">
                                                        <small>Kateter</small>
                                                        <input type="text" name="assesment[kateter][jenis_kateter]" placeholder="Jenis Kateter" class="form-control">
                                                        <input type="text" name="assesment[kateter][no_kateter]" placeholder="No Kateter" class="form-control">
                                                        <input type="date" name="assesment[tgl_pasang]" placeholder="Tgl Pasang" class="form-control">
                                                    </div>
                                                </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Transfer / Mobilisasi</td>
                                            <td style="padding: 5px;">
                                                <select name="assesment[transfer]" id="" class="select2" style="width: 100%;">
                                                    <option value="" selected disabled>Pilih salah satu</option>
                                                    <option value="mandiri">Mandiri</option>
                                                    <option value="dibantusebagian">Dibantu Sebagian</option>
                                                    <option value="dibantupenuh">Dibantu penuh</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Mobilisasi</td>
                                            <td style="padding: 5px;">
                                                <select name="assesment[mobilisasi]" id="" class="select2" style="width: 100%;">
                                                    <option value="" selected disabled>Pilih salah satu</option>
                                                    <option value="jalan">Jalan</option>
                                                    <option value="tirahbaring">Tirah baring</option>
                                                    <option value="duduk">Duduk</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Gangguan Indra</td>
                                            <td style="padding: 5px;">
                                                <select name="assesment[gangguan_indra]" id="" class="select2" style="width: 100%;">
                                                    <option value="" selected disabled>Pilih salah satu</option>
                                                    <option value="tidak_ada">Tidak ada</option>
                                                    <option value="bicara">Bicara</option>
                                                    <option value="pendengaran">Pendengaran</option>
                                                    <option value="penciuman">Penciuman</option>
                                                    <option value="perabaan">Perabaan</option>
                                                    <option value="penglihatan">Penglihatan</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Alat bantu yang digunakan</td>
                                            <td style="padding: 5px;">
                                                <select name="assesment[alat_bantu]" id="" class="select2" style="width: 100%;">
                                                    <option value="" selected disabled>Pilih salah satu</option>
                                                    <option value="normal">Tanpa alat bantu</option>
                                                    <option value="gigi_palsu">Gigi palsu</option>
                                                    <option value="kaca_mata">Kaca mata</option>
                                                    <option value="alat_bantu_dengar">Alat bantu dengar</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  style="width:20%;">
                                                Infus
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="checkbox" name="assesment[infus][tidak]">
                                                    <small>Tidak</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="assesment[infus][ya]">
                                                    <small>Ya</small>
                                                    <input type="text" name="assesment[infus][ya][lokasi]" placeholder="Lokasi" class="form-control">
                                                    <input type="date" name="assesment[infus][ya][tgl_pasang]" placeholder="Tgl Pemasangan" class="form-control">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Hal - hal istimewa yang berhubungan dengan kondisi pasien</td>
                                            <td style="padding: 5px;">
                                                <textarea type="date" name="assesment[hal_istimewa]" class="form-control"> </textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Tindakan / kebutuhan khusus</td>
                                            <td style="padding: 5px;">
                                                <select name="assesment[tindakan]" id="" class="select2" style="width: 100%;">
                                                    <option value="" selected disabled>Pilih salah satu</option>
                                                    <option value="Protokol resiko jatuh">Protokol resiko jatuh</option>
                                                    <option value="Protokol Restrain">Protokol Restrain</option>
                                                    <option value="Perawat luka">Perawat luka</option>
                                                    <option value="Hygiene">Hygiene</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Peralatan khusus yang diperlukan</td>
                                            <td style="padding: 5px;">
                                                <textarea type="date" name="assesment[peralatan_khusus]" class="form-control"> </textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <h5><b>RECOMENDATION</b></h5>
                                <div class="col-md-12">
                                    <table style="width: 100%" class="table table-striped table-bordered table-hover table-condensed form-box"
                                        style="font-size:12px;">
                                        <tr>
                                            <td style="width: 20%;">Konsultasi</td>
                                            <td style="padding: 5px;">
                                                <textarea type="date" name="recomendation[konsultasi]" class="form-control"> </textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Terapi</td>
                                            <td style="padding: 5px;">
                                                <textarea type="date" name="recomendation[terapi]" class="form-control"> </textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Rencana pemeriksaan Lab/Rad</td>
                                            <td style="padding: 5px;">
                                                <textarea type="date" name="recomendation[rencana_pemeriksaan]" class="form-control"> </textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Rencana tindakan lebih lanjut</td>
                                            <td style="padding: 5px;">
                                                <textarea type="date" name="recomendation[rencana_tindakan]" class="form-control"> </textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Kebutuhan Transfer Pasien</td>
                                            <td style="padding: 5px;">
                                                <textarea type="date" name="recomendation[kebutuhan_transfer_pasien]" class="form-control"> </textarea>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td style="width: 20%;">DERAJAT</td>
                                            <td style="padding: 5px;">
                                                <div>
                                                    <input type="checkbox" name="recomendation[derajat0]">
                                                    <small>DERAJAT:0</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[derajat1]">
                                                    <small>DERAJAT:1</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[derajat2]">
                                                    <small>DERAJAT:2</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[derajat3]">
                                                    <small>DERAJAT:3</small>
                                                </div>
                                            </td>
                                        </tr> --}}
                                        <tr>
                                            <td style="width: 20%;">Obat, Barang, Dokumen yang disertakan</td>
                                            <td style="padding: 5px;">
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][hasil_permintaan]">
                                                    <small>Hasil/Permintaan</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][lab]">
                                                    <small>Laboratorium</small> ->
                                                    <a href="{{ url('emr/pemeriksaan-lab/' . $unit . '/' . $reg->id . '?poli=' . $poli . '&dpjp=' . $dpjp) }}" class="btn btn-danger btn-sm" target="_blank">Hasil Laboratorium</a>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][foto]">
                                                    <small>Foto / X-Ray</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][ct]">
                                                    <small>CT Scan</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][usg]">
                                                    <small>USG</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][mri_mra]">
                                                    <small>MRI/MRA</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][konfirmasi_spesialis]">
                                                    <small>Konfirmasi Spesialis</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][admission]">
                                                    <small>Admission</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][formulir_konsultasi_spesialis]">
                                                    <small>Formulir konsultasi spesialis</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][echo]">
                                                    <small>Echo</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][form_rawat_inap]">
                                                    <small>Form rawat inap</small>
                                                </div>
                                            </td>
                                            <td style="padding: 5px;">
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][konfirmasi_rmo]">
                                                    <small>Konfirmasi dr. RMO</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][ecg]">
                                                    <small>ECG</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][gelang_nama]">
                                                    <small>Gelang Nama</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][catatan_integrasi]">
                                                    <small>Catatan Terintegrasi</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][imr]">
                                                    <small>IMR</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][rujukan_dari_dokter]">
                                                    <small>Rujukan dari dokter / RS</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][obat_obatan]">
                                                    <small>OBat - obatan</small> ->
                                                    <a href="#" id="historipenjualaneresep" data-bayar="{{@$reg->bayar ? $reg->bayar :''}}" data-registrasiID="{{ $reg->id }}" class="btn btn-info btn-sm">History E-Resep</a>
                                                    <div class="modal fade" id="showHistoriPenjualanEresep" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="">History E-Resep</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                <div id="dataHistoriEresep"></div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][konfirmasi_bo_tindakan_cito]">
                                                    <small>Konfirmasi BO tindakan cito</small>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="recomendation[disertakan][informasi_concent]">
                                                    <small>Inform Concent</small>
                                                </div>
                                                <div>
                                                    <small>Lain - lain</small>
                                                    <input type="text" class="form-control" name="recomendation[disertakan][lain-lain]">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Observasi tiba di ruangan</td>
                                            <td style="padding: 5px;">
                                                <textarea type="date" name="recomendation['obersarvasi_di_ruangan']" class="form-control"> </textarea>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="text-right">
                                        <button class="btn btn-success">Simpan</button>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </form>
                        
                    </div>

                    <br /><br />
                </div>


            </div>

            
            <br />
            <br />
            {{-- <div class="col-md-12 text-right">
      <table class="table table-striped table-bordered table-hover table-condensed form-box" style="font-size:12px;">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode(ICD 9)</th>
            <th>Deskripsi</th>
            <th>Diagnosa</th>
            <th>Tanggal</th>
          </tr>
        </thead>
         <tbody>
          @foreach ($riwayat as $key => $item)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->icd9}}</td>
                <td>{{baca_icd9($item->icd9)}}</td>
                <td>{{$item->diagnosis}}</td>
                <td>{{date('d-m-Y, H:i:s',strtotime($item->created_at))}}</td>
              </tr>
          @endforeach
         </tbody>
      </table>
    </div> --}}

        </div>
    @endsection

    @section('script')
        <script type="text/javascript">
            //ICD 10

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
