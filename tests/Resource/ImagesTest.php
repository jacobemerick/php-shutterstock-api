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
    public function testGetSearch($expectedPath, $query)
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getSearch($query);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetSearch()
    {
        return [
            [
                'expectedPath' => 'images/search?query=test',
                'query' => ['query' => 'test'],
            ],
            [
                'expectedPath' => 'images/search',
                'query' => [],
            ],
            [
                'expectedPath' => 'images/search?query=test&license=editorial',
                'query' => ['query' => 'test', 'license' => 'editorial'],
            ],
        ];
    }

 
    /**
     * @dataProvider dataGetSearchPopularQueries
     */
    public function testGetSearchPopularQueries($expectedPath, $language, $imageType)
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getSearchPopularQueries($language, $imageType);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetSearchPopularQueries()
    {
        return [
            [
                'expectedPath' => 'images/search/popular/queries',
                'language' => '',
                'imageType' => '',
            ],
            [
                'expectedPath' => 'images/search/popular/queries?language=zh',
                'language' => 'zh',
                'imageType' => '',
            ],
            [
                'expectedPath' => 'images/search/popular/queries?language=th&image_type=illustration',
                'language' => 'th',
                'imageType' => 'illustration',
            ],
        ];
    }

    /**
     * @dataProvider dataGetRecommendations
     */
    public function testGetRecommendations($expectedPath, $imageIds, $maxItems, $restrictToSafe) {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getRecommendations($imageIds, $maxItems, $restrictToSafe);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetRecommendations()
    {
        return [
            [
                'expectedPath' => 'images/recommendations?id=1&id=2',
                'imageIds' => [1, 2],
                'maxItems' => 0,
                'restrictToSafe' => null,
            ],
            [
                'expectedPath' => 'images/recommendations?id=1&max_items=3',
                'imageIds' => [1],
                'maxItems' => 3,
                'restrictToSafe' => null,
            ],
            [
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
    public function testGetSimilar($expectedPath, $imageId, $page, $perPage, $sort, $view) {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getSimilar($imageId, $page, $perPage, $sort, $view);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetSimilar()
    {
        return [
            [
                'expectedPath' => 'images/34/similar',
                'imageId' => 34,
                'page' => 0,
                'perPage' => 0,
                'sort' => '',
                'view' => '',
            ],
            [
                'expectedPath' => 'images/37/similar?page=3&per_page=4&sort=relevance&view=full',
                'imageId' => 37,
                'page' => 3,
                'perPage' => 4,
                'sort' => 'relevance',
                'view' => 'full',
            ],
            [
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
    public function testGetList($expectedPath, array $imageIds, $view)
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getList($imageIds, $view);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetList()
    {
        return [
            [
                'expectedPath' => 'images?id=1&id=2&id=3',
                'imageIds' => [1,2,3],
                'view' => '',
            ],
            [
                'expectedPath' => 'images?id=1&id=2&id=3&view=minimal',
                'imageIds' => [1,2,3],
                'view' => 'minimal',
            ],
            [
                'expectedPath' => 'images?id=1&view=full',
                'imageIds' => [1],
                'view' => 'full',
            ],
        ];
    }

    /**
     * @dataProvider dataGetById
     */
    public function testGetById($expectedPath, $imageId, $view)
    {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getById($imageId, $view);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetById()
    {
        return [
            [
                'expectedPath' => 'images/1',
                'imageId' => 1,
                'view' => '',
            ],
            [
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
    public function testGetLicences($expectedPath, $imageId, $license, $page, $perPage, $sort) {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->getLicenses($imageId, $license, $page, $perPage, $sort);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals($expectedPath, $lastRequest->getUri());
    }

    public function dataGetLicenses()
    {
        return [
            [
                'expectedPath' => 'images/licenses',
                'imageId' => '',
                'license' => '',
                'page' => 0,
                'perPage' => 0,
                'sort' => '',
            ],
            [
                'expectedPath' => 'images/licenses?image_id=213&license=321&page=2&per_page=10&sort=oldest',
                'imageId' => '213',
                'license' => '321',
                'page' => 2,
                'perPage' => 10,
                'sort' => 'oldest',
            ],
            [
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
    public function testPostLicence($expectedBody, $subscriptionId, $format, $size, $searchId) {
        $mockHandler = $this->getMockHandler();
        $client = $this->getClient();
        $this->setClientWithMockHandler($client, $mockHandler);

        $client->getImages()->postLicense($subscriptionId, $format, $size, $searchId);
        $lastRequest = $mockHandler->getLastRequest();

        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('images/licenses', $lastRequest->getUri());
        $this->assertEquals($expectedBody, $lastRequest->getBody());
    }

    public function dataPostLicense()
    {
        return [
            [
                'expectedBody' => '{"subscription_id":"123"}',
                'subscriptionId' => '123',
                'format' => '',
                'size' => '',
                'searchId' =>'',
            ],
            [
                'expectedBody' => '{"subscription_id":"312","format":"eps","size":"medium","search_id":"452"}',
                'subscriptionId' => '312',
                'format' => 'eps',
                'size' => 'medium',
                'searchId' => '452',
            ],
            [
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
