# Nome do projeto
PROJECT_NAME=laravel_docker

# COMO USARRRR
# up → Inicia os containers em background (-d).
# down → Para e remove os containers.
# restart → Reinicia os containers.
# logs → Mostra os logs em tempo real.
# bash → Entra no terminal do container Laravel.
# migrate → Executa php artisan migrate.
# seed → Executa php artisan db:seed.
# fresh → Apaga o banco e recria as tabelas (migrate:fresh --seed).
# composer-install → Roda composer install dentro do container.
# artisan → Permite rodar qualquer comando do Artisan (make artisan cmd=config:cache).
# cache → Limpa todos os caches (config, cache, route, view).
# build → Reconstrói as imagens do Docker.
# stop → Para os containers sem removê-los.
# ps → Lista os containers em execução.
# prune → Remove containers, volumes e cache antigos do Docker.

# Comandos do Docker
up:
	@docker compose up -d

down:
	@docker compose down

restart:
	@docker compose down && docker compose up -d

logs:
	@docker compose logs -f

bash:
	@docker compose exec app bash

migrate:
	@docker compose exec app php artisan migrate

seed:
	@docker compose exec app php artisan db:seed

fresh:
	@docker compose exec app php artisan migrate:fresh --seed

composer-install:
	@docker compose exec app composer install

artisan:
	@docker compose exec app php artisan $(cmd)

cache:
	@docker compose exec app php artisan config:clear && \
	docker compose exec app php artisan cache:clear && \
	docker compose exec app php artisan route:clear && \
	docker compose exec app php artisan view:clear

build:
	@docker compose up -d --build

stop:
	@docker compose stop

ps:
	@docker ps

prune:
	@docker system prune -a -f



