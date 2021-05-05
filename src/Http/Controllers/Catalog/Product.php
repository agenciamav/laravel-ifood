<?php

namespace Agenciamav\LaravelIfood\Http\Controllers\Catalog;

use Agenciamav\LaravelIfood\Http\Controllers\Auth\IfoodClient;

class Product extends IfoodClient
{
    public function getProducts($merchantId)
    {
        $request = $this->client->request(
            'GET',
            "catalog/v1.0/merchants/$merchantId/products"
        );
        $response = $request->getBody();
        return json_decode($response->getContents());
    }

    public function createProduct()
    {
    }

    public function updateProduct()
    {
    }

    public function deleteProduct()
    {
    }

    public function updateProductStatus()
    {
    }

    public function updateProductStatusBatch()
    {
    }

    public function updateProductPriceBatch()
    {
    }
}
