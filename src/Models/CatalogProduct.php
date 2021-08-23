<?php

namespace Agenciamav\LaravelIfood\Models;

use Agenciamav\LaravelIfood\IfoodClient;

class CatalogProduct
{
    use IfoodClient;
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
