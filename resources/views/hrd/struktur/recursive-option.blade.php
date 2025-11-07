<li class="folder" data-task="{{ $child->task_id }}" data-parent="{{ $child->id }}" data-parent-name="{{ $child->nama }}"> <a href="#" class="loc-href">{{ $child->nama }}</a>
    @if ($child->children)
        <ul>
            @foreach ($child->childrenLocation as $k => $child)
                @include('hrd.struktur.recursive-option', ['child' => $child])
            @endforeach
        </ul>
    @endif
</li>

</li>