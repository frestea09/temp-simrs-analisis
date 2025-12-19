<!DOCTYPE html>
<html lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Excel</title>
    
  </head>
  <body>
    <table>
      <tr>
        <th>No</th>
        <th>Registrasi ID</th>
        <th>Nama Pasien</th>
        <th>No. RM</th>
        <th>Nama Tarif </th>
        <th>Jenis Pasien</th>
        <th>Total</th>
        <th>Jenis Pelayanan</th>
      </tr>
      @foreach ($kinerja as $d)
        <td>{{ $no++ }}</td>
        <td>{{ $d->registrasi_id }}</td>
        <td>{{ $d->pasien }}</td>
        <td>{{ $d->noRM }}</td>
        <td>{{ $d->namatarif }}</td>
        <td>{{ $d->jenisPasien }}</td>
        <td>{{ $d->total }}</td>
        <td>{{ $d->JasaPelayanan }}</td>
      @endforeach
    </table>
  </body>
</html>

