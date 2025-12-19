<table class='table table-bordered table-hover'>
    <thead>
          <tr>
            <th class="v-middle text-center">No</th>
            <th class="v-middle text-center">No. RM</th>
            <th class="v-middle text-center">Nama</th>
            <th class="v-middle text-center">Alamat</th>
            <th class="v-middle text-center">Umur</th>
            <th class="v-middle text-center">Jenis Kelamin</th>
            <th class="v-middle text-center">Cara Bayar</th>
            <th class="v-middle text-center">Rujukan</th>
            <th class="v-middle text-center">Poli</th>
            <th class="v-middle text-center">Dokter</th>
            <th class="v-middle text-center">Tanggal</th>
            <th class="v-middle text-center">Diagnosa</th>
			<th class="v-middle text-center">Prosedure</th>
            <th class="v-middle text-center">Tanggal Registrasi</th>
            <th class="v-middle text-center">Tanggal Lahir</th>
        </tr>
    </thead>
    <tbody>
         <tbody>
            @foreach ($rajal as $k => $d)
            <tr>
                <td class="text-center">{{ $k+1 }}</td>
                <td class="text-center">{{ $d->no_rm }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->alamat }}</td>
                <td>{{ hitung_umur($d->tgllahir) }}</td>
                <td>{{ $d->kelamin }}</td>
                <td>{{ baca_carabayar($d->bayar) }}</td>
                <td>{{ $d->pengirim_rujukan == null ? '-' : baca_rujukan($d->pengirim_rujukan) }}</td>
                <td>{{ baca_poli($d->poli_id) }}</td>
                <td>{{ baca_dokter($d->dokter_id) }}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
                <td>
                    <ul>
                        @foreach($d->icd10 as $v)
                            <li>{{ baca_icd10($v->icd10 ) .', '}}</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <ul>
                        @foreach($d->icd9 as $v)
                            <li>{{ getICD9($v->icd9 ) .', '}}</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ date('d-m-Y', strtotime($d->reg_created_at)) }}</td>
                <td>{{ date('d-m-Y', strtotime($d->tgllahir)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </tbody>
</table>