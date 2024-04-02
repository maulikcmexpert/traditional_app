<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\LifeStyleDataTable;
use App\Http\Requests\{
    PostLifestyle
};
use App\Models\{
    Lifestyle
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LifeStyleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LifeStyleDataTable $dataTable)
    {
        $page = 'admin.lifestyle.list';
        $title = 'Lifestyle';
        $js = 'admin.lifestyle.scriptjs';
        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.lifestyle.add';
        $title = 'Add Lifestyle';
        $js = 'admin.lifestyle.scriptjs';
        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostLifestyle $request)
    {

        try {
            DB::beginTransaction();
            foreach ($request->lifestyle as $val) {

                $lifestyle = new Lifestyle();
                $lifestyle->lifestyle = $val;
                $lifestyle->save();
            }
            DB::commit();
            toastr()->success('Lifestyle created successfully !');
            return redirect()->route('lifestyle.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('lifestyle.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('lifestyle.create');
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
        $page = 'admin.lifestyle.edit';
        $title = 'Update Lifestyle';
        $js = 'admin.lifestyle.scriptjs';
        $getData = Lifestyle::Findorfail($ids);
        return view('layouts.layout', compact('page', 'title', 'getData', 'js'));
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

    public function LifestyleExist(Request $request)
    {
        try {

            $eventType = Lifestyle::where(['life_style' => $request->lifestyle])->get();

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
}
