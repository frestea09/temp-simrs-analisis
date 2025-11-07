@extends('master')

@section('header')
  <h1>Logistik - Retur Obat Rusak ke Supplier
    <a href="{{ url('/retur-obat-rusak/create') }}" class="btn btn-success"> <i class="fa fa-icon fa-plus"></i> BUAT RETUR</a>
  </h1>

@endsection

@section('content')
@isset($returobatrusak)
    
<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
          Retur Obat Rusak
      </h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
         <table class="table table-hover table-condensed table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Nomor Batch</th>
                <th>Jumlah Retur</th>
                <th>Keterangan</th>
                <th>Obat dari</th>
                <th>Status</th>
                @role('logistikmedik')
                <th>Harga Beli</th>
                <th>Supplier</th>
                <th>TGL Diterima Supplier</th>
                <th>Penerima</th>
                <th>Update</th>
                @endrole
              </tr>
            </thead>
            <tbody>
              @foreach ($returobatrusak as $i)
              <form action="{{ url('penyerahan-obat-rusak-supplier') }}" method="POST" class="form-horizontal" >
                {{ csrf_field() }}
                <input type="hidden" name="obatrusak_id" value="{{ $i->id }}">
                <input type="hidden" name="user_gudang_pusat" value="{{ Auth::user()->gudang_id }}">
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ baca_obat($i->masterobat_id) }}</td>
                  <td>{{ batch($i->logistik_batch_id) }}</td>
                  <td>{{ $i->jumlahretur }}</td>
                  <td>{{ $i->keterangan  }}</td>
                  <td>{{ baca_gudang_logistik($i->gudang_id) }}</td>
                  <td>
                    @if ($i->status == 'belum')
                        <span class="label label-warning">Belum Diterima</span>
                    @elseif($i->status == 'diterima')
                        <span class="label label-success">Diterima Supplier</span>
                    @else    
                        <span class="label label-danger">Ditolak Supplier</span>
                    @endif
                  </td>
                  @role('logistikmedik')
                  <td style="width: 10%">
                    @if ($i->hargabeli == NULL)
                        
                    <input type="text" name="hargabeli" value="{{ $i->hargabeli }}">
                    @else
                    <input type="hidden" name="hargabeli" value="{{ $i->hargabeli }}">
                    {{ $i->hargabeli }}
                    @endif
                  </td>
                  <td>
                    @if ( App\Logistik\LogistikSupplier::where('id', $i->supplier_id)->first())
                    {{ App\Logistik\LogistikSupplier::where('id', $i->supplier_id)->first()->nama }}
                    <input type="hidden" name="supplier_id" value="{{ $i->supplier_id }}">

                    @else
                      <select name="supplier_id"  class="form-control select2"  >
                        <option value="">[ -- ]</option> 
                        @foreach (\App\Logistik\LogistikSupplier::all() as $s)
                        {{-- <option value="{{ $s->id }}"  {{  !empty($i->supplier_id == $s->id) ? "selected" : "" }}>{{ $s->nama }}</option> --}}
                          <option value="{{ $s->id }}">{{ $s->nama }}</option>
                        @endforeach
                      </select>
                    @endif
                  </td>
                  <td style="width:10%">
                    @if ($i->status == 'belum')
                      <input type="text" name="tglditerima" class="form-control datepicker">
                    @else    
                      {{ date('d-m-Y', strtotime($i->tgl_diterima)) }}
                    @endif
                  </td>
                  <td style="width:10%">
                    @if ($i->status == 'belum')
                    <input type="text" name="penerima" class="form-control">
                    @else    
                    {{ $i->nama_penerima }}
                    @endif
                  </td>
                  <td>
                    @if ($i->status == 'belum')
                    <button type="submit" class="btn btn-primary btn-flat">Serahkan</button>
                    @else    
                    <button disabled class="btn btn-success btn-flat"> <i class="fa fa-check" aria-hidden="true"></i> </button>
                    @endif
                  </td>
                  @endrole
                </tr>
              </form>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
  </div>
@endisset
@endsection

@section('script')
<script type="text/javascript">
  $('.select2').select2()

</script>
@endsection
