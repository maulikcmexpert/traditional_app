<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LegalAgreement;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class LegalAgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = 'admin.legal_agreement.add';
        $title = 'Legal Agreement';
        $js = 'admin.legal_agreement.scriptjs';
        $legalAgreement = LegalAgreement::first();
        return view('layouts.layout', compact('page', 'title', 'js', 'legalAgreement'));
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
            $leagalAgreement = LegalAgreement::first();
            if ($leagalAgreement == null) {

                $agreement = new LegalAgreement();
                $agreement->privacy_policy = $request->privacy_policy;
                $agreement->term_and_condition = $request->term_and_condition;
                $agreement->save();
            } else {
                $leagalAgreement->privacy_policy = $request->privacy_policy;

                $leagalAgreement->term_and_condition = $request->term_and_condition;
                $leagalAgreement->save();
            }


            DB::commit();
            toastr()->success('Legal Agreement updated successfully !');
            return redirect()->route('legal_agreement.index');
        } catch (Exception $e) {

            toastr()->error("something went wrong");
            return redirect()->route('legal_agreement.create');
        } catch (QueryException $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->route('legal_agreement.create');
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
