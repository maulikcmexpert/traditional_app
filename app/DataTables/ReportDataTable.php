<?php

namespace App\DataTables;

use App\Models\Report;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReportDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('report_user', function ($row) {
                return $row->reporter_full_name;
            })
            ->addColumn('to_be_reporter_user', function ($row) {

                return $row->to_reporter_full_name;
            })
            ->addColumn('report_media', function ($row) {
                $img = "-";
                if ($row->report_image != null || $row->report_image != "") {

                    $img = asset('storage/report_media/' . $row->report_image);
                }
                return '<img src="' . $img . '" height="100px" class="repor-img" >';
            })
            ->addColumn('action', function ($row) {

                $id = encrypt($row->id);
                $view = route('report_management.show', $id);

                return '<div class="d-flex gap-2"><a class="editBtns" href="' . $view . '"><i class="fas fa-comment"></i></a></div>
            ';
            })
            ->rawColumns(['report_user', 'to_be_reporter_user', 'report_media', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Report $model): QueryBuilder
    {
        // return $model->newQuery()->with(['reporter_user', 'to_reporter_user'])->orderBy('id', 'DESC');
        return $model->newQuery()
            ->join('users as reporter_user', 'reports.reporter_user_id', '=', 'reporter_user.id')
            ->join('users as to_reporter_user', 'reports.to_be_reported_user_id', '=', 'to_reporter_user.id')
            ->select('reports.*', 'reporter_user.full_name as reporter_full_name', 'to_reporter_user.full_name as to_reporter_full_name')
            ->orderBy('reports.id', 'DESC');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('report-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('reporter_full_name')->searchable(true),
            Column::make('to_reporter_full_name')->searchable(true),
            Column::make('report_message'),
            Column::make('report_media'),
            Column::make('action'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Report_' . date('YmdHis');
    }
}
