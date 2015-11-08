# L5
composer install;
php artisan migrate;
# Grab all the latest pubs from official site, import to db
php artisan jsonToDb;
# Get Lat lon for each pub
