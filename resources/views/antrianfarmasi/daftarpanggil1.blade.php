<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Antrian</h3>
    </div>
    <div class="panel-body">
      <div class='table-responsive'>
        <table class='table table-striped table-bordered table-hover table-condensed'>
          <thead>
            <tr>
              <th class="text-center">Antrian</th>
              <th>Waktu Antri</th>
              <th class="text-center">Panggil</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($antrian as $key => $d)
              <tr>
                <td class="text-center">{{ $d->kelompok }}{{ $d->nomor }}</td>
                <td>{{ date('H:i',strtotime($d->created_at)) }}</td>
                <td class="text-center">
                  <a href="{{ route('antrianfarmasi.panggil1',$d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-microphone"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="panel-footer">

    </div>
  </div>
</div>
{{-- ============================ --}}
