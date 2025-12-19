 @php
	 $no = 1;
 @endphp
			<table class='table table-bordered table-hover' style="font-size:12px;" >
				<thead>
					<tr>
						<th class="v-middle text-center" >No</th>
						{{-- <th class="v-middle text-center" >Reg Id</th> --}}
						<th class="v-middle text-center" >Nama</th>
						<th class="v-middle text-center" >Jenis Pasien</th>
						<th class="v-middle text-center" >Waktu Observasi</th>
						<th class="v-middle text-center" >Cara Pulang</th>
						<th class="v-middle text-center" >Meninggal</th>
						<th class="v-middle text-center" >Diinapkan</th>
						<th class="v-middle text-center"  style="min-width:90px">Rujuk</th>
						<th class="v-middle text-center"  style="min-width:90px">Obs. Anak</th>
						<th class="v-middle text-center"  style="min-width:90px">Obs. Dewasa</th>
						<th class="v-middle text-center"  style="min-width:90px">Resus</th>
						<th class="v-middle text-center"  style="min-width:90px">Triage</th>
						<th class="v-middle text-center"  style="min-width:90px">Bedah</th>
						<th class="v-middle text-center"  style="min-width:90px">Iso</th>
						<th class="v-middle text-center"  style="min-width:90px">Keterangan</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($daruratItems as $d)
					<tr>
						<td class="text-center">{{ $no++ }}</td>
						{{-- <td class="text-center">{{ $d->regID }}</td> --}}
						<td class="text-center">{{ $d->nama }}</td>
						<td class="text-center">{{ $d->status == 'baru' ? 'Baru' : 'Lama' }}</td>
						<td class="text-center">{{ $d->waktu_observasi }}</td>
						<td class="text-center">{{ $d->cara_pulang ?? '-' }}</td>
						<td class="text-center">{{ $d->meninggal ?? '-' }}</td>
						<td class="text-center">{{ $d->inap ?? 'Tidak' }}</td>
						<td class="text-center">{{ $d->rujuk ?? '-' }}</td>
						<td class="text-center">{{ $d->obs_anak ? 'Ya' : 'Tidak' }}</td>
						<td class="text-center">{{ $d->obs_dewasa ? 'Ya' : 'Tidak' }}</td>
						<td class="text-center">{{ $d->resus ? 'Ya' : 'Tidak' }}</td>
						<td class="text-center">{{ $d->triage ? 'Ya' : 'Tidak' }}</td>
						<td class="text-center">{{ $d->bedah ? 'Ya' : 'Tidak' }}</td>
						<td class="text-center">{{ $d->iso ? 'Ya' : 'Tidak' }}</td>
						<td class="text-center">{{ $d->keterangan ?? '-' }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			