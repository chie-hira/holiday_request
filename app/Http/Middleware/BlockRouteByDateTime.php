<?php

namespace App\Http\Middleware;

use App\Models\Calender;
use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $holiday_calender = Calender::whereHas('calender_category', function (
            $query
        ) {
            $query
                ->where(
                    'calender_id',
                    Auth::user()->affiliation->calender_category->id
                )
                ->where('date_id', 1);
        })->get('date');
        $business_day_calender = Calender::whereHas(
            'calender_category',
            function ($query) {
                $query
                    ->where(
                        'calender_id',
                        Auth::user()->affiliation->calender_category->id
                    )
                    ->where('date_id', 2);
            }
        )->get('date');

        if ($holiday_calender->contains('date', $DateTime->format('Ymd'))) {
            return back()->withErrors('休日は申請できません');
        } elseif (
            $DateTime->dayName == '水曜日' &&
            !$business_day_calender->contains('date', $DateTime->format('Ymd'))
        ) {
            return back()->withErrors('休日は申請できません');
        } elseif (
            $DateTime->dayName == '日曜日' &&
            !$business_day_calender->contains('date', $DateTime->format('Ymd'))
        ) {
            return back()->withErrors('休日は申請できません');
        }

        return $next($request);
    }
}
