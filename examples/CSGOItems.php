<?php

/*
 * Retrieve all CSGO items from the inventory.
 * App-ID: 730
 * Context-ID: 2
 */

require_once('../vendor/autoload.php');

use SteamInventory\Inventory;

$options = [
    'steamid' => '76561198129782984',
    'appid' => 730,
    'contextid' => 2,
    'all_items' => true,
];

$inventory = new Inventory($options);
$items = $inventory->getItems();

foreach ($items as $item) {
    echo $item->getName() . "<br>";
}
