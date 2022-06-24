<?php

namespace SteamInventory\Item;

class Item
{
    /**
     * The item's asset object.
     *
     * @var Asset
     */
    public ItemAsset $asset;

    /**
     * The item's description object.
     *
     * @var ItemDescription
     */
    public ItemDescription $description;

    /**
     * Creates a new inventory item.
     *
     * @param  array $asset
     * @param  array $description
     * @return void
     */
    public function __construct(array $asset, array $description)
    {
        $this->asset = new ItemAsset($asset);
        $this->description = new ItemDescription($description);
    }

    /**
     * Returns the name of the item.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->description->name;
    }

    /**
     * Returns a list of item descriptions.
     *
     * @return array
     */
    public function getDescriptions(): array
    {
        return $this->description->descriptions;
    }

    /**
     * Returns the item type.
     *
     * @return string
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
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->description->getIcon();
    }

    /**
     * Returns the URL for the large icon image of the item.
     *
     * @return string
     */
    public function getIconLarge(): string
    {
        return $this->description->getIconLarge();
    }

    /**
     * Returns the amount of the item (e.g. for Steam Gems).
     * Note: Steam Gems are often split into separate items. The amount is not accumulated.
     *
     * @return int
     */
    public function getAmount(): int
    {
        return \intval($this->asset->amount);
    }

    /**
     * Returns the appid of the app this item belongs to
     * if it differs from the inventory appid (e.g. for Trading Cards).
     *
     * @return int|null
     */
    public function getRealAppID(): mixed
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
     *
     * @return bool
     */
    public function isTradable(): bool
    {
        return $this->description->tradable;
    }

    /**
     * Returns 'true' if the item is marketable.
     *
     * @return bool
     */
    public function isMarketable(): bool
    {
        return $this->description->marketable;
    }
    
    /**
     * Returns a human readable type identifier for Steam items.
     * TODO: Clean-up this mess (Item Type Objects?)
     *
     * @throws \Exception
     * @return string
     */
    public function getSteamItemType(): string
    {
        if ($this->description->appid != 753) {
            throw new \Exception('The item is not a Steam item.');
        }

        $itemType = 'Unknown';

        foreach ($this->getTags() as $tag) {
            switch ($tag->category) {
                case 'cardborder':
                    switch ($tag->internal_name) {
                        case 'cardborder_0':
                            return 'TradingCard';
                        case 'cardborder_1':
                            return 'FoilTradingCard';
                        default:
                            return 'Unknown';
                    }
                    // no break
                case 'item_class':
                    switch ($tag->internal_name) {
                        case 'item_class_2':
                            if ($itemType == 'Unknown') {
                                $itemType = 'TradingCard';
                            }
                            break;
                        case 'item_class_3':
                            return 'ProfileBackground';
                        case 'item_class_4':
                            return 'Emoticon';
                        case 'item_class_5':
                            return 'BoosterPack';
                        case 'item_class_6':
                            return 'Consumable';
                        case 'item_class_7':
                            return 'SteamGems';
                        case 'item_class_8':
                            return 'ProfileModifier';
                        case 'item_class_10':
                            return 'SaleItem';
                        case 'item_class_11':
                            return 'Sticker';
                        case 'item_class_12':
                            return 'ChatEffect';
                        case 'item_class_13':
                            return 'MiniProfileBackground';
                        case 'item_class_14':
                            return 'AvatarProfileFrame';
                        case 'item_class_15':
                            return 'AnimatedAvatar';
                        case 'item_class_16':
                            return 'KeyboardSkin';
                        default:
                            return 'Unknown';
                    }
                    // no break
                default:
                    return 'Unknown';
            }
        }

        return $itemType;
    }
}
