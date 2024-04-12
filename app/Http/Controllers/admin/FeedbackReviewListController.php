<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\FeedbackReviewListDataTable;
use App\Http\Requests\{
    PostFeedbackReviewList
};
use App\Models\{
    FeedbackReview,
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
        $ids = decrypt($id);
        $page = 'admin.feedback_review_list.edit';
        $title = 'Update interest and hobby';
        $js = 'admin.feedback_review_list.scriptjs';
        $getData = FeedbackReviewList::Findorfail($ids);
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
            $update = FeedbackReviewList::Findorfail($ids);
            $update->feedback_review = $request->feedback_review;
            $update->save();
            DB::commit();
            toastr()->success('Feedback Review successfully !');
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $ids = decrypt($id);
            $delete = FeedbackReviewList::Findorfail($ids)->delete();
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        } catch (QueryException $e) {

            return response()->json(false);
        }
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

    public function selectedbyuser(Request $request)
    {
        try {


            $ids = decrypt($request->id);

            $eventType = FeedbackReview::pluck('feedback_review_id')->toArray();

            $mergedArray = [];
            foreach ($eventType as $element) {
                $ids = json_decode($element, true); // Decode to array
                $mergedArray = array_merge($mergedArray, $ids); // Merge arrays
            }
            dd($mergedArray);
            $occurrences = array_count_values($mergedArray);

            // Remove digits that occur only once
            $uniqueDigits = array_filter($occurrences, function ($value) {
                return $value > 1;
            });

            // Extract the keys (digits)
            $uniqueDigits = array_keys($uniqueDigits);


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
