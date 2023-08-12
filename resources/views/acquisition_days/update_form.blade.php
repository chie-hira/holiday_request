<x-app-layout>

    <section class="text-gray-600 body-font">
        <div class="container w-full md:w-2/3 px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">取得可能日数の更新</h1>
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
                            有給休暇の取得可能日数を<span class="font-semibold">勤続年数</span>に応じて自動更新できます。
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
                            <span class="font-bold">更新基準日</span>
                            を選択して更新ボタンを押してください。
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
                            更新作業は<span class="font-bold">取消できません</span>。
                        </p>
                    </div>
                </div>
            </div>

            <x-errors :errors="$errors" />
            <x-notice :notice="session('notice')" />

            <!-- 更新日form - start -->
            <form action="{{ route('acquisition_days.add_remainings') }}" method="POST">
                @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label id="update_date" for="update_date" class="block mb-2 text-sm font-medium text-gray-900">
                            更新基準日
                        </label>
                        <x-input type="date" id="update_date" name="update_date" class="block mt-1"
                            :value="old('update_date')" />
                    </div>
                </div>

                <div class="flex flex-row-reverse">
                    <x-button class="w-full" onclick="if(!confirm('有給休暇日数を更新します。この操作は取り消せません。更新してよろしいですか？')){return false};">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
            <!-- 更新日form - end -->

            <div class="mt-10 flex justify-end">
                <x-return-button class="w-24 mr-2" href="{{ route('acquisition_days.index') }}">
                    一覧
                </x-return-button>
                <x-back-home-button class="w-30" href="{{ route('menu') }}">
                    {{ __('Back') }}
                </x-back-home-button>
            </div>
        </div>
    </section>
</x-app-layout>
