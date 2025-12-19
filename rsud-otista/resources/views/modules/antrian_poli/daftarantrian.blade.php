@extends('master')

@section('header')
  <h1 style="font-size: 20pt;color:black;font-weight: bold;">Front Office - Daftar Antrian Loket UMUM </h1>
@endsection

@section('content')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
            Data Antrian Hari Ini &nbsp;
          </h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-5">
              <div id="daftarantrian"></div>
            </div>
            {{-- ============================ --}}
            <div class="col-md-7">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Sudah di panggil</h3>
                </div>
                <div class="panel-body">
                  <div class='table-responsive'>
                    <table class='table table-striped table-bordered table-hover table-condensed' id="dataAntrian">
                      <thead>
                        <tr>
                          <th class="text-center">Antrian</th>
                          <th>Waktu Antri</th>
                          <th>Panggil Ulang</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($terpanggil as $key => $d)
                          <tr>
                            <td class="text-center">{{ $d->nomor }}</td>
                            <td>{{ $d->created_at }}</td>
                            <td>

                              @if (cek_registrasi_antrian($d->id, 1) < 1)
                                @if ($d->status <= 2)
                                  <a href="{{ route('antrian.panggilkembali',$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-microphone"></i></a>
                                @endif

                                <button type="button" class="btn btn-success btn-flat btn-sm" onclick="btnProses({{ $d->id }})"><i class="fa fa-registered"></i> Proses</button>
                              @else
                                @php
                                  $reg = \App\RegistrasiAntrian::where('id_antrian', $d->id)->first();
                                @endphp

                                <a href="{{ url('/frontoffice/cetak-tracer/'.$reg->id) }}" class="btn btn-sm btn-flat btn-danger"><i class="fa fa-print"></i> CETAK</a>
                              @endif

                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="panel-footer">

                </div>
              </div>
            </div>
          </div>

        @if (!empty(session('no_sep')))
          <script type="text/javascript">
            window.open("{{ url('cetak-sep/'.session('no_sep')) }}","Cetak SEP", width=600,height=300)
          </script>
        @endif


        </div>
      </div>

{{-- Modal pencarian --}}
<div class="modal fade" id="pasien">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ url('antrian/proses-antrian') }}" id="form-proses">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="antrian_id"> 
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" style="display:grid;">
        <div class="form-group">
          <label class="control-label col-sm-2" for="poli">Poli:</label>
          <div class="col-sm-10">
            <select class="form-control select2" name="poli" required>
              <option selected disabled>- Silahkan Pilih -</option>
              @foreach($data['poli'] as $key => $item)
              <option value="{{ $item->id }}">{{ $item->nama }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="dokter">Dokter:</label>
          <div class="col-sm-10">
            <select class="form-control select2" name="dokter" required>
              <option selected disabled>- Silahkan Pilih -</option>
              @foreach($data['dokter'] as $key => $item)
              <option value="{{ $item->id }}">{{ $item->nama }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
        <button type="button" id="btn-proses" class="btn btn-primary btn-flat">Proses</button>
    </div>
    </div>
  </form>
  </div>
</div>



<!-- jQuery 3 -->
<script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
  $(function () {
    $('#dataAntrian').DataTable({
      'language'    : {
        "url": "/json/pasien.datatable-language.json",
      },
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false
    });
  });

  $(document).ready(function() {
    setInterval(function () {
      $('#daftarantrian').load("{{ route('antrian.daftarpanggil') }}");
    },2000);
  });

  function btnProses(id)
  {
    $('#pasien').modal({backdrop: 'static', keybord: false});
    $('.modal-title').text('Pilih Poli Dokter');
    $('input[name="antrian_id"]').val(id)
  }

  // function searchPasien(antrian_id){
  //   //alert(antrian_id)
  //   $('#pasien').modal({backdrop: 'static', keybord: false});
  //   $('.modal-title').text('Pendaftaran Pasien')
  //   var table;
  //   table = $('#tablePasien').DataTable({
  //     'language': {
  //         "url": "/json/pasien.datatable-language.json",
  //     },
  //     pageLength  : 5,
  //     paging      : true,
  //     lengthChange: false,
  //     searching   : true,
  //     ordering    : false,
  //     info        : false,
  //     autoWidth   : false,
  //     destroy     : true,
  //     processing  : true,
  //     serverSide  : true,
  //     ajax: '/pasien/search-pasien/'+antrian_id+'/'+1,
  //     columns: [
  //         {data: 'nama'},
  //         {data: 'no_rm'},
  //         {data: 'no_rm_lama'},
  //         {data: 'ibu_kandung'},
  //         {data: 'alamat'},
  //         {data: 'nik'},
  //         {data: 'no_jkn'},
  //         {data: 'jkn', searchable: false, sClass: 'text-center'},
  //         {data: 'non-jkn', searchable: false, sClass: 'text-center'}
  //     ]
  //   });
  // }

</script>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
  $('.select2').select2({width:"100%"});
  $(document).on('click','#btn-proses',function(e){
    e.preventDefault();
      let values = $('#form-proses').serialize();
      let url = $('#form-proses').attr('action');

      $.ajax({
          url: url,
          type: "POST",
          data: values ,
          dataType  : 'json',
          success: function (res) { 
            if(res.status == false){
              Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: res.msg
              })
            }else{
              Swal.fire(
                'Sukses!',
                'Antrian Berhasi Diproses!',
                'success'
              )
              location.reload();
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
          }
      });
  })
</script>
@endsection
