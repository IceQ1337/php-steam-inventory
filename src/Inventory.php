<?php

namespace SteamInventory;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Inventory
{
    /**
     * List of items in inventory.
     *
     * @var Item[]
     */
    public $items = [];
    
    /**
     * 1 (true) if more items can be fetched from the inventory.
     *
     * @var int|null
     */
    public $more_items;
    
    /**
     * ID of the last fetched asset, 'null' if no more items are available.
     *
     * @var string|null
     */
    public $last_assetid;
    
    /**
     * Total number of items in inventory with given context
     *
     * @var int
     */
    public $total_inventory_count;
        
    /**
     * Options array for specifying the request parameters.
     *
     * @var array
     */
    private $options = [];
    
    /**
     * A GuzzleHTTP client to handle web requests.
     *
     * @var Client
     */
    private $httpClient;

    /**
     * Creates new inventory and fetches data from the Steam API.
     *
     * @param  array $options
     * @return void
     */
    public function __construct($options)
    {
        if (!\is_array($options)) {
            throw new \Exception('$options must be of type array.');
        }

        if (empty($options['steamid'])) {
            throw new \Exception('$options must specify a steamid.');
        }

        if (!\preg_match('/[^\/][0-9]{8,}/', $options['steamid'])) {
            throw new \Exception('$options contains an invalid steamid.');
        }

        $this->options = [
            'steamid' => $options['steamid'],
            'appid' => $options['appid'] ?? 753,
            'contextid' => $options['contextid'] ?? 6,
            'language' => isset($options['language']) ? LanguageFactory::getLanguage($options['language']) : LanguageFactory::getDefaultLanguage(),
            'all_items' => $options['all_items'] ?? false,
            'count' => $options['count'] ?? 5000,
            'start_assetid' => $options['start_assetid'] ?? null,
        ];

        if ($this->options['all_items']) {
            $this->options['count'] = 5000;
        }

        $this->fetchInventory();
    }
    
    /**
     * Returns a list of all items in inventory.
     *
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
    
    /**
     * Adds item entries to the inventory.
     *
     * @param  array $assets
     * @param  array $descriptions
     * @return void
     */
    private function setItems(array $assets, array $descriptions): void
    {
        foreach ($assets as $asset) {
            foreach ($descriptions as $description) {
                if ($asset['classid'] === $description['classid']) {
                    $this->items[] = new Item($asset, $description);
                    break;
                }
            }
        }
    }
    
    /**
     * Initiates the Steam API request(s).
     *
     * @return void
     */
    private function fetchInventory(): void
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://steamcommunity.com/inventory/',
            'timeout' => 30,
        ]);

        $this->requestInventory();

        if ($this->options['all_items'] === true) {
            while ($this->more_items && $this->last_assetid) {
                $this->requestInventory();
            }
        }
    }
    
    /**
     * Executes the request to the Steam API and saves the response.
     *
     * @throws \Exception
     * @return void
     */
    private function requestInventory(): void
    {
        try {
            $response = $this->httpClient->get($this->getRelativeUri());
        } catch (ClientException $e) {
            throw new \Exception($e->getMessage());
        }

        $data = \json_decode($response->getBody()->getContents(), true);

        if (!$this->isValidResponse($data)) {
            throw new \Exception('Based on the response data, the request was unsuccessful.');
        }

        $this->setItems($data['assets'], $data['descriptions']);
        $this->more_items = $data['more_items'] ?? null;
        $this->last_assetid = $data['last_assetid'] ?? null;
        $this->total_inventory_count = $data['total_inventory_count'];
    }

    /**
     * Returns the relative URI for the API request.
     *
     * @return string
     */
    private function getRelativeUri(): string
    {
        $queryParameters = \http_build_query([
            'l' => $this->options['language'],
            'count' => $this->options['count'],
            'start_assetid' => $this->options['start_assetid'],
        ], '', '&');

        return $this->options['steamid'] . '/' . $this->options['appid'] . '/' . $this->options['contextid'] . '?' . $queryParameters;
    }
    
    /**
     * Returns 'true' if the response from the Steam server is valid.
     *
     * @param  array $response
     * @return bool
     */
    private function isValidResponse($data): bool
    {
        return $data['success'] && isset($data['assets'], $data['descriptions']);
    }
}
