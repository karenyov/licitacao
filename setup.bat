#!/bin/bash
set -e

echo "▶ Instalando dependências do backend (Laravel)..."
docker exec -it laravel-app bash -c "composer install && php artisan migrate"

echo "▶ Ajustando permissões do PHP CS Fixer..."
docker exec -it laravel-app bash -c "chmod +x ./vendor/bin/php-cs-fixer"

echo "✅ Backend pronto!"

echo "▶ Instalando dependências do frontend (Vue + Vite)..."
docker exec -it laravel-vite sh -c "npm install"

echo "✅ Frontend pronto!"
echo "ℹ️ Agora rode 'npm run dev' dentro do container laravel-vite se quiser iniciar o Vite."
