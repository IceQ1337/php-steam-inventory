<?php

namespace SteamInventory;

class Description
{
    /**
     * The base URL for item images.
     *
     * @var string
     */
    const IMAGE_URL = 'https://steamcommunity-a.akamaihd.net/economy/image/';

    /**
     * The 'appid' of the item.
     *
     * @var int
     */
    public $appid;

    /**
     * The 'classid' of the item.
     *
     * @var string
     */
    public $classid;

    /**
     * The 'instanceid' of the item.
     *
     * @var string
     */
    public $instanceid;

    /**
     * The 'currency' of the item.
     *
     * @var int
     */
    public $currency;

    /**
     * The 'background_color' of the item.
     *
     * @var string|null
     */
    public $background_color;

    /**
     * The 'icon_url' of the item.
     *
     * @var string
     */
    public $icon_url;

    /**
     * The 'icon_url_large' of the item.
     *
     * @var string|null
     */
    public $icon_url_large;

    /**
     * The contents of the item description.
     *
     * @var array
     */
    public $descriptions = [];

    /**
     * 1 (true) if the item is tradable.
     *
     * @var int
     */
    public $tradable;

    /**
     * The 'name' of the item.
     *
     * @var string
     */
    public $name;

    /**
     * The 'type' of the item.
     *
     * @var string
     */
    public $type;

    /**
     * The 'market_name' of the item.
     *
     * @var string
     */
    public $market_name;

    /**
     * The 'market_hash_name' of the item.
     *
     * @var string
     */
    public $market_hash_name;

    /**
     * The 'market_fee_app' of the item.
     *
     * @var int|null
     */
    public $market_fee_app;

    /**
     * The 'commodity' of the item.
     *
     * @var int
     */
    public $commodity;

    /**
     * 1 (true) if the item has a trade restriction.
     *
     * @var int
     */
    public $market_tradable_restriction;

    /**
     * 1 (true) if the item has a market restriction.
     *
     * @var int|null
     */
    public $market_marketable_restriction;

    /**
     * 1 (true) if the item is marketable.
     *
     * @var int
     */
    public $marketable;

    /**
     * List of tags for the item.
     *
     * @var Tag[]
     */
    public $tags = [];

    /**
     * Creates a item description.
     *
     * @param  array $data
     * @return void
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
            $this->tags = \array_map(static fn ($data) => new Tag($data), $data['tags']);
        }
    }

    /**
     * Returns the URL for the icon image of the item.
     *
     * @return string
     */
    public function getIcon(): string
    {
        return self::IMAGE_URL . $this->icon_url;
    }

    /**
     * Returns the URL for the large icon image of the item.
     *
     * @return string
     */
    public function getIconLarge(): string
    {
        return self::IMAGE_URL . $this->icon_url_large;
    }
}
