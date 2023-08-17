<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreApprovalRequest;
use App\Http\Requests\StoreApprovalRequest;
use App\Http\Requests\UpdateApprovalRequest;
use App\Models\Affiliation;
use App\Models\Approval;
use App\Models\ApprovalCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $my_approvals = Auth::user()->approvals->where('approval_id', 1);
        $approvals = Approval::whereHas('user', function ($query) use (
            $my_approvals
        ) {
            $query->where(function ($query) use ($my_approvals) {
                foreach ($my_approvals as $approval) {
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

        if ($my_approvals->contains('affiliation_id', 1)) {
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
        $my_approvals = Auth::user()->approvals->where('approval_id', 1);
        $users = User::whereHas('affiliation', function ($query) use (
            $my_approvals
        ) {
            $query->where(function ($query) use ($my_approvals) {
                foreach ($my_approvals as $approval) {
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
                                )
                                ->where(
                                    'group_id',
                                    $approval->affiliation->group_id
                                );
                        });
                    }
                }
            });
        })->get();

        $affiliations = Affiliation::where(function ($query) use (
            $my_approvals
        ) {
            foreach ($my_approvals as $approval) {
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
                            )
                            ->where(
                                'group_id',
                                $approval->affiliation->group_id
                            );
                    }
                });
            }
        })->get();

        $approval_categories = ApprovalCategory::where('id', '!=', 1)->get();

        if ($my_approvals->contains('affiliation_id', 1)) {
            $users = User::all();
            $affiliations = Affiliation::all();
            $approval_categories = ApprovalCategory::all();
        }

        return view('approvals.create')->with(
            compact(
                'users',
                'affiliations',
                'approval_categories'
            )
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
        $approval = new Approval();
        $approval->fill($request->all());

        try {
            $approval->save();
            return redirect()
                ->route('approvals.index')
                ->with('notice', 'StoreApproval');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
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
        $my_approvals = Auth::user()->approvals->where('approval_id', 1);

        $affiliations = Affiliation::where(function ($query) use (
            $my_approvals
        ) {
            foreach ($my_approvals as $approval) {
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
                            )
                            ->where(
                                'group_id',
                                $approval->affiliation->group_id
                            );
                    }
                });
            }
        })->get();

        $approval_categories = ApprovalCategory::where('id', '!=', 1)->get();

        if ($my_approvals->contains('id', 1)) {
            $affiliations = Affiliation::all();
            $approval_categories = ApprovalCategory::all();
        }
        
        return view('approvals.edit')->with(
            compact(
                'approval',
                'affiliations',
                'approval_categories'
            )
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
        $approval->fill($request->all());
        try {
            $approval->save();
            return redirect()
                ->route('approvals.index')
                ->with('notice', 'UpdateApproval');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
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
        try {
            $approval->delete();
            return redirect()
                ->route('approvals.index')
                ->with('notice', 'DestroyApproval');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }
}
