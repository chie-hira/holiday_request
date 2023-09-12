<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container max-w-2xl px-5 py-6 mx-auto">
            <div class="flex flex-col text-center w-full mb-4">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{ __('Rest Days') }}</h1>
                <div class="text-left mx-auto leading-relaxed text-sm mb-1">
                    <x-info>
                        <p class="text-sm">
                            <span class="font-semibold">{{ Auth::user()->name }}さん</span>の取得状況です。
                        </p>
                    </x-info>
                    <x-info>
                        @if (5 - Auth::user()->acquisition_days->where('report_id',1)->first()->acquisition_days > 0)
                            <p class="text-sm">
                                有給休暇の取得推進日数はあと<span class="font-semibold text-red-500">{{ 5 - Auth::user()->acquisition_days->where('report_id',1)->first()->acquisition_days }}日</span>です。
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
                                        @foreach ($acquisition_days as $acquisition_day)
                                            <tr class="">
                                                <td
                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                    {{ $acquisition_day->report_category->report_name }}
                                                    @if (
                                                        $acquisition_day->report_category->report_name == '介護休業' ||
                                                            $acquisition_day->report_category->report_name == '育児休業')
                                                        <span class="text-blue-400 text-xs">{{ __('※') }}</span>
                                                    @endif
                                                </td>
                                                <td
                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                    {{ Str::limit($acquisition_day->report_category->report_name, 20) }}
                                                </td>
                                                <td
                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                    <span class=" font-bold">
                                                        @if (isset($acquisition_day->remaining_days))
                                                            {{ $acquisition_day->remaining_days }}日
                                                        @endif
                                                        @if (!empty($acquisition_day->remaining_hours))
                                                            &ensp;{{ $acquisition_day->remaining_hours }} 時間
                                                        @endif
                                                        @if (!empty($acquisition_day->remaining_minutes))
                                                            &ensp;{{ $acquisition_day->remaining_minutes }} 分
                                                        @endif
                                                    </span>
                                                    <p class="text-blue-400 text-xs">
                                                        @if ($acquisition_day->remaining_days != null)
                                                            @if (Auth::user()->reports->where('report_id', $acquisition_day->report_id)->where('approved', 0)->where('cancel', 0)->first())
                                                                @if (
                                                                    ($acquisition_day->expectation_remaining_days == 0 &&
                                                                        $acquisition_day->expectation_remaining_hours == 0 &&
                                                                        $acquisition_day->expectation_remaining_minutes == 0) ||
                                                                        $acquisition_day->expectation_remaining_days != 0)
                                                                    {{ $acquisition_day->expectation_remaining_days }}
                                                                    日
                                                                @endif
                                                                @if ($acquisition_day->expectation_remaining_hours != 0)
                                                                    {{ $acquisition_day->expectation_remaining_hours }}
                                                                    時間
                                                                @endif
                                                                @if ($acquisition_day->expectation_remaining_minutes != 0)
                                                                    {{ $acquisition_day->expectation_remaining_minutes }}
                                                                    分
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </p>
                                                </td>
                                                <td
                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                    <span class=" font-bold">
                                                        @if ($acquisition_day->report_category->acquisition_id != 7)
                                                            {{ $acquisition_day->acquisition_days }} 日
                                                            @if (!empty($acquisition_day->acquisition_hours))
                                                                &ensp;{{ $acquisition_day->acquisition_hours }} 時間
                                                            @endif
                                                            @if (!empty($acquisition_day->acquisition_minutes))
                                                                &ensp;{{ $acquisition_day->acquisition_minutes }} 分
                                                            @endif
                                                        @else
                                                                {{ $acquisition_day->acquisition_hours }} 時間
                                                            @if (!empty($acquisition_day->acquisition_minutes))
                                                                &ensp;{{ $acquisition_day->acquisition_minutes }} 分
                                                            @endif
                                                        @endif
                                                    </span>
                                                    <p class="text-blue-400 text-xs">
                                                        {{-- @if ($acquisition_day->pending_acquisition_days != 0) --}}
                                                        @if ($acquisition_day->pending_acquisition_days != 0)
                                                            {{ $acquisition_day->pending_acquisition_days }}
                                                            日
                                                        @endif
                                                        @if ($acquisition_day->pending_acquisition_hours != 0)
                                                            {{ $acquisition_day->pending_acquisition_hours }}
                                                            時間
                                                        @endif
                                                        @if ($acquisition_day->pending_acquisition_minutes != 0)
                                                            {{ $acquisition_day->pending_acquisition_minutes }}
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
    </section>
</x-app-layout>
