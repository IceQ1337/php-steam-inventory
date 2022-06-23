<?php

/*
 * Retrieve all TF2 items from the inventory.
 * App-ID: 440
 * Context-ID: 2
 */

require_once('../vendor/autoload.php');

use SteamInventory\Inventory;

$options = [
    'steamid' => '76561198129782984',
    'appid' => 440,
    'contextid' => 2,
    'all_items' => true,
];

$inventory = new Inventory($options);
$items = $inventory->getItems();

foreach ($items as $item) {
    echo $item->getName() . "<br>";
}
