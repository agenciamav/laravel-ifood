<?php

namespace Agenciamav\LaravelIfood\Http\Controllers\Merchant;

use Agenciamav\LaravelIfood\Http\Controllers\Auth\IfoodClient;

class Merchant extends IfoodClient
{
    public function getAllMerchants()
    {
        $request = $this->client->request('GET', "merchant/v1.0/merchants");
        $response = $request->getBody();
        return $response->getContents();
    }

    public function getMerchant($merchantId)
    {
        $request = $this->client->request('GET', "merchant/v1.0/merchants/$merchantId");
        $response = $request->getBody();
        return $response->getContents();
    }

    public static function all()
    {
        return json_decode(app(Merchant::class)->getAllMerchants());
    }

    public static function show($merchantId)
    {
        return app(Merchant::class)->getMerchant($merchantId);
    }
}
