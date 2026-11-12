#!/usr/bin/env bash
# ==============================================================================
# PickMeRoute Production Deployment Script for Hostinger
# Target: https://pickmeroute.com
# ==============================================================================
set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# 0. Load optional deployment environment overrides
DEPLOY_ENV_FILE="${PROJECT_DIR}/.deploy.env"
if [ -f "$DEPLOY_ENV_FILE" ]; then
    # shellcheck disable=SC1090
    source "$DEPLOY_ENV_FILE"
fi

# Configuration (can be overridden via environment or .deploy.env)
REMOTE_HOST="${DEPLOY_REMOTE_HOST:-82.29.199.213}"
REMOTE_PORT="${DEPLOY_REMOTE_PORT:-65002}"
REMOTE_USER="${DEPLOY_REMOTE_USER:-u344465073}"
REMOTE_PASS="${DEPLOY_REMOTE_PASS:-}"
REMOTE_BASE="${DEPLOY_REMOTE_BASE:-/home/u344465073/domains/pickmeroute.com}"
REMOTE_DIR="${DEPLOY_REMOTE_DIR:-${REMOTE_BASE}/public_html}"
PHP_BIN="${DEPLOY_PHP_BIN:-/opt/alt/php84/usr/bin/php}"
TEMP_ARCHIVE="/tmp/pickmeroute_hostinger_deploy_$$.tar.gz"
ASKPASS_FILE="/tmp/pickmeroute_hostinger_askpass_$$.sh"

if [ -z "$REMOTE_PASS" ]; then
    read -rsp "Enter SSH password for ${REMOTE_USER}@${REMOTE_HOST}:${REMOTE_PORT}: " REMOTE_PASS
    echo
fi

echo "=========================================================="
echo "🚀 Starting Deployment for PickMeRoute on Hostinger"
echo "🌐 Destination: https://pickmeroute.com"
echo "=========================================================="

# 1. Setup Askpass Helper for Passwordless Automation
cleanup() {
    rm -f "$TEMP_ARCHIVE" "$ASKPASS_FILE" 2>/dev/null || true
}
trap cleanup EXIT

cat << EOF > "$ASKPASS_FILE"
#!/bin/sh
printf "%s\n" "$REMOTE_PASS"
EOF
chmod 700 "$ASKPASS_FILE"

run_ssh() {
    DISPLAY=:0 SSH_ASKPASS="$ASKPASS_FILE" SSH_ASKPASS_REQUIRE=force \
    ssh -p "$REMOTE_PORT" -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null -o NumberOfPasswordPrompts=1 \
    "$REMOTE_USER@$REMOTE_HOST" "$@"
}

# 2. Build Frontend Assets
echo "📦 1/6 Compiling frontend production assets (Vite)..."
cd "$PROJECT_DIR"
npm run build

# Remove local public/hot so production reads manifest.json
rm -f "$PROJECT_DIR/public/hot"

# 3. Create Project Archive
echo "📦 2/6 Packaging application archive..."
COPYFILE_DISABLE=1 tar --no-xattrs -czf "$TEMP_ARCHIVE" \
    --exclude='.git' \
    --exclude='node_modules' \
    --exclude='tests' \
    --exclude='.env' \
    --exclude='.env.*' \
    --exclude='.deploy.env' \
    --exclude='storage/logs/*.log' \
    --exclude='storage/framework/cache/data/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    --exclude='.DS_Store' \
    --exclude='*/.DS_Store' \
    --exclude='oliver_transport' \
    --exclude='.claude' \
    -C "$PROJECT_DIR" .

ARCHIVE_SIZE=$(ls -lh "$TEMP_ARCHIVE" | awk '{print $5}')
echo "   Archive generated ($ARCHIVE_SIZE)."

# 4. Stream Archive to Remote Server & Extract into public_html
echo "🚀 3/6 Uploading and extracting to $REMOTE_DIR..."
run_ssh "mkdir -p '$REMOTE_DIR'"
DISPLAY=:0 SSH_ASKPASS="$ASKPASS_FILE" SSH_ASKPASS_REQUIRE=force \
ssh -p "$REMOTE_PORT" -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null -o NumberOfPasswordPrompts=1 \
"$REMOTE_USER@$REMOTE_HOST" "tar --no-same-owner -xzf - -C '$REMOTE_DIR'" < "$TEMP_ARCHIVE"

# 5. Remote Web Root Security & Cache Permissions
echo "⚙️  4/6 Configuring Hostinger web root permissions & .htaccess..."
run_ssh "bash -s -- '$REMOTE_BASE' '$REMOTE_DIR' '$PHP_BIN'" <<'REMOTE_SETUP'
set -euo pipefail
REMOTE_BASE="$1"
REMOTE_DIR="$2"
PHP_BIN="$3"

cd "$REMOTE_DIR"

# Ensure master .htaccess with security rules and transparent rewrite to public/
cat << 'HTACCESS' > .htaccess
<IfModule mod_rewrite.c>
    RewriteEngine On

    # 1. Strict security rules: block access to sensitive files and directories
    RewriteRule ^(\.env|\.git|composer\.(json|lock)|package(-lock)?\.json|artisan|phpunit\.xml) - [F,L,NC]
    RewriteRule ^(app|bootstrap/cache|config|database|resources|routes|storage/logs|tests)(/.*)?$ - [F,L,NC]

    # 2. Redirect all other traffic to public/ directory transparently
    RewriteRule ^$ public/ [L]
    RewriteRule ^((?!public/).*)$ public/$1 [L]
</IfModule>

# Prevent directory browsing
Options -Indexes
HTACCESS
echo "   Configured master .htaccess in public_html"

# Clean macOS metadata and hot file
find . -name '._*' -delete 2>/dev/null || true
rm -f public/hot 2>/dev/null || true

# Storage & Cache permissions
mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Verify production .env exists
if [ ! -f .env ]; then
    echo "⚠️ Warning: .env file not found on remote! Please ensure production .env is configured."
fi
REMOTE_SETUP

# 6. Database Migrations and Optimizations
echo "⚙️  5/6 Running database migrations and framework cache..."
run_ssh "bash -s -- '$REMOTE_DIR' '$PHP_BIN'" <<'REMOTE_MIGRATE'
set -euo pipefail
REMOTE_DIR="$1"
PHP_BIN="$2"

cd "$REMOTE_DIR"

# Storage Symlink
"$PHP_BIN" artisan storage:link 2>/dev/null || true

# Run Database Migrations
echo "   Applying database migrations..."
"$PHP_BIN" artisan migrate --force --no-interaction

# Clear and Cache Configurations
echo "   Optimizing framework cache..."
"$PHP_BIN" artisan optimize:clear --no-interaction
"$PHP_BIN" artisan config:cache --no-interaction
"$PHP_BIN" artisan route:cache --no-interaction
"$PHP_BIN" artisan view:cache --no-interaction
REMOTE_MIGRATE

# 7. Verification
echo "🔍 6/6 Verifying live responses from https://pickmeroute.com..."
HTTP_CODE=$(curl -s -k -o /dev/null -w "%{http_code}" "https://pickmeroute.com/")

if [ "$HTTP_CODE" = "200" ]; then
    echo "=========================================================="
    echo "✅ DEPLOYMENT TO HOSTINGER SUCCESSFUL!"
    echo "🌐 Site is LIVE: https://pickmeroute.com"
    echo "=========================================================="
else
    echo "⚠️ Warning: Expected HTTP 200 but received HTTP $HTTP_CODE"
    exit 1
fi
