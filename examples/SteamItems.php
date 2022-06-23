<?php

/*
 * Retrieve all Steam items (e.g. Trading Cards, Backgrounds, Emoticons) from the inventory.
 * App-ID: 753 (default)
 * Context-ID: 6 (default)
 */

require_once('../vendor/autoload.php');

use SteamInventory\Inventory;

$options = [
    'steamid' => '76561198129782984',
    'all_items' => true,
];

$inventory = new Inventory($options);
$items = $inventory->getItems();

foreach ($items as $item) {
    echo $item->getName() . "<br>";
}
