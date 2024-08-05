<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container max-w-2xl px-5 py-6 mx-auto">
            <div class="flex flex-col text-center w-full mb-4">
                <h1 class="sm:text-3xl text-2xl font-medium ZenMaruGothic title-font mb-4 text-gray-800">
                    {{ __('Rest Days') }}</h1>
                <div class="text-left mx-auto leading-relaxed text-sm mb-1">
                    <x-info>
                        <p class="text-sm">
                            <span class="font-semibold">{{ Auth::user()->name }}さん</span>の取得状況です。
                        </p>
                    </x-info>
                    <x-info>
                        @if (5 -
                                Auth::user()->acquisition_days->where('report_id', 1)->first()->acquisition_days >
                                0)
                            <p class="text-sm">
                                有給休暇の取得推進日数はあと<span
                                    class="font-semibold">{{ 5 -Auth::user()->acquisition_days->where('report_id', 1)->first()->acquisition_days }}日</span>です。
                            </p>
                        @else
                            <p class="text-sm">
                                有給休暇取得推進日数を消化しました。
                            </p>
                        @endif
                    </x-info>
                </div>
            </div>

            <div class="container max-w-2xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-2 sm:p-8">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 ">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                {{ __('Report Category') }}
                                            </th>
                                            <th scope="col"
                                                class="px-2 pt-3 pb-1 text-center text-xs font-medium text-gray-500 uppercase">
                                                <p class="font-semibold">{{ __('Remaining Days') }}</p>
                                                <p class="text-blue-400 text-xs">{{ __('申請中') }}</p>
                                            </th>
                                            <th scope="col"
                                                class="pr-2 pt-3 pb-1 text-center text-xs font-medium text-gray-500 uppercase">
                                                <p class="font-semibold">{{ __('Acquisition Days') }}</p>
                                                <p class="text-blue-400 text-xs">{{ __('申請中') }}</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($acquisitionDays as $acquisitionDay)
                                            <tr class="">
                                                <td
                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $acquisitionDay->report_category->report_name }}
                                                    {{-- @if ($acquisitionDay->report_category->report_name == '介護休業' || $acquisitionDay->report_category->report_name == '育児休業')
                                                        <span class="text-blue-400 text-xs">{{ __('※') }}</span>
                                                    @endif --}}
                                                    @if (
                                                        $acquisitionDay->report_category->report_name == '有給休暇' &&
                                                            Auth::user()->adoption_date >
                                                                now()->subMonth(3)->format('Y-m-d'))
                                                        <span
                                                            class="text-blue-400 text-xs">{{ __('(採用から3か月後に申請できます)') }}</span>
                                                    @endif
                                                </td>
                                                <td
                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                    {{ Str::limit($acquisitionDay->report_category->report_name, 20) }}
                                                </td>
                                                <td
                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                    <span class=" font-bold">
                                                        @if (isset($acquisitionDay->remaining_days))
                                                            {{ $acquisitionDay->remaining_days }}日
                                                        @endif
                                                        @if (!empty($acquisitionDay->remaining_hours))
                                                            &ensp;{{ $acquisitionDay->remaining_hours }} 時間
                                                        @endif
                                                        @if (!empty($acquisitionDay->remaining_minutes))
                                                            &ensp;{{ $acquisitionDay->remaining_minutes }} 分
                                                        @endif
                                                    </span>
                                                    <p class="text-blue-400 text-xs">
                                                        @if ($acquisitionDay->remaining_days != null)
                                                            @if (Auth::user()->reports->where('report_id', $acquisitionDay->report_id)->where('approved', 0)->where('cancel', 0)->first())
                                                                @if (
                                                                    ($acquisitionDay->expectation_remaining_days == 0 &&
                                                                        $acquisitionDay->expectation_remaining_hours == 0 &&
                                                                        $acquisitionDay->expectation_remaining_minutes == 0) ||
                                                                        $acquisitionDay->expectation_remaining_days != 0)
                                                                    {{ $acquisitionDay->expectation_remaining_days }}
                                                                    日
                                                                @endif
                                                                @if ($acquisitionDay->expectation_remaining_hours != 0)
                                                                    {{ $acquisitionDay->expectation_remaining_hours }}
                                                                    時間
                                                                @endif
                                                                @if ($acquisitionDay->expectation_remaining_minutes != 0)
                                                                    {{ $acquisitionDay->expectation_remaining_minutes }}
                                                                    分
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </p>
                                                </td>
                                                <td
                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                    <span class=" font-bold">
                                                        @if ($acquisitionDay->report_category->acquisition_id != 7)
                                                            {{ $acquisitionDay->acquisition_days }} 日
                                                            @if (!empty($acquisitionDay->acquisition_hours))
                                                                &ensp;{{ $acquisitionDay->acquisition_hours }} 時間
                                                            @endif
                                                            @if (!empty($acquisitionDay->acquisition_minutes))
                                                                &ensp;{{ $acquisitionDay->acquisition_minutes }} 分
                                                            @endif
                                                        @else
                                                            {{ $acquisitionDay->acquisition_hours }} 時間
                                                            @if (!empty($acquisitionDay->acquisition_minutes))
                                                                &ensp;{{ $acquisitionDay->acquisition_minutes }} 分
                                                            @endif
                                                        @endif
                                                    </span>
                                                    <p class="text-blue-400 text-xs">
                                                        {{-- @if ($acquisitionDay->pending_acquisition_days != 0) --}}
                                                        @if ($acquisitionDay->pending_acquisition_days != 0)
                                                            {{ $acquisitionDay->pending_acquisition_days }}
                                                            日
                                                        @endif
                                                        @if ($acquisitionDay->pending_acquisition_hours != 0)
                                                            {{ $acquisitionDay->pending_acquisition_hours }}
                                                            時間
                                                        @endif
                                                        @if ($acquisitionDay->pending_acquisition_minutes != 0)
                                                            {{ $acquisitionDay->pending_acquisition_minutes }}
                                                            分
                                                        @endif
                                                        {{-- @endif --}}
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container max-w-2xl px-5 pb-6 mx-auto">
            <div class="mx-auto my-6">
                <div class="text-left mx-auto leading-relaxed text-sm mb-1">
                    {{-- <x-info>
                        <p>
                            育児休業は<span class="font-bold">1歳に満たない子</span>を扶養する者が取得できます。
                        </p>
                    </x-info> --}}
                    <x-info>
                        <p>
                            休暇制度の詳細は総務課にお問い合わせください。
                        </p>
                    </x-info>
                </div>
            </div>

            <div class="flex justify-end">
                <x-back-home-button class="w-30" href="{{ route('menu') }}" dusk='back-button'>
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>

        <!-- ボタン -->
        <div class="w-full max-w-3xl px-5 mx-auto grid grid-cols-1 gap-2">
            <button class="fixed right-16 bottom-16 bg-sky-400/80 text-white px-2 py-2 rounded-full shadow"
                onclick="window.history.back();">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            {{-- <button class="fixed right-16 bottom-28 bg-sky-400/80 text-white px-2 py-2 rounded-full shadow"
            onclick="location.href='{{ route('menu') }}'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
        </button> --}}
        </div>
    </section>
</x-app-layout>
