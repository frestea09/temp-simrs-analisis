{{-- {!! Form::open(['method' => 'POST', 'url' => 'kasir-obat/rawatjalan', 'class'=>'form-horizontal']) !!} --}}
<div class="row">
    <div class="col-md-6">
        {{-- <div class="form-group{{ $errors->has('tanggal') ? ' has-error' : '' }}">
            {!! Form::label('tanggal', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('tanggal', null, ['class' => 'form-control datepicker','autocomplete'=>'off']) !!}
                <small class="text-danger">{{ $errors->first('tanggal') }}</small>
            </div>

        </div> --}}
        {{-- <div class="form-group{{ $errors->has('lunas') ? ' has-error' : '' }}">
            {!! Form::label('lunas', 'Lunas / Blm', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::select('ket_lunas', ['' => '[Semua]', 'N'=> 'Belum Lunas', 'Y'=>'Lunas', 'P'=>'Piutang'], null, ['class' => 'form-control select2', 'style'=>'width: 100%']) !!}
                <small class="text-danger">{{ $errors->first('Lunas/Blm') }}</small>
            </div>
        </div> --}}
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
    <div class="form-group">
      <div class="col-md-6">
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
        {{-- <th>Total Tagihan</th> --}}
        {{-- <th>Status</th> --}}
        <th>Bayar</th>
        {{-- <th>Piutang</th> --}}
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
          url: '/kasir-obat/data_rawatjalan',
          data:function(d){
            d.keyword = $('input[name="keyword"]').val();
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
            {data: 'bayar', orderable: false},
            // {data: 'piutang', orderable: false},
        ]
      });
      $('select[name="status_bayar"]').change(function () {
        tableKasir.draw();
      });
      $(".searchBtn").click(function (){
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
