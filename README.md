master-thesis
================

Ce projet a été réalisé dans le but d'un mémoire de master. L'objectif étant de réaliser une analyse comparatives des performances entre Rest et Graphql

EN Version

This project has been done for a master thesis. The goal was to make a performance analyse of graphql and rest usgin symfony projects

================

Commandes utiles pour mettre en place se projet

Creation de la base de données sur mysql

php bin/console doctrine:database:create

Creation/Mis à jour du schema de base de données

php bin/console doctrine:schema:update --force

load fixtures in db (will charge 100 customers with random generated data)

php bin/console doctrine:fixtures:load
