<?php

namespace $NAMESPACE_API_CONTROLLER$;

use $NAMESPACE_API_REQUEST$\Create$MODEL_NAME$APIRequest;
use $NAMESPACE_API_REQUEST$\Update$MODEL_NAME$APIRequest;
use $NAMESPACE_MODEL$\$MODEL_NAME$;
use $NAMESPACE_REPOSITORY$\$MODEL_NAME$Repository;
use Illuminate\Http\Request;
use $NAMESPACE_BASE_CONTROLLER$\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

$DOC_CONTROLLER$
class $MODEL_NAME$APIController extends InfyOmBaseController
{
    /** @var  $MODEL_NAME$Repository */
    private $$MODEL_NAME_CAMEL$Repository;

    public function __construct($MODEL_NAME$Repository $$MODEL_NAME_CAMEL$Repo)
    {
        $this->$MODEL_NAME_CAMEL$Repository = $$MODEL_NAME_CAMEL$Repo;
    }

    $DOC_INDEX$
    public function index(Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);
            $query = $MODEL_NAME$::orderBy($sortCol, $sortDir);
        } else {
            $query = $MODEL_NAME$::orderBy('created_at', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $API_VUEJS_CONTROLLER_FILTER$
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        return response()->json($query->paginate($perPage));    
    }

    $DOC_STORE$
    public function store(Create$MODEL_NAME$APIRequest $request)
    {
        $input = $request->all();

        $$MODEL_NAME_PLURAL_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->create($input);

        return $this->sendResponse($$MODEL_NAME_PLURAL_CAMEL$->toArray(), '$MODEL_NAME$ saved successfully');
    }

    $DOC_SHOW$
    public function show($id)
    {
        /** @var $MODEL_NAME$ $$MODEL_NAME_CAMEL$ */
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            return Response::json(ResponseUtil::makeError('$MODEL_NAME$ not found'), 400);
        }

        return $this->sendResponse($$MODEL_NAME_CAMEL$->toArray(), '$MODEL_NAME$ retrieved successfully');
    }

    $DOC_UPDATE$
    public function update($id, Update$MODEL_NAME$APIRequest $request)
    {
        $input = $request->all();

        /** @var $MODEL_NAME$ $$MODEL_NAME_CAMEL$ */
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            return Response::json(ResponseUtil::makeError('$MODEL_NAME$ not found'), 400);
        }

        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->update($input, $id);

        return $this->sendResponse($$MODEL_NAME_CAMEL$->toArray(), '$MODEL_NAME$ updated successfully');
    }

    $DOC_DESTROY$
    public function destroy($id)
    {
        /** @var $MODEL_NAME$ $$MODEL_NAME_CAMEL$ */
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            return Response::json(ResponseUtil::makeError('$MODEL_NAME$ not found'), 400);
        }

        $$MODEL_NAME_CAMEL$->delete();

        return $this->sendResponse($id, '$MODEL_NAME$ deleted successfully');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               /* Move down content because we have a fixed navbar that is 50px tall */
body {
  /* padding-top: 50px; */
  padding-bottom: 20px;
}
ul.dropdown-menu li {
    margin-left: 20px;
}
.vuetable th.sortable:hover {
    color: #2185d0;
    cursor: pointer;
}
.vuetable-actions {
    width: 11%;
    padding: 12px 0px;
    text-align: center;
}
.vuetable-actions > button {
  padding: 3px 6px;
  margin-right: 4px;
}
.vuetable-pagination {
}
.vuetable-pagination-info {
    float: left;
    margin-top: auto;
    margin-bottom: auto;
}
.vuetable-pagination-component {
  float: 