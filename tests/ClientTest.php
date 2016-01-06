<?php

namespace Shutterstock\Api;

use GuzzleHttp\Client as Guzzle;
use PHPUnit_Framework_TestCase;

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
        // todo w/ mocking, maybe
    }

    protected function newClient()
    {
        return new Client('client_id', 'client_secret');
    }
}
