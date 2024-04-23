<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\SizeOfOrganizationDataTable;
use App\Http\Requests\{
    PostSizeOfOrganization
};
use App\Models\{
    OrganizationDetail,
    SizeOfOrganization
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SizeOfOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SizeOfOrganizationDataTable $dataTable)
    {
        $page = 'admin.size_of_organization.list';
        $title = 'Size of Organization';
        $js = 'admin.size_of_organization.scriptjs';
        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.size_of_organization.add';
        $title = 'Add Size of Organization';
        $js = 'admin.size_of_organization.scriptjs';
        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostSizeOfOrganization $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->size_range as $val) {

                $sizeRange = new SizeOfOrganization();
                $sizeRange->size_range = $val;
                $sizeRange->save();
            }
            DB::commit();
            toastr()->success('Size of Organization created successfully!');
            return redirect()->route('sizeoforganization.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('sizeoforganization.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('sizeoforganization.create');
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
        $page = 'admin.size_of_organization.edit';
        $title = 'Update Size of Organization';
        $js = 'admin.size_of_organization.scriptjs';
        $getData = SizeOfOrganization::Findorfail($ids);
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
            $update = SizeOfOrganization::Findorfail($ids);
            $update->size_range = $request->size_range;
            $update->save();
            DB::commit();
            toastr()->success('Size of Organization updated successfully!');
            return redirect()->route('sizeoforganization.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('sizeoforganization.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('sizeoforganization.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $delete = SizeOfOrganization::Findorfail($ids)->delete();
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
    }

    public function SizeOfOrganizationExist(Request $request)
    {
        try {

            $eventType = SizeOfOrganization::where(['size_range' => $request->size_range])->get();

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
            $eventType = OrganizationDetail::where(['size_of_organization_id' => $ids])->get();

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
