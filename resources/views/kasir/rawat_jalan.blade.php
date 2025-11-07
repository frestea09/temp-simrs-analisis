{{-- {!! Form::open(['method' => 'POST', 'url' => 'kasir/rawatjalan', 'class'=>'form-horizontal']) !!} --}}
<div class="row">
  <div class="col-md-6">

    <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">Tanggal</button>
      </span>
      {!! Form::text('tglReg', null, [
        'class' => 'form-control datepicker tglReg',
        ]) !!}
    </div>
  </div>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">Poli</button>
      </span>
      <select name="poli_id" id="" class="form-control select2 selectPoli" style="width: 100%;">
        <option value="">-- Semua --</option>
        @foreach($polis as $id => $nama)
          <option value="{{ $id }}">{{ $nama }}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>
<br>
<div class="row">
  
    <div class="col-md-6">
      <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">No RM/NAMA</button>
        </span>
        {!! Form::text('keyword', null, [
          'class' => 'form-control', 
          'autocomplete' => 'off', 
          'placeholder' => 'NO RM/NAMA',
          'required',
          ]) !!}
      </div>
    </div>
    <div class="col-md-6">
      <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">Cara Bayar</button>
        </span>
        <select name="bayar" id="" class="form-control select2 selectBayar" style="width: 100%;">
          <option value="">-- Semua --</option>
          @foreach($bayar as $id => $nama)
            <option value="{{ $nama->id }}">{{ $nama->carabayar }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md-6">
      <br/>
      <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">Status Pembayaran</button>
        </span>
        <select name="status_bayar" class="form-control select2" style="width: 100%;">
          <option value="">-- Semua --</option>
          <option value="lunas">Sudah Dibayar</option>
          <option value="belum">Belum Dibayar</option>
        </select>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <div class="form-group text-right">
        <button class="btn btn-primary btn-flat searchBtn">
            <i class="fa fa-search"></i> Cari
        </button>
      </div>
    </div>
  </div>

{{-- {!! Form::close() !!} --}}
<hr>

<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed' id='tableKasir'>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Pasien</th>
        <th>No. RM</th>
        <th>Dokter</th>
        <th>Klinik</th>
        <th>Cara Bayar</th>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Tagihan</th>
        <th>Pembayaran</th>
        <th>No. Kwitansi</th>
        {{-- <th>Status</th> --}}
        <th>Rincian</th>
        <th>Bayar</th>
        <th>Billing</th>
        {{-- <th>Piutang</th> --}}
        <th>Kwitansi Penunjang</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>

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
          url: '/kasir/data_rawatjalan',
          data:function(d){
            d.keyword = $('input[name="keyword"]').val();
            d.poli_id = $('select[name="poli_id"]').val();
            d.tglReg = $('input[name="tglReg"]').val();
            d.bayar = $('select[name="bayar"]').val();
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
            {data: 'keterangan', orderable: false},
            {data: 'tagihan', orderable: false},
            {data: 'pembayaran', orderable: false},
            {data: 'no_kuitansi', orderable: false},
            {data: 'rincian', orderable: false},
            {data: 'bayar', orderable: false},
            {data: 'billing', orderable: false},
            // {data: 'piutang', orderable: false},
            {data: 'kwitansi_penunjang', orderable: false},
        ]
      });
      $('select[name="status_bayar"]').change(function () {
        tableKasir.draw();
      });

      $(".searchBtn").click(function (){
        tableKasir.draw();
      });

      $(".selectPoli").change(function (){
        var keyword = $('input[name="keyword"]');
        keyword.val('');

        tableKasir.draw();
      });

      $(".tglReg").change(function (){
        var keyword = $('input[name="keyword"]');
        keyword.val('');

        tableKasir.draw();
      });

      $(".selectBayar").change(function (){
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
