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
                  <select name="jenis_pengadaan" class="form-control select2" style="width: 100%">
                    {{-- @foreach ($penerima as $d)
                        <option value="{{ $d->nama }}">{{ $d->nama }}</option>
                    @endforeach --}}
                      <option value="OBAT">OBAT</option>
                      <option value="BMHP">BMHP</option>
                      <option value="ALAT">ALAT</option>
                      <option value="Bank Darah">Bank Darah</option>
                      <option value="Laboratorium">Laboratorium</option>
                  </select>
                </div>
              </div>
             
              <div class="form-group">
                <label for="supplier" class="col-sm-4 control-label">Supplier</label>
                <div class="col-sm-8">
                  <select name="supplier" class="form-control select2" style="width: 100%">
                    @foreach ($supplier as $d)
                      <option value="{{ $d->nama }}">{{ $d->nama }} </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="supplier" class="col-sm-4 control-label">Nomor SP</label>
                <div class="col-sm-8">
                  <input type="text" name="no_sp" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="supplier" class="col-sm-4 control-label">Lampiran</label>
                <div class="col-sm-8">
                  <input type="text" name="lampiran" class="form-control">
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group tanggalGroup">
                <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
                <div class="col-sm-8">
                  <input type="text" value="{{ !empty(session('tanggal')) ? session('tanggal') : date('d-m-Y') }}" name="tanggal" class="form-control datepicker">
                  <small class="text-danger tanggalError"></small>
                </div>
              </div>
              <div class="form-group">
                <label for="kategori_obat" class="col-sm-4 control-label">Kategori</label>
                <div class="col-sm-8">
                  <select name="kategori_obat" class="form-control select2" style="width: 100%">
                    @foreach (\App\Kategoriobat::all() as $d)
                      <option value="{{ $d->id }}">{{ $d->nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="supplier" class="col-sm-4 control-label">Nomor Usulan</label>
                <div class="col-sm-8">
                  <input type="text" name="no_usulan" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="supplier" class="col-sm-4 control-label">Perihal</label>
                <div class="col-sm-8">
                  <input type="text" name="perihal" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="supplier" class="col-sm-4 control-label">Total Setelah PPN</label>
                <div class="col-sm-8">
                  <input type="text" name="totalppn" class="form-control">
                </div>
              </div>
            </div>
          </div>
          {{-- DETAIL PO --}}
          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
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
                          @foreach ($barang as $d)
                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endforeach
                        </select>
                        <input type="hidden" name="hargaAwal" value="" id="harga">
                      </td>
                      <td style="width: 10%" class="kolomHarga"><input type="text" name="harga" class="form-control"></td>
                      <td style="width: 10%" class="kolomDiskon"><input type="text" name="diskon" class="form-control"></td>
                      <td style="width: 10%" class="kolomJumlah"><input type="text" name="jumlah" class="form-control"></td>
                      {{-- <td style="width: 10%" class="kolomSatuan"><input type="text" name="Satuan" class="form-control" readonly></td> --}}
                      <td style="width: 15%">
                        <select name="satuan"  class="form-control satuans" style="width: 100%;" readonly>
                          <option value="">[ -- ]</option>
                          @foreach ($satuan as $d)
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
                        <a href="{{ url('logistikmedik/po') }}" class="btn btn-default btn-flat pull-right">KEMBALI</a>
                        <button type="button" onclick="saveForm()" class="btn btn-primary btn-flat pull-right">SIMPAN</button>
                       {{-- <a href="{{ url('logistikmedik/po') }}" class="btn btn-success btn-flat pull-right">SELESAI</a> --}}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <span class="text-danger">*</span><b>Satuan</b> bisa diisi manual ,dengan cara ketik nama satuannya di kolom "Satuan",<br/> kemudian <b>"Enter"</b>
            </div>
          </div>

        </form>
    </div>



@endsection

@section('script')
<script type="text/javascript">
  $('.select2').select2()
  $(".satuans").select2({
    tags: true
  });
  $('#viewPO').load('/logistikmedik/po-data')
  // Currency
  $('.uang').maskNumber({
    thousands: '.',
    integer: true,
  });

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
      $('input[name="hargaAwal"]').val(json.hargabeli).trigger('change')
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
    var firstPrice = $('input[name="harga"]').val();
    var lastPrice = $('input[name="hargaAwal"]').val();
    if (firstPrice > lastPrice) {
      confirm('Harga Yang Di Inputkan Lebih Dari Harga Di Master Obat');
    }
    if (firstPrice < lastPrice) {
      confirm('Harga Yang Di Inputkan Kurang Dari Harga Di Master Obat');
    }

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
        $('#viewPO').load('/logistikmedik/po-data')
      }
    }).fail(function (err) {
      if (err.status = 500) {
        alert('Internal Server Error')
      } else if (err.status = 0) {
        alert('Gagal terhubung ke server, silahkan periksa jaringan kembali')
      } else {
        alert('Gagal menambah barang')
      }
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
