<?php

/*
 * Place your Ifood configuration here.
 */
return [
		'api_key' 			=> env('IFOOD_CLIENT_ID'),
		'api_secret' 		=> env('IFOOD_CLIENT_SECRET'),
		'table_name' 		=> 'ifood',
		// 'client_model' 	=> 'App\\Models\\User'	// The model that will be used to link the user to the ifood table
	];
