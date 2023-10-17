<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Imports\UserImport;
use App\Models\Affiliation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $my_approvals = Auth::user()
            ->approvals->where('approval_id', 1)
            ->load('affiliation');

        // 一部管理者の場合
        $users = User::where(function ($query) use ($my_approvals) {
            foreach ($my_approvals as $approval) {
                if ($approval->affiliation->department_id == 1) {
                    $query->orWhere(function ($query) use ($approval) {
                        $query->whereHas('affiliation', function ($query) use (
                            $approval
                        ) {
                            $query->where(
                                'factory_id',
                                $approval->affiliation->factory_id
                            );
                        });
                    });
                } else {
                    $query->orWhere(function ($query) use ($approval) {
                        $query->whereHas('affiliation', function ($query) use (
                            $approval
                        ) {
                            $query
                                ->where(
                                    'factory_id',
                                    $approval->affiliation->factory_id
                                )
                                ->where(
                                    'department_id',
                                    $approval->affiliation->department_id
                                );
                        });
                    });
                }
            }
        })->get();

        // 全体管理者の場合
        if (
            $my_approvals
                ->where('affiliation_id', 1)
                ->contains('approval_id', 1)
        ) {
            $users = User::all();
        }

        // 重複削除&並べ替え
        $users = $users
            ->unique()
            ->load([
                'affiliation',
                'affiliation.factory',
                'affiliation.department',
                'affiliation.group',
            ])
            ->sortBy('affiliation_id')
            ->sortBy('employee');

        return view('users.index')->with(compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $my_approvals = Auth::user()
            ->approvals->where('approval_id', 1)
            ->load('affiliation');

        $affiliations = Affiliation::where('id', '!=', 1)
            ->where(function ($query) use ($my_approvals) {
                foreach ($my_approvals as $approval) {
                    $query->orWhere(function ($query) use ($approval) {
                        if ($approval->affiliation->department_id == 1) {
                            $query->where(
                                'factory_id',
                                $approval->affiliation->factory_id
                            );
                        } else {
                            $query
                                ->where(
                                    'factory_id',
                                    $approval->affiliation->factory_id
                                )
                                ->where(
                                    'department_id',
                                    $approval->affiliation->department_id
                                );
                        }
                    });
                }
            })
            ->get()
            ->load(['factory', 'department', 'group']);

        // 全体管理者の場合
        if (
            $my_approvals
                ->where('affiliation_id', 1)
                ->contains('approval_id', 1)
        ) {
            $affiliations = Affiliation::where('id', '!=', 1)
                ->get()
                ->load(['factory', 'department', 'group']);
        }
        return view('users.edit')->with(compact('user', 'affiliations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->fill($request->all());
        try {
            $user->save();
            return redirect()
                ->route('users.index')
                ->with('notice', 'ユーザー情報を更新しました');
        } catch (\Throwable $th) {
            return back()->withErrors('エラーが発生しました');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()
                ->route('users.index')
                ->with('notice', 'ユーザー情報を削除しました。');
        } catch (\Throwable $th) {
            return back()->withErrors('エラーが発生しました');
        }
    }

    // profile_admin
    // 管理者がユーザーのプロフィールを変更できる
    public function email_edit(User $user)
    {
        // dd($user);
        return view('users.mail_address_edit', [
            'user' => $user,
        ]);
    }

    public function password_edit(User $user)
    {
        return view('users.password_edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function email_update(Request $request, User $user)
    {
        // dd($request);
        // dd($user);
        $user->fill($request->all());
        $user->save();

        return back()->with('status', 'profile-updated');
    }

    public function password_update(Request $request, User $user)
    {
        // dd($user);
        $validated = $request->validateWithBag('updatePassword', [
            'current_password_original' => ['required', 'current_password_original:'.$user->id],
            // 'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);
        // dd($user);

        $user->password = Hash::make($validated['password']);
        $user->save();
        // dd($user);

        // $request->user()->update([
        //     'password' => Hash::make($validated['password']),
        // ]);

        return back()->with('status', 'password-updated');
    }

    public function import(Request $request)
    {
        // ユーザー情報インサート
        $excel_file = $request->file('excel_file');
        $excel_file->store('excels');
        Excel::import(new UserImport(), $excel_file);

        return redirect()
            ->route('import_form')
            ->with('notice', 'ユーザー情報インポート完了！');
    }
}
