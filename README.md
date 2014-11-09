# Brainstorage PHP Library

Unofficial Brainstorage PHP Library based on parsing with the use [sleeping-owl/apist](https://github.com/sleeping-owl/apist)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
php composer.phar require kotchuprik/php-brainstorage "dev-master"
```

or add

```json
"kotchuprik/php-brainstorage": "dev-master"
```

to the `require` section of your application `composer.json` file.

## Usage

```php
require('vendor/autoload.php');

$client = new \kotchuprik\brainstorage\Client();

// Getting jobs on the page
$items = $client->getItems();

// Getting the job description
var_export($client->getItem(reset($items)['id']));
```
