<?php

namespace Agenciamav\LaravelIfood\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class IfoodAuthorizationCode extends Model
{

	protected $userCode;
	protected $authorizationCode;
	protected $authorizationCodeVerifier;
	protected $verificationUrl;
	protected $verificationUrlComplete;

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'token_expires_date' => 'datetime',
		'is_valid' => 'boolean',
	];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'merchant_id',
		'user_code',
		'authorization_code',
		'authorization_code_verifier',
		'verification_url',
		'verification_url_complete',
		'access_token',
		'refresh_token',
		'token_expires_date',
	];

	protected $appends = [
		'is_valid',
	];

	/**
	 * Get the client model that the authorization code belongs to.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function client()
	{
		return $this->morphTo();
	}

	public function getIsValidAttribute()
	{
		if ($this->token_expires_date > Carbon::now()) {
			return true;
		}

		// if is invalid, delete it
		$this->delete($this->id);

		return false;
	}
}
