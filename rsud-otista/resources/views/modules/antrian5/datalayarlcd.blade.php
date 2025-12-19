@if (isset($antrian->nomor))
    {{ !empty($antrian->nomor) ? 'E'.$antrian->nomor : NULL }}
@endif

