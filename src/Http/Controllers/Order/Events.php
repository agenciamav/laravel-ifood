<?php

namespace Agenciamav\LaravelIfood\Http\Controllers\Order;

use Agenciamav\LaravelIfood\Http\Controllers\Auth\IfoodClient;

class Events extends IfoodClient
{
    public function getOrderEvents()
    {
        $request = $this->client->request('GET', "order/v1.0/events:polling");
        $response = $request->getBody();
        return response($response->getContents(), $request->getStatusCode());
    }

    public function acknowledgeEvents()
    {
    }

    public static function sendAcknowledgement($event)
    {
        return !!app(Events::class)->acknowledgeEvents($event);
    }

    public static function check()
    {
        return app(Events::class)->getOrderEvents();
    }

    public static function hasNewEvents()
    {
        return !!app(Events::class)->check()->getContent();
    }
}
