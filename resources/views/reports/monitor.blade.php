<x-app-layout>

    <section class="body-font">
        <div class="container max-w-5xl px-5 py-6 mx-auto">
            <div class="relative border border-gray-400 rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-8 py-3 rounded-tl-lg">
                                {{ __('Affiliation') }}
                            </th>
                            <th scope="col" class="px-6 py-3 rounded-tr-lg">
                                {{ __('承認待ち件数') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($pending_reports) > 0)
                            @foreach ($pending_reports as $report)
                                <tr class="bg-white">
                                    <th scope="row"
                                        class="px-6 py-2 font-medium text-gray-800 text-2xl whitespace-nowrap">
                                        {{ $report['affiliation'] }}
                                    </th>
                                    <td class="px-8 py-2 font-semibold text-5xl">
                                        {{ $report['count'] }}
                                    </td>
                                </tr>
                            @endforeach
                            <th scope="row"
                                class="px-6 py-2 font-medium text-gray-800 text-2xl whitespace-nowrap rounded-l-lg">
                            </th>
                            <td class="px-8 py-2 font-semibold text-5xl rounded-r-lg">
                            </td>
                        @else
                            <tr class="bg-white">
                                <th scope="row" colspan="2"
                                    class="px-6 py-6 text-center font-semibold text-gray-800 text-4xl whitespace-nowrap rounded-b-lg">
                                    {{ __('承認待ちの申請はありません') }}
                                </th>
                            </tr>

                        @endif
                </table>
            </div>
        </div>
    </section>
    <script>
        // 5分ごとにページをリロードする関数
        function reloadPage() {
            location.reload();
        }

        // ページロード後に最初のリロードをスケジュール
        document.addEventListener("DOMContentLoaded", function() {
            setInterval(reloadPage, 300000); // 5分（300秒）ごとにリロード
        });
    </script>

</x-app-layout>
