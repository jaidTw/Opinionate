# Opinionate

# Deployment
First, use laravel to create a new app.

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
* BUG : End Time default date and min date control
* `showTopic.blade.php`
    * add `Chart.js`
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
Copyright (C) 2016 JaidTw

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.