@extends('master')

@section('header')
  <h1>Keuangan - Tarif Rawat Jalan</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Tarif &nbsp;
          {{-- <a href="{{ url('tarif/create/TA') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a> --}}
        </h3>
      </div>
      <div class="box-body">

        

            <hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th class="text-center" style="vertical-align: middle;">No</th>
                <th class="text-center" style="vertical-align: middle;">Tahun Tarif</th>
                <th class="text-center" style="vertical-align: middle;">Nama</th>
                <th class="text-center" style="vertical-align: middle;">Total </th>
                @foreach (App\Mastersplit::where('kategoriheader_id', 2)->get() as $key => $d)
                  <th class="text-center" style="vertical-align: middle;">{{ $d->nama }}</th>
                @endforeach
                <th class="text-center" style="vertical-align: middle;">Edit</th>
              </tr>
            </thead>

            <tbody>
              @if (isset($tarif) && $tarif->count() > 0 )
                @foreach ($tarif as $key => $d)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->tahuntarif->tahun }}</td>
                    <td>{{ $d->nama }} </td>
                    <td>{{ number_format($d->total) }}</td>
                    @php
                      $split = App\Split::where('tarif_id', $d->id)->get();
                      $jml = $split->count();
                    @endphp
                    @if ($split->count() > 0)
                      @foreach ($split as $key => $r)
                       <td class="text-right">{{ number_format($r->nominal) }} </td>
                      @endforeach
                    @else
                      @for ($i=0; $i < 2; $i++)
                        <td class="text-right">0</td>
                      @endfor
                    @endif

                    <td>
                      <a href="{{ url('tarif/'.$d->id.'/edit/TA') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="7">Data tidak ditemukan</td>
                </tr>
              @endif

            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop

@section('script')
  <script type="text/javascript">
    function hapusTarif(jenis, tahuntarif_id, kategoritarif_id) {
      alert('jenis: '+ jenis +' tahun tarif: '+ tahuntarif_id + ' kategoritarif_id: '+ kategoritarif_id)
    }
  </script>
@endsection
