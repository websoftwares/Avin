# Avin

Client for interacting with the [avin.cc](http://www.avin.cc/api-documentation/ "avin.cc") JSON RESTful api.

[![Build Status](https://api.travis-ci.org/websoftwares/Avin.png)](https://travis-ci.org/websoftwares/Avin)

## Documentation
We encourage you to read the [documentation](http://www.avin.cc/api-documentation/ "avin.cc") carefully before proceeding.

## Api Key
The AVIN API requires a developer key which you can ask avin.cc using this email address: info@avin.cc.

## Installing via Composer (recommended)

Install composer in your project:
```
curl -s http://getcomposer.org/installer | php
```

Create a composer.json file in your project root:
```
{
    "require": {
        "websoftwares/avin": "dev-master"
    }
}
```

Install via composer
```
php composer.phar install
```

## Usage
Below u find a list with available methods.

## GetWineByAvin
Gets a wine by Avin.

```php
use Websoftwares\AvinClient, Websoftwares\Avin;

$avin = new Avin(new AvinClient('123456789YourApiKey'));
$avin->GetWineByAvin('AVIN0123456789012');

```

## GetWinesByName
Gets wine by name.

```php
use Websoftwares\AvinClient, Websoftwares\Avin;

$avin = new Avin(new AvinClient('123456789YourApiKey'));
$avin->GetWinesByName('Era');

```

## GetCountries
Gets a list of countries.

```php
use Websoftwares\AvinClient, Websoftwares\Avin;

$avin = new Avin(new AvinClient('123456789YourApiKey'));
$avin->GetCountries();

```

## GetWineTypes
Gets a list of wine types.

```php
use Websoftwares\AvinClient, Websoftwares\Avin;

$avin = new Avin(new AvinClient('123456789YourApiKey'));
$avin->GetWineTypes();

```

## GetProducerByID
Gets a producer by id.

```php
use Websoftwares\AvinClient, Websoftwares\Avin;

$avin = new Avin(new AvinClient('123456789YourApiKey'));
$avin->GetProducerByID(12345);

```

## GetProducerByName
Gets a producer by name.

```php
use Websoftwares\AvinClient, Websoftwares\Avin;

$avin = new Avin(new AvinClient('123456789YourApiKey'));
$avin->GetProducerByName('Producer sample name');

```

## setFilter
Please read the [documentation](http://www.avin.cc/api-documentation/ "avin.cc") for a complete list of available filters.

```php
use Websoftwares\AvinClient, Websoftwares\Avin;

$avin = new Avin(new AvinClient('123456789YourApiKey'));

$avin
	->setFilter('vintage', 2003)
    ->setFilter('country', 620)
    ->setFilter('type', '1')
    ->setFilter('producer', 'Cortes de Cima')
    ->GetWineByAvin('AVIN6452997073019');

```

## Error messages
Use try/catch block to get error messages.

```php
use Websoftwares\AvinClient,
	Websoftwares\Avin,
	Websoftwares\AvinException;

try {
	$avin = new Avin(new AvinClient('123456789YourApiKey'));
	$avin->GetWinesByName('Era');
} catch (AvinException $e) {
	echo $e->getMessages();
}

```

## Testing
In the tests folder u can find several tests for online and offline.