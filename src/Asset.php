<?php

namespace SteamInventory;

class Asset
{
    /**
     * The 'appid' of the item asset.
     *
     * @var string
     */
    public $appid;

    /**
     * The 'contextid' of the item asset.
     *
     * @var string
     */
    public $contextid;

    /**
     * The 'assetid' of the item asset.
     *
     * @var string
     */
    public $assetid;

    /**
     * The 'classid' of the item asset.
     *
     * @var string
     */
    public $classid;

    /**
     * The 'instanceid' of the item asset.
     *
     * @var string
     */
    public $instanceid;

    /**
     * The 'amount' of the item asset.
     *
     * @var string
     */
    public $amount;

    /**
     * Creates a new item asset.
     *
     * @param  array $data
     * @return void
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
