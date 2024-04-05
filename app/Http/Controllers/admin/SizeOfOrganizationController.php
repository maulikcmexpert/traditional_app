<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\SizeOfOrganizationDataTable;
use App\Http\Requests\{
    PostSizeOfOrganization
};
use App\Models\{
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
        $title = 'Size Of Organization';
        $js = 'admin.size_of_organization.scriptjs';
        return $dataTable->render('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.size_of_organization.add';
        $title = 'Add Size Of Organization';
        $js = 'admin.size_of_organization.scriptjs';
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
