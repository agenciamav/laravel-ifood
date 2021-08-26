<?php

namespace Agenciamav\LaravelIfood\Controllers;

use Agenciamav\LaravelIfood\IfoodClient;

class MerchantStatus
{
    use IfoodClient;
    public function getAllStatusDetails($merchantId)
    {
        $request = $this->client->request('GET', "merchant/v1.0/merchants/$merchantId/status");
        $response = $request->getBody();
        return $response->getContents();
    }

    public function getStatusDetails($merchantId, $operation)
    {
        $request = $this->client->request('GET', "merchant/v1.0/merchants/$merchantId/status/$operation");
        $response = $request->getBody();
        return $response->getContents();
    }

    public static function all($merchantId)
    {
        return app(Status::class)->getAllStatusDetails($merchantId);
    }

    public static function details($merchantId, $operation)
    {
        return app(Status::class)->getStatusDetails($merchantId, $operation);
    }
}
