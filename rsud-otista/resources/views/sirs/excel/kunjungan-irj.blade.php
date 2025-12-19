<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 5.2</th>
        </tr>
        <tr>
            <th colspan="3">RL 5.2 Kunjungan Rawat Jalan</th>
        </tr>
    </thead>
  </table>
  <table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
    <thead>
      <tr>
        <th>No</th>
        <th>Kode RS</th>
        <th>Nama RS</th>
        <th>Bulan</th>
        <th>Tahun</th>
        <th>Kab/Kota</th>
        <th>Kode Propinsi</th>
        <th>Jenis Kegiatan</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      @if ( isset($irj) )
          @php
            $total_keseluruhan = 0;
          @endphp
        @foreach ($irj as $rajal)
          @php
            $total = 0;
          @endphp
          @foreach ($rajal['conf_rl52'] as $k => $v)
            <tr>
              <td>{{ $k+1 }}</td>
              <td>3204090</td>
              <td>RSUD Soreang</td>
              <td>{{ $rajal['month'] }}</td>
              <td>{{ $rajal['year'] }}</td>
              <td>Bandung</td>
              <td>32Prop</td>
              <td>{{ $v }}</td>
              <td>
                @foreach ($rajal['irj'] as $key => $d)
                    @if( ($d->poli_id == 15) && ($v == "Penyakit Dalam") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 7) && ($v == "Bedah") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 18) && ($v == "Kesehatan Anak (Neonatal)") )
                      @php
                        // $lahir 	= explode(',', $d->tgl_lahir);
                        // dd($lahir,$d->jumlah);
                        // $now	= time();
                        // $lhir 	= strtotime($l);
                        // $diff 	= $now - $lhir;
                        // $day 	= round($diff / (60 * 60 * 24));
                        // $timestemp = "2020-01-01 01:02:03";
                        // $month = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestemp)->month;
                        // dd( $month );
                      @endphp
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 18) && ($v == "Kesehatan Anak Lainnya") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 1) && ($v == "Obstetri & Gynecolog (Ibu Hamil)") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 1) && ($v == "Obstetri & Gynecolog Lainnya") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 1) && ($v == "Keluarga Berencana") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 13) && ($v == "Bedah Syaraf") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 5) && ($v == "Syaraf") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 6) && ($v == "Jiwa") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 6) && ($v == "Napza") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 3) && ($v == "THT") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 4) && ($v == "Mata") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 9) && ($v == "Kulit & Kelamin") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 2) && ($v == "Gigi & Mulut") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 99) && ($v == "Geriatri") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 99) && ($v == "Kardiologi") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    {{-- @elseif( ($d->poli_id == 27) && ($v == "Radiologi") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp --}}
                    @elseif( ($d->poli_id == 8) && ($v == "Bedah Ortopedi") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 10) && ($v == "Paru") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 99) && ($v == "Kusta") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 99) && ($v == "Umum") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    {{-- @elseif( ($d->poli_id == 99) && ($v == "Rawat Darurat") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp --}}
                    {{-- @elseif( $v == "Rehabilitasi Medik" )
                      {{ $rehabmedik }}
                      @php $total += $rehabmedik @endphp --}}
                    @elseif( ($d->poli_id == 99) && ($v == "Akupuntur Medik") )  
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 99) && ($v == "Konsultasi Gizi") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 99) && ($v == "Day Care") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @elseif( ($d->poli_id == 99) && ($v == "Lain-Lain") )
                      {{ $d->jumlah }}
                      @php $total += $d->jumlah @endphp
                    @endif
                @endforeach
                @if( $v == "Rehabilitasi Medik" )
                  {{ $rajal['rehabmedik'] }}
                  @php $total += $rajal['rehabmedik'] @endphp
                @elseif( $v == "Radiologi" )
                  {{ $rajal['radiologi'] }}
                  @php $total += $rajal['radiologi'] @endphp
                @elseif( $v == "Rawat Darurat" )
                  {{ $rajal['rawatdarurat'] }}
                  @php $total += $rajal['rawatdarurat'] @endphp
                @endif
              </td>
            </tr>
            @php
              $total_keseluruhan += $total;
            @endphp
          @endforeach        
        @endforeach
        <tr>
          <th colspan="3">###</th>
          <th>Total</th>
          <th>{{ number_format($total_keseluruhan) }}</th>
        </tr>
      @endif
    </tbody>
  </table>