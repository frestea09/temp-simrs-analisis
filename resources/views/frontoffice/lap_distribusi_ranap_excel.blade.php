
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
          <thead>
          <tr>
            <th rowspan="3" class="text-center">No</th>
            <th rowspan="3" class="text-center">RUANGAN</th>
            <th colspan="6" class="text-center">Jumlah Pasien Per Status Bayar</th>
            <th colspan="3" rowspan="2" class="text-center">Jumlah Pasien Per Status</th>
          </tr>
          <tr>
            <th rowspan="2" class="text-center">Bayar Sendiri (Umum)</th>
            <th colspan="4" class="text-center">KONTRAK</th>
            <th rowspan="2" class="text-center">KONTRAKTOR</th>
          </tr>
          <tr>
            <th class="text-center">BPJS PBI</th>
            <th class="text-center">BPJS PNS</th>
            <th class="text-center">BPJS SWASTA</th>
            <th class="text-center">BPJS MANDIRI</th>
            <th class="text-center" rowspan="2">LAMA</th>
            <th class="text-center" rowspan="2">BARU</th>
            <th class="text-center" rowspan="2">TOTAL</th>
          </tr>
         
          </thead>
          <tbody>
            @if ( isset($kelompok) )
             
              @foreach ($kelompok as $d)
                @php
                    $no = 1;
                    $total_kontraktor = App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')
                                        ->where('registrasis.bayar', 1)
                                        ->where('rawatinaps.kelompokkelas_id', $d->id)
                                        ->where('registrasis.tipe_jkn', '!=','PBI')
                                        ->where('registrasis.tipe_jkn', '!=','PNS')
                                        ->where('registrasis.tipe_jkn', '!=','SWASTA')
                                        ->where('registrasis.tipe_jkn', '!=','MANDIRI')
                                        ->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count()
                @endphp
                <tr>
                <td>{{ $no++ }}</td>
                <td class="text-center">{{baca_kelompok($d->id)}}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.bayar', 2)->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.bayar', 1)->where('registrasis.tipe_jkn', 'PBI')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.bayar', 1)->where('registrasis.tipe_jkn', 'PNS')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.bayar', 1)->where('registrasis.tipe_jkn', 'SWASTA')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.bayar', 1)->where('registrasis.tipe_jkn', 'MANDIRI')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ $total_kontraktor }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.status', 'lama')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('registrasis.status', 'baru')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
                <td class="text-center">{{ App\Rawatinap::join('registrasis', 'rawatinaps.registrasi_id', 'registrasis.id')->where('rawatinaps.kelompokkelas_id', $d->id)->whereBetween('rawatinaps.created_at', [$tga . ' 00:00:00', $tgb . ' 23:59:59'])->count() }}</td>
              </tr>
              @endforeach
            @endif
            </tbody>
          </table>
       
