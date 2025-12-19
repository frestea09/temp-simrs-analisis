<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 1.3</th>
        </tr>
        <tr>
            <th colspan="3">RL 1.3 Tempat Tidur </th>
        </tr>
    </thead>
</table>
<table class='table table-striped table-bordered table-hover table-condensed' id="data">
  <thead>
    <tr>
    <th class="text-center" rowspan="2" valign="top">No</th>
    <th class="text-center" rowspan="2" valign="top">JENIS PELAYANAN</th>
    <th class="text-center" rowspan="2" valign="top">JUMLAH TT</th>
    <th class="text-center" colspan="6">PERINCIAN TEMPAT TIDUR PER-KELAS</th>
  </tr>
  <tr>
    <th></th>
    <th></th>
    <th></th>
    <th class="text-center">VVIP</th>
    <th class="text-center">VIP</th>
    <th class="text-center">I</th>
    <th class="text-center">II</th>
    <th class="text-center">III</th>
    <th class="text-center">Kelas Khusus</th>
  </tr>
  </thead>
  <tbody>
    @php
        $jmltt = 0;
        $jmlvvip = 0;
        $jmlvip = 0;
        $jmlkelas1 = 0;
        $jmlkelas2 = 0;
        $jmlkelas3 = 0;
        $jmlkhusus = 0;
    @endphp
    @if ( isset($data) )
      @foreach ($data as $key => $d)
      @php
        $vvip = 0;
        $vip = 0;
        $kelas1 = 0;
        $kelas2 = 0;
        $kelas3 = 0;
      @endphp
        <tr>
          <td>{{ $key+1 }}</td>
          <td>{{ $d->kegiatan }}</td>
          <td>
            @if($d->kamar)
              @php $bed = 0; @endphp
              @foreach($d->kamar as $v)
                @php 
                  // $bed += count($v->bed);
                  $bed += $v->bed->where('aktif','Y')->count();
                @endphp
              @endforeach
              @php $jmltt += $bed; @endphp
              {{ $bed }}
            @else
              {{ 0 }}
            @endif
          </td>
          <td>
            @foreach($d->kamar as $v)
              @if( $v->kelas_id == 1 ) {{-- VVIP --}}
                {{-- @php $vip +=  @endphp --}}
                  @php 
                    // $vip += count($v->bed);
                    $vvip += $v->bed->where('aktif','Y')->count();
                  @endphp
                {{-- {{ $vip }} --}}
              @endif
            @endforeach
            @php $jmlvvip += $vvip; @endphp
            {{ $vvip }}
          </td>
          <td>
            @foreach($d->kamar as $v)
              @if( $v->kelas_id == 2 ) {{-- VIP --}}
                {{-- @php $vip +=  @endphp --}}
                  @php 
                    // $vip += count($v->bed);
                    $vip += $v->bed->where('aktif','Y')->count();
                  @endphp
                {{-- {{ $vip }} --}}
              @endif
            @endforeach
            @php $jmlvip += $vip; @endphp
            {{ $vip }}
          </td>
          <td>
            @foreach($d->kamar as $v)
              @if( $v->kelas_id == 4 ) {{-- kelas 1 --}}
                {{-- @php $kelas1 += 1 @endphp --}}
                @php 
                  // $kelas1 += count($v->bed); 
                  $kelas1 += $v->bed->where('aktif','Y')->count();
                  $jmlkelas1 += $kelas1;
                @endphp
              @endif
            @endforeach
            {{ $kelas1 }}
          </td>
          <td>
            @foreach($d->kamar as $v)
              @if( $v->kelas_id == 5 ) {{-- kelas 2 --}}
                {{-- @php $kelas2 += 1 @endphp --}}
                @php 
                  // $kelas2 += count($v->bed);
                  $kelas2 += $v->bed->where('aktif','Y')->count();
                  $jmlkelas2 += $kelas2;
                @endphp
              @endif
            @endforeach
            {{ $kelas2 }}
          </td>
          <td>
            @foreach($d->kamar as $v)
              @if( $v->kelas_id == 6 ) {{-- kelas 3 --}}
                {{-- @php $kelas3 += 1 @endphp --}}
                @php 
                  // $kelas3 += count($v->bed);
                  $kelas3 += $v->bed->where('aktif','Y')->count();
                  $jmlkelas3 += $kelas3;
                @endphp
              @endif
            @endforeach
            {{ $kelas3 }}
          </td>
          <td>
            @php
              $khusus = ($bed) - ($vip+$kelas1+$kelas2+$kelas3);
              $jmlkhusus += $khusus;
            @endphp
            {{ ($khusus != 0) ? $khusus : 0 }}
          </td>
        </tr>
      @endforeach
      <tr>
        <td>99</td>
        <td>Total</td>
        <td>{{ $jmltt }}</td>
        <td>{{ $jmlvvip }}</td>
        <td>{{ $jmlvip }}</td>
        <td>{{ $jmlkelas1 }}</td>
        <td>{{ $jmlkelas2 }}</td>
        <td>{{ $jmlkelas3 }}</td>
        <td>{{ $jmlkhusus }}</td>
      </tr>
    @endif
    </tbody>
  </table>