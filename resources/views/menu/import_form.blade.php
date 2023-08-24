<x-app-layout>
    <div class="container max-w-2xl px-5 py-24 mx-auto">

        <x-notice :notice="session('notice')" />

        <h2 class="mb-2 text-lg font-bold text-gray-700">1.&ensp;初期設定&emsp;<span class="text-blue-600">migrate&seed</span>後に<span class="text-blue-600">users→approvals</span>の順でinsertする</h2>
        <p class="mb-6 text-gray-700">インポート後に休暇日数をアプリの管理メニューから設定する<br>
        1度に読み込むデータは100件以内に分割する</p>
        <form method="post" action="{{ route('users_import') }}" enctype="multipart/form-data" class="mb-4">
            @csrf
            <label for="users" class="block text-sm text-gray-500">users</label>
            <div class="flex">
                <input type="file" name="excel_file" id="users" required
                    class="block w-80 px-3 py-2 m-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg file:bg-gray-200 file:text-gray-700 file:text-sm file:px-4 file:py-1 file:border-none file:rounded-full  placeholder-gray-400/70  focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 " />
                <input type="submit" value="インポート"
                    class="px-4 py-2 my-2 text-sm font-medium tracking-wider text-gray-600 uppercase transition-colors duration-300 transform bg-gray-200 rounded-lg hover:bg-gray-400 focus:bg-gray-600 focus:outline-none">
            </div>
        </form>
        <form method="post" action="{{ route('approvals_import') }}" enctype="multipart/form-data" class="mb-4">
            @csrf
            <label for="approvals" class="block text-sm text-gray-500">approvals</label>
            <div class="flex">
                <input type="file" name="excel_file" id="approvals" required
                    class="block w-80 px-3 py-2 m-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg file:bg-gray-200 file:text-gray-700 file:text-sm file:px-4 file:py-1 file:border-none file:rounded-full  placeholder-gray-400/70  focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 " />
                <input type="submit" value="インポート"
                    class="px-4 py-2 my-2 text-sm font-medium tracking-wider text-gray-600 uppercase transition-colors duration-300 transform bg-gray-200 rounded-lg hover:bg-gray-400 focus:bg-gray-600 focus:outline-none">
            </div>
        </form>
        <h2 class="mt-12 mb-2 text-lg font-bold text-gray-700">2.&ensp;休暇日数インポート&emsp;<span class="text-blue-600">acquisition_days</span>を最新の日数にupdateする</h2>
        <p class="mb-6 text-gray-700">エクセルを読み込んで休暇日数を設定する</p>
        <form method="post" action="{{ route('acquisition_days_import') }}" enctype="multipart/form-data" class="mb-4">
            @csrf
            <label for="acquisition_days" class="block text-sm text-gray-500">acquisition_days</label>
            <div class="flex">
                <input type="file" name="excel_file" id="acquisition_days" required
                    class="block w-80 px-3 py-2 m-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg file:bg-gray-200 file:text-gray-700 file:text-sm file:px-4 file:py-1 file:border-none file:rounded-full  placeholder-gray-400/70  focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 " />
                <input type="submit" value="インポート"
                    class="px-4 py-2 my-2 text-sm font-medium tracking-wider text-gray-600 uppercase transition-colors duration-300 transform bg-gray-200 rounded-lg hover:bg-gray-400 focus:bg-gray-600 focus:outline-none">
            </div>
        </form>
    </div>




</x-app-layout>
