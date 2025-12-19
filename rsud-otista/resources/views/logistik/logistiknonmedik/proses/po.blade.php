@extends('master')
@section('header')
  <h1>Logistik Non Medik - PO</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar PO
        <a href="{{ url('#') }}" class="btn btn-default btn-sm" onclick="tambah()"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed tabeldata'>
            <thead>
              <tr>
                <th>No</th>
                <th>No.PO </th>
                <th>Supplier</th>
                <th>Tanggal</th>
                <th>Cetak</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
    </div>
    <div id="Modal" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header bg-green">
                  <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                  <form method="POST" class="form-horizontal" id="form">
                      {{ csrf_field() }} {{ method_field('POST') }}
                      <input type="hidden" name="id">
                      <div class="box-body">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="jenis_pengadaan" class="col-sm-4 control-label">Jenis Pengadaan</label>
                              <div class="col-sm-8 jenis_pengadaanGroup">
                                  <select name="jenis_pengadaan" class="form-control select2" style="width: 100%">
                                    <option value="barang">Barang</option>
                                  </select>
                                  <span class="text-danger jenis_pengadaanError"></span>
                              </div>
                          </div>
                          <div class="form-group tanggalGroup">
                            <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ !empty(session('tanggal')) ? session('tanggal') : date('d-m-Y') }}" name="tanggal" class="form-control datepicker">
                              <small class="text-danger tanggalError"></small>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="supplier" class="col-sm-4 control-label">Supplier</label>
                            <div class="col-sm-8">
                              <select name="supplier" class="form-control select2" style="width: 100%">
                                @foreach ( \App\LogistikNonMedik\LogistikNonMedikSuplier::all() as $d)
                                  <option value="{{ $d->nama }}">{{ $d->nama }} </option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group kodeRekeningGroup">
                            <label for="kode_rekening" class="col-sm-4 control-label">Kode Rekening</label>
                            <div class="col-sm-8">
                              <input type="text" value="{{ !empty(session('kode_rekening')) ? session('kode_rekening') : '2.2.2.33.01.01.01' }}" name="kode_rekening" class="form-control">
                              {{--  <select name="kode_rekening" class="form-control select2" style="width: 100%">
                                @foreach (\App\Logistik\LogistikPengirimPenerima::all() as $d)
                                    <option value="{{ $d->nip }}"> {{ $d->nip }} | {{ $d->nama }}</option>
                                @endforeach
                              </select>  --}}
                              <small class="text-danger kodeRekeningError"></small>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="kategori_barang" class="col-sm-4 control-label">Kategori</label>
                            <div class="col-sm-8">
                              <select name="kategori_barang" class="form-control select2" style="width: 100%">
                                @foreach ( \App\LogistikNonMedik\LogistikNonMedikGudang::all() as $d)
                                  <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    <table class='table table-striped table-bordered table-hover table-condensed tabel'>
                      <thead>
                        <tr>
                          <th>Hapus</th>
                          <th>Kd Brng</th>
                          <th style="width: 28%;">Nama Barang</th>
                          <th class="text-center">Jml</th>
                          <th class="text-center">Satuan</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                    <table class="table-hover table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td style="width: 40%">
                          <select name="masterbarang_id" onchange="setSatuan()" class="form-control select2" style="width: 100%">
                            <option value="">[ -- ]</option>
                            @foreach (\App\LogistikNonMedik\LogistikNonMedikBarang::all() as $d)
                              <option value="{{ $d->id }}">{{ $d->nama }} | Rp. {{ number_format($d->hargajual) }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td style="width: 10%" class="kolomJumlah"><input type="text" name="jumlah" class="form-control"></td>
                        <td style="width: 15%">
                          <select name="satuan" readonly="true" class="form-control select2" style="width: 100%;">
                            <option value="">[ -- ]</option>
                            @foreach (\App\LogistikNonMedik\LogistikNonMedikSatuan::all() as $d)
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
                          <button type="button" onclick="save()" class="btn btn-primary btn-flat">SIMPAN</button>
                          <a href="" onclick="tutup()" class="btn btn-default btn-flat pull-right">KEMBALI</a>
                          <a href="{{ url('logistiknonmedik/reset') }}" class="btn btn-success btn-flat pull-right">SELESAI</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </form>
              </div>
          </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script type="text/javascript">
    function tutup(){
      $('#Modal').modal('hide');
      $('#form')[0].reset();
      table.ajax.reload()
    }
    
    $('.select2').select2()
    function tambah(){
        $('#Modal').modal({
          backdrop: 'static',
          keyboard : false,
        })
        $('.modal-title').text('Tambah Po')
        $('input[name="id"]').val('')
        $('input[name="_method"]').val('POST')
        $('#form')[0].reset();
      }

      $('.uang').maskNumber({
      thousands: '.',
      integer: true,
    });

    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
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

    function hapus(id){
      $.ajax({
        url: '/logistiknonmedik/logistiknonmedikpo/'+id,
        type: 'POST',
        dataType: 'json',
        data: {
          '_method': 'DELETE',
          '_token': $('input[name="_token"]').val()
        },
      })
      .done(function(json) {
        if (json.sukses == true) {
          table1.ajax.reload()
        }
      });
    }

    function save(){
        var data = $('#form').serialize()
        var id = $('input[name="id"]').val()

        if(id == ''){
            var url = '{{ route('logistiknonmedikpo.store') }}'
        } else {
            var url = '/logistiknonmedik/satuan-barang/'+id
        }

        $.post( url, data, function(resp){
          if (resp.sukses == true) {
            table1.ajax.reload()
          }
        })
    }

    var table1;
    table1 = $('.tabel').DataTable({
    'language': {
      'url': '/json/pasien.datatable-language.json',
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: '{{ route('data-po') }}',
    columns: [
        {data: 'aksi', searchable: false},
        {data: 'kode_barang'},
        {data: 'masterbarang_id'},
        {data: 'jumlah'},
        {data: 'satuan'},
    ]
    });

    var table;
    table = $('.tabeldata').DataTable({
      'language': {
          'url': '/DataTables/datatable-language.json',
      },
      select: {
      	style: 'multi'
      },
      ordering: false,
      autoWidth: false,
      processing: true,
      serverSide: true,
      ajax: '{{ route('logistiknonmedikpo.index') }}',
      columns: [
          {data: 'DT_RowIndex', searchable: false, orderable: false},
          {data: 'no_po'},
          {data: 'supplier'},
          {data: 'tanggal'},
          {data: 'aksi', searchable: false}
      ]
    });
  </script>
@endsection
