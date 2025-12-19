@extends('master')
@section('header')
  <h1>Kasir Rawat Inap</h1>

@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="box-title">
        Periode Tanggal &nbsp;
      </h4>
    </div>
    <div class="box-body">

      {!! Form::open(['method' => 'POST', 'url' => 'kasir/rawatinap', 'class'=>'form-hosizontal']) !!}
      <div class="row">
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::text('tanggal', null, ['class' => 'form-control datepicker', 'autocomplete'=>'off']) !!}
                    <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                </div>
    
            </div>
            <div class="form-group{{ $errors->has('lunas') ? ' has-error' : '' }}">
                {!! Form::label('lunas', 'Lunas / Blm', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::select('ket_lunas', ['' => '[Semua]', 'N'=> 'Belum Lunas', 'Y'=>'Lunas', 'P'=>'Piutang'], null, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
                    <small class="text-danger">{{ $errors->first('Lunas/Blm') }}</small>
                </div>
            </div>
    
        </div>
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('carabayar') ? ' has-error' : '' }}">
                {!! Form::label('carabayar', 'Cara Bayar', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    <select class="form-control select2" style="width: 100%" name="carabayar">
                      @if (!empty($_POST['carabayar']) && $_POST['carabayar'] == 1)
                        <option value="">[Semua]</option>
                        <option value="1" selected>JKN</option>
                        <option value="2">Umum</option>
                      @elseif (!empty($_POST['carabayar']) && $_POST['carabayar'] == 2)
                        <option value="">[Semua]</option>
                        <option value="1">JKN</option>
                        <option value="2" selected>Umum</option>
                      @else
                        <option value="">[Semua]</option>
                        <option value="1">JKN</option>
                        <option value="2">Umum</option>
                      @endif
    
                    </select>
                    <small class="text-danger">{{ $errors->first('carabayar') }}</small>
                </div>
            </div>
            <div class="form-group{{ $errors->has('tipe_jkn') ? ' has-error' : '' }}">
                {!! Form::label('tipe_jkn', 'Tipe JKN', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    <select class="form-control select2" style="width: 100%" name="tipe_jkn">
                      @if (!empty($_POST['tipe_jkn']) && $_POST['tipe_jkn'] == 'PBI')
                        <option value="">[Semua]</option>
                        <option value="PBI" selected>PBI</option>
                        <option value="NON PBI">NON PBI</option>
                      @elseif (!empty($_POST['tipe_jkn']) && $_POST['tipe_jkn'] == 'NON PBI')
                        <option value="">[Semua]</option>
                        <option value="PBI">PBI</option>
                        <option value="NON PBI" selected>NON PBI</option>
                      @else
                        <option value="">[Semua]</option>
                        <option value="PBI">PBI</option>
                        <option value="NON PBI">NON PBI</option>
                      @endif
    
                    </select>
                    <small class="text-danger">{{ $errors->first('tipe_jkn') }}</small>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-primary btn-flat">
                        Lanjut
                    </button>
                </div>
            </div>
    
        </div>
    </div>
    <div class="row">
      <div class="col-md-7">
          <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
              {!! Form::label('nama', 'Nama Pasien', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                  {!! Form::text('nama', null, ['class' => 'form-control','autocomplete'=>'off']) !!}
                  <small class="text-danger">{{ $errors->first('nama') }}</small>
              </div>
    
          </div>
          <div class="form-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
              {!! Form::label('no_rm', 'No RM', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                {!! Form::text('no_rm', null, ['class' => 'form-control','autocomplete'=>'off']) !!}
                  <small class="text-danger">{{ $errors->first('no_rm/Blm') }}</small>
              </div>
          </div>
          {{-- <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
            {!! Form::label('alamat', 'Alamat', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
              {!! Form::text('alamat', null, ['class' => 'form-control','autocomplete'=>'off']) !!}
                <small class="text-danger">{{ $errors->first('alamat') }}</small>
            </div>
          </div> --}}
    
      </div>
    </div>
      {!! Form::close() !!}
      <hr>
      <div class='table-responsive'>
        <table style="font-size:12px;" class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pasien</th>
              <th>No. RM</th>
              <th>Dokter</th>
              <th>Ruangan</th>
              <th>Cara Bayar</th>
              <th>Total Tagihan</th>
              <th>Pembayaran</th>
              <th>No Kwitansi</th>
              <th>Ket.</th>
              <th>SIP</th>
              <th>Surat Pulang Paksa</th>
              <th>Bayar</th>
              <th>Billing</th>
              <th>RB</th>
              {{-- <th>Piutang</th> --}}
              <th>Kwitansi Penunjang</th>
            </tr>
          </thead>
          <tbody>
            @isset($today)
              @foreach ($today as $key => $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->pasien->nama }}</td>
                    <td>{{ $d->pasien->no_rm }}</td>
                    <td>{{ baca_dokter($d->dokter_id) }}</td>
                    <td>{{ baca_kamar($d->kamar_id) }}</td>
                    <td>{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                    <td class="text-right">{{ number_format(total_tagihan($d->id)) }}</td>
                    <td class="text-right">{{ number_format(total_dibayar($d->id)) }}</td>
                    <td class="text-right">{!! no_kuitansi($d->id) !!}</td>
                    <td class="text-right">{{ @$d->keterangan }}</td>
                    <td class="text-center">
                      @if ($d->keterangan_sip == NULL)
                        <a id="btn-buatSIP" href="#modalBuatSIP{{ $d->id }}" class="btn btn-warning btn-sm" data-toggle="modal" data-id="{{ $d->id }}">Buat SIP</a>
                      @else
                        <div class="btn-group" style="display: flex; justify-content: center;">
                          <a href="{{ url('tindakan/cetak-sip/'.$d->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
                          <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right" role="menu" style="color:white !important">
                            {{-- @foreach (\App\Pembayaran::where('pembayaran','tindakan')->where('registrasi_id', $d->registrasi_id)->orderBy('id','DESC')->get() as $p) --}}
                              <li>
                                <button class="btn btn-danger btn-sm btn-flat" onclick="batalSIP({{$d->id}})">Batalkan SIP</button>
                            </li> 
                            {{-- @endforeach --}}
                          </ul>
                        </div>
                      @endif
                    </td>
                    <td class="text-center">
                      {{-- @if (@$d->kondisi_akhir_pasien == 3) --}}
                      {{-- @else
                      - --}}
                      {{-- @endif --}}
                      <div class="btn-group">
                        <a href="{{ url('kasir/cetak-surat-pulang-paksa/'. $d->id) }}" target="_blank"  class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print text-center"></i></a>
                        <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="color:white !important">
                          {{-- @foreach (\App\Pembayaran::where('pembayaran','tindakan')->where('registrasi_id', $d->registrasi_id)->orderBy('id','DESC')->get() as $p) --}}
                            <li>
                              <button class="btn btn-warning btn-sm btn-flat" onclick="edit_penanggung_jawab({{$d->id}})">Edit Penanggung Jawab</button>
                          </li> 
                            <li>
                              <a href="{{url('/signaturepad/surat-pulang-paksa/' . $d->id)}}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-pencil"></i>Tanda Tangan Penanggung Jawab</a>
                          </li> 
                          {{-- @endforeach --}}
                        </ul>
                      </div>
                    </td>
                    <td>
                      @if (total_tagihan($d->id) > 0)
                        <a href="{{ url('kasir/rawatinap/bayar/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                      @else
                        <i class="fa fa-check text-success"></i> <span class="text-success"> LUNAS </span>
                        <br>
                        <a href="{{ url('kasir/rawatinap/bayar/'. $d->id.'/'.$d->pasien_id) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                      @endif
                    </td>
                    <td>
                      @if (total_tagihan($d->id) > 0)
                        <a href="{{ url('rawat-inap/entry-tindakan/'. $d->id) }}" class="btn btn-sm btn-success btn-flat"><i class="fa fa-edit"></i></a>
                      @else
                        <i class="fa fa-check text-success"></i> <span class="text-success"> LUNAS </span>
                        <br>
                        <a href="{{ url('rawat-inap/entry-tindakan/'. $d->id) }}" class="btn btn-sm btn-success btn-flat"><i class="fa fa-edit"></i></a>
                      @endif
                    </td>
                    <td>
                      <button type="button"
                        onclick="rincianBiaya({{ @$d->id }}, '{{ @$d->pasien->nama }}', {{ @$d->pasien->no_rm }} )"
                        class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i></button>
                    </td>
                    {{-- <td>
                      @if ($d->bayar <> 1)
                        @if ($d->lunas == 'P')
                          Piutang
                        @else
                          <a href="{{ url('kasir/piutang/'.$d->id) }}" onclick="return confirm('Yakin akan di masukkan piutang?')" class="btn btn-sm btn-warning btn-flat"><i class="fa fa-dollar"></i></a>
                        @endif
                      @endif
                    </td> --}}
                    <td class="text-left">
                      <div class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></button>
                        <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" style="color:white !important">
                          {{-- @foreach (\App\Pembayaran::where('pembayaran','tindakan')->where('registrasi_id', $d->registrasi_id)->orderBy('id','DESC')->get() as $p) --}}
                            <li>
                              <a href="{{ url("kasir/cetakkuitansi-penunjang-rad/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Radiologi </a>
                              <a href="{{ url("kasir/cetakkuitansi-penunjang-lab/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Laboratorium </a>
                              <a href="{{ url("kasir/cetakkuitansi-penunjang-usg/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> USG</a>
                              <a href="{{ url("kasir/cetakkuitansi-penunjang-citologi/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Citologi</a>
                              <a href="{{ url("kasir/cetakkuitansi-penunjang-pa-biopsi/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>PA Biopsi</a>
                              <a href="{{ url("kasir/cetakkuitansi-penunjang-fnab/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>Fnab</a>
                              <a href="{{ url("kasir/cetakkuitansi-penunjang-pa-operasi/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>PA Operasi</a>
                          </li> 
                          {{-- @endforeach --}}
                        </ul>
                      </div>
                      {{-- <a href="{{ url('kasir/cetakkuitansi-blumlunas/'.$d->id) }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i></a> --}}
                    </td>
                  </tr>
                {{-- @endif --}}

                <!-- Modal Buat SIP-->
                <div class="modal fade" id="modalBuatSIP{{ $d->id }}" role="dialog" aria-labelledby="" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="">Masukkan Data</h4>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12">
                                <form method="POST" id="formBuatSIP" class="form-horizontal">
                                  {{ csrf_field() }}
                                  {{ method_field('POST') }}
                                  <input type="hidden" name="regId" id="regId{{ $d->id }}" value="{{ $d->id }}">
                                  <div class="form-group row">
                                    <div class="col-sm-12">
                                      <div>
                                        <label for="">Status</label>
                                        <input type="text" name="statusSipModal{{ $d->id }}" id="statusSipModal{{ $d->id }}" class="form-control">
                                      </div>
                                      <div>
                                        <label for="">Pembayaran</label>
                                        <input type="text" name="pembayaranSipModal{{ $d->id }}" id="pembayaranSipModal{{ $d->id }}" class="form-control">
                                      </div>
                                      <div>
                                        <label for="">Keterangan</label>
                                        <br>
                                        <select name="keteranganSipModal" id="keteranganSipModal{{ $d->id }}" class="form-control" required>
                                          <option value="SEP DAN RINCIAN DI RUANGAN">SEP DAN RINCIAN DI RUANGAN</option>
                                          <option value="SEP DAN RINCIAN DI KASIR">SEP DAN RINCIAN DI KASIR</option>
                                          <option value="LUNAS PEMBAYARAN">LUNAS PEMBAYARAN</option>
                                          <option value="PERJANJIAN PASIEN">PERJANJIAN PASIEN</option>
                                          <option value="PULANG ATAS PERMINTAAN SENDIRI (APS)">PULANG ATAS PERMINTAAN SENDIRI (APS)</option>
                                          <option value="MENINGGAL DUNIA">MENINGGAL DUNIA</option>
                                          <option value="SKTM">SKTM</option>
                                        </select>
                                      </div>
                                      
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-sm-12" style="text-align: right">
                                        <button id="btn-save-resep-modal" class="btn btn-primary" type="button" onclick="buatSIP({{ $d->id }})" >Buat SIP</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
                <!-- End Modal Buat SIP-->
              @endforeach
            @endisset
            @isset($byRM)
              @foreach ($byRM as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->no_rm }}</td>
                  <td>{{ $d->reg_id }}</td>
                  <td>{{ baca_dokter($d->dokter_id) }}</td>
                  <td>{{ baca_poli($d->poli_id) }}</td>
                  <td>{{ baca_carabayar($d->bayar) }}</td>
                  <td>{{ number_format(total_tagihan($d->id)) }}</td>
                  <td>{{ number_format(total_dibayar($d->id)) }}</td>
             
                  <td>
                    <a href="{{ url('kasir/rawatinap/bayar/'. $d->regid.'/'.$d->pasienid) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-credit-card"></i></a>
                  </td>
                  <td>
                    @if ($d->bayar <> 1)
                      @if ($d->lunas == 'P')
                        Piutang
                      @else
                        <a href="{{ url('kasir/piutang/'.$d->id) }}" onclick="return confirm('Yakin akan di masukkan piutang?')" class="btn btn-sm btn-warning btn-flat"><i class="fa fa-dollar"></i></a>
                      @endif
                    @endif
                  </td>
                  <td class="text-left">
                    <div class="btn-group">
                      <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></button>
                      <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" style="color:white !important">
                        {{-- @foreach (\App\Pembayaran::where('pembayaran','tindakan')->where('registrasi_id', $d->registrasi_id)->orderBy('id','DESC')->get() as $p) --}}
                          <li>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-rad/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Radiologi </a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-lab/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Laboratorium </a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-usg/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> USG</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-citologi/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i> Citologi</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-pa-biopsi/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>PA Biopsi</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-fnab/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>Fnab</a>
                            <a href="{{ url("kasir/cetakkuitansi-penunjang-pa-operasi/".$d->id) }}" class="btn btn-info btn-sm btn-flat"> <i class="fa fa-print"></i>PA Operasi</a>
                        </li> 
                        {{-- @endforeach --}}
                      </ul>
                    </div>
                    {{-- <a href="{{ url('kasir/cetakkuitansi-blumlunas/'.$d->id) }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i></a> --}}
                  </td>
                </tr>
              @endforeach
            @endisset

          </tbody>
        </table>
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
                {{-- <a href="{{ url('kasir/rincian-biaya/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm pull-right"><i class="fa fa-print"></i></a> --}}
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

    </div>
  </div>

  {{-- MODAL EDIT PENANGGUNG JAWAB -> COSTUM TANGGAL PULANG --}}
<div class="modal fade" id="modalEditPenanggungJawab">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit Penanggung Jawab</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          {{ csrf_field() }} {{ method_field('POST') }}
          <div class="form-group">
            <label for="nama_keluarga" class="col-md-3 control-label">Nama Keluarga</label>
            <div class="col-md-9">
              <input type="text" name="nama_keluarga" class="form-control" value="">
            </div>
          </div>
          <div class="form-group hubungan_keluargaGroup">
            <label for="hubungan_keluarga" class="col-sm-3 control-label">Hubungan Keluarga</label>
            <div class="col-sm-9">
              <select name="hubungan_keluarga" class="form-control select2" style="width: 100%;">
                  <option value="SAUDARA">SAUDARA</option>
                  <option value="IBU">IBU</option>
                  <option value="AYAH">AYAH</option>
                  <option value="SUAMI">SUAMI</option>
                  <option value="ISTRI">ISTRI</option>
                  <option value="ANAK">ANAK</option>
                  <option value="LAINNYA">LAINNYA</option>
              </select>
              <small class="text-danger hubungan_keluarga"></small>
            </div>
          </div>
          <div class="form-group">
            <label for="nik_penanggung_jawab" class="col-md-3 control-label">NIK Penanggung Jawab</label>
            <div class="col-md-9">
              <input type="number" name="nik_penanggung_jawab" class="form-control" value="">
            </div>
          </div>
          <div class="form-group">
            <label for="alamat_penanggung_jawab" class="col-md-3 control-label">Alamat Penanggung Jawab</label>
            <div class="col-md-9">
              <input type="text" name="alamat_penanggung_jawab" class="form-control" value="">
            </div>
          </div>
          <input type="hidden" name="registrasi_id" value="">
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="savePenanggungJawab()">Simpan</button>
      </div>
    </div>
  </div>
</div>

  <!-- jQuery 3 -->
  <script type="text/javascript">
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

  function buatSIP(registrasi_id){
    var regId = registrasi_id;
    var keterangan = $('#keteranganSipModal'+registrasi_id).val();
    var status = $('#statusSipModal'+registrasi_id).val();
    var pembayaran = $('#pembayaranSipModal'+registrasi_id).val();

    let dataForm = {
      "regId" : regId,
      "keterangan" : keterangan,
      "status" : status,
      "pembayaran" : pembayaran,
      "_token" : $('input[name=_token]').val(),
    };

    console.log(dataForm);
    $.ajax({
      url: "/kasir/buat-sip",
      method: 'POST',
      dataType: 'json',
      data: dataForm,
    }).done(function(resp){
      if(resp.sukses == true){
        alert(resp.text);
        location.reload(true);
      }else{
        alert(resp.text);
      }
    }).fail(function (e){
      console.log(e);
    });
  }

  function batalSIP(registrasi_id) {
    if (confirm('Yakin akan membatalkan SIP pada pasien?')) {
      var regId = registrasi_id;
  
      let dataForm = {
        "regId" : regId,
        "_token" : $('input[name=_token]').val(),
      };
  
      $.ajax({
        url: "/kasir/batal-sip",
        method: 'POST',
        dataType: 'json',
        data: dataForm,
      }).done(function(resp){
        if(resp.sukses == true){
          alert(resp.text);
          location.reload(true);
        }else{
          alert(resp.text);
        }
      });
    }
  }

  function edit_penanggung_jawab(id) {
    $('input[name=registrasi_id]').val(id);
    $('#modalEditPenanggungJawab').modal('show');
  }

  function savePenanggungJawab() {
    let regId = $('input[name=registrasi_id]').val();
    let nama_keluarga = $('input[name=nama_keluarga]').val();
    let nik_penanggung_jawab = $('input[name=nik_penanggung_jawab]').val();
    let alamat_penanggung_jawab = $('input[name=alamat_penanggung_jawab]').val();
    let hubungan_keluarga = $('select[name=hubungan_keluarga]').val();

    let dataForm = {
      "regId" : regId,
      "nama_keluarga" : nama_keluarga,
      "hubungan_keluarga" : hubungan_keluarga,
      "nik_penanggung_jawab" : nik_penanggung_jawab,
      "alamat_penanggung_jawab" : alamat_penanggung_jawab,
      "_token" : $('input[name=_token]').val(),
    };

    $.ajax({
      url: "/kasir/ubah-penanggung-jawab",
      method: 'POST',
      dataType: 'json',
      data: dataForm,
    }).done(function(resp){
      if(resp.sukses == true){
        alert(resp.text);
        location.reload(true);
      }else{
        alert(resp.text);
      }
    });
  }

  </script>
@endsection
