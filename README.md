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
* `showTopic.blade.php`
    * Add/delete question sets
        * each topic need to have at least one question set.
    * Update question sets
        * Visibility
        * Add options
    * add `Chart.js`
* `createTopic.blade.php`
    * question sets and options number constraint.
        * trigger error by the number of DOM elements.
        * validate length at controller
    * rewrite post with jQuery iterator
* `browseTopic.blade.php`
    * use laravel paginator
* `TopicController@store`
    * add `close_at` validation
    * perform question set number checking
* `TopicController@update`
    * add `close_at` validation
    * add more compliacated validation rule
    * perform question set number checking
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