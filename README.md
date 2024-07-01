<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Passo a Passo

Copie o arquivo .env.example e renomeie para .env

``cp .env.example .env``

Execute o composer install

``composer install``

Utilize o serviço para iniciar o mysql e execute as migrations e os seeders

``php artisan migrate --seed``

Inicie o servidor

``php artisan serve``

Consuma a api seguindo a documentação disponível na rota "/api/documentation"
Será necessário realizar login e utilizar o token gerado para autenticação Bearer Token

O projeto também está rodando na seguinte URL

``https://airport-api-40ce70907706.herokuapp.com/``
