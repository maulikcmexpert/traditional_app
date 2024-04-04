<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\CurseWordDataTable;
use App\Http\Requests\{
    PostCurseWord
};
use App\Models\{
    BadWord
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class CurseWordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CurseWordDataTable $dataTable)
    {
        $page = 'admin.curseword.list';
        $title = 'Curse Word';
        $js = 'admin.curseword.scriptjs';
        return $dataTable->render('layouts.layout', compact('page', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.curseword.add';
        $title = 'Add Curse Word';
        $js = 'admin.curseword.scriptjs';
        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCurseWord $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->words as $val) {

                $curseWord = new BadWord();
                $curseWord->words = $val;
                $curseWord->save();
            }
            DB::commit();
            toastr()->success('Curse Word created successfully !');
            return redirect()->route('curseword.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('curseword.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('curseword.create');
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
        $page = 'admin.curseword.edit';
        $title = 'Update Curse Word';
        $js = 'admin.curseword.scriptjs';
        $getData = BadWord::Findorfail($ids);
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

    public function CursewordExist(Request $request)
    {
        try {

            $eventType = BadWord::where(['words' => $request->words])->get();

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
