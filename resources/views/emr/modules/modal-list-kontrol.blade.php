@if (count($rencanaKontrols) == 0)
  <span>Tidak Ada Record</span>
@else
  <div id="data-list-kontrol">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th colspan="3">List Pasien Kontrol Tgl {{ $tglKontrol }} Dokter {{ $dokter->nama }}</th>
        </tr>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>RM</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rencanaKontrols as $key => $value)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $value->registrasi->pasien->nama }}</td>
            <td>{{ $value->registrasi->pasien->no_rm }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3">Total Pasien : {{ count($rencanaKontrols) }}</td>
        </tr>
      </tfoot>
    </table>
  </div>
@endif