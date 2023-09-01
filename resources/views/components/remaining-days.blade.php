@props(['user', 'key'])

{{ $user->remainingDays($key) }} 日
@if ($user->remainingHours($key) != 0)
    {{ $user->remainingHours($key) }} 時間
@endif
@if ($user->remainingMinutes($key) != 0)
    {{ $user->remainingMinutes($key) }} 分
@endif
