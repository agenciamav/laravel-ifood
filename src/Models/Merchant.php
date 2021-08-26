<?php

namespace Agenciamav\LaravelIfood\Models;

use Agenciamav\LaravelIfood\IfoodAuthorization;
use Agenciamav\LaravelIfood\IfoodAuthentication;
use Illuminate\Support\Facades\Http;

class Merchant
{
    protected $name;
    protected $corporateName;
    protected $description;
    protected $averageTicket;
    protected $exclusive;
    protected $type;
    protected $status;
    protected $createdAt;
    protected $address;

    protected $access_token;

    public $http;

    public function __construct()
    {
        $this->access_token = IfoodAuthentication::accessToken();

        $this->http = Http::withOptions([
            'base_uri'  => 'https://merchant-api.ifood.com.br/',
        ])->withToken($this->access_token);
    }

    public function fetchAllMerchants()
    {
        $request = $this->http->get("merchant/v1.0/merchants");
        return $request->collect();
    }

    public function fetchMerchant($merchantId)
    {
        $request = $this->http->get("merchant/v1.0/merchants/$merchantId");
        return $request->collect();
    }    

    /**
     * FACADE FUNCTIONS
     */
    public static function all($columns = [])
    {
        return json_decode(app(Merchant::class)->fetchAllMerchants());
    }

    public static function show($merchantId)
    {
        return app(Merchant::class)->fetchMerchant($merchantId);
    }


}
