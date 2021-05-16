<?php

namespace Agenciamav\LaravelIfood\Http\Controllers\Order;

use Agenciamav\LaravelIfood\Http\Controllers\Auth\IfoodClient;

class Details extends IfoodClient
{
    public function getOrderDetails($id)
    {
        // ----------------------
        $request = $this->client->request('GET', "order/v1.0/orders/$id");
        $response = $request->getBody();
        return ($request->getStatusCode() == 200) ? $response->getContents() : $request->getStatusCode();
    }

    public static function show($id)
    {
        return app(Details::class)->getOrderDetails($id);
    }
}
