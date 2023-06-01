<x-app-layout>
{{-- //TODO:バースデイ休暇は取得期間だけ取得可能にする --}}
{{-- //TODO:バースデイ休暇の取得期間を表示 --}}
    <!-- Page Heading -->
    <header class="text-xs sm:text-sm bg-sky-50 border-b-2 border-gray-400">
        <!-- 有休残日数 -->
        <p class="flex items-center py-1 px-6 text-gray-700 text-xl">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="w-6 h-6 mr-3 text-sky-600">
                <path fill-rule="evenodd"
                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                    clip-rule="evenodd" fill="" />
            </svg>
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
            <span class="text-sm text-blue-500">&emsp;有給休暇取得推進日を除く</span>
        </p>
        <!-- バースデイ休暇notice -->
        @if (now()->addMonth(-3) <= $birthday && now()->addMonth(3) >= $birthday)
            <p class="flex items-center py-1 px-6 text-gray-700 text-xl">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-6 h-6 mr-3 text-sky-600">
                    <path fill-rule="evenodd"
                        d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
                        clip-rule="evenodd" fill="" />
                </svg>
                バースデイ休暇の取得期間です。期間内に必ず習得しましょう！
            </p>
        @endif
        <!-- ハッピーバースデイ -->
        @if (now()->format('Y-m-d') === $birthday->format('Y-m-d'))
            <p class="flex items-center py-1 px-6 text-gray-700 text-xl">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-6 h-6 mr-3 text-fuchsia-400">
                    <path
                        d="M15 1.784l-.796.796a1.125 1.125 0 101.591 0L15 1.784zM12 1.784l-.796.796a1.125 1.125 0 101.591 0L12 1.784zM9 1.784l-.796.796a1.125 1.125 0 101.591 0L9 1.784zM9.75 7.547c.498-.02.998-.035 1.5-.042V6.75a.75.75 0 011.5 0v.755c.502.007 1.002.021 1.5.042V6.75a.75.75 0 011.5 0v.88l.307.022c1.55.117 2.693 1.427 2.693 2.946v1.018a62.182 62.182 0 00-13.5 0v-1.018c0-1.519 1.143-2.829 2.693-2.946l.307-.022v-.88a.75.75 0 011.5 0v.797zM12 12.75c-2.472 0-4.9.184-7.274.54-1.454.217-2.476 1.482-2.476 2.916v.384a4.104 4.104 0 012.585.364 2.605 2.605 0 002.33 0 4.104 4.104 0 013.67 0 2.605 2.605 0 002.33 0 4.104 4.104 0 013.67 0 2.605 2.605 0 002.33 0 4.104 4.104 0 012.585-.364v-.384c0-1.434-1.022-2.7-2.476-2.917A49.138 49.138 0 0012 12.75zM21.75 18.131a2.604 2.604 0 00-1.915.165 4.104 4.104 0 01-3.67 0 2.604 2.604 0 00-2.33 0 4.104 4.104 0 01-3.67 0 2.604 2.604 0 00-2.33 0 4.104 4.104 0 01-3.67 0 2.604 2.604 0 00-1.915-.165v2.494c0 1.036.84 1.875 1.875 1.875h15.75c1.035 0 1.875-.84 1.875-1.875v-2.494z" />
                </svg>
                <span class="Courgette">
                    happy birthday
                </span>
            </p>
        @endif
        <!-- バースデイ休暇失効alert -->
        @if (now()->addDay(14)->addMonth(-3) >= $birthday)
            <p class="flex items-center py-1 px-6 text-gray-700 text-xl">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-6 h-6 mr-2 text-red-700">
                    <path
                        d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                    <path fill-rule="evenodd"
                        d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z"
                        clip-rule="evenodd" />
                </svg>
                あと
                {{ now()->addMonth(-3)->diff($birthday)->days }}
                日でバースデイ休暇が失効します。
            </p>
        @endif
        <!-- 有休失効alert -->
        @if (now()->addMonth(1) >= $year_end && $lost_days > 0)
            <p class="flex items-center py-1 px-6 text-gray-700 text-xl">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-6 h-6 mr-2 text-red-700">
                    <path
                        d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                    <path fill-rule="evenodd"
                        d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z"
                        clip-rule="evenodd" />
                </svg>
                あと
                {{ now()->diff($year_end)->days }}
                日で
                {{ $lost_days }}
                日間の有給休暇が失効します。
            </p>
        @endif
        @if (now()->addMonth(1) >= $year_end && $get_days_only < 5)
            <p class="flex items-center py-1 px-6 text-gray-700 text-xl">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-6 h-6 mr-2 text-red-700">
                    <path
                        d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                    <path fill-rule="evenodd"
                        d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z"
                        clip-rule="evenodd" />
                </svg>
                有給休暇を取得してください。年度末までにあと
                {{ 5 - $get_days_only }}
                日間以上の有給休暇を推奨します。
            </p>
        @endif
    </header>
    <!-- 通知機能 閲覧権限以上 start -->
    @can('general_manager_gl')
        @empty(!($pending || $approved))
            <ul class="px-6 py-4 mb-2 text-md sm:text-lg text-red-700 border-l-4 border-b border-red-600 bg-red-50"
                role="alert">
                @if ($pending)
                    <li class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-2">
                            <path
                                d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                            <path fill-rule="evenodd"
                                d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <span class="font-bold">{{ $pending }}件</span>の<span class="font-bold">承認待</span>があります
                        </div>
                    </li>
                @endif
                @if ($approved)
                    <li class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-2">
                            <path
                                d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                            <path fill-rule="evenodd"
                                d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-bold">{{ $approved }}件</span>の<span class="font-bold">取消確認</span>があります
                    </li>
                @endif
            </ul>
        @endempty
    @endcan
    <!-- 通知機能 閲覧権限以上 end -->

    <section class="text-gray-600 body-font">
        <div class="container w-3/4 py-10 mx-auto">
            @auth
                <div class="max-w-md mx-auto grid grid-cols-1 mb-10">
                    <!-- 基本機能 start -->
                    <a href={{ route('reports.create') }}
                        class="block text-center items-center p-3 my-2 text-white rounded-xl border-2 border-gray-500 bg-cyan-500 hover:text-gray-600 hover:font-semibold hover:bg-white focus:text-cyan-500 ">
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
                        class="block text-center items-center p-3 my-2 text-base text-white rounded-xl border-2 border-gray-500 bg-fuchsia-400 hover:text-gray-600 hover:font-semibold hover:bg-white focus:text-fuchsia-400 ">
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

                    <a href={{ route('reports.index') }}
                        class="block text-center items-center p-3 my-2 text-white rounded-xl border-2 border-gray-500 bg-amber-400 hover:text-gray-600 hover:font-semibold hover:bg-white focus:text-amber-400 ">
                        <div class="flex justify-center items-center text-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-6 h-6 hover:text-cyan-400">
                                <path fill-rule="evenodd"
                                    d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                    clip-rule="evenodd" fill="" />
                            </svg>
                            <span class="ZenMaruGothic w-40">届 出 一 覧</span>
                        </div>
                    </a>
                    <!-- 基本機能 end -->
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <!-- 閲覧権限以上 start -->
                    @can(['general_gl_reader'])
                        <a href={{ route('reports.pending_approval') }}
                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-600 hover:font-bold">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            <span class="flex items-center w-24">
                                承認<span class="text-red-700 font-bold">待ち</span>
                            </span>
                            @if ($pending)
                                <div class="flex justify-center relative -ml-4 -mt-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-6 h-6 text-red-700">
                                        <path fill-rule="evenodd"
                                            d="M5.337 21.718a6.707 6.707 0 01-.533-.074.75.75 0 01-.44-1.223 3.73 3.73 0 00.814-1.686c.023-.115-.022-.317-.254-.543C3.274 16.587 2.25 14.41 2.25 12c0-5.03 4.428-9 9.75-9s9.75 3.97 9.75 9c0 5.03-4.428 9-9.75 9-.833 0-1.643-.097-2.417-.279a6.721 6.721 0 01-4.246.997z"
                                            clip-rule="evenodd" fill="" />
                                    </svg>
                                    <div class="absolute text-xs text-white font-bold leading-6 text-center">
                                        {{ $pending }}
                                    </div>
                                </div>
                            @endif
                        </a>

                        <a href={{ route('reports.approved') }}
                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-600 hover:font-bold">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            <span class="flex items-center w-24">
                                承認<span class="font-bold text-sky-600">済み</span>
                            </span>
                            @if ($approved)
                                <div class="flex justify-center relative -ml-4 -mt-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-6 h-6 text-red-700">
                                        <path fill-rule="evenodd"
                                            d="M5.337 21.718a6.707 6.707 0 01-.533-.074.75.75 0 01-.44-1.223 3.73 3.73 0 00.814-1.686c.023-.115-.022-.317-.254-.543C3.274 16.587 2.25 14.41 2.25 12c0-5.03 4.428-9 9.75-9s9.75 3.97 9.75 9c0 5.03-4.428 9-9.75 9-.833 0-1.643-.097-2.417-.279a6.721 6.721 0 01-4.246.997z"
                                            clip-rule="evenodd" fill="" />
                                    </svg>
                                    <div class="absolute text-xs text-white font-bold leading-6 text-center">
                                        {{ $approved }}
                                    </div>
                                </div>
                            @endif
                        </a>

                        <a href={{ route('reports.get_and_remaining') }}
                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-600 hover:font-bold">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            <span class="w-32">休暇取得状況</span>
                        </a>
                    @endcan
                    <!-- 閲覧権限以上 start -->

                    <!-- 管理者 start -->
                    @can('admin_only')
                        <a href={{ route('remainings.index') }}
                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-600 hover:font-bold">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            <span class="w-32">休暇日数の設定</span>
                        </a>

                        <a href={{ route('users.index') }}
                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-600 hover:font-bold">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M4.5 3.75a3 3 0 00-3 3v10.5a3 3 0 003 3h15a3 3 0 003-3V6.75a3 3 0 00-3-3h-15zm4.125 3a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5zm-3.873 8.703a4.126 4.126 0 017.746 0 .75.75 0 01-.351.92 7.47 7.47 0 01-3.522.877 7.47 7.47 0 01-3.522-.877.75.75 0 01-.351-.92zM15 8.25a.75.75 0 000 1.5h3.75a.75.75 0 000-1.5H15zM14.25 12a.75.75 0 01.75-.75h3.75a.75.75 0 010 1.5H15a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3.75a.75.75 0 000-1.5H15z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            <span class="w-32">ユーザー設定</span>
                        </a>
                    @endcan
                    <!-- 管理者 end -->

                    <!-- 上長承認 start -->
                    @can('general_only')
                        <a href={{ route('approvals.index') }}
                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-600 hover:font-bold">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-6 h-6">
                                    <path fill-rule="evenodd"
                                        d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"
                                        clip-rule="evenodd" />
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
                        @foreach (Auth::user()->approvals as $approval)
                            <li class="flex mx-auto items-center leading-relaxed">
                                <span class="w-4 h-4 mr-2 rounded-full inline-flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5 text-sky-600">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" fill="" />
                                    </svg>
                                </span>
                                <!-- 閲覧 -->
                                @if ($approval->approval_id == 5)
                                    {{ Auth::user()->getApprovalFactory($approval->factory_id) }}
                                    @if ($approval->department_id == 1)
                                        ・{{ Auth::user()->getApprovalName($approval->approval_id) }}
                                    @else
                                        ・{{ Auth::user()->getApprovalDepartment($approval->department_id) }}
                                        ・{{ Auth::user()->getApprovalGroup($approval->group_id) }}
                                        ・{{ Auth::user()->getApprovalName($approval->approval_id) }}
                                    @endif
                                @endif
                                <!-- GL -->
                                @if ($approval->approval_id == 4)
                                    {{ Auth::user()->getApprovalDepartment($approval->department_id) }}
                                    ・{{ Auth::user()->getApprovalGroup($approval->group_id) }}
                                    ・{{ __('Leader') }}
                                @endif
                                <!-- 課長 -->
                                @if ($approval->approval_id == 3)
                                    {{ Auth::user()->getApprovalDepartment($approval->department_id) }}
                                    ・{{ __('Manager') }}
                                @endif
                                <!-- 工場長承認:課ごと -->
                                @if ($approval->approval_id == 2 && $approval->department_id != 1)
                                    {{ Auth::user()->getApprovalFactory($approval->factory_id) }}
                                    ・{{ Auth::user()->getApprovalDepartment($approval->department_id) . __('長') }}
                                @endif
                                <!-- 工場長承認:包括 -->
                                @if ($approval->approval_id == 2 && $approval->department_id == 1)
                                    {{ Auth::user()->getApprovalFactory($approval->factory_id) }}
                                    ・{{ __('工場長') }}
                                @endif
                                <!-- 管理者 -->
                                @if ($approval->approval_id == 1)
                                    {{ Auth::user()->getApprovalFactory($approval->factory_id) }}
                                    ・{{ Auth::user()->getApprovalName($approval->approval_id) }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>

</x-app-layout>
