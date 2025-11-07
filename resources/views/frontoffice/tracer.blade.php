@extends('master')
@section('header')
  <h1>Tracer <small></small></h1>
@endsection

@section('content')
<style>
  #DataTables_Table_0_processing{
    top: 237px !important;
    position: absolute !important;
  }
</style>
  <div class="box box-primary">
    <div class="box-header with-border">
      <span class="text-red">*</span> Halaman auto refresh <b>5 menit</b> sekali<br/>
      <span class="text-red">*</span> Data yang muncul otomatis mengambil data <b>2 hari terakhir</b><br/>
      <span class="text-red">*</span> Pilih tanggal untuk mengambil data sesuai tanggal<br/>
    </div>
    <div class="box-body">
      <form method="POST" class="form-horizontal" role="form">
        <div class="row">
          <div class="col-md-6 col-lg-6">
            <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
                {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::text('tanggal', null, ['class' => 'form-control datepicker', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('tanggal') }}</small>
                </div>
            </div>
           </div>
        </div>
      </form>
      <hr>
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' style="font-size:11px;">
          <thead>
            <tr>
              <th>No</th>
              <th>Tgl</th>
              <th>Pasien</th>
              <th>RM</th>
              <th>Klinik</th>
              <th>Tanggal Reistrasi</th>
              <th>Cara Bayar</th>
              <th>Penginput</th>
              {{-- <th>Antrian Poli</th> --}}
              <th>Cetak</th>
              <th>Proses</th>
              {{--<th>Petugas</th>--}}
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>

    </div>
    <div class="box-footer">
    </div>
  </div>
  <meta http-equiv="Refresh" content="300"> 

@endsection

@section('script')
<script type="text/javascript">
  $(".skin-blue").addClass( "sidebar-collapse" );
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target).attr("href") // activated tab
          // alert(target);
        });
  $(document).ready(function() {
    $(".select2").select2();
    var table = $('.table').DataTable({
      language : { "url": "/json/pasien.datatable-language.json" },
      serverSide : true,
      rowCallback: function (row, data) {
              if ( data.posisi_tracer == '1') {
                  $(row).addClass('success');
              }else if ( data.posisi_tracer == '-1') {
                  $(row).addClass('danger');
              }else if ( data.posisi_tracer == '2') {
                  $(row).addClass('info');
              }
          },
           buttons: [
              {
              extend: 'print',
              autoPrint: true,
              customize: function (win) {
              // delete the data after printing is complete
              table.clear().draw();
              }
            }
          ],
      ordering : false,
      info : true,
      dom: 'lpftrip',
      autoWidth : false,
      destroy : true,
      pageLength: 100,
      processing : true,
      ajax: '/frontoffice/data-tracer/',
      columns: [
        {data: 'nomorbaris'},
        {data: 'tgl'},
        {data: 'pasien'},
        {data: 'norm'},
        {data: 'poli'},
        {data: 'tanggal'},
        {data: 'bayar'},
        {data: 'penginput'},
        // {data: 'antrian_poli'},
        {data: 'cetak'},
        {data: 'proses'},
        // {data: 'petugas'}
      ]
    });
  });
  // JIKA UBAH TANGGAL

  $('input[name="tanggal"]').on('change', function(e) {
    var tanggal = $(this).val();
    var poli_id = 0;
    // alert(tanggal,poli_id);
    // return
    e.preventDefault()
    var table = $('.table').DataTable({
          language : { "url": "/json/pasien.datatable-language.json" },
          serverSide : true,
          rowCallback: function (row, data) {
            if ( data.posisi_tracer == '1') {
                  $(row).addClass('success');
              }else if ( data.posisi_tracer == '-1') {
                  $(row).addClass('danger');
              }else if ( data.posisi_tracer == '2') {
                  $(row).addClass('info');
              }
          },

          buttons: [
              {
              extend: 'print',
              autoPrint: true,
              customize: function (win) {
              // delete the data after printing is complete
              table.clear().draw();
              }
            }
          ],

          ordering : false,
          info : false,
          autoWidth : false,
          dom: 'lpftrip',
          destroy : true,
          pageLength: 100,
          processing : true,
          ajax: '/frontoffice/data-tracer/'+poli_id+'/'+tanggal,
          columns: [
            {data: 'nomorbaris'},
            {data: 'tgl'},
            {data: 'pasien'},
            {data: 'norm'},
            {data: 'poli'},
            {data: 'tanggal'},
            {data: 'bayar'},
            {data: 'penginput'},
            // {data: 'antrian_poli'},
            {data: 'cetak'},
            {data: 'proses'},
            // {data: 'petugas'}
          ]
        });
  })

  // JIKA UBAH POLI
    $('select[name="poli"]').on('change', function(e) {
      e.preventDefault()
      var poli_id = $(this).val();
      if(poli_id == '') {
        var table = $('.table').DataTable({
          language : { "url": "/json/pasien.datatable-language.json" },
          rowCallback: function (row, data) {
            if ( data.posisi_tracer == '1') {
                  $(row).addClass('success');
              }else if ( data.posisi_tracer == '-1') {
                  $(row).addClass('danger');
              }else if ( data.posisi_tracer == '2') {
                  $(row).addClass('info');
              }
          },
          buttons: [
              {
              extend: 'print',
              autoPrint: true,
              customize: function (win) {
              // delete the data after printing is complete
              table.clear().draw();
              }
            }
          ],

          serverSide : true,
          ordering : true,
          info : false,
          dom: 'lpftrip',
          pageLength: 100,
          autoWidth : false,
          destroy : true,
          processing : true,
          ajax: '/frontoffice/data-tracer/',
          columns: [
            {data: 'nomorbaris'},
            {data: 'tgl'},
            {data: 'pasien'},
            {data: 'norm'},
            {data: 'poli'},
            // {data: 'dokter'},
            {data: 'bayar'},
            {data: 'penginput'},
            // {data: 'antrian_poli'},
            {data: 'cetak'},
            {data: 'proses'},
            // {data: 'petugas'}
          ]
        });
      } else {
        var tanggal = $('input[name="tanggal"]').val();
        var table = $('.table').DataTable({
          language : { "url": "/json/pasien.datatable-language.json" },
          serverSide : true,
          rowCallback: function (row, data) {
            if ( data.posisi_tracer == '1') {
                  $(row).addClass('success');
              }else if ( data.posisi_tracer == '-1') {
                  $(row).addClass('danger');
              }else if ( data.posisi_tracer == '2') {
                  $(row).addClass('info');
              }
          },

          buttons: [
              {
              extend: 'print',
              autoPrint: true,
              customize: function (win) {
              // delete the data after printing is complete
              table.clear().draw();
              }
            }
          ],

          ordering : false,
          info : false,
          autoWidth : false,
          pageLength: 100,
          dom: 'lpftrip',
          destroy : true,
          processing : true,
          ajax: '/frontoffice/data-tracer/'+poli_id+'/'+tanggal,
          columns: [
            {data: 'nomorbaris'},
            {data: 'tgl'},
            {data: 'pasien'},
            {data: 'norm'},
            {data: 'poli'},
            // {data: 'dokter'},
            {data: 'bayar'},
            // {data: 'antrian_poli'},
            {data: 'cetak'},
            {data: 'proses'},
            // {data: 'petugas'}
          ]
        });
      }
    })

  </script>
@endsection
