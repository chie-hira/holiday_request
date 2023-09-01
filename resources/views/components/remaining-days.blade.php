@props(['user', 'key'])

{{-- @if ($user->acquisition_days->first()) --}}
    @if ($user->remainingDays($key) != 0)
        {{ $user->remainingDays($key) }} 日
    @endif
    @if ($user->remainingHours($key) != 0)
        {{ $user->remainingHours($key) }} 時間
    @endif
    @if ($user->remainingMinutes($key) != 0)
        {{ $user->remainingMinutes($key) }} 分
    @endif
    @if ($user->remainingDays($key) == 0)
        {{ 0 }} 日
    @endif
{{-- @endif --}}
