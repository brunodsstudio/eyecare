#Laravel 10 + Vite + Vue2 + Vuetify2

## ⚡️ How to install
copie .env_copia para .env

docker-compose up --build
docker compose exec app php artisan migrate --seed

APIS

/exames [get, post, delete]
/pacotes [get, post, delete]

/examesAvulsos

/pacotes/remove-exame
/pacotes/{pacote}/attach-exame [inserir exame no pacote]

/pacotes/{pacote}
/storePacoteExameAvulso