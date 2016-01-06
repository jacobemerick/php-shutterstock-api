<?php

namespace Shutterstock\Api\Resource;

class Images extends AbstractResource
{

    /**
     * @param array  $imageIds
     * @param string $view
     *
     * @returns Response
     */
    public function getList(array $imageIds, $view = '')
    {
        $query = array_map(function ($id) {
            return "id={$id}";
        }, $imageIds);
        if (!empty($view)) {
            array_push($query, "view={$view}");
        }

        $query = implode('&', $query);
        return $this->get('', $query);
    }

    /**
     * @param integer $imageId
     * @param string  $view
     *
     * @returns Response
     */
    public function getById($imageId, $view = '')
    {
        $query = [];
        if (!empty($view)) {
            $query['view'] = $view;
        }

        return $this->get("{$imageId}", [
            'query' => $query,
        ]);
    }

    /**
     * @returns Response
     */
    public function getCategories()
    {
        return $this->get('categories');
    }

    /**
     * @returns string
     */
    protected function getResourcePath()
    {
        return 'images';
    }
}
