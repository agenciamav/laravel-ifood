# Laravel Ifood 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/agenciamav/laravel-ifood.svg?style=flat-square)](https://packagist.org/packages/agenciamav/laravel-ifood)
[![Total Downloads](https://img.shields.io/packagist/dt/agenciamav/laravel-ifood.svg?style=flat-square)](https://packagist.org/packages/agenciamav/laravel-ifood)

Pacote Laravel para integração com as novas APIs do Ifood.

---

## Como funciona a autorização: 
O iFood fornece dois fluxos de autorização: o _Fluxo de credencial de aplicativo_ e o *_Fluxo de código de autorização_*. 
Este pacote atente somente o *fluxo de código de autorização*.

### Fluxo de código de autorização:
1. Solicita código de vínculo ✔
2. Recebe código de vínculo e código verificador ✔
3. Insere código de vínculo no Portal do Parceiro ✔
4. Após autorizar o aplicativo, o código de autorização é digitado no aplicativo ✔
5. Solicita token de acesso com código de autorização e código verificador 🟠 _WIP_
6. Aplicativo recebe token de acesso e refresh token
7. Aplicativo usa token para acessar recursos das lojas via as APIs do iFood
8. Aplicativo atualiza o token de acesso com o refresh token

Passo a passo [aqui](https://developer.ifood.com.br/docs/guides/authentication#passo-a-passo-1)

## Instalação
Você pode instalar o pacote via composer:
```bash
composer require agenciamav/laravel-ifood
```

Obtenha as credenciais do seu aplicativo **distribuído** no Portal do Parceiro Ifood e insira no arqivo `.env`:
```php
// .env
IFOOD_CLIENT_ID=******
IFOOD_CLIENT_SECRET=******
```
Publique as configurações e assets do pacote:
```sh
php artisan vendor:publish --provider=Agenciamav\LaravelIfood\LaravelIfoodServiceProvider
```

Isto gerará um arquivo `config/ifood.php` com as configurações do pacote e os arquivos de assets.

```
/config
	/ifood.php

/resources
	/js
		/Pages
			/Ifood
				Auth.vue
				Merchant.vue
				Header.vue
				...
```

Rode o comando `php artisan migrate` para criar as tabelas necessárias.

Pronto! Agora você pode usar os recursos do iFood.

---

## Como usar
Exemplo de uso:
```php
use Agenciamav\LaravelIfood\Models\Merchant;

Merchant::all(); // Obter todas as lojas conectadas
Merchant::show($merchantId); // Obter detalhes de uma loja via ID
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