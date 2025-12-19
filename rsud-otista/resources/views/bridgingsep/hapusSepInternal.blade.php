@extends('master')
@section('header')
  <h1>Hapus SEP Internal<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-6">
          <form method="POST" class="form-horizontal" id="formKunjungan">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="form-group">
              <label for="poli" class="col-sm-3 control-label">No. SEP</label>
              <div class="col-sm-9">
                  <input type="text" name="no_sep" value="" class="form-control" style="width: 100%">
              </div>
            </div>
            <div class="form-group">
              <label for="poli" class="col-sm-3 control-label">No. Surat</label>
              <div class="col-sm-9">
                  <input type="text" name="no_surat" value="" class="form-control" style="width: 100%">
              </div>
            </div> 
            <div class="form-group">
              <label for="poli" class="col-sm-3 control-label">Poli Tujuan</label>
              <div class="col-sm-9">
                  <select name="poli" class="form-control select2" style="width: 100%">
                    @foreach ($poli as $item)
                      <option value="{{$item->bpjs}}">{{$item->nama}}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="tglSep" class="col-sm-3 control-label">Tgl rujukan internal</label>
              <div class="col-sm-9">
                <input type="text" name="tgl" value="{{ date('d-m-Y') }}" class="form-control datepicker">
              </div>
            </div> 
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <button type="button" class="btn btn-danger btn-flat" onclick="deleteSurat()">HAPUS</button>
              </div>
            </div>
          </form>
        </div>
      </div> 
    </div>
      {{-- Loading State --}}
      <div class="overlay hidden">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
    <div class="box-footer">

    </div>
  </div>

@include('bridgingsep.form')

@endsection

@section('script')
  <script src="{{ asset('js/lz-string/libs/lz-string.js') }}"></script>
  <script type="text/javascript">
    $('.select2').select2();
    function deleteSurat() { 
      $.ajax({
        url: '/bridgingsep/hapus-sep-internal',
        type: 'POST',
        dataType: 'json',
        data: $('#formKunjungan').serialize(), 
        beforeSend: function () {
          $('.overlay').removeClass('hidden')
        },
        complete: function () {
           $('.overlay').addClass('hidden')
        }
      })
      .done(function(res) {
        // var decompressData = LZString.decompressFromBase64(res); 
        data = JSON.parse(res)
        
        console.log(data)
        if(data[0] == null){
          $('.overlay').addClass('hidden')
          return alert('Gagal mengambil data, periksa jaringan')
        }

        // console.log(data);
        if (data[0].metaData.code !== '200') {
          // $('tbody').empty()
          return alert(data[0].metaData.message)
        }
        if (data[0].metaData.code == '200') {
           console.log(data)
           alert('Sukses Hapus rencana kontrol')
           window.location.href = "{{ url('/bridgingsep/sep-rencana-kontrol')}}";
        }
      });
    } 

  </script>
@endsection
