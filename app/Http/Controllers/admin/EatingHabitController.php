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
        dd($request);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
