<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Persetujuan</title>
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
          <b style="font-size:17px;">{{ strtoupper(configrs()->dinas) }}</b><br/>
          <b style="font-size:17px;">{{ strtoupper(configrs()->nama) }}</b><br/>
          <b style="font-size:10px;">{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</b>
        </td>
        <td style="width:10%;">
          <img src="{{ public_path('images/'.configrs()->logo_paripurna) }}" style="width:68px;height:60px">
        </td>
      </tr>
    </table>
    <div class="row">
      <div class="col-sm-12 text-center">
        <hr>
        <table style="width: 100%;"> 
            <tr>
              <td style="text-align: center">
                <h3 style="font-size:17px;">PERSETUJUAN RAWAT INAP</h3><br/>
              </td>
            </tr>
          </table>
          <table class="table table-borderless">
            <tr>
              <td>Yang bertanda tangan dibawah ini</td> <td>: 
            </tr>
        </table>
        <table class="table table-borderless">
          <tr>
            <td>Nama</td> <td>: {{ $pasien->nama_keluarga }}</td>
          </tr>
          <tr>
            <td>Pekerjaan</td> <td>: ........................</td>
          </tr>
          <tr>
            <td>Hubungan Dengan Pasien</td> <td>: {{ $pasien->hub_keluarga }}</td>
          </tr>
          <tr>
            <td>Alamat</td> <td>: ........................</td>
          </tr>
          <tr>
            <td>No. Telp/HP</td> <td>: ........................</td>
          </tr>
          
        </table><br>

        <table class="table table-borderless">
            <tr>
              <td>Dengan ini menyatakan bahwa pasien</td> <td>: 
            </tr>
        </table>
        <table class="table table-borderless">
          <tr>
            <td>Nama</td> <td style="padding-left:28px">: {{ $pasien->nama }}</td>
          </tr>
          
          <tr>
            <td >Nomor Rekam Medis</td> <td style="padding-left:28px">: {{ $pasien->no_rm }}</td>
          </tr>
          <tr>
            <td>Pekerjaan</td> <td style="padding-left:28px">: {{ $pasien->tmplahir }}</td>
          </tr>
          <tr>
            <td>Alamat</td> <td style="padding-left:28px">: {{ $pasien->alamat }}</td>
          </tr>
          <tr>
            <td>No. Telp/HP</td> <td style="padding-left:28px">: {{ $pasien->nohp }}</td>
          </tr>
          {{--<tr>
            <td>Jenis Kelamin</td> 
            <td>: 
              @if ($pasien->kelamin == 'L')
                Laki - Laki
              @elseif ($pasien->kelamin == 'P')
                Perempuan
              @endif
            </td>
          </tr>--}}
        </table>

        {{--<div class='footer'>
			<div>Selatpanjang, ...................</div>
			<div style='margin-top:30px; margin-right:5px;'>(.............................)</div>
			<div style='margin-top:10px; margin-left:30px;'> {!! Auth::user()->fullname !!}</div>
		</div>--}}
        <br><br>
        <table border=0 style="width:100%">
            <tr>
                <td style="width:100%">Setuju untuk dirawat di Ruang ..................................... Kelas ............................. Rumah Sakit Umum Daerah Kabupaten Kepulauan Meranti
                 dan bersedia mematuhi dan membayar biaya sesuai tarif yang berlaku di Rumah Sakit Umum Daerah Kabupaten Kepulauan Meranti.<br><br><br>
                </td>
            </tr>
            <tr>
                <td style="width:100%">Demikian surat pernyataan ini saya buat sebenarnya
                </td>
            </tr>
        </table>
    <br><br><br>
        <table border=0 style="width:100%">
            <tr>
                <td colspan="4" scope="row" style="width:130px"><b style="color:black"></b></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;"></td>
                <td style="text-align:left;">Soreang,....................<br><br></td>
            </tr>
        
            <tr>
                <td colspan="4" scope="row" style="width:200px;padding-left:20px">Petugas Jaga,</td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:140px;text-align:center;">Pasien/Keluarga,</td>
            </tr>

            <tr>
                <td colspan="4" scope="row" style="width:170px;font-size: 7px;">  </td>
                <td></td>
                <td style="width:140px;text-align:center;width:170px;"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
            {{--<td colspan="4" scope="row" style="width:170px;font-size: 10px;"></td>--}}
                <td colspan="4" scope="row" style="width:170px;"><br><br><br><br><br>(.................................)</td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:140px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"></td>
                <td style="width:80px;text-align:center;"><br><br><br><br><br>(.................................)</td>
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

        </style>
       
      </div>
    </div>
    {{--<p>Update data oleh: {{ $pasien->user_create }}, pada tanggal: {{ $pasien->created_at->format('d/m/Y') }}</p>--}}
    
  </body>
</html>


{{--<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak kuitansi Penerimaan</title>

    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet" media="print">
    <style type="text/css">
		body{
			font-size: 9pt;
		}
    </style>
  </head>
  <body>
    <table style="width: 100%; margin-left: 10px;">
        <tr>
            <td style="width:30%;">
                <img src="{{ asset('images/'.configrs()->logo) }}" style="width: 100px; float: left;">
            </td>
            <td class="text-center" style="width:30%; font-weight: bold;">
                <img src="{{ public_path('images/logorsud.png') }}" style="width: 100px; float: right;">
            </td>
        </tr>
    </table>
  	<div class="row">
        <div class="col-sm-12 text-center">
            <h6>PEMERINTAH KABUPATEN KUNINGAN</h6>
            <h6>{{ configrs()->nama }}</h6>
            <h6>{{ configrs()->alamat }} Telp. {{ configrs()->tlp }}</h6>
            <hr>
            <h5>BERITA ACARA PEMERIKSAAN BARANG</h5>
            <h6> Nomor : 009999 </h6>
            <br>
        </div>
		<p style="width: 100%">
            Pada hari ini {{ !empty($barang->created_at) ? $barang->created_at : '' }}, bertempat di {{configrs()->nama}}, dasar Keputusan Direktur {{configrs()->nama}} Nomor : 510.2/34/Sekretariat/2019, tgl. 9 Januari 2019, yang bertanda tangan dibawah ini Panitia Penerima Hasil Pekerjaan ( PPHP ). 
            Masing-masing sesuai  hak dan kewenangannya, menyatakan dengan sebenarnya telah melaksanakan pemeriksaan hasil pengadaan Barang/Jasa Bahan Pelayanan yang dilakukan oleh Panitia Pengadaan sesuai dengan ketentuan terhadap realisasi Surat Pesanan : Nomor : {{ !empty($barang->no_po) ? $barang->no_po :'' }} dengan spesifikasi sebagai berikut : 
		</p>
		
		<br>
		<p style="width: 100%">
			Hasil Pemeriksaan diyatakan
                a. Bak
                b. Kurang/Tidak Baik
            Yang selanjutnya menyerahkan aset hasil pengadaan barang/jasa kepada direktur melalui Pejabat Pembuat Komitmen/ PPK.

            Demikian Berita Acara ini dibuat dalam rangkap 4 (empat) untuk dipergunakan sebagaimana mestinya.	
		</p>
        <br>
        <table class="table table-hover table-dark">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Faktur</th>
                    <th>Nama Obat</th>
                    <th>Satuan</th>
                    <th>Stok Gudang</th>
                    <th class="text-center">Jumlah Dipesan</th>
                    <th class="text-center">Jumlah Dikirim</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
           
                    <tr>
                        <th>xx</th>
                        <td>xx</td>
                        <td>xx</td>
                        <td>xx</td>
                        <td>xx</td>
                        <td class="text-center">xx</td>
                        <td class="text-center">xx</td>
                        <td>xx</td>
                    </tr>
                
            </tbody>
        </table>
        <table style="width: 20%; float: left">
			<tbody>
				<tr>
					<th class="text-center"></th>
				</tr>
				<tr>
					<th class="text-center" style="font-size: 10px;">PENYEDIA BARANG/JASA</th>
				</tr>
				<tr>
					<th class="text-center" style="font-size: 10px;">supplier</th>
					<th class="text-center"></th>
				</tr>
				<tr>
					<th class="text-center"><br><br><br><br>(_________________)</th>
					<th class="text-center"> </th>
				</tr>
			</tbody>
        </table>
    
	</div>
  </body>
</html>--}}

