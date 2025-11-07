<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 3.6</th>
        </tr>
        <tr>
            <th colspan="3">RL 3.6 Kegiatan Pembedahan</th>
        </tr>
    </thead>
</table>

<table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
          <thead>
            <tr>
              <th>No</th>
              <th>SPESIALISASI</th>
              <th>Total</th>
              {{-- <th>Khusus</th>
              <th>Besar</th>
              <th>Sedang</th>
              <th>Kecil</th> --}}
            </tr>
          </thead>
          <tbody>
            @if ( isset($rl_pembedahan) )
              @php
               $conf = App\Conf_rl\M_config36::all();
               $total = 0;
              @endphp
              @foreach( $conf as $k => $v )
              <tr>
                <td>{{ $k+1 }}</td>
                <td>{{ $v->kegiatan }}</td>
                <td>
                  @foreach ($rl_pembedahan as $key => $d)
                    @if( $d->id_conf_rl36 == $v->id_conf_rl36 )
                      {{ $d->count }}
                      @php $total += $d->count @endphp
                    @endif
                  @endforeach
                </td>
                {{-- <td></td>
                <td></td>
                <td></td>
                <td></td> --}}
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