<?php

namespace SteamInventory\Item;

class ItemDescription
{
    /**
     * The base URL for item images.
     */
    const IMAGE_URL = 'https://steamcommunity-a.akamaihd.net/economy/image/';

    /**
     * The 'appid' of the item.
     */
    public int $appid;

    /**
     * The 'classid' of the item.
     */
    public string $classid;

    /**
     * The 'instanceid' of the item.
     */
    public string $instanceid;

    /**
     * The 'currency' of the item.
     */
    public int $currency;

    /**
     * The 'background_color' of the item.
     */
    public ?string $background_color;

    /**
     * The 'icon_url' of the item.
     */
    public string $icon_url;

    /**
     * The 'icon_url_large' of the item.
     */
    public ?string $icon_url_large;

    /**
     * The contents of the item description.
     */
    public array $descriptions = [];

    /**
     * 1 (true) if the item is tradable.
     */
    public int $tradable;

    /**
     * The 'name' of the item.
     */
    public string $name;

    /**
     * The 'type' of the item.
     */
    public string $type;

    /**
     * The 'market_name' of the item.
     */
    public string $market_name;

    /**
     * The 'market_hash_name' of the item.
     */
    public string $market_hash_name;

    /**
     * The 'market_fee_app' of the item.
     */
    public ?int $market_fee_app;

    /**
     * The 'commodity' of the item.
     */
    public int $commodity;

    /**
     * 1 (true) if the item has a trade restriction.
     */
    public int $market_tradable_restriction;

    /**
     * 1 (true) if the item has a market restriction.
     */
    public ?int $market_marketable_restriction;

    /**
     * 1 (true) if the item is marketable.
     */
    public int $marketable;

    /**
     * List of tags for the item.
     *
     * @var ItemTag[]
     */
    public array $tags = [];

    /**
     * Creates a item description.
     */
    public function __construct(array $data)
    {
        $this->appid = $data['appid'];
        $this->classid = $data['classid'];
        $this->instanceid = $data['instanceid'];
        $this->currency = $data['currency'];
        $this->background_color = $data['background_color'] ?? null;
        $this->icon_url = $data['icon_url'];
        $this->icon_url_large = $data['icon_url_large'] ?? null;
        $this->descriptions = $data['descriptions'] ?? [];
        $this->tradable = $data['tradable'];
        $this->name = $data['name'];
        $this->type = $data['type'];
        $this->market_name = $data['market_name'];
        $this->market_hash_name = $data['market_hash_name'];
        $this->market_fee_app = $data['market_fee_app'] ?? null;
        $this->commodity = $data['commodity'];
        $this->market_tradable_restriction = $data['market_tradable_restriction'];
        $this->market_marketable_restriction = $data['market_marketable_restriction'] ?? null;
        $this->marketable = $data['marketable'];

        if (!empty($data['tags'])) {
            $this->tags = \array_map(static fn ($data) => new ItemTag($data), $data['tags']);
        }
    }

    /**
     * Returns the URL for the icon image of the item.
     */
    public function getIcon(): string
    {
        return self::IMAGE_URL . $this->icon_url;
    }

    /**
     * Returns the URL for the large icon image of the item.
     */
    public function getIconLarge(): string
    {
        return self::IMAGE_URL . $this->icon_url_large;
    }
}
