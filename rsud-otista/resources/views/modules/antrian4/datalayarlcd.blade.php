
@if (isset($antrian->nomor))
    {{ !empty($antrian->nomor) ? $antrian->kelompok.$antrian->nomor : NULL }}
@endif

