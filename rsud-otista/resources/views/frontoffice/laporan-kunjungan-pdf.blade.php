<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Laporan Kunjungan</title>
    <!-- Bootstrap 3.3.7 -->
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style media="screen">
    @page {
        margin-top: 1cm;
        margin-left: 3cm;
        margin-right: 3cm;
      }
      .table-borderless > tbody > tr > td,
      .table-borderless > tbody > tr > th,
      .table-borderless > tfoot > tr > td,
      .table-borderless > tfoot > tr > th,
      .table-borderless > thead > tr > td,
      .table-borderless > thead > tr > th {
          border: none;
      }
    </style>
  </head>
  <body>
  <table style="width:100%; margin-bottom: -10px;">
    <tbody>
        <tr>
            <th style="width:15%" rowspan="2">
                <img src="{{ public_path('images/'.configrs()->logo) }}" class="img img-responsive text-left" style="width:100px;">
            </th>
            <th class="text-left" colspan="7" rowspan="2" >
                <h6 style="font-size: 110%;"><b>{{ configrs()->nama }}</b></h6>
                <p style="font-size: 100%">{{ configrs()->alamat }} {{ configrs()->tlp }} </p>
            </th>
  
        </tr>
    </tbody>
  </table>
    <div class="row">
      <div class="col-sm-12 text-center">
        <hr>
          <h5><b>LAPORAN KUNJUNGAN</b></h5>
         
                
          </div>
        <div class="table-responsive mt-3">
          <table class="table table-bordered"  width="100px">
            <thead>
            <tr>
                <th class="text-center" rowspan="2">No</th>
                <th class="text-center" rowspan="2">Ruangan</th> 
                <th class="text-center" colspan="2">Jenis Kelamin</th>
                {{-- <th>
                    <td colspan="3">Users Info</td>
                
               
                    <tr>
                        <td>1</td>
                        <td>John Carter</td>
                        <td>johncarter@mail.com</td>
                     </tr>
                </th> --}}
                
                <th class="text-center" rowspan="2">Jumlah</th> 
                <th class="text-center" colspan="2">Jenis Kunjungan</th>
                <th class="text-center" rowspan="2">Jumlah</th> 
                
            </tr>
            
            <tr class="text-center">
                <th>Laki - Laki</th>
                <th>Perempuan</th>
                <th>Lama</th>
                <th>Baru</th>
            </tr>    
            </thead>
          <tbody>
            @foreach ($data["kunjungan"] as $k)
             @php
                 $no = 1
             @endphp     
             
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ baca_poli($k->poli_id) }}</td>
                <td>
                  {{ $k->kelaminLaki }}
                </td>
                 
                <td>{{ $k->kelaminPerempuan }}</td>
                <td>{{ $k->jumlahKelamin }}</td>
                <td>{{ $k->lama }}</td>
                <td>{{ $k->baru }}</td>
                <td>{{ $k->jumlahStatus }}</td>
              
            </tr>
            @endforeach
          </tbody> 
        </table>
          </div>
        <hr>
      </div>
    
    {{-- <p>Update data oleh: {{ $pasien->user_create }}, pada tanggal: {{ $pasien->created_at->format('d/m/Y') }}</p> --}}
  </body>
</html>
