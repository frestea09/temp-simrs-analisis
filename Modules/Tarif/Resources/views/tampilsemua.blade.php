@extends('master')

@section('header')
  <h1>Semua Tarif</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
           Tarif &nbsp;
          {{-- <a href="{{ url('tarif/create/TG') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a> --}}
        </h3>
      </div>
      <div class="box-body">
        {!! Form::open(['method' => 'POST', 'url' => '/tarif/tampil-jenis-tarif', 'class'=>'form-horizontal']) !!}
      <div class="row">
        <div class="col-md-6">
          
          <div class="form-group">
            <label for="jenis" class="col-md-3">Jenis Tarif</label>
            <div class="col-md-8">
              <select class="form-control select2" name="jenis">
                  <option value="semua"> - </option></option>
                  <option value="TA"> Rawat Jalan</option></option>
                  <option value="TG">IGD</option>
                  <option value="TI"> Rawat Inap</option>

              </select>
            </div>
          </div>
            <div class="form-group">
            <label for="tanggal" class="col-md-3"> &nbsp; </label>
            <div class="col-md-8">
              <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
              <input type="submit" name="excel" class="btn btn-success btn-flat fa-file" value="EXCEL">
              <input type="submit" name="pdf" class="btn btn-success btn-flat fa-file" value="PDF">
            </div>
          </div>
        </div>
      </div>

      {!! Form::close() !!}
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">No</th>
                  <th class="text-center" style="vertical-align: middle;">Nama</th>
                  <th class="text-center" style="vertical-align: middle;">Jenis</th>
                  <th class="text-center" style="vertical-align: middle;">JKN / Umum</th>
                  <th class="text-center" style="vertical-align: middle;">Kategori Header</th>
                  <th class="text-center" style="vertical-align: middle;">Kategori Tarif</th>
                  <th class="text-center" style="vertical-align: middle;">Total</th>
                </tr>
              </thead>
            <tbody>
              @foreach ($tarif as $key => $d)
                <tr class="">
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->tarif }}
                  @if ($d->jenis == 'TG')
                    <td>Tarif IGD</td>
                    @elseif($d->jenis == 'TI')
                    <td>Tarif IRNA</td>
                    @else
                    <td>Tarif IRJ</td>
                  @endif
                  @if ($d->carabayar == 1)
                    <td>JKN</td>
                    @else
                    <td>Umum</td>
                  @endif
                  {{-- <td>{{ $d->carabayar }} --}}
                  <td>{{ $d->kategoriheader }}
                  <td>{{ $d->kategoritarif }}
                  <td>{{ number_format($d->total) }}</td>
                    
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@endsection

{{-- @section('script')
    <script>
      $('table').DataTable();
    </script>
@endsection --}}

@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();

  });

  // $('table').DataTable();

</script>
@endsection