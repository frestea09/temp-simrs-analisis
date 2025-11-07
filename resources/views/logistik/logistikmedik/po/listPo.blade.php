@extends('master')

@section('header')
  <h1>Logistik</h1>
@endsection

@section('content')
@role('verifikatorlogistik')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           Data yang belum diverifikasi
      </h3>
    </div>
    <div class="box-body">
        <form method="POST" id="form">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="id">
            <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed">
                <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Stok Gudang</th>
                    <th>Jumlah Yang Akan Dipesan</th>
                    <th>Cek</th>
                    <th>Cancel</th>
                    <th>Verifikasi</th>
                </tr>
                </thead>                      
                <tbody>
                    @if (!empty($belum_verif))
                        @foreach ($belum_verif as $d)
                                <tr>
                                    <td>{{ $d->nama }}</td>
                                    <td>{{ !empty(\App\Logistik\LogistikStock::where('gudang_id', 1)->where('masterobat_id', $d->masterobat_id)->latest()->first()->total) ? \App\Logistik\LogistikStock::where('gudang_id', 1)->where('masterobat_id', $d->masterobat_id)->latest()->first()->total:0}}</td>
                                    <td style="width:20%">
                                        @if ($d->verifikasi == 'Y' || $d->verifikasi == 'N' )
                                        {{ $d->jumlah }}
                                        @else
                                        <input type="number" name="jumlah{{ $d->id }}" value="{{ $d->jumlah }}" onchange=edit("{{ $d->id }}") class="form-control">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($d->verifikasi == 'Y')
                                        <i class="fa fa-check text-green"></i>
                                        @elseif ($d->verifikasi == 'N')
                                        <i class="fa fa-remove text-red"></i>
                                        @else
                                        <input type="checkbox" name="id[]" value="{{ $d->id }}">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->verifikasi == 'Y')
                                        <b>-</b>
                                        @elseif($d->verifikasi == 'N')
                                        <b class="text-red">Cancel</b>
                                        @else   
                                            <button type="button" onclick=cancel("{{ $d->id }}") class="btn btn-danger btn-sm btn-flat"> Cancel </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->verifikasi == 'Y')
                                        <b class="text-green">Terverif</b>
                                        @elseif($d->verifikasi == 'N')
                                        <b>-</b>
                                        @else 
                                            <button type="button" onclick=verifikasi("{{ $d->id }}") class="btn btn-success btn-sm btn-flat"> Verif </button>
                                        @endif
                                    </td>
                                </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            </div>
        </form>
        <div class="modal-footer">
            @if (Auth::user()->hasRole('verifikatorlogistik'))
            {{-- <button type="button" class="btn btn-success btn-flat" onclick="verifikasi()">Verif</button> --}}
            <a href="{{ url('logistikmedik/verifikasi') }}" type="button" class="btn btn-default btn-flat">Selesai</a>
            
            @else
            <a href="{{ url('logistikmedik/po') }}" type="button" class="btn btn-default btn-flat">Selesai</a>
                
            @endif
        
        </div>
    </div>
</div>

@endrole

<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
        Data yang sudah diverifikasi
      </h3>
    </div>
    <div class="box-body">
        <form method="POST" id="form">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="id">
            <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed">
                <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Stok Gudang</th>
                    <th>Jumlah Yang Akan Dipesan</th>
                    <th>Verifikasi</th>
                </tr>
                </thead>                      
                <tbody>
                    @if (!empty($verif))
                        @foreach ($verif as $d)
                                <tr>
                                    <td>{{ $d->nama }}</td>
                                    <td>
                                        @if (App\Logistik\LogistikStock::where('masterobat_id',$d->masterobat_id)->where('gudang_id', $d->gudang_id)->latest()->first()) 
                                            {{ App\Logistik\LogistikStock::where('masterobat_id',$d->masterobat_id)->where('gudang_id', $d->gudang_id)->latest()->first()->total }}
                                        @else
                                            {{ App\LogistikBatch::where('masterobat_id',$d->masterobat_id)->where('gudang_id', $d->gudang_id)->sum('stok') }}
                                        @endif
                                        
                                    </td>
                                    <td style="width:20%">
                                        {{ $d->jumlah }}
                                    </td>
                                    <td>
                                        @if ($d->verifikasi == 'Y')
                                        <b class="text-green">Verif</b>
                                        @elseif($d->verifikasi == 'N')
                                        <b class="text-red">Cancel</b>
                                        @elseif($d->verifikasi == 'B')
                                        <b class="text-info">Belum Diverifikasi</b>
                                        @endif
                                    </td>
                                </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            </div>
        </form>
        <div class="modal-footer">
            @if (Auth::user()->hasRole('verifikatorlogistik'))
            {{-- <button type="button" class="btn btn-success btn-flat" onclick="verifikasi()">Verif</button> --}}
            <a href="{{ url('logistikmedik/verifikasi') }}" type="button" class="btn btn-default btn-flat">Selesai</a>
            
            @else
            <a href="{{ url('logistikmedik/po') }}" type="button" class="btn btn-default btn-flat">Selesai</a>
                
            @endif
        
        </div>
    </div>
</div>


    
@endsection

@section('script')
<script type="text/javascript">

    function cencelpo(id){
		$.ajax({
			url: '/logistikmedik/cencel-po',
			type: 'POST',
			dataType: 'json',
			data: {
				'id':id, 
				'_token' : $('input[name="_token"]').val()
				}
		})
		.done(function(data) {
			if(data.sukses == false){
      }
			if(data.sukses == true){
                alert('Cancel PO Berhasil !!')
                location.reload()
			}
		});
    }

    function cancel(id){
		$.ajax({
			url: '/logistikmedik/verifikator-po-cancel',
			type: 'POST',
			dataType: 'json',
			data: {
				'id':id, 
				'_token' : $('input[name="_token"]').val()
				}
		})
		.done(function(data) {
			if(data.sukses == false){
      }
			if(data.sukses == true){
                location.reload()
			}
		});
    }

    function verifikasi(id){
		$.ajax({
			url: '/logistikmedik/verifikator-po-verif',
			type: 'POST',
			dataType: 'json',
			data: {
				'id':id, 
				'_token' : $('input[name="_token"]').val(),
				'jumlah': $('input[name="jumlah'+id+'"]').val(),
				}
		})
		.done(function(data) {
			if(data.sukses == false){
      }
			if(data.sukses == true){
                location.reload()
			}
		});
    }

    function edit(id){
		$.ajax({
			url: '/logistikmedik/edit-po',
			type: 'POST',
			dataType: 'json',
			data: {
				'id':id, 
				'jumlah': $('input[name="jumlah'+id+'"]').val(),
				'_token' : $('input[name="_token"]').val()
				}
		})
		.done(function(data) {
			if(data.sukses == false){
                alert('Jumlah Melebihi!!')
            }
            if(data.sukses == true){
              alert('Jumlah Berhasil di ubah!!')
            }
        });
	}
</script>
@endsection
