<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\BodyTypeDataTable;
use App\Http\Requests\{
    PostBodyType
};
use App\Models\{
    UserDetail,
    BodyType
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class BodyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BodyTypeDataTable $dataTable)
    {
        $page = 'admin.body_type.list';
        $title = 'Body Type';
        $js = 'admin.body_type.scriptjs';

        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.body_type.add';
        $title = 'Add Body Type';
        $js = 'admin.body_type.scriptjs';

        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostBodyType $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->body_type as $val) {

                $body_type = new BodyType();
                $body_type->body_type = $val;
                $body_type->save();
            }
            DB::commit();
            toastr()->success('Body Type created successfully !');
            return redirect()->route('body_type.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('body_type.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('body_type.create');
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
        $page = 'admin.body_type.edit';
        $title = 'Update Body Type';
        $js = 'admin.body_type.scriptjs';
        $getData = BodyType::Findorfail($ids);
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
            $update = BodyType::Findorfail($ids);
            $update->body_type = $request->body_type;
            $update->save();
            DB::commit();
            toastr()->success('Body Type updated successfully !');
            return redirect()->route('body_type.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('body_type.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('body_type.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $delete = BodyType::Findorfail($ids)->delete();
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
    }

    public function BodyTypeExist(Request $request)
    {
        try {

            $eventType = BodyType::where(['body_type' => $request->body_type])->get();

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
            $eventType = UserDetail::where(['body_type_id' => $ids])->get();

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
