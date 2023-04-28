<?php

namespace SteamInventory\Item;

class ItemTag
{
    /**
     * The category name of the item tag.
     */
    public string $category;

    /**
     * The internal name of the item tag.
     */
    public string $internal_name;

    /**
     * The localized category name of the item tag.
     */
    public string $localized_category_name;

    /**
     * The localized name of the item tag.
     */
    public string $localized_tag_name;

    /**
     * Creates a new item tag.
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
     */
    public function getCategory(): string
    {
        return $this->localized_category_name;
    }

    /**
     * Returns the localized tag name.
     */
    public function getName(): string
    {
        return $this->localized_tag_name;
    }
}
