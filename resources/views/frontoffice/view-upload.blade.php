@extends('master')
@section('header')
  <h1>View Hasil Upload file EMR</h1>
@endsection
@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
    </h3>
  </div>
  <div class="box-body">
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
            <th class="text-center">No</th>
            <th class="text-center">No Hasil</th>
            <th >Penanggung Jawab</th>
            <th >Tgl Pemeriksaan</th>
            <th >Tgl Hasil Selesai</th>
            <th >Hasil</th>
            <th >Diupload Oleh</th>
            {{-- <th >Hapus</th> --}}
        </tr>
    </thead>
    <tbody>
        @forelse ($hasilPemeriksaan as $hasil)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$hasil->no_hasil_pemeriksaan}}</td>
                <td>{{$hasil->pegawai->nama}}</td>
                <td>{{date('d-m-Y H:i',strtotime($hasil->tgl_pemeriksaan))}}</td>
                <td>{{date('d-m-Y H:i',strtotime($hasil->tgl_hasilselesai))}}</td>
                <td><a href="/hasil-pemeriksaan/{{$hasil->filename}}" target="_blank" class="btn btn-info"><i class="fa fa-eye"> Lihat</i></a></td>
                <td>{{baca_user($hasil->user_id)}}</td>
                {{-- <td><a href="/emr-hasil-pemeriksaan/hapus-hasil-pemeriksaan/{{$hasil->id}}" class="btn btn-flat btn-danger" onclick="return confirm('Yakin akan hapus hasil pemeriksaan?')"><i class="fa fa-trash"> Hapus</i></a></td> --}}
            </tr>
        @empty
            <tr>
                <td class="text-center" colspan="7">Tidak Ada Data</td>
            </tr>
        @endforelse
    </tbody>
      
      
      <tfoot> 
        <tr>
          <th>

          </th> 
        </tr>
      </tfoot>
    </table>
  </div>
  </div>
</div>

  
  @endsection