migrate:
	sudo docker-compose exec web /bin/bash -c "cd app && php ../vendor/bin/doctrine-migrations migrate"

migrate-diff:
	sudo docker-compose exec web /bin/bash -c "cd app && php ../vendor/bin/doctrine-migrations diff"

up:
	sudo docker-compose up

down:
	sudo docker-compose down
