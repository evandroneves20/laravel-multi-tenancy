## Laravel Multi Tenancy

Pequeno Exemplo de uso de multiplas bases de dados em Laravel. Projeto final do curso https://www.especializati.com.br/curso-laravel-multi-tenancy-multi-database com alguns ajustes.

## Pré-requisitos

Para que o sistema rode sem problemas é necessário configurar os virtualHosts: post_master, post_tenant1 e post_tenant2.
Tambem é necessário criar as bases de dados: db_master, db_tenant1 e db_tenant2

## Instalação

```shell script
php artisan migrate
php artisan db:seed CompanyTableSeeder
php artisan tenant:migrate
```
## Dicas
* Para as migrations dos tenants, criar normalmente a migration e colocar na pasta migrations/tenant 
