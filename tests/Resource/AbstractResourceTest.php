<?php

namespace Shutterstock\Api\Resource;

use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Shutterstock\Api\Client;

class AbstractResourceTest extends PHPUnit_Framework_TestCase
{

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
        $client = $this->newClient();
        $abstractResource = $this->mockAbstractResource();

        $this->assertAttributeInstanceOf(
            'Shutterstock\Api\Client',
            'client',
            $abstractResource
        );
        $this->assertAttributeEquals($client, 'client', $abstractResource);
    }

    public function testGet()
    {
        // todo
    }

    public function testBuildRelativeUri()
    {
        $abstractResource = $this->mockAbstractResource();
        $abstractResource->expects($this->any())
            ->method('getResourcePath')
            ->will($this->returnValue('test'));

        $reflectedAbstractResource = new ReflectionClass($abstractResource);
        $reflectedMethod = $reflectedAbstractResource->getMethod('buildRelativeUri');
        $reflectedMethod->setAccessible(true);

        $this->assertEquals('test', $reflectedMethod->invokeArgs($abstractResource, ['']));
        $this->assertEquals('test/path', $reflectedMethod->invokeArgs($abstractResource, ['path']));
    }

    protected function mockAbstractResource()
    {
        return $this->getMockForAbstractClass(
            'Shutterstock\Api\Resource\AbstractResource',
            [$this->newClient()]
        );
    }

    protected function newClient()
    {
        return new Client('client_id', 'client_secret');
    }
}
