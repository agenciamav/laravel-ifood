<?php

namespace Agenciamav\LaravelIfood;

use Agenciamav\LaravelIfood\Models\IfoodAuthorizationCode;
use GuzzleHttp\Exception\ClientException;

trait IfoodAuth
{
    protected $grantType;

    protected $accessToken;
    protected $refreshToken;

    // RETURN OBJECT
    // Retorna código para colar no painel do IFOOD
    public function requestAuthorizationCode()
    {
        // Se o cliente já tem um authorization code, retorna o mesmo
        if ($this->authorization_code && $this->authorization_code->is_valid) {
            return $this->authorization_code;
        }

        // Senão, cria um novo authorization code
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'https://merchant-api.ifood.com.br/',
        ]);

        try {
            $request = $this->client->request('POST', "authentication/v1.0/oauth/userCode", [
                'allow_redirects' => false,
                'header' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'clientId' => getenv('IFOOD_CLIENT_ID'),
                ],
            ]);

            $response = $request->getBody()->getContents();
            $response = json_decode($response, true);

            $authorizationCode = $this->createAuthorizationCode($response);
            return $authorizationCode;
        } catch (ClientException $e) {
            return $e->getMessage();
        }
    }

    // RETURN OBJECT
    public function requestToken()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'https://merchant-api.ifood.com.br/',
        ]);

        $formParams = [
            'grantType' => $this->grantType,
            'clientId' => getenv('IFOOD_CLIENT_ID'),
            'clientSecret' => getenv('IFOOD_CLIENT_SECRET'),
            'authorizationCode' => $this->authorization_code,
            'authorizationCodeVerifier' => $this->authorization_code_verifier,
            'refreshToken' => $this->grantType == 'refresh_token' ? $this->refresh_token : null,
        ];

        try {
            $request = $this->client->request('POST', "authentication/v1.0/oauth/token", [
                'allow_redirects' => false,
                'header' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => $formParams
            ]);

            $response = $request->getBody()->getContents();
            $response = json_decode($response);

            // $this->accessToken = $response->accessToken;
            // $this->refreshToken = $response->refreshToken;
            return  $response;
        } catch (ClientException $e) {


            if ($e->getCode() == 401) {
                $this->access_token = null;
                $this->authorization_code = null;
                $this->authorization_code_verifier = null;
                $this->refresh_token = null;
                $this->save();
            }

            return $e->getMessage();
        }
    }

    public function createAuthorizationCode($response)
    {
        $authorizationCode = new IfoodAuthorizationCode();
        $authorizationCode->user_code = $response['userCode'];
        $authorizationCode->authorization_code_verifier = $response['authorizationCodeVerifier'];
        $authorizationCode->verification_url = $response['verificationUrl'];
        $authorizationCode->verification_url_complete = $response['verificationUrlComplete'];

        $expires_date = $response["expiresIn"] + time();
        $authorizationCode->token_expires_date = date('Y-m-d H:i:s', $expires_date);

        $authorizationCode->client_id = $this->id;
        $authorizationCode->client_type = self::class;

        $authorizationCode->save();

        return $authorizationCode;
    }
}
