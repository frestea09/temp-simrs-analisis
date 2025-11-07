
{!! Form::open(['method' => 'POST', 'url' => 'penjualan/updateFaktur', 'class'=>'form-horizontal']) !!}
	{!! Form::hidden('namatarif', $folio->namatarif) !!}
	<table class="table table-condensed table-bordered">
		<tr>
			<th>Nama Pasien</th> <td>{{ $reg->pasien->nama }}</td>
		</tr>
		<tr>
			<th>Nomor RM</th> <td>{{ $reg->pasien->no_rm }}</td>
		</tr>
		<tr>
			<th>Cara Bayar</th>
			<td>
				<div class="form-group">
					<div class="col-md-12">
						{!! Form::select('cara_bayar_id', $carabayar, $folio->cara_bayar_id, ['class' => 'form-control select2', 'id' => 'idBayar', 'style' => 'width:100%']) !!}
					</div>
				</div>
			</td>
		</tr>
		<tr class="{{ ($folio->cara_bayar_id == 2) ? '' : 'hidden'}}" id="bayar">
			<th>Pembayaran</th>
			<td>
				<div class="form-group">
					<div class="col-md-12">
						{!! Form::select('bayar', ['Y' => "Lunas",'N' => 'Belum Lunas'], $folio->lunas, ['class' => 'form-control select2', 'style' => 'width:100%']) !!}
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<th>Tanggal Input</th>
			<td>
				<div class="form-group">
					<div class="col-md-12">
						{!! Form::text('created_at', $folio->created_at->format('d-m-Y'), ['class' => 'form-control datepicker', 'style' => 'width:100%']) !!}
					</div>
				</div>
			</td>
        </tr>
        <tr>
			<th>No Resep</th>
			<td>
				{{$p->no_resep}}
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<div class="form-group">
					<div class="col-md-12 text-right">
						<a href="{{ url('penjualan/hapus-faktur-baru/'.$p->no_resep) }}" class="btn btn-danger btn-flat">Hapus Faktur</a>
					</div>
				</div>
			</td>
		</tr>
	</table>
{!! Form::close() !!}
	<div class="table-responsive">
		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th class="text-center">No</th>
					<th>Nama Obat</th>
					<th class="text-center">Jml INACBG</th>
					<th class="text-center">Jml Kronis</th>
					<th class="text-center">Harga</th>
					<th class="text-center">Harga Kronis</th>
				</tr>
			</thead>
			<tbody>
				@php $jual = 0;$kronis = 0; @endphp
				@foreach ($data as $d)
					<tr>
						<td class="text-center">{{ $no++ }}</td>
						<td>
                            {{-- {{ $d->masterobat->nama }} --}}
                            {{ !empty($d->logistik_batch_id) ? baca_batches($d->logistik_batch_id) :$d->masterobat->nama }}
                        </td>
						<td class="text-center">{{ $d->jumlah }}</td>
						<td class="text-center">{{ $d->jml_kronis }}</td>
						<td class="text-right">{{ number_format($d->hargajual) }}</td>
						<td class="text-right">{{ number_format($d->hargajual_kronis) }}</td>
					</tr>
					@php $jual += $d->hargajual; $kronis += $d->hargajual_kronis; @endphp
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" class="text-center">Total</th>
					<th class="text-right">{{ number_format($jual) }}</th>
					<th class="text-right">{{ number_format($kronis) }}</th>
					<th></th>
				</tr>
			</tfoot>
		</table>
	</div>
	<script>
		$( ".datepicker" ).datepicker({
			format: "dd-mm-yyyy",
			autoclose: true
		});
		$('.select2').select2();
		$('#idBayar').on('change', function(){
			if($(this).val() == 2){
				$('#bayar').removeClass('hidden');
			}else{
				if(!$('#bayar').hasClass('hidden')){
					$('#bayar').addClass('hidden');
					$('select[name="bayar"]').val('{{ $folio->lunas }}').change();
				}
			}
		})
	</script>