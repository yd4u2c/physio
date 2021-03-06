ctory is called). It also includes a reference to the `Immutable` lib, so that plugin authors don't need to include it.


### The Plugin system

Each plugin you include will end up getting merged into the `system`, which is just an object.

Then we bind the `system` to our state. And flatten it, so that we don't need to reach into deep objects

> ie: spec.actions becomes specActions, spec.selectors becomes specSelectors

You can reach this bound system by calling `getSystem` on the store.

`getSystem` is the heart of this whole project. Each container component will receive a spread of props from `getSystem`

here is an example....
```js
class Bobby extends React.Component {

  handleClick(e) {
    this.props.someNamespaceActions.actionName() // fires an action... which the reducer will *eventually* see
  }

  render() {

    let { someNamespaceSelectors, someNamespaceActions } = this.props // this.props has the whole state spread
    let something = someNamespaceSelectors.something() // calls our selector, which returns some state (either an immutable object or value)

    return (
      <h1 onClick={this.handleClick.bind(this)}> Hello {something} </h1> // render the contents
    )

  }

}
```

TODO: a lot more elaboration
`
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               