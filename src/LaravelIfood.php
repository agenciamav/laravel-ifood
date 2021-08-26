<?php

namespace Agenciamav\LaravelIfood;

use Agenciamav\LaravelIfood\Models\Merchant;
use Agenciamav\LaravelIfood\Models\IfoodAuthorizationToken;
use Agenciamav\LaravelIfood\IfoodAuthorization;
use Illuminate\Support\Facades\Http;

trait LaravelIfood
{
	protected $http;

	public function initializeLaravelIfood()
	{
		// Set HTTP client
		$this->http = Http::withOptions([
			'base_uri'  => 'https://merchant-api.ifood.com.br/',
			'grantType' => 'authorization_code', // client_credentials | authorization_code | refresh_token
		]);
	}

	// 1. Get the USER CODE to paste in the ifood portal
	public function getUserCode()
	{
		if ($this->IfoodAuthorizationToken && $this->IfoodAuthorizationToken->user_code != null) {
			return $this->IfoodAuthorizationToken->user_code;
		}

		$response = app(IfoodAuthorization::class)->requestUserCode();

		// Salva o authorization code
		$ifoodAuthorizationToken = new IfoodAuthorizationToken;
		$ifoodAuthorizationToken->user_code                     = $response['userCode'];
		$ifoodAuthorizationToken->authorization_code_verifier   = $response['authorizationCodeVerifier'];
		$ifoodAuthorizationToken->verification_url              = $response['verificationUrl'];
		$ifoodAuthorizationToken->verification_url_complete     = $response['verificationUrlComplete'];

		$expires_date = $response["expiresIn"] + time();
		$ifoodAuthorizationToken->authorization_code_expires_date = date('Y-m-d H:i:s', $expires_date);

		$ifoodAuthorizationToken->client_id    = $this->id;
		$ifoodAuthorizationToken->client_type  = self::class;

		$ifoodAuthorizationToken->save();

		return $ifoodAuthorizationToken->user_code;
	}

	// 2. Pass the AUTHORIZATION CODE and get the ACCESS TOKEN
	public function	getAccessToken($authorization_code)
	{
		if ($this->IfoodAuthorizationToken && $this->IfoodAuthorizationToken->access_token !== null) {

			return $this->IfoodAuthorizationToken->access_token;
		}

		$response = app(IfoodAuthorization::class)->requestAccessToken($authorization_code, $this->IfoodAuthorizationToken->authorization_code_verifier);

		if (isset($response['error'])) {
			return false;
		}

		// Salva o access token
		$this->IfoodAuthorizationToken->authorization_code   = $authorization_code;
		$this->IfoodAuthorizationToken->access_token         = $response['accessToken'];
		$this->IfoodAuthorizationToken->refresh_token        = $response['refreshToken'];

		$token_expires_date = $response['expiresIn'] + time();
		$this->IfoodAuthorizationToken->token_expires_date   = date('Y-m-d H:i:s', $token_expires_date);

		$this->IfoodAuthorizationToken->save();

		// $this->IfoodAuthorizationToken->refresh();

		return $this->IfoodAuthorizationToken->access_token;
	}

	public function IfoodAuthorizationToken()
	{
		return $this->morphOne(IfoodAuthorizationToken::class, 'client');
	}

	public function merchants()
	{
		if (!$this->IfoodAuthorizationToken) {
			return collect();
		}
		IfoodAuthentication::setAccessToken($this->IfoodAuthorizationToken->access_token);
		return collect(Merchant::all());
	}
}
