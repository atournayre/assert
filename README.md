Atournayre Assert
================

This library extends [webmozart/assert] with additional assertions.

Installation
------------

Use [Composer] to install the package:

```bash
composer require atournayre/assert
```

Assertions
----------

The [`Assert`] class provides the following assertions:

### Type Assertions

 Method                                                              | Description                                    
---------------------------------------------------------------------|------------------------------------------------
 `isListOf(array $array, string $classOrType, string $message = '')` | Check that the array is a list of a given type 
 `isMapOf(array $array, string $classOrType, string $message = '')`  | Check that the array is a map of a given type  
 `isType(mixed $value, string $type, string $message = '')`          | Check that a value is of a given type          
 `allIsType(mixed $value, string $type, string $message = '')`       | Check that all values are of a given type      

Contribute
----------

Contributions to the package are always welcome!

* Report any bugs or issues you find on the [issue tracker].
* You can grab the source code at the package's [Git repository].

License
-------

All contents of this package are licensed under the [MIT license].

[Composer]: https://getcomposer.org

[The Community Contributors]: https://github.com/atournayre/assert/graphs/contributors

[issue tracker]: https://github.com/atournayre/assert/issues

[Git repository]: https://github.com/atournayre/assert

[MIT license]: LICENSE

[webmozart/assert]: https://github.com/webmozart/assert
