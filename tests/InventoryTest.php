<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use SteamInventory\Inventory;

final class InventoryTest extends TestCase
{
    public function testInventoryOptionsInvalid()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('$options must be of type array.');

        $inventory = new Inventory(true);
    }

    public function testInventoryOptionsWithoutSteamID()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('$options must specify a steamid.');

        $inventory = new Inventory([
            'steamid' => '',
        ]);
    }

    public function testInventoryOptionsWithInvalidSteamID()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('$options contains an invalid steamid.');

        $inventory = new Inventory([
            'steamid' => 'xyz',
        ]);
    }

    public function testInventoryFromPrivateProfile()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessageMatches('/403/');

        $inventory = new Inventory([
            'steamid' => '76561198033858363',
        ]);
    }

    public function testInventoryEmpty()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('The inventory is empty.');

        $options = [
            'steamid' => '76561198129782984',
            'appid' => 440,
            'contextid' => 2,
            'all_items' => true,
        ];

        $inventory = new Inventory($options);
    }

    public function testInventoryWithMoreItems()
    {
        $options = [
            'steamid' => '76561198129782984',
            'count' => 10,
        ];

        $inventory = new Inventory($options);
        $items = $inventory->getItems();

        $this->assertEquals(10, \count($items));
        $this->assertTrue((bool)$inventory->more_items);
        $this->assertNotNull($inventory->last_assetid);
        $this->assertGreaterThan(\count($items), $inventory->total_inventory_count);
    }

    public function testInventoryWithoutFurtherItems()
    {
        $options = [
            'steamid' => '76561198129782984',
            'all_items' => true,
        ];

        $inventory = new Inventory($options);
        $items = $inventory->getItems();

        $this->assertNull($inventory->more_items);
        $this->assertNull($inventory->last_assetid);
        $this->assertEquals(\count($items), $inventory->total_inventory_count);
    }
}
