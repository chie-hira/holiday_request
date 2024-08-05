<x-app-layout>
    <!-- Page Heading -->
    <section class="text-gray-600 body-font">
        <div class="container max-w-2xl px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-4">
                <h1 class="sm:text-4xl text-3xl font-medium ZenMaruGothic title-font text-gray-900">ユーザー一覧</h1>
                <x-info class="mx-auto my-4">
                    <p class="text-sm">
                        設定から<span class="font-bold">所属の変更</span>と<span class="font-bold">ユーザーの削除</span>ができます。
                    </p>
                </x-info>
            </div>
            @can('general_admin')
                <h2 class="text-right mb-4">
                    <x-show-a-button href="{{ route('register') }}"
                        class="px-2 py-1">ユーザー登録</x-show-button>
                </h2>
            @endcan

            <x-notice :notice="session('notice')" />

            <div class="container max-w-2xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-6 mx-auto">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="mx-auto divide-y divide-gray-200 ">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Employee Name') }}
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Affiliation') }}
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        @foreach ($users as $user)
                                            <tr>
                                                <td
                                                    class="px-8 py-4 whitespace-nowrap text-sm text-left font-medium text-gray-800 ">
                                                    @if (Str::length($user->employee) == 1)
                                                        &ensp;&ensp;
                                                    @endif
                                                    @if (Str::length($user->employee) == 2)
                                                        &ensp;
                                                    @endif
                                                    {{ $user->employee }}&ensp;
                                                    {{ $user->name }}
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-xs text-gray-800 ">
                                                    <x-affiliation-name :affiliation="$user->affiliation" />
                                                </td>
                                                <td class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    <x-show-a-button href="{{ route('users.edit', $user) }}" class="px-3 py-1">
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

            <div class="mt-10 flex justify-end">
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </section>
</x-app-layout>
