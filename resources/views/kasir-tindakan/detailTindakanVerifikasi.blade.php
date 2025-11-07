<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed' id="data">
    <thead>
      <tr>
        <th>No</th>
        <th>Tindakan</th>
        <th>Jenis Pelayanan</th>
        <th>Total</th>
        <th>Pelaksana</th>
        <th>Tanggal</th>
        <th>Verif</th>
        <th>Hapus</th>
      </tr>
    </thead>
    <tbody>
      {!! Form::hidden('poli_tipe', $poli_tipe) !!}
      {!! Form::hidden('tipe', $tipe) !!}
      {!! Form::hidden('registrasi_id', $reg->id) !!}
      @foreach ($folio as $key => $d)
        <tr>
          <td>{{ $no++ }}</td>
          <td>{{ $d->namatarif }}</td>
          <td>
            @if ($d->poli_tipe == '')
              Rawat Inap
            @else
            {{ baca_politipe($d->poli_tipe) }} 
            @endif
          </td>
          <td class="text-right">{{ number_format($d->total,0,',','.') }}</td>
          <td>{{ baca_dokter($d->dokter_pelaksana) }}</td>
          <td>{{ $d->created_at->format('d-m-Y') }}</td>
          <td class="text-center">
            @if ($d->verif_kasa == 'Y')
              <input type="checkbox" checked="true" name="verif_kasa{{ $i_verif++ }}" value="{{ $d->id }}">
            @else
              <input type="checkbox" name="verif_kasa{{ $i_verif++ }}" value="{{ $d->id }}">
            @endif
          </td>
          <td class="text-center">
            @if ($d->verif_kasa == 'Y')
              <input type="checkbox" name="hapus{{ $i_hapus++ }}" value="{{ $d->id }}">
            @else
              <input type="checkbox" name="hapus{{ $i_hapus++ }}" value="{{ $d->id }}">
            @endif

          </td>
        
        </tr>
      @endforeach
      {!! Form::hidden('jmlbaris', $no) !!}
    </tbody>
  </table>
</div>

       
