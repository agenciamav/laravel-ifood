<?php
namespace Agenciamav\LaravelIfood\Http\Controllers\Auth;

use Agenciamav\LaravelIfood\Http\Controllers\Auth\IfoodAuth;

class IfoodClient extends IfoodAuth
{
    protected $client;

    public function __construct()
    {
        $this->client =
            new \GuzzleHttp\Client([
                'base_uri' => 'https://merchant-api.ifood.com.br/',
                'headers' => [
                    'Authorization' => 'Bearer ' . app(IfoodAuth::class)->accessToken,
                ],
            ]);
    }
}
