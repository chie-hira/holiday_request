@props(['affiliation'])

@if ($affiliation->id == 1)
    {{ $affiliation->factory->factory_name }}
@elseif ($affiliation->department_id == 1)
    {{ Str::substr($affiliation->factory->factory_name, 0, 2) }}
@elseif ($affiliation->department_id != 1 && $affiliation->group_id == 1)
    {{ Str::substr($affiliation->factory->factory_name, 0, 2) }}
    {{ $affiliation->department->department_name }}
@else
    {{ Str::substr($affiliation->factory->factory_name, 0, 2) }}
    {{ $affiliation->department->department_name }}
    {{ Str::limit($affiliation->group->group_name, 8) }}
@endif
