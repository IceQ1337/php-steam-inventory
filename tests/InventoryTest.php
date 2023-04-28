<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use SteamInventory\Exception\EmptyInventoryException;
use SteamInventory\Exception\InventoryOptionsException;
use SteamInventory\Exception\PrivateInventoryException;
use SteamInventory\Inventory;

final class InventoryTest extends TestCase
{
    public function testInventoryOptionsWithoutSteamID(): void
    {
        $this->expectException(InventoryOptionsException::class);
        $this->expectExceptionMessage('$options must specify a steamid.');

        $inventory = new Inventory([
            'steamid' => '',
        ]);
    }

    public function testInventoryOptionsWithInvalidSteamID(): void
    {
        $this->expectException(InventoryOptionsException::class);
        $this->expectExceptionMessage('$options contains an invalid steamid.');

        $inventory = new Inventory([
            'steamid' => 'xyz',
        ]);
    }

    public function testInventoryFromPrivateProfile(): void
    {
        $this->expectException(PrivateInventoryException::class);

        $inventory = new Inventory([
            'steamid' => '76561198033858363',
        ]);
    }

    public function testInventoryEmpty(): void
    {
        $this->expectException(EmptyInventoryException::class);

        $options = [
            'steamid' => '76561198129782984',
            'appid' => 440,
            'contextid' => 2,
            'all_items' => true,
        ];

        $inventory = new Inventory($options);
    }

    public function testInventoryWithMoreItems(): void
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

    public function testInventoryWithoutFurtherItems(): void
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
