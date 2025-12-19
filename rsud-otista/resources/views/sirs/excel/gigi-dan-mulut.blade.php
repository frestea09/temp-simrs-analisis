<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 3.3</th>
        </tr>
        <tr>
            <th colspan="3">RL 3.3 Kegiatan Kesehatan Gigi dan Mulut</th>
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
        @if ( isset($rl_kegiatan_kesehatan_gigi_dan_mulut) )
        @php
         $conf = App\Conf_rl\M_config33::all();
         $total = 0;
        @endphp
        @foreach( $conf as $k => $v )
        <tr>
          <td>{{ $k+1 }}</td>
          <td>{{ $v->kegiatan }}</td>
          <td>
            @foreach ($rl_kegiatan_kesehatan_gigi_dan_mulut as $key => $d)
              @if( $d->id_conf_rl33 == $v->id_conf_rl33 )
                {{ $d->count }}
                @php $total += $d->count @endphp
              @endif
            @endforeach
          </td>
        </tr>
        @endforeach
        <tr>
          <td>###</td>
          <td>Total</td>
          <td>{{ $total }}</td>
        </tr>
        @endif
      </tbody>
    </table>