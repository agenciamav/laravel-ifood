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
		$this->with[] = 'ifoodAuthorization';

		// Set HTTP client
		$this->http = Http::withOptions([
			'base_uri'  => 'https://merchant-api.ifood.com.br/',
			'grantType' => 'authorization_code', // client_credentials | authorization_code | refresh_token
		]);
	}

	// 1. Get the USER CODE to paste in the ifood portal
	public function getUserCode()
	{
		$this->load('ifoodAuthorization');

		// Check if exists an USER CODE and if it's valid
		if ($this->ifoodAuthorization && $this->ifoodAuthorization->user_code != null && $this->ifoodAuthorization->is_valid) {
			// Return USER CODE
			return $this->ifoodAuthorization->user_code;
		}

		// Else, request new USER CODE
		$response = app(IfoodAuthorization::class)->requestUserCode();

		// Save the USER CODE
		$ifoodAuthorizationToken = new IfoodAuthorizationToken;
		$ifoodAuthorizationToken->user_code                     = $response['userCode'];
		$ifoodAuthorizationToken->authorization_code_verifier   = $response['authorizationCodeVerifier'];
		$ifoodAuthorizationToken->verification_url              = $response['verificationUrl'];
		$ifoodAuthorizationToken->verification_url_complete     = $response['verificationUrlComplete'];

		$expires_date = $response["expiresIn"] + time();
		$ifoodAuthorizationToken->authorization_code_expires_date = date('Y-m-d H:i:s', $expires_date);

		$ifoodAuthorizationToken->authorizable_id    = $this->id;
		$ifoodAuthorizationToken->authorizable_type  = self::class;

		$ifoodAuthorizationToken->save();

		// Return just the USER CODE
		return $ifoodAuthorizationToken->user_code;
	}

	public function setAuthorizationCode($authorization_code = null)
	{
		$this->ifoodAuthorization->authorization_code = $authorization_code;
		return $this->ifoodAuthorization->save();
	}

	// 2. Pass the AUTHORIZATION CODE and get the ACCESS TOKEN
	public function	getAccessToken($authorization_code)
	{
		$this->load('ifoodAuthorization');
		$auth = $this->ifoodAuthorization;

		if (is_object($auth) && $auth->access_token !== null && $auth->authorization_code_verifier && $auth->is_valid) {
			IfoodAuthentication::setAccessToken($auth->access_token);
			return $auth->access_token;
		}

		if (!$authorization_code) {
			$authorization_code = $auth->authorization_code;
		}

		$response = app(IfoodAuthorization::class)->requestAccessToken($authorization_code, $auth->authorization_code_verifier);
		
		if (isset($response['error'])) {
			return $response;
		}

		// Salva o access token
		$auth->authorization_code   = $authorization_code;
		$auth->access_token         = $response['accessToken'];
		$auth->refresh_token        = $response['refreshToken'];

		$token_expires_date 				= $response['expiresIn'] + time();
		$auth->token_expires_date   = date('Y-m-d H:i:s', $token_expires_date);

		$auth->save();
		IfoodAuthentication::setAccessToken($auth->access_token);

		return $auth->access_token;
	}

	public function ifoodAuthorization()
	{
		return $this->morphOne(IfoodAuthorizationToken::class, 'authorizable');
	}

	public function merchants()
	{
		if (!$this->ifoodAuthorization) {
			return collect();
		}
		
		return collect(Merchant::all());
	}
}
