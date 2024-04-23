<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\BlockReasonDataTable;
use App\Http\Requests\{
    PostBlockReason
};
use App\Models\{
    BlockReason,
    ProfileBlock
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class BlockReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BlockReasonDataTable $dataTable)
    {
        $page = 'admin.block_reason.list';
        $title = 'Block Reaason';
        $js = 'admin.block_reason.scriptjs';
        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }


    public function create()
    {
        $page = 'admin.block_reason.add';
        $title = 'Add Block Reason';
        $js = 'admin.block_reason.scriptjs';
        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(PostBlockReason $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->block_reason as $val) {

                $blockReason = new BlockReason();
                $blockReason->reason = $val;
                $blockReason->save();
            }
            DB::commit();
            toastr()->success('Block Reason created successfully!');
            return redirect()->route('blockreason.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('blockreason.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('blockreason.create');
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
        $page = 'admin.block_reason.edit';
        $title = 'Update Block Reason';
        $js = 'admin.block_reason.scriptjs';
        $getData = BlockReason::Findorfail($ids);
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
            $update = BlockReason::Findorfail($ids);
            $update->reason = $request->block_reason;
            $update->save();
            DB::commit();
            toastr()->success('Block Reason updated successfully!');
            return redirect()->route('blockreason.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('blockreason.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('blockreason.create');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $delete = BlockReason::Findorfail($ids)->delete();
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
    }

    public function BlockReasonExist(Request $request)
    {
        try {

            $eventType = BlockReason::where(['reason' => $request->block_reason])->get();

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
            $eventType = ProfileBlock::where(['block_reason_id' => $ids])->get();

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
