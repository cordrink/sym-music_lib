# Projet Symfony 7 de Gestion de Bibliothèque Numérique

## Description

Ce projet est une application Symfony 7 dédiée à la gestion d'une bibliothèque numérique de musique. Il permet de gérer
des artistes, des albums, des morceaux de musique et des styles musicaux.

## Prérequis

- PHP 8.2 ou supérieur
- Composer
- Symfony CLI
- Un serveur de base de données (MySQL ou MariaDB)

## Installation

1. **Clonez le dépôt :**

   ```bash
   git clone https://github.com/cordrink/sym-music_lib.git
   cd sym-music_lib
   ```

2. **Installez les dépendances :**

   ```bash
    composer install
   ```

## Configuration de la Base de Données

1. **Créez la base de données :**

   ```bash
    php bin/console doctrine:database:create
   ```

2. **Exécutez les migrations :**

   ```bash
    php bin/console doctrine:migrations:migrate
   ```

3. **Chargez des données fictives :**

   chargez les fixtures :

   ```bash
    php bin/console doctrine:fixtures:load
   ```

   Exécutez les commandes SQL suivantes pour ajuster les auto-incréments des tables :

   ```sql
   ALTER TABLE style AUTO_INCREMENT = 18;
   ALTER TABLE album AUTO_INCREMENT = 275;
   ALTER TABLE artiste AUTO_INCREMENT = 70;
   ```

## Démarrage du Serveur

Pour démarrer le serveur intégré de Symfony, exécutez la commande suivante :

```bash
   symfony server:start
```

## Contribuer

Les contributions sont les bienvenues. Veuillez soumettre une demande de tirage pour toute modification.