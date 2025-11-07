@extends('master')

@section('header')
  <h1>Edit <small>Logistik Bacth ID</small></h1>
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
                    <th>Obat ID</th>
                    <th class="text-center">Opname ID</th>
                    <th class="text-center">Opname _ Logistik_batch_id</th>
                    <th class="text-center">Batch _ Logistik_batch_id</th>
                    <th class="text-center">Stok - Logistik Batch ID</th>
                    <th class="text-center">Stok - Nomor Batch</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($stok as $d)
                  {!! Form::model($d, ['route' => ['update-logistik-batch-id-stok', $d->id], 'method' => 'post', 'class' => 'form-horizontal']) !!}

                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ baca_obat($d->masterobat_id) }}</td>
                    <td>{{ $d->masterobat_id }}</td>
                    <td class="text-center">{{ $d->opname_id }}</td>
                    <td class="text-center">
                      @if (App\LogistikOpname::where('id',$d->opname_id)->first())
                        {{ App\LogistikOpname::where('id',$d->opname_id)->first()->logistik_batch_id }}
                      @else
                          
                      @endif
                    </td>
                    <td class="text-center">
                      @if (App\LogistikOpname::where('id',$d->opname_id)->first())
                          
                      {{ batch(App\LogistikOpname::where('id',$d->opname_id)->first()->logistik_batch_id) }}
                      @else
                          
                      @endif
                    </td>
                    <td>
                      @if (App\LogistikOpname::where('id',$d->opname_id)->first())
                          
                      <input class="form-control text-center" name="logistik_batch_id" type="text" value="{{ App\LogistikOpname::where('id',$d->opname_id)->first()->logistik_batch_id }}">
                      @else
                          
                      @endif
                    </td>
                    <td>
                      @if (App\LogistikOpname::where('id',$d->opname_id)->first())
                          
                      <input class="form-control text-center" name="batch_no" type="text" value="{{ batch(App\LogistikOpname::where('id',$d->opname_id)->first()->logistik_batch_id) }}">
                      @else
                          
                      @endif
                    </td>

                    <td>
                          <button type="submit" class="btn btn-success btn-flat"> <i class="fa fa-icon fa-save"></i> Update</button>
                  </td>
                  </tr>
                  {!! Form::close() !!}

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
  $('.select2').select2();

  // $('table').DataTable();

</script>
@endsection
