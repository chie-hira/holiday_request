<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container max-w-4xl px-5 py-24 w-full xl:w-3/4 mx-auto">
            <div class="flex flex-col text-center ZenMaruGothic w-full mb-10">
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
                                        <tr>
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
                                        @can('general_admin')
                                            <tr>
                                                <td colspan="4" class="px-4">
                                                    <x-sub-menu-a-link href="{{ route('users.email_edit', $user) }}">
                                                        <span class="mr-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                fill="currentColor" class="w-6 h-6">
                                                                <path
                                                                    d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                                                                <path
                                                                    d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                                                            </svg>
                                                        </span>
                                                        <span class="w-40 text-sm">メールアドレス変更</span>
                                                    </x-sub-menu-a-link>
                                                    <x-sub-menu-a-link href="{{ route('users.password_edit', $user) }}">
                                                        <span class="mr-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                fill="currentColor" class="w-6 h-6">
                                                                <path fill-rule="evenodd"
                                                                    d="M15.75 1.5a6.75 6.75 0 00-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 00-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 00.75-.75v-1.5h1.5A.75.75 0 009 19.5V18h1.5a.75.75 0 00.53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1015.75 1.5zm0 3a.75.75 0 000 1.5A2.25 2.25 0 0118 8.25a.75.75 0 001.5 0 3.75 3.75 0 00-3.75-3.75z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </span>
                                                        <span class="w-40 text-sm">パスワード変更</span>
                                                    </x-sub-menu-a-link>
                                                </td>
                                            </tr>
                                        @endcan
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
