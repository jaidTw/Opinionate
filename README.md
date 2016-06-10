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
* `createTopic`
    * question sets and options number constraint.
        - trigger error by the number of DOM elements.
    * `close_at` timestamp validation(by regex or something more complicated).
    * rewrite post with jQuery `.index()`
* Change edit button to save and cancel
* Landing Page
* User Dashboard
* Destroy feature
* Validation error message hadling.
* Replace pure sql statements with Eloquent ORM after demo
* I18N + Chinese L10N
* Add discuss support

# License
The MIT License