# PHP Steam Inventory
[![Latest Stable Version](http://poser.pugx.org/iceq1337/steam-inventory-api/v?style=flat-square)](https://packagist.org/packages/iceq1337/steam-inventory-api) [![Total Downloads](http://poser.pugx.org/iceq1337/steam-inventory-api/downloads?style=flat-square)](https://packagist.org/packages/iceq1337/steam-inventory-api) [![PHP Version Require](http://poser.pugx.org/iceq1337/steam-inventory-api/require/php?style=flat-square)](https://packagist.org/packages/iceq1337/steam-inventory-api) [![License](http://poser.pugx.org/iceq1337/steam-inventory-api/license?style=flat-square)](https://packagist.org/packages/iceq1337/steam-inventory-api)

This library provides an easy way to access the public Steam Inventory API (https://steamcommunity.com/inventory/) from your PHP code. It provides a simple interface to retrieve a Steam user's inventory from the API with information about the items in it.  

Using this API does not require an API key, but as it is not part of the Steam Web API, the rate limit of 100,000 requests per day does not apply. Instead, the rate limit for this API is extremely low. So use this API or rather this library with caution.  

While using this API is generally discouraged, it has been part of Steam since forever and despite or perhaps because its rework in 2016, it is probably here to stay.  

The library is designed to be easily extendable by other developers. It should be well documented and includes a comprehensive test suite.  

## Requirements
* PHP 8.X  

This library supports all [officially and actively supported PHP versions](https://www.php.net/supported-versions.php). PHP 7.4 will soon reach its EOL on November 28, 2022 and the library already makes use of useful features from PHP 8.0, so this version is no longer supported.  

See the ``composer.json`` for other requirements.  

## Installation
```shell
composer require iceq1337/php-steam-inventory
```

## Usage
```PHP
use SteamInventory\Inventory;

$options = [
    'steamid' => '76561198129782984',
    'appid' => 753, // default: 753
    'contextid' => 6, // default: 6
    'language' => 'english', // default: 'english'
    'all_items' => false, // default: false
    'count' => 100, // default: 500, max: 5000
    'start_assetid' => null, // default: null, used for consecutive requests
];

$inventory = new Inventory($options);
$items = $inventory->getItems();
$total = $inventory->total_inventory_count;

foreach ($items as $item) {
    echo $item->getName() . "<br>";
}
```

### Contributing
There are currently no contributing guidelines. In order to contribute to the project, please follow the GitHub Standard Fork & Pull Request Workflow.

- **Fork** this repository on GitHub.
- **Clone** the project to your own machine.
- **Commit** changes to your own branch.
- **Push** your work to your own fork.
- Submit a **Pull Request** so I can review your changes

Please make sure you always run the tests and apply the code style before submitting your pull request. All tests and the code style workflow must pass in order for the pull request to be approved and merged.  

```shell
composer run test
composer run lint
```

### License
This library is licensed under the [MIT license](https://github.com/IceQ1337/php-steam-inventory/blob/master/LICENSE).  

### Credits
Parts of this library are based on [PHP Steam Inventory](https://github.com/matthewlilley/php-steam-inventory) published by [matthewlilley](https://github.com/matthewlilley) in 2018.