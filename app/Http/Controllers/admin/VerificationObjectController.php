<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\VerificationObjectDataTable;
use App\Http\Requests\{
    PostVerificationObject
};
use App\Models\{
    VerificationObject
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class VerificationObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VerificationObjectDataTable $dataTable)
    {
        $page = 'admin.verification_object.list';
        $title = 'Verification Object';
        $js = 'admin.verification_object.scriptjs';
        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.verification_object.add';
        $title = 'Add Verification Object';
        $js = 'admin.verification_object.scriptjs';
        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostVerificationObject $request)
    {
        try {

            DB::beginTransaction();

            if (!empty($request->object_image)) {
                $image = $request->object_image;
                $imageName = time() . $image->getClientOriginalExtension();
                $image->move(public_path('storage/verification_object'), $imageName);

                $verifyObj = new VerificationObject();
                $verifyObj->object_type = $request->object_type;
                $verifyObj->object_image = $imageName;
                $verifyObj->save();
            }


            DB::commit();
            toastr()->success('Verfication Object created successfully !');
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
}
