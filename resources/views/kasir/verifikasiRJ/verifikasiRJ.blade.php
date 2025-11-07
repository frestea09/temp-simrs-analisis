@extends('master')
@section('header')
  <h1>Kasir - Verifikasi Rawat Jalan<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">

      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nomor RM</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Cara Bayar</th>
              <th>Status</th>
              <th>Verifikasi</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($registrasi as $key => $d)
                <td>{{ $no++ }}</td>
                <td>{{ $d->pasien->no_rm }} </td>
                <td>{{ $d->pasien->nama }}</td>
                <td>{{ $d->pasien->alamat }}</td>
                <td>{{ baca_carabayar($d->bayar) }} {{ !empty($d->tipe_jkn) ? ' - '.$d->tipe_jkn : '' }}</td>
                <td>
                  @if (substr($d->status_reg,0,1) == 'J')
                    Rawat Jalan
                  @elseif (substr($d->status_reg,0,1) == 'G')
                    Rawat Darurat
                  @endif
                </td>
                <td>
                  <button type="button" onclick="verifikasi({{ $d->id }})" class="btn btn-primary btn-sm btn-flat">
                    <i class="fa fa-check"></i>
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

  <div class="modal fade" id="modalVerifikasi" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <form method="post" id="formTindakan">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div id="detailVerifikasi">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="saveForm()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    function ribuan(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function verifikasi(registrasi_id) {
      $('#modalVerifikasi').modal('show');
      $('.modal-title').text('Verifikasi Rawat Jalan');
      $('#detailVerifikasi').load('/tindakan/detail-verifikasi-rj/'+registrasi_id);
    }

    function saveForm() {
      var data = $('#formTindakan').serialize();

      $.ajax({
        url: '/tindakan/save-verifikasi-rj',
        type: 'POST',
        dataType: 'json',
        data: data,
        success: function (data) {
          console.log(data);
          if (data.sukses == true) {
            $('#modalVerifikasi').modal('hide');
            location.reload();
          }
        }
      });

    }


  </script>
@endsection
