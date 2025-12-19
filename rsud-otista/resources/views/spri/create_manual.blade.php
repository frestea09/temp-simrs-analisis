@extends('master')

@section('header')
  <h1>Pembuatan SPRI Manual</h1>
@endsection

@section('content')
  <div class="box box-primary">
    {{-- <div class="box-header with-border">
      <h3 class="box-title">
      </h3>
    </div> --}}
    <div class="box-body">

        {{-- <div class="row">
            <div class="col-md-12">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua-active" style="height: 175px;">
                        <div class="row">
                            
                            <div class="col-md-3 text-center"> 
                            </div>
                        </div>
                    </div>
                    <div class="widget-user-image">

                    </div>

                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-md-12">
                        <div class="modal-body">
                          <form method="POST" class="form-horizontal" id="formSPRI">
                            {{ csrf_field() }}
                            <input type="hidden" name="registrasi_id" value="{{$reg->id}}">
                            <input type="hidden" name="id" value="">
                          <div class="table-responsive">
                            <table class="table table-condensed table-bordered">
                              <tbody>
                                <tr>
                                  <th>Nama Pasien </th> <td class="nama">{{@$reg->pasien->nama}}</td>
                                  <th>Umur </th><td class="umur">{{hitung_umur(@$reg->pasien->tgllahir)}}</td>
                                </tr>
                                <tr>
                                  <th>Jenis Kelamin </th><td class="jk" colspan="1">{{@$reg->pasien->kelamin}}</td>
                                  <th>No. RM </th><td class="no_rm" colspan="2">{{@$reg->pasien->no_rm}}</td>
                                </tr>
              
                                <tr>
                                    <th>Dokter Rawat</th>
                                    <td>
                                        <select name="dokter_rawat" class="form-control select2" style="width: 100%">
                                          @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                                              <option value="{{ $d->id }}" {{$d->id == $reg->dokter_id ? 'selected' :''}}>{{ $d->nama }}</option>
                                          @endforeach
                                        </select>
                                    </td>
                                    <th>Dokter Pengirim</th>
                                    <td>
                                        <select name="dokter_pengirim" class="form-control select2" style="width: 100%">
                                          @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->get() as $d)
                                              <option value="{{ $d->id }}" {{$d->id == $reg->dokter_id ? 'selected' : ''}}>{{ $d->nama }}</option>
                                          @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jenis Kamar</th>
                                    <td>
                                      <select name="jenis_kamar" class="form-control select2" style="width: 100%">
                                        @foreach (\Modules\Kamar\Entities\Kamar::all() as $d)
                                            <option value="{{ $d->id }}">{{ @$d->kode }} | {{@$d->kelompokkelas->kelompok}} |{{@$d->kelas->nama}} |{{ @$d->nama }} | </option>
                                        @endforeach
                                      </select>
                                      {{-- <input type="text" name="jenis_kamar" class="form-control"> --}}
                                    </td>
                                    <th>Cara Bayar</th>
                                    <td>
                                        <select name="cara_bayar" class="form-control select2" style="width: 100%">
                                          @foreach (\Modules\Registrasi\Entities\Carabayar::all() as $d)
                                              <option value="{{ $d->id }}" {{$d->id == $reg->bayar ? 'selected' : ''}}>{{ $d->carabayar }}</option>
                                          @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                  <th>Tgl Rencana Kontrol <label class="text-danger">*</label></th>
                                  <td>
                                    <div class="input-group{{ $errors->has('tglRencanaKontrol') ? ' has-error' : '' }}">
                                      <span class="input-group-btn">
                                        <button class="btn btn-default{{ $errors->has('tglRencanaKontrol') ? ' has-error' : '' }}" type="button">Tanggal</button>
                                      </span>
                                      {!! Form::text('tglRencanaKontrol', date('d-m-Y'), ['class' => 'form-control datepicker', 'required' => 'required', 'autocomplete' => 'off']) !!}
                                      <small class="text-danger">{{ $errors->first('tglRencanaKontrol') }}</small>
                                  </div>
                                  </td>
              
                                  <th>No. Kartu<label class="text-danger">*</label></th>
                                  <td>
                                    <div class="input-group{{ $errors->has('no_jkn') ? ' has-error' : '' }}">
                                      {!! Form::text('no_jkn',@$reg->pasien->no_jkn, ['class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off']) !!}
                                      <small class="text-danger">{{ $errors->first('no_jkn') }}</small>
                                  </div>
                                  </td> 
                              </tr>
                                <tr>
                                  <th>SMF<label class="text-danger">*</label></th>
                                  <td>
                                    <div class="input-group{{ $errors->has('tglRencanaKontrol') ? ' has-error' : '' }}">
                                      <select name="poli_id" class="form-control select2" id="">
                                        @foreach ($poli as $item)
                                          <option value="{{$item->bpjs}}" {{$item->id == $reg->poli_id ? 'selected' :''}}>{{$item->nama}}</option>
                                            
                                        @endforeach
                                      </select>
                                      <small class="text-danger">{{ $errors->first('tglRencanaKontrol') }}</small>
                                  </div>
                                  </td> 
                              </tr>
                                <tr>
                                  <th>Diagnosa</th>
                                  <td colspan="3">
                                    <textarea name="diagnosa" class="form-control wysiwyg">{{@$soap ? @$soap->assesment : ''}}</textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Keterangan</th>
                                  <td colspan="3">
                                    <textarea name="keterangan" class="form-control"></textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <th>NO. SPRI</th>
                                  <td colspan="3">
                                      {{-- <div class="col-sm-2" style="padding-left:0">
                                        <button type="button" id="createSPRI" class="btn btn-primary btn-flat"><i class="fa fa-recycle"></i> BUAT SPRI</button>
                                      </div> --}}
                                      <div class="col-sm-7" id="fieldSPRI">
                                        {!! Form::text('no_spri', null, ['class' => 'form-control', 'id'=>'noSPRI','required'=>true]) !!}
                                        {{-- <small>Klik <b>"BUAT SPRI"</b> dahulu, baru klik <b>SIMPAN</b></small> --}}
                                        {{-- <small class="text-danger">{{ $errors->first('no_spri') }}</small> --}}
                                      </div> 
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default btn-flat" data-dismiss="modal" onclick="window.close();">Tutup</button>
                          <button type="button" class="btn btn-primary btn-flat" onclick="saveSPRI()">Simpan</button>
                        </div>
                      {{-- </div> --}}
                    {{-- </div> --}}
                  {{-- </div> --}}
                <hr/> 
                @if (count($surat_inap) > 0)
                    
                <h5 class="text-center"><b>Histori SPRI Pasien</b></h5>
                <table class="table table-bordered" style="font-size:11px;">
                  
                  <tr>
                    <th>No</th>
                    <th>No.SPRI</th>
                    <th>Tanggal Rencana</th>
                    <th>Diagnosa</th>
                    <th>Waktu Input</th>
                    <th>Hapus SPRI</th>
                  </tr>
                  @foreach ($surat_inap as $key=>$item)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{@$item->no_spri ?$item->no_spri : '-'}}</td>
                      <td>{{@date('d-m-Y',strtotime($item->tgl_rencana_kontrol))}}</td>
                      <td>{!!$item->diagnosa!!}</td>
                      <td>{{@date('d-m-Y',strtotime($item->created_at))}}</td>
                      <td>
                        <button class="btn btn-danger btn-sm" onclick="deleteSpri({{ $item->id }})">Hapus</button>
                      </td>
                    </tr>
                      
                  @endforeach
                </table>
                @endif
            </div>
        </div>
    </div>
  </div>
