<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VersionSetting;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AppVersionSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $page = 'admin.version_setting.add';
        $title = 'App Version Setting';
        $js = 'admin.version_setting.scriptjs';
        $setting = VersionSetting::first();
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
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            $checkSetting = VersionSetting::first();
            if ($checkSetting == null) {

                $setting = new VersionSetting();
                $setting->android_version = $request->android_version;
                if ($request->android_in_force != null) {
                    $setting->android_in_force = $request->android_in_force;
                }
                $setting->ios_version = $request->ios_version;
                if ($request->ios_in_force != null) {
                    $setting->ios_in_force = $request->ios_in_force;
                }
                $setting->save();
            } else {
                $checkSetting->android_version = $request->android_version;
                if ($request->android_in_force != null) {

                    $checkSetting->android_in_force = $request->android_in_force;
                }
                $checkSetting->ios_version = $request->ios_version;
                if ($request->ios_in_force != null) {

                    $checkSetting->ios_in_force = $request->ios_in_force;
                }

                $checkSetting->save();
            }


            DB::commit();
            toastr()->success('Version setting updated successfully !');
            return redirect()->route('version_setting.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('version_setting.index');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('version_setting.index');
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
