<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BlockRouteByDateTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 申請可能時間は8時~16時
        // $blockedDateTimeEnd = Carbon::createFromTime(16,0,0); # 当日の16時
        // $blockedDateTimeStart = Carbon::createFromTime(8,0,0); # 当日の8時

        // // 現在の日時を取得
        // $currentDateTime = Carbon::now();

        // // 指定の日時以降はリダイレクトなどの処理を行う
        // if ($currentDateTime < $blockedDateTimeStart || $currentDateTime > $blockedDateTimeEnd) {
        //     return redirect()->route('menu'); // リダイレクト先のルート名を指定
        // }
        // TODO:休日は申請NG
        $DateTime = Carbon::now();

        if ($DateTime->dayName == '土曜日' || $DateTime->dayName == '日曜日') {
            return redirect()->route('menu'); // リダイレクト先のルート名を指定
        }

        return $next($request);
    }
}
