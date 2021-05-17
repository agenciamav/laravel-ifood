<?php

namespace Agenciamav\LaravelIfood\Http\Controllers\Auth;

use GuzzleHttp\Exception\ClientException;
use Carbon\Carbon;

class IfoodAuth
{
    protected $grantType;

    protected $accessToken;
    protected $refreshToken;

    protected $authorizationCode;
    protected $authorizationCodeVerifier;
    protected $verificationUrl;
    protected $verificationUrlComplete;

    public function __construct()
    {

        $team = request()->user()->currentTeam;

        if ($team) {
            $this->grantType = 'authorization_code';

            if (!$team->ifood_access_token) {
                $response = $this->getToken();

                $team->ifood_access_token = $response->accessToken;
                $team->ifood_refresh_token = $response->refreshToken;
                $team->ifood_token_expires_date = Carbon::now()->addSeconds($response->expiresIn)->toDateTimeString();
                $team->save();
            } elseif (Carbon::create($team->ifood_token_expires_date)->lte(Carbon::now())) {
                if ($team->ifood_refresh_token) {
                    $this->grantType = 'refresh_token';
                }
                $response = $this->getToken();
                $team->ifood_access_token = $response->accessToken;
                $team->ifood_refresh_token = $response->refreshToken;
                $team->ifood_token_expires_date = Carbon::now()->addSeconds($response->expiresIn)->toDateTimeString();
                $team->save();
            }

            $this->accessToken = $team->ifood_access_token;
            $this->refreshToken = $team->ifood_refresh_token;
        } else {
            $this->grantType = 'client_credentials';
            $this->accessToken = $this->getToken();
            // session(['IFOOD_ACCESS_TOKEN' => $this->accessToken]);
        }
    }

    // RETURN OBJECT
    // Retorna código para colar no painel do IFOOD
    public static function getUserCode()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://merchant-api.ifood.com.br/',
        ]);

        try {
            $request = $client->request('POST', "authentication/v1.0/oauth/userCode", [
                'allow_redirects' => false,
                'header' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'clientId' => getenv('IFOOD_DIST_CLIENT_ID'),
                ],
            ]);

            $response = $request->getBody()->getContents();
            $response = json_decode($response);
            return collect($response)->toArray();
        } catch (ClientException $e) {
            return $e->getMessage();
        }
    }

    // RETURN OBJECT
    public function getToken()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://merchant-api.ifood.com.br/',
        ]);

        $formParams = [
            'grantType' => $this->grantType,
            'clientId' => $this->grantType == 'client_credentials' ? getenv('IFOOD_CLIENT_ID') : getenv('IFOOD_DIST_CLIENT_ID'),
            'clientSecret' => $this->grantType == 'client_credentials' ? getenv('IFOOD_CLIENT_SECRET') : getenv('IFOOD_DIST_CLIENT_SECRET'),
            'authorizationCode' => request()->user()->currentTeam->ifood_authorization_code,
            'authorizationCodeVerifier' => request()->user()->currentTeam->ifood_authorization_code_verifier,
            'refreshToken' => $this->grantType == 'refresh_token' ? request()->user()->currentTeam->ifood_refresh_token : null,
        ];

        try {
            $request = $client->request('POST', "authentication/v1.0/oauth/token", [
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
                $team = request()->user()->currentTeam;
                $team->ifood_access_token = null;
                $team->ifood_authorization_code = null;
                $team->ifood_authorization_code_verifier = null;
                $team->ifood_refresh_token = null;
                $team->save();
            }

            return $e->getMessage();
        }
    }

    public static function getAccessToken()
    {
        return app(IfoodAuth::class)->accessToken;
    }

    public static function getAuthorizationCode()
    {
        return app(IfoodAuth::class)->authorizationCode;
    }
    public static function getAuthorizationCodeVerifier()
    {
        return app(IfoodAuth::class)->authorizationCodeVerifier;
    }
    public static function getVerificationUrl()
    {
        return app(IfoodAuth::class)->verificationUrl;
    }
    public static function getVerificationUrlComplete()
    {
        return app(IfoodAuth::class)->verificationUrlComplete;
    }
}
