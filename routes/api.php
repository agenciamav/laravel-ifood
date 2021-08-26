<?php

use Illuminate\Support\Facades\Route;

Route::get('/merchants', function () {
	return response()->json([
		'status' => 'success',
		'merchants' => [
			[
				'id' => 1,
				'name' => 'Merchant 1'
			],
			[
				'id' => 2,
				'name' => 'Merchant 2'
			]
		]
	]);
});

Route::get('/merchants/{id}', function ($id) {
	return response()->json([
		'status' => 'success',
		'merchant' => ['id' => $id]
	]);
});
