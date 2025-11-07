<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 3.8</th>
        </tr>
        <tr>
            <th colspan="3">RL 3.8 Pemeriksaan Laboratorium</th>
        </tr>
    </thead>
</table>
<table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Jenis Tindakan</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      @if ( isset($pemeriksaan_laboratorium) )
      @php
        $conf = App\Conf_rl\M_config38::all();
        $total = 0;
      @endphp
        @foreach ($conf as $k => $v)
          <tr>
            <td>{{ $v->nomer }}</td>
            <td>{{ $v->kegiatan }}</td>
            <td>
              @foreach ($pemeriksaan_laboratorium as $key => $d)
                @if( $d->id_conf_rl38 == $v->id_conf_rl38 )
                  {{ $d->count }}
                  @php $total += $d->count @endphp
                @endif
              @endforeach
            </td>
          </tr>
        @endforeach
        <tr>
          <th>###</th>
          <th>Total</th>
          <th>{{ $total }}</th>
        </tr>
      @endif
    </tbody>
  </table>