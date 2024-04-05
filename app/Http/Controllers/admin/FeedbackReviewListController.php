<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\FeedbackReviewListDataTable;
use App\Http\Requests\{
    PostFeedbackReviewList
};
use App\Models\{
    FeedbackReviewList
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class FeedbackReviewListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FeedbackReviewListDataTable $dataTable)
    {
        $page = 'admin.feedback_review_list.list';
        $title = 'Feedback Review List';
        $js = 'admin.feedback_review_list.scriptjs';
        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
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



    public function FeedbackReviewListExist(Request $request)
    {
        try {

            $eventType = FeedbackReviewList::where(['feedback_review' => $request->feedback_review])->get();

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
