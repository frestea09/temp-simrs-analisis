<div id="data-list">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover table-condensed">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Diagnosa</th>
          <th>Waktu</th>
          @if (Auth::user()->id == 1)
            <th>Registrasi ID</th>    
            <th>TGL Registrasi Pasien</th>    
          @endif
          <th>Hapus</th>
        </tr>
      </thead>
      <tbody>
        @if (count($diagnosa) > 0)
          @foreach ($diagnosa as $data)
            <tr>
              <td>{{ $data->icd10 }}</td>
              @if (Modules\Icd10\Entities\Icd10::where('nomor', $data->icd10)->first())
              <td>{{ baca_diagnosa($data->icd10) }}</td>
              <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</td>
              @if (Auth::user()->id == 1)
                <td>{{@$data->registrasi_id}}</td>
                <td>{{@$data->registrasi->created_at}}</td>
              @endif
              <td>
                <a href="{{ url('frontoffice/hapus-diagnosa-jkn/'.$data->id.'/'.$data->registrasi_id) }}" class="btn btn-flat btn-danger btn-sm" title="hapus"> <i class="fa fa-trash"></i></a>
              </td>
              @endif
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="5">
              <span style="text-align: center">Tidak Ada Diagnosa Sebelumnya</span>
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>