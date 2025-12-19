@extends('master')
@section('header')
  <h1>Cari Pasien Berdasarkan RM </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          {{-- Readmisi&nbsp; --}}
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'tindakan/cari-pasien', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-3">
          <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
            <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">Nomor RM</button>
            </span>
            @if (session('no_rm'))
                
            {!! Form::text('no_rm', '', ['class' => 'form-control']) !!}
            @else
            {!! Form::text('no_rm', null, ['class' => 'form-control']) !!}
                
            @endif
          </div>
          
          </div>
          <div class="col-md-4">
          <div class="input-group{{ $errors->has('nama') ? ' has-error' : '' }}">
            <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('nama') ? ' has-error' : '' }}" type="button">Nama</button>
            </span>
            {!! Form::text('nama', null, ['class' => 'form-control']) !!}
          </div>
          
          </div>
          <div class="col-md-4">
            <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI PASIEN">
          </div>
        </div>
      {!! Form::close() !!}
        <div class='table-responsive' style="font-size:12px">       
          <table class='table' id="">
            <thead>
              <tr>
                <th>No</th>
                <th>Panggil</th>
                <th>Pasien</th>
                <th>RM</th>
                <th>Usia</th>
                <th>Tgl.Lahir</th>
                <th>Dokter</th>
                <th>Poli</th>
                <th>Bayar</th>
                <th style="width:8%">Tgl.Reg</th>
                <th>Proses</th>
                <th class="text-center" style="vertical-align: middle">RB</th>
                <th>Kontrol</th>
                <th>SOAP</th>
                <th>Poli</th>
                <th>SPRI</th>
              </tr>
            </thead>
            <tbody>
              @if (isset($registrasi))
                  
                  @foreach ($registrasi as $key => $d)
          
                  @php
                    
                    $pasien = Modules\Pasien\Entities\Pasien::find($d->pasien_id);
                    $antrian_poli_order = @\App\AntrianPoli::where('histori_kunjungan_irj_id',$d->id_kunjungan)->first();
        
                  @endphp
                  <tr>
                    <td>
                      
                      
                      @if ($d->antrian_poli_id)
                        @if ($antrian_poli_order)
                        {{$antrian_poli_order->kelompok}}{{$antrian_poli_order->nomor}}
                        @else
                        {{ @\App\AntrianPoli::where('id',@$d->antrian_poli_id)->first()->kelompok }}{{ @\App\AntrianPoli::where('id',@$d->antrian_poli_id)->first()->nomor }}
                        @endif
        
                      @endif
                  </td>
                    <td>
                      @if ($d->antrian_poli_id)
                        @if ($antrian_poli_order)
                        <a href="{{ (($d->status) > 2) ? 'javascript:void(0)' : url('/antrian_poli/panggilkembali2/'.@$antrian_poli_order->nomor.'/'.@$antrian_poli_order->id.'/'.@$d->poli_id.'/'.$d->id)}}" {{ (($d->status) > 2) ? "disabled" : "" }} class="btn {{ (($d->status) > 2) ? 'btn-danger' : 'btn-info' }} btn-sm btn-flat"><i class="fa fa-microphone"></i></a>
                        @else
                        <a href="{{ (($d->status) > 2) ? 'javascript:void(0)' : url('/antrian_poli/panggilkembali2/'.@\App\AntrianPoli::where('id',@$d->antrian_poli_id)->first()->nomor.'/'.@$d->antrian_poli_id.'/'.@$d->poli_id.'/'.$d->id)}}" {{ (($d->status) > 2) ? "disabled" : "" }} class="btn {{ (($d->status) > 2) ? 'btn-danger' : 'btn-info' }} btn-sm btn-flat"><i class="fa fa-microphone"></i></a>
                        @endif
        
                      @endif
                    </td>
                    <td>{{ $pasien ? $pasien->nama : '' }}{!! $pasien->no_jkn ? '<br/>('.$pasien->no_jkn.')' : '' !!}</td>
                    <td>{{ $pasien ? $pasien->no_rm : '' }}</td>
                    <td>{{ hitung_umur(@$pasien->tgllahir) }}</td>
                    <td>{{ date("d-m-Y", strtotime(@$pasien->tgllahir)) }}</td>
                    <td>{{ (!empty($d->dokter_id)) ? baca_dokter(@$d->dokter_id) : NULL }}</td>
                    <td>
                      @if(cek_folio_counts($d->id, $d->poli_id) > 0)
                        {{ !empty($d->poli_id) ? $d->poli->nama : NULL }}
                      @else
                        <span style="color: red">{{ !empty($d->poli_id) ? $d->poli->nama : NULL }}</span></td>
                      @endif
                    <td>{{ baca_carabayar($d->bayar) }}
                      @if (!empty($d->tipe_jkn))
                        - {{ @$d->tipe_jkn }}
                      @endif
                    </td> 
                    <td>
                      {{ @$d->tgl_reg }} {!!$key == 0 ? '<b style="color:green">Terbaru</b>' :'' !!}
                    </td>
                    <td>
                      <a href="{{ url('tindakan/entry/'. @$d->id.'/'.@$d->pasien_id.'/'.@$d->id_kunjungan) }}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-edit"></i></a>
                    </td>
                    <td>
                      <button type="button"
                              onclick="rincianBiaya({{ @$d->id }}, '{{ RemoveSpecialChar(@$pasien->nama) }}', {{ @$pasien->no_rm }}, '{{ @$d->id }}' )"
                              class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i></button>
                    </td>
                    <td>
                      <a href="{{ url('resume-medis/jalan/'.$d->id) }}" class="btn btn-warning btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                    </td>           
                    <td class="text-center">
                      <a href="{{url('emr-soap/anamnesis/umum/jalan/'.@$d->id.'?poli='.@$d->poli_id.'&dpjp='.@$d->dokter_id)}}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                    </td>        
                    @php
        
                        $regist = Modules\Registrasi\Entities\Registrasi::find($d->id);
        
                        // dd(substr($regist->status_reg, 0, 1));
                    @endphp
        
                    @if ( (substr($regist->status_reg, 0, 1) == 'J'))
        
                    <!-- <td class="text-center">
                      <a href="{{url('emr-soap/anamnesis/umum/jalan/'.@$d->id.'?poli='.@$d->poli_id.'&dpjp='.@$d->dokter_id)}}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                    </td> -->
                    @elseif (substr($regist->status_reg, 0, 1) == 'I')
        
                    <td class="text-center">
                      <a href="{{url('emr-soap/anamnesis/umum/inap/'.$d->id.'?poli='.$poli.'&dpjp='.$dpjp)}}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                    </td>
        
                    @endif
        
                    <td>
                      <a onclick="loadModal('{{ url('tindakan/order-poli/'.$d->id.'/'.$d->pasien_id) }}')" class="btn btn-warning btn-flat btn-sm"><i class="fa fa-plus"></i></a>
                    </td>
                    <td class="text-center">
                      @if (cek_spri($d->id) >= 1)
                      <a href="{{ url('spri/cetak/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i></a> 
                      @else
                      <a href="{{ url('create-spri/'.$d->id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-bed"></i></a> 
                      {{-- <a class="btn btn-danger btn-sm btn-flat" onclick="suratPri({{ $d->id }})"><i class="fa fa-bed"></i></a> --}}
                      @endif
                    </td>
                    {{-- <td class="text-center">
                      <a href="{{ url('tindakan/cetak-gelang/'.$d->id) }}"  target="_blank" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-print"></i></a>
                    
                    </td> --}}
                  </tr>
              @endforeach
              @endif
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
        @isset($reg)
            
        
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
                    <label for="statusPulang" class="col-sm-3 control-label">Status Pulang</label>
                    <div class="col-sm-9">
                      <select name="statusPulang" class="form-control select2" style="width: 100%;">
                        <option value=""></option>
                        @foreach(\App\KondisiAkhirPasien::orderBy('urutan','ASC')->get() as $i)
                          <option value="{{ $i->id }}">{{ $i->namakondisi }}</option>
                        @endforeach
                      </select>
                      <small class="text-danger statusPulang"></small>
                    </div>
                  </div>
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
        @endisset
      </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
$(".skin-blue").addClass( "sidebar-collapse" );
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

  let bayi;

  function pulangkan(registrasi_id, bed_id, is_bayi) {
    bayi = is_bayi;
    $('#modalPulangkan').modal('show')
    $('input[name="is_bayi"]').val(bayi);
    $('#perinatologi').hide();
    $('#perinatologi_hidup').hide();
    $('#perinatologi_mati').hide();
    $('.modal-title').text('Yakin akan di pulangkan?')
    $('input[name="registrasi_id"]').val(registrasi_id)
    $('input[name="bed_id"]').val(bed_id)
    $('input[name="tanggal"]').val('{{ date("d-m-Y") }}')
    // $('input[name="statusPulang"]').val('')
  }

  function savePulang() {
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
  })
</script>
    
@endsection