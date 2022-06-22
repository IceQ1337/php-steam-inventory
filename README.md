# PHP Steam Inventory
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.0-8892BF.svg?style=flat-square)](https://php.net/)  

This library provides an easy way to access the public Steam Inventory API (https://steamcommunity.com/inventory/) from your PHP code. It provides a simple interface to make requests to the API and retrieve information about Steam users' inventories, specifically their items.  

This PHP library is designed to be easily extendable by other developers. It should be well documented and includes a comprehensive test suite.  

## Requirements
This library supports all [officially and actively supported PHP versions](https://www.php.net/supported-versions.php).

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
    'count' => 100, // default: 5000, max: 5000
    'start_assetid' => null, // default: null
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

### License
[MIT](https://github.com/IceQ1337/php-steam-inventory/blob/master/LICENSE)

### Credits
- Parts of this library are based on [PHP Steam Inventory](https://github.com/matthewlilley/php-steam-inventory) published by [matthewlilley](https://github.com/matthewlilley) in 2018.