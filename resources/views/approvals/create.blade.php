<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container max-w-4xl px-5 py-16 w-full mx-auto">
            <div class="flex flex-col text-center w-full mb-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">権限の追加</h1>
                <x-info class="mx-auto">
                    <p class="text-sm">
                        <span class="font-bold">新しく権限を設定する</span>ときはこちらから追加してください。
                    </p>
                </x-info>
            </div>

            <div class="max-w-4xl w-full mx-auto">
                <x-errors :errors="$errors" />
            </div>

            <div class="container max-w-4xl bg-white w-full mx-auto border-2 rounded-lg">
                <div class="flex flex-col p-8 mx-auto">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="mx-auto divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead>
                                        <tr>
                                            <th
                                                class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Employee Name') }}
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('管 轄') }}
                                            </th>
                                            <th
                                                class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                {{ __('Approval Category') }}
                                            </th>
                                            <th class="w-24"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr class="hover:bg-gray-100">
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
                                                    <x-select name="affiliation_id" class="block mt-1 w-64 text-sm"
                                                        required>
                                                        @foreach ($affiliations as $affiliation)
                                                            <option value="{{ $affiliation->id }}"
                                                                @if ($affiliation->id === (int) old('affiliation_id')) selected @endif>
                                                                <x-affiliation-name :affiliation="$affiliation"/>
                                                            </option>
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

            <div class="max-w-4xl w-full mx-auto mt-8">
                <div class="relative w-30 h-8 mb-2">
                    <x-return-button class="px-5 absolute inset-y-0 right-0" href="{{ route('approvals.index') }}">
                        {{ __('一覧へ戻る') }}
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