@endsection

@section('script')
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        $(".skin-blue").addClass( "sidebar-collapse" );
        $('.select2').select2();
        $("#date_tanpa_tanggal").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
        $("#date_dengan_tanggal").attr('required', true);
        
        $('#createSK').on('click', function () {
        $("input[name='no_surat_kontrol']").val( ' ' );
        $.ajax({
          url : '{{ url('/bridgingsep/buat-surat-kontrol') }}',
          type: 'POST',
          data: $("#formSK").serialize(), 
          processing: true,
        })
        .done(function(res) {
            data = JSON.parse(res) 
            if (data[0].metaData.code !== "200") {
                return alert(data[0].metaData.message)
            } 
            $("input[name='no_surat_kontrol']").val( data[1].noSuratKontrol ); 
            $("input[name='diagnosa_awal']").val( data[1].namaDiagnosa ); 
        });
      }); 


      $('#createSPRI').on('click', function () {
        $("input[name='no_spri']").val( ' ' );
        $.ajax({
          url : '{{ url('/spri/buat-spri') }}',
          type: 'POST',
          data: $("#formSPRI").serialize(),
          processing: true,
          beforeSend: function () {
            $('.overlay').removeClass('hidden')
          },
          complete: function () {
            $('.overlay').addClass('hidden')
          },
          success:function(data){
            console.log(data.sukses)
            if(data.code !== "200"){
              return swal("Gagal", data.msg, "error");
            }
            $('#fieldSPRI').removeClass('has-error');
            $("input[name='no_spri']").val(data.sukses);
            }
        });
    });

    //CKEDITOR
    CKEDITOR.replace( 'diagnosa', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    // save spri
    function saveSPRI() {
      var token = $('input[name="_token"]').val();
      var diagnosa = CKEDITOR.instances['diagnosa'].getData();
      var form_data = new FormData($("#formSPRI")[0])
      form_data.append('diagnosa', diagnosa)
      if(!diagnosa){
        return swal("Gagal", 'Diagnosa Wajib diisi', "error");
      }
      if($('input[name="no_spri"]').val() == ''){
        return swal("Gagal", 'No. SPRI Wajib terisi', "error");
      }
      
      $.ajax({
        url: '/spri/store',
        type: 'POST',
        dataType: 'json',
        data: form_data,
        async: false,
        processData: false,
        contentType: false,
      })
      .done(function(resp) {
        if (resp.sukses == true) {
          $('input[name="id"]').val(resp.data.id)
          alert('Surat Perintah Rawat Inap berhasil disimpan.')
          location.reload();
        }else{
          return swal("Gagal", resp.msg, "error");
        } 
      });
    }
    </script>
    <script>
      function deleteSpri(id) {
          if (confirm('Apakah Anda yakin ingin menghapus SPRI ini?')) {
              fetch(`/spri/delete/${id}`, {
                  method: 'DELETE',
                  headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}',
                      'Content-Type': 'application/json',
                  },
              })
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Gagal menghapus SPRI. Server mengembalikan status: ' + response.status);
                  }
                  return response.json();
              })
              .then(data => {
                  if (data.success) {
                      alert(data.message);

                      if (document.getElementById(`row-${id}`)) {
                          document.getElementById(`row-${id}`).remove();
                      } else {
                          console.warn(`Baris dengan ID row-${id} tidak ditemukan.`);
                          location.reload();
                      }
                  } else {
                      alert(data.message);
                  }
              })
              .catch(error => {
                  console.error('Terjadi kesalahan:', error);
                  alert('Terjadi kesalahan saat menghapus SPRI. Silakan coba lagi.');
              });
          }
      }
    </script>
@endsection
