<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">残日数の修正</h1>
                <x-info class="mx-auto">
                    <p class="text-sm">
                        休暇日数を変更できます。
                    </p>
                </x-info>
            </div>

            <div class="container max-w-4xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-8">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                {{ __('社員名') }}</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                {{ __('Report Category') }}</th>
                                            <th scope="col"
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                {{ __('残日数') }}</th>
                                            <th scope="col"
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                {{ __('取得日数') }}</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="hover:bg-gray-100">
                                            <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium text-gray-800">
                                                {{ $acquisition_day->user->employee }}
                                                {{ $acquisition_day->user->name }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium text-gray-800">
                                                {{ $acquisition_day->report_category->report_name }}
                                            </td>
                                            <form action="{{ route('acquisition_days.update', $acquisition_day) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-input name="remaining_days" type="number" max="{{ $acquisition_day->report_category->max_days }}"
                                                        min="0" class="inline h-8 mt-1 w-20" :value="old('remaining_days', $acquisition_day->remaining_days)" />
                                                    日
                                                    <x-input name="remaining_hours" type="number" max="7"
                                                        min="0" class="inline h-8 mt-1 w-20" :value="old('remaining_hours', $acquisition_day->remaining_hours)" />
                                                    時間
                                                </td>
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-input name="sum_get_days" type="number" max="{{ $acquisition_day->report_id == 1 || $acquisition_day->report_id == 2 ? $acquisition_day->report_category->max_days : 30 }}"
                                                        min="0" class="inline h-8 mt-1 w-20" :value="old('sum_get_days', $acquisition_day->sum_get_days_only)" />
                                                    日
                                                    <x-input name="sum_get_hours" type="number" max="7"
                                                        min="0" class="inline h-8 mt-1 w-20" :value="old('sum_get_hours', $acquisition_day->sum_get_hours)" />
                                                    時間
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

            <div class="mt-10 flex justify-end">
                <x-return-button class="w-24 mr-2" href="{{ route('acquisition_days.index') }}">
                    一覧
                </x-return-button>
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </section>
</x-app-layout>
