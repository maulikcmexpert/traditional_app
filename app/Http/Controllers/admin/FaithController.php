<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\DataTables\FaithDataTable;
use App\Http\Requests\{
    PostFaith
};

use App\Models\{
    Faith,
    UserDetail
};

use Illuminate\Http\Request;

class FaithController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FaithDataTable $dataTable)
    {
        $page = 'admin.faith.list';
        $title = 'Faith';
        $js = 'admin.faith.scriptjs';
        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.faith.add';
        $title = 'Add Faith';
        $js = 'admin.faith.scriptjs';

        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFaith $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->zodiac_sign as $val) {

                $faith = new Faith();
                $faith->zodiac_sign = $val;
                $faith->save();
            }
            DB::commit();
            toastr()->success('Faith created successfully !');
            return redirect()->route('faith.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('faith.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('faith.create');
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
        $page = 'admin.faith.edit';
        $title = 'Update Faith';
        $js = 'admin.faith.scriptjs';
        $getData = Faith::Findorfail($ids);
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
            $update = Faith::Findorfail($ids);
            $update->faith = $request->faith;
            $update->save();
            DB::commit();
            toastr()->success('Faith updated successfully !');
            return redirect()->route('faith.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('faith.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('faith.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $delete = Faith::Findorfail($ids)->delete();
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
    }


    public function FaithExist(Request $request)
    {
        try {

            $eventType = Faith::where(['faith' => $request->faith])->get();

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

            $eventType = UserDetail::where(['faith_id' => $ids])->get();

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
