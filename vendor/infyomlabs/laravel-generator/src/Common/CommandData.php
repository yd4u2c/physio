<?php

namespace $NAMESPACE_DATATABLES$;

use $NAMESPACE_MODEL$\$MODEL_NAME$;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class $MODEL_NAME$DataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', '$VIEW_PREFIX$$MODEL_NAME_PLURAL_SNAKE$.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\$MODEL_NAME$ $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query($MODEL_NAME$ $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            $DATATABLE_COLUMNS$
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return '$MODEL_NAME_PLURAL_SNAKE$datatable_' . time();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

namespace $NAMESPACE_CONTROLLER$;

use $NAMESPACE_REQUEST$\Create$MODEL_NAME$Request;
use $NAMESPACE_REQUEST$\Update$MODEL_NAME$Request;
use $NAMESPACE_REPOSITORY$\$MODEL_NAME$Repository;
use $NAMESPACE_APP$\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class $MODEL_NAME$Controller extends AppBaseController
{
    /** @var  $MODEL_NAME$Repository */
    private $$MODEL_NAME_CAMEL$Repository;

    public function __construct($MODEL_NAME$Repository $$MODEL_NAME_CAMEL$Repo)
    {
        $this->$MODEL_NAME_CAMEL$Repository = $$MODEL_NAME_CAMEL$Repo;
    }

    /**
     * Display a listing of the $MODEL_NAME$.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $$MODEL_NAME_PLURAL_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->$RENDER_TYPE$;

        return view('$VIEW_PREFIX$$MODEL_NAME_PLURAL_SNAKE$.index')
            ->with('$MODEL_NAME_PLURAL_CAMEL$', $$MODEL_NAME_PLURAL_CAMEL$);
    }

    /**
     * Show the form for creating a new $MODEL_NAME$.
     *
     * @return Response
     */
    public function create()
    {
        return view('$VIEW_PREFIX$$MODEL_NAME_PLURAL_SNAKE$.create');
    }

    /**
     * Store a newly created $MODEL_NAME$ in storage.
     *
     * @param Create$MODEL_NAME$Request $request
     *
     * @return Response
     */
    public function store(Create$MODEL_NAME$Request $request)
    {
        $input = $request->all();

        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->create($input);

        Flash::success('$MODEL_NAME_HUMAN$ saved successfully.');

        return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
    }

    /**
     * Display the specified $MODEL_NAME$.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            Flash::error('$MODEL_NAME_HUMAN$ not found');

            return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
        }

        return view('$VIEW_PREFIX$$MODEL_NAME_PLURAL_SNAKE$.show')->with('$MODEL_NAME_CAMEL$', $$MODEL_NAME_CAMEL$);
    }

    /**
     * Show the form for editing the specified $MODEL_NAME$.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            Flash::error('$MODEL_NAME_HUMAN$ not found');

            return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
        }

        return view('$VIEW_PREFIX$$MODEL_NAME_PLURAL_SNAKE$.edit')->with('$MODEL_NAME_CAMEL$', $$MODEL_NAME_CAMEL$);
    }

    /**
     * Update the specified $MODEL_NAME$ in storage.
     *
     * @param int $id
     * @param Update$MODEL_NAME$Request $request
     *
     * @return Response
     */
    public function update($id, Update$MODEL_NAME$Request $request)
    {
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            Flash::error('$MODEL_NAME_HUMAN$ not found');

            return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
        }

        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->update($request->all(), $id);

        Flash::success('$MODEL_NAME_HUMAN$ updated successfully.');

        return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
    }

    /**
     * Remove the specified $MODEL_NAME$ from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            Flash::error('$MODEL_NAME_HUMAN$ not found');

            return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
        }

        $this->$MODEL_NAME_CAMEL$Repository->delete($id);

        Flash::success('$MODEL_NAME_HUMAN$ deleted successfully.');

        return redirect(route('$ROUTE_NAMED_PREFIX$$MODEL_NAME_PLURAL_CAMEL$.index'));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          