<?php

require_once('../vendor/autoload.php');

use SteamInventory\Inventory;

$options = [
    'steamid' => '76561198129782984',
    'appid' => 753,
    'contextid' => 6,
    'language' => 'english',
    'all_items' => true,
];

$inventory = new Inventory($options);
$items = $inventory->getItems();

foreach ($items as $item) {
    echo $item->getName() . "<br>";
}
