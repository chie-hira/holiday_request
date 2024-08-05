<x-app-layout>

    <section class="text-gray-600 body-font">
        <div class="container w-full md:w-2/3 px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium ZenMaruGothic title-font mb-4 text-gray-900">有給休暇日数の更新</h1>
                <div class="text-left mx-auto leading-relaxed text-sm mb-1">
                    <x-info>
                        <p>
                            有給休暇の{{ __('Remaining Days') }}を<span class="font-semibold">勤続年数</span>に応じて自動更新します。
                        </p>
                    </x-info>
                    <x-info>
                        <p>
                            <span class="font-bold">更新基準日</span>
                            を選択して更新ボタンを押してください。
                        </p>
                    </x-info>
                    <x-info>
                        <p>
                            更新作業は<span class="font-bold">取消できません</span>。
                        </p>
                    </x-info>
                </div>
            </div>

            <x-errors :errors="$errors" />
            <x-notice :notice="session('notice')" />

            <!-- 更新日form - start -->
            <form id="myForm" action="{{ route('acquisitions_days.add_remainings') }}" method="POST">
                @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="update_date" class="block mb-2 text-sm font-medium text-gray-900">
                            更新基準日
                        </label>
                        <x-input type="date" id="update_date" name="update_date" class="block mt-1"
                            :value="old('update_date')" />
                    </div>
                </div>

                <div class="flex flex-row-reverse">
                    <x-button id="submitButton" class="w-full"
                        onclick="if(!confirm('有給休暇日数を更新します。この操作は取り消せません。更新してよろしいですか？')){return false};">
                        {{ __('Update') }}
                    </x-button>
                </div>
            </form>
            <!-- 更新日form - end -->

            <div class="mt-8">
                @foreach ($filePaths as $path)
                    <div class="flex items-center">
                        <p class="text-sm pr-2">
                            {{ pathinfo($path, PATHINFO_FILENAME) }}
                        </p>
                        <x-show-a-button href="{{ asset($path) }}"
                            class="text-xs px-2 py-1 my-1">
                            ダウンロード
                            </x-a>
                    </div>
                @endforeach
            </div>
            <div class="max-w-2xl w-full mx-auto mt-8">
                <div class="relative w-30 h-8 mb-2">
                    <x-return-button class="px-5 absolute inset-y-0 right-0"
                        href="{{ route('acquisition_days.index') }}">
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

    <script>
        /* 二重送信防止start */
        // 送信ボタンをクリックした後に非活性化する関数
        function disableSubmitButton() {
            var submitButton = document.getElementById('submitButton');
            submitButton.disabled = true; // ボタンを非活性にする
        }

        // フォームが送信される前にdisableSubmitButton関数を呼び出す
        document.getElementById('myForm').addEventListener('submit', function() {
            disableSubmitButton();
        });
        /* 二重送信防止end */
    </script>
</x-app-layout>
