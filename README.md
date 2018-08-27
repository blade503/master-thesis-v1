master-thesis-v2
================

Mettre en place la base de données

php bin/console doctrine:database:create

update schema

php bin/console doctrine:schema:update --force

load fixtures

php bin/console doctrine:fixtures:load