<?php

namespace Agenciamav\LaravelIfood;

use Agenciamav\LaravelIfood\Models\IfoodAuthorizationCode;

trait IfoodClient
{
	use IfoodAuth;

	protected $client; // HTTP Client

	public function authorization_code()
	{
		return $this->morphOne(IfoodAuthorizationCode::class, 'client');
	}

	public function authorization_codes()
	{
		return $this->morphMany(IfoodAuthorizationCode::class, 'client');
	}
}
