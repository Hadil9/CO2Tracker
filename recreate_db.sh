#!/bin/bash

mysql laravel -u student -psecret < drop_all_tables.sql

php artisan migrate
php artisan db:seed