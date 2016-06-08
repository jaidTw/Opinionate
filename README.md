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

# Todo
* `browseTopic`
    * use laravel paginator
    * `createModal` add `description`, `is_unlisted`, `is_same_attr` field.
* `createTopic`
    * add `is_multiple_choice`, `is_synced`, `is_anonymous`, `result_visibility`, `close_at`, `visualization` field.
    * add `is_same_attr` handling.
* Show Topic Page
* Edit Topic Page
* Destroy feature
* Validation error message hadling.
* Replace pure sql statements with Eloquent ORM after demo