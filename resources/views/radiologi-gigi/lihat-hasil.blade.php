@extends('master')

@section('header')
  <h1>Hasil Ekspertise</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
           
      </h3>
    </div>
    <div class="box-body">

      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <tbody class="table table-borderless">
              <tr>
                <td> Nomer</td>
                <td>:</td>
                <td> {{ $radiologi->no_dokument }} </td>
  
                <td> Tanggal </td>
                <td>:</td>
                <td>  {{  $radiologi->created_at->format('d-m-Y') }} </td>
              </tr>
              <tr>
                <td> Nama </td>
                <td>:</td>
                <td> {{ $radiologi->nama }} </td>
  
                <td> Jenis Klamin </td>
                <td>:</td>
                <td> {{ $radiologi->kelamin }} </td>
              </tr>
              <tr>
                <td> Cara Bayar </td>
                <td>:</td>
                <td> {{ baca_carabayar($radiologi->bayar) }} </td>
  
                <td> Umur </td>
                <td>:</td>
                <td> {{ hitung_umur($radiologi->tgllahir) }}</td>
              </tr>
              <tr>
                <td> Klinik / Ruangan </td>
                <td>:</td>
                <td> 
                @if (substr($radiologi->status_reg, 0,1) == 'I' )
                    @php
                        $irna = \App\Rawatinap::where('registrasi_id', $radiologi->registrasi_id)->first();
                    @endphp
                    {{ $irna ? baca_kamar($irna->kamar_id) : null}}
                @else
                    {{ baca_poli($radiologi->poli_id) }}
                @endif
                 </td>
                 <td> No. Rm </td>
                 <td>:</td>
                 <td> {{ no_rm($radiologi->no_rm) }} </td>
              </tr>
              <tr>
                  <td>Dokter Pengirim </td>
                  <td>:</td>
                  <td> {{ baca_dokter($radiologi->pengirim) }} </td>
                  <td> Tanggal Ekpertise </td>
                  <td>:</td>
                  <td> {{ $radiologi->tanggal_eksp }} </td>
              </tr>
              <tr>
                <td>Dokter </td>
                <td>:</td>
                <td> {{ baca_dokter($radiologi->dokter) }} </td>
              </tr>
              <tr>
                <td>Klinis </td>
                <td>:</td>
                <td> {{ $radiologi->klinis }} </td>
              </tr>
            </tbody>
          </table>
        <h5">Ekpertise :</h5>
        <div style="border:1px solid gray; padding: 5px; border-radius: 5px; word-wrap: break-word;">
          {!! $radiologi->ekspertise !!}
        </div>
    </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">


</script>
@endsection
