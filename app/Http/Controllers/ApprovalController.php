<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApprovalRequest;
use App\Http\Requests\UpdateApprovalRequest;
use App\Imports\ApprovalImport;
use App\Models\Affiliation;
use App\Models\Approval;
use App\Models\ApprovalCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myApprovals = Auth::user()
            ->approvals->where('approval_id', 1)
            ->load('affiliation');
        $approvals = Approval::whereHas('user', function ($query) use (
            $myApprovals
        ) {
            $query->where(function ($query) use ($myApprovals) {
                foreach ($myApprovals as $approval) {
                    if ($approval->affiliation->department_id == 1) {
                        $query->orWhere(function ($query) use ($approval) {
                            $query->whereHas('affiliation', function (
                                $query
                            ) use ($approval) {
                                $query->where(
                                    'factory_id',
                                    $approval->affiliation->factory_id
                                );
                            });
                        });
                    } else {
                        $query->orWhere(function ($query) use ($approval) {
                            $query->whereHas('affiliation', function (
                                $query
                            ) use ($approval) {
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
            });
        })->get();

        if ($myApprovals->contains('affiliation_id', 1)) {
            $approvals = Approval::all();
        }

        // 重複削除&並べ替え
        $approvals = $approvals
            ->unique()
            ->load([
                'user',
                'user.affiliation',
                'affiliation',
                'affiliation.factory',
                'affiliation.department',
                'affiliation.group',
                'approval_category',
            ])
            ->sortBy('affiliation_id')
            ->sortBy('user.employee');

        return view('approvals.index')->with(compact('approvals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $myApprovals = Auth::user()
            ->approvals->where('approval_id', 1)
            ->load('affiliation');
        $users = User::whereHas('affiliation', function ($query) use (
            $myApprovals
        ) {
            $query->where(function ($query) use ($myApprovals) {
                foreach ($myApprovals as $approval) {
                    if ($approval->affiliation->department_id == 1) {
                        $query->orWhere(
                            'factory_id',
                            $approval->affiliation->factory_id
                        );
                    } elseif (
                        $approval->affiliation->department_id != 1 &&
                        $approval->affiliation->group_id == 1
                    ) {
                        $query->orWhere(function ($query) use ($approval) {
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
                    } elseif (
                        $approval->affiliation->department_id != 1 &&
                        $approval->affiliation->group_id != 1
                    ) {
                        $query->orWhere(function ($query) use ($approval) {
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
                    }
                }
            });
        })->get();

        // TODO:権限の組み合わせにルールをつける 1はdepartmentまでgroupは必ず1など
        $affiliations = Affiliation::where(function ($query) use (
            $myApprovals
        ) {
            foreach ($myApprovals as $approval) {
                $query->orWhere(function ($query) use ($approval) {
                    if (
                        $approval->affiliation->factory_id != 1 &&
                        $approval->affiliation->department_id == 1
                    ) {
                        $query->where(
                            'factory_id',
                            $approval->affiliation->factory_id
                        );
                    } elseif (
                        $approval->affiliation->factory_id != 1 &&
                        $approval->affiliation->department_id != 1
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
                    }
                });
            }
        })->get();

        $approvalCategories = ApprovalCategory::where('id', '!=', 1)->get();

        if ($myApprovals->contains('affiliation_id', 1)) {
            $users = User::all()->sortBy('employee');
            $affiliations = Affiliation::all()->load([
                'factory',
                'department',
                'group',
            ]);
            $approvalCategories = ApprovalCategory::all();
        }

        return view('approvals.create')->with(
            compact('users', 'affiliations', 'approvalCategories')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApprovalRequest  $request
     * @return \Illuminate\Http\Response
     */
    // fixme:StoreApprovalRequest通らない useから書き直しで通った
    public function store(StoreApprovalRequest $request)
    {
        Log::info('Request data:', $request->all());

        $approval = new Approval();
        $approval->fill($request->all());

        try {
            $approval->save();
            return redirect()
                ->route('approvals.index')
                ->with('notice', 'StoreApproval');
        } catch (\Throwable $th) {
            Log::error('Exception caught: ' . $th->getMessage());
            return back()->withErrors('エラーが発生しました');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function show(Approval $approval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function edit(Approval $approval)
    {
        $myApprovals = Auth::user()->approvals->where('approval_id', 1);

        $affiliations = Affiliation::where(function ($query) use (
            $myApprovals
        ) {
            foreach ($myApprovals as $approval) {
                $query->orWhere(function ($query) use ($approval) {
                    if (
                        $approval->affiliation->factory_id != 1 &&
                        $approval->affiliation->department_id == 1
                    ) {
                        $query->where(
                            'factory_id',
                            $approval->affiliation->factory_id
                        );
                    } elseif (
                        $approval->affiliation->factory_id != 1 &&
                        $approval->affiliation->department_id != 1
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
                    }
                });
            }
        })
            ->get()
            ->load(['factory', 'department', 'group']);

        $approvalCategories = ApprovalCategory::where('id', '!=', 1)->where('id', '!=', 5)->get();

        if ($myApprovals->contains('affiliation_id', 1)) {
            $affiliations = Affiliation::all()->load([
                'factory',
                'department',
                'group',
            ]);
            $approvalCategories = ApprovalCategory::all();
        }

        return view('approvals.edit')->with(
            compact('approval', 'affiliations', 'approvalCategories')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApprovalRequest  $request
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApprovalRequest $request, Approval $approval)
    {
        Log::info('Request data:', $request->all());

        $approval->fill($request->all());
        try {
            $approval->save();
            return redirect()
                ->route('approvals.index')
                ->with('notice', 'UpdateApproval');
        } catch (\Throwable $th) {
            Log::error('Exception caught: ' . $th->getMessage());
            return back()->withErrors('エラーが発生しました');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approval $approval)
    {
        Log::info('Destroy data:', $approval->getAttributes());

        $isAdmin = Auth::user()->approvals->where('approval_id', 1);

        if ($approval->approval_id === 1 && $isAdmin->count() === 1) {
            return back()->withErrors('1人以上の管理者が必要です。管理者を削除することはできません。');
        }

        try {
            $approval->delete();
            return redirect()
                ->route('approvals.index')
                ->with('notice', 'DestroyApproval');
        } catch (\Throwable $th) {
            Log::error('Exception caught: ' . $th->getMessage());
            return back()->withErrors('エラーが発生しました');
        }
    }

    public function import(Request $request)
    {
        $excelFile = $request->file('excel_file');
        $excelFile->store('excels');
        Excel::import(new ApprovalImport(), $excelFile);

        return redirect()
            ->route('import_form')
            ->with('notice', '権限インポート完了！');
    }
}
