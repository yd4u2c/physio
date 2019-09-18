<?php

namespace $NAMESPACE_API_CONTROLLER$;

use $NAMESPACE_API_REQUEST$\Create$MODEL_NAME$APIRequest;
use $NAMESPACE_API_REQUEST$\Update$MODEL_NAME$APIRequest;
use $NAMESPACE_MODEL$\$MODEL_NAME$;
use $NAMESPACE_REPOSITORY$\$MODEL_NAME$Repository;
use Illuminate\Http\Request;
use $NAMESPACE_APP$\Http\Controllers\AppBaseController;
use Response;

$DOC_CONTROLLER$
class $MODEL_NAME$APIController extends AppBaseController
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
        $$MODEL_NAME_PLURAL_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($$MODEL_NAME_PLURAL_CAMEL$->toArray(), '$MODEL_NAME_PLURAL_HUMAN$ retrieved successfully');
    }

    $DOC_STORE$
    public function store(Create$MODEL_NAME$APIRequest $request)
    {
        $input = $request->all();

        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->create($input);

        return $this->sendResponse($$MODEL_NAME_CAMEL$->toArray(), '$MODEL_NAME_HUMAN$ saved successfully');
    }

    $DOC_SHOW$
    public function show($id)
    {
        /** @var $MODEL_NAME$ $$MODEL_NAME_CAMEL$ */
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            return $this->sendError('$MODEL_NAME_HUMAN$ not found');
        }

        return $this->sendResponse($$MODEL_NAME_CAMEL$->toArray(), '$MODEL_NAME_HUMAN$ retrieved successfully');
    }

    $DOC_UPDATE$
    public function update($id, Update$MODEL_NAME$APIRequest $request)
    {
        $input = $request->all();

        /** @var $MODEL_NAME$ $$MODEL_NAME_CAMEL$ */
        $$MODEL_NAME_CAMEL$ = $this->$MODEL_NAME_CAMEL$Repository->find($id);

        if (empty($$MODEL_NAME_CAMEL$)) {
            return $this->sendError('$MODEL_NAME_HUMAN$ not found');
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
            return $this->sendError('$MODEL_NAME_HUMAN$ not found');
        }

        $$MODEL_NAME_CAMEL$->delete();

        return $this->sendResponse($id, '$MODEL_NAME_HUMAN$ deleted successfully');
    }
}
                                                                                     