@props(['user', 'key'])

{{-- @if ($user->sum_get_days->first()) --}}
    @if ($user->acquisitionDays($key) != 0)
        {{ $user->acquisitionDays($key) }} 日
    @endif
    @if ($user->acquisitionHours($key) != 0)
        {{ $user->acquisitionHours($key) }} 時間
    @endif
    @if ($user->acquisitionMinutes($key) != 0)
        {{ $user->acquisitionMinutes($key) }} 分
    @endif
    @if ($user->acquisitionDays($key) == 0)
        {{ 0 }} 日
    @endif
{{-- @endif --}}
