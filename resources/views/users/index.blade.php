<x-app-layout>
    <!-- Page Heading -->
    <section class="text-gray-600 body-font">
        <div class="container lg:w-2/3 px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-6">
                <h1 class="sm:text-4xl text-3xl font-medium title-font mb-4 text-gray-900">従業員一覧</h1>
            </div>

            <x-notice :notice="session('notice')" />

            <div class="container bg-white w-full mx-auto border-2 rounded-lg">
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
                                                class="w-24 px-6 py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                                所 属
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($users as $user)
                                            <tr>
                                                <td
                                                    class="px-8 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                                    {{ $user->employee }}
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-800 dark:text-gray-200">
                                                    {{ $user->name }}
                                                </td>
                                                <td
                                                    class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                    {{ $user->factory->factory_name }}工場&ensp;/&ensp;{{ $user->department->department_name }}
                                                </td>
                                                <td
                                                    class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                    <a href="{{ route('users.edit', $user) }}"
                                                        class="px-3 py-1 text-sm text-blue-500 rounded-full bg-blue-100/60 hover:text-white hover:bg-blue-500">
                                                        設 定
                                                    </a>
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

            <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                <a href="{{ route('menu') }}"
                    class="text-indigo-500 inline-flex mx-auto md:mb-2 lg:mb-0 hover:-translate-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="px-2 mt-1">
                        戻る
                    </div>
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
