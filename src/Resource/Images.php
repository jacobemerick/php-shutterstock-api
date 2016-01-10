<?php

namespace Shutterstock\Api\Resource;

class Images extends AbstractResource
{

    /**
     * @link https://developers.shutterstock.com/api/v2/images/search
     *
     * @param array $query
     *
     * @return Response
     */
    public function getSearch(array $query = [])
    {
        return $this->get('search', $query);
    }

    /**
     * @link https://developers.shutterstock.com/api/v2/images/popularQueries
     *
     * @param string $language
     * @param string $imageType
     *
     * @return Response
     */
    public function getSearchPopularQueries($language = '', $imageType = '')
    {
        $query = [];
        if (!empty($language)) {
            $query['language'] = $language;
        }
        if (!empty($imageType)) {
            $query['image_type'] = $imageType;
        }

        return $this->get('search/popular/queries', $query);
    }

    /**
     * @link https://developers.shutterstock.com/api/v2/images/recommendations
     *
     * @param array   $imageIds
     * @param integer $maxItems
     * @param boolean $restrictToSafe
     *
     * @return Response
     */
    public function getRecommendations(array $imageIds, $maxItems = 0, $restrictToSafe = null)
    {
        $query = array_map(function ($imageId) {
            return "id={$imageId}";
        }, $imageIds);
        if ($maxItems > 0) {
            array_push($query, "max_items={$maxItems}");
        }
        if (!is_null($restrictToSafe)) {
            array_push($query, 'safe=' . ($restrictToSafe ? 'true' : 'false'));
        }

        $query = implode('&', $query);
        return $this->get('recommendations', $query);
    }

    /**
     * @link https://developers.shutterstock.com/api/v2/images/similar
     *
     * @param string  $imageId
     * @param integer $page
     * @param integer $perPage
     * @param string  $sort
     * @param string  $view
     *
     * @return Response
     */
    public function getSimilar($imageId, $page = 0, $perPage = 0, $sort = '', $view = '')
    {
        $query = [];
        if ($page > 0) {
            $query['page'] = $page;
        }
        if ($perPage > 0) {
            $query['per_page'] = $perPage;
        }
        if (!empty($sort)) {
            $query['sort'] = $sort;
        }
        if (!empty($view)) {
            $query['view'] = $view;
        }

        return $this->get("{$imageId}/similar", $query);
    }

    /**
     * @link https://developers.shutterstock.com/api/v2/images/list
     *
     * @param array  $imageIds
     * @param string $view
     *
     * @return Response
     */
    public function getList(array $imageIds, $view = '')
    {
        $query = array_map(function ($imageId) {
            return "id={$imageId}";
        }, $imageIds);
        if (!empty($view)) {
            array_push($query, "view={$view}");
        }

        $query = implode('&', $query);
        return $this->get('', $query);
    }

    /**
     * @link https://developers.shutterstock.com/api/v2/images/get
     *
     * @param string $imageId
     * @param string $view
     *
     * @return Response
     */
    public function getById($imageId, $view = '')
    {
        $query = [];
        if (!empty($view)) {
            $query['view'] = $view;
        }

        return $this->get("{$imageId}", $query);
    }

    /**
     * @link https://developers.shutterstock.com/api/v2/images/categories
     *
     * @return Response
     */
    public function getCategories()
    {
        return $this->get('categories');
    }

    /**
     * @return string
     */
    protected function getResourcePath()
    {
        return 'images';
    }
}
