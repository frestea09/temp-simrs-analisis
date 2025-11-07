@if (count($hasilLab) == 0)
  <span>Tidak Ada Record</span>
@else
  <div id="data-list-history-lab">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Daftar Pemeriksaan</th>
          <th>Tanggal Pemeriksaan</th>
          <th>Hasil</th>
        </tr>
      </thead>
      @foreach( $hasilLab as $p)
        <tr>
          <td>
            <ul style="padding: 15px;">
                @foreach ($p->orderLab->folios as $folio)
                    <li>{{$folio->namatarif}}</li>
                @endforeach
            </ul>
        </td>
        <td>{{ date('Y-m-d', strtotime($p->tgl_pemeriksaan)) }} {{ $p->jam }}</td>
        <td>
            <a href="{{ url('cetak-lis-pdf/' . @$p->no_lab . '/' . @$p->registrasi_id) }}" target="_blank" class="btn btn-sm btn-danger btn-flat">
              <i class="fa fa-eyes"></i> Pratinjau
            </a>
            <br>
            <small class="text-danger"><i>*Hasil LAB Langsung ambil dari LIS, lama tidaknya tergantung jaringan</i></small>
        </td>
        </tr>
      @endforeach
    </table>
  </div>
@endif