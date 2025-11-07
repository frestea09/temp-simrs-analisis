@extends('master')
@section('header')
  <h1>Cari Pasien Operasi Berdasarkan RM </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          {{-- Readmisi&nbsp; --}}
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => 'operasi/cari-pasien', 'class'=>'form-hosizontal']) !!}
        <div class="row">
          <div class="col-md-4">
          <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
            <span class="input-group-btn">
            <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">Nomor RM</button>
            </span>
            @if (session('no_rm'))
                
            {!! Form::text('no_rm', '', ['class' => 'form-control']) !!}
          
            @else
            {!! Form::text('no_rm', null, ['class' => 'form-control']) !!}
                
            @endif
          </div>
          </div>
          <div class="col-md-4">
            <div class="input-group{{ $errors->has('nama') ? ' has-error' : '' }}">
              <span class="input-group-btn">
              <button class="btn btn-default{{ $errors->has('nama') ? ' has-error' : '' }}" type="button">Nama Pasien</button>
              </span>
              @if (session('nama'))
                  
              {!! Form::text('nama', '', ['class' => 'form-control']) !!}
            
              @else
              {!! Form::text('nama', null, ['class' => 'form-control']) !!}
                  
              @endif
            </div>
            </div>
          <div class="col-md-4">
            <input type="submit" name="cari" class="btn btn-primary btn-flat" value="CARI PASIEN">
          </div>
        </div>
      {!! Form::close() !!}
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>No. RM</th>
              <th>Nama</th>
              <th>Status</th>
              <th>Kelas</th>
              <th>Kamar</th>
              <th>Bed</th>
              <th>Tgl Registrasi</th>
              <th>Tindakan</th>
              <th>Catatan</th>
            </tr>
          </thead>
          <tbody>
            @isset($antrian)
              @foreach ($antrian as $key => $d)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->pasien->no_rm }}</td>
                  <td>{{ $d->pasien->nama }}</td>
                  <td>
                    @if (cek_status_reg($d->status_reg)  == 'J')
                      Rawat Jalan
                    @endif
                    @if (cek_status_reg($d->status_reg)  == 'I')
                      Rawat Inap
                    @endif
                    @if (cek_status_reg($d->status_reg)  == 'G')
                      Gawat Darurat
                    @endif
                  </td>
                  <td>{{ !empty($d->kelas_id) ? baca_kelas($d->kelas_id) : NULL }}</td>
                  <td>{{ !empty($d->kamar_id) ? baca_kamar($d->kamar_id) : NULL }}</td>
                  <td>{{ !empty($d->bed_id) ? baca_bed($d->bed_id) : NULL }}</td>
                  <td>{{ $d->created_at }}</td>
                  <td>
                    <a href="{{ url('operasi/tindakan/antrian/'.$d->id) }}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-scissors"></i></a>
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" onclick="coba({{ $d->id }})"><i class="fa fa-book"></i></button>
                  </td>
                </tr>
              @endforeach
              @endisset
          </tbody>
        </table>
        {{-- {{ $antrian->links() }} --}}
      </div>
    </div>
  </div>
       
      <div class="modal fade" id="pemeriksaanModel" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-scrollable" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <form method="POST" class="form-horizontal" id="form">
                <table class="table table-condensed table-bordered">
                  <tbody>
                      <tr>
                        <th>Tanggal Order :<input class="form-control" name="waktu" redonly> </th> 
                      </tr>
                      <tr>
                        <td>
                          <textarea name="pemeriksaan" class="form-control wysiwyg"></textarea>
                        </td>
                      </tr>
                  </tbody>
                </table>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>
    
@endsection

@section('script')
 <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
  <script type="text/javascript">
    //CKEDITOR
    $('.select2').select2();
    
    CKEDITOR.replace( 'pemeriksaan', {
      height: 200,
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });

    function coba(registrasi_id) {
      $('#pemeriksaanModel').modal({
        backdrop: 'static',
        keyboard : false,
      })
      $('.modal-title').text('Catataan Order Operasi')
      $("#form")[0].reset()
      CKEDITOR.instances['pemeriksaan'].setData('')
      $.ajax({
        url: '/operasi/catatan-pasien/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(data) {
        $('input[name="waktu"]').val(data.rencana_operasi)
        CKEDITOR.instances['pemeriksaan'].setData(data.suspect)
      })
      .fail(function() {

      });
    }
</script>
    
@endsection