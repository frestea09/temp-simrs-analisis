<table class='table table-bordered table-hover'>
	<thead>
		<tr>
			<th class="v-middle text-center">No</th>
			<th class="v-middle text-center">Poli Klinik</th>
			<th class="v-middle text-center">Pasien Umum</th>
			<th class="v-middle text-center">Pasien JKN</th>
			<th class="v-middle text-center">Online</th>
			<th class="v-middle text-center">Offline</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($polis as $key=>$poli)
		<tr>
			<td>{{$key+1}}</td>
			<td>{{$poli->nama}}</td>

			<td class="text-center">{{$poli->umum}}</td>
			<td class="text-center">{{$poli->jkn}}</td>

			<td class="text-center">{{$poli->online}}</td>
			<td class="text-center">{{$poli->offline}}</td>
		</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<th class="text-center" style="font-weight: bold" colspan="2" rowspan="2">Total</th>
			<th class="text-center" style="font-weight: bold">{{$total_umum}}</th>
			<th class="text-center" style="font-weight: bold">{{$total_jkn}}</th>
			<th class="text-center" style="font-weight: bold">{{$total_online}}</th>
			<th class="text-center" style="font-weight: bold">{{$total_offline}}</th>
		</tr>
		<tr>
			<th class="text-center" style="font-weight: bold" colspan="4">{{$total_keseluruhan}}</th>

		</tr>
	</tfoot>
</table>