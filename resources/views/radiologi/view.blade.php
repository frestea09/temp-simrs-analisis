@extends('master')
@section('header')
  <h1>RADIOLIGI<small>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <a href="{{url()->previous()}}" class="btn btn-default" id="tambah"> Kembali </a></small>
    <a href="{{url('radiologi/hasil-radiologi')}}" class="btn btn-default" id="tambah"> Kembali kehasil Radiologi</a></small>
  </h1>
@endsection
@section('content')
  <hr style="border-top: 1px solid red;"/>
  <div class='table-responsive'>
    <table class='table table-striped table-bordered table-hover table-condensed'>
      <tr>
        <td>Nama</td>
        <td>{{@$reg->pasien->nama}}</td>
      </tr>
      <tr>
        <td>RM</td>
        <td>{{@$reg->pasien->no_rm}}</td>
      </tr>
      <tr>
        <td>Dokter</td>
        <td>{{baca_dokter(@$reg->dokter_id)}}</td>
      </tr>
      <tr>
        <td>Poli</td>
        <td>
          @php
              $histori = \App\HistorikunjunganIRJ::where('registrasi_id',@$reg->id)->orderBy('id','DESC')->first();
          @endphp
          @if ($histori)
          {{baca_poli(@$histori->poli_id)}}  
          @else
          {{@$reg->poli->nama}}
          @endif
        </td>
      </tr>
    </table>
    <table class='table table-striped table-bordered table-hover table-condensed'>
      <thead> 
        <tr>
          <th>No</th>
          <th>Tindakan</th>
          <th>Catatan</th>
          <th>Pelayanan</th>
          <th>Biaya</th>
          <th>Jml</th>
          <th>Total</th>
          <th>Dokter Radiologi</th>
          <th>Pelaksana</th>
          <th>Cara Bayar</th>
          <th>Admin</th>
          <th>Waktu</th>
          {{-- @role(['rawatjalan','supervisor', 'rawatdarurat','administrator']) --}}
          <th>Hapus</th>
          {{-- @endrole --}}
        </tr>
      </thead>
      <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($folio as $key => $d)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ ($d->tarif_id <> 10000 ) ? $d->tarif_baru->nama : 'Penjualan Obat' }}</td>
                <td>{{ $d->catatan}}</td>
                <td>{{ baca_poli($d->poli_id) }}</td>
                <td class="text-right">{{ ($d->tarif_id <> 10000 ) ? number_format($d->tarif_baru->total,0,',','.') : '' }}</td>
                <td class="text-center">{{ ($d->tarif_id <> 10000 ) ? ($d->total / $d->tarif_baru->total) : '' }}</td>
                <td class="text-center">{{ number_format($d->total,0,',','.') }}</td>

                <td>
                  <select name="dokter" id="dokter" class="form-control select2 col-md-6" onchange="editDokter({{ $d->id }})">
                    <option value="{{ $d->dokter_radiologi }}" selected>{{ baca_pegawai($d->dokter_radiologi) }}</option>
                    @foreach ($dokter as $dok)
                    <option value="{{ $dok->dokter_radiologi }}">{{ baca_pegawai($dok->dokter_radiologi) }}</option>
                    @endforeach
                   
                  </select>
                </td>


                <td>
                  <select name="radiografer" id="radiografer" class="form-control select2" onchange="editPelaksana({{ $d->id }})">
                    <option value="{{ $d->radiografer }}" selected>{{ baca_pegawai($d->radiografer) }}</option>
                    @foreach ($radiografer as $item)
                    <option value="{{ $item->radiografer }}">{{ baca_pegawai($item->radiografer) }}</option>
                    @endforeach
                   
                  </select>
                </td>
                <td>{{ baca_carabayar($d->cara_bayar_id) }}</td>
                <td>{{ $d->user->name }}</td>
                <td>{{ $d->created_at->format('d-m-Y') }}</td>
                <td>
                  @if ($d->lunas == 'Y')
                    <i class="fa fa-check"></i>
                  @else
                    <a href="{{ url('tindakan/hapus-tindakan/'.$d->id.'/'.$d->registrasi_id.'/'.$d->pasien_id) }}" onclick="return confirm('Yakin akan di hapus?')" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash-o"></i></a>
                  @endif
                </td>
              </tr>
            @endforeach
      </tbody>
      <tfoot> 
        <tr>
          <th>

          </th> 
        </tr>
      </tfoot>
    </table>
  </div>

  
  @endsection
  @section('script')
    <script>
        $('.select2').select2();

        function editPelaksana(id) {
          var radiografer = $("#radiografer option:selected").val();

        $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/radiologi/edit-rad/'+id+'/'+radiografer,
        type: 'POST',
        dataType: 'json',
        })
        .done(function(data) {
          alert('Berhasil Edit Radiografer')
        
        })
        .fail(function() {
          alert('Gagal Edit Radiografer');
        });

      }


      function editDokter(id) {
          var dokter = $("#dokter option:selected").val();

        $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/radiologi/edit-dok/'+id+'/'+dokter,
        type: 'POST',
        dataType: 'json',
        })
        .done(function(data) {
          alert('Berhasil Edit Dokter')
        
        })
        .fail(function() {
          alert('Gagal Edit Dokter');
        });

      }












    </script>
  @endsection