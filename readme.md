# Opinionate
We are tired of those stringent options of voting systems today, so we decided to make our owns. Opinionate is a voting system site built on Laravel. It supports various option types, anonymity of users, time-sensitive or privacy-concerned topics.

# Deployment
First, use Laravel to create a new app.

```
laravel new opinionate
```

After it, remember to configure `.env` for database connection settings.

Then, set up the git repository to fetch.
```
git init
git remote add origin https://github.com/jaidTw/Opinionate.git
git fetch --all
git reset --hard origin/master
```
Or you can just download the archive and replace the original files.

Then do the database migration.

```
php artisan migrate
```

# Todo
* `showTopic.blade.php`
    * add `Chart.js`
    * implement Visible after ended.
* `createTopic.blade.php`
    * question sets and options number constraint.
        * trigger error by the number of DOM elements.
    * rewrite post with jQuery iterator
* `browseTopic.blade.php`
    * use laravel paginator
* `TopicController@store`
    * add `close_at` validation
    * qs and opt number validation
    * may perform question set number checking
* `TopicController@update`
    * add `close_at` validation
    * qs and opt number validation
    * may perform question set number checking
* Landing Page
* User dashboard
* User page
    * All name link to user page.
* More friendly validation error message.
* Replace pure sql statements with Eloquent ORM after demo
* I18N + Chinese L10N
* Add disqus support

# License
The MIT License
