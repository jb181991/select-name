<p align="center">Laravel VueJs</p>

## About Select Name

A user can select name in the dropdown list, if the user can't find the name, user will select 'Create New' and then a popup will show. It will ask the user to input a name and if the inputted name is valid, it will be save directly to the database.

## How to Install and Run

**Step:_1_** Clone the project, after cloning:
```
cd projectName/
```

**Step:_2_** Add new _.env_ file or just rename _.env.example_ to _.env_

**Step:_3_** Change the following in the _.env_

``
DB_DATABASE=your_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
``

**Step:_4_** Run the following:
```
npm install
&&
composer install
```

**Step:_5_** Migrate and run tinker.

``
php artisan migrate
``

use tinker to add user data in the database:
``
php artisan tinker
``
then copy
``
factory(App\User::class, 10)->create();
``
after adding users, enter ``exit``

**Step:_6_** You can now run the project by running these:

``npm run watch`` or ``npm run dev``

then

``php aritsan serve``

And then we're done! You can now access the project thru ``http://localhost:8000/``
