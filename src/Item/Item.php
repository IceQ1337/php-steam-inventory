<?php

namespace SteamInventory\Item;

class Item
{
    /**
     * The item's asset object.
     */
    public ItemAsset $asset;

    /**
     * The item's description object.
     */
    public ItemDescription $description;

    /**
     * Creates a new inventory item.
     */
    public function __construct(array $asset, array $description)
    {
        $this->asset = new ItemAsset($asset);
        $this->description = new ItemDescription($description);
    }

    /**
     * Returns the name of the item.
     */
    public function getName(): string
    {
        return $this->description->name;
    }

    /**
     * Returns a list of item descriptions.
     */
    public function getDescriptions(): array
    {
        return $this->description->descriptions;
    }

    /**
     * Returns the item type.
     */
    public function getType(): string
    {
        return $this->description->type;
    }

    /**
     * Returns a list of item tags.
     *
     * @return ItemTag[]
     */
    public function getTags(): array
    {
        return $this->description->tags;
    }

    /**
     * Returns the URL for the icon image of the item.
     */
    public function getIcon(): string
    {
        return $this->description->getIcon();
    }

    /**
     * Returns the URL for the large icon image of the item.
     */
    public function getIconLarge(): string
    {
        return $this->description->getIconLarge();
    }

    /**
     * Returns the amount of the item (e.g. for Steam Gems).
     * Note: Steam Gems are often split into separate items. The amount is not accumulated.
     */
    public function getAmount(): int
    {
        return \intval($this->asset->amount);
    }

    /**
     * Returns the appid of the app this item belongs to
     * if it differs from the inventory appid (e.g. for Trading Cards).
     */
    public function getRealAppID(): ?int
    {
        foreach ($this->getTags() as $tag) {
            if ($tag->category == 'Game') {
                return \intval(\explode('_', $tag->internal_name)[1]);
                break;
            }
        }

        return $this->description->market_fee_app;
    }

    /**
     * Returns 'true' if the item is tradable.
     */
    public function isTradable(): bool
    {
        return $this->description->tradable;
    }

    /**
     * Returns 'true' if the item is marketable.
     */
    public function isMarketable(): bool
    {
        return $this->description->marketable;
    }

    /**
     * Returns a human readable type identifier for Steam items.
     *
     * @throws \Exception
     */
    public function getSteamItemType(): string
    {
        if ($this->description->appid != 753) {
            throw new \Exception('The item is not a Steam item.');
        }

        $itemType = 'Unknown';

        foreach ($this->getTags() as $tag) {
            if ($tag->category == 'cardborder') {
                $itemType = match ($tag->internal_name) {
                    'cardborder_0' => 'TradingCard',
                    'cardborder_1' => 'FoilTradingCard',
                };
            }

            if ($tag->category == 'item_class') {
                $itemType = match ($tag->internal_name) {
                    'item_class_2' => ($itemType == 'Unknown') ? 'TradingCard' : $itemType,
                    'item_class_3' => 'ProfileBackground',
                    'item_class_4' => 'Emoticon',
                    'item_class_5' => 'BoosterPack',
                    'item_class_6' => 'Consumable',
                    'item_class_7' => 'SteamGems',
                    'item_class_8' => 'ProfileModifier',
                    'item_class_10' => 'SaleItem',
                    'item_class_11' => 'Sticker',
                    'item_class_12' => 'ChatEffect',
                    'item_class_13' => 'MiniProfileBackground',
                    'item_class_14' => 'AvatarProfileFrame',
                    'item_class_15' => 'AnimatedAvatar',
                    'item_class_16' => 'KeyboardSkin',
                };
            }
        }

        return $itemType;
    }
}
