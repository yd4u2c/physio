/**
     * @param int $id
     * @param Update$MODEL_NAME$APIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/$MODEL_NAME_PLURAL_CAMEL$/{id}",
     *      summary="Update the specified $MODEL_NAME$ in storage",
     *      tags={"$MODEL_NAME$"},
     *      description="Update $MODEL_NAME$",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of $MODEL_NAME$",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="$MODEL_NAME$ that should be updated",
