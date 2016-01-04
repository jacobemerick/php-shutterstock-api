<?php

namespace Shutterstock\Api;

use GuzzleHttp\Client as Guzzle;
use Psr\Http\Message\ResponseInterface as Response;

class Client
{

    /** @var  Guzzle */
    protected $guzzle;

    /**
     * @param string $clientId
     * @param string $clientSecret
     */
    public function __construct($clientId, $clientSecret)
    {
        $guzzle = new Guzzle([
            'base_uri' => 'https://api.shutterstock.com/v2/',
            'auth' => [$clientId, $clientSecret],
        ]);
        $this->guzzle = $guzzle;
    }

    /**
     * @param string $query
     * @param array  $params
     *
     * @response Response
     */
    public function performSearch($query = '', array $params = [])
    {
        return $this->guzzle->get('images/search', ['query' => ['query' => $query]]);
    }
}
