<?php

namespace Shutterstock\Api\Resource;

use PHPUnit_Framework_TestCase;
use Shutterstock\Api\Client;
use Shutterstock\Api\MockClientTrait;
use Shutterstock\Api\MockHandlerTrait;
use Shutterstock\Api\ClientWithMockHandlerTrait;

class ImagesTest extends PHPUnit_Framework_TestCase
{

    use MockClientTrait,
        MockHandlerTrait,
        ClientWithMockHandlerTrait;

    /**
     * @dataProvider dataGetList
     */
    public function testGetList($expectedMethod, $expectedPath, array $imageIds, $view = '')
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getList($imageIds, $view);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals($expectedMethod, $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetList()
    {
        return [
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images?id=1&id=2&id=3',
                'imageIds' => [1,2,3],
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images?id=1&id=2&id=3&view=minimal',
                'imageIds' => [1,2,3],
                'view' => 'minimal',
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images?id=1&view=full',
                'imageIds' => [1],
                'view' => 'full',
            ],
        ];
    }

    /**
     * @dataProvider dataGetById
     */
    public function testGetById($expectedMethod, $expectedPath, $imageId, $view = '')
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getById($imageId, $view);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals($expectedMethod, $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetById()
    {
        return [
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/1',
                'imageId' => 1,
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/3?view=minimal',
                'imageIds' => 3,
                'view' => 'minimal',
            ],
        ];
    }

    public function testGetCategories()
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getCategories();
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals('images/categories', $lastRequest->getUri());
    }
}
