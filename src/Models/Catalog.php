<?php

namespace Agenciamav\LaravelIfood\Models;

use Agenciamav\LaravelIfood\IfoodClient;

class Catalog
{
    use IfoodClient;
    public function getCatalogs($merchantId)
    {
        $request = $this->client->request('GET', "catalog/v1.0/merchants/$merchantId/catalogs");
        $response = $request->getBody();
        return response($response->getContents(), $request->getStatusCode());
    }

    public function fetchChangelog($merchantId, $catalogId)
    {
        $request = $this->client->request(
            'GET',
            "catalog/v1.0/merchants/$merchantId/catalogs/$catalogId/changelog"
        );
        $response = $request->getBody();
        return response($response->getContents(), $response->getStatusCode());
    }

    public function listUnsellableItems($merchantId, $catalogId)
    {
        $request = $this->client->request(
            'GET',
            "catalog/v1.0/merchants/$merchantId/catalogs/$catalogId/unsellableItems"
        );
        $response = $request->getBody();
        return response($response->getContents(), $response->getStatusCode());
    }
}
