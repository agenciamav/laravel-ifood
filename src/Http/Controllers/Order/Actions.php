<?php

namespace Agenciamav\LaravelIfood\Http\Controllers\Order;

use Agenciamav\LaravelIfood\Http\Controllers\Auth\IfoodClient;

class Actions extends IfoodClient
{
    public function confirm($id)
    {
        $request = $this->client->request('POST', "order/v1.0/orders/$id/confirm");
        return $request->getStatusCode() == 202;
    }

    public function readyToPickup()
    {
    }

    public function dispatch($id)
    {
        $request = $this->client->request('POST', "order/v1.0/orders/$id/dispatch");
        return $request->getStatusCode() == 202;
    }

    public function requestCancellation()
    {
    }

    public function acceptCancellation()
    {
    }

    public function denyCancellation()
    {
    }
}