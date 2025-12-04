<div class="btn btn-info btn-block">
  <h1>LOKET 1</h1>
</div>
<div class="panel panel-info">
  <div class="panel-heading">
    <h1 class="panel-title text-center">NOMOR ANTRIAN</h1>
  </div>
  <div class="panel-body text-center">
    @if (isset($antrian->nomor))
      <h1 style="font-size:1600%" style="font-weight: bold;">{{ $antrian->nomor }}</h1>
    @endif
  </div>

</div>
{{-- Play Audio --}}
@if (isset($antrian))
  @if ($antrian->panggil == 0)
    <audio autoplay="true">
      <source src="{{ asset('suara_1/'.$antrian->suara) }}" type="audio/mp3">
    </audio>
  @endif

  @php
    DB::table('antrians')->where('id', $antrian->id)->update(['panggil' => 1]);
  @endphp
@endif
