<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ExerciseDataTable;
use App\Http\Requests\{
    PostExercise
};
use App\Models\{
    UserDetail,
    Exercise
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ExerciseDataTable $dataTable)
    {
        $page = 'admin.exercise.list';
        $title = 'Exercise';
        $js = 'admin.exercise.scriptjs';

        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.exercise.add';
        $title = 'Add Exercise';
        $js = 'admin.exercise.scriptjs';

        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostExercise $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->exercise as $val) {

                $exercise = new Exercise();
                $exercise->exercise = $val;
                $exercise->save();
            }
            DB::commit();
            toastr()->success('Exercise created successfully!');
            return redirect()->route('exercise.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('exercise.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('exercise.create');
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
        $page = 'admin.exercise.edit';
        $title = 'Update Eating';
        $js = 'admin.exercise.scriptjs';
        $getData = Exercise::Findorfail($ids);
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
            $update = Exercise::Findorfail($ids);
            $update->exercise = $request->exercise;
            $update->save();
            DB::commit();
            toastr()->success('Exercise updated successfully!');
            return redirect()->route('exercise.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('exercise.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('exercise.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $delete = Exercise::Findorfail($ids)->delete();
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
    }

    public function ExerciseExist(Request $request)
    {
        try {

            $eventType = Exercise::where(['exercise' => $request->exercise])->get();

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
            $eventType = UserDetail::where(['exercise_id' => $ids])->get();

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
