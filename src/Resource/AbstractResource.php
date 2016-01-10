<?php

namespace Shutterstock\Api\Resource;

use Psr\Http\Message\ResponseInterface as Response;
use Shutterstock\Api\Client;

abstract class AbstractResource
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $path
     * @param mixed  $query
     *
     * @return Response
     */
    public function get($path, $query = null)
    {
        $uri = $this->buildRelativeUri($path);
        $parameters = [];
        if (!is_null($query)) {
            $parameters['query'] = $query;
        }

        return $this->client->request('GET', $uri, $parameters);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function buildRelativeUri($path)
    {
        $uri = $this->getResourcePath();
        if (!empty($path)) {
            $uri .= '/';
            $uri .= $path;
        }

        return $uri;
    }

    abstract protected function getResourcePath();
}
