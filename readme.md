# Spoons v2

## L5

```
composer install;
```

```
php artisan migrate;
```

## get pubs form spoons site

```
php artisan downloadJson;
```

## parse the pubs into the db

```
php artisan jsonToDb;
```

## Add google apps api key to .env

```
googleApi=AIzaSyCdsaBvhasdase33QsQCjdasasdsadJrdU71mk
```

## Get Lat lon for each pub

```
php artisan geoCodeProperties
```

warning - this will use about 1000 of your 2500/day google api calls - and will take 5-10 minutes to run. You will need to check your geo table to make sure all pubs were found. It will die on any errors.

## These pubs sometimes don't geocode correctly

```
INSERT INTO `spoons`.`geos` (`id`, `lat`, `lon`, `pub_id`, `created_at`, `updated_at`) VALUES (NULL, '52.0418076', '-0.7488899', '456', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `spoons`.`geos` (`id`, `lat`, `lon`, `pub_id`, `created_at`, `updated_at`) VALUES (NULL, '52.625122', '1.3037323', '498', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `spoons`.`geos` (`id`, `lat`, `lon`, `pub_id`, `created_at`, `updated_at`) VALUES (NULL, '50.8968177', '-1.3938053', '612', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `spoons`.`geos` (`id`, `lat`, `lon`, `pub_id`, `created_at`, `updated_at`) VALUES (NULL, '52.3382458', '-2.2818771', '640', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `spoons`.`geos` (`id`, `lat`, `lon`, `pub_id`, `created_at`, `updated_at`) VALUES (NULL, '54.9055735', '-1.3897555', '651', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `spoons`.`geos` (`id`, `lat`, `lon`, `pub_id`, `created_at`, `updated_at`) VALUES (NULL, '51.2100664', '-4.119179', '939', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `spoons`.`geos` (`id`, `lat`, `lon`, `pub_id`, `created_at`, `updated_at`) VALUES (NULL, '55.9429719', '-4.5719597', '960', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
```

## Get places API IDs - and possibly more accurate latlon

```
php artisan placesApiProperties
```

## Add elasticsearch params (using searchly atm)

```
searchlyApi=b8adddddddddddddd3852f47d22a5
```
```
searchlyDomain=xxx-yyy-zzz.searchly.com
```

## Send all coordinates to elastic search

```
php artisan sendGeoToElasticSearch
```

# Frontend
```
npm install --global gulp
```
```
npm install
```
```
bower install
```

# ToDo
 - Admin panel to reindex edited pubs
 - Deleted pubs detection
 - Some kind of cron with email
 - Learn Angular

# new stuff

https://www.jdwetherspoon.com/api/pubs

{"location":{"lng":-0.07475060000001577,"lat":51.590117},"paging":{"numberPerPage":3,"page":1}}
{"location":{"lng":-0.07475060000001577,"lat":51.590117},"paging":{"numberPerPage":1000,"page":1}}
{"paging":{"numberPerPage":90000,"page":1}}

https://www.jdwetherspoon.com/api/advancedsearch

{"region":null,"paging":{"UsePagination":false},"facilities":[],"searchType":0}
{"term":"hitchin","region":null,"location":{"lng":-0.2834139999999934,"lat":51.94921},"paging":{"numberPerPage":30,"page":0,"UsePagination":true},"facilities":[],"searchType":0}