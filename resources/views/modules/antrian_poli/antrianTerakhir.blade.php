@if (isset($antrian->nomor))
  @if($antrian->panggil == 0)
    <span class="blink_me">{{ !empty($antrian->nomor) ? $antrian->kelompok.$antrian->nomor : NULL }}</span>
  @else
    <span>{{ !empty($antrian->nomor) ? $antrian->kelompok.$antrian->nomor : NULL }}</span>
  @endif
@endif


