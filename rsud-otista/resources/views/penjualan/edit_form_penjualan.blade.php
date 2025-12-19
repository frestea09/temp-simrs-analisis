@extends('master')
@section('header')
<h1>Penjualan Rawat {{ $unit }}</h1>
@endsection

@section('content')
<div class="box box-primary">
   <div class="box-body">
      {!! Form::open(['method' => 'POST', 'url' => 'penjualan/savepenjualan']) !!}
         {!! Form::hidden('pasien_id', $pasien->id) !!}
         {!! Form::hidden('idreg', $idreg) !!}
         <table class='table table-striped table-bordered table-hover table-condensed'>
            <tbody>
               <tr>
                  <td style="width: 30%">Nama Pasien / No. RM</td>
                  <td>
                     {{ strtoupper($pasien->nama) }} / {{ $pasien->no_rm }} / {{ (!empty($pasien->tgllahir)) ? hitung_umur($pasien->tgllahir) : 'tgl lahir kosonglo' }}
                     <button type="button" id="historipenjualan" data-registrasiID="{{ $idreg }}" class="btn btn-info btn-sm btn-flat">
                        <i class="fa fa-th-list"></i> HISTORY
                     </button>
                  </td>
               </tr>
               <tr>
               @if($unit == 'Ranap')
                  <td>Ruangan</td><td>{{ ($ranap->kamar_id != '') ? baca_kamar($ranap->kamar_id) : '' }}</td>
               @else
                  <td>Klinik</td><td>{{ strtoupper(baca_poli($reg->poli_id)) }}</td>
               @endif
               </tr>
               <tr>
                  <td>Dokter</td>
                  <td>
                     {!! Form::select('dokter_id', $dokter, $reg->dokter_id, ['class' => 'form-control select2']) !!}
                  </td>
               </tr>
               <tr>
                  <td>Jenis Pasien</td><td>{{ baca_carabayar($reg->bayar) }}</td>
               </tr>
               <tr>
                  <td>Alamat</td> <td>{{ strtoupper($pasien->alamat) }} RT. {{ $pasien->rt }} / RW. {{ $pasien->rw }} {{ baca_kelurahan($pasien->village_id) }} {{ baca_kecamatan($pasien->district_id) }}</td>
               </tr>
            </tbody>
         </table>
      {!! Form::close() !!}
      <hr/>
      <form method="POST" id="formPenjualan" class="form-horizontal">
         {{ csrf_field() }}
         {!! Form::hidden('pasien_id', $pasien->id) !!}
         {!! Form::hidden('idreg', $idreg) !!}
         {!! Form::hidden('tipe_rawat', $reg->status_reg) !!}
         {!! Form::hidden('cara', $reg->bayar) !!}
         {!! Form::hidden('penjualan_id', $penjualan->id) !!}
         {{-- {{dd($penjualan->id)}} --}}

         <div class="form-group{{ $errors->has('obat_racik') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label text-primary">Uang Racik</label>
            {{-- {!! Form::label('obat_racik', 'Tipe Obat', ['class' => 'col-sm-2 control-label']) !!} --}}
            <div class="col-sm-4">
              <select class="form-control select2" name="uang_racik" style="width: 100%;">
                @foreach ($tipe_uang_racik as $d)
                  <option value="{{ $d->id }}" {{ ( $d->id == 2) ? 'selected' : '' }}>{{ $d->nama }}</option>
                @endforeach
              </select>
              <small class="text-danger">{{ $errors->first('obat_racik') }}</small>
            </div> 
             <div class="col-sm-3">
               <div class="input-group">
                  <span class="input-group-btn">
                     <button class="btn btn-default" type="button">Jumlah</button>
                  </span>
                  <input type="number" name="jumlah" value="1" class="form-control">
               </div>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Cetak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                </span>
                {!! Form::select('cetak', ['Y'=>'Ya', 'N'=>'Tidak'], null, ['class' => 'form-control select2']) !!}
                <small class="text-danger">{{ $errors->first('cetak') }}</small>
              </div>
            </div>
            {{-- <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Kronis</button>
                </span>
                <input type="number" name="jml_kronis" value="0" min="1" class="form-control">
              </div>
            </div> --}}
          </div>
         <div class="form-group{{ $errors->has('masterobat_id') ? ' has-error' : '' }}">
            {!! Form::label('masterobat_id', 'Pilih Obat', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
               <select name="masterobat_id" onchange="cariBatch()" id="masterObat" class="form-control"></select>
               <small class="text-danger">{{ $errors->first('masterobat_id') }}</small>
            </div>
           
            <div class="col-sm-3">
               <div class="input-group">
                 <span class="input-group-btn">
                   <button class="btn btn-default" type="button">No. Batch</button>
                 </span>
                 {!! Form::text('batch',  null, ['class' => 'form-control', 'readonly'=>true]) !!}
                 <small class="text-danger">{{ $errors->first('batch') }}</small>
               </div>
             </div>
             <div class="col-sm-3">
               <div class="input-group">
                 <span class="input-group-btn">
                   <button class="btn btn-default" type="button">Harga</button>
                 </span>
                 {!! Form::text('harga',  null, ['class' => 'form-control','readonly'=>true]) !!}
                 <small class="text-danger">{{ $errors->first('harga') }}</small>
               </div>
             </div>
         </div>

         <div class="form-group{{ $errors->has('uang_racik') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label"> Cara Bayar</label>
            <div class="col-sm-4">
               {{-- <div class="input-group"> --}}
                  {{-- <span class="input-group-btn">
                     <button class="btn btn-default" type="button">Cara Bayar</button>
                  </span> --}}
               {!! Form::select('cara_bayar_id', $carabayar, $reg->bayar, ['class' => 'select2 form-control', 'placeholder'=>'']) !!}
               {{-- </div> --}}
            </div>
            <div class="col-sm-3">
               <div class="input-group">
                  <span class="input-group-btn">
                     <button class="btn btn-default" type="button">Expired</button>
                  </span>
                  {!! Form::text('expired', null, ['class' => 'form-control datepicker']) !!}
                  <small class="text-danger">{{ $errors->first('cetak') }}</small>
               </div>
            </div>
            <div class="col-sm-3">
               <div class="input-group">
                 <span class="input-group-btn">
                   <button class="btn btn-default" type="button">Stok&nbsp;&nbsp;</button>
                 </span>
                 {!! Form::text('stok', 0, ['class' => 'form-control','readonly'=>true]) !!}
                 <small class="text-danger">{{ $errors->first('stok') }}</small>
               </div>
             </div>
            <div class="col-sm-4">
               {{-- <select class="form-control select2" name="uang_racik" style="width: 100%;">
                  <option value="">-</option>
                  @foreach ($uangracik as $d)
                  <option value="{{ $d->jumlah  }}">{{ $d->nama }} | {{ number_format($d->jumlah) }}</option>
                  @endforeach
               </select>
               <small class="text-danger">{{ $errors->first('uang_racik') }}</small> --}}
            </div>
          
            {{-- <div class="col-sm-3">
               <div class="input-group">
                  <span class="input-group-btn">
                     <button class="btn btn-default" type="button">Kronis</button>
                  </span>
                  <input type="number" name="jml_kronis" value="0" class="form-control">
               </div>
            </div> --}}
         </div>



         <div class="form-group{{ $errors->has('aturan_pakai') ? ' has-error' : '' }}">
            {!! Form::label('aturan_pakai', 'Aturan Pakai', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
               {!! Form::select('tiket', $tiket, null, ['class' => 'form-control select2']) !!}
               <small class="text-danger">{{ $errors->first('tiket') }}</small>
            </div>
            <div class="col-sm-3">
               <div class="input-group">
                 <span class="input-group-btn">
                   <button class="btn btn-default" type="button">Cara Minum&nbsp;&nbsp; </button>
                 </span>
                 {!! Form::select('cara_minum_id', $cara_minum, null, ['class' => 'form-control select2']) !!}
                 <small class="text-danger">{{ $errors->first('cara_minum_id') }}</small>
               </div>
             </div> 
            <div class="col-sm-3">
               <div class="input-group">
                  <span class="input-group-btn">
                     <button class="btn btn-default" type="button">Takaran</button>
                  </span>
                  {!! Form::select('takaran', $takaran, '-', ['class' => 'form-control select2']) !!}
                  <small class="text-danger">{{ $errors->first('takaran') }}</small>
               </div>
            </div>  
         </div>

         <div class="form-group{{ $errors->has('informasi1') ? ' has-error' : '' }}">
            {!! Form::label('informasi1', 'Informasi 1', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
               {!! Form::text('informasi1', null, ['class' => 'form-control']) !!}
               <small class="text-danger">{{ $errors->first('informasi1') }}</small>
            </div>
            <div class="col-sm-3">
               <div class="input-group">
                 <span class="input-group-btn">
                   <button class="btn btn-default" type="button">Jenis&nbsp;&nbsp;&nbsp;</button>
                 </span>
                 <input type="text" class="form-control" readonly name="jenis">
                 <small class="text-danger">{{ $errors->first('expired') }}</small>
               </div>
             </div>
            <div class="form-group{{ $errors->has('cetak') ? ' has-error' : '' }}">
               <div class="col-sm-3">
                  <button type="button" class="btn btn-primary btn-flat" onclick="addItem()">Tambahkan</button>
               </div>
            </div>
         </div>
         <div class="form-group{{ $errors->has('is_kronis') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label"> Kronis</label>
            <div class="col-sm-4" style="margin-top: .5rem;">
               <input type="hidden" name="is_kronis" value="N">
               <input type="checkbox" name="is_kronis" value="Y">
               <small class="text-danger">{{ $errors->first('is_kronis') }}</small>
            </div>
         </div>
         <hr>
         <h5><b>Obat Sekarang</b></h5>
         @php
         $no =1;
         @endphp
         <div class='table-responsive'>
         <table class='table table-striped table-bordered table-hover table-condensed' id="dataOrder">
            <thead class="bg-blue">
               <tr>
               <th class="text-center">No</th>
               <th>Nama Obat</th>
               {{-- <th class="text-center">Jumlah INACBG</th> --}}
               <th class="text-center">Jumlah</th>
               {{-- <th class="text-center">Jumlah Kronis</th> --}}
               <th class="text-center">Kronis</th>
               <th style="width:10%" class="text-center">Harga @</th>
                  {{-- <th style="width:10%" class="text-center">Uang Racik</th> --}}
               <th style="width:10%" class="text-center">Subtotal </th>
               {{-- <th style="width:10%" class="text-center">Cara Bayar </th> --}}
               <th>Etiket</th>
               <th>Cetak</th>
               <th>Hapus</th>
               </tr>
            </thead>
            <tbody>
               @if (count($detail) > 0)
               @foreach ($detail as $key => $d)
               <tr> 
                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ !empty($d->logistik_batch_id) ? baca_batches($d->logistik_batch_id) :$d->masterobat->nama }}</td>
                  <td class="text-center">{{ $d->jumlah }}</td>
                  <td class="text-center">{{ $d->is_kronis == 'Y' ? 'Ya' : 'Tidak' }}</td>
                  <td class="text-center">{{ number_format($d->jumlah > 0 ? $d->hargajual / $d->jumlah : 0) }}</td>
                  {{-- <td class="text-right">{{ number_format($d->uang_racik) }}</td> --}}
                  <td class="text-right">{{ number_format($d->hargajual) }}
                  </td>
                  {{-- <td>{{ baca_carabayar($d->cara_bayar_id) }}</td> --}}
                  <td>{{ $d->etiket }}</td>
                  <td>{{ $d->cetak }}</td>
                  
						<td class="text-center">
							<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="hapusObat({{ $d->id }})"><i class="fa fa-trash-o"></i></button>
							{{-- <a href="{{url('/penjualan/hapus-detail-penjualan/'.)}}" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash-o"></i></a> --}}
						</td>
                  {{-- <td>
                     <button type="button" onclick="deleteCart('{{ $d->rowId }}')" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash-o"></i></button>
                  </td> --}}
               </tr>
               @endforeach
               @endif 
            </tbody>
            {{-- <tfoot>
               <tr>
               <th colspan="6" class="text-right">Total Harga</th>
               <th class="text-right">{{ Cart::subtotal(0,','.',') }}</th>
               <th></th>
               <th></th>
               <th></th>
               <th>
                  <button type="button" onclick="destroyCart()" class="btn btn-sm btn-default btn-flat"><i class="fa fa-remove"></i></button>
               </th>
               </tr>
            </tfoot> --}}
         </table>
         </div>

         <h5><b>Obat Tambahan</b></h5>
         <div id="viewDataOrder"></div>
         <div class="col-sm-6">
            {{-- <div class="form-group {{ $errors->has('jasa_racik') ? ' has-error' : '' }} {{ ($reg->bayar != 1) ? 'hidden' : '' }}"> --}}
           
            <div class="form-group">
               {!! Form::label('jasa_racik', 'Jasa Racik', ['class' => 'col-sm-5 control-label']) !!}
               <div class="col-sm-7">
                  {!! Form::text('jasa_racik', 0, ['class' => 'form-control uang']) !!}
                  <small class="text-danger">{{ $errors->first('jasa_racik') }}</small>
               </div>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="form-group">
               {!! Form::label('embalase', 'Embalase ', ['class' => 'col-sm-2 control-label']) !!}
               <div class="col-sm-6">
                  {!! Form::text('embalase', 0, ['class' => 'form-control uang']) !!}
                  <small class="text-danger">{{ $errors->first('embalase') }}</small>
               </div>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="form-group{{ $errors->has('pembuat_resep') ? ' has-error' : '' }}">
               {!! Form::label('pembuat_resep', 'Pelaksana Layanan', ['class' => 'col-sm-5 control-label pembuat_resepGroup']) !!}
               <div class="col-sm-7">
                  {!! Form::select('pembuat_resep', $apoteker, null, ['class' => 'select2 form-control']) !!}
                  <small class="text-danger pembuat_resepError">{{ $errors->first('pembuat_resep') }}</small>
               </div>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="form-group">
               {!! Form::label('tanggal', 'Tanggal ', ['class' => 'col-sm-2 control-label']) !!}
               <div class="col-sm-6">
                  {!! Form::text('created_at', date('d-m-Y'), ['class' => 'form-control datepicker']) !!}
                  <small class="text-danger">{{ $errors->first('informasi2') }}</small>
               </div>
               <div class="col-sm-4">
                  <button type="button" onclick="savePenjualan()" class="btn btn-success btn-flat">SIMPAN</button>
               </div>
            </div>
         </div>
      {!! Form::close() !!}
      <div class="overlay hidden">
         <i class="fa fa-refresh fa-spin"></i>
       </div>
   </div>
</div>

{{-- Modal History Penjualan ======================================================================== --}}
<div class="modal fade" id="showHistoriPenjualan" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         <h4 class="modal-title" id="">History Penjualan Obat Sebelumnya</h4>
       </div>
       <div class="modal-body">
         <div id="dataHistori"></div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
       </div>
     </div>
   </div>
 </div>

{{-- Cetak ======================================================================== --}}
<div class="modal fade" id="showCetak" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Cetak Nota</h4>
         </div>
         <div class="modal-body text-center">
            <a href="" class="btn btn-primary btn-flat" id="non_kronis"  target="_blank"> <i class="fa fa-file-pdf-o"></i> CETAK FAKTUR NON KRONIS </a>
            <a href="" class="btn btn-danger btn-flat"  id="kronis" target="_blank"> <i class="fa fa-file-pdf-o"></i> CETAK FAKTUR KRONIS </a>
         </div>
         <div class="modal-footer">
            <a href="" class="btn btn-default btn-flat"  id="selesai" > SELESAI </a>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
   <script type="text/javascript">
      function ribuan(x) {
         return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      $(document).ready(function() {
         $('.uang').maskNumber({
            thousands: ".",
            integer: true,
         });

         $(document).on('click', '#historipenjualan', function (e) {
            var id = $(this).attr('data-registrasiID');
            $('#showHistoriPenjualan').modal('show');
            // $('#dataHistori').load("/penjualan/"+id+"/history");
            $('#dataHistori').load("/penjualan/"+id+"/history-baru");
         });
      });

      $('.select2').select2();
      $('#viewDataOrder').load('{{ url('cartContent') }}')
      $('#masterObat').select2({
         placeholder: "Klik untuk isi nama obat",
         ajax: {
            url: '/penjualan/master-obat-baru/',
            dataType: 'json',
            data: function (params) {
               return {
                  j: {{ $reg->bayar }},
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

      function editJumlah(rowId, input) {
      var qty = input.value;
            $.ajax({
            url: '/cartEditJumlahNew?rowId='+rowId+'&qty='+qty,
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
               $('.overlay').removeClass('hidden')
            },
            complete: function () {
               $('.overlay').addClass('hidden')
            }
            })
            .done(function(resp) {
            if (resp.sukses == true) {
               $('#viewDataOrder').load("/cartContent/"+idreg)
            }else{
               alert('Gagal merubah jumlah obat')
            }
            });
      }

      function addItem() {
         var data = $('#formPenjualan').serialize()
         $.ajax({
            url: '/cartAdd',
            type: 'POST',
            dataType: 'json',
            data: data,
         })
         .done(function(resp) {
            if (resp.sukses == true) {
               $('select[name="masterobat_id"]').empty()
               $('#viewDataOrder').load('{{ url('cartContent') }}')
            }
         });
      }

      function destroyCart() {
         if (confirm('Yakin akan di hapus semua?')) {
            $.ajax({
               url: '/cartDestroy',
               type: 'GET',
               dataType: 'json',
            })
            .done(function(resp) {
               if (resp.sukses == true) {
                  $('select[name="masterobat_id"]').empty()
                  $('#viewDataOrder').load('{{ url('cartContent') }}')
               }
            });
         }
      }

      function deleteCart(rowId) {
         $.ajax({
            url: '/cartDelete/'+rowId,
            type: 'GET',
            dataType: 'json',
         })
         .done(function(resp) {
            if (resp.sukses == true) {
               $('select[name="masterobat_id"]').empty()
               $('#viewDataOrder').load('{{ url('cartContent') }}')
            }
         });
      }

      function cariBatch() {
         var masterobat_id= $("select[name='masterobat_id']").val();
         $.get('/penjualan/get-obat-baru/'+masterobat_id, function(resp){
            $("input[name='expired']").val(resp.obat.expireddate);
            $("input[name='stok']").val(resp.obat.stok);
            $("input[name='jenis']").val(resp.kategori_obat);
            $("input[name='batch']").val(resp.obat.nomorbatch);
            $("input[name='harga']").val(ribuan(resp.obat.hargajual_jkn));
            $("input[name='jumlah']").attr('max',resp.obat.stok);
         })
      }

      function hapusObat(id){
         
         // alert(id)
      $.ajax({
         url: '/hapus-detail-penjualan-new/'+id,
         type: 'GET',
         dataType: 'json',
         success: function (data) {
            if (data.sukses == true) {
               // if(!alert('Berhasil hapus obat'))
               {window.location.reload();}
            }
         }
      });
      }

      function savePenjualan() {
         if (confirm('Yakin data penjualan sudah benar?')) {
            var  data = $('#formPenjualan').serialize()
            $.ajax({
               url: '/penjualan/update-save-penjualan',
               type: 'POST',
               dataType: 'json',
               data: data,
               beforeSend: function () {
                  $('.overlay').removeClass('hidden')
               },
               complete: function () {
                  $('.overlay').addClass('hidden')
               }
            })
            
            .done(function(resp) {
               if (resp.sukses == true) {
                  $('#showCetak').modal({ backdrop : 'static', keyboad : false });
                  $('#non_kronis').attr('href', '/farmasi/cetak-detail/'+resp.id + '?faktur=true')
                  $('#kronis').attr('href', '/farmasi/cetak-fakturkronis/'+resp.id)
                  if (resp.jenis == 'J') {
                  $('#selesai').attr('href', '/penjualan/jalan-baru-fast')
                  }else if( resp.jenis == 'G'){
                  $('#selesai').attr('href', '/penjualan/darurat-baru-fast')
                  }else if (resp.jenis == 'I') {
                  $('#selesai').attr('href', '/penjualan/irna-baru-fast')
                  }
                  //window.history.back();
               }
               if (resp.sukses == false) {
                  alert('Data Apoteker Wajib diisi')
               }
            });
         }
      }
   </script>
@endsection
