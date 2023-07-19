# AntoineDly\Container

This simple container ...

## Usage

```php
<?php

use AntoineDly\Container\Container;

$container = new Container();
$container->set('SomeClassOrInterface', 'SomeConcreteClass');
$container->get('SomeClassOrInterface'); //will return 'SomeConcreteClass' being resolved
```


### Requirements

- AntoineDly\Container `^1.0` works with PHP 8.2 or above.

### Author

Antoine Delaunay - <antoine.delaunay333@gmail.com> - [Twitter](http://twitter.com/AntDlny)<br />

### License

AntoineDly\Container is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

### Acknowledgements

This library is heavily inspired by [PHP-DI](https://github.com/PHP-DI/PHP-DI) and Gio's [Container](https://www.youtube.com/watch?v=78Vpg97rQwE)

### Contributing

If you want to contribute, make sure to run those 3 steps before submitting a PR : 

- Run static tests :
```php
tools/phpstan/vendor/bin/phpstan analyse src tests --level=9
```

- Run fixer :
```php
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src
```

- Run tests :
```php
vendor/bin/phpunit tests
```