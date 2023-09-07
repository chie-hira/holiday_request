<x-app-layout>
    <section class="text-gray-600 body-font p-2">
        <div class="grid grid-cols-6">

            <!-- table of contents -->
            <div class="col-span-2 md:col-span-1">
                <h2 class="text-xl font-medium">目次</h2>
                <ul class="sticky top-0" data-hs-scrollspy="#scrollspy-2"
                    data-hs-scrollspy-scrollable-parent="#scrollspy-scrollable-parent-2">
                    <li data-hs-scrollspy-group>
                        <a href="#common" id="drop-down-button-1"
                            class="block py-0.5 text-sm font-medium leading-6 text-slate-700 hover:text-slate-900 hs-scrollspy-active:text-blue-600 active">
                            <div class="flex text-center items-center">
                                共通機能
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </a>

                        <ul id="drop-down-menu-1" class="hidden">
                            <li class="ml-2">
                                <a href="#notice"
                                    class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                    <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                        width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    通知機能
                                </a>
                            </li>
                            <li class="ml-2">
                                <a href="#base"
                                    class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                    <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                        width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    基本メニュー
                                </a>
                            </li>
                            <li class="ml-2">
                                <a href="#report-create"
                                    class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                    <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                        width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    休暇申請書の作成と提出
                                </a>
                            </li>
                            <li class="ml-2">
                                <a href="#report-error"
                                    class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                    <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                        width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    提出に失敗したときは
                                </a>
                            </li>
                            <li class="ml-2">
                                <a href="#report-show"
                                    class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                    <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                        width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    申請書の確認
                                </a>
                            </li>
                            <li class="ml-2">
                                <a href="#report-my-index"
                                    class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                    <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                        width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    自分の申請を一覧表示
                                </a>
                            </li>
                            <li class="ml-2">
                                <a href="#report-edit"
                                    class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                    <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                        width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    申請の修正
                                </a>
                            </li>
                            <li class="ml-2">
                                <a href="#report-delete"
                                    class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                    <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                        width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    申請の取消
                                </a>
                            </li>
                            <li class="ml-2">
                                <a href="#remaining-my-index"
                                    class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                    <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                        width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    休暇日数の確認
                                </a>
                            </li>
                        </ul>
                    </li>
                    @can('approver_reader')
                        <li data-hs-scrollspy-group>
                            <a href="#approval" id="drop-down-button-2"
                                class="block py-0.5 text-sm font-medium leading-6 text-slate-700 hover:text-slate-900 hs-scrollspy-active:text-blue-600 active">
                                <div class="flex text-center items-center">
                                    承認機能
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </a>
                            <ul id="drop-down-menu-2" class="hidden">
                                <li class="ml-2">
                                    <a href="#approval-notice"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        承認と取消確認の通知
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#report-index"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        部署内の申請を一覧表示
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#report-approval"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        申請を承認する
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#report-cant-approval"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        承認したくないときは
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#report-cancel-check"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        取消申請の確認
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li data-hs-scrollspy-group>
                            <a href="#achievement" id="drop-down-button-3"
                                class="block py-0.5 text-sm font-medium leading-6 text-slate-700 hover:text-slate-900 hs-scrollspy-active:text-blue-600 active">
                                <div class="flex text-center items-center">
                                    実績確認機能
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </a>
                            <ul id="drop-down-menu-3" class="hidden">
                                <li class="ml-2">
                                    <a href="#get-and-remaining" id="drop-down-button-3"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        メンバーの休暇日数の確認
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#export"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        一覧のエクスポート
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @can('admin')
                        <li data-hs-scrollspy-group>
                            <a href="#admin" id="drop-down-button-4"
                                class="block py-0.5 text-sm font-medium leading-6 text-slate-700 hover:text-slate-900 hs-scrollspy-active:text-blue-600 active">
                                <div class="flex text-center items-center">
                                    管理機能
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </a>
                            <ul id="drop-down-menu-4" class="hidden">
                                <li class="ml-2">
                                    <a href="#remaining-update"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        休暇日数を設定する
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#remaining-all-update"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        有給休暇を一括更新する
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#user-update"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        ユーザーの部署の変更
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#user-delete"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        ユーザーの削除
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#register"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        ユーザーの新規登録
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#approval-info"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        権限
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#approval-update"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        権限の変更
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#approval-delete"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        権限の削除
                                    </a>
                                </li>
                                <li class="ml-2">
                                    <a href="#approval-create"
                                        class="group flex items-start gap-x-2 py-0.5 text-xs text-gray-700 leading-6 hover:text-gray-800 hs-scrollspy-active:text-blue-600">
                                        <svg class="w-2 h-6 text-gray-400 overflow-visible group-hover:text-gray-600"
                                            width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 2L10.6464 7.64645C10.8417 7.84171 10.8417 8.15829 10.6464 8.35355L5 14"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                        権限の追加
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                </ul>
            </div>

            <!--  -->
            <div class="col-span-4 md:col-span-5">
                <div id="scrollspy-2" class="space-y-4">
                    <div id="common">
                        <h3 class="text-lg font-semibold">共通機能</h3>
                        <!-- notice -->
                        <div id="notice" class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                            <div class="mt-2">
                                <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                    tabindex="0">通知機能</h2>
                                <p class="mt-2 text-sm text-gray-600">
                                    &emsp;有給休暇の残日数、バースデイ休暇、休暇の失効について通知が表示されます。
                                    有給休暇の残日数は常時、他の通知は時期になると表示されます。
                                </p>
                            </div>
                        </div>

                        <div class="border-b-2 border-gray-200">
                            <nav class="py-1 px-2 sm:px-6 -mb-0.5">
                                <!-- 有休残日数 -->
                                <x-info class="py-1">
                                    <p class="text-sm">
                                        有給休暇残日数:
                                        <span class="font-bold">
                                            20
                                        </span> 日
                                        <span class="font-bold">
                                            4
                                        </span> 時間
                                    </p>
                                </x-info>
                                <!-- バースデイ休暇notice -->
                                <x-info class="py-1 text-sm">
                                    バースデイ休暇取得期間です
                                </x-info>
                                <div class="pl-2 -mt-2 mb-1">
                                    <span class="text-xs text-blue-500">
                                        {{ '2023' }}年
                                        {{ '4' }}月
                                        {{ '1' }}日
                                        ~
                                        {{ '2023' }}年
                                        {{ '6' }}月
                                        {{ '1' }}日
                                    </span>
                                </div>
                                <x-alert class="text-sm">
                                    バースデイ休暇が失効します
                                </x-alert>
                                <div class="pl-2 -mt-1 mb-1">
                                    <span class="text-xs text-blue-500">失効まであと</span>
                                    <span class="font-bold text-sm text-red-600">{{ '14' }}日</span>
                                </div>
                                <!-- 有給休暇失効alert -->
                                <x-alert class="text-sm">
                                    有給休暇が失効します
                                </x-alert>
                                <div class="pl-2 -mt-1 mb-1">
                                    <span class="text-xs text-blue-500">年度末で</span>
                                    <span class="font-bold text-sm text-red-600">{{ '7' }}日間</span>
                                    <span class="text-xs text-blue-500">の有給休暇が失効します</span>
                                </div>
                                <!-- 有給休暇取得推進alert -->
                                <x-alert class="text-sm">
                                    有給休暇を取得してください
                                </x-alert>
                                <div class="pl-2 -mt-1 mb-1">
                                    <span class="text-xs text-blue-500">年度末までにあと</span>
                                    <span class="font-bold text-sm text-red-600">{{ '2' }}日</span>
                                    <span class="text-xs text-blue-500">取得してください</span>
                                </div>
                            </nav>
                        </div>
                    </div>

                    <!-- base -->
                    <div id="base">
                        <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                            <div class="mt-2">
                                <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                    tabindex="0">基本メニュー</h2>
                                <p class="mt-2 text-sm text-gray-600">
                                    &emsp;基本メニューは、申請書作成、休暇日数、My申請一覧の3つあります。
                                    申請書の作成と提出、休暇日数の取得日数と残日数の確認、自身の申請書の一覧の確認ができます。</p>
                            </div>
                        </div>
                        <section class="text-gray-600 body-font border-b-2 border-green-800">
                            <div class="container w-3/4 py-4 md:py-8 mx-auto">
                                <!-- 基本機能 start -->
                                <div class="max-w-md mx-auto grid grid-cols-1 mb-10">
                                    <a href="#report-create"
                                        class="block text-center items-center p-3 my-2 text-white rounded-xl border border-gray-500 bg-cyan-500 hover:text-gray-600 hover:bg-white focus:text-cyan-500 ">
                                        <div class="flex justify-center items-center text-2xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6">
                                                <path
                                                    d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                                <path
                                                    d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"
                                                    fill="" />
                                            </svg>
                                            <span class="ZenMaruGothic w-40">届 出 作 成</span>
                                        </div>
                                    </a>

                                    <a href="#remaining-my-index"
                                        class="block text-center items-center p-3 my-2 text-white rounded-xl border border-gray-500 bg-fuchsia-400 hover:text-gray-600 hover:bg-white focus:text-fuchsia-400">
                                        <div class="flex justify-center items-center text-2xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6">
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

                                    <a href="#report-my-index"
                                        class="block text-center items-center p-3 my-2 text-white rounded-xl border border-gray-500 bg-amber-400 hover:text-gray-600 hover:bg-white focus:text-amber-400">
                                        <div class="flex justify-center items-center text-2xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd"
                                                    d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                                    clip-rule="evenodd" fill="" />
                                            </svg>
                                            <span class="ZenMaruGothic w-40">My届出一覧</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- report-create -->
                    <div id="report-create">
                        <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                            <div class="mt-2">
                                <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                    tabindex="0">休暇申請書の作成と提出
                                </h2>
                                <p class="mt-2 text-sm text-gray-600">
                                    &emsp;基本メニューの<a href="#base"
                                        class="text-blue-600 hover:underline">申請書作成</a>をクリックして、申請書作成ページにすすみます。<br>
                                    &emsp;休暇種類、取得形態、休暇期間、事由は必須項目です。
                                    事由で「その他」「体調不良」を選択した場合は、事由の詳細を入力してください。
                                    取得日数と残日数は自動計算されます。入力が終わったら提出ボタンを押してください。<br>
                                    &emsp;正しく提出されたときは、<a href="#report-show"
                                        class="text-blue-600 hover:underline">申請書</a>が表示されます。提出できないときは、<a
                                        href="#report-error"
                                        class="text-blue-600 hover:underline">エラーメッセージ</a>が表示されます。
                                    エラーメッセージを確認して、休暇種類を修正して提出してください。
                                </p>
                            </div>
                        </div>

                        <section class="text-gray-600 body-font border-b-2 border-green-800">
                            <div class="container w-full md:w-4/5 lg:w-2/3 px-5 py-8 md:py-16 mx-auto">
                                <div class="flex flex-col text-center w-full mb-12">
                                    <h1 class="sm:text-3xl text-2xl ZenMaruGothic title-font mb-4 text-gray-900">申請書作成
                                    </h1>
                                    <x-info class="mx-auto">
                                        <p class="text-xs md:text-sm">
                                            項目を入力して、<span class="font-bold">提出</span>を押してください。
                                        </p>
                                    </x-info>
                                </div>

                                <form action="#report-show">
                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                        <div>
                                            <label for="report_date"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                申請日
                                            </label>
                                            <x-input type="date" id="report_date" name="report_date"
                                                class="block mt-1 w-full" :value="date('Y-m-d')" readonly />
                                        </div>
                                        <div>
                                            <label for="user_id"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                氏名
                                            </label>
                                            <x-input type="text" id="user_id" class="block mt-1 w-full"
                                                :value="Auth::user()->name" readonly />
                                        </div>
                                        <div>
                                            <label for="report_id"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                休暇種類
                                            </label>
                                            <x-select id="report_id" class="block mt-1 w-full">
                                                <option>{{ '有給休暇' }}</option>
                                                <option>{{ 'バースデイ休暇' }}</option>
                                                <option>{{ '他' }}</option>
                                            </x-select>
                                        </div>
                                        <div>
                                            <p class="block mb-2 text-sm font-medium text-gray-900">
                                                取得形態
                                            </p>
                                            <div class="flex gap-x-6">
                                                <div class="flex mt-2">
                                                    <input type="radio" id="sub_report_id_1"
                                                        class="shrink-0 mt-0.5 border-gray-200 rounded-full text-green-600 focus:ring-grenn-300 ">
                                                    <label for="sub_report_id_1"
                                                        class="mr-2 text-xs md:text-sm text-gray-500 ml-2">
                                                        {{ __('終日休') }}
                                                    </label>
                                                    <input type="radio" id="sub_report_id_2"
                                                        class="shrink-0 mt-0.5 border-gray-200 rounded-full text-green-600 focus:ring-grenn-300 ">
                                                    <label for="sub_report_id_2"
                                                        class="mr-2 text-xs md:text-sm text-gray-500 ml-2">
                                                        {{ __('連休') }}
                                                    </label>
                                                    <input type="radio" id="sub_report_id_3"
                                                        class="shrink-0 mt-0.5 border-gray-200 rounded-full text-green-600 focus:ring-grenn-300 ">
                                                    <label for="sub_report_id_3"
                                                        class="mr-2 text-xs md:text-sm text-gray-500 ml-2">
                                                        {{ __('半日休') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="start_date"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                休暇予定日：何日から
                                            </label>
                                            <x-input type="date" id="start_date" class="block mt-1 w-full" />
                                        </div>
                                        <div>
                                            <label for="end_date"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                何日まで
                                            </label>
                                            <x-input id="end_date" type="date" class="block mt-1 w-full" />
                                        </div>
                                        <div>
                                            <label for="reason_id"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                事 由
                                            </label>
                                            <x-select id="reason_id" class="block mt-1 w-full">
                                                <option>
                                                    {{ __('その他') }}
                                                </option>
                                                <option>
                                                    {{ __('体調不良') }}
                                                </option>
                                                <option>
                                                    {{ __('私用') }}
                                                </option>
                                            </x-select>
                                        </div>
                                        <div>
                                            <label for="reason_detail"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                事由の詳細・備考
                                            </label>
                                            <x-input id="reason_detail" type="text"
                                                placeholder="詳細・備考があれば記載してください" class="block mt-1 w-full" />
                                        </div>
                                    </div>

                                    <div class="flex my-6">
                                        <div class="mr-4">
                                            <p class="block mb-2 text-sm font-medium text-gray-900">
                                                取得日数
                                            </p>
                                            <div class="flex items-center mb-1">
                                                <x-input id="get_days_only" type="number"
                                                    class="block mt-1 w-14 md:w-20" readonly />
                                                <p class="ml-2 text-xs md:text-md">日</p>
                                            </div>
                                            <div class="flex items-center mb-1">
                                                <x-input id="get_hours" type="number"
                                                    class="block mt-1 w-14 md:w-20" readonly />
                                                <p class="ml-2 text-xs md:text-md">時間</p>
                                            </div>
                                            <div class="flex items-center">
                                                <x-input id="get_minutes" type="number"
                                                    class="block mt-1 w-14 md:w-20" readonly />
                                                <p class="ml-2 text-xs md:text-md">分</p>
                                            </div>
                                        </div>

                                        <div>
                                            <p class="block mb-2 text-sm font-medium text-gray-900">
                                                残日数
                                            </p>
                                            <div class="flex items-center mb-1">
                                                <x-input id="remaining_days_only" type="number"
                                                    class="block mt-1 w-14 md:w-20" readonly />
                                                <p class="ml-2 text-xs md:text-md">日</p>
                                            </div>
                                            <div class="flex items-center mb-1">
                                                <x-input id="remaining_hours" type="number"
                                                    class="block mt-1 w-14 md:w-20" readonly />
                                                <p class="ml-2 text-xs md:text-md">時間</p>
                                            </div>
                                            <div class="flex items-center">
                                                <x-input id="remaining_minutes" type="number"
                                                    class="block mt-1 w-14 md:w-20" readonly />
                                                <p class="ml-2 text-xs md:text-md">分</p>
                                            </div>
                                        </div>
                                    </div>
                                    <x-button class="w-full">
                                        {{ __('Submission') }}
                                    </x-button>
                                </form>

                                <div class="mt-10 flex justify-end">
                                    <x-back-home-button class="w-30" href="#base">
                                        {{ __('Back') }}
                                    </x-back-home-button>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- report-error -->
                    <div id="report-error">
                        <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                            <div class="mt-2">
                                <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                    tabindex="0">提出に失敗したときは
                                </h2>
                                <p class="mt-2 text-sm text-gray-600">
                                    &emsp;申請書を作成して、提出ボタンを押しても申請書が表示されないときは、提出に失敗しています。エラーメッセージを確認してください。<br>
                                    &emsp;例えば、既に申請済みの日付で申請したり、残日数を超えて申請することはできません。
                                    また、提出ボタンを押す前に備考入力欄の下に注意が表示されていないか確認してください。
                                </p>
                            </div>
                        </div>

                        <section class="text-gray-600 body-font border-b-2 border-green-800">
                            <div class="container w-full md:w-4/5 lg:w-2/3 px-5 py-8 md:py-16 mx-auto">
                                <div class="flex flex-col text-center w-full mb-12">
                                    <h1 class="sm:text-3xl text-2xl ZenMaruGothic title-font mb-4 text-gray-900">申請書作成
                                    </h1>
                                    <x-info class="mx-auto">
                                        <p class="text-xs md:text-sm">
                                            項目を入力して、<span class="font-bold">提出</span>を押してください。
                                        </p>
                                    </x-info>
                                </div>

                                <div class="my-4 bg-red-50 border border-red-200 text-sm text-red-600 rounded-md p-2">
                                    <div class="flex m-1 text-xs md:text-sm">
                                        <span class="font-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-4 h-4 md:w-5 md:h-5 mr-2">
                                                <path
                                                    d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                                                <path fill-rule="evenodd"
                                                    d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                        <span class="font-bold">{{ __('2') }}件</span>の<span
                                            class="font-bold">エラー</span>があります
                                    </div>
                                    <ul class="text-xs md:text-sm">
                                        <li class="flex ml-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-4 h-4 mr-2">
                                                <path fill-rule="evenodd"
                                                    d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                                                    clip-rule="evenodd" fill="" />
                                            </svg>
                                            <div class="font-medium">
                                                {{ __('連休は取得日数が2日以上で申請してください。') }}
                                            </div>
                                        </li>
                                        <li class="flex ml-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-4 h-4 mr-2">
                                                <path fill-rule="evenodd"
                                                    d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                                                    clip-rule="evenodd" fill="" />
                                            </svg>
                                            <div class="font-medium">
                                                {{ __('終了日付には、開始日付以降の日付を指定してください。') }}
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <form action="#report-error">
                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                        <div>
                                            <label for="report_date"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                申請日
                                            </label>
                                            <x-input type="date" id="report_date" class="block mt-1 w-full"
                                                :value="date('Y-m-d')" readonly />
                                        </div>
                                        <div>
                                            <label for="user_id"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                氏名
                                            </label>
                                            <x-input type="text" id="user_id" class="block mt-1 w-full"
                                                :value="Auth::user()->name" readonly />
                                        </div>
                                        <div>
                                            <label for="report_id"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                休暇種類
                                            </label>
                                            <x-select id="report_id" class="block mt-1 w-full">
                                                <option>{{ 'バースデイ休暇' }}</option>
                                                <option>{{ '有給休暇' }}</option>
                                                <option>{{ '他' }}</option>
                                            </x-select>
                                        </div>
                                        <div>
                                            <label for="start_date"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                休暇予定日
                                            </label>
                                            <x-input id="start_date" type="date" class="block mt-1 w-full"
                                                :value="old('start_date')" />
                                        </div>
                                        <div>
                                            <label for="reason_id"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                事 由
                                            </label>
                                            <x-select id="reason_id" class="block mt-1 w-full">
                                                <option>{{ __('誕生日') }}</option>
                                                <option>{{ __('他') }}</option>
                                            </x-select>
                                        </div>
                                        <div id="reason_detail_form">
                                            <label for="reason_detail"
                                                class="block mb-2 text-sm font-medium text-gray-900">
                                                事由の詳細・備考
                                            </label>
                                            <x-input type="text" id="reason_detail"
                                                placeholder="詳細・備考があれば記載してください" class="block mt-1 w-full"
                                                :value="old('reason_detail')" />
                                        </div>
                                    </div>

                                    <div>
                                        <x-info>
                                            <p class="text-xs md:text-sm">
                                                時間休は
                                                <span class="font-semibold text-red-500">1時間単位</span>
                                                で取得できます。
                                            </p>
                                        </x-info>
                                    </div>
                                    <div>
                                        <x-info>
                                            <p class="text-xs md:text-sm">
                                                選択中の休暇予定日は
                                                <span class="font-semibold text-red-500">休日</span>
                                                です。
                                            </p>
                                        </x-info>
                                    </div>
                                    <div style="display: ">
                                        <x-info>
                                            <p class="text-xs md:text-sm">
                                                選択中の休暇予定に
                                                <span class="font-semibold text-red-500">申請済みの日時</span>
                                                が含まれています。
                                            </p>
                                        </x-info>
                                    </div>

                                    <div class="flex my-6">
                                        <div class="mr-4">
                                            <p class="block mb-2 text-sm font-medium text-gray-900">
                                                取得日数
                                            </p>
                                            <div class="flex items-center mb-1">
                                                <x-input id="get_days_only" type="number"
                                                    class="block mt-1 w-14 md:w-20" readonly />
                                                <p class="ml-2 text-xs md:text-md">日</p>
                                            </div>
                                            <div class="flex items-center mb-1">
                                                <x-input id="get_hours" type="number"
                                                    class="block mt-1 w-14 md:w-20" readonly />
                                                <p class="ml-2 text-xs md:text-md">時間</p>
                                            </div>
                                            <div class="flex items-center">
                                                <x-input id="get_minutes" type="number"
                                                    class="block mt-1 w-14 md:w-20" readonly />
                                                <p class="ml-2 text-xs md:text-md">分</p>
                                            </div>
                                        </div>

                                        <div>
                                            <p class="block mb-2 text-sm font-medium text-gray-900">
                                                残日数
                                            </p>
                                            <div class="flex items-center mb-1">
                                                <x-input id="remaining_days_only" type="number"
                                                    class="block mt-1 w-14 md:w-20" readonly />
                                                <p class="ml-2 text-xs md:text-md">日</p>
                                            </div>
                                            <div class="flex items-center mb-1">
                                                <x-input id="remaining_hours" type="number"
                                                    class="block mt-1 w-14 md:w-20" readonly />
                                                <p class="ml-2 text-xs md:text-md">時間</p>
                                            </div>
                                            <div class="flex items-center">
                                                <x-input id="remaining_minutes" type="number"
                                                    class="block mt-1 w-14 md:w-20" readonly />
                                                <p class="ml-2 text-xs md:text-md">分</p>
                                            </div>
                                        </div>
                                    </div>
                                    <x-button class="w-full">
                                        {{ __('Submission') }}
                                    </x-button>
                                </form>

                                <div class="mt-10 flex justify-end">
                                    <x-back-home-button class="w-30" href="#base">
                                        {{ __('Back') }}
                                    </x-back-home-button>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- report-show -->
                    <div id="report-show">
                        <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                            <div class="mt-2">
                                <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                    tabindex="0">申請書の確認
                                </h2>
                                <p class="mt-2 text-sm text-gray-600">
                                    &emsp;申請書を提出すると承認中の申請書が表示されます。
                                    承認中の申請は、係長と上長の2人が承認すると承認済みに変わります。<br>
                                    &emsp;提出した申請書は<a href="#report-my-index"
                                        class="text-blue-600 hover:underline">My申請一覧</a>から確認できます。
                                </p>
                            </div>
                        </div>

                        <section class="text-gray-600 body-font border-b-2 pb-6">
                            <div id="pending-show" class="w-full max-w-lg mx-auto mt-8">
                                <p class="text-center text-amber-500 text-2xl font-semibold">承認中</p>
                            </div>

                            <div
                                class="w-full max-w-md mx-auto mt-6 mb-8 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                <div class="flex items-center justify-between mb-2">
                                    <h5
                                        class="border-solid border-2 px-6 sm:px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                                        出 退 勤 届 け
                                    </h5>
                                    <p
                                        class="border-solid border-2 px-4 py-1 border-sky-500 rounded-md text-md font-medium text-sky-600">
                                        {{ Auth::user()->affiliation->factory->factory_name }}
                                    </p>
                                </div>
                                <p class="text-gray-600 text-sm text-right">{{ Auth::user()->department_group_name }}
                                </p>
                                <div class="flow-root">
                                    <ul role="list" class="divide-y divide-gray-200">
                                        <!-- divide-y アンダーライン仕切り -->
                                        <li class="">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <p class="ZenKurenaido px-2 text-xl font-semibold text-gray-800">
                                                        {{ __('有給休暇') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                            {{ __('Reason') }}
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                            {{ __('その他') }}</p>
                                                    </div>
                                                    <p class="text-sm text-gray-700 truncate px-4 pt-2">
                                                        {{ __('子供の行事') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                            期 間
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                            {{ __('2023-05-02') }}&emsp;
                                                            <span class="ml-4">
                                                                {{ __('1') }}日間
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                            {{ __('Report Date') }}
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                            {{ __('2023-05-01') }}&emsp;
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                            コード
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                            {{ Auth::user()->employee }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                            {{ __('Name') }}
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                            {{ Auth::user()->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <table>
                                                <thead class="">
                                                    <tr>
                                                        <th
                                                            class="w-20 border border-gray-500 text-gray-900 text-center text-sm">
                                                            部長/工場長
                                                        </th>
                                                        <th
                                                            class="w-20 border border-gray-500 text-gray-900 text-center text-sm">
                                                            課長/GL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="w-20 h-12 border border-gray-500 text-center">
                                                        </td>
                                                        <td class="w-20 h-12 border border-gray-500 text-center">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="w-full max-w-md mx-auto grid grid-cols-1 gap-2">
                                <div class="flex justify-end">
                                    <x-return-button class="w-30 px-4" href="#report-my-index">
                                        {{ __('Report MyIndex') }}
                                    </x-return-button>
                                </div>
                                <div class="flex justify-end">
                                    <x-back-home-button class="w-30" href="#base">
                                        {{ __('Back') }}
                                    </x-back-home-button>
                                </div>
                            </div>

                            {{-- <div
                                class="w-full max-w-lg mx-auto my-4 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 items-center justify-between mb-2">
                                    <h5
                                        class="text-center border-solid border-2 px-6 sm:px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                                        {{ __('有給休暇願') }}
                                    </h5>
                                    <p
                                        class="text-right underline underline-offset-4 border-solid px-4 py-1 border-sky-500 text-md font-medium text-sky-600">
                                        {{ __('終日休') }}
                                    </p>
                                </div>
                                <div class="flex justify-end">
                                    <div></div>
                                    <ul role="list" class="divide-y divide-gray-500">
                                        <li class="text-sm md:text-lg">
                                            &emsp;申請日&emsp;:&emsp;
                                            <span class="ZenKurenaido font-bold text-gray-800 mr-2">
                                                {{ __('2023-05-01') }}&emsp;
                                            </span>
                                        </li>
                                        <li></li>
                                    </ul>
                                </div>

                                <div class="flex justify-between my-4">
                                    <ul class="divide-y divide-gray-500 text-sm md:text-md">
                                        <li class="pt-2">
                                            <div class="ZenKurenaido font-semibold text-gray-800 text-md sm:text-lg">
                                                &emsp;富士善工業株式会社&ensp;御中&emsp;
                                            </div>
                                        </li>
                                        <li class="pt-2">
                                            <div class="flex items-center text-md sm:text-lg">
                                                &emsp;氏 名 &emsp;
                                                <span class="ZenKurenaido font-semibold text-gray-800 mr-2">
                                                    {{ Auth::user()->name }}
                                                </span>
                                            </div>
                                        </li>
                                        <li></li>
                                    </ul>
                                </div>
                                <ul role="list" class="divide-y divide-gray-500 text-sm md:text-lg">
                                    <li class="pt-2 pb-0">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center pb-1">
                                                    <p
                                                        class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                        期 間
                                                    </p>
                                                    <p class="ZenKurenaido font-semibold text-gray-800 ml-4">
                                                        {{ __('2023-05-01') }}
                                                        <span class="font-bold text-gray-800 ml-4">
                                                            {{ __('1') }}日間
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-3 pb-0 sm:pt-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center pb-1">
                                                    <p
                                                        class="w-16 text-center border rounded border-gray-700 py-1 text-gray-800">
                                                        事 由
                                                    </p>
                                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                        {{ __('怪我') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-3 pb-0 sm:pt-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center pb-1">
                                                    <p
                                                        class="w-16 text-center border rounded border-gray-700 py-1 text-gray-800">
                                                        備 考
                                                    </p>
                                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                        {{ __('骨折') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-4 pb-0 flex justify-end">
                                        <table>
                                            <thead class="">
                                                <tr>
                                                    <th
                                                        class="w-16 md:w-20 border border-gray-500 text-gray-900 text-center">
                                                        上長</th>
                                                    <th
                                                        class="w-16 md:w-20 border border-gray-500 text-gray-900 text-center">
                                                        係長</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="w-16 md:w-20 h-12 border border-gray-500 text-center">
                                                    </td>
                                                    <td class="w-16 md:w-20 h-12 border border-gray-500 text-center">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                </ul>
                            </div>

                            <div class="w-full max-w-md mx-auto grid grid-cols-1 gap-2">
                                <div class="flex justify-end">
                                    <x-return-button class="w-30" href="#report-my-index">
                                        {{ __('My申請一覧') }}
                                    </x-return-button>
                                </div>
                                <div class="flex justify-end">
                                    <x-back-home-button class="w-30" href="#base">
                                        {{ __('Back') }}
                                    </x-back-home-button>
                                </div>
                            </div> --}}

                            <div id="approved-show" class="w-full max-w-lg mx-auto pt-8">
                                <p class="text-center text-sky-600 text-2xl font-semibold">承認済み</p>
                            </div>

                            <div
                                class="w-full max-w-md mx-auto mt-6 mb-8 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                <div class="flex items-center justify-between mb-2">
                                    <h5
                                        class="border-solid border-2 px-6 sm:px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                                        出 退 勤 届 け
                                    </h5>
                                    <p
                                        class="border-solid border-2 px-4 py-1 border-sky-500 rounded-md text-md font-medium text-sky-600">
                                        {{ Auth::user()->affiliation->factory->factory_name }}
                                    </p>
                                </div>
                                <p class="text-gray-600 text-sm text-right">{{ Auth::user()->department_group_name }}
                                </p>
                                <div class="flow-root">
                                    <ul role="list" class="divide-y divide-gray-200">
                                        <!-- divide-y アンダーライン仕切り -->
                                        <li class="">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <p class="ZenKurenaido px-2 text-xl font-semibold text-gray-800">
                                                        {{ __('有給休暇') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                            {{ __('Reason') }}
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                            {{ __('その他') }}</p>
                                                    </div>
                                                    <p class="text-sm text-gray-700 truncate px-4 pt-2">
                                                        {{ __('子供の行事') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                            期 間
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                            {{ __('2023-05-02') }}&emsp;
                                                            <span class="ml-4">
                                                                {{ __('1') }}日間
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                            {{ __('Report Date') }}
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                            {{ __('2023-05-01') }}&emsp;
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                            コード
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                            {{ Auth::user()->employee }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                            {{ __('Name') }}
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                            {{ Auth::user()->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <table>
                                                <thead class="">
                                                    <tr>
                                                        <th
                                                            class="w-20 border border-gray-500 text-gray-900 text-center text-sm">
                                                            部長/工場長
                                                        </th>
                                                        <th
                                                            class="w-20 border border-gray-500 text-gray-900 text-center text-sm">
                                                            課長/GL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="w-20 h-12 border border-gray-500 text-center">
                                                            <div class="flex justify-center">
                                                                <x-approved-stamp />
                                                            </div>
                                                        </td>
                                                        <td class="w-20 h-12 border border-gray-500 text-center">
                                                            <div class="flex justify-center">
                                                                <x-approved-stamp />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="w-full max-w-md mx-auto grid grid-cols-1 gap-2">
                                <div class="flex justify-end">
                                    <x-return-button class="w-30 px-4" href="#report-my-index">
                                        {{ __('Report MyIndex') }}
                                    </x-return-button>
                                </div>
                                <div class="flex justify-end">
                                    <x-back-home-button class="w-30" href="#base">
                                        {{ __('Back') }}
                                    </x-back-home-button>
                                </div>
                            </div>

                            {{-- <div
                                class="w-full max-w-lg mx-auto my-4 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 items-center justify-between mb-2">
                                    <h5
                                        class="text-center border-solid border-2 px-6 sm:px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                                        {{ __('有給休暇願') }}
                                    </h5>
                                    <p
                                        class="text-right underline underline-offset-4 border-solid px-4 py-1 border-sky-500 text-md font-medium text-sky-600">
                                        {{ __('終日休') }}
                                    </p>
                                </div>
                                <div class="flex justify-end">
                                    <div></div>
                                    <ul role="list" class="divide-y divide-gray-500">
                                        <li class="text-sm md:text-lg">
                                            &emsp;申請日&emsp;:&emsp;
                                            <span class="ZenKurenaido font-bold text-gray-800 mr-2">
                                                {{ __('2023-05-01') }}&emsp;
                                            </span>
                                        </li>
                                        <li></li>
                                    </ul>
                                </div>

                                <div class="flex justify-between my-4">
                                    <ul class="divide-y divide-gray-500 text-sm md:text-md">
                                        <li class="pt-2">
                                            <div class="ZenKurenaido font-semibold text-gray-800 text-md sm:text-lg">
                                                &emsp;富士善工業株式会社&ensp;御中&emsp;
                                            </div>
                                        </li>
                                        <li class="pt-2">
                                            <div class="flex items-center text-md sm:text-lg">
                                                &emsp;氏 名 &emsp;
                                                <span class="ZenKurenaido font-semibold text-gray-800 mr-2">
                                                    {{ Auth::user()->name }}
                                                </span>
                                            </div>
                                        </li>
                                        <li></li>
                                    </ul>
                                </div>
                                <ul role="list" class="divide-y divide-gray-500 text-sm md:text-lg">
                                    <li class="pt-2 pb-0">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center pb-1">
                                                    <p
                                                        class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                        期 間
                                                    </p>
                                                    <p class="ZenKurenaido font-semibold text-gray-800 ml-4">
                                                        {{ __('2023-05-01') }}
                                                        <span class="font-bold text-gray-800 ml-4">
                                                            {{ __('1') }}日間
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-3 pb-0 sm:pt-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center pb-1">
                                                    <p
                                                        class="w-16 text-center border rounded border-gray-700 py-1 text-gray-800">
                                                        事 由
                                                    </p>
                                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                        {{ __('怪我') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-3 pb-0 sm:pt-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center pb-1">
                                                    <p
                                                        class="w-16 text-center border rounded border-gray-700 py-1 text-gray-800">
                                                        備 考
                                                    </p>
                                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                        {{ __('骨折') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-4 pb-0 flex justify-end">
                                        <table>
                                            <thead class="">
                                                <tr>
                                                    <th
                                                        class="w-16 md:w-20 border border-gray-500 text-gray-900 text-center">
                                                        上長</th>
                                                    <th
                                                        class="w-16 md:w-20 border border-gray-500 text-gray-900 text-center">
                                                        係長</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="w-16 md:w-20 h-12 border border-gray-500 text-center">
                                                        <div class="flex justify-center">
                                                            <x-approved-stamp />
                                                        </div>
                                                    </td>
                                                    <td class="w-16 md:w-20 h-12 border border-gray-500 text-center">
                                                        <div class="flex justify-center">
                                                            <x-approved-stamp />
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                </ul>
                            </div>

                            <div class="w-full max-w-md mx-auto grid grid-cols-1 gap-2 mb-6">
                                <div class="flex justify-end">
                                    <x-return-button class="w-30" href="#report-my-index">
                                        {{ __('My申請一覧') }}
                                    </x-return-button>
                                </div>
                                <div class="flex justify-end">
                                    <x-back-home-button class="w-30" href="#base">
                                        {{ __('Back') }}
                                    </x-back-home-button>
                                </div>
                            </div> --}}
                        </section>

                        <!-- report-my-index -->
                        <div id="report-my-index" class="border-b-2">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">自分の申請を一覧表示
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;提出した申請書は基本メニューの<a href="#base"
                                            class="text-blue-600 hover:underline">My申請一覧</a>から確認できます。一覧は横にスクロールして申請日、状態、休暇種類、休暇期間、休暇日数を確認できます。<br>
                                        &emsp;休暇事由や承認の状態を詳しく確認したいときは、表示ボタンから申請書を表示できます。
                                    </p>
                                </div>
                            </div>

                            <section class="text-gray-600 body-font">
                                <div class="container max-w-5xl md:px-5 py-6 md:py-10 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-10">
                                        <h1 class="sm:text-4xl text-3xl ZenMaruGothic title-font mb-6 text-gray-900">
                                            My申請一覧</h1>
                                        <div class="text-left mx-auto leading-relaxed text-xs md:text-sm mb-1">
                                            <x-info>
                                                <p>
                                                    <span class="text-amber-500">承認待ち</span>の申請は<span
                                                        class="font-bold">編集、取消</span>できます。
                                                </p>
                                            </x-info>
                                            <x-info>
                                                <p>
                                                    <span class="text-sky-500">承認済み</span>の申請は<span
                                                        class="font-bold">修正できません</span>。
                                                    <span class="text-sky-500">承認済み</span>の申請を<span
                                                        class="font-bold">修正する場合は、申請を取消してから再申請</span>してください。
                                                </p>
                                            </x-info>
                                        </div>
                                    </div>

                                    <div class="container max-w-5xl bg-white w-full mx-auto border-2 rounded-lg">
                                        <div class="flex flex-col p-2 md:p-6">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table
                                                            class="min-w-full divide-y divide-gray-200 text-xs md:text-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col"
                                                                        class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('Report Date') }}
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('状 態') }}
                                                                    </th>
                                                                    <th scope="col" colspan="3"
                                                                        class="px-2 py-3 whitespace-nowrap text-right text-xs font-medium text-gray-500 tracking-wider">
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('Report Category') }}
                                                                    </th>
                                                                    <th scope="col" colspan="2"
                                                                        class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('Rest Span') }}
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="w-32 px-2 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('Acquisition Days') }}
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200 ">
                                                                <tr class="hover:bg-gray-100 ">
                                                                    <td
                                                                        class="pl-4 pr-3 py-4 whitespace-nowrap font-medium text-gray-800 ">
                                                                        {{ __('2023-04-20') }}
                                                                    </td>
                                                                    <td
                                                                        class="px-3 py-4 whitespace-nowrap text-center text-gray-800 ">
                                                                        <span class="text-sky-500">承認済み</span>
                                                                    </td>
                                                                    <td
                                                                        class="px-1 py-4 whitespace-nowrap text-gray-800 ">
                                                                        <x-show-a-button href="#approved-show"
                                                                            class="px-3 py-1">
                                                                            {{ __('Show') }}
                                                                        </x-show-a-button>
                                                                    </td>
                                                                    <td
                                                                        class="px-1 py-4 whitespace-nowrap text-gray-800 ">
                                                                    </td>
                                                                    <td
                                                                        class="px-1 py-4 whitespace-nowrap font-medium">
                                                                        <form action="#report-my-index">
                                                                            <x-delete-input-button value="取消申請"
                                                                                onclick="if(!confirm('承認済みの申請を取消しますか？')){return false};" />
                                                                        </form>
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-gray-800 ">
                                                                        {{ __('有給休暇') }}
                                                                        <span class="text-blue-400 text-xs">
                                                                            {{ __('半日休') }}
                                                                        </span>
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-gray-800 ">
                                                                        {{ __('2023-04-20') }}
                                                                    </td>
                                                                    <td
                                                                        class="pr-6 py-4 whitespace-nowrap text-gray-800 ">
                                                                        {{ __('午前') }}
                                                                    </td>
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-right text-gray-800 ">
                                                                        {{ __('4') }} 時間&emsp;
                                                                    </td>
                                                                </tr>
                                                                <tr class="hover:bg-gray-100 ">
                                                                    <td
                                                                        class="pl-4 pr-3 py-4 whitespace-nowrap font-medium text-gray-800 ">
                                                                        {{ __('2023-05-01') }}
                                                                    </td>
                                                                    <td
                                                                        class="px-3 py-4 whitespace-nowrap text-center text-gray-800 ">
                                                                        <span class="text-amber-500">承認待ち</span>
                                                                    </td>
                                                                    <td
                                                                        class="px-1 py-4 whitespace-nowrap text-gray-800 ">
                                                                        <x-show-a-button href="#pending-show"
                                                                            class="px-3 py-1">
                                                                            {{ __('Show') }}
                                                                        </x-show-a-button>
                                                                    </td>
                                                                    <td
                                                                        class="px-1 py-4 whitespace-nowrap text-gray-800 ">
                                                                        <x-edit-a-button href="#report-edit">
                                                                            {{ __('Edit') }}
                                                                        </x-edit-a-button>
                                                                    </td>
                                                                    <td
                                                                        class="px-1 py-4 whitespace-nowrap font-medium">
                                                                        <form action="#report-my-index">
                                                                            <x-delete-input-button value="取消"
                                                                                onclick="if(!confirm('申請を取消しますか？')){return false};" />
                                                                        </form>
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-gray-800 ">
                                                                        {{ __('有給休暇') }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-gray-800 ">
                                                                        {{ __('2023-05-01') }}
                                                                    </td>
                                                                    <td
                                                                        class="pr-6 py-4 whitespace-nowrap text-gray-800 ">
                                                                        {{-- {{ __('2023-05-01') }} --}}
                                                                    </td>
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-right text-gray-800 ">
                                                                        {{ __('1') }} 日&emsp;
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-10 flex justify-end">
                                        <x-back-home-button class="w-30" href="#base">
                                            {{ __('Back') }}
                                        </x-back-home-button>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- report-edit -->
                        <div id="report-edit">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">申請の編集
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;提出した申請書は承認前であれば編集することができます。申請書を編集すると承認はリセットされます。<a
                                            href="#report-my-index"
                                            class="text-blue-600 hover:underline">My申請一覧</a>の一覧から編集したい申請の編集ボタンを選択して申請書編集ページにすすみます。<br>
                                        &emsp;編集が終わったら更新ボタンを押してください。
                                        正しく更新されたときは、<a href="#report-show"
                                            class="text-blue-600 hover:underline">申請書</a>が表示されます。更新できないときは、<a
                                            href="#report-error"
                                            class="text-blue-600 hover:underline">エラーメッセージ</a>が表示されます。
                                        エラーメッセージを確認して、休暇種類を修正してから更新してください。
                                    </p>
                                </div>
                            </div>

                            <section class="text-gray-600 body-font border-b-2">
                                <div class="container w-full md:w-4/5 lg:w-2/3 px-5 py-6 md:py-10 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-12">
                                        <h1 class="sm:text-3xl text-2xl ZenMaruGothic title-font mb-4 text-gray-900">
                                            申請書編集</h1>
                                        <x-info class="mx-auto">
                                            <p class="text-xs md:text-sm">
                                                項目を入力して、<span class="font-bold">更新</span>を押してください。
                                            </p>
                                        </x-info>
                                    </div>

                                    <form action="#report-show">
                                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                                            <div>
                                                <label for="report_date"
                                                    class="block mb-2 text-sm font-medium text-gray-900">
                                                    申請日
                                                </label>
                                                <x-input id="report_date" type="date" class="block mt-1 w-full"
                                                    :value="date('2023-05-01')" readonly />
                                            </div>
                                            <div>
                                                <label for="user_id"
                                                    class="block mb-2 text-sm font-medium text-gray-900">
                                                    氏名
                                                </label>
                                                <x-input id="user_id" type="text" class="block mt-1 w-full"
                                                    :value="Auth::user()->name" readonly />
                                            </div>
                                            <div>
                                                <label for="report_id"
                                                    class="block mb-2 text-sm font-medium text-gray-900">
                                                    休暇種類
                                                </label>
                                                <x-select id="report_id" class="block mt-1 w-full">
                                                    <option>{{ '有給休暇' }}</option>
                                                    <option>{{ 'バースデイ休暇' }}</option>
                                                    <option>{{ '他' }}</option>
                                                </x-select>
                                            </div>
                                            <div>
                                                <p class="block mb-2 text-sm font-medium text-gray-900">
                                                    取得形態
                                                </p>
                                                <div class="flex gap-x-6">
                                                    <div class="flex mt-2">
                                                        <input id="sub_report_id_1" type="radio"
                                                            class="shrink-0 mt-0.5 border-gray-200 rounded-full"
                                                            checked>
                                                        <label for="sub_report_id_1"
                                                            class="mr-2 text-xs md:text-sm text-gray-500 ml-2">
                                                            {{ __('終日休') }}
                                                        </label>
                                                        <input id="sub_report_id_2" type="radio"
                                                            class="shrink-0 mt-0.5 border-gray-200 rounded-full">
                                                        <label for="sub_report_id_2"
                                                            class="mr-2 text-xs md:text-sm text-gray-500 ml-2">
                                                            {{ __('連休') }}
                                                        </label>
                                                        <input id="sub_report_id_3" type="radio"
                                                            class="shrink-0 mt-0.5 border-gray-200 rounded-full">
                                                        <label for="sub_report_id_3"
                                                            class="mr-2 text-xs md:text-sm text-gray-500 ml-2">
                                                            {{ __('半日休') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="start_date"
                                                    class="block mb-2 text-sm font-medium text-gray-900">
                                                    休暇予定日
                                                </label>
                                                <x-input id="start_date" type="date" class="block mt-1 w-full"
                                                    :value="date('2023-05-01')" />
                                            </div>
                                            <div>
                                                <label for="reason_id"
                                                    class="block mb-2 text-sm font-medium text-gray-900">
                                                    事 由
                                                </label>
                                                <x-select id="reason_id" class="block mt-1 w-full">
                                                    <option>
                                                        {{ __('怪我') }}
                                                    </option>
                                                    <option>
                                                        {{ __('その他') }}
                                                    </option>
                                                    <option>
                                                        {{ __('体調不良') }}
                                                    </option>
                                                    <option>
                                                        {{ __('私用') }}
                                                    </option>
                                                </x-select>
                                            </div>
                                            <div>
                                                <label for="reason_detail"
                                                    class="block mb-2 text-sm font-medium text-gray-900">
                                                    事由の詳細・備考
                                                </label>
                                                <x-input id="reason_detail" type="text"
                                                    placeholder="詳細・備考があれば記載してください" class="block mt-1 w-full"
                                                    :value="'骨折'" />
                                            </div>
                                            <!-- 事由 - end -->
                                        </div>

                                        <div class="flex my-6">
                                            <div class="mr-4">
                                                <p class="block mb-2 text-sm font-medium text-gray-900">
                                                    取得日数
                                                </p>
                                                <div class="flex items-center mb-1">
                                                    <x-input id="get_days_only" type="number"
                                                        class="block mt-1 w-14 md:w-20" :value="'1'" readonly />
                                                    <p class="ml-2 text-xs md:text-md">日</p>
                                                </div>
                                                <div class="flex items-center mb-1">
                                                    <x-input id="get_hours" type="number"
                                                        class="block mt-1 w-14 md:w-20" readonly />
                                                    <p class="ml-2 text-xs md:text-md">時間</p>
                                                </div>
                                                <div class="flex items-center">
                                                    <x-input id="get_minutes" type="number"
                                                        class="block mt-1 w-14 md:w-20" readonly />
                                                    <p class="ml-2 text-xs md:text-md">分</p>
                                                </div>
                                            </div>

                                            <div>
                                                <p class="block mb-2 text-sm font-medium text-gray-900">
                                                    残日数
                                                </p>
                                                <div class="flex items-center mb-1">
                                                    <x-input id="remaining_days_only" type="number"
                                                        class="block mt-1 w-14 md:w-20" :value="'19'" readonly />
                                                    <p class="ml-2 text-xs md:text-md">日</p>
                                                </div>
                                                <div class="flex items-center mb-1">
                                                    <x-input id="remaining_hours" type="number"
                                                        class="block mt-1 w-14 md:w-20" readonly />
                                                    <p class="ml-2 text-xs md:text-md">時間</p>
                                                </div>
                                                <div class="flex items-center">
                                                    <x-input id="remaining_minutes" type="number"
                                                        class="block mt-1 w-14 md:w-20" readonly />
                                                    <p class="ml-2 text-xs md:text-md">分</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-row-reverse">
                                            <x-edit-rectangle-button class="w-full">
                                                {{ __('Update') }}
                                            </x-edit-rectangle-button>
                                        </div>
                                    </form>

                                    <div class="mt-10 flex justify-end">
                                        <x-back-home-button class="w-30" href="#base">
                                            {{ __('Back') }}
                                        </x-back-home-button>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- report-delete -->
                        <div id="report-delete" class="border-b-2 pb-6">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">申請の取消
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;提出した申請書は取消することができます。<br>
                                        &emsp;承認前の申請は誰も承認していなければ、すぐに削除されます。承認後の申請は上長と係長の取消確認後に削除されます。<br>
                                        &emsp;申請を取消には、<a href="#report-my-index"
                                            class="text-blue-600 hover:underline">My申請一覧</a>の一覧から取消したい申請の取消ボタンまたは取消申請ボタンを押してください。<br>
                                        &emsp;取消確認が必要な申請書は取消確認中になり、上長と係長の取消確認後に削除されます。
                                    </p>
                                </div>
                            </div>

                            <section class="text-gray-600 body-font">
                                <div class="w-full max-w-lg mx-auto pt-8">
                                    <p class="text-center text-red-600 text-2xl font-semibold">取消確認中</p>
                                </div>

                                <div
                                    class="w-full max-w-md mx-auto mt-6 mb-8 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                    <div class="flex items-center justify-between mb-2">
                                        <h5
                                            class="border-solid border-2 px-6 sm:px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                                            出 退 勤 届 け
                                        </h5>
                                        <p
                                            class="border-solid border-2 px-4 py-1 border-sky-500 rounded-md text-md font-medium text-sky-600">
                                            {{ Auth::user()->affiliation->factory->factory_name }}
                                        </p>
                                    </div>
                                    <p class="text-gray-600 text-sm text-right">
                                        {{ Auth::user()->department_group_name }}
                                    </p>
                                    <div class="flow-root">
                                        <ul role="list" class="divide-y divide-gray-200">
                                            <!-- divide-y アンダーライン仕切り -->
                                            <li class="">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <p
                                                            class="ZenKurenaido px-2 text-xl font-semibold text-gray-800">
                                                            {{ __('有給休暇') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                {{ __('Reason') }}
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ __('その他') }}</p>
                                                        </div>
                                                        <p class="text-sm text-gray-700 truncate px-4 pt-2">
                                                            {{ __('子供の行事') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                期 間
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ __('2023-05-02') }}&emsp;
                                                                <span class="ml-4">
                                                                    {{ __('1') }}日間
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                {{ __('Report Date') }}
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ __('2023-05-01') }}&emsp;
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                コード
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ Auth::user()->employee }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                {{ __('Name') }}
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ Auth::user()->name }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <table>
                                                    <thead class="">
                                                        <tr>
                                                            <th
                                                                class="w-20 border border-gray-500 text-gray-900 text-center text-sm">
                                                                部長/工場長
                                                            </th>
                                                            <th
                                                                class="w-20 border border-gray-500 text-gray-900 text-center text-sm">
                                                                課長/GL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-20 h-12 border border-gray-500 text-center">
                                                                <div class="flex justify-center">
                                                                    <x-approved-stamp />
                                                                </div>
                                                            </td>
                                                            <td class="w-20 h-12 border border-gray-500 text-center">
                                                                <div class="flex justify-center">
                                                                    <x-cancel-stamp />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="w-full max-w-md mx-auto grid grid-cols-1 gap-2">
                                    <div class="flex justify-end">
                                        <x-return-button class="w-30 px-4" href="#report-my-index">
                                            {{ __('Report MyIndex') }}
                                        </x-return-button>
                                    </div>
                                    <div class="flex justify-end">
                                        <x-back-home-button class="w-30" href="#base">
                                            {{ __('Back') }}
                                        </x-back-home-button>
                                    </div>
                                </div>

                                {{-- <div
                                    class="w-full max-w-lg mx-auto my-4 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                    <div
                                        class="grid grid-cols-1 gap-2 sm:grid-cols-2 items-center justify-between mb-2">
                                        <h5
                                            class="text-center border-solid border-2 px-6 sm:px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                                            {{ __('有給休暇願') }}
                                        </h5>
                                        <p
                                            class="text-right underline underline-offset-4 border-solid px-4 py-1 border-sky-500 text-md font-medium text-sky-600">
                                            {{ __('終日休') }}
                                        </p>
                                    </div>
                                    <div class="flex justify-end">
                                        <div></div>
                                        <ul role="list" class="divide-y divide-gray-500">
                                            <li class="text-sm md:text-lg">
                                                &emsp;申請日&emsp;:&emsp;
                                                <span class="ZenKurenaido font-bold text-gray-800 mr-2">
                                                    {{ __('2023-05-01') }}&emsp;
                                                </span>
                                            </li>
                                            <li></li>
                                        </ul>
                                    </div>

                                    <div class="flex justify-between my-4">
                                        <ul class="divide-y divide-gray-500 text-sm md:text-md">
                                            <li class="pt-2">
                                                <div
                                                    class="ZenKurenaido font-semibold text-gray-800 text-md sm:text-lg">
                                                    &emsp;富士善工業株式会社&ensp;御中&emsp;
                                                </div>
                                            </li>
                                            <li class="pt-2">
                                                <div class="flex items-center text-md sm:text-lg">
                                                    &emsp;氏 名 &emsp;
                                                    <span class="ZenKurenaido font-semibold text-gray-800 mr-2">
                                                        {{ Auth::user()->name }}
                                                    </span>
                                                </div>
                                            </li>
                                            <li></li>
                                        </ul>
                                    </div>
                                    <ul role="list" class="divide-y divide-gray-500 text-sm md:text-lg">
                                        <li class="pt-2 pb-0">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                            期 間
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-800 ml-4">
                                                            {{ __('2023-05-01') }}
                                                            <span class="font-bold text-gray-800 ml-4">
                                                                {{ __('1') }}日間
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-gray-800">
                                                            事 由
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                            {{ __('怪我') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-3 pb-0 sm:pt-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center pb-1">
                                                        <p
                                                            class="w-16 text-center border rounded border-gray-700 py-1 text-gray-800">
                                                            備 考
                                                        </p>
                                                        <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                            {{ __('骨折') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="pt-4 pb-0 flex justify-end">
                                            <table>
                                                <thead class="">
                                                    <tr>
                                                        <th
                                                            class="w-16 md:w-20 border border-gray-500 text-gray-900 text-center">
                                                            上長</th>
                                                        <th
                                                            class="w-16 md:w-20 border border-gray-500 text-gray-900 text-center">
                                                            係長</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            class="w-16 md:w-20 h-12 border border-gray-500 text-center">
                                                            <div class="flex justify-center">
                                                                <x-approved-stamp />
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="w-16 md:w-20 h-12 border border-gray-500 text-center">
                                                            <div class="flex justify-center">
                                                                <x-cancel-stamp />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </li>
                                    </ul>
                                </div>

                                <div class="w-full max-w-md mx-auto grid grid-cols-1 gap-2 mb-6">
                                    <div class="flex justify-end">
                                        <x-return-button class="w-30" href="#report-my-index">
                                            {{ __('My申請一覧') }}
                                        </x-return-button>
                                    </div>
                                    <div class="flex justify-end">
                                        <x-back-home-button class="w-30" href="#base">
                                            {{ __('Back') }}
                                        </x-back-home-button>
                                    </div>
                                </div> --}}
                            </section>
                        </div>

                        <!-- remaining-my-index -->
                        <div id="remaining-my-index" class="border-b-2">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">
                                        休暇日数の確認
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;休暇の取得日数と残日数を確認できます。有給休暇の取得推進日数を確認して計画的に休暇を取得しましょう。
                                    </p>
                                </div>
                            </div>

                            <section class="text-gray-600 body-font">
                                <div class="container max-w-xl px-5 py-6 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-4">
                                        <h1 class="sm:text-3xl text-2xl ZenMaruGothic title-font mb-4 text-gray-900">
                                            休暇日数</h1>
                                        <div class="text-left mx-auto leading-relaxed text-xs md:text-sm mb-1">
                                            <x-info>
                                                <p class="">
                                                    <span
                                                        class="font-semibold">{{ Auth::user()->name }}さん</span>の休暇日数です。
                                                </p>
                                            </x-info>
                                            <x-info>
                                                <p class="">
                                                    有給休暇の取得推進日数はあと<span
                                                        class="font-semibold text-red-500">3日</span>です。
                                                </p>
                                            </x-info>
                                        </div>
                                    </div>
                                </div>

                                <div class="container max-w-xl bg-white w-full mx-auto border-2 rounded-lg">
                                    <div class="flex flex-col p-2 sm:p-8">
                                        <div class="-m-1.5 overflow-x-auto">
                                            <div class="p-1.5 min-w-full inline-block align-middle">
                                                <div class="overflow-hidden">
                                                    <table class="min-w-full divide-y divide-gray-200 ">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col"
                                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                                    名 称</th>
                                                                <th scope="col"
                                                                    class="px-2 pt-3 pb-1 text-center text-xs font-medium text-gray-500 uppercase">
                                                                    <p class="font-semibold">{{ __('残日数') }}
                                                                    </p>
                                                                    <p class="text-blue-400 text-xs">
                                                                        {{ __('申請中') }}</p>
                                                                </th>
                                                                <th scope="col"
                                                                    class="pr-2 pt-3 pb-1 text-center text-xs font-medium text-gray-500 uppercase">
                                                                    <p class="font-semibold">{{ __('取得日数') }}
                                                                    </p>
                                                                    <p class="text-blue-400 text-xs">
                                                                        {{ __('申請中') }}</p>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="divide-y divide-gray-200">
                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                    {{ __('有給休暇') }}
                                                                </td>
                                                                <td
                                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                                    {{ Str::limit('有給休暇', 15) }}
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('19') }} 日
                                                                    </span>
                                                                    <p class="text-blue-400 text-xs">
                                                                        {{ __('18') }} 日
                                                                        {{-- &ensp;{{ __('4') }} 時間 --}}
                                                                    </p>
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('1') }} 日
                                                                    </span>
                                                                    <p class="text-blue-400 text-xs">
                                                                        {{ __('1') }} 日
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                    {{ __('バースデイ休暇') }}
                                                                </td>
                                                                <td
                                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                                    {{ Str::limit('バースデイ休暇', 15) }}
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('1') }} 日
                                                                    </span>
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('0') }} 日
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                    {{ __('慶事休暇(結婚・本人)') }}
                                                                </td>
                                                                <td
                                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                                    {{ Str::limit('慶事休暇(結婚・本人)', 15) }}
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('7') }} 日
                                                                    </span>
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('0') }} 日
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                    {{ __('慶事休暇(結婚・子)') }}
                                                                </td>
                                                                <td
                                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                                    {{ Str::limit('慶事休暇(結婚・子)', 15) }}
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('3') }} 日
                                                                    </span>
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('0') }} 日
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                    {{ __('慶事休暇(結婚・兄弟姉妹)') }}
                                                                </td>
                                                                <td
                                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                                    {{ Str::limit('慶事休暇(結婚・兄弟姉妹)', 15) }}
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('1') }} 日
                                                                    </span>
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('0') }} 日
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                    {{ __('慶事休暇(配偶者の出産)') }}
                                                                </td>
                                                                <td
                                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                                    {{ Str::limit('慶事休暇(配偶者の出産)', 15) }}
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('3') }} 日
                                                                    </span>
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('0') }} 日
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                    {{ __('弔事休暇(死亡・父母、配偶者、子)') }}
                                                                </td>
                                                                <td
                                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                                    {{ Str::limit('弔事休暇(死亡・父母、配偶者、子)', 15) }}
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('5') }} 日
                                                                    </span>
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('0') }} 日
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                    {{ __('弔事休暇(死亡・祖父母、配偶者の父母、兄弟、孫)') }}
                                                                </td>
                                                                <td
                                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                                    {{ Str::limit('弔事休暇(死亡・祖父母、配偶者の父母、兄弟、孫)', 15) }}
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('3') }} 日
                                                                    </span>
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('0') }} 日
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                    {{ __('弔事休暇(死亡・伯叔父母、甥、姪)') }}
                                                                </td>
                                                                <td
                                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                                    {{ Str::limit('弔事休暇(死亡・伯叔父母、甥、姪)', 15) }}
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('1') }} 日
                                                                    </span>
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('0') }} 日
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                    {{ __('弔事休暇(法事)') }}
                                                                </td>
                                                                <td
                                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                                    {{ Str::limit('弔事休暇(法事)', 15) }}
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('1') }} 日
                                                                    </span>
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    <span class=" font-bold">
                                                                        {{ __('0') }} 日
                                                                    </span>
                                                                </td>
                                                            </tr>

                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="hidden md:block pl-4 pr-2 py-3 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                    {{ __('育児休業') }}
                                                                </td>
                                                                <td
                                                                    class="block md:hidden pl-4 pr-2 py-3 whitespace-nowrap text-xs font-medium text-gray-800 ">
                                                                    {{ Str::limit('育児休業', 15) }}
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                </td>
                                                                <td
                                                                    class="px-4 pt-3 pb-1 whitespace-nowrap text-right text-sm font-medium">
                                                                    ※
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container max-w-xl px-5 pb-6 mx-auto">
                                    <div class="mx-auto my-6">
                                        <div class="text-left mx-auto leading-relaxed text-xs md:text-sm mb-1">
                                            <x-info>
                                                <p>
                                                    育児休業は<span class="font-bold">1歳に満たない子</span>を扶養する者が取得できます。
                                                </p>
                                            </x-info>
                                            <x-info>
                                                <p>
                                                    休暇制度の詳細は総務課にお問い合わせください。
                                                </p>
                                            </x-info>
                                        </div>
                                    </div>

                                    <div class="flex justify-end">
                                        <x-back-home-button class="w-30" href="#base">
                                            {{ __('Back') }}
                                        </x-back-home-button>
                                    </div>
                            </section>
                        </div>

                        @can('approver_reader')
                            <!-- approval -->
                            <div id="approval" class="border-b-2">
                                <h3 class="mt-2 text-lg font-semibold">承認機能</h3>
                                <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                    <div class="pt-2">
                                        <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                            tabindex="0">承認と取消確認の通知
                                        </h2>
                                        <p class="mt-2 text-sm text-gray-600">
                                            &emsp;承認権限のあるユーザーのホーム画面には、申請に対する承認と取消確認の通知が表示されます。<br>
                                            &emsp;通知があるときは、<a href="#report-index"
                                                class="text-blue-600 hover:underline">申請一覧</a>から承認する申請書を表示して承認します。
                                        </p>
                                    </div>
                                </div>

                                <div class="border-b-2 border-gray-200">
                                    <nav class="py-1 px-2 sm:px-6 -mb-0.5">
                                        <!-- 有休残日数 -->
                                        <x-info class="py-1">
                                            <p class="text-sm">
                                                有給休暇残日数:
                                                <span class="font-bold">
                                                    20
                                                </span> 日
                                                <span class="font-bold">
                                                    4
                                                </span> 時間
                                            </p>
                                        </x-info>
                                    </nav>
                                </div>

                                <!-- 通知機能 閲覧権限以上 start -->
                                <div
                                    class="m-2 bg-red-50 border border-red-200 text-xs md:text-sm text-red-600 rounded-md px-4 py-2">
                                    <div class="flex m-1">
                                        <span class="font-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-4 h-4 md:w-5 md:h-5 mr-2">
                                                <path
                                                    d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                                                <path fill-rule="evenodd"
                                                    d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                        <span class="font-bold">{{ '1' }}件</span>の<span
                                            class="font-bold">承認待</span>があります
                                    </div>
                                    <div class="flex m-1">
                                        <span class="font-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-4 h-4 md:w-5 md:h-5 mr-2">
                                                <path
                                                    d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                                                <path fill-rule="evenodd"
                                                    d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                        <span class="font-bold">{{ '1' }}件</span>の<span
                                            class="font-bold">取消確認</span>があります
                                    </div>
                                </div>
                                <!-- 通知機能 閲覧権限以上 end -->

                                <section class="text-gray-600 body-font">
                                    <div class="container w-3/4 py-8 mx-auto">
                                        <!-- 基本機能 start -->
                                        <div class="max-w-md mx-auto grid grid-cols-1 mb-10">
                                            <a href="#report-create"
                                                class="block text-center items-center p-3 my-2 text-white rounded-xl border border-gray-500 bg-cyan-500 hover:text-gray-600 hover:bg-white focus:text-cyan-500 ">
                                                <div class="flex justify-center items-center text-2xl">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" class="w-6 h-6">
                                                        <path
                                                            d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                                        <path
                                                            d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"
                                                            fill="" />
                                                    </svg>
                                                    <span class="ZenMaruGothic w-40">届 出 作 成</span>
                                                </div>
                                            </a>

                                            <a href="#remaining-my-index"
                                                class="block text-center items-center p-3 my-2 text-white rounded-xl border border-gray-500 bg-fuchsia-400 hover:text-gray-600 hover:bg-white focus:text-fuchsia-400">
                                                <div class="flex justify-center items-center text-2xl">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" class="w-6 h-6">
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

                                            <a href="#report-my-index"
                                                class="block text-center items-center p-3 my-2 text-white rounded-xl border border-gray-500 bg-amber-400 hover:text-gray-600 hover:bg-white focus:text-amber-400">
                                                <div class="flex justify-center items-center text-2xl">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" class="w-6 h-6">
                                                        <path fill-rule="evenodd"
                                                            d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                                            clip-rule="evenodd" fill="" />
                                                    </svg>
                                                    <span class="ZenMaruGothic w-40">My届出一覧</span>
                                                </div>
                                            </a>
                                        </div>

                                        {{-- <div class="max-w-md mx-auto grid grid-cols-1 mb-4 md:mb-10">
                                        <a href="#report-create"
                                            class="block text-center items-center p-3 my-2 rounded-xl border border-gray-500 bg-cyan-400 hover:text-gray-600 hover:bg-white focus:text-cyan-400 ">
                                            <div class="flex justify-center items-center text-2xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="w-6 h-6">
                                                    <path
                                                        d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                                    <path
                                                        d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"
                                                        fill="" />
                                                </svg>
                                                <span class="ZenMaruGothic w-40">申請書作成</span>
                                            </div>
                                        </a>

                                        <a href="#remaining-my-index"
                                            class="block text-center items-center p-3 my-2 rounded-xl border border-gray-500 bg-fuchsia-300 hover:text-gray-600 hover:bg-white focus:text-fuchsia-300">
                                            <div class="flex justify-center items-center text-2xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5zm6.61 10.936a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                        clip-rule="evenodd" />
                                                    <path
                                                        d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"
                                                        fill="" />
                                                </svg>
                                                <span class="ZenMaruGothic w-40">休 暇 日 数</span>
                                            </div>
                                        </a>

                                        <a href="#report-my-index"
                                            class="block text-center items-center p-3 my-2 rounded-xl border border-gray-500 bg-amber-300 hover:text-gray-600 hover:bg-white focus:text-amber-300">
                                            <div class="flex justify-center items-center text-2xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                                        clip-rule="evenodd" fill="" />
                                                </svg>
                                                <span class="ZenMaruGothic w-40">My申請一覧</span>
                                            </div>
                                        </a>
                                    </div> --}}
                                        <!-- 基本機能 end -->

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                            <!-- 承認,閲覧 start -->
                                            <a href="#report-index"
                                                class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                                                <span class="mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                    </svg>
                                                </span>
                                                <span class="flex items-center w-24">
                                                    申請一覧
                                                </span>
                                                <div class="flex justify-center relative -ml-4 -mt-5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" class="w-6 h-6 text-red-600">
                                                        <path fill-rule="evenodd"
                                                            d="M5.337 21.718a6.707 6.707 0 01-.533-.074.75.75 0 01-.44-1.223 3.73 3.73 0 00.814-1.686c.023-.115-.022-.317-.254-.543C3.274 16.587 2.25 14.41 2.25 12c0-5.03 4.428-9 9.75-9s9.75 3.97 9.75 9c0 5.03-4.428 9-9.75 9-.833 0-1.643-.097-2.417-.279a6.721 6.721 0 01-4.246.997z"
                                                            clip-rule="evenodd" fill="" />
                                                    </svg>
                                                    <div
                                                        class="absolute text-xs text-white font-bold leading-6 text-center">
                                                        {{ '2' }}
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="#get-and-remaining"
                                                class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                                                <span class="mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                                    </svg>
                                                </span>
                                                <span class="w-32">休暇取得状況</span>
                                            </a>

                                            <a href="#export"
                                                class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                                                <span class="mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                                    </svg>
                                                </span>
                                                <span class="w-32">エクスポート</span>
                                            </a>
                                            <!-- 承認,閲覧 end -->
                                        </div>
                                </section>
                            </div>

                            <!-- report-index -->
                            <div id="report-index" class="border-b-2">
                                <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                    <div class="mt-2">
                                        <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                            tabindex="0">部署内の申請を一覧表示
                                        </h2>
                                        <p class="mt-2 text-sm text-gray-600">
                                            &emsp;承認または閲覧権限のあるユーザーは、権限の範囲内のメンバーの申請を確認できます。メンバーの申請書はメニューの<a
                                                href="#approval"
                                                class="text-blue-600 hover:underline">申請一覧</a>から確認できます。一覧は横にスクロールして申請日、状態、申請者、休暇種類、休暇期間、休暇日数を確認できます。<br>
                                            &emsp;承認や取消確認は、表示ボタンで申請書を表示して承認します。
                                        </p>
                                    </div>
                                </div>
                                <section class="text-gray-600 body-font">
                                    <div class="container max-w-7xl md:px-5 py-6 md:py-10 mx-auto">
                                        <div class="flex flex-col text-center w-full mb-10">
                                            <h1 class="sm:text-4xl text-3xl ZenMaruGothic title-font text-gray-900">申請一覧
                                            </h1>
                                        </div>

                                        <div class="container max-w-7xl bg-white border-2 rounded-lg">
                                            <div class="flex flex-col p-2 md:p-6">
                                                <div class="-m-1.5 overflow-x-auto">
                                                    <div class="p-1.5 min-w-full inline-block align-middle">
                                                        <div class="overflow-hidden">
                                                            <table
                                                                class="min-w-full divide-y divide-gray-200 text-xs md:text-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col"
                                                                            class="py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                            {{ __('Report Date') }}
                                                                        </th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 whitespace-nowrap text-right text-xs font-medium text-gray-500 tracking-wider">
                                                                            {{ __('状 態') }}
                                                                        </th>
                                                                        <th scope="col"
                                                                            class="px-4 py-3 whitespace-nowrap text-right text-xs font-medium text-gray-500 tracking-wider">
                                                                        </th>
                                                                        <th scope="col" colspan="2"
                                                                            class="pl-4 pr-1 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                            {{ __('申請者') }}
                                                                        </th>
                                                                        <th scope="col"
                                                                            class="pl-4 pr-1 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                            {{ __('所 属') }}
                                                                        </th>
                                                                        <th scope="col"
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                            {{ __('Report Category') }}
                                                                        </th>
                                                                        <th scope="col" colspan="2"
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                            {{ __('Rest Span') }}
                                                                        </th>
                                                                        <th scope="col"
                                                                            class="w-32 px-2 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                            {{ __('Acquisition Days') }}
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="divide-y divide-gray-200 ">
                                                                    <tr class="hover:bg-gray-100 ">
                                                                        <td
                                                                            class="px-2 md:px-4 py-4 whitespace-nowrap font-medium text-gray-800 ">
                                                                            {{ __('2023-04-20') }}
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-4 text-center whitespace-nowrap text-gray-800 ">
                                                                            <span class="text-red-500">取消確認中</span>
                                                                        </td>
                                                                        <td
                                                                            class="flex px-2 py-4 whitespace-nowrap text-gray-800 ">
                                                                            <x-show-a-button href="#report-cancel-check"
                                                                                class="px-3 py-1">
                                                                                {{ __('Show') }}
                                                                            </x-show-a-button>
                                                                            <div class="mt-2 -ml-2 text-red-700">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 20 20"
                                                                                    fill="currentColor" class="w-5 h-5">
                                                                                    <path fill-rule="evenodd"
                                                                                        d="M10 1a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 1zM5.05 3.05a.75.75 0 011.06 0l1.062 1.06A.75.75 0 116.11 5.173L5.05 4.11a.75.75 0 010-1.06zm9.9 0a.75.75 0 010 1.06l-1.06 1.062a.75.75 0 01-1.062-1.061l1.061-1.06a.75.75 0 011.06 0zM3 8a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 013 8zm11 0a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 0114 8zm-6.828 2.828a.75.75 0 010 1.061L6.11 12.95a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zm3.594-3.317a.75.75 0 00-1.37.364l-.492 6.861a.75.75 0 001.204.65l1.043-.799.985 3.678a.75.75 0 001.45-.388l-.978-3.646 1.292.204a.75.75 0 00.74-1.16l-3.874-5.764z"
                                                                                        clip-rule="evenodd" />
                                                                                </svg>
                                                                            </div>
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-4 whitespace-nowrap text-center text-gray-800 ">
                                                                            {{ '1000' }}
                                                                        </td>
                                                                        <td
                                                                            class="pl-1 pr-4 py-4 whitespace-nowrap text-gray-800 ">
                                                                            {{ '長島 秋休' }}
                                                                        </td>
                                                                        <td
                                                                            class="pl-4 pr-1 py-4 whitespace-nowrap text-gray-800 ">
                                                                            {{ '第一製造部' }}
                                                                            {{ '精密板金課' }}
                                                                        </td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-gray-800 ">
                                                                            {{ __('有給休暇') }}
                                                                            <span class="text-blue-400 text-xs">
                                                                                {{ __('半日休') }}
                                                                            </span>
                                                                        </td>
                                                                        <td
                                                                            class="pl-6 py-4 whitespace-nowrap text-gray-800 ">
                                                                            {{ __('2023-04-20') }}
                                                                        </td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-gray-800 ">
                                                                            {{ __('午前') }}
                                                                        </td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-gray-800 ">
                                                                            {{ __('4') }} 時間&emsp;
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="hover:bg-gray-100 ">
                                                                        <td
                                                                            class="px-2 md:px-4 py-4 whitespace-nowrap font-medium text-gray-800 ">
                                                                            {{ __('2023-05-01') }}
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-4 text-center whitespace-nowrap text-gray-800 ">
                                                                            <span class="text-amber-500">承認待ち</span>
                                                                        </td>
                                                                        <td
                                                                            class="flex px-2 py-4 whitespace-nowrap text-gray-800 ">
                                                                            <x-show-a-button href="#report-approval"
                                                                                class="px-3 py-1">
                                                                                {{ __('Show') }}
                                                                            </x-show-a-button>
                                                                            <div class="mt-2 -ml-2 text-red-700">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    viewBox="0 0 20 20"
                                                                                    fill="currentColor" class="w-5 h-5">
                                                                                    <path fill-rule="evenodd"
                                                                                        d="M10 1a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 1zM5.05 3.05a.75.75 0 011.06 0l1.062 1.06A.75.75 0 116.11 5.173L5.05 4.11a.75.75 0 010-1.06zm9.9 0a.75.75 0 010 1.06l-1.06 1.062a.75.75 0 01-1.062-1.061l1.061-1.06a.75.75 0 011.06 0zM3 8a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 013 8zm11 0a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5A.75.75 0 0114 8zm-6.828 2.828a.75.75 0 010 1.061L6.11 12.95a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zm3.594-3.317a.75.75 0 00-1.37.364l-.492 6.861a.75.75 0 001.204.65l1.043-.799.985 3.678a.75.75 0 001.45-.388l-.978-3.646 1.292.204a.75.75 0 00.74-1.16l-3.874-5.764z"
                                                                                        clip-rule="evenodd" />
                                                                                </svg>
                                                                            </div>
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-4 whitespace-nowrap text-center text-gray-800 ">
                                                                            {{ '2000' }}
                                                                        </td>
                                                                        <td
                                                                            class="pl-1 pr-4 py-4 whitespace-nowrap text-gray-800 ">
                                                                            {{ '長島 島子' }}
                                                                        </td>
                                                                        <td
                                                                            class="pl-4 pr-1 py-4 whitespace-nowrap text-gray-800 ">
                                                                            {{ '第二製造部' }}
                                                                            {{ '総務課' }}
                                                                        </td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-gray-800 ">
                                                                            {{ __('有給休暇') }}
                                                                        </td>
                                                                        <td
                                                                            class="pl-6 py-4 whitespace-nowrap text-gray-800 ">
                                                                            {{ __('2023-05-01') }}
                                                                        </td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-gray-800 ">
                                                                        </td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-gray-800 ">
                                                                            {{ __('1') }} 日&emsp;
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-10 flex justify-end">
                                            <x-back-home-button class="w-30" href="#approval">
                                                {{ __('Back') }}
                                            </x-back-home-button>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>

                        <!-- report-approval -->
                        <div id="report-approval" class="border-b-2">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">申請を承認する
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;申請を承認するときはメニューの<a href="#report-index"
                                            class="text-blue-600 hover:underline">申請一覧</a>から承認する申請書を表示して、承認ボタンで承認します。
                                    </p>
                                </div>
                            </div>

                            <section class="text-gray-600 body-font pb-6">
                                <div class="w-full max-w-lg mx-auto pt-8">
                                    <p class="text-center text-amber-500 text-2xl font-semibold">承認中</p>
                                </div>

                                <div
                                    class="w-full max-w-md mx-auto mt-6 mb-8 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                    <div class="flex items-center justify-between mb-2">
                                        <h5
                                            class="border-solid border-2 px-6 sm:px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                                            出 退 勤 届 け
                                        </h5>
                                        <p
                                            class="border-solid border-2 px-4 py-1 border-sky-500 rounded-md text-md font-medium text-sky-600">
                                            {{ Auth::user()->affiliation->factory->factory_name }}
                                        </p>
                                    </div>
                                    <p class="text-gray-600 text-sm text-right">
                                        {{ Auth::user()->department_group_name }}
                                    </p>
                                    <div class="flow-root">
                                        <ul role="list" class="divide-y divide-gray-200">
                                            <!-- divide-y アンダーライン仕切り -->
                                            <li class="">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <p class="ZenKurenaido px-2 text-xl font-semibold text-gray-800">
                                                            {{ __('有給休暇') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                {{ __('Reason') }}
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ __('その他') }}</p>
                                                        </div>
                                                        <p class="text-sm text-gray-700 truncate px-4 pt-2">
                                                            {{ __('子供の行事') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                期 間
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ __('2023-05-02') }}&emsp;
                                                                <span class="ml-4">
                                                                    {{ __('1') }}日間
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                {{ __('Report Date') }}
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ __('2023-05-01') }}&emsp;
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                コード
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ Auth::user()->employee }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                {{ __('Name') }}
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ Auth::user()->name }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <table>
                                                    <thead class="">
                                                        <tr>
                                                            <th
                                                                class="w-20 border border-gray-500 text-gray-900 text-center text-sm">
                                                                部長/工場長
                                                            </th>
                                                            <th
                                                                class="w-20 border border-gray-500 text-gray-900 text-center text-sm">
                                                                課長/GL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-20 h-12 border border-gray-500 text-center">
                                                            </td>
                                                            <td class="w-20 h-12 border border-gray-500 text-center">
                                                                <x-edit-a-button href="#report-approval"
                                                                    onclick="if(!confirm('承認しますか？')){return false};"
                                                                    class="px-3 py-1">
                                                                    {{ __('Approval') }}
                                                                </x-edit-a-button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="w-full max-w-md mx-auto grid grid-cols-1 gap-2">
                                    <div class="flex justify-end">
                                        <x-return-button class="w-30 px-4" href="#report-my-index">
                                            {{ __('Report MyIndex') }}
                                        </x-return-button>
                                    </div>
                                    <div class="flex justify-end">
                                        <x-back-home-button class="w-30" href="#base">
                                            {{ __('Back') }}
                                        </x-back-home-button>
                                    </div>
                                </div>

                                {{-- <div
                                class="w-full max-w-lg mx-auto my-4 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 items-center justify-between mb-2">
                                    <h5
                                        class="text-center border-solid border-2 px-6 sm:px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                                        {{ __('有給休暇願') }}
                                    </h5>
                                    <p
                                        class="text-right underline underline-offset-4 border-solid px-4 py-1 border-sky-500 text-md font-medium text-sky-600">
                                        {{ __('終日休') }}
                                    </p>
                                </div>
                                <div class="flex justify-end">
                                    <div></div>
                                    <ul role="list" class="divide-y divide-gray-500">
                                        <li class="text-sm md:text-lg">
                                            &emsp;申請日&emsp;:&emsp;
                                            <span class="ZenKurenaido font-bold text-gray-800 mr-2">
                                                {{ __('2023-05-01') }}&emsp;
                                            </span>
                                        </li>
                                        <li></li>
                                    </ul>
                                </div>

                                <div class="flex justify-between my-4">
                                    <ul class="divide-y divide-gray-500 text-sm md:text-md">
                                        <li class="pt-2">
                                            <div class="ZenKurenaido font-semibold text-gray-800 text-md sm:text-lg">
                                                &emsp;富士善工業株式会社&ensp;御中&emsp;
                                            </div>
                                        </li>
                                        <li class="pt-2">
                                            <div class="flex items-center text-md sm:text-lg">
                                                &emsp;氏 名 &emsp;
                                                <span class="ZenKurenaido font-semibold text-gray-800 mr-2">
                                                    {{ '長島 島子' }}
                                                </span>
                                            </div>
                                        </li>
                                        <li></li>
                                    </ul>
                                </div>
                                <ul role="list" class="divide-y divide-gray-500 text-sm md:text-lg">
                                    <li class="pt-2 pb-0">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center pb-1">
                                                    <p
                                                        class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                        期 間
                                                    </p>
                                                    <p class="ZenKurenaido font-semibold text-gray-800 ml-4">
                                                        {{ __('2023-05-01') }}
                                                        <span class="font-bold text-gray-800 ml-4">
                                                            {{ __('1') }}日間
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-3 pb-0 sm:pt-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center pb-1">
                                                    <p
                                                        class="w-16 text-center border rounded border-gray-700 py-1 text-gray-800">
                                                        事 由
                                                    </p>
                                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                        {{ __('怪我') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-3 pb-0 sm:pt-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center pb-1">
                                                    <p
                                                        class="w-16 text-center border rounded border-gray-700 py-1 text-gray-800">
                                                        備 考
                                                    </p>
                                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                        {{ __('骨折') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-4 pb-0 flex justify-end">
                                        <table>
                                            <thead class="">
                                                <tr>
                                                    <th
                                                        class="w-16 md:w-20 border border-gray-500 text-gray-900 text-center">
                                                        上長</th>
                                                    <th
                                                        class="w-16 md:w-20 border border-gray-500 text-gray-900 text-center">
                                                        係長</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="w-16 md:w-20 h-12 border border-gray-500 text-center">
                                                    </td>
                                                    <td class="w-16 md:w-20 h-12 border border-gray-500 text-center">
                                                        <div class="flex justify-center">
                                                            <x-edit-a-button href="#report-approval"
                                                                dusk='approval2-button'
                                                                onclick="if(!confirm('承認しますか？')){return false};"
                                                                class="text-xs md:text-md px-2 md:px-3 py-1">
                                                                {{ __('Approval') }}
                                                            </x-edit-a-button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                </ul>
                            </div>

                            <div class="w-full max-w-md mx-auto grid grid-cols-1 gap-2 mb-6">
                                <div class="flex justify-end">
                                    <x-return-button class="w-30" href="#report-my-index">
                                        {{ __('My申請一覧') }}
                                    </x-return-button>
                                </div>
                                <div class="flex justify-end">
                                    <x-back-home-button class="w-30" href="#approval">
                                        {{ __('Back') }}
                                    </x-back-home-button>
                                </div>
                            </div> --}}
                            </section>
                        </div>

                        <!-- report-cant-approval -->
                        <div id="report-cant-approval" class="border-b-2">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">承認したくないときは
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;承認したくないときや休暇日の調整が必要なときは、申請者と話し合って<a href="#report-edit"
                                            class="text-blue-600 hover:underline">申請を修正</a>してもらうか<a
                                            href="#report-delete" class="text-blue-600 hover:underline">取消</a>してもらいましょう。
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- report-cancel-check -->
                        <div id="report-cancel-check" class="border-b-2 pb-6">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">取消申請の確認
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;取消申請の確認は承認と同様に、メニューの<a href="#report-index"
                                            class="text-blue-600 hover:underline">申請一覧</a>から取消確認する申請書を表示して、取消確認ボタンで承認を取消します。
                                    </p>
                                </div>
                            </div>

                            <section class="text-gray-600 body-font">
                                <div class="w-full max-w-lg mx-auto pt-8">
                                    <p class="text-center text-red-600 text-2xl font-semibold">取消確認中</p>
                                </div>

                                <div
                                    class="w-full max-w-md mx-auto mt-6 mb-8 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                    <div class="flex items-center justify-between mb-2">
                                        <h5
                                            class="border-solid border-2 px-6 sm:px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                                            出 退 勤 届 け
                                        </h5>
                                        <p
                                            class="border-solid border-2 px-4 py-1 border-sky-500 rounded-md text-md font-medium text-sky-600">
                                            {{ Auth::user()->affiliation->factory->factory_name }}
                                        </p>
                                    </div>
                                    <p class="text-gray-600 text-sm text-right">
                                        {{ Auth::user()->department_group_name }}
                                    </p>
                                    <div class="flow-root">
                                        <ul role="list" class="divide-y divide-gray-200">
                                            <!-- divide-y アンダーライン仕切り -->
                                            <li class="">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <p class="ZenKurenaido px-2 text-xl font-semibold text-gray-800">
                                                            {{ __('有給休暇') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                {{ __('Reason') }}
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ __('その他') }}</p>
                                                        </div>
                                                        <p class="text-sm text-gray-700 truncate px-4 pt-2">
                                                            {{ __('子供の行事') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                期 間
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ __('2023-05-02') }}&emsp;
                                                                <span class="ml-4">
                                                                    {{ __('1') }}日間
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                {{ __('Report Date') }}
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ __('2023-05-01') }}&emsp;
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                コード
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ Auth::user()->employee }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center pb-1">
                                                            <p
                                                                class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                                {{ __('Name') }}
                                                            </p>
                                                            <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                                {{ Auth::user()->name }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="pt-3 pb-0 sm:pt-4">
                                                <table>
                                                    <thead class="">
                                                        <tr>
                                                            <th
                                                                class="w-20 border border-gray-500 text-gray-900 text-center text-sm">
                                                                部長/工場長
                                                            </th>
                                                            <th
                                                                class="w-20 border border-gray-500 text-gray-900 text-center text-sm">
                                                                課長/GL</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-20 h-12 border border-gray-500 text-center">
                                                                <x-delete-a-button href="#report-cant-approval"
                                                                    onclick="if(!confirm('取消を確認しました')){return false};"
                                                                    class="px-1 py-1">
                                                                    {{ __('CancelCheck') }}
                                                                </x-delete-a-button>
                                                            </td>
                                                            <td class="w-20 h-12 border border-gray-500 text-center">
                                                                <div class="flex justify-center">
                                                                    <x-cancel-stamp />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="w-full max-w-md mx-auto grid grid-cols-1 gap-2">
                                    <div class="flex justify-end">
                                        <x-return-button class="w-30 px-4" href="#report-my-index">
                                            {{ __('Report MyIndex') }}
                                        </x-return-button>
                                    </div>
                                    <div class="flex justify-end">
                                        <x-back-home-button class="w-30" href="#base">
                                            {{ __('Back') }}
                                        </x-back-home-button>
                                    </div>
                                </div>

                                {{-- <div
                                class="w-full max-w-lg mx-auto my-4 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 items-center justify-between mb-2">
                                    <h5
                                        class="text-center border-solid border-2 px-6 sm:px-10 py-2 border-gray-500 rounded-md text-xl font-bold leading-none text-gray-900">
                                        {{ __('有給休暇願') }}
                                    </h5>
                                    <p
                                        class="text-right underline underline-offset-4 border-solid px-4 py-1 border-sky-500 text-md font-medium text-sky-600">
                                        {{ __('終日休') }}
                                    </p>
                                </div>
                                <div class="flex justify-end">
                                    <div></div>
                                    <ul role="list" class="divide-y divide-gray-500">
                                        <li class="text-sm md:text-lg">
                                            &emsp;申請日&emsp;:&emsp;
                                            <span class="ZenKurenaido font-bold text-gray-800 mr-2">
                                                {{ __('2023-05-01') }}&emsp;
                                            </span>
                                        </li>
                                        <li></li>
                                    </ul>
                                </div>

                                <div class="flex justify-between my-4">
                                    <ul class="divide-y divide-gray-500 text-sm md:text-md">
                                        <li class="pt-2">
                                            <div class="ZenKurenaido font-semibold text-gray-800 text-md sm:text-lg">
                                                &emsp;富士善工業株式会社&ensp;御中&emsp;
                                            </div>
                                        </li>
                                        <li class="pt-2">
                                            <div class="flex items-center text-md sm:text-lg">
                                                &emsp;氏 名 &emsp;
                                                <span class="ZenKurenaido font-semibold text-gray-800 mr-2">
                                                    {{ '長島 秋休' }}
                                                </span>
                                            </div>
                                        </li>
                                        <li></li>
                                    </ul>
                                </div>
                                <ul role="list" class="divide-y divide-gray-500 text-sm md:text-lg">
                                    <li class="pt-2 pb-0">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center pb-1">
                                                    <p
                                                        class="w-16 text-center border rounded border-gray-700 py-1 text-md text-gray-800">
                                                        期 間
                                                    </p>
                                                    <p class="ZenKurenaido font-semibold text-gray-800 ml-4">
                                                        {{ __('2023-05-01') }}
                                                        <span class="font-bold text-gray-800 ml-4">
                                                            {{ __('1') }}日間
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-3 pb-0 sm:pt-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center pb-1">
                                                    <p
                                                        class="w-16 text-center border rounded border-gray-700 py-1 text-gray-800">
                                                        事 由
                                                    </p>
                                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                        {{ __('怪我') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-3 pb-0 sm:pt-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center pb-1">
                                                    <p
                                                        class="w-16 text-center border rounded border-gray-700 py-1 text-gray-800">
                                                        備 考
                                                    </p>
                                                    <p class="ZenKurenaido font-semibold text-gray-700 ml-4">
                                                        {{ __('骨折') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="pt-4 pb-0 flex justify-end">
                                        <table>
                                            <thead class="">
                                                <tr>
                                                    <th
                                                        class="w-16 md:w-20 border border-gray-500 text-gray-900 text-center">
                                                        上長</th>
                                                    <th
                                                        class="w-16 md:w-20 border border-gray-500 text-gray-900 text-center">
                                                        係長</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="w-16 md:w-20 h-12 border border-gray-500 text-center">
                                                        <x-delete-a-button href="#report-cant-approval"
                                                            onclick="if(!confirm('取消を確認しました')){return false};"
                                                            class="text-xs md:text-md px-1 py-1">
                                                            {{ __('CancelCheck') }}
                                                        </x-delete-a-button>
                                                    </td>
                                                    <td class="w-16 md:w-20 h-12 border border-gray-500 text-center">
                                                        <div class="flex justify-center">
                                                            <x-cancel-stamp />
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </li>
                                </ul>
                            </div>

                            <div class="w-full max-w-md mx-auto grid grid-cols-1 gap-2 mb-6">
                                <div class="flex justify-end">
                                    <x-return-button class="w-30" href="#report-my-index">
                                        {{ __('My申請一覧') }}
                                    </x-return-button>
                                </div>
                                <div class="flex justify-end">
                                    <x-back-home-button class="w-30" href="#approval">
                                        {{ __('Back') }}
                                    </x-back-home-button>
                                </div>
                            </div> --}}
                            </section>
                        </div>

                        <!-- achievement -->
                        <div id="achievement" class="border-b-2">
                            <h3 class="text-lg font-semibold">実績確認機能</h3>
                            <div id="get-and-remaining"
                                class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">メンバーの休暇日数の確認</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;承認または閲覧権限のあるユーザーは、権限の範囲内のメンバーの休暇の取得状況を確認できます。
                                        ナビゲーションバーから確認したい休暇の種類を選択するとメンバーの取得日数と残日数を確認できます。
                                    </p>
                                </div>
                            </div>

                            <!-- Page nav -->
                            <div class="border-b-2 border-gray-200">
                                <nav class="px-4 -mb-0.5 flex space-x-2 overflow-x-auto">
                                    <x-nav-button>
                                        {{ __('有給休暇') }}
                                    </x-nav-button>
                                    <x-nav-button>
                                        {{ __('バースデイ休暇') }}
                                    </x-nav-button>
                                    <x-nav-button>
                                        {{ __('欠勤') }}
                                    </x-nav-button>
                                    <x-nav-button>
                                        {{ __('遅刻') }}
                                    </x-nav-button>
                                    <x-nav-button>
                                        {{ __('早退') }}
                                    </x-nav-button>
                                    <x-nav-button>
                                        {{ __('外出') }}
                                    </x-nav-button>
                                </nav>
                            </div>
                            <section class="text-gray-600 body-font">
                                <div class="container max-w-3xl md:px-5 py-6 md:py-10 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-2 md:mb-6">
                                        <h1 class="sm:text-4xl text-3xl ZenMaruGothic title-font mb-4 text-gray-900">
                                            休暇取得状況</h1>
                                        <p id="report_name-1" style="display: "
                                            class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                                            有給休暇
                                        </p>
                                    </div>

                                    <div class="container max-w-3xl bg-white w-full mx-auto border-2 rounded-lg">
                                        <div class="flex flex-col p-2 md:p-6">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table class="mx-auto divide-y divide-gray-200 ">
                                                            <thead>
                                                                <tr>
                                                                    <th
                                                                        class="w-32 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('所 属') }}
                                                                    </th>
                                                                    <th
                                                                        class="w-24 px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('社 員') }}
                                                                    </th>
                                                                    <th
                                                                        class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('取得日数') }}
                                                                    </th>
                                                                    <th id="bar_title" style="display: "></th>
                                                                    <th id="remaining_title" style="display: "
                                                                        class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('残日数') }}
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200 ">
                                                                <tr>
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ '第一製造部' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '1000' }}&ensp;
                                                                        {{ '長島 秋休' }}</td>
                                                                    <td
                                                                        class="pl-4 pr-2 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        <div style="display: ">
                                                                            {{ '1' }}日&ensp;{{ '4' }}時間
                                                                        </div>
                                                                    </td>
                                                                    <td style="display: ">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" fill="currentColor"
                                                                            class="w-5 h-6">
                                                                            <path fill-rule="evenodd"
                                                                                d="M10.5 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                    </td>
                                                                    <td id="remaining_data" style="display: "
                                                                        class="px-2 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        <div style="display: ">
                                                                            {{ '18' }}日&ensp;{{ '4' }}時間
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ '第二製造部' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '2000' }}&ensp;
                                                                        {{ '長島 島子' }}</td>
                                                                    <td
                                                                        class="pl-4 pr-2 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        <div style="display: ">
                                                                            {{ '16' }}日
                                                                        </div>
                                                                    </td>
                                                                    <td style="display: ">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" fill="currentColor"
                                                                            class="w-5 h-6">
                                                                            <path fill-rule="evenodd"
                                                                                d="M10.5 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                    </td>
                                                                    <td id="remaining_data" style="display: "
                                                                        class="px-2 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        <div style="display: ">
                                                                            {{ '12' }}日
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ '第二製造部' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '2222' }}&ensp;
                                                                        {{ '長島 美楽乃' }}</td>
                                                                    <td
                                                                        class="pl-4 pr-2 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        <div style="display: ">
                                                                            {{ '3' }}日
                                                                        </div>
                                                                    </td>
                                                                    <td style="display: ">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" fill="currentColor"
                                                                            class="w-5 h-6">
                                                                            <path fill-rule="evenodd"
                                                                                d="M10.5 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                    </td>
                                                                    <td id="remaining_data" style="display: "
                                                                        class="px-2 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        <div style="display: ">
                                                                            {{ '14' }}日
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ '第二製造部' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '3000' }}&ensp;
                                                                        {{ '長島 利休' }}</td>
                                                                    <td
                                                                        class="pl-4 pr-2 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        <div style="display: ">
                                                                            {{ '3' }}日
                                                                        </div>
                                                                    </td>
                                                                    <td style="display: ">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" fill="currentColor"
                                                                            class="w-5 h-6">
                                                                            <path fill-rule="evenodd"
                                                                                d="M10.5 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                    </td>
                                                                    <td id="remaining_data" style="display: "
                                                                        class="px-2 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        <div style="display: ">
                                                                            {{ '30' }}日
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-10 flex justify-end">
                                        <x-back-home-button class="w-30" href="#approval">
                                            {{ __('Back') }}
                                        </x-back-home-button>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- export -->
                        <div id="export" class="border-b-2">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">一覧のエクスポート</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;承認または閲覧権限のあるユーザーは<span class="font-bold">承認済みの</span>休暇申請をエクセルで出力できます。
                                        部署や休暇種類などで検索できます。
                                    </p>
                                </div>
                            </div>

                            <div class="border-b-2 border-gray-200">
                                <nav class="-mb-0.5 px-4 py-1 flex space-x-3 overflow-x-auto">
                                    <!-- 所属選択 - start -->
                                    <x-select id="factory_id" class="block text-xs w-40">
                                        <option value=''>部署</option>
                                        <option value=''>全て</option>
                                        <option>
                                            {{ '第一製造部' }}
                                        </option>
                                        <option>
                                            {{ '第二製造部' }}
                                        </option>
                                    </x-select>
                                    <x-select id="department_id" class="block text-xs w-40">
                                        <option value=''>グループ</option>
                                        <option value=''>全て</option>
                                        <option>
                                            {{ 'グループ1' }}
                                        </option>
                                        <option>
                                            {{ 'グループ2' }}
                                        </option>
                                    </x-select>
                                    <!-- 休暇種類選択 - start -->
                                    <x-select id="report_id" class="block text-xs w-40">
                                        <option value=''>休暇種類</option>
                                        <option value=''>全て</option>
                                        <option>
                                            {{ '有給休暇' }}
                                        </option>
                                        <option>
                                            {{ 'バースデイ休暇' }}
                                        </option>
                                        <option>
                                            {{ '欠勤' }}
                                        </option>
                                        <option>
                                            {{ '他' }}
                                        </option>
                                    </x-select>
                                    <!-- 理由選択 - start -->
                                    <x-select id="reason_id" class="block text-xs w-40">
                                        <option value=''>事由</option>
                                        <option value=''>全て</option>
                                        <option>
                                            {{ '私用' }}
                                        </option>
                                        <option>
                                            {{ '体調不良' }}
                                        </option>
                                        <option>
                                            {{ '誕生日' }}
                                        </option>
                                        <option>
                                            {{ '他' }}
                                        </option>
                                    </x-select>
                                    <!-- 取得日選択 - start -->
                                    <x-input id="get_date" type="month" class="block text-xs" />
                                </nav>
                            </div>

                            <section class="text-gray-600 body-font">
                                <div class="container max-w-7xl md:px-5 py-6 md:py-10 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-10">
                                        <h1 class="sm:text-4xl text-3xl font-medium title-font text-gray-900">
                                            {{ __('出力内容') }}</h1>
                                    </div>

                                    <div class="container max-w-7xl bg-white w-full mx-auto border-2 rounded-lg">
                                        <div class="flex flex-col p-2 md:p-6">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table class="min-w-full divide-y divide-gray-200 ">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col"
                                                                        class="pl-4 pr-1 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('所 属') }}
                                                                    </th>
                                                                    <th scope="col" colspan="2"
                                                                        class="pl-4 pr-1 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('申請者') }}
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('Report Category') }}
                                                                    </th>
                                                                    <th scope="col" colspan="2"
                                                                        class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('Lest Span') }}
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-2 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('日数・時間') }}
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('Report Date') }}
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('Reason') }}
                                                                    </th>
                                                                    <th scope="col"
                                                                        class="px-4 py-3 whitespace-nowrap text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200 ">
                                                                <tr style="display:" class="hover:bg-gray-100 ">
                                                                    <td
                                                                        class="pl-4 pr-1 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '第二製造部' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-2 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '2222' }}
                                                                    </td>
                                                                    <td
                                                                        class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '長島 美楽乃' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '有給休暇' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ __('2023-05-01') }}
                                                                    </td>
                                                                    <td
                                                                        class="pr-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                    </td>
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        {{ '1' }} 日&emsp;
                                                                        {{-- {{ '4' }} 時間 --}}
                                                                        {{-- {{ '30' }} 分 --}}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ __('2023-05-01') }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ '体調不良' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ '二日酔い' }}
                                                                    </td>
                                                                </tr>
                                                                <tr style="display:" class="hover:bg-gray-100 ">
                                                                    <td
                                                                        class="pl-4 pr-1 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '第二製造部' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-2 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '2222' }}
                                                                    </td>
                                                                    <td
                                                                        class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '長島 美し楽' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ 'バースデイ休暇' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ __('2023-06-06') }}
                                                                    </td>
                                                                    <td
                                                                        class="pr-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{-- ~&emsp;&emsp;{{ $report->end_date }}
                                                                        ~&emsp;&emsp;{{ Str::substr($report->end_time, 0, 5) }}
                                                                        {{ $report->am_pm == 1 ? '午 前' : '午 後' }} --}}
                                                                    </td>
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        {{ '1' }} 日&emsp;
                                                                        {{-- {{ '4' }} 時間 --}}
                                                                        {{-- {{ '30' }} 分 --}}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ __('2023-05-01') }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ '誕生日' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ '' }}
                                                                    </td>
                                                                </tr>
                                                                <tr style="display:" class="hover:bg-gray-100 ">
                                                                    <td
                                                                        class="pl-4 pr-1 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '第三製造部' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-2 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '3000' }}
                                                                    </td>
                                                                    <td
                                                                        class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '長島 利休' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ '遅刻' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{ __('2023-03-03') }}
                                                                        &emsp;{{ '8:00' }}
                                                                    </td>
                                                                    <td
                                                                        class="pr-6 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        {{-- ~&emsp;&emsp;{{ $report->end_date }} --}}
                                                                        ~&emsp;&emsp;{{ '8:30' }}
                                                                        {{-- {{ $report->am_pm == 1 ? '午 前' : '午 後' }} --}}
                                                                    </td>
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        {{-- {{ '1' }} 日&emsp; --}}
                                                                        {{-- {{ '4' }} 時間 --}}
                                                                        {{ '30' }} 分
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ __('2023-03-03') }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ 'その他' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 ">
                                                                        {{ '寝坊' }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full mx-auto mt-4 grid grid-cols-1 gap-2">
                                        <div class="flex justify-end mb-4">
                                            <form action="#export">
                                                <div class="flex flex-row-reverse">
                                                    <x-button class="w-full flex">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="currentColor" class="w-5 h-5 mr-2 leading-6">
                                                            <path fill-rule="evenodd"
                                                                d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zm5.845 17.03a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V12a.75.75 0 00-1.5 0v4.19l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3z"
                                                                clip-rule="evenodd" />
                                                            <path
                                                                d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z" />
                                                        </svg>
                                                        {{ __('エクスポート') }}
                                                    </x-button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="flex justify-end">
                                            <x-back-home-button class="w-30" href="#approval">
                                                {{ __('Back') }}
                                            </x-back-home-button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    @endcan

                    @can('admin')
                        <!-- admin -->
                        <div id="admin" class="border-b-2">
                            <h3 class="mt-2 text-lg font-semibold">管理機能</h3>
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="pt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">管理機能
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;管理者権限のあるユーザーのホーム画面には、管理メニューとして<a href="#remaining-update"
                                            class="text-blue-600 hover:underline">休暇日数の設定</a>、<a href="#user-update"
                                            class="text-blue-600 hover:underline">ユーザー設定</a>、<a href="#approval-update"
                                            class="text-blue-600 hover:underline">権限設定</a>が表示されます。<br>
                                        &emsp;管理メニューは休暇の残日数の変更、ユーザーの所属部署の変更、権限の追加、変更、削除ができます。<br>
                                        &emsp;ユーザーの追加や削除、残日数の変更など、与える影響が大きいものは<a href="#approval-info"
                                            class="text-blue-600 hover:underline">全体管理者</a>だけが設定できます。
                                    </p>
                                </div>
                            </div>

                            <div class="border-b-2 border-gray-200">
                                <nav class="py-1 px-2 sm:px-6 -mb-0.5">
                                    <!-- 有休残日数 -->
                                    <x-info class="py-1">
                                        <p class="text-sm">
                                            有給休暇残日数:
                                            <span class="font-bold">
                                                20
                                            </span> 日
                                            <span class="font-bold">
                                                4
                                            </span> 時間
                                        </p>
                                    </x-info>
                                </nav>
                            </div>


                            <section class="text-gray-600 body-font">
                                <div class="container w-3/4 py-8 mx-auto">
                                    <!-- 基本機能 start -->
                                    <div class="max-w-md mx-auto grid grid-cols-1 mb-10">
                                        <a href="#report-create"
                                            class="block text-center items-center p-3 my-2 text-white rounded-xl border border-gray-500 bg-cyan-500 hover:text-gray-600 hover:bg-white focus:text-cyan-500 ">
                                            <div class="flex justify-center items-center text-2xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="w-6 h-6">
                                                    <path
                                                        d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                                    <path
                                                        d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"
                                                        fill="" />
                                                </svg>
                                                <span class="ZenMaruGothic w-40">届 出 作 成</span>
                                            </div>
                                        </a>

                                        <a href="#remaining-my-index"
                                            class="block text-center items-center p-3 my-2 text-white rounded-xl border border-gray-500 bg-fuchsia-400 hover:text-gray-600 hover:bg-white focus:text-fuchsia-400">
                                            <div class="flex justify-center items-center text-2xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="w-6 h-6">
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

                                        <a href="#report-my-index"
                                            class="block text-center items-center p-3 my-2 text-white rounded-xl border border-gray-500 bg-amber-400 hover:text-gray-600 hover:bg-white focus:text-amber-400">
                                            <div class="flex justify-center items-center text-2xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                                        clip-rule="evenodd" fill="" />
                                                </svg>
                                                <span class="ZenMaruGothic w-40">My届出一覧</span>
                                            </div>
                                        </a>
                                    </div>

                                    {{-- <div class="max-w-md mx-auto grid grid-cols-1 mb-4 md:mb-10">
                                    <a href="#report-create"
                                        class="block text-center items-center p-3 my-2 rounded-xl border border-gray-500 bg-cyan-400 hover:text-gray-600 hover:bg-white focus:text-cyan-400 ">
                                        <div class="flex justify-center items-center text-2xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6">
                                                <path
                                                    d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                                <path
                                                    d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"
                                                    fill="" />
                                            </svg>
                                            <span class="ZenMaruGothic w-40">申請書作成</span>
                                        </div>
                                    </a>

                                    <a href="#remainig-my-index"
                                        class="block text-center items-center p-3 my-2 rounded-xl border border-gray-500 bg-fuchsia-300 hover:text-gray-600 hover:bg-white focus:text-fuchsia-300">
                                        <div class="flex justify-center items-center text-2xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd"
                                                    d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5zm6.61 10.936a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                    clip-rule="evenodd" />
                                                <path
                                                    d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"
                                                    fill="" />
                                            </svg>
                                            <span class="ZenMaruGothic w-40">休 暇 日 数</span>
                                        </div>
                                    </a>

                                    <a href="#report-my-index"
                                        class="block text-center items-center p-3 my-2 rounded-xl border border-gray-500 bg-amber-300 hover:text-gray-600 hover:bg-white focus:text-amber-300">
                                        <div class="flex justify-center items-center text-2xl">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd"
                                                    d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 18.375V5.625zM21 9.375A.375.375 0 0020.625 9h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zm0 3.75a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 00.375-.375v-1.5zM10.875 18.75a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375h7.5zM3.375 15h7.5a.375.375 0 00.375-.375v-1.5a.375.375 0 00-.375-.375h-7.5a.375.375 0 00-.375.375v1.5c0 .207.168.375.375.375zm0-3.75h7.5a.375.375 0 00.375-.375v-1.5A.375.375 0 0010.875 9h-7.5A.375.375 0 003 9.375v1.5c0 .207.168.375.375.375z"
                                                    clip-rule="evenodd" fill="" />
                                            </svg>
                                            <span class="ZenMaruGothic w-40">My申請一覧</span>
                                        </div>
                                    </a>
                                </div> --}}
                                    <!-- 基本機能 end -->

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                        <!-- 承認,閲覧 start -->
                                        <a href="#report-index"
                                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                                            <span class="mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>
                                            </span>
                                            <span class="flex items-center w-24">
                                                申請一覧
                                            </span>
                                        </a>

                                        <a href="#get-and-remaining"
                                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                                            <span class="mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                                </svg>
                                            </span>
                                            <span class="w-32">休暇取得状況</span>
                                        </a>

                                        <a href="#export"
                                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                                            <span class="mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                                </svg>
                                            </span>
                                            <span class="w-32">エクスポート</span>
                                        </a>
                                        <!-- 承認,閲覧 end -->
                                        <!-- 管理者 start -->
                                        <a href="#remaining-update"
                                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                                            <span class="mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                                </svg>
                                            </span>
                                            <span class="w-32">休暇日数の設定</span>
                                        </a>

                                        <a href="#user-update"
                                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                                            <span class="mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                                </svg>
                                            </span>
                                            <span class="w-32">ユーザー設定</span>
                                        </a>

                                        <a href="#approval-info"
                                            class="inline-flex items-center p-2 text-lg font-medium text-gray-600 hover:text-sky-700 hover:underline hover:underline-offset-0 hover:decoration-4 hover:decoration-sky-200">
                                            <span class="mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </span>
                                            <span class="w-32">権限設定</span>
                                        </a>
                                    </div>
                            </section>
                        </div>

                        <!-- remaining-update -->
                        <div id="remaining-update" class="border-b-2">
                            <div id="remaining-index"
                                class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">休暇日数を設定する</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;<a href="#approval_info"
                                            class="text-blue-600 hover:underline">全体管理者</a>は、休暇の残日数を修正できます。<br>
                                        &emsp;残日数の管理は申請と承認で自動的に更新されますが、変更が必要になときは<a href="#remaining-update"
                                            class="text-blue-600 hover:underline">休暇日数の設定</a>から休暇取得状況にすすみます。<br>
                                        &emsp;ナビゲーションバーから修正したい休暇の種類を選択し、編集するユーザーの編集ボタンを押して<a href="#remaining-edit"
                                            class="text-blue-600 hover:underline">残日数の編集</a>にすすみ、日数を変更して更新ボタンを押します。
                                    </p>
                                </div>
                            </div>

                            <!-- Page nav -->
                            <div class="border-b-2 border-gray-200">
                                <nav class="px-4 -mb-0.5 flex space-x-2 overflow-x-auto">
                                    <x-nav-button>
                                        {{ __('有給休暇') }}
                                    </x-nav-button>
                                    <x-nav-button>
                                        {{ __('バースデイ休暇') }}
                                    </x-nav-button>
                                    <x-nav-button>
                                        {{ __('欠勤') }}
                                    </x-nav-button>
                                    <x-nav-button>
                                        {{ __('遅刻') }}
                                    </x-nav-button>
                                    <x-nav-button>
                                        {{ __('早退') }}
                                    </x-nav-button>
                                    <x-nav-button>
                                        {{ __('外出') }}
                                    </x-nav-button>
                                </nav>
                            </div>
                            <section class="text-gray-600 body-font">
                                <div class="container max-w-3xl md:px-5 py-8 md:py-16 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-2 md:mb-6">
                                        <h1 class="sm:text-4xl text-3xl ZenMaruGothic title-font mb-4 text-gray-900">
                                            休暇取得状況</h1>
                                        <p class="lg:w-2/3 mx-auto mb-2 text-lg leading-relaxed">
                                            有給休暇
                                        </p>
                                        {{-- <h2 class="text-right">
                                        <a href="#remaining-all-update"
                                            class="inline-flex items-center justify-center text-base mr-2 -mt-8 font-medium text-green-800 hover:text-green-50 p-1 rounded-full border-2 border-green-800 bg-green-100/60 hover:bg-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd"
                                                    d="M12 5.25c1.213 0 2.415.046 3.605.135a3.256 3.256 0 013.01 3.01c.044.583.077 1.17.1 1.759L17.03 8.47a.75.75 0 10-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 00-1.06-1.06l-1.752 1.751c-.023-.65-.06-1.296-.108-1.939a4.756 4.756 0 00-4.392-4.392 49.422 49.422 0 00-7.436 0A4.756 4.756 0 003.89 8.282c-.017.224-.033.447-.046.672a.75.75 0 101.497.092c.013-.217.028-.434.044-.651a3.256 3.256 0 013.01-3.01c1.19-.09 2.392-.135 3.605-.135zm-6.97 6.22a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l1.752-1.751c.023.65.06 1.296.108 1.939a4.756 4.756 0 004.392 4.392 49.413 49.413 0 007.436 0 4.756 4.756 0 004.392-4.392c.017-.223.032-.447.046-.672a.75.75 0 00-1.497-.092c-.013.217-.028.434-.044.651a3.256 3.256 0 01-3.01 3.01 47.953 47.953 0 01-7.21 0 3.256 3.256 0 01-3.01-3.01 47.759 47.759 0 01-.1-1.759L6.97 15.53a.75.75 0 001.06-1.06l-3-3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </h2> --}}
                                        <h2 class="text-right">
                                            <x-circle-button href="#remaining-all-update">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M12 5.25c1.213 0 2.415.046 3.605.135a3.256 3.256 0 013.01 3.01c.044.583.077 1.17.1 1.759L17.03 8.47a.75.75 0 10-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 00-1.06-1.06l-1.752 1.751c-.023-.65-.06-1.296-.108-1.939a4.756 4.756 0 00-4.392-4.392 49.422 49.422 0 00-7.436 0A4.756 4.756 0 003.89 8.282c-.017.224-.033.447-.046.672a.75.75 0 101.497.092c.013-.217.028-.434.044-.651a3.256 3.256 0 013.01-3.01c1.19-.09 2.392-.135 3.605-.135zm-6.97 6.22a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l1.752-1.751c.023.65.06 1.296.108 1.939a4.756 4.756 0 004.392 4.392 49.413 49.413 0 007.436 0 4.756 4.756 0 004.392-4.392c.017-.223.032-.447.046-.672a.75.75 0 00-1.497-.092c-.013.217-.028.434-.044.651a3.256 3.256 0 01-3.01 3.01 47.953 47.953 0 01-7.21 0 3.256 3.256 0 01-3.01-3.01 47.759 47.759 0 01-.1-1.759L6.97 15.53a.75.75 0 001.06-1.06l-3-3z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </x-circle-button>
                                        </h2>
                                    </div>

                                    <div class="container max-w-2xl bg-white w-full mx-auto border-2 rounded-lg">
                                        <div class="flex flex-col p-2 md:p-6 mx-auto">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table class="mx-auto divide-y divide-gray-200">
                                                            <thead>
                                                                <tr>
                                                                    <th
                                                                        class="w-24 px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('所 属') }}
                                                                    </th>
                                                                    <th colspan="2"
                                                                        class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('社員名') }}
                                                                    </th>
                                                                    <th id="remaining_title" style="display: "
                                                                        class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('残日数') }}
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200">
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                                                                        {{ '第一製造部' }}
                                                                    </td>
                                                                    <td
                                                                        class="pl-4 py-4 whitespace-nowrap text-sm text-center text-gray-800">
                                                                        {{ '1000' }}</td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-left text-gray-800">
                                                                        {{ '長島 秋休' }}</td>
                                                                    <td id="remaining_data"
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        <div>
                                                                            {{ '18' }}日&ensp;{{ '4' }}時間
                                                                        </div>
                                                                    </td>
                                                                    <td
                                                                        class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        <div>
                                                                            <x-show-a-button href="#remaining-edit"
                                                                                class="px-3 py-1">
                                                                                {{ __('Edit') }}
                                                                            </x-show-a-button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                                                                        {{ '第二製造部' }}
                                                                    </td>
                                                                    <td
                                                                        class="pl-4 py-4 whitespace-nowrap text-sm text-center text-gray-800">
                                                                        {{ '2000' }}</td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-left text-gray-800">
                                                                        {{ '長島 島子' }}</td>
                                                                    <td id="remaining_data"
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        <div>
                                                                            {{ '16' }}日&ensp;{{ '4' }}時間
                                                                        </div>
                                                                    </td>
                                                                    <td
                                                                        class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        <div>
                                                                            <x-show-a-button href="#remaining-edit"
                                                                                class="px-3 py-1">
                                                                                {{ __('Edit') }}
                                                                            </x-show-a-button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                                                                        {{ '第二製造部' }}
                                                                    </td>
                                                                    <td
                                                                        class="pl-4 py-4 whitespace-nowrap text-sm text-center text-gray-800">
                                                                        {{ '2222' }}</td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-left text-gray-800">
                                                                        {{ '長島 美楽乃' }}</td>
                                                                    <td id="remaining_data"
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        <div>
                                                                            {{ '14' }}日&ensp;{{ '4' }}時間
                                                                        </div>
                                                                    </td>
                                                                    <td
                                                                        class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        <div>
                                                                            <x-show-a-button href="#remaining-edit"
                                                                                class="px-3 py-1">
                                                                                {{ __('Edit') }}
                                                                            </x-show-a-button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-xs font-medium text-gray-800">
                                                                        {{ '第三製造部' }}
                                                                    </td>
                                                                    <td
                                                                        class="pl-4 py-4 whitespace-nowrap text-sm text-center text-gray-800">
                                                                        {{ '3000' }}</td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-left text-gray-800">
                                                                        {{ '長島 利休' }}</td>
                                                                    <td id="remaining_data"
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-right text-gray-800 ">
                                                                        <div>
                                                                            {{ '33' }}日&ensp;{{ '4' }}時間
                                                                        </div>
                                                                    </td>
                                                                    <td
                                                                        class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800 ">
                                                                        <div>
                                                                            <x-show-a-button href="#remaining-edit"
                                                                                class="px-3 py-1">
                                                                                {{ __('Edit') }}
                                                                            </x-show-a-button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-10 flex justify-end">
                                        <x-back-home-button class="w-30" href="#admin">
                                            {{ __('Back') }}
                                        </x-back-home-button>
                                    </div>
                                </div>
                            </section>

                            <section id="remaining-edit" class="text-gray-600 body-font">
                                <div class="container dm:px-5 py-8 md:py-16 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-10">
                                        <h1 class="sm:text-3xl text-2xl ZenMaruGothic title-font mb-4 text-gray-900">
                                            残日数の修正</h1>
                                        <x-info class="mx-auto">
                                            <p class="text-xs md:text-sm">
                                                休暇の<span class="font-semibold">残日数</span>を変更できます。
                                            </p>
                                        </x-info>
                                    </div>

                                    <div class="container max-w-4xl bg-white w-full mx-auto border-2 rounded-lg">
                                        <div class="flex flex-col p-2 md:p-8">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table
                                                            class="min-w-full divide-y divide-gray-200 text-xs md:text-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                                        {{ __('社員名') }}</th>
                                                                    <th scope="col"
                                                                        class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                                        {{ __('休暇種類') }}</th>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                                        {{ __('残日数') }}</th>
                                                                    <th scope="col"
                                                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200">
                                                                <tr class="hover:bg-gray-100">
                                                                    <td
                                                                        class="px-4 py-3 whitespace-nowrap text-center font-medium text-gray-800">
                                                                        {{ '1000' }}
                                                                        {{ '水島寒月' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-3 whitespace-nowrap text-center font-medium text-gray-800">
                                                                        {{ '有給休暇' }}
                                                                    </td>
                                                                    <form action="#remaining-update">
                                                                        <td
                                                                            class="px-4 py-3 whitespace-nowrap text-center font-medium">
                                                                            <x-input id="remaining_days" type="number"
                                                                                min="0"
                                                                                class="inline h-8 mt-1 w-20"
                                                                                :value="'18'" />
                                                                            日
                                                                            <x-input id="remaining_hours" type="number"
                                                                                max="7" min="0"
                                                                                class="inline h-8 mt-1 w-20"
                                                                                :value="'4'" />
                                                                            時間
                                                                        </td>
                                                                        <td
                                                                            class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                                            <x-edit-button>
                                                                                {{ __('Update') }}
                                                                            </x-edit-button>
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
                                            <x-return-button class="absolute inset-y-0 right-0"
                                                href="#remaining-update">
                                                {{ __('一覧へ戻る') }}
                                            </x-return-button>
                                        </div>
                                        <div class="relative w-30 h-8">
                                            <x-back-home-button class="absolute inset-y-0 right-0" href="#admin">
                                                {{ __('Back') }}
                                            </x-back-home-button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- remaining-all-update -->
                        <div id="remaining-all-update" class="border-b-2">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">有給休暇を一括更新する</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;有給休暇を勤続年数に応じて一括で更新します。
                                        更新基準日(年度初めの日付)を選択して更新ボタンをおしてください。
                                        一括更新の取消しはできません。
                                    </p>
                                </div>
                            </div>

                            <section class="text-gray-600 body-font">
                                <div class="container w-full md:w-2/3 px-5 py-8 md:py-16 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-12">
                                        <h1 class="text-lg sm:text-2xl ZenMaruGothic title-font mb-4 text-gray-900">
                                            有給休暇残日数の更新</h1>
                                        <div class="text-left mx-auto leading-relaxed text-xs md:text-sm mb-1">
                                            <x-info>
                                                <p>
                                                    有給休暇の残日数を<span class="font-semibold">勤続年数</span>に応じて自動更新します。
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

                                    <!-- 更新日form - start -->
                                    <form action="#remaining-all-update">
                                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                                            <div>
                                                <label for="update_date"
                                                    class="block mb-2 text-sm font-medium text-gray-900">
                                                    更新基準日
                                                </label>
                                                <input type="date" id="update_date" name="update_date"
                                                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                    value="{{ date('2024-04-01') }}">
                                            </div>
                                        </div>

                                        <div class="flex flex-row-reverse">
                                            <x-button class="w-full"
                                                onclick="if(!confirm('有給休暇日数を更新します。この操作は取り消せません。更新してよろしいですか？')){return false};">
                                                {{ __('Update') }}
                                            </x-button>
                                        </div>
                                    </form>
                                    <!-- 更新日form - end -->

                                    <div class="max-w-2xl w-full mx-auto mt-8">
                                        <div class="relative w-30 h-8 mb-2">
                                            <x-return-button class="absolute inset-y-0 right-0"
                                                href="#remaining-update">
                                                {{ __('一覧へ戻る') }}
                                            </x-return-button>
                                        </div>
                                        <div class="relative w-30 h-8">
                                            <x-back-home-button class="absolute inset-y-0 right-0" href="#admin">
                                                {{ __('Back') }}
                                            </x-back-home-button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- user-update -->
                        <div id="user-update" class="border-b-2">
                            <div id="remaining-index"
                                class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">ユーザーの部署の変更</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;管理者権限のあるユーザーは、権限の範囲内でユーザーの部署を変更できます。<br>
                                        &emsp;ユーザーの部署を変更したいときは<a href="#admin"
                                            class="text-blue-600 hover:underline">ユーザー設定</a>からユーザー一覧にすすみます。<br>
                                        &emsp;部署を変更するユーザーの設定ボタンを押して<a href="#user-update"
                                            class="text-blue-600 hover:underline">ユーザー情報の編集</a>にすすみ、部署を変更して更新ボタンを押します。
                                    </p>
                                </div>
                            </div>

                            <section class="text-gray-600 body-font">
                                <div class="container max-w-2xl md:px-5 py-8 md:py-16 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-6">
                                        <h1 class="text-xl md:text-3xl ZenMaruGothic title-font text-gray-900">ユーザー一覧
                                        </h1>
                                        <x-info class="mx-auto my-4">
                                            <p class="text-xs md:text-sm">
                                                設定から<span class="font-bold">所属の変更</span>と<span
                                                    class="font-bold">ユーザーの削除</span>ができます。
                                            </p>
                                        </x-info>
                                        <h2 class="text-right">
                                            <x-circle-button href="#register">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="w-6 h-6">
                                                    <path
                                                        d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                                </svg>
                                            </x-circle-button>
                                            {{-- <a href="#register"
                                            class="inline-flex items-center justify-center text-base mr-2 -mt-8 font-medium text-green-800 hover:text-green-50 p-1 rounded-full border-2 border-green-800 bg-green-100/60 hover:bg-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="w-6 h-6">
                                                <path
                                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                            </svg>
                                        </a> --}}
                                        </h2>
                                    </div>

                                    <div class="container max-w-2xl bg-white w-full mx-auto border-2 rounded-lg">
                                        <div class="flex flex-col p-2 md:p-6 mx-auto">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table
                                                            class="mx-auto divide-y divide-gray-200 text-xs md:text-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th
                                                                        class="md:px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('Employee') }}
                                                                    </th>
                                                                    <th
                                                                        class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('Name') }}
                                                                    </th>
                                                                    <th
                                                                        class="w-24 px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('所 属') }}
                                                                    </th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200">
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-right font-medium text-gray-800">
                                                                        {{ '1000' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-left text-gray-800">
                                                                        {{ '長島 秋休' }}
                                                                    </td>
                                                                    <td class="px-4 py-4 whitespace-nowrap text-gray-800">
                                                                        {{ '第一製造部' }}
                                                                        {{ 'グループ1' }}
                                                                    </td>
                                                                    <td class="px-1 py-4 whitespace-nowrap text-gray-800">
                                                                        <x-show-a-button href="#user-edit"
                                                                            class="px-3 py-1">
                                                                            {{ __('Setting') }}
                                                                        </x-show-a-button>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-right font-medium text-gray-800">
                                                                        {{ '2000' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-left text-gray-800">
                                                                        {{ '長島 島子' }}
                                                                    </td>
                                                                    <td class="px-4 py-4 whitespace-nowrap text-gray-800">
                                                                        {{ '第二製造部' }}
                                                                        {{ 'グループ1' }}
                                                                    </td>
                                                                    <td class="px-1 py-4 whitespace-nowrap text-gray-800">
                                                                        <x-show-a-button href="#user-edit"
                                                                            class="px-3 py-1">
                                                                            {{ __('Setting') }}
                                                                        </x-show-a-button>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-right font-medium text-gray-800">
                                                                        {{ '2222' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-left text-gray-800">
                                                                        {{ '長島 美楽乃' }}
                                                                    </td>
                                                                    <td class="px-4 py-4 whitespace-nowrap text-gray-800">
                                                                        {{ '第二製造部' }}
                                                                        {{ 'グループ2' }}
                                                                    </td>
                                                                    <td class="px-1 py-4 whitespace-nowrap text-gray-800">
                                                                        <x-show-a-button href="#user-edit"
                                                                            class="px-3 py-1">
                                                                            {{ __('Setting') }}
                                                                        </x-show-a-button>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-right font-medium text-gray-800">
                                                                        {{ '3000' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-left text-gray-800">
                                                                        {{ '長島 利休' }}
                                                                    </td>
                                                                    <td class="px-4 py-4 whitespace-nowrap text-gray-800">
                                                                        {{ '第三製造部' }}
                                                                        {{ 'グループ3' }}
                                                                    </td>
                                                                    <td class="px-1 py-4 whitespace-nowrap text-gray-800">
                                                                        <x-show-a-button href="#user-edit"
                                                                            class="px-3 py-1">
                                                                            {{ __('Setting') }}
                                                                        </x-show-a-button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="max-w-2xl w-full mx-auto mt-8">
                                        <div class="relative w-30 h-8">
                                            <x-back-home-button class="absolute inset-y-0 right-0" href="#admin">
                                                {{ __('Back') }}
                                            </x-back-home-button>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="user-edit" class="text-gray-600 body-font">
                                <div class="container max-w-3xl md:px-5 py-8 md:py-16 w-full mx-auto">
                                    <div class="flex flex-col text-center w-full mb-10">
                                        <h1
                                            class="text-xl md:text-2xl ZenMaruGothic title-font bm-2 md:mb-4 text-gray-900">
                                            ユーザー情報の編集</h1>
                                        {{-- <x-info class="mx-auto">
                                            <p class="text-sm">
                                                削除したユーザーはアプリを
                                                <span class="font-bold">利用できなくなります</span>。
                                                削除の
                                                <span class="font-bold">取消はできません。</span>
                                            </p>
                                        </x-info> --}}
                                    </div>

                                    <div class="container max-w-3xl bg-white w-full mx-auto border-2 rounded-lg">
                                        <div class="flex flex-col p-2 md:p-8 mx-auto">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table class="mx-auto divide-y divide-gray-200">
                                                            <thead>
                                                                <tr>
                                                                    <th
                                                                        class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        社員番号
                                                                    </th>
                                                                    <th
                                                                        class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        氏 名
                                                                    </th>
                                                                    <th colspan="2"
                                                                        class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        所 属
                                                                    </th>
                                                                    <th colspan="2" class="w-24"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200 ">
                                                                <tr class="hover:bg-gray-100">
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-800 ">
                                                                        {{ '1000' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-800 ">
                                                                        {{ '長島 秋休' }}
                                                                    </td>
                                                                    <form action="#user-update">
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select id="factory_id"
                                                                                class="block mt-1 w-32 text-sm">
                                                                                <option>
                                                                                    {{ '第一製造部' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '第二製造部' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '第三製造部' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select id="department_id"
                                                                                class="block mt-1 w-32 text-sm" required>
                                                                                <option>
                                                                                    {{ 'グループ1' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ 'グループ2' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ 'グループ3' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="px-1 py-4 text-right whitespace-nowrap text-sm text-gray-800">
                                                                            <x-edit-button>
                                                                                {{ __('Update') }}
                                                                            </x-edit-button>
                                                                        </td>
                                                                    </form>
                                                                    {{-- <td
                                                                    class="pl-1 pr-2 py-4 text-center whitespace-nowrap text-sm font-medium">
                                                                    <form action="#user-update">
                                                                        <x-delete-input-button value="削除"
                                                                            onclick="if(!confirm('ユーザー情報を削除しますか？この操作は取り消せません。削除したユーザーは、アプリを使用できなくなります。')){return false};" />
                                                                    </form>
                                                                </td> --}}
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="max-w-2xl w-full mx-auto mt-8">
                                        <div class="relative w-30 h-8 mb-2">
                                            <x-return-button class="absolute inset-y-0 right-0" href="#user-update">
                                                {{ __('一覧へ戻る') }}
                                            </x-return-button>
                                        </div>
                                        <div class="relative w-30 h-8">
                                            <x-back-home-button class="absolute inset-y-0 right-0" href="#admin">
                                                {{ __('Back') }}
                                            </x-back-home-button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- user-delete -->
                        <div id="user-delete" class="border-b-2">
                            <div id="remaining-index"
                                class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">ユーザーの削除</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;<a href="#approval-info"
                                            class="text-blue-600 hover:underline">全体管理者</a>は、ユーザーを削除できます。
                                        ユーザーが退職した場合など休暇申請の必要がなくなった場合は、ユーザーを削除します。<br>
                                        &emsp;ユーザーを削除するときは、ホーム画面のユーザー設定から<a href="#user-update"
                                            class="text-blue-600 hover:underline">ユーザー一覧</a>にすすみます。
                                        削除するユーザーの設定ボタンを押して<a href="#user-edit"
                                            class="text-blue-600 hover:underline">ユーザー情報の編集</a>にすすみ、削除ボタンを押します。
                                    </p>
                                </div>
                            </div>

                            <section id="user-edit" class="text-gray-600 body-font">
                                <div class="container max-w-3xl md:px-5 py-8 md:py-16 w-full mx-auto">
                                    <div class="flex flex-col text-center w-full mb-10">
                                        <h1
                                            class="text-xl md:text-2xl ZenMaruGothic title-font mb-2 md:mb-4 text-gray-900">
                                            ユーザー情報の編集</h1>
                                        <x-info class="mx-auto">
                                            <p class="text-xs md:text-sm">
                                                削除したユーザーはアプリを
                                                <span class="font-bold">利用できなくなります</span>。
                                                削除の
                                                <span class="font-bold">取消はできません。</span>
                                            </p>
                                        </x-info>
                                    </div>

                                    <div class="container max-w-3xl bg-white w-full mx-auto border-2 rounded-lg">
                                        <div class="flex flex-col p-2 md:p-8 mx-auto">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table class="mx-auto divide-y divide-gray-200">
                                                            <thead>
                                                                <tr>
                                                                    <th
                                                                        class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        社員番号
                                                                    </th>
                                                                    <th
                                                                        class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        氏 名
                                                                    </th>
                                                                    <th colspan="2"
                                                                        class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        所 属
                                                                    </th>
                                                                    <th colspan="2" class="w-24"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200 ">
                                                                <tr class="hover:bg-gray-100">
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-800 ">
                                                                        {{ '1000' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-800 ">
                                                                        {{ '長島 秋休' }}
                                                                    </td>
                                                                    <form action="#user-update">
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select id="factory_id"
                                                                                class="block mt-1 w-32 text-sm">
                                                                                <option>
                                                                                    {{ '第一製造部' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '第二製造部' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '第三製造部' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select id="department_id"
                                                                                class="block mt-1 w-32 text-sm" required>
                                                                                <option>
                                                                                    {{ 'グループ1' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ 'グループ2' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ 'グループ3' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="px-1 py-4 text-right whitespace-nowrap text-sm text-gray-800">
                                                                            <x-edit-button>
                                                                                {{ __('Update') }}
                                                                            </x-edit-button>
                                                                        </td>
                                                                    </form>
                                                                    <td
                                                                        class="pl-1 pr-2 py-4 text-center whitespace-nowrap text-sm font-medium">
                                                                        <form action="#user-update">
                                                                            <x-delete-input-button value="削除"
                                                                                onclick="if(!confirm('ユーザー情報を削除しますか？この操作は取り消せません。削除したユーザーは、アプリを使用できなくなります。')){return false};" />
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="max-w-2xl w-full mx-auto mt-8">
                                        <div class="relative w-30 h-8 mb-2">
                                            <x-return-button class="absolute inset-y-0 right-0" href="#user-update">
                                                {{ __('一覧へ戻る') }}
                                            </x-return-button>
                                        </div>
                                        <div class="relative w-30 h-8">
                                            <x-back-home-button class="absolute inset-y-0 right-0" href="#admin">
                                                {{ __('Back') }}
                                            </x-back-home-button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- register -->
                        <div id="register" class="border-b-2">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">ユーザーの新規登録</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;全体管理者は、新規のユーザーを登録できます。
                                        採用などで新しく休暇申請が必要になった場合は、ユーザーを登録します。<br>
                                        &emsp;ユーザーを登録するときは、ホーム画面のユーザー設定から<a href="#user-update"
                                            class="text-blue-600 hover:underline">ユーザー一覧</a>にすすみます。
                                        ユーザー一覧のタイトル右下の円形の<a href="#user-update"
                                            class="text-blue-600 hover:underline">ユーザー追加マーク</a>から<a href="#register"
                                            class="text-blue-600 hover:underline">ユーザー登録</a>にすすみ、全ての項目を入力してアカウント作成ボタンを押します。
                                    </p>
                                </div>
                            </div>

                            {{-- <x-app-layout> --}}

                            <x-auth-card>
                                <x-slot name="logo">
                                    <div class="container px-5 mx-auto text-gray-600">
                                        <div class="flex flex-col text-center w-full">
                                            <h1
                                                class="text-xl md:text-2xl ZenMaruGothic font-medium title-font mb-2 md:mb-4 text-gray-900">
                                                ユーザー登録</h1>
                                        </div>
                                    </div>
                                </x-slot>

                                <form action="#register">
                                    <!-- Name -->
                                    <div>
                                        <x-label for="register_name" :value="__('Name')" />
                                        <x-input id="register_name" class="block mt-1 w-full" type="text" />
                                    </div>
                                    <!-- Email Address -->
                                    <div class="mt-4">
                                        <x-label for="register_email" :value="__('Email')" />
                                        <x-input id="register_email" class="block mt-1 w-full" type="email" />
                                    </div>
                                    <!-- Password -->
                                    <div class="mt-4">
                                        <x-label for="password" :value="__('Password')" />
                                        <x-input id="password" class="block mt-1 w-full" type="password"
                                            autocomplete="new-password" />
                                    </div>
                                    <!-- Confirm Password -->
                                    <div class="mt-4">
                                        <x-label for="confirm_password" :value="__('Confirm Password')" />
                                        <x-input id="confirm_password" class="block mt-1 w-full" type="password" />
                                    </div>
                                    <!-- Employee -->
                                    <div class="mt-4">
                                        <x-label for="employee" :value="__('Employee')" />
                                        <x-input id="employee" class="block mt-1 w-full" type="number" />
                                    </div>
                                    <!-- Factory_id -->
                                    <div class="mt-4">
                                        <x-label for="factory_id" :value="__('Factory')" />
                                        <x-select id="factory_id" class="block w-full p-2.5">
                                            <option>{{ '第一製造部' }}</option>
                                            <option>{{ '第二製造部' }}</option>
                                            <option>{{ '第三製造部' }}</option>
                                        </x-select>
                                    </div>
                                    <!-- Department_id -->
                                    <div class="mt-4">
                                        <x-label for="department_id" :value="__('Department')" />
                                        <x-select id="department_id" class="block w-full p-2.5">
                                            <option>{{ 'グループ1' }}</option>
                                            <option>{{ 'グループ2' }}</option>
                                            <option>{{ 'グループ3' }}</option>
                                        </x-select>
                                    </div>
                                    <!-- Adoption_date -->
                                    <div class="mt-4">
                                        <x-label for="adoption_date" :value="__('Adoption')" />
                                        <x-input id="adoption_date" type="date" class="block mt-1 w-full"
                                            required />
                                    </div>
                                    <!-- Birthday -->
                                    <div class="mt-4">
                                        <p class='block font-medium text-sm text-gray-700'>{{ __('Birthday') }}</p>
                                        <x-input id="birthday_month" type="number" min="1" max='12'
                                            class="mt-1 w-10 md:w-20" required />
                                        {{ __('月') }}
                                        <x-input id="birthday_day" type="number" min="1" max='31'
                                            class="mt-1 ml-2 w-10 md:w-20" required />
                                        {{ __('日') }}
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <x-button class="ml-4">
                                            {{ __('Register') }}
                                        </x-button>
                                    </div>
                                </form>
                            </x-auth-card>

                            <div class="bg-gray-50">
                                <div class="w-full sm:max-w-md mx-auto py-8">
                                    <div class="relative w-30 h-8 mb-2">
                                        <x-return-button class="absolute inset-y-0 right-0" href="#user-update">
                                            {{ __('一覧へ戻る') }}
                                        </x-return-button>
                                    </div>
                                    <div class="relative w-30 h-8">
                                        <x-back-home-button class="absolute inset-y-0 right-0" href="#admin">
                                            {{ __('Back') }}
                                        </x-back-home-button>
                                    </div>
                                </div>
                            </div>
                            {{-- </x-app-layout> --}}
                        </div>

                        <!-- approval-info -->
                        <div id="approval-info" class="border-b-2">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">権限</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;権限の種類は、以下の4種類あります。<br>
                                    </p>
                                    <ul class="pace-y-1 list-disc list-inside text-sm">
                                        <li class="pl-2 pt-2">管理者</li>
                                        <li class="pl-4 list-none pb-2 text-xs">管轄内の管理機能が使用可能</li>
                                        <li class="pl-2">上長承認</li>
                                        <li class="pl-4 list-none pb-2 text-xs">管轄内の上長承認と閲覧</li>
                                        <li class="pl-2">係長承認</li>
                                        <li class="pl-4 list-none pb-2 text-xs">管轄内の係長承認と閲覧</li>
                                        <li class="pl-2">閲 覧</li>
                                        <li class="pl-4 list-none pb-2 text-xs">管轄内の閲覧</li>
                                    </ul>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;権限は「管轄」と「権限の種類」の組み合わせで設定します。<br>
                                        &emsp;例えば、特定の部署、特定のグループを管轄する係長承認を設定する場合は、部署:特定の部署、グループ:特定のグループ、権限:係長承認を選択します。
                                        また、特定の部署の全てのグループを閲覧できる権限を与える場合は、部署:特定の部署、グループ:全グループ、権限:閲覧を選択します。<br>
                                        <br>
                                        &emsp;管理者は、「全体管理者」と「一般管理者」があり、一般管理者は管理機能が限定されます。<br>
                                        &emsp;全体管理者とは、すべての部署、すべてのグループに対して管理者権限を持つユーザーです。
                                        全体管理者として設定するときは、部署:全部、グループ:全グループ、権限:管理者を設定します。<br>
                                        &emsp;一般管理者は、特定の部署や特定のグループに対して管理者権限を持つユーザーです。
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- approval-update -->
                        <div id="approval-update" class="border-b-2">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">権限の変更</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;管理者権限のあるユーザーは、権限の範囲内でユーザーの権限を変更できます。<br>
                                        &emsp;権限を変更するときは、ホーム画面の権限設定から<a href="#approval-index"
                                            class="text-blue-600 hover:underline">権限一覧</a>にすすみます。
                                        権限を変更したいユーザーの変更ボタンから<a href="#approval-edit"
                                            class="text-blue-600 hover:underline">権限の編集</a>にすすみ、管轄と権限を選択して更新ボタンを押します。
                                    </p>
                                </div>
                            </div>

                            <section id="approval-index" class="text-gray-600 body-font">
                                <div class="container max-w-3xl md:px-5 py-8 md:py-16 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-6">
                                        <h1 class="text-2xl md:text-3xl ZenMaruGothic title-font text-gray-900">権限一覧</h1>
                                        <x-info class="mx-auto my-4">
                                            <p class="text-xs md:text-sm">
                                                設定から<span class="font-bold">権限の変更</span>と<span
                                                    class="font-bold">取消</span>ができます。
                                            </p>
                                        </x-info>
                                        <h2 class=" text-right">
                                            <x-circle-button href="#approval-create">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor" class="w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </x-circle-button>
                                        </h2>
                                    </div>

                                    <div class="container max-w-2xl bg-white w-full mx-auto border-2 rounded-lg">
                                        <div class="flex flex-col  p-2 md:p-6 mx-auto">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table class="mx-auto divide-y divide-gray-200">
                                                            <thead>
                                                                <tr>
                                                                    <th
                                                                        class="w-24 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('社 員') }}
                                                                    </th>
                                                                    <th
                                                                        class="w-24 px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('管 轄') }}
                                                                    </th>
                                                                    <th
                                                                        class="w-24 px-4 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('権 限') }}
                                                                    </th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200">
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-left text-gray-800">
                                                                        {{ '1000' }}
                                                                        {{ '長島 秋休' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-xs text-gray-800">
                                                                        {{ '全部' }}
                                                                        {{ '全グループ' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 text-center whitespace-nowrap text-sm text-gray-800">
                                                                        {{ '管理者' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-1 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                        <x-show-a-button href="#approval-edit"
                                                                            class="px-3 py-1">
                                                                            {{ __('Setting') }}
                                                                            </x-shos-a-button>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-left text-gray-800">
                                                                        {{ '1000' }}
                                                                        {{ '長島 秋休' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-xs text-gray-800">
                                                                        {{ '第一製造部' }}
                                                                        {{ 'グループ1' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 text-center whitespace-nowrap text-sm text-gray-800">
                                                                        {{ '上長承認' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-1 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                        <x-show-a-button href="#approval-edit"
                                                                            class="px-3 py-1">
                                                                            {{ __('Setting') }}
                                                                            </x-shos-a-button>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-left text-gray-800">
                                                                        {{ '2000' }}
                                                                        {{ '金田' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-xs text-gray-800">
                                                                        {{ '第一製造部' }}
                                                                        {{ 'グループ1' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 text-center whitespace-nowrap text-sm text-gray-800">
                                                                        {{ '上長承認' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-1 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                        <x-show-a-button href="#approval-edit"
                                                                            class="px-3 py-1">
                                                                            {{ __('Setting') }}
                                                                            </x-shos-a-button>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-sm text-left text-gray-800">
                                                                        {{ '3000' }}
                                                                        {{ '長島 利休' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 whitespace-nowrap text-xs text-gray-800">
                                                                        {{ '第一製造部' }}
                                                                        {{ 'グループ1' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-4 text-center whitespace-nowrap text-sm text-gray-800">
                                                                        {{ '閲覧' }}
                                                                    </td>
                                                                    <td
                                                                        class="px-1 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                        <x-show-a-button href="#approval-edit"
                                                                            class="px-3 py-1">
                                                                            {{ __('Setting') }}
                                                                            </x-shos-a-button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="max-w-2xl w-full mx-auto mt-8">
                                        <div class="relative w-30 h-8">
                                            <x-back-home-button class="absolute inset-y-0 right-0" href="#admin">
                                                {{ __('Back') }}
                                            </x-back-home-button>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section id="approval-edit" class="text-gray-600 body-font">
                                <div class="container max-w-4xl md:px-5 py-6 md:py-18 w-full xl:w-3/4 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-6 md:mb-10">
                                        <h1 class="text-xl md:text-2xl font-medium title-font mb-4 text-gray-900">権限の編集
                                        </h1>
                                        <x-info class="mx-auto">
                                            <p class="text-xs md:text-sm">
                                                <span class="font-bold">管轄、権限の種類</span>を変更できます。
                                            </p>
                                        </x-info>
                                    </div>

                                    <div class="container max-w-4xl bg-white w-full mx-auto border-2 rounded-lg">
                                        <div class="flex flex-col p-2 md:p-8 mx-auto">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table class="mx-auto divide-y divide-gray-200">
                                                            <thead>
                                                                <tr>
                                                                    <th
                                                                        class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('社 員') }}
                                                                    </th>
                                                                    <th colspan="2"
                                                                        class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('管 轄') }}
                                                                    </th>
                                                                    <th
                                                                        class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('権 限') }}
                                                                    </th>
                                                                    <th colspan="2" class="w-24"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200">
                                                                <tr class="hover:bg-gray-100">
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-800">
                                                                        {{ '1000' }}&ensp;
                                                                        {{ '長島 秋休' }}
                                                                    </td>
                                                                    <form action="#approval-index">
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select id="factory_id"
                                                                                class="w-32 border-gray-300 text-gray-900 text-sm p-2.5">
                                                                                <option>
                                                                                    {{ '全部' }}
                                                                                    {{ '第一製造部' }}
                                                                                    {{ '第二製造部' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select id="department_id"
                                                                                class="w-32 border-gray-300 text-gray-900 text-sm p-2.5">
                                                                                <option>
                                                                                    {{ '全グループ' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ 'グループ1' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ 'グループ2' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select id="approval_id"
                                                                                class="w-32 border-gray-300 text-gray-900 text-sm p-2.5">
                                                                                <option>
                                                                                    {{ '上長承認' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '係長承認' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '閲覧' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="pl-2 pr-1 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            <x-edit-button>
                                                                                {{ __('Update') }}
                                                                            </x-edit-button>
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

                                    <div class="max-w-2xl w-full mx-auto mt-8">
                                        <div class="relative w-30 h-8 mb-2">
                                            <x-return-button class="absolute inset-y-0 right-0" href="#approval-index">
                                                {{ __('一覧へ戻る') }}
                                            </x-return-button>
                                        </div>
                                        <div class="relative w-30 h-8">
                                            <x-back-home-button class="absolute inset-y-0 right-0" href="#admin">
                                                {{ __('Back') }}
                                            </x-back-home-button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- approval-delete -->
                        <div id="approval-delete" class="border-b-2">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">権限の削除</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;全体管理者は権限を取消すことができます。<br>
                                        &emsp;権限を取消するときは、ホーム画面の権限設定から<a href="#approval-index"
                                            class="text-blue-600 hover:underline">権限一覧</a>にすすみます。
                                        権限を取消したいユーザーの削除ボタンを押します。
                                    </p>
                                </div>
                            </div>


                            <section id="approval-edit" class="text-gray-600 body-font">
                                <div class="container max-w-4xl md:px-5 py-6 md:py-18 w-full xl:w-3/4 mx-auto">
                                    <div class="flex flex-col text-center w-full mb-6 md:mb-10">
                                        <h1 class="text-xl md:text-2xl font-medium title-font mb-4 text-gray-900">権限の編集
                                        </h1>
                                        <x-info class="mx-auto">
                                            <p class="text-xs md:text-sm">
                                                <span class="font-bold">管轄、権限の種類</span>を変更できます。
                                            </p>
                                        </x-info>
                                    </div>

                                    <div class="container max-w-4xl bg-white w-full mx-auto border-2 rounded-lg">
                                        <div class="flex flex-col p-2 md:p-8 mx-auto">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table class="mx-auto divide-y divide-gray-200">
                                                            <thead>
                                                                <tr>
                                                                    <th
                                                                        class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('社 員') }}
                                                                    </th>
                                                                    <th colspan="2"
                                                                        class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('管 轄') }}
                                                                    </th>
                                                                    <th
                                                                        class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('権 限') }}
                                                                    </th>
                                                                    <th colspan="2" class="w-24"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200">
                                                                <tr class="hover:bg-gray-100">
                                                                    <td
                                                                        class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-800">
                                                                        {{ '1000' }}&ensp;
                                                                        {{ '長島 秋休' }}
                                                                    </td>
                                                                    <form action="#approval-index">
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select name="factory_id"
                                                                                class="w-32 border-gray-300 text-gray-900 text-sm p-2.5">
                                                                                <option>
                                                                                    {{ '全部' }}
                                                                                    {{ '第一製造部' }}
                                                                                    {{ '第二製造部' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select name="department_id"
                                                                                class="w-32 border-gray-300 text-gray-900 text-sm p-2.5">
                                                                                <option>
                                                                                    {{ '全グループ' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ 'グループ1' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ 'グループ2' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select name="approval_id"
                                                                                class="w-32 border-gray-300 text-gray-900 text-sm p-2.5">
                                                                                <option>
                                                                                    {{ '上長承認' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '係長承認' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '閲覧' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="pl-2 pr-1 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            <x-edit-button>
                                                                                {{ __('Update') }}
                                                                            </x-edit-button>
                                                                        </td>
                                                                    </form>
                                                                    <td
                                                                        class="pl-1 pr-4 py-4 whitespace-nowrap text-sm font-medium">
                                                                        <form action="#approval-index">
                                                                            <x-delete-input-button value="削除"
                                                                                onclick="if(!confirm('権限を取消しますか？')){return false};" />
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="max-w-2xl w-full mx-auto mt-8">
                                        <div class="relative w-30 h-8 mb-2">
                                            <x-return-button class="absolute inset-y-0 right-0" href="#approval-index">
                                                {{ __('一覧へ戻る') }}
                                            </x-return-button>
                                        </div>
                                        <div class="relative w-30 h-8">
                                            <x-back-home-button class="absolute inset-y-0 right-0" href="#admin">
                                                {{ __('Back') }}
                                            </x-back-home-button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- approval-create -->
                        <div id="approval-create">
                            <div class="max-w-2xl px-4 py-2 bg-white rounded-lg shadow-md mx-auto my-2">
                                <div class="mt-2">
                                    <h2 class="text-md font-bold text-gray-700 hover:text-gray-600 hover:underline"
                                        tabindex="0">権限の追加</h2>
                                    <p class="mt-2 text-sm text-gray-600">
                                        &emsp;全体管理者は、新しく権限を追加できます。
                                        新しく権限が必要になったときは、権限を追加します。<br>
                                        &emsp;権限の追加は、ホーム画面の権限設定から<a href="#approval-index"
                                            class="text-blue-600 hover:underline">権限一覧</a>にすすみます。
                                        権限一覧のタイトル右下の円形の<a href="#approval-index"
                                            class="text-blue-600 hover:underline">権限追加マーク</a>から<a
                                            href="#approval-create"
                                            class="text-blue-600 hover:underline">権限の追加</a>にすすみ、管轄と権限を選択して追加ボタンを押します。
                                    </p>
                                </div>
                            </div>

                            <section class="text-gray-600 body-font">
                                <div class="container max-w-4xl md:px-5 y-8 md:ppy-16 w-full mx-auto">
                                    <div class="flex flex-col text-center w-full mb-10">
                                        <h1 class="text-xl md:text-2xl ZenMaruGothic title-font mb-4 text-gray-900">権限の追加
                                        </h1>
                                        <x-info class="mx-auto">
                                            <p class="text-xs md:text-sm">
                                                <span class="font-bold">新しく権限を設定する</span>ときはこちらから追加してください。
                                            </p>
                                        </x-info>
                                    </div>

                                    <div class="container max-w-4xl bg-white w-full mx-auto border-2 rounded-lg">
                                        <div class="flex flex-col p-2 md:p-8 mx-auto">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table class="mx-auto divide-y divide-gray-200">
                                                            <thead>
                                                                <tr>
                                                                    <th
                                                                        class="w-24 px-2 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('社 員') }}
                                                                    </th>
                                                                    <th colspan="2"
                                                                        class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('管 轄') }}
                                                                    </th>
                                                                    <th
                                                                        class="w-24 px-6 py-3 text-center text-xs font-medium text-gray-500 tracking-wider">
                                                                        {{ __('権 限') }}
                                                                    </th>
                                                                    <th class="w-24"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200">
                                                                <tr class="hover:bg-gray-100">
                                                                    <form action="#approval-index">
                                                                        <td
                                                                            class="px-2 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-800">
                                                                            <x-select name="user_id"
                                                                                class="w-40 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                                                                                <option>
                                                                                    {{ '1000' }}&ensp;{{ '長島 秋休' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '2000' }}&ensp;{{ '長島 島子' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '2222' }}&ensp;{{ '長島 美楽乃' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '3000' }}&ensp;{{ '長島 利休' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select name="factory_id"
                                                                                class="w-32 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                                                                                <option>
                                                                                    {{ '全部' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '第一製造部' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '第二製造部' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '第三製造部' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select name="department_id"
                                                                                class="w-32 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                                                                                <option>
                                                                                    {{ '全グループ' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ 'グループ1' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ 'グループ2' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ 'グループ3' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="px-2 py-3 whitespace-nowrap text-center text-sm font-medium">
                                                                            <x-select name="approval_id"
                                                                                class="w-32 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
                                                                                <option>
                                                                                    {{ '管理者' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '上長承認' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '係長承認' }}
                                                                                </option>
                                                                                <option>
                                                                                    {{ '閲覧' }}
                                                                                </option>
                                                                            </x-select>
                                                                        </td>
                                                                        <td
                                                                            class="pl-1 pr-4 py-4 whitespace-nowrap text-sm text-gray-800">
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
                                            <x-return-button class="absolute inset-y-0 right-0" href="#approval-index">
                                                {{ __('一覧へ戻る') }}
                                            </x-return-button>
                                        </div>
                                        <div class="relative w-30 h-8">
                                            <x-back-home-button class="absolute inset-y-0 right-0" href="#admin">
                                                {{ __('Back') }}
                                            </x-back-home-button>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    @endcan
                </div>
            </div>
        </div>

        <!-- ボタン -->
        <button class="fixed right-4 bottom-16 bg-sky-700/80 text-white px-2 py-2 rounded-full shadow"
            onclick="location.href='{{ route('menu') }}'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
        </button>
        <button id="scrollTopBtn"
            class="fixed right-4 bottom-4 bg-sky-700/80 text-white px-2 py-2 rounded-full shadow"
            onclick="scrollToTop()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
            </svg>
        </button>
    </section>

    <!-- JavaScriptのリンク -->
    <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // ドロップダウンを表示/非表示するJavaScriptの処理
        document.addEventListener("DOMContentLoaded", function() {
            const dropdownButton1 = document.getElementById("drop-down-button-1");
            const dropdownMenu1 = document.getElementById("drop-down-menu-1");
            const dropdownButton2 = document.getElementById("drop-down-button-2");
            const dropdownMenu2 = document.getElementById("drop-down-menu-2");
            const dropdownButton3 = document.getElementById("drop-down-button-3");
            const dropdownMenu3 = document.getElementById("drop-down-menu-3");
            const dropdownButton4 = document.getElementById("drop-down-button-4");
            const dropdownMenu4 = document.getElementById("drop-down-menu-4");

            dropdownButton1.addEventListener("click", function() {
                dropdownMenu1.classList.toggle("hidden");
            });
            dropdownButton2.addEventListener("click", function() {
                dropdownMenu2.classList.toggle("hidden");
            });
            dropdownButton3.addEventListener("click", function() {
                dropdownMenu3.classList.toggle("hidden");
            });
            dropdownButton4.addEventListener("click", function() {
                dropdownMenu4.classList.toggle("hidden");
            });
        });

        // function dropDownswich1() {
        //     let dropDown1 = document.getElementById('dropDown1');
        //     console.log(dropDown1);
        //     if (dropDown1.style.display = 'none') {
        //         dropDown1.style.display = '';
        //     } 
        //     if (dropDown1.style.display = '') {
        //         dropDown1.style.display = 'none';
        //     }
        // }
    </script>

</x-app-layout>
