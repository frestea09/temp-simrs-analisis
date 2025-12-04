<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Tarif PDF</title>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    
  </head>
  <body>
    <h3>Tarif</h3>

      <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">No</th>
                  <th class="text-center" style="vertical-align: middle;">Nama</th>
                  <th class="text-center" style="vertical-align: middle;">Jenis</th>
                  <th class="text-center" style="vertical-align: middle;">Kategori Header</th>
                  <th class="text-center" style="vertical-align: middle;">Kategori Tarif</th>
                  <th class="text-center" style="vertical-align: middle;">Total</th>
                </tr>
              </thead>
            <tbody>
              @foreach ($tarif as $key => $d)
                <tr class="">
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->tarif }}
                  <td>{{ $d->jenis }}
                  <td>{{ $d->kategoriheader }}
                  <td>{{ $d->kategoritarif }}
                  <td>{{ number_format($d->total) }}</td>
                    
                </tr>
              @endforeach
            </tbody>
          </table>

  </body>
</html>
