<?php

namespace Agenciamav\LaravelIfood;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Agenciamav\LaravelIfood\Models\IfoodAuthorizationToken;

class IfoodAuthorization
{
    public $http;

    public function __construct()
    {
        // Set HTTP client
        $this->http = Http::withOptions([
            'base_uri'  => 'https://merchant-api.ifood.com.br/',
            'grantType' => 'authorization_code', // client_credentials | authorization_code | refresh_token
        ]);
    }

    // 1. Get the USER CODE to paste in the ifood portal
    public function requestUserCode()
    {
        $request = $this->http->asForm()->post("authentication/v1.0/oauth/userCode", [
            'clientId' => getenv('IFOOD_CLIENT_ID')
        ]);
        return $request->json();
    }

    // 2. Pass the AUTHORIZATION CODE and get the ACCESS TOKEN
    public function requestAccessToken($authorization_code, $authorization_code_verifier)
    {
        $request = $this->http->asForm()->post("authentication/v1.0/oauth/token", [
            'grantType' => 'authorization_code',
            'clientId' => getenv('IFOOD_CLIENT_ID'),
            'clientSecret' => getenv('IFOOD_CLIENT_SECRET'),
            'authorizationCode' => $authorization_code,
            'authorizationCodeVerifier' => $authorization_code_verifier,
            // 'refreshToken' => $this->IfoodAuthorizationToken->grant_type == 'refresh_token' ? $this->IfoodAuthorizationToken->refresh_token : null,
        ]);
        $response = $request->json();

        // Check if the response contains ERROR
        if (isset($response['error'])) {
            dd('requestAccessToken', $authorization_code, $authorization_code_verifier, $response);
            return $response;
        }


        if (isset($response['accessToken'])) {
            $this->access_token = $response['accessToken'];
            return $response;
        }

        return false;
    }
}
