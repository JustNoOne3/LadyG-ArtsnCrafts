composer2 install
php artisan config:cache
php artisan view:cache
php artisan filament:optimize

cd public
ln -s ../storage/app/public storage