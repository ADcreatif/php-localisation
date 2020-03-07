# Localisation
**The easy way to translate your php websites**

This project is a personal tool helping me to store translations/localisation on my scratch
projects.

 - It doesn't needs any instalation. For persistance, i'll use .txt files.
 - It's very simple to use. You will surround your texts with a functions.
 - Furthermore, it keeps the original language in your views so it's easy to edit and
update. 
 

## Install via Composer
```shell
    composer require adcreatif/php-localisation
```
## usage

```php
<?php 
// Autoload files using Composer autoload
require_once __DIR__ . '/../vendor/autoload.php'; 

// Gives access to translations functions
use Common;

// define the global variable $lang (for ex with session)
$lang = $_SESSION['lang'];

// now you can use it eveywhere
echo _('my sentence to translate');
```
## Next versions
 - automaticaly scan new translations
 - GUI for editing and translate

## License
This project is licensed under the MIT License. See the  [license file]() for more information.


## Contributing
Feel free to open new issues and contribute to the project. Let's make it awesome and let's do in a positive way.
## Author