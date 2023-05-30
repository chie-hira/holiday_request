<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container max-w-4xl px-5 py-24 w-full xl:w-3/4 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">ユーザー情報の修正</h1>

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
                            工場長は、
                            <span class="font-bold">全課、全グループ</span>
                            を選択してください。
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
                            グループのない課は
                            <span class="font-bold">全グループ</span>
                            を選択してください。
                        </p>
                    </div>
                </div>

            </div>

            <x-errors :errors="$errors" />

            <div class="container max-w-4xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-8 mx-auto">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="mx-auto divide-y divide-gray-200 ">
                                    <thead>
                                        <tr>
                                            <th
                                                class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                社員番号
                                            </th>
                                            <th
                                                class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                氏 名
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                所属工場
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                所属課
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                所属グループ
                                            </th>
                                            <th colspan="2" class="w-40"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        <tr class="hover:bg-gray-100 ">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-800 ">
                                                {{ $user->employee }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-800 ">
                                                {{ $user->name }}
                                            </td>
                                            <form action="{{ route('users.update', $user) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-select name="factory_id"
                                                        class="block mt-1 w-32 text-sm" required autofocus>
                                                        <option value="{{ $user->factory->id }}">
                                                            {{ $user->factory->factory_name }}</option>
                                                        @foreach ($factory_categories as $factory_category)
                                                            <option value="{{ $factory_category->id }}"
                                                                @if ($factory_category->id === (int) old('factory_id')) selected @endif>
                                                                {{ $factory_category->factory_name }}</option>
                                                        @endforeach
                                                    </x-select>
                                                </td>
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-select name="department_id"
                                                        class="block mt-1 w-32 text-sm" required>
                                                        <option value="{{ $user->department->id }}">
                                                            {{ $user->department->department_name }}</option>
                                                        @foreach ($department_categories as $department_category)
                                                            <option value="{{ $department_category->id }}"
                                                                @if ($department_category->id === (int) old('department_id')) selected @endif>
                                                                {{ $department_category->department_name }}</option>
                                                        @endforeach
                                                    </x-select>
                                                </td>
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-select name="group_id"
                                                        class="block mt-1 w-32 text-sm" required>
                                                        <option value="{{ $user->group->id }}">
                                                            {{ $user->group->group_name }}</option>
                                                        @foreach ($group_categories as $group_category)
                                                            <option value="{{ $group_category->id }}"
                                                                @if ($group_category->id === (int) old('group_id')) selected @endif>
                                                                {{ $group_category->group_name }}</option>
                                                        @endforeach
                                                    </x-select>
                                                </td>
                                                <td class="px-1 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    <x-edit-button >
                                                        {{ __('Update') }}
                                                    </x-edit-button>
                                                </td>
                                            </form>
                                            <td class="pl-1 pr-2 py-4 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('users.destroy', $user) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-delete-input-button value="ユーザー削除" onclick="if(!confirm('ユーザー情報を削除しますか？この操作は取り消せません。削除したユーザーは、アプリを使用できなくなります。')){return false};"/>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-end">
                <x-return-button class="w-24 mr-2" href="{{ route('users.index') }}">
                    一覧
                </x-return-button>
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </section>
</x-app-layout>
