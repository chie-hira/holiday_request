<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container max-w-4xl px-5 py-24 w-full xl:w-3/4 mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">ユーザー情報の修正</h1>
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
                                                {{ __('Employee Name') }}
                                            </th>
                                            <th
                                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Affiliation') }}
                                            </th>
                                            <th colspan="2" class="w-24"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 ">
                                        <tr class="hover:bg-gray-100 ">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium text-gray-800 ">
                                                @if (Str::length($user->employee) == 1)
                                                    &ensp;&ensp;
                                                @endif
                                                @if (Str::length($user->employee) == 2)
                                                    &ensp;
                                                @endif
                                                {{ $user->employee }}&ensp;
                                                {{ $user->name }}
                                            </td>
                                            <form action="{{ route('users.update', $user) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                    <x-select name="affiliation_id" class="block mt-1 text-sm" required
                                                        autofocus>
                                                        <option value="{{ $user->affiliation_id }}">
                                                            <x-affiliation-name :affiliation="$user->affiliation" />
                                                        </option>
                                                        @foreach ($affiliations as $affiliation)
                                                            <option value="{{ $affiliation->id }}"
                                                                @if ($affiliation->id === (int) old('affiliation_id')) selected @endif>
                                                                <x-affiliation-name :affiliation="$affiliation" />
                                                            </option>
                                                        @endforeach
                                                    </x-select>
                                                </td>
                                                <td class="px-1 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    <x-edit-button>
                                                        {{ __('Update') }}
                                                    </x-edit-button>
                                                </td>
                                            </form>
                                            @can('general_admin')
                                                <td class="pl-1 pr-2 py-4 whitespace-nowrap text-sm font-medium">
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-delete-input-button value="ユーザー削除"
                                                            onclick="if(!confirm('ユーザー情報を削除しますか？この操作は取り消せません。削除したユーザーは、アプリを使用できなくなります。')){return false};" />
                                                    </form>
                                                </td>
                                            @endcan
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-2xl w-full mx-auto mt-8">
                <div class="relative w-30 h-8 mb-2">
                    <x-return-button class="px-5 absolute inset-y-0 right-0" href="{{ route('users.index') }}">
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
