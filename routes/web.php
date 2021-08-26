<?php

use Illuminate\Support\Facades\Route;
use Agenciamav\LaravelIfood\IfoodAuthorization;
use Agenciamav\LaravelIfood\IfoodAuthentication;

Route::get('/', function () {

	$user = request()->user();

	// returns the user code to paste in the ifood portal
	// $user_code = $user->getUserCode();
	// dd($user_code);

	// Get a new access token, passing the authorization code
	$access_token = $user->getAccessToken('DJSF-PSGD');
	// dd($access_token);


	$merchants = $user->merchants();
	dd($merchants);

	// if ($ifoodAuthorizationToken == null) {
	// 	return redirect('/ifood/auth');
	// }

	// IfoodAuthorization::setAuth($ifoodAuthorizationToken);
	// $auth       = IfoodAuthorization::getAuth();

	// dd($userCode, $auth);

	// if ($userCode == null) {
	//     return redirect('/ifood/auth');
	// }

	// Client (User | Store | Any ... )
	// $client = request()->user();
	// $ifoodAuthorizationToken = $client->ifoodAuthorizationToken;    

	// $user_code = IfoodAuthorization::getUserCode();

	// dd($user_code);

	// Client has Ifood Access Token ?    
	// if ($ifoodAuthorizationToken == null || $ifoodAuthorizationToken->access_token == null) {
	//     return redirect('/ifood/auth');
	// }

	// // Client Ifood Access Token
	// $merchants1 = $client->merchants();
	// $merchants2 = Merchant::all();
	// dd($merchants1, $merchants2, $ifoodAuthorizationToken->access_token);

	// // Client received the USER CODE, now we can request the AUTHORIZATION TOKEN
	// return Inertia::render('Ifood/Auth', [
	//     'ifood_authorization_token' => $ifoodAuthorizationToken
	// ]);
})->middleware(['auth', 'verified'])->name('ifood');


Route::get('/auth', function () {
	// Client (User | Store | Any ... )
	$client = request()->user();
	$ifoodAuthorizationToken = $client->IfoodAuthorizationToken;
	dd($ifoodAuthorizationToken);
	$userCode   = IfoodAuthorization::getUserCode();

	dd($ifoodAuthorizationToken, $userCode);

	IfoodAuthorization::setAuth($ifoodAuthorizationToken);
	$auth       = IfoodAuthorization::getAuth();

	dd($userCode, $auth);


	// Client must have valid USER CODE to init the auth process
	if (
		$ifoodAuthorizationToken == null || $ifoodAuthorizationToken->user_code == null
	) {
		$client->requestNewUserCode();
		return redirect('/ifood/auth');
	}

	// if the client has already received the USER CODE, AUTHORIZATION TOKEN, and ACCESS TOKEN
	if ($ifoodAuthorizationToken->access_token != null) {
		// we can redirect to the dashboard
		return redirect('/ifood');
	}

	// Client received the USER CODE, now we can request the AUTHORIZATION TOKEN
	return Inertia::render('Ifood/Auth', [
		'ifood_authorization_token' => $ifoodAuthorizationToken,
	]);
})->middleware(['auth', 'verified'])->name('ifood');



Route::get('/ifood/merchants', function () {
	$client = request()->user();
	$merchants = $client->merchants();
	dd($merchants);
	return Inertia::render('Ifood/Merchants', [
		'merchants' => $merchants
	]);
})->middleware(['auth', 'verified'])->name('ifood');