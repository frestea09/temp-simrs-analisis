<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Hais</title>
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
          <h5><b>FORMULIR HARIAN SURVELIANS HAIs</b></h5>
          <div class="text-left my-3">
           <h5>Ruangan  : &nbsp;{{baca_kamar($histori->kamar_id)}}</h5> 
            <h5>Bulan  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tahun :</h5>
                
          </div>
        <div class="table mt-3">
            <table class="table table-bordered"  width="100px">
                <thead>
                <tr>
                    <th class="text-center" rowspan="2">No</th>
                    <th class="text-center" rowspan="2">Tanggal</th>
                    <th class="text-center" rowspan="2">Nama Pasien</th> 
                    <th class="text-center" colspan="2">Jumlah Pemakaian</th>
                    {{-- <th>
                        <td colspan="3">Users Info</td>
                    
                   
                        <tr>
                            <td>1</td>
                            <td>John Carter</td>
                            <td>johncarter@mail.com</td>
                         </tr>
                    </th> --}}
                    
                    <th class="text-center" rowspan="2">Operasi</th> 
                    <th class="text-center" rowspan="2">Anti Biotik</th> 
                    <th class="text-center" rowspan="2">Kultur</th> 
                    <th class="text-center" rowspan="2">Komplikasi Infeksi</th> 
                    
                </tr>
                
                <tr class="text-center">
                    <th>Infus</th>
                    <th>Urine Catheter</th>
                </tr>    
                </thead>
              <tbody>
                <tr>
                    <td>try</td>
                    <td>try</td>
                    <td>try</td>
                    <td>try</td>
                    <td>try</td>
                    <td>try</td>
                    <td>try</td>
                    <td>try</td>
                    <td>try</td>
                </tr>
              </tbody> 
            </table>
          </div>
        <hr>
      </div>
    </div>
    {{-- <p>Update data oleh: {{ $pasien->user_create }}, pada tanggal: {{ $pasien->created_at->format('d/m/Y') }}</p> --}}
  </body>
</html>
