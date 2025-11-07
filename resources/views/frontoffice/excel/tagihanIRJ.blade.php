
	@php
		use \Modules\Registrasi\Entities\Folio;
		$no = 1;
	@endphp
			<table class='table table-bordered table-hover' style="font-size:11px;">
				<thead>
					  <tr>
						<th class="v-middle text-center">No</th>
						<th class="v-middle text-center">No. RM</th>
						<th class="v-middle text-center">Nama</th>
						<th class="v-middle text-center">Ruangan</th>
						<th class="v-middle text-center">No. SEP</th>
						<th class="v-middle text-center">Status</th>
						<th class="v-middle text-center">L/P</th>
						<th class="v-middle text-center">Bayar</th>
						<th class="v-middle text-center">DPJP</th>
						<th class="v-middle text-center" style="min-width:90px">Tanggal</th>
						<th class="v-middle text-center" style="color:red">Diagnosa (dari Coder)</th>
						<th class="v-middle text-center" style="color:red">Retribusi Umum</th>
						<th class="v-middle text-center" style="color:red">Retribusi Spesialis</th>
						<th class="v-middle text-center" style="color:red">Retribusi Konseling</th>
						<th class="v-middle text-center" style="color:red">Resume Medis</th>
						<th class="v-middle text-center" style="color:red">TMO Pembedahan</th>
						<th class="v-middle text-center" style="color:red">Tindakan Operatif Jasa RS</th>
						<th class="v-middle text-center" style="color:red">TPO Pembedahan</th>
						<th class="v-middle text-center" style="color:red">TP (Tindakan Perawat)</th>
						<th class="v-middle text-center" style="color:red">TP (Tindakan Perawat) Hemato</th>
						<th class="v-middle text-center" style="color:red">TM</th>
						<th class="v-middle text-center" style="color:red">Lab</th>
						{{-- <th class="v-middle text-center" style="color:red">Dokter Lab 1 (dr. Jenny)</th>
						<th class="v-middle text-center" style="color:red">Dokter Lab 2 (dr. Andy)</th> --}}
						<th class="v-middle text-center" style="color:red">Dokter PA (dr. Yuke)</th>
						<th class="v-middle text-center" style="color:red">Dokter Rad 1 (dr. Indrarini)</th>
						<th class="v-middle text-center" style="color:red">Dokter Rad 1 (dr. Taufiq)</th>
						<th class="v-middle text-center" style="color:red">Dokter Rad Gigi (drg. Nine)</th>
						<th class="v-middle text-center" style="color:red">EKG Dalam</th>
						<th class="v-middle text-center" style="color:red">EKG Jantung</th>
						<th class="v-middle text-center" style="color:red">EKG Anak</th>
						{{-- <th class="v-middle text-center" style="color:red">EKG</th> --}}
						<th class="v-middle text-center" style="color:red">USG Obgyn</th>
						<th class="v-middle text-center" style="color:red">USG dr. Indrarini</th>
						<th class="v-middle text-center" style="color:red">USG dr. Taufiq</th>
						<th class="v-middle text-center" style="color:red">Tindakan Rehab Medis</th>
						<th class="v-middle text-center" style="color:red">CTG/NST</th>
						<th class="v-middle text-center" style="color:red">CT Scan</th>
						<th class="v-middle text-center" style="color:red">Paket Alkes</th>
						<th class="v-middle text-center" style="color:red">Retribusi OBS</th>
						<th class="v-middle text-center" style="color:red">Farmasi Rajal</th>
						<th class="v-middle text-center" style="color:red">Farmasi OK</th>
						<th class="v-middle text-center" style="color:red">Total</th>
					</tr>
				</thead>
				<tbody>
					 <tbody>
						@if (count($rajal) > 0)
							
							@foreach ($rajal as $d)
							<tr>
								<td class="text-center">{{ $no++ }}</td>
								<td class="text-center">{{ $d->no_rm }}</td>
								<td>{{ $d->nama }}</td>
								<td>{{ baca_poli($d->poli_id) }}</td>
								<td>{{ $d->no_sep }}</td>
								<td>{{ ucfirst($d->status) }}</td>
								<td>{{ $d->kelamin }}</td>
								<td>{{ baca_carabayar($d->bayar) }}
								@if ($d->bayar == '1')
									-{{$d->tipe_jkn}}
								@endif
								</td>
								<td>{{ baca_dokter($d->dokter_id) }}</td>
								<td class="text-center">{{ date('d-m-Y', strtotime($d->created_at)) }}</td>
								<td>
									@php
										$diagnosa = \App\JknIcd10::where('registrasi_id',$d->registrasi_id)->select('icd10')->get();
									@endphp
									@foreach ($diagnosa as $item)
										&#x2022; {{$item->icd10}}<br/>
									@endforeach
								</td>
								<td>
									@php
										$retr_umum = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->whereIn('namatarif',['Retribusi Umum','Retribusi Poliklinik Gigi dan Mulut'])->sum('total');
									@endphp
									{{$retr_umum}}
								</td>
								<td>
									@php
										$retr_spesialis = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->whereIn('namatarif',['Retribusi Spesialis','Retribusi Poliklinik THT',
											'Retribusi Poliklinik Syaraf',
											'Retribusi Poliklinik Rehabilitasi Medik',
											'Retribusi Poliklinik Psikiatri',
											'Retribusi Poliklinik Orthopedi',
											'Retribusi Poliklinik MCU',
											'Retribusi Poliklinik Mata',
											'Retribusi Poliklinik Kulit dan Kelamin',
											'Retribusi Poliklinik Konservasi Gigi',
											'Retribusi Poliklinik Kemuning',
											'Retribusi Poliklinik Kebidanan dan Kandungan',
											'Retribusi Poliklinik Jantung',
											'Retribusi Poliklinik Hematologi dan Onkologi',
											'Retribusi Poliklinik Gizi',
											'Retribusi Poliklinik Eksekutif',
											'Retribusi Poliklinik DOTS',
											'Retribusi Poliklinik Bedak Mulut',
											'Retribusi Poliklinik Bedah Saraf',
											'Retribusi Poliklinik Bedah Mulut',
											'Retribusi Poliklinik Bedah Anak',
											'Retribusi Poliklinik Bedah',
											'Retribusi Poliklinik Aster (Anak Eksekutif)',
											'Retribusi Poliklinik Anesthesi',
											'Retribusi Poliklinik Anak',
											'Retribusi Penyakit Dalam'])->sum('total');
									@endphp
									{{$retr_spesialis}}
								</td>
								<td>
									@php
										$retr_kons = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%konseling%')->sum('total');
									@endphp
									{{$retr_kons}}
								</td>
								<td>
									@php
										$resume = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%resume%')->sum('total');
									@endphp
									{{$resume}}
								</td>
								<td>
									{{-- TMO PEMBEDAHAN --}}
									@php
										$tmo = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%tindakan pembedahan%')->sum('total');
									@endphp
									{{$tmo}}
								</td>
								<td>
									{{-- Tindakan Operatif Jasa RS --}}
									@php
										$tojrs = \Modules\Registrasi\Entities\Folio::
										leftJoin('tarifs','tarifs.id','=','folios.tarif_id')
										->where('tarifs.kategori_tagihan',196)
										->where('folios.registrasi_id',$d->registrasi_id)
										->sum('folios.total');
									@endphp
									{{$tojrs}}
								</td>
								<td>
									{{-- TPO Pembedahan --}}
									@php
										$tpo = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%tindakan keperawatan%')->sum('total');
									@endphp
									{{$tpo}}
								</td>
								<td>
									{{-- TP (Tindakan Perawat) --}}
									<i>Belum terkalkulasi</i>
								</td>
								<td>
									{{-- TP (Tindakan Perawat) Hemato --}}
									<i>Belum terkalkulasi</i>
								</td>
								<td>
									@php
										$tm = \Modules\Registrasi\Entities\Folio::
										leftJoin('tarifs','tarifs.id','=','folios.tarif_id')
										->where('tarifs.kategori_tagihan',195)
										->where('folios.registrasi_id',$d->registrasi_id)
										->sum('folios.total');
									@endphp
									{{$tm}}
								</td>
								<td>
									{{-- Labor --}}
									@php
										$labor = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('poli_tipe','L')->sum('total');
									@endphp
									{{$labor}}
								</td>
								{{-- <td> --}}
									{{-- Dokter Lab 1 (dr. Jenny) --}}
									{{-- @php
										$drjenny = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('dokter_id',17)
										->where(function ($query){
											$query->where('dokter_lab', 17);
										})
										->sum('total');
									@endphp
									{{$drjenny}} --}}
								{{-- </td> --}}
								{{-- <td> --}}
									{{-- <i>Belum terkalkulasi</i> --}}
									{{-- Dokter Lab 2 (dr. Andy) --}}
									{{-- @php
										$drandy = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('dokter_id',17)
										->where(function ($query){
											$query->where('dokter_lab', 851);
												// ->orWhere('dpjp', 851);
										})
										->sum('total');
									@endphp
									{{$drandy}} --}}
								{{-- </td> --}}
								<td>
									@php
										$yuke = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('dokter_lab',24)->sum('total');
									@endphp
									{{$yuke}}
								</td>
								<td>
									{{-- Dokter Rad 1 (dr. Indrarini) --}}
									@php
										$indrarini = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('dokter_radiologi',20)->sum('total');
									@endphp
									{{$indrarini}}
								</td>
								<td>
									{{-- Dokter Rad 1 (dr. Taufiq) --}}
									@php
										$tauf = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('dokter_radiologi',31)->sum('total');
									@endphp
									{{$tauf}}
								</td>
								<td>
									{{-- Dokter Rad 1 (dr. Nine) --}}
									@php
										$nine = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('dokter_radiologi',43)->sum('total');
									@endphp
									{{$nine}}
								</td>
								{{-- <td>
									@php
										$ekg = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%ekg%')->sum('total');
									@endphp
									{{$ekg}}
								</td> --}}
								<td>
									{{-- EKG DALAM --}}
									@php
										$ekgdalam = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%ekg%')->where('poli_id',2)->sum('total');
									@endphp
									{{$ekgdalam}}
								</td>
								<td>
									{{-- EKG JANTUNG --}}
									@php
										$ekgjantung = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%ekg%')->where('poli_id',14)->sum('total');
									@endphp
									{{$ekgjantung}}
								</td>
								<td>
									{{-- EKG ANAK --}}
									@php
										$ekganak = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%ekg%')->where('poli_id',8)->sum('total');
									@endphp
									{{$ekganak}}
								</td>
								<td>
									@php
										$uso = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%USG Kandungan%')->sum('total');
									@endphp
									{{$uso}}
								</td>
								<td>
									@php
										$usgindrarini = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%USG%')->where('dokter_radiologi',20)->sum('total');
									@endphp
									{{$usgindrarini}}
								</td>
								<td>
									@php
										$usgtauf = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%USG%')->where('dokter_radiologi',31)->sum('total');
									@endphp
									{{$usgtauf}}
								</td>
								<td>
									@php
										$rehab = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('dokter_id',17)
										->where(function ($query){
											$query->where('namatarif','LIKE','%Rehab Medik%')
												->orWhere('namatarif','LIKE', '%Rehab Medis%');
										})
										->sum('total');
									@endphp
									{{$rehab}}
								</td>
								<td>
									@php
										$ctg = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%CTG%')->sum('total');
									@endphp
									{{$ctg}}
								</td>
								<td>
									@php
										$cts = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','CT.%')->sum('total');
									@endphp
									{{$cts}}
								<td>
									@php
									$retrobs = array('sticker','stiker','hari rawat');

									$retr_obs = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)
											->Where(function ($query) use($retrobs) {
												for ($i = 0; $i < count($retrobs); $i++){
													$query->orwhere('namatarif', 'like',  '%' . $retrobs[$i] .'%');
												}      
											})->sum('total');
									@endphp
									{{$retr_obs}}
								</td>
								<td>
									@php
										$paket_alkes = \Modules\Registrasi\Entities\Folio::where('registrasi_id',$d->registrasi_id)->where('namatarif','LIKE','%Paket Alkes%')->sum('total');
									@endphp
									{{$paket_alkes}}
								</td>
								<td>
									{{-- obat rajal --}}
									@php
										$obatrajal = Folio::where('registrasi_id', '=', $d->registrasi_id)
											->where('namatarif','LIKE','%FRJ%')
											->sum('total');
										 
									@endphp
									{{$obatrajal}}
								</td>
								
								<td>
									{{-- obat operasi --}}
									@php
										$obat_gudang_operasi = Folio::where('registrasi_id', '=', $d->registrasi_id)
											->where('namatarif','LIKE','FRO%')
											->sum('total');
										 
									@endphp
									{{$obat_gudang_operasi}}
								</td>
								
								<td>
									{{$retr_umum+$tojrs+$tm+$retr_spesialis+$labor+$retr_kons+$resume+$yuke+$usgtauf+$indrarini+$usgindrarini+$tauf+$nine+$ekganak+$ekgjantung+$ekgdalam+$uso+$paket_alkes+$retr_obs+$tmo+$tpo+$rehab+$ctg+$obat_gudang_operasi+$obatrajal}}
								</td>
							</tr>
							@endforeach
						@endif
					</tbody>
				</tbody>
			</table>