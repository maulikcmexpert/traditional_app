<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ReligionDataTable;
use App\Http\Requests\{
    PostReligion
};
use App\Models\{
    Religion,
    UserDetail
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ReligionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ReligionDataTable $dataTable)
    {
        $page = 'admin.religion.list';
        $title = 'Religion';
        $js = 'admin.religion.scriptjs';
        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.religion.add';
        $title = 'Add Religion';
        $js = 'admin.religion.scriptjs';
        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostReligion $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->religion as $val) {

                $religion = new Religion();
                $religion->religion = $val;
                $religion->save();
            }
            DB::commit();
            toastr()->success('Lifestyle created successfully !');
            return redirect()->route('religion.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('religion.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('religion.create');
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
        $page = 'admin.religion.edit';
        $title = 'Update Lifestyle';
        $js = 'admin.religion.scriptjs';
        $getData = Religion::Findorfail($ids);
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
            $update = Religion::Findorfail($ids);
            $update->religion = $request->religion;
            $update->save();
            DB::commit();
            toastr()->success('Religion updated successfully !');
            return redirect()->route('religion.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('religion.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('religion.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $delete = Religion::Findorfail($ids)->delete();
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
    }

    public function ReligionExist(Request $request)
    {
        try {

            $eventType = Religion::where(['religion' => $request->religion])->get();

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
            $eventType = UserDetail::where(['religion_id' => $ids])->get();

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
