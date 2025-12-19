<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed'>
    <thead>
      <tr>
        <th>Nama Tindakan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($ekspertise as $d)
        <tr>
          <td>{{ $d->namatarif }}</td>
          <td>
              @if($d->jenis == 'TA')
                  <a href="{{ url('radiologi-gigi/entry-expertise-irj/'.$d->registrasi_id.'/'.$d->id.'/'.$d->tarif_id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat pull-right"><i class="fa fa-send"></i></a>
              @elseif($d->jenis == 'TG')
                  <a href="{{ url('radiologi-gigi/entry-expertise-igd/'.$d->registrasi_id.'/'.$d->id.'/'.$d->tarif_id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat pull-right"><i class="fa fa-send"></i></a>
              @else
                  <a href="{{ url('radiologi-gigi/entry-expertise-irna/'.$d->registrasi_id.'/'.$d->id.'/'.$d->tarif_id) }}" target="_blank" class="btn btn-danger btn-sm btn-flat pull-right"><i class="fa fa-send"></i></a>
              @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
