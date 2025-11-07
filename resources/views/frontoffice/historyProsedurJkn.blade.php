<div id="data-list-prosedur">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover table-condensed">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Prosedur</th>
          <th>Waktu</th>
          <th>Hapus</th>
        </tr>
      </thead>
      <tbody>
        @if (count($prosedur) > 0)
          @foreach ($prosedur as $data)
            <tr>
              <td>{{ $data->icd9 }}</td>
              @if (Modules\Icd9\Entities\Icd9::where('nomor', $data->icd9)->first())
              <td>{{ baca_prosedur($data->icd9) }}</td>
              <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</td>
              <td>
                <a href="{{ url('frontoffice/hapus-prosedur-jkn/'.$data->id.'/'.$data->registrasi_id) }}" class="btn btn-flat btn-danger btn-sm" title="hapus"> <i class="fa fa-trash"></i></a>
              </td>
              @endif
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="4">
              <span style="text-align: center">Tidak Ada prosedur Sebelumnya
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>