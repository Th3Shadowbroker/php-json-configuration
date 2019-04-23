## Json-Configuration
This library (actually it's just a single file xD) contains a basic
json-based configuration handler.

### Composer
php-json-configuration is available on [packagist](https://packagist.org/packages/th3shadowbroker/json-configuration):
```
composer require th3shadowbroker/json-configuration
```

### Example
```php
//Use class.
use github\th3shadowbroker\json_config\JsonConfiguration;

//Create a new config
$config = new JsonConfiguration(__DIR__.'/somefile.json');

//Set a default value.
$config->setDefault('something', 'anything');

//Set multiple defaults at once.
$config->setDefaults( ['another' => 'value'] );

//Set the value of a nested key.
$config->set('sonethingnested.nest', 'a nested value');

//Save the configuration.
$config->save();

//or save it to another location
$config->save(__DIR__.'/someotherfile.json');

echo $config->get('somethingnested.nest');
```
