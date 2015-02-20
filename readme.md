1) The main idea is to send messages to background queue for processing. This way the server can handle a lot of requests and process them as fast as it can.

2) I use a Laravel framework for this test, so to make it easier to review, here are the main code files I created:
* [Controllers Directory]
* [Process Message Command]
* [Models and Interfaces] are placed directly in app/ directory
* [Repositories]
* [View]
* [Tests]
* [JS]
* [Database Migrations]


[Controllers Directory]:https://github.com/iktash/laravel/tree/master/app/Http/Controllers
[Process Message Command]:https://github.com/iktash/laravel/blob/master/app/Commands/ProcessMessage.php
[Models and Interfaces]:https://github.com/iktash/laravel/tree/master/app
[Repositories]:https://github.com/iktash/laravel/tree/master/app/Repositories
[Tests]:https://github.com/iktash/laravel/tree/master/tests
[JS]: https://github.com/iktash/laravel/blob/master/public/js/app.js
[View]:https://github.com/iktash/laravel/blob/master/resources/views/welcome.blade.php
[Database Migrations]:https://github.com/iktash/laravel/tree/master/database/migrations