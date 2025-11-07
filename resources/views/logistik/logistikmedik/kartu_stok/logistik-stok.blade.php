@extends('master')

@section('header')
  <h1>Logistik Stok sebagai Acuan Data <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
    </div>
    <div class="box-body">
        
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-condensed">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Master Obat ID</th>
                    <th>Logistik Batch ID</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($stok as $d)

                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ baca_obat($d->masterobat_id) }}</td>
                    <td>{{ $d->masterobat_id }}</td>
                    <td>{{ $d->logistik_batch_id }}</td>
                    <td>{{ $d->keterangan }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
            
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">

  $('table').DataTable();

</script>
@endsection
