import database
run migration
run seeder UpdateFormSeeder

php artisan db:seed --class=UpdateFormSeeder
