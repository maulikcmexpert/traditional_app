<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\CultureDataTable;
use App\Http\Requests\{
    PostCulture
};
use App\Models\{
    UserDetail,
    Culture
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class CultureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CultureDataTable $dataTable)
    {
        $page = 'admin.culture.list';
        $title = 'Culture';
        $js = 'admin.culture.scriptjs';

        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.culture.add';
        $title = 'Add Culture';
        $js = 'admin.culture.scriptjs';

        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->culture as $val) {

                $culture = new Culture();
                $culture->culture = $val;
                $culture->save();
            }
            DB::commit();
            toastr()->success('Culture created successfully !');
            return redirect()->route('culture.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('culture.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('culture.create');
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
        $page = 'admin.culture.edit';
        $title = 'Update Culture';
        $js = 'admin.culture.scriptjs';
        $getData = Culture::Findorfail($ids);
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
            $update = Culture::Findorfail($ids);
            $update->culture = $request->culture;
            $update->save();
            DB::commit();
            toastr()->success('Culture updated successfully !');
            return redirect()->route('culture.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('culture.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('culture.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $delete = Culture::Findorfail($ids)->delete();
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
    }

    public function CultureExist(Request $request)
    {
        try {

            $eventType = Culture::where(['culture' => $request->culture])->get();

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
            $eventType = UserDetail::where(['culture_id' => $ids])->get();

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
