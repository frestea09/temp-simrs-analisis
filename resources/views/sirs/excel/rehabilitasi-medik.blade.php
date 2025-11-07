<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 3.9</th>
        </tr>
        <tr>
            <th colspan="3">RL 3.9 Pelayanan Rehabilitasi Medik</th>
        </tr>
    </thead>
</table>
<table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
    <thead>
      <tr>
          <th>No</th>
          <th>JENIS TINDAKAN</th>
          <th>Jumlah</th>
        </tr>
      </thead>
      <tbody>
        @if ( isset($kegiatan_rehabilitasi_medik) )
        @php
          $conf = App\Conf_rl\M_config39::all();
          $total = 0;
        @endphp
        @foreach ($conf as $k => $v)
        <tr>
          <td>{{ $v->nomer }}</td>
          <td>{{ $v->kegiatan }}</td>
          <td>
            @foreach ($kegiatan_rehabilitasi_medik as $key => $d)
              @if( $d->id_conf_rl39 == $v->id_conf_rl39 )
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