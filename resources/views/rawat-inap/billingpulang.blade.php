@extends('master')
@section('header')
<h1>Sistem Rawat Inap <small></small></h1>
@endsection

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h4>Periode Tanggal :</h4>
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/billing-filter-new-pulang', 'class'=>'form-horizontal']) !!}
    <input type="hidden" name="jenis_reg" value="I3">
    <div class="row mt-5">
        <div class="col-md-3">
          <div class="input-group{{ $errors->has('tga') ? ' has-error' : '' }}">
              <span class="input-group-btn">
                <button class="btn btn-default{{ $errors->has('tga') ? ' has-error' : '' }}" type="button">Tanggal</button>
              </span>
              {!! Form::text('tga', null, ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
              <small class="text-danger">{{ $errors->first('tga') }}</small>
          </div>
        </div>

        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Sampai Tanggal</button>
            </span>
              {!! Form::text('tgb', null, ['class' => 'form-control datepicker', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete' => 'off']) !!}
          </div>
        </div> 
        <div class="col-md-3">
          <div class="input-group">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">No RM</button>
            </span>
              {!! Form::text('no_rm', null, ['class' => 'form-control', 'required' => 'required', 'onchange'=>'this.form.submit()', 'autocomplete' => 'off']) !!}
          </div>
        </div> 
      <div class="col-md-3">
        <div class="input-group">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">Kelompok</button>
          </span>
          <select name="kelompok_kelas" class="form-control select2" onchange="this.form.submit()" id="">
              <option value=""> --Semua-- </option>
              @foreach ($kelompok_kelas as $key => $item)
              <option value="{{ $item }}" {{$item == @$kelas_selected ? 'selected' :''}}>{{ $item }}</option>
              @endforeach
          </select>
        </div>
      </div>
    </div>
    {!! Form::close() !!}
    <hr>
    @if($inap->count() > 0)
      <span><b>Keterangan:</b></span><br>
      <ul>
        <li>Baris berwarna hijau, artinya sudah selesai dibilling</li>
        <li>Klik tombol <button class="btn btn-success btn-sm" type="button">
          <span class="fa fa-check"></span>
        </button> untuk menandai selesai dibilling</li>
      </ul>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th class="text-center" style="vertical-align: middle">No</th>
              <th class="text-center" style="vertical-align: middle">RM</th>
              <th class="text-center" style="vertical-align: middle">Pasien</th>
              <th class="text-center" style="vertical-align: middle">Usia</th>
              <th class="text-center" style="vertical-align: middle">Tgl.Lahir</th>
              <th class="text-center" style="vertical-align: middle">Kelas</th>
              <th class="text-center" style="vertical-align: middle">Kamar</th>
              <th class="text-center" style="vertical-align: middle">Bed</th>
              <th class="text-center" style="vertical-align: middle">Bayar</th>
              <th class="text-center" style="vertical-align: middle">Masuk</th>
              <th class="text-center" style="vertical-align: middle">Keluar</th>
              @if($status_reg == 'I3')
                <th class="text-center" style="vertical-align: middle">Mutasi</th>
                <th class="text-center" style="vertical-align: middle">RB</th>
                <th class="text-center" style="vertical-align: middle">Entry Tindakan</th>
              @endif
              <th class="text-center" style="vertical-align: middle">Cetak Konsul</th>
              <th class="text-center" style="vertical-align: middle">KONTROL</th>
              <th class="text-center" style="vertical-align: middle">Selesai Billing</th>
              <th class="text-center" style="vertical-align: middle">SPRI Manual</th>
            </tr>
          </thead>
          <tbody>
            @foreach($inap as $key => $d)
              @php
            //   dd($d);
                // $reg = Modules\Registrasi\Entities\Registrasi::where('id', $d->registrasi_id)->first();
                $reg = $d->registrasi;
              @endphp
              <tr style="background-color: {{!empty($d->selesai_billing) ? 'rgb(173, 255, 173)' : 'transparent'}};">
                <td>{{ @$no++ }}</td>
                <td>{{ @$reg->pasien->no_rm }}</td>
                <td>{{ @$reg->pasien->nama }}</td>
                <td>{{ hitung_umur(@$reg->pasien->tgllahir) }}</td>
                <td>{{ date("d-m-Y", strtotime(@$reg->pasien->tgllahir)) }}</td>
                <td>{{ baca_kelas(@$d->kelas_id) }}</td>
                <td>{{ baca_kamar(@$d->kamar_id) }}</td>
                <td>{{ baca_bed(@$d->bed_id) }}</td>
                <td>{{ baca_carabayar(@$reg->bayar) }}
                  {{ !empty(@$reg->tipe_jkn) ? ' - '.@$reg->tipe_jkn : '' }}
                </td>
                <td onclick="updateTgl({{ $d->registrasi_id }})">{{ date('d/m/Y H:i',strtotime($d->tgl_masuk) )}}</td>
                <td>{{  date('d/m/Y H:i',strtotime($d->tgl_keluar)) }}</td>
                @if($reg->status_reg == 'I3')
                  {{-- <td class="text-center">
                    <button type="button" class="btn btn-primary btn-sm btn-flat btn-add-resep"
                      data-id="{{ $reg->id }}"><i class="fa fa-address-card-o" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-warning btn-sm btn-flat btn-history-resep"
                      data-id="{{ $reg->id }}"><i class="fa fa-bars" aria-hidden="true"></i></button>
                  </td> --}}
                  {{-- <td class="text-center">
                    <div class="btn-lebar">
                      <a href="{{ url('rawat-inap/laboratorium/'.@$reg->id) }}"
                        onclick="return confirm('Yakin akan di order ke LAB?')"
                        class="btn btn-success btn-sm btn-flat"><i class="fa fa-flask"> </i></a>
                      @if(cek_hasil_lab(@$reg->id) >= 1)
                        <a href="{{ url('pemeriksaanlab/pasien/'.@$reg->id) }}"
                          class="btn btn-sm btn-danger btn-flat"><i class="fa fa fa-eye"></i></a>
                      @endif
                    </div>
                  </td> --}}
                  {{-- <td class="text-center">
                    <div class="btn-lebar">
                      <a href="{{ url('rawat-inap/radiologi/'.@$reg->id) }}"
                        onclick="return confirm('Yakin akan di order ke RADIOLOGI?')"
                        class="btn btn-primary btn-sm btn-flat"><i class="fa fa-television"> </i></a>
                      @if(cek_ekspertise(@$reg->id) >= 1)
                        <a href="{{ url('radiologi/ekspertise-pasien/'.@$reg->id) }}"
                          class="btn btn-sm btn-danger btn-flat"><i class="fa fa fa-eye"></i></a>
                      @endif
                    </div>

                  </td> --}}
                  {{--<td class="text-center">
                    <a href="{{ url('rawat-inap/ibs/'.@$reg->id) }}"
                      onclick="return confirm('Yakin akan di order ke IBS?')" class="btn btn-warning btn-sm btn-flat"><i
                        class="fa fa-cut"></i></a>
                  </td> 
                  <td class="text-center">
                    <a href="{{ url('emr/ris/inap/'.@$reg->id.'?poli='.@$reg->poli_id.'&dpjp='.@$reg->dokter_id) }}"
                      onclick="return confirm('Yakin akan di order ke RIS?')" class="btn btn-info btn-sm btn-flat"><i
                        class="fa fa-dashboard"></i></a>
                  </td> --}}
                  {{-- <td class="text-center">
                    <a href="{{ url('emr/inap/'.@$reg->id.'?poli='.@$reg->poli_id.'&dpjp='.@$d->dokter_id) }}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                  </td> --}}
                  <td class="text-center">
                    <a href="{{ url('rawat-inap/mutasi/'.@$reg->id) }}"
                      onclick="return confirm('Yakin akan di Mutasi?')" class="btn btn-success btn-sm btn-flat"><i
                        class="fa fa-recycle"></i></a>
                  </td>
                  <td>
                    <button type="button"
                      onclick="rincianBiaya({{ @$reg->id }}, '{{ RemoveSpecialChar(@$reg->pasien->nama) }}', {{ @$reg->pasien->no_rm }}, '{{ @$reg->id }}' )"
                      class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i></button>
                  </td>
                  <td class="text-center">
                    <a href="{{ url('rawat-inap/entry-tindakan/'.@$d->registrasi_id) }}"
                      class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i> </a>
                  </td>
                  {{-- <td class="text-center">
                    <a href="{{ url('rawat-inap/ppi/'.$reg->pasien_id) }}"
                      class="btn btn-default btn-sm btn-flat"><i class="fa fa-pencil"> </i></a>
                  </td> --}}
                @endif
                {{--<td class="text-center">
                  <a href="{{ url('rawat-inap/cetak-rincian/'.$d->registrasi_id) }}"
                    target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-file-pdf-o"></i></a>
                </td>--}}
                <td>
                  @if (@$d->konsulJawabId)
                    <a id="btn-cetakKonsul" href="#modalCetakKonsul{{ @$d->id }}" class="btn btn-warning btn-sm" data-toggle="modal" data-id="{{ @$d->konsulJawabId }}"><i class="fa fa-print"></i></a>
                  @else
                    <span><i>belum ada</i></span>
                  @endif
                </td>
                <td class="text-center">
                  @if(@$reg->status_reg == 'I3')
                    <a href="{{ url('resume-medis/inap/'.@$d->registrasi_id) }}"
                      class="btn btn-warning btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                  @endif
                  @if(count_resume(@$d->registrasi_id) > 0)
                    {{-- <a href="{{ url('cetak-resume-medis/'.$d->registrasi_id) }}"
                    target="_blank" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-print"></i></a> --}}
                  @endif
                </td>
                <td>
                  @if (empty($d->selesai_billing))
                    <button class="btn btn-success btn-md" onclick="selesaiBilling({{ @$d->registrasi_id }})">
                      <span class="fa fa-check"></span>
                    </button>
                  @else
                    <i style="color: rgb(31, 195, 31);"><b>SELESAI</b></i>
                  @endif
                </td>
                <td class="text-center">
                  <a href="{{ url('create-spri-manual/'.@$reg->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-bed"></i></a> 
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
    $('#modalRincianBiaya').modal('show');
    $('.modal-title').text(nama + ' | ' + no_rm + '|' + registrasi_id)
    $('.tagihan').empty();
    $('.rincian_biaya').empty();
    $.ajax({
      url: '/informasi-rincian-biaya/' + registrasi_id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        cetak = '<a class="btn btn-info btn-sm pull-right" style="margin-left:20px;" target="_blank" href="/ranap-informasi-rincian-biaya/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya</a>';
        cetak2 = '<a class="btn btn-success btn-sm pull-right" target="_blank" href="/ranap-informasi-unit-rincian-biaya-tanpa-rajal/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya Unit Tanpa Rajal</a>';
        cetak3 = '<a class="btn btn-danger btn-sm pull-right" style="margin-left:20px;" target="_blank" href="/ranap-informasi-unit-item-rincian-biaya-tanpa-rajal/'+registrasi_id+'"><span class="fa fa-print"></span> Rincian Biaya(Klaim)</a>';
        $('.rincian_biaya').append(cetak3)
        $('.rincian_biaya').append(cetak)
        $('.rincian_biaya').append(cetak2)

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
  })

  function selesaiBilling(reg_id){
    $.ajax({
      url: '/rawat-inap/selesai-billing/' + reg_id,
      type: 'GET',
      dataType: 'json',
      success: function (res) {
        if(res.code){
          alert(res.message);
          location.reload();
        }
      }
    });
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