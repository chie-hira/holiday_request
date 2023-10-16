<x-app-layout>
    <div class="container max-w-2xl px-5 py-24 mx-auto">

        <x-notice :notice="session('notice')" />

        <h2 class="mb-2 text-lg font-bold text-gray-700">1.&ensp;運用開始時に<span class="text-blue-600">必ず</span>行う設定</h2>
        <ul class="text-gray-600 pl-8 mb-6">
            <li class="list-decimal"><span class="text-blue-600">migrate&seed</span></li>
            <li class="list-decimal"><span class="text-blue-600">users</span>データインポート:1度に読み込むデータは100件以内</li>
            <li class="list-decimal"><span class="text-blue-600">acquisition_days</span>設定</li>
            <li class="list-decimal"><span class="text-blue-600">approvals</span>データインポート</li>
        </ul>
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
        <div class="mb-4">
            <label class="block text-sm text-gray-500">acquisition_days</label>
            <div class="flex">
                <p class="text-gray-600 px-3 py-3 m-2">ユーザーデータ全部読み込み後に設定</p>
                <a href="{{ route('initial_import') }}">
                    <button
                        class="px-4 py-3 my-2 text-sm font-medium tracking-wider text-gray-600 uppercase transition-colors duration-300 transform bg-gray-200 rounded-lg hover:bg-gray-400 focus:bg-gray-600 focus:outline-none">
                        設定
                    </button>
                </a>
            </div>
        </div>
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

        <h2 class="mt-12 mb-2 text-lg font-bold text-gray-700">2.&ensp;休暇日数を<span
                class="text-blue-600">運用開始時点</span>の日数にupdate</h2>
        <ul class="text-gray-600 pl-8 mb-6">
            <li class="list-disc"><span class="text-blue-600">エクセルを読み込んで</span>一括update</li>
            <li class="list-disc"><span class="text-blue-600">設定menu</span>から手動でupdate</li>
        </ul>
        <form method="post" action="{{ route('acquisition_days_import') }}" enctype="multipart/form-data"
            class="mb-4">
            @csrf
            <label for="acquisition_days" class="block text-sm text-gray-500">acquisition_days</label>
            <div class="flex">
                <input type="file" name="excel_file" id="acquisition_days" required
                    class="block w-80 px-3 py-2 m-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg file:bg-gray-200 file:text-gray-700 file:text-sm file:px-4 file:py-1 file:border-none file:rounded-full  placeholder-gray-400/70  focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 " />
                <input type="submit" value="インポート"
                    class="px-4 py-2 my-2 text-sm font-medium tracking-wider text-gray-600 uppercase transition-colors duration-300 transform bg-gray-200 rounded-lg hover:bg-gray-400 focus:bg-gray-600 focus:outline-none">
            </div>
        </form>

        <h2 class="mt-12 mb-2 text-lg font-bold text-gray-700">3.&ensp;レポートを
            import</h2>
        <ul class="text-gray-600 pl-8 mb-6">
            <li class="list-disc"><span class="text-blue-600">移行前の申請データ</span>があるときはここからimport</li>
        </ul>
        <form method="post" action="{{ route('reports_import') }}" enctype="multipart/form-data" class="mb-4">
            @csrf
            <label for="acquisition_days" class="block text-sm text-gray-500">reports</label>
            <div class="flex">
                <input type="file" name="excel_file" id="acquisition_days" required
                    class="block w-80 px-3 py-2 m-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg file:bg-gray-200 file:text-gray-700 file:text-sm file:px-4 file:py-1 file:border-none file:rounded-full  placeholder-gray-400/70  focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 " />
                <input type="submit" value="インポート"
                    class="px-4 py-2 my-2 text-sm font-medium tracking-wider text-gray-600 uppercase transition-colors duration-300 transform bg-gray-200 rounded-lg hover:bg-gray-400 focus:bg-gray-600 focus:outline-none">
            </div>
        </form>
    </div>




</x-app-layout>
