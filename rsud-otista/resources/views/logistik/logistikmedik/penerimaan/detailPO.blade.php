@extends('master')

@section('header')
  <h1>Logistik</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Faktur Penerimaan Barang
           <a href="{{ url('logistikmedik/penerimaan') }}" class="btn btn-default btn-flat btn-sm">KEMBALI</a>
           <a href="{{ url('logistikmedik/penerimaan/add-penerimaan/'.$no_po) }}" class="btn btn-primary btn-flat btn-sm">TAMBAH</a>
      </h3>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th>Tanggal Faktur</th>
              <th>Nomor Faktur</th>
              <th>Supplier</th>
              <th>Cetak</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $d)
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">




</script>
@endsection
