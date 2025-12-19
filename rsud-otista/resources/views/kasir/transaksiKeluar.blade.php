@extends('master')

@section('header')
  <h1>Kasir</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Transaksi Keluar 
           <button class="btn btn-default" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i>&nbsp;Klasifikasi</button>
           <button class="btn btn-default" data-toggle="modal" data-target="#jenisPengeluaran"><i class="fa fa-plus"></i>&nbsp;Jenis Pengeluaran</button>
           {{-- <button class="btn btn-default" data-toggle="modal" data-target="#jenisPengeluaran"><i class="fa fa-print"></i>&nbsp;Cetak</button> --}}
      </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-8">
                <form class="form-horizontal" id="formDiklat" method="POST">
                    {{ csrf_field() }}
                    {{-- <div class="form-group namaGroup">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" name="nama" class="form-control" autocomplete="off">
                            <small class="text-danger namaError"></small>
                        </div>
                    </div> --}}
                    <div class="form-group namaGroup">
                        <label class="col-sm-3 control-label">Tanggal</label>
                        <div class="col-sm-9">
                            <input type="text" name="tgl" value="{{ date('d-m-Y') }}" class="form-control datepicker">
                            <small class="text-danger namaError"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Satuan</label>
                        <div class="col-sm-9">
                            <select name="satuanbeli_id" class="form-control select2" style="width: 100%">
                                @foreach ($satuan as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Klasifikasi</label>
                        <div class="col-sm-9">
                            <select name="klasifikasi_pengeluaran_id" class="form-control select2" style="width: 100%">
                                @foreach ($klasifikasi as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jenis</label>
                        <div class="col-sm-9">
                            <select name="jenis_pengeluaran_id" class="form-control select2" style="width: 100%">
                                @foreach ($jenis as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group keteranganGroup">
                        <label class="col-sm-3 control-label">Keterangan</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="keterangan" class="form-control" autocomplete="off"></textarea>
                            <small class="text-danger keteranganError"></small>
                        </div>
                    </div>
                    <div class="form-group namaGroup">
                        <label class="col-sm-3 control-label">Bukti Transaksi</label>
                        <div class="col-sm-9">
                            <input type="text" name="bukti_transaksi" class="form-control" autocomplete="off">
                            <small class="text-danger namaError"></small>
                        </div>
                    </div>
                    <div class="form-group totalGroup">
                        <label class="col-sm-3 control-label">Hrg.Satuan</label>
                        <div class="col-sm-9">
                            <input placeholder="contoh: 90000" type="number" name="harga_satuan" class="form-control" autocomplete="off">
                            <small class="text-danger totalError"></small>
                        </div>
                    </div>
                    <div class="form-group totalGroup">
                        <label class="col-sm-3 control-label">Jumlah</label>
                        <div class="col-sm-9">
                            <input placeholder="contoh: 1" type="number" name="jumlah" class="form-control" autocomplete="off">
                            <small class="text-danger totalError"></small>
                        </div>
                    </div>
                    {{-- <div class="form-group totalGroup">
                        <label class="col-sm-3 control-label">Total</label>
                        <div class="col-sm-9">
                            <input placeholder="contoh: 90000" type="number" name="total" class="form-control" autocomplete="off">
                            <small class="text-danger totalError"></small>
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-9">
                            <button type="button" onclick="save()" class="btn btn-primary btn-flat">SIMPAN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No.BKK</th>
                        <th>Ket</th>
                        <th>Jml</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Klasifikasi</th>
                        <th>Jenis</th>
                        {{-- <th>Penginput</th> --}}
                        {{-- <th>Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
  </div>
  {{-- Klasifikasi Pengeluaran --}}
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Klasifikasi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal" action="{{url('/kasir/save-klasifikasi-pengeluaran')}}" id="formDiklat" method="POST">
        {{ csrf_field() }}
        <div class="modal-body">
                <div class="form-group namaGroup">
                    <label class="col-sm-3 control-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" autocomplete="off">
                        <small class="text-danger namaError"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  {{-- Jenis Pengeluaran --}}
  <div class="modal fade" id="jenisPengeluaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Pengeluaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form-horizontal" action="{{url('/kasir/save-jenis-pengeluaran')}}" id="formDiklat" method="POST">
        {{ csrf_field() }}
        <div class="modal-body">
                <div class="form-group namaGroup">
                    <label class="col-sm-3 control-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" autocomplete="off">
                        <small class="text-danger namaError"></small>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('id_akun_coa') ? ' has-error' : '' }}">
                    {!! Form::label('id_akun_coa', 'Akun COA', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::select('id_akun_coa', $akun_coa, null, ['class' => 'form-control select2', 'style'=>'width:100%']) !!}
                        <small class="text-danger">{{ $errors->first('id_akun_coa') }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@section('script')
<script type="text/javascript">
    $('.select2').select2()
    var table;
    table = $('.table').DataTable({
        "language": {
        "url": "/json/pasien.datatable-language.json",
        },
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: '/kasir/transaksi-keluar-data',
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'no_bkk'},
            {data: 'keterangan'},
            {data: 'jumlah'},
            {data: 'total'},
            {data: 'tanggal'},
            {data: 'klasifikasi'},
            {data: 'jenis'},
            // {data: 'aksi'},
        ]
    });

    function resetForm(){
        $('.namaGroup').removeClass('has-error');
        $('.namaError').text('')
        $('.keteranganGroup').removeClass('has-error');
        $('.keteranganError').text('')
    }

    function save(){
        var data = $('#formDiklat').serialize()
        $.post('/kasir/transaksi-keluar-save', data, function(resp){
            resetForm()
            if(resp.sukses == false){
                if(resp.error.nama){
                    $('.namaGroup').addClass('has-error');
                    $('.namaError').text(resp.error.nama[0])
                }
                if(resp.error.keterangan){
                    $('.keteranganGroup').addClass('has-error');
                    $('.keteranganError').text(resp.error.keterangan[0])
                }
            }
            if(resp.sukses == true){
                $('#formDiklat')[0].reset()
                resetForm()
                table.ajax.reload()
                alert('Transaksi Keluar berhasil disimpan')
            }
        })
    }

    function hapus(id){
        if(confirm('Yakin akan dihapus?')){
            $.get('/kasir/transaksi-keluar-batal/'+id, function(resp){
                if(resp.sukses == true){
                    table.ajax.reload()
                }
            })
        }
    }

</script>
@endsection
