<x-app-layout>
    <!-- Page nav -->
    <div class="border-b-2 border-gray-200">
        <nav class="py-1 px-2 sm:px-6 -mb-0.5">
            <!-- 有休残日数 -->
            <x-info>
                <p>
                    有休残日数&ensp;:&ensp;
                    @if (!empty($paid_holidays->remaining_days))
                        <span class="font-bold">
                            {{ $paid_holidays->remaining_days }}
                        </span> 日
                    @endif
                    @if (!empty($paid_holidays->remaining_hours))
                        <span class="font-bold">
                            &ensp;{{ $paid_holidays->remaining_hours }}
                        </span> 時間
                    @endif
                </p>
            </x-info>
            <div class="pl-2 -mt-2 mb-1">
                <span class="text-xs text-blue-500">有給休暇取得推進日を除く</span>
            </div>
            <!-- バースデイ休暇notice -->
            @if (now()->subMonths(3) <= $birthday && now()->addMonths(3) >= $birthday)
                <x-info>
                    バースデイ休暇取得期間です
                </x-info>
                <div class="pl-2 -mt-2 mb-1">
                    <span class="text-xs text-blue-500">
                        {{ $birthday->copy()->subMonths(3)->year }}年
                        {{ $birthday->copy()->subMonths(3)->month }}月
                        {{ $birthday->copy()->subMonths(3)->day }}日
                        ~
                        {{ $birthday->copy()->addMonths(3)->year }}年
                        {{ $birthday->copy()->addMonths(3)->month }}月
                        {{ $birthday->copy()->addMonths(3)->day }}日
                    </span>
                </div>
            @endif
            <!-- ハッピーバースデイ -->
            @if (now()->format('Y-m-d') === $birthday->format('Y-m-d'))
                <div class="flex items-center py-1 text-gray-700 text-lg">
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-4 h-4 mr-2 mb-0.5 text-pink-500">
                            <path
                                d="M15 1.784l-.796.796a1.125 1.125 0 101.591 0L15 1.784zM12 1.784l-.796.796a1.125 1.125 0 101.591 0L12 1.784zM9 1.784l-.796.796a1.125 1.125 0 101.591 0L9 1.784zM9.75 7.547c.498-.02.998-.035 1.5-.042V6.75a.75.75 0 011.5 0v.755c.502.007 1.002.021 1.5.042V6.75a.75.75 0 011.5 0v.88l.307.022c1.55.117 2.693 1.427 2.693 2.946v1.018a62.182 62.182 0 00-13.5 0v-1.018c0-1.519 1.143-2.829 2.693-2.946l.307-.022v-.88a.75.75 0 011.5 0v.797zM12 12.75c-2.472 0-4.9.184-7.274.54-1.454.217-2.476 1.482-2.476 2.916v.384a4.104 4.104 0 012.585.364 2.605 2.605 0 002.33 0 4.104 4.104 0 013.67 0 2.605 2.605 0 002.33 0 4.104 4.104 0 013.67 0 2.605 2.605 0 002.33 0 4.104 4.104 0 012.585-.364v-.384c0-1.434-1.022-2.7-2.476-2.917A49.138 49.138 0 0012 12.75zM21.75 18.131a2.604 2.604 0 00-1.915.165 4.104 4.104 0 01-3.67 0 2.604 2.604 0 00-2.33 0 4.104 4.104 0 01-3.67 0 2.604 2.604 0 00-2.33 0 4.104 4.104 0 01-3.67 0 2.604 2.604 0 00-1.915-.165v2.494c0 1.036.84 1.875 1.875 1.875h15.75c1.035 0 1.875-.84 1.875-1.875v-2.494z" />
                        </svg>
                    </p>
                    <p>
                        <span
                            class="Courgette my-4 text-center
                            font-bold tracking-tight
                            bg-gradient-to-r from-pink-500 via-blue-500 to-green-500
                            bg-clip-text text-transparent">
                            happy birthday
                        </span>
                    </p>
                </div>
            @endif
            <!-- バースデイ休暇失効alert -->
            @if (now()->addDays(14)->subMonths(3) >= $birthday && now() <= $birthday->copy()->addMonths(3))
                <x-alert>
                    バースデイ休暇が失効します
                </x-alert>
                <div class="pl-2 -mt-1 mb-1">
                    <span class="text-xs text-blue-500">失効まであと</span>
                    <span class="font-bold text-red-600">{{ now()->subMonths(3)->diff($birthday)->days }}日</span>
                </div>
            @endif
            <!-- 有給休暇失効alert -->
            @if (now()->addMonth() >= $year_end && $lost_paid_holidays > 0)
                <x-alert>
                    有給休暇が失効します
                </x-alert>
                <div class="pl-2 -mt-1 mb-1">
                    <span class="text-xs text-blue-500">年度末で</span>
                    <span class="font-bold text-red-600">{{ now()->diff($year_end)->days }}日間</span>
                    <span class="text-xs text-blue-500">の有給休暇が失効します</span>
                </div>
            @endif
            <!-- 有給休暇取得推進alert -->
            @if (now()->addMonth() >= $year_end && $get_paid_holidays < 5)
                <x-alert>
                    有給休暇を取得してください
                </x-alert>
                <div class="pl-2 -mt-1 mb-1">
                    <span class="text-xs text-blue-500">年度末までにあと</span>
                    <span class="font-bold text-red-600">{{ 5 - $get_paid_holidays }}日</span>
                    <span class="text-xs text-blue-500">取得してください</span>
                </div>
            @endif
        </nav>
    </div>

    <!-- 通知機能 閲覧権限以上 start -->
    @can('general_manager_gl')
        @empty(!($pending || $approved))
            <div class="m-2 bg-red-50 border border-red-200 text-sm text-red-600 rounded-md px-4 py-2">
                @if ($pending)
                    <div class="flex m-1">
                        <span class="font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-5 h-5 mr-2">
                                <path
                                    d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                                <path fill-rule="evenodd"
                                    d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="font-bold">{{ $pending }}件</span>の<span class="font-bold">承認待</span>があります
                    </div>
                @endif
                @if ($approved)
                    <div class="flex m-1">
                        <span class="font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-5 h-5 mr-2">
                                <path
                                    d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                                <path fill-rule="evenodd"
                                    d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="font-bold">{{ $approved }}件</span>の<span class="font-bold">取消確認</span>があります
                    </div>
                @endif
            </div>
        @endempty
    @endcan
    <!-- 通知機能 閲覧権限以上 end -->

    <section class="text-gray-600 body-font">
        <div class="container w-3/4 py-8 mx-auto">
            @auth
                <!-- 基本機能 start -->
                <div class="max-w-md mx-auto grid grid-cols-1 mb-10">
                    <a href={{ route('reports.create') }}
                        class="block text-center items-center p-3 my-2 text-white rounded-xl border border-gray-500 bg-cyan-500 hover:text-gray-600 hover:bg-white focus:text-cyan-500 ">
                        <div class="flex justify-center items-center text-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path
                                    d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                <path
                                    d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"
                                    fill="" />
                            </svg>
                            <span class="ZenMaruGothic w-40">届 出 作 成</span>
                        </div>
                    </a>

                    <a href={{ route('remainings.my_index') }} 
                        class="block text-center items-center p-3 my-2 text-white rounded-xl border border-gray-500 bg-fuchsia-400 hover:text-gray-600 hover:bg-white focus:text-fuchsia-400">
                        <div class="flex justify-center items-center text-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd"
                                    d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5zm6.61 10.936a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"
                                    fill="" />
                            </svg>
                            <span class="ZenMaruGothic w-40">休暇可能日数</span>
                        </div>
                    </a>

                    <a href={{ route('reports.my_index') }} 
                        class="block text-center items-center p-3 my-2 text-white rounded-xl border border-gray-500 bg-amber-400 hover:text-gray-600 hover:bg-white focus:text-amber-400">
                        <div class="flex justify-center items-center text-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd"
                                    d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                    clip-rule="evenodd" fill="" />
                            </svg>
                            <span class="ZenMaruGothic w-40">My届出一覧</span>
                        </div>
                    </a>
                </div>
                <!-- 基本機能 end -->

                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <!-- 閲覧権限以上 start -->
                    @can(['general_gl_reader'])
                        <a href={{ route('reports.index') }} 
                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </span>
                            <span class="flex items-center w-24">
                                届出一覧
                            </span>
                            @if ($pending || $approved)
                                <div class="flex justify-center relative -ml-4 -mt-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-6 h-6 text-red-600">
                                        <path fill-rule="evenodd"
                                            d="M5.337 21.718a6.707 6.707 0 01-.533-.074.75.75 0 01-.44-1.223 3.73 3.73 0 00.814-1.686c.023-.115-.022-.317-.254-.543C3.274 16.587 2.25 14.41 2.25 12c0-5.03 4.428-9 9.75-9s9.75 3.97 9.75 9c0 5.03-4.428 9-9.75 9-.833 0-1.643-.097-2.417-.279a6.721 6.721 0 01-4.246.997z"
                                            clip-rule="evenodd" fill="" />
                                    </svg>
                                    <div class="absolute text-xs text-white font-bold leading-6 text-center">
                                        {{ $pending + $approved }}
                                    </div>
                                </div>
                            @endif
                        </a>

                        <a href={{ route('reports.get_and_remaining') }}
                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                            </span>
                            <span class="w-32">休暇取得状況</span>
                        </a>

                        <a href={{ route('reports.export_form') }}
                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                            </span>
                            <span class="w-32">エクスポート</span>
                        </a>
                    @endcan
                    <!-- 閲覧権限以上 start -->

                    <!-- 管理者 start -->
                    @can('admin_only')
                        <a href={{ route('remainings.index') }}
                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </svg>
                            </span>
                            <span class="w-32">休暇日数の設定</span>
                        </a>

                        <a href={{ route('users.index') }}
                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                </svg>

                            </span>
                            <span class="w-32">ユーザー設定</span>
                        </a>
                    @endcan
                    <!-- 管理者 end -->

                    <!-- 上長承認 start -->
                    @can('general_only')
                        <a href={{ route('approvals.index') }}
                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                            <span class="w-32">権限設定</span>
                        </a>

                    @endcan
                    <!-- 上長承認 end -->
                </div>
            @endauth

            <div class="text-left w-full my-12">
                @if (Auth::user()->approvals->first())
                    <ul class="text-sm">
                        @foreach (Auth::user()->approvals->load('affiliation') as $approval)
                            <x-list>
                                <!-- 管理者 -->
                                @if ($approval->approval_id == 1)
                                    {{ $approval->affiliation->factory->factory_name }}
                                    @if ($approval->affiliation->department_id != 1)
                                        {{ $approval->affiliation->department->department_name }}
                                    @endif
                                    ・{{ __('Admin') }}
                                @endif
                                <!-- 承認 -->
                                @if ($approval->approval_id == 2)
                                    {{ $approval->affiliation->factory->factory_name }}
                                    @if ($approval->affiliation->department_id != 1)
                                        {{ $approval->affiliation->department->department_name }}
                                    @endif
                                    ・{{ __('Approval1') }}
                                @endif
                                @if ($approval->approval_id == 3)
                                    {{ $approval->affiliation->factory->factory_name }}
                                    @if ($approval->affiliation->department_id != 1)
                                        {{ $approval->affiliation->department->department_name }}
                                    @endif
                                    ・{{ __('Approval2') }}
                                @endif
                                <!-- 閲覧 -->
                                @if ($approval->approval_id == 4)
                                    {{ $approval->affiliation->factory->factory_name }}
                                    @if ($approval->affiliation->department_id != 1)
                                        {{ $approval->affiliation->department->department_name }}
                                    @endif
                                    ・{{ __('Reader') }}
                                @endif
                            </x-list>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>

</x-app-layout>
