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
    * qs and options number constraint.
        - Use CSS selector to count the number of DOM elements and trigger error.
    * add `description`, `is_unlisted`, `close_at`, `is_same_attr` field.
    * add `is_same_attr` handling.
* Show Topic Page
* Edit Topic Page
* Destroy feature
* Validation error message hadling.
* Replace pure sql statements with Eloquent ORM after demo
* I18N + Chinese L10N