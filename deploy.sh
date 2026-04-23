#!/bin/bash
set -e

echo "--- Démarrage du déploiement ---"

# Récupérer la dernière version du code
echo "-> Git Pull origin main"
git pull origin main

# Construire et redémarrer les conteneurs de production
echo "-> Construction et redémarrage des conteneurs"
docker-compose -f docker-compose.prod.yml build
docker-compose -f docker-compose.prod.yml up -d

# Exécuter les commandes d'optimisation Laravel
echo "-> Exécution des commandes Laravel (Optimisation & Migration)"
docker-compose -f docker-compose.prod.yml exec -T app php artisan migrate --force
docker-compose -f docker-compose.prod.yml exec -T app php artisan config:clear
docker-compose -f docker-compose.prod.yml exec -T app php artisan cache:clear
docker-compose -f docker-compose.prod.yml exec -T app php artisan config:cache
docker-compose -f docker-compose.prod.yml exec -T app php artisan route:cache
docker-compose -f docker-compose.prod.yml exec -T app php artisan view:cache

echo "--- Déploiement terminé avec succès ! ---"
