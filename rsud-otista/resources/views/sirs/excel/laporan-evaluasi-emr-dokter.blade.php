<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Dokter</th>
      <th>Poli</th>
      <th>Jumlah Kunjungan</th>
      <th>EMR Terisi Lengkap</th>
      <th>EMR Belum Lengkap</th>
      <th>Kesimpulan</th>
    </tr>
  </thead>
  <tbody>
      @foreach($dataEvaluasi as $dokter => $item)
        @php
          $nomor = $loop->iteration;
        @endphp
        @foreach ($item as $key => $regis)
            <tr>
              <td>{{ @$nomor }}</td>
              <td>{{ @$regis['namaDokter'] }}</td>
              <td>{{ @$regis['poli'] }}</td>
              <td>{{ @$regis['totalKunjungan'] }}</td>
              <td>{{ @$regis['emrTerisi'] }}</td>
              <td>{{ @$regis['emrBelum'] }}</td>
              <td>{{ @$regis['kesimpulan'] .'%' }}</td>
            </tr>
        @endforeach
      @endforeach
  </tbody>
  <tfoot>
    <tr>
      <td colspan="6">
        *Data kelengkapan pengisian diambil dari data Resume yang terisi dan diperoleh dari asesmen awal ( untuk pasien baru )
         dan CPPT ( untuk pasien lama). data pengisian e-resep tidak dapat dijadikan standar kelengkapan EMR dikarenakan e-resep bersifat situsional
      </td>
    </tr>
    <tr>
      <td colspan="6">
        *Dikarenakan pada periode maret-mei TTE belum dapat digunakan secara optimal karena beberapa faktor, 
        maka hasil laporan diambil dari data pengisian tanpa TTE sebagai standar data yang lengkap terisi.
      </td>
    </tr>
  </tfoot>
</table>