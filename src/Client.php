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
     * @param string $uri
     * @param array  $query
     * @param array  $options
     *
     * @return Response
     */
    public function get($uri, array $query = [], array $options = [])
    {
        if (!empty($query)) {
            $options['query'] = $this->buildQuery($query);
        }
        return $this->guzzle->get($uri, $options);
    }

    /**
     * @param array  $query
     * @param string $separator
     *
     * @return string
     */
    public function buildQuery(array $query, $separator = '&')
    {
        $queryPieces = [];
        foreach ($query as $key => $value) {
            if (!is_array($value)) {
                $piece = urlencode($key) . '=' . urlencode($value);
                array_push($queryPieces, $piece);
                continue;
            }
            foreach ($value as $valuePiece) {
                $piece = urlencode($key) . '=' . urlencode($valuePiece);
                array_push($queryPieces, $piece);
            }
        }

        $queryString = implode($separator, $queryPieces);
        return $queryString;
    }

    /**
     * @param string $uri
     * @param array  $body
     * @param array  $options
     *
     * @return Response
     */
    public function post($uri, array $body = [], array $options = [])
    {
        if (!empty($body)) {
            $options['body'] = json_encode($body);
        }
        return $this->guzzle->post($uri, $options);
    }
}
