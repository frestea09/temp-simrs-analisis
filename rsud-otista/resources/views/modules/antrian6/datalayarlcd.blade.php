@if (isset($antrian->nomor))
    {{ !empty($antrian->nomor) ? 'F'.$antrian->nomor : NULL }}
@endif
