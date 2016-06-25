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
* `createTopic.blade.php`
    * question sets and options number constraint.
        * trigger error by the number of DOM elements.
    * rewrite post with jQuery iterator
* `TopicController@store`
    * add `close_at` validation
    * qs and opt number validation
    * may perform question set number checking
* `TopicController@update`
    * qs and opt number validation
    * may perform question set number checking
* Improve Landing Page
* User dashboard
* User page
* More friendly validation error message.
* Replace pure sql statements with Eloquent ORM after demo
* Improve i18n + zh-tw l10n

# License
The MIT License
