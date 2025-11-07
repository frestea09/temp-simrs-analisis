<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Reg ID</th>
      <th>Pasien</th>
      <th>RM</th>
      <th>NIK</th>
      <th>Poli</th>
      <th>Dokter</th>
      <th>ASWAL</th>
      <th>CPPT</th>
      <th>RESUME TTE</th>
      <th>E-RESEP TTE</th>
    </tr>
  </thead>
  <tbody>
      @php
          $emrLengkap = 0;
      @endphp
      @foreach ($registrasi as $reg)
          @if (count($reg->aswal_dokter) > 0 || count($reg->cppt_dokter) > 0)
          {{-- @if (!empty(json_decode(@$reg->tte_resume_pasien)->base64_signed_file) || @$reg->tte_resume_pasien_status) --}}
              @php
                  $emrLengkap++;
              @endphp
          <tr>
          @else
          <tr style="background-color: #FF0000;">
          @endif
              <td>{{$loop->iteration}}</td>
              <td>{{ @$reg->id }}</td>
              <td>{{ @$reg->pasien->nama }}</td>
              <td>{{ @$reg->pasien->no_rm}}</td>
              <td>{{ @$reg->pasien->nik ? (int)@$reg->pasien->nik : '-' }}</td>
              <td>{{ baca_poli(@$reg->poli_id)}}</td>
              <td>{{ @$reg->dokter_umum->nama }}</td>
              <td>{{ count($reg->aswal_dokter) > 0 ? 'Lengkap' : '-' }}</td>
              <td>{{ count($reg->cppt_dokter) > 0 ? 'Lengkap' : '-' }}</td>
              <td>
                @if(!empty(json_decode(@$reg->tte_resume_pasien)->base64_signed_file) || @$reg->tte_resume_pasien_status)
                Lengkap
                @else
                -
                @endif
              </td>
              <td>{{ @$reg->eResepTTE ? 'Lengkap' : '-' }}</td>
          </tr>
      @endforeach
  </tbody>
  @if (isset($registrasi))
  <tfoot>
    <tr>
      <td colspan="10">
        <b>JUMLAH KUNJUNGAN PASIEN PADA TANGGAL {{@$tga ? date('d m Y', strtotime(@$tga)) : '-'}} 
          SAMPAI DENGAN {{@$tgb ? date('d m Y', strtotime(@$tgb)) : '-'}} ADALAH {{count(@$registrasi)}} PASIEN.
        </b>
      </td>
    </tr>
    <tr>
      <td colspan="10">
        <b>
          DATA PENGISIAN PASIEN YANG DILAKUKAN OLEH DOKTER ADALAH {{$emrLengkap}} DATA    
        </b>
      </td>
    </tr>
  </tfoot>
  @endif
</table>