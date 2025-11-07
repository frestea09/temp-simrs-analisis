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
        {!! Form::open(['method' => 'POST', 'url' => 'rawat-inap/cari-pasien', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-4">
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
              <button class="btn btn-default{{ $errors->has('nama') ? ' has-error' : '' }}" type="button">Nama Pasien</button>
              </span>
              @if (session('nama'))
                  
              {!! Form::text('nama', '', ['class' => 'form-control']) !!}
            
              @else
              {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                  
              @endif
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
              
                <th class="text-center" style="vertical-align: middle">No</th>
                <th class="text-center" style="vertical-align: middle">Tgl. Regis</th>
                <th class="text-center" style="vertical-align: middle">RM</th>
                <th class="text-center" style="vertical-align: middle">Pasien</th>
                <th class="text-center" style="vertical-align: middle">DPJP</th>
                <th class="text-center" style="vertical-align: middle">Usia</th>
                <th class="text-center" style="vertical-align: middle">Tgl.Lahir</th>
                <th class="text-center" style="vertical-align: middle">Kelas</th>
                <th class="text-center" style="vertical-align: middle">Kamar</th>
                <th class="text-center" style="vertical-align: middle">Bed</th>
                <th class="text-center" style="vertical-align: middle">Bayar</th>
                <th class="text-center" style="vertical-align: middle">Masuk</th>
                <th class="text-center" style="vertical-align: middle">Keluar</th>
                {{-- @if(@$status_reg == 'I2') --}}
                  <th class="text-center" style="vertical-align: middle">IBS</th>
                  {{-- <th class="text-center" style="vertical-align: middle">RIS</th> --}}
                  <th class="text-center" style="vertical-align: middle">MUT</th>
                  <th class="text-center" style="vertical-align: middle">PULANG</th>
                  <th class="text-center" style="vertical-align: middle">RB</th>
                  <th class="text-center" style="vertical-align: middle">Entry Tindakan</th>
                {{-- @endif --}}
                {{-- <th class="text-center" style="vertical-align: middle">CETAK</th> --}}
                <th class="text-center" style="vertical-align: middle">KONTROL</th>
              </tr>
            </thead>
            <tbody>
                @isset($reg)
                    @foreach ($reg as $key => $d)
                    @php
                        $reg = $d;
                        @$ranap = \App\Rawatinap::where('registrasi_id', $reg->id)->orderBy('id','DESC')->first();
                    @endphp
                        <tr>
                          <td>{{ @$key+1 }}</td>
                          <td>{{ date('d/m/Y',strtotime($reg->created_at)) }}</td>
                          <td>{{ @$reg->pasien->no_rm }}</td>
                          <td>{{ @$reg->pasien->nama }}</td>
                          <td>{{ baca_dokter(@$ranap->dokter_id) }}</td>
                          <td>{{ hitung_umur(@$reg->pasien->tgllahir) }}</td>
                          <td>{{ date("d-m-Y", strtotime(@$reg->pasien->tgllahir)) }}</td>
                          <td>{{ baca_kelas(@$ranap->kelas_id) }}</td>
                          <td>{{ baca_kamar(@$ranap->kamar_id) }}</td>
                          <td>{{ baca_bed(@$ranap->bed_id) }}</td>
                          <td>{{ baca_carabayar(@$reg->bayar) }}
                            {{ !empty(@$reg->tipe_jkn) ? ' - '.@$reg->tipe_jkn : '' }}
                          </td>
                          <td onclick="updateTgl({{ $reg->id }})">{{ @tanggal_eklaim(@$ranap->tgl_masuk) }}</td>
                          <td>{{ tanggal_eklaim($d->tgl_keluar) }}</td>
                          {{-- @if($d->status_reg == 'I2')  --}}
                            <td class="text-center">
                              <a href="{{ url('rawat-inap/ibs/'.@$reg->id) }}"
                                onclick="return confirm('Yakin akan di order ke IBS?')" class="btn btn-warning btn-sm btn-flat"><i
                                  class="fa fa-cut"></i></a>
                            </td> 
                            {{-- <td class="text-center">
                              <a href="{{ url('emr/ris/inap/'.@$reg->id.'?poli='.@$reg->poli_id.'&dpjp='.@$reg->dokter_id) }}"
                                onclick="return confirm('Yakin akan di order ke RIS?')" class="btn btn-info btn-sm btn-flat"><i
                                  class="fa fa-dashboard"></i></a>
                            </td>   --}}
                            <td class="text-center">
                              <a href="{{ url('rawat-inap/mutasi/'.@$reg->id) }}"
                                onclick="return confirm('Yakin akan di Mutasi?')" class="btn btn-success btn-sm btn-flat"><i
                                  class="fa fa-recycle"></i></a>
                            </td>
                            <td class="text-center">
                              @if(strpos($reg->pasien->nama, "BY") === FALSE)
                                <a class="btn btn-danger btn-sm btn-flat"
                                  onclick="pulangkan({{ @$reg->id }}, {{ @$ranap->bed_id }}, null)"><i class="fa fa-home"></i></a>
                              @else
                                <a class="btn btn-danger btn-sm btn-flat"
                                  onclick="pulangkan({{ @$reg->id }}, {{ @$ranap->bed_id }},'bayi')"><i class="fa fa-home"></i></a>
                              @endif
                            </td>
                            <td>
                              <button type="button"
                                onclick="rincianBiaya({{ @$reg->id }}, '{{ RemoveSpecialChar(@$reg->pasien->nama) }}', {{ @$reg->pasien->no_rm }}, '{{ @$reg->id }}' )"
                                class="btn btn-info btn-sm btn-flat"><i class="fa fa-search"></i></button>
                            </td>
                            <td class="text-center">
                              <a href="{{ url('rawat-inap/entry-tindakan/'.@$ranap->registrasi_id) }}"
                                class="btn btn-primary btn-sm btn-flat"><i class="fa fa-edit"></i> </a>
                            </td>
                          {{-- @endif --}}
                          <td class="text-center">
                            {{-- @if(@$reg->status_reg == 'I2') --}}
                              <a href="{{ url('resume-medis/inap/'.@$reg->id) }}"
                                class="btn btn-warning btn-flat btn-sm"><i class="fa fa-paste"></i></a>
                            {{-- @endif --}}
                            @if(count_resume(@$reg->id) > 0)
                              
                            @endif
                          </td>
                        </tr>
                      

                    @endforeach
                    
                @endisset
            </tbody>
          </table>
        </div>
        @isset($reg)
            
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