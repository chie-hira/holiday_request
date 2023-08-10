<?php

namespace App\Http\Controllers;

use App\Models\DepartmentCategory;
use App\Models\FactoryCategory;
use App\Models\GroupCategory;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $my_approvals = Auth::user()->approvals->where('approval_id', 1);

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
        if ($my_approvals->where('affiliation_id', 1)->contains('approval_id', 1)) {
            $users = User::all();
        }

        // 重複削除&並べ替え
        $users = $users
            ->unique()
            ->load('affiliation')
            ->sortBy('affiliation_id')
            ->sortBy('employee');

        return view('users.index')->with(compact('users'));

        // // $users = User::all();
        // $approvals = Auth::user()->approvals->where('approval_id', 1);

        // # 工場単位で一覧作成
        // $users = new Collection();
        // foreach ($approvals as $approval) {
        //     $extractions = User::with(['reports', 'remainings'])
        //                     ->where('factory_id', $approval->factory_id)
        //                     ->get();

        //     $extractions->each(function ($extraction) use ($users) {
        //         $users->add($extraction);
        //     });
        // }

        // return view('users.index')->with(compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $factory_categories = FactoryCategory::all();
        $department_categories = DepartmentCategory::all();
        $group_categories = GroupCategory::all();
        return view('users.edit')->with(
            compact(
                'user',
                'factory_categories',
                'department_categories',
                'group_categories'
            )
        );
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
            return back()->withErrors($th->getMessage());
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
            return back()->withErrors($th->getMessage());
        }
    }
}
