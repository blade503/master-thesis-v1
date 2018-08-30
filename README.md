master-thesis
================

Creation de la base de données sur mysql

php bin/console doctrine:database:create

Creation/Mis à jour du schema de base de données

php bin/console doctrine:schema:update --force

load fixtures in db (will charge 100 customers with random generated data)

php bin/console doctrine:fixtures:load
