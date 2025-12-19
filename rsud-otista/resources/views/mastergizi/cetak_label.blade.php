<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Label</title>
    <style>
        .border {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .borderless {
            border: none;
            border-collapse: collapse;
        }

        .bold {
            font-weight: bold;
        }

        .p-1 {
            padding: .5rem;
        }
        .text-center {
            text-align: center;
        }

        .border-bottom {
            border-bottom: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="box box-primary">
        <div class="">
        </div>
        <div class="box-body">
          <div class=''>
            <table border=0 style="width:95%;font-size:12px;"> 
              <tr>
                <td style="width:10%;">
                  <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
                </td>
                <td style="text-align: center">
                  <b style="font-size:20px;">ETIKET MAKAN</b><br/>
                  <b style="font-size:20px;">INSTALASI GIZI</b><br/>
                  <b style="font-size:20px;">RSUD OTO ISKANDAR DI NATA</b><br/>
                </td>
                <td style="width:10%;">
                  {{-- <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px"> --}}
                </td>
              </tr>
            </table>
            <br><br>
            <table class='borderless' style="width: 100%">
              <tbody>
                @isset($registrasi)
                  <tr style="">
                    <td class="" style="width: 25%; font-weight: 500">Hari / Tanggal</td>
                    <td class="" style="width: 1%;">:</td>
                    <td class="">{{ $asessments ? $asessments->created_at->format('d-m-Y') : '-' }}</td>
                  </tr>
                  <tr style="">
                    <td class="" style="width: 25%; font-weight: 500">Waktu Makan</td>
                    <td class="" style="width: 1%;">:</td>
                    {{-- <td class="">{{ $asessments ? $asessments->created_at->format('H:i') : '-' }}</td> --}}
                    <td class="">{{@$konsul->waktu_makan}}</td>
                  </tr>
                  <tr style="">
                    <td class="" style="width: 25%; font-weight: 500">Ruang / Bed</td>
                    <td class="" style="width: 1%;">:</td>
                    <td class="">{{@baca_kamar(@$registrasi->rawat_inap->kamar_id)}}</td>
                  </tr>
                  <tr style="">
                    <td class="" style="width: 25%; font-weight: 500">Nama Pasien</td>
                    <td class="" style="width: 1%;">:</td>
                    <td class="">{{@$registrasi->pasien->nama}}</td>
                  </tr>
                  <tr style="">
                    <td class="" style="width: 25%; font-weight: 500">No Rekam Medis</td>
                    <td class="" style="width: 1%;">:</td>
                    <td class="">{{@$registrasi->pasien->no_rm}}</td>
                  </tr>
                  <tr style="">
                    <td class="" style="width: 25%; font-weight: 500">Usia</td>
                    <td class="" style="width: 1%;">:</td>
                    <td class="">{{hitung_umur(@$registrasi->pasien->tgllahir)}}</td>
                  </tr>
                  <tr style="">
                    <td class="" style="width: 25%; font-weight: 500">Tanggal Penyajian</td>
                    <td class="" style="width: 1%;">:</td>
                    {{-- <td class="">{{date('d-m-Y')}}</td> --}}
                    <td class="">{{@$konsul->tanggal_penyajian}}</td>
                  </tr>
                  <tr style="">
                    <td class="" style="width: 25%; font-weight: 500">Diet</td>
                    <td class="" style="width: 1%;">:</td>
                    <td class="">
                        {{-- {{@$assesment['intervensi_gizi']['preskripsi_diet']['jenis_diet']}} --}}
                        {{@$konsul->bentuk_makanan}}, {{@$konsul->jenis_diet}}
                    </td>
                  </tr>
                  <tr class="border text-center">
                    <td class="p-1" colspan="3" style="font-weight: 500">
                        Selamat Menikmati Hidangan <br>
                        Alat makan akan diambil 1 jam kemudian<br>
                    </td>
                  </tr>
                @endisset
    
              </tbody>
            </table>
          </div>
    
        </div>
        <div class="box-footer">
        </div>
      </div>
    
</body>
</html>