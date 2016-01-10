<?php

namespace Shutterstock\Api\Resource;

use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Shutterstock\Api\Client;
use Shutterstock\Api\MockClientTrait;
use Shutterstock\Api\MockHandlerTrait;
use Shutterstock\Api\SetMockHandlerTrait;

class AbstractResourceTest extends PHPUnit_Framework_TestCase
{

    use MockClientTrait,
        MockHandlerTrait,
        SetMockHandlerTrait;

    public function testIsInstanceOfResource()
    {
        $abstractResource = $this->mockAbstractResource();

        $this->assertInstanceOf(
            'Shutterstock\Api\Resource\AbstractResource',
            $abstractResource
        );
    }

    public function testConstructSetsClient()
    {
        $client = $this->getClient();
        $abstractResource = $this->mockAbstractResource();

        $this->assertAttributeInstanceOf(
            'Shutterstock\Api\Client',
            'client',
            $abstractResource
        );
        $this->assertAttributeEquals($client, 'client', $abstractResource);
    }

    /**
     * @dataProvider dataGet
     */
    public function testGet($expectedPath, $path, $query = null)
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setGuzzleWithMockHandler($client, $mockHandler);
        $abstractResource = $this->mockAbstractResource($client);
        $reflectedBuildUriMethod = $this->getAccessibleBuildUriMethod($abstractResource);

        $abstractResource->get($path, $query);
        $relativeUri = $reflectedBuildUriMethod->invokeArgs($abstractResource, [$path]);

        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGet()
    {
        return [
            [
                'expectedPath' => '/test',
                'path' => 'test',
            ],
            [
                'expectedPath' => '/test-with-query?key=value',
                'path' => 'test-with-query',
                'query' => 'key=value',
            ],
            [
                'expectedPath' => '/test-with-query-array?array_key=array_value',
                'path' => 'test-with-query-array',
                'query' => ['array_key' => 'array_value'],
            ]
        ];
    }

    /**
     * @dataProvider dataBuildRelativeUri
     */
    public function testBuildRelativeUri($expectedPath, $resourcePath, $path)
    {
        $abstractResource = $this->mockAbstractResource();
        $abstractResource->expects($this->any())
            ->method('getResourcePath')
            ->will($this->returnValue($resourcePath));
        $reflectedBuildUriMethod = $this->getAccessibleBuildUriMethod($abstractResource);

        $path = $reflectedBuildUriMethod->invokeArgs($abstractResource, [$path]);

        $this->assertEquals($expectedPath, $path);
    }

    public function dataBuildRelativeUri()
    {
        return [
            [
                'expectedPath' => 'test',
                'resourcePath' => 'test',
                'path' => '',
            ],
            [
                'expectedPath' => 'test/path',
                'resourcePath' => 'test',
                'path' => 'path',
            ],
        ];
    }

    protected function getAccessibleBuildUriMethod($abstractResource)
    {
        $reflectedAbstractResource = new ReflectionClass($abstractResource);
        $reflectedMethod = $reflectedAbstractResource->getMethod('buildRelativeUri');
        $reflectedMethod->setAccessible(true);

        return $reflectedMethod;
    }

    protected function mockAbstractResource(Client $client = null)
    {
        if (is_null($client)) {
            $client = $this->getClient();
        }

        return $this->getMockForAbstractClass(
            'Shutterstock\Api\Resource\AbstractResource',
            [$client]
        );
    }
}
