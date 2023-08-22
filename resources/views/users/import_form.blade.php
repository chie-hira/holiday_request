<x-app-layout>
    <div class="container max-w-2xl px-5 py-24 mx-auto">
        <form method="post" action="/users_import" enctype="multipart/form-data" class="mb-4">
            @csrf
                <label for="users" class="block text-sm text-gray-500">ユーザー情報</label>
                <div class="flex">
                    <input type="file" name="excel_file" id="users"
                        class="block w-60 px-3 py-2 m-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg file:bg-gray-200 file:text-gray-700 file:text-sm file:px-4 file:py-1 file:border-none file:rounded-full  placeholder-gray-400/70  focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 " />
                    <input type="submit" value="インポート" class="px-4 py-2 my-2 text-sm font-medium tracking-wider text-gray-600 uppercase transition-colors duration-300 transform bg-gray-200 rounded-lg hover:bg-gray-400 focus:bg-gray-600 focus:outline-none">
                </div>
        </form>
    </div>




</x-app-layout>
