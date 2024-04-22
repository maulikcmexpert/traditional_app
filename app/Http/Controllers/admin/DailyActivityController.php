<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\DailyActivityDataTable;
use App\Http\Requests\{
    PostDailyActivity
};
use App\Models\{
    UserDetail,
    DailyActivity
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class DailyActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DailyActivityDataTable $dataTable)
    {
        $page = 'admin.daily_activity.list';
        $title = 'Daily Activity';
        $js = 'admin.daily_activity.scriptjs';

        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.daily_activity.add';
        $title = 'Add Daily Activity';
        $js = 'admin.daily_activity.scriptjs';

        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostDailyActivity $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->daily_activity as $val) {

                $daily_activity = new DailyActivity();
                $daily_activity->daily_activity = $val;
                $daily_activity->save();
            }
            DB::commit();
            toastr()->success('Daily Activity created successfully!');
            return redirect()->route('daily_activity.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('daily_activity.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('daily_activity.create');
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
        $page = 'admin.daily_activity.edit';
        $title = 'Update Body Type';
        $js = 'admin.daily_activity.scriptjs';
        $getData = DailyActivity::Findorfail($ids);
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
            $update = DailyActivity::Findorfail($ids);
            $update->daily_activity = $request->daily_activity;
            $update->save();
            DB::commit();
            toastr()->success('Body Type updated successfully!');
            return redirect()->route('daily_activity.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('daily_activity.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('daily_activity.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $delete = DailyActivity::Findorfail($ids)->delete();
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
    }

    public function DailyActivityExist(Request $request)
    {
        try {

            $eventType = DailyActivity::where(['daily_activity' => $request->daily_activity])->get();

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
            $eventType = UserDetail::where(['daily_activity_id' => $ids])->get();

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
