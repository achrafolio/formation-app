# Formation App

Une application web simple de gestion de formations construite avec Laravel 11, Docker, et GitHub Actions.

## Prérequis (Développement Local)

- Docker et Docker Compose installés sur votre machine.

## Lancement Local avec Docker Compose

1. **Entrez dans le dossier** `formation-app`.
2. **Configuration** : Copiez le fichier d'environnement.
   ```bash
   cp .env.example .env
   ```
3. **Démarrer les conteneurs** :
   ```bash
   docker-compose up -d
   ```
   *Cela va démarrer l'application PHP sur le port 3000 et MySQL sur le port 3307.*
   
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

---

## 🚀 Déploiement en Production (VPS)

Ce projet est configuré avec un pipeline CI/CD GitHub Actions pour se déployer automatiquement sur un serveur VPS à chaque `push` sur la branche `main`.

### Architecture de Production
- Un service **Nginx** sert de reverse proxy et expose l'application sur le port `80`.
- L'application tourne derrière Nginx.
- La base de données est sécurisée dans le réseau Docker sans port exposé publiquement.
- Un fichier `docker-compose.prod.yml` est utilisé pour cette configuration.

### 1. Préparation du serveur VPS
Sur votre serveur Ubuntu :
1. Installez Docker et Docker Compose.
2. Créez un dossier pour le projet :
   ```bash
   mkdir -p /var/www/formation-app
   cd /var/www/formation-app
   ```
3. Clonez votre dépôt GitHub manuellement la première fois :
   ```bash
   git clone https://github.com/votre-compte/formation-app.git .
   ```
4. Créez le fichier `.env` de production :
   ```bash
   cp .env.example .env
   nano .env
   ```
   *Modifiez ces valeurs essentielles pour la production :*
   ```env
   APP_ENV=production
   APP_DEBUG=false
   # Générez une vraie clé locale et collez-la ici
   APP_KEY=base64:xxx...
   ```

### 2. Configuration des GitHub Secrets
Dans les paramètres de votre dépôt GitHub (`Settings > Secrets and variables > Actions`), ajoutez les secrets suivants :
- `VPS_HOST` : Adresse IP de votre serveur VPS (ex: 192.168.1.100)
- `VPS_PORT` : Port SSH (généralement `22`)
- `VPS_USER` : Utilisateur SSH (ex: `root` ou `ubuntu`)
- `VPS_SSH_KEY` : Votre clé privée SSH (qui correspond à la clé publique autorisée sur le VPS)
- `VPS_PROJECT_PATH` : Chemin absolu vers le projet (ex: `/var/www/formation-app`)

### 3. Comment ça marche ?
À chaque push sur `main`, GitHub Actions va :
1. Se connecter au VPS via SSH.
2. Lancer le script `./deploy.sh` sur le serveur.
3. Ce script fait un `git pull`, redémarre les conteneurs avec `docker-compose.prod.yml` et exécute les optimisations Laravel (`config:cache`, `migrate --force`, etc.).

### Commandes utiles (Debug sur le VPS)
- Voir les logs de production : `docker-compose -f docker-compose.prod.yml logs -f`
- Relancer manuellement : `bash deploy.sh`
