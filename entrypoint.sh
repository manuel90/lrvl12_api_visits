
if [ ! -d vendor ] && [ -f composer.json ] ; then
    echo "********************************"
    echo "********************************"
    echo "********************************"
    echo "Running: composer install"
    echo "********************************"
    echo "********************************"
    echo "********************************"
    composer install
fi

if [ ! -f .env ] && [ -f .env.example ] ; then
    cp .env.example .env
    php artisan key:generate
fi

echo "Running: php artisan migrate"
php artisan migrate
echo "================================================================"

echo "Running: php artisan test"
php artisan test
echo "================================================================"

echo "Running: php artisan serv --host=0.0.0.0 --port=80"
echo "================================================================"

# tail -f /dev/null
php artisan serve --host=0.0.0.0 --port=80