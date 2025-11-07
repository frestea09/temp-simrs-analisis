@extends('master')

@section('header')
  @if (substr($reg->status_reg,0,1) == 'G')
    <h1>Kasir Rawat Darurat</h1>
  @else
    <h1>Kasir Rawat Jalan</h1>
  @endif

@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      {{-- <h3 class="box-title">
        Data Rekam Medis &nbsp;
      </h3> --}}
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-aqua-active"  style="height: 140px;">
            <div class="row">
              <div class="col-md-2">
                <h3 class="widget-user-username">Nama</h3>
                <h5 class="widget-user-desc">No. RM</h5>
                <h5 class="widget-user-desc">Alamat</h5>
                <h5 class="widget-user-desc">Cara Bayar</h5>
              </div>
              <div class="col-md-7">
                <h3 class="widget-user-username">:{{ $pasien->nama}}</h3>
                <h5 class="widget-user-desc">: {{ $pasien->no_rm }}</h5>
                <h5 class="widget-user-desc">: {{ $pasien->alamat}}</h5>
                <h5 class="widget-user-desc">: {{ baca_carabayar($reg->bayar) }} {{ (!empty($reg->tipe_jkn) && $reg->bayar == 1) ? ' - '.$reg->tipe_jkn : '' }}</h5>
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
        {{-- @if ($reg->bayar == 1)
          <h4>Data Bridging E-Klaim</h4>
          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No. Kartu</th>
                  <th>No. SEP</th>
                  <th>Kode Grouper</th>
                  <th>Dijamin</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{ (!empty($eklaim->no_kartu)) ? $eklaim->no_kartu : '' }}</td>
                  <td>{{ (!empty($eklaim->no_sep)) ? $eklaim->no_sep : '' }}</td>
                  <td>{{ (!empty($eklaim->kode)) ? $eklaim->kode : '' }}</td>
                  <td>{{ (!empty($eklaim->dijamin)) ? 'Rp. '.number_format($eklaim->dijamin) : '' }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <hr>
        @endif --}}

          <div class='table-responsive'>
            <table class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Tindakan</th>
                  <th>Nama Dokter</th>
                  <th>Pelayanan</th>
                  <th class="text-center">Total </th>
                  <th>Hapus </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($fol as $key => $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->namatarif }} </td>
                    <td>{{ baca_dokter($d->dokter_id) }}</td>
                    <td>{{ $d->poli->nama }}</td>
                    <td>
                        {{ number_format($d->total+$obat+$jasa_racik) }}
                    </td>
                    <td>
                      {{-- @role('administrator') --}}
                      <button type="button" onclick="hapus('{{ $d->id }}','{{ $reg->id }}')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                      {{-- @endrole --}}
                    </td>
                  </tr>
                @endforeach
              </tbody>
                {!! Form::open(['method' => 'POST', 'route' => 'kasir-obat.save_bayar_rawat_jalan', 'class' => 'form-horizontal']) !!}
                {!! Form::hidden('totalbayar', $tagihan+$uang_racik+$jasa_racik) !!}
                {!! Form::hidden('registrasi_id', $reg->id) !!}
                {!! Form::hidden('status_reg', substr($reg->status_reg,0,1)) !!}
                <input type="hidden" name="total" id="total" value="{{ $tagihan+$uang_racik+$jasa_racik }}">
                @php
                  if ($reg->bayar == '2') {
                    $def = 'tunai';
                  }else {
                    $def = 'piutang';
                  }
                @endphp
                <tfoot>
                <tr>
                  <th colspan="4" class="text-right">Total Tagihan</th>
                  <th style="width: 15%"> {!! Form::text('total_tagihan', number_format($tagihan+$uang_racik+$jasa_racik), ['class' => 'form-control input-sm uang']) !!}</th>
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
                <tr>
                  <th colspan="4" class="text-right">Diskon Rp</th>
                  <th style="width: 15%"> {!! Form::text('diskon_rupiah', 0, ['class' => 'form-control input-sm uang', 'onkeyup'=>'hitungDiskonRupiah()']) !!}</th>
                </tr>
                <tr>
                  <th colspan="4" class="text-right">Diskon %</th>
                  <th style="width: 15%"> {!! Form::number('diskon_persen', 0, ['class' => 'form-control input-sm', 'onkeyup'=>'hitungDiskonPersen()']) !!}</th>
                </tr>
                <tr>
                  <th colspan="4" class="text-right">IUR Bayar</th>
                  <th style="width: 15%"> {!! Form::text('iur', NULL, ['class' => 'form-control input-sm uang', 'onkeyup'=>'totalHarusBayar()']) !!}</th>
                </tr>
                <tr>
                  <th colspan="4" class="text-right">Total Bayar</th>
                  <th style="width: 15%"> 
                  <input class="form-control input-sm uang" type="text" name="totalBayar">
                  {{-- {!! Form::text('totalBayar', NULL, ['class' => 'form-control input-sm uang']) !!} --}}
                  </th>
                </tr>
                  @php
                    if ($reg->bayar == '2') {
                        $def = 'tunai';
                    }else {
                        $def = 'piutang';
                    }
                  @endphp
                  <input type="hidden" name="jenis" value="{{ $def }}">

              </tfoot>
            </table>
          </div>
                <div class="btn-group pull-right">
                  @if ($reg->bayar == '2')
                    {!! Form::submit("Bayar", ['class' => 'btn btn-success btn-flat','id'=>'btnSave', 'onclick'=>'javascript:return confirm("Yakin data sudah benar? Cek Sekali Lagi!")']) !!}
                  @else
                    {!! Form::submit("Tutup Transaksi", ['class' => 'btn btn-success btn-flat','id'=>'btnSave', 'onclick'=>'javascript:return confirm("Yakin data sudah benar? Cek Sekali Lagi!")']) !!}
                  @endif
                </div>
            {!! Form::close() !!}
              <div class="pull-left">
                <a href="{{ URL::previous() }}" class="btn btn-info btn-flat"><i class="fa fa-step-backward"></i> Halaman Sebelumnya</a>
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
    
    $('input[name="totalBayar"]').val('{{ number_format($tagihan+$uang_racik+$jasa_racik) }}')
    // Currency
    $('.uang').maskNumber({
      thousands: ',',
      integer: true,
    });

    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    function hitungDiskonRupiah() {
      var total_tagihan = $('input[name="total_tagihan"]').val();
      var diskon_rupiah = $('input[name="diskon_rupiah"]').val();
      var totalTagihan  = parseInt( total_tagihan.split(',').join("") );
      var diskonRupiah  = parseInt( diskon_rupiah.split(',').join("") );
      var totalBayar    = Math.round(totalTagihan - diskonRupiah);
      var persen        = Math.round((diskonRupiah / totalTagihan)*100);
      // console.log(totalBayar);
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
      var total = $('input[name="total"]').val();
      var iur = $('input[name="iur"]').val();
      var dijamin = parseInt( iur.split(',').join("") );
      var totalBayar = total - dijamin;
      $('input[name="totalBayar"]').val(ribuan(totalBayar));
    }

      
  </script>
@endsection
