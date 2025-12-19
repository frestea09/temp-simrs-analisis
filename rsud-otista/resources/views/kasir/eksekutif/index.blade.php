@extends('master')
@section('header')
    <h1>Kasir Eksekutif</h1>

@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      
    </div>
    <div class="box-body">
      @include('kasir.eksekutif.data_eksekutif')
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    $('.select2').select2()
    $(document).ready(function() {
      var tableKasir = $('#tableKasir').DataTable({
        pageLength: 10,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ordering: false,
        ajax: {
          url: '/kasir/data_eksekutif',
          data:function(d){
            d.keyword = $('input[name="keyword"]').val();
            d.poli_id = $('select[name="poli_id"]').val();
            d.tglReg = $('input[name="tglReg"]').val();
            d.tglReg2 = $('input[name="tglReg2"]').val();
            d.status_bayar = $('select[name="status_bayar"]').val(); // ← ini tambahan
          }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {data: 'nama', orderable: false},
            {data: 'no_rm', orderable: false},
            {data: 'dokter_umum', orderable: false},
            {data: 'poli', orderable: false},
            {data: 'cara_bayar', orderable: false},
            {data: 'tanggal', orderable: false},
            {data: 'tagihan', orderable: false},
            {data: 'keterangan', orderable: false},
            {data: 'rincian', orderable: false},
            {data: 'bayar', orderable: false},
            {data: 'billing', orderable: false},
            {data: 'piutang', orderable: false},
            {data: 'cetak_rajal', orderable: false},
            {data: 'kwitansi', orderable: false},
            {data: 'kwitansiTindakan', orderable: false},
            {data: 'kwitansi_penunjang', orderable: false},
        ]
      });

      $(".searchBtn").click(function (){
        tableKasir.draw();
      });
      $('select[name="status_bayar"]').change(function () {
        tableKasir.draw();
      });

      $(".selectPoli").change(function (){
        var keyword = $('input[name="keyword"]');
        keyword.val('');

        tableKasir.draw();
      });

      $(".tglReg2").change(function (){
        var keyword = $('input[name="keyword"]');
        keyword.val('');

        tableKasir.draw();
      });

      if($('select[name="carabayar"]').val() == 1) {
        $('select[name="tipe_jkn"]').removeAttr('disabled');
      } else {
        $('select[name="tipe_jkn"]').attr('disabled', true);
      }

      $('select[name="carabayar"]').on('change', function () {
        if ($(this).val() == 1) {
          $('select[name="tipe_jkn"]').removeAttr('disabled');
        } else {
          $('select[name="tipe_jkn"]').attr('disabled', true);
        }
      });
    });

  </script>
@endsection