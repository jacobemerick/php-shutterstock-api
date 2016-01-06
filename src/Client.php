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
     * @returns Resource\Images
     */
    public function getImages()
    {
        return new Resource\Images($this);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $parameters
     *
     * @returns Response
     */
    public function request($method, $uri, $parameters)
    {
        return $this->guzzle->request($method, $uri, $parameters);
    }
}
