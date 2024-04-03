<p align="center">Healthcare Appointment Booking API</p>

## Clone the Project into your local machine
Repository=https://github.com/austinPatel/Healthcare-Appointment-API.git
Change the current working directory to the location where you want the cloned directory.

## install composer which resolves the dependencies, and installs them into vendor all laravel packages.

#composer install

## Important Note: only time you need to call key:generate is following a clone of a pre-created project.
#php artisan key:generate

If you use a version control system like git to manage your project for development, calling git push ... will push a copy of your project to wherever it is going, but will not include your .env file. Therefore, if someone clones your project using git clone ... they will have to manually enter key:generate for their app to function correctly.

## Create Database and Configure your database in .env file

copy the .env.example and rename the name with .env
open .env file and find the database configuration

For example.
DB_CONNECTION=mysql
DB_HOST=<Host>
DB_PORT=<PORT>
DB_DATABASE=<DatabaseName>
DB_USERNAME=<Username>
DB_PASSWORD=<Password>

## Once you have configured your database, you may run your application's database migrations, which will create your application's database tables.

#php artisan migrate

Seed your initial data
#php artisan db:seed

You can call migrate:refresh with the --seed option to automatically seed after the migrations are complete.

#php artisan migrate:refresh --seed

## Once all table is created add super admin to user table using seeder command.

execute specific seeder class which you have created.

#php artisan db:seed --class=SuperAdminSeeder
#php artisan db:seed --class=HealthcareProfessionalSeeder
or
#php artisan db:seed ( which will be execute all seederclass)

## execute passport:install command. this command will create the encryption keys needed to generate secure access tokens.(allowed authenticated user's token).

#php artisan passport:install
or 
#php artisan passport:install --force

## When deploying Passport to your application's servers for the first time, you will likely need to run the passport:keys command.(generates the encryption keys Passport needs in order to generate access tokens).

#php artisan passport:keys

## API Endpoints

# User Singup = /api/user/sign-up - Post method
#Request Body 
{
  "name": "Hardik Patel",
  "email": "hardik@localhost.com",
  "password": "password",
  "confirm_password": "password"
}

# User Signin = /api/user/sign-in

#Request Body 
{
  "email": "hardik@localhost.com",
  "password": "password"
}

# Below api is required the access token for accessing the all other api endpoint

Authorization: Bearer {token}

# get all Healthcare Professional = /api/get-healthcare-professional
Optional Query Parameters used for the filter
name - filter by name
specialty- filter by specialty

# ser booking appointment = /api/user/appointment/booked -Post method
Status = (booked=1, completed=2, cancelled=3)
Request Body
{
    "healthcare_professionals_id": 3,
    "appointment_start_time": "2023-04-03 09:00:00",
    "appointment_end_time": "2023-04-03 09:30:00",
    "status": "1"
}
# get all user appointment = /api/user/appointment

# Cancelled appointment - /api/user/appointment/cancelled - Patch method
passed the appointment_id
Request Body
{
    "appointment_id": 2
}

# we can also made the appointment resources e.g /appointment -
/GET(All appointment)
/POST(Booked)
/Patch(cancelled)
/PUT(completed)

# Dockerization
Create the Dockerfile - which consist of install PHP/APACHE/MYSQL
-install all the dependencies and enable PHP modules
-enable apache modules
-apache configs + document root
-Copy our application code
-Working Directory
-Install Composer or COPY Composer
-Set permission to cache and bootstrap folder

# Provided a Dockerfile and docker-compose.yml to set up the entire application.
Which will install MYSQL PHPMYADMIN APACHE SERVER
MYSQL_ROOT_PASSWORD: root
MYSQL_DATABASE: healthcare

