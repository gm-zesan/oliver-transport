#!/usr/bin/env bash
# ==============================================================================
# PickMeRoute Production Deployment Script
# Target: https://pickmeroute.entrepreneursautomation.com
# Server: cPanel Cloud (cloud.webfastdns.com:2083)
# ==============================================================================
set -euo pipefail

# Configuration
REMOTE_HOST="cloud.webfastdns.com"
REMOTE_USER="entrepre"
REMOTE_PASS="Abm7*2q0)YmZ1T"
REMOTE_DIR="/home/entrepre/pickmeroute.entrepreneursautomation.com"
PHP_BIN="/usr/local/bin/php"
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
TEMP_ARCHIVE="/tmp/pickmeroute_deploy_$(date +%s).tar.gz"
ASKPASS_FILE="/tmp/pickmeroute_askpass_$$.sh"

echo "=========================================================="
echo "🚀 Starting Deployment for PickMeRoute"
echo "🌐 Destination: https://pickmeroute.entrepreneursautomation.com"
echo "=========================================================="

# 1. Setup Askpass Helper for Passwordless Automation
cleanup() {
    rm -f "$TEMP_ARCHIVE" "$ASKPASS_FILE" 2>/dev/null || true
}
trap cleanup EXIT

cat << EOF > "$ASKPASS_FILE"
#!/bin/sh
echo "$REMOTE_PASS"
EOF
chmod +x "$ASKPASS_FILE"

run_ssh() {
    DISPLAY=:0 SSH_ASKPASS="$ASKPASS_FILE" SSH_ASKPASS_REQUIRE=force \
    ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null -o NumberOfPasswordPrompts=1 \
    "$REMOTE_USER@$REMOTE_HOST" "$@"
}

# 2. Build Frontend Assets
echo "📦 1/5 Compiling frontend production assets (Vite)..."
cd "$PROJECT_DIR"
npm run build

# Remove local public/hot so production reads manifest.json
rm -f "$PROJECT_DIR/public/hot"

# 3. Create Project Archive
echo "📦 2/5 Packaging application archive..."
tar -czf "$TEMP_ARCHIVE" \
    --exclude='.git' \
    --exclude='node_modules' \
    --exclude='tests' \
    --exclude='.env' \
    --exclude='storage/logs/*.log' \
    --exclude='storage/framework/cache/data/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    --exclude='.DS_Store' \
    --exclude='*/.DS_Store' \
    -C "$PROJECT_DIR" .

ARCHIVE_SIZE=$(ls -lh "$TEMP_ARCHIVE" | awk '{print $5}')
echo "   Archive generated ($ARCHIVE_SIZE)."

# 4. Stream Archive to Remote Server & Extract
echo "🚀 3/5 Uploading and extracting to $REMOTE_DIR..."
DISPLAY=:0 SSH_ASKPASS="$ASKPASS_FILE" SSH_ASKPASS_REQUIRE=force \
ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null -o NumberOfPasswordPrompts=1 \
"$REMOTE_USER@$REMOTE_HOST" "tar -xzf - -C $REMOTE_DIR" < "$TEMP_ARCHIVE"

# 5. Remote Post-Deploy Tasks
echo "⚙️  4/5 Running remote setup, migrations & optimizations..."
run_ssh "
set -euo pipefail
cd '$REMOTE_DIR'

# Clean macOS metadata
find '$REMOTE_DIR' -name '._*' -delete 2>/dev/null || true
rm -f '$REMOTE_DIR/public/hot' 2>/dev/null || true

# Storage & Cache permissions
mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Run Database Migrations
echo '   Applying database migrations...'
$PHP_BIN artisan migrate --force

# Storage Symlink
$PHP_BIN artisan storage:link 2>/dev/null || true

# Clear and Cache Configurations
echo '   Optimizing framework cache...'
$PHP_BIN artisan optimize:clear
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache
"

# 6. Verification
echo "🔍 5/5 Verifying live response..."
HTTP_CODE=$(curl -s -k -o /dev/null -w "%{http_code}" https://pickmeroute.entrepreneursautomation.com/)

if [ "$HTTP_CODE" = "200" ]; then
    echo "=========================================================="
    echo "✅ DEPLOYMENT SUCCESSFUL!"
    echo "🌐 Site is LIVE: https://pickmeroute.entrepreneursautomation.com"
    echo "=========================================================="
else
    echo "⚠️ Warning: Expected HTTP 200 but received HTTP $HTTP_CODE"
    exit 1
fi

