<p align="center">
	<img src="https://raw.githubusercontent.com/agenciamav/laravel-ifood/master/resources/img/laravelifood.jpg" width="100%">
</p>

[![Latest Version on Packagist](https://img.shields.io/packagist/v/agenciamav/laravel-ifood.svg?style=flat-square)](https://packagist.org/packages/agenciamav/laravel-ifood)
[![Total Downloads](https://img.shields.io/packagist/dt/agenciamav/laravel-ifood.svg?style=flat-square)](https://packagist.org/packages/agenciamav/laravel-ifood)

Pacote Laravel para integração com as novas APIs do Ifood.

---

## Instalação
Instale o pacote via composer:
```bash
composer require agenciamav/laravel-ifood
```

Obtenha as credenciais do seu aplicativo do tipo **distribuído** em [developer.ifood.com.br](https://developer.ifood.com.br/pt-BR/developer/applications) e insira no arquivo `.env`:
```php
// .env
IFOOD_CLIENT_ID=******
IFOOD_CLIENT_SECRET=******
```

Adicione o trait `LaravelIfood` ao model que deseja integrar:
```php
namespace App\Models;

use Agenciamav\LaravelIfood\LaravelIfood;

class User extends Model
{
	use LaravelIfood;
}
```
Isto irá adicionar ao model as funções necessárias para autenticação.

Caso precise de uma interface para autorização da aplicação, você pode publicar as configurações e assets do pacote:
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
Autorizando a aplicação:
```php
$user = request()->user(); // Ou qualquer model que use o trait

// 1. Obtém USER CODE para inserir no portal do iFood
$user->getUserCode();  // Retorna: 'XXXX-XXXX'

// 2. Após informar o USER CODE no portal do iFood, um AUTHORIZATION CODE será gerado
$auth_code = 'XXXX-XXXX'; // O código de autorização gerado pelo iFood

// 3. Passando o AUTHORIZATION CODE, obtém-se o token de acesso
$user->getAccessToken($auth_code); // Retorna o ACCESS TOKEN
```
Com isto o token de acesso será armazenado no banco de dados e ficará salvo na seção para ser utilizado em todas as requisições.

Exemplo de uso:
```php
use Agenciamav\LaravelIfood\Models\Merchant;

Merchant::all(); // Obtém todas as lojas conectadas
Merchant::show('xxx...'); // Obtém detalhes de uma loja via UUID
```

Outras funcionalidades estão sendo implementadas.

Você pode contribuir para o desenvolvimento do pacote. Faça um fork deste repositório e envie pull requests.

Você pode encontrar mais informações na [documentação do iFood](https://developer.ifood.com.br/pt-BR/developer/api-documentation).

---
## Sobre autorização e autenticação: 
O Ifood fornece dois fluxos de autorização: o **_Fluxo de credencial de aplicativo_** e o **_Fluxo de código de autorização_**. 
Este pacote visa atender o **fluxo de código de autorização** para aplicativos cadastrados como [tipo "distribuído"](https://developer.ifood.com.br/pt-BR/developer/applications/register).

Esse fluxo requer que o usuário do seu aplicativo seja capaz de se autenticar via Portal do Parceiro e autorizar a conexão solicitada pelo app.

### Fluxo de código de autorização:
1. Seu app solicita código de vínculo ✔
2. Recebe código de vínculo e código verificador ✔
3. Insere código de vínculo no Portal do Parceiro ✔
4. Após autorizar o aplicativo, o código de autorização é digitado no aplicativo ✔
5. Solicita token de acesso com código de autorização e código verificador ✔
6. Aplicativo recebe token de acesso e refresh token ✔
7. Aplicativo usa token para acessar recursos das lojas via as APIs do iFood ✔
8. Aplicativo atualiza o token de acesso com o refresh token  🟠 _WIP_

Passo a passo [aqui](https://developer.ifood.com.br/docs/guides/authentication#passo-a-passo-1)

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