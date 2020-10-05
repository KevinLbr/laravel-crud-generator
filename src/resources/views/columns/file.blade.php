<td>
{{--    TODO remove media ?--}}
    @if ($entity->media)
        <img style="width: 50px" src="{{ $entity->media->route() }}">
    @else
{{--        TODO --}}
    @endif
</td>
