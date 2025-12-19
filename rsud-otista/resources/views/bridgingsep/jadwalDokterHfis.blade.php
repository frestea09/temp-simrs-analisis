@extends('master')
@section('header')
  <h1>Jadwal Dokter HFIS<small></small></h1>
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
              <label for="tglSep" class="col-sm-3 control-label">Tanggal</label>
              <div class="col-sm-9">
                <input type="text" name="tgl" value="{{ date('d-m-Y') }}" class="form-control datepicker">
              </div>
            </div>
            <div class="form-group">
              <label for="poli" class="col-sm-3 control-label">Poli</label>
              <div class="col-sm-9">
                  <select name="poli" class="form-control select2" style="width: 100%">
                    @foreach ($poli as $item)
                      <option value="{{$item->bpjs}}">{{$item->nama}}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                <button type="button" class="btn btn-primary btn-flat" onclick="tampilkanHistoriSEP()">TAMPILKAN</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      {{-- VIEW DATA --}}
      <div class="row dataKunjungan hidden">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead class="bg-primary">
                <tr>
                  <th class="text-center" style="vertical-align: middle;">No</th>
                  <th class="text-center" style="vertical-align: middle;">Kode</th>
                  <th class="text-center" style="vertical-align: middle;">Nama</th>
                  <th class="text-center" style="vertical-align: middle;">Hari</th> 
                  <th class="text-center" style="vertical-align: middle;">Jadwal</th>
                  <th class="text-center" style="vertical-align: middle;">Status</th>
                  <th class="text-center" style="vertical-align: middle;">Kapasitas</th>
                  <th class="text-center" style="vertical-align: middle;">-</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
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

    function tampilkanHistoriSEP() {
      $('.respon').html('');
      $.ajax({
        url: '/bridgingsep/jadwal-dokter-hfis',
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
        console.log(data);
        
        // if(data.metadata == 'undefined'){
        //   // console.log(data.metadata)
        //   if(data.metadata.code == 201){
        //     $('.dataKunjungan').removeClass('hidden')  
        //     $('tbody').empty()
        //     $('tbody').append('<tr> <td colspan="8">'+data.metadata.message+'</td> </tr>')
        //   }
        //   return
        // }

        if (data[0].metadata.code == 200) {
          $('.dataKunjungan').removeClass('hidden')
          $('tbody').empty() 
          $('.poli').removeClass('hidden')
          $('.kelasRawat').addClass('hidden')
          $.each(data[1], function(index, val) {
            if(val.libur == '0'){
              val.libur = '<span style="color:green">Tersedia</span>'
            }else{
              val.libur = '<span style="color:red">Libur</span>'
            }
            $('tbody').append('<tr> <td>'+(index + 1)+'</td>  <td>'+val.kodedokter+'</td> <td>'+val.namadokter+'</td>  <td class="text-center">'+val.namahari+'</td> <td>'+val.jadwal+'</td><td class="text-center">'+val.libur+'</td> <td>'
              +val.kapasitaspasien+'</td> <td class="text-center"><a class="btn btn-success btn-xs" href="edit-dokter-hfis/'+val.kodedokter+'/'+val.kodepoli+'/'+val.kodesubspesialis+'">Update</a></td></tr>')
          }); 
          // return
        }else{
            $('.dataKunjungan').removeClass('hidden')  
            $('tbody').empty()
            $('tbody').append('<tr> <td colspan="8">'+data['0'].metadata.message+'</td> </tr>')
        }
      });
    }


  </script>
@endsection
