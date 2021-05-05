# Laravel Ifood 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/agenciamav/laravel-ifood.svg?style=flat-square)](https://packagist.org/packages/agenciamav/laravel-ifood)
[![Total Downloads](https://img.shields.io/packagist/dt/agenciamav/laravel-ifood.svg?style=flat-square)](https://packagist.org/packages/agenciamav/laravel-ifood)

A Laravel package to consume official Ifood APIs.

## Installation

! Important!
This package is built to work on a project that uses Laravel Jetstream with TEAMS and Inertia stack. Otherwise it will not work.

You can install the package via composer:

```bash
composer require agenciamav/laravel-ifood
```
Get your app credentials on Ifood developoer portal
```php
// Set .ENV variables
IFOOD_DIST_CLIENT_ID=
IFOOD_DIST_CLIENT_SECRET=
```
Publish the frontend assets
```sh
php artisan vendor:publish --provider=Agenciamav\LaravelIfood\LaravelIfoodServiceProvider
```
Run migrations
```sh
php artisan migrate
```


## Usage
Example of use
```php
use Agenciamav\LaravelIfood\Http\Controllers\Merchant\Merchant;

Merchant::all(); // Get all connected stores
Merchant::show($merchantId); // Get store by ID
```

Example of authentication
```php
// routes/web.php
use Illuminate\Support\Facades\Route;
use Agenciamav\LaravelIfood\Http\Controllers\Merchant\Merchant;
use Agenciamav\LaravelIfood\Http\Controllers\Auth\IfoodAuth;

Route::get('/ifood', function (Request $request) {
	if (!request()->user()->currentTeam->ifood_authorization_code) {
		return redirect('/ifood/auth');
	}

	// AUTENTICADO!!!
	return Merchant::show(request()->user()->currentTeam->ifood_merchant_id),
})->name('ifood');

// EXIBE CÓDIGO PARA COLAR NO IFOOD
Route::get('/ifood/auth', function () {
	return IfoodAuth::getUserCode();
})->name('ifood.auth');

// SALVA CÓDIGO GERADO PELO IFOOD
Route::post('/ifood/auth', function () {
	$team = request()->user()->currentTeam;
	$team->ifood_authorization_code = request()->get('authorizationCode');
	$team->ifood_authorization_code_verifier = request()->get('authorizationCodeVerifier');
	$team->save();

	return redirect('/ifood');
});

```



---

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email agenciamav@gmail.com instead of using the issue tracker.

## Credits

-   [Luciano Tonet](https://github.com/lucianotonet)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.