@extends('master')

@section('header')
  <h1>Ubah DPJP </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <form class="form-horizontal" method="post">
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="tanggal" class="col-sm-3 control-label">Tanggal</label>
                    <div class="col-sm-9">
                        <input type="text" name="tga" class="form-control datepicker" id="" placeholder="" autocomplete="off">
                        <span class="text-danger"></p>
                    </div>
                  </div>
              </div>
              {{-- <div class="col-md-6">
                  <div class="form-group">
                    <label for="tanggal" class="col-sm-3 control-label">Tanggal Akhir</label>
                    <div class="col-sm-9">
                        <input type="text" name="tgb" class="form-control datepicker" id="" placeholder="" autocomplete="off">
                        <span class="text-danger"></p>
                    </div>
                  </div>
              </div> --}}
          </div>
      </form>
      <hr>
      {{-- ================================================================================================== --}}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='dataUbahDpjp'>
          <thead>
            <tr>
              <th>RM</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Poli Tujuan</th>
              <th>Cara Bayar</th> 
              <th>Dokter</th> 
              <th>Ubah</th>
              {{-- <th>SEP</th> --}}
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <br><br><br>

      {{-- Cetak SEP --}}
       @if (!empty(session('no_sep')))
          <script type="text/javascript">
            window.open("{{ url('cetak-sep/'.session('no_sep')) }}","Cetak SEP", width=600,height=300)
          </script>
        @endif

    </div>
    <div class="box-footer">
    </div>
  </div>

  <div class="modal fade" id="ubahDpjpModal" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
            <div class='table-responsive'>
              <table class='table table-striped table-bordered table-hover table-condensed'>
                <tbody>
                    <tr>
                      <th>No. RM</th> <td id="norm"></td>
                    </tr>
                  <tr>
                    <th>Nama</th> <td id="nama"></td>
                  </tr>
                  <tr>
                    <th>Alamat</th> <td id="alamat"></td>
                  </tr>
                  {{-- <tr>
                    <th>Dokter</th> <td id="dokter"></td>
                  </tr> --}}
                  <tr>
                    <th>Poli Tujuan</th> <td id="poli"></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <form class="form-horizontal" id="formDpjp" method="post">
                {{ csrf_field() }} {{ method_field('POST') }}
                <input type="hidden" name="id" value="">

                <div class="form-group" id="poliGroup">
                  <label for="poli_id" class="col-sm-3 control-label">Poli Tujuan</label>
                  <div class="col-sm-9">
                      <select class="form-control select2" name="poli_id" style="width: 100%">
                          @foreach (Modules\Poli\Entities\Poli::select('id', 'nama')->get() as $key => $d)
                              <option value="{{ $d->id }}">{{ $d->nama }}</option>
                          @endforeach
                      </select>
                      <span class="text-danger" id="poliError"></p>
                  </div>
                </div>

                <div class="form-group" id="bayarGroup">
                  <label for="carabayar" class="col-sm-3 control-label">Cara Bayar</label>
                  <div class="col-sm-9">
                      <select class="form-control select2" name="carabayar" style="width: 100%">
                          @foreach (Modules\Registrasi\Entities\Carabayar::select('id', 'carabayar')->get() as $key => $d)
                              <option value="{{ $d->id }}">{{ $d->carabayar }}</option>
                          @endforeach
                      </select>
                      <span class="text-danger" id="carabayarError"></p>
                  </div>
                </div>

                <div class="form-group" id="tipeJKNGroup">
                  <label for="tipe_jkn" class="col-sm-3 control-label">Tipe JKN</label>
                  <div class="col-sm-9">
                      <select class="form-control select2" name="tipe_jkn" style="width: 100%">
                        @foreach (\Modules\Jenisjkn\Entities\Jenisjkn::all() as $d)
                            <option value="{{ $d->nama }}">{{ $d->nama }}</option>
                        @endforeach
                      </select>
                      <span class="text-danger" id="tipe_jknError"></p>
                  </div>
                </div>

                  {{-- YANG DITAMBAH --}}
                <div class="form-group" id="sebabGroup">
                  <label for="carabayar" class="col-sm-3 control-label">Sebab sakit</label>
                  <div class="col-sm-9">
                     <select class="form-control select2" name="sebabsakit" style="width: 100%">
                          <option value=""> </option>
                         @foreach (Modules\Sebabsakit\Entities\Sebabsakit::select('id', 'nama')->get() as $key => $d)
                              <option value="{{ $d->id }}">{{ $d->nama }}</option>
                         @endforeach
                     </select>
                      <span class="text-danger" id="carabayarError"></p>
                  </div>
                </div>
                <div class="form-group" id="bayarGroup">
                  <label for="carabayar" class="col-sm-3 control-label">Dokter DPJP</label>
                  <div class="col-sm-9">
                     <select class="form-control select2" name="dokter_id" style="width: 100%">
                         @foreach (Modules\Pegawai\Entities\Pegawai::where('kategori_pegawai', 1)->select('id', 'nama')->get() as $key => $d)
                              <option value="{{ $d->id }}">{{ $d->nama }}</option>
                         @endforeach
                     </select>
                      <span class="text-danger" id="carabayarError"></p>
                  </div>
                </div>

              {{-- @role('administrator') --}}
                <div class="form-group" id="bayarGroup">
                  <label for="tanggal" class="col-sm-3 control-label">Tanggal</label>
                  <div class="col-sm-9">
                    <input class="form-control datepicker" type="text" value="{{date("d-m-Y")}}" name="tgla"/>
                  </div>
                </div>
              {{-- @endrole --}}
            </form>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
                <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Batal</button>
                <button type="button" id="saveDpjp" class="btn btn-success btn-flat">Simpan</button>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('.select2').select2()
    //SHOW DATA
    $(document).ready(function() {
            var tga = $('input[name="tga"]').val();
            var tgb = $('input[name="tga"]').val();

            if(tga !='' && tga !='')            {
                url = '/frontoffice-data-ubah-dpjp/'+tga+'/'+tgb;
            } else {
                url = '/frontoffice-data-ubah-dpjp';
            }

            var table;
            table = $('#dataUbahDpjp').DataTable({
                'language'    : {
                  "url": "/json/pasien.datatable-language.json",
                },

                paging      : true,
                lengthChange: false,
                searching   : true,
                ordering    : false,
                info        : false,
                autoWidth   : false,
                destroy     : true,
                processing  : true,
                serverSide  : true,
                ajax: url,
                columns: [
                  {data: 'no_rm'},
                  {data: 'nama'},
                  {data: 'alamat'},
                  {data: 'poli'},
                  {data: 'bayar'},
                  {data: 'dokter'},
                  {data: 'ubah'},
                  //{data: 'create_sep'}
              ]
            });
        });

    //FILTER TANGGAL
        $('input[name="tga"]').on('change', function() {
            var tga = $('input[name="tga"]').val()
            var tgb = $(this).val();

            $('#dataUbahDpjp').empty();
            $('#dataUbahDpjp').DataTable({
                'language'    : {
                  "url": "/json/pasien.datatable-language.json",
                },

                destroy     : true,
                paging      : true,
                lengthChange: false,
                searching   : true,
                ordering    : false,
                info        : false,
                autoWidth   : false,
                processing  : true,
                serverSide  : true,
                ajax: '/frontoffice-data-ubah-dpjp/'+tga+'/'+tgb,
                columns: [
                  {data: 'no_rm'},
                  {data: 'nama'},
                  {data: 'alamat'},
                  {data: 'poli'},
                  {data: 'bayar'},
                  {data: 'dokter'},
                  {data: 'ubah'},
                  // {data: 'sebabsakit'},
                  //{data: 'create_sep'}
              ]
            });
        });
        //SET JKN PBI NON PBI
        $('select[name="carabayar"]').on('change', function() {
            if($(this).val() == 1) {
                $('select[name="tipe_jkn"]').removeAttr('disabled');
            } else {
                $('select[name="tipe_jkn"]').attr('disabled', 'disabled');
            }
        })
        //FORM UBAH DPJP
        function ubahDpjp(id) {
            console.log(id)
            $('#ubahDpjpModal').modal('show');
            $('.modal-title').text('Ubah DPJP');

            $.ajax({
                url: '/frontoffice-data-detail-reg/'+id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('select[name="carabayar"]').val(data.bayar).trigger('change');
                    $('select[name="poli_id"]').val(data.poli_id).trigger('change');
                    $('select[name="tipe_jkn"]').val(data.tipe_jkn).trigger('change');
                    $('select[name="dokter_id"]').val(data.dokter_id).trigger('change');
                    $('input[name="id"]').val(data.id);

                    $('#tipeJKNGroup').removeClass('has-error');
                    $('#tipe_jknError').html('');

                    $('#norm').html(data.no_rm);
                    $('#nama').html(data.nama);
                    $('#alamat').html(data.alamat);
                    // $('#dokter').html(data.dokter.namadokter);
                    $('#poli').html(data.poli);

                    if($('select[name="carabayar"]').val() == 1) {
                        $('select[name="tipe_jkn"]').removeAttr('disabled');
                        $('select[name="tipe_jkn"]').attr('required', true);
                    } else {
                        $('select[name="tipe_jkn"]').attr('disabled', 'disabled');
                    }
                }
            });
        };

    //SAVE UBAH DPJP
        $(document).on('click', '#saveDpjp', function(e) {
            e.preventDefault();
            $.ajax({
                url: '/frontoffice/supervisor/saveubahdpjp',
                type: 'POST',
                dataType: 'json',
                data: $('#formDpjp').serialize(),
                success: function (data) {
                    console.log(data);
                    if(data.sukses == false) {
                        $('#tipeJKNGroup').addClass('has-error');
                        $('#tipe_jknError').html(data.errors.tipe_jkn[0]);
                    }
                    if(data.sukses == true){
                        $('#ubahDpjpModal').modal('hide');
                        location.reload();
                    }
                }
            });
        })


    </script>

@endsection
