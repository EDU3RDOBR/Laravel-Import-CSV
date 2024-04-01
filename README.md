## Laravel CSV Import with Matching Fields

A demo project with Laravel 8 and Laravel Excel package, to import CSV file and choose the DB fields to match the CSV column.

### How to use

Clone this project to your local computer.

```ps
git clone https://github.com/EDU3RDOBR/Laravel-Import-CSV
```

Navigate to the project folder.

```ps
cd Laravel-Import-CSV
```

Install required packages.

```ps
composer install
```

create new .env file and edit database credentials there.

```ps
cp .env.example .env
```

Generate new app key.

```ps
php artisan key:generate
```

Run migrations. (it has some seeded data for your testing)

```ps
php artisan migrate --seed
```

That's it: launch the main URL

