<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Models\FactoryCategory;
use App\Models\DepartmentCategory;
use App\Models\GroupCategory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $factory_categories = FactoryCategory::all();
        $department_categories = DepartmentCategory::all();
        $group_categories = GroupCategory::all();
        return view('auth.register')->with(compact('factory_categories', 'department_categories', 'group_categories'));
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'employee' => ['required', 'integer', 'min:0', 'unique:users'],
            'factory_id' => ['required', 'integer'],
            'department_id' => ['required', 'integer'],
            'group_id' => ['required', 'integer'],
            'adoption_date' => ['required', 'date'],
            'birth_m' => ['required', 'integer'],
            'birth_d' => ['required', 'integer'],
        ]);

        $birthday = $request->birth_m. '-'. $request->birth_d;
        // dd($birthday);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'employee' => $request->employee,
            'factory_id' => $request->factory_id,
            'department_id' => $request->department_id,
            'group_id' => $request->group_id,
            'adoption_date' => $request->adoption_date,
            'birthday' => $birthday,
        ]);

        event(new Registered($user));

        $user->approved($request->name);
        // $user->registered($request->name);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
