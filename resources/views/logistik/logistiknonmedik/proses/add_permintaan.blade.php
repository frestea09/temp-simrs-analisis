@extends('master')
@section('header')
  <h1>Logistik Non Medik - PERMINTAAN</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Permintaan
        <a href="{{ url('#') }}" class="btn btn-default btn-sm" onclick="tambah()"><i class="fa fa-plus"></i></a>
      </h3>
    </div>
    <div class="box-body">
        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed tabeldata'>
            <thead>
              <tr>
                <th>No</th>
                <th>Nomor </th>
                <th>Gudang Asal</th>
                <th>Gudang Tujuan</th>
                <th>Tanggal</th>
                <th>Cetak</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
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
                            <label for="nomor" class="col-sm-4 control-label">Nomor</label>
                            <div class="col-sm-8">
                                {{--  <input type="text" name="nomor" value="00000/{{ \App\LogistikGudang::where('id', Auth::user()->gudang_id)->first()->nama }}/{{ date('d-m-Y') }}" class="form-control">  --}}
                                <input type="text" name="nomor" value="{{ !empty(session('nomor')) ? session('nomor') : NULL }}" class="form-control">
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="tanggal" class="col-sm-4 control-label">Tanggal</label>
                            <div class="col-sm-8">
                                <input type="text" name="tanggal"  value="{{ date('d-m-Y') }}" class="form-control datepicker">
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="nomor" class="col-sm-4 control-label">Gudang Asal</label>
                            <div class="col-sm-8">
                                <input type="text" value="{{ baca_gudang(Auth::User()->gudang_id) }}" class="form-control">
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="gudang_id" class="col-sm-4 control-label">Gudang Tujuan</label>
                            <div class="col-sm-8">
                                <select name="gudang_tujuan" class="form-control select2" readonly="true" style="width: 100%;">
                                @foreach ( \App\LogistikNonMedik\LogistikNonMedikGudang::all() as $d)
                                    @if ($d->id == 1)
                                    <option value="{{ $d->id }}" selected>{{ $d->nama }}</option>
                                    @else
                                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                    @endif
                                @endforeach
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label for="masterbarang_id" class="col-sm-4 control-label">Nama Barang</label>
                            <div class="col-sm-8">
                                <select name="masterbarang_id" class="form-control select2" style="width: 100%;">
                                <option value="">[---]</option>
                                @foreach ( \App\LogistikNonMedik\LogistikNonMedikBarang::all() as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                @endforeach
                                </select>
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="jumlah_permintaan" class="col-sm-4 control-label">Jumlah Permintaan</label>
                            <div class="col-sm-8">
                                <input type="text" name="jumlah_permintaan" class="form-control">
                            </div>
                            </div>

                            <div class="form-group">
                            <label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
                            <div class="col-sm-8">
                                <input type="text" name="keterangan" class="form-control">
                            </div>
                            </div>
                            <div class="form-group">
                            <label for="save" class="col-sm-4 control-label">&nbsp;</label>
                            <div class="col-sm-8">
                                <button type="button" class="btn btn-primary btn-flat" onclick="save()" >SIMPAN</button>
                            </div>
                            </div>
                        </div>
                      </div>
                    <table class='table table-striped table-bordered table-hover table-condensed tabel'>
                      <thead>
                        <tr>
                          <th>Tanggal Permintaan</th>
                          <th style="width: 28%;">Nama Barang</th>
                          <th class="text-center">Jml</th>
                          <th class="text-center">Keterangan</th>
                          <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                </form>
              </div>
              <div class="modal-footer">
                <a href="{{ url('logistiknonmedik/reset-permintaan') }}" class="btn btn-success btn-flat pull-right">SELESAI</a>
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
        $('.modal-title').text('Tambah Permintaann')
        $('input[name="id"]').val('')
        $('input[name="_method"]').val('POST')
        $('#form')[0].reset();
      }

      $('.uang').maskNumber({
      thousands: '.',
      integer: true,
    });

    function hapus(id){
      $.ajax({
        url: '/logistiknonmedik/nonmedikpermintaan/'+id,
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

        var url = '{{ route('nonmedikpermintaan.store') }}'

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
    ajax: '{{ route('data-permintaan') }}',
    columns: [
        {data: 'tanggal_permintaan'},
        {data: 'masterbarang_id'},
        {data: 'masterbarang_id'},
        {data: 'jumlah_permintaan'},
        {data: 'keterangan'},
        {data: 'aksi', searchable: false}
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
      ajax: '{{ route('nonmedikpermintaan.index') }}',
      columns: [
          {data: 'DT_RowIndex', searchable: false, orderable: false},
          {data: 'nomor'},
          {data: 'asal'},
          {data: 'tujuan'},
          {data: 'tanggal_permintaan'},
          {data: 'aksi', searchable: false}
      ]
    });
  </script>
@endsection
