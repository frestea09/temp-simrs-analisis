        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
        <thead>
        <tr>
          <th class="text-center">No</th>
          <th class="text-center">Poli</th>
          <th class="text-center">Bayar Sendiri (Umum)</th>
          <th class="text-center">BPJS PBI</th>
          <th class="text-center">BPJS PNS</th>
          <th class="text-center">BPJS SWASTA</th>
          <th class="text-center">BPJS MANDIRI</th>
          <th class="text-center">PASIEN LAMA</th>
          <th class="text-center">PASIEN BARU</th>
          <th class="text-center">TOTAL</th>
        </tr>
       
        </thead>
        <tbody>
          @if ( isset($poli) )
           
            @foreach ($poli as $d)
              @php
                $no = 1;
                  $total_kontraktor = Modules\Registrasi\Entities\Registrasi::where('bayar', 1)
                                      ->where('poli_id', $d->id)
                                      ->whereIn('status_reg', ['J1','J2','J3'])
                                      ->where('tipe_jkn','not like','%PBI%')
                                      ->where('tipe_jkn','not like','%PNS%')
                                      ->where('tipe_jkn','not like','%SWASTA%')
                                      ->where('tipe_jkn','not like','%MANDIRI%')
                                      ->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count()
              @endphp
              <tr>
              <td>{{ $no++ }}</td>
              <td class="text-center">{{$d->nama}}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('bayar', 2)->where('poli_id', $d->id)->whereIn('status_reg', ['J1','J2','J3'])->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('bayar', 1)->where('tipe_jkn','like', '%PBI%')->where('poli_id', $d->id)->whereIn('status_reg', ['J1','J2','J3'])->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('bayar', 1)->where('tipe_jkn','like', '%PNS%')->where('poli_id', $d->id)->whereIn('status_reg', ['J1','J2','J3'])->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('bayar', 1)->where('tipe_jkn','like', '%SWASTA%')->where('poli_id', $d->id)->whereIn('status_reg', ['J1','J2','J3'])->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('bayar', 1)->where('tipe_jkn','like', '%MANDIRI%')->where('poli_id', $d->id)->whereIn('status_reg', ['J1','J2','J3'])->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ $total_kontraktor }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('status', 'lama')->where('poli_id', $d->id)->whereIn('status_reg', ['J1','J2','J3'])->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('status', 'baru')->where('poli_id', $d->id)->whereIn('status_reg', ['J1','J2','J3'])->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              <td class="text-center">{{ Modules\Registrasi\Entities\Registrasi::where('poli_id', $d->id)->whereBetween('created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
            </tr>
            @endforeach
          @endif
          </tbody>
        </table>
        