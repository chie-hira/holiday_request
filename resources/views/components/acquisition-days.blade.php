@props(['user', 'key'])

@if ($key <= 2 || $key == 12)
    {{ $user->acquisitionDays($key) }} 日
@endif
@if ($key == 13 || $key == 14 || $key == 15)
    {{ $user->acquisitionHours($key) }} 時間
    @if ($user->acquisitionMinutes($key) != 0)
        {{ $user->acquisitionMinutes($key) }} 分
    @endif
@endif
