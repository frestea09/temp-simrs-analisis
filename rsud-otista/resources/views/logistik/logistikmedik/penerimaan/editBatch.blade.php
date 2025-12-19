@extends('master')

@section('header')
  <h1>Edit Batch</h1>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
         Data Batch
      </h3>
    </div>
    <div class="box-body">
      <form class="form-horizontal" id="" method="POST">
        <hr>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr class="bg-primary">
                    <th class="text-center" style="vertical-align: middle;">Nomer Batch</th>
                    <th class="text-center" style="vertical-align: middle;">Nama Obat</th>
                    <th class="text-center" style="vertical-align: middle;">Expired Date</th>
                    <th class="text-center" style="vertical-align: middle;">Harga Obat</th>
                    <th class="text-center" style="vertical-align: middle;">Jumlah Diterima</th>
                    <th class="text-center" style="vertical-align: middle;">edit</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($batches as $d)
                     @php
                        $po = \App\Logistik\Po::join('masterobats', 'masterobats.id', '=', 'logistik_po.masterobat_id')
                        ->where('logistik_po.no_po', $d->no_po)
                        ->where('masterobats.nama', $d->nama)
                        ->select('logistik_po.id as id_po', 'logistik_po.*', 'masterobats.*')
                        ->first();
                     @endphp
                    <tr>
                      <td>{{ $d->no_faktur }}</td>
                      <td>{{ $d->nama }}</td>
                      <td class="text-center">
                        {{ $d->jumlah_diterima }}
                      </td>
                      <td>{{ number_format($d->harga) }}</td>
                      <td>
                        @if (\App\LogistikBatch::where('bapb_id', $d->id)->first())
                           
                        <a href="{{ url('/logistikmedik/penerimaan/list-batches/'.$d->id) }}" type="button" class="btn btn-default btn-flat"> <i class="fa fa-icon fa-eye"></i>  {{ \App\LogistikBatch::where('bapb_id', $d->id)->sum('jumlah_item_diterima') }}</a>
                        @else
                        <button type="button" class="btn btn-default btn-flat"> <i class="fa fa-icon fa-eye"></i> 0</button>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="13" class="text-right">
                      <a href="{{ url('logistikmedik/penerimaan') }}" class="btn btn-default btn-flat">KEMBALI</a>
                    </th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>




@endsection

@section('script')
@endsection