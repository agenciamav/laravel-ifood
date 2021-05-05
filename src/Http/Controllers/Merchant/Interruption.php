<?php

namespace Agenciamav\LaravelIfood\Http\Controllers\Merchant;

use Agenciamav\LaravelIfood\Http\Controllers\Auth\IfoodClient;

class Interruption extends IfoodClient
{
    public function getInterruption($merchantId)
    {
        $request = $this->client->request('GET', "merchant/v1.0/merchants/$merchantId/interruptions");
        $response = $request->getBody();
        return $response->getContents();
    }

    public function postInterruption($merchantId)
    {
        // ...
    }

    public function deleteInterruption($merchantId, $interruptionId)
    {
        $request = $this->client->request('DELETE', "merchant/v1.0/merchants/$merchantId/interruptions/$interruptionId");
        $response = $request->getBody();
        return $response->getContents();
    }
}
