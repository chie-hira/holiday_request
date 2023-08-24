<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Imports\UserImport;
use App\Models\Affiliation;
use App\Models\ReportCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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
        $affiliations = Affiliation::all()->load([
            'factory',
            'department',
            'group',
        ]);
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

    public function import(Request $request)
    {
        // ユーザー情報インサート
        // $excel_file = $request->file('excel_file');
        // $excel_file->store('excels');
        // Excel::import(new UserImport(), $excel_file);
        $excel_file = $request->file('excel_file');
        $stored_path = $excel_file->store('excels');
        $full_path = Storage::path($stored_path);
        Excel::import(new UserImport(), $full_path);

        // 休暇日数インサート
        $users = User::all();
        $param = [];
        $chunkSize = 100; // チャンクのサイズ

        for ($i = 0; $i < count($users); $i++) {
            $user_id = $users[$i]->id;
            $report_categories = ReportCategory::all();

            foreach ($report_categories as $report) {
                $param[] = [
                    'user_id' => $user_id,
                    'report_id' => $report->id,
                    'remaining_days' => $report->max_days,
                ];

                // パラム数がチャンク数を超えたらインサート
                if (count($param) >= $chunkSize) {
                    DB::table('acquisition_days')->insert($param);
                    $param = [];
                }
            }
        }

        if (!empty($param)) {
            DB::table('acquisition_days')->insert($param);
        }

        return redirect()
            ->route('import_form')
            ->with('notice', 'ユーザー情報インポート完了！');
    }
}
