<?php

namespace SteamInventory;

class Item
{
    /**
     * The item's asset object.
     *
     * @var Asset
     */
    public Asset $asset;

    /**
     * The item's description object.
     *
     * @var Description
     */
    public Description $description;

    /**
     * Creates a new inventory item.
     *
     * @param  array $asset
     * @param  array $description
     * @return void
     */
    public function __construct(array $asset, array $description)
    {
        $this->asset = new Asset($asset);
        $this->description = new Description($description);
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
     * @return Tag[]
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
}
