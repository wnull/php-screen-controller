# Package management utility 'screen' on PHP

Start, kill, and process list.

## Prerequisites

To work correctly, you will need `php` version `>=7.0`.

## Installation

You can install it using Composer using the following command:

```sh
composer require wnull/php-screen-controller
```

## Using

Common use:
```php
require __DIR__ . '/vendor/autoload.php';

$screen = new ScreenController();
var_dump($screen->list());
```

## Methods

Below is a list of possible commands for starting, killing, and listing processes.

* ### start()
  Returns a boolean value.

  The second argument, and the first element of the array must pass the path to the php file. The subsequent array elements will be considered as parameters to the file whose path is specified.
  ```php
  $start = $screen->start('<here is the name of your process>', [
      '<here is the path to your php file>'
  ]);
  ```

* ### kill()
  Returns a boolean value.

  Kill the process using its name:
  ```php
  $kill = $screen->kill('name', '<here is the name of your process>');
  ```

  Kill the process using its pid:
  ```php
  $kill = $screen->kill('pid', '<here is the pid of your process>');
  ```
* ### list()
  Returns an array.

  ```php
  $list = $screen->list();
  ```

## License

The library is distributed under the [MIT](https://github.com/wnull/php-screen-controller/blob/master/LICENSE) license.