<?php

namespace App\DataTables;

use App\Models\FeedbackReviewList;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FeedbackReviewListDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {


        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {

                $id = encrypt($row->id);
                $editRoute = route('feedbackreviewlist.edit', $id);
                $deleteRoute = route('feedbackreviewlist.destroy', $id);


                return '<div class="d-flex gap-2"><a class="editBtns" href="' . $editRoute . '"><i class="fas fa-edit"></i></a>
                <a class="deleteBtns" href="javascript:" data-id="' . $id . '"  data-url="' . $deleteRoute . '" id="delete"><i class="fas fa-trash text-danger"></i></a></div>
                ';
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(FeedbackReviewList $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'desc');;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('feedbackreviewlist-table')
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

            Column::make('feedback_review'),

            Column::make('action'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'FeedbackReviewList_' . date('YmdHis');
    }
}
