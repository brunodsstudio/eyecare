#Laravel 10 + Vite + Vue2 + Vuetify2

## ⚡️ How to install
copie .env_copia para .env

## LARAVEL
/composer install
/npm install
/php artisan server
/php artisan migrate
/php artisan db:seed


## DOCKER
/docker-compose up --build
/docker compose exec app php artisan migrate --seed

## APIS (routes/api.php)
## campos requeridos do banco

/exames [get, post, delete]
/pacotes [get, post, delete]

/examesAvulsos [get]

/pacotes/remove-exame  [delete]
/pacotes/{pacote}/attach-exame [post /inserir exame no pacote]

/pacotes/{pacote} [get / pacote individual]
/storePacoteExameAvulso  [post/ pacote individual]

## stacks
Mysql 8
VUE2.js (vuetify, bootstrap vue, axios)
laravel 10 + Inertia
Node 20

## Bruno de Lima
# 11 9 1210 1715
# brunodsstudio@gmail.com