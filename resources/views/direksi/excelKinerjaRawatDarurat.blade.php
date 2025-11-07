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
    <th rowspan="2">No</th>
    <th rowspan="2">Nama Dokter</th>
    <th rowspan="2">Pemeriksaan</th>
    <th rowspan="2">Konsultasi</th>
    @foreach ($klinik as $k)
      <th colspan="2">{{ str_replace('Klinik', '', $k->nama)  }}</th>
    @endforeach
  </tr>
  <tr>
    @foreach ($klinik as $k)
      <th>Perawat</th>
      <th>Dokter</th>
    @endforeach
  </tr>
  @foreach ($dokter as $d)
    <tr>
      <td>{{ $no++ }}</td>
      <td>{{ $d->nama }}</td>
      <td>{{ pemeriksaan($d->id, 'TG', $tga, $tgb, $cara_bayar_id) }}</td>
      <td>{{ konsultasi($d->id, 'TG', $tga, $tgb, $cara_bayar_id) }}</td>
      @foreach ($klinik as $r)
        <td></td>
        <td>{{ kinerjaDokter($d->id, $r->id, 'TG', $tga, $tgb, $cara_bayar_id) }}</td>
      @endforeach
    </tr>
  @endforeach
</table>
  </body>
</html>

