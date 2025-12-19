@extends('master')

@section('header')
  <h1>Kasir Rawat Inap</h1>

@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Data Rekam Medis &nbsp;
      </h3>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-aqua-active" style="height: 200px;">
            <div class="row">
              <div class="col-md-2">
                <h3 class="widget-user-username">Nama</h3>
                <h5 class="widget-user-desc">No. RM</h5>
                <h5 class="widget-user-desc">Alamat</h5>
                <h5 class="widget-user-desc">Cara Bayar</h5>
                <h5 class="widget-user-desc">Tanggal Masuk</h5>
                <h5 class="widget-user-desc">Tanggal Keluar</h5>
                
              </div>
              <div class="col-md-7">
                <h3 class="widget-user-username">:{{ $pasien->nama}}</h3>
                <h5 class="widget-user-desc">: {{ $pasien->no_rm }}</h5>
                <h5 class="widget-user-desc">: {{ $pasien->alamat}}</h5>
                <h5 class="widget-user-desc">: {{ baca_carabayar($reg->bayar) }} {{ !empty($reg->tipe_jkn) ? ' - '.$reg->tipe_jkn : '' }}</h5>
                <h5 class="widget-user-desc">:{{ $rawatinap->tgl_masuk}}</h5>
                <h5 class="widget-user-desc">:{{ $rawatinap->tgl_keluar}}</h5>
              </div>
              <div class="col-md-3 text-center">
                <h3>Total Tagihan</h3>
                <h2 style="margin-top: -5px;">Rp. {{ number_format($tagihan+$uang_racik+$jasa_racik,0,',','.') }}</h2>
              </div>
            </div>


          </div>
          <div class="widget-user-image">

          </div>

        </div>
        <!-- Tagihan -->
    
        {{-- <div class="text-right">
          <button type="button" onclick="hapusTindakanSelect('{{ $reg->id }}')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
        </div> --}}
        <br>
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Tindakan</th>
                  <th>Pelayanan</th>
                  <th>Dokter Pelaksana</th>
                  <th>Klinik/Kamar</th>
                  <th>Total </th>
                  {{-- <th>Hapus </th> --}}
                </tr>
              </thead>
              <tbody>
                @foreach ($fol as $key => $d)
                  @php
                    $obat_uang_racik = 0;
                    $uang_jasa_racik = 0;
                    // $obat_uang_racik = \App\Penjualandetail::where('no_resep', $d->namatarif)->sum('uang_racik');
                    // $uang_jasa_racik = \Modules\Registrasi\Entities\Folio::where('namatarif', $d->namatarif)->sum('jasa_racik');
                  @endphp
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->namatarif }}</td>
                    <td>
                        @if ($d->jenis == 'TA')
                          Rawat Jalan
                        @elseif($d->jenis == 'TG')
                          Rawat Darurat
                        @else
                          Rawat Inap
                        @endif
                    </td>
                    <td>{{ !empty($d->dokter_pelaksana ) ? baca_dokter($d->dokter_pelaksana) : '' }}</td>
                    <td>
                      @if ($d->jenis == 'TA' OR $d->jenis == 'TG')
                        {{ baca_poli($d->poli_id) }}
                      @elseif($d->jenis == 'TI')
                        {{ baca_kamar($d->kamar_id) }}
                      @endif
                    </td>
                    <td>
                        @if ($d->jenis == 'ORJ')
                          {{ number_format($d->total+$obat_uang_racik+$uang_jasa_racik) }}
                        @else
                          {{ number_format($d->total) }}
                        @endif
                        
                    </td>
                    {{-- <td>
                      @role(['kasir', 'administrator'])
                        @if ($d->jenis != 'ORJ')
                          <input type="checkbox" name="delete[{{ $d->id }}]" data-id="{{$d->id}}" class="form-check-input delete-checkbox">
                        @endif
                      @endrole
                    </td> --}}
                  </tr>
                @endforeach
              </tbody>
                {!! Form::open(['method' => 'POST', 'url' => 'kasir/rawatinap/save_bayar_rawat_inap', 'class' => 'form-horizontal']) !!}
                {!! Form::hidden('totalbayar', $tagihan+$uang_racik+$jasa_racik) !!}
                {!! Form::hidden('registrasi_id', $reg->id) !!}
                {!! Form::hidden('status_reg', substr($reg->status_reg,0,1)) !!}
                <input type="hidden" name="total" id="total" value="{{ $tagihan+$uang_racik+$jasa_racik }}">
              <tfoot>
                <tr>
                  <th colspan="2" class="text-right">Total RS</th>
                  <th style="width: 15%"> {!! Form::text('total_tagihan', number_format($tagihan+$uang_racik+$jasa_racik), ['class' => 'form-control input-sm uang', 'readonly'=> true]) !!}</th>
                  <th class="text-right">Diskon Rp</th>
                  <th style="width: 15%"> {!! Form::text('diskon_rupiah', 0, ['class' => 'form-control input-sm uang', 'onkeyup'=>'hitungDiskonRupiah()']) !!}</th>
                </tr>
                <tr>
                  <th colspan="2" class="text-right">Uang Muka</th>
                  <th style="width: 15%"> {!! Form::text('uang_muka', 0, ['class' => 'form-control input-sm uang', 'onkeyup'=>'totalHarusBayar()']) !!}</th>
                  <th class="text-right">Diskon %</th>
                  <th style="width: 15%"> {!! Form::number('diskon_persen', 0, ['class' => 'form-control input-sm', 'onkeyup'=>'hitungDiskonPersen()']) !!}</th>
                </tr>
                <tr>
                  <th colspan="2" class="text-right">Harus Dibayar</th>
                  <th style="width: 15%"> {!! Form::text('harusBayar', number_format($tagihan+$uang_racik+$jasa_racik), ['class' => 'form-control input-sm uang', 'readonly'=>true]) !!}</th>
                  <th class="text-right">Dibayar</th>
                  <th style="width: 15%"> {!! Form::text('totalBayar', NULL, ['class' => 'form-control input-sm uang']) !!}</th>
                </tr>
                <tr>
                  <th colspan="4" class="text-right">Metode</th>
                  <th style="width: 15%"> 
                    <select name="metode_bayar_id" id="" class="form-control">
                      @foreach ($metode as $item)
                      <option value={{$item->id}}>{{$item->name}}</option>
                      @endforeach
                    </select>
                  </th>
                </tr>
                  <input type="hidden" name="jenis" value="tunai">

              </tfoot>
            </table>
          </div>
            <div class="btn-group pull-right">
              @if ($tagihan > 0)
                {!! Form::submit("BAYAR", ['id'=>'btnSave','class' => 'btn btn-success btn-flat', 'onclick'=>'javascript:return confirm("Yakin data sudah benar? Cek Sekali Lagi!")']) !!}  
              @endif
            </div>
            {!! Form::close() !!}
              <div class="pull-left">
                <a href="{{ URL::previous() }}" class="btn btn-info btn-flat"><i class="fa fa-step-backward"></i> Halaman Sebelumnya</a>
                <button type="button" class="btn btn-danger btn-flat" onclick="tambahTindakan('{{ $reg->id }}')">TAMBAH TINDAKAN</button>
              </div>

        </div>
      </div>
      {{-- <h4>Piutang</h4>
      <table class="table table-condensed table-bordered">
        <thead class="bg-red">
          <tr>
            <th>No</th>
            <th>No Kwitansi</th>
            <th>Tanggal Piutang</th>
            <th>Total Piutang</th>
            <th>Dibayar</th>
            <th colspan="2">Tanggal Dibayar</th>
          </tr>
        </thead>
        <tbody>
          @php
            $p = 1;
          @endphp
          @foreach ($piutang as $d)
            <tr>
              <td>{{ $p++ }}</td>
              <td>{{ $d->kwitansi_pembayaran }}</td>
              <td>{{ $d->created_at }}</td>
              <td>{{ number_format($d->total_piutang) }}</td>
              <td>{{ number_format($d->dibayar) }}</td>
              <td>{{ $d->tglbayar }}</td>
              <td>
                  @if ($d->dibayar == 0)
                      <button onclick="bayarPiutang('{{ $d->id }}')" class="btn btn-success btn-flat btn-sm"><i class="fa fa-dollar"></i> BAYAR</button>
                  @else
                      <a href="{{ url('/kasir/cetak/cetakkuitansi/'.$d->pembayaran_id) }}" target="_blank" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-file-pdf-o"></i> CETAK</a>
                  @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table> --}}
      <h4 style="margin-bottom: -30px; margin-top: 20px;">Histori Pembayaran</h4>
      <div class="table-responsive">
        <table class="table table-condensed table-bordered" id="histori">
          <thead class="bg-primary">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>No. Kuitansi</th>
              <th>Tagihan</th>
              <th>Diskon Rp</th>
              <th>Dsk %</th>
              <th>Harus Bayar</th>
              <th>Di Bayar</th>
              <th>Tgl Pembayaran</th>
              <th>Penerima</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php
              $h = 1;
            @endphp
            @foreach ( $histori as $d )
                <tr>
                  <td>{{ $h++ }}</td>
                  <td>{{ \Modules\Pasien\Entities\Pasien::find($d->pasien_id)->nama }}</td>
                  <td>{{ $d->no_kwitansi }}</td>
                  @if ($d->flag == 'Y')
                    <td>{{ number_format($d->total) }}</td>
                    <td>{{ number_format($d->diskon_rupiah) }}</td>
                    <td>{{ $d->diskon_persen }}</td>
                    <td>{{ number_format($d->hrs_bayar) }}</td>
                    <td>{{ number_format($d->dibayar) }}</td>
                  @else
                    <td style="font-style: initial;text-decoration: line-through;">{{ number_format($d->total) }}</td>
                    <td style="font-style: initial;text-decoration: line-through;">{{ number_format($d->diskon_rupiah) }}</td>
                    <td style="font-style: initial;text-decoration: line-through;">{{ $d->diskon_persen }}</td>
                    <td style="font-style: initial;text-decoration: line-through;">{{ number_format($d->hrs_bayar) }}</td>
                    <td style="font-style: initial;text-decoration: line-through;">{{ number_format($d->dibayar) }}</td>
                  @endif
                  <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                  <td>{{ \App\User::find($d->user_id)->name }} </td>
                  <td>
                    @if ($d->flag == 'Y')
                      @if (!empty($terbaru->no_kwitansi) && $terbaru->no_kwitansi == $d->no_kwitansi)
                        <button onclick="rincianPembayaran('{{ $d->no_kwitansi }}')" class="btn btn-success btn-flat btn-sm"><i class="fa fa-folder-open"></i>DETAIL</button>
                        <a href="{{ url('/kasir/save-batal-bayar/'.$d->registrasi_id.'/'.$d->no_kwitansi) }}" onclick="return confirm('Yakin akan dibatalkan?')" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-trash"></i> BATAL</a>  
                        <a href="{{ url('/kasir/cetak/cetakkuitansi/'.$d->id) }}" target="_blank" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-file-pdf-o"></i> CETAK</a>
                      @else
                        <a href="{{ url('/kasir/cetak/cetakkuitansi/'.$d->id) }}" target="_blank" class="btn btn-danger btn-flat btn-sm"><i
                            class="fa fa-file-pdf-o"></i> CETAK</a>
                      @endif
                    @else
                      <span class="text text-danger"><b> DIBATALKAN </b></span>
                    @endif
                  </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{--  //modal tambah tindakan  --}}
      <div class="modal fade" id="tambahTindakanModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <form method="POST" class="form-horizontal" id="formTindakan">
                <div class="row">
                  <div class="col-sm-12">
                    {{ csrf_field() }}
                    <div class="form-group namatarifGroup">
                      <label for="tagihan" class="col-sm-3 control-label">Nama Tarif</label>
                      <div class="col-sm-6">
                        <div class="selectTarifId">
                          <select name="tarif_id" class="form-control select2" style="width: 100%">
                          </select>
                        </div>
                        <input type="text" name="namatarif" class="form-control hidden">
                        <small class="text-danger namatarifError"></small>
                      </div>
                      <div class="col-sm-3">
                        <select name="jenisTarif" class="form-control select2" style="width: 100%">
                          <option value="1">Tarif</option>
                          <option value="2">Non Tarif</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group tarifTotalGroup besaranTarif hidden">
                      <label for="tagihan" class="col-sm-3 control-label">Besar Tarif</label>
                      <div class="col-sm-6">
                        <input type="text" name="tarifTotal" class="form-control uang">
                        <small class="text-danger tarifTotalError"></small>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="quantity" class="col-sm-3 control-label">Quantity</label>
                      <div class="col-sm-6">
                        <input name="qty" type="number" value="1" class="form-control" style="width: 100%">
                        <small class="text-danger quantityError"></small>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tagihan" class="col-sm-3 control-label">Perawat</label>
                      <div class="col-sm-6">
                        <select name="perawat" class="form-control select2" style="width: 100%">

                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tagihan" class="col-sm-3 control-label">Pelaksana</label>
                      <div class="col-sm-6">
                        <select name="pelaksana" class="form-control select2" style="width: 100%">

                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <input type="hidden" name="registrasi_id" value="">
                <input type="hidden" name="pasien_id" value="">
                <input type="hidden" name="cara_bayar_id" value="">
                <input type="hidden" name="dokter_id" value="">
                <input type="hidden" name="jenis_pasien" value="">
              </form>
              <p class="text-success messageSukses text-center" style="font-size: 14pt; font-weight: bold;">
              </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary btn-flat" onclick="save()">Simpan</button>
            </div>
          </div>
        </div>
      </div>
      {{--  //modal Rincian Bayar  --}}
      <div class="modal fade" id="rincianbayarModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <table class="table table-condensed table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Tarif</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody id="viewRincian">
                  
                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Keluar</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="piutangModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <table class="table">
                <thead>
                  <tr>
                    <th>No Kwitansi</th>
                    <th>Total Piutang</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <form method="POST" id="bayarPiutang">
                    {{ csrf_field() }}
                      <input type="hidden" name="id" value="">
                      <input type="hidden" name="registrasi_id" value="">
                      <input type="hidden" name="pasien_id" value="">
                      <input type="hidden" name="total_piutang" value="">
                      <input type="hidden" name="total_tagihan_hutang" class="form-control uang" value="">
                    <tr>
                      <td class="no-kwitansi"></td>
                      <td class="total"></td>
                      <td class="tanggal"></td>
                    </tr>
                    <tr>
                      <th class="text-right">Diskon Rp</th>
                      <th style="width: 15%"> {!! Form::text('diskon_rupiah_Utang', 0, ['class' => 'form-control input-sm uang', 'onkeyup'=>'hitungDiskonRupiahHutang()']) !!}</th>
                      <th class="text-right">Harus Dibayar</th>
                      <th style="width: 15%"> {!! Form::text('harusBayarUtang', 0, ['class' => 'form-control input-sm uang', 'readonly'=>true]) !!}</th>
                    </tr>
                    <tr>
                      <th class="text-right">Diskon %</th>
                      <th style="width: 15%"> {!! Form::number('diskon_persen_Utang', 0, ['class' => 'form-control input-sm', 'onkeyup'=>'hitungDiskonPersenHutang()']) !!}</th>
                      <th class="text-right">Bayar</th>
                      <td>
                        <input type="text" name="total" onkeyup="cekBayar()" class="form-control uang">
                      </td>
                      <td>
                        <button type="button" class="btn btn-primary btn-sm btn-flat" onclick="saveBayarPiutang()">Bayar</button>
                      </td>
                    </tr>
                     <tr>
                      <th colspan="4" class="text-right">Metode</th>
                      <th style="width: 15%"> 
                        <select name="metode_bayar_id" id="" class="form-control">
                          @foreach ($metode as $item)
                          <option value={{$item->id}}>{{$item->name}}</option>
                          @endforeach
                        </select>
                      </th>
                    </tr>
                  </form>
                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Keluar</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="hapusModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <table class="table">
                <thead>
                  <form method="POST" id="hapusTindakan">
                    {{ csrf_field() }}
                      <input type="hidden" name="id" value="">
                      <input type="hidden" name="registrasi_id" value="">
                      <input type="hidden" name="tarif_id" value="">
                      <input type="hidden" name="pasien" value="">
                    <tr>
                      <th class="text-right">Tindakan</th>
                      <th> 
                        <input class="form-control" type="text" name="nama_tindakan" value="" style="width: 75%" readonly>
                      </th>
                    </tr>
                    <tr>
                      <th class="text-right">Alasan</th>
                      <th> 
                        <textarea name="alasan" style="width: 565px; height: 110px;"></textarea>
                      </th>
                    </tr>
                    <tr>
                       <th class="text-right"></th>
                      <th>
                        <small class="text-danger">
                          (*) Apakah Benar Tindakan Tindakan ini Akan Dihapus
                        </small>
                      </th>
                    </tr>
                  </form>
                </thead>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Keluar</button>
              <button type="button" class="btn btn-info btn-flat" onclick="simpanHapus()">Simpan</button>
            </div>
          </div>
        </div>
      </div>

@endsection

@section('script')

  <script type="text/javascript">
    $('form').submit(function() {
        $('#btnSave').prop('disabled',true);
    });
    function hapus(id,registrasi_id){
      // alert(registrasi_id);
      $('#hapusModal').modal({
        backdrop : 'static',
        keyboard : false,
      })
      $('.modal-title').text('Hapus Tindakan')
      
      $.get('/kasir/hapus-tindakan-kasir/'+id+'/'+registrasi_id, function(data){
        $('#hapusTindakan')[0].reset()
        $('input[name="nama_tindakan"]').val(data.namatarif)
        $('input[name="tarif_id"]').val(data.tarif_id)
        $('input[name="registrasi_id"]').val(data.registrasi_id)
        $('input[name="id"]').val(data.id)
        $('input[name="pasien"]').val(data.pasien_id)
      });
    }

    function simpanHapus(){
      if(confirm('Yakin transaksi ini akan disimpan ?')){
        var data = $('#hapusTindakan').serialize()
        
        $.post('/kasir/simpan-hapus-tindakan-kasir', data, function(resp){
          if (resp.sukses == true){
            $('#hapusTindakan')[0].reset()
            location.reload()
          }
          if (resp.sukses == false){
            alert('Alasan Mohon Diisi!');
          }  
        })
      }
    }

    $('.select2').select2()
    $('#histori').DataTable({
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

    $('select[name="jenisTarif"]').on('change', function(e) {
      e.preventDefault();
      if ($(this).val() == 1) {
        $('.selectTarifId').removeClass('hidden')
        $('input[name="namatarif"]').addClass('hidden')
        $('.besaranTarif').addClass('hidden')
      } else if ($(this).val() == 2) {
        $('.selectTarifId').addClass('hidden')
        $('input[name="namatarif"]').removeClass('hidden')
        $('.besaranTarif').removeClass('hidden')
      }
    });

    function bayarPiutang(id){
      $('#piutangModal').modal({
        backdrop : 'static',
        keyboard : false,
      })
      $('.modal-title').text('Pembayaran Piutang')
      
      $.get('/kasir/get-rincian-piutang/'+id, function(data){
         $('.no-kwitansi').text(data.kwitansi_pembayaran) 
         $('.total').text(ribuan(data.total_piutang)) 
         $('.tanggal').text(data.created_at) 
         $('input[name="id"]').val(data.id)
         $('input[name="registrasi_id"]').val(data.registrasi_id)
         $('input[name="pasien_id"]').val(data.pasien_id)
         $('input[name="total_piutang"]').val(data.total_piutang)
         $('input[name="total_tagihan_hutang"]').val(ribuan(data.total_piutang))
         $('input[name="harusBayarUtang"]').val(ribuan(data.total_piutang))
         $('input[name="total"]').val(ribuan(data.total_piutang))

      });
    }

    function saveBayarPiutang(){
      var data = $('#bayarPiutang').serialize()
      
      $.post('/kasir/bayar-piutang', data, function(resp){
        if (resp.sukses == true){
          $('#bayarPiutang')[0].reset()
          location.reload()
        }  
      })
    }

    function rincianPembayaran(no_kwitansi){
      $('#rincianbayarModal').modal({
        backdrop : 'static', 
        keyboard :false,
      })
      $('.modal-title').text('Detail Pembayaran')
      
      $.ajax({
        url: '/kasir/get-rincian-pembayaran/'+no_kwitansi,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('#viewRincian').empty()
        $.each(data.folio,function(index, val){
          $('#viewRincian').append('<tr> <td>'+(index+1)+'</td> <td>'+ val.namatarif+'</td> <td>'+ribuan(val.total)+'</td> </tr>')
        })

      });
    }

    function tambahTindakan(registrasi_id) {
      $('#tambahTindakanModal').modal('show')
      $('.modal-title').text('Tambah Pembiayaan')
      $('select[name="jenisTarif"]').val(1)
      //GET REGISTER
      $.ajax({
        url: '/kasir/get-register/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('input[name="registrasi_id"]').val(registrasi_id)
        $('input[name="pasien_id"]').val(data.reg.pasien_id)
        $('input[name="cara_bayar_id"]').val(data.reg.bayar)
        $('input[name="dokter_id"]').val(data.reg.dokter_id)
        $('input[name="jenis_pasien"]').val(data.reg.jenis_pasien)
      });

      //GET TARIF
      $.ajax({
        url: '/kasir/get-tarif',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $.each(data.tarif, function(index, val) {
           $('select[name="tarif_id"]').append('<option value="'+val.id+'">'+val.nama+' => '+ ribuan(val.total) +'</option>')
        });
      });
      //GET PELAKSANA
      $.ajax({
        url: '/kasir/get-pelaksana',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $.each(data.pelaksana, function(index, val) {
           $('select[name="pelaksana"]').append('<option value=""></option>','<option value="'+val.id+'">'+val.nama+'</option>')
        });
      });


      //GET PERAWAT
      $.ajax({
        url: '/kasir/get-perawat',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $.each(data.perawat, function(index, val) {
           $('select[name="perawat"]').append('<option value=""></option>','<option value="'+val.id+'">'+val.nama+'</option>')
        });
      });

    }

    function save() {
      var data = $('#formTindakan').serialize()
      $.ajax({
        url: '/kasir/save-biaya-tambahan',
        type: 'POST',
        dataType: 'json',
        data: data,
      })
      .done(function(data) {
        $('.namatarifGroup').removeClass('has-error');
        $('.tarifTotalGroup').removeClass('has-error');
        $('.quantityGroup').removeClass('has-error');
        $('#formTindakan')[0].reset();
        if (data.sukses == true) {
          $('.messageSukses').text('Biaya lain-lain berhasil ditambahkan')
          $('.messageSukses').append('<br /><button type="button" class="btn btn-success" onclick="closeModalBiaya()"> OK </button>')
        }
      })
      .fail(function (resp) {
        if (resp.status === 422) {
          var data = resp.responseJSON
          if (data.errors.qty) {
            $('.quantityGroup').addClass('has-error');
            $('.quantityError').html(data.errors.qty[0]);
          }
          if (data.errors.namatarif) {
            $('.namatarifGroup').addClass('has-error');
            $('.namatarifError').html(data.errors.namatarif[0]);
          }
          if (data.errors.tarifTotal) {
            $('.tarifTotalGroup').addClass('has-error');
            $('.tarifTotalError').html(data.errors.tarifTotal[0]);
          }
        }
      });

    }

    function closeModalBiaya() {
      $('#tambahTindakanModal').modal('show')
      location.reload()
    }


//=======================================================================================================================================
    $('input[name="totalBayar"]').val('{{ number_format($tagihan+$uang_racik+$jasa_racik) }}')
    // Currency
    $('.uang').maskNumber({
      thousands: ',',
      integer: true,
    });

    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function hitungDiskonRupiah() {
      var total_tagihan = $('input[name="total_tagihan"]').val();
      var diskon_rupiah = $('input[name="diskon_rupiah"]').val();
      var totalTagihan  = parseInt( total_tagihan.split(',').join("") );
      var diskonRupiah  = parseInt( diskon_rupiah.split(',').join("") );
      var totalBayar    = Math.round(totalTagihan - diskonRupiah);
      var persen        = Math.round((diskonRupiah / totalTagihan)*100);
      $('input[name="totalBayar"]').val(ribuan(totalBayar));
      $('input[name="diskon_persen"]').val(persen);
      $('input[name="harusBayar"]').val(ribuan(totalBayar));
    }

    function hitungDiskonPersen(){
      var total_tagihan = $('input[name="total_tagihan"]').val();
      var diskon_rupiah = $('input[name="diskon_persen"]').val();
      var totalTagihan  = parseInt( total_tagihan.split(',').join("") );
      var diskonPersen  = Math.round((diskon_rupiah / 100) * totalTagihan);
      var totalBayar    = Math.round(totalTagihan - diskonPersen);
      $('input[name="totalBayar"]').val(ribuan(totalBayar));
      $('input[name="diskon_rupiah"]').val(ribuan(diskonPersen));
      $('input[name="harusBayar"]').val(ribuan(totalBayar));
    }

    function totalHarusBayar()
    {
      var inacbg = $('input[name="inacbg"]').val();
      var iur = $('input[name="iur"]').val();
      var totalinacbg = parseInt( inacbg.split(',').join("") );
      var dijamin = parseInt( iur.split(',').join("") );
      var totalBayar = totalinacbg - dijamin;
      $('input[name="totalBayar"]').val(ribuan(totalBayar));
    }

    function hitungDiskonRupiahHutang() {
      var total_tagihan = $('input[name="total_tagihan_hutang"]').val();
      var diskon_rupiah = $('input[name="diskon_rupiah_Utang"]').val();
      var totalTagihan  = parseInt( total_tagihan.split(',').join("") );
      var diskonRupiah  = parseInt( diskon_rupiah.split(',').join("") );
      var totalBayar    = Math.round(totalTagihan - diskonRupiah);
      var persen        = Math.round((diskonRupiah / totalTagihan)*100);
      $('input[name="diskon_persen_Utang"]').val(persen);
      $('input[name="harusBayarUtang"]').val(ribuan(totalBayar));
      $('input[name="total"]').val(ribuan(totalBayar));
    }

    function hitungDiskonPersenHutang(){
      var total_tagihan = $('input[name="total_tagihan_hutang"]').val();
      var diskon_rupiah = $('input[name="diskon_persen_Utang"]').val();
      var totalTagihan  = parseInt( total_tagihan.split(',').join("") );
      var diskonPersen  = Math.round((diskon_rupiah / 100) * totalTagihan);
      var totalBayar    = Math.round(totalTagihan - diskonPersen);
      $('input[name="diskon_rupiah_Utang"]').val(ribuan(diskonPersen));
      $('input[name="harusBayarUtang"]').val(ribuan(totalBayar));
      $('input[name="total"]').val(ribuan(totalBayar));
    }

    function cekBayar(){
      
      var dibayar = $('input[name="total"]').val();
      var harus_bayar = $('input[name="harusBayarUtang"]').val();
      var totalBayar  = parseInt( dibayar.split(',').join("") );
      var totalHarusBayar  = parseInt( harus_bayar.split(',').join("") );

      if(totalBayar > totalHarusBayar){
        alert('Input Anda Terlalu Besar!');
      }
    }
    
    function hapusTindakanSelect(regId){
      let idFolioArr = [];

      $('.delete-checkbox:checked').each(function(){
        idFolioArr.push($(this).attr('data-id'));
      })

      if(idFolioArr.length <= 0){
        alert('Silahkan Pilih Tindakan Yang ingin diHapus Terlebih Dahulu');
      }else{
        if(confirm('Apakah Yakin Ingin Menghapus Tindakan Ini ?')){
          let strIdFolio = idFolioArr.join(', ');
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            type: 'POST',
            url: '/kasir/hapus-tindakan-select',
            data:{
              'idFolio': strIdFolio,
              'idReg': regId,
            },
            success: function(response){
              if(response.success == true){
                alert(response.message);
                location.reload();
              }
            } 
          });
        }
      }
    }
  </script>
@endsection
