<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed'>
    <thead>
      <tr>
        <th>Nama Pasien</th>
        <th>No. RM</th>
        <th>Alamat</th>
        <th>Status Reg</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $pasien->nama }}</td>
        <td>{{ $pasien->no_rm }}</td>
        <td>{{ $pasien->alamat }}</td>
        <td>
          @if (substr($registrasi->status_reg,0,1) == 'J')
            Rawat Jalan
          @elseif (substr($registrasi->status_reg,0,1) == 'G')
            Rawat Darurat
          @endif
        </td>
      </tr>
    </tbody>
  </table>
</div>

@if ($folio->count() > 0)
  <div class='table-responsive'>
    <table class='table table-striped table-bordered table-hover table-condensed'>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Tindakan</th>
          <th>Total</th>
          <th>DPJP</th>
          <th>Poli</th>
          <th>Petugas Entry</th>
          <th>  </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($folio as $key => $d)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->namatarif }}</td>
            <td>{{ number_format($d->total) }}</td>
            <td>{{ baca_dokter($d->dokter_id) }}</td>
            <td>{{ baca_poli($d->poli_id) }}</td>
            <td>{{ App\user::find($d->user_id)->name }}</td>
            <td> <input type="checkbox" name="verif_rj{{ $baris++ }}" value="{{ $d->id }}"> </td>
          </tr>
        @endforeach
        <input type="hidden" name="jmlbaris" value="{{ $baris }}">
      </tbody>
    </table>
  </div>
@else
  @if (Modules\Registrasi\Entities\Folio::where('registrasi_id', $registrasi->id)->where('verif_rj', 'Y')->count() > 0)
    <h4 class="text-success text-center">Sudah di verifikasi</h4>
  @else
    <h4 class="text-danger text-center">Belum diinput tindakan!!!</h4>
  @endif
@endif
