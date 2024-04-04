<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\CurseWordDataTable;
use App\Http\Requests\{
    PostCurseWord
};
use App\Models\{
    BadWord
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class CurseWordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CurseWordDataTable $dataTable)
    {
        $page = 'admin.curseword.list';
        $title = 'Curse Word';
        $js = 'admin.curseword.scriptjs';
        return $dataTable->render('layouts.layout', compact('page', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'admin.curseword.add';
        $title = 'Add Curse Word';
        $js = 'admin.curseword.scriptjs';
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
