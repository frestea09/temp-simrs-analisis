@extends('master')

@section('header')
  <h1>Logistik</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Form PO
      </h3>
    </div>
    <div class="box-body">
        <form id="formPO" method="POST" class="form-horizontal">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="jenis_pengadaan" class="col-sm-4 control-label">Jenis Pengadaan</label>
                <div class="col-sm-8">
                  <input type="hidden" value="{{ session('no_po') }}">
                  <select name="jenis_pengadaan" class="form-control select2" style="width: 100%">
                        @if (isset($po->jenis_pengadaan) && $po->jenis_pengadaan == 'OBAT')
                            <option value="OBAT" selected="true">OBAT</option>
                            <option value="BMHP">BMHP</option>
                            <option value="ALAT">ALAT</option>
                            <option value="Bank Darah">Bank Darah</option>
                            <option value="Laboratorium">Laboratorium</option>
                        @elseif (isset($po->jenis_pengadaan) && $po->jenis_pengadaan == 'BMHP')
                            <option value="OBAT">OBAT</option>
                            <option value="BMHP" selected="true">BMHP</option>
                            <option value="ALAT">ALAT</option>
                            <option value="Bank Darah">Bank Darah</option>
                            <option value="Laboratorium">Laboratorium</option>
                        @elseif(isset($po->jenis_pengadaan) && $po->jenis_pengadaan == 'ALAT')
                            <option value="OBAT">OBAT</option>
                            <option value="BMHP">BMHP</option>
                            <option value="ALAT" selected="true">ALAT</option>
                            <option value="Bank Darah">Bank Darah</option>
                            <option value="Laboratorium">Laboratorium</option>
                        @elseif(isset($po->jenis_pengadaan) && $po->jenis_pengadaan == 'Bank Darah')
                            <option value="OBAT">OBAT</option>
                            <option value="BMHP">BMHP</option>
                            <option value="ALAT">ALAT</option>
                            <option value="Bank Darah" selected="true">Bank Darah</option>
                            <option value="Laboratorium">Laboratorium</option>
                         @elseif(isset($po->jenis_pengadaan) && $po->jenis_pengadaan == 'Laboratorium')
                            <option value="OBAT">OBAT</option>
                            <option value="BMHP">BMHP</option>
                            <option value="ALAT">ALAT</option>
                            <option value="Bank Darah">Bank Darah</option>
                            <option value="Laboratorium" selected="true">Laboratorium</option>
                        @else
                            <option value="OBAT">OBAT</option>
                            <option value="BMHP">BMHP</option>
                            <option value="ALAT">ALAT</option>
                            <option value="Bank Darah">Bank Darah</option>
                            <option value="Laboratorium" selected="true">Laboratorium</option>
                        @endif
                  </select>
                </div>
              </div>
              <div class="form-group tanggalGroup">
                <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
                <div class="col-sm-8">
                  <input type="text" value="{{ !empty(session('tanggal')) ? date('d-m-Y') : tanggalPeriode($po->tanggal)  }}" name="tanggal" class="form-control datepicker">
                  <small class="text-danger tanggalError"></small>
                </div>
              </div>
              <div class="form-group">
                <label for="supplier" class="col-sm-4 control-label">Supplier</label>
                <div class="col-sm-8">
                  <select name="supplier" class="form-control select2" style="width: 100%">
                    @foreach ( \App\Logistik\LogistikSupplier::where('nama', $po->supplier)->get() as $d)
                      <option value="{{ $d->nama }}">{{ $d->nama }} </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="supplier" class="col-sm-4 control-label">Nomor SP</label>
                <div class="col-sm-8">
                  <input type="text" name="no_sp" value="{{ $po->no_sp }}"  class="form-control">
                  <input type="hidden" name="no_po" value="{{ $po->no_po }}"  class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="supplier" class="col-sm-4 control-label">Lampiran</label>
                <div class="col-sm-8">
                  <input type="text" name="lampiran" value="{{ $po->lampiran }}" class="form-control">
                </div>
              </div>
             
            </div>

            





            <div class="col-sm-6">
              <div class="form-group kodeRekeningGroup">
                <label for="kode_rekening" class="col-sm-4 control-label">Kode Rekening</label>
                <div class="col-sm-8">
                  <select name="kode_rekening" class="form-control select2" style="width: 100%">
                    @foreach (\App\Logistik\LogistikPengirimPenerima::all() as $d)
                        @if (!empty($po->supplier) && $po->supplier == $d->nama)
                            <option value="{{ $d->nip }}" selected> {{ $d->nip }} | {{ $d->nama }}</option>
                        @else
                            <option value="{{ $d->nip }}"> {{ $d->nip }} | {{ $d->nama }}</option>
                        @endif
                    @endforeach
                  </select>
                  <small class="text-danger kodeRekeningError"></small>
                </div>
              </div>
              <div class="form-group">
                <label for="kategori_obat" class="col-sm-4 control-label">Kategori</label>
                <div class="col-sm-8">
                  <select name="kategori_obat" class="form-control select2" style="width: 100%">
                    @foreach (\App\Kategoriobat::all() as $d)
                        @if (!empty($po->kategori_obat) && $po->kategori_obat == $d->id)
                            <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                        @else
                           <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                        @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="supplier" class="col-sm-4 control-label">Nomor Usulan</label>
                <div class="col-sm-8">
                  <input type="text" name="no_usulan" value="{{ $po->no_usulan }}" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="supplier" class="col-sm-4 control-label">Perihal</label>
                <div class="col-sm-8">
                  <input type="text" name="perihal" value="{{ $po->perihal }}" class="form-control">
                </div>
              </div>
            </div>
          </div>
          {{-- DETAIL PO --}}
          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
                {{--  <caption>Data Po</caption>
                <table class="table table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                        <th>Hapus</th>
                        <th>Kd Brng</th>
                        <th style="width: 28%;">Nama Barang</th>
                        <th class="text-center">Jml</th>
                        <th class="text-center">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td class="text-center">
                                    <a onclick="hapusPO({{ $d->id }})" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a>
                                </td>
                                <td>{{ $d->kode_barang }}</td>
                                <td>{{ $d->barang->nama }}</td>
                                <td class="text-center" style="width:10%"><input type="number" name="jumlah{{ $d->id }}" value="{{ $d->jumlah }}" onchange=edit({{ $d->id }}) class="form-control"></td>
                                <td class="text-center">{{ $d->satBeli->nama }}</td>
                                <td>{{ $d->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>  --}}
                <table class="table table-hover table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th>Nama Barang</th>
                      <th>Harga</th>
                      <th>Diskon</th>
                      <th>Jumlah</th>
                      <th>Satuan</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <div id="viewPO"></div>
                    <tr>
                      <td style="width: 40%">
                        <select name="masterobat_id" onchange="setSatuan()" class="form-control select2 masterobat" style="width: 100%">
                          <option value="">[ -- ]</option>
                          @foreach (\App\Masterobat::all() as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }} | Rp. {{ number_format($d->hargajual) }}</option>
                          @endforeach
                          <input type="hidden" value="" id="harga" onchange="hargaAwal()">
                        </select>
                      </td>
                      <td style="width: 10%" class="kolomHarga"><input type="text" name="harga" class="form-control"></td>
                      <td style="width: 10%" class="kolomDiskon"><input type="text" name="diskon" class="form-control"></td>
                      <td style="width: 10%" class="kolomJumlah"><input type="text" name="jumlah" class="form-control"></td>
                      <td style="width: 15%">
                        <select name="satuan" readonly="true" class="form-control select2" style="width: 100%;">
                          <option value="">[ -- ]</option>
                          @foreach (\App\Satuanbeli::all() as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td style="width: 35%">
                        <input type="text" name="keterangan" value="" class="form-control">
                      </td>
                    </tr>
                    <tr>
                      <td colspan="10">
                        <a href="{{ url('logistikmedik/po') }}" class="btn btn-success btn-flat pull-right">SELESAI</a>
                        <button type="button" onclick="saveForm()" class="btn btn-primary btn-flat pull-right">SIMPAN</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </form>
    </div>



@endsection

@section('script')
<script type="text/javascript">
  $('.select2').select2()
  $('#viewPO').load('/logistikmedik/po-data-edit')
  // Currency
  $('.uang').maskNumber({
    thousands: '.',
    integer: true,
  });

  function editJumlah(id){
		$.ajax({
			url: '/logistikmedik/edit-po',
			type: 'POST',
			dataType: 'json',
			data: {
				'id':id, 
				'jumlah': $('input[name="jumlah'+id+'"]').val(),
				'_token' : $('input[name="_token"]').val()
				}
		})
		.done(function(data) {
			if(data.sukses == false){
      }
			if(data.sukses == true){
        alert('Jumlah Berhasil di ubah!!')
        location.reload();
			}
		});
	}

  // $ppnAwal = $sum * 11 / 100;

  function editPPN(){
    var ppnPersen = $('input[name="ppnPersen"]').val();
    var totalPPN = $('input[name="totalPPN"]').val();
    $.ajax({
			url: '/logistikmedik/edit-ppn',
			type: 'POST',
			dataType: 'json',
			data: {
				'no_po':$('input[name="no_po"]').val(), 
        'jml_ppn': $('input[name="ppnPersen"]').val(),
				'ppn':  $('input[name="sum"]').val() * ppnPersen / 100,
				'_token' : $('input[name="_token"]').val(),
				}
		})
		.done(function(data) {
			if(data.sukses != true){
        alert ('gagal ubah');
        location.reload();
      }
			if(data.sukses == true){
        alert('Ppn Berhasil di ubah!!');
        $('input[name="totalPPN"]').val(data.po.ppn);
			}
		});
	
	}















  function ribuan(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
  }

  $(document).ready(function() {

$(".masterobat").change(function() {
  var IdValue = $(this).val();
 

  $.ajax({
    url: '/masterobat/'+IdValue,
    type: 'GET',
    dataType: 'json',
  })
  .done(function(json) {
    $('input[name="harga"]').val(json.hargabeli).trigger('change')
  });

});

});

  function resetForm() {
    $('.no_poGroup').removeClass('has-error')
    $('.no_poError').text('')
    $('.tanggalGroup').removeClass('has-error')
    $('.tanggalError').text('')
    $('.kolomJumlah').removeClass('has-error')
  }

  function saveForm() {
    resetForm()
    $.ajax({
      url: '/logistikmedik/po',
      type: 'POST',
      dataType: 'json',
      data: $('#formPO').serialize(),
    })
    .done(function(json) {
      if (json.sukses == false) {
        if (json.error.no_po) {
          $('.no_poGroup').addClass('has-error')
          $('.no_poError').text(json.error.no_po[0])
        }
        if (json.error.tanggal) {
          $('.tanggalGroup').addClass('has-error')
          $('.tanggalError').text(json.error.tanggal[0])
        }

        if (json.error.jumlah) {
          $('.kolomJumlah').addClass('has-error')
        }
      }

      if (json.sukses == true) {
        $('#viewPO').load('/logistikmedik/po-data-edit')
      }
    });
  }

  function setSatuan() {
    var masterbarang_id = $('select[name="masterbarang_id"]').val()
    $.ajax({
      url: '/cari-barang/'+masterbarang_id,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(json) {
      $('input[name="jumlah"]').focus()
    });
  }

  function hapusPO(id) {
    $.ajax({
      url: '/logistikmedik/po/'+id,
      type: 'POST',
      dataType: 'json',
      data: {
        '_method': 'DELETE',
        '_token': $('input[name="_token"]').val()
      },
    })
    .done(function(json) {
      if (json.sukses == true) {
        $('#viewPO').load('/logistikmedik/po-data')
      }
    });
  }


</script>
@endsection
