<?php

namespace SteamInventory\Item;

class ItemTag
{
    /**
     * The category name of the item tag.
     *
     * @var string
     */
    public $category;

    /**
     * The internal name of the item tag.
     *
     * @var string
     */
    public $internal_name;

    /**
     * The localized category name of the item tag.
     *
     * @var string
     */
    public $localized_category_name;

    /**
     * The localized name of the item tag.
     *
     * @var string
     */
    public $localized_tag_name;

    /**
     * Creates a new item tag.
     *
     * @param  array $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->category = $data['category'];
        $this->internal_name = $data['internal_name'];
        $this->localized_category_name = $data['localized_category_name'];
        $this->localized_tag_name = $data['localized_tag_name'];
    }

    /**
     * Returns the localized category name.
     *
     * @return string
     */
    public function getCategory(): string
    {
        return $this->localized_category_name;
    }

    /**
     * Returns the localized tag name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->localized_tag_name;
    }
}
