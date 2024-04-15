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
        $title = 'General Setting';
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

        try {

            DB::beginTransaction();
            $checkSetting = Setting::first();
            if ($checkSetting == null) {

                $setting = new Setting();
                $setting->min_age = $request->min_age;
                $setting->max_age = $request->max_age;
                $setting->ghost_count = $request->ghost_count;
                $setting->ghost_day = $request->ghost_day;
                $setting->no_chat_day_duration = $request->no_chat_day_duration;
                $setting->save();
            } else {
                $checkSetting->min_age = $request->min_age;
                $checkSetting->max_age = $request->max_age;
                $checkSetting->ghost_count = $request->ghost_count;
                $checkSetting->ghost_day = $request->ghost_day;
                $checkSetting->no_chat_day_duration = $request->no_chat_day_duration;
                $checkSetting->save();
            }


            DB::commit();
            toastr()->success('General setting updated successfully !');
            return redirect()->route('generalsetting.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('generalsetting.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('generalsetting.create');
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
