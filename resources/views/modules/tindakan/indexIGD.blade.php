@extends('master')

@section('header')
  <h1>Sistem Rawat Darurat</h1>
@endsection

@section('content')
    <style>
        .td-btn{
            margin: 0 !important;
            padding: 0 !important;
            vertical-align: middle !important;
        }
        .vertical-center{
            vertical-align: middle !important;
        }
    
    </style>
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Periode Tanggal: &nbsp;
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'tindakan/igd', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-4">
            <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
                </span>
                {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
                <small class="text-danger">{{ $errors->first('tga') }}</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Sampai Tanggal</button>
              </span>
                {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'onchange'=>'this.form.submit()']) !!}
            </div>
          </div>
          <div class="col-md-4" style="display: flex; ">
            <div class="input-group">
                {!! Form::text('keyword', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'NO RM/NAMA']) !!}
            </div>
            <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI">
          </div>
          </div>
        {!! Form::close() !!}
        <hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Pasien</th>
                <th class="text-center">RM</th>
                <th class="text-center">Usia</th>
                <th class="text-center">Tgl.Lahir</th>
                <th class="text-center">Dokter</th>
                <th class="text-center">Triage</th>
                <th class="text-center">Bayar</th>
                <th class="text-center" width="8%">Masuk</th>
                <th class="text-center">E.RSP</th>
                <th class="text-center">RB</th>
                <th class="text-center" width="8%">LAB</th>
                {{-- <th class="text-center" width="8%">RIS</th> --}}
                {{-- <th class="text-center" width="8%">RAD</th> --}}
                {{-- <th class="text-center" width="8%">SOAP</th> --}}
                
                {{-- <th style="width:8%">EKG</th> --}}
                <th class="text-center">SOAP</th>
                <th class="text-center">Proses</th>
                <th class="text-center">Cetak Konsul</th>
                <th class="text-center">Status</th>
                <th class="text-center">Cetak</th>
                <th class="text-center">Resume</th>
                <th class="text-center">ICD</th>
                <th style="width:15%">SPRI</th>
                <th style="width:15%">SPRI MANUAL</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($registrasi as $key => $d)
                @php
                    $folio = \Modules\Registrasi\Entities\Folio::where('registrasi_id', $d->id)->whereIn('jenis', ['TG','TI'])->count();
                    $pulang = App\ResumePasien::where('registrasi_id', $d->id)->first();
                @endphp
                {{-- @if (Auth::user()->role()->first()->name == 'rawatdarurat') --}}
                    @if (@$folio < 1)
                      <tr class="info">
                    @else
                      <tr>
                    @endif
                {{-- @endif --}}
                  <td>{{ $no++ }}</td>
                  <td>
                    @if (Carbon\Carbon::now() > $d->created_at->addHours(6) && $d->status_reg == 'G1')
                      <span class="blink_me" style="color: red; font-weight: bold;">{{ @$d->pasien->nama }}</span>
                    @else
                      {{ @$d->pasien->nama }}
                    @endif
                  </td>
                  <td class="text-center vertical-center" >{{ @$d->pasien->no_rm }}</td>
                  <td class="text-center vertical-center" >{{ hitung_umur(@$d->pasien->tgllahir, 'bulan') }}</td>
                  <td class="text-center vertical-center" >{{ date("d/m/Y", strtotime(@$d->pasien->tgllahir)) }}</td>
                  <td style="width: max-content">{{ Modules\Pegawai\Entities\Pegawai::where('id', @$d->dokter_id)->first()->nama }}</td>
                  {{-- <td>{{ !empty(@$d->poli_id) ? @$d->poli->nama : '' }}</td> --}}
                  <td>{{ @$d->triage_nama }}</td>
                  <td class="text-center vertical-center" >{{ baca_carabayar($d->bayar) }}
                    @if (!empty($d->tipe_jkn))
                      - {{ $d->tipe_jkn }}
                    @endif
                  </td>
                  <td class="text-center td-btn">{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                  <td class="text-center td-btn">
                    {{-- <a href="" type="button" class="btn btn-primary btn-sm btn-flat btn-add-resep" data-id="{{ $d->id }}"><i class="fa fa-address-card-o" aria-hidden="true"></i></button> --}}
                        <div style="display: flex;">
                            <a href="{{url('/emr/eresep/igd/'.$d->id."?poli_id=".$d->poli_id.'&dpjp='.$d->dokter_id)}}" class="btn btn-primary btn-sm btn-flat" "><i class="fa fa-address-card-o" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-warning btn-sm btn-flat btn-history-resep" data-id="{{ $d->id }}"><i class="fa fa-bars" aria-hidden="true"></i></button>
                        </div>
                  </td>
                  <td class="text-center td-btn">
                    <button type="button"
                      onclick="rincianBiaya({{ @$d->id }}, '{{ RemoveSpecialChar(@$d->pasien->nama) }}', {{ @$d->pasien->no_rm }}, '{{ @$d->registrasi_id }}' )"
                      class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i></button>
                  </td>
                  <td class="text-center td-btn">
                    {{-- @if(in_array($d->status_reg, ['I1', 'G1', 'G2', 'G3'])) --}}
                    <a href="{{ url('tindakan/labIgd/'.$d->id) }}" onclick="return confirm('Yakin akan di order ke LAB?')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-flask"> </i></a>
                    {{-- @endif --}}
                    @if (cek_hasil_lab($d->id) >= 1)
                     <a href="{{ url('pemeriksaanlab/pasien/'.$d->id) }}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa fa-eye"></i></a>
                    @endif
                  </td>
                  
                  {{-- <td class="text-center">
                  
                    <a href="{{ url('tindakan/radIgd/'.$d->id) }}" onclick="return confirm('Yakin akan di order ke RADIOLOGI?')"  class="btn btn-primary btn-sm btn-flat"><i class="fa fa-television"> </i></a>
                  
                  </td> --}}
                  {{-- <td class="text-center">
                    <a href="{{url('/emr/ris/igd/'.$d->id."?poli_id=".$d->poli_id.'&dpjp='.$d->dokter_id)}}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-television" aria-hidden="true"></i></a>
                  </td> --}}
                  <td class="text-center td-btn">
                    <a href="{{url('emr-soap/pemeriksaan/asesmen-igd/igd/'.$d->id.'?poli='.$d->poli_id.'&dpjp='.$d->dokter_id)}}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                  </td>
                  </td>
                  {{-- <td class="text-center">
                    <a href="{{ url('emr/igd/'.$d->id) }}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                  </td> --}}
                  <td class="text-center td-btn">
                  {{-- @if(in_array($d->status_reg, ['I1', 'G1', 'G2', 'G3'])) --}}
                    <a  href="{{ url('tindakan/entry/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                  {{-- @endif --}}
                  </td>
                  <td>
                    @if (@$d->konsulJawabId)
                      <a id="btn-cetakKonsul" href="#modalCetakKonsul{{ @$d->id }}" class="btn btn-warning btn-sm" data-toggle="modal" data-id="{{ @$d->konsulJawabId }}"><i class="fa fa-print"></i></a>
                    @else
                      <span><i>belum ada</i></span>
                    @endif
                  </td>
                    <td class="text-center td-btn">
                      <a target="_blank" href="{{url('emr-soap/pemeriksaan/status-igd/'.$d->id.'?poli='.$d->poli_id.'&dpjp='.$d->dokter_id)}}" class="btn btn-sm btn-warning btn-flat"><i class="fa fa-info-circle"></i></a>
                    </td>
                  <td class="text-center td-btn">
                     @if ($folio >= 1)
                      <a href="{{ url('tindakan/cetak-rincian-tindakan/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-file-pdf-o"></i></a>  
                    @endif
                  </td>
                  <td class="text-center td-btn">
                  {{-- @if(in_array($d->status_reg, ['I1', 'G1', 'G2'])) --}}
                    <a href="{{ url('resume-medis/igd/'.$d->id) }}" class="btn btn-warning btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                  {{-- @endif --}}
                  </td>
                  <td class="text-center td-btn">
                    <a href="{{ url('frontoffice/form_input_diagnosa_igd/'. @$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-tint"></i></a>
                    </td>
                  {{-- <td>
                    <a onclick="echocardiogram({{ $d->id }})" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-diamond"> </i></a>
                    @if (cek_echocardiogram($d->id) >= 1)
                      <a href="{{ url("echocardiogram/cetak-echocardiogram/".$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-eye"></i>
                    @endif
                  </td> --}}
                
                  <td class="text-center td-btn" >
                    <a href="{{ url('create-spri/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-bed"></i></a> 
                    {{-- <a class="btn btn-danger btn-sm btn-flat" onclick="suratPri({{ $d->id }})"><i class="fa fa-bed"></i></a> --}}
                    @if (cek_spri($d->id) >= 1)
                        <small class="btn btn-success btn-xs"><i class="fa fa-check"></i>Sudah</small>
                    @endif
                  </td>
                  <td>
                    <a href="{{ url('create-spri-manual/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-bed"></i></a> 
                  </td>
                </tr>
                <!-- Modal Cetak Konsul-->
                  <div class="modal fade" id="modalCetakKonsul{{ $d->id }}" role="dialog" aria-labelledby="" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="">Masukkan Keterangan Untuk Konsul</h4>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <form method="POST" id="formCetakKonsul" class="form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('POST') }}
                                    <input type="hidden" name="regId" id="regId{{ $d->id }}" value="{{ $d->id }}">
                                    <div class="form-group row">
                                      <div class="col-sm-12">
                                        <div>
                                          <label for="">Keterangan</label>
                                          <input type="text" name="keteranganCetakKonsul{{ $d->id }}" id="keteranganCetakKonsul{{ $d->id }}" class="form-control">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-sm-12" style="text-align: right">
                                          <button id="" class="btn btn-primary" type="button" onclick="cetakKonsul({{ $d->id }})" >Cetak Konsul</button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <!-- End Modal Cetak Konsul-->
              @endforeach
            </tbody>
          </table>
        </div>
        Keterangan <br>
        <button type="button" class="btn btn-sm btn-info btn-flat">
          <i class="fa fa-edit"></i>
        </button> Entry Tindakan
        &nbsp; &nbsp; &nbsp; &nbsp;
        <button type="button" class="btn btn-success btn-flat btn-sm">
          <i class="fa fa-user"></i>
        </button> False Emergency
      </div>
    </div>
    <div class="modal fade" id="modalTriage" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""></h4>
          </div>
          <div class="modal-body">
            <form method="POST" class="form-horizontal" role="form">
              <input type="hidden" name="registrasi_id" value="">
                <div class="form-group">
                  <label for="nama" class="col-md-3">Nama Pasien</label>
                  <div class="col-md-6">
                    <input type="text" readonly class="form-control" id="namaPasien" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="norm" class="col-md-3">No. RM</label>
                  <div class="col-md-6">
                    <input type="text" readonly class="form-control" id="nomorRM" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="kondisi" class="col-md-3">False Emergency</label>
                  <div class="col-md-6">
                    <select class="form-control" name="status_ugd">
                      <option value="HTS1">HTS1</option>
                      <option value="HTS2">HTS2</option>
                      <option value="HTS3">HTS3</option>
                      <option value="HTS4">HTS4</option>
                    </select>
                  </div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
              <button type="button" onclick="simpanTriage()" class="btn btn-primary btn-flat">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalRincianBiaya" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""></h4>
          </div>
          <div class="modal-body">
            <div class='table-responsive'>
              <div class="rincian_biaya">
              </div>
              
              <br/>
              <table class='table table-striped table-bordered table-hover table-condensed'>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tindakan</th>
                    {{--<th>Waktu Entry Tindakan</th>--}}
                    <th>Jenis Pelayanan</th>
                    <th>Biaya</th>
                  </tr>
                </thead>
                <tbody class="tagihan">
                </tbody>
                <tfoot>
                  <tr>
                    <th class="text-center" colspan="2">
                      <div class="rincian_biaya">
    
                      </div>
                    </th>
                    <th class="text-right">Total Tagihan</th>
                    <th class="text-right totalTagihan"></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

      <div class="modal fade" id="suratPri" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form method="POST" class="form-horizontal" id="formSPRI">
              {{ csrf_field() }}
              <input type="hidden" name="registrasi_id" value="">
              <input type="hidden" name="id" value="">
            <div class="table-responsive">
              <table class="table table-condensed table-bordered">
                <tbody>
                  <tr>
                    <th>Nama Pasien </th> <td class="nama"></td>
                    <th>Umur </th><td class="umur"></td>
                  </tr>
                  <tr>
                    <th>Jenis Kelamin </th><td class="jk" colspan="1"></td>
                    <th>No. RM </th><td class="no_rm" colspan="2"></td>
                  </tr>
                  <tr>
                      <th>Dokter Rawat</th>
                      <td>
                          <select name="dokter_rawat" class="form-control select2" style="width: 100%">
                            @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                                <option value="{{ @$d->id }}">{{ @$d->nama }}</option>
                            @endforeach
                          </select>
                      </td>
                      <th>Dokter Pengirim</th>
                      <td>
                          <select name="dokter_pengirim" class="form-control select2" style="width: 100%">
                            @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                                <option value="{{ @$d->id }}">{{ @$d->nama }}</option>
                            @endforeach
                          </select>
                      </td>
                  </tr>
                  <tr>
                      <th>Jenis Kamar</th>
                      <td>
                        <input type="text" name="jenis_kamar" class="form-control">
                      </td>
                      <th>Cara Bayar</th>
                      <td>
                          <select name="cara_bayar" class="form-control select2" style="width: 100%">
                            @foreach (\Modules\Registrasi\Entities\Carabayar::all() as $d)
                                <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
                            @endforeach
                          </select>
                      </td>
                  </tr>
                  <tr>
                    <th>Tgl Rencana Kontrol <label class="text-danger">*</label></th>
                    <td>
                      <div class="input-group{{ $errors->has('tglRencanaKontrol') ? ' has-error' : '' }}">
                        <span class="input-group-btn">
                          <button class="btn btn-default{{ $errors->has('tglRencanaKontrol') ? ' has-error' : '' }}" type="button">Tanggal</button>
                        </span>
                        {!! Form::text('tglRencanaKontrol', date('d-m-Y'), ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
                        <small class="text-danger">{{ $errors->first('tglRencanaKontrol') }}</small>
                    </div>
                    </td> 

                    <th>No. Kartu<label class="text-danger">*</label></th>
                    <td>
                      <div class="input-group{{ $errors->has('no_jkn') ? ' has-error' : '' }}">
                        {!! Form::text('no_jkn', null, ['class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off']) !!}
                        <small class="text-danger">{{ $errors->first('no_jkn') }}</small>
                    </div>
                    </td> 
                </tr>
                  <tr>
                    <th>Diagnosa</th>
                    <td colspan="3">
                      <textarea name="diagnosa" class="form-control wysiwyg"></textarea>
                    </td>
                  </tr>
                  <tr>
                    <th>SPRI</th>
                    <td colspan="3">
                        <div class="col-sm-2" style="padding-left:0">
                          <button type="button" id="createSPRI" class="btn btn-primary btn-flat"><i class="fa fa-recycle"></i> BUAT SPRI</button>
                        </div>
                        <div class="col-sm-5" id="fieldSPRI">
                            {!! Form::text('no_spri', null, ['class' => 'form-control', 'id'=>'noSPRI','readonly'=>true]) !!}
                            <small class="text-danger">{{ $errors->first('no_spri') }}</small>
                        </div> 
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="saveSPRI()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="echocardiogramModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        {{-- <div class="modal-body">
          <form method="POST" class="form-horizontal" id="formEkspertise">
            {{ csrf_field() }}
            <input type="hidden" name="registrasi_id" value="">
            <input type="hidden" name="pasien_id" value="">
            <input type="hidden" name="jenis" value="TA">
            <input type="hidden" name="id" value="">
          <div class="table-responsive">
            <table class="table table-condensed table-bordered">
              <tbody>
                <tr>
                  <th>Nama Pasien </th> <td class="nama"></td>
                  <th>Umur </th><td class="umur"></td>
                </tr>
                <tr>
                  <th>Jenis Kelamin </th><td class="jk" colspan="1"></td>
                  <th>No. RM </th><td class="no_rm" colspan="2"></td>
                </tr>
                <tr>
                  <th>Fungsi Sistolik LV</th>
                  <td>
                    <select name="fungsi_sistolik" class="form-control select2" style="width: 100%">
                      <option value="baik">Baik</option>
                      <option value="cukup">Cukup</option>
                      <option value="menurun">Menurun</option>
                    </select>
                  </td>
                  <th>Dimensi Ruang Jantung</th>
                  <td>
                    <select name="dimensi_ruang_jantung" class="form-control select2" style="width: 100%">
                      <option value="normal">Normal</option>
                      <option value="la_dilatasi">La dilatasi</option>
                      <option value="lv_dilatasi">Lv dilatasi</option>
                      <option value="ra_dilatasi">Ra dilatasi</option>
                      <option value="rv_dilatasi">Rv dilatasi</option>
                      <option value="semua_dilatasi">semua dilatasi</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Ef</th>
                  <td>
                    <input type="number" name="ef" class="form-control">
                  </td>
                  <th>Lv</th>
                  <td>
                    <select name="lv" class="form-control select2" style="width: 100%">
                      <option value="konsentrik(+)">Konsentrik (+)</option>
                      <option value="Eksentrik(+)">Eksentrik(+)</option>
                      <option value="(-)">(-)</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Global</th>
                  <td>
                    <select name="global" class="form-control select2" style="width: 100%">
                      <option value="normokinetik">Normokinetik</option>
                      <option value="hipokinetik">Hipokinetik</option>
                      <option value="(-)">(-)</option>
                    </select>
                  </td>
                  <th>Fungsi Sistolik Rv</th>
                  <td>
                    <select name="fungsi_sistolik_rv" class="form-control select2" style="width: 100%">
                      <option value="baik">Baik</option>
                      <option value="menurun">Menurun</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Tapse</th>
                  <td>
                    <select name="tapse" class="form-control select2" style="width: 100%">
                      <option value="<_16">< 16</option>
                      <option value=">_16">> 16</option>
                    </select>
                  </td>
                  <th>Katup-Katup Jantung Mitral</th>
                  <td>
                    <select name="katup_katup_jantung_mitral" class="form-control select2" style="width: 100%">
                      <option value="ms_ringan">ms_ringan</option>
                      <option value="ms_sedang">ms_sedang</option>
                      <option value="ms_berat">ms_berat</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Katup-Katup Jantung Aorta</th>
                  <td>
                    <select name="katup_katup_jantung_aorta" class="form-control select2" style="width: 100%">
                      <option value="3_cuspis">3 cuspis</option>
                      <option value="2_cuspis">2 cuspis</option>
                    </select>
                  </td>
                  <th>Katup-Katup Jantung Trikuspid</th>
                  <td>
                    <select name="katup_katup_jantung_trikuspid" class="form-control select2" style="width: 100%">
                      <option value="tr_ringan">Tr Ringan</option>
                      <option value="tr_sedang">Tr Sedang</option>
                      <option value="tr_berat">Tr Berat</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Katup-Katup Jantung Aorta Lain-Lain</th>
                  <td>
                    <input type="text" name="katup_katup_jantung_aorta_cuspis" class="form-control">
                  </td>
                  <th>Katup-Katup Jantung Pulmonal</th>
                  <td>
                    <select name="katup_katup_jantung_pulmonal" class="form-control select2" style="width: 100%">
                      <option value="pr_ringan">Pr Ringan</option>
                      <option value="pr_sedang">Pr Sedang</option>
                      <option value="pr_berat">Pr Berat</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Catatan Dokter</th>
                  <td colspan="3">
                    <textarea name="catatan_dokter" class="form-control wysiwyg"></textarea>
                  </td>
                </tr>
                <tr>
                  <th>Kesimpulan</th>
                  <td colspan="3">
                    <textarea name="kesimpulan" class="form-control wysiwyg"></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          </form>
        </div> --}}
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="saveEkpertise()">Simpan</button>
        </div>
      </div>
    </div> 

</div>

 {{-- Modal Eresep --}}
 <div id="myModalAddResep" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <input type="hidden" name="pasien_id">
    <input type="hidden" name="uuid">
    <input type="hidden" name="reg_id">
    <input type="hidden" name="source" value="inap">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah E-Resep</h4>
      </div>
      <div class="modal-body" style="display:grid;">
        <h3>Informasi Pasien</h3>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label class="control-label col-sm-4">No RM:</label>
              <div class="col-sm-8">
                <input type="text" name="no_rm" class="form-control" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-sm-4">Pasien:</label>
              <div class="col-sm-8">
                <input type="text" name="nama" class="form-control" readonly>
              </div>
            </div>
          </div>
        </div>
        <h3>Daftar E-Resep</h3>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label class="control-label col-sm-4">Nama Obat:</label>
              <div class="col-sm-8">
                <select name="masterobat_id" id="masterObat" class="form-control" onchange="cariBatch()"></select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-sm-4">Stok:</label>
              <div class="col-sm-8">
                <input type="text" name="last_stok" class="form-control" disabled>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-sm-4">Qty:</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" name="qty">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-sm-4">Cara Bayar:</label>
              <div class="col-sm-8">
                <select class="form-control select2" name="cara_bayar" style="width: 100%">
                  @foreach($carabayar as $key => $item)
                  <option value="{{ $item->carabayar }}" >{{ $item->carabayar }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-sm-4">E-Tiket:</label>
              <div class="col-sm-8">
                <select class="form-control select2" name="tiket" style="width: 100%">
                  @foreach($tiket as $key => $item)
                  <option value="{{ @$item->nama }}" >{{ @$item->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group row">
              <label class="control-label col-sm-4">Cara Minum:</label>
              <div class="col-sm-8">
                <select class="form-control select2" name="cara_minum" style="width: 100%">
                  @foreach($cara_minum as $key => $item)
                  <option value="{{ $item->aturan }}" >{{ $item->aturan }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-sm-4">Takaran:</label>
              <div class="col-sm-8">
                <select class="form-control select2" name="takaran" style="width: 100%">
                  @foreach($takaran as $key => $item)
                  <option value="{{ @$item->nama }}" >{{ @$item->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-sm-4">Inforrmasi:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="informasi">
              </div>
            </div>
            <div class="text-right">
            <button type="button" class="btn btn-primary" id="btn-save-resep">Tambah</button>
            </div>
          </div>
        </div>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Obat</th>
              <th>Qty</th>
              <th>Cara Bayar</th>
              <th>Tiket</th>
              <th>Cara Minum</th>
              <th>Takaran</th>
              <th>Informasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="listResep">
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
        <button type="button" id="btn-final-resep" class="btn btn-success">Simpan</button>
      </div>
    </div>

  </div>
</div>

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


@stop

@section('script')
  <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
  <script type="text/javascript">
    $('.select2').select2();
    (function blink() {
      $('.blink_me').fadeOut(500).fadeIn(500, blink);
    })();
    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function jenisLayanan(jenis) {
      switch (jenis) {
        case 'TA':
          return 'Layanan rawat jalan';
          break;
        case 'TG':
          return 'Layanan rawat darurat';
          break;
        case 'TI':
          return 'Layanan rawat inap';
          break;
        default:
          return 'Apotik';
          break;
      }
    }

    function rincianBiaya(registrasi_id, nama, no_rm) {
      // alert(registrasi_id)
      $('#modalRincianBiaya').modal('show');
      $('.modal-title').text(nama + ' | ' + no_rm + '|' + registrasi_id)
      $('.tagihan').empty();
      $('.rincian_biaya').empty();
      $.ajax({
        url: '/informasi-rincian-biaya/' + registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          cetak = '<a class="btn btn-info btn-sm pull-right" style="margin-left:10px" target="_blank" href="/ranap-informasi-rincian-biaya/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya</a>';
        cetak2 = '<a class="btn btn-success btn-sm pull-right" target="_blank" href="/ranap-informasi-unit-rincian-biaya-tanpa-rajal/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya Unit Tanpa Rajal</a><br/>';
        cetak3 = '<a class="btn btn-danger btn-sm pull-right" style="margin-left:20px;" target="_blank" href="/ranap-informasi-unit-item-rincian-biaya-tanpa-rajal/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya(Klaim)</a>';
        $('.rincian_biaya').append(cetak3)
        $('.rincian_biaya').append(cetak)
        $('.rincian_biaya').append(cetak2)
          // console.log(data);
          $.each(data, function (key, value) {
            $('.tagihan').append('<tr> <td>' + (key + 1) + '</td> <td>' + value.namatarif + '</td> <td>' + jenisLayanan(value.jenis) + '</td> <td class="text-right">' +
              ribuan(value.total) + '</td> </tr>')
          });
        }
      });

      $.ajax({
        url: '/informasi-total-biaya/' + registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log(data);
          $('.totalTagihan').html(ribuan(data))
        }
      });
    }
    function triage(registrasi_id, nama, norm) {
      $('#modalTriage').modal('show');
      $('.modal-title').text('Kondisi Pasien');
      $('#namaPasien').val(nama);
      $('#nomorRM').val(norm);
      $('input[name="registrasi_id"]').val(registrasi_id);
    }
    function simpanTriage() {
      var status_ugd = $('select[name="status_ugd"]').val();
      var registrasi_id = $('input[name="registrasi_id"]').val();
      $.ajax({
        url: '/tindakan/igd/ubah-status-ugd/'+registrasi_id+'/'+status_ugd,
        type: 'GET',
        success: function (data) {
          console.log(data);
          if(data.sukses == true){
            $('#modalTriage').modal('hide');
            location.reload();
          }
        }
      })
    }

    CKEDITOR.replace( 'kesimpulan', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    //CKEDITOR
    CKEDITOR.replace( 'catatan_dokter', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    function echocardiogram(id) {
      $('#echocardiogramModal').modal({
        backdrop: 'static',
        keyboard : false,
      })
      $('.modal-title').text('Input Echocardiogram')
      $("#formEkspertise")[0].reset()
      CKEDITOR.instances['catatan_dokter'].setData('')
      CKEDITOR.instances['kesimpulan'].setData('')
      $.ajax({
        url: '/echocardiogram/echocardiogram/'+id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('.nama').text(data.reg.pasien.nama)
        $('.no_rm').text(data.reg.pasien.no_rm)
        $('input[name="pasien_id"]').val(data.reg.pasien.id)
        $('.umur').text(data.umur)
        $('.jk').text(data.reg.pasien.kelamin)
        $('input[name="registrasi_id"]').val(data.reg.id)
        $('input[name="jenis"]').val(data.ep.jenis)
        $('input[name="ef"]').val(data.ep.ef)
        $('input[name="katup_katup_jantung_aorta_cuspis"]').val(data.ep.katup_katup_jantung_aorta_cuspis)

        $('select[name="fungsi_sistolik"]').val(data.ep.fungsi_sistolik).trigger('change')
        $('select[name="global"]').val(data.ep.global).trigger('change')
        $('select[name="dimensi_ruang_jantung"]').val(data.ep.dimensi_ruang_jantung).trigger('change')
        $('select[name="lv"]').val(data.ep.lv).trigger('change')
        $('select[name="fungsi_sistolik_rv"]').val(data.ep.fungsi_sistolik_rv).trigger('change')
        $('select[name="tapse"]').val(data.ep.tapse).trigger('change')
        $('select[name="katup_katup_jantung_mitral"]').val(data.ep.katup_katup_jantung_mitral).trigger('change')
        $('select[name="katup_katup_jantung_aorta"]').val(data.ep.katup_katup_jantung_aorta).trigger('change')
        $('select[name="katup_katup_jantung_aorta_cuspis"]').val(data.ep.katup_katup_jantung_aorta_cuspis).trigger('change')
        $('select[name="katup_katup_jantung_trikuspid"]').val(data.ep.katup_katup_jantung_trikuspid).trigger('change')
        $('select[name="katup_katup_jantung_pulmonal"]').val(data.ep.katup_katup_jantung_pulmonal).trigger('change')
        $('select[name="katup_katup_jantung_trikuspid"]').val(data.ep.katup_katup_jantung_trikuspid).trigger('change')
        
        if (data.ep != '') {
          $('input[name="id"]').val(data.ep.id)
          CKEDITOR.instances['kesimpulan'].setData(data.ep.kesimpulan)
          CKEDITOR.instances['catatan_dokter'].setData(data.ep.catatan_dokter)
        }
      })
      .fail(function() {

      });
    }

    // function saveEkpertise() {
    //   var token = $('input[name="_token"]').val();
    //   var catatan_dokter = CKEDITOR.instances['catatan_dokter'].getData();
    //   var kesimpulan = CKEDITOR.instances['kesimpulan'].getData();
    //   var form_data = new FormData($("#formEkspertise")[0])
    //   form_data.append('catatan_dokter', catatan_dokter)
    //   form_data.append('kesimpulan', kesimpulan)

    //   $.ajax({
    //     url: '/echocardiogram/echocardiogram',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: form_data,
    //     async: false,
    //     processData: false,
    //     contentType: false,
    //   })
    //   .done(function(resp) {
    //     if (resp.sukses == true) {
    //       $('input[name="id"]').val(resp.data.id)
    //       alert('Echocardiogram berhasil disimpan.')
    //       location.reload();
    //     }

    //   });
    // }

      //CKEDITOR
    CKEDITOR.replace( 'diagnosa', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    function suratPri(id) {
      $('#suratPri').modal({
        backdrop: 'static',
        keyboard : false,
      })
      $('.modal-title').text('Input SPRI')
      $("#formSPRI")[0].reset()
      CKEDITOR.instances['diagnosa'].setData('')
      $.ajax({
        url: '/view-spri/'+id,
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
        $('select[name="dokter_pengirim"]').val(data.reg.dokter_id).trigger('change')
        
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
        }
        if (resp.sukses == false) {
          alert(resp.msg)
        }
      });
    }
    $('#createSPRI').on('click', function () {
        $("input[name='no_spri']").val( ' ' );
        $.ajax({
          url : '{{ url('/spri/buat-spri') }}',
          type: 'POST',
          data: $("#formSPRI").serialize(),
          processing: true,
          beforeSend: function () {
            $('.overlay').removeClass('hidden')
          },
          complete: function () {
            $('.overlay').addClass('hidden')
          },
          success:function(data){
            console.log(data.sukses)
            if(data.code !== "200"){
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

    // E RESEP
     // ADD RESEP
     $(document).on('click','.btn-add-resep',function(){
      let id = $(this).attr('data-id');
      $('input[name=uuid]').val('');
      $.ajax({
        url: '/tindakan/e-resep/show/'+id,
        type: 'GET',
        dataType: 'json',
        // data: $('#formPulang').serialize(),
        success: function (res){
          console.log(res.data.bayar);
          $('input[name="pasien_id"]').val(res.data.pasien.id)
          $('input[name="reg_id"]').val(res.data.id)
          $('input[name="no_rm"]').val(res.data.pasien.no_rm)
          $('input[name="nama"]').val(res.data.pasien.nama)
          $('select[name="cara_bayar"]').val(res.data.bayars.carabayar).trigger('change');
          $('#myModalAddResep').modal('show');
          // $('.select2').select2({
          //   placeholder: '[--]',
          // });
        }
      });
    })
    // HISTORY RESEP
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
    // BTN SAVE RESEP
    $(document).on('click','#btn-save-resep',function(){
      let body = {
        "uuid" : $('input[name=uuid]').val(),
        "reg_id" : $('input[name=reg_id]').val(),
        "pasien_id" : $('input[name=pasien_id]').val(),
        "source" : $('input[name=source]').val(),
        "masterobat_id" : $('select[name=masterobat_id]').val(),
        "qty" : $('input[name=qty]').val(),
        "cara_bayar" : $('select[name=cara_bayar]').val(),
        "tiket" : $('select[name=tiket]').val(),
        "cara_minum" : $('select[name=cara_minum]').val(),
        "takaran" : $('select[name=takaran]').val(),
        "informasi" : $('input[name=informasi]').val(),
        "_token" : $('input[name=_token]').val(),
      };
      $.ajax({
        url: '/tindakan/e-resep/save-detail-igd',
        type: 'POST',
        dataType: 'json',
        data: body,
        success: function (res){
          if(res.status == true){
            $('input[name="uuid"]').val(res.uuid);
            $('#listResep').html(res.html);
            $('select[name="masterobat_id"]').val('');
            $('input[name="qty"]').val('');
          }
        }
      });
    })
    // BTN FINAL RESEP
    $(document).on('click','#btn-final-resep',function(){
      if( confirm('Yakin Akan Disimpan ?') ){
        let body = {
          "uuid" : $('input[name=uuid]').val(),
          "_token" : $('input[name=_token]').val(),
        };
        $.ajax({
          url: '/tindakan/e-resep/save-resep',
          type: 'POST',
          dataType: 'json',
          data: body,
          success: function (res){
            if(res.status == true){
              location.reload();
            }
          }
        });
      }
    })

    $(document).on('click','.del-detail-resep',function(){
      let id = $(this).attr('data-id');
      let body = {
        "_token" : $('input[name=_token]').val(),
      };
      $.ajax({
        url: '/tindakan/e-resep/detail/'+id+'/delete',
        type: 'DELETE',
        dataType: 'json',
        data: body,
        success: function (res){
          if(res.status == true){
            $('#listResep').html(res.html);
          }
        }
      });
    })

    $('#masterObat').select2({
        placeholder: "Klik untuk isi nama obat",
        width: '100%',
        ajax: {
            url: '/penjualan/resep/master-obat-baru/',
            dataType: 'json',
            data: function (params) {
                return {
                    j: 1,
                    q: $.trim(params.term)
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

    function cariBatch() {
      var masterobat_id= $("select[name='masterobat_id']").val();
      $.get('/penjualan/get-obat-baru/'+masterobat_id, function(resp){
        console.log(resp)
        $('input[name="last_stok"]').val(resp.obat.stok);
      })
    }

  function cetakKonsul(registrasi_id){
    var regId = registrasi_id;
    var keterangan = $('#keteranganCetakKonsul'+registrasi_id).val();

    let dataForm = {
      "regId" : regId,
      "keterangan" : keterangan,
      "_token" : $('input[name=_token]').val(),
    };

    // console.log(dataForm);
    $.ajax({
      url: "/emr-konsul/buat-cetak-konsul",
      method: 'POST',
      dataType: 'json',
      data: dataForm,
    }).done(function(resp){
      if(resp.sukses == true){
        alert(resp.text);
        $('#modalCetakKonsul'+regId).modal('hide');
        window.open('/emr-konsul/cetak-konsul/'+resp.regId+'/'+resp.konsulId, '_blank');
        // location.reload(true);
      }else{
        alert(resp.text);
      }
    }).fail(function (res){
      if (res.status == 0) {
        alert('Gagal Terhubung ke Server, Silahkan Hubungi Pak T10')
      } else {
        alert('Gagal menyimpan')
      }
    });
  }
  </script>
@endsection
