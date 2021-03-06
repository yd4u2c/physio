e'));

$copy = $copier->copy($object);

// $copy->title will contain the data returned by the callback, e.g. 'The title (copy)'
```

2. If you want to replace whole element:

```php
use DeepCopy\DeepCopy;
use DeepCopy\TypeFilter\ReplaceFilter;
use DeepCopy\TypeMatcher\TypeMatcher;

$copier = new DeepCopy();
$callback = function (MyClass $myClass) {
  return get_class($myClass);
};
$copier->addTypeFilter(new ReplaceFilter($callback), new TypeMatcher('MyClass'));

$copy = $copier->copy([new MyClass, 'some string', new MyClass]);

// $copy will contain ['MyClass', 'some string', 'MyClass']
```


The `$callback` parameter of the `ReplaceFilter` constructor accepts any PHP callable.


#### `ShallowCopyFilter` (type filter)

Stop *DeepCopy* from recursively copying element, using standard `clone` instead:

```php
use DeepCopy\DeepCopy;
use DeepCopy\TypeFilter\ShallowCopyFilter;
use DeepCopy\TypeMatcher\TypeMatcher;
use Mockery as m;

$this->deepCopy = new DeepCopy();
$this->deepCopy->addTypeFilter(
	new ShallowCopyFilter,
	new TypeMatcher(m\MockInterface::class)
);

$myServiceWithMocks = new MyService(m::mock(MyDependency1::class), m::mock(MyDependency2::class));
// All mocks will be just cloned, not deep copied
```


## Edge cases

The following structures cannot be deep-copied with PHP Reflection. As a result they are shallow cloned and filters are
not applied. There is two ways for you to handle them:

- Implement your own `__clone()` method
- Use a filter with a type matcher


## Contributing

DeepCopy is distributed under the MIT license.


### Tests

Running the tests is simple:

```php
vendor/bin/phpunit
```
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          