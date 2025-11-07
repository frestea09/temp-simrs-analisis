@extends('master')
@section('header')
<h1>Sistem Rawat Inap <small></small></h1>
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
    {{-- <h4>Periode Tanggal :</h4> --}}
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/billing-filter-new', 'class'=>'form-horizontal']) !!}
    <input type="hidden" name="jenis_reg" value="I2">
    <div class="row">
        <div class="col-md-4">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">No.RM</button>
              </span>
              {!! Form::text('no_rm', NULL, ['class' => 'form-control', 'required' => 'required', 'onchange'=>'this.form.submit()','placeholder'=>'Masukkan No.RM kemudian ENTER' ,'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>
        {{-- <div class="col-md-4">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', $tga, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div> --}}
        
        {{-- <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', $tgb, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete' => 'off']) !!}
          </div>
        </div> 
       --}}
       <div class="col-md-4" style="display: none">
        <div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">Kelompok</button>
          </span>
          <select name="kelompok_kelas" class="form-control select2" onchange="this.form.submit()" id="">
              <option value=""> --Semua-- </option>
              @foreach ($kelompok_kelas as $key => $item)
              <option value="{{ $item }}" {{$item == @$kelas_selected ? 'selected' :''}}>{{ str_replace('_',' ',$item) }}</option>
              @endforeach
          </select>
        </div>
      </div>
    </div>
    
    {!! Form::close() !!}
    <hr>
    {{-- {{dd(count($inap))}} --}}
    @if(@count($inap) > 0)
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='datas' style="font-size: 12px">
          <thead>
            <tr>
              
              {{-- <th class="text-center" style="vertical-align: middle">No</th> --}}
              <th class="text-center" style="vertical-align: middle">RM</th>
              <th class="text-center" style="vertical-align: middle">Pasien</th>
              <th class="text-center" style="vertical-align: middle">DPJP</th>
              <th class="text-center" style="vertical-align: middle">Usia</th>
              <th class="text-center" style="vertical-align: middle">Tgl.Lahir</th>
              <th class="text-center" style="vertical-align: middle">Kelas</th>
              <th class="text-center" style="vertical-align: middle">Hak Kelas</th>
              <th class="text-center" style="vertical-align: middle">Kamar</th>
              <th class="text-center" style="vertical-align: middle">Bed</th>
              <th class="text-center" style="vertical-align: middle">Bayar</th>
              <th class="text-center" style="vertical-align: middle">Masuk</th>
              <th class="text-center" style="vertical-align: middle">Keluar</th>
              <th class="text-center" style="vertical-align: middle">SEP</th>
              @if(@$status_reg == 'I2')
                <th class="text-center" style="vertical-align: middle">IBS</th>
                <th class="text-center" style="vertical-align: middle">RIS</th>
                <th class="text-center" style="vertical-align: middle">MUT</th>
                <th class="text-center" style="vertical-align: middle">PULANG</th>
                <th class="text-center" style="vertical-align: middle">RB</th>
                <th class="text-center" style="vertical-align: middle">Tindakan</th>
              @endif
              {{-- <th class="text-center" style="vertical-align: middle">CETAK</th> --}}
              <th class="text-center" style="vertical-align: middle">KONTROL</th>
              <th class="text-center" style="vertical-align: middle">SPRI</th>
              <th class="text-center" style="vertical-align: middle">SEP</th>
            </tr>
          </thead>
          
          <tbody>
            @foreach($inap as $key => $d)
              <tr>
                {{-- <td>{{ @$no++ }}</td> --}}
                <td data-rawatinap_id={{@$d->id}} data-registrasi_id={{@$d->registrasi_id}}>{{ @$d->no_rm }}</td>
                <td>{{ @$d->nama_pasien }}</td>
                {{-- <td>{{@$d->dokter_dpjp }}</td> --}}
                <td>{{ @$d->dokter_inap ? @$d->dokter_ahli->nama : @$d->dokter_dpjp }}</td>
                <td>{{ hitung_umur(@$d->tgllahir, 'buln') }}</td>
                <td>{{ date("d/m/Y", strtotime(@$d->tgllahir)) }}</td>
                <td>{{ @$d->kelas }}</td>
                <td>{{ @$d->hakkelas }}</td>
                <td>{{ @$d->kamar }}</td>
                <td>{{ @$d->bed }}</td>
                <td>{{ @$d->carabayar }}
                  {{ !empty(@$d->tipe_jkn) ? ' - '.@$d->tipe_jkn : '' }}
                </td>
                <td onclick="updateTgl({{ $d->registrasi_id }})">{{date('d-m-Y H:i',strtotime($d->tgl_masuk)) }}</td>
                <td class="text-center">{{ $d->tgl_keluar ? tanggal_eklaim($d->tgl_keluar) : '-'}}</td>
                <td class="text-center">{{ @$d->no_sep ? @$d->no_sep : '-' }}</td>
                @if(@$d->status_reg == 'I2') 
                  <td class="text-center td-btn">
                    <a href="{{ url('rawat-inap/ibs/'.@$d->reg_id) }}"
                      onclick="return confirm('Yakin akan di order ke IBS?')" class="btn btn-warning btn-sm btn-flat"><i
                        class="fa fa-cut"></i></a>
                  </td> 
                  <td class="text-center td-btn">
                    <a href="{{ url('emr/ris/inap/'.@$d->reg_id.'?poli='.@$d->poli_id.'&dpjp='.@$d->dokter_id) }}"
                      onclick="return confirm('Yakin akan di order ke RIS?')" class="btn btn-info btn-sm btn-flat"><i
                        class="fa fa-dashboard"></i></a>
                  </td>  
                  <td class="text-center td-btn">
                    <a href="{{ url('rawat-inap/mutasi/'.@$d->reg_id) }}"
                      onclick="return confirm('Yakin akan di Mutasi?')" class="btn btn-success btn-sm btn-flat"><i
                        class="fa fa-recycle"></i></a>
                  </td>
                  <td class="text-center td-btn">
                    @if(strpos($d->nama_pasien, "BY") === FALSE)
                      <a class="btn btn-danger btn-sm btn-flat"
                        onclick="pulangkan({{ @$d->reg_id }}, {{ @$d->bed_id }}, null)"><i class="fa fa-home"></i></a>
                    @else
                      <a class="btn btn-danger btn-sm btn-flat"
                        onclick="pulangkan({{ @$d->reg_id }}, {{ @$d->bed_id }},'bayi')"><i class="fa fa-home"></i></a>
                    @endif
                    {{-- <a class="btn btn-danger btn-sm btn-flat" onclick="pulangkan({{ @$d->reg_id }},
                    {{ $d->bed_id }})"><i class="fa fa-home"></i></a> --}}
                  </td>
                  <td class="text-center td-btn"> 
                    <button type="button"
                      onclick="rincianBiaya({{ @$d->reg_id }}, '{{ RemoveSpecialChar(@$d->nama_pasien) }}', {{ @$d->no_rm }}, '{{ @$d->reg_id }}' )"
                      class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i></button>
                  </td>
                  <td class="text-center td-btn">
                    <a href="{{ url('rawat-inap/entry-tindakan/'.@$d->reg_id) }}"
                      class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i> </a>
                  </td>
                  {{-- <td class="text-center">
                    <a href="{{ url('rawat-inap/ppi/'.$reg->pasien_id) }}"
                      class="btn btn-default btn-sm btn-flat"><i class="fa fa-pencil"> </i></a>
                  </td> --}}
                @endif
                {{--<td class="text-center">
                  <a href="{{ url('rawat-inap/cetak-rincian/'.$d->reg_id) }}"
                    target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-file-pdf-o"></i></a>
                </td>--}}
                <td class="text-center td-btn">
                  @if(@$d->status_reg == 'I2')
                    <a href="{{ url('resume-medis/inap/'.@$d->reg_id) }}"
                      class="btn btn-warning btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                  @endif
                </td>
                <td class="text-center td-btn">
                  <a href="{{ url('/create-spri/'.@$d->reg_id) }}"
                    class="btn btn-danger btn-sm btn-flat"><i class="fa fa-edit"></i> </a>
                </td>
                <td>
                  @if (!empty($d->no_sep))
                    <a href="{{ url('cetak-sep/'.$d->no_sep) }}" target="_blank"  class="btn btn-info btn-sm btn-flat"><i class="fa fa-print text-center"></i> </a>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</div>

<!-- Modal -->
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
                    <option value="{{ $item->carabayar }}">{{ $item->carabayar }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-sm-4">E-Tiket:</label>
              <div class="col-sm-8">
                <select class="form-control select2" name="tiket" style="width: 100%">
                  @foreach($tiket as $key => $item)
                    <option value="{{ $item->nama }}">{{ $item->nama }}</option>
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
                    <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-sm-4">Takaran:</label>
              <div class="col-sm-8">
                <select class="form-control select2" name="takaran" style="width: 100%">
                  @foreach($takaran as $key => $item)
                    <option value="{{ $item->nama }}">{{ $item->nama }}</option>
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
                <th class="text-right">Total Tagihan Seluruh</th>
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

{{-- MODAL PULANGKAN -> COSTUM TANGGAL PULANG --}}
<div class="modal fade" id="modalPulangkan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formPulang" method="POST">
          {{ csrf_field() }} {{ method_field('POST') }}
          <div class="form-group">
            <label for="tanggal" class="col-md-3 control-label">Tanggal Pulang</label>
            <div class="col-md-9">
              <input type="text" name="tanggal" class="form-control datepicker" value="">
              <small class="text-muted"><i>Default tanggal adalah hari ini, sesuaikan jika pasien sudah
                  dipulangkan!</i></small>
            </div>
          </div>
          <div class="form-group statusPulangGroup">
            <label for="statusPulang" class="col-sm-3 control-label">Cara Pulang</label>
            <div class="col-sm-9">
              <select id="statusPulang" name="statusPulang" class="form-control select2" style="width: 100%;">
                <option value=""></option>
                @foreach($caraPulang as $id => $namakondisi)
                  <option value="{{ $id }}">{{ $namakondisi }}</option>
                @endforeach
              </select>
              <small class="text-danger statusPulang"></small>
            </div>
          </div>
          <div class="form-group kondisiPulangGroup">
            <label for="kondisiPulang" class="col-sm-3 control-label">Kondisi Saat Pulang</label>
            <div class="col-sm-9">
              <select id="kondisiPulang" name="kondisiPulang" class="form-control select2" style="width: 100%;">
                <option value=""></option>
                @foreach($kondisiPulang as $id => $namakondisi)
                  <option value="{{ $id }}">{{ $namakondisi }}</option>
                @endforeach
              </select>
              <small class="text-danger kondisiPulang"></small>
            </div>
          </div>
          <section id="rujukan" style="display:none;">
            <div class="form-group">
              <label for="faskes" class="col-md-4 control-label">Faskes Rujukan</label>
              <div class="col-md-8">
                <select id="faskes" name="status[diRujukKe]" class="form-control select2" style="width: 100%">
                    <option value="">- Pilih -</option>
                    <option value="RS Kab. Bandung">RS Kab. Bandung</option>
                    <option value="RS Kota Bandung">RS Kota Bandung</option>
                    <option value="RS Provinsi">RS Provinsi</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="faskes_rs_rujukan" class="col-md-4 control-label">Rumah Sakit Rujukan</label>
              <div class="col-md-8">
                <select id="faskes_rs_rujukan" name="status[rsRujukan]" class="form-control select2" style="width: 100%">
                    <option value="">- Pilih -</option>
                    @foreach ($faskesRujukanRs as $rs)
                        <option value="{{$rs->id}}">{{$rs->nama_rs}}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="alasan" class="col-md-4 control-label">Alasan Rujukan</label>
              <div class="col-md-8">
                <input type="text" style="width: 100%" name="status[alasanRujuk]" value="" class="form-control" >
              </div>
            </div>
          </section>
          
          <section id="perinatologi" style="display:none;">
            <hr>
            <div class="row text-left">
              <label class="col-md-12 control-label">PERINATOLOGI</label>
            </div>
            <section id="perinatologi_hidup">
              <div class="form-group">
                <label for="tanggal" class="col-md-3 control-label">Bayi Lahir Hidup</label>
                <div class="col-md-9">
                  <select class="form-control select2" name="perinatologi_hidup" style="width:100%;">
                    {{-- <option value="">Pilih</option> --}}
                    @foreach($perinatologi->where('parent_id',1) as $item)
                      <option value="{{ $item->id_conf_rl35 }}">{{ $item->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </section>
            <section id="perinatologi_mati">
              <div class="form-group">
                <label for="tanggal" class="col-md-3 control-label">Kematian Perinatal</label>
                <div class="col-md-9">
                  <select class="form-control select2" name="perinatologi_mati" style="width:100%;">
                    {{-- <option value="">Pilih</option> --}}
                    @foreach($perinatologi->where('parent_id',4) as $item)
                      <option value="{{ $item->id_conf_rl35 }}">{{ $item->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="tanggal" class="col-md-3 control-label">Sebab Kematian Perinatal</label>
                <div class="col-md-9">
                  <select class="form-control select2" name="perinatologi_sebab_mati" style="width:100%;">
                    {{-- <option value="">Pilih</option> --}}
                    @foreach($perinatologi->where('parent_id',7) as $item)
                      <option value="{{ $item->id_conf_rl35 }}">{{ $item->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </section>
          </section>
          <input type="hidden" name="registrasi_id" value="">
          <input type="hidden" name="bed_id" value="">
          <input type="hidden" name="is_bayi">
          <input type="hidden" name="status_bayi">
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary btn-flat" onclick="savePulang()">Simpan</button>
      </div>
    </div>
  </div>
</div>

{{-- EDIT TANGGAL MASUK --}}
<div class="modal fade" id="tglMasukModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formUpdateTglMasuk" method="POST">
          {{ csrf_field() }} {{ method_field('POST') }}
          <div class="form-group">
            <label for="tanggal" class="col-md-4 control-label">Nama Pasien</label>
            <div class="col-md-8">
              <input type="text" name="nama" class="form-control" value="" readonly="true">
            </div>
          </div>
          <div class="form-group">
            <label for="tanggal" class="col-md-4 control-label">Tanggal Masuk</label>
            <div class="col-md-8">
              <input type="text" name="tanggalMasukSebelumnya" class="form-control" value="" readonly="true">
            </div>
          </div>
          <div class="form-group">
            <label for="tanggal" class="col-md-4 control-label">Ubah Tanggal Masuk</label>
            <div class="col-md-8">
              <input type="text" name="tanggalMasuk" class="form-control datepicker" value="">
            </div>
          </div>
          <input type="hidden" name="registrasi_id" value="">
        </form>
      </div>
      <div class="modal-footer">
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary btn-flat" onclick="simpanUpdateTanggal()">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(function () {

  $('#datas').DataTable({
    'language'    : {
      "url": "/json/pasien.datatable-language.json",
    },
    'paging'      : true,
    'lengthChange': false,
    'searching'   : true,
    'ordering'    : false,
    'info'        : true,
    'autoWidth'   : false
  });
  });
  $('.select2').select2({
    // placeholder: '[--]',
  });

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
        cetak4 = '<br/><a class="btn btn-warning btn-sm pull-right" target="_blank" href="/ranap-informasi-unit-rincian-biaya-tanpa-igd/'+registrasi_id+'"><span class="fa fa-print"></span> RB Tanpa IGD</a><br/>';
        cetak3 = '<a class="btn btn-danger btn-sm pull-right" style="margin-left:20px;" target="_blank" href="/ranap-informasi-unit-item-rincian-biaya-tanpa-rajal/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya(Klaim)</a>';
        $('.rincian_biaya').append(cetak3)
        $('.rincian_biaya').append(cetak)
        $('.rincian_biaya').append(cetak2)
        $('.rincian_biaya').append(cetak4)
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

  let bayi;

  function pulangkan(registrasi_id, bed_id, is_bayi) {
    bayi = is_bayi;
    $('#modalPulangkan').modal('show');
    $('input[name="is_bayi"]').val(bayi);
    $('#perinatologi').hide();
    $('#perinatologi_hidup').hide();
    $('#perinatologi_mati').hide();
    $('.modal-title').text('Yakin akan di pulangkan?');
    $('input[name="registrasi_id"]').val(registrasi_id);
    $('input[name="bed_id"]').val(bed_id);
    $('input[name="tanggal"]').val('{{ date("d-m-Y") }}');
    // $('input[name="statusPulang"]').val('')
    $('#statusPulang').val('').trigger('change');
    $('#rujukan').hide();
    $('#faskes').val('').trigger('change');
    $('#faskes_rs_rujukan').val('').trigger('change');
    $('input[name="alasanRujuk"]').val('').trigger('change');
  }

  function savePulang() {
    const tanggal = $('input[name="tanggal"]').val();
    const statusPulang = $('#statusPulang').val();
    const kondisiPulang = $('#kondisiPulang').val();
    
    if (!tanggal) {
      alert('Tanggal pulang wajib diisi!');
      return;
    }
    if (!statusPulang) {
      alert('Cara pulang wajib dipilih!');
      return;
    }
    if (!kondisiPulang) {
      alert('Kondisi saat pulang wajib dipilih!');
      return;
    }
    $.ajax({
      url: '/rawat-inap/pulang',
      type: 'POST',
      dataType: 'json',
      data: $('#formPulang').serialize(),
      success: function (data) {
        if (data.sukses == true) {
          $('#modalPulangkan').modal('hide')
          location.reload()
        }
      }
    });
  }

  function updateTgl(registrasi_id) {
    $('#tglMasukModal').modal('show')
    $('.modal-title').text('Ubah Tanggal Masuk')
    $('#formUpdateTglMasuk')[0].reset()
    $.ajax({
      url: '/detail-data-rawat-inap/' + registrasi_id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        $('input[name="nama"]').val(data.nama)
        $('input[name="tanggalMasukSebelumnya"]').val(data.tglMasuk)
        $('input[name="registrasi_id"]').val(registrasi_id)
      }
    });
  }

  function simpanUpdateTanggal() {
    var data = $('#formUpdateTglMasuk').serialize();
    $.ajax({
      url: '/update-tanggal-masuk-rawat-inap',
      type: 'POST',
      dataType: 'json',
      data: data,
      success: function (data) {
        if (data.sukses == true) {
          location.reload()
        } else {
          location.reload()
        }
      }
    });
  }

  function cariBatch() {
    var masterobat_id = $("select[name='masterobat_id']").val();
    $.get('/penjualan/get-obat-baru/' + masterobat_id, function (resp) {
      console.log(resp)
    })
  }

  $('#masterObat').select2({
    placeholder: "Klik untuk isi nama obat",
    width: '100%',
    ajax: {
      url: '/penjualan/resep/master-obat-baru/',
      dataType: 'json',
      data: function (params) {
        return {
          j: {
            // {
            //   % 24 reg - % 3 Ebayar
            // }
          },
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

  $(document).on('click', '.btn-add-resep', function () {
    let id = $(this).attr('data-id');
    $('input[name=uuid]').val('');
    $.ajax({
      url: '/rawat-inap/e-resep/show/' + id,
      type: 'GET',
      dataType: 'json',
      // data: $('#formPulang').serialize(),
      success: function (res) {
        // console.log(res);
        $('input[name="pasien_id"]').val(res.data.pasien.id)
        $('input[name="reg_id"]').val(res.data.id)
        $('input[name="no_rm"]').val(res.data.pasien.no_rm)
        $('input[name="nama"]').val(res.data.pasien.nama)
        $('#myModalAddResep').modal('show');
      }
    });
  })

  $(document).on('click', '.btn-history-resep', function () {
    let id = $(this).attr('data-id');
    $.ajax({
      url: '/rawat-inap/e-resep/history/' + id,
      type: 'GET',
      dataType: 'json',
      beforeSend: function () {
        $('#listHistoryResep').html('');
      },
      success: function (res) {
        $('#listHistoryResep').html(res.html);
        $('#myModalHistoryResep').modal('show');
      }
    });
  })

  $(document).on('click', '#btn-save-resep', function () {
    let body = {
      "uuid": $('input[name=uuid]').val(),
      "reg_id": $('input[name=reg_id]').val(),
      "pasien_id": $('input[name=pasien_id]').val(),
      "source": $('input[name=source]').val(),
      "masterobat_id": $('select[name=masterobat_id]').val(),
      "qty": $('input[name=qty]').val(),
      "cara_bayar": $('select[name=cara_bayar]').val(),
      "tiket": $('select[name=tiket]').val(),
      "cara_minum": $('select[name=cara_minum]').val(),
      "takaran": $('select[name=takaran]').val(),
      "informasi": $('input[name=informasi]').val(),
      "_token": $('input[name=_token]').val(),
    };
    $.ajax({
      url: '/rawat-inap/e-resep/save-detail',
      type: 'POST',
      dataType: 'json',
      data: body,
      success: function (res) {
        if (res.status == true) {
          $('input[name="uuid"]').val(res.uuid);
          $('#listResep').html(res.html);
          $('select[name="masterobat_id"]').val('');
          $('input[name="qty"]').val('');
        }
      }
    });
  })

  $(document).on('click', '.del-detail-resep', function () {
    let id = $(this).attr('data-id');
    let body = {
      "_token": $('input[name=_token]').val(),
    };
    $.ajax({
      url: '/rawat-inap/e-resep/detail/' + id + '/delete',
      type: 'DELETE',
      dataType: 'json',
      data: body,
      success: function (res) {
        if (res.status == true) {
          $('#listResep').html(res.html);
        }
      }
    });
  })

  $(document).on('click', '#btn-final-resep', function () {
    if (confirm('Yakin Akan Disimpan ?')) {
      let body = {
        "uuid": $('input[name=uuid]').val(),
        "_token": $('input[name=_token]').val(),
      };
      $.ajax({
        url: '/rawat-inap/e-resep/save-resep', 
        type: 'POST',
        dataType: 'json',
        data: body,
        success: function (res) {
          if (res.status == true) {
            location.reload();
          }
        }
      });
    }
  })

  $(document).on('change', 'select[name="statusPulang"]', function () {
    if (this.value == 4 && bayi != null) {
      $('#perinatologi').show();
      $('#perinatologi_mati').show();
      $('#perinatologi_hidup').hide();
      $('input[name="status_bayi"]').val('mati');
    } else if (this.value != 4 && bayi != null) {
      $('#perinatologi').show();
      $('#perinatologi_hidup').show();
      $('#perinatologi_mati').hide();
      $('input[name="status_bayi"]').val('hidup');
    } else {
      $('#perinatologi').hide();
      $('#perinatologi_hidup').hide();
      $('#perinatologi_mati').hide();
      $('input[name="status_bayi"]').val();
    }

    if (this.value == 2) { //dirujuk
      $('#rujukan').show();
      $('#faskes').val('').trigger('change');
      $('#faskes_rs_rujukan').val('').trigger('change');
    }else{
      $('#rujukan').hide();
    }
    
  })

  $(document).on('change', '#faskes', function () {
    var selectedValue = $(this).val();
    console.log(selectedValue);
    if(selectedValue != ''){
        $('#faskes_rs_rujukan').val('');

        $('#faskes_rs_rujukan').select2({
            placeholder: "Pilh Faskes RS Rujukan",
            width: '100%',
            ajax: {
                url: '/emr-soap/ajax-faskes-rs',
                dataType: 'json',
                data: function (params) {
                    return {
                        jenis_faskes: selectedValue
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
    }
  });

</script>

@endsection