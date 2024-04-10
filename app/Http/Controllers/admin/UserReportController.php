<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ReportDataTable;

use App\Models\{
    Report,
    UserReportChat
};
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class UserReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ReportDataTable $dataTable)
    {
        $page = 'admin.report.list';
        $title = 'Report Management';


        return $dataTable->render('layouts.layout', compact('page', 'title'));
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

        $report_id =  decrypt($id);


        $page = 'admin.report.chatview';
        $title = 'View Chat Message';
        $userchat =  UserReportChat::with('sender_user')->where('report_id', $report_id)->get();

        return view('layouts.layout', compact('page', 'title', 'userchat'));
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
