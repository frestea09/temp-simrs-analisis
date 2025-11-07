<div class='table-responsive'>
  <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
    <thead>
      <tr class="text-center">
        <th>No</th>
        <th>No RM</th>
        <th>Nama Pasien</th>
        <th>JK</th>
        <th>Cetak Barcode</th>
        <th>Cetak Kartu Pasien</th>
        <th>Cetak Gelang Pasien</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($today as $key => $d)
        <tr class="text-center">
          <td>{{ $no++ }}</td>
          <td>{{ $d->pasien->no_rm }}</td>
          <td class="text-left">{{ $d->pasien->nama }}</td>
          <td>{{ $d->pasien->kelamin }}</td>
          <td><a href="{{ url('frontoffice/cetak_barcode/'.$d->pasien_id) }}" target="_blank" class="btn btn-info btn-sm"> <i class="fa fa-print text-center"></i> </a></td>
          <td><a href="{{ url('frontoffice/cetak_buktiregistrasi/'.$d->id) }}" target="_blank" class="btn btn-info btn-sm" ><i class="fa fa-print text-center"></i></td>
          <td> <a href="{{ url('frontoffice/cetak_gelang/'.$d->pasien_id) }}" target="_blank"  class="btn btn-info btn-sm"><i class="fa fa-print text-center"></i> </a> </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
