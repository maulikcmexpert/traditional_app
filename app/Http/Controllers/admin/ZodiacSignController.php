<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ZodiacSignDataTable;
use App\Http\Requests\{
    PostZodiacSign
};
use App\Models\{
    UserDetail,
    ZodiacSign
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ZodiacSignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ZodiacSignDataTable $dataTable)
    {
        $page = 'admin.zodiacsign.list';
        $title = 'Zodiac Sign';
        $js = 'admin.zodiacsign.scriptjs';
        $ZodiacCount = ZodiacSign::count();
        return $dataTable->render('layouts.layout', compact('page', 'title', 'js', 'ZodiacCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.zodiacsign.add';
        $title = 'Add Zodiac Sign';
        $js = 'admin.zodiacsign.scriptjs';

        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostZodiacSign $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->zodiac_sign as $val) {

                $zodiacSign = new ZodiacSign();
                $zodiacSign->zodiac_sign = $val;
                $zodiacSign->save();
            }
            DB::commit();
            toastr()->success('Zodiac Sign created successfully!');
            return redirect()->route('zodiacsign.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('zodiacsign.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('zodiacsign.create');
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
        $page = 'admin.zodiacsign.edit';
        $title = 'Update Zodiac Sign';
        $js = 'admin.zodiacsign.scriptjs';
        $getData = ZodiacSign::Findorfail($ids);
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
            $update = ZodiacSign::Findorfail($ids);
            $update->zodiac_sign = $request->zodiac_sign;
            $update->save();
            DB::commit();
            toastr()->success('Zodiac Sign updated successfully!');
            return redirect()->route('zodiacsign.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('zodiacsign.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('zodiacsign.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $delete = ZodiacSign::Findorfail($ids)->delete();
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
    }

    public function zodiacsignExist(Request $request)
    {
        try {

            $eventType = ZodiacSign::where(['zodiac_sign' => $request->zodiacsign])->get();

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
            $eventType = UserDetail::where(['zodiac_sign_id' => $ids])->get();

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
