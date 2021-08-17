 
 #CONTENTS OF THIS FILE
    ---------------------

 * Introduction
 * Setting Up
 * Installation
 * Clone Laravel Source
 * Start Local Development Server
 * Folders
 * Enviromental Variables
 * Testing API
 * Request Headers
 * Cross-Origin Resource Sharing(CORS)
 * Maintainers
  ------------------------

 #INTRODUCTION
 -------------------------
 # \<Quiz_App_Project\>

 *This contains the application code for the \<Quiz_App_Project\>. The app is build on top of [Laravel framework](http://laravel.com/docs) which runs on the LAMP stack.
 * Example Laravel codebase containing real world examples (CRUD, auth, advanced patterns and more).
 
 *Follow these steps to set up the project.

  # SETTING UP
  --------------------
  # INSTALLATION
   -------------------
  *Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)
  *If you use composer create-project  laravel/laravel Quiz_App_Project to create a Laravel project.
   
  # CLONE LARAVEL SOURCE
   ----------------------
  *Clone the repository  git clone <gitlab url>
  *Install all the dependencies using composer
  -composer install

  *Copy the example env file and make the required configuration changes in the .env file
  -cp .env.example .env

  *Generate a new application key
  -php artisan key:generate

  *Change the values of the .env file as necessary.

  *Run the database migrations (Set the database connection in .env before migrating)

  -php artisan migrate

 * Database seeding

 *Populate the database with seed data this can help you to quickly start testing the api or couple a frontend and start using it with ready content.

  -php artisan migrate:fresh --seed

   # START LOCAL DEVELOPMENT SERVER
   -------------------------
   *Start the local development server

   -php artisan serve

   *Make sure you set the correct database connection information before running the migrations Environment variables
   -php artisan migrate
   -php artisan serve


   #FOLDERS
   ******************

   - `App` - Contains all the Eloquent models

   #CONTROLLERS
   ----------------------
   -` App\Http\Controllers\AdminController;
   -` App\Http\Controllers\CandidateController;
   -` App\Http\Controllers\QuizController;
   -` App\Http\Controllers\QuizLogController;

   #MIDDLEWARES
   ------------------------
   - `app/Http/Middleware` - Contains the auth middleware

   #MODELS
   ------------------
   -`Admin.php
   -`Candidate.php
   -`QuizLog.php
   -`User.php
   ```````````````````
   - Available options
  - --fillable: comma separated fields for fillable attributes
  - --searchable: comma separated fields for searchable attributes (based on search() method)
  - --primaryKey: field or comma separated fields that are the table's primary key
  - --softDeletes: if passed enables SoftDeletes trait on class
  - --uploads: if passed adds fileUploads() method on class 
  - --logable: adds Logable trait on model 
 
   #DATABASES
  ---------------------------
   `*MIGRATIONS
 
   - `database/migrations` - Contains all the database migrations
   -create_admins_table
   -create_quiz_logs_table
   -create_candidates_table

   ```````````````````````
   `*SEEDERS
   - `database/seeds` - Contains the database seeder
  
   -AdminSeeder.php
   -CandidatesSeeder.php
   -DatabaseSeeder.php
   -QuizLogSeeder.php

    ```````````````````````
  `*FACTORY
   - `database/factories` - Contains the model factory for all the models
 
  -AdminFactory.php
  -CandidateFactory.php
  -QuizLogFactory.php
  -UserFactory.php
 ```````````````````````
  #ROUTES
  -------------------------
   - `routes` - Contains all the api routes defined in api.php file.

  ````````````````````
 `*API.PHP

  -Route::get('/admins', [AdminController::class, 'index']);
  -Route::post('/admin/signup', [AdminController::class, 'store']);
  -Route::post('/admin/login', [AdminController::class, 'login']);
  -Route::get('/candidates', [CandidateController::class, 'index']);
  -Route::post('/candidate/signup', [CandidateController::class, 'store']);
  -Route::get('dashboard/candidates_record', [QuizLogController::class, 'index']);
  -Route::post('/dashboard/generateurl', [CandidateController::class, 'generateurl']);
  -Route::get('/quiz/instructions', [QuizController::class, 'quizhome'])->name('quiz')->middleware('signed');
  ``````````````````
  #CONFIG.PHP
  ------------------------
  - `config` - Contains all the application configuration files

 `````````````````` 
 #TESTS
 ---------------------
  - `tests` - Contains all the application tests

  ``````````````````
  ******************************

 # TESTING

 -You can execute the tests by running the following command.

  ./vendor/bin/phpunit --tap

  # ENVIROMENTAL VARIABLES

   - `.env` - Environment variables can be set in this file

   ***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

  ----------------------

 # TESTING API

 Run the laravel development server

    php artisan serve

 The api can now be accessed at

   http://192.168.1.106:3000/api {Example URL}

  -----------------------------

 # REQUEST HEADERS

 | **Required** 	| **Key**              	| **Value**            	|
 |----------	|------------------	|------------------	|
 | Yes      	| Content-Type     	| application/json 	|
 | Yes      	| X-Requested-With 	| XMLHttpRequest   	|


  Refer the [api specification](#api-specification) for more info.

  ------------------------------
 # Cross-Origin Resource Sharing (CORS)
 
 *This applications has CORS enabled by default on all API endpoints. 
 *The CORS allowed origins can be changed by setting them in the config file. Please check the following sources to learn more about CORS.
 
 - https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
 - https://en.wikipedia.org/wiki/Cross-origin_resource_sharing
 - https://www.w3.org/TR/cors
