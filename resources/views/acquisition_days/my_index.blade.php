<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container max-w-xl px-5 py-6 mx-auto">
            <div class="flex flex-col text-center w-full mb-4">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{ __('Rest Days') }}</h1>
                <div class="text-left mx-auto leading-relaxed text-sm mb-1">
                    <x-info>
                        <p class="text-sm">
                            <span class="font-semibold">{{ Auth::user()->name }}さん</span>の取得状況です。
                        </p>
                    </x-info>
                </div>
            </div>

            <div class="container max-w-xl bg-white w-full mx-auto border-2 rounded-lg">
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
                                                        $acquisition_day->report_category->report_name == '育児休業' 
                                                    )
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
                                                            {{ $acquisition_day->remaining_days_only }}
                                                            日
                                                        @endif
                                                        @if (!empty($acquisition_day->remaining_hours))
                                                            &ensp;{{ $acquisition_day->remaining_hours }} 時間
                                                        @endif
                                                    </span>
                                                    <p class="text-blue-400 text-xs">
                                                        @if ($acquisition_day->pending_acquisition_days != 0)
                                                            @if ($acquisition_day->remaining - $acquisition_day->pending_acquisition_days == 0)
                                                                {{ 0 }} 日
                                                            @endif
                                                            @if ($acquisition_day->expectation_days != 0)
                                                                {{ $acquisition_day->expectation_days }}
                                                                日
                                                            @endif
                                                            @if ($acquisition_day->expectation_hours != 0)
                                                                {{ $acquisition_day->expectation_hours }}
                                                                時間
                                                            @endif
                                                            @if ($acquisition_day->expectation_minutes != 0)
                                                                {{ $acquisition_day->expectation_minutes }}
                                                                分
                                                            @endif
                                                        @endif
                                                    </p>
                                                </td>
                                                <td
                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                    <span class=" font-bold">
                                                        {{ $acquisition_day->acquisition_days_only }} 日
                                                        @if (!empty($acquisition_day->acquisition_hours))
                                                            &ensp;{{ $acquisition_day->acquisition_hours }} 時間
                                                        @endif
                                                    </span>
                                                    <p class="text-blue-400 text-xs">
                                                        @if ($acquisition_day->pending_acquisition_days != 0)
                                                            @if ($acquisition_day->pending_acquisition_days_only != 0)
                                                                {{ $acquisition_day->pending_acquisition_days_only }}
                                                                日
                                                            @endif
                                                            @if ($acquisition_day->pending_get_hours != 0)
                                                                {{ $acquisition_day->pending_get_hours }}
                                                                時間
                                                            @endif
                                                            @if ($acquisition_day->pending_get_minutes != 0)
                                                                {{ $acquisition_day->pending_get_minutes }}
                                                                分
                                                            @endif
                                                        @endif
                                                    </p>
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td colspan="3" class="border-b border-slate-300 -pt-2">
                                                    <span class="text-blue-400 text-xs">
                                                    {{ $acquisition_day->report_category->remarks }}
                                                    </span>
                                                </td>
                                            </tr> --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container max-w-xl px-5 pb-6 mx-auto">
            <div class="mx-auto my-6">
                <div class="text-left mx-auto leading-relaxed text-sm mb-1">
                    <x-info>
                        <p>
                            看護休暇は<span class="font-bold">小学校就学前の子</span>を養育する者が取得できます。
                        </p>
                    </x-info>
                    <x-info>
                        <p>
                            介護休暇、介護休業は<span class="font-bold">要介護状態の家族</span>を介護する者が取得できます。
                        </p>
                    </x-info>
                    <x-info>
                        <p>
                            特別休暇(慶事)は<span class="font-bold">本人が結婚する</span>ときに取得できます。
                        </p>
                    </x-info>
                    <x-info>
                        <p>
                            特別休暇(弔事)は<span class="font-bold">近親者が喪に服す</span>ときに取得できます。
                        </p>
                    </x-info>
                    <x-info>
                        <p>
                            特別休暇(短期育休)、育児休業、パパ育休は<span class="font-bold">1歳に満たない子</span>と同居し扶養する者が取得できます。
                        </p>
                    </x-info>
                    <x-info>
                        <p>
                            ※は<span class="font-bold">対象によって休暇日数が変わります</span>。詳細は総務課にお問い合わせください。
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
