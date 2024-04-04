<?php

namespace App\DataTables;

use App\Models\InterestAndHobby;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InterestAndHobbiesDataTable extends DataTable
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
                $editRoute = route('interest_and_hobby.edit', $id);
                $deleteRoute = route('interest_and_hobby.destroy', $id);


                return '<div class="d-flex gap-2"><a class="editBtns" href="' . $editRoute . '"><i class="fas fa-edit"></i></a>
                <a class="deleteBtns" href="javascript:" data-url="' . $deleteRoute . '" id="delete"><i class="fas fa-trash text-danger"></i></a></div>
                ';
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(InterestAndHobby $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('interestandhobbies-table')
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
            ])
            ->parameters([
                'buttons' => ['pdf'],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('interest_and_hobby'),

            Column::make('action'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'InterestAndHobbies_' . date('YmdHis');
    }
}
