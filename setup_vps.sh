#!/bin/bash
set -e

PUBKEY="$1"

echo "Setting up authorized_keys..."
mkdir -p ~/.ssh
chmod 700 ~/.ssh
# Add key if it doesn't exist
if ! grep -q "$PUBKEY" ~/.ssh/authorized_keys 2>/dev/null; then
    echo "$PUBKEY" >> ~/.ssh/authorized_keys
fi
chmod 600 ~/.ssh/authorized_keys

echo "Updating system and installing Docker..."
export DEBIAN_FRONTEND=noninteractive
apt-get update -y
apt-get install -y apt-transport-https ca-certificates curl software-properties-common git
if ! command -v docker &> /dev/null; then
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | apt-key add -
    add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" -y
    apt-get update -y
    apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
fi
if ! command -v docker-compose &> /dev/null; then
    # Create symlink if docker compose plugin is installed
    if docker compose version &> /dev/null; then
        ln -s /usr/libexec/docker/cli-plugins/docker-compose /usr/local/bin/docker-compose
    else
        curl -L "https://github.com/docker/compose/releases/download/v2.24.5/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
        chmod +x /usr/local/bin/docker-compose
    fi
fi

echo "Setting up project directory..."
mkdir -p /var/www/formation-app
cd /var/www/formation-app

echo "Creating .env file..."
cat << 'EOF' > .env
APP_NAME=Laravel
APP_ENV=production
APP_KEY=base64:oGjW33zJ5rF+JgE6E9H8T5aR/Fz1+6wVd+RzP/U9vjI=
APP_DEBUG=false
APP_URL=http://161.97.182.212

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=formation_db
DB_USERNAME=formation_user
DB_PASSWORD=secret

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
EOF

echo "VPS setup completed successfully."
