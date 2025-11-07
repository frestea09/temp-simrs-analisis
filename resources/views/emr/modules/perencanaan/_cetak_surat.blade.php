<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Surat Sakit</title>
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('style') }}/bower_components/bootstrap/dist/css/bootstrap.min.css"> --}}
    {{-- <META HTTP-EQUIV="REFRESH" CONTENT="1; URL={{ url('frontoffice/cetak') }}"> --}}
   
   <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" media="print">
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
     <table border=0 style="width: 100%;"> 
        <tr>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 60px;">
          </td>
          <td style="text-align: center">
            <b style="font-size:17px;">{{ strtoupper(configrs()->pt) }}</b><br/>
            <b style="font-size:17px;">{{ @strtoupper(configrs()->dinas) }}</b><br/>
            <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
            <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
          </td>
          <td style="width:10%;">
            <img src="{{ public_path('images/'.@configrs()->logo_paripurna) }}" style="width:68px;height:60px">
          </td>
        </tr>
      </table>
    <div class="row">
      <div class="col-sm-12 text-center">
        <hr>
        <table border=0 style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;"><u>SURAT KETERANGAN SAKIT</u></h3><br/>
              </td>
            </tr>
          </table>
          <br/>
          <table>
            <tr>
              <td colspan="3">Yang bertanda tangan dibawah ini</td>
            </tr>
            <tr>
              <td style="width:100px;"><span style="margin-left:50px;">Dokter</span></td>
              <td style="width:50px;"><span style="margin-left:20px;">:</span></td>
              <td>{{baca_dokter($cetak->dokter_id)}}</td>
            </tr>
            <tr>
              <td colspan="3">Menerangkan Bahwa</td>
            </tr>
            <tr>
              <td style="width:100px;"><span style="margin-left:50px;">Nama</span></td>
              <td><span style="margin-left:20px;">:</span></td>
              <td>{{$pasien->nama}}</td>
            </tr>
            <tr>
              <td style="width:100px;"><span style="margin-left:50px;">Umur</span></td>
              <td><span style="margin-left:20px;">:</span></td>
              <td>{{@hitung_umur($pasien->tgllahir, 'Y')}}</td>
            </tr>
            <tr>
              <td style="width:100px;"><span style="margin-left:50px;">Alamat</span></td>
              <td><span style="margin-left:20px;">:</span></td>
              <td>{{$pasien->alamat}}</td>
            </tr>
            <tr>
              <td colspan="3">
                <br/><br/>
                Berdasarkan hasil pemeriksaan yang telah dilakukan, Pasien tersebut dalam keadaan sakit, Sehingga perlu beristirahat selama <b>{{$cetak->lama_istirahat}}</b> Hari,<br/>
                dari tanggal {{tanggalkuitansi(date('d-m-Y',strtotime($cetak->tgl_kontrol)))}} <b>s/d</b> {{tanggalkuitansi(date('d-m-Y',strtotime($cetak->tgl_selesai)))}}<br/><br/>
                Diagnosa : {{$cetak->keterangan}}<br/><br/>
                Demikian surat keterangan ini diberikan untuk diketahui dan dipergunakan sebagaimana mestinya.

                {{-- Pada tanggal {{tanggalkuitansi(date('d-m-Y'))}} sudah dilakukan pemeriksaan pada pasien tersebut diatas didapatkan hasil : --}}
              </td>
            </tr>
          </table>

        {{-- <table border=0 class="table table-borderless">
          <tr>
            <td>1. Nama</td> <td style="padding-left:28px">: {{ $pasien->nama }}</td>
            <td></td><td></td>
            <td></td><td></td>
            <td><input type="checkbox"></td> <td style="padding-left:28px">Kunjungan Awal</td>
          </tr>
          
          <tr>
            <td >2. Nomor Rekam Medis</td> <td style="padding-left:28px">: {{ $pasien->no_rm }}</td>
            <td></td><td></td>
            <td></td><td></td>
            <td><input type="checkbox"></td> <td style="padding-left:28px">Kontrol Lanjutan</td>
          </tr>
          <tr>
            <td>3. Tanggal Lahir</td> <td style="padding-left:28px">: {{ $pasien->tgllahir }}</td>
            <td></td><td></td>
            <td></td><td></td>
            <td><input type="checkbox"></td> <td style="padding-left:28px">Observasi</td>
          </tr>
          <tr>
            <td>4. Jenis Kelamin</td> <td style="padding-left:28px">:  @if ($pasien->kelamin == 'L')
                Laki - Laki
              @elseif ($pasien->kelamin == 'P')
                Perempuan
              @endif</td>
            <td></td><td></td>
            <td></td><td></td>
            <td><input type="checkbox"></td> <td style="padding-left:28px">Post Operasi</td>
          </tr>
           
        </table>
        <table border=0 class="table table-borderless">
            <tr>
                <td>5. Tanggal Masuk RS</td> <td style="padding-left:28px">: {{ $pasien->tgldaftar }}</td>
                <td >Cara Pulang</td><td style="width:60px">:</td>
                <td>BeratLahir</td><td style="width:30px">:</td>
                <td></td> <td style="padding-left:28px">grams</td>
              </tr>
        </table> --}}
        {{--<div class='footer'>
			<div>Selatpanjang, ...................</div>
			<div style='margin-top:30px; margin-right:5px;'>(.............................)</div>
			<div style='margin-top:10px; margin-left:30px;'> {!! Auth::user()->fullname !!}</div>
		</div>--}}
        <br><br>
     
    <br> 
<br>

    <br><br><br>
        <table border=0 style="width:100%">
            <tr>
                <td colspan="4" scope="row" style="width:130px"><b style="color:black"></b></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;">Soreang,{{tanggalkuitansi(date('d-m-Y'))}}<br><br></td>
            </tr>
        
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">Dokter,</td>
            </tr>

            <tr>
                <td colspan="4" scope="row" style="width:170px;font-size: 7px;">  </td>
                <td></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td></td>
                <td style="text-align: center;">
                      @php
                          $base64 = base64_encode(\QrCode::format('png')->size(75)->merge('/public/images/' . configrs()->logo, .3)->errorCorrection('H')->generate(baca_dokter($cetak->dokter_id)))
                      @endphp
                      <img src="data:image/png;base64, {!! $base64 !!} ">
                </td>
            </tr>
            <tr>
            {{--<td colspan="4" scope="row" style="width:170px;font-size: 10px;"></td>--}}
                <td colspan="4" scope="row" style="width:170px;"><br></td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"><br>({{ baca_dokter($cetak->dokter_id) }})</td>
            </tr>
            <tr>
                <td colspan="4" scope="row" style="width:270px;font-size: 8px;"></td>
                <td></td>
                <td></td>
                <td><div style='margin-top:10px; text-align:center;'></div></td>
            </tr>
    </table>

        <style>

            .footer{
            padding-top: 20px;
            margin-left: 330px;
        }

        .table-border {
        border: 1px solid black;
        border-collapse: collapse;
        }

        </style>
       
      </div>
    </div>
    {{--<p>Update data oleh: {{ $pasien->user_create }}, pada tanggal: {{ $pasien->created_at->format('d/m/Y') }}</p>--}}
    
  </body>
</html>

