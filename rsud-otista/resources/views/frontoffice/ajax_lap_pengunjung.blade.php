
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>No. RM</th>
              <th>Umur</th>
              <th>Waktu Kunj</th>
              <th>Ibu kandung</th>
              <th>No Handphone</th>
              <th>provinsi</th>
              <th>kabupaten</th>
              <th>kecamatan</th>
              <th>desa</th>
              <th>Klinik Tujuan</th>
              <th>Cara Bayar</th>
              <th>Dokter</th>
              <th>Jenis Pasien</th>
              <th>Petugas</th>
              <th>Diagnosa</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reg as $key => $d)
              @php
                $reg = Modules\Registrasi\Entities\Registrasi::find($d->registrasi_id);
              @endphp
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ Modules\Pasien\Entities\Pasien::find($d->pasien_id)->nama }}</td>
                <td>{{ Modules\Pasien\Entities\Pasien::find($d->pasien_id)->alamat }}</td>
                <td>{{ Modules\Pasien\Entities\Pasien::find($d->pasien_id)->no_rm }}</td>
                <td>{{ hitung_umur(Modules\Pasien\Entities\Pasien::find($d->pasien_id)->tgllahir) }}</td>
                <td>{{date('d-m-Y, H:i:s',strtotime($d->created_at))}}</td>
                <td>{{ Modules\Pasien\Entities\Pasien::find($d->pasien_id)->ibu_kandung }}</td>
                <td>{{ Modules\Pasien\Entities\Pasien::find($d->pasien_id)->nohp }}</td>
                <td>{{ Modules\Pasien\Entities\Province::find(Modules\Pasien\Entities\Pasien::find($d->pasien_id)->province_id)->name }}</td>
                <td>{{ Modules\Pasien\Entities\Regency::find(Modules\Pasien\Entities\Pasien::find($d->pasien_id)->regency_id)->name }}</td>
                <td>{{ Modules\Pasien\Entities\District::find(Modules\Pasien\Entities\Pasien::find($d->pasien_id)->district_id)->name }}</td>
                <td>{{ Modules\Pasien\Entities\Village::find(Modules\Pasien\Entities\Pasien::find($d->pasien_id)->village_id)->name }}</td>
                <td>
                  @if ($reg)
                    {{ baca_poli($reg->poli_id) }}
                  @else 
                    {{ NULL }}
                  @endif
                </td>
                <td>{{ baca_carabayar($d->bayar) }} {{@$d->tipe_jkn}}</td>
                <td>
                  @if ($reg)
                    {{ baca_dokter($reg->dokter_id) }}
                  @else 
                    {{ NULL }}
                  @endif
                </td>
                <td>
                  @if (!empty($reg->status) )
                    {{ $reg->status }}
                  @else 
                    {{ NULL }}
                  @endif
                </td>
                <td>{{ @baca_user(@$reg->user_create) }}</td>
                <td>{{ @$reg->diagnosa_awal }}</td>
                <td>{{ @$reg->keterangan }}</td>
              </tr>
            @endforeach

          </tbody>
        </table>
      </div>
