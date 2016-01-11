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
     * @dataProvider dataGetSearch
     */
    public function testGetSearch($expectedMethod, $expectedPath, $query)
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getSearch($query);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals($expectedMethod, $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetSearch()
    {
        return [
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/search?query=test',
                'query' => ['query' => 'test'],
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/search',
                'query' => [],
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/search?query=test&license=editorial',
                'query' => ['query' => 'test', 'license' => 'editorial'],
            ],
        ];
    }

 
    /**
     * @dataProvider dataGetSearchPopularQueries
     */
    public function testGetSearchPopularQueries($expectedMethod, $expectedPath, $language, $imageType)
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getSearchPopularQueries($language, $imageType);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals($expectedMethod, $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetSearchPopularQueries()
    {
        return [
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/search/popular/queries',
                'language' => '',
                'imageType' => '',
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/search/popular/queries?language=zh',
                'language' => 'zh',
                'imageType' => '',
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/search/popular/queries?language=th&image_type=illustration',
                'language' => 'th',
                'imageType' => 'illustration',
            ],
        ];
    }

    /**
     * @dataProvider dataGetRecommendations
     */
    public function testGetRecommendations(
        $expectedMethod,
        $expectedPath,
        $imageIds,
        $maxItems,
        $restrictToSafe
    ) {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getRecommendations($imageIds, $maxItems, $restrictToSafe);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals($expectedMethod, $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetRecommendations()
    {
        return [
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/recommendations?id=1&id=2',
                'imageIds' => [1, 2],
                'maxItems' => 0,
                'restrictToSafe' => null,
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/recommendations?id=1&max_items=3',
                'imageIds' => [1],
                'maxItems' => 3,
                'restrictToSafe' => null,
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/recommendations?id=1&id=2&safe=true',
                'imageIds' => [1, 2],
                'maxItems' => 0,
                'restrictToSafe' => true,
            ],
        ];
    }

    /**
     * @dataProvider dataGetSimilar
     */
    public function testGetSimilar(
        $expectedMethod,
        $expectedPath,
        $imageId,
        $page,
        $perPage,
        $sort,
        $view
    ) {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getSimilar($imageId, $page, $perPage, $sort, $view);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals($expectedMethod, $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetSimilar()
    {
        return [
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/34/similar',
                'imageId' => 34,
                'page' => 0,
                'perPage' => 0,
                'sort' => '',
                'view' => '',
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/37/similar?page=3&per_page=4&sort=relevance&view=full',
                'imageId' => 37,
                'page' => 3,
                'perPage' => 4,
                'sort' => 'relevance',
                'view' => 'full',
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/34/similar?sort=newest',
                'imageId' => 34,
                'page' => 0,
                'perPage' => 0,
                'sort' => 'newest',
                'view' => '',
            ],
        ];
    }

    /**
     * @dataProvider dataGetList
     */
    public function testGetList($expectedMethod, $expectedPath, array $imageIds, $view)
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
                'view' => '',
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
    public function testGetById($expectedMethod, $expectedPath, $imageId, $view)
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
                'view' => '',
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

    /**
     * @dataProvider dataGetLicenses
     */
    public function testGetLicences(
        $expectedMethod,
        $expectedPath,
        $imageId,
        $license,
        $page,
        $perPage,
        $sort
    ) {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getLicenses($imageId, $license, $page, $perPage, $sort);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals($expectedMethod, $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetLicenses()
    {
        return [
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/licenses',
                'imageId' => '',
                'license' => '',
                'page' => 0,
                'perPage' => 0,
                'sort' => '',
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/licenses?image_id=213&license=321&page=2&per_page=10&sort=oldest',
                'imageId' => '213',
                'license' => '321',
                'page' => 2,
                'perPage' => 10,
                'sort' => 'oldest',
            ],
            [
                'expectedMethod' => 'GET',
                'expectedPath' => 'images/licenses?page=4&per_page=5',
                'imageId' => '',
                'license' => '',
                'page' => 4,
                'perPage' => 5,
                'sort' => '',
            ],
        ];
    }

    /**
     * @dataProvider dataPostLicense
     */
    public function testPostLicence(
        $expectedMethod,
        $expectedPath,
        $expectedBody,
        $subscriptionId,
        $format,
        $size,
        $searchId
    ) {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->postLicense($subscriptionId, $format, $size, $searchId);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals($expectedMethod, $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
        $this->assertEquals($expectedBody, $lastRequest->getBody());
    }

    public function dataPostLicense()
    {
        return [
            [
                'expectedMethod' => 'POST',
                'expectedPath' => 'images/licenses',
                'expectedBody' => '{"subscription_id":"123"}',
                'subscriptionId' => '123',
                'format' => '',
                'size' => '',
                'searchId' =>'',
            ],
            [
                'expectedMethod' => 'POST',
                'expectedPath' => 'images/licenses',
                'expectedBody' => '{"subscription_id":"312","format":"eps","size":"medium","search_id":"452"}',
                'subscriptionId' => '312',
                'format' => 'eps',
                'size' => 'medium',
                'searchId' => '452',
            ],
            [
                'expectedMethod' => 'POST',
                'expectedPath' => 'images/licenses',
                'expectedBody' => '{"subscription_id":"524","size":"huge"}',
                'subscriptionId' => '524',
                'format' => '',
                'size' => 'huge',
                'searchId' => '',
            ],
        ];
    }

    public function testPostDownloadImage()
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->postDownloadImage('312');
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('images/licenses/312/downloads', $lastRequest->getUri());
    }
}
