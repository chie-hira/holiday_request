@props(['affiliation'])

@if ($affiliation->id == 1)
    {{ $affiliation->factory->factory_name }}
@elseif ($affiliation->department_id == 1)
    {{ $affiliation->factory->factory_name }}
@elseif ($affiliation->department_id != 1 && $affiliation->group_id == 1)
    {{ $affiliation->factory->factory_name }}
    {{ $affiliation->department->department_name }}
@else
    {{ $affiliation->factory->factory_name }}
    {{ $affiliation->department->department_name }}
    {{ $affiliation->group->group_name }}
@endif
