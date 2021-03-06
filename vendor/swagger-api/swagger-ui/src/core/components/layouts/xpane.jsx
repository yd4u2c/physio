[ "requests", path, method ], fromJSOrdered(req))
  },

  [SET_MUTATED_REQUEST]: (state, { payload: { req, path, method } } ) =>{
    return state.setIn( [ "mutatedRequests", path, method ], fromJSOrdered(req))
  },

  [UPDATE_OPERATION_META_VALUE]: (state, { payload: { path, value, key } }) => {
    // path is a pathMethod tuple... can't change the name now.
    let operationPath = ["paths", ...path]
    let metaPath = ["meta", "paths", ...path]

    if(
      !state.getIn(["json", ...operationPath])
      && !state.getIn(["resolved", ...operationPath])
      && !state.getIn(["resolvedSubtrees", ...operationPath])
    ) {
      // do nothing if the operation does not exist
      return state
    }

    return state.setIn([...metaPath, key], fromJS(value))
  },

  [CLEAR_RESPONSE]: (state, { payload: { path, method } } ) =>{
    return state.deleteIn( [ "responses", path, method ])
  },

  [CLEAR_REQUEST]: (state, { payload: { path, method } } ) =>{
    return state.deleteIn( [ "requests", path, method ])
  },

  [SET_SCHEME]: (state, { payload: { scheme, path, method } } ) =>{
    if ( path && method ) {
      return state.setIn( [ "scheme", path, method ], scheme)
    }

    if (!path && !method) {
      return state.setIn( [ "scheme", "_defaultScheme" ], scheme)
    }

  }

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    