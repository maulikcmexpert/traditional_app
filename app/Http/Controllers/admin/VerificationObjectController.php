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
                $imageName = time() . 'objverify.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/verification_object'), $imageName);

                $verifyObj = new VerificationObject();
                $verifyObj->object_type = $request->object_type;
                $verifyObj->object_image = $imageName;
                $verifyObj->save();
            }


            DB::commit();
            toastr()->success('Verfication Object created successfully!');
            return redirect()->route('verificationobject.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('verificationobject.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('verificationobject.create');
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
        $page = 'admin.verification_object.edit';
        $title = 'Update Object Verification';
        $js = 'admin.verification_object.scriptjs';
        $getData = VerificationObject::Findorfail($ids);
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

            $updateVerifyObj = VerificationObject::where('id', $ids)->first();
            if (!empty($request->object_image_edit)) {
                $filePath = public_path('storage/verification_object/' . $updateVerifyObj->object_image);
                if (file_exists($filePath)) {

                    unlink($filePath);
                }

                $image = $request->object_image_edit;
                $imageName = time() . 'objverify.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/verification_object'), $imageName);
                $updateVerifyObj->object_image = $imageName;
            }
            $updateVerifyObj->object_type = $request->object_type;
            $updateVerifyObj->save();
            DB::commit();
            toastr()->success('Verification Object updated successfully!');
            return redirect()->route('verificationobject.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('verificationobject.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('verificationobject.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function VerificationObjectExist(Request $request)
    {
        try {

            $eventType = VerificationObject::where(['object_type' => $request->object_type])->get();

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
