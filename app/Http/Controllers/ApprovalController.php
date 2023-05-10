<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreApprovalRequest;
use App\Http\Requests\StoreApprovalRequest;
use App\Http\Requests\UpdateApprovalRequest;
use App\Models\Approval;
use App\Models\ApprovalCategory;
use App\Models\FactoryCategory;
use App\Models\DepartmentCategory;
use App\Models\GroupCategory;
use App\Models\User;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $approvals = Approval::all();
        return view('approvals.index')->with(compact('approvals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $factory_categories = FactoryCategory::all();
        $department_categories = DepartmentCategory::all();
        $group_categories = GroupCategory::all();
        $approval_categories = ApprovalCategory::all();
        return view('approvals.create')->with(compact('users', 'factory_categories', 'department_categories', 'group_categories', 'approval_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApprovalRequest  $request
     * @return \Illuminate\Http\Response
     */
    // FIXME:StoreApprovalRequest通らない useから書き直しで通った
    public function store(StoreApprovalRequest $request)
    {
        $approval = new Approval();
        $approval->fill($request->all());
        // dd($approval);

        try {
            $approval->save();
            return redirect()
                ->route('approvals.index')
                ->with('notice', '権限を追加しました');
        } catch (\Throwable $th) {
            return back()
                ->withErrors($th->getMessage());
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
        $factory_categories = FactoryCategory::all();
        $department_categories = DepartmentCategory::all();
        $group_categories = GroupCategory::all();
        $approval_categories = ApprovalCategory::all();
        return view('approvals.edit')->with(compact('approval', 'factory_categories', 'department_categories', 'group_categories', 'approval_categories'));
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
                ->with('notice', '権限を更新しました');
        } catch (\Throwable $th) {
            return back()
                ->withErrors($th->getMessage());
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
                ->with('notice', '権限を取り消しました');
        } catch (\Throwable $th) {
            return back()->withErrors($th->getMessage());
        }
    }
}
