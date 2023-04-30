<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 w-full xl:w-3/4 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">社員情報の修正</h1>
                <p class="mx-10 lx:mx-20 text-left leading-relaxed text-sm">
                    複数の工場、課、グループに所属する場合は、<span class="font-bold">メインの工場、課、グループ</span>を選択してください。
                </p>
                <p class="mx-10 xl:mx-20 text-left leading-relaxed text-sm">
                    工場長など複数ある所属先が同列の場合は、<span class="font-bold">無所属</span>を選択してください。
                </p>
            </div>

            <x-errors :errors="$errors" />
            
            <div class="container bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-8 mx-auto">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="mx-auto divide-y divide-gray-200 dark:divide-gray-700">
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
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td
                                                class="px-8 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-800 dark:text-gray-200">
                                                {{ $user->employee }}
                                            </td>
                                            <td
                                                class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-800 dark:text-gray-200">
                                                {{ $user->name }}
                                            </td>
                                            <form action="{{ route('users.update', $user) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <select name="factory_id"
                                                        class="w-24 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                                                        <option value="{{ $user->factory->id }}">{{ $user->factory->factory_name }}工場</option>
                                                        @foreach ($factory_categories as $factory_category)
                                                            <option value="{{ $factory_category->id }}"
                                                                @if ($factory_category->id === (int) old('factory_id')) selected @endif>
                                                                {{ $factory_category->factory_name }}工場</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <select name="department_id"
                                                        class="w-32 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                                                        <option value="{{ $user->department->id }}">{{ $user->department->department_name }}</option>
                                                        @foreach ($department_categories as $department_category)
                                                            <option value="{{ $department_category->id }}"
                                                                @if ($department_category->id === (int) old('department_id')) selected @endif>
                                                                {{ $department_category->department_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <select name="group_id"
                                                        class="w-32 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                                                        <option value="{{ $user->group->id }}">{{ $user->group->group_name }}</option>
                                                        @foreach ($group_categories as $group_category)
                                                            <option value="{{ $group_category->id }}"
                                                                @if ($group_category->id === (int) old('group_id')) selected @endif>
                                                                {{ $group_category->group_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-1 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    <button type="submit"
                                                        class="px-3 py-1 text-sm text-blue-500 rounded-full bg-blue-100/60 hover:text-white hover:bg-blue-500">
                                                        所属更新
                                                    </button>
                                                </td>
                                            </form>
                                            <td class="px-1 py-4 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('users.destroy', $user) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" value="社員情報削除"
                                                        onclick="if(!confirm('社員情報を削除しますか？この操作は取り消せません。社員情報を削除した社員は、アプリを使用できなくなります。')){return false};"
                                                        class="px-3 py-1 text-sm text-pink-500 rounded-full bg-pink-100/60 hover:text-white hover:bg-pink-500">
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

            <div class="flex mt-4 lg:w-2/3 w-full mx-auto">
                <a href="{{ route('users.index') }}"
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
