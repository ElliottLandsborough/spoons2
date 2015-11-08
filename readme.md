# L5
```composer install;
php artisan migrate;```
# get pubs form spoons site
```php artisan downloadJson;```
# parse the pubs into the db
```php artisan jsonToDb;```
# Add google apps api key to .env
```googleApi=AIzaSyCdsaBvhasdase33QsQCjdasasdsadJrdU71mk```
# Get Lat lon for each pub
```php artisan geoCodeProperties```
warning - this will use about 1000 of your 2500/day google api calls - and will take 5-10 minutes to run. You will need to check your geo table to make sure all pubs were found.
