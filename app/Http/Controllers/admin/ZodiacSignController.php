<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ZodiacSignDataTable;
use App\Http\Requests\{
    PostZodiacSign
};
use App\Models\{
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
        $ZodiacCount = ZodiacSign::count();
        return $dataTable->render('layouts.layout', compact('page', 'title', 'ZodiacCount'));
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
    public function store(Request $request)
    {
        //
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

    public function zodiacsignExist(Request $request)
    {
        try {

            $eventType = ZodiacSign::where(['zodiac' => $request->zodiacsign])->get();

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
