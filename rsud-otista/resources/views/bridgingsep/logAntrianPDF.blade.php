<!DOCTYPE html>
<html>
<head>
	<title>Laporan Log Antrian</title>
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
    table, td, th{
      border: 1px solid black;
      border-collapse: collapse;
    }
	</style>
	<center>
		<h5>Laporan Log Antrian</h5>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>No. Antrian</th>
				<th>Request</th>
				<th>Response</th>
				<th>User</th>
				<th>Waktu</th>
			</tr>
		</thead>
		<tbody>
			@foreach($log as $l)
			<tr>
				<td>{{ $no++ }}</td>
				<td>{{$l->nomorantrian}}</td>
				<td>{{$l->request}}</td>
				<td>{{$l->response}}</td>
				<td>{{$l->penginput}}</td>
				<td>{{$l->created_at}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>