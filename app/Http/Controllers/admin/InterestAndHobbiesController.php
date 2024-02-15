<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\InterestAndHobbiesDataTable;

class InterestAndHobbiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InterestAndHobbiesDataTable $dataTable)
    {
        $page = 'admin.interest_and_hobbies.list';
        $title = 'Interest and hobbies';

        return $dataTable->render('layouts.layout', compact('page', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.interest_and_hobbies.add';
        $title = 'Add Interest and hobbies';
        $js = 'admin.interest_and_hobbies.scriptjs';
        return view('layouts.layout', compact('page', 'title', 'js'));
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
}
