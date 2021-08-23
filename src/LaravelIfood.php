<?php

namespace Agenciamav\LaravelIfood;

use \Agenciamav\LaravelIfood\IfoodAuth;
use \Agenciamav\LaravelIfood\Models\IfoodAuthorizationCode;

class LaravelIfood
{

	use IfoodAuth;

	public $client;

	public function __construct()
	{
		$this->client =
			new \GuzzleHttp\Client([
				'base_uri' => 'https://merchant-api.ifood.com.br/',
				'headers' => [
					'Authorization' => 'Bearer ' . $this->accessToken, // in the auth trait
				],
			]);

		// $team = request()->user()->currentTeam;

		// if ($team) {
		// 	$this->grantType = 'authorization_code';

		// 	if (!$team->ifood_access_token) {
		// 		$response = $this->getToken();

		// 		$team->ifood_access_token = $response->accessToken;
		// 		$team->ifood_refresh_token = $response->refreshToken;
		// 		$team->ifood_token_expires_date = Carbon::now()->addSeconds($response->expiresIn)->toDateTimeString();
		// 		$team->save();
		// 	} elseif (Carbon::create($team->ifood_token_expires_date)->lte(Carbon::now())) {
		// 		if ($team->ifood_refresh_token) {
		// 			$this->grantType = 'refresh_token';
		// 		}
		// 		$response = $this->getToken();
		// 		$team->ifood_access_token = $response->accessToken;
		// 		$team->ifood_refresh_token = $response->refreshToken;
		// 		$team->ifood_token_expires_date = Carbon::now()->addSeconds($response->expiresIn)->toDateTimeString();
		// 		$team->save();
		// 	}

		// 	$this->accessToken = $team->ifood_access_token;
		// 	$this->refreshToken = $team->ifood_refresh_token;
		// } else {
		// 	$this->grantType = 'client_credentials';
		// 	$this->accessToken = $this->getToken();
		// 	// session(['IFOOD_ACCESS_TOKEN' => $this->accessToken]);
		// }


	}
}
