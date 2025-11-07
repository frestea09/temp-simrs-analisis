<div class='table-responsive'>
  <table class='table table-striped table-hover table-condensed'>
    <tbody>
      <tr>
        <td>No. RM</td> <td>: {{ @$p->no_rm }}</td>
      </tr>
      <tr>
        <td>Nama Lengkap</td> <td>: {{ @$p->nama }}</td>
      </tr>
      <tr>
        <td>NIK</td> <td>: {{ @$p->nik }}</td>
      </tr>
      <tr>
        <td>Tempat, Tanggal Lahir</td>
        <td>: {{ @$p->tmplahir }}
          {{ (!empty(@$p->tgllahir)) ? tgl_indo(@$p->tgllahir) : '' }}</td>
      </tr>
      <tr>
        <td>Jenis Kelamin</td> <td>: {{ @$p->kelamin }}</td>
      </tr>
      <tr>
        <td>Alamat</td> <td>: {{ @$p->alamat }} </td>
      </tr>
      {{-- <tr>
        <td>Kelurahan</td> <td>: {{ (!empty(@$p->village_id)) ? ucwords(strtolower(baca_kelurahan(@$p->village_id))) : '' }} </td>
      </tr>
      <tr>
        <td>Kecamatan</td> <td>: {{ (!empty(@$p->district_id)) ? ucwords(strtolower(baca_kecamatan(@$p->district_id))) : '' }}</td>
      </tr>
      <tr>
        <td>Kabupaten / Kota</td> <td>: {{ (!empty(@$p->regency_id)) ? ucwords(strtolower(baca_kabupaten(@$p->regency_id))) : '' }} </td>
      </tr> --}}
      <tr>
        <td>No. HP</td> <td>: {{ @$p->nohp }}</td>
      </tr>
      <tr>
        <td>Pekerjaan</td> <td>: {{ (!empty(@$p->pekerjaan_id)) ? @$p->pekerjaan->nama : '' }} </td>
      </tr>
      <tr>
        <td>Agama</td> <td>: {{ (@$p->agama_id) ? @$p->agama->agama : '' }}</td>
      </tr>
      <tr>
        <td>Pendidikan</td> <td>: {{ (!empty(@$p->pendidikan_id)) ? @$p->pendidikan->pendidikan : '' }}</td>
      </tr>
    </tbody>
  </table>
</div>
