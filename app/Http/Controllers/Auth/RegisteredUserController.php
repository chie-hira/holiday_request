<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Affiliation;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Models\FactoryCategory;
use App\Models\DepartmentCategory;
use App\Models\GroupCategory;
use App\Models\Remaining;
use App\Models\ReportCategory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $affiliations = Affiliation::where('id', '!=', 1)->get();
        // $factory_categories = FactoryCategory::where('id', '!=', 1)->get();
        // $department_categories = DepartmentCategory::all();
        // $group_categories = GroupCategory::all();
        return view('auth.register')->with(
            compact(
                'affiliations'
            )
        );
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // 'unique:users',
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'employee' => ['required', 'integer', 'min:0', 'unique:users'],
            'affiliation_id' => ['required', 'integer'],
            'adoption_date' => ['required', 'date'],
            'birthday_month' => ['required'],
            'birthday_day' => ['required'],
        ]);

        /** 誕生日は1月1日の場合、01-01の形式で格納 */
        $birthday = $request->birthday_month . '-' . $request->birthday_day;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'employee' => $request->employee,
            'affiliation_id' => $request->affiliation_id,
            'adoption_date' => $request->adoption_date,
            'birthday' => $birthday,
            'remarks' => $request->password,
        ]);

        event(new Registered($user));

        // メール通知
        $user->registered($user);
        // remarks削除
        $user->remarks = null;
        $user->save();

        /** ユーザー作成と同時に残日数を登録する */
        $report_categories = ReportCategory::where('id', '!=', 1)->get();

        $param[] = [
            'user_id' => $user->id,
            'report_id' => 1,
            'remaining_days' => 10,
        ];
        foreach ($report_categories as $report) {
            $param[] = [
                'user_id' => $user->id,
                'report_id' => $report->id,
                'remaining_days' => $report->max_days,
            ];
        }
        DB::table('acquisition_days')->insert($param);

        return redirect()
            ->route('users.index')
            ->with('notice', 'ユーザーを登録しました。');
    }
}
