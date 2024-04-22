<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\InterestAndHobbiesDataTable;
use App\Http\Requests\{
    PostInterestAndHobbies
};
use App\Models\{
    InterestAndHobby,
    UserInterestAndHobby
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InterestAndHobbiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InterestAndHobbiesDataTable $dataTable)
    {
        $page = 'admin.interest_and_hobbies.list';
        $title = 'Interest and hobby';
        $js = 'admin.interest_and_hobbies.scriptjs';
        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.interest_and_hobbies.add';
        $title = 'Add Interest and hobby';
        $js = 'admin.interest_and_hobbies.scriptjs';
        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostInterestAndHobbies $request)
    {


        try {
            DB::beginTransaction();
            foreach ($request->interest_and_hobby as $val) {

                $interestandhobby = new InterestAndHobby();
                $interestandhobby->interest_and_hobby = $val;
                $interestandhobby->save();
            }
            DB::commit();
            toastr()->success('Interest and Hobby created successfully !');
            return redirect()->route('interest_and_hobby.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('interest_and_hobby.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('interest_and_hobby.create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ids = decrypt($id);
        $page = 'admin.interest_and_hobbies.edit';
        $title = 'Update interest and hobby';
        $js = 'admin.interest_and_hobbies.scriptjs';
        $getData = InterestAndHobby::Findorfail($ids);
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
            $update = InterestAndHobby::Findorfail($ids);
            $update->interest_and_hobby = $request->interest_and_hobby;
            $update->save();
            DB::commit();
            toastr()->success('Interest and Hobby updated successfully !');
            return redirect()->route('interest_and_hobby.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('interest_and_hobby.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('interest_and_hobby.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $checkSelected = UserInterestAndHobby::where(['interest_and_hobby_id' => $ids])->count();
            if ($checkSelected == 0) {

                $delete = InterestAndHobby::Findorfail($ids)->delete();
                return response()->json(true);
            } else {
                return response()->json(false);
            }
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
    }




    public function interestAndHobbyExist(Request $request)
    {
        try {

            $eventType = InterestAndHobby::where(['interest_and_hobby' => $request->interest_and_hobby])->get();

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
            $eventType = UserInterestAndHobby::where(['interest_and_hobby_id' => $ids])->get();

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
