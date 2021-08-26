<?php

namespace Agenciamav\LaravelIfood;

use Illuminate\Support\Facades\Http;

class IfoodAuthentication extends IfoodAuthorization
{
	public $access_token;

	public function access_token($access_token = null)
	{
		if ($access_token) {
			$this->access_token = $access_token;
		}
		return $this->access_token;
	}

	public static function accessToken()
	{
		return app(IfoodAuthentication::class)->access_token();
	}

	public static function  setAccessToken($access_token = null)
	{
		if ($access_token) {
			app(IfoodAuthentication::class)->access_token($access_token);
		}
		return app(IfoodAuthentication::class)->access_token();
	}
}
