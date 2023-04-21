@props(['user', 'key'])

@if ($user->sum_get_days->first())
    @if ($user->sumGetDaysOnly($key) != 0)
        {{ $user->sumGetDaysOnly($key) }} 日&emsp;
    @endif
    @if ($user->sumGetHours($key) != 0)
        {{ $user->sumGetHours($key) }} 時間
    @endif
    @if ($user->sumGetHours($key) == 0)
        &emsp;&emsp;&emsp;
    @endif
@endif
