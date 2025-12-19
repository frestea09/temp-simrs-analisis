@extends('master')

@section('header')
  <h1>Hasil Laboratorium</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">

      </h3>
    </div>
    <div class="box-body">
    <br>
    <div class="table-responsive">

      <table class="table  table-striped table-bordered table-hover table-condensed">
        <tbody>
          <tr>
            <th >No. RM</th> <td>: {{ $registrasi->pasien->no_rm }}</td>
            <th>Tgl Lahir / Kelamin</th> <td>: {{ tgl_indo($registrasi->pasien->tgllahir) }} / {{ $registrasi->pasien->kelamin }}</td>
          </tr>
          <tr>
            <th>Nama Pasien</th> <td>: {{ $registrasi->pasien->nama }}</td>
            <th>Dokter Pengirim</th> <td>: {{ baca_dokter($hasillab->dokter_id) }} </td>
          </tr>
          <tr>
            <th>Alamat</th> <td>: {{ $registrasi->pasien->alamat }}</td>
            <th>Dokter Pemeriksa</th> <td>: {{ baca_dokter($hasillab->penanggungjawab) }}</td>
          </tr>

        </tbody>
      </table>
    </div>
    <div class="table-responsive">

      <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr>
            <th class="">PEMERIKSAAN</th>
            <th class="text-center">PENGAMBILAN</th>
            <th class="text-center" style="">HASIL</th>
            <th class="text-center" style="">STANDART</th>
            <th class="text-center" style="">SATUAN</th>
          </tr>
        </thead>

        <tbody>
          @php $kat = 0; @endphp
        @foreach($hasillabs as $labs)
            @php $rincian = App\RincianHasillab::where(['hasillab_id' => $labs->id])->get(); @endphp
            @foreach ($rincian as $item)
              @if($item->labkategori_id != $kat)
              <tr class="_border">
                <td colspan="5" style="padding-top:10px;"> <b> {{ App\Labkategori::where('id',$item->labkategori_id)->first()->nama }}</b></td>
              </tr>
              @else
                
              @endif

              @if($kat != 0 && $item->labkategori_id != $kat)
              <tr class="">
               <td>{{ $item->laboratoria->nama }}</td>
              @else
              <tr>
                <td>{{ $item->laboratoria->nama }}</td>
              @endif
              <td class="text-center" style="">{{ $item->created_at }}</td>
              <td class="text-center" style="">{{ $item->hasil }}</td>
              <td class="text-center" style="">{{ $item->laboratoria->nilairujukanbawah }} - {{ $item->laboratoria->nilairujukanatas }}</td>
              <td class="text-center" style="">{{ $item->laboratoria->satuan }}</td>
            </tr>
                @php $kat = $item->labkategori_id; @endphp
            @endforeach
        @endforeach
        </tbody>
      </table>
    </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">


</script>
@endsection
