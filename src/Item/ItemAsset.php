<?php

namespace SteamInventory\Item;

class ItemAsset
{
    /**
     * The 'appid' of the item asset.
     */
    public string $appid;

    /**
     * The 'contextid' of the item asset.
     */
    public string $contextid;

    /**
     * The 'assetid' of the item asset.
     */
    public string $assetid;

    /**
     * The 'classid' of the item asset.
     */
    public string $classid;

    /**
     * The 'instanceid' of the item asset.
     */
    public string $instanceid;

    /**
     * The 'amount' of the item asset.
     */
    public string $amount;

    /**
     * Creates a new item asset.
     */
    public function __construct(array $data)
    {
        $this->appid = $data['appid'];
        $this->contextid = $data['contextid'];
        $this->assetid = $data['assetid'];
        $this->classid = $data['classid'];
        $this->instanceid = $data['instanceid'];
        $this->amount = $data['amount'];
    }
}
