<?php

namespace App\DataTables;

use App\Models\InterestAndHobby;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InterestAndHobbiesDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($row) {
                $editRoute = route('interest_and_hobby.edit', encrypt($row->id));
                $deleteRoute = route('interest_and_hobby.destroy', encrypt($row->id));

                return '<div class="d-flex gap-2">
                            <a class="editBtns" href="' . $editRoute . '"><i class="fas fa-edit"></i></a>
                            <a class="deleteBtns" href="javascript:" data-id="' . encrypt($row->id) . '" data-url="' . $deleteRoute . '" id="delete"><i class="fas fa-trash text-danger"></i></a>
                        </div>';
            })
            ->setRowId('id');
    }

    public function query(InterestAndHobby $model)
    {
        return $model->newQuery()->orderByDesc('id');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('interestandhobbies-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['excel', 'csv', 'pdf', 'print', 'reset', 'reload']
            ]);
    }

    protected function getColumns()
    {
        return [
            Column::make('interest_and_hobby')->title('Interest and Hobbies'),
            Column::make('action')->title('Action')->orderable(false)->searchable(false),
        ];
    }

    protected function filename()
    {
        return 'InterestAndHobbies_' . date('YmdHis');
    }
}
