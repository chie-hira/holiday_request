<x-app-layout>
    <!-- Page Heading -->
    <section class="text-gray-600 body-font">
        <div class="container max-w-2xl px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-6">
                <h1 class="sm:text-4xl text-3xl font-medium title-font text-gray-900">ユーザー一覧</h1>
                <h2 class=" text-right">
                    @can('general_only')
                        <a href={{ route('register') }}
                            class="inline-flex items-center justify-center text-base mr-2 font-medium text-sky-600 hover:text-sky-50 p-1 rounded-full border-2 border-gray-400 bg-sky-100/60 hover:bg-sky-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                            </svg>
                        </a>
                    @endcan
                </h2>
                <div class="mx-auto">
                    <div class="flex text-left leading-relaxed text-sm mb-1">
                        <p>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-5 h-5 mr-3 text-sky-600">
                                <path fill-rule="evenodd"
                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                    clip-rule="evenodd" fill="" />
                            </svg>
                        </p>
                        <p class="text-sm">
                            設定から<span class="font-bold">所属の変更</span>と<span class="font-bold">ユーザーの削除</span>ができます。
                        </p>
                    </div>
                </div>
            </div>

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
                                                社員番号
                                            </th>
                                            <th
                                                class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                氏 名
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                                所 属
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        @foreach ($users as $user)
                                            <tr>
                                                <td
                                                    class="px-8 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-800 ">
                                                    {{ $user->employee }}
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-left text-gray-800 ">
                                                    {{ $user->name }}
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-xs text-gray-800 ">
                                                    {{ $user->factory->factory_name }}
                                                    @if ($user->department->id != 1)
                                                        ・{{ $user->department->department_name }}
                                                    @endif
                                                    @if ($user->group->id != 1)
                                                        ・{{ $user->group->group_name }}
                                                    @endif
                                                    @if ($user->department->id == 1)
                                                        ・工場長
                                                    @endif
                                                </td>
                                                <td class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                    <x-edit-a-button href="{{ route('users.edit', $user) }}">
                                                        {{ __('Setting') }}
                                                    </x-edit-a-button>
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
