<?php

namespace SteamInventory;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use SteamInventory\Exception\EmptyInventoryException;
use SteamInventory\Exception\InventoryOptionsException;
use SteamInventory\Exception\PrivateInventoryException;
use SteamInventory\Exception\RequestFailedException;
use SteamInventory\Item\Item;
use SteamInventory\Util\LanguageFactory;

class Inventory
{
    /**
     * List of items in inventory.
     *
     * @var Item[]
     */
    public array $items = [];

    /**
     * 1 (true) if more items can be fetched from the inventory.
     */
    public ?int $more_items;

    /**
     * ID of the last fetched asset, 'null' if no more items are available.
     */
    public ?string $last_assetid;

    /**
     * Total number of items in inventory with given context
     */
    public int $total_inventory_count;

    /**
     * Options array for specifying the request parameters.
     */
    private array $options = [];

    /**
     * A GuzzleHTTP client to handle web requests.
     */
    private Client $httpClient;

    /**
     * Creates new inventory and fetches data from the Steam API.
     *
     * @throws InventoryOptionsException
     */
    public function __construct(array $options)
    {
        if (!\is_array($options)) {
            throw new InventoryOptionsException('$options must be of type array.');
        }

        if (empty($options['steamid'])) {
            throw new InventoryOptionsException('$options must specify a steamid.');
        }

        if (!\preg_match('/[^\/][0-9]{8,}/', $options['steamid'])) {
            throw new InventoryOptionsException('$options contains an invalid steamid.');
        }

        $this->options = [
            'steamid' => $options['steamid'],
            'appid' => $options['appid'] ?? 753,
            'contextid' => $options['contextid'] ?? 6,
            'language' => isset($options['language']) ? LanguageFactory::getLanguage($options['language']) : LanguageFactory::getDefaultLanguage(),
            'all_items' => $options['all_items'] ?? false,
            'count' => $options['count'] ?? 500,
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
     * Executes the request to the Steam API.
     *
     * @throws PrivateInventoryException
     * The API endpoint always returns a 403 on errors. It's just assumed that the inventory is private if the request was ok.
     * @throws RequestFailedException
     * If the API does not return a 403, the error may be in the request itself.
     */
    private function requestInventory(): void
    {
        try {
            $response = $this->httpClient->get($this->getRelativeUri());
        } catch (ClientException $e) {
            if (\preg_match('/403/', $e->getMessage())) {
                throw new PrivateInventoryException();
            }

            throw new RequestFailedException($e->getMessage());
        }

        $data = \json_decode($response->getBody()->getContents(), true);

        if (!$this->isValidResponse($data)) {
            throw new RequestFailedException('The Steam API returned an invalid response.');
        }

        $this->parseInventory($data);
    }

    /**
     * Parses and saves the response from the Steam API.
     *
     * @throws EmptyInventoryException
     */
    private function parseInventory(array $data): void
    {
        if ($this->isEmptyInventory($data)) {
            throw new EmptyInventoryException();
        }

        $this->setItems($data['assets'], $data['descriptions']);
        $this->more_items = $data['more_items'] ?? null;
        $this->last_assetid = $data['last_assetid'] ?? null;
        $this->total_inventory_count = $data['total_inventory_count'];
    }

    /**
     * Returns the relative URI for the API request.
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
     */
    private function isValidResponse(array $data): bool
    {
        return \boolval($data['success']);
    }

    /**
     * Returns 'true' if the response returned an empty inventory.
     */
    private function isEmptyInventory(array $data): bool
    {
        if ($data['total_inventory_count'] == 0) {
            return true;
        }

        return !isset($data['assets'], $data['descriptions']);
    }
}
