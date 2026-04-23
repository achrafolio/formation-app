# Formation App

Une application web simple de gestion de formations construite avec Laravel 11, Docker, et GitHub Actions.

## Prérequis

- Docker et Docker Compose installés sur votre machine.
- (Optionnel) PHP 8.2+ et Composer si vous souhaitez lancer le projet sans Docker.

## Lancement avec Docker Compose (Recommandé)

C'est la méthode la plus simple pour démarrer l'application avec sa base de données.

1. **Entrez dans le dossier** `formation-app`.
2. **Configuration** : Copiez le fichier d'environnement.
   ```bash
   cp .env.example .env
   ```
3. **Démarrer les conteneurs** :
   ```bash
   docker-compose up -d
   ```
   *Cela va démarrer l'application PHP sur le port 3000 et MySQL sur le port 3306.*
   
4. **Initialiser l'application** : Exécutez ces commandes dans le conteneur `app` pour installer les dépendances et la clé :
   ```bash
   docker-compose exec app composer install
   docker-compose exec app php artisan key:generate
   ```
   
5. **Base de données (Migration et Seeding)** :
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```
6. **Accès à l'application** : 
   Ouvrez votre navigateur sur [http://localhost:3000](http://localhost:3000).

## Lancement sans Docker

Si vous avez PHP 8.2, Composer et un serveur MySQL local :

1. Copiez le fichier `.env` : `cp .env.example .env`
2. Modifiez le fichier `.env` pour utiliser vos identifiants MySQL (assurez-vous d'avoir créé une base `formation_db`).
3. Installez les dépendances : `composer install`
4. Générez la clé : `php artisan key:generate`
5. Migrez et seedez la base de données : `php artisan migrate --seed`
6. Lancez le serveur local : `php artisan serve --port=3000`
7. Accédez à `http://localhost:3000`.

## Lancement avec Docker (sans Docker Compose)

Vous pouvez construire et lancer le conteneur de l'application (nécessite une base de données configurée dans le `.env`) :

```bash
docker build -t formation-app .
docker run -p 3000:3000 -v $(pwd):/app formation-app
```

## Structure et détails techniques

- **Modèle et Base de données** : Le modèle `Formation` gère la table `formations` avec les champs (titre, description, formateur, duree, date_debut). Validation intégrée sur tous les champs requis.
- **Identifiants Docker MySQL** : La base se nomme `formation_db`, avec l'utilisateur `formation_user` et le mot de passe `secret`.
- **Dockerfile** : Inclut PHP 8.2, toutes les extensions requises (pdo_mysql, mbstring, xml, etc.), ainsi que Composer. Configure également les permissions correctes pour le dossier `storage` et `bootstrap/cache`.
- **CI/CD** : Un pipeline GitHub Actions se lance au push sur main pour valider la compilation Docker et tester la configuration via `php artisan route:list`.
