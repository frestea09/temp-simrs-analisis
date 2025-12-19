@extends('master')
@section('header')
  <h1>Setting Loket Antrian Poli <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class='table-responsive'>
        <span style="color:red">*</span> Kuota berwarna <span style="color:red"><b>Merah</b></span> adalah KUOTA<b> KIOSK</b><br/>
        <span style="color:red">*</span> Kuota berwarna <span style="color:blue"><b>Biru</b></span> adalah KUOTA<b> MOBILE JKN</b>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>Poli</th>
              <th>Kuota</th>
              {{-- <th>Kuota JKN</th> --}}
              <th>Loket</th>
              <th>Praktik</th>
              <th>Buka</th>
              <th>Tutup</th>
              <th>SEN</th>
              <th>SEL</th>
              <th>RAB</th>
              <th>KAM</th>
              <th>JUM</th>
              <th>SAB</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($poli as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->kuota }}</td>
                {{-- <td>{{ $d->kuota_online }}</td> --}}
                <td>{{ $d->loket }}</td>
                <td>
                  @if ($d->praktik == 'Y')
                    <a href="{{ url('frontoffice/tutup-praktik/'.$d->id) }}" onclick="return confirm('Non Aktifkan Antrian <b>{{ strtoupper($d->nama) }}</b> ?')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"></i></a>
                  @else
                    <a href="{{ url('frontoffice/buka-praktik/'.$d->id) }}" onclick="return confirm('Aktifkan Antrian {{ strtoupper($d->nama) }}?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-remove"></i></a>
                  @endif
                </td>
                <td>{{ substr($d->buka,0,-3) }}</td>
                <td>{{ substr($d->tutup,0,-3) }}</td>
                <td><span style="color:red">{{$d->monday}}</span> | <span style="color:blue">{{$d->jkn_monday}}</span></td>
                <td><span style="color:red">{{$d->tuesday}}</span> | <span style="color:blue">{{$d->jkn_tuesday}}</span></td>
                <td><span style="color:red">{{$d->wednesday}}</span> | <span style="color:blue">{{$d->jkn_wednesday}}</span></td>
                <td><span style="color:red">{{$d->thursday}}</span> | <span style="color:blue">{{$d->jkn_thursday}}</span></td>
                <td><span style="color:red">{{$d->friday}}</span> | <span style="color:blue">{{$d->jkn_friday}}</span></td>
                <td><span style="color:red">{{$d->saturday}}</span> | <span style="color:blue">{{$d->jkn_saturday}}</span></td>
                <td>
                  <button type="button" onclick="editKuota({{ $d->id }})" class="btn btn-primary btn-sm btn-flat">
                    <i class="fa fa-edit"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>

  <div class="modal fade" id="modalKuota" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formKuota" class="form-horizontal" role="form">
            {{ csrf_field() }} {{ method_field('POST') }}
					  <input type="hidden" name="id" value="">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="namapoli" class="col-md-3 control-label" readonly >Nama Poli</label>
                  <div class="col-md-9">
                    <input type="text" name="nama" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Jumlah Kuota Non JKN</label>
                  <div class="col-md-9">
                    <input type="text" name="kuota" class="form-control" >
                  </div>
                </div>
                {{-- <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Kuota Mobile JKN</label>
                  <div class="col-md-9">
                    <input type="text" name="kuota_online" class="form-control" >
                  </div>
                </div> --}}
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Buka Praktik</label>
                  <div class="col-md-9">
                    <input type="time" name="buka" class="form-control" style="height: auto;">
                  </div>
                </div>
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Tutup Praktik</label>
                  <div class="col-md-9">
                    <input type="time" name="tutup" class="form-control" style="height: auto;">
                  </div>
                </div>
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Loket Antrian</label>
                  <div class="col-md-9">
                    <select name="loket" class="form-control" >
                      @for ($i = 0; $i <=6 ; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                      @endfor
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Loket B/C</label>
                  <div class="col-md-9">
                    <input type="text" name="bagian" class="form-control" style="height: auto;">
                  </div>
                </div>
              </div>

               <div class="col-md-6">
                <h5 class="text-center">Kuota KIOSK</h5>
                
                <div class="form-group">
                  <label for="senin" class="col-md-3 control-label">Senin</label>
                  <div class="col-md-9">
                    <input type="number" min="0" name="senin" class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Selasa</label>
                  <div class="col-md-9">
                    <input type="number" min="0" name="selasa" class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Rabu</label>
                  <div class="col-md-9">
                    <input type="number" min="0" name="rabu" class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Kamis</label>
                  <div class="col-md-9">
                    <input type="number" min="0" name="kamis" class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  
                  <label for="kuota" class="col-md-3 control-label">Jumat</label>
                  <div class="col-md-9">
                    <input type="number" min="0" name="jumat" class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Sabtu</label>
                  <div class="col-md-9">
                    <input type="number" min="0" name="sabtu" class="form-control" >
                  </div>
                </div>
               </div>
               
               <div class="col-md-6">
                <h5 class="text-center">Kuota MOBILE JKN</h5>
                
                <div class="form-group">
                  <label for="senin" class="col-md-3 control-label">Senin</label>
                  <div class="col-md-9">
                    <input type="number" min="0" name="jkn_senin" class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Selasa</label>
                  <div class="col-md-9">
                    <input type="number" min="0" name="jkn_selasa" class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Rabu</label>
                  <div class="col-md-9">
                    <input type="number" min="0" name="jkn_rabu" class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Kamis</label>
                  <div class="col-md-9">
                    <input type="number" min="0" name="jkn_kamis" class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  
                  <label for="kuota" class="col-md-3 control-label">Jumat</label>
                  <div class="col-md-9">
                    <input type="number" min="0" name="jkn_jumat" class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="kuota" class="col-md-3 control-label">Sabtu</label>
                  <div class="col-md-9">
                    <input type="number" min="0" name="jkn_sabtu" class="form-control" >
                  </div>
                </div>
               </div>
            </div>

            
            
          </form>
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="saveKuota()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalPraktik" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""</h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formPraktik" class="form-horizontal" role="form">
            {{ csrf_field() }} {{ method_field('POST') }}
					  <input type="hidden" name="id" value="">
            <div class="form-group">
              <label for="praktik" class="col-md-3 control-label">Praktik</label>
              <div class="col-md-9">
                <select nama="praktik" class="form-control">
                  <option value="Y">Ya</option>
                  <option value="T">Tidak</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="savePraktik()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
  <script type="text/javascript">
  $(".skin-blue").addClass( "sidebar-collapse" );
    function editKuota(id) {
      $('#modalKuota').modal('show');
      $('.modal-title').text('Ubah Kuota Poli');
      $.ajax({
        url: '/frontoffice/get-poli/'+id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          // console.log(data);
          $('input[name="id"]').val(data.id);
          $('input[name="nama"]').val(data.nama);
          $('input[name="kuota"]').val(data.kuota);
          $('input[name="kuota_online"]').val(data.kuota_online);
          $('input[name="buka"]').val(data.buka);
          $('input[name="tutup"]').val(data.tutup);
          $('select[name="loket"]').val(data.loket);
          $('input[name="bagian"]').val(data.kode_loket);
          $('input[name="senin"]').val(data.monday);
          $('input[name="selasa"]').val(data.tuesday);
          $('input[name="rabu"]').val(data.wednesday);
          $('input[name="kamis"]').val(data.thursday);
          $('input[name="jumat"]').val(data.friday);
          $('input[name="sabtu"]').val(data.saturday);
          $('input[name="jkn_senin"]').val(data.jkn_monday);
          $('input[name="jkn_selasa"]').val(data.jkn_tuesday);
          $('input[name="jkn_rabu"]').val(data.jkn_wednesday);
          $('input[name="jkn_kamis"]').val(data.jkn_thursday);
          $('input[name="jkn_jumat"]').val(data.jkn_friday);
          $('input[name="jkn_sabtu"]').val(data.jkn_saturday);
        }
      });
    }

    function editStatus(id) {
      $('#modalPraktik').modal('show');
      $('.modal-title').text('Ubah Praktik');
      $.ajax({
        url: '/frontoffice/get-poli/'+id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('select[name="praktik"]').val(data.praktik);
        }
      });
    }

    //SAve Kuota
    function saveKuota() {
      $.ajax({
        url: '/frontoffice/save-kuota-poli',
        type: 'POST',
        dataType: 'json',
        data: $('#formKuota').serialize(),
        success: function (data) {
          if(data.sukses == true) {
            $('#modalKuota').modal('hide');
            // location.reload();
            if(!alert('Berhasil Update Loket Antrian Poli')){location.reload()}
          }
        }
      });
    }

    function savePraktik() {
      $.ajax({
        url: '/frontoffice/save-edit-praktik',
        type: 'POST',
        dataType: 'json',
        data: $('#formPraktik').serialize(),
        success: function (data) {
          if(data.sukses == true) {
            $('#modalPraktik').modal('hide');
            location.reload();
          }
        }
      });
    }
  </script>
@endsection
