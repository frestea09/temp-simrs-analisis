@extends('master')
@section('header')
  <h1>Master Batch</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Daftar Master Batches
      </h3>
      <hr>
        {{-- <a class="btn btn-default btn-sm" onclick="tambah()"><i class="fa fa-plus"></i></a> --}}
        {!! Form::open(['method' => 'POST', 'url' => 'cek-batches', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-4">
            <div class="input-group{{ $errors->has('nomorbatch') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('nomorbatch') ? ' has-error' : '' }}" type="button">Cari Nomor Batch</button>
                </span>
                {!! Form::text('nomorbatch', NULL, ['class' => 'form-control', 'required' => 'required','placeholder'=>'Input Nomor Batch Disini']) !!}
                <small class="text-danger">{{ $errors->first('nomorbatch') }}</small>
            </div>
          </div>
          <div class="col-md-4">
            <a href="{{ url('/masterobat-batches') }}" class="btn btn-danger btn-flat" onclick="return confirm('Yakin Akan Keluar ?');" >KEMBALI</a>
            <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI BATCH">
        </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="box-body">
        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th>Nama</th>
                <th>Nomor Batches</th>
                <th>Satuan Beli</th>
                <th>Satuan Jual</th>
                <th>Stok</th>
                <th>Harga Umum</th>
                <th>Harga JKN</th>
                <th>Harga Dinas</th>
                <th>Harga Beli</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
                @foreach($masterobat AS $d)
                <tr>
                    <td>{{ $d->nama_obat }}</td>
                    <td>{{ $d->nomorbatch }}</td>
                    <td>{{ $d->satuanbeli_id }}</td>
                    <td>{{ $d->satuanjual_id }}</td>
                    <td>{{ $d->stok }}</td>
                    <td>{{ $d->hargajual_umum }}</td>
                    <td>{{ $d->hargajual_jkn }}</td>
                    <td>{{ $d->hargajual_dinas }}</td>
                    <td>{{ $d->hargabeli }}</td>
                    <td>
                        <a onclick="edit({{ $d->id }})" class="btn btn-info btn-sm btn-flat"><i class="fa fa-edit"></i></a>
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </div>
    <div id="Modal" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                  <form method="POST" class="form-horizontal" id="form">
                      {{ csrf_field() }} {{ method_field('POST') }}
                      <input type="hidden" name="id">
                      <div class="box-body">
                        <div class="col-sm-12">
                          <div class="form-group nama_obatGroup">
                            <label for="nama_obat" class="col-sm-4 control-label">Nama</label>
                            <div class="col-sm-8">
                              <input type="text" value="" name="nama_obat" class="form-control">
                              <small class="text-danger nama_obatError"></small>
                            </div>
                          </div>
                          <div class="form-group nomorbatchGroup">
                            <label for="nomorbatch" class="col-sm-4 control-label">Nomor Batch</label>
                            <div class="col-sm-8">
                              <input type="text" value="" name="nomorbatch" class="form-control">
                              <small class="text-danger nomorbatchError"></small>
                            </div>
                          </div>
                          <div class="form-group stokGroup">
                            <label for="stok" class="col-sm-4 control-label">Stok</label>
                            <div class="col-sm-8">
                              <input type="text" value="" name="stok" class="form-control" readonly>
                              <small class="text-danger stokError"></small>
                            </div>
                          </div>
                          <div class="form-group expireddateGroup">
                            <label for="expireddate" class="col-sm-4 control-label">Expired Date</label>
                            <div class="col-sm-8">
                              <input type="text" value="" name="expireddate" class="form-control">
                              <small class="text-danger expireddateError"></small>
                            </div>
                          </div>
                          <div class="form-group hargabeliGroup">
                            <label for="hargabeli" class="col-sm-4 control-label">Harga Beli</label>
                            <div class="col-sm-8">
                              <input type="text" value="" name="hargabeli" class="form-control">
                              <small class="text-danger hargabeliError"></small>
                            </div>
                          </div>
                          <div class="form-group hargajual_jknGroup">
                            <label for="hargajual_jkn" class="col-sm-4 control-label">Harga JKN</label>
                            <div class="col-sm-8">
                              <input type="text" value="" name="hargajual_jkn" class="form-control">
                              <small class="text-danger hargajual_jknError"></small>
                            </div>
                          </div>
                          <div class="form-group hargajual_umumGroup">
                            <label for="hargajual_umum" class="col-sm-4 control-label">Harga Umum</label>
                            <div class="col-sm-8">
                              <input type="text" value="" name="hargajual_umum" class="form-control">
                              <small class="text-danger hargajual_umumError"></small>
                            </div>
                          </div>
                          <div class="form-group hargajual_dinasGroup">
                            <label for="hargajual_dinas" class="col-sm-4 control-label">Harga Beli</label>
                            <div class="col-sm-8">
                              <input type="text" value="" name="hargajual_dinas" class="form-control">
                              <small class="text-danger hargajual_dinasError"></small>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="satuan_beli" class="col-sm-4 control-label">Satuan Beli</label>
                              <div class="col-sm-8 satuan_beliGroup">
                                  <select name="satuanbeli_id" class="form-control select2" style="width: 100%">
                                    @foreach ($satuanbeli as $d)
                                      <option value="{{ $d->id }}">{{ $d->nama }} </option>
                                    @endforeach
                                  </select>
                                  <span class="text-danger satuan_beliError"></span>
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="satuan_jual" class="col-sm-4 control-label">Satuan Jual</label>
                              <div class="col-sm-8 satuan_jualGroup">
                                  <select name="satuanjual_id" class="form-control select2" style="width: 100%">
                                    @foreach ($satuanjual as $d)
                                      <option value="{{ $d->id }}">{{ $d->nama }} </option>
                                    @endforeach
                                  </select>
                                  <span class="text-danger satuan_jualError"></span>
                              </div>
                          </div>
                          <div class="form-group bacth_milikGroup">
                            <label for="bacth_milik" class="col-sm-4 control-label">Bacth Milik</label>
                            <div class="col-sm-8">
                              <input type="text" name="bacth_milik" class="form-control" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div class="btn-group">
                          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary btn-flat" onclick=save()>Simpan</button>
                        </div>
                      </div>
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
    $('.uang').maskNumber({
      thousands: '.',
      integer: true,
    });

    function reset(){
          $('.nama_obatGroup').removeClass('has-error')
          $('.nama_obatError').text('');
          $('.nomorbatchGroup').removeClass('has-error')
          $('.nomorbatchError').text('');
          $('.expireddateGroup').removeClass('has-error')
          $('.expireddateError').text('');
          $('.hargabeliGroup').removeClass('has-error')
          $('.hargabeliError').text('');
          $('.hargajual_jknGroup').removeClass('has-error')
          $('.hargajual_jknError').text('');
          $('.hargajual_umumGroup').removeClass('has-error')
          $('.hargajual_umumError').text('');
          $('.hargajual_dinasGroup').removeClass('has-error')
          $('.hargajual_dinasError').text('');
      }

    function edit($id){
        reset()
        $('#form')[0].reset();
        $('#Modal').modal({
          backdrop: 'static',
          keyboard : false,
        })
        $('.modal-title').text('Ubah Master Batches');
        $('#inputnama').removeClass('has-error');
        $('#nama-error').html("");

        $.ajax({
          url: '/masterobat-batches/'+$id+'/edit',
          type: 'GET',
          success: function(data) {
            $('input[name="id"]').val(data.LogistikBatch.id);
            $('input[name="nama_obat"]').val(data.LogistikBatch.nama_obat);
            $('input[name="nomorbatch"]').val(data.LogistikBatch.nomorbatch);
            $('input[name="stok"]').val(data.LogistikBatch.stok);
            $('input[name="expireddate"]').val(data.LogistikBatch.expireddate);
            $('input[name="hargabeli"]').val(data.LogistikBatch.hargabeli);
            $('input[name="hargajual_jkn"]').val(data.LogistikBatch.hargajual_jkn);
            $('input[name="hargajual_umum"]').val(data.LogistikBatch.hargajual_umum);
            $('input[name="hargajual_dinas"]').val(data.LogistikBatch.hargajual_dinas);
            $('select[name="satuanbeli_id"]').val(data.LogistikBatch.satuanbeli_id).trigger('change');
            $('select[name="satuanjual_id"]').val(data.LogistikBatch.satuanjual_id).trigger('change');
            $('input[name="bacth_milik"]').val(data.gudang);
            $('input[name="_method"]').val('PATCH');
          }
        });
      };

    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
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
            var url = '{{ route('masterobat-batches.store') }}'
        } else {
            var url = '/masterobat-batches/'+id
        }

        $.post( url, data, function(resp){
          if (resp.sukses == true) {
            alert('Batches Berhasil Di Ubah!!')
            location.replace("{{ url('/masterobat-batches') }}");
          }
        })
    }
  </script>
@endsection
