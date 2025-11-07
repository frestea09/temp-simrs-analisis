<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cetak kuitansi Diklat</title>

		<link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
		<style media="screen">
		@page {
			margin-top: 0.5cm;
			margin-left: 1cm;
			width: 9.5cm;
			height: 20cm;
        }
        body{
            width: auto;
            position: absolute;
        }
        table{
            width: 100%;
        }
        table:first-child{
        	border-bottom: 5px double;
        }
		}
		</style>
	</head>

	<body onload="window.print()">
		<table>
			<tr>
				<td style="width:20%;"><img src="{{ asset('images/'.configrs()->logo) }}" style="width:75px; margin-right: -20px;"></td>
				<td>
					<h4 style="font-size: 135%; font-weight: bold; margin-bottom: -3px;">{{ configrs()->nama }} </h4>
					<p>{{ configrs()->pt }} <br> NPWP: {{ configrs()->npwp }}   <br> {{ configrs()->alamat }} <br> Tlp. {{ configrs()->tlp }} </p>
				</td>
			</tr>
		</table>
		<table>
			<tr>
                <th style="text-align:center;width:25%">Jenis </th>
                <th style="text-align:center;width:25%">Tarif </th>
                <th style="text-align:center;width:25%">Jumlah </th>
                <th style="text-align:center;width:25%">Pendapatan </th>
            </tr>
            <tr>
                <td>{{ ($parkir->jenis == 2) ? 'Roda 2' : 'Roda 4 / Lebih' }}</td>
                <td style="text-align:right">{{ 'Rp. '.number_format($parkir->tarif, 0, ',', '.') }}</td>
                <td style="text-align:center">{{ $parkir->jml_kendaraan }}</td>
                <td style="text-align:right">{{ 'Rp. '.number_format($parkir->total, 0, ',', '.') }}</td>
            </tr>
        </table>
        <br>
		<table>
			<tr>
				<th class="text-center">{{ configrs()->kota }}, {{ tanggalkuitansi(date('Y-m-d')) }}<br><br><br><br><i><u>{{ Auth::user()->name }}</u></i></th>
			</tr>
		</table>
	</body>
</html>
