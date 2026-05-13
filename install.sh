#!/bin/bash
# ============================================================
# E-Surat — Quick Installation Script
# Sistem Informasi Manajemen Surat Desa
# ============================================================

set -e

echo ""
echo "╔══════════════════════════════════════════════════════╗"
echo "║         📮 E-SURAT — QUICK INSTALLER                ║"
echo "║    Sistem Informasi Manajemen Surat Desa             ║"
echo "╚══════════════════════════════════════════════════════╝"
echo ""

# --- Check PHP version ---
PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
echo "✅ PHP Version: $PHP_VERSION"
if [[ $(php -r "echo version_compare(PHP_VERSION,'8.2','<') ? 'old' : 'ok';") == "old" ]]; then
    echo "❌ Error: PHP 8.2+ diperlukan. Versi saat ini: $PHP_VERSION"
    exit 1
fi

# --- Check Composer ---
if ! command -v composer &>/dev/null; then
    echo "❌ Error: Composer tidak ditemukan. Install dari https://getcomposer.org"
    exit 1
fi
echo "✅ Composer: $(composer --version --no-ansi | head -1)"

# --- Install PHP dependencies ---
echo ""
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# --- Setup .env ---
if [ ! -f ".env" ]; then
    echo ""
    echo "⚙️  Setting up .env..."
    cp .env.example .env
    php artisan key:generate --ansi
    echo "✅ .env created & APP_KEY generated"
else
    echo "✅ .env already exists"
fi

# --- Prompt for DB credentials ---
echo ""
echo "🗄️  Database Configuration"
read -p "   DB Host [127.0.0.1]: " DB_HOST
DB_HOST=${DB_HOST:-127.0.0.1}
read -p "   DB Port [3306]: " DB_PORT
DB_PORT=${DB_PORT:-3306}
read -p "   DB Name [e_surat]: " DB_DATABASE
DB_DATABASE=${DB_DATABASE:-e_surat}
read -p "   DB Username [root]: " DB_USERNAME
DB_USERNAME=${DB_USERNAME:-root}
read -sp "   DB Password: " DB_PASSWORD
echo ""

# Update .env
sed -i "s/DB_HOST=.*/DB_HOST=$DB_HOST/" .env
sed -i "s/DB_PORT=.*/DB_PORT=$DB_PORT/" .env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_DATABASE/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USERNAME/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/" .env

echo "✅ Database credentials saved"

# --- Create DB and run migrations ---
echo ""
echo "🏗️  Running database migrations..."
php artisan migrate --force --ansi

echo ""
echo "🌱 Seeding database..."
php artisan db:seed --force --ansi

# --- Storage symlink ---
echo ""
echo "🔗 Creating storage symlink..."
php artisan storage:link --ansi 2>/dev/null || echo "   (Storage link already exists)"

# --- Set permissions ---
echo ""
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# --- Optimize ---
echo ""
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "╔══════════════════════════════════════════════════════╗"
echo "║            ✅ INSTALASI BERHASIL!                    ║"
echo "╚══════════════════════════════════════════════════════╝"
echo ""
echo "  🌐 Jalankan: php artisan serve"
echo "  🔑 Admin:    admin@kediri.go.id / password"
echo "  🔑 Staff:    budi@kediri.go.id / password"
echo ""
echo "  ⚠️  PENTING: Ganti password default setelah login!"
echo ""
