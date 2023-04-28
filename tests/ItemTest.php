<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use SteamInventory\Item\Item;

final class ItemTest extends TestCase
{
    public function getSteamInventoryResponse(): mixed
    {
        $json = \file_get_contents(__DIR__ . '/json/steam_inventory.json');

        return \json_decode($json, true);
    }

    public function getCSGOInventoryResponse(): mixed
    {
        $json = \file_get_contents(__DIR__ . '/json/csgo_inventory.json');

        return \json_decode($json, true);
    }

    public function getItems(array $assets, array $descriptions): array
    {
        $items = [];
        foreach ($assets as $asset) {
            foreach ($descriptions as $description) {
                if ($asset['classid'] === $description['classid']) {
                    $items[] = new Item($asset, $description);
                    break;
                }
            }
        }

        return $items;
    }

    // public function testWithoutAssertions()
    // {
    //     $this->expectNotToPerformAssertions();
    // }

    public function testItemCreation(): void
    {
        $response = $this->getSteamInventoryResponse();
        $steamItems = $this->getItems($response['assets'], $response['descriptions']);

        $response = $this->getCSGOInventoryResponse();
        $csgoItems = $this->getItems($response['assets'], $response['descriptions']);

        $this->assertEquals(3, \count($steamItems));
        $this->assertEquals(3, \count($csgoItems));
    }

    public function testSteamItemTypeForNonSteamItem(): void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('The item is not a Steam item.');

        $response = $this->getCSGOInventoryResponse();
        $csgoItems = $this->getItems($response['assets'], $response['descriptions']);

        $steamItemType = $csgoItems[0]->getSteamItemType();
    }
}
