@extends('master')

@section('header')
  <h1>Android - Slider</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        {{-- <h3 class="box-title">
            <strong>{!! $data['content']->content_title !!}</strong>
        </h3> --}}
          <div align="right">
              <a href="{{ url('android/konfigurasi') }}" class="btn btn-default btn-flat btn-sm">Kembali</a>
              <a href="javascript:void(0)" class="btn btn-primary btn-flat btn-sm add-data" >Tambah</a>
          </div>
      </div>
         <div class="box-body">
            <div class="box-body">
                <div class='table-responsive'>
                    <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
                      <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Gambar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($data['slider'] as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a href="{{ url($item->slider_path.$item->slider_img) }}" target="_blank">Lihat Gambar</a>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-md btn-warning edit-data" data-id="{{ $item->id }}" data-source='[{
                                    "id": "{{ $item->id }}",
                                    "slider_path": "{{ $item->slider_path }}",
                                    "slider_img": "{{ $item->slider_img }}",
                                }]'>Edit</a>
                                <a href="javascript:void(0)" class="btn btn-md btn-danger delete-data" data-id="{{ $item->id }}">Hapus</a>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
        </div>
    </div>

    <div class="modal fade" id="modal-data">
        <div class="modal-dialog">
          <div class="modal-content" style="margin-top:100px;">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title text-center" id="modal-data-title">Form Halaman Baru</h4>
            </div>
            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <form method="POST" id="form-delete" style="display:none;" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-success">Ya</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                </form>
    
                <form method="POST" action="" id="form-update" style="display:none;" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id">
                    <div style="display: grid;margin-bottom: 30px;">
                        <div class="form-group{{ $errors->has('gambar') ? ' has-error' : '' }}">
                            {!! Form::label('Gambar', 'Gambar', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::file('gambar', null , ['class' => 'form-control']) !!}
                                <small class="text-danger">{{ $errors->first('gambar') }}</small>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                </form>

                <form method="POST" action="" id="form-add" style="display:none;" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div style="display: grid;margin-bottom: 30px;">
                        <div class="form-group{{ $errors->has('gambar') ? ' has-error' : '' }}">
                            {!! Form::label('Gambar', 'Gambar', ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::file('gambar', null , ['class' => 'form-control']) !!}
                                <small class="text-danger">{{ $errors->first('gambar') }}</small>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">BATAL</button>
                </form>
            </div>
          </div>
        </div>
    </div>

@endsection

@section('script')
<script>
    $(document).ready(function(){
        $(document).on('click','.edit-data', function(){
            let id = $(this).attr('data-id');
            let url = window.location.origin+'/android/slider/'+id;
            let source = eval($(this).attr('data-source'));
            jQuery('#modal-data').modal('show', {
                backdrop: 'static'
            });
            $('input[name="id"]').val(id);
            $('input[name="manaj_nama"]').val(source[0].manaj_nama);
            $('#modal-data-title').html('Edit Data');
            $('#form-update').attr('action',url)
            $('#form-update').show();
            $('#form-delete').hide();
            $('#form-add').hide();
        })

        $(document).on('click','.add-data', function(){
            let id = $(this).attr('data-id');
            let url = window.location.origin+'/android/slider';
            let source = eval($(this).attr('data-source'));
            jQuery('#modal-data').modal('show', {
                backdrop: 'static'
            });
            $('#modal-data-title').html('Tambah Data');
            $('#form-add').attr('action',url)
            $('#form-add').show();
            $('#form-delete').hide();
            $('#form-update').hide();
        })

        $(document).on('click','.delete-data', function(){
            let id = $(this).attr('data-id');
            let url = window.location.origin+'/android/slider/'+id;
            jQuery('#modal-data').modal('show', {
                backdrop: 'static'
            });
            $('#modal-data-title').html('Yakin Akan Menghapus Data ?');
            $('#form-delete').attr('action',url)
            $('#form-update').hide();
            $('#form-add').hide();
            $('#form-delete').show();
        })
    })
</script>
@endsection