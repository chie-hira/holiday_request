@props(['user', 'key'])

@if ($user->remainings->first())
    @if ($user->remainingDaysOnly($key) != 0)
        {{ $user->remainingDaysOnly($key) }} 日&emsp;
    @endif
    @if ($user->remainingHours($key) != 0)
        {{ $user->remainingHours($key) }} 時間
    @endif
    @if ($user->remainingHours($key) == 0)
        &emsp;&emsp;&emsp;
    @endif
    @if ($user->remainings->where('report_id', '=', $key+1)->first()->remaining == 0)
        {{ $user->remainings->where('report_id', '=', $key+1)->first()->remaining }} 日&emsp; &emsp;&emsp;&emsp;
    @endif
@endif
