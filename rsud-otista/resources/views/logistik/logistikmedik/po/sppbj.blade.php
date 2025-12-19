<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cetak Surat Perintah Pengadaan Barang/Jasa</title>

    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <style type="text/css">
		body{
			font-size: 8pt;
		}

		

    </style>
  </head>
 
  <body>
  	<div class="container">
		<div class="row">
			<table style="width:100%">
			<tr>
				<td class="text-center">
					<img src="{{ public_path('images/'.configrs()->logo) }}"style="width: 50px;position:absolute;left:20"><br>
					<h5><b> PEMERINTAH KABUPATEN BANDUNG</b></h5>
					<b style="font-size:16px;">{{config('app.nama_kop_rs')}}</b><br>
					{{config('app.alamat_kop')}}<br/> Telp: {{configrs()->tlp}},Email: {{configrs()->email}}<br>
				</td>
			</tr>
			</table>
            <div class="col-sm-12 text-center">
                
                
                <hr>
            </div>
        </div>
  		<br>
          <div class="row">
            <div class="col-sm-12">
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td style="width: 20%; padding-bottom: 60px">
                                <p>Nomor :027/01- SPP/Pj.PAKK/II/2022</p>
                                <p>Lampiran :-</p>
                                Perihal  :Surat Perintah Pengadaan Barang/Jasa
                            </td>
                            <td style="padding-left: 40%;width: 30%">
                                <p>Soreang, {{ $po->tanggal }}</p>
                                <p style="padding-top: 1px">Kepada Yth</p>
                                <p style="padding-top: 1px">{{ $po->supplier }}</p>
                                <p style="padding-top: 1px">Di</p>
                                <p style="padding-top: 1px">Tempat</p>
                
                            </td>
                        </tr>
                        
                        
                    </tbody>
                </table>
            </div>
            </div>
		<br> 
		<div class="row">
			<div class="col-sm-12 "> 
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td>
                                <p>
                                    Berdasarkan Disposisi dari Direktur RSUD Soreang Kab. Bandung mengenai Nota Dinas Nomor :  perihal permohonan sebagai berikut :
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12 "> 
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td>
                                <p>Nama Kegiatan     :</p>
                                
                            </td>
                            <td>
                                <p> Pengadaan Barang</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Lokasi   :</p>
                            </td>
                            <td>
                                <p>  RSUD OTO ISKANDAR DI NATA, {{config('app.alamat_kop')}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Barang/Jasa   : </p>
                            </td>
                            <td>
                                <p> Terlampir</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @php
                                    $date = DateTime::createFromFormat("Y-m-d", $po->tanggal);
                                @endphp         
                                <p>Tahun Anggaran   : </p>
                            </td>
                            <td>
                                <p> {{ $date->format('Y') }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
		</div>
		<br>
	<div class="row">
			<div class="col-sm-12">
				<table style="width: 100%; ">
					<tr class="text-left">
							<td style="25%">
								<p>Dengan ini Pejabat Pembuat Komitmen (PPK) memerintahkan kepada Pejabat Pengadaan Barang /Jasa segera mengadakan proses pelaksanaan pengadaan atas kegiatan tersebut diatas sesuai dengan ketentuan dan perundang – undangan yang berlaku.</p>
								<p>Demikian Surat ini kami buat, atas perhatiannya kami ucapkan terima kasih.</p>
							</td>
	
					</tr>
				</table>
			</div>
		</div>
	<div class="row">
		<div class="col-sm-12">
			<table style="width: 100%; ">
				<tr class="text-right">
						@php
							$peg = App\LogistikPejabatPengadaan::all()
						@endphp
						<td style="25%" class="text-lrft">
							Pejabat Pembuat Komitmen<br><br><br><br><br><br>
							{{$peg[0]->nama }}<br>
							
							NIP:{{$peg[0]->nip }}<br>
							
						</td>

				</tr>
			</table>
		</div>
	</div>

	</div>
  </body>
</html>
