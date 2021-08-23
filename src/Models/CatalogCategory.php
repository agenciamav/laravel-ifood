<?php

namespace Agenciamav\LaravelIfood\Models;

use Agenciamav\LaravelIfood\IfoodClient;

class CatalogCategory
{
    use IfoodClient;
    public function getAllCategories($merchantId, $catalogId)
    {
        $request = $this->client->request(
            'GET',
            "catalog/v1.0/merchants/$merchantId/catalogs/$catalogId/categories"
        );
        $response = $request->getBody();
        return json_decode($response->getContents());
    }

    public function getCategory($merchantId, $catalogId, $categoryId)
    {
        $request = $this->client->request(
            'GET',
            "catalog/v1.0/merchants/$merchantId/catalogs/$catalogId/categories/$categoryId"
        );
        $response = $request->getBody();
        return json_decode($response->getContents());
    }


    public function createCategory()
    {
    }

    public function updateCategory()
    {
    }
    public function deleteCategory()
    {
    }
}
