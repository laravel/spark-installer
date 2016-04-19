## Laravel Spark Installer

#### Installation

You should clone this repository to any location on your system, then run the `composer install` command within the cloned directory so the installer's dependencies will be installed. Finally add that location to your system's PATH so that the `spark` executable can be run from anywhere on your system.

After purchasing a Spark license, run the `spark register` command with your API token generated from the [Laravel Spark](https://spark.laravel.com) website.

    spark register token-value

#### Creating Projects

Once your Spark client has been registered, you can run the `new` command to create new projects:

    spark new project-name

After the project has been created, don't forget to run your database migrations!
