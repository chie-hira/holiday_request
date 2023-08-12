@props(['user', 'key'])

@if ($user->acquisition_days->first())
    @if ($user->remainingDaysOnly($key) != 0)
        {{ $user->remainingDaysOnly($key) }} 日&emsp;
    @endif
    @if ($user->remainingHours($key) != 0)
        {{ $user->remainingHours($key) }} 時間
    @endif
    @if ($user->remainingHours($key) == 0)
        &emsp;&emsp;&emsp;
    @endif
    @if ($user->acquisition_days->where('report_id', $key)->first()->remaining_days == 0)
        {{ $user->acquisition_days->where('report_id', $key)->first()->remaining_days }} 日&emsp; &emsp;&emsp;&emsp;
    @endif
@endif
