<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\EatingHabitDataTable;
use App\Http\Requests\{
    PostEatingHabit
};
use App\Models\{
    UserDetail,
    EatingHabit
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class EatingHabitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EatingHabitDataTable $dataTable)
    {
        $page = 'admin.eating_habit.list';
        $title = 'Eating Habit';
        $js = 'admin.eating_habit.scriptjs';

        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.eating_habit.add';
        $title = 'Add Eating Habit';
        $js = 'admin.eating_habit.scriptjs';

        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostEatingHabit $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->eating_habit as $val) {

                $eating_habit = new EatingHabit();
                $eating_habit->eating_habit = $val;
                $eating_habit->save();
            }
            DB::commit();
            toastr()->success('Eating Habit created successfully!');
            return redirect()->route('eating_habit.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('eating_habit.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('eating_habit.create');
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
        $page = 'admin.eating_habit.edit';
        $title = 'Update Eating Habit';
        $js = 'admin.eating_habit.scriptjs';
        $getData = EatingHabit::Findorfail($ids);
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
            $update = EatingHabit::Findorfail($ids);
            $update->eating_habit = $request->eating_habit;
            $update->save();
            DB::commit();
            toastr()->success('Eating Habit updated successfully!');
            return redirect()->route('eating_habit.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('eating_habit.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('eating_habit.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $delete = EatingHabit::Findorfail($ids)->delete();
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
    }

    public function EatingHabitExist(Request $request)
    {
        try {

            $eventType = EatingHabit::where(['eating_habit' => $request->eating_habit])->get();

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
            $eventType = UserDetail::where(['eating_habit_id' => $ids])->get();

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
