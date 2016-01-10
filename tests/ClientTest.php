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

    public function testGetImages()
    {
        $client = $this->getClient();
        $expectedImageResource = new Resource\Images($client);

        $imageResource = $client->getImages();

        $this->assertInstanceOf(
            'Shutterstock\Api\Resource\Images',
            $imageResource
        );
        $this->assertEquals($expectedImageResource, $imageResource);
    }

    /**
     * @dataProvider dataRequests
     */
    public function testRequest($method, $uri, $options, Response $response, $compiledUri)
    {
        $mockHandler = $this->getMockHandler($response);
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $testResponse = $client->request($method, $uri, $options);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertSame($response, $testResponse);
        $this->assertEquals($method, $lastRequest->getMethod());
        $this->assertEquals($compiledUri, $lastRequest->getUri());
    }

    public function dataRequests()
    {
        return [
            [
                'method' => 'GET',
                'uri' => '/test',
                'options' => ['query' => ['key' => 'value']],
                'response' => new Response(200, [], json_encode(['key' => 'value'])),
                'compiled_uri' => '/test?key=value',
            ],
        ];
    }
}
