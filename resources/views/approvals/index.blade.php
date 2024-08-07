<x-app-layout>
    <!-- Page Heading -->
    <section class="text-gray-600 body-font">
        <div class="container max-w-3xl px-5 py-16 mx-auto">
            <div class="flex flex-col text-center w-full mb-4">
                <h1 class="sm:text-4xl text-3xl font-medium ZenMaruGothic title-font text-gray-800">権限一覧</h1>
                <x-info class="mx-auto my-4">
                    <p class="text-sm">
                        設定から<span class="font-bold">権限の変更</span>と<span class="font-bold">取消</span>ができます。
                    </p>
                </x-info>
            </div>
            @can('general_admin')
                <h2 class="text-right mb-4">
                    <x-show-a-button href="{{ route('approvals.create') }}"
                        class="px-2 py-1">権限追加</x-show-button>
                </h2>
            @endcan

            <div class="max-w-3xl w-full mx-auto">
                <x-notice :notice="session('notice')" />
            </div>

            <div class="container max-w-3xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-6 mx-auto">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="mx-auto divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th
                                                class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Employee Name') }}
                                            </th>
                                            <th
                                                class="w-24 px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('管 轄') }}
                                            </th>
                                            <th
                                                class="w-24 px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('権 限') }}
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($approvals as $approval)
                                            <tr>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-left text-gray-800">
                                                    @if (Str::length($approval->user->employee) == 1)
                                                        &ensp;&ensp;
                                                    @endif
                                                    @if (Str::length($approval->user->employee) == 2)
                                                        &ensp;
                                                    @endif
                                                    {{ $approval->user->employee }}&ensp;
                                                    {{ $approval->user->name }}
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-xs text-gray-800">
                                                    <x-affiliation-name :affiliation="$approval->affiliation" />
                                                </td>
                                                <td class="px-4 py-4 text-left whitespace-nowrap text-sm text-gray-800">
                                                    {{ $approval->approval_category->approval_name }}
                                                </td>
                                                <td class="px-1 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    <x-show-a-button href="{{ route('approvals.edit', $approval) }}"
                                                        class="px-3 py-1">
                                                        {{ __('Setting') }}
                                                    </x-show-a-button>
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

            <div class="max-w-3xl w-full mx-auto mt-8">
                <div class="relative w-30 h-8">
                    <x-back-home-button class="absolute inset-y-0 right-0" href="{{ route('menu') }}"
                        dusk='back-button'>
                        {{ __('Back') }}
                    </x-back-home-button>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
