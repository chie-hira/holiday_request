<x-app-layout>

    <div
        class="w-full max-w-md mx-auto my-10 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
        <div class="flex items-center justify-between mb-4">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">
                出退勤届け
            </h5>
            <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                平泉工場
            </a>
        </div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200"> <!-- divide-y アンダーライン仕切り -->
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 pb-1 truncate">
                                {{ $report->report_category->report_name }}
                            </p>
                            <p class="text-sm text-gray-500 pb-1 truncate">
                                理由 : {{ $report->reason->reason }}
                            </p>
                            @if ($report->reason_detail)
                            <p class="text-sm text-gray-500 truncate">
                                {{ $report->reason_detail }}
                            </p>
                            @endif
                        </div>
                    </div>
                </li>
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                期間
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                {{ $report->start_date }} ~ {{ $report->end_date }}
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            $3467
                        </div>
                    </div>
                </li>
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-2.jpg"
                                alt="Michael image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Michael Gough
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                email@windster.com
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            $67
                        </div>
                    </div>
                </li>
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-4.jpg"
                                alt="Lana image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Lana Byrd
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                email@windster.com
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            $367
                        </div>
                    </div>
                </li>
                <li class="pt-3 pb-0 sm:pt-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-5.jpg"
                                alt="Thomas image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Thomes Lean
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                email@windster.com
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            $2367
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</x-app-layout>
