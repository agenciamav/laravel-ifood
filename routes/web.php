<?php

use Agenciamav\LaravelIfood\Models\IfoodAuthorizationCode;
use Illuminate\Support\Facades\Route;

Route::post('/auth', function () {
	$authorizationCodeVerifier = request()->input('authorizationCodeVerifier'); // just for reference
	$authorizationCode = request()->get('authorizationCode');

	// get the IfoodAuthorizationCode that matches the authorization code verifier
	$authorizationCode = IfoodAuthorizationCode::where('authorization_code_verifier', $authorizationCodeVerifier)->first();
	$authorizationCode->authorization_code = request()->get('authorizationCode');
	$authorizationCode->save();

	return response()->json(['status' => 'success']);
})->name('ifood.auth');
