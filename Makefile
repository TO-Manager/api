.SILENT:
PORT?=8888

OK_COLOR = \033[0;32m
NO_COLOR = \033[m

server: ## Lacement du serveur
	echo "Lancement  du serveur sur $(OK_COLOR)http://localhost:$(PORT)$(NO_COLOR)"
	php -S localhost:$(PORT) -t public

install: composer.json composer.lock ## Installation des dépendances
	composer self-update
	composer install

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'