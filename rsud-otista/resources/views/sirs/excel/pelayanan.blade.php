<table>
    <thead>
        <tr>
            <th colspan="3">Formulir RL 1.2</th>
        </tr>
        <tr>
            <th colspan="3">RL 1.2 Pelayanan Tahun {{ $data['thn'] }}</th>
        </tr>
    </thead>
</table>
<table class='table table-striped table-bordered table-hover table-condensed' id="data-table">
  <thead>
    <tr>
      {{-- <th>No</th> --}}
      <th>Bulan</th>
      <th>Bor</th>
      <th>Los</th>
      <th>Bto</th>
      <th>Toi</th>
      <th>Ndr</th>
      <th>Gdr</th>
      <th>Idr</th>
      <th>Rata-rata Kunjungan/Hari</th>
    </tr>
  </thead>
  <tbody>
    @php
      $totBOR = 0;
      $totLOS = 0;
      $totBTO = 0;
      $totTOI = 0;
      $totNDR = 0;
      $totGDR = 0;
      $totIDR = 0;
      $totKunj = 0;
    @endphp
    @if ( isset($data['inap']) )
      @foreach ($data['inap'] as $key => $d)
        <tr>
          {{-- <td>{{ $no++ }}</td> --}}
          <td>{{ $data['bulan'][$d->bln] }}</td>
          <td>
            {{-- 
                       jml hari perawatan 
              BOR = -------------------------- x 100%
                    jml tt x hari kerja efektif
            --}}
            @if($d->lama_rawat != 0)
            {{ number_format( ($d->lama_rawat / ($data['kamar']*cal_days_in_month(CAL_GREGORIAN,$d->bln,$data['thn'])))*100/10 ,2) }}
            @php $totBOR += ( ($d->lama_rawat / ($data['kamar']*cal_days_in_month(CAL_GREGORIAN,$d->bln,$data['thn'])))*100/10) @endphp
            @else
            {{ 0 }}
            @endif
          </td>
          <td>
            {{-- 
                       jml lama dirawat 
              LOS = --------------------------
                    pasien keluar hidup & mati
            --}}
            @if($d->total_pasien != 0)
            {{ number_format(($d->lama_rawat-1)/$d->total_pasien,2) }}
            @php $totLOS += (($d->lama_rawat-1)/$d->total_pasien) @endphp
            @else
            {{ 0 }}
            @endif
          </td>
          <td>
            {{-- 
                   pasien keluar hidup & mati 
              BTO = --------------------------
                           jml tt
            --}}
            {{ number_format($d->total_pasien/$data['kamar'],2) }}
            @php $totBTO += ($d->total_pasien/$data['kamar']) @endphp
          </td>
          <td>
            {{-- 
                   (jml tt x hari kerja efektif) - jml hari perawatan
              TOI = ---------------------------------------------------
                              pasien keluar hidup & mati
            --}}
            @if($d->total_pasien != 0)
            {{ number_format( (($data['kamar']*cal_days_in_month(CAL_GREGORIAN,$d->bln,$data['thn'])) - $d->lama_rawat) / $d->total_pasien,2) }}
            @php $totTOI += ( (($data['kamar']*cal_days_in_month(CAL_GREGORIAN,$d->bln,$data['thn'])) - $d->lama_rawat) / $d->total_pasien) @endphp
            @else
            {{ 0 }}
            @endif
          </td>
          <td>
            {{-- 
                   pasien keluar mati > 48 jam x 1000
              NDR = ----------------------------------
                            pasien keluar mati
            --}}
            @if($d->keluar_mati != 0)
            {{ number_format( ($d->mati_kurang_48 * 1000) / $d->keluar_mati ) }}
            @php $totNDR += ( ($d->mati_kurang_48 * 1000) / $d->keluar_mati ) @endphp
            @else
            {{ 0 }}
            @endif
          </td>
          <td>
            {{-- 
                   pasien keluar mati x 1000
              GDR = -------------------------
                   pasien keluar hidup & mati
            --}}
            @if($d->total_pasien != 0)
            {{ number_format( ($d->keluar_mati * 1000) / $d->total_pasien ) }}
            @php $totGDR += ( ($d->keluar_mati * 1000) / $d->total_pasien ) @endphp
            @else
            {{ 0 }}
            @endif
          </td>
          <td>
            {{-- 
                   jml bayi lahir mati x 1000
              IDR = -------------------------
                   jml bayi lahir hidup & mati
            --}}
            @if($d->bayi_lahir_hidup != 0 || $d->bayi_lahir_mati != 0)
            {{ number_format( ($d->bayi_lahir_mati * 1000) / ($d->bayi_lahir_hidup + $d->bayi_lahir_mati) ) }}
            @php $totIDR += ( ($d->bayi_lahir_mati * 1000) / ($d->bayi_lahir_hidup + $d->bayi_lahir_mati) ) @endphp
            @else
            {{ 0 }}
            @endif
          </td>
          <td>-</td>
        </tr>
      @endforeach
      <tr>
        <th>Total</th>
        <th>{{ number_format($totBOR,2) }}</th>
        <th>{{ number_format($totLOS,2) }}</th>
        <th>{{ number_format($totBTO,2) }}</th>
        <th>{{ number_format($totTOI,2) }}</th>
        <th>{{ number_format($totNDR,2) }}</th>
        <th>{{ number_format($totGDR,2) }}</th>
        <th>{{ number_format($totIDR,2) }}</th>
        <th>{{ number_format($totKunj,2) }}</th>
      </tr>
    @endif
    </tbody>
  </table>