<?php declare(strict_types=1);

namespace App;

use GPH\Api\DefaultApi;
use App\Models\GiphyGif;
use GPH\ApiException;


class GiphyApiClient
{
    private DefaultApi $client;
    private string $apiKey;

    public function __construct()
    {
        $this->client = new DefaultApi;
        $this->apiKey = $_ENV["API_KEY"];
    }

    public function getGifs(string $tag): ?array
    {
        $gifs = $this->fetch($tag);

        if ($gifs != null) {
            $gifsCollection = [];
            foreach ($gifs as $gif) {
                $gifsCollection[] = new GiphyGif
                (
                    "{$gif->getId()}",
                    "{$gif->getImages()->getOriginal()->getUrl()}"
                );
            }
            return $gifsCollection;
        }
        return null;
    }

    private function fetch(string $tag): ?array
    {
        $api_key = $this->apiKey;
        $q = $tag;
        $limit = 25;
        $rating = "r";

        try {
            return $this->client->gifsSearchGet($api_key, $q, $limit, $rating)->getData();
        } catch (ApiException $e) {
        }
        return null;
    }
}

