<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium ZenMaruGothic title-font mb-4 text-gray-800">{{ __('Rest Days') }}の修正</h1>
                <x-info class="mx-auto">
                    <p class="text-sm">
                        {{ __('Rest Days') }}を変更できます。
                    </p>
                </x-info>
            </div>

            <x-errors :errors="$errors" />

            <div class="container max-w-3xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-8">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                {{ __('Employee Name') }}</th>
                                            <th scope="col"
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                {{ __('Report Category') }}</th>
                                            <th scope="col"
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                {{ __('Remaining Days') }}</th>
                                            <th scope="col"
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                {{ __('Acquisition Days') }}</th>
                                            <th scope="col"
                                                class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="hover:bg-gray-100">
                                            <td
                                                class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium text-gray-800">
                                                {{ $acquisition_day->user->employee }}
                                                {{ $acquisition_day->user->name }}
                                            </td>
                                            <td
                                                class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium text-gray-800">
                                                {{ $acquisition_day->report_category->report_name }}
                                            </td>
                                            <form action="{{ route('acquisition_days.update', $acquisition_day) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-input name="remaining_days" type="number" step="{{ $acquisition_day->report_id == 2 ? 1 : 0.5 }}"
                                                        max="{{ $acquisition_day->report_category->max_days }}"
                                                        min="0" class="inline h-8 mt-1 w-20" :value="old(
                                                            'remaining_days',
                                                            $acquisition_day->remaining_days,
                                                        )" />
                                                    日
                                                </td>
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-input name="acquisition_days" type="number" step="{{ $acquisition_day->report_id == 2 ? 1 : 0.5 }}"
                                                        max="{{ $acquisition_day->report_id == 1 || $acquisition_day->report_id == 2 ? $acquisition_day->report_category->max_days : 30 }}"
                                                        min="0" class="inline h-8 mt-1 w-20" :value="old(
                                                            'acquisition_days',
                                                            $acquisition_day->acquisition_days,
                                                        )" />
                                                    日
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                    <x-edit-button>
                                                        {{ __('Update') }}
                                                    </x-edit-button>
                                                </td>
                                            </form>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-3xl w-full mx-auto mt-8">
                <div class="relative w-30 h-8 mb-2">
                    <x-return-button class="px-5 absolute inset-y-0 right-0"
                        href="{{ route('acquisition_days.index') }}">
                        {{ __('Back Index') }}
                    </x-return-button>
                </div>
                <div class="relative w-30 h-8">
                    <x-back-home-button class="absolute inset-y-0 right-0" href="{{ route('menu') }}">
                        {{ __('Back') }}
                    </x-back-home-button>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
