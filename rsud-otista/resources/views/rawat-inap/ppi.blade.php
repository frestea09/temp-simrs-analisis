@extends('master')
@section('header')
  <h1>Rawat Inap - PPI <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Pasien</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th>No. RM</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Dokter</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $reg->pasien->no_rm }}</td>
              <td>{{ $reg->pasien->nama }}</td>
              <td>{{ $reg->pasien->alamat }}</td>
              <td>{{ baca_dokter($reg->dokter_id) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Tindakan PPI</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <form class="form-horizontal" id="formPpi" method="POST">
            <div class="col-sm-6">
                {{ csrf_field() }}
                <input type="text" class="form-control hidden" name="id" value="">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Pasien</label>
                    <div class="col-sm-8">
                        <select class="form-control select2" name="pasien_id" style="width: 100%;">
                          @foreach ( $pasien as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                          @endforeach
                        </select>
                        <small class="text-danger pasien_idError"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Jenis PPI</label>
                    <div class="col-sm-8">
                        <select class="form-control select2" name="tindakan_id" style="width: 100%;">
                            @foreach ( \App\PPI\MasterPpi::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger tindakan_idError"></small>
                    </div>
                </div>
                <div class="form-group tarifGroup">
                    <label class="col-sm-4 control-label">Jumlah</label>
                    <div class="col-sm-8">
                        <input type="text" name="jumlah_tindakan" value="" class="form-control">
                        <small class="text-danger jumlah_tindakanError"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">&nbsp;</label>
                    <div class="col-sm-8">
                        <button type="button" onclick="save()" class="btn btn-primary btn-flat">SIMPAN</button>
                    </div>
                </div>
            </div>
            </div> 
        </form>
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <table class="table table-bordered table-condensed" id="data">
            <thead>
                <tr>
                    <th width="10px" class="text-center">No</th>
                    <th class="text-center">Jenis</th>
                    {{-- <th class="text-center">Pasien</th> --}}
                    <th class="text-center">Jumlah</th>
                    <th class="text-center">Waktu</th>
                    {{-- <th class="text-center" width="120px">Aksi</th> --}}
                </tr>
            </thead>
            <tbody>
              @if(isset($ppi))
                @foreach ($ppi as $key => $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ !empty(\App\PPI\MasterPpi::where('id', $d->tindakan_id)->first()->nama) ? \App\PPI\MasterPpi::where('id', $d->tindakan_id)->first()->nama : '' }}</td>
                    {{-- <td>{{ $no++ }}</td> --}}
                    <td>{{ $d->jumlah_tindakan }}</td>
                    <td>{{ $d->created_at }}</td>
                  </tr>
                @endforeach
              @endif
            </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script type="text/javascript">
    $('.select2').select2();

    function resetForm(){
        $('.tindakan_idGroup').removeClass('has-error');
        $('.tindakan_idError').text('')
        $('.jumlah_tindakanGroup').removeClass('has-error');
        $('.jumlah_tindakanError').text('')
    }

    function save(){
        var data = $('#formPpi').serialize()
        var id = $('input[name="id"]').val()

        var url = '{{ route('ppi.store') }}'
        $.post( url, data, function(resp){
            resetForm()
            if(resp.sukses == false){
                if(resp.error.tindakan_id){
                    $('.tindakan_idGroup').addClass('has-error');
                    $('.tindakan_idError').text(resp.error.tindakan_id[0])
                }
                if(resp.error.jumlah_tindakan){
                    $('.jumlah_tindakanGroup').addClass('has-error');
                    $('.jumlah_tindakanError').text(resp.error.jumlah_tindakan[0])
                }
            } if(resp.sukses == true){
                $('#formPpi')[0].reset();
                location.reload();
            }
        })

    }

    function hapus(id){
        if(confirm('Yakin transaksi ini akan dihapus ?')){
            $('input[name="id"]').val()
            $('input[name="_method"]').val('PATCH')
            $.get('/ppi/'+id+'/delete', function(resp){
                if(resp.sukses == false){
                    table.ajax.reload();
                }
                if (resp.sukses== true) {
                    table.ajax.reload();
                }  
            })
        }
    }
</script>
@endsection