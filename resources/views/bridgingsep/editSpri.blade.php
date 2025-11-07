@extends('master')
@section('header')
  <h1>EDIT SPRI {{$request->no_surat_kontrol}}<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body"> 
      {{-- VIEW DATA --}}
      <div class="row dataKunjungan">
        <div class="col-sm-12">
          <div class="table-responsive">
            <form method="POST" class="form-horizontal" id="formKunjungan">
            <input type="hidden" name="no_surat_kontrol" value="{{$request->no_surat_kontrol}}"> 

            
            <table class="table table-hover table-striped table-bordered">
              <tbody>
                <tr>
                  <th class="" style="vertical-align: middle;">No. Surat Kontrol</th>
                  <td class="noSuratKontrol" style="width: 50% !important">{{$request->no_surat_kontrol}}</td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Dokter</th>
                  <td class="jenisKontrol">
                    <select name="kode_dokter" class="form-control select2">
                      {{-- <option value="0" {{ ($klasifikasi == '0') ? 'selected' : '' }}>SEMUA</option> --}}
                      @foreach ($dokter as $item)
                        <option value={{@$item->kode_bpjs}} {{ (@$item->kode_bpjs == @$request->kode_dokter) ? 'selected' : '' }}>{{@$item->nama}}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Poli</th>
                  <td>
                    <select name="poli_id" class="form-control select2">
                      {{-- <option value="0" {{ ($klasifikasi == '0') ? 'selected' : '' }}>SEMUA</option> --}}
                      @foreach ($poli as $item)
                        <option value={{@$item->bpjs}} {{ (@$item->bpjs == @$request->poli_id) ? 'selected' : '' }}>{{@$item->nama}}</option>
                      @endforeach
                    </select>
                  </td>
                </tr> 
                <tr>
                  <th class="" style="vertical-align: middle;">Tanggal Rencana Kontrol</th>
                  <td>
                      <input type="text" name="tglRencanaKontrol" value="{{date('d-m-Y',strtotime($request->tglRencanaKontrol))}}" class="form-control datepicker" autocomplete="off">
                  </td>
                </tr>

              </tbody>
            </table>
            <button  type="button" class="btn btn-success pull-right" onclick="update()"><i class="fa fa-edit"></i> SIMPAN</button>
          </form>
          </div>
        </div>
      </div>

      <div class="row dataSep hidden">
        <div class="col-sm-12">
          <div class="table-responsive">
            <h5>DATA SEP</h5>
            <table class="table table-hover table-striped table-bordered">
              <tbody>
                <tr>
                  <th class="" style="vertical-align: middle;">No. SEP</th>
                  <td class="noSep"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Jenis Pelayanan</th>
                  <td class="jnsPelayanan"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Hak Kelas</th>
                  <td class="hakKelas"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Kelamin</th>
                  <td class="kelamin"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Nama</th>
                  <td class="name"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">No.Kartu</th>
                  <td class="no_kartu"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Poli</th>
                  <td class="poliSep"></td>
                </tr>
                <tr>
                  <th class="" style="vertical-align: middle;">Tgl.SEP</th>
                  <td class="tglSep"></td>
                </tr>
                </tr>

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

    function update() {
      var today = new Date();
      var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
      // console.log($('input[name="tglRencanaKontrol"]').val());
      // if($('input[name="tglRencanaKontrol"]').val() < date){
      //   return alert('Tanggal tidak boleh kurang dari hari ini');
      // }
      // if($('input[name="tglRencanaKontrol"]').val() < )
      $.ajax({
        url: '/bridgingsep/update-spri',
        type: 'POST',
        dataType: 'json',
        // data: $('#formKunjungan').serialie(),
        data: {
          data : LZString.compressToBase64($('#formKunjungan').serialize()),
          _token : $('input[name="_token"]').val(),
          _method : 'POST'
          },
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
           alert('Sukses Update SPRI')
           window.location.href = "{{ url('/bridgingsep/sep-rencana-kontrol')}}";
        }
      });
    }


  </script>
@endsection