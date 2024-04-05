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
        $page = 'admin.feedback_review_list.add';
        $title = 'Add Feedback Review List';
        $js = 'admin.feedback_review_list.scriptjs';
        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFeedbackReviewList $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->feedback_review as $val) {

                $feedbackrev = new FeedbackReviewList();
                $feedbackrev->feedback_review = $val;
                $feedbackrev->save();
            }
            DB::commit();
            toastr()->success('Feedback Review created successfully !');
            return redirect()->route('feedbackreviewlist.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('feedbackreviewlist.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('feedbackreviewlist.create');
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
