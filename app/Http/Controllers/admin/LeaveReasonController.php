<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\LeaveReasonDataTable;
use App\Http\Requests\{
    PostLeaveReason
};
use App\Models\{
    ApproachRequest,
    LeaveReason
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class LeaveReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LeaveReasonDataTable $dataTable)
    {
        $page = 'admin.leave_reason.list';
        $title = 'Leave Reason';
        $js = 'admin.leave_reason.scriptjs';
        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.leave_reason.add';
        $title = 'Add Leave Reason';
        $js = 'admin.leave_reason.scriptjs';
        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostLeaveReason $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->reason as $val) {

                $leavereason = new LeaveReason();
                $leavereason->reason = $val;
                $leavereason->save();
            }
            DB::commit();
            toastr()->success('Leave Reason created successfully!');
            return redirect()->route('leavereason.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('leavereason.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('leavereason.create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ids = decrypt($id);
        $page = 'admin.leave_reason.edit';
        $title = 'Update Leave Reason';
        $js = 'admin.leave_reason.scriptjs';
        $getData = LeaveReason::Findorfail($ids);
        return view('layouts.layout', compact('page', 'title', 'getData', 'js'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $ids = decrypt($id);
            $update = LeaveReason::Findorfail($ids);
            $update->reason = $request->reason;
            $update->save();
            DB::commit();
            toastr()->success('Leave Reason updated successfully!');
            return redirect()->route('leavereason.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('leavereason.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('leavereason.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $delete = LeaveReason::Findorfail($ids)->delete();
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
    }

    public function LeaveReasonExist(Request $request)
    {
        try {

            $eventType = LeaveReason::where(['reason' => $request->reason])->get();

            if (count($eventType) > 0) {

                if (isset($request->id) && !empty($request->id)) {



                    if ($eventType[0]->id == decrypt($request->id)) {



                        $return =  true;

                        echo json_encode($return);

                        exit;
                    }
                }

                $return =  false;
            } else {

                $return = true;
            }

            echo json_encode($return);

            exit;
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(false);
        }
    }

    public function selectedbyuser(Request $request)
    {
        try {


            $ids = decrypt($request->id);
            $eventType = ApproachRequest::where(['leave_reason_id' => $ids])->onlyTrashed()->get();

            if (count($eventType) > 0) {

                $return =  false;
            } else {

                $return = true;
            }

            echo json_encode($return);

            exit;
        } catch (QueryException $e) {

            DB::rollBack();

            return response()->json(false);
        }
    }
}
