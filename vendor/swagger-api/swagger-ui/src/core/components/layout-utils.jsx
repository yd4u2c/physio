ee()
    }
    layoutActions.show(["operations", tag, operationId], !isShown)
  }

  onCancelClick=() => {
    this.setState({tryItOutEnabled: !this.state.tryItOutEnabled})
  }

  onTryoutClick =() => {
    let { specActions, path, method } = this.props
    this.setState({tryItOutEnabled: !this.state.tryItOutEnabled})
    specActions.clearValidateParams([path, method])
  }

  onExecute = () => {
    this.setState({ executeInProgress: true })
  }

  getResolvedSubtree = () => {
    const {
      specSelectors,
      path,
      method,
      specPath
    } = this.props

    if(specPath) {
      return specSelectors.specResolvedSubtree(specPath.toJS())
    }

    return specSelectors.specResolvedSubtree(["paths", path, method])
  }

  requestResolvedSubtree = () => {
    const {
      specActions,
      path,
      method,
      specPath
    } = this.props


    if(specPath) {
      return specActions.requestResolvedSubtree(specPath.toJS())
    }

    return specActions.requestResolvedSubtree(["paths", path, method])
  }

  render() {
    let {
      op: unresolvedOp,
      tag,
      path,
      method,
      security,
      isAuthorized,
      operationId,
      showSummary,
      isShown,
      jumpToKey,
      allowTryItOut,
      response,
      request,
      displayOperationId,
      displayRequestDuration,
      isDeepLinkingEnabled,
      specPath,
      specSelectors,
      specActions,
      getComponent,
      getConfigs,
      layoutSelectors,
      layoutActions,
      authActions,
      authSelectors,
      oas3Actions,
      oas3Selectors,
      fn
    } = this.props

    const Operation = getComponent( "operation" )

    const resolvedSubtree = this.getResolvedSubtree() || Map()

    const operationProps = fromJS({
      op: resolvedSubtree,
      tag,
      path,
      summary: unresolvedOp.getIn(["operation", "summary"]) || "",
      deprecated: resolvedSubtree.get("deprecated") || unresolvedOp.getIn(["operation", "deprecated"]) || false,
      method,
      security,
      isAuthorized,
      operationId,
      originalOperationId: resolvedSubtree.getIn(["operation", "__originalOperationId"]),
      showSummary,
      isShown,
      jumpToKey,
      allowTryItOut,
      request,
      displayOperationId,
      displayRequestDuration,
      isDeepLinkingEnabled,
      executeInProgress: this.state.executeInProgress,
      tryItOutEnabled: this.state.tryItOutEnabled
    })

    return (
      <Operation
        operation={operationProps}
        response={response}
        request={request}
        isShown={isShown}

        toggleShown={this.toggleShown}
        onTryoutClick={this.onTryoutClick}
        onCancelClick={this.onCancelClick}
        onExecute={this.onExecute}
        specPath={specPath}

        specActions={ specActions }
        specSelectors={ specSelectors }
        oas3Actions={oas3Actions}
        oas3Selectors={oas3Selectors}
        layoutActions={ layoutActions }
        layoutSelectors={ layoutSelectors }
        authActions={ authActions }
        authSelectors={ authSelectors }
        getComponent={ getComponent }
        getConfigs={ getConfigs }
        fn={fn}
      />
    )
  }

}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              import React from "react"
import PropTypes from "prop-types"

export default class SchemesContainer extends React.Component {

  static propTypes = {
    specActions: PropTypes.object.isRequired,
    specSelectors: PropTypes.object.isRequired,
    getComponent: PropTypes.func.isRequired
  }

  render () {
    const {specActions, specSelectors, getComponent} = this.props

    const currentScheme = specSelectors.operationScheme()
    const schemes = specSelectors.schemes()

    const Schemes = getComponent("schemes")

    const schemesArePresent = schemes && schemes.size

    return schemesArePresent ? (
        <Schemes
          currentScheme={currentScheme}
          schemes={schemes}
          specActions={specActions}
        />
      ) : null
  }
}
                                                                                                                                                                                                                                                                                                                                                                                     