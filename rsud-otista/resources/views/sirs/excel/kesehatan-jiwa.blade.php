<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 3.11</th>
        </tr>
        <tr>
            <th colspan="3">RL 3.11 Kesehatan Jiwa</th>
        </tr>
    </thead>
</table>
<table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
    <thead>
      <tr>
          <th>No</th>
          <th>Jenis Pelayanan</th>
          <th>Jumlah</th>
        </tr>
      </thead>
      <tbody>
        @if ( isset($rl_kesehatan_jiwa) )
        @php
          $conf = App\Conf_rl\M_config311::all();
          $total = 0;
        @endphp
        @foreach ($conf as $k => $v)
        <tr>
          <td>{{ $v->nomer }}</td>
          <td>{{ $v->kegiatan }}</td>
          <td>
            @foreach ($rl_kesehatan_jiwa as $key => $d)
              @if( $d->id_conf_rl311 == $v->id_conf_rl311 )
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