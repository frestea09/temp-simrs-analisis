<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 3.10</th>
        </tr>
        <tr>
            <th colspan="3">RL 3.10 Kegiatan Pelayanan Khusus</th>
        </tr>
    </thead>
</table>
<table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
    <thead>
      <tr>
          <th>No</th>
          <th>JENIS KEGIATAN</th>
          <th>Jumlah</th>
        </tr>
      </thead>
      <tbody>
        @if ( isset($rl_pelayanan_khusus) )
        @php
          $conf = App\Conf_rl\M_config310::all();
          $total = 0;
        @endphp
        @foreach ($conf as $k => $v)
        <tr>
          <td>{{ $v->nomer }}</td>
          <td>{{ $v->kegiatan }}</td>
          <td>
            @foreach ($rl_pelayanan_khusus as $key => $d)
              @if( $d->id_conf_rl310 == $v->id_conf_rl310 )
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