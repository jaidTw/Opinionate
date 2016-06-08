# Opinionate

# Deployment
First, use laravel to create the new app.

```
laravel new opinionate
```

After creating the new app, remember to configure `.env` for database connection settings.

Then, set up the git repository to fetch.

```
git init
git remote add origin https://github.com/jaidTw/Opinionate.git
git fetch --all
git reset --hard origin/master
```

Then do the database migration.

```
php artisan migrate
```