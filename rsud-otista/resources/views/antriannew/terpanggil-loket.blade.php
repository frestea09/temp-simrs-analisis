@if (isset($antrian->loket))
    {{ !empty($antrian->loket) ? 'Loket '.$antrian->loket : NULL }}
@endif