# Projet BestLoc

Ce projet est une librairie qui permet d'échanger avec deux bases de données:
- Une base MySQL
- Une base MongoDB

## Tests unitaires

Ce projet dispose de tests unitaires dans le dossier `/tests`

Pour les lancer, le projet dispose d'un script composer:
```sh
    composer test
```
Ce script fonctionne comme le CLI de phpunit avec les mêmes paramètres.
Cela permet entre autres de lancer un test spécifique:
```sh
    composer test <chemin jusqu\'au test>
```