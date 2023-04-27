<x-app-layout>
    <section class="text-gray-600 body-font">
        <div class="container w-full md:w-2/3 px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">取得可能日数の更新</h1>
                <p class="mx-auto text-left leading-relaxed text-sm">
                    更新作業は<span class="font-bold">取消できません</span>。
                    <span class="font-bold">更新基準日</span>を選択して更新ボタンを押してください。
                </p>
            </div>

            <x-errors :errors="$errors" />
            <x-notice :notice="session('notice')" />

            <!-- 更新日form - start -->
            <form action="{{ route('remainings.add_remainings') }}" method="POST">
                @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label id="update_date" for="update_date"
                            class="block mb-2 text-sm font-medium text-gray-900">
                            更新基準日
                        </label>
                        <input type="date" id="update_date" name="update_date"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('update_date') }}">
                    </div>
                </div>

                <div class="flex flex-row-reverse">
                    <button type="submit"
                        class="text-white bg-indigo-400 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-purple-300 hover:font-bold font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        更 新
                    </button>
                </div>
            </form>
            <!-- 更新日form - end -->

            <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                <a href="{{ route('menu') }}"
                    class="text-indigo-500 inline-flex mx-auto md:mb-2 lg:mb-0 hover:-translate-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H15a6.75 6.75 0 010 13.5h-3a.75.75 0 010-1.5h3a5.25 5.25 0 100-10.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="px-2">
                        戻る
                    </div>
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
