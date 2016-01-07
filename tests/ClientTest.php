<?php

namespace Shutterstock\Api;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

class ClientTest extends PHPUnit_Framework_TestCase
{

    public function testIsInstanceOfClient()
    {
        $client = $this->newClient();

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
        $client = $this->newClient();
        $expectedImageResource = new Resource\Images($client);

        $imageResource = $client->getImages();

        $this->assertInstanceOf(
            'Shutterstock\Api\Resource\Images',
            $imageResource
        );
        $this->assertEquals($expectedImageResource, $imageResource);
    }

    public function testRequest()
    {
        $responseBody = json_encode(['key' => 'value']);
        $expectedResponse = new Response(200, [], $responseBody);

        $client = $this->newClientWithMockHandler([$expectedResponse]);
        $response = $client->request('GET', '/', []);

        $this->assertSame($expectedResponse, $response);
    }

    protected function newClient()
    {
        return new Client('client_id', 'client_secret');
    }

    protected function newClientWithMockHandler(array $responseQueue)
    {
        $mock = new MockHandler($responseQueue);
        $handler = HandlerStack::create($mock);
        $client = $this->newClient();

        $reflectedClient = new ReflectionClass($client);
        $reflectedProperty = $reflectedClient->getProperty('guzzle');
        $reflectedProperty->setAccessible(true);

        $reflectedProperty->setValue($client, new Guzzle(['handler' => $handler]));
        return $client;
    }
}
