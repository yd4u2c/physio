<thead>
              <tr className="responses-header">
                <td className="col col_header response-col_status">Code</td>
                <td className="col col_header response-col_description">Description</td>
                { specSelectors.isOAS3() ? <td className="col col_header response-col_links">Links</td> : null }
              </tr>
            </thead>
            <tbody>
              {
                responses.entrySeq().map( ([code, response]) => {

                  let className = tryItOutResponse && tryItOutResponse.get("status") == code ? "response_current" : ""
                  return (
                    <Response key={ code }
                              specPath={specPath.push(code)}
                              isDefault={defaultCode === code}
                              fn={fn}
                              className={ className }
                              code={ code }
                              response={ response }
                              specSelectors={ specSelectors }
                              controlsAcceptHeader={response === acceptControllingResponse}
                              onContentTypeChange={this.onResponseContentTypeChange}
                              contentType={ producesValue }
                              getConfigs={ getConfigs }
                              getComponent={ getComponent }/>
                    )
                }).toArray()
              }
            </tbody>
          </table>
        </div>
      </div>
    )
  }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   