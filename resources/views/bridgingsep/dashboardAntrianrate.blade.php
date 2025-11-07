@extends('master')
@section('header')
  <h1>Dashboard Antrian Rate<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-6">
          <form method="POST" target="_blank" class="form-horizontal" id="formKunjungan" action="{{ url('bridgingsep/log-antrian/pdf') }}">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="form-group">
              <label for="tga" class="col-sm-3 control-label">Tanggal Awal</label>
              <div class="col-sm-9">
                <input type="text" name="tglAwal" value="{{ date('d-m-Y') }}" class="form-control datepicker">
              </div>
            </div>
            <div class="form-group">
              <label for="tga" class="col-sm-3 control-label">Tanggal Akhir</label>
              <div class="col-sm-9">
                <input type="text" name="tglAkhir" value="{{ date('d-m-Y') }}" class="form-control datepicker">
              </div>
            </div>
            {{-- <div class="form-group">
              <label for="tga" class="col-sm-3 control-label">Status</label>
              <div class="col-sm-9">
                <select name="status" id="" class="form-control">
                  <option value="">Semua</option>
                  <option value="200">200</option>
                  <option value="201">201</option>
                </select>
                
              </div>
            </div> --}}
            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-3">
                {{-- <button type="sumbit" class="btn btn-success btn-flat" onclick="downloadPDF()">PDF</button> --}}
                <button type="button" class="btn btn-primary btn-flat" onclick="tampilkanDashboardAntrian()">TAMPILKAN</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      {{-- VIEW DATA --}}
      <div class="row dataKunjungan hidden" style="font-size:12px">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead class="bg-primary">
                <tr>
                  <th class="text-center" style="vertical-align: middle;">SEP Terbit</th>
                  <th class="text-center" style="vertical-align: middle;">Kode Booking Terbit</th>
                  <th class="text-center" style="vertical-align: middle;">Rate Antrian</th>
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

    function tampilkanDashboardAntrian() {
    $('.respon').html('');
    $.ajax({
        url: '/bridgingsep/dashboard-antrianrate',
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
        if (!res) {
            $('.overlay').addClass('hidden');
            return alert('Gagal mengambil data, periksa jaringan');
        }

        // Tampilkan data di tabel
        $('.dataKunjungan').removeClass('hidden');
        $('tbody').empty();

        // Tambahkan hasil perhitungan rate ke tabel
        $('tbody').append('<tr>' +
            '<td>' + res.total_sep + '</td>' +
            '<td>' + res.total_kode_booking + '</td>' +
            '<td>' + res.rate_antrian + '</td>' +
        '</tr>');
    });
  }

    function downloadPDF(){
      $('.respon').html('');
      var tglAwal = $('input[name="tglAwal"]').val();
      var tglAkhir = $('input[name="tglAkhir"]').val();
      var tglAkhir = $('select[name="status"]').val();

      window.location.href();
    }
  </script>
@endsection
