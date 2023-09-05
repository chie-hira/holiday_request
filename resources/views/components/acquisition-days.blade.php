@props(['user', 'key'])

@if ($key == 13 || $key == 14 || $key == 15)
    {{ $user->acquisitionHours($key) }} 時間
    @if ($user->acquisitionMinutes($key) != 0)
        {{ $user->acquisitionMinutes($key) }} 分
    @endif
@else
    {{ $user->acquisitionDays($key) }} 日
@endif
