<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 3.7</th>
        </tr>
        <tr>
            <th colspan="3">RL 3.7 Kegiatan Radiologi</th>
        </tr>
    </thead>
</table>
<table class='table table-striped table-bordered table-hover table-condensed' id="data">
    <thead>
      <tr>
          <th>No</th>
          <th>JENIS KEGIATAN</th>
          <th>Jumlah</th>
        </tr>
      </thead>
      <tbody>
        @if ( isset($kegiatan_radiologi) )
        @php
          $conf = App\Conf_rl\M_config37::all();
          $total = 0;
        @endphp
        <tr>
          <th colspan="3">RADIODIAGNOSTIK</th>
        </tr>
        @foreach( $conf->whereIn('id_conf_rl37',[1,2,3,4,5,6,7,8,9]) as $k => $v )
        <tr>
          <td>{{ $k+1 }}</td>
          <td>{{ str_replace('RADIODIAGNOSTIK','',$v->kegiatan) }}</td>
          <td>
            @foreach ($kegiatan_radiologi as $key => $d)
                @if( $d->id_conf_rl37 == $v->id_conf_rl37 )
                  {{ $d->count }}
                  @php $total += $d->count @endphp
                @endif
            @endforeach
          </td>
        </tr>
        @endforeach
        <tr>
          <th colspan="3">RADIOTHERAPI</th>
        </tr>
        @foreach( $conf->whereIn('id_conf_rl37',[10,11]) as $k => $v )
        <tr>
          <td>{{ $k+1 }}</td>
          <td>{{ str_replace('RADIOTHERAPI','',$v->kegiatan) }}</td>
          <td>
            @foreach ($kegiatan_radiologi as $key => $d)
                @if( $d->id_conf_rl37 == $v->id_conf_rl37 )
                  {{ $d->count }}
                  @php $total += $d->count @endphp
                @endif
            @endforeach
          </td>
        </tr>
        @endforeach
        <tr>
          <th colspan="3">KEDOKTERAN NUKLIR</th>
        </tr>
        @foreach( $conf->whereIn('id_conf_rl37',[12,13,14]) as $k => $v )
        <tr>
          <td>{{ $k+1 }}</td>
          <td>{{ str_replace('KEDOKTERAN NUKLIR','',$v->kegiatan) }}</td>
          <td>
            @foreach ($kegiatan_radiologi as $key => $d)
                @if( $d->id_conf_rl37 == $v->id_conf_rl37 )
                  {{ $d->count }}
                  @php $total += $d->count @endphp
                @endif
            @endforeach
          </td>
        </tr>
        @endforeach
        <tr>
          <th colspan="3">IMAGING/PENCITRAAN</th>
        </tr>
        @foreach( $conf->whereIn('id_conf_rl37',[15,16,17]) as $k => $v )
        <tr>
          <td>{{ $k+1 }}</td>
          <td>{{ str_replace('IMAGING/PENCITRAAN','',$v->kegiatan) }}</td>
          <td>
            @foreach ($kegiatan_radiologi as $key => $d)
                @if( $d->id_conf_rl37 == $v->id_conf_rl37 )
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