<div class='table-responsive'>
  <table class='table-striped table-bordered table-hover table-condensed table' id="datas">
    @php
        $reg_id = 7360;
    @endphp
    <thead>
      <tr>
        {{-- <th>No</th> --}}
        <th>Pasien</th>
        <th>RM</th>
        <th>Dokter</th>
        <th style="width:8%">Tgl.</th>
        <th>Bayar</th>
        <th>SEP</th>
        <th>Status</th>
        <th>Asal</th>
        <th>Kamar</th>
        <th>Tgl. Masuk</th>
        <th>Tgl. Keluar</th>
        <th class="text-center">EMR</th> 
        <th class="text-center">Tarif IDRG</th> 
      </tr>
    </thead>
    <tbody>
      @foreach ($registrasi as $key => $d)
          @php
            // $pasien = Modules\Pasien\Entities\Pasien::find($d->pasien_id);
            // $emr = App\Emr::where('registrasi_id', $d->id)->exists();
            // $ri = App\Rawatinap::where('registrasi_id', $d->id)->first();
          @endphp
          <tr>
            {{-- <td>{{ $no++ }}</td> --}}
            <td>{{ @$d->pasien->nama }}</td>
            <td>{{ @$d->pasien->no_rm }}</td>
            <td>
              {{ (!empty($d->dokterInap)) ? baca_dokter($d->dokterInap) : baca_dokter($d->dokter_id) }}
            </td>
            <td>
              {{ $d->created_at->format('d-m-Y') }}
            </td>
            <td class="{{ empty($d->no_sep) ? 'text-red' : '' }}">
              {{ baca_carabayar($d->bayar) }}
              @if (!empty($d->tipe_jkn))
                - {{ $d->tipe_jkn }}
              @endif
            </td>          
            <td>{{ @$d->no_sep }}</td>
            <td>{{ @$d->status_reg == "I3" ? "Dipulangkan" : "Diinapkan" }}</td>
            <td>{{ baca_poli(@$d->poli_id) }}</td>
            {{-- <td>{{ @$d->kamar? @$d->kamar->nama : '' }} {{ @$d->bed ? '('.@$d->bed->nama.')' : '' }}</td> --}}
            <td class="status-kamar-bed"
                data-id="{{ $d->id }}">
                <i class="loading"><small>memuat...</small></i>
            </td>

            <td>{{ !empty($d) ? tanggal($d->tgl_masuk) : NULL }}</td>
            <td>{{ !empty($d) ? tanggal($d->tgl_keluar) : NULL }}</td>
            <td class="status-emr text-center"
                data-registrasi-id="{{ $d->id }}"
                data-unit="{{ $unit }}"
                data-poli="{{ $d->poli_id }}"
                data-dpjp="{{ $d->dokter_id }}"
                data-tte="{{ @$d->tte_resume_pasien_status }}">
                <i class="loading"><small>memuat...</small></i>
            </td>
            <td class="text-center">
              <a class="btn btn-info btn-sm btn-flat" onclick="tarifIDRG({{ $d->id }}, '{{ $d->tarif_idrg ?? '' }}')"><i class="fa fa-edit"></i></a>
            </td>
      @endforeach
    </tbody>
  </table>
</div>