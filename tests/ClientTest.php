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

    protected function newClient()
    {
        return new Client('client_id', 'client_secret');
    }
}
