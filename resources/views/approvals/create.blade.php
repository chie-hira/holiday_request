<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container max-w-5xl px-5 py-24 w-full mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">権限の追加</h1>
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
                            <span class="font-bold">会社承認権限</span>は管轄工場、管轄課、管轄グループの選択に関わらず、すべての届けの承認権です。
                        </p>
                    </div>
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
                            <span class="font-bold">管理者権限</span>は管轄工場ごとに各種設定ができる権限です。全課、全グループを選択してください。
                        </p>
                    </div>
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
                            <span class="font-bold">工場全体を管轄</span>する場合は、<span
                                class="font-bold">全課、全グループ</span>を選択してください。
                        </p>
                    </div>
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
                            <span class="font-bold">課全体を管轄</span>する場合は、<span class="font-bold">全グループ</span>を選択してください。
                        </p>
                    </div>
                </div>
            </div>

            <div class="container max-w-5xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-8 mx-auto">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="mx-auto divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead>
                                        <tr>
                                            <th
                                                class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                社員名
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                管轄工場
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                管轄課
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                管轄グループ
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                権限の種類
                                            </th>
                                            <th class="w-24"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <form action="{{ route('approvals.store') }}" method="POST">
                                                @csrf
                                                <td
                                                    class="px-2 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-800 dark:text-gray-200">
                                                    <x-select name="user_id" class="block mt-1 w-40 text-sm" required
                                                        autofocus>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                @if ($user->id === (int) old('user_id')) selected @endif>
                                                                {{ $user->employee }}&ensp;{{ $user->name }}</option>
                                                        @endforeach
                                                    </x-select>
                                                </td>
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-select name="factory_id" class="block mt-1 w-30 text-sm"
                                                        required>
                                                        @foreach ($factory_categories as $factory_category)
                                                            <option value="{{ $factory_category->id }}"
                                                                @if ($factory_category->id === (int) old('factory_id')) selected @endif>
                                                                {{ $factory_category->factory_name }}工場</option>
                                                        @endforeach
                                                    </x-select>
                                                </td>
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-select name="department_id" class="block mt-1 w-32 text-sm"
                                                        required>
                                                        @foreach ($department_categories as $department_category)
                                                            <option value="{{ $department_category->id }}"
                                                                @if ($department_category->id === (int) old('department_id')) selected @endif>
                                                                {{ $department_category->department_name }}</option>
                                                        @endforeach
                                                    </x-select>
                                                </td>
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-select name="group_id" class="block mt-1 w-32 text-sm" required>
                                                        @foreach ($group_categories as $group_category)
                                                            <option value="{{ $group_category->id }}"
                                                                @if ($group_category->id === (int) old('group_id')) selected @endif>
                                                                {{ $group_category->group_name }}</option>
                                                        @endforeach
                                                    </x-select>
                                                </td>
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-select name="approval_id" class="block mt-1 w-32 text-sm"
                                                        required>
                                                        @foreach ($approval_categories as $approval_category)
                                                            <option value="{{ $approval_category->id }}"
                                                                @if ($approval_category->id === (int) old('approval_id')) selected @endif>
                                                                {{ $approval_category->approval_name }}</option>
                                                        @endforeach
                                                    </x-select>
                                                </td>
                                                <td class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    <x-show-button>
                                                        {{ __('Add') }}
                                                    </x-show-button>
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
                <x-return-button class="w-24 mr-2" href="{{ route('approvals.index') }}">
                    一覧
                </x-return-button>
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>

        </div>
    </section>
</x-app-layout>