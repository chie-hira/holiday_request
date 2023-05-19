<x-app-layout>
    <!-- Page Heading -->
    <section class="text-gray-600 body-font">
        <div class="container max-w-3xl px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-6">
                <h1 class="sm:text-4xl text-3xl font-medium title-font text-gray-900">権限一覧</h1>
                <h2 class=" text-right">
                    @can('general_only')
                        <a href={{ route('approvals.create') }}
                            class="inline-flex items-center justify-center text-base mr-2 font-medium text-sky-600 hover:text-sky-50 p-1 rounded-full border-2 border-gray-400 bg-sky-100/60 hover:bg-sky-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-6 h-6">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endcan
                </h2>
                <div class="mx-auto">
                    <p class="flex text-left leading-relaxed text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5 mr-3 text-sky-600">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd" fill="" />
                        </svg>
                        設定から<span class="font-bold">権限の変更</span>と<span class="font-bold">取消</span>ができます。
                    </p>
                </div>
            </div>

            <x-notice :notice="session('notice')" />

            <div class="container max-w-3xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-6 mx-auto">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="mx-auto divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                社員番号
                                            </th>
                                            <th
                                                class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                氏 名
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                管 轄
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                                権 限
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($approvals as $approval)
                                            <tr>
                                                <td
                                                    class="px-8 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-800 dark:text-gray-200">
                                                    {{ $approval->user->employee }}
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-left text-gray-800 dark:text-gray-200">
                                                    {{ $approval->user->name }}
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-xs text-gray-800 dark:text-gray-200">
                                                    {{ $approval->factory->factory_name }}
                                                        ・{{ $approval->department->department_name }}
                                                    @if ($approval->group != null && $approval->group->id != 1)
                                                        ・{{ $approval->group->group_name }}
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-4 py-4 text-center whitespace-nowrap text-sm text-gray-800">
                                                    {{ $approval->approval_category->approval_name }}
                                                </td>
                                                <td
                                                    class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                    <x-show-a-button href="{{ route('approvals.edit', $approval) }}" class="px-3 py-1">
                                                        {{ __('Setting') }}
                                                    </x-shos-a-button>
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

            <div class="mt-10 flex justify-end">
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </section>
</x-app-layout>
