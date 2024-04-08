<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
    PostGeneralSetting
};
use App\Models\{
    FeedbackReviewList,
    Setting
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = 'admin.general_setting.add';
        $title = 'Add Verification Object';
        $js = 'admin.general_setting.scriptjs';
        $setting = Setting::first();
        return view('layouts.layout', compact('page', 'title', 'js', 'setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostGeneralSetting $request)
    {
        dd($request->min_age);
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
            toastr()->success('Verfication Object created successfully !');
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
