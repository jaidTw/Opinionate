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
* BUG : End Time default date and min date control
* `showTopic`
    * Add/delete question sets
        * each topic need to have at least one question set.
    * Update question sets
        * Visibility
        * Add options
* `createTopic`
    * question sets and options number constraint.
        * trigger error by the number of DOM elements.
        * validate length at controller
    * rewrite post with jQuery `.index()`
* `browseTopic`
    * use laravel paginator
* `TopicController`
    * add `close_at` validation in `@store` and `@update`
    * perform question set number checking
* add `Chart.js`
* Landing Page
* User dashboard
* User page
    * All name link to user page.
* Validation error message hadling.
* Replace pure sql statements with Eloquent ORM after demo
* I18N + Chinese L10N
* Add disqus support

# License
The MIT License