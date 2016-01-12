<?php

namespace Shutterstock\Api;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;

class ClientTest extends PHPUnit_Framework_TestCase
{

    use MockClientTrait,
        MockHandlerTrait,
        ClientWithMockHandlerTrait;

    public function testIsInstanceOfClient()
    {
        $client = $this->getClient();

        $this->assertInstanceOf(
            'Shutterstock\Api\Client',
            $client
        );
    }

    public function testConstructSetsGuzzle()
    {
        $guzzle = new Guzzle([
            'base_uri' => 'https://api.shutterstock.com/v2/',
            'auth' => ['test_client_id', 'test_client_secret'],
        ]);
        $client = new Client('test_client_id', 'test_client_secret');

        $this->assertAttributeInstanceOf(
            'GuzzleHttp\Client',
            'guzzle',
            $client
        );
        $this->assertAttributeEquals($guzzle, 'guzzle', $client);
    }

    /**
     * @dataProvider dataGet
     */
    public function testGet($expectedUri, $uri, $query, $options)
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->get($uri, $query, $options);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals($expectedUri, (string) $lastRequest->getUri());
    }

    public function dataGet()
    {
        return [
            [
                'expectedUri' => 'test?key=value',
                'uri' => 'test',
                'query' => ['key' => 'value'],
                'options' => [],
            ],
        ];
    }

    /**
     * @dataProvider dataBuildQuery
     */
    public function testBuildQuery($expectedQuery, $query, $separator)
    {
        $client = $this->getClient();
        $queryString = $client->buildQuery($query, $separator);

        $this->assertEquals($expectedQuery, $queryString);
    }

    public function dataBuildQuery()
    {
        return [
            [
                'expectedQuery' => 'key=value',
                'query' => ['key' => 'value'],
                'separator' => '&',
            ],
            [
                'expectedQuery' => 'key_a=value_a&key_b=value_b',
                'query' => ['key_a' => 'value_a', 'key_b' => 'value_b'],
                'separtor' => '&',
            ],
        ];
    }

    /**
     * @dataProvider dataPost
     */
    public function testPost($expectedUri, $expectedBody, $uri, $body, $options)
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->post($uri, $body, $options);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals($expectedUri, (string) $lastRequest->getUri());
        $this->assertEquals($expectedBody, (string) $lastRequest->getBody());
    }

    public function dataPost()
    {
        return [
            [
                'expectedUri' => 'test',
                'expectedBody' => '{"key":"value"}',
                'uri' => 'test',
                'body' => ['key' => 'value'],
                'options' => [],
            ],
        ];
    }
}
